// This is your test secret API key.
const stripe = Stripe(
    "pk_test_51QtW9UPs5Jprbp6Q6eWQyn8ZykfTAXFpthlqaGGbCjZD3Nhhysi8AomOFwsSrZj28sCw2JBCI2y5JS7IIRpQ75Cb00F8H0bGKI"
);

initialize();

// Create a Checkout Session
async function initialize() {
    const fetchClientSecret = async () => {
        const response = await fetch("/panier/checkoutsession", {
            method: "POST",
        });
        const { clientSecret } = await response.json();
        return clientSecret;
    };

    const checkout = await stripe.initEmbeddedCheckout({
        fetchClientSecret,
    });

    // Mount Checkout
    checkout.mount("#checkout");
}
