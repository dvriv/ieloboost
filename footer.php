<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package LeagueBoost
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="row footer-row">
				<div class="columns large-3">
					<h1 class="logo">
						<a href="/">
							<img src="<?= get_template_directory_uri(); ?>/assets/img/ieloboost.png" alt="iEloboost" />
						</a>
					</h1>
					<span class="copyright">Copyright © 2016</span>
					<a href="#terms" class="terms">Terms, Privacy & Copyright
						 Security
 					</a>
				</div>

				<div class="columns large-3">
					<h1>SITE PAGES</h1>
					<ul>
							<li>
							<a href="/#fBoosts">Boosts</a>
							</li>
							<li>
								<a href="/demo/">Demo</a>
							</li>
							<li>
								<a href="/faq/">FAQ</a>
							</li>
							<li >
								<a href="/wp-admin/">Dashboard</a>
							</li>
							<li >
								<a href="/wp-login.php">Login/Register</a>
							</li>
							<li>
								<a href="/contact/">Contact</a>
							</li>
					</ul>

				</div>

				<div class="columns large-3">
					<h1>SOLO BOOST</h1>
					<ul>
							<li>
								<a href="/solo-net-wins">Solo Net Wins</a>
							</li>
							<li>
								<a href="/solo-divisions">Solo Divisions</a>
							</li>
							<li>
								<a href="/solo-placements">Solo Placements</a>
							</li>
							<li>
								<a href="/solo-normals">Solo Normal Wins</a>
							</li>
					</ul>
				</div>

				<div class="columns large-3">
					<h1>DUO BOOST</h1>
					<ul>
							<li>
								<a href="/group-net-wins">Duo Net Wins</a>
							</li>
							<li>
								<a href="/group-divisions">Duo Divisions</a>
							</li>
							<li>
								<a href="/group-placements">Duo Placements</a>
							</li>
							<li>
								<a href="/group-games">Duo Games</a>
							</li>
					</ul>
				</div>
		</div><!-- .row -->
		<div class="disclaimer-container">
			<div class="row  disclaimer">
				<div class="columns large-12">
					<span>League of Legends is a registered trademark of Riot Games, Inc. We are in no way affiliated with, associated with or endorsed by Riot Games, Inc.</span>
				</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->


<!-- modal for login/registration/lostpassword -->

<div class="modal-overlay login-modal-overlay">
  <div class="login-modal">
		<button class="close-button login-close" aria-label="Close modal" type="button">
			<span aria-hidden="true">&times;</span>
		</button>
		<div class="modal-container">

			<div class="login-container">
				<a class="login-link active">Log In</a>
			<a class="signup-link">Sign Up</a>
			<!--********** login form********** -->
	    <form autocomplete="off" class="login_form" name="login_form" id="login_form" method="post">
				<h2>To continue to the Dashboard, please enter your credentials below</h2>
	      <div class="group username-container">
	        <input id="username" autocomplete="off" type="text" required name="username"><span class="bar"></span>
	        <label for="username">Username</label>
	      </div>
	      <div class="group password-container">
	        <input id="password" autocomplete="off" type="password" required name="password"><span class="bar"></span>
	        <label for="password">Password</label>
	      </div>
	      <button type="submit" class="btn-login">LOG IN</button>
				<a class="fgt-password">Forgot password?</a>
	  </form>

	<!--********** registration form********** -->

	<form autocomplete="off" class="login_form" name="register_customer_form" id="register_customer_form" method="post">
		<h2>Enter your email and create a password to get started</h2>
		<div class="group username-container">
			<input id="username" autocomplete="off" type="text" required name="username"><span class="bar"></span>
			<label for="username">Username</label>
		</div>
		<div class="group email-container">
			<input id="email" autocomplete="off" required type="email" name="email_address" />
			 <span class="bar"></span>
			 <label for="email_address">Email Address</label>
		 </div>
		<div class="group password-container">
			<input id="password" autocomplete="off" type="password" required name="password"><span class="bar"></span>
			<label for="password">Password</label>
		</div>
		<button type="submit" class="btn-login">SIGN UP</button>
		<a class="fgt-password">Forgot password?</a>
</form>

		<!--********** reset password form********** -->
		<form autocomplete="off" class="login_form" name="forgot_password_form" id="forgot_password_form" method="post">
			<h2>Enter the email address you used and we’ll send you instructions to reset your password</h2>
			<div class="group email-container">
				<input id="email" autocomplete="off" required type="email" name="email_address" />
				 <span class="bar"></span>
				 <label for="email_address">Email Address</label>
			 </div>
			<button type="submit" class="btn-login">RESET</button>
			<a class="fgt-password">Forgot password?</a>
	</form>
		</div>

				<div class="sidebar-login">
						<div class="registerAfter-container">
						<span>Remember that you can also register <strong>after</strong> the purchase has been made</span>
						<a href="#fBoosts" class="btn-boost">Go to Boosts</a>
						</div>
				</div>
		</div>
</div>

</div>

<!--

<div class="reveal" id="registerCustomerModal" data-reveal>
    <h1>Welcome to <?php echo get_option('blogname');?></h1>
	<form name="register_customer_form" id="register_customer_form" method="post">
		<fieldset class="fieldset">
  			<legend>Register your Account</legend>
			<div class="row">

				<div class="column small-12 float-right">
					<small>Please, fill all the fields to create your account.</small>
					<br><br>
				</div>

				<div class="column small-12 medium-6">
					<fieldset>
						<label for="username">Username</label>
						<input required type="text" name="username"/>
					</fieldset>
					<fieldset>
						<label for="email_address">Email Address</label>
						<input required type="email" name="email_address"/>
					</fieldset>
				</div>
				<div class="column small-12 medium-6">
					<fieldset>
						<label for="customer_password1">Password</label>
						<input type="password" id="customer_password1" required name="customer_password1"/>
					</fieldset>
					<fieldset>
						<label for="customer_password2">Confirm Password</label>
						<input type="password" id="customer_password2" required name="customer_password2"/>
					</fieldset>
				</div>
			</div>
		</fieldset>
	    <button class="close-button" data-close aria-label="Close modal" type="button">
	        <span aria-hidden="true">&times;</span>
	    </button>
		<input type="hidden" name="register_for" value="customer">
	    <button class="button" type="submit">Register</button>
		&nbsp;&nbsp;<span class="status_loader"></span>
		<a class="float-right" data-open="loginModal"><small>Already have an Account?</small></a>
		<a class="float-right" data-open="registerBoosterModal" style="clear:both;"><small>Register as a Booster</small></a>
	</form>
	<script type="text/javascript">

    var customer_password1 = document.getElementById("customer_password1")
      , customer_password2 = document.getElementById("customer_password2")

	  function validateCustomerPassword(){
	      if(customer_password1.value != customer_password2.value) {
	        customer_password2.setCustomValidity("Passwords Don't Match");
	      } else {
	        customer_password2.setCustomValidity('');
	      }
	  }
	  customer_password1.onchange = validateCustomerPassword;
	  customer_password2.onkeyup = validateCustomerPassword;
	</script>
</div>

<div class="reveal" id="registerBoosterModal" data-reveal>
    <h1>Welcome to <?php echo get_option('blogname');?></h1>
	<form name="register_booster_form" id="register_booster_form" method="post">
		<fieldset class="fieldset">
  			<legend>Request for Booster Account</legend>

			<div class="row">

				<div class="column small-12 float-right">
					<small>Please, fill all the fields to create your account.</small>
					<br><br>
				</div>

				<div class="column small-12 medium-6">
					<fieldset>
						<label for="username">Username</label>
						<input required type="text" name="username"/>
					</fieldset>
					<fieldset>
						<label for="email_address">Email Address</label>
						<input required type="email" name="email_address"/>
					</fieldset>
					<fieldset>
						<label for="lol_account_name">LOL Account Name</label>
						<input required type="text" name="lol_account_name"/>
					</fieldset>
				</div>
				<div class="column small-12 medium-6">
					<fieldset>
						<label for="booster_password1">Password</label>
						<input type="password" id="booster_password1" required name="booster_password1"/>
					</fieldset>
					<fieldset>
						<label for="booster_password2">Confirm Password</label>
						<input type="password" id="booster_password2" required name="booster_password2"/>
					</fieldset>
				</div>
			</div>
		</fieldset>
	    <button class="close-button" data-close aria-label="Close modal" type="button">
	        <span aria-hidden="true">&times;</span>
	    </button>
		<input type="hidden" name="register_for" value="booster">
	    <button class="button" type="submit">Register</button>
		&nbsp;&nbsp;<span class="status_loader"></span>
		<a class="float-right" data-open="registerCustomerModal"><small>Register as a Customer</small></a>
		<a class="float-right" data-open="loginModal" style="clear:both;"><small>Already have an Account?</small></a>
	</form>
	<script type="text/javascript">

    var booster_password1 = document.getElementById("booster_password1")
      , booster_password2 = document.getElementById("booster_password2")

	  function validateBoosterPassword(){
	      if(booster_password1.value != booster_password2.value) {
	        booster_password2.setCustomValidity("Passwords Don't Match");
	      } else {
	        booster_password2.setCustomValidity('');
	      }
	  }
	  booster_password1.onchange = validateBoosterPassword;
	  booster_password2.onkeyup = validateBoosterPassword;
	</script>
</div>

<div class="reveal" id="loginModal" data-reveal vOffset:3>
    <h1>Welcome to <?php echo get_option('blogname');?></h1>
	<form name="login_form" id="login_form" method="post">
		<fieldset class="fieldset">
  			<legend>Login to your Account</legend>
			<div class="row">
				<div class="column small-12">
					<fieldset>
						<label for="username">Username</label>
						<input required type="text" name="username"/>
					</fieldset>
					<fieldset>
						<label for="password">Password</label>
						<input required type="password" name="password"/>
					</fieldset>
				</div>
			</div>
		</fieldset>
	    <button class="close-button" data-close aria-label="Close modal" type="button">
	        <span aria-hidden="true">&times;</span>
	    </button>
	    <button class="button" type="submit">Login</button>
		&nbsp;&nbsp;<span class="status_loader"></span>
		<a class="float-right" data-open="registerCustomerModal"><small>Don't have an Account?</small></a>
		<a class="float-right" data-open="forgotPasswordModal" style="clear:both;"><small>Forgot Password?</small></a>
	</form>
</div>

<div class="reveal" id="activationRequiredModal" data-reveal>
    <h1>Activation Required</h1>
	<div class="content">
		We've registered your information, however, to access the account, you need to verify for the first time.
		We've sent you the activation procedure in your email address, Please check you mailbox.
	</div>
	<button class="close-button" data-close aria-label="Close modal" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="reveal" id="forgotPasswordModal" data-reveal>
    <h1>Welcome to <?php echo get_option('blogname');?></h1>
	<form name="forgot_password_form" id="forgot_password_form" method="post">
		<fieldset class="fieldset">
  			<legend>Reset Password</legend>
			<div class="row">
				<div class="column small-12">
					<small>Reset your Password with the Email Address you registered.<br>
						We will send you the reset link in the same mailbox!</small>
					<br><br>
					<fieldset>
						<label for="email_address">Email Address</label>
						<input required type="text" name="email_address"/>
					</fieldset>
				</div>
			</div>
		</fieldset>
	    <button class="close-button" data-close aria-label="Close modal" type="button">
	        <span aria-hidden="true">&times;</span>
	    </button>
	    <button class="button" type="submit">Reset</button>
		&nbsp;&nbsp;<span class="status_loader"></span>
		<a class="float-right" data-open="registerCustomerModal"><small>Don't have an Account?</small></a>
		<a class="float-right" data-open="loginModal" style="clear:both;"><small>Already have an Account?</small></a>
	</form>
</div> -->

<?php
if(isset($_GET['orderid']) && isset($_GET['key'])){
	$order_identify = get_post_meta($_GET['orderid'], 'order_identification', true);
	if($order_identify == $_GET['key']){?>
		<div class="large reveal" id="acountLoginRegister" data-reveal>
			<h1>Please Login/Register to proceed with your Payment.</h1>
			<?php echo get_custom_login_register_form();?>
		    <button class="close-button" data-close aria-label="Close modal" type="button">
		        <span aria-hidden="true">&times;</span>
		    </button>
		</div>

	    <script type="text/javascript">
		jQuery(function($){
			var $acountLoginRegister = new Foundation.Reveal($('#acountLoginRegister'));
				$acountLoginRegister.open();
		});
	    </script>
	<?php }
}?>

<?php if(isset($_SESSION) && isset($_SESSION['activated']) && $_SESSION['activated'] == true){?>
	<div class="reveal" id="acountActivated" data-reveal>
	    <h1>Welcome to <?php echo get_option('blogname');?></h1>
			<fieldset class="fieldset">
	  			<legend>Account Activated!</legend>
				<div class="row">
					<div class="column small-12">
						<p>Congratulation, Your account is now verified.</p>
						<ul>
				            <li><i class="fa fa-user"></i> Update your <a href="<?php echo admin_url()."profile.php"; ?>">Profile</a></li>
				            <li><i class="fa fa-link"></i> Go to your <a href="<?php echo admin_url(); ?>">Dashboard</a></li>
						</ul>
					</div>
				</div>
			</fieldset>
		    <button class="close-button" data-close aria-label="Close modal" type="button">
		        <span aria-hidden="true">&times;</span>
		    </button>
	</div>
    <script type="text/javascript">
	jQuery(function($){
		var $acountActivated = new Foundation.Reveal($('#acountActivated'));
			$acountActivated.open();
	});
    </script>
<?php
	unset($_SESSION['activated']);
}?>

<?php if(isset($_SESSION) && isset($_SESSION['resetPass']) && $_SESSION['resetPass'] == true){?>

	<div class="modal-overlay password-modal-overlay">
			<div class="temporarily-logged">
				<div class="container">
				<h1>Now you are temporarily logged in, please go to <a href="/wp-admin/profile.php">your profile</a> and click on "Generate Password" to choose a new password</h1>
				<a href="/wp-admin/profile.php" class="btn-boost">Go to Profile</a>
			</div>
			</div>
	</div>
	<script type="text/javascript">
jQuery(function($) {
	$(".password-modal-overlay").fadeIn(200);
})
	</script>

	<!-- <div class="reveal" id="resetPass" data-reveal>
	    <h1>Welcome to <?php echo get_option('blogname');?></h1>
			<fieldset class="fieldset">
	  			<legend>You are temporarily Logged In.</legend>
				<div class="row">
					<div class="column small-12">
						<p>Please reset your credentials from the Profile Page.</p>
						<ul>
				            <li><i class="fa fa-user"></i> Update your <a href="<?php echo admin_url()."profile.php"; ?>">Profile</a></li>
				            <li><i class="fa fa-link"></i> Go to your <a href="<?php echo admin_url(); ?>">Dashboard</a></li>
						</ul>
					</div>
				</div>
			</fieldset>
		    <button class="close-button" data-close aria-label="Close modal" type="button">
		        <span aria-hidden="true">&times;</span>
		    </button>
	</div>
    <script type="text/javascript">
	jQuery(function($){
		var $resetPass = new Foundation.Reveal($('#resetPass'));
			$resetPass.open();
	});
    </script> -->
<?php
	unset($_SESSION['resetPass']);
}?>

<?php wp_footer(); ?>
<?php if (!isset($_SESSION['tz'])) { ?>
	<script type="text/javascript">
		jQuery(function($){
			jQuery.ajax({
				type: "POST",
				url: '<?php echo admin_url( 'admin-ajax.php' );?>',
				data: {
					'action':'set_timezone',
					'timezone':jstz.determine().name()
				},
				success: function(data){
					//location.reload();
				}
			});
		});
	</script>
<?php } ?>

</body>
</html>
