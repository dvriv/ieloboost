<?php
/*
* Content Part of Boosting Templates
*/
 ?>
<div class="reveal" id="howToPlaceOrder" data-reveal>
    <h1>HOW TO PLACE YOUR ORDER.</h1>
    <ol>
        <li>Log on to your Account.</li>
        <li>Choose your current rank/division</li>
        <li>Choose the desired rank/division.</li>
        <li>Accept Terms of Use and press the Purchase button.</li>
        <li>Fill in the Pre-Order Form and Click the "Confirm Order" Button.</li>
        <li>You'll be redirected to PayPal. Fill in your PayPal Account Information and accept the transaction for your Order.</li>
        <li>You will be redirected to our Site and your order is completed.</li>
    </ol>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>


<script src="//www.paypalobjects.com/api/checkout.js" async></script>
  <script type="text/javascript">
  <?php
  	if(SANDBOX_FLAG){
  		$merchantID=PP_USER_SANDBOX;  /* Use Sandbox merchant id when testing in Sandbox */
  		$env= 'sandbox';
  	}
  	else {
  		$merchantID=PP_USER;  /* Use Live merchant ID for production environment */
  		$env='production';
  	}
    ?>
  window.paypalCheckoutReady = function () {
      paypal.checkout.setup('<?php echo $merchantID; ?>', {
          button: 'payBoosting',
          environment: '<?php echo $env; ?>'
      });
  };
  </script>
