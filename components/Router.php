<?php


class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);

    }

    // Возвразает запрос в url
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI']))
        {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        // Получить строку запроса
        $uri = $this->getURI();
        // Проверить наличие такого запроса в routes.php
        foreach ($this->routes as $uriPattern => $path)
        {
            // Если есть совпадение, определить какой контроллер и action будет обрабатывать
            if (preg_match("~$uriPattern~", $uri ))
            {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                // explode - Делит по /

                $segments = explode('/', $internalRoute);
                // ЧТОБЫ УБРАТЬ ПРОЕКТ ИЗ URL
                array_shift($segments);
                // array_shift - берет 1ый эл массива и убивает его
                // ucfirst - привет -> Привет
                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action' . ucfirst(array_shift($segments));

                // Параметры передачи
                $parametrs = $segments;
                // Подключить файл класса контроллера
                $controllerFile = ROOT.'/controllers/' .
                    $controllerName . '.php';

                if (file_exists($controllerFile))
                {
                    include_once($controllerFile);
                }

                // Создать объект, вызвать метод (action)
                $controllerObject = new $controllerName;
                $result = $controllerObject->$actionName($parametrs);
                if ($result != null){
                    break;
                }

            }
        }





    }
}