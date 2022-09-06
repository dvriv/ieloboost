<?php
/**
 * LeagueBoost functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package LeagueBoost
 */

if ( ! function_exists( 'leagueboost_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function leagueboost_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on LeagueBoost, use a find and replace
	 * to change 'leagueboost' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'leagueboost', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'leagueboost' ),


	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'leagueboost_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'leagueboost_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function leagueboost_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'leagueboost_content_width', 640 );
}
add_action( 'after_setup_theme', 'leagueboost_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function leagueboost_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'leagueboost' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'leagueboost_widgets_init' );

/**
 * Enqueue scripts and styles.
 */

function leagueboost_scripts() {

	wp_enqueue_style( 'dependent-css-scripts', get_template_directory_uri() . '/assets/css/dependencies.css');
	wp_enqueue_style( 'leagueboost-style', get_stylesheet_uri() );

	wp_enqueue_script( 'leagueboost-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20130115', true );
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,300', false );
	wp_enqueue_script( 'dependent-js-scripts', get_template_directory_uri() . '/assets/js/dependencies.js', array('jquery'), '', true );

	wp_register_script( 'custom-js', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), '1', true );
	wp_enqueue_script( 'jstz', get_template_directory_uri() . '/assets/js/jstz.min.js', array('jquery'), '1', true );

	// Localize the script with new data
	$translation_array = array(
		'templateUri' => get_template_directory_uri(),
		'siteLink' => home_url(),
		'ajaxUrl' => admin_url( 'admin-ajax.php' )
	);
	wp_localize_script( 'custom-js', 'globalObject', $translation_array );
	wp_enqueue_script( 'custom-js' );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'leagueboost_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Customised Admin
 */
require get_template_directory() . '/admin/easy-admin.php';
/**
 * Paypal Config File.
 */
require get_template_directory() . '/inc/paypal-functions.php';
/**
 * LOL API Functions
 */
require get_template_directory() . '/inc/lol-api-functions.php';
/**
 * Ajax Functions
 */
require get_template_directory() . '/inc/ajax-functions.php';
/**
 * Custom PostType & Supporting Functions
 */
require get_template_directory() . '/inc/custom-functions.php';
/**
 * Required: include Advanced Custom Fields Framework.
 */
 require get_template_directory() . '/inc/acf/advanced-custom-fields/acf.php' ;
 require get_template_directory() . '/inc/acf/acf-repeater/acf-repeater.php';
/**
 * ACF exported codes
 */
require get_template_directory() . '/inc/acf-fields.php';

add_action("gform_pre_render", "set_chosen_options");
function set_chosen_options($form){
    ?>

    <script type="text/javascript">
        gform.addFilter('gform_chosen_options','set_chosen_options_js');
        //limit how many options may be chosen in a multi-select to 2
        function set_chosen_options_js(options, element){
                options.disable_search = true;

            return options;
        }
    </script>

    <?php
    //return the form object from the php hook
    return $form;
}

add_filter( 'wp_nav_menu_items', 'insert_custom_nav_menu_items', 10, 2 );
function insert_custom_nav_menu_items($items, $args) {
	if( $args->theme_location == 'primary' )
	{
		if(!is_user_logged_in()){
			$homelink = '<li class="login"><a data-open="loginModal">Login</a></li>';
		}else{
			$homelink = '<li class="my-account"><a href="'.admin_url().'">Dashboard</a></li>';
		}
		// add the home link to the end of the menu
		$items .= $homelink;
	}
	return $items;
}


add_filter( 'wp_mail_from_name', 'custom_wp_mail_from_name' );
function custom_wp_mail_from_name( $name ){
    return get_option('blogname');
}
add_filter( 'wp_mail_from', 'custom_wp_mail_from_email' );
function custom_wp_mail_from_email( $email )
{
    return get_option('admin_email');
}

add_action('admin_init', 'remove_admin_menu_links');

function remove_admin_menu_links(){
	if(!current_user_can('manage_options'))
	{
		remove_menu_page( 'edit.php?post_type=eloboost-orders' );
		remove_menu_page( 'acf-options-options' );
	}

}

add_action( 'wp_ajax_set_timezone', 'ajax_set_timezone_callback' );
add_action( 'wp_ajax_nopriv_set_timezone', 'ajax_set_timezone_callback' );
function ajax_set_timezone_callback(){
    if(session_id() == '')
        session_start();
    if (isset($_POST['timezone']))
    {
        $_SESSION['tz'] = $_POST['timezone'];
    }
    die(0);
}

function posts_filter_ordering($query) {
  if (is_admin()) {
    $post_type = $query->query['post_type'];
    if ( $post_type == 'eloboost-orders') {
      $query->set('orderby', 'date');
      $query->set('order', 'DESC');
    }
  }
}
add_action('pre_get_posts','posts_filter_ordering');

add_action('wp_footer', 'add_googleanalytics');
function add_googleanalytics() {
	?>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-85962012-1', 'auto');
	  ga('send', 'pageview');

	</script>

<?php }

?>
