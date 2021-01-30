// Create a Stripe client.
var stripe = Stripe('<YOUR STRIPE PUBLIC KEY>');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
    base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};

// Create an instance of the card Element.
var card = elements.create('card', { style: style });

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.on('change', function (event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function (event) {
    event.preventDefault();

    document.querySelector("#spinner").classList.remove("invisible");
    document.querySelector("#checkout-button").classList.add("disabled");

    const cardButton = document.getElementById('checkout-button');
    const clientSecret = cardButton.dataset.secret;

    stripe.confirmCardPayment(clientSecret, {
        payment_method: {
            card: card,
            billing_details: {
                name: document.getElementById('name').value,
                phone:'787-000-0000',
                email: document.getElementById('email').value,
                    address: {
                        line1: document.getElementById('address').value,
                        city: document.getElementById('city').value,
                        state: 'PR',
                        postal_code: document.getElementById('zip').value,
                    }
            }
        }
    })
    .then(function (result) {
        if (result.error) {
            // Inform the user if there was an error.
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
            document.querySelector("#spinner").classList.add("invisible");
            document.querySelector("#checkout-button").classList.remove("disabled");

        } else {
            if (result.paymentIntent.status === 'succeeded') {
                // Show a success message to your customer
                // There's a risk of the customer closing the window before callback
                // execution. Set up a webhook or plugin to listen for the
                // payment_intent.succeeded event that handles any business critical
                // post - payment actions.
                const form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'paymentID');
                hiddenInput.setAttribute('value', result.paymentIntent.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        }
    });
});