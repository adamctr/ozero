<?php

class CheckoutView extends View
{

    public function getCheckoutSession()
    {
        $stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);
        header('Content-Type: application/json');
        $YOUR_DOMAIN = 'http://localhost:8000';

        $checkout_session = $stripe->checkout->sessions->create([
            'ui_mode' => 'embedded',
            'line_items' => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                'price' => $priceId,
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'return_url' => $YOUR_DOMAIN . '/panier/checkoutsessionsuccess?session_id={CHECKOUT_SESSION_ID}',
        ]);
        echo json_encode(array('clientSecret' => $checkout_session->client_secret));
    }

    public function show()
    {
?>


        <div id="checkout">
        </div>

        <script src="https://js.stripe.com/v3/"></script>
        <script src="/scripts/checkout.js" defer></script>

<?php
    }
}
