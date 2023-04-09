<?php
//==============================================================================
// Restrict Checkout v2022-7-28
// 
// Author: Clear Thinking, LLC
// E-mail: johnathan@getclearthinking.com
// Website: http://www.getclearthinking.com
// 
// All code within this file is copyright Clear Thinking, LLC.
// You may not copy or reuse code within this file without written permission.
//==============================================================================

$_['version'] = 'v2022-7-28';

$name = 'Restrict';
$type = 'Checkout';
$row = 'restriction';

//------------------------------------------------------------------------------
// Heading
//------------------------------------------------------------------------------
$_['heading_title']						= $name . ' ' . $type;
$_['heading_welcome']					= 'Welcome to ' . $_['heading_title'] . '!';
$_['help_first_time']					= '
Some things to note before you get started:
<br><br>
<ul>
	<li>For help with any setting, make sure the "Tooltips" setting is enabled. You can then hover over any field to get help with what it means and how to use it.</li><br>
	<li>To create a manual backup of all your current settings, click the "Backup Settings" button. You can then restore from this backup at any time using the "Restore Settings" button. You can also restore from the automatic backup that is created every time the extension is opened, in case you want to go back to the settings as they were when you loaded the page.</li><br>
	<li>Backups are in tab-separated format, so you can easily edit them in a spreadsheet application. For help with creating new rules when using a spreadsheet application, visit http://www.getclearthinking.com/tutorials#editing-backup-files</li>
</ul>
';

// Backup/Restore Settings
$_['button_backup_settings']			= 'Backup Settings';
$_['text_this_will_overwrite_your']		= 'This will overwrite your previous backup file. Continue?';
$_['text_backup_saved_to']				= 'Backup saved to your /system/logs/ folder on';
$_['text_view_backup']					= 'View Backup';
$_['text_download_backup_file']			= 'Download Backup File';

$_['button_restore_settings']			= 'Restore Settings';
$_['text_restore_from_your']			= 'Restore from your:';
$_['text_automatic_backup']				= '<b>Automatic Backup</b>, created when this page was loaded:';
$_['text_manual_backup']				= '<b>Manual Backup</b>, created when "Backup Settings" was clicked:';
$_['text_backup_file']					= '<b>Backup File:</b>';
$_['button_restore']					= 'Restore';
$_['text_this_will_overwrite_settings']	= 'This will overwrite all current settings. Continue?';
$_['text_restoring']					= 'Restoring...';
$_['error_invalid_file_data']			= 'Error: invalid file data';
$_['text_settings_restored']			= 'Settings restored successfully';

// Buttons
$_['button_expand_all']					= 'Expand All';
$_['button_collapse_all']				= 'Collapse All';
$_['help_expand_all']					= 'Click to expand all rows in this table.';
$_['help_collapse_all']					= 'Click to collapse all rows in this table.';

//------------------------------------------------------------------------------
// Extension Settings
//------------------------------------------------------------------------------
$_['tab_extension_settings']			= 'Extension Settings';
$_['heading_extension_settings']		= 'Extension Settings';

$_['entry_status']						= 'Status: <div class="help-text">Set the status for the extension as a whole.</div>';
$_['entry_sort_order']					= 'Sort Order: <div class="help-text">The sort order for the extension, relative to other ' . strtolower($type) . ' extensions.</div>';
$_['entry_heading']						= 'Heading: <div class="help-text">The heading under which these shipping options will appear. HTML is supported.<br><br>Use the shortcodes [distance], [postcode], [quantity], [total], [volume], or [weight] to display the calculated value.</div>';
$_['entry_tax_class_id']				= 'Default Tax Class: <div class="help-text">Set the default tax class applied to ' . $row . 's. Any ' . $row . ' that does not have a "Tax Class" rule will use this tax class.</div>';

// Distance Settings
$_['heading_distance_settings']			= 'Distance Settings';

$_['entry_distance_calculation']		= 'Distance Calculation: <div class="help-text">Select the way distances are calculated. To change the origin of distance calculations for a single ' . $row . ', add an "Origin" rule to it.</div>';
$_['text_driving_distance']				= 'Driving Distance';
$_['text_straightline_distance']		= 'Straight-line Distance';

$_['entry_distance_units']				= 'Distance Units: <div class="help-text">Select the unit type for distance comparisons.</div>';
$_['text_miles']						= 'Miles';
$_['text_kilometers']					= 'Kilometers';

$_['entry_google_apikey']				= 'Google Maps API Key: <div class="help-text">If you are using distance-based ' . $row . 's, enter your Google Maps API Key here. If you do not have an API Key, you can get one at <a target="_blank" href="https://cloud.google.com/maps-platform">https://cloud.google.com/maps-platform</a>. Once you register, you can create a new API Key in the "Credentials" section. When choosing the APIs for the Key, make sure you choose to enable the "Directions" API and "Geocoding" API.</div>';

// Admin Panel Settings
$_['heading_admin_panel_settings']		= 'Admin Panel Settings';

$_['entry_autosave']					= 'Automatic Saving: <div class="help-text">Choose whether settings are automatically saved. If you have this disabled and notice settings not getting saved, it means you should enable Automatic Saving (because your server has a max_input_vars limitation imposed).<br><br>After changing this setting, reload the page to apply the change. You can tell a setting is being saved when it turns yellow, signaling that it cannot be edited while it is recorded to the database.</div>';

$_['entry_autocomplete_preloading']		= 'Auto-Complete Pre-loading: <div class="help-text">Choose whether to pre-load the auto-complete database when the page is loaded, or to pull items dynamically from the database. Pre-loading is faster, but may take too long with large databases.</div>';

$_['entry_display']						= 'Default Admin Display: <div class="help-text">Set the way table rows are displayed by default when the page is loaded. If the extension admin panel is loading slowly, try selecting "Collapsed".</div>';
$_['text_expanded']						= 'Expanded';
$_['text_collapsed']					= 'Collapsed';

$_['entry_tooltips']					= 'Tooltips: <div class="help-text">Disable to hide the tooltips that display for each setting. If the extension admin panel is loading slowly, try disabling Tooltips.</div>';

//------------------------------------------------------------------------------
// Restrictions
//------------------------------------------------------------------------------
$_['tab_restrictions']					= 'Restrictions';
$_['help_restrictions']					= 'By default, checkout is always available. If all of the rules for a restriction are met, checkout will be <strong>DISABLED</strong>.';
$_['heading_restrictions']				= 'Restrictions';

$_['column_action']						= 'Action';
$_['column_group']						= 'Name';
$_['column_checkout_message']			= 'Checkout Message';
$_['column_rules']						= 'Rules';

$_['text_expand']						= 'Expand (or double-click blank space in a collapsed row)';
$_['text_collapse']						= 'Collapse';
$_['text_copy']							= 'Copy';
$_['text_delete']						= 'Delete';

$_['help_restriction_name']				= 'Enter a reference name for this restriction, only visible internally to the admin. Leave this field blank to disable the restriction.';
$_['help_restriction_checkout_message']	= 'Enter the error message displayed when all the restriction rules are met. This will appear on the cart page, and the customer will not be able to proceed to the checkout until the rules are met.';

$_['button_add_restriction']			= 'Add Restriction';

//------------------------------------------------------------------------------
// Rules
//------------------------------------------------------------------------------
$_['text_choose_rule_type']				= '--- Choose rule type ---';
$_['help_rules']						= 'Choose a rule type from the list of options. Once you select a rule type, hover over the input field that is created for more information on that specific rule type.';

$_['text_of']							= 'of';
$_['text_is']							= 'is';
$_['text_is_not']						= 'is not';
$_['text_is_on_or_after']				= 'is after';
$_['text_is_on_or_before']				= 'is before';

$_['button_add_rule']					= 'Add Rule';
$_['help_add_rule']						= 'All rules must be true for the ' . $row . ' to be enabled. Rules of different types will be combined using AND logic, and rules of the same type using OR logic. (Note: Product Group and Date/Time rules are an exception to this.) For example, if you add these rules:<br><br>&bull; Customer Group is Wholesale<br>&bull; Geo Zone is United States<br>&bull; Geo Zone is Canada<br><br>then the ' . $row . ' will be enabled when the customer is part of the Wholesale group <b>AND</b> the location is in the United States <b>OR</b> Canada.';

$_['text_adjustments']					= 'Adjustments';
$_['text_adjust']						= 'Adjust';
$_['text_charge_adjustment']			= 'charge adjustment';
$_['text_final_charge']					= 'final charge';
$_['text_cart']							= 'cart';
$_['text_item']							= 'item';
$_['text_cumulative']					= 'Cumulative Brackets';
$_['text_enabled_successive_brackets']	= 'enabled = successive brackets are added together';
$_['text_max']							= 'Maximum';
$_['text_min']							= 'Minimum';
$_['text_round']						= 'Round';
$_['text_to_the_nearest']				= 'to the nearest';
$_['text_up_to_the_nearest']			= 'up to the nearest';
$_['text_down_to_the_nearest']			= 'down to the nearest';
$_['text_tax_class']					= 'Tax Class';
$_['text_total_value']					= 'Total Value';
$_['text_prediscounted_subtotal']		= 'Pre-Discounted Sub-Total';
$_['text_nondiscounted_subtotal']		= 'Non-Discounted Sub-Total';
$_['text_shipping_cost_subtotal']		= 'Shipping Cost';
$_['text_taxed_subtotal']				= 'Taxed Sub-Total';
$_['text_total_subtotal']				= 'Total';

$_['help_adjust_comparison']			= '&bull; Choose the type of value to adjust. Final charge adjustments occur after the charge has been calculated, and before Maximum or Minimum criteria are checked.<br><br>&bull; All other adjustments occur before calculations take place. "Cart adjustments" will apply to the entire cart, and "item adjustments" will apply to each individual item.<br><br>&bull; For example, if the cart contains an item that is 1 kg and an item that is 2 kg, then a "cart weight" adjustment of 1.00 would result in a total weight of:<br><br>(1 + 2) + 1.00 = 4.00 kg<br><br>An "item weight" adjustment of 1.00 would result in:<br><br>(1 + 1.00) + (2 + 1.00) = 5.00 kg';
$_['help_adjust']						= 'Enter a postive or negative value (such as 5.00 or -3.50) or percentage (such as 15% or -10%) by which the value will be adjusted.';
$_['help_cumulative']					= 'Cumulative bracket charges mean that each successive bracket will be added together. For example, if you charge $2.00 for 0-1 kg and $3.00 for 1-2 kg, then an order that is 1.5 kg will charge $2.00 + $3.00 = $5.00';
$_['help_max']							= 'Enter a flat value (such as 49.99) to have the ' . $row . ' always be no more than this maximum value.';
$_['help_min']							= 'Enter a flat value (such as 10.00) to have the ' . $row . ' always be at least this minimum value.';
$_['help_round']						= 'Enter a value to round the ' . $row . ' to (such as 0.25) after calculations have been performed. Also optionally select whether to always round up or down.';
$_['help_tax_class']					= 'Select a tax class to apply to this ' . $row . '.';
$_['help_total_value']					= 'The cart&#39;s Sub-Total is normally used for calculations involving the total. To change this, use one of the following:<br><br>&bull; <b>Pre-Discounted Sub-Total:</b> the sub-total of all products&#39; original prices, ignoring Special or Discount prices<br><br>&bull; <b>Non-Discounted Sub-Total:</b> the sub-total not including products with Special or Discount pricing<br><br>&bull; <b>Taxed Sub-Total:</b> the sub-total including any tax on products<br><br>&bull; <b>Total:</b> the total at the relative Sort Order of ' . ($type == 'Shipping' ? 'the "Shipping" Order Total<br><br>Products that do not require shipping are NOT included in values based on the sub-total.' : 'this extension.');

$_['text_cart_criteria']				= 'Cart/Item Criteria';
$_['text_length']						= 'Length';
$_['text_width']						= 'Width';
$_['text_height']						= 'Height';
$_['text_lwh']							= 'L + W + H';
$_['text_price']						= 'Price';
$_['text_quantity']						= 'Quantity';
$_['text_stock']						= 'Stock';
$_['text_total']						= 'Total';
$_['text_volume']						= 'Volume';
$_['text_weight']						= 'Weight';
$_['text_eligible_item_comparisons']	= 'eligible item comparisons';
$_['text_of_cart']						= 'of cart';
$_['text_of_any_item']					= 'of any item';
$_['text_of_every_item']				= 'of every item';
$_['text_entire_cart_comparisons']		= 'entire cart comparisons';
$_['text_of_entire_cart']				= 'of entire cart';
$_['text_of_any_item_in_entire_cart']	= 'of any item in entire cart';
$_['text_of_every_item_in_entire_cart']	= 'of every item in entire cart';
$_['text_items']						= 'items';
$_['help_cart_criteria_comparisons']	= '
	<b>of cart</b> = compare the value against the cart as a whole<br><br>
	<b>of any item</b> = compare the value against each item individually; any that qualify will be included the calculation, and any that do not will be ignored<br><br>
	<b>of every item</b> = compare the value against every item individually; if any do not qualify, the ' . $row . ' will be disabled
	<hr />
	Values are normally compared only against eligible items (i.e. those that qualify for the ' . $row . ' based on other rules). To compare values against all items in the cart, including ineligible ones, choose a comparison containing "entire cart".';
$_['help_cart_criteria']				= 'Enter a minimum value (such as 5.00) or a range (such as 3.3-10.5) that the cart or individual items must meet.<br><br>A single value indicates <b>at least</b> that value. For example, if you set a criteria of 5.00, any value of 5.00 or more will be eligible.<br><br>Ranges are inclusive of the end values. Separate multiple ranges using commas. To specify an exact value, use a range like 5.00-5.00.';

$_['text_datetime_criteria']			= 'Date/Time Criteria';
$_['text_day']							= 'Day of the Week';
$_['text_sunday']						= 'Sunday';
$_['text_monday']						= 'Monday';
$_['text_tuesday']						= 'Tuesday';
$_['text_wednesday']					= 'Wednesday';
$_['text_thursday']						= 'Thursday';
$_['text_friday']						= 'Friday';
$_['text_saturday']						= 'Saturday';
$_['text_date']							= 'Date';
$_['text_time']							= 'Time';
$_['help_day']							= 'Choose the day of the week that this ' . $row . ' is active. Create multiple rules if you want it active on multiple days.';
$_['help_date']							= 'YYYY-MM-DD';
$_['help_time']							= 'HH:MM (12-23 for PM)';
$_['help_datetime_criteria']			= 'Choose when the ' . $row . ' starts or ends. Use the format YYYY-MM-DD for dates and HH:MM for times. Use 12-23 for the PM hours. Date rules can accept a date + time, like this:<br><br><b>Date is after 2021-02-26 15:00</b><br><br>Note: By necessity, Date and Time rules always use AND logic when combined. If you want OR logic, you need to split your ' . $row . ' into two separate ' . $row . 's, with separate Date/Time rules.';

$_['text_discount_criteria']			= 'Discount Criteria';
$_['text_coupon']						= 'Coupon';
$_['text_discount_is']					= 'discount is';
$_['text_gift_voucher']					= 'Gift Voucher';
$_['text_reward_points']				= 'Reward Points';
$_['text_applied_to_cart']				= 'applied to cart';
$_['text_being_purchased']				= 'being purchased';
$_['text_of_products_in_cart']			= 'of products in cart';
$_['text_within_customers_account']		= 'within customer\'s account';
$_['help_coupon']						= 'For <b>"is/is not"</b> comparisons: enter a specific coupon code, or leave this field blank to check only for the presence of a coupon.<br>For example:<br><br><b>Coupon is ABC123</b><br>The ' . $row . ' will be active when ABC123 is applied to the cart<br><br><b>Coupon is __________</b><br>The ' . $row . ' will be active when any coupon is applied to the cart<br><hr />For <b>"discount is"</b> comparisons: enter a minimum value (such as 10.00) or a range (such as 0-99.99) that the coupon discount must meet. A single value indicates <b>at least</b> that value. Use 0 to indicate that a coupon has not been applied to the cart.<br>For example: <br><br><b>Coupon discount is 10.00</b><br>The ' . $row . ' will be active if the cart has a coupon applied with a discount of 10.00 or more<br><br><b>Coupon discount is 0-99.99</b><br>The ' . $row . ' will be active if the cart has a coupon with a discount between 0 and 99.99. If the discount is higher than 99.99, the ' . $row . ' will not be active.';
$_['help_gift_voucher']					= 'Enter a minimum value (such as 50.00) or a range (such as 0-99.99) that the gift voucher must meet. A single value indicates <b>at least</b> that value. Use 0 to indicate that a gift voucher has not been applied to the cart. For example: <br><br><b>Gift Voucher is 0-99.99</b><br>The ' . $row . ' will be active if the customer has not applied a gift voucher, or has applied one with a value less than 99.99. If the gift voucher value is more than 99.99, the ' . $row . ' will not be active.<br><br><b>Gift Voucher is 50.00</b><br>The ' . $row . ' will be active if the customer has applied a gift voucher of 50.00 or more.';
$_['help_reward_points']				= 'Enter a minimum value (such as 500) or a range (such as 0-999) that the reward points must meet. A single value indicates <b>at least</b> that value. For example: <br><br><b>Reward Points applied to cart = 0-999</b><br>The ' . $row . ' will be active if the customer has applied between 0 and 999 reward points to their cart. If they have applied more than 999 reward points, the ' . $row . ' will not be active.<br><br>(Hint: you can use this rule with a range of 0-0.9 to disable the ' . $row . ' when there are any reward points applied to the order.)<br><br><b>Reward Points of products in cart = 500</b><br>The ' . $row . ' will be active if the cart has products with a total reward points value of 500 or more.<br><br><b>Reward Points within customer&#39;s account = 750</b><br>The ' . $row . ' will be active if the customer has at least 750 reward points in their account.';

$_['text_location_criteria']			= 'Location Criteria';
$_['text_address']						= 'Address';
$_['text_city']							= 'City';
$_['text_country']						= 'Country';
$_['text_distance']						= 'Distance';
$_['text_geo_zone']						= 'Geo Zone';
$_['text_everywhere_else']				= 'Everywhere Else';
$_['text_location_comparison']			= 'Location Comparison';
$_['text_geo_ip_tools_location']		= 'Geo IP Tools Location';
$_['text_payment_address']				= 'Payment Address';
$_['text_shipping_address']				= 'Shipping Address';
$_['text_origin']						= 'Origin';
$_['text_postcode']						= 'Postcode';
$_['text_zone']							= 'Zone';
$_['help_address']						= 'Enter a full or partial address to compare against the Address Line 1 field. Separate multiple values by commas. For example, to make this ' . $row . ' only apply to PO Boxes, you could enter:<br><br><b>PO Box, P.O. Box</b>';
$_['help_city']							= 'Enter an exact city name, such as:<br><br>New York<br><br>or multiple city names separated by commas, such as<br><br>New York, New York City, London<br><br>The city entered by the customer will be compared against these values (case-insensitively).';
$_['help_country']						= 'Select a country from the dropdown list.';
$_['help_distance']						= 'Enter a maximum value (such as 5.00) or a range (such as 3.3-10.5) that the customer&#39;s distance must be from the store location. For example, if you enter 5.00, and Distance Units are set to "Miles", any location within 5 miles will be eligible.<br><br>Ranges are inclusive of the end values. Separate multiple ranges using commas.<br><br>Location determinations are made using the Google Geocoding API. This API is limited to 2,500 requests every 24 hours. If you need more than this, consider signing up for Google Maps API for Business, which allows 100,000 requests every 24 hours.';
$_['help_geo_zone']						= 'Select a geo zone, or select "Everywhere Else" to restrict the ' . $row . ' to anywhere not in a geo zone.';
$_['help_location_comparison']			= 'By default, ' . $type . ' extensions compare location criteria against the ' . ($type == 'Shipping' || $type == 'Banner' ? 'shipping' : 'payment') . ' address. Use this setting to change this behavior.<br><br>Choosing "Geo IP Tools Location" requires that you have <a target="_blank" href="http://www.opencartx.com/geo-ip-tools">Geo IP Tools</a> click Installed. It will then use the location determined by the customer IP address or browser location request, if enabled.';
$_['help_origin']						= 'Enter the origin address used for distance calculations. This will override the default store address set in System > Settings (in the Store tab).';
$_['help_postcode']						= 'Enter a single postcode or prefix (such as AB1) or a range (such as 91000-94499). Ranges are inclusive of the end values. Separate multiple postcodes using commas.';
$_['help_zone']							= 'Enter a zone name in the auto-complete field. Make sure to leave the zone_id in the square brackets [ and ] since that is used for comparison purposes.';

$_['text_order_criteria']				= 'Order Criteria';
$_['text_coupon']						= 'Coupon';
$_['text_currency']						= 'Currency';
$_['text_custom_field']					= 'Custom Field';
$_['text_customer_data']				= 'Customer Data';
$_['text_customer_group']				= 'Customer Group';
$_['text_guests']						= 'Guests';
$_['text_language']						= 'Language';
$_['text_past_orders']					= 'Past Orders';
$_['text_average_total']				= 'Average Total';
$_['text_coupon_used']					= 'Coupon Used';
$_['text_coupon_unused']				= 'Coupon Unused';
$_['text_days']							= 'Days';
$_['text_order_amount']					= 'Order Amount';
$_['text_order_status']					= 'Order Status';
$_['text_payment_extension']			= 'Payment Method';
$_['text_shipping_extension']			= 'Shipping Method';
$_['text_shipping_rate']				= 'Shipping Rate';
$_['text_store']						= 'Store';
$_['help_coupon']						= 'Enter a specific coupon code, or leave this field blank to check only for the presence of a coupon.<br>For example:<br><br><b>Coupon is ABC123</b><br>The ' . $row . ' will be active when ABC123 is applied to the cart<br><br><b>Coupon is not ABC123</b><br>The ' . $row . ' will be active when ABC123 is <b>not</b> applied to the cart<br><br><b>Coupon is __________</b><br>The ' . $row . ' will be active when any coupon is applied to the cart<br><br><b>Coupon is not __________</b><br>The ' . $row . ' will be active when a coupon is <b>not</b> applied to the cart';
$_['help_currency']						= 'Select a currency. If multiple currency rules are added, the total will be appropriately converted from the default currency using your currency conversions.<br><br>If you want to enter a total value in its foreign currency amount, then add a single currency rule with that currency selected.';
$_['help_custom_field']					= 'Enter a custom field name in the auto-complete field, then enter a single value or range, separated by a hyphen. If the targeted values include a hyphen already, such as for negative numbers, use :: to separate the range. Make sure to leave the custom_field_id in the square brackets [ and ] since that is used for comparison purposes.';
$_['help_custom_field_value']			= 'Enter a custom field value, or multiple values separated by commas. Products that have the specified custom field with this value will be eligible for this ' . $row . '. Leave this field blank to check whether the customer&#39;s custom field value is blank or not present.';
$_['help_customer_data']				= 'Select a customer field to compare against, and then enter the required value. Use "!" at the beginning of the value you enter to negate it. Separate multiple values using commas, and enter ranges using :: instead of a hyphen. Leave this field blank to check for any filled in value. For example:<br><br><b>Company is __________</b><br><br>will check to make sure the Company field is filled in.';
$_['help_customer_group']				= 'Select a customer group, or select "Guests" to restrict the ' . $row . ' to customers not logged in to an account.';
$_['help_language']						= 'Select a language.';
$_['help_past_orders_dropdown']			= 'Choose how to compare customer&#39;s past orders. For example:<br><br>&bull; To apply the ' . $row . ' to customers who have placed an order within the past 30 days, choose "Days" and enter 0-30<br><br>&bull; To apply the ' . $row . ' to customers with at least 2 past orders, choose "Quantity" and enter 2<br><br>&bull; To apply the ' . $row . ' to customers whose past orders total $500 to $1000, choose "Total" and enter 500-1000';
$_['help_past_orders']					= 'For "Order Status", "Category", "Manufacturer", and "Product" comparisons, enter the order_status_id, category_id, manufacturer_id, or product_id in this field. Separate multiple values using commas.<br><br>For the "Date" comparison, enter the date range in the format <code>YYYY-MM-DD::YYYY-MM-DD</code>. To count all orders up to the present, leave the second value out.<br><br>For other comparison types, enter a minimum value (such as 5) or a range (such as 50.00-100.00) that the customer&#39;s past orders must meet. A single value indicates <b>at least</b> that value.<br><br>Ranges are inclusive of the end values. Separate multiple ranges using commas. To specify an exact value, use a range like 50.00-50.00.';
$_['help_payment_extension']			= 'Select a payment method to which this fee/discount applies.';
$_['help_shipping_cost']				= 'Enter a minimum value (such as 5.00) or a range (such as 30.00-70.00) that the shipping cost must meet. A single value indicates <b>at least</b> that value. For example, if you set a criteria of 5.00, the ' . $row . ' will apply when the customer chooses a shipping option whose cost is 5.00 or more.<br><br>Ranges are inclusive of the end values. Separate multiple ranges using commas. To specify an exact value, use a range like 5.00-5.00';
$_['help_shipping_extension']			= 'Select a shipping method to which this fee/discount applies.';
$_['help_shipping_rate']				= 'Enter a shipping rate title (such as Priority Mail) or multiple titles separated by commas (such as Priority Mail, Express Mail). The shipping rate selected by the customer will be compared against these values (case-insensitively).';
$_['help_store']						= 'Select a store from your multi-store installation.';

$_['text_product_criteria']				= 'Product Criteria';
$_['text_attribute']					= 'Attribute';
$_['text_attribute_group']				= 'Attribute Group';
$_['text_category']						= 'Category';
$_['text_filter']						= 'Filter';
$_['text_manufacturer']					= 'Manufacturer';
$_['text_option']						= 'Option';
$_['text_product']						= 'Product';
$_['help_attribute']					= 'Enter an attribute name in the auto-complete field. Make sure to leave the attribute_id in the square brackets [ and ] since that is used for comparison purposes. For more complex requirements, use the Product Groups feature.';
$_['help_attribute_group']				= 'Enter an attribute group name in the auto-complete field. Make sure to leave the attribute_group_id in the square brackets [ and ] since that is used for comparison purposes. For more complex requirements, use the Product Groups feature.';
$_['help_attribute_value']				= 'Enter an attribute value, or multiple attribute values separated by commas. Products that have the specified attribute with this value will be eligible for this ' . $row . '. Leave this field blank to allow for any attribute value.';
$_['help_category']						= 'Enter a category name in the auto-complete field. Make sure to leave the category_id in the square brackets [ and ] since that is used for comparison purposes. For more complex requirements, use the Product Groups feature.';
$_['help_filter']						= 'Enter a filter name in the auto-complete field. Make sure to leave the filter_id in the square brackets [ and ] since that is used for comparison purposes. For more complex requirements, use the Product Groups feature.';
$_['help_manufacturer']					= 'Enter a manufacturer name in the auto-complete field. Make sure to leave the manufacturer_id in the square brackets [ and ] since that is used for comparison purposes. For more complex requirements, use the Product Groups feature.';
$_['help_option']						= 'Enter an option in the auto-complete field. Make sure to leave the option_id in the square brackets [ and ] since that is used for comparison purposes. For more complex requirements, use the Product Groups feature.';
$_['help_option_value']					= 'Enter a value (such as Small) or a range (such as 25-50). Products that have the specified option with the value or within the range will be eligible for this ' . $row . '. Leave this field blank to allow for any option value.<br><br>If the option value can include a hyphen, use :: in place of - for ranges. Ranges are inclusive of the end values.';
$_['help_product']						= 'Enter a product name in the auto-complete field. Make sure to leave the product_id in the square brackets [ and ] since that is used for comparison purposes. For more complex requirements, use the Product Groups feature.';

$_['text_other_product_data']			= 'Other Product Data';
$_['help_other_product_data_column']	= 'Choose which database column to use for the comparison.';
$_['help_other_product_data']			= 'This rule has two functions:<br><br>1. Enter a value (such as ABC001X) or a range (such as 500-1000). Products that match this value or have a value in this range will be eligible for this ' . $row . '.<br><br>If product data includes hyphens, use :: in place of - for ranges. Ranges are inclusive of the end values. Separate multiple ranges using commas.<br><br>For example, if you choose "model" for the database column, and then enter "Model XYZ" (without quotes) in the field, any product with a matching model will be used for this ' . $row . '&#39;s calculation.<br><br>2. If you leave the value blank, then that field will instead be used to calculate the ' . $row . ' for each product. For example, if you are using a Quantity ' . $row . ' type and choose "sku", then the SKU data for each product will be calculated as quantity brackets.<br><br>In this example, if a product had a value of 5.00 / 1 in that field, its ' . $row . ' would be $5.00 per item. If another product had 7.50 in that field, then its ' . $row . ' would be $7.50. These ' . $row . 's would be added together as the final ' . $row . ' displayed to the customer.';

$_['text_product_group']				= 'Product Group';
$_['text_cart_has_items_from']			= 'Cart has items from';
$_['text_any']							= 'any';
$_['text_all']							= 'all';
$_['text_not']							= 'not';
$_['text_only_any']						= 'only any';
$_['text_only_all']						= 'only all';
$_['text_none_of_the']					= 'none of the';
$_['text_members_of']					= 'members of';
$_['help_product_group']				= 'Select a product group from the list. Multiple Product Group rules are combined using AND logic, unlike other rules.<br><br>Note: new groups can be created in the "Product Groups" tab. Product Groups must be created <b>before</b> adding a "Product Group" rule.';
$_['help_product_group_comparison']		= '
	<b>any</b> = cart has at least one item from group members, and can have items not from members<br><br>
	<b>all</b> = cart has items from all group members, and can have items not from members<br><br>
	<b>not</b> = cart has at least one item <b>not</b> from group members, and can have items from members<br><br>
	<b>only any</b> = cart has <b>only</b> items from group members, and <b>cannot</b> have items not from members<br><br>
	<b>only all</b> = cart has <b>only</b> items from all group members, and <b>cannot</b> have items not from members<br><br>
	<b>none</b> = cart has <b>no</b> items from any group member
';

$_['text_quantity_of_product']			= 'Quantity of Product';
$_['help_quantity_of_product_comparison'] = 'Enter a product name in the auto-complete field. Make sure to leave the product_id in the square brackets [ and ] since that is used for comparison purposes.';
$_['help_quantity_of_product']			= 'Enter a minimum value (such as 5) or a range (such as 3-10) that the quantity of the chosen product must meet. A single value indicates <b>at least</b> that value.<br><br>Ranges are inclusive of the end values. Separate multiple ranges using commas. To specify an exact value, use a range like 5-5.<br><br>Note: with this rule the quantity of a product will be checked, but it will <b>NOT</b> be factored into any other calculations. To include the product in calculations, add an additional "Product" rule for the product.';

$_['text_quantity_of_group']			= 'Quantity of Group';
$_['help_quantity_of_group_comparison']	= 'Select a product group from the list.';
$_['help_quantity_of_group']			= 'Enter a minimum value (such as 5) or a range (such as 3-10) that the quantity of the chosen product group must meet. A single value indicates <b>at least</b> that value.<br><br>Ranges are inclusive of the end values. Separate multiple ranges using commas. To specify an exact value, use a range like 5-5.<br><br>Note: with this rule the total quantity of all items in the product group will be checked, but these items will <b>NOT</b> be factored into any other calculations. To include the product group members in calculations, add an additional "Product Group" rule, using the "any" comparison.';

$_['text_recurring_profile']			= (version_compare(VERSION, '4.0', '<') ? 'Recurring Profile' : 'Subscription Plan');
$_['help_recurring_profile']			= 'Choose a ' . (version_compare(VERSION, '4.0', '<') ? 'recurring profile' : 'subscription plan') . ' from the list. This will apply the ' . $row . ' to any products in the cart that has (or does not have) the chosen ' . (version_compare(VERSION, '4.0', '<') ? 'profile' : 'plan') . '.';

$_['text_rule_sets']					= 'Rule Sets';
$_['text_rule_set']						= 'Rule Set';
$_['help_rule_set']						= 'Select a rule set from the list. New rule sets can be created in the "Rule Sets" tab.<br><br>All rules in the rule set will be applied just like other rules, so remember that rules of different types will be combined using AND logic, and rules of the same type using OR logic.<br><br>Note: rule sets must be created before adding a "Rule Set" rule.';

//------------------------------------------------------------------------------
// Charge Combinations
//------------------------------------------------------------------------------
$_['tab_charge_combinations']			= 'Charge Combinations';
$_['help_charge_combinations']			= 'Charge Combinations allow you to combine charges created in the "Charges" area. Any unused Group values from the Charges tab will show up on their own.';
$_['heading_charge_combinations']		= 'Charge Combinations';
$_['button_add_combination']			= 'Add Combination';

$_['column_sort_order']					= 'Sort Order';
$_['column_title_combination']			= 'Title Combination';
$_['column_groups_required']			= 'Groups Required';
$_['column_combination_formula']		= 'Combination Formula';

$_['text_single_title']					= 'Single Title';
$_['text_combined_title_no_prices']		= 'Combined Title, No Prices';
$_['text_combined_title_with_prices']	= 'Combined Title, With Prices';

$_['help_combination_sort_order']		= 'The sort order in which the charge combinations will appear to the customer as shipping options.';
$_['help_combination_title']			= '&bull; <b>Single Title</b> means the first applicable title will be shown as the shipping choice title. If choosing this then you should use the same title for all charges in the formula.<br><br>&bull; <b>Combined Title</b> means that all charge titles will be combined in a list, so the shipping choice would appear as something like "Category A Charge + Category B Charge"<br><br>&bull; <b>With Prices</b> means the title will include the price of each charge, so the shipping choice would appear as something like "Category A Charge ($5.00) + Category B Charge ($7.00)"';
$_['help_combination_groups_required']	= 'If a Charge is <b>required</b> for this Charge Combination to be enabled, enter its Group value here. Separate multiple Group values with commas. <b>If any listed Group value(s) are not active, this Charge Combination will not appear.</b>';
$_['help_combination_formula']			= 'Enter a formula for how the charges are combined together.<br><br><b>SUM</b> = Sum of all charges<br><b>AVG</b> = Average of all charges<br><b>MAX</b> = Highest of all charges<br><b>MIN</b> = Lowest of all charges<br><b>MULT</b> = Product of all charges<br><br>Use the charge&#39;s Group value to designate which charges are part of the combination. For example, to add together all charges for Groups A and B, you would enter:<br><br><span style="font-family: monospace; font-size: 14px">SUM(A, B)</span><br><br>If you wanted to take the highest of either the sum of Group A, or the average of Group B, then you would enter:<br><br><span style="font-family: monospace; font-size: 14px">MAX(SUM(A), AVG(B))</span>';
$_['placeholder_formula']				= 'SUM(), AVG(), MAX(), MIN(), MULT()';

//------------------------------------------------------------------------------
// Product Groups
//------------------------------------------------------------------------------
$_['tab_product_groups']				= 'Product Groups';
$_['help_product_groups']				= 'Product Groups are used to restrict ' . $row . 's based on a group of categories, manufacturers, ' . ($name == 'Ultimate' ? 'products, attributes, and/or options' : 'and/or products') . '. Product Groups can be used in any ' . $row;
$_['heading_product_groups']			= 'Product Groups';
$_['button_add_product_group']			= 'Add Product Group';

$_['column_group_members']				= 'Group Members';
$_['column_']							= '';

$_['text_include_all_subcategories']	= ' &nbsp; Include All Sub-Categories of <br> &nbsp; Category Members:';
$_['text_autocomplete_from']			= 'Auto-Complete From:';
$_['text_all_database_tables']			= 'All Database Tables';

$_['help_product_group_sort_order']		= 'The sort order in which the product group will appear when selecting it as a Rule.';
$_['help_product_group_name']			= 'The name displayed for the product group when selecting it as a Rule.';
$_['help_autocomplete_from']			= 'Choose whether the auto-complete field pulls items from all database tables, or from specific ones (categories, products, etc.).';
$_['placeholder_typeahead']				= 'Start typing a name';
$_['help_typeahead']					= 'Start typing a name in the auto-complete field. If more than 15 entries are found, the list will be scrollable, up to 100 entries.<br><br>Hit "enter" to add the first entry and clear the input field, or click an entry to add it to the list and keep the dropdown open, allowing you to choose multiple entries from the list quickly.<br><br>Make sure to leave the data within the square brackets [ and ] alone, since that is used for comparison purposes.';

//------------------------------------------------------------------------------
// Rule Sets
//------------------------------------------------------------------------------
$_['tab_rule_sets']						= 'Rule Sets';
$_['help_rule_sets']					= 'Rule Sets are used to apply multiple rules to a single ' . $row . ' at once. Rule Sets can be used in any ' . $row . '.';
$_['heading_rule_sets']					= 'Rule Sets';
$_['button_add_rule_set']				= 'Add Rule Set';

$_['column_name']						= 'Name';

$_['help_rule_set_sort_order']			= 'The sort order in which the rule set will appear when selecting it as a Rule.';
$_['help_rule_set_name']				= 'The name displayed for the rule set when selecting it as a Rule.';

//------------------------------------------------------------------------------
// Testing Mode
//------------------------------------------------------------------------------
$_['tab_testing_mode']					= 'Testing Mode';
$_['testing_mode_help']					= 'Enable Testing Mode if things are not working as expected on the front-end. Messages logged during testing can be viewed below.';
$_['heading_testing_mode']				= 'Testing Mode';

$_['entry_testing_mode']				= 'Testing Mode:';
$_['entry_testing_messages']			= 'Messages:';
$_['button_refresh_log']				= 'Refresh Log';
$_['button_download_log']				= 'Download Log';
$_['button_clear_log']					= 'Clear Log';

//------------------------------------------------------------------------------
// Standard Text
//------------------------------------------------------------------------------
$_['copyright']							= '<hr /><div class="text-center" style="margin: 15px">' . $_['heading_title'] . ' (' . $_['version'] . ') &copy; <a target="_blank" href="http://www.getclearthinking.com/contact">Clear Thinking, LLC</a></div>';

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
// Extension-Specific Text
//------------------------------------------------------------------------------

?>