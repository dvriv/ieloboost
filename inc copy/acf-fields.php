<?php
/**
 * Setup Theme Options Pages
 */
if(function_exists("register_field_group"))
{
	//user-profile Page
	register_field_group(array (
		'id' => 'acf_lol-details',
		'title' => 'LOL Details',
		'fields' => array (
			array (
				'key' => 'field_574d181994a44',
				'label' => 'LOL Account Name',
				'name' => 'lol_account_name',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			)
		),
		'location' => array (
			array (
				array (
					'param' => 'ef_user',
					'operator' => '!=',
					'value' => 'subscriber',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
    //order Pages
	register_field_group(array (
		'id' => 'acf_booster-assigned',
		'title' => 'Booster Assigned',
		'fields' => array (
			array (
				'key' => 'field_573ab816dae35',
				'label' => 'Select Booster',
				'name' => 'booster_assigned',
				'type' => 'user',
				'role' => array (
					0 => 'administrator',
					1 => 'contributor',
				),
				'field_type' => 'select',
				'allow_null' => 1,
			),
			array (
				'key' => 'field_574d187994a47',
				'label' => 'Booster Summoner Name',
				'name' => 'booster_summoner_name',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'eloboost-orders',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_client-details-for-solo-boosting',
		'title' => 'Client Details for Solo Boosting',
		'fields' => array (
			array (
				'key' => 'field_573a9bfe64687',
				'label' => 'Account Name',
				'name' => 'account_name',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573a9c9764688',
				'label' => 'Account Password',
				'name' => 'account_password',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => '3',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => '4',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
			array (
				array (
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => '5',
					'order_no' => 0,
					'group_no' => 2,
				),
			),
			array (
				array (
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => '6',
					'order_no' => 0,
					'group_no' => 3,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_details-for-general-game-boosting',
		'title' => 'Details for General Game Boosting',
		'fields' => array (
			array (
				'key' => 'field_573aaa25970e3',
				'label' => 'Start League',
				'name' => 'order_start_league',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573aaa2d973e9',
				'label' => 'Start Division',
				'name' => 'order_start_division',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
            array (
                'key' => 'field_573aaa705034w',
                'label' => 'Current General Wins',
                'name' => 'order_current_general_wins',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array (
				'key' => 'field_573aaa70500d6',
				'label' => 'Desired General Wins',
				'name' => 'order_general_wins',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => '10',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => '11',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_order-details-for-division-boosting',
		'title' => 'Order Details for Division Boosting',
		'fields' => array (
			array (
				'key' => 'field_573aa97731612',
				'label' => 'Start League',
				'name' => 'order_start_league',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573aa9a331613',
				'label' => 'Start Division',
				'name' => 'order_start_division',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573aa9a33r4e4',
				'label' => 'League Points',
				'name' => 'order_start_league_points',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
            array (
				'key' => 'field_573aa9a9e5o14',
				'label' => 'Current League',
				'name' => 'order_current_league',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573aa9d4o4r95',
				'label' => 'Current Division',
				'name' => 'order_current_division',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573aa9a33r4e4',
				'label' => 'Current League Points',
				'name' => 'order_current_league_points',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573aa9ac31614',
				'label' => 'Desired League',
				'name' => 'order_desired_league',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573aa9d431615',
				'label' => 'Desired Division',
				'name' => 'order_desired_division',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => '4',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => '5',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_order-details-for-net-wins',
		'title' => 'Order Details for Net Wins',
		'fields' => array (
			array (
				'key' => 'field_573aaa2597710',
				'label' => 'Start League',
				'name' => 'order_start_league',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573aaa2d97711',
				'label' => 'Start Division',
				'name' => 'order_start_division',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573aaa36e4512',
				'label' => 'Current Net Wins',
				'name' => 'order_current_net_wins',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573aaa3697712',
				'label' => 'Desired Net Wins',
				'name' => 'order_net_wins',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => '6',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => '7',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_order-details-for-unranked-games',
		'title' => 'Order Details for Unranked Games',
		'fields' => array (
			array (
				'key' => 'field_573aaa9c978bf',
				'label' => 'Start League',
				'name' => 'order_start_league',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573aaa46978c0',
				'label' => 'Current Unranked Games',
				'name' => 'order_current_unranked_games',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573aaaa5978c0',
				'label' => 'Desired Unranked Games',
				'name' => 'order_unranked_games',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => '8',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => '9',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_orders-metas',
		'title' => 'Orders Metas',
		'fields' => array (
			array (
				'key' => 'field_573ab0dcc90e3',
				'label' => 'Order Name',
				'name' => 'order_name',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573737550c975',
				'label' => 'Order Price',
				'name' => 'order_price',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573a1dbcb42ef',
				'label' => 'Order Status',
				'name' => 'order_status',
				'type' => 'radio',
				'choices' => array (
					'Pending' => 'Pending',
					'Paused' => 'Paused',
					'Under-Review' => 'Under Review',
					'Processing' => 'Processing',
					'Complete' => 'Complete',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'Pending',
				'layout' => 'horizontal',
			),
			array (
				'key' => 'field_573a1e1bb42f0',
				'label' => 'Order Status Detail',
				'name' => 'order_status_detail',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573a9ce3d7f7c',
				'label' => 'Client Summoner Name',
				'name' => 'summoner_name',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573a9d216579c',
				'label' => 'Server',
				'name' => 'choose_server',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573a9dbf59677',
				'label' => 'Prefered Position',
				'name' => 'prefered_positions',
				'type' => 'checkbox',
				'choices' => array (
					'Top' => 'Top',
					'Jungle' => 'Jungle',
					'Mid' => 'Mid',
					'Support' => 'Support',
					'Bot' => 'Bot',
				),
				'default_value' => '',
				'layout' => 'horizontal',
			),
			array (
				'key' => 'field_573a9e1b59678',
				'label' => 'Prefered Champions',
				'name' => 'selected_champions',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_573a9ec159679',
				'label' => 'Notes to Booster',
				'name' => 'notes_to_booster',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'eloboost-orders',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
