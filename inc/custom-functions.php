<?php
// user account verification
add_action( 'admin_init', 'get_order_verification' );

add_action( 'init', 'get_user_verification' );
add_action( 'admin_init', 'get_user_verification' );

add_action('init', 'change_default_role_name');
add_action('admin_init', 'change_default_role_name');

function change_default_role_name() {
    global $wp_roles;
    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();

    $wp_roles->roles['contributor']['name'] = 'Booster';
    $wp_roles->role_names['contributor'] = 'Booster';

    $wp_roles->roles['subscriber']['name'] = 'Customer';
    $wp_roles->role_names['subscriber'] = 'Customer';
}

function get_user_verification() {
	if(session_id() == '') {
		session_start();
	}
    //verify new user
	if(isset($_GET) && isset($_GET['verify']) && isset($_GET['key'])){
		$userinfo = get_user_by('id', $_GET['verify']);

        if ( !is_wp_error( $userinfo ) )
        {
            wp_clear_auth_cookie();
            wp_set_current_user ( $userinfo->ID );
            wp_set_auth_cookie  ( $userinfo->ID );
            do_action( 'wp_login', $userinfo->user_login );
    		$user_activation_code = $userinfo->user_activation_key;
    		$status = $userinfo->user_status;

    		if($user_activation_code == $_GET['key']){
    			if($status != true){
    				global $wpdb;
    				$sql_update = "UPDATE {$wpdb->users} SET user_status = true WHERE ID = '{$userinfo->ID}'";
    				$wpdb->query($sql_update);
        			$sql_update = "UPDATE {$wpdb->users} SET user_activation_key = '' WHERE ID = '{$userinfo->ID}'";
        			$wpdb->query($sql_update);
    			}
                if(isset($_GET['reset']) && $_GET['reset'] == true)
                {
                    $_SESSION['resetPass'] = true;
                }else{
                    $_SESSION['activated'] = true;
                }
            }
        }
	}
	else if(is_user_logged_in()){
		global $current_user;
		if(!$current_user->user_status && !current_user_can('administrator'))
        {
			wp_logout();
			wp_clear_auth_cookie();
		}
	}
}
function get_order_verification()
{
    //verify orderid
    if( (!defined('DOING_AJAX') || !DOING_AJAX) && isset($_SESSION) && isset($_SESSION['orderid']) && isset($_SESSION['key'])){
        $order_identify = get_post_meta($_SESSION['orderid'], 'order_identification', true);
        if($order_identify == $_SESSION['key']){
            update_post_meta($_SESSION['orderid'], 'order_identification', '');
            wp_update_post( array('ID' => $_SESSION['orderid'], 'post_author' => get_current_user_id()) );
            update_user_meta(get_current_user_id(), 'eloboost_new_order_alert', $_SESSION['orderid']);
        }
        unset($_SESSION['orderid']);
        unset($_SESSION['key']);
    }
}
//register custom postype "eloboost-order" and taxonomy "eloboost-type"
add_action('init', 'register_my_custom_posttypes');
function register_my_custom_posttypes() {
    //post type orders
	register_post_type('eloboost-orders', array(
        'labels' => array(
            'name' => 'EloBoost Orders',
            'singular_name' => 'EloBoost Orders',
            'add_new' => 'Add new Order',
            'edit_item' => 'Edit Order',
            'new_item' => 'New Order',
            'view_item' => 'View Orders',
            'search_items' => 'Search Orders',
            'not_found' => 'No Order found',
            'not_found_in_trash' => 'No Order found in Trash',
            'menu_position' => 5
        ),
        'public'        => true,
		'hierarchical'  => true,
        'supports'      => array( 'title', 'author' ),
        'show_ui'       => true,
        'show_in_menu'  => true,
		'menu_icon'	    => 'dashicons-cart',
    ));

	// Add new taxonomy for Type
	$labels = array(
		'name'              => _x( 'Boosting Type', 'taxonomy general name' ),
		'singular_name'     => _x( 'Boosting Type', 'taxonomy singular name' ),
		'search_items'      => __( 'Search types' ),
		'all_items'         => __( 'All types' ),
		'parent_item'       => __( 'Parent type' ),
		'parent_item_colon' => __( 'Parent Type:' ),
		'edit_item'         => __( 'Edit Type' ),
		'update_item'       => __( 'Update Type' ),
		'add_new_item'      => __( 'Add New Type' ),
		'new_item_name'     => __( 'New Type Name' ),
		'menu_name'         => __( 'Boosting Type' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'eloboost-type' ),
	);

	register_taxonomy( 'eloboost-type', array( 'eloboost-orders' ), $args );

}

// Get Custom Login/Register Form
function get_custom_login_register_form()
{
    ob_start();
    ?>
   <div class="row">
     <div class="medium-6 large-5 columns">
     <form method="post" name="custom_login_form" id="custom_login_form" action="">
         <input type="hidden" name="custom_login_register" value="true">
         <?php if(isset($_GET))
         {
             foreach($_GET as $key => $val) {
                 echo "<input type='hidden' name='$key' value='$val'>";
              }
         }?>
       <fieldset class="fieldset">
             <legend>Login to your Account</legend>
             <div class="row">
                 <div class="column small-12">
                     <fieldset>
                         <label for="c_username">Username</label>
                         <input required type="text" name="c_username"/>
                     </fieldset>
                     <fieldset>
                         <label for="c_password">Password</label>
                         <input required type="password" name="c_password"/>
                     </fieldset>
                 </div>
             </div>
             <button class="button float-center" type="submit" value="c_Login">Login</button>&nbsp;&nbsp;<span class="status_loader"></span>
         </fieldset>
     </form>
     </div>

     <div class="medium-6 large-7 columns">
     <form method="post" name="custom_register_form" id="custom_register_form" action="">
         <input type="hidden" name="custom_login_register" value="true">
         <?php if(isset($_GET))
         {
             foreach($_GET as $key => $val) {
                 echo "<input type='hidden' name='$key' value='$val'>";
              }
         }?>
       <fieldset class="fieldset">
         <legend>Register your Account</legend>
         <div class="row">
             <div class="column small-12 medium-6">
                 <fieldset>
                     <label for="c_r_username">Username</label>
                     <input required type="text" name="c_username"/>
                 </fieldset>
                 <fieldset>
                     <label for="c_email_address">Email Address</label>
                     <input required type="email" name="c_email_address"/>
                 </fieldset>
             </div>
             <div class="column small-12 medium-6">
                 <fieldset>
                     <label for="custom_password1">Password</label>
                     <input type="password" id="custom_password1" required name="custom_password1"/>
                 </fieldset>
                 <fieldset>
                     <label for="custom_password2">Confirm Password</label>
                     <input type="password" id="custom_password2" required name="custom_password2"/>
                 </fieldset>
             </div>
         </div>
         <button class="button float-center" type="submit" value="c_Register">Register</button>&nbsp;&nbsp;<span class="status_loader"></span>
       </fieldset>
     </form>

 	<script type="text/javascript">

     var custom_password1 = document.getElementById("custom_password1")
       , custom_password2 = document.getElementById("custom_password2")

 	  function validateCustomPassword(){
          console.log(custom_password1.value);
              console.log(custom_password2.value);
 	      if(custom_password1.value != custom_password2.value) {
 	        custom_password2.setCustomValidity("Passwords Don't Match");
 	      } else {
 	        custom_password2.setCustomValidity('');
 	      }
 	  }
 	  custom_password1.onchange = validateCustomPassword;
 	  custom_password2.onkeyup = validateCustomPassword;
 	</script>
     </div>
   </div>
   <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

/**
* Unranked: 0
* Bronze: 1
* Silver:2
* Gold:3
* platinum:4
* Diamond:5
* master:6

* Division V: 1
* Division IV: 2
* Division III: 3
* Division II: 4
* Division I: 5
**/

$resolveLeagues = array
(
    'Unranked',
    'Bronze',
    'Silver',
    'Gold',
    'Platinum',
    'Diamond',
    'Master'
);
$resolveDivisions = array
(
    '0',
    'V',
    'IV',
    'III',
    'II',
    'I'
);
$resolveType = array
(
    '',
    'Solo',
    'Group',
    'Coaching'
);
