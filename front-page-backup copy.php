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

get_header(frontpage); ?>

<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
			    $args = array(
							'post_type' => 'page',
							'post__in' => array( 150, 19, 21, 24, 74, 78, 303, 377),
							'orderby' => 'post__in'
			    );
			    $the_query = new WP_Query( $args );
			?>
			<?php if ( have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'no-header' ); ?>

			<?php endwhile; endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
