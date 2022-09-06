<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package LeagueBoost
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'leagueboost' ); ?></a>
	<header id="masthead" class="site-header frontpage-header" role="banner">
			<div class="mobile-bar">
				<h1 class="logo-mobile">
					<a href="/">
						<img src="<?= get_template_directory_uri(); ?>/assets/img/ieloboost.png" alt="iEloboost" />
					</a>
				</h1>
				<a href="#" class="toggle">
					<span class="lines"></span>
				</a>
			</div>
			<nav id="mobile-menu" class="mobile-menu" role='navigation'>
					<ul>
					<li>
						<a href="/">Home</a>
					</li>
					<li>
						<a href="/contact">Contact</a>
					</li>
					<li>
						<a href="/faq">FAQ</a>
					</li>
					<li>
						<a href="/login">Login</a>
					</li>
					<li>
						<a href="/demo" class="mobile-btn-demo">Demo</a>
					</li>
					<li>
						<a href="#fBoosts" class="mobile-btn-boost">Boosting</a>
					</li>
				</ul>
			</nav>

			 <div id="topheader" class="stick">
				<div class="site-branding">
					<h1 class="logo">
					  <a href="/">
					    <img src="<?= get_template_directory_uri(); ?>/assets/img/ieloboost.png" alt="iEloboost" />
					  </a>
					</h1>
				</div><!-- .site-branding -->

				<nav id="site-navigation" class="main-navigation" role="navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
				</nav><!-- #site-navigation -->
			</div>



			   <!-- front page header -->
				<?php
				if ( is_front_page() ) : ?>
				<div class="container">
		      <h2 class="first-title">Kickstart your climb this new season with our boosting services</h2>
					<h2 class="discount-title"><strong>10% OFF</strong> on your Solo and Duo Placement Matches <br> <strong>25% OFF</strong> on Division Boosts up to Gold League</h2>
					<a href="/#fBoosts" class="btn-boost">Get a Boost</a>
		    </div>

				<!-- <div class="container">
					<h2 class="first-title">The 2017 Season is here!</h2>
					<h2>Kickstart your climb in the ranked ladder with our boosting services</h2>
					<a href="/#fBoosts" class="btn-boost">Get a Boost</a>
					<span>Solo and Duo Placement Matches have 10% OFF!!</span>
					<span>And 25% OFF on Solo and Duo Division Boosts up to Gold League!!</span>
				</div> -->


				<?php
				endif;	?>

	</header><!-- #masthead -->

	<div id="content" class="site-content">
