<?php

add_action( 'wp_ajax_register_customer_action', 'register_customer_action_callback' );
add_action( 'wp_ajax_nopriv_register_customer_action', 'register_customer_action_callback' );

add_action( 'wp_ajax_register_booster_action', 'register_customer_action_callback' );
add_action( 'wp_ajax_nopriv_register_booster_action', 'register_customer_action_callback' );

add_action( 'wp_ajax_login_action', 'login_action_callback' );
add_action( 'wp_ajax_nopriv_login_action', 'login_action_callback' );

add_action( 'wp_ajax_custom_register_action', 'register_customer_action_callback' );
add_action( 'wp_ajax_nopriv_custom_register_action', 'register_customer_action_callback' );

add_action( 'wp_ajax_custom_login_action', 'login_action_callback' );
add_action( 'wp_ajax_nopriv_custom_login_action', 'login_action_callback' );

add_action( 'wp_ajax_forgot_password_action', 'forgot_password_action_callback' );
add_action( 'wp_ajax_nopriv_forgot_password_action', 'forgot_password_action_callback' );

add_action( 'wp_ajax_resend_activation_action', 'resend_activation_action_callback' );
add_action( 'wp_ajax_nopriv_resend_activation_action', 'resend_activation_action_callback' );


function login_action_callback()
{
	extract($_REQUEST);
	$login = wp_signon( array( 'user_login' => $username, 'user_password' => $password, 'remember' => true ), true );
	if( $login->ID ) {
		if(isset($custom_login_register))
		{
			global $wpdb;
			$sql_update = "UPDATE {$wpdb->users} SET user_status = true WHERE ID = '{$userinfo->ID}'";
			$wpdb->query($sql_update);
			if($orderid && $key)
			{
				$sql_update = "UPDATE {$wpdb->post_meta} SET order_identification = '' WHERE post_id = '{$orderid}'";
				$wpdb->query($sql_update);
				if(session_id() == '')
					session_start();
				$_SESSION["key"] = $key;
				$_SESSION["orderid"] = $orderid;
			}
			echo '{"result":"login_success","msg":"Congratulation, Login success! Please wait while page reloads...",  "redirectto":"'.admin_url().'"}';
			die(0);
		}
		$userinfo = get_user_by('id', $login->ID);
		$user_status = $userinfo->user_status;
		if($user_status){
			echo '{"result":"login_success","msg":"Congratulations, Login success! Please wait while page reloads...",  "redirectto":"'.admin_url().'"}';
			die(0);
		}else{
			if(is_array($login->roles) && in_array('contributor',$login->roles)){
				echo '{"result":"login_verify_error","msg":"Account not active yet!...<br><a href=\''.home_url('contact').'\' class=\'resend-activation\'>Contact Support</a>"}';
			}else{
				$resend_activation = "<form style='display:none;' method='post' id='resend-activation' name='resend-activation'><input type='hidden' name='user_id' value='".$login->ID."'/></form>";
				echo '{"result":"login_verify_error","msg":"Account not verified...<br><a href=\'javascript:void(0);\' class=\'resend-activation\'>Resend Activation Code</a>","form":"'.$resend_activation.'"}';
			}
			wp_clear_auth_cookie();
			die(0);
		}
	}else {
		echo '{"result":"login_error","msg":"'.strip_tags($login->get_error_message()).'"}';
		die(0);
	}
die(0);
}

function register_customer_action_callback()
{
	//if(!get_option('users_can_register')){ echo '{"result":"error","msg":"Sorry, Registration closed. Contact administrator for new user"}';exit;}
	extract($_REQUEST);
	if ( username_exists( $username )){
			echo '{"result":"register_username_error","msg":"Sorry, The username you entered is already taken."}';
			exit;
	}
	if ( email_exists($email_address) ){
			echo '{"result":"register_email_error","msg":"Sorry, The email you entered is already used."}';
			exit;
	}
	else{
		if($register_for == 'booster')
			$role = 'contributor';
		elseif($register_for == 'customer')
			$role = 'subscriber';
		else
			$role = get_option( 'default_role' );

		$userdata = array(
			'user_pass' => esc_attr( $password1),
			'user_login' => esc_attr( $username ),
			'user_email' => esc_attr( $email_address ),
			'role' => $role
		);
		$new_user = wp_insert_user( $userdata );

		if( !is_wp_error($new_user) ) {
			if($register_for == 'booster')
			{
				update_user_meta($new_user, 'lol_account_name', $lol_account_name);
			}

			$userinfo = get_user_by('id', $new_user);

			if(isset($custom_login_register))
			{
				global $wpdb;
				$sql_update = "UPDATE {$wpdb->users} SET user_status = true WHERE ID = '{$userinfo->ID}'";
				$wpdb->query($sql_update);
				if($orderid && $key)
				{
					$sql_update = "UPDATE {$wpdb->post_meta} SET order_identification = '' WHERE post_id = '{$orderid}'";
					$wpdb->query($sql_update);
					if(session_id() == '')
						session_start();
					$_SESSION["key"] = $key;
					$_SESSION["orderid"] = $orderid;
				}
				wp_clear_auth_cookie();
				wp_set_current_user ( $userinfo->ID );
				wp_set_auth_cookie  ( $userinfo->ID );
    			do_action( 'wp_login', $userinfo->user_login );

				echo '{"result":"login_success","msg":"Redirecting to dashboard...",  "redirectto":"'.admin_url().'"}';
				die(0);
			}
			$generatedKey = sha1(mt_rand(10000,99999).time().$email_addr);
			global $wpdb;
			$sql_update = "UPDATE {$wpdb->users} SET user_activation_key = '$generatedKey' WHERE ID = '$new_user'";
			$wpdb->query($sql_update);

			wp_new_user_notification($new_user, $password1);

			echo '{"result":"success_activation_required","msg":"Please check your mail to activate your account! It may be in your SPAM Folder.","modal":"activationRequiredModal"}';
			die(0);
		}
		else{
			echo '{"result":"register_error","msg":"Sorry, There was an error during sign Up. Please try again!"}';
			die(0);
		}
	}
}

function resend_activation_action_callback()
{
	extract($_REQUEST);
	$userinfo = get_user_by('id', $user_id);

	$generatedKey = $userinfo->user_activation_key;
	if(empty($generatedKey)){
		$generatedKey = sha1(mt_rand(10000,99999).time().$userinfo->user_email);
		global $wpdb;
		$sql_update = "UPDATE {$wpdb->users} SET user_activation_key = '$generatedKey' WHERE ID = '$user_id'";
		$wpdb->query($sql_update);
	}

	$message  = __('Hi ') . $userinfo->display_name . ",\r\n\r\n". "<br><br>";
	if(!empty($generatedKey)){
		$activation_link = add_query_arg( array( 'key' => $generatedKey, 'verify' => $user_id ), home_url());
		$message .= sprintf( __('Activate your account, simply by clicking the verify button: <br><br> <a href="%1s" style="color:#ffffff;font-size:20px;text-decoration:none;padding:5px;background-color:#FF9800;display:inline-block;">Verify Now</a>'), $activation_link ) . "<br><br>";
		$message .= 'If button doesn\'t work, simply copy this link below and open in your browser to verify: <br>'.$activation_link . "<br><br>";
	}
	$message .= sprintf( __('If you experience any problem, please contact us at %s.'), get_option('admin_email') ) . "\r\n\r\n"."<br>";
	$message .= get_option('blogname');
	$headers = array('Content-Type: text/html; charset=UTF-8');
	if(wp_mail($userinfo->user_email, sprintf( __('Verify your Account - %s'), get_option('blogname') ), $message, $headers)){
		echo '{"result":"success_activation_sent","msg":"Please check your mail to activate your account! It may be in your SPAM Folder."}';
		exit;
	}
die(0);
}

function forgot_password_action_callback()
{
	extract($_REQUEST);
	$userinfo = get_user_by('email', $lost_email_address);
	if(!empty($userinfo)){
		$generatedKey = $userinfo->user_activation_key;
		if(empty($generatedKey)){
			$generatedKey = sha1(mt_rand(10000,99999).time().$userinfo->user_email);
			global $wpdb;
			$sql_update = "UPDATE {$wpdb->users} SET user_activation_key = '$generatedKey' WHERE ID = '{$userinfo->ID}'";
			$wpdb->query($sql_update);
		}

		$message  = 'Hi ' . $userinfo->display_name.",<br><br>";
		$message  .= 'A password reset link is generated for your account!' . "<br><br>";
		if(!empty($generatedKey)){
			$activation_link = add_query_arg( array( 'key' => $generatedKey, 'verify' => $userinfo->ID, 'reset' =>true ), home_url());
			$message .= sprintf( __('Reset your new passwords, by simply clicking the link below. You\'ll be temporarily Logged In and asked to change the password from profile page. <br> <a href="%1s">%2s</a>'), $activation_link, $activation_link ) . "<br><br>";
		}
		$message .= sprintf( __('If you experience any problem, please contact us at %s.'), get_option('admin_email') ) . "\r\n\r\n"."<br>";
		$message .= get_option('blogname');
		$headers = array('Content-Type: text/html; charset=UTF-8');
		if(wp_mail($userinfo->user_email, sprintf( __('Reset your Password - %s'), get_option('blogname') ), $message, $headers)){
			echo '{"result":"success_password_sent","msg":"Please check your mail to reset your password! It may be in your SPAM Folder."}';
			die(0);
		}else{
			echo '{"result":"error_password_sent","msg":"Processing Error! Mail not sent at that address. Please Try again!"}';
			die(0);
		}
	}else{
		echo '{"result":"error_password_sent","msg":"No User found registered with that email. You can a new user with that email!"}';
		die(0);
	}
die(0);
}
