<?php

class SuccessView extends View
{

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
}
