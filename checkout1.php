<?php
require 'vendor/autoload.php';
 \Stripe\Stripe::setApiKey('your_stripe_api_key');

  $checkout_session = \Stripe\Checkout\Session::create([
      'success_url' => 'http://billingbizz.com/success.php?session_id={CHECKOUT_SESSION_ID}',
      'cancel_url' => 'http://billingbizz.com/cancel.html',
      'payment_method_types' => ['card'],
      'mode' => 'payment',
      'line_items' => [[
        // 'price' => "price_1OaxzlSGitGctbJvaBY5WS21",
        // For metered billing, do not pass quantity
        'quantity' => 1,
        'price_data' => [
            'currency' => 'inr',
            'unit_amount' => 9900, 
            'product_data' => [
                'name' => '3 months plan']]
      ]],
    ]);

?>
<head>
  <title>Stripe Subscription Checkout</title>
  <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
  <script type="text/javascript">
     var stripe = Stripe('pk_live_51O97nOSGitGctbJvOy8v7z8nLne7qBhpRX3nfKD6wUEIULTG1d7Zr1uirlq7ZEoSTXE2OmfDatr7FpkbKQMiDP7H002jOtAMFW');
     var session = "<?php echo $checkout_session['id']; ?>";
          stripe.redirectToCheckout({ sessionId: session })
                  .then(function(result) {
          // If `redirectToCheckout` fails due to a browser or network
          // error, you should display the localized error message to your
          // customer using `error.message`.
          if (result.error) {
            alert(result.error.message);
          }
        })
        .catch(function(error) {
          console.error('Error:', error);
        });          



  </script>
  
</body>


