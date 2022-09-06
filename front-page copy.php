<?php
/**
 * The template for the Front Page
 *
 * This template display the Static Front Page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package LeagueBoost
 */

get_header('frontpage'); ?>

<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
				<section id="fVpn" class="fVpn">
						 <div class="front row">
								 <div class="large-6 medium-8 medium-centered small-centered small-10 columns">
										<h1 class="front">We care as much as you about the security and privacy of your account</h1>
										<p class="front">We use a premium VPN(Virtual Private Network) and strong security measures to ensure that your account will never be suspended or compromised in any way if you use our services.</p>
								</div>
						</div>
				</section>
				<section id="fRecorded" class="fRecorded">
						<div class="front row">

							<div class="large-6 large-uncentered medium-8 medium-centered small-centered small-10 columns">
									<h1 class="front">We have the most friendly high Elo players in the Elo Boosting market</h1>
									<p class="front">Every single booster we have is at least Diamond l and all of them had to pass a special process to verify they are able to boost at any league. Some of them are known for being EX-pro players. Get ready to get the fastest and most secure boost you’ve ever had!</p>
							</div>
						</div>
				</section>
				<section id="fBoosters" class="fBooster">
						<div class="front row">
							<div class="large-6 medium-8 medium-centered small-centered small-10 columns">
								<h1 class="front">Get full control of your boost at any moment</h1>
								<p class="front">With our special dashboard you can:</p>
							<ul>
							<li>Pick the roles and  champions you want us to play</li>
							<li>Communicate with your booster whenever you need to</li>
							<li>Pause the order whenever you want</li>
							<li>Check the match history of all the games played by the booster</li>
							</ul>
						</div>
						 </div>
				</section>

				<section id="fTestimonials"class="fTestimonials">
				<script>
				jQuery(document).ready(function(){
				  jQuery(".owl-carousel").owlCarousel({
				    singleItem : true,
				    navigation : true,
				    navigationText : false,
				    pagination : false,
				    stopOnHover: true,
				    autoHeight : true,
				    slideSpeed : 200,
				    rewindSpeed : 750
				});
				});
				</script>
				<div class="owl-carousel">
				  <div class="testimonials">
				    <div class="quote">
				   “My booster never loses, no matter how much the team feeds, hes very communicative. One of the most professional boosters on this sight. He has never told me his current rank but im guessing it's high challenger at the very least”
				    </div>
				    <!-- <div class="quote-author">
				    Anonymous - Silver III to Platinum V
				    </div> -->
				    <div class="quote-img">
							<img src="/wp-content/themes/leagueboost/assets/img/testim1.png" width="500px">
				    </div>
				  </div>
				  <div class="testimonials">
				    <div class="quote">
							“The boost was super quick. After purchasing, the booster added me and started the game up and we finished the game in under 20 minutes he is here to get the job done. Great games!”
						</div>
					  <!-- <div class="quote-author">
				    Anonymous - Bronze I to Platinum V
				    </div> -->
				    <div class="quote-img">
							<img src="/wp-content/themes/leagueboost/assets/img/testim2.png" width="500px" >
				    </div>
				  </div>
				  <div class="testimonials">
				    <div class="quote">
				   “I played support while my booster played ADC. He communicated well and was quite friendly. Finally Gold 5. Thank you so much. :)”
				    </div>
				    <!-- <div class="quote-author">
				    Anonymous - Bronze 5 to Diamond 5
				    </div> -->
				    <div class="quote-img">
							<img src="/wp-content/themes/leagueboost/assets/img/testim3.png" width="500px">
				    </div>
				  </div>

				  <div class="testimonials">
				    <div class="quote">
							“Friendly and experienced booster. Started in less than 15 minutes after the payment went through. Definitely a good experience, now my MMR is back to normal. Thanks a lot! :)”
				    </div>
				    <!-- <div class="quote-author">
				    Anonymous - Bronze 5 to Diamond 5
				    </div> -->
				    <div class="quote-img">
							<img src="/wp-content/themes/leagueboost/assets/img/testim1.png" width="500px">
				    </div>
				  </div>
				  <div class="testimonials">
				    <div class="quote">
							“He was an outstanding booster, not only carried hard every game he gave out game play times to every member of my team in-game. leading to everyone doing well, I will be requesting him again A+++”
				    </div>
				    <!-- <div class="quote-author">
				    Anonymous - Bronze 5 to Diamond 5
				    </div> -->
				    <div class="quote-img">
							<img src="/wp-content/themes/leagueboost/assets/img/testim1.png" width="500px">
				    </div>
				  </div>
				</div>
				</section>
				 <section id="fBoosts" class="fBoosts">
					 <div class="switch-button"><span class="active"></span>
  				 		<button class="switch-button-case left active-case">SOLO</button>
  						<button class="switch-button-case right">DUO</button>
						</div>
						<span class="boost-mode">You are viewing our Solo Boost options. On this mode, the booster will log in to your account to complete the boosting order</span>

						<div class="row row-boosts">
							<div class="container-boosts">
								<div class="bNet">
										<div class="image">
										</div>
										<div class="content">
												<div class="content-container">
													<h4>Solo Net Wins</h4>
													<p>We will play the number of positive wins you desire <br> </p>
													<a class="btn-choose" href="/solo-net-wins">Purchase</a>
												</div>
										</div>
								</div>
								<div class="bDivision">
										<div class="image">
										</div>
										<div class="content">
												<div class="content-container">
													<h4>Solo Divisions</h4>
													<p>Choose a Desired League and we will play in your account until we reach it</p>
													<a class="btn-choose" href="/solo-divisions">Purchase</a>
												</div>
										</div>
								</div>
								<div class="bPlacements">
										<div class="image">
										</div>
										<div class="content">
												<div class="content-container">
													<h4>Solo Placements</h4>
													<p>We will play your placement matches ensuring at least 7 out of 10 wins. </p>
													<a class="btn-choose" href="/solo-placements">Purchase</a>
												</div>
										</div>
								</div>
								<div class="bGames-Wins">
										<div class="image">
										</div>
												<div class="content">
													<div class="content-container">
													<h4>Solo Normal Wins</h4>
													<p>We will play the number of positive wins you desire</p>
													<a class="btn-choose" href="/solo-normal-wins">Purchase</a>
												</div>
										</div>
								</div>
						</div>
						<span>All the boosts are available for <strong>Solo/Duo Queue</strong> and <strong>Flex Queue</strong>, you can specify it later in your Dashboard</span>
				</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
