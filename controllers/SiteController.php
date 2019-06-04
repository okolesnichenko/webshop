<?php

class SiteController
{
    // Action для страницы "Главная"
    public function actionIndex()
    {

        $categories = array();
        $categories = Category::getCategoriesList();

        $latestProducts = array();
        $latestProducts = Product::getLatestProducts(6);

        require ROOT . '/views/site/index.php';

        return true;
    }
}