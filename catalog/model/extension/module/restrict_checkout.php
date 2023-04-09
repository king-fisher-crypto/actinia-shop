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

//namespace Opencart\Catalog\Model\Extension\RestrictCheckout\Module;
//class RestrictCheckout extends \Opencart\System\Engine\Model {

class ModelExtensionModuleRestrictCheckout extends Model {
	
	private $type = 'module';
	private $name = 'restrict_checkout';
	private $testing_mode;
	private $row;
	
	//==============================================================================
	// restrict()
	//==============================================================================
	public function restrict() {
		$settings = $this->getSettings();
		$this->testing_mode = $settings['testing_mode'];
		
		$this->logMessage("\n" . '------------------------------ Starting Test ' . date('Y-m-d G:i:s') . ' ------------------------------');
		
		if (empty($settings['status'])) {
			$this->logMessage('Extension is disabled');
			return array();
		}
		
		// Set address info
		$addresses = array();
		$this->load->model('account/address');
		foreach (array('shipping', 'payment', 'geoiptools') as $address_type) {
			if ($address_type == 'geoiptools' && !empty($this->session->data['geoip_data']['location'])) {
				$address = $this->session->data['geoip_data']['location'];
			} elseif (($address_type == 'shipping' && empty($address)) || $address_type == 'payment') {
				$address = array();
				
				if ($this->customer->isLogged()) 										$address = $this->model_account_address->getAddress($this->customer->getAddressId());
				if (!empty($this->session->data['country_id']))							$address['country_id'] = $this->session->data['country_id'];
				if (!empty($this->session->data['zone_id']))							$address['zone_id'] = $this->session->data['zone_id'];
				if (!empty($this->session->data['postcode']))							$address['postcode'] = $this->session->data['postcode'];
				if (!empty($this->session->data['city']))								$address['city'] = $this->session->data['city'];
				
				if (!empty($this->session->data[$address_type . '_country_id']))		$address['country_id'] = $this->session->data[$address_type . '_country_id'];
				if (!empty($this->session->data[$address_type . '_zone_id']))			$address['zone_id'] = $this->session->data[$address_type . '_zone_id'];
				if (!empty($this->session->data[$address_type . '_postcode']))			$address['postcode'] = $this->session->data[$address_type . '_postcode'];
				if (!empty($this->session->data[$address_type . '_city']))				$address['city'] = $this->session->data[$address_type . '_city'];
				
				if (!empty($this->session->data['guest'][$address_type]))				$address = $this->session->data['guest'][$address_type];
				if (!empty($this->session->data[$address_type . '_address_id']))		$address = $this->model_account_address->getAddress($this->session->data[$address_type . '_address_id']);
				if (!empty($this->session->data[$address_type . '_address']))			$address = $this->session->data[$address_type . '_address'];
			}
			
			if (empty($address['address_1']))	$address['address_1'] = '';
			if (empty($address['address_2']))	$address['address_2'] = '';
			if (empty($address['city']))		$address['city'] = '';
			if (empty($address['postcode']))	$address['postcode'] = '';
			if (empty($address['country_id']))	$address['country_id'] = $this->config->get('config_country_id');
			if (empty($address['zone_id']))		$address['zone_id'] =  $this->config->get('config_zone_id');
			
			$country_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country WHERE country_id = " . (int)$address['country_id']);
			$address['country'] = (isset($country_query->row['name'])) ? $country_query->row['name'] : '';
			$address['iso_code_2'] = (isset($country_query->row['iso_code_2'])) ? $country_query->row['iso_code_2'] : '';
			
			$zone_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone WHERE zone_id = " . (int)$address['zone_id']);
			$address['zone'] = (isset($zone_query->row['name'])) ? $zone_query->row['name'] : '';
			$address['zone_code'] = (isset($zone_query->row['code'])) ? $zone_query->row['code'] : '';
			
			$addresses[$address_type] = $address;
			
			$addresses[$address_type]['geo_zones'] = array();
			$geo_zones_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE country_id = " . (int)$address['country_id'] . " AND (zone_id = 0 OR zone_id = " . (int)$address['zone_id'] . ")");
			if ($geo_zones_query->num_rows) {
				foreach ($geo_zones_query->rows as $geo_zone) {
					$addresses[$address_type]['geo_zones'][] = $geo_zone['geo_zone_id'];
				}
			} else {
				$addresses[$address_type]['geo_zones'] = array(0);
			}
		}
		
		if (version_compare(VERSION, '4.0', '>=') && !$this->config->get('config_checkout_address')) {
			$addresses['payment'] = $addresses['shipping'];
		}
		
		// Record testing mode info
		if ($this->customer->isLogged()) {
			$this->logMessage('CUSTOMER: ' . $this->customer->getFirstName() . ' ' . $this->customer->getLastName() . ' (customer_id: ' . $this->customer->getId() . ', ip: ' . $this->request->server['REMOTE_ADDR'] . ')');
		} else {
			$this->logMessage('CUSTOMER: Guest (' . $this->request->server['REMOTE_ADDR'] . ')');
		}
		
		if ($this->type != 'shipping') {
			$billing_address = array(
				$addresses['payment']['address_1'],
				$addresses['payment']['address_2'],
				$addresses['payment']['city'],
				$addresses['payment']['zone'],
				$addresses['payment']['postcode'],
				$addresses['payment']['country'],
			);
			$this->logMessage('BILLING ADDRESS: ' . implode(', ', array_filter($billing_address)));
		}
		
		$shipping_address = array(
			$addresses['shipping']['address_1'],
			$addresses['shipping']['address_2'],
			$addresses['shipping']['city'],
			$addresses['shipping']['zone'],
			$addresses['shipping']['postcode'],
			$addresses['shipping']['country'],
		);
		$this->logMessage('SHIPPING ADDRESS: ' . implode(', ', array_filter($shipping_address)));
		
		// Set order totals if necessary
		if ($this->type != 'total') {
			$stop_before = ($this->type == 'shipping') ? 'shipping' : $this->name;
			$order_totals = $this->getOrderTotals($stop_before);
			
			$total_data = $order_totals['totals'];
			$order_total = $order_totals['total'];
		}
		
		// Set cart data
		$this->load->model('catalog/product');
		
		$list_of_products = array();
		$cart_products = $this->cart->getProducts();
		
		foreach ($cart_products as &$cart_product) {
			$product_options = array();
			foreach ($cart_product['option'] as $option) {
				$product_options[] = $option['name'] . ': ' . $option['value'];
			}
			$list_of_products[] = $cart_product['name'] . ($product_options ? ' (' . implode(', ', $product_options) . ')' : '');
			
			if (version_compare(VERSION, '2.1', '>=')) {
				if (!empty($cart_product['recurring']['recurring_id'])) {
					$recurring_or_subscription_id = $cart_product['recurring']['recurring_id'];
				} elseif (!empty($cart_product['subscription']['subscription_plan_id'])) {
					$recurring_or_subscription_id = $cart_product['subscription']['subscription_plan_id'];
				} else {
					$recurring_or_subscription_id = 0;
				}
				$cart_product['recurring_or_subscription_id'] = $recurring_or_subscription_id;
				$cart_product['key'] = $cart_product['product_id'] . json_encode($cart_product['option']) . $recurring_or_subscription_id;
			}
		}
		
		$this->logMessage('PRODUCTS: ' . implode(', ', $list_of_products));
		
		// Set variables
		$cumulative_total_value = $order_total;
		$currency = $this->session->data['currency'];
		$customer_id = (int)$this->customer->getId();
		$customer_group_id = (int)$this->customer->getGroupId();
		$distance = 0;
		$distance_origin = '';
		$language = (isset($this->session->data['language'])) ? $this->session->data['language'] : $this->config->get('config_language');
		$main_currency = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `key` = 'config_currency' AND store_id = 0 ORDER BY setting_id DESC LIMIT 1")->row['value'];
		$store_id = (isset($this->session->data['store_id'])) ? (int)$this->session->data['store_id'] : (int)$this->config->get('config_store_id');
		
		// Loop through rows
		$messages = array();
		
		foreach ($settings['restriction'] as $row) {
			$this->row = $row;
			$this->logMessage("\n" . 'CHECKING RESTRICTION "' . $row['name'] . '"');
			
			// Compile rules and rule sets
			$rule_list = (!empty($row['rule'])) ? $row['rule'] : array();
			
			if (empty($row['name'])) {
				$this->logMessage('Disabled for having no name. The rules are:' . print_r($rule_list, true));
				continue;
			}
			
			$rule_sets = array();
			
			foreach ($rule_list as $rule) {
				if (isset($rule['type']) && $rule['type'] == 'rule_set') {
					$rule_sets[] = $settings['rule_set'][$rule['value']]['rule'];
				}
			}
			
			foreach ($rule_sets as $rule_set) {
				$rule_list = array_merge($rule_list, $rule_set);
			}
			
			$rules = array();
			
			foreach ($rule_list as $rule) {
				if (empty($rule['type'])) continue;
				
				if (isset($rule['comparison'])) {
					if (in_array($rule['type'], array('attribute', 'custom_field', 'option', 'quantity_of_product'))) {
						$comparison = substr($rule['comparison'], strrpos($rule['comparison'], '[') + 1, -1);
					} else {
						$comparison = $rule['comparison'];
					}
				} else {
					$comparison = '';
				}
				
				if (isset($rule['value'])) {
					if (in_array($rule['type'], array('attribute_group', 'category', 'filter', 'manufacturer', 'product', 'zone'))) {
						$value = substr($rule['value'], strrpos($rule['value'], '[') + 1, -1);
					} else {
						$value = $rule['value'];
					}
				} else {
					$value = 1;
				}
				
				$rules[$rule['type']][$comparison][] = $value;
			}
			
			$this->row['rules'] = $rules;
			
			// Check date/time criteria
			if ($this->ruleViolation('day', strtolower(date('l'))) ||
				$this->ruleViolation('date', date('Y-m-d H:i')) ||
				$this->ruleViolation('time', date('H:i'))
			) {
				continue;
			}
			
			// Check location criteria
			if (isset($rules['location_comparison'])) {
				$location_comparison = $rules['location_comparison'][''][0];
			} else {
				$location_comparison = ($this->type == 'shipping' || empty($addresses['payment']['city'])) ? 'shipping' : 'payment';
			}
			$address = $addresses[$location_comparison];
			$postcode = $address['postcode'];
			
			if (isset($rules['city'])) {
				$this->commaMerge($rules['city']);
				$this->row['rules']['city'] = $rules['city'];
			}
			
			if ($this->ruleViolation('city', strtolower(trim($address['city']))) ||
				$this->ruleViolation('country', $address['country_id']) ||
				$this->ruleViolation('geo_zone', $address['geo_zones']) ||
				$this->ruleViolation('zone', $address['zone_id'])
			) {
				continue;
			}
			
			if (isset($rules['postcode'])) {
				$this->commaMerge($rules['postcode']);
				
				foreach ($rules['postcode'] as $comparison => $postcodes) {
					$in_range = $this->inRange($postcode, $postcodes, 'postcode' . ($comparison == 'not' ? ' not' : ''));
					
					if (($comparison == 'is' && !$in_range) || ($comparison == 'not' && $in_range)) {
						continue 2;
					}
				}
			}
			
			// Check order criteria
			if ($this->ruleViolation('currency', $currency) ||
				$this->ruleViolation('customer_group', $customer_group_id) ||
				$this->ruleViolation('language', $language) ||
				$this->ruleViolation('store', $store_id)
			) {
				continue;
			}
			
			// Generate comparison values
			$cart_criteria = array(
				'length',
				'width',
				'height',
				'lwh',
				'price',
				'quantity',
				'stock',
				'total',
				'volume',
				'weight',
			);
			
			foreach ($cart_criteria as $spec) {
				${$spec.'s'} = array();
				if (isset($rules[$spec])) {
					$this->commaMerge($rules[$spec]);
				}
			}
			
			$categorys = array();
			$manufacturers = array();
			$products = array();
			
			$product_keys = array();
			$total_value = $cumulative_total_value;
			
			foreach ($cart_products as $product) {
				if ($this->type == 'shipping' && !$product['shipping']) {
					$total_value -= $product['total'];
					$this->logMessage($product['name'] . ' (product_id: ' . $product['product_id'] . ') was ignored because it does not require shipping');
					continue;
				}
				
				$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id = " . (int)$product['product_id']);
				
				// dimensions
				$length_class_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "length_class WHERE length_class_id = " . (int)$product['length_class_id']);
				if ($length_class_query->num_rows) {
					$lengths[$product['key']] = $this->length->convert($product['length'], $product['length_class_id'], $this->config->get('config_length_class_id'));
					$widths[$product['key']] = $this->length->convert($product['width'], $product['length_class_id'], $this->config->get('config_length_class_id'));
					$heights[$product['key']] = $this->length->convert($product['height'], $product['length_class_id'], $this->config->get('config_length_class_id'));
					$lwhs[$product['key']] = $lengths[$product['key']] + $widths[$product['key']] + $heights[$product['key']];
				} else {
					$message = $product['name'] . ' (product_id: ' . $product['product_id'] . ') does not have a valid length class, which causes a "Division by zero" error, and means it cannot be used for dimension/volume calculations. You can fix this by re-saving the product data.';
					$this->log->write($message);
					$this->logMessage($message);
					
					$lengths[$product['key']] = 0;
					$widths[$product['key']] = 0;
					$heights[$product['key']] = 0;
					$lwhs[$product['key']] = 0;
				}
				
				// price
				$prices[$product['key']] = $product['price'];
				
				// quantity
				$quantitys[$product['key']] = $product['quantity'];
				
				// stock
				$stocks[$product['key']] = $product_query->row['quantity'] - $product['quantity'];
				
				foreach ($product['option'] as $option) {
					$option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_value_id = " . (int)$option['product_option_value_id']);
					if ($option_query->num_rows) {
						$stocks[$product['key']] = min($stocks[$product['key']], $option_query->row['quantity'] - $product['quantity']);
					}
				}
				
				// total
				if (isset($rules['total_value'])) {
					$product_info = $this->model_catalog_product->getProduct($product['product_id']);
					$product_price = ($product_info['special']) ? $product_info['special'] : $product_info['price'];
					
					if (in_array('prediscounted', $rules['total_value'][''])) {
						$totals[$product['key']] = $product['total'] + ($product['quantity'] * ($product_query->row['price'] - $product_price));
					} elseif (in_array('nondiscounted', $rules['total_value'][''])) {
						$product_discount_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = " . (int)$product['product_id'] . " AND customer_group_id = " . (int)($customer_group_id ? $customer_group_id : $this->config->get('config_customer_group_id')) . " AND quantity <= " . (int)$product['quantity'] . " AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
						$totals[$product['key']] = ($product_info['special'] || $product_discount_query->num_rows) ? 0 : $product['total'];
					} elseif (in_array('taxed', $rules['total_value'][''])) {
						$totals[$product['key']] = $this->tax->calculate($product['total'], $product['tax_class_id']);
					}
				}
				if (!isset($totals[$product['key']])) {
					$totals[$product['key']] = $product['total'];
				}
				
				// volume
				$volumes[$product['key']] = $lengths[$product['key']] * $widths[$product['key']] * $heights[$product['key']] * $product['quantity'];
				
				// weight
				$weight_class_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "weight_class WHERE weight_class_id = " . (int)$product['weight_class_id']);
				if ($weight_class_query->num_rows) {
					$weights[$product['key']] = $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('config_weight_class_id'));
				} else {
					$message = $product['name'] . ' (product_id: ' . $product['product_id'] . ') does not have a valid weight class, which causes a "Division by zero" error, and means it cannot be used for weight calculations. You can fix this by re-saving the product data.';
					$this->log->write($message);
					$this->logMessage($message);
					
					$weights[$product['key']] = 0;
				}
				
				// categories
				$category_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = " . (int)$product['product_id']);
				if ($category_query->num_rows) {
					foreach ($category_query->rows as $category) {
						$categorys[$product['key']][] = $category['category_id'];
					}
				} else {
					$categorys[$product['key']][] = 0;
				}
				
				// manufacturer
				$manufacturers[$product['key']][] = $product_query->row['manufacturer_id'];
				
				// products
				$products[$product['key']][] = $product['product_id'];
				
				// Check item criteria (entire cart comparisons)
				foreach ($cart_criteria as $spec) {
					if (isset($rules['adjust']['item_' . $spec])) {
						foreach ($rules['adjust']['item_' . $spec] as $adjustment) {
							${$spec.'s'}[$product['key']] += (strpos($adjustment, '%')) ? ${$spec.'s'}[$product['key']] * (float)$adjustment / 100 : (float)$adjustment;
						}
					}
					
					$spec_value = ${$spec.'s'}[$product['key']];
					if ($spec == 'weight') $spec_value /= $product['quantity'];
					
					if (isset($rules[$spec]['entire_any'])) {
						if (!$this->inRange($spec_value, $rules[$spec]['entire_any'], $spec . ' of any item in entire cart', true)) {
							continue 2;
						}
					}
					
					if (isset($rules[$spec]['entire_every'])) {
						if (!$this->inRange($spec_value, $rules[$spec]['entire_every'], $spec . ' of every item in entire cart', true)) {
							continue 3;
						}
					}
				}
				
				// Check product criteria
				if (isset($rules['category']) && $this->ruleViolation('category', $categorys[$product['key']], $product['name'] . ' (product_id: ' . $product['product_id'] . ')')) {
					continue;
				}
				
				if (isset($rules['manufacturer']) && $this->ruleViolation('manufacturer', $product_query->row['manufacturer_id'], $product['name'] . ' (product_id: ' . $product['product_id'] . ')')) {
					continue;
				}
				
				if (isset($rules['product']) && $this->ruleViolation('product', $product['product_id'], $product['name'] . ' (product_id: ' . $product['product_id'] . ')')) {
					continue;
				}
				
				// Check item criteria (eligible item comparisons)
				foreach ($cart_criteria as $spec) {
					$spec_value = ${$spec.'s'}[$product['key']];
					if ($spec == 'weight') $spec_value /= $product['quantity'];
					
					if (isset($rules[$spec]['any'])) {
						if (!$this->inRange($spec_value, $rules[$spec]['any'], $spec . ' of any item', true)) {
							continue 2;
						}
					}
					
					// rules with "of every item" comparisons are checked after Product Group rules below
				}
				
				// product passed all rules and is eligible for charge
				$product_keys[] = $product['key'];
			}
			
			// Check "Quantity of Product" rules
			if (isset($rules['quantity_of_product'])) {
				$this->commaMerge($rules['quantity_of_product']);
				
				foreach ($rules['quantity_of_product'] as $product_id => $quantity_ranges) {
					$pass = false;
					
					foreach ($cart_products as $product) {
						if ($product['product_id'] == $product_id && $this->inRange($product['quantity'], $quantity_ranges, 'quantity_of_product', true)) {
							$pass = true;
						}
					}
					
					if (!$pass) {
						$product_name = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = " . (int)$product_id . " AND language_id = " . (int)$this->config->get('config_language_id'))->row['name'];
						$this->logMessage('Disabled for violating rule "quantity of ' . $product_name . ' [' . $product_id . '] = ' . implode(',', $quantity_ranges) . '"');
						continue 2;
					}
				}
			}
			
			// Check "Quantity of Group" rules
			if (isset($rules['quantity_of_group'])) {
				$this->commaMerge($rules['quantity_of_group']);
				
				foreach ($rules['quantity_of_group'] as $product_group_id => $quantity_ranges) {
					$pass = false;
					$members_array = array();
					
					foreach ($settings['product_group'][$product_group_id]['member'] as $member) {
						$bracket = strrpos($member, '[');
						$colon = strrpos($member, ':');
						$member_type = substr($member, $bracket + 1, $colon - $bracket - 1);
						$member_id = substr($member, $colon + 1, -1);
						$members_array[$member_type][] = $member_id;
						
						if ($member_type == 'category' && $settings['product_group'][$product_group_id]['subcategories']) {
							$child_category_ids = $this->getChildCategoryIds($member_id);
							foreach ($child_category_ids as $child_category_id) {
								$members_array[$member_type][] = $child_category_id;
							}
						}
					}
					
					$group_quantity = 0;
					
					foreach ($cart_products as $product) {
						foreach ($members_array as $type => $members) {
							if (!empty(${$type.'s'}[$product['key']]) && array_intersect(${$type.'s'}[$product['key']], $members)) {
								$group_quantity += $product['quantity'];
								break;
							}
						}
					}
					
					if (!$this->inRange($group_quantity, $quantity_ranges, 'quantity_of_group', true)) {
						$this->logMessage('Disabled for violating rule "quantity of ' . $settings['product_group'][$product_group_id]['name'] . ' = ' . implode(',', $quantity_ranges) . '"');
						continue 2;
					}
				}
			}
			
			// Check product group rules
			$row_disabled_text = 'Ignored';
			
			if (isset($rules['product_group'])) {
				$list_types = array(
					'category',
					'manufacturer',
					'product',
				);
				
				foreach ($list_types as $list_type) {
					${$list_type . 's_array'} = array();
					foreach (${$list_type . 's'} as $list) {
						${$list_type . 's_array'} = array_merge(${$list_type . 's_array'}, $list);
					}
				}
				
				$eligible_products = array();
				$ineligible_products = array();
				
				foreach ($rules['product_group'] as $comparison => $product_group_ids) {
					$rule_satisfied = false;
					
					foreach ($product_group_ids as $product_group_id) {
						if (empty($settings['product_group'][$product_group_id]['member'])) continue;
						
						$product_group_rule_text = 'cart has items from ' . ($comparison == 'none' ? 'none of the' : $comparison) . ' members of ' . $settings['product_group'][$product_group_id]['name'];
						unset($members_array);
						
						foreach ($settings['product_group'][$product_group_id]['member'] as $member) {
							$bracket = strrpos($member, '[');
							$colon = strrpos($member, ':');
							$member_type = substr($member, $bracket + 1, $colon - $bracket - 1);
							$member_id = substr($member, $colon + 1, -1);
							$members_array[$member_type][] = $member_id;
							
							if ($member_type == 'category' && $settings['product_group'][$product_group_id]['subcategories']) {
								$child_category_ids = $this->getChildCategoryIds($member_id);
								foreach ($child_category_ids as $child_category_id) {
									$members_array[$member_type][] = $child_category_id;
								}
							}
						}
						
						foreach ($members_array as $type => $members) {
							// Check "all", "onlyall", and "none" comparisons
							if (($comparison == 'all' || $comparison == 'onlyall') && array_diff($members, ${$type.'s_array'})) {
								$this->logMessage($row_disabled_text . ' for violating product group rule "' . $product_group_rule_text . '", due to missing ' . $type . '_id(s) "' . implode(', ', array_diff($members, ${$type.'s_array'})) . '"');
								continue 4;
							}
							
							if (($comparison == 'not' || $comparison == 'none') && empty($cart_products)) {
								$rule_satisfied = true;
							}
							
							// Check product eligibility
							foreach ($cart_products as $product) {
								if ($this->type == 'shipping' && !$product['shipping']) {
									continue;
								}
								
								if ($type == 'category') {
									if (($comparison == 'onlyany' || $comparison == 'onlyall') && array_intersect(${$type.'s'}[$product['key']], $members)) {
										$rule_satisfied = true;
										$eligible_products[] = $product['key'];
										continue;
									}
									if ($comparison == 'not' && array_intersect(${$type.'s'}[$product['key']], $members)) {
										$ineligible_products[] = $product['key'];
										continue;
									}
								}
								
								if ((($comparison == 'onlyany' || $comparison == 'onlyall') && array_diff(${$type.'s'}[$product['key']], $members)) ||
									($comparison == 'none' && array_intersect(${$type.'s'}[$product['key']], $members))
								) {
									$this->logMessage($row_disabled_text . ' for violating product group rule "' . $product_group_rule_text . '"');
									continue 5;
								} elseif (($comparison != 'not' && $comparison != 'none' && !array_intersect(${$type.'s'}[$product['key']], $members)) ||
									(($comparison == 'not' || $comparison == 'none') && !array_diff(${$type.'s'}[$product['key']], $members))
								) {
									$ineligible_products[] = $product['key'];
								} else {
									$rule_satisfied = true;
									if ($comparison != 'not' && $comparison != 'none') {
										$eligible_products[] = $product['key'];
									}
								}
							}
						}
					}
					
					// Check that rule has at least one matching product
					if (!$rule_satisfied) {
						$this->logMessage($row_disabled_text . ' for having no eligible products');
						continue 2;
					}
				}
				
				// Remove ineligible products
				foreach ($ineligible_products as $ineligible_key) {
					if (in_array($ineligible_key, $eligible_products)) continue;
					foreach ($product_keys as $index => $product_key) {
						if ($product_key == $ineligible_key) {
							$total_value -= $totals[$product_key];
							unset($product_keys[$index]);
						}
					}
				}
			}
			
			// Check "of every item" rules
			foreach ($product_keys as $index => $product_key) {
				foreach ($cart_criteria as $spec) {
					$spec_value = ${$spec.'s'}[$product_key];
					if ($spec == 'weight') $spec_value /= $product['quantity'];
					
					if (isset($rules[$spec]['every'])) {
						if (!$this->inRange($spec_value, $rules[$spec]['every'], $spec . ' of every item')) {
							continue 3;
						}
					}
				}
			}
			
			// Check for empty product list
			if (empty($product_keys)) {
				$disable_charge = true;
				
				if (!empty($this->session->data['vouchers'])) {
					$disable_charge = false;
					foreach ($rules as $type => $value) {
						if (in_array($type, array('attribute', 'attribute_group', 'category', 'manufacturer', 'option', 'product', 'product_group', 'other_product_data'))) {
							$disable_charge = true;
						}
					}
				}
				
				if ($disable_charge) {
					$this->logMessage($row_disabled_text . ' for having no eligible products');
					continue;
				}
			}
			
			// Check cart criteria and generate total comparison values
			$single_foreign_currency = (isset($rules['currency']['is']) && count($rules['currency']['is']) == 1 && $main_currency != $currency) ? $rules['currency']['is'][0] : '';
			
			foreach ($cart_criteria as $spec) {
				// note: cart_comparison to be added here if requested
				if ($spec == 'total' && isset($rules['total_value']) && in_array('total', $rules['total_value'][''])) {
					$total = $total_value;
					$cart_total = $total_value;
				} else {
					${$spec} = 0;
					foreach ($product_keys as $product_key) {
						if ($spec == 'length' || $spec == 'width' || $spec == 'height') {
							${$spec} += ${$spec.'s'}[$product_key] * $quantitys[$product_key];
						} else {
							${$spec} += ${$spec.'s'}[$product_key];
						}
					}
					${'cart_'.$spec} = array_sum(${$spec.'s'});
				}
				
				if ($spec == 'total' && $single_foreign_currency) {
					$total = $this->currency->convert($total, $main_currency, $single_foreign_currency);
				}
				
				if (isset($rules['adjust']['cart_' . $spec])) {
					foreach ($rules['adjust']['cart_' . $spec] as $adjustment) {
						${$spec} += (strpos($adjustment, '%')) ? ${$spec} * (float)$adjustment / 100 : (float)$adjustment;
						${'cart_'.$spec} += (strpos($adjustment, '%')) ? ${'cart_'.$spec} * (float)$adjustment / 100 : (float)$adjustment;
					}
				}
				
				if (isset($rules[$spec]['cart'])) {
					if (!$this->inRange(${$spec}, $rules[$spec]['cart'], $spec . ' of cart')) {
						continue 2;
					}
				}
				
				if (isset($rules[$spec]['entire_cart'])) {
					if (!$this->inRange(${'cart_'.$spec}, $rules[$spec]['entire_cart'], $spec . ' of entire cart')) {
						continue 2;
					}
				}
			}
			
			// Check distance rules
			$origin_address = (!empty($rules['origin'])) ? $rules['origin'][''][0] : $this->config->get('config_address');
			
			if (isset($rules['distance']) && $origin_address != $distance_origin) {
				$distance = 0;
				$distance_origin = $origin_address;
				
				$store_address = html_entity_decode(preg_replace('/\s+/', '+', $origin_address), ENT_QUOTES, 'UTF-8');
				$settings['google_apikey'] = trim($settings['google_apikey']);
				
				if (!empty($address['geocode'])) {
					$customer_address = $address['geocode'];
				} else {
					$customer_address = $address['address_1'] . ' ' . $address['address_2'] . ' ' . $address['city'] . ' ' . $address['zone'] . ' ' . $address['country'] . ' ' . $address['postcode'];
					$customer_address = html_entity_decode(preg_replace('/\s+/', '+', $customer_address), ENT_QUOTES, 'UTF-8');
				}
				
				if (isset($settings['distance_calculation']) && $settings['distance_calculation'] == 'driving') {
					$directions = $this->curlRequest('https://maps.googleapis.com/maps/api/directions/json?key=' . $settings['google_apikey'] . '&origin=' . $store_address . '&destination=' . $customer_address);
					if (empty($directions['routes'])) {
						sleep(1);
						$directions = $this->curlRequest('https://maps.googleapis.com/maps/api/directions/json?key=' . $settings['google_apikey'] . '&origin=' . $store_address . '&destination=' . $customer_address);
						if (empty($directions['routes'])) {
							$google_error = $directions['status'] . (!empty($directions['error_message']) ? ': ' . $directions['error_message'] : '');
							$this->logMessage('The Google directions service returned the error "' . $google_error . '" for origin "' . $store_address . '" and destination "' . $customer_address . '"');
							continue;
						}
					}
					$distance = $directions['routes'][0]['legs'][0]['distance']['value'] / 1609.344;
				} else {
					if ($this->config->get('config_geocode')) {
						$xy = explode(',', $this->config->get('config_geocode'));
						$x1 = $xy[0];
						$y1 = $xy[1];
					} else {
						$geocode = $this->curlRequest('https://maps.googleapis.com/maps/api/geocode/json?key=' . $settings['google_apikey'] . '&address=' . $store_address);
						if (empty($geocode['results'])) {
							sleep(1);
							$geocode = $this->curlRequest('https://maps.googleapis.com/maps/api/geocode/json?key=' . $settings['google_apikey'] . '&address=' . $store_address);
							if (empty($geocode['results'])) {
								$google_error = $geocode['status'] . (!empty($geocode['error_message']) ? ': ' . $geocode['error_message'] : '');
								$this->logMessage('The Google geocoding service returned the error "' . $google_error . '" for address "' . $store_address . '"');
								continue;
							}
						}
						$x1 = $geocode['results'][0]['geometry']['location']['lat'];
						$y1 = $geocode['results'][0]['geometry']['location']['lng'];
					}
					
					if (!empty($address['geocode'])) {
						$xy = explode(',', $address['geocode']);
						$x2 = $xy[0];
						$y2 = $xy[1];
					} else {
						$geocode = $this->curlRequest('https://maps.googleapis.com/maps/api/geocode/json?key=' . $settings['google_apikey'] . '&address=' . $customer_address);
						if (empty($geocode['results'])) {
							sleep(1);
							$geocode = $this->curlRequest('https://maps.googleapis.com/maps/api/geocode/json?key=' . $settings['google_apikey'] . '&address=' . $customer_address);
							if (empty($geocode['results'])) {
								$google_error = $geocode['status'] . (!empty($geocode['error_message']) ? ': ' . $geocode['error_message'] : '');
								$this->logMessage('The Google geocoding service returned the error "' . $google_error . '" for address "' . $customer_address . '"');
								continue;
							}
						}
						$x2 = $geocode['results'][0]['geometry']['location']['lat'];
						$y2 = $geocode['results'][0]['geometry']['location']['lng'];
					}
					
					$distance = rad2deg(acos(sin(deg2rad($x1)) * sin(deg2rad($x2)) + cos(deg2rad($x1)) * cos(deg2rad($x2)) * cos(deg2rad($y1 - $y2)))) * 60 * 114 / 99;
				}
				
				if (isset($settings['distance_units']) && $settings['distance_units'] == 'km') {
					$distance *= 1.609344;
				}
				$this->logMessage('Calculated distance between ' . $store_address . ' and ' . $customer_address . ' = ' . round($distance, 3) . ' ' . $settings['distance_units']);
			}
			
			if (isset($rules['distance'])) {
				$this->commaMerge($rules['distance']);
				
				foreach ($rules['distance'] as $comparison => $distances) {
					$in_range = $this->inRange($distance, $distances, 'distance' . ($comparison == 'not' ? ' not' : ''));
					
					if (($comparison == 'is' && !$in_range) || ($comparison == 'not' && $in_range)) {
						continue 2;
					}
				}
			}
			
			// All rules have been met, so checkout is restricted
			if (!empty($product_keys)) {
				$messages[] = html_entity_decode($row['checkout_message'], ENT_QUOTES, 'UTF-8');
			}
			
		} // end row loop
		
		if ($messages) {
			$this->logMessage('All rules passed, restricting checkout with the following messages:' . "\n• " . implode("\n• ", $messages));
		}
		
		return $messages;
	}
	
	//==============================================================================
	// Private functions
	//==============================================================================
	private function getSettings() {
		$code = (version_compare(VERSION, '3.0', '<') ? '' : $this->type . '_') . $this->name;
		
		$settings = array();
		$settings_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `code` = '" . $this->db->escape($code) . "' ORDER BY `key` ASC");
		
		foreach ($settings_query->rows as $setting) {
			$value = $setting['value'];
			if ($setting['serialized']) {
				$value = (version_compare(VERSION, '2.1', '<')) ? unserialize($setting['value']) : json_decode($setting['value'], true);
			}
			$split_key = preg_split('/_(\d+)_?/', str_replace($code . '_', '', $setting['key']), -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
			
				if (count($split_key) == 1)	$settings[$split_key[0]] = $value;
			elseif (count($split_key) == 2)	$settings[$split_key[0]][$split_key[1]] = $value;
			elseif (count($split_key) == 3)	$settings[$split_key[0]][$split_key[1]][$split_key[2]] = $value;
			elseif (count($split_key) == 4)	$settings[$split_key[0]][$split_key[1]][$split_key[2]][$split_key[3]] = $value;
			else 							$settings[$split_key[0]][$split_key[1]][$split_key[2]][$split_key[3]][$split_key[4]] = $value;
		}
		
		if (version_compare(VERSION, '4.0', '<')) {
			$settings['extension_route'] = 'extension/' . $this->type . '/' . $this->name;
		} else {
			$settings['extension_route'] = 'extension/' . $this->name . '/' . $this->type . '/' . $this->name;
		}
		
		return $settings;
	}
	
	private function logMessage($message) {
		if ($this->testing_mode) {
			file_put_contents(DIR_LOGS . $this->name . '.messages', print_r($message, true) . "\n", FILE_APPEND|LOCK_EX);
		}
	}
	
	private function getOrderTotals($stop_before = '') {
		$prefix = (version_compare(VERSION, '3.0', '<')) ? '' : 'total_';
		$order_total_extensions = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = 'total' ORDER BY `code` ASC")->rows;
		
		$sort_order = array();
		foreach ($order_total_extensions as $key => $value) {
			$sort_order[$key] = $this->config->get($prefix . $value['code'] . '_sort_order');
		}
		array_multisort($sort_order, SORT_ASC, $order_total_extensions);
		
		$order_totals = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();
		$reference_array = array('totals' => &$order_totals, 'total' => &$total, 'taxes' => &$taxes);
		
		foreach ($order_total_extensions as $ot) {
			if ($ot['code'] == $this->name || $ot['code'] == $stop_before) {
				break;
			}
			if (!$this->config->get($prefix . $ot['code'] . '_status') || $ot['code'] == 'intermediate_order_total') {
				continue;
			}
			
			if (version_compare(VERSION, '2.2', '<')) {
				$this->load->model('total/' . $ot['code']);
				$this->{'model_total_' . $ot['code']}->getTotal($order_totals, $total, $taxes);
			} elseif (version_compare(VERSION, '2.3', '<')) {
				$this->load->model('total/' . $ot['code']);
				$this->{'model_total_' . $ot['code']}->getTotal($reference_array);
			} elseif (version_compare(VERSION, '4.0', '<')) {
				$this->load->model('extension/total/' . $ot['code']);
				$this->{'model_extension_total_' . $ot['code']}->getTotal($reference_array);
			} else {
				$this->load->model('extension/' . $ot['extension'] . '/total/' . $ot['code']);
				$getTotalFunction = $this->{'model_extension_' . $ot['extension'] . '_total_' . $ot['code']}->getTotal;
				$getTotalFunction($order_totals, $taxes, $total);
			}
		}
		
		return $reference_array;
	}
	
	private function curlRequest($url) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 3);
		$response = json_decode(curl_exec($curl), true);
		curl_close($curl);
		return $response;
	}
	
	private function commaMerge(&$rule) {
		$merged_rule = array();
		foreach ($rule as $comparison => $values) {
			$merged_rule[$comparison] = array();
			foreach ($values as $value) {
				$merged_rule[$comparison] = array_merge($merged_rule[$comparison], array_map('trim', explode(',', strtolower($value))));
			}
		}
		$rule = $merged_rule;
	}
	
	private function ruleViolation($rule, $value, $product_name = '') {
		$violation = false;
		$rules = $this->row['rules'];
		$function = (is_array($value)) ? 'array_intersect' : 'in_array';
		
		if (isset($rules[$rule]['after']) && strtotime($value) < min(array_map('strtotime', $rules[$rule]['after']))) {
			$violation = true;
			$comparison = 'after';
		}
		if (isset($rules[$rule]['before']) && strtotime($value) > max(array_map('strtotime', $rules[$rule]['before']))) {
			$violation = true;
			$comparison = 'before';
		}
		if (isset($rules[$rule]['is']) && !$function($value, $rules[$rule]['is'])) {
			$violation = true;
			$comparison = 'is';
		}
		if (isset($rules[$rule]['not']) && $function($value, $rules[$rule]['not'])) {
			$violation = true;
			$comparison = 'not';
		}
		
		if ($violation) {
			if ($product_name) {
				$this->logMessage($product_name . ' was ignored for violating rule "' . $rule . ' ' . $comparison . ' ' . implode(', ', $rules[$rule][$comparison]) . '" with value "' . (is_array($value) ? implode(',', $value) : $value) . '"');
			} else {
				$this->logMessage('Disabled for violating rule "' . $rule . ' ' . $comparison . ' ' . implode(', ', $rules[$rule][$comparison]) . '" with value "' . (is_array($value) ? implode(',', $value) : $value) . '"');
			}
		}
		
		return $violation;
	}
	
	private function inRange($value, $range_list, $charge_type = '', $skip_testing = false) {
		$in_range = false;
		
		foreach ($range_list as $range) {
			if ($range == '') continue;
			
			$range = (strpos($range, '::')) ? explode('::', $range) : explode('-', $range);
			
			if (strpos($charge_type, 'distance') === 0) {
				if (empty($range[1])) {
					array_unshift($range, 0);
				}
				if ($value >= (float)$range[0] && $value <= (float)$range[1]) {
					$in_range = true;
				}
			} elseif (strpos($charge_type, 'postcode') === 0) {
				$postcode = preg_replace('/[^A-Z0-9]/', '', strtoupper($value));
				$from = preg_replace('/[^A-Z0-9]/', '', strtoupper($range[0]));
				$to = (isset($range[1])) ? preg_replace('/[^A-Z0-9]/', '', strtoupper($range[1])) : $from;
				
				if (strlen($from) < 3 && !preg_match('/[0-9]/', $from)) $from .= '1';
				if (strlen($to) < 3 && !preg_match('/[0-9]/', $to)) $to .= '99';
				
				if (strlen($from) < strlen($postcode)) $from = str_pad($from, max(strlen($postcode), strlen($from) + 3), ' ');
				if (strlen($to) < strlen($postcode)) $to = str_pad($to, max(strlen($postcode), strlen($to) + 3), preg_match('/[A-Z]/', $postcode) ? 'Z' : '9');
				
				$postcode = substr_replace(substr_replace($postcode, ' ', -3, 0), ' ', -2, 0);
				$from = substr_replace(substr_replace($from, ' ', -3, 0), ' ', -2, 0);
				$to = substr_replace(substr_replace($to, ' ', -3, 0), ' ', -2, 0);
				
				if (strnatcasecmp($postcode, $from) >= 0 && strnatcasecmp($postcode, $to) <= 0) {
					$in_range = true;
				}
			} else {
				if (!isset($range[1]) && $charge_type != 'attribute' && $charge_type != 'custom_field' && strpos($charge_type, 'customer_data') !== 0 && $charge_type != 'option' && $charge_type != 'other product data') {
					$range[1] = 999999999;
				}
				
				if ((count($range) > 1 && $value >= $range[0] && $value <= $range[1]) || (count($range) == 1 && $value == $range[0])) {
					$in_range = true;
				}
			}
		}
		
		if (empty($value) && empty($range_list[0])) {
			$in_range = true;
		}
		
		if (!$skip_testing) {
			if (strpos($charge_type, ' not') ? $in_range : !$in_range) {
				$this->logMessage('Disabled for violating rule "' . $charge_type . (strpos($charge_type, ' not') ? ' ' : ' is ') . implode(', ', $range_list) . '" with value "' . $value . '"');
			}
		}
		
		return $in_range;
	}
	
	private function getChildCategoryIds($parent_id) {
		$child_ids = array();
		$child_categories = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE parent_id = " . (int)$parent_id)->rows;
		foreach ($child_categories as $child_category) {
			$child_ids[] = $child_category['category_id'];
			$child_ids = array_merge($child_ids, $this->getChildCategoryIds($child_category['category_id']));
		}
		return array_unique($child_ids);
	}
	
	// extension-specific
	public function hasLocationRestrictions() {
		$settings = $this->getSettings();
		
		$location_rules = array('address', 'city', 'country', 'distance', 'geo_zone', 'postcode', 'zone');
		
		foreach ($settings['restriction'] as $row) {
			foreach ($row['rule'] as $rule) {
				if (in_array($rule['type'], $location_rules)) {
					return true;
				}
			}
		}
		
		return false;
	}
}
?>