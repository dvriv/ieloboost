<?php
/**
 * Template Name: Boosting Purchase
 *
 * The template for handling Paypal Payment.
 *
 * @package LeagueBoost
 */
ob_start();
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
            <div class="row">
                <div class="large-12 columns">
                <?php
                    if(isset($_POST['proceed_payment']))
                    {
                       $returnURL = RETURN_URL;
                       $cancelURL = $_POST['CANCEL_URL'] ? $_POST['CANCEL_URL'] : CANCEL_URL;
                       $_POST["L_PAYMENTREQUEST_0_AMT0"] = $_POST["PAYMENTREQUEST_0_AMT"] = $_POST["PAYMENTREQUEST_0_ITEMAMT"];
                       $_POST["PAYMENTREQUEST_0_NOTIFYURL"] = get_permalink();
                       $_POST["BRANDNAME"] = get_option('blogname');

                       //$_POST["LOGOIMG"] = get_template_directory_uri().'/assets/img/logo.png';
                       $_POST["LOGOIMG"] = "http://placehold.it/190x60";
                       $_POST["NOSHIPPING"] = 1;

                       $resArray = CallShortcutExpressCheckout ($_POST, $returnURL, $cancelURL);
                       $_SESSION = $_POST;

                       $ackresArray = strtoupper($resArray["ACK"]);
                       if($ackresArray=="SUCCESS" || $ackresArray=="SUCCESSWITHWARNING")  //if SetExpressCheckout API call is successful
                       {
						   $_SESSION["TOKEN"] = $resArray["TOKEN"];
                           echo 'Redirecting to Paypal...';
                    		RedirectToPayPal ( $resArray["TOKEN"] );
                       }
                       else
                       {
                       	//Display a user friendly Error on the page using any of the following error information returned by PayPal
                       	$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
                       	$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
                       	$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
                       	$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

                       	echo "SetExpressCheckout API call failed. ";
                       	echo "Detailed Error Message: " . $ErrorLongMsg;
                       	echo "Short Error Message: " . $ErrorShortMsg;
                       	echo "Error Code: " . $ErrorCode;
                       	echo "Error Severity Code: " . $ErrorSeverityCode;
                       }
                    }
                   elseif( isset($_GET['PayerID']) && isset($_SESSION) && ($_SESSION['TOKEN'] == $_GET['token']) )
                   {
					   //get payment details
 	  					$detailsArray = CallExpressCheckoutDetails($_SESSION["TOKEN"]);
						$ackdetailsArray = strtoupper($detailsArray["ACK"]);
						if( $ackdetailsArray == "SUCCESS" || $ackdetailsArray == "SUCESSWITHWARNING")
						{
							$checkoutArray = CallConfirmPayment ( $_SESSION['PAYMENTREQUEST_0_ITEMAMT'] );
							$ackcheckoutArray = strtoupper($checkoutArray["ACK"]);
							if( $ackcheckoutArray == "SUCCESS" || $ackcheckoutArray == "SUCCESSWITHWARNING" )
							{
		 					   	// Create orders
		 						$my_post = array(
		 						  'post_title'    => wp_strip_all_tags( $_SESSION['L_PAYMENTREQUEST_0_NAME0'] ),
		 						  'post_status'   => 'publish',
		 						  'post_author'   => get_current_user_id(),
		 						  'post_type'	  => 'eloboost-orders'
		 						);
		 						$post_id = wp_insert_post( $my_post );
		 						if(!is_wp_error($post_id)){
			 					    if($_SESSION['type'] == '1') $boosting_type = 'solo';
									elseif($_SESSION['type'] == '2') $boosting_type = 'group';
									else $boosting_type = $_SESSION['type'];

									wp_set_object_terms($post_id, array( $boosting_type.'-'.$_SESSION['action'] ), 'eloboost-type');
									update_post_meta($post_id, 'order_name', $_SESSION['L_PAYMENTREQUEST_0_NAME0']);
									update_post_meta($post_id, 'order_price', $_SESSION['PAYMENTREQUEST_0_ITEMAMT']);
									update_post_meta($post_id, 'boosting_type', $boosting_type);
									update_post_meta($post_id, 'boosting_action', $_SESSION['action']);

									global $resolveLeagues, $resolveDivisions;
									$boost_name = '';

									if($_SESSION['action'] == 'division')
									{
										update_post_meta($post_id, 'order_start_league', $_SESSION['from_league']);
										update_post_meta($post_id, 'order_start_division', $_SESSION['from_division']);
										update_post_meta($post_id, 'order_start_league_points', $_SESSION['league_points']);
										update_post_meta($post_id, 'order_desired_league', $_SESSION['to_league']);
										update_post_meta($post_id, 'order_desired_division', $_SESSION['to_division']);
										if($boosting_type == 'solo')
											$boost_name = 'Solo Division Boost from ';
										else
											$boost_name = 'Group Division Boost from ';
										$boost_name .= $resolveLeagues[$_SESSION['from_league']]. ' '.$resolveDivisions[$_SESSION['from_division']].' to '.$resolveLeagues[$_SESSION['to_league']]. ' '.$resolveDivisions[$_SESSION['to_division']];

									}elseif($_SESSION['action'] == 'net-wins')
									{
										update_post_meta($post_id, 'order_start_league', $_SESSION['from_league']);
										update_post_meta($post_id, 'order_start_division', $_SESSION['from_division']);
										update_post_meta($post_id, 'order_net_wins', $_SESSION['net-wins_sliderValue']);
										if($boosting_type == 'solo')
											$boost_name = 'Solo Boost from ';
										else
											$boost_name = 'Group Boost from ';
										$boost_name .= $resolveLeagues[$_SESSION['from_league']]. ' '.$resolveDivisions[$_SESSION['from_division']].' for '.$_SESSION['net-wins_sliderValue'].' Net Wins';
									}elseif($_SESSION['action'] == 'general-wins')
									{
										update_post_meta($post_id, 'order_start_league', $_SESSION['from_league']);
										update_post_meta($post_id, 'order_start_division', $_SESSION['from_division']);
										update_post_meta($post_id, 'order_general_wins', $_SESSION['general-wins_sliderValue']);
										if($boosting_type == 'solo')
											$boost_name = 'Solo Boost from ';
										else
											$boost_name = 'Group Boost from ';
										$boost_name .= $resolveLeagues[$_SESSION['from_league']]. ' '.$resolveDivisions[$_SESSION['from_division']].' for '.$_SESSION['general-wins_sliderValue'].' Normal Wins';
									}elseif($_SESSION['action'] == 'unranked')
									{
										update_post_meta($post_id, 'order_start_league', $_SESSION['from_league']);
										update_post_meta($post_id, 'order_unranked_games', $_SESSION['unranked_sliderValue']);
										if($boosting_type == 'solo')
											$boost_name = 'Solo Boost from ';
										else
											$boost_name = 'Group Boost from ';
										$boost_name .= $resolveLeagues[$_SESSION['from_league']].' for '.$_SESSION['unranked_sliderValue'].' Unranked Games';
									}elseif($_SESSION['action'] == 'coaching' && $_SESSION['type'] == 'hourly')
									{
										update_post_meta($post_id, 'order_coaching_hours', $_SESSION['hourly-coaching_sliderValue']);
										$boost_name = 'Hourly Coaching';
									}elseif($_SESSION['action'] == 'coaching' && $_SESSION['type'] == 'games')
									{
										update_post_meta($post_id, 'order_coaching_wins', $_SESSION['games-coaching_sliderValue']);
										$boost_name = 'Games Coaching';
									}
		 						}
								//clear session
								session_unset();
						  		?>

		                       <h1 style="text-align: center">
		                           <?php the_title();?>
		                       </h1>
							   <?php
							  if(!is_user_logged_in())
							  {
								  $generatedKey = sha1(mt_rand(10000,99999).time().$detailsArray["EMAIL"]);
								  $registrationLink = add_query_arg( array( 'key' => $generatedKey, 'orderid' => $post_id, 'reset' =>true ), home_url());
								  update_post_meta($post_id, 'order_identification', $generatedKey);
			  						$_SESSION["key"] = $generatedKey;
			  						$_SESSION["orderid"] = $post_id;

							  		$message  = "
										<html>
											<head>
												<title>New Order Registration</title>
											</head>
											<body>
													<h1 style=\"margin:10px 0;\">Thank you for purchasing our boosting services.</h1>";
									if($boost_name){
										$message .= "<p>
												Your order details: <br>
												$boost_name<br>";
									}
									$message .= "<br>
									
												Please access to your dashboard to start the order. <br>
												<a href=\"http://ieloboost.com/wp-admin/\">GO TO DASHBOARD</a> <br> <br>
												If you did not register or sign in your account after the payment, please use this link instead: <br>
												<a href=\"$registrationLink\">REGISTER/SIGN IN</a> <br> <br>

												If you experience any problem, please just reply this email or contact us at support@ieloboost.com.
												</p>
											</body>
										</html>";

							  		$headers = array('Content-Type: text/html; charset=UTF-8');
							  		wp_mail($detailsArray["EMAIL"], sprintf( __('New Order Registered - %s'), get_option('blogname') ), $message, $headers);?>
			 	                   <div class="row">
			 	                       <div class="small-12 columns success_message">
			 							   <?php if(!is_wp_error($post_id)){ ?>
			 								   <h4>Your payment was completed. Thank you for using our services.</h4>
			 								   <div class="desc">
			 									   <p>Now you just need to either login or register to access the Dashboard. Here, you can fill the required in-game information and start the boost.</p>
												   <?php echo get_custom_login_register_form();?>
			 								   </div>
			 							   <?php } else{ ?>
			 								   <h4>Payment was recorded but our Server met with an error!</h4>
			 								   <div class="desc">
			 									   <p>
			 									   Please <strong><a href="<?php echo home_url('contact');?>">contact</a></strong> our admin and inform about the issue.
			 									   Sorry about the inconvenience caused.
			 								   		</p>
			 									   <a href="<?php echo admin_url();?>" class="button float-center">Go to Dashboard</a>
			 								   </div>
			 							   <?php }?>

			 	                       </div>
			 					   </div>
								<?php
							  }else{
								  update_user_meta(get_current_user_id(), 'eloboost_new_order_alert', $post_id);
							   ?>
			                   <div class="row">
			                       <div class="small-12 columns success_message">
									   <?php if(!is_wp_error($post_id)){ ?>
										   <h4>Payment Success</h4>
										   <div class="desc">
											   <p>Thank you for purchasing our boosting services.<br>
											   Please go to your <strong><a href="<?php echo admin_url();?>">dashboard</a></strong> to fill your in-game information and start the boost.</p>
											   <a href="<?php echo admin_url();?>" class="button float-center">Go to Dashboard</a>
										   </div>
									   <?php } else{ ?>
										   <h4>Payment was recorded but our Server met with an error!</h4>
										   <div class="desc">
											   <p>
											   Please <strong><a href="<?php echo home_url('contact');?>">contact</a></strong> our admin and inform about the issue with your paypal email used for payment. <br>
											   Sorry about the inconvenience caused.
										   		</p>
											   <a href="<?php echo admin_url();?>" class="button float-center">Go to Dashboard</a>
										   </div>
									   <?php }?>
			                       </div>
							   </div>
		                      <?php
						   	  }
						  	}else{
								//Display a user friendly Error on the page using any of the following error information returned by PayPal

						  		$ErrorCode = urldecode($checkoutArray["L_ERRORCODE0"]);
						  		$ErrorShortMsg = urldecode($checkoutArray["L_SHORTMESSAGE0"]);
						  		$ErrorLongMsg = urldecode($checkoutArray["L_LONGMESSAGE0"]);
						  		$ErrorSeverityCode = urldecode($checkoutArray["L_SEVERITYCODE0"]);

						  		if($ErrorCode == 10486)  //Transaction could not be completed error because of Funding failure. Should redirect user to PayPal to manage their funds.
						  		{
						  			?>
						  			<!--<div class="hero-unit">
						      			 Display the Transaction Details
						      			<h4> There is a Funding Failure in your account. You can modify your funding sources to fix it and make purchase later. </h4>
						      			Payment Status:-->
						      			<?php  //echo($resArrayDoExpressCheckout["PAYMENTINFO_0_PAYMENTSTATUS"]);
						  						RedirectToPayPal ( $checkoutArray["TOKEN"] );
						      			?>
						      			<!--<h3> Click <a href='https://www.sandbox.paypal.com/'>here </a> to go to PayPal site.</h3> <!--Change to live PayPal site for production-->
						      		<!--</div>-->
						  			<?php
						  		}
						  		else
						  		{
						  			echo "DoExpressCheckout API call failed. ";
						  			echo "Detailed Error Message: " . $ErrorLongMsg;
						  			echo "Short Error Message: " . $ErrorShortMsg;
						  			echo "Error Code: " . $ErrorCode;
						  			echo "Error Severity Code: " . $ErrorSeverityCode;
						  		}
						  	}
					  	}else{
				  			//Display a user friendly Error on the page using any of the following error information returned by PayPal
				  			$ErrorCode = urldecode($detailsArray["L_ERRORCODE0"]);
				  			$ErrorShortMsg = urldecode($detailsArray["L_SHORTMESSAGE0"]);
				  			$ErrorLongMsg = urldecode($detailsArray["L_LONGMESSAGE0"]);
				  			$ErrorSeverityCode = urldecode($detailsArray["L_SEVERITYCODE0"]);

				  			echo "GetExpressCheckoutDetails API call failed. ";
				  			echo "Detailed Error Message: " . $ErrorLongMsg;
				  			echo "Short Error Message: " . $ErrorShortMsg;
				  			echo "Error Code: " . $ErrorCode;
				  			echo "Error Severity Code: " . $ErrorSeverityCode;
			  			}
                    }else{
                        $redirectLink = home_url();

                		if (!headers_sent())
                			header("Location:".$redirectLink);
                		else
                			echo '<script type="text/javascript">window.location = "'.$redirectLink.'";</script>';
                		exit;
                    }
                ?>
                </div>
            </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
?>
