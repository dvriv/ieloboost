var $ = jQuery.noConflict();




// Smooth Scroll

$(function() {
  $('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 500);
        return false;
      }
    }
  });
});

// Login-Signup Modal
$(window, document, undefined).ready(function() {

  // Show Old Pricing with Discount





  // Show overlay & Open Login Modal

  $( ".modal-overlay" ).click(function() {
    $(this).fadeOut(200);
  });
  $( ".login" ).click(function() {
    $(".login-modal-overlay").fadeIn(200);
  });
  $( ".login-close" ).click(function() {
    $(".login-modal-overlay").fadeOut(200);
  });
  $(".login-modal").click(function(event) {
    event.stopPropagation();
  });


  // Input label


  $(document).on('blur', 'input',function() {
    var $this = $(this);
    if ($this.val())
      $this.addClass('used');
    else
      $this.removeClass('used');
  });

  $(document).on('change', 'input',function() {
    var $this = $(this);
    if ($this.val())
      $this.addClass('used');
    else
      $this.removeClass('used');
  });

  $(document).on('bind', 'input',function() {
    var $this = $(this);
    if ($this.val())
      $this.addClass('used');
    else
      $this.removeClass('used');
  });

});

// Changing data after clicking login/signup/forgotpassword

var signupTitle = "<h2>Enter your email and create a password to get started!</h2>"
var loginTitle = "<h2>To continue to the Dashboard, please enter your credentials below</h2>"
var forgotPassword = "<h2>Enter the email address you used and we’ll send you instructions to reset your password</h2>"

function loginClick() {
  $(".login_form").hide('slow');
  $("#login_form").show('slow');
  $(".login-link").addClass("active");
  $(".signup-link").removeClass("active");
  $(".error").detach();

}

function signupClick() {
  $(".login_form").hide('slow');
  $("#register_customer_form").show('slow');
  $(".signup-link").addClass("active");
  $(".login-link").removeClass("active");
  $(".error").detach();

}

function forgotPass() {
  $(".login_form").hide('slow');
  $("#forgot_password_form").show('slow');
  $(".signup-link").removeClass("active");
  $(".login-link").removeClass("active");
  $(".error").detach();

}

$(".signup-link").click(function() {
      signupClick();
});

$(".login-link").click(function() {
      loginClick();
});

$(".fgt-password").click(function() {
      forgotPass();
});

// Login Success and Errors
// Will be called later in the ajax section
var loginSuccessDiv = '<div class="successContainer"><img class="success-img" src="./wp-content/themes/leagueboost/assets/img/checked.svg" width="150px" /> <span>Redirecting to dashboard...</span> </div>'
var registerSuccessDiv = '<div class="successContainer"><img class="success-img" src="./wp-content/themes/leagueboost/assets/img/email.svg" width="150px" /> <span>Confirm your email by clicking the verification link we just sent to your inbox.</span> </div>'
var errorLoginMsg = '<span class="error">Invalid username/password</span>'
var successReset = '<span class="error passSent">If the email you specified exists in our system, we&apos;ve sent a password reset link to it</span>'
var emailRegisterErrorMsg = '<span class="error">Unable to create account: That email address is already in use</span>'
var usernameRegisterErrorMsg = '<span class="error">Unable to create account: That username is already in use</span>'
var emailActivationMsg = '<div class="emailActivationContainer"> </div>'

function loginSuccess() {
  $(".login-container").slideUp("300", function () {
    loginSuccessDiv = $(loginSuccessDiv).hide();
    $(this).replaceWith(loginSuccessDiv);
    $(".successContainer").slideDown("300");
  })
}

function registerSuccess() {
  $(".login-container").slideUp("300", function () {
    registerSuccessDiv = $(registerSuccessDiv).hide();
    $(this).replaceWith(registerSuccessDiv);
    $(".successContainer").slideDown("300");
  })
}

function loginError() {
  $(".error").detach();
  $(errorLoginMsg).insertBefore('#login_form');
  $(".errorMsg").replaceWith('<span class="errorMsg">Invalid username/password</span>')
}
function passwordSent() {
  $(".error").detach();
  $(successReset).insertBefore('#forgot_password_form')
}

function emailRegisterError() {
  $(".error").detach();
  $(emailRegisterErrorMsg).insertBefore('#register_customer_form')
  $(".errorMsg").replaceWith('<span class="errorMsg">Unable to create account: That email is already in use</span>')
}

function usernameRegisterError() {
  $(".error").detach();
  $(usernameRegisterErrorMsg).insertBefore('#register_customer_form')
  $(".errorMsg").replaceWith('<span class="errorMsg">Unable to create account: That username is already in use</span>')

}


/* Switch Javascript */
'use strict';

var switchButton 			= document.querySelector('.switch-button');
var switchBtnRight 			= document.querySelector('.switch-button-case.right');
var switchBtnLeft 			= document.querySelector('.switch-button-case.left');
var activeSwitch 			= document.querySelector('.active');

var sNetP = "<p>We will play the amout of positive wins you desire</p>"
var sDivisionsP = "<p>Choose a Desired League and we will play on your account until we reach it</p>"
var sPlacementsP = "<p>We will play your placement matches ensuring at least 7 out of 10 wins</p>"
var sNormalsP = "<p>We will play the desired number of normal matches</p>"

var sNetH = "<h4>SOLO NET WINS</h4>"
var sDivisionsH = "<h4>SOLO DIVISIONS</h4>"
var sPlacementsH = "<h4>SOLO PLACEMENTS</h4>"
var sNormalsH = "<h4>SOLO NORMAL GAMES</h4>"

var gNetP = "<p>We will play with you the amout of positive wins you desire</p>"
var gDivisionsP = "<p>Choose a Desired League and we will play with you in Duo Queue</p>"
var gPlacementsP = "<p>We will play with you in your placement matches ensuring at least 7 out of 10 wins</p>"
var gGamesP = "<p>Play ranked games with the booster without a guaranteed number of wins</p>"

var gNetH = "<h4>DUO NET WINS</h4>"
var gDivisionsH = "<h4>DUO DIVISIONS</h4>"
var gPlacementsH = "<h4>DUO PLACEMENTS</h4>"
var gGamesH = "<h4>DUO GAMES</h4>"

var sNetB = '<a class="btn-choose" href="/solo-net-wins">Purchase</a>'
var sDivisionsB = '<a class="btn-choose" href="/solo-divisions">Purchase</a>'
var sPlacementsB = '<a class="btn-choose" href="/solo-placements">Purchase</a>'
var sNormalsB = '<a class="btn-choose" href="/solo-normal-games">Purchase</a>'

var gNetB = '<a class="btn-choose" href="/group-net-wins">Purchase</a>'
var gDivisionsB = '<a class="btn-choose" href="/group-divisions">Purchase</a>'
var gPlacementsB = '<a class="btn-choose" href="/group-placements">Purchase</a>'
var gGamesB = '<a class="btn-choose" href="/group-games">Purchase</a>'

var soloBoost = '<span class="boost-mode">You are viewing our Solo Boost options. On this mode the booster will log in to your account to complete the boost order</span>'
var groupBoost = '<span class="boost-mode">You are viewing our Duo Boost options. On this mode, the booster will Duo Queue with you in a smurf account to complete the order.</span>'

function switchLeft(){
	switchBtnRight.classList.remove('active-case');
	switchBtnLeft.classList.add('active-case');
	activeSwitch.style.left 						= '0%';

	$(".bNet").find("h4").replaceWith(sNetH);
	$(".bDivision").find("h4").replaceWith(sDivisionsH);
	$(".bPlacements").find("h4").replaceWith(sPlacementsH);
	$(".bGames-Wins").find("h4").replaceWith(sNormalsH);

	$(".bNet").find("p").replaceWith(sNetP);
	$(".bDivision").find("p").replaceWith(sDivisionsP);
	$(".bPlacements").find("p").replaceWith(sPlacementsP);
	$(".bGames-Wins").find("p").replaceWith(sNormalsP);

	$(".bNet").find("a").replaceWith(sNetB);
	$(".bDivisions").find("a").replaceWith(sDivisionsB);
	$(".bPlacements").find("a").replaceWith(sPlacementsB);
	$(".bGames-Wins").find("a").replaceWith(sNormalsB);

	$('.boost-mode').replaceWith(soloBoost);

}

function switchRight(){
	switchBtnRight.classList.add('active-case');
	switchBtnLeft.classList.remove('active-case');
	activeSwitch.style.left 						= '50%';
	$(".bNet").find("h4").replaceWith(gNetH);
	$(".bDivision").find("h4").replaceWith(gDivisionsH);
	$(".bPlacements").find("h4").replaceWith(gPlacementsH);
	$(".bGames-Wins").find("h4").replaceWith(gGamesH);

	$(".bNet").find("p").replaceWith(gNetP);
	$(".bDivision").find("p").replaceWith(gDivisionsP);
	$(".bPlacements").find("p").replaceWith(gPlacementsP);
	$(".bGames-Wins").find("p").replaceWith(gGamesP);

	$(".bNet").find("a").replaceWith(gNetB);
	$(".bDivision").find("a").replaceWith(gDivisionsB);
	$(".bPlacements").find("a").replaceWith(gPlacementsB);
	$(".bGames-Wins").find("a").replaceWith(gGamesB);

	$('.boost-mode').replaceWith(groupBoost);

}


if ( switchButton ) {

switchBtnLeft.addEventListener('click', function(){
	switchLeft();
}, false);

switchBtnRight.addEventListener('click', function(){
	switchRight();
}, false);

};

/* Menu Clip */
/*var menuClip = [[0, 0], [100, 0], [95, 100], [5, 100]];
var fVpn = [[0, 0], [100, 0], [100, 86], [0, 100]];
   $('#topheader').clipPath(menuClip, {
       isPercentage: true,
       svgDefId: 'menuclip'
   });*/



$(document).ready(function(){

// Mobile Menu

// menu click event
$('.toggle').click(function() {
  $(this).toggleClass('act');
    if($(this).hasClass('act')) {
      $('.mobile-menu').addClass('act');
    }
    else {
      $('.mobile-menu').removeClass('act');
    }
});

//Zurb foundation dependencies.

	$(document).foundation();
  updateBoostingImage('to');
  updateBoostingImage('from');
  sliderUpdate('net-wins');
  sliderUpdate('unranked');
  sliderUpdate('general-wins');
  coachingUpdate('hourly-coaching');
  coachingUpdate('games-coaching');
/** ===========================================
    Hide / show the master navigation menu
============================================ */

  // console.log('Window Height is: ' + $(window).height());
  // console.log('Document Height is: ' + $(document).height());

  var previousScroll = 0;

  $(window).scroll(function(){

    var currentScroll = $(this).scrollTop();

    /*
      If the current scroll position is greater than 0 (the top) AND the current scroll position is less than the document height minus the window height (the bottom) run the navigation if/else statement.
    */
    if (currentScroll > 0 && currentScroll < $(document).height() - $(window).height()){
      /*
        If the current scroll is greater than the previous scroll (i.e we're scrolling down the page), hide the nav.
      */
      if (currentScroll > previousScroll){
        window.setTimeout(hideNav, 300);
      /*
        Else we are scrolling up (i.e the previous scroll is greater than the current scroll), so show the nav.
      */
      } else {
        window.setTimeout(showNav, 300);
      }
      /*
        Set the previous scroll value equal to the current scroll.
      */
      previousScroll = currentScroll;
    }

  });

	function hideNav() {
		$("#topheader").removeClass("visible").addClass("hidden");
	}
	function showNav() {
		$("#topheader").removeClass("hidden").addClass("visible");
	}

});


//*




function sliderUpdate(elem)
{
    if($('#'+elem+'_slider').length)
    {
        setInterval(function(){
            $('#'+elem+'_slider').parents('.desiredColumns').find('#'+elem+'_stat').html($('#'+elem+'_slider').find('input[type=hidden]').val());
            updateBoostingImage('to');
        }, 100);
    }
}

function coachingUpdate(elem)
{
    if($('#'+elem+'_slider').length)
    {
        setInterval(function(){
            $('#'+elem+'_slider').parents('.desiredColumns').find('#'+elem+'_stat').html($('#'+elem+'_slider').find('input[type=hidden]').val());
            $('form.'+elem+'_form').find('[type=submit]').attr('disabled',false);
            var form_type = $('form.'+elem+'_form').find('input[name=type]').attr('value');
            var form_action = $('form.'+elem+'_form').find('input[name=action]').attr('value');
            var coaching = $('#'+elem+'_sliderValue').val();
            var form_type_index = '';

            if(form_type == 'hourly')
            {
                form_type_index = '1';
                service_name = 'Hourly Coaching for '+coaching+' hours';
            }
            else if(form_type == 'games')
            {
                form_type_index = '2';
                service_name = 'Games Coaching for '+coaching+' wins';
            }

            var data = 'false';
            data = coachingPrices[eval(form_type_index.toString())] * coaching;
            if (data != undefined ) {
                $('#'+elem+'_final_price').html(data.toFixed(2));
                $('form.'+elem+'_form').find('input[name=PAYMENTREQUEST_0_ITEMAMT]').attr('value', data.toFixed(2));
                $('form.'+elem+'_form').find('input[name=L_PAYMENTREQUEST_0_NAME0]').attr('value', service_name);
                var old_price = $("#final_price").html() / .75;
                $("#old_price").html(Math.round(old_price));
            }
            else {
                $('form.'+elem+'_form').find('[type=submit]').attr('disabled',true);
            }
        }, 100);
    }
}
function updateBoostingImage(type)
{
    var fromLeague = $('#from_league').val();
    var fromDivision = $('#from_division').val();
    var toLeague = $('#to_league').val();
    var toDivision = $('#to_division').val();
    if(parseInt(toLeague) == 6) {
        toDivision = 1;
        $('#to_division').val(1);
        $('#to_division').parents('fieldset').hide();
    }
    else {
        $('#to_division').parents('fieldset').show();
    }
    $('#'+type+'-image').attr('src', globalObject.templateUri+'/assets/img/divisions/'+$('#'+type+'_league').val()+'_'+$('#'+type+'_division').val()+'.png');
    $('form.booster_payement_form').find('[type=submit]').attr('disabled',false);
    var form_type = $('form.booster_payement_form').find('input[name=type]').attr('value');

    var form_action = $('form.booster_payement_form').find('input[name=action]').attr('value');
    if(form_action == 'division')
    {
        if(toLeague < fromLeague || ( toLeague == fromLeague && toDivision <= fromDivision) )
        {
            $('form.booster_payement_form').find('[type=submit]').attr('disabled',true);
            $('.error_display').removeClass('hide');
        }else{
            $('form.booster_payement_form').find('[type=submit]').attr('disabled',false);
            if(!$('.error_display').hasClass('hide'))
                $('.error_display').addClass('hide');

            var data = 0,
                arrLists = [],
                i = fromLeague,
                j = fromDivision;
            do
            {
                if(i != toLeague)
                {
                    for (j; j < 5; j++)
                    {
                        arrLists.push(i.toString()+j.toString()+i.toString()+(parseInt(j)+1).toString()+form_type.toString());
                    }
                    if(j==5)
                    {
                        arrLists.push(i.toString()+j.toString()+(parseInt(i)+1).toString()+(1).toString()+form_type.toString());
                        j=1; i++;
                    }
                }
                if(i == toLeague)
                {
                    for (j; j < toDivision; j++)
                    {
                        arrLists.push(i.toString()+j.toString()+i.toString()+(parseInt(j)+1).toString()+form_type.toString());
                    }
                }
            }
            while(i != toLeague)

            $.each(arrLists, function(i, val){
                var sum = divisionPrices[eval(val)];
                if(sum != undefined)
                    data += sum;
            });
            var lPoints = parseInt($('#league_points').val());
            if(lPoints && data)
            {
                if(lPoints <= 20)
                    var index = "0-20";
                else if(lPoints <= 40)
                    var index = "20-40";
                else if(lPoints <= 60)
                    var index = "40-60";
                else if(lPoints <= 80)
                    var index = "60-80";
                else if(lPoints <= 100)
                    var index = "80-100";
                data -= divisionPrices[eval(arrLists[0])] * ( pointsPrices[index] / 100 );
            }
            if (data && data != undefined ) {
                $('#final_price').html(data.toFixed(2));
                $('form.booster_payement_form').find('input[name=PAYMENTREQUEST_0_ITEMAMT]').attr('value', data.toFixed(2));
                $('form.booster_payement_form').find('input[name=L_PAYMENTREQUEST_0_NAME0]').attr('value', resolveType[form_type]+' Boost from '+resolveLeagues[fromLeague]+' '+resolveDivisions[fromDivision]+' to ' +resolveLeagues[toLeague]+' '+resolveDivisions[toDivision]);
                var old_price = $("#final_price").html() / .75;
                $("#old_price").html(Math.round(old_price));
            }
            else {
                $('form.booster_payement_form').find('[type=submit]').attr('disabled',true);
            }
        }

        if(document.getElementById('to_league').value < "4") {
          $(".old_price_container").show();
          $(".discount").show();
        }
        else {
          $(".old_price_container").hide();
          $(".discount").hide();
        }

    }
    if(form_action == 'net-wins')
    {
        var data = 'false';
        var nWins = $('#net-wins_sliderValue').val();
        data = netWinPrices[eval(fromDivision.toString() + fromLeague.toString() + form_type.toString())] * nWins;
        if (data != undefined ) {
            $('#final_price').html(data.toFixed(2));
            $('form.booster_payement_form').find('input[name=PAYMENTREQUEST_0_ITEMAMT]').attr('value', data.toFixed(2));
            $('form.booster_payement_form').find('input[name=L_PAYMENTREQUEST_0_NAME0]').attr('value', resolveType[form_type]+' Boost '+resolveLeagues[fromLeague]+' '+resolveDivisions[fromDivision]+' for ' +nWins+' net wins');
            var old_price = $("#final_price").html() / .75;
            $("#old_price").html(Math.round(old_price));
        }
        else {
            $('form.booster_payement_form').find('[type=submit]').attr('disabled',true);
        }

        if(document.getElementById('from_league').value < "4") {
          $(".old_price_container").show();
          $(".discount").show();
        }
        else {
          $(".old_price_container").hide();
          $(".discount").hide();
        }
    }
    if(form_action == 'unranked')
    {
        var data = 'false';
        var unranked = $('#unranked_sliderValue').val();
        data = unrankedPrices[fromLeague.toString() + form_type.toString()] * unranked;
        if (data != undefined ) {
            $('#final_price').html(data.toFixed(2));
            $('form.booster_payement_form').find('input[name=PAYMENTREQUEST_0_ITEMAMT]').attr('value', data.toFixed(2));
            $('form.booster_payement_form').find('input[name=L_PAYMENTREQUEST_0_NAME0]').attr('value', resolveType[form_type]+' Boost '+resolveLeagues[fromLeague]+' for ' +unranked+' unranked games');
            var old_price = $("#final_price").html() / .90;
            $("#old_price").html(Math.round(old_price));
        }
        else {
            $('form.booster_payement_form').hide();
        }
    }
    if(form_action == 'general-wins')
    {
        var data = 'false';
        var generalWins = $('#general-wins_sliderValue').val();
        // data = generalWinPrices[eval(form_type.toString())] * generalWins;
        if (form_type == 2) {
          data = generalWinPrices[eval(fromDivision.toString() + fromLeague.toString() + form_type.toString())] * generalWins;
        }
        else {
          data = generalWinPrices[eval(form_type.toString())] * generalWins;
        }


        if (data != undefined ) {
            $('#final_price').html(data.toFixed(2));
            $('form.booster_payement_form').find('input[name=PAYMENTREQUEST_0_ITEMAMT]').attr('value', data.toFixed(2));
            $('form.booster_payement_form').find('input[name=L_PAYMENTREQUEST_0_NAME0]').attr('value', resolveType[form_type]+' Boost for ' +generalWins+' game Wins');
            var old_price = $("#final_price").html() / .75;
            $("#old_price").html(Math.round(old_price));
        }
        else {
            $('form.booster_payement_form').find('[type=submit]').attr('disabled',true);
        }
    }

}

//Ajax Functions
jQuery(function($){
  jQuery('#register_customer_form, #register_booster_form, #login_form, #custom_login_form, #custom_register_form' ).on('submit', function(e){
	 var form_id = $(this).attr('id');
	 jQuery('#'+form_id).find('input[type=submit]').attr('disabled',true);
	//jQuery('#'+form_id).find('.status_loader').html('<img src="'+globalObject.templateUri+'/assets/img/loading.gif"/>').show();
	 e.preventDefault();

     var customLoginRegister = $(this).find('input[name=custom_login_register]').val();
     if(customLoginRegister)
     {
        var dataArr = {
			'action': form_id.replace('_form', '_action'),
			'username': $(this).find('input[name=c_username]').val(),
			'email_address': $(this).find('input[name=c_email_address]').val(),
			'password': $(this).find('input[name=c_password]').val(),
            'password1': $(this).find('input[name=custom_password1]').val(),
            'register_for': 'customer',
            'lol_account_name': $(this).find('input[name=lol_account_name]').val()
		};
        $(this).find('input[type=hidden]').each(function(){
            dataArr[$(this).attr('name')] = $(this).attr('value');
        });
     }else
     {
         var registerFor = $(this).find('input[name=register_for]').val();
         var password1 = '';
         if(registerFor == 'booster')
         {
             password1 = $(this).find('input[name=booster_password1]').val();
         }else if(registerFor == 'customer')
         {
             password1 = $(this).find('input[name=customer_password1]').val();
         }
        var dataArr = {
			'action': form_id.replace('_form', '_action'),
			'username': $(this).find('input[name=username]').val(),
			'email_address': $(this).find('input[name=email_address]').val(),
			'password': $(this).find('input[name=password]').val(),
            'password1': password1,
            'register_for': registerFor,
            'lol_username': $(this).find('input[name=lol_username]').val()
		};
    }
		$.ajax({
			url: globalObject.ajaxUrl,  //server script to process data
			method: "POST",
			data: dataArr,
			dataType: "json",
			success: function(response) {
				console.log(response);
				if(response.result == 'login_success'){
					loginSuccess();
                    if(response.redirectto != undefined){
                        window.setTimeout(function() {   //calls click event after a certain time
                           window.location.href = response.redirectto;
                       }, 1000);
                    }
                    // if(response.modal != undefined){
                        //var $activationRequiredModal = new Foundation.Reveal($('#'+response.modal));
				        //$activationRequiredModal.show();
                // console.log(response);
                //         console.log($('#'+form_id).parents('.reveal').attr('id'));
                //         $('#'+form_id)[0].reset();
                //         $('#'+$('#'+form_id).parents('.reveal').attr('id')).foundation('close');
                //         $('#'+response.modal).foundation('open');
                //     }


				}
        else if (response.result=='success_activation_required') {
          registerSuccess();
        }

        else if(response.result=='login_error'){
					// jQuery('#'+form_id).find('.status_loader').addClass('error').html(response.msg).show().delay(4000).fadeOut(400);
          loginError();
				}else if(response.result=='login_verify_error'){

				} else if (response.result=='register_username_error') {
          usernameRegisterError();
        } else if (response.result == "register_email_error") {
          emailRegisterError();
        }
	 			jQuery('#'+form_id).find('input[type=submit]').attr('disabled',false);
			}
		});
  });

    jQuery('#forgot_password_form').on('submit', function(e){
  	 var form_id = $(this).attr('id');
  	 jQuery('#'+form_id).find('input[type=submit]').attr('disabled',true);
  	//  var loaderElem =  jQuery('#'+form_id).find('.status_loader');
  	//  jQuery(loaderElem).html('<img src="'+globalObject.templateUri+'/assets/img/loading.gif"/>').show();
  	 e.preventDefault();

       var dataArr = {
  			'action': 'forgot_password_action',
        'lost_email_address': $(this).find('input[name=email_address]').val()
  		};
  		$.ajax({
  			url: globalObject.ajaxUrl,  //server script to process data
  			type: 'POST',
  			data: dataArr,
  			dataType: "json",
  			success: function(response) {
  				console.log(response);
  				// jQuery(loaderElem).html('');
  				jQuery('#'+form_id).find('input[type=submit]').attr('disabled',false);
  				if(response.result == 'success_password_sent'){
            passwordSent();

  				}else if(response.result=='error_password_sent'){
            passwordSent();
  				}
  			}
  		});
    });

  $(document).on('click','.resend-activation', function(e){
	 var form_id = 'resend-activation';
	//  var loaderElem = jQuery(this).parents('div').find('.status_loader');
	//  jQuery(loaderElem).html('<img src="'+globalObject.templateUri+'/assets/img/loading.gif"/>').show();
	 e.preventDefault();

     var dataArr = {
			'action': 'resend_activation_action',
			'user_id': $('#'+form_id).find('input[name=user_id]').val()
		};
		$.ajax({
			url: globalObject.ajaxUrl,  //server script to process data
			type: 'POST',
			data: dataArr,
			dataType: "json",
			success: function(response) {
				console.log(response);
				// jQuery(loaderElem).html('');
				if(response.result == 'success_activation_sent'){
					// jQuery(loaderElem).addClass('error').html(response.msg).show().queue(function() {
					// 	$(this).delay(4000).fadeOut(400);
					// 	$(this).dequeue();
					// });
          //
          registerSuccess();
				}
			}
		});
  });
});
