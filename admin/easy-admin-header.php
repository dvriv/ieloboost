<?php $screen = get_current_screen();?>
<header id="header">
	<ul>
		<li><a href="<?php echo bloginfo('url'); ?>"><i class="dashicons dashicons-admin-home" aria-hidden="true"></i><span>Home</span></a></li>
		<li><a href="<?php echo admin_url('admin.php?page=my-dashboard');?>" class="<?php if ($screen->base == 'toplevel_page_my-dashboard') echo '-primary'; ?>"> <i class="dashicons dashicons-dashboard" aria-hidden="true"></i><span>Dashboard</span></a></li>
		<li><a href="<?php echo admin_url('profile.php'); ?>" class="<?php if ($screen->base == 'profile') echo '-primary'; ?>"> <i class="dashicons dashicons-admin-users" aria-hidden="true"></i><span>My Account</span></a></li>
		<li><a href="<?php echo wp_logout_url(home_url()); ?>"><i class="dashicons dashicons-share-alt2" aria-hidden="true"></i><span>Logout</span></a></li>
	</ul>
</header>

<div class="overlay-tip-booster">
	<div class="modal-container-tip-booster">
	<h1>If you like you can reward your booster with a small tip!</h1>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="DXN7JB9ATSM6Y">
			<input type="hidden" name="on0" value="Donation Amount">
				<select name="os0">
				<option value="1">$5.00 USD</option>
				<option value="2">$10.00 USD</option>
				<option value="3">$25.00 USD</option>
				<option value="4">$50.00 USD</option>
				<option value="5">$100.00 USD</option>
			</select>
		<input type="hidden" name="currency_code" value="USD">
		<input class="btn-primary btn"type="submit" value="SEND TIP" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>

	</div>
</div>
