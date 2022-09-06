jQuery(function($){

	$(window, document, undefined).ready(function() {

	$( ".overlay-tip-booster" ).click(function() {
		$(this).fadeOut(200);
	});
	$( ".tip-modal-button" ).click(function() {
		$(".overlay-tip-booster").fadeIn(200);
	});
	$(".modal-container-tip-booster").click(function(event) {
		event.stopPropagation();
	});

})

    //profile Pages
	var profileForm = $('#your-profile'),
		submits = profileForm.find('input[type="submit"]');
	// redirect form when user want to upgrade directory account
	submits.click(function(event) {
		if ($(this).attr('name') == 'user-submit') {
			profileForm.attr('action','<?php echo admin_url('profile.php'); ?>');
			// profileForm.trigger('submit');
			// return false;
		}
	});
	// rename profile to Account
	profileForm.parent().find('> h2').text('Account');
	// first show entire form
	$('#wpbody-content').show();
	// Hide h3 titles
	profileForm.find('h3').hide();
	// Hide personal info form
	profileForm.find('> table').eq(0).hide();
    profileForm.find('> table').eq(0).prev('h2').hide();
    profileForm.find('#display_name').parents('tr').hide();
    profileForm.find('#url').parents('tr').hide();
    profileForm.find('#description').parents('tr').hide();
    profileForm.find('#destroy-sessions').parents('tr').hide();
    profileForm.find('#destroy-sessions').parents('tr').hide();
    profileForm.find('label[for="wplc_ma_agent"]').parents('table').hide();
    profileForm.find('th:contains("Capabilities")').parents('table').hide();
    profileForm.find('th:contains("Capabilities")').parents('table').prev('h2').hide();

    //customer dashboard config
    $(document).foundation();
    //$('#selected_champions').find('img.champion_images').append('<i class="dashicons dashicons-no"></i>');
    $(document).on('click', '#selected_champions .selected_champion_container', function(){
        if($(this).find('img.champion_images').length != undefined)
        {
            var selectedVal = removeValue($('input[name=selected_champions]').val(), $(this).find('img.champion_images').attr('data-id'), ',');
            $('input[name=selected_champions]').val(selectedVal);
            $(this).remove();
        }
    });
    jQuery(document).on('open.zf.reveal', function(){
        if($('input[name=selected_champions]').length > 0)
        {
            var selected = $('input[name=selected_champions]').val().split(',');
            $(selected).each(function(i, val){
                $('#champion'+val).prop('checked', true);
            });
        }
    });
	$('textarea.wp-message-area').on('keypress',function(e){
	    if (e.keyCode == 13 && e.shiftKey === false)
		{
			$(this).parents('form').submit();
		}
	});
});

function removeValue(list, value, separator) {
  separator = separator || ",";
  var values = list.split(separator);
  for(var i = 0 ; i < values.length ; i++) {
    if(values[i] == value) {
      values.splice(i, 1);
      return values.join(separator);
    }
  }
  return list;
}

function saveChampions()
{
    jQuery(function($){
        var selected = [];
        $('#selected_champions').html('');
        $('#prefered_champions_lists input[class=champion_checkbox]:checked').each(function() {
            selected.push($(this).next('label').find('img').attr('data-id'));
            $('#selected_champions').append('<div class="selected_champion_container">'+$(this).next('label').html()+'<i class="dashicons dashicons-no"></i></div>');
        });
        $('#selected_champions').append('<input type="hidden" name="selected_champions" value="'+selected+'">');
    });
}

function paginateMatches(pageNum)
{
	jQuery(function($){
		$('.matches_pagination li').each(function(){
			$(this).removeClass('current');
		});

		$('.match-history tr.matches_tr').each(function(){
			$(this).hide();
		});

		$('.matches_pagination li:nth-of-type('+pageNum+')').addClass('current');
		for(var i=((pageNum-1)*5+1); i<=(pageNum*5);i++){
			$('.match-history tr.matches_tr.match_id_'+i).show();
		}
	});
}

function hideNewOrderAlert(user_id)
{
	jQuery(function($){
		var dataArr = {
		   'action': 'hide_new_order_alert',
		   'user_recipient': user_id,
		};
		$.ajax({
			url: ajaxurl,  //server script to process data
			type: 'POST',
			data: dataArr,
			dataType: "html",
			success: function(response) {
				console.log(response);
			}
		});
	});
}

// ajax Functions
jQuery(function($){
	$('form[name=send_message]').on('submit', function(e){
		var form_elem = $(this).attr('id');
		jQuery('#'+form_elem).find('input[type=submit]').attr('disabled',true);
		var loaderElem = jQuery('#'+form_elem).find('.status_loader');
		jQuery(loaderElem).html('<img src="<?php echo get_template_directory_uri();?>/assets/img/loading.gif"/>').show();
		e.preventDefault();
		var dataArr = {
	 	   'action': 'send_message',
	 	   'message': $('#'+form_elem).find('textarea.wp-message-area').val(),
		   'user_recipient': $('#'+form_elem).find('input[name=user_recipient]').val(),
		   'post_id': $('#'+form_elem).find('input[name=order_in_progress]').val()
	    };
		$.ajax({
			url: ajaxurl,  //server script to process data
			type: 'POST',
			data: dataArr,
			dataType: "html",
			success: function(response) {
				var responseArr = response.split(';-;');
				if(responseArr[1]=='error')
					jQuery(loaderElem).html('Error: couldn\'t send message!');
				else{
					jQuery(loaderElem).html('');
					var contentFill = $('#'+form_elem).parents('.tabs-panel').find('.message-history > ul.message-list');
					jQuery('#'+form_elem).find('input[type=submit]').attr('disabled', false);
					var texts = '<li class="message-me"><div class="message-head"><h4>You</h4><span>Just Now</span></div><div class="message-content">'+responseArr[2]+'</div></li>';
					$(contentFill).append(texts);
					$('#'+form_elem).find('textarea[class="wp-message-area"]').val('');
					$(document).find('#'+form_elem).parents('.tabs-panel').find('.message-history > ul.message-list').scrollTop($(contentFill).prop("scrollHeight"));
				}
			}
		});
	});
});
