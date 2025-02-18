<?php

require_once '../vendor/autoload.php';

class CheckoutController
{

    public function execute()
    {
        $view = new CheckoutView();
        $view->show();
    }

    public function getCheckoutSession()
    {
        // Créer un produit
        $product = \Stripe\Product::create([
            'name' => 'Nom du produit',
            'description' => 'Description du produit',
        ]);

        // Créer un tarif pour ce produit
        $price = \Stripe\Price::create([
            'product' => $product->id,
            'unit_amount' => 2000, // Montant en centimes (2000 = 20.00 USD)
            'currency' => 'usd',
        ]);

        $priceId = $price->id;
        $view = new CheckoutView();
        $view->getCheckoutSession();
    }

    public function getCheckoutSuccess()
    {
        $view = new SuccessView();
        $view->getCheckoutSuccess();
    }
}
