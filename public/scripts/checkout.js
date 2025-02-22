// This is your test secret API key.
const stripe = Stripe(
    "pk_test_51QtW9UPs5Jprbp6Q6eWQyn8ZykfTAXFpthlqaGGbCjZD3Nhhysi8AomOFwsSrZj28sCw2JBCI2y5JS7IIRpQ75Cb00F8H0bGKI"
);

initialize();

async function initialize() {
    try {
        const response = await fetch("/panier/checkoutsession", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
        });

        const data = await response.json();

        if (data.error) {
            console.error("Error:", data.error);
            return;
        }

        const checkout = await stripe.initEmbeddedCheckout({
            clientSecret: data.sessionId,
        });

        // Mount Checkout
        checkout.mount("#checkout");
    } catch (error) {
        console.error("Error:", error);
    }
}
