<?php

class ProductController
{
    // Action для страницы "Продукт"
    public function actionView($productId)
    {
        $categories = array();
        $categories = Category::getCategoriesList();

        $product = Product::getProductById($productId[0]);

        require_once(ROOT . '/views/product/view.php');

        return true;
    }
}