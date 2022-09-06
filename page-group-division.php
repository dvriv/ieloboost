<?php
/**
 * Template Name: Group Division
 *
 * The template for Solo Division Booster page.
 * @package LeagueBoost
 */

get_header(); ?>
<div id="primary" class="content-area">
    <div class="page-description">
        <div class="wrap">
            <h1>Duo Division Boost</h1>
            <span>Choose a Desired League and we will play with you in Duo Queue</span>
        </div>
    </div>
        <main id="main" class="site-main" role="main">
                <div class="row form-container">
                    <form action="<?php echo home_url('/boosting-purchase'); ?>" method="POST" class="booster_payement_form" id="solo_division_form" name="solo_division_form">
                    <div class="medium-6 small-12 columns">
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
                        <fieldset>
                            <label for="ileague" class="medium-2 control-label columns">Points</label>
                            <div class="medium-10 columns">
                                <select name="league_points" id="league_points" onchange="javascript:updateBoostingImage('to');" class="form-control">
                                    <option value="20">0-20</option>
                                    <option value="40">21-40</option>
                                    <option value="60">41-60</option>
                                    <option value="80">61-80</option>
                                    <option value="100">81-100</option>
                                </select>
                            </div>
                        </fieldset>
                    </div>
                    <div class="medium-6 small-12 columns">
                      <div class="medium-12 small-12 large-12 columns rank-container">
                          <div class="title">Desired Rank</div>
                          <div class="img-container">
                            <span class="discount">25% OFF</span>
                          <img class="img-responsive" id="to-image" src="
                              <?php echo get_template_directory_uri(); ?>/assets/img/divisions/2_1.png" />
                          </div>
                      </div>
                        <fieldset>
                            <label for="to_league" class="medium-2 control-label columns">League</label>
                            <div class="medium-10 columns">
                                <select id="to_league" onChange="javascript:updateBoostingImage('to');" name="to_league" class="custom-select form-control">
                                    <option value="1">Bronze</option>
                                    <option value="2">Silver</option>
                                    <option value="3" selected>Gold</option>
                                    <option value="4">Platinum</option>
                                    <option value="5">Diamond</option>
                                </select>
                            </div>
                        </fieldset>
                        <fieldset>
                            <label for="to_division" class="medium-2 control-label columns">Division</label>
                            <div class="medium-10 columns">
                                <select id="to_division" onChange="javascript:updateBoostingImage('to');" name="to_division" class="custom-select form-control">
                                    <option value="1">V</option>
                                    <option value="2">IV</option>
                                    <option value="3">III</option>
                                    <option value="4" selected>II</option>
                                    <option value="5">I</option>
                                </select>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="medium-12 small-12 columns">
                                <input type="hidden" name="L_PAYMENTREQUEST_0_NAME0" value="EloBoost"/>
                                <input type="hidden" name="L_PAYMENTREQUEST_0_DESC0" value="EloBoost Service Charge"/>
                                <input type="hidden" name="PAYMENTREQUEST_0_ITEMAMT" value="10.00"/>
                                <input type="hidden" name="CANCEL_URL" value="<?php echo get_permalink();?>"/>
                                <input type="hidden" name="proceed_payment" value="true"/>
                                <input type="hidden" name="type" value="2"><!-- 2 for group games -->
                                <input type="hidden" name="action" value="division">
                                <img width="100" src="
									<?php echo get_template_directory_uri(); ?>/assets/img/paypal.png">
                                <button  id="payBoosting" type="submit" class="large button payButton">Purchase Total : $
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
                    <span> This a Duo Division Boost. This mean you have to play with the booster in Duo Queue. If you want the booster to play on your account, please <a href="/solo-divisions">go to the Solo version of the same boost here</a></span>
                    <br><br><span>All the boosts are available for <strong>Solo/Duo Queue</strong> and <strong>Flex Queue</strong>, you can specify it later in your Dashboard</span>
                    <div class="clear"></div>
                </div>
                <section class="bQuestions">
                  <h1>Frequently Asked Questions</h1>
                  <div class="row rowQuestions">
                            <div class="question-container">
                              <h2>What is a Division Boost?</h2>
                              <p>In a Division Boost you choose a league and a division, and the booster will play with you until reaching that desired league and division.</p>
                            </div>
                            <div class="question-container">
                              <h2>What is a Duo Boost?</h2>
                              <p>In Duo Boost, the booster plays with you in Duo Queue with his own smurf account with a similar rank to yours. For this service you don't have to give your account name and password.</p>
                            </div>
                            <div class="question-container">
                              <h2> Can I change my booster while the order is in progress?</h2>
                              <p>Yes, make a request to the administrator on the chat located on your dashboard.</p>
                            </div>
                            <div class="question-container">
                              <h2>What is your refund policy?</h2>
                              <p>Refunds can be made if the order never started or the booster didn't play any match. If the order was in progress and some games were played, refunds will only be done in a case by case basis. For example, if the booster does something improper or is taking too much time to finish your order. We reserve the right to refuse any refund we consider is not justified. For more information please read our terms and conditions.</p>
                            </div>
                            <div class="question-container">
                              <h2>Is possible to my account to be banned?</h2>
                              <p>No, Duo Boosting is not again the rules of the game.</p>
                            </div>
                            <div class="question-container">
                              <h2>Can I play ranked games without the booster?</h2>
                              <p>No, you should never play ranked games if you have a Division Boost.</p>
                            </div>
                            <div class="question-container">
                              <h2>How much time will my order take to be completed?</h2>
                              <p>It depends on your and your booster's availability. We recommend to indicate your schedule availability in Notes to Booster or in a message to the admin in the chat so we can assign you a booster with a availability according to your needs.</p>
                            </div>
                            <div class="question-container">
                              <h2>Can i request my order to be played with only specifics champions or lanes?</h2>
                              <p>Yes, you can specify the lanes and the champions that will be used to complete your order. We do not recommend to choose champs outside of the metagame because the booster may take more time to complete your order. If you do ask for a specific champion/lane that isn't in the metagame, for example, Urgot, keep in mind that it will be harder for our boosters and the order will take more time. But don't worry, our boosters can do it!</p>
                            </div>
                            <div class="question-container">
                              <h2>What security do you offer for my payment information and other sensitive data?</h2>
                              <p>Every single bit of information you share with us is encrypted using a 256 bits SSL certificate. Also for your security, all payments are handled by PayPal, so we have no access to any of your private information.</p>
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
