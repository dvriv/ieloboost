<?php
/**
 * Template Name: Booster
 * The template for Boost page.
 * @package LeagueBoost
 */

get_header(); ?>
	<div id="primary" class="content-area">

			<main id="main" class="site-main" role="main">
					<div class="row boostrow">
							<div class="large-12 columns boostcolumn">
								<div class="tab-pane active" id="tab1">
									<h1 style="text-align: center">
										Guaranteed League / Division Boosting</h1>
									<div class="row">



								<?php
									if ( !is_user_logged_in() ) { ?>
									<form action="" method="post">
							 	<?php } else { ?>
									  <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" class="form-horizontal" id="test_win_form" name="test_win_form">
								<?php } ?>
									  <!-- <input type="hidden" name="cmd" value="_s-xclick">
									  <input type="hidden" name="hosted_button_id" value="6RNT8A4HBBJRE"> -->
										<input type="hidden" name="business" value="lalamitranjan@yahoo.com">
										<input type="hidden" name="cmd" value="_xclick">
										<input type="hidden" name="item_name" value="buy boosting">
										<input type="hidden" name="cancel_return" value="<?php echo get_permalink();?>">
										<input type="hidden" name="return" value="<?php echo get_permalink();?>">
										<input type="hidden" name="amount" value="10">
										<input type="hidden" name="item_number" value="1">
											<div class="medium-6 small-6 columns">
												<div class="medium-12 small-12 large-12 columns">
													<div class="title">Current standing</div>
													<img class="img-responsive" id="from-image" src="<?php echo get_template_directory_uri(); ?>/assets/img/divisions/1_4.png">
												</div>

												<fieldset>
													<label for="ileague" class="medium-2 control-label columns">League</label>
													<div class="medium-10 columns">
														<select id="from_league" onChange="javascript:updateBoostingImage('from');" name="from_league" class="custom-select form-control">
															<option value="0">Bronze</option>
															<option value="1" selected>Silver</option>
															<option value="2">Gold</option>
															<option value="3">Platinum</option>
															<option value="4">Diamond</option>
															<option value="5">Master</option>
														</select>
													</div>
												</fieldset>

												<fieldset>
													<label for="from_division" class="medium-2 control-label columns">Division</label>
													<div class="medium-10 columns">
														<select id="from_division" onChange="javascript:updateBoostingImage('from');" name="from_division" class="custom-select form-control">
															<option value="4" selected>V</option>
															<option value="3">IV</option>
															<option value="2">III</option>
															<option value="1">II</option>
															<option value="0">I</option>
														</select>
													</div>
												</fieldset>

												<fieldset>
													<label for="ileague" class="medium-2 control-label columns">Points</label>
													<div class="medium-10 columns">
														<input type="text" name="points" value="0" id="points" max="100" min="0" class="form-control">
													</div>
												</fieldset>

												<fieldset>
													<label for="ileague" class="medium-2 control-label columns">LP gain</label>
													<div class="medium-10 columns">
														<input type="text" name="lpgain" value="15" min="1" max="30" id="lp_gain" class="form-control">
													</div>
												</fieldset>

											</div>


											<div class="medium-6 small-6 columns">
												<div class="medium-12 small-12 large-12 columns">
													<div class="title">Desired Standing</div>
													<img class="img-responsive" id="to-image" src="<?php echo get_template_directory_uri(); ?>/assets/img/divisions/2_1.png">
												</div>
												<fieldset>
													<label for="to_league" class="medium-2 control-label columns">League</label>
													<div class="medium-10 columns">
														<select id="to_league" onChange="javascript:updateBoostingImage('to');" name="to_league" class="custom-select form-control">
															<option value="0">Bronze</option>
															<option value="1">Silver</option>
															<option value="2" selected>Gold</option>
															<option value="3">Platinum</option>
															<option value="4">Diamond</option>
															<option value="5">Master</option>
															<option value="6">Challenger</option>
														</select>
													</div>
												</fieldset>

												<fieldset>
													<label for="to_division" class="medium-2 control-label columns">Division</label>
													<div class="medium-10 columns">
														<select id="to_division" onChange="javascript:updateBoostingImage('to');" name="to_division" class="custom-select form-control">
															<option value="4">V</option>
															<option value="3">IV</option>
															<option value="2">III</option>
															<option value="1" selected>II</option>
															<option value="0">I</option>
														</select>
													</div>
												</fieldset>
												<fieldset>
													<div class="medium-12 small-12 columns">
														<div class="checkbox" style="margin-left: 30px">
															<label>
																<input type="checkbox" name="accept_terms" class="acceptBoostingTerms">
																I confirm that all the entered information is accurate and I agree to your <a data-open="terms_modal" class="open-terms">terms of use</a>.
															</label>
														</div>
													</div>
												</fieldset>

												<input type="hidden" name="quantity" value="1">
												<input type="hidden" name="type" value="1">
												<input type="hidden" name="action" value="ldboosting">

												<div class="form-group pull-right" style="margin-right: 0px;">
													<img width="100" src="<?php echo get_template_directory_uri(); ?>/assets/img/paypal.png">
													<button  id="payBoosting" <?php if(!is_user_logged_in()){ echo 'type="button" data-toggle="modal" data-target="#login-modal"'; } else { echo 'type="submit"'; }?>  class="btn btn-info btn-lg payButton">Purchase Total : $ <span id="final_price">10</spands=></button>
												</div>
											</div>

											<div class="pull-right">

												<div>All discounts will be visible in the checkout page</div>
											</div>

											<div class="clear"></div>
										</form>

										<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
										  <input type="hidden" name="cmd" value="_s-xclick">
										  <input type="hidden" name="hosted_button_id" value="6RNT8A4HBBJRE">
										  <input type="image"
											src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif"
											name="submit" alt="PayPal - The safer, easier way to pay online!">
										  <img alt="" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif"
											width="1" height="1">
										</form>
									</div>
									<div class="text-center">
										<button class="button" data-open="howToPlaceOrder">
											HOW TO PLACE YOUR ORDER
										</button>
									</div>
								</div>
							</div>

					</div>
			</main><!-- #main -->
		</div><!-- #primary -->

<div class="reveal" id="terms_modal" data-overlay="false" data-reveal>
	<h1>Terms and Agreement.</h1>
	<p>.....</p>
	<p>........ :</p>
	<button class="close-button" data-close aria-label="Close modal" type="button">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="reveal" id="howToPlaceOrder" data-overlay="false" data-reveal>
  <h1>HOW TO PLACE YOUR ORDER.</h1>
  <p><p>HOW TO PLACE YOUR ORDER</p>
  <p>STEP ONE :</p>
  <p>LOG ON TO YOUR LOLELOBOOSTER.COM ACCOUNT</p>
  <p>STEP TWO:</p>
  <p>Choose your current rank/division</p>
  <p>STEP THREE:</p>
  <p>
	  Choose the desired rank/division/amount
	  of wins.
  </p>
  <p>STEP FOUR: </p>
  <p>ACCEPT TERMS OF USE AND PRESS THE PURCHASE BUTTON</p>
  <p>STEP FIVE:</p>
  <p>
	  FILL IN THE PRE-ORDER FORM AND CLICK THE "CONFIRM
	  ORDER" BUTTON
  </p>
  <p>STEP SIX: </p>
  <p>
	  YOU WILL BE REDIRECTED TO PAYPAL.
	  YOU NEED TO FILL IN YOUR PAYPAL ACCOUNT
	  INFORMATION AND ACCEPT THE TRANSACTION FOR YOUR ORDER.
  </p>
  <p>STEP SEVEN:</p>
  <p>YOU WILL BE REDIRECTED TO OUR SITE AND YOUR ORDER IS COMPLETED.</p><br></p>
  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<?php
get_footer();
