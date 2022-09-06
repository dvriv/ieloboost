<?php
/**
 * The template for Contact page.
 *
 * @package LeagueBoost
 */

get_header(); ?>
	<div class="page-description">
		<div class="wrap">
			<h1>Contact Us</h1>
		</div>
	</div>
	<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<span>Please fill this information to contact us. You can also email us at support@ieloboost.com</span> 
				<?php
				if ( function_exists( 'ninja_forms_display_form' ) ) {
				  ninja_forms_display_form( 1 );
				}
				?>
			</main><!-- #main -->
		</div><!-- #primary -->

<?php
get_footer();
