<?php
$admin_id = 1;

add_action( 'wp_ajax_send_message', 'ajax_send_message_callback' );
add_action( 'wp_ajax_receive_message', 'ajax_receive_message_callback' );

add_action( 'wp_ajax_hide_new_order_alert', 'ajax_hide_new_order_alert_callback' );

add_action('admin_menu', 'leagueboost_create_admin_menu');
add_action( 'add_meta_boxes',
	function(){
		add_meta_box( 'order-standing-details', 'Order Standing', 'current_order_standings_meta_box_callback', 'eloboost-orders','normal' );
		add_meta_box( 'order-admin-send-message', 'Admin Chat Box', 'admin_send_message_meta_boxes_callback', 'eloboost-orders','side' );
		add_meta_box( 'order-booster-send-message', 'Booster Chat Box', 'booster_send_message_meta_boxes_callback', 'eloboost-orders','side' );
	}
);
add_action( 'save_post', 'leagueboost_save_meta_box', 9 );

add_filter( 'user_contactmethods','hide_profile_fields',10,1);
add_action( 'show_user_profile', 'add_custom_profile_meta' );
add_action( 'edit_user_profile', 'add_custom_profile_meta' );
add_action( 'personal_options_update', 'save_custom_profile_meta' );
add_action( 'edit_user_profile_update', 'save_custom_profile_meta' );
add_action( 'admin_footer', 'load_admin_pages_scripts' );

function leagueboost_create_admin_menu() {
	if(current_user_can('subscriber')){
		add_menu_page( 'My Dashboard', 'Dashboard', 'read', 'my-dashboard', 'my_account_dashboard', 'dashicons-groups', 58);
	}
	if(current_user_can('manage_options')){
		global $wpdb, $admin_id;
		$messages = $wpdb->get_results($wpdb->prepare("
			SELECT c.user_id as user_id, c.comment_karma as comment_karma, c.comment_parent as comment_parent FROM {$wpdb->comments} c
			WHERE c.comment_parent = %d
			AND c.user_id != %d
			AND c.comment_type = 'message'
			AND c.comment_karma = '0'
			ORDER BY c.comment_date DESC
			", $admin_id, $admin_id));
	    $number = (count($messages)==0) ? '0' : count($messages);
		$my_messages = "Messages <span class='awaiting-mod count-$number'><span class='message-count'>$number</span></span>";
		add_menu_page( 'Message Box', $my_messages, 'manage_options', 'all-messages', 'all_messages_page_callback', 'dashicons-format-chat', 58);
	}
}

function all_messages_page_callback(){?>
	<div class="wrap">
	  	<?php
			screen_icon();
		?>
		<h2><?php echo $GLOBALS['title'] ?></h2>
		<style type="text/css">
			.message-header .message-author{display:inline-block;padding:0;margin:0;margin-right:10px;font-size:16px;text-transform:capitalize;text-decoration:none}
			.message-header .message-author a{text-decoration:none;color:#333}
			.message-date{color:#A9A7A7}
			.message-header{display:inline-block;padding:10px 30px 5px 0}
			div.listed-message .comment{border:1px solid #ddd;border-radius:5px;padding:0 15px;background:#fff;text-transform:capitalize;margin-bottom:15px}
			.wrap h2{font-size:23px;font-weight:400;padding:17px 15px 19px 0;line-height:29px}
			ul.bordered-list{font-size:15px;margin:0;padding:0}
			ul.bordered-list .static-column h4{margin:0;line-height:normal;display:inline-block;vertical-align:middle}
			ul.bordered-list .static-column h4 a{text-decoration:none;color:#666}
			.avatar-image img{border-radius:54%;border:1px solid #8AD7FF;max-width:100%;padding:1px;background:#FFF}
			.avatar-image{float:left;width:100px}
			.avatar-icons{display:inline-block!important;width:260px;margin-right:20px;margin-bottom:40px}
			.static-column{float:left;padding-left:10px;max-width:150px;height:100px;position: relative;top:10px;}
			.message-panel{max-width: 500px;border: 1px solid #E6E6E6;background: #fefefe;padding: 1rem;}
			.message-panel.message_page_message_box{margin-left: 20px;}
			.message-history{border: 1px solid #E6E6E6;margin-bottom: 10px;padding: 5px;}
		</style>
		<?php
		global $wpdb, $admin_id;

		if ($_REQUEST['message_url']) {
			if (!empty($_REQUEST['user_messages'])) {
				$message    = trim($_REQUEST['user_messages']);
				$user_query = get_userdata($admin_id);
				$message    = wp_insert_comment(array(
					'comment_post_ID' => 0,
					'comment_karma' => 0,
					'comment_type' => 'message',
					'comment_parent' => $_REQUEST['message_url'],
					'user_id' => $user_query->ID,
					'comment_author' => $user_query->user_login,
					'comment_author_email' => $user_query->user_email,
					'comment_content' => wp_kses($message, array(
						'strong' => array(),
						'em' => array(),
						'a' => array(
							'href' => array(),
							'title' => array(),
							'target' => array()
						),
						'p' => array(),
						'br' => array()
					))
				));
			}
			?>
		  	<h3> Message to <?php echo get_userdata($_REQUEST['message_url'])->user_nicename;?></h3>
			<div class="message-panel message_page_message_box">
			  <div class="message-history">
				  <ul class="message-list">
				  <?php
					  $messages = get_comments_messages( (int) $_REQUEST['message_url'], $admin_id, 0);
					  if(!empty($messages)){
							$wpdb->query($wpdb->prepare("
								UPDATE {$wpdb->comments} c
								SET c.comment_karma = '1'
								WHERE c.comment_parent = %d
								AND c.user_id = %d
								AND c.comment_type = 'message'
								", $admin_id, $_REQUEST['message_url']
							));
						  foreach($messages as $message) {
							  $GLOBALS['comment']=$message;

								$comment_time = (get_comment_time( 'U' ));
		            $actual_time = current_time('timestamp');

		            $comment_time_old = new DateTime();
		            $comment_time_old->setTimestamp($comment_time);
                    if(isset($_SESSION['tz']))
		                  $comment_time_old->setTimezone(new DateTimeZone($_SESSION['tz']));
		            $comment_time_new = $comment_time_old->format('m/d/Y g:i A');
		            $comment_time_unix = strtotime($comment_time_new);
		            $actual_time_old = new DateTime();
		            $actual_time_old-> setTimestamp($actual_time);
                    if(isset($_SESSION['tz']))
		                  $actual_time_old-> setTimezone(new DateTimeZone($_SESSION['tz']));
		            $actual_time_new = $actual_time_old->format('m/d/Y g:i A');
		            $actual_time_unix = strtotime($actual_time_new);
								?>
							<li>
							  <div class="message-head">
								  <h4><?php echo get_comment_author();?></h4>
									<span title="<?php echo $comment_time_new ?>"><?php echo human_time_diff($comment_time_unix, $actual_time_unix); ?> </span>
							  </div>
							  <div class="message-content"><?php comment_text(); ?></div>
						  </li>
					  <?php }
					  }?>
				  </ul>
			  </div>
			  <div class="message-reply">
				  <div class="message-form">
					<form name="user_message_form" method="post">
						<?php //renderEditor('user_messages'); ?>
						<textarea class="wp-message-area" rows="3" autocomplete="off" cols="27" name="user_messages" id="user_messages"></textarea>
						<input type="hidden" name="user_action" value="send_message" />
						<input type="hidden" name="message_url" value="<?php echo $_POST['message_url'];?>" />
						<button type="submit" class="button btn btn-primary">Send Message</button>&nbsp;&nbsp;<span class="status_loader"></span>
					</form>
				  </div>
			  </div>
			</div>
			<br/><br/>
			<?php
		}?>
		  <h3>All Messages</h3>
		  <?php
		  $sender_arr = array();
		  $messages = $wpdb->get_results($wpdb->prepare("
			  SELECT c.user_id as user_id, c.comment_karma as comment_karma, c.comment_author as comment_author, c.comment_date as comment_date FROM {$wpdb->comments} c
			  WHERE c.comment_parent = %d
			  AND c.user_id != %d
			  AND c.comment_type = 'message'
			  ORDER BY c.comment_date ASC
			  ", $admin_id, $admin_id), ARRAY_A);
		  if(!empty($messages)){
			  foreach($messages as $message_details){
				  $uID = $message_details['user_id'];
				  $sender_arr[$uID]['author'] = $message_details['comment_author'];
				  if(!isset($sender_arr[$uID]['unread']))
				  	$sender_arr[$uID]['unread'] = 0;
				  if($message_details['comment_karma'] == 0){
				  	$sender_arr[$uID]['unread'] += 1;
				  }
				  $sender_arr[$uID]['date'] = $message_details['comment_date'];
			  }
		  }
	        if (!empty($sender_arr)) {
			?>
	  		<form id="users_messages_lists" method="post">
	    	  <ul class="bordered-list">
	      		<?php
	            foreach ($sender_arr as $sender_id => $sender_details) {?>
	      			<li class="clearfix avatar-icons"
						<?php if ($sender_details['unread'] > 0) { ?>style="background:#A5A5A5;"<?php }?>>
					  <a href="javascript:userMessage(<?php echo $sender_id;?>);">
	        			<div class="avatar-image">
	          			<?php
							$avatar_id =  esc_attr( get_the_author_meta( 'avatar', $sender_id ) );
							$avatar = wp_get_attachment_image_src( $avatar_id, 'medium');
			                if (empty($avatar[0])) {?>
					          	<img src="<?php echo get_template_directory_uri();?>/assets/img/avatar.png" class="avatar" width="100px" alt="">
							<?php }else{?>
							      <img src="<?php echo $avatar[0];?>">
							<?php }?>
				        </div>
				        <div class="static-column tencol">
				          <h4><?php echo $sender_details['author'];?></h4>
						  <br/><small><?php echo $sender_details['unread'].' unread';?></small>
						  <br/><small><?php echo $sender_details['date'];?></small>
				        </div>
				      </a>
				    </li>
				<?php
				} ?>
		      </ul>
		    <input type="hidden" name="message_url" value="submit" />
		  </form>
	  	<?php
        } else {
			echo 'No messages received Yet.';
        }?>
	</div><!-- /wrap -->
	<script type="text/javascript">
	function userMessage(obj){
		jQuery('#users_messages_lists').find('input[name=message_url]').val(obj);
		jQuery('#users_messages_lists').submit();
	}
	</script>
	<?php
}

function my_account_dashboard(){
	global $wpdb, $current_user;

	if(current_user_can('subscriber'))
	{
		customer_dashboard();
	}
}

function customer_dashboard(){?>

	<?php
		$cUserId = get_current_user_id();
		$orderInProgress = 0;
		$allOrders = get_posts("post_type=eloboost-orders&posts_per_page=-1&author=$cUserId&fields=ids");
		if(isset($_GET['order'])){
			$post_author = (int) get_post_field('post_author', $_GET['order']);
			if($cUserId == $post_author){
				$orderInProgress = $_GET['order'];
			}else{
				$error = 'Order Id is Invalid or not available!';
			}
		}
		if(!empty($allOrders) && empty($orderInProgress)){
			$orderInProgress = get_user_meta($cUserId, 'order_in_progress', true);
			if(empty($orderInProgress) || !in_array($orderInProgress, $allOrders)){
				for($i=0; $i<count($allOrders); $i++){
					$order_status = get_post_meta($allOrders[$i], 'order_status', true);
					if($order_status != 'Complete')
					{
						$orderInProgress = $allOrders[$i];
						update_user_meta($cUserId, 'order_in_progress', $allOrders[$i]);
						break;
					}
				}
			}
		}
		if(!empty($orderInProgress)){
			$order_status = get_post_meta($orderInProgress, 'order_status', true);
			$boosting_type = get_post_meta($orderInProgress, 'boosting_type', true);
			$boosting_action = get_post_meta($orderInProgress, 'boosting_action', true);
		}
		if(isset($_POST["order_status_change"]))
		{
			extract($_POST);

			$all_set = get_post_meta($orderInProgress, 'all_information_provided', true);
			if(!$all_set)
			{
				update_post_meta($orderInProgress, 'order_status', 'Pending');
				$error = 'Please submit all the required information';
				update_post_meta($orderInProgress, 'order_status_detail', $error);
			}else{
				$order_status_detail_update = "";
				if(empty($order_status) || $order_status == 'Pending'){
					update_post_meta($orderInProgress, 'order_status', 'Processing');
					//$order_status_detail_update = 'We are reviewing your information';
					$processing_started = get_post_meta($orderInProgress, 'processing_started', true);
					if(empty($processing_started))
						update_post_meta($orderInProgress, 'processing_started', time());
					update_post_meta($orderInProgress, 'processing_completed', '');
				}
				elseif($order_status == 'Paused'){
					update_post_meta($orderInProgress, 'order_status', 'Processing');
				}
				elseif($order_status == 'Processing'){
					update_post_meta($orderInProgress, 'order_status', 'Paused');
					$order_status_detail_update = 'Paused! The booster will no play any games until you start it again';
				}
				update_post_meta($orderInProgress, 'order_status_detail', $order_status_detail_update);
				echo '<script>location.reload(true);</script>';
			}
		}

	?>
	<div class="wrap">

	<?php //alert box starts
	$alert_order = get_user_meta($cUserId, 'eloboost_new_order_alert', true);
	if(!empty($alert_order) && $orderInProgress == $alert_order){
		$alert_boosting_type = get_post_meta($alert_order, 'boosting_type', true);
		$alert_boosting_action = get_post_meta($alert_order, 'boosting_action', true);
		if($alert_boosting_type == 'solo' && $alert_boosting_type !== 'division'){
			$alert_message = 'Please remember for the security of your account that you should never log in to your account while the order is in progress. If you really need to use your account, pause the order first and then wait or confirm that your booster has no been playing for at least 1 hour.';
		}
		if($alert_boosting_type == 'solo' && $alert_boosting_action == 'division'){
			$alert_message = 'Please remember for the security of your account that you should never log in to your account while the order is in progress. If you really need to use your account, pause the order first and then wait or confirm that your booster has no been playing for at least 1 hour. Also keep in mind that you can\'t play ranked games or your order will be converted to Net Wins.';
		}
		if($alert_boosting_type == 'group' && $alert_boosting_type !== 'division'){
			$alert_message = 'After you start the order, we will find the perfect booster for you. We recommend to indicate your schedule availability in <i>Notes to Booster</i> or in a message to the admin in the chat so we can assign you a booster with a availability according to your needs.';
		}

		if($alert_boosting_type == 'group' && $alert_boosting_type == 'division'){
			$alert_message = 'After you start the order, we will find the perfect booster for you. We recommend to indicate your schedule availability in Notes to Booster or in a message to the admin in the chat so the assigned booster will have availability according to your needs and can play together without a hitch. Also keep in mind that you can\'t play ranked games or your order will be converted to Net Wins.';
		}
		?>
		<div class="alert callout alert-container" data-closable>
		  <h3>Welcome to your Dashboard. Please fill the required information and start your order!!</h3>
		  <p><?php echo $alert_message;?></p>
		  <button class="close-button" aria-label="Dismiss alert" onClick="javascript:hideNewOrderAlert('<?php echo $cUserId;?>');" type="button" data-close>
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
	<?php } //alert box ends
	?>

	<?php screen_icon();
  ?>
	<h2><?php echo $GLOBALS['title'] ?></h2>
	<?php if(isset($error)) echo '<div class="error"><p>'.$error.'</p></div>'; ?>
	<!-- ======== START PAGE CONTENT =========== -->
	<div id="mainstage">
		<div id="current_order_details" class="clearfix">
			<div class="avatar-image">
			  <?php
				$avatar_id =  esc_attr( get_the_author_meta( 'avatar', $current_user->ID ) );
				$avatar = wp_get_attachment_image_src( $avatar_id, 'medium');
				if( empty($avatar[0]) ) { ?>
			      <img src="<?php echo get_template_directory_uri();?>/assets/img/avatar.png" class="avatar" width="100px" alt="">
			  <?php }else{?>
			      <img src="<?php echo $avatar[0];?>">
			  <?php }?>
			</div>

			<?php if(!empty($orderInProgress)){?>
			<div class="admin-info clearfix">
				<div class="row">
				    <div class="order-id inline">
						<span>Order ID</span>
				      	<div><strong><?php echo str_pad($orderInProgress, 6, 0, STR_PAD_LEFT);?></strong></div>
				    </div>
					<div class="order-status inline">
						<span>Order Status</span>
				      	<div><strong>
							<?php
								 if(empty($order_status)) echo 'Pending';
								 else echo $order_status;
							?>
						</strong></div>
				    </div>
					<div class="server-info inline">
						<span>Server</span>
				      	<div><strong><?php echo get_post_meta($orderInProgress, 'choose_server', true);?></strong></div>
				    </div>
					<?php if($booting_type == 'group'){?>
					<div class="status-info inline">
						<span>Summoner name</span>
				      	<div><strong>
							<?php $summoner_name = get_user_meta($orderInProgress, 'summoner_name', true);
								if($summoner_name)
									echo $summoner_name;
								else echo "N/A";
							?>
						</strong></div>
				    </div>
					<?php }?>
				</div>
				<div class="row clearfix">
					<?php $order_status_detail = get_post_meta($orderInProgress, 'order_status_detail', true);?>
					<?php if(!empty($order_status_detail)){?>
				    <div class="order-status-info inline">
						<span>Status Information:</span>
				      	<div><strong><?php echo $order_status_detail;?></strong></div>
				    </div>
					<?php }?>

					<?php //if($order_status != 'Under-Review'){?>
					<div class="order-status-change inline">
						<form name="order_status_change_form" method="POST">
							<input type="hidden" name="order_status_change" value="true" />
							<button class="button btn-primary" type="submit"><?php if(!empty($order_status) && $order_status == 'Processing') echo 'Pause Order'; else echo 'Start Order';?></button>
						</form>
				    </div>
						<a class="button btn-primary tip-modal-button">Tip Booster</a>
					<?php //}?>
				</div>
			</div>
			<?php }else{?>
			<div class="admin-info clearfix">
				<div class="row">
					<div class="order-status-info inline">
						<p>No active orders available!<p>
					</div>
					<div class="order-status-change inline">
						<a class="button btn-primary" href="<?php echo home_url('#fBoosts');?>">Purchase a Boost</a>
				    </div>
				</div>
			</div>
			<?php }?>

		</div>
		<?php
		if(!empty($orderInProgress)){
			add_meta_box("user_details_fillup_meta_box", "Current Order Details", "user_details_fillup_meta_box_callback", "dashboard_user_details_fillup_left");
		    do_meta_boxes('dashboard_user_details_fillup_left', 'advanced',
				array(
					'order_in_progress' => $orderInProgress,
					'boosting_type' => $boosting_type,
					'boosting_action' => $boosting_action
				)
			);
			if( ($order_status == 'Processing' || $order_status == 'Complete') && $boosting_action != 'coaching')
			{
				add_meta_box("match_history_meta_box", "Matches Played", "match_history_meta_box_callback", "dashboard_match_history_left");
			    do_meta_boxes('dashboard_match_history_left', 'advanced',
					array(
						'order_in_progress' => $orderInProgress,
						'boosting_type' => $boosting_type,
						'boosting_action' => $boosting_action,
						'order_status' => $order_status
					)
				);
			}
		}
		add_meta_box("order_history_meta_box", "All Order History", "order_history_meta_box_callback", "dashboard_order_section_left");
	    do_meta_boxes('dashboard_order_section_left','advanced', $allOrders);
		?>
	  	</div>

	</div><!-- /wrap -->

	<!-- ================ Start Sidebar ================ -->
	<div id="sidebar">
		<?php
		if(!empty($orderInProgress)){
			add_meta_box("current_order_standings_meta_box", "Current Order Standing", "current_order_standings_meta_box_callback", "dashboard_current_order_standings_section_right");
			do_meta_boxes('dashboard_current_order_standings_section_right','advanced', $orderInProgress);
		}

			add_meta_box("send_message_meta_box", "Message Box", "send_message_meta_box_callback", "dashboard_send_message_section_right");
			do_meta_boxes('dashboard_send_message_section_right','advanced', $orderInProgress);
		?>
	</div>
	<script type="text/javascript">
	jQuery(function($){
		$('form').on('submit',function(){
			<?php if(isset($_GET)){
				foreach($_GET as $name => $value){?>
					$(this).append('<input type="hidden" name="<?php echo $name;?>" value="<?php echo $value;?>"/>');
				<?php }
			}?>
		});
	});
	</script>

	<?php
}
function user_details_fillup_meta_box_callback($params){
	$orderInProgress = $params['order_in_progress'];
	$boosting_type = $params['boosting_type'];
	$boosting_action = $params['boosting_action'];?>
	<?php
		if(isset($_POST['user_details_fillup_submit']))
		{
			extract($_POST);
			update_post_meta($orderInProgress, 'account_name', $account_name);
			update_post_meta($orderInProgress, 'summoner_name', $summoner_name);
			update_post_meta($orderInProgress, 'account_password', $account_password);
			update_post_meta($orderInProgress, 'choose_server', $choose_server);
			update_post_meta($orderInProgress, 'prefered_positions', $prefered_positions);
			update_post_meta($orderInProgress, 'selected_champions', $selected_champions);
			update_post_meta($orderInProgress, 'notes_to_booster', $booster_notes);
			if(
				( !isset($_POST['choose_server']) || !empty($_POST['choose_server']) )
				&&
				( !isset($_POST['account_name']) || !empty($_POST['account_name']) )
				&&
				( !isset($_POST['summoner_name']) || !empty($_POST['summoner_name']) )
				&&
				( !isset($_POST['account_password']) || !empty($_POST['account_password']) )
			){
				$information_provided = true;
			}else $information_provided = false;
			update_post_meta($orderInProgress, 'all_information_provided', $information_provided);
		}
		$order_status = get_post_meta($orderInProgress, 'order_status', true);
		if($order_status == 'Paused' || $order_status == 'Processing' || $order_status == 'Complete')
			$disabled = 'disabled="disabled"';
		else
			$disabled = "";
	?>
	<div id="user_details_fillup">
	  <form name="user_details_fillup" action="" method="post">
		  <?php if($boosting_type == 'solo' || $boosting_action == 'coaching'){?>
		  <fieldset>
			  <label for="account_name">Account name</label>
			  <input type="text" name="account_name" <?php echo $disabled;?> value="<?php echo get_post_meta($orderInProgress, 'account_name', true);?>"/>
		  </fieldset>
		  <?php }?>
		  <fieldset>
			  <label for="summoner_name">Summoner name</label>
			  <input type="text" name="summoner_name" <?php echo $disabled;?> value="<?php echo get_post_meta($orderInProgress, 'summoner_name', true);?>"/>
		  </fieldset>
		  <?php if($boosting_type == 'solo'){?>
		  <fieldset>
			  <label for="account_password">Password</label>
			  <input type="text" name="account_password" <?php echo $disabled;?> value="<?php echo get_post_meta($orderInProgress, 'account_password', true);?>"/>
		  </fieldset>
		  <?php }?>
		  <?php if($boosting_action != 'coaching'){?>
		  <fieldset>
			  <label for="choose_server">Server</label>
			  <?php $choose_server = get_post_meta($orderInProgress, 'choose_server', true);?>
			  <select name="choose_server" <?php echo $disabled;?>>
			  	  <option value="EUNE" <?php echo ($choose_server == "EUNE")?'selected="selected"':'';?>>EUNE</option>
				  <option value="EUW" <?php echo ($choose_server == "EUW")?'selected="selected"':'';?>>EUW</option>
				  <option value="LAN" <?php echo ($choose_server == "LAN")?'selected="selected"':'';?>>LAN</option>
				  <option value="LAS" <?php echo ($choose_server == "LAS")?'selected="selected"':'';?>>LAS</option>
				  <option value="NA" <?php echo ($choose_server == "NA")?'selected="selected"':'';?>>NA</option>
				  <option value="OCE" <?php echo ($choose_server == "OCE")?'selected="selected"':'';?>>OCE</option>
			  </select>
		  </fieldset>
		  <?php }?>
		  <fieldset>
			  <label for="booster_notes">Notes to Booster</label>
			  <input type="text" name="booster_notes" <?php echo $disabled;?> value="<?php echo get_post_meta($orderInProgress, 'notes_to_booster', true);?>"/>
		  </fieldset>
		  <fieldset>
			  <label for="prefered_position">Prefered Position</label>
			  <?php $prefered_positions = get_post_meta($orderInProgress, 'prefered_positions', true);?>
			  <input type="checkbox" name="prefered_positions[]" id="radioTop" value="Top" <?php if(!empty($prefered_positions) && in_array('Top', $prefered_positions)) echo 'checked';?> <?php echo $disabled;?>/><label for="radioTop">Top</label>
			  <input type="checkbox" name="prefered_positions[]" id="radioJungle" value="Jungle" <?php if(!empty($prefered_positions) && in_array('Jungle', $prefered_positions)) echo 'checked';?> <?php echo $disabled;?>/><label for="radioJungle">Jungle</label>
			  <input type="checkbox" name="prefered_positions[]" id="radioMid" value="Mid" <?php if(!empty($prefered_positions) && in_array('Mid', $prefered_positions)) echo 'checked';?> <?php echo $disabled;?>/><label for="radioMid">Mid</label>
			  <input type="checkbox" name="prefered_positions[]" id="radioSupport" value="Support" <?php if(!empty($prefered_positions) && in_array('Support', $prefered_positions)) echo 'checked';?> <?php echo $disabled;?>/><label for="radioSupport">Support</label>
			  <input type="checkbox" name="prefered_positions[]" id="radioBot" value="Bot" <?php if(!empty($prefered_positions) && in_array('Bot', $prefered_positions)) echo 'checked';?> <?php echo $disabled;?>/><label for="radioBot">Bot</label>
		  </fieldset>
		  <fieldset>
			  <label for="prefered_position">Prefered Champions</label>
			  <div id="selected_champions">
				  <?php $selected_champions = get_post_meta($orderInProgress, 'selected_champions', true);
					if(!empty($selected_champions))
					{
						$selected_champions_arr = explode(',', $selected_champions);
						foreach($selected_champions_arr as $champion_id)
						{
							echo "<div class='selected_champion_container'> <img data-id='$champion_id' class='champion_images' src='".get_template_directory_uri()."/assets/img/champs42x42/".$champion_id.".png'/><i class='dashicons dashicons-no'></i></div>";
						}
						echo "<input type='hidden' name='selected_champions' value='$selected_champions'>";
					}
				  ?>
			  </div>
			   <?php if(!$disabled){?>
				<button class="button" type="button" data-open="prefered_champions_lists">
				  <span aria-hidden="true"><i class="fi-plus"></i> Add</span>
				</button>
				<div class="reveal" id="prefered_champions_lists" data-reveal data-animation-in="fade-in" >
					<fieldset class="fieldset">
					<legend>Choose Champions</legend>
					<?php for($i=1; $i<500; $i++)
					{
						$filename = get_template_directory().'/assets/img/champs42x42/'.$i.'.png';
						if(file_exists($filename)){?>
							<input id="champion<?php echo $i;?>" class="champion_checkbox" type="checkbox">
								<label for="champion<?php echo $i;?>"><img data-id="<?php echo $i;?>" class="champion_images" src="<?php echo get_template_directory_uri().'/assets/img/champs42x42/'.$i.'.png';?>"/></label>
						<?php }
					}?>
				  </fieldset>
				  <button class="small button" data-close aria-label="Save" onClick="javascript:saveChampions();" type="button">Save</button>
				  <button class="close-button" data-close aria-label="Close modal" type="button">
					<span aria-hidden="true">&times;</span>
				  </button>
			  </div><!-- /prefered_champions_lists popup -->
			  <?php }?>

		  </fieldset>

		  <fieldset>
			  <br>
			   <?php if(!$disabled){?>
			  <input type="hidden" name="user_details_fillup_submit" value="true">
			  <?php }?>
			  <input class="btn btn-primary" type="submit" <?php echo $disabled;?> value="Save">
		  </fieldset>
	  </form>
	</div>
	<?php
}

function updateMatchResults($orderInProgress, $matches_played, $boosting_action, $boosting_type){
	$match_win = $match_loss = 0;
	foreach($matches_played as $match_details){
		if($match_details['wins'] == true) $match_win +=1;
		elseif($match_details['wins'] == false) $match_loss +=1;
	}
	if($boosting_action == 'net-wins'){
		$net_wins = $match_win - $match_loss;
		update_post_meta($orderInProgress, 'order_current_net_wins', $net_wins);
	}elseif($boosting_action == 'general-wins'){
		if($boosting_type == 'group')
			$count_match = count($matches_played);
		else
			$count_match = $match_win;
		update_post_meta($orderInProgress, 'order_current_general_wins', $count_match);
	}elseif($boosting_action == 'unranked'){
		update_post_meta($orderInProgress, 'order_current_unranked_games', $match_win);
	}
}
function checkOrderStatus($orderInProgress, $boosting_action, $boosting_type){
	if($boosting_action == 'division'){
		$order_current_league = get_post_meta($orderInProgress, 'order_current_league', true);
		$order_current_division = get_post_meta($orderInProgress, 'order_current_division', true);
		$order_desired_league = get_post_meta($orderInProgress, 'order_desired_league', true);
		$order_desired_division = get_post_meta($orderInProgress, 'order_desired_division', true);
		if($order_desired_division == $order_current_division && $order_desired_league == $order_current_league){
			$order_complete = true;
		}
	}elseif($boosting_action == 'net-wins'){
		$order_current_net_wins = get_post_meta($orderInProgress, 'order_current_net_wins', true);
		$order_net_wins = get_post_meta($orderInProgress, 'order_net_wins', true);
		if($order_net_wins == $order_current_net_wins){
			$order_complete = true;
		}
	}elseif($boosting_action == 'unranked'){
		$order_current_unranked_games = get_post_meta($orderInProgress, 'order_current_unranked_games', true);
		$order_unranked_games = get_post_meta($orderInProgress, 'order_unranked_games', true);
		if($order_current_unranked_games == $order_unranked_games){
			$order_complete = true;
		}
	}elseif($boosting_action == 'general-wins'){
		$order_current_general_wins = get_post_meta($orderInProgress, 'order_current_general_wins', true);
		$order_general_wins = get_post_meta($orderInProgress, 'order_general_wins', true);
		if($order_current_general_wins == $order_general_wins){
			$order_complete = true;
		}
	}
	if(isset($order_complete) && $order_complete){
		update_post_meta($orderInProgress, 'order_status', 'Complete');
		orderStatusCompleteAction($orderInProgress);
	}
}
function orderStatusCompleteAction($orderInProgress){
	$processing_completed = get_post_meta($orderInProgress, 'processing_completed', true);
	if(empty($processing_completed))
		update_post_meta($post_id, 'processing_completed', time());

	$post_author = (int) get_post_field('post_author', $orderInProgress);
	$authorOrderInProgress = get_user_meta($post_author, 'order_in_progress',true);
	if($authorOrderInProgress == $orderInProgress){
		update_user_meta($post_author, 'order_in_progress', "");
	}
	$user_data = get_userdata($post_author);
	$display_name = $user_data->display_name;
	$user_email = $user_data->user_email;

	$message  = "
<html>
	<head>
		<title>Order Completed</title>
	</head>
	<body>
			<h1 style=\"margin:10px 0;\">Your order #$orderInProgress has been successfully completed.</h1>
			<p>
			Please confirm that your order has been properly completed. <br>
			If there is any problem, complaint or suggestion just reply to this email or contact us at <a href=\"mailto:support@ieloboost.com\">support@ieloboost.com</a>.
			<br>Thank you for choosing <a href=\"http://ieloboost.com\">iEloboost</a> and enjoy playing on your new league!
		</p>
	</body>
</html>";

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

	wp_mail($user_email, sprintf( __('Order Completed - %s'), get_option('blogname') ), $message, $headers);

}
function match_history_meta_box_callback($params){
	$orderInProgress = $params['order_in_progress'];
	$boosting_type = $params['boosting_type'];
	$boosting_action = $params['boosting_action'];
	$order_status = $params['order_status'];

	$booster_assigned = get_post_meta($orderInProgress, 'booster_assigned', true);
	$last_api_run = get_post_meta($orderInProgress, 'last_api_run', true);
	//update_post_meta($orderInProgress, 'matches_played', array());
	if(empty($last_api_run) || ( time() - $last_api_run ) > 180 ) //every 3 minutes
	{
		$summoner_id = get_post_meta($orderInProgress, 'summoner_id', true);
		if(empty($summoner_id))
		{
			if($boosting_type == 'group'){
				$client_summoner_name = get_post_meta($orderInProgress, 'summoner_name', true);
				$response = lolAPISummonerDetails($orderInProgress, $client_summoner_name, 'client_summoner_id');
				if(!empty($response) && isset($response['error'])){
					$api_error = 'Error with Summoner Name: '.$response['message'];
				}
				$summoner_name = get_post_meta($orderInProgress, 'booster_summoner_name', true);
			}else{
				$summoner_name = get_post_meta($orderInProgress, 'summoner_name', true);
			}

			if(!empty($summoner_name))
			{
				$response = lolAPISummonerDetails($orderInProgress, $summoner_name);
				$summoner_id = $response['summoner_id'];
				if(!empty($response) && isset($response['error'])){
					$api_error = $response['message'];
				}elseif(!empty($response) && isset($response['success'])){
					$response = lolAPIMatchDetails($orderInProgress, $summoner_id);
					if(!empty($response) && isset($response['error']))
						$api_error = $response['message'];
					else{
						if($boosting_action == 'division'){
							if($boosting_type == 'group'){
								$client_summoner_id = get_post_meta($orderInProgress, 'client_summoner_id', true);
								if(empty($client_summoner_id)){
									$client_summoner_name = get_post_meta($orderInProgress, 'summoner_name', true);
									$response = lolAPISummonerDetails($orderInProgress, $client_summoner_name, 'client_summoner_id');
									if(!empty($response) && isset($response['error'])){
										$api_error = 'Error with Summoner Name: '.$response['message'];
									}
									else $client_summoner_id = $response['summoner_id'];
								}
								lolAPICheckDivisionRank($orderInProgress, $client_summoner_id);
							}
							else lolAPICheckDivisionRank($orderInProgress, $summoner_id);
						}else{
							if(isset($response['all_matches']) && is_array($response['all_matches'])){
								updateMatchResults($orderInProgress, $response['all_matches'], $boosting_action, $boosting_type);
							}
						}
						checkOrderStatus($orderInProgress, $boosting_action, $boosting_type);
					}
				}
			}else{
				$api_error = "Summoner Name/ID is empty";
			}
		}else{
			$response = lolAPIMatchDetails($orderInProgress, $summoner_id);
			if(!empty($response) && isset($response['error']))
				$api_error = $response['message'];
			else{
				if($boosting_action == 'division'){
					if($boosting_type == 'group'){
						$client_summoner_id = get_post_meta($orderInProgress, 'client_summoner_id', true);
						if(empty($client_summoner_id)){
							$client_summoner_name = get_post_meta($orderInProgress, 'summoner_name', true);
							$response = lolAPISummonerDetails($orderInProgress, $client_summoner_name, 'client_summoner_id');
							if(!empty($response) && isset($response['error'])){
								$api_error = 'Error with Summoner Name: '.$response['message'];
							}
							else $client_summoner_id = $response['summoner_id'];
						}
						lolAPICheckDivisionRank($orderInProgress, $client_summoner_id);
					}
					else lolAPICheckDivisionRank($orderInProgress, $summoner_id);
				}else{
					if(isset($response['all_matches']) && is_array($response['all_matches'])){
						updateMatchResults($orderInProgress, $response['all_matches'], $boosting_action, $boosting_type);
					}
				}
				checkOrderStatus($orderInProgress, $boosting_action, $boosting_type);
			}
		}
	}
	$matches_played = get_post_meta($orderInProgress, 'matches_played', true);
	?>
	<div class="match-history">
		<table class="match-history-table widefat fixed tablesorter">
			<thead>
				<tr>
					<th class="match-champion header">Champion</th>
					<th class="match-result header">Result</th>
					<th class="match-data header" title="Champions Killed/Deaths/Assists">K/D/A</th>
					<th class="match-gold header">Gold</th>
					<th class="match-minions header">Minions</th>
					<th class="match-items header">Items</th>
					<th class="match-spells header">Spells</th>
					<th class="match-booster header">Booster</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(isset($api_error) || empty($matches_played) || !is_array($matches_played)){
					echo '<tr><td colspan="8">';
					if(isset($api_error)){?><div class="api_error"><?php echo $api_error;?></div><?php }
					else echo 'No matches played yet!';
					echo '</td></tr>';
				}
				elseif(!empty($matches_played) && is_array($matches_played)){
					$matchNum=1;
					foreach($matches_played as $match_details){?>
            <?php
            $match_time = ($match_details['create_date']/1000);
            $actual_time = current_time('timestamp');
            $match_time_old = new DateTime();
            $match_time_old->setTimestamp($match_time);
            if(isset($_SESSION['tz']))
                $match_time_old->setTimezone(new DateTimeZone($_SESSION['tz']));
            $match_time_new = $match_time_old->format('m/d/Y g:i A');
            $match_time_unix = strtotime($match_time_new);
            $actual_time_old = new DateTime();
            $actual_time_old-> setTimestamp($actual_time);
            if(isset($_SESSION['tz']))
                $actual_time_old-> setTimezone(new DateTimeZone($_SESSION['tz']));
            $actual_time_new = $actual_time_old->format('m/d/Y g:i A');
            $actual_time_unix = strtotime($actual_time_new);

            ?>
						<tr class="matches_tr match_id_<?php echo $matchNum;?> <?php echo ($match_details['wins'] == true)?'win':'lost';?>">
							<td><img src="<?php echo get_template_directory_uri().'/assets/img/champs60x60/'.$match_details['champion_id'].'.png';?>" alt="champion image" width="60"/></td>
							<td><div class="result"><?php echo ($match_details['wins'] == true)?'Victory':'Defeat';?></div>
							<span title="<?php echo $match_time_new ?>"> <?php echo human_time_diff( $match_time_unix, $actual_time_unix); ?> ago</span>
							</td>
							<td><?php echo ($match_details['k'])?$match_details['k']:'0';
							echo '/';
							echo ($match_details['d'])?$match_details['d']:'0';
							echo '/';
							echo ($match_details['a'])?$match_details['a']:'0';?></td>
							<td><?php echo $match_details['gold_spent'];?></td>
							<td><?php echo $match_details['minions'];?></td>
							<td><?php for($i=0;$i<=6;$i++){
								if(!empty($match_details['items'][$i])){
									echo '<img src="'.get_template_directory_uri().'/assets/img/items30x30/'.$match_details['items'][$i].'.png" width="30" alt="items-'.$i.'"/>';
								}
							}?></td>
							<td>
								<img src="<?php echo get_template_directory_uri().'/assets/img/summonersspell30x30/'.$match_details['spell1'].'.png';?>" alt="spell1 image" width="30"/>
								<img src="<?php echo get_template_directory_uri().'/assets/img/summonersspell30x30/'.$match_details['spell2'].'.png';?>" alt="spell2 image" width="30"/>
							</td>
							<td><?php if(!empty($booster_assigned) && trim($booster_assigned) != 'null')
								{
									echo get_userdata($booster_assigned)->user_nicename;
								}
								?>
							</td>
						</tr>
						<?php
						$matchNum++;
					}
				}
				?>
			</tbody>
		</table>
		<?php if(!empty($matches_played) && is_array($matches_played)){?>
			<div class="match_stat">Total <strong><?php echo count($matches_played);?></strong> matches have been played.</div> <span>(Updated every <strong>180 seconds</strong>)</span>
			<?php if(count($matches_played) > 5){?>
			<ul class="matches_pagination pagination" role="navigation" aria-label="Pagination">
				<?php $total_pages = count($matches_played)/5;
				if(count($matches_played)%5 != 0) $total_pages +=1;
					for( $i = 1; $i <= $total_pages; $i++ ){?>
					<li <?php if($i==1) echo 'class="current"';?>><a href="javascript:paginateMatches(<?php echo $i;?>);"><?php echo $i;?></a></li>
				<?php }?>
			</ul>
			<?php }
		}?>

		<?php /*
		<div class="last_api_run" title="<?php echo date('m/d/Y g:i A', $last_api_run) ?>">
			<?php
				$last_api_run = get_post_meta($orderInProgress, 'last_api_run', true);
				if($last_api_run)
					echo 'Last updated '.human_time_diff( $last_api_run, current_time( 'timestamp' )).' ago (Updates every 180 seconds)';
			?>
		</div>
	</div>
*/ ?>	 <?php
}
function order_history_meta_box_callback($allOrders)
{
	?>
	<div class="boosting-orders">
		<table class="boosting-orders-table widefat fixed tablesorter">
			<thead>
				<tr>
					<th class="boosting-service header">Service</th>
					<th class="boosting-type header">Type</th>
					<th class="booster-assigned header">Booster</th>
					<th class="boosting-date header">Date/time (CDT)</th>
					<th class="boosting-status header">Status</th>
					<th class="boosting-status header">Details</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($allOrders)){
					foreach($allOrders as $order_id){
						$booting_category = get_the_terms($order_id, 'eloboost-type');
						$order_status = get_post_meta($order_id, 'order_status', true);?>
						<tr>
							<td><?php echo get_post_meta($order_id, 'order_name', true);?></td>
							<td><?php echo $booting_category[0]->name;?></td>
							<td><?php $booster_assigned = get_post_meta($order_id, 'booster_assigned', true); if($booster_assigned) echo get_userdata($booster_assigned)->user_nicename;?></td>
							<td><?php echo get_the_date('F j, Y g:i a', $order_id);?></td>
							<td><?php if(empty($order_status)) echo 'Pending'; else echo $order_status;?></td>
							<td><a href='<?php echo admin_url("admin.php?page=my-dashboard&order=$order_id");?>'>More</a></td>
						</tr>
				<?php }
				}
				else{ echo '<tr><td colspan="5">No orders found</td></tr>';}?>
			</tbody>
		</table>
	</div>
	<?php
}
function current_order_standings_meta_box_callback($orderInProgress){
	global $current_user, $post, $wpdb, $resolveLeagues, $resolveDivisions;

	if(is_object($orderInProgress) && !empty($orderInProgress))
	{
		$orderInProgress = $orderInProgress->ID;
	}

	if(empty($orderInProgress))
		return;

	echo '<div class="boosting_name">'.get_post_meta($orderInProgress, 'order_name', true).'</div>';

	$boosting_type = get_post_meta($orderInProgress, 'boosting_type', true);
	$boosting_action = get_post_meta($orderInProgress, 'boosting_action', true);
	if($boosting_action == 'division'){
		$order_start_league = get_post_meta($orderInProgress, 'order_start_league', true);
		$order_start_division = get_post_meta($orderInProgress, 'order_start_division', true);
		$order_start_league_points = get_post_meta($orderInProgress, 'order_start_league_points', true);
		$order_current_league = get_post_meta($orderInProgress, 'order_current_league', true);
		if(empty($order_current_league))
			$order_current_league = $order_start_league;
		$order_current_division = get_post_meta($orderInProgress, 'order_current_division', true);
		if(empty($order_current_division))
			$order_current_division = $order_start_division;
		$order_current_league_points = get_post_meta($orderInProgress, 'order_current_league_points', true);
		if(empty($order_current_league_points))
			$order_current_league_points = '0';
		$order_desired_league = get_post_meta($orderInProgress, 'order_desired_league', true);
		$order_desired_division = get_post_meta($orderInProgress, 'order_desired_division', true);
		?>
		<div class="order_start_block standing_block three_col">
			<div class="title">Start</div>
			<div class="order_start_details">
				<img class="img-responsive" id="start-image" width="100" src="
					<?php echo get_template_directory_uri() . "/assets/img/divisions/" . $order_start_league."_".$order_start_division . ".png";?>" />
				<div class="order_name"><?php echo $resolveLeagues[$order_start_league].'<br>Division '.$resolveDivisions[$order_start_division].'<br>LP: '.$order_start_league_points;?></div>
			</div>
		</div>
		<div class="order_current_block standing_block three_col">
			<div class="title">Current</div>
			<div class="order_current_details">
				<img class="img-responsive" id="current-image" width="100" src="
					<?php echo get_template_directory_uri() . "/assets/img/divisions/" . $order_current_league."_".$order_current_division . ".png";?>" />
				<div class="order_name"><?php echo $resolveLeagues[$order_current_league].'<br>Division '.$resolveDivisions[$order_current_division].'<br>LP: '.$order_current_league_points;?></div>
			</div>
		</div>
		<div class="order_desired_block standing_block three_col">
			<div class="title">Desired</div>
			<div class="order_desired_details">
				<img class="img-responsive" id="desired-image" width="100" src="
					<?php echo get_template_directory_uri() . "/assets/img/divisions/" . $order_desired_league."_".$order_desired_division . ".png";?>" />
				<div class="order_name"><?php echo $resolveLeagues[$order_desired_league].'<br>Division '.$resolveDivisions[$order_desired_division];?></div>
			</div>
		</div>
		<?php
	}
	elseif($boosting_action == 'net-wins'){
		$order_start_league = get_post_meta($orderInProgress, 'order_start_league', true);
		$order_start_division = get_post_meta($orderInProgress, 'order_start_division', true);
		$order_current_net_wins = get_post_meta($orderInProgress, 'order_current_net_wins', true);
		if(empty($order_current_net_wins)) $order_current_net_wins = 0;
		$order_net_wins = get_post_meta($orderInProgress, 'order_net_wins', true);
		?>
		<div class="order_start_block standing_block three_col">
			<div class="title">Start</div>
			<div class="order_start_details">
				<img class="img-responsive" id="start-image" width="100" src="
					<?php echo get_template_directory_uri() . "/assets/img/divisions/" . $order_start_league."_".$order_start_division . ".png";?>" />
				<div class="order_name"><?php echo $resolveLeagues[$order_start_league].'<br>Division '.$resolveDivisions[$order_start_division];?></div>
			</div>
		</div>
		<div class="order_current_block standing_block three_col">
			<div class="title">Current</div>
			<div class="order_current_details">
				<div class="stat"><?php echo $order_current_net_wins;?></div>
				<div class="order_name">Net Wins</div>
			</div>
		</div>
		<div class="order_desired_block standing_block three_col">
			<div class="title">Desired</div>
			<div class="order_desired_details">
				<div class="stat"><?php echo $order_net_wins;?></div>
				<div class="order_name">Net Wins</div>
			</div>
		</div>
		<?php
	}
	elseif($boosting_action == 'unranked'){
		$order_start_league = get_post_meta($orderInProgress, 'order_start_league', true);
		$order_current_unranked_games = get_post_meta($orderInProgress, '$order_current_unranked_games', true);
		if(empty($order_current_unranked_games)) $order_current_unranked_games = 0;
		$order_unranked_games = get_post_meta($orderInProgress, 'order_unranked_games', true);
		?>
		<div class="order_start_block standing_block three_col">
			<div class="title">Start</div>
			<div class="order_start_details">
				<img class="img-responsive" id="start-image" width="100" src="
					<?php echo get_template_directory_uri() . "/assets/img/divisions/" . $order_start_league."_".$order_start_division . ".png";?>" />
				<div class="order_name"><?php echo $resolveLeagues[$order_start_league];?></div>
			</div>
		</div>
		<div class="order_current_block standing_block three_col">
			<div class="title">Current</div>
			<div class="order_current_details">
				<div class="stat"><?php echo $order_current_unranked_games;?></div>
				<div class="order_name">Unranked Games</div>
			</div>
		</div>
		<div class="order_desired_block standing_block three_col">
			<div class="title">Desired</div>
			<div class="order_desired_details">
				<div class="stat"><?php echo $order_unranked_games;?></div>
				<div class="order_name">Unranked Games</div>
			</div>
		</div>
		<?php
	}
	elseif($boosting_action == 'general-wins'){
		if($boosting_type == 'group'){
			$order_start_league = get_post_meta($orderInProgress, 'order_start_league', true);
			$order_start_division = get_post_meta($orderInProgress, 'order_start_division', true);
			$order_current_general_wins = get_post_meta($orderInProgress, 'order_current_general_wins', true);
			if(empty($order_current_general_wins)) $order_current_general_wins = 0;
			$order_general_wins = get_post_meta($orderInProgress, 'order_general_wins', true);
			?>
			<div class="order_start_block standing_block three_col">
				<div class="title">Start</div>
				<div class="order_start_details">
					<img class="img-responsive" id="start-image" width="100" src="
						<?php echo get_template_directory_uri() . "/assets/img/divisions/" . $order_start_league."_".$order_start_division . ".png";?>" />
					<div class="order_name"><?php echo $resolveLeagues[$order_start_league].'<br>Division '.$resolveDivisions[$order_start_division];?></div>
				</div>
			</div>
			<div class="order_current_block standing_block three_col">
				<div class="title">Current</div>
				<div class="order_current_details">
					<div class="stat"><?php echo $order_current_general_wins;?></div>
					<div class="order_name">Group Games</div>
				</div>
			</div>
			<div class="order_desired_block standing_block three_col">
				<div class="title">Desired</div>
				<div class="order_desired_details">
					<div class="stat"><?php echo $order_general_wins;?></div>
					<div class="order_name">Group Games</div>
				</div>
			</div>
			<?php
		}else{
			$order_current_general_wins = get_post_meta($orderInProgress, 'order_current_general_wins', true);
			if(empty($order_current_general_wins)) $order_current_general_wins = 0;
			$order_general_wins = get_post_meta($orderInProgress, 'order_general_wins', true);
			?>
			<div class="order_current_block standing_block two_col">
				<div class="title">Current</div>
				<div class="order_current_details">
					<div class="stat"><?php echo $order_current_general_wins;?></div>
					<div class="order_name">Normal Win</div>
				</div>
			</div>
			<div class="order_desired_block standing_block two_col">
				<div class="title">Desired</div>
				<div class="order_desired_details">
					<div class="stat"><?php echo $order_general_wins;?></div>
					<div class="order_name">Normal Win</div>
				</div>
			</div>
			<?php
		}
	}
	elseif($boosting_action == 'coaching' && $boosting_type == 'hourly'){
		$order_current_coaching_hours = get_post_meta($orderInProgress, 'order_current_coaching_hours', true);
		if(empty($order_current_coaching_hours)) $order_current_coaching_hours = 0;
		$order_coaching_hours = get_post_meta($orderInProgress, 'order_coaching_hours', true);
		?>
		<div class="order_current_block standing_block two_col">
			<div class="title">Current</div>
			<div class="order_current_details">
				<div class="stat"><?php echo $order_current_coaching_hours;?></div>
				<div class="order_name">Hours Coached</div>
			</div>
		</div>
		<div class="order_desired_block standing_block two_col">
			<div class="title">Desired</div>
			<div class="order_desired_details">
				<div class="stat"><?php echo $order_coaching_hours;?></div>
				<div class="order_name">Hours Remaining</div>
			</div>
		</div>
		<?php
	}
	elseif($boosting_action == 'coaching' && $boosting_type == 'games'){
		$order_current_coaching_games = get_post_meta($orderInProgress, 'order_current_coaching_games', true);
		if(empty($order_current_coaching_games)) $order_current_coaching_games = 0;
		$order_coaching_games = get_post_meta($orderInProgress, 'order_coaching_games', true);
		?>
		<div class="order_current_block standing_block two_col">
			<div class="title">Current</div>
			<div class="order_current_details">
				<div class="stat"><?php echo $order_current_coaching_games;?></div>
				<div class="order_name">Games Coached</div>
			</div>
		</div>
		<div class="order_desired_block standing_block two_col">
			<div class="title">Desired</div>
			<div class="order_desired_details">
				<div class="stat"><?php echo $order_coaching_games;?></div>
				<div class="order_name">Games Remaining</div>
			</div>
		</div>
		<?php
	}
}

function send_message_meta_box_callback($orderInProgress){
	global $currentCommentTimeF, $current_user, $wpdb, $admin_id; $booster_assigned=false;
	if(isset($_POST) && $_POST['user_action'] == 'send_message'){
		ajax_send_message_callback();
	}
	if($orderInProgress){
		$booster_assigned = get_post_meta($orderInProgress, 'booster_assigned', true);
		run_incoming_message_ajax($current_user->ID, $orderInProgress);
		$booster_active = false;
		if(!empty($booster_assigned) && trim($booster_assigned) != 'null'){
			$booster_active = true;
		}
	}
	?>
	<div class="main-message">
		<ul class="tabs" data-tabs id="message-users-tab">
	  	<?php if($booster_active){?>
		  <li class="tabs-title is-active"><a href="#booster" aria-selected="true">Booster</a></li>
		<?php }?>
		  <li class="tabs-title <?php if(!$booster_active) echo ' is-active';?>"><a href="#admin">Admin</a></li>
		</ul>
		<div class="tabs-content" data-tabs-content="message-users-tab">
		  <div class="tabs-panel <?php if(!$booster_active) echo ' is-active';?>" id="admin">
			<div class="message-history">
				<ul class="message-list">
				<?php

					$messages = get_comments_messages($current_user->ID, $admin_id, $orderInProgress);
					if(!empty($messages)){
			  			$wpdb->query($wpdb->prepare("
			  				UPDATE {$wpdb->comments} c
			  				SET c.comment_karma = '1'
			  				WHERE c.comment_parent = %d
			  				AND c.user_id = %d
			  				AND c.comment_type = 'message'
			  				", $current_user->ID, $admin_id
			  			));
						foreach($messages as $message) {
							$GLOBALS['comment']=$message;
              $comment_time = (get_comment_time( 'U' ));
              $actual_time = current_time('timestamp');

              $comment_time_old = new DateTime();
              $comment_time_old->setTimestamp($comment_time);
              if(isset($_SESSION['tz']))
                $comment_time_old->setTimezone(new DateTimeZone($_SESSION['tz']));
              $comment_time_new = $comment_time_old->format('m/d/Y g:i A');
              $comment_time_unix = strtotime($comment_time_new);
              $actual_time_old = new DateTime();
              $actual_time_old-> setTimestamp($actual_time);
              if(isset($_SESSION['tz']))
                $actual_time_old-> setTimezone(new DateTimeZone($_SESSION['tz']));
              $actual_time_new = $actual_time_old->format('m/d/Y g:i A');
              $actual_time_unix = strtotime($actual_time_new);
							if(get_comment_author() == $current_user->user_login || get_comment_author() == $current_user->display_name)
								$current_author = 'You';
							else $current_author = get_comment_author();?>
						  <li class="<?php if($current_author == 'You') echo 'message-me'; else echo 'message-other';?>">
							<div class="message-head">
	  							<h4><?php echo $current_author;?></h4>
									<span title="<?php echo $comment_time_new ?>"><?php echo human_time_diff($comment_time_unix, $actual_time_unix); ?> </span>
							</div>
							<div class="message-content"><?php comment_text(); ?></div>
						</li>
					<?php }
					}?>
				</ul>
			</div>
  			<div class="message-reply">
  				<div class="message-form">
  					<form action="" name="send_message" id="admin_message_form" method="POST" class="formatted-form"  accept-charset="utf-8">
  					  <?php //renderEditor('admin_message'); ?>
					  <textarea class="wp-message-area" rows="3" autocomplete="off" cols="27" name="admin_message" id="admin_message"></textarea>
  					  <input type="hidden" name="user_recipient" value="<?php echo $admin_id;?>" />
					  <input type="hidden" name="user_action" value="send_message" />
  					  <input type="hidden" name="order_in_progress" value="<?php echo $orderInProgress;?>" />
  					  <button type="submit" class="button btn btn-primary">Send Message</button>&nbsp;&nbsp;<span class="status_loader"></span>
  					</form>
  				</div>
  			</div>
		  </div>
		  <?php if($booster_active){?>
		    <div class="tabs-panel is-active" id="booster">
		  	<div class="message-history">
		  		<ul class="message-list">
		  		<?php
					$messages = get_comments_messages($current_user->ID, $booster_assigned, $orderInProgress);
		  			if(!empty($messages)) {
			  			$wpdb->query($wpdb->prepare("
			  				UPDATE {$wpdb->comments} c
			  				SET c.comment_karma = '1'
			  				WHERE c.comment_parent = %d
			  				AND c.user_id = %d
			  				AND c.comment_type = 'message'
			  				", $current_user->ID, $booster_assigned
			  			));
		  				foreach($messages as $message) {
		  					$GLOBALS['comment'] = $message;
                $comment_time = (get_comment_time( 'U' ));
                $actual_time = current_time('timestamp');

                $comment_time_old = new DateTime();
                $comment_time_old->setTimestamp($comment_time);
                if(isset($_SESSION['tz']))
                    $comment_time_old->setTimezone(new DateTimeZone($_SESSION['tz']));
                $comment_time_new = $comment_time_old->format('m/d/Y g:i A');
                $comment_time_unix = strtotime($comment_time_new);
                $actual_time_old = new DateTime();
                $actual_time_old-> setTimestamp($actual_time);
                if(isset($_SESSION['tz']))
                    $actual_time_old-> setTimezone(new DateTimeZone($_SESSION['tz']));
                $actual_time_new = $actual_time_old->format('m/d/Y g:i A');
                $actual_time_unix = strtotime($actual_time_new);

							if(get_comment_author() == $current_user->user_login || get_comment_author() == $current_user->display_name)
								$current_author = 'You';
							else $current_author = get_comment_author();?>
						  <li class="<?php if($current_author == 'You') echo 'message-me'; else echo 'message-other';?>">
							<div class="message-head">
	  							<h4><?php echo $current_author;?></h4>
                  <span title="<?php echo $comment_time_new ?>"><?php echo human_time_diff($comment_time_unix, $actual_time_unix); ?> </span>
		  					</div>
		  					<div class="message-content"><?php comment_text(); ?></div>
		  				</li>
		  			<?php }
		  			}?>
		  		</ul>
		  	</div>
		  	<div class="message-reply">
		  		<div class="message-form">
		  			<form action="" name="send_message" id="booster_message_form" method="POST" class="formatted-form" accept-charset="utf-8">
		  			  <?php //renderEditor('booster_message'); ?>
					  <textarea class="wp-message-area" rows="3" autocomplete="off" cols="27" name="booster_message" id="booster_message"></textarea>
		  			  <input type="hidden" name="user_recipient" value="<?php echo $booster_assigned;?>" />
		  			  <input type="hidden" name="user_action" value="send_message" />
  					  <input type="hidden" name="order_in_progress" value="<?php echo $orderInProgress;?>" />
		  			  <button type="submit" class="button btn btn-primary">Send Message</button>&nbsp;&nbsp;<span class="status_loader"></span>
		  			</form>
		  		</div>
		  	</div>
		    </div>
		    <?php }?>
		</div>
	</div>
	<?php
}

//remove default fields
function hide_profile_fields( $contactmethods ) {
	unset($contactmethods['aim']);
	unset($contactmethods['jabber']);
	unset($contactmethods['yim']);
	$contactmethods['skype']   = 'Skype Username';
	return $contactmethods;
}


function add_custom_profile_meta($profileuser ) {
	global $current_user, $wpdb;
	if(current_user_can('manage_options')){
	?>
	<style>
    .switch input[type=radio]{display:none;}
    .switch-label {
      position: relative;
      z-index: 2;
      float: left;
      width: 110px;
      line-height: 26px;
      font-size: 11px;
      color: #fff;
      text-align: left;
      text-shadow: 0 1px 1px rgba(0, 0, 0, 0.45);
      cursor: pointer;
      border-radius: 12px;
      -webkit-box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
    }
    .switch-label:active {
      font-weight: bold;
    }


    .switch-label-on {
      padding-left: 22px;
      background-color: #48a9d0;
    }

    .switch-label-off {
      padding-left:30px;
      background-color: #EF6A8A;
    }


    .switch-input {
      display: none;
    }

    .switch-input:checked + .switch-label {
        background:transparent;
        color:#fff;
        width:0px;
        padding-left:0px;
        text-indent:-99999px;
    }
    .switch-input:checked + .switch-label-off ~ .switch-selection {
      left: 107px;
    }

    .switch-selection {
      position: relative;
      z-index: 99;
      display: block;
      width: 26px;
      height: 26px;
      border-radius: 50%;
      background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABsAAAAaCAYAAABGiCfwAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAR8SURBVHjanFZdaJtVGH7zffn5vmTJV9K0yaxLSle3LnPOtbPaC29HQVAQYYI3grd6IbsVvBG88QcU9FYQxKIgeiUDB7tS1LGg2DVpsG3SzIIuy/9/G9/n5DtfT7PUdh54cnK+8/Oc932f857jeu+Dj+gYZYLxHGOJEWNMMYqMDUaa8c21N9/YOGoR1xFkTzLeNQxjORE/RdHoJAX8fgoE/NRut6lcqVKpVKKNzS2qVmspHvs2k373sGQm45PxcPjVubkzdI7R7/cHE1wuUaMtv6EU7v5Fd9bSlMtt3+DmK0y6cxyyOOOr88lziwvzF2lvb09A13UBTdMcMnzf3d0VQEH/H6trdDv1G4heYMKf1YW1ISKLcX3+0sXFJy4kqdFoCHdhUWmJao1so7/b7Yrxj83O0NIzi4jr9fc//Dh5GJnO+PLC48mzmNBqtR4gGUWkAuOxuZOxSbq8cAkb/5YJw6PIrs7MTC+fT85Rr9c74CoJleywfmll/NQU8cZnIbBhMi8+npk9LQYPC0FdTBKq1qiQBf8hLC6vsXVnVbKrs6dn4uPjYUECEQCSUApBXUz9rvZhzkBILsL0py7PIzyvq2QvJeKPDkxlEqk6iVGEo4jkXLcbcIv2dCIu1seP2yZbikQizgS4R1qoLo5YejyeA21V9iDRNd6oLj2jkeFz05hlxeBKkMVM05wwDJ8jDBBJF0pSuTCC7/V6RQ2gz+NxC0sGHpEudNlzdbLGQlQqlwVZ2OfzPqA2SSbdiIVABmkHAgFqNpuEeT6fz3HZ/ia5FouQbZ2BVnjgxv5+DI4qsAoLR6NRetgCsmK703bIhqWtpiW4TaQZy6KffknRyegEBYMBsQHdjpMmLbNN03WX8AZ4QLbTbLaKnDHCwwSopdpQw5WRyLggnHokxsl3h+qNJt8EJiHmInaIGwCXcuz6bM/9UhlT0lL6P/79zz2xOIQAC9RaEiFWpmGKCX7TJJzLSrVG5XJVXDfVal2Q8+apxdZ0Oj1cPdxf3uGk7JCt5POFA3KWNTYAIgjBNA3S3YMwwwqDBTI2ZlGD82i93hREQEMQtsVmN/mu4/K1eqhXtnL5XInNhZpUZYIIZwtkHo/XUSm+e/k7YFkhanc6InkLq1pt0QbZr7duQ3WfqmQdxlubW3lH6vsH1S0E4PV6RDzUI4E+ecZCoSB1uj12XZcF0eEN92ktncHQz9mFq8NZ/4v8duH79eyfwhJ5WeI/IM6Svj8cBxcKxHe3PTYUDFIXiYE3VCgUaH09m+Wh10ZdMTD3ZSZLb+W2WV2GQyLTEA6oc+jJZedCbZAL9UGagmiKxXuUTqchwRfZquJhNzUGXFm9k761lskKQmQJmZhtD9oZxk682sAquBoKvcsWZTIZPAuuMNHv//UsQMkxns1ksp/9cOMmsXCEMKDCA5YJIs1RZblcolQqBYtucvfTw++P4zzlFhjv+P3m8nQiQZMTEToRPCGshQiK90tUqVSEvGu1+v9+yg0XPGCet8nj9qO1Zj9Q8ThdOc4j9V8BBgDHpr2idbGMxgAAAABJRU5ErkJggg==) no-repeat;
      /*background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #9dd993), color-stop(100%, #65bd63));
      background-image: -webkit-linear-gradient(top, #9dd993, #65bd63);
      background-image: -moz-linear-gradient(top, #9dd993, #65bd63);
      background-image: -ms-linear-gradient(top, #9dd993, #65bd63);
      background-image: -o-linear-gradient(top, #9dd993, #65bd63);
      background-image: linear-gradient(top, #9dd993, #65bd63);*/

      -webkit-box-shadow: inset 0 1px rgba(255, 255, 255, 0.5), 0 0 2px rgba(0, 0, 0, 0.2);
      box-shadow: inset 0 1px rgba(255, 255, 255, 0.5), 0 0 2px rgba(0, 0, 0, 0.2);
      -webkit-transition: left 0.15s ease-out;
      -moz-transition: left 0.15s ease-out;
      -ms-transition: left 0.15s ease-out;
      -o-transition: left 0.15s ease-out;
      transition: left 0.15s ease-out;
    }
	</style>
	<table class="form-table">
		<tr>
		<th><label>Acount Status</label></th>
		<td>
            <div class="switch">
              <input type="radio" class="switch-input" name="account_status" value="0" id="acn_inact" <?php if(!$profileuser->user_status) echo 'checked';?> >
              <label for="acn_inact" title="Deactivate this Account" class="switch-label switch-label-on">Account Active</label>
              <input type="radio" class="switch-input" name="account_status" value="1" id="acn_act" <?php if($profileuser->user_status) echo 'checked';?>>
              <label for="acn_act" title="Click here to reactivate the account." class="switch-label  switch-label-off">Account Inactive</label>
              <span class="switch-selection"></span>
            </div>
		</td>
		</tr>
  	</table>
<?php }
}

function save_custom_profile_meta($profileuser_id ) {
	global $current_user, $wpdb;
	// Save user meta
	if ( isset( $_POST['account_status'] ) )
	{
		$account_status = get_the_author_meta( 'user_status', $profileuser_id );
		if($account_status != $_POST['account_status'])
		{
			$sql_update = "UPDATE {$wpdb->users} SET user_status = {$_POST['account_status']} WHERE ID = '$profileuser_id'";
			$wpdb->query($sql_update);
		}
	}
}

function renderEditor($ID, $content='') {
	$settings=array(
		'media_buttons'=>false,
		'teeny'=>true,
		'quicktags' => false,
		'textarea_rows' => 5,
		'tinymce' => array(
			'theme_advanced_buttons1' => 'bold,italic,undo,redo',
			'theme_advanced_buttons2' => '',
			'theme_advanced_buttons3' => '',
			'toolbar1' => 'bold,italic,undo,redo',
			'toolbar2' => '',
			'toolbar3' => '',
		),
	);
	wp_editor($content, $ID, $settings);
}

function ajax_send_message_callback(){
	global $current_user, $screen;
	$in_ajax = false;

	if (defined('DOING_AJAX') && DOING_AJAX)
		$in_ajax = true;
	if ($_REQUEST['screen'] == 'edit-eloboost-orders')
		$in_ajax = false;

	if(isset($_REQUEST['message']) && !empty($_REQUEST['message'])){
		$message = $_REQUEST['message'];
	}
	elseif(isset($_REQUEST['admin_message']) && !empty($_REQUEST['admin_message']))
	{
		$message = $_REQUEST['admin_message'];
		$send_from = 'admin_chat';
	}
	elseif(isset($_REQUEST['booster_message']) && !empty($_REQUEST['booster_message']))
	{
		$message = $_REQUEST['booster_message'];
		$send_from = 'booster_chat';
	}

	if(isset($_REQUEST['post_id']))
		$post_id = $_REQUEST['post_id'];
	elseif(isset($_REQUEST['order_in_progress']))
		$post_id = $_REQUEST['order_in_progress'];
	else $post_id = 0;

	if(isset($_REQUEST["send_method"]) && $_REQUEST["send_method"] == 'order_page')
	{
		if($send_from == 'admin_chat')
		{
			$user_id = 1;
		}
		elseif($send_from == 'booster_chat')
		{
			$user_id = get_post_meta($post_id, 'booster_assigned', true);
		}
		$user_data = get_userdata($user_id);
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
	}
	elseif(empty($user_id)) {
		$user_id = $current_user->ID;
		$user_login = $current_user->user_login;
		$user_email = $current_user->user_email;
	}


	if( ( empty($_REQUEST['user_recipient']) || empty($message) ) && $in_ajax){
		echo ';-;error;-;';
		die(0);
	}

	$message = trim($message);
	if($message){
		$comment_id = wp_insert_comment(array(
			'comment_post_ID' => $post_id,
			'comment_karma' => 0,
			'comment_type' => 'message',
			'comment_parent' => $_REQUEST['user_recipient'],
			'user_id' => $user_id,
			'comment_author' => $user_login,
			'comment_author_email' => $user_email,
			'comment_content' => wp_kses($message, array(
					'strong' => array(),
					'em' => array(),
					'a' => array(
					'href' => array(),
					'title' => array(),
					'target' => array(),
				),
				'p' => array(),
				'br' => array(),
			)),
		));
	}
	if($in_ajax){
		if($comment_id)
			echo ';-;success;-;'.$message.';-;'.date('F j, g:i a');
		else
			echo ';-;error;-;';
		die(0);
	}
}

function get_comments_messages($from, $to, $orderInProgress){
	global $wpdb;
	$sql = $wpdb->prepare("
		SELECT c.comment_ID as comment_ID, c.user_id as user_id,
		c.comment_date as comment_date, c.comment_content as comment_content FROM {$wpdb->comments} c
		WHERE ((c.comment_parent = %d
		AND c.user_id = %d)
		OR (c.user_id = %d
		AND c.comment_parent = %d))
		AND c.comment_type = 'message'
		ORDER BY c.comment_date ASC
		", $from, $to, $from, $to);

	$messages=$wpdb->get_results($sql);
	return $messages;
}

function ajax_hide_new_order_alert_callback(){
	extract($_POST);
	update_user_meta($user_recipient, 'eloboost_new_order_alert', '');
	die(0);
}

function ajax_receive_message_callback(){
	global $current_user, $wpdb, $admin_id;
	extract($_POST);

	if(empty($order_id))
		return;

	$booster_assigned = get_post_meta($order_id, 'booster_assigned', true);
	$post_author = (int) get_post_field('post_author', $order_id);
	 $content = array();

	$booster_messages = get_comments_messages($booster_assigned, $recipent_user_id, $order_id);
	$admin_messages = get_comments_messages($admin_id, $recipent_user_id, $order_id);

	if(!empty($booster_messages)) {
		ob_start();
		foreach($booster_messages as $message) {
			$GLOBALS['comment'] = $message;

      $comment_time = (get_comment_time( 'U' ));
      $actual_time = current_time('timestamp');

      $comment_time_old = new DateTime();
      $comment_time_old->setTimestamp($comment_time);
      if(isset($_SESSION['tz']))
        $comment_time_old->setTimezone(new DateTimeZone($_SESSION['tz']));
      $comment_time_new = $comment_time_old->format('m/d/Y g:i A');
      $comment_time_unix = strtotime($comment_time_new);
      $actual_time_old = new DateTime();
      $actual_time_old-> setTimestamp($actual_time);
      if(isset($_SESSION['tz']))
        $actual_time_old-> setTimezone(new DateTimeZone($_SESSION['tz']));
      $actual_time_new = $actual_time_old->format('m/d/Y g:i A');
      $actual_time_unix = strtotime($actual_time_new);
			if(get_comment_author() == $current_user->user_login || get_comment_author() == $current_user->display_name)
				$current_author = 'You';
			else $current_author = get_comment_author();?>
		  <li class="<?php if($current_author == 'You') echo 'message-me'; else echo 'message-other';?>">
			<div class="message-head">
				<h4><?php echo $current_author;?></h4>
        <span title="<?php echo $comment_time_new ?>"><?php echo human_time_diff($comment_time_unix, $actual_time_unix); ?> </span>
			</div>
			<div class="message-content"><?php comment_text(); ?></div>
		</li>
	<?php }
		$content['booster'] = ob_get_contents();
		ob_end_clean();
	}
	if(!empty($admin_messages)) {
		ob_start();
		foreach($admin_messages as $message) {
			$GLOBALS['comment'] = $message;

      $comment_time = (get_comment_time( 'U' ));
      $actual_time = current_time('timestamp');

      $comment_time_old = new DateTime();
      $comment_time_old->setTimestamp($comment_time);
      if(isset($_SESSION['tz']))
        $comment_time_old->setTimezone(new DateTimeZone($_SESSION['tz']));
      $comment_time_new = $comment_time_old->format('m/d/Y g:i A');
      $comment_time_unix = strtotime($comment_time_new);
      $actual_time_old = new DateTime();
      $actual_time_old-> setTimestamp($actual_time);
      if(isset($_SESSION['tz']))
        $actual_time_old-> setTimezone(new DateTimeZone($_SESSION['tz']));
      $actual_time_new = $actual_time_old->format('m/d/Y g:i A');
      $actual_time_unix = strtotime($actual_time_new);
			if(get_comment_author() == $current_user->user_login || get_comment_author() == $current_user->display_name)
				$current_author = 'You';
			else $current_author = get_comment_author();?>
		  <li class="<?php if($current_author == 'You') echo 'message-me'; else echo 'message-other';?>">
			<div class="message-head">
				<h4><?php echo $current_author;?></h4>
        <span title="<?php echo $comment_time_new ?>"><?php echo human_time_diff($comment_time_unix, $actual_time_unix); ?> </span>
			</div>
			<div class="message-content"><?php comment_text(); ?></div>
		</li>
	<?php }
		$content['admin'] = ob_get_contents();
		ob_end_clean();
	}
	echo ';--;'.$content['booster'].';--;'.$content['admin'];
	die(0);
}
function run_incoming_message_ajax($user_id, $post_id){?>
	<script type="text/javascript">
		jQuery(function($){
	        var interval = 1000 * 10; //X secs
	        var ajaxRecall;
	        var ajaxCall = function() {
	             $.ajax({
	                async: true,
	                type: 'POST',
	                url: ajaxurl,
	                dataType: "html",
	                data: {
						'action':'receive_message',
						'recipent_user_id':'<?php echo $user_id;?>',
						'order_id':'<?php echo $post_id;?>'
					},
	                success: function (response) {
						var resArr = response.split(';--;');
	                    if (resArr[1] != "") {
							var contentFill = $('#booster_message_form').parents('.tabs-panel').find('.message-history > ul.message-list');
							$(contentFill).html(resArr[1]);
							$(document).find('#booster_message_form').parents('.tabs-panel').find('.message-history > ul.message-list').scrollTop($(contentFill).prop("scrollHeight"));
	                    }
						if (resArr[2] != "") {
							var contentFill = $('#admin_message_form').parents('.tabs-panel').find('.message-history > ul.message-list');
							$(contentFill).html(resArr[2]);
							$(document).find('#admin_message_form').parents('.tabs-panel').find('.message-history > ul.message-list').scrollTop($(contentFill).prop("scrollHeight"));
	                    }
	                }
	            });
	        };
	        ajaxRecall = setInterval(ajaxCall, interval);
	    });
	</script>
	<?php
}

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function admin_send_message_meta_boxes_callback( $post ) {?>

	<?php
		global $wpdb, $admin_id;

	?>
	<div class="message-panel admin_message_box">
	  <div class="message-history">
		  <ul class="message-list">
		  <?php
			  $messages = get_comments_messages( (int) $post->post_author, $admin_id, $post->ID);
		  	  if(!empty($messages)){
		  			$wpdb->query($wpdb->prepare("
		  				UPDATE {$wpdb->comments} c
		  				SET c.comment_karma = '1'
		  				WHERE c.comment_parent = %d
		  				AND c.user_id = %d
		  				AND c.comment_type = 'message'
		  				", $admin_id, $post->post_author
		  			));
				  foreach($messages as $message) {
					  $GLOBALS['comment']=$message;

            $comment_time = (get_comment_time( 'U' ));
            $actual_time = current_time('timestamp');

            $comment_time_old = new DateTime();
            $comment_time_old->setTimestamp($comment_time);
            if(isset($_SESSION['tz']))
                $comment_time_old->setTimezone(new DateTimeZone($_SESSION['tz']));
            $comment_time_new = $comment_time_old->format('m/d/Y g:i A');
            $comment_time_unix = strtotime($comment_time_new);
            $actual_time_old = new DateTime();
            $actual_time_old-> setTimestamp($actual_time);
            if(isset($_SESSION['tz']))
                $actual_time_old-> setTimezone(new DateTimeZone($_SESSION['tz']));
            $actual_time_new = $actual_time_old->format('m/d/Y g:i A');
            $actual_time_unix = strtotime($actual_time_new);

            ?>
					<li>
					  <div class="message-head">
						  <h4><?php echo get_comment_author();?></h4>
              <span title="<?php echo $comment_time_new ?>"><?php echo human_time_diff($comment_time_unix, $actual_time_unix); ?> </span>
					  </div>
					  <div class="message-content"><?php comment_text(); ?></div>
				  </li>
			  <?php }
			  }?>
		  </ul>
	  </div>
	  <div class="message-reply">
		  <div class="message-form">
			<?php //renderEditor('admin_message'); ?>
			<textarea class="wp-message-area" rows="3" autocomplete="off" cols="27" name="admin_message" id="admin_message"></textarea>
			<input type="hidden" name="user_recipient" value="<?php echo $post->post_author;?>" />
			<input type="hidden" name="user_action" value="send_message" />
			<input type="hidden" name="send_method" value="order_page" />
			<input type="hidden" name="order_in_progress" value="<?php echo $post->ID;?>" />
			<button type="submit" class="button btn btn-primary">Send Message</button>&nbsp;&nbsp;<span class="status_loader"></span>
		  </div>
	  </div>
	</div>
	<?php
}

function booster_send_message_meta_boxes_callback($post){?>

	<?php
		global $wpdb;
		$booster_assigned = get_post_meta($post->ID, 'booster_assigned', true);

	if(!empty($booster_assigned) && trim($booster_assigned) != 'null'){
	?>
	<div class="message-panel booster_message_box">
	  <div class="message-history">
		  <ul class="message-list">
		  <?php
			  $messages = get_comments_messages( (int) $post->post_author, $booster_assigned, $post->ID);
			  if(!empty($messages)) {
				  foreach($messages as $message) {
					  $GLOBALS['comment']=$message;
            $comment_time = (get_comment_time( 'U' ));
            $actual_time = current_time('timestamp');
            $comment_time_old = new DateTime();
            $comment_time_old->setTimestamp($comment_time);
            if(isset($_SESSION['tz']))
                $comment_time_old->setTimezone(new DateTimeZone($_SESSION['tz']));
            $comment_time_new = $comment_time_old->format('m/d/Y g:i A');
            $comment_time_unix = strtotime($comment_time_new);
            $actual_time_old = new DateTime();
            $actual_time_old-> setTimestamp($actual_time);
            if(isset($_SESSION['tz']))
                $actual_time_old-> setTimezone(new DateTimeZone($_SESSION['tz']));
            $actual_time_new = $actual_time_old->format('m/d/Y g:i A');
            $actual_time_unix = strtotime($actual_time_new);
            ?>
					<li>
					  <div class="message-head">
						  <h4><?php echo get_comment_author();?></h4>
							<span title="<?php echo $currentCommentTimeF ?>"><?php echo human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' )); ?> </span>
					  </div>
					  <div class="message-content"><?php comment_text(); ?></div>
				  </li>
			  <?php }
			  }?>
		  </ul>
	  </div>
	  <div class="message-reply">
		  <div class="message-form">
			<?php //renderEditor('booster_message'); ?>
			<textarea class="wp-message-area" rows="3" autocomplete="off" cols="27" name="booster_message" id="booster_message"></textarea>
			<input type="hidden" name="user_recipient" value="<?php echo $post->post_author;?>" />
			<input type="hidden" name="user_action" value="send_message" />
			<input type="hidden" name="send_method" value="order_page" />
			<input type="hidden" name="order_in_progress" value="<?php echo $post->ID;?>" />
			<button type="submit" class="button btn btn-primary">Send Message</button>&nbsp;&nbsp;<span class="status_loader"></span>
		  </div>
	  </div>
	</div>

	<?php }else{
		echo 'No Booster Assigned!';
	}
}
/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function leagueboost_save_meta_box( $post_id ) {

        /*
         * If this is an autosave, our form has not been submitted,
         * so we don't want to do anything.
         */
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        // Check the post.
        if ( 'eloboost-orders' != $_POST['post_type'] ) {
                return $post_id;
        }

		ajax_send_message_callback();

		//when client_summoner_name is changed during by admin/booster in its dashboard
		if(isset($_POST['fields']['field_573a9ce3d7f7c']) && !empty($_POST['fields']['field_573a9ce3d7f7c'])){
			$client_summoner_name = get_post_meta($post_id, 'summoner_name', true);
			if(!empty($client_summoner_name) && $client_summoner_name != $_POST['fields']['field_573a9ce3d7f7c']){
				update_post_meta($post_id, 'summoner_id', '');
				update_post_meta($post_id, 'last_api_run', '');
				update_post_meta($post_id, 'matches_played', array());
			}
		}
		//when choose_server is changed during by admin/booster in its dashboard
		if(isset($_POST['fields']['field_573a9d216579c']) && !empty($_POST['fields']['field_573a9d216579c'])){
			$choose_server = get_post_meta($post_id, 'choose_server', true);
			if(!empty($choose_server) && $choose_server != $_POST['fields']['field_573a9d216579c']){
				update_post_meta($post_id, 'last_api_run', '');
				update_post_meta($post_id, 'matches_played', array());
			}
		}

		//when booster_summoner_name is changed during group game in progress
		if(isset($_POST['fields']['field_574d187994a47']) && !empty($_POST['fields']['field_574d187994a47'])){
			$booster_summoner_name = get_post_meta($post_id, 'booster_summoner_name', true);
			if(!empty($booster_summoner_name) && $booster_summoner_name != $_POST['fields']['field_574d187994a47']){
				$summoner_id = get_post_meta($post_id, 'summoner_id', true);
				$boosting_action = get_post_meta($post_id, 'boosting_action', true);
				$response = lolAPIMatchDetails($post_id, $summoner_id);
				if(!empty($response) && isset($response['error']))
					$api_error = $response['message'];
				else{
					if($boosting_action == 'division')
						lolAPICheckDivisionRank($orderInProgress, $summoner_id);
					else{
						if(isset($response['all_matches']) && is_array($response['all_matches'])){
							updateMatchResults($orderInProgress, $response['all_matches'], $boosting_action, $boosting_type);
						}
					}
					checkOrderStatus($orderInProgress, $boosting_action, $boosting_type);
				}
				lolAPISummonerDetails($post_id, $_POST['fields']['field_574d187994a47']);
			}
		}
		if(isset($_POST['fields']['field_573a1dbcb42ef']) && $_POST['fields']['field_573a1dbcb42ef'] == 'Processing')
		{
			$processing_started = get_post_meta($post_id, 'processing_started', true);
			if(empty($processing_started))
				update_post_meta($post_id, 'processing_started', time());
			update_post_meta($post_id, 'processing_completed', '');
		}
		if(isset($_POST['fields']['field_573a1dbcb42ef']) && $_POST['fields']['field_573a1dbcb42ef'] == 'Complete')
		{
			orderStatusCompleteAction($post_id);
		}

}

function load_admin_pages_scripts()
{
    $screen = \get_current_screen();
    if( !empty($screen) &&
        (   $screen->base == 'toplevel_page_my-dashboard' ||
			$screen->base == 'toplevel_page_all-messages' ||
            $screen->post_type == 'eloboost-orders'
        )
    )
	{ ?>
		<script type="text/javascript">
		jQuery(function($){
			$('.message-history > ul.message-list').each(function(){
				$(this).scrollTop($(this).prop("scrollHeight"));
			});
		});
		</script>

	<?php }
    //return;

}


?>
