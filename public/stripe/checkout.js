document.addEventListener('DOMContentLoaded', (event) => {
    const stripe = Stripe('pk_test_51PTJw1KXG6ROz21Wb1G30BgYg0uxVHoXFaJlhbesC3m3WIMORCMZtstZN4CxBIkptEcb31SKaiZdH9uXOiRx1uL200KeDlAMfb'); // Assuming this is set globally
    const options = {
        clientSecret: clientSecret // Using the clientSecret passed from the Blade view
    };

    // Set up Stripe.js and Elements to use in checkout form
    const elements = stripe.elements(options);

    // Create and mount the Payment Element
    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');

    // Handle form submission
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const { error } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                // Make sure to change this to your payment completion page
                return_url: 'http://localhost:8005/success',
            },
        });

        if (error) {
            // Display error.message in your UI
            document.getElementById('error-message').textContent = error.message;
        }
    });
});
