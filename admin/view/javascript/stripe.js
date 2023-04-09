//==============================================================================
// Stripe Payment Gateway v303.16
// 
// Author: Clear Thinking, LLC
// E-mail: johnathan@getclearthinking.com
// Website: http://www.getclearthinking.com
// 
// All code within this file is copyright Clear Thinking, LLC.
// You may not copy or reuse code within this file without written permission.
//==============================================================================

function getQueryVariable(variable) {
	var vars = window.location.search.substring(1).split('&');
	for (i = 0; i < vars.length; i++) {
		var pair = vars[i].split('=');
		if (pair[0] == variable) return pair[1];
	}
	return false;
}

function stripeCapture(element, charge_amount, payment_intent_id) {
	var token = getQueryVariable('token');
	token = (token) ? '&token=' + token : '&user_token=' + getQueryVariable('user_token');
	
	amount = prompt('Enter the amount to capture:', charge_amount.toFixed(2));
	
	if (amount != null && amount > 0) {
		element.after('<span id="please-wait" style="font-size: 11px"> Please wait...</span>');
		$.get('index.php?route=extension/payment/stripe/capture&payment_intent_id=' + payment_intent_id + '&amount=' + amount + token,
			function(error) {
				$('#please-wait').remove();
				if (error) {
					alert(error);
				}
				if (!error || error.indexOf('has already been captured') != -1) {
					element.prev().html('Yes (' + parseFloat(amount).toFixed(2) + ' captured)');
					element.remove();
				}
			}
		);
	}
}

function stripeRefund(element, charge_amount, charge_id) {
	var token = getQueryVariable('token');
	token = (token) ? '&token=' + token : '&user_token=' + getQueryVariable('user_token');
	
	amount = prompt('Enter the amount to refund:', charge_amount.toFixed(2));
	
	if (amount != null && amount > 0) {
		element.after('<span id="please-wait" style="font-size: 11px"> Please wait...</span>');
		$.get('index.php?route=extension/payment/stripe/refund&charge_id=' + charge_id + '&amount=' + amount + token,
			function(error) {
				if (error) {
					alert(error);
					$('#please-wait').remove();
				} else {
					alert('Success!');
					setTimeout(function(){
						$('#history').load('index.php?route=sale/order/history&order_id=' + getQueryVariable('order_id') + token);
						$('#please-wait').remove();
					}, 2000);
				}
			}
		);
	}
}