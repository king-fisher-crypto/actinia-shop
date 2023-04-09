<?php
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

$version = 'v303.16';

//------------------------------------------------------------------------------
// Heading
//------------------------------------------------------------------------------
$_['heading_title']						= 'Stripe Payment Gateway';
$_['text_stripe']						= '<a target="blank" href="https://dashboard.stripe.com"><img src="https://stripe.com/img/logo.png" alt="Stripe" title="Stripe" /></a>';

//------------------------------------------------------------------------------
// Extension Settings
//------------------------------------------------------------------------------
$_['tab_extension_settings']			= 'Extension Settings';
$_['heading_extension_settings']		= 'Extension Settings';

$_['entry_status']						= 'Status: <div class="help-text">Set the status for the extension as a whole.</div>';
$_['entry_sort_order']					= 'Sort Order: <div class="help-text">Enter the sort order for the extension, relative to other payment methods.</div>';
$_['entry_title']						= 'Title: <div class="help-text">Enter the title for the payment method displayed to the customer in the Payment Method area of checkout. HTML is supported.</div>';
$_['entry_terms']						= 'Terms: <div class="help-text">Optionally enter some payment terms that will display next to the title in ( and ) brackets. HTML is supported. This setting does not work on OpenCart 1.5.x.</div>';
$_['entry_card_input_format']			= 'Card Input Format: <div class="help-text">Choose whether to use a single combined field for the card inputs, or separate fields.</div>';
$_['text_combined']						= 'Combined';
$_['text_individual']					= 'Individual';
$_['entry_button_text']					= 'Button Text: <div class="help-text">Enter the text for the order confirmation button.</div>';
$_['entry_button_class']				= 'Button Class: <div class="help-text">Enter the CSS class for buttons in your theme.</div>';
$_['entry_button_styling']				= 'Button Styling: <div class="help-text">Optionally enter extra CSS styling for the button.</div>';
$_['entry_additional_css']				= 'Additional CSS: <div class="help-text">Add any additional CSS styling here. If your CSS does not seem to be applying, try adding <code>!important</code> at the end of the declarations, to override any other CSS styling.</div>';

// Payment Page Text
$_['heading_payment_page_text']			= 'Payment Page Text';
$_['entry_text_use_a_new_card']			= 'Use a New Card: <div class="help-text">HTML is supported.</div>';
$_['entry_new_card_image']				= 'New Card Image: <div class="help-text">Optionally enter an &lt;img&gt; tag for an icon that shows up to the left of the "Use a New Card" text. A default image (encoded as base64 code) is included.</div>';
$_['entry_text_card_number']			= 'Card Number: <div class="help-text">This is only used if using individual card inputs. HTML is supported.</div>';
$_['entry_text_card_expiry']			= 'Card Expiry: <div class="help-text">This is only used if using individual card inputs. HTML is supported.</div>';
$_['entry_text_card_cvc']				= 'Card CVC: <div class="help-text">This is only used if using individual card inputs. HTML is supported.</div>';
$_['entry_text_store_card']				= 'Store Card for Future Use: <div class="help-text">HTML is supported.</div>';
$_['entry_text_use_a_stored_card']		= 'Use Your Stored Card: <div class="help-text">HTML is supported.</div>';
$_['entry_stored_card_image']			= 'Stored Card Image: <div class="help-text">Optionally enter an &lt;img&gt; tag for an icon that shows up to the left of the "Use a Stored Card" text. A default image (encoded as base64 code) is included.</div>';
$_['entry_text_ending_in']				= 'ending in: <div class="help-text">HTML is supported. Used for stored cards, such as "Visa ending in 4242"</div>';
$_['entry_text_set_card_as_default']	= 'Set Card as Default: <div class="help-text">HTML is supported.</div>';
$_['entry_text_delete_this_card']		= 'Delete This Card: <div class="help-text">HTML is supported.</div>';
$_['entry_text_customer_required']		= 'Customer Required: <div class="help-text">Enter the text displayed when a non-logged-in customer (i.e. a guest) tries to check out with a subscription product in their cart. This will only be shown if the "Prevent Guests From Purchasing" setting is enabled.</div>';
$_['entry_text_to_be_charged']			= 'To Be Charged Later: <div class="help-text">This text is displayed for the line item on the order invoice when a subscription product has a trial. The line item subtracts the subscription price out of the total, so the customer is not double-charged.</div>';

// Please Wait Messages
$_['heading_please_wait_messages']		= 'Please Wait Messages';
$_['entry_text_please_wait']			= 'Default Please Wait: <div class="help-text">HTML is supported.</div>';
$_['entry_text_validating_payment_info']= 'Validating Payment Info: <div class="help-text">HTML is supported.</div>';
$_['entry_text_redirecting_to_payment']	= 'Redirecting to Payment Page: <div class="help-text">HTML is supported.</div>';
$_['entry_text_processing_payment']		= 'Processing Payment: <div class="help-text">HTML is supported.</div>';
$_['entry_text_finalizing_order']		= 'Finalizing Order: <div class="help-text">HTML is supported.</div>';

// Stripe Error Codes
$_['heading_stripe_error_codes']		= 'Stripe Error Codes';
$_['help_stripe_error_codes']			= 'HTML is supported. Leave any of these fields blank to display Stripe\'s default error message for that error code.';

$_['entry_error_card_declined']			= 'card_declined:';
$_['entry_error_expired_card']			= 'expired_card:';
$_['entry_error_incorrect_cvc']			= 'incorrect_cvc: <div class="help-text">This only occurs if your Stripe account is set to deny payments that fail CVC validation.</div>';
$_['entry_error_incorrect_number']		= 'incorrect_number:';
$_['entry_error_incorrect_zip']			= 'incorrect_zip: <div class="help-text">This only occurs if your Stripe account is set to deny payments that fail Zip Code validation.</div>';
$_['entry_error_invalid_cvc']			= 'invalid_cvc:';
$_['entry_error_invalid_expiry_month']	= 'invalid_expiry_month:';
$_['entry_error_invalid_expiry_year']	= 'invalid_expiry_year:';
$_['entry_error_invalid_number']		= 'invalid_number:';
$_['entry_error_missing']				= 'missing: <div class="help-text">This occurs when there is no card stored for a customer that is being charged.</div>';
$_['entry_error_processing_error']		= 'processing_error:';

//------------------------------------------------------------------------------
// Order Statuses
//------------------------------------------------------------------------------
$_['tab_order_statuses']				= 'Order Statuses';
$_['heading_order_statuses']			= 'Order Statuses';
$_['help_order_statuses']				= 'Choose the order statuses set when a payment meets each condition. You can refund a payment by using the link provided in the History tab for the order. Note: to actually <b>deny</b> payments that fail CVC or Zip Checks, you need to enable the appropriate setting in your Stripe admin panel.';

$_['entry_success_status_id']			= 'Successful Payment (Captured):';
$_['entry_authorize_status_id']			= 'Successful Payment (Authorized):';
$_['entry_error_status_id']				= 'Order Completion Error: <div class="help-text">This status will apply when the payment is completed successfully, but the order cannot be completed using the normal OpenCart order confirmation functions. This usually happens when you have entered incorrect SMTP settings in System > Settings > Mail, or you have installed modifications that affect customer orders.</div>';
$_['entry_street_status_id']			= 'Street Check Failure:';
$_['entry_zip_status_id']				= 'Zip Check Failure:';
$_['entry_cvc_status_id']				= 'CVC Check Failure:';
$_['entry_refund_status_id']			= 'Fully Refunded Payment:';
$_['entry_partial_status_id']			= 'Partially Refunded Payment:';

$_['text_ignore']						= '--- Ignore ---';

//------------------------------------------------------------------------------
// Restrictions
//------------------------------------------------------------------------------
$_['tab_restrictions']					= 'Restrictions';
$_['heading_restrictions']				= 'Restrictions';
$_['help_restrictions']					= 'Set the required cart total and select the eligible stores, geo zones, and customer groups for this payment method.';

$_['entry_min_total']					= 'Minimum Total: <div class="help-text">Enter the minimum order total that must be reached before this payment method becomes active. Leave blank to have no restriction.</div>';
$_['entry_max_total']					= 'Maximum Total: <div class="help-text">Enter the maximum order total that can be reached before this payment method becomes inactive. Leave blank to have no restriction.</div>';

$_['entry_stores']						= 'Store(s): <div class="help-text">Select the stores that can use this payment method.</div>';

$_['entry_geo_zones']					= 'Geo Zone(s): <div class="help-text">Select the geo zones that can use this payment method. The "Everywhere Else" checkbox applies to any locations not within a geo zone.</div>';
$_['text_everywhere_else']				= '<em>Everywhere Else</em>';

$_['entry_customer_groups']				= 'Customer Group(s): <div class="help-text">Select the customer groups that can use this payment method. The "Guests" checkbox applies to all customers not logged in to an account.</div>';
$_['text_guests']						= '<em>Guests</em>';

// Currency Settings
$_['heading_currency_settings']			= 'Currency Settings';
$_['help_currency_settings']			= 'Select the currencies that Stripe will charge in, based on the order currency. <a target="_blank" href="https://support.stripe.com/questions/which-currencies-does-stripe-support">See which currencies your country supports</a>';
$_['entry_currencies']					= 'When Orders Are In [currency], Charge In:';
$_['text_currency_disabled']			= '--- Disabled ---';

//------------------------------------------------------------------------------
// Stripe Settings
//------------------------------------------------------------------------------
$_['tab_stripe_settings']				= 'Stripe Settings';
$_['help_stripe_settings']				= 'Click "Connect with Stripe" to visit stripe.com and enable the extension to process payments via your Stripe account.';

// Connect with Stripe
$_['heading_connect_with_stripe']		= 'Connect with Stripe';

$_['button_connect_with_stripe']		= 'Connect with Stripe';
$_['entry_connection_status']			= 'Connection Status:';
$_['text_not_connected']				= 'Not Connected';
$_['text_connected']					= 'Connected';

$_['entry_live_publishable_key']		= 'Live Publishable Key:';
$_['entry_live_access_token']			= 'Live Secret Key:';
$_['entry_test_publishable_key']		= 'Test Publishable Key:';
$_['entry_test_access_token']			= 'Test Secret Key:';

// Stripe Settings
$_['heading_stripe_settings']			= 'Stripe Settings';

$_['entry_three_d_secure']				= '<div style="margin: -9px 0 9px">3D Secure:</div>';
$_['text_three_d_secure']				= '3D Secure is always enabled for card payments that are eligible. If you want to disable 3D Secure for some reason, you can disable it in your Stripe account, and in your Radar rules.';

$_['entry_webhook_url']					= 'Webhook URL: <div class="help-text">Copy and paste this URL into your Stripe account, in <a target="_blank" href="https://dashboard.stripe.com/webhooks">Developers > Webhooks</a>. Click "Add Endpoint" and then choose to receive "all events". Any events that my extension does not use will be ignored. You can choose any API version for the webhook URL, it will not affect my extension. The "key" for the URL is based on your store\'s Encryption Key in System > Settings > Server, so if you change that don\'t forget to also update the webhook URL in Stripe.</div>';

$_['entry_transaction_mode']			= 'Transaction Mode: <div class="help-text">Use "Test" to test payments through Stripe. For more info, visit <a href="https://stripe.com/docs/testing" target="_blank">https://stripe.com/docs/testing</a>. Use "Live" when you&apos;re ready to accept payments.</div>';
$_['text_test']							= 'Test';
$_['text_live']							= 'Live';

$_['entry_charge_mode']					= 'Charge Mode: <div class="help-text">Choose whether to authorize payments and manually capture them later, or to capture (i.e. fully charge) payments when orders are placed. For payments that are only Authorized, you can Capture them by using the link provided in the History tab for the order.<br><br>If you choose "Authorize if possibly fraudulent, Capture otherwise" then the extension will authorize the payment if (1) the Stripe Radar result is "review", or (2) Stripe Radar returns a risk level of "highest", or (3) your OpenCart anti-fraud extensions determine that the order might be fraudulent.</div>';
$_['text_authorize']					= 'Authorize';
$_['text_capture']						= 'Capture';
$_['text_fraud_authorize']				= 'Authorize if possibly fraudulent, Capture otherwise';

$_['entry_attempts']					= 'Maximum Number of Allowed Attempts: <div class="help-text">Enter the maximum number of payment attempts customers are allowed to try in one session. This helps prevent fraudsters from running lots of cards through your Stripe account to check if they are valid. Leave this field blank to have no maximum limit.</div>';
$_['entry_attempts_exceeded']			= 'Error When Exceeding Allowed Attempts: <div class="help-text">Enter the error message shown when a customer continues to make payment attempts after exceeding the allowed number of attempts set above.</div>';

$_['entry_transaction_description']		= 'Transaction Description: <div class="help-text">Enter the text sent as the Stripe transaction description. You can use the following shortcodes to enter information about the order: [store], [order_id], [amount], [email], [comment], [products]</div>';

$_['entry_send_customer_data']			= 'Send Customer Data: <div class="help-text">Sending customer data will create a customer in Stripe when an order is processed, based on the email address for the order. The credit card used will be attached to this customer, allowing you to charge them again in the future in Stripe.</div>';
$_['text_never']						= 'Never';
$_['text_customers_choice']				= 'Customer&apos;s choice';
$_['text_always']						= 'Always';

$_['entry_allow_stored_cards']			= 'Allow Customers to Use Stored Cards: <div class="help-text">If set to "Yes", customers that have cards stored in Stripe will be able to use those cards for future purchases in your store, without having to re-enter the information.</div>';
$_['entry_advanced_error_handling']		= 'Advanced Error Handling: <div class="help-text">Enabling this will catch errors that occur outside the extension, and record those into the order history. Quick checkout extensions sometimes have issues with this, so if you encounter problems with payments completing but orders not being confirmed, try disabling this setting.</div>';
$_['entry_always_send_receipts']		= 'Always Send Receipts From Stripe: <div class="help-text">Receipts are normally only sent from Stripe if the customer\'s info is stored in Stripe, and you have enabled receipt sending in your Stripe admin panel. If you set this to "Yes", then a receipt will always be sent to customers from Stripe, no matter what your settings are in the Stripe admin panel.</div>';
$_['entry_uncaptured_emails']			= 'Notify About Uncaptured Payments: <div class="help-text">If you want to notify administrators about any uncaptured payments, enter their e-mail addresses here, separated by commas. The extension will send out an e-mail once a day if any uncaptured transactions are found.</div>';
$_['entry_decline_code_emails']			= 'Notify About "fraudulent" Decline Codes: <div class="help-text">If you want to notify administrators about any declined payments that have the code "fraudulent", enter their e-mail addresses here, separated by commas.</div>';

//------------------------------------------------------------------------------
// Subscription Products
//------------------------------------------------------------------------------
$_['tab_subscription_products']			= 'Subscription Products';
$_['help_subscription_products']		= '
<ul>
	<li>Subscription products will subscribe the customer to the associated Stripe pricing plan when they are purchased. You can associate a product with a pricing plan by entering the Stripe <b>Pricing Plan ID</b> (not the Product ID) in the "Location" field for the product.</li><br>
	<li>If the subscription is not set to be charged immediately (i.e. it has a trial period), the amount of the subscription will be taken off their original order, and a new order will be created when the subscription is actually charged to their card.</li><br>
	<li>Any time Stripe charges the subscription in the future, a corresponding order will be created in OpenCart. You can choose whether the order uses the customer\'s default address in OpenCart or the customer\'s address in Stripe below.</li><br>
	<li>If you have a coupon set up in your Stripe account, you can map an OpenCart coupon to it by using the same coupon code and discount amount. Use the OpenCart coupon code for the <b>coupon ID</b> when creating the coupon in Stripe. When a customer purchases a subscription product and uses that coupon code, it will pass the code to Stripe to properly adjust the subscription charge.</li><br>
	<li class="text-danger">Subscriptions made with cards using 3D Secure will require the customer to return to Stripe in order to validate their payment info when the card is charged in the future. Make sure you have set up e-mails with a "Stripe-hosted link" to go out to customers, as described <a target="_blank" href="https://stripe.com/docs/billing/migration/strong-customer-authentication#3ds-payment-settings">on this page</a>.</li>
</ul>	
';

// Subscription Product Settings
$_['heading_subscription_products']		= 'Subscription Product Settings';
$_['entry_subscriptions']				= 'Enable Subscription Products:';

$_['entry_subscription_order_report']	= 'Subscription Order Report: <div class="help-text">This will display a list of all orders that were placed for subscription products.</div>';
$_['button_view_report']				= 'View Report';
$_['heading_subscription_order_report']	= 'Subscription Order Report';
$_['column_order_id']					= 'Order ID';
$_['column_customer']					= 'Customer';
$_['column_status']						= 'Status';
$_['column_total']						= 'Total';
$_['column_date_added']					= 'Date Added';
$_['column_date_modified']				= 'Date Modified';
$_['column_action']						= 'Action';

$_['entry_prevent_guests']				= 'Prevent Guests From Purchasing: <div class="help-text">If set to "Yes", only customers with accounts in OpenCart will be allowed to checkout if a subscription product is in the cart.</div>';

$_['entry_order_address']				= 'Subscription Order Shipping Address: <div class="help-text">Choose the address to use for the shipping address on orders created when a subscription is charged. The billing address on subscription orders will always be the address on the card used for payment.<br><br>A customer\'s "Stripe address" will be changed whenever they use a stored card, store a new card, or purchase a subscription product. A customer\'s "OpenCart address" will be changed when they modify their default address in OpenCart. The "original order address" will always be the address that was used for the initial subscription order.</div>';
$_['text_stripe_address']				= 'Use Stripe address';
$_['text_opencart_address']				= 'Use OpenCart address';
$_['text_original_address']				= 'Use original order address';

// Current Subscription Products
$_['heading_current_subscriptions']		= 'Current Subscription Products';
$_['entry_current_subscriptions']		= 'Current Subscription Products: <div class="help-text">Products with mismatching prices are highlighted. The customer will always be charged the Stripe plan price, not the OpenCart product price, so you should make sure the price in OpenCart corresponds to the price in Stripe.<br><br>Note: only plans for your Transaction Mode will be listed. You are currently set to "[transaction_mode]" mode.</div>';

$_['text_thead_opencart']				= 'OpenCart';
$_['text_thead_stripe']					= 'Stripe';
$_['text_product_name']					= 'Product Name';
$_['text_product_price']				= 'Product Price';
$_['text_location_plan_id']				= 'Location / Plan ID';
$_['text_plan_name']					= 'Plan Name';
$_['text_plan_interval']				= 'Plan Interval';
$_['text_plan_charge']					= 'Plan Charge';
$_['text_no_subscription_products']		= 'No Subscription Products';
$_['text_create_one_by_entering']		= 'Create one by entering the Stripe pricing plan ID in the "Location" field for the product';

//------------------------------------------------------------------------------
// Standard Text
//------------------------------------------------------------------------------
$_['copyright']							= '<hr /><div class="text-center" style="margin: 15px">' . $_['heading_title'] . ' (' . $version . ') &copy; <a target="_blank" href="http://www.getclearthinking.com/contact">Clear Thinking, LLC</a></div>';

$_['standard_autosaving_enabled']		= 'Auto-Saving Enabled';
$_['standard_confirm']					= 'This operation cannot be undone. Continue?';
$_['standard_error']					= '<strong>Error:</strong> You do not have permission to modify ' . $_['heading_title'] . '!';
$_['standard_max_input_vars']			= '<strong>Warning:</strong> The number of settings is close to your <code>max_input_vars</code> server value. You should enable auto-saving to avoid losing any data.';
$_['standard_please_wait']				= 'Please wait...';
$_['standard_saved']					= 'Saved!';
$_['standard_saving']					= 'Saving...';
$_['standard_select']					= '--- Select ---';
$_['standard_success']					= 'Success!';
$_['standard_testing_mode']				= "Your log is too large to open! If you need to archive it, you can download it using the button above.\n\nTo start a new log, (1) click the Clear Log button, (2) reload the admin panel page, then (3) run your test again.";

$_['standard_module']					= 'Modules';
$_['standard_shipping']					= 'Shipping';
$_['standard_payment']					= 'Payments';
$_['standard_total']					= 'Order Totals';
$_['standard_feed']						= 'Feeds';

//------------------------------------------------------------------------------
// Payment Methods Icons
//------------------------------------------------------------------------------
$_['new_card_image'] = '<img height="16" src="data:image/png;base64,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" />';

$_['stored_card_image'] = '<img height="16" src="data:image/png;base64,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" />';

?>