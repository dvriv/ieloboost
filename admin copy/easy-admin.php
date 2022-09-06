<?php

if(is_admin()){
	require get_template_directory() . '/admin/admin-functions.php';
}

/**
 * Login changes
 */
add_action('login_head', 'leagueboostEasyLoginHead');
function leagueboostEasyLoginHead() {
	echo '<style>';
	include_once dirname(__FILE__) . '/easy-admin-login.css';
	echo '</style>';
}

add_filter('login_headerurl', 'leagueboostEasyLoginUrl');
function leagueboostEasyLoginUrl($url) {
	return home_url();
}
add_filter('login_headertitle', 'leagueboostEasyLoginTitle');
function leagueboostEasyLoginTitle($title) {
	return get_option('blogname');
}

/**
 * Login redirect
 */
add_filter('login_redirect', 'leagueboostEasyAdminRedirect', 10, 3);
function leagueboostEasyAdminRedirect($redirectTo, $request, $user) {
	if ( isset( $user->roles ) && is_array( $user->roles ) && ( in_array( 'subscriber', $user->roles ) ) )
	{
		$redirectTo = admin_url('admin.php?page=my-dashboard');
	}
	return $redirectTo;
}

/**
 * Admin Branding
 */

global $current_user;
$user = wp_get_current_user();
if( isset( $user->roles ) && is_array( $user->roles ) && ( in_array('subscriber', $user->roles) ) ) {
	// hide from frontend
	show_admin_bar( false );

	// admin
	if (is_admin()) {
		/**
		 * Hide admin bar from admin and frontend
		 */
		// hide from backend
		function leagueboostEasyAdminDisableAdminBar() {
			echo '<style>#wpadminbar {display:none;} html.wp-toolbar { padding-top: 0px !important; }</style>';
		}
		add_filter('admin_head','leagueboostEasyAdminDisableAdminBar');

		/**
		 * Dashboard redirect
		 */
		if ($pagenow == 'index.php') {
			if (current_user_can('subscriber')) {
				wp_redirect( admin_url('admin.php?page=my-dashboard') );
			}
			exit();
		}

		/**
		 * Easy admin header
		 */
		 add_action('in_admin_header', 'leagueboostEasyAdminHeader',2);
		 function leagueboostEasyAdminHeader() {
		 	include_once dirname(__FILE__) . '/easy-admin-header.php';
		 }

		 /**
		  * Easy admin head
		  */
		 add_action('admin_head', 'leagueboostEasyAdminHead');
		 function leagueboostEasyAdminHead() {
		 	echo '<style>';
		 	include_once dirname(__FILE__) . '/easy-admin.css';
		 	echo '</style>';
		 }
		 /**
 		 * Easy admin Enqueue Scripts
 		 */
		add_action( 'admin_enqueue_scripts', 'leagueboostLoadWPAdminScripts' );
		function leagueboostLoadWPAdminScripts() {
			wp_enqueue_script('post');
			wp_enqueue_style( 'admin-css-scripts', get_template_directory_uri() . '/admin/css-styles.css');
			wp_enqueue_script( 'admin-js-scripts', get_template_directory_uri() . '/admin/js-scripts.js', array('jquery'), '', true );
			wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,300', false );
			wp_enqueue_script ('jstz', get_template_directory_uri() . '/assets/js/jstz.min.js', false);
		}

		/**
		 * Easy admin Footer
		 */
		add_action('admin_footer', 'leagueboostEasyAdminFooter');
		function leagueboostEasyAdminFooter() {
			echo '<script type="text/javascript">';
			include_once dirname(__FILE__) . '/easy-admin.js';
			echo '</script>';
		}

	}

}
