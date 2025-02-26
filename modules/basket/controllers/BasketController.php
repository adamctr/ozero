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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        } else {
            $view = new page404View();
            $view->show();
        }
    }

    public function testPanier()
    {
        $view = new TestAddBasketView();
        $view->show();
    }

    public function checkConnect()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['totalAmount'] = $_POST['totalAmount'];
        try {

            if (!isset($_COOKIE['auth_token'])) {
                header('Location: /login');
            } else {
                $jwtManager = new JWT();
                if (!$jwtManager->getUserIdFromJWT()) {
                    header('Location: /login');
                } else {
                    $addressModel = new AdressesModel();
                    $userModel = new UserModel();
                    $userId = $jwtManager->getUserIdFromJWT();
                    $user = $userModel->getUserById($userId);
                    $addresse = $addressModel->getAddressesByUserId($userId);

                    $view = new BasketView();
                    $view->shipping($user, $addresse);
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function confirmation()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $street = htmlspecialchars($_POST['street']);
        $city = htmlspecialchars($_POST['city']);
        $zipCode = htmlspecialchars($_POST['zipCode']);
        $country = htmlspecialchars($_POST['country']);
        $phone = htmlspecialchars($_POST['phone']);
        $_SESSION['addresse'] = [
            'street' => $street,
            'city' => $city,
            'zipCode' => $zipCode,
            'country' => $country,
            'phone' => $phone,
        ];
        $view = new BasketView();
        $view->confirmationPage();
    }
}
