<?php
/**
 * Template Name: Solo Normals
 *
 * The template for Solo Division Booster page.
 * @package LeagueBoost
 */

get_header(); ?>
<div id="primary" class="content-area">
    <div class="page-description">
        <div class="wrap">
            <h1>Solo Normal Games </h1>
            <span>We will play the amout of wins you desire</span>
        </div>
    </div>
        <main id="main" class="site-main" role="main">
          <section>
                <div class="row form-container">
                    <form action="<?php echo home_url('/boosting-purchase');?>" method="POST" class="booster_payement_form" id="solo_division_form" name="solo_division_form">
                    <div class="medium-12 columns desiredColumns">
                            <div class="title">Select Amount</div>
                            <div id="general-wins_stat" class="normal-wins-stat slider_stat stat"></div>
                        <input type="hidden" id="from_division" value=""/>
                        <input type="hidden" id="from_division" value=""/>
                        <input type="hidden" id="to_league" value=""/>
                        <input type="hidden" id="to_division" value=""/>
                        <fieldset class="normal-wins-fieldset">
                            <label for="general-winsLabel" class="control-label columns">Normal Wins</label>
                            <div class="normal-wins-slider">
                                <div class="slider" id="general-wins_slider" aria-labelledby="general-winsLabel" data-slider data-start='1' data-initial-start='3' data-end='10'>
                                  <span class="slider-handle"  data-slider-handle role="slider" tabindex="1"></span>
                                  <span class="slider-fill" data-slider-fill></span>
                                  <input type="hidden" name="general-wins_sliderValue" id="general-wins_sliderValue">
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
                                <input type="hidden" name="action" value="general-wins">
                                <img width="100" src="
									<?php echo get_template_directory_uri(); ?>/assets/img/paypal.png">
                                <button  id="payBoosting" type="submit" class="large button payButton">Purchase Total : $
                                    <span id="final_price">10</span>
                                </button>
                            	<div class="alert label error_display hide">The desired rank must be higher than the current rank!</div>
                            </div>
                        </fieldset>
                	</div>
                    </form>
                    <span class="listServers">Service available in the following servers: <br> <strong>North America, Europe West, Europe Nordic & East, Brazil, Latin America North, Latin America South and Oceania!</strong></span>
                    <span> This is a Solo Division Boost. This mean the booster will log in to your account to play the games. If you want to Duo Queue with the booster, please go to the <a href="/group-games">Duo version of this boost here</a></span>
                    <div class="clear"></div>
                </div>
                                <section class="bQuestions">
                                  <h1>Frequently Asked Questions</h1>
                                    <div class="row rowQuestions">
                                              <div class="question-container">
                                                <h2>What is a Normal Wins Boost?</h2>
                                                <p>In a Normal Wins Boost, A booster will log into your account and play normal games until he reaches the amount of wins you purchased. We do not offer any net wins for this service.</p>
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
                                                  <p>It depends on the order size and the time you pause the order.</p>
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
