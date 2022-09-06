<?php
/**
 * Template Name: Solo Net Wins
 *
 * The template for Solo Division Booster page.
 * @package LeagueBoost
 */

get_header(); ?>
<div id="primary" class="content-area">
  <div class="page-description">
      <div class="wrap">
          <h1>Solo Net Wins</h1>
          <span>We will play the amout of positive wins you desire</span>
      </div>
  </div>
    <main id="main" class="site-main" role="main">
      <section>
      <div class="row form-container">
                    <form action="<?php echo home_url('/boosting-purchase'); ?>" method="POST" class="booster_payement_form" id="solo_division_form" name="solo_division_form">
                    <div class="medium-6 small-12 columns desiredColumns">
                      <div class="medium-12 small-12 large-12 columns rank-container">
                            <div class="title">Current Standing</div>
                            <img class="img-responsive" id="from-image" src="
                                <?php echo get_template_directory_uri(); ?>/assets/img/divisions/1_4.png">
                        </div>
                        <fieldset>
                            <label for="ileague" class="medium-2 control-label columns">League</label>
                            <div class="medium-10 columns">
                                <select id="from_league" onChange="javascript:updateBoostingImage('from');" name="from_league" class="custom-select form-control">
                                    <option value="1">Bronze</option>
                                    <option value="2" selected>Silver</option>
                                    <option value="3">Gold</option>
                                    <option value="4">Platinum</option>
                                    <option value="5">Diamond</option>
                                </select>
                            </div>
                        </fieldset>
                        <fieldset>
                            <label for="from_division" class="medium-2 control-label columns">Division</label>
                            <div class="medium-10 columns">
                                <select id="from_division" onChange="javascript:updateBoostingImage('from');" name="from_division" class="custom-select form-control">
                                    <option value="1" selected>V</option>
                                    <option value="2">IV</option>
                                    <option value="3">III</option>
                                    <option value="4">II</option>
                                    <option value="5">I</option>
                                </select>
                            </div>
                        </fieldset>
                    </div>
                    <div class="medium-6 small-12 columns desiredColumns">
                        <div class="medium-12 small-12 large-12 columns rank-container">
                            <div class="title">Desired Amount</div>
                            <div class="img-container">
                            <span class="discount">25% OFF</span>
                            </div>
                            <div id="net-wins_stat" class="slider_stat stat"></div>
                        </div>
                        <input type="hidden" id="to_league" value=""/>
                        <input type="hidden" id="to_division" value=""/>
                        <fieldset>
                            <label for="number_of_winsLabel" class="control-label columns">Number of Wins</label>
                            <div class="medium-12 columns">
                                <div class="slider" id="net-wins_slider" aria-labelledby="number_of_winsLabel" data-slider data-start='1' data-initial-start='3' data-end='10'>
                                  <span class="slider-handle"  data-slider-handle role="slider" tabindex="1"></span>
                                  <span class="slider-fill" data-slider-fill></span>
                                  <input type="hidden" name="net-wins_sliderValue" id="net-wins_sliderValue">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="medium-12 small-12 columns">
                                <input type="hidden" name="L_PAYMENTREQUEST_0_NAME0" value="EloBoost"/>
                                <input type="hidden" name="L_PAYMENTREQUEST_0_DESC0" value="EloBoost Service Charge"/>
                                <input type="hidden" name="PAYMENTREQUEST_0_ITEMAMT" value="10.00"/>
                                <input type="hidden" name="CANCEL_URL" value="<?php echo get_permalink();?>"/>
                                <input type="hidden" name="proceed_payment" value="true"/>
                                <input type="hidden" name="type" value="1"><!-- 2 for group games -->
                                <input type="hidden" name="action" value="net-wins">
                                <img width="100" src="
									<?php echo get_template_directory_uri(); ?>/assets/img/paypal.png">
                                <button id="payBoosting" type="submit" class="large button payButton">Purchase Total : $
                                    <span id="final_price">10</span>
                                </button>
                                <div class="old_price_container">
                                  <span>Old Price: <i>$</i></span><span id="old_price">10</span>
                              </div>
                            	<div class="alert label error_display hide">The desired rank must be higher than the current rank!</div>
                            </div>
                        </fieldset>
                	</div>
                    </form>
                    <span class="listServers">Service available in the following servers: <br> <strong>North America, Europe West, Europe Nordic & East, Brazil, Latin America North, Latin America South and Oceania!</strong></span>
                    <span> This is a Solo Division Boost. This mean the booster will log in to your account to play the games. If you want to Duo Queue with the booster, please go to the <a href="/group-net-wins">Duo version of this boost here</a></span>
                    <br><br><span>All the boosts are available for <strong>Solo/Duo Queue</strong> and <strong>Flex Queue</strong>, you can specify it later in your Dashboard</span>
                    <div class="clear"></div>
                </div>

                <section class="bQuestions">
                  <h1>Frequently Asked Questions</h1>
                  <div class="row rowQuestions">
                            <div class="question-container">
                              <h2>What is a Net Wins?</h2>
                              <p>In a Net Wins Boost, you choose the number of net wins you want and the booster will play until the total number of purchased net wins is reached. A net win is calculated by the number of victories minus the number of defeats. This means that if you asked for one net win and for whatever reason our booster loses one game, he will have to win a total of two games to fulfill the order. Another example: 10 victories and 3 defeats give a total of 7 net wins.</p>
                            </div>
                            <div class="question-container">
                              <h2>What is a Solo Boost?</h2>
                              <p>In a Solo Boost, the booster logs into your account and plays the games for you. For this service, your account name and password is required.</p>
                            </div>
                            <div class="question-container">
                              <h2> Can i change my booster while the order is in progress?</h2>
                              <p>Yes, make a request to the administrator on the chat located on your dashboard.  </p>
                            </div>
                            <div class="question-container">
                              <h2>What security measures do you use to guarantee my account security?</h2>
                              <p>Is not possible to steal accounts since every account has a specific email associated with it. Only the owner has access to it, so your account is always recoverable. Regardless, each of our boosters has passed a strict review and a trial period before they get access to any account.</p>
                            </div>
                            <div class="question-container">
                              <h2> What about getting banned?</h2>
                              <p>We have a serie of security measures to be sure every boost is not detected by Riot. We can tell about some of them, but we prefer to keep most of them private so Riot doesn't know exactly what we do. Also, we need your help to ensure this and we have text inside the dashboard indicating what you should and shouldn't do.</p>
                            </div>
                            <div class="question-container">
                              <h2>Will my booster use my IP/RP?</h2>
                              <p>He will never use or change anything in your account without your permission.</p>
                            </div>
                            <div class="question-container">
                              <h2>How much time will my order take to be completed?</h2>
                              <p>It depends on the order size and the time you pause the order. For example: A Solo Boost order from Silver V to Gold V should take 48 to 72 hours to be completed.</p>
                            </div>
                            <div class="question-container">
                              <h2>Can i request my order to be played with only specifics champions or lanes?</h2>
                              <p>Yes, you can specify the lanes and the champions that will be used to complete your order, but is recommended to keep inside the metagame or the boost may take more time to be finished because it will be harder to win with things like Soraka ADC (But don't worry, our boosters can do it!)</p>
                            </div>
                            <div class="question-container">
                              <h2>What security do you offer for my payment information and other sensitive data?</h2>
                              <p>Every single bit of information you share with us is encrypted using a 256 bits SSL certificate. Also for you security all payments are handled completely by paypal, so we have no access to any of your private information.</p>
                            </div>
                  </div>
                        <h1>Have more questions?</h1>
                        <p class="checkFAQ">You can check our <a>Full FAQ</a> or contact our live support.</p>

                </section>
	</main>
    <!-- #main -->
</div>
<!-- #primary -->
<?php get_template_part( 'template-parts/content-boosting-prices');?>
<?php get_template_part( 'template-parts/content-boosting-footer');?>

<?php
get_footer();
