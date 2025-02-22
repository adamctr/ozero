<?php

class BasketController
{
    public function execute()
    {
        $view = new BasketView();
        $view->show();
    }

    public function addToCart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        for ($i = 0; $i < count($_POST['product']); $i++) {
            $product = $_POST['product'][$i];
            $price = $_POST['price'][$i];
            $quantity = $_POST['quantity'][$i];
            if (isset($_SESSION['cart'][$product])) {
                $i++;
            } else {
                $_SESSION['cart'][$product] = [
                    'product' => $product,
                    'price' => $price,
                    'quantity' => $quantity
                ];
            }
        }
        $view = new BasketView();
        $view->show();
    }
}
