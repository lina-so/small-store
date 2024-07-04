<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <link rel="stylesheet" href="{{ asset('stripe/checkout.css') }}" />

    <!-- Include Stripe.js -->
</head>
<body>
    <h1>Complete Your Payment</h1>
    <!-- Create a form element to contain the payment details -->
    <form id="payment-form">
        <div id="payment-element">
            <!-- Elements will create form elements here -->
            <input type="hidden" name="payment_intent_id" value="{{ $paymentIntentId }}">
        </div>
        <button id="submit">Submit Payment</button>
        <div id="error-message">
            <!-- Display error message to your customers here -->
        </div>
    </form>

    <script src="https://js.stripe.com/v3/"></script>
    {{-- <script src="{{ asset('stripe/checkout.js') }}" defer></script> --}}

     <script>
        // Initialize Stripe
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        const options = {
            clientSecret: '{{ $clientSecret }}'
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
    </script>
</body>
</html>
