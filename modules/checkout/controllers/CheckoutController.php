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

    public function postConfirmationBeforePayment()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $jwtManager = new JWT();
        $userId = $jwtManager->getUserIdFromJWT();

        $addresse = new AddressesEntity([
            'userId' => $userId,
            'street' => $_SESSION['addresse']['street'],
            'city' => $_SESSION['addresse']['city'],
            'zipCode' => $_SESSION['addresse']['zipCode'],
            'country' => $_SESSION['addresse']['country'],
            'phone' => $_SESSION['addresse']['phone'],
        ]);

        $addressesModel = new AdressesModel();
        $checkAddress = $addressesModel->foundAddress($addresse);
        $addresseConfirmed = ($checkAddress == null) ?
            $addressesModel->createAddress($addresse) :
            $checkAddress;

        $purchase = new PurchaseEntity([
            'userId' => $userId,
            'status' => 'panier',
            'addressId' => $addresseConfirmed,
            'paymentMethod' => 'CB',
            'totalAmount' => $_SESSION['totalAmount'],
        ]);

        $purchaseModel = new PurchaseModel();
        $purchaseId = $purchaseModel->newPurchase($purchase);
        $_SESSION['purchaseId'] = $purchaseId;

        $view = new CheckoutView();
        $view->show();
    }



    public function getCheckoutSuccess()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $purchaseModel = new PurchaseModel();
        $purchaseModel->updatePurchaseStatus($_SESSION['purchaseId'], 'payé');

        $_SESSION['cart'] = [];

        var_dump($_SESSION);
        $view = new CheckoutView();
        $view->getCheckoutSuccess();
    }

    public function getCheckoutError()
    {
        $view = new CheckoutView();
        $view->getCheckoutError();
    }
}
