<?php

require_once '../vendor/autoload.php';

class CheckoutController
{


    public function getCheckoutSession()
    {
        $view = new CheckoutView();
        $view->show();
    }

    public function testCheckout() {}

    public function postCheckoutSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        try {
            \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

            $cart = [];
            foreach ($_SESSION['cart'] as $product) {
                $cart[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $product['product'],
                        ],
                        'unit_amount' => $product['price'] * 100,
                    ],
                    'quantity' => $product['quantity'],
                ];
            }
            $session = \Stripe\Checkout\Session::create([
                'ui_mode' => 'embedded',
                'payment_method_types' => ['card'],
                'line_items' => $cart,
                'mode' => 'payment',
                'return_url' => 'http://localhost:8000/panier/checkoutsessionsuccess?session_id={CHECKOUT_SESSION_ID}'
            ]);

            header('Content-Type: application/json');
            echo json_encode(['sessionId' => $session->client_secret]);
        } catch (\Exception $e) {
            error_log($e->getMessage()); // Log the error
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }



    public function getCheckoutSuccess()
    {
        $view = new CheckoutView();
        $view->getCheckoutSuccess();
    }

    public function getCheckoutError()
    {
        $view = new CheckoutView();
        $view->getCheckoutError();
    }
}
