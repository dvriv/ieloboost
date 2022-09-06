<?php
/**
 * Template Name: Coaching Page
 *
 * The template for Coaching Booster page.
 * @package LeagueBoost
 */
global $post;
get_header(); ?>
<div id="primary" class="content-area">
    <div class="page-description">
        <div class="wrap">
            <h1>Coaching</h1>
        </div>
    </div>
    <main id="main" class="site-main" role="main">
                <div class="row">
                    <div class="medium-6 small-12 columns desiredColumns">
                        <form action="<?php echo home_url('/boosting-purchase'); ?>" method="POST" class="hourly-coaching_form" name="hourly-coaching_form">
                            <div class="medium-12 small-12 large-12 columns">
                                <div class="title">Hourly Coaching</div>
                                <div id="hourly-coaching_stat" class="slider_stat stat">2</div>
                            </div>
                            <fieldset>
                                <label for="number_of_hoursLabel" class="medium-3 control-label columns">Number of Hours</label>
                                <div class="medium-9 columns">
                                    <div class="slider" id="hourly-coaching_slider" aria-labelledby="number_of_hoursLabel" data-slider data-start='1' data-initial-start='2' data-end='10'>
                                      <span class="slider-handle"  data-slider-handle role="slider" tabindex="1"></span>
                                      <span class="slider-fill" data-slider-fill></span>
                                      <input type="hidden" name="hourly-coaching_sliderValue" id="hourly-coaching_sliderValue">
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
                                    <input type="hidden" name="type" value="hourly">
                                    <input type="hidden" name="action" value="coaching">
                                    <img width="100" src="<?php echo get_template_directory_uri(); ?>/assets/img/paypal.png"/>
                                    <button id="hourly-coaching_payBoosting" type="submit" class="large button payButton">Purchase Total : $<span id="hourly-coaching_final_price">10</span></button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="medium-6 small-12 columns desiredColumns">
                        <form action="<?php echo home_url('/boosting-purchase'); ?>" method="POST" class="games-coaching_form" name="games-coaching_form">
                            <div class="medium-12 small-12 large-12 columns">
                                <div class="title">Games Coaching</div>
                                <div id="games-coaching_stat" class="slider_stat stat">3</div>
                            </div>
                            <fieldset>
                                <label for="number_of_winsLabel" class="medium-3 control-label columns">Number of Wins</label>
                                <div class="medium-9 columns">
                                    <div class="slider" id="games-coaching_slider" aria-labelledby="number_of_winsLabel" data-slider data-start='1' data-initial-start='3' data-end='10'>
                                      <span class="slider-handle"  data-slider-handle role="slider" tabindex="1"></span>
                                      <span class="slider-fill" data-slider-fill></span>
                                      <input type="hidden" name="games-coaching_sliderValue" id="games-coaching_sliderValue">
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
                                    <input type="hidden" name="type" value="games">
                                    <input type="hidden" name="action" value="coaching">
                                    <img width="100" src="<?php echo get_template_directory_uri(); ?>/assets/img/paypal.png"/>
                                    <button id="games-coaching_payBoosting" type="submit" class="large button payButton">Purchase Total : $<span id="games-coaching_final_price">10</span></button>
                                </div>
                            </fieldset>
                        </form>
                	</div>
                    </form>
                    <div class="clear"></div>
                </div>
	</main>
    <!-- #main -->
</div>
<!-- #primary -->
<?php get_template_part( 'template-parts/content-boosting-prices');?>

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
          button: ['hourly-coaching_payBoosting','games-coaching_payBoosting'],
          environment: '<?php echo $env; ?>'
      });
    };
</script>

<?php
get_footer();
