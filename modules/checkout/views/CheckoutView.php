<?php

class CheckoutView extends View
{



    public function show()
    {
?>
        <div id="checkout">
        </div>

        <script src="https://js.stripe.com/v3/"></script>
        <script src="/scripts/checkout.js" defer></script>

    <?php
    }

    public function getCheckoutSuccess()
    {
    ?>
        <section id="success" class="hidden">
            <p>
                We appreciate your business! A confirmation email will be sent to <span id="customer-email"></span>.

                If you have any questions, please email <a href="mailto:orders@example.com">orders@example.com</a>.
            </p>
        </section>
    <?php
    }

    public function getCheckoutError()
    {
    ?>
        <section id="error" class="hidden">
            <p>
                Quelque chose s'est mal passé <span id="customer-email"></span>.

                If you have any questions, please email <a href="mailto:orders@example.com">orders@example.com</a>.
            </p>
        </section>
<?php
    }
}
