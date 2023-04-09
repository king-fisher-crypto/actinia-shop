<?php
/**
 * @total-module	Product Options To Category List
 * @author-name 	◘ Dotbox Creative
 * @copyright		Copyright (C) 2014 ◘ Dotbox Creative www.dotbox.eu
 */
class ControllerExtensionModuleOptionsToList extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('extension/module/options_to_list');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('options_to_list', $this->request->post);	

			//oc list fix
			$this->request->post['module_options_to_list_status'] = $this->request->post['options_to_list_status'];
			$this->model_setting_setting->editSetting('module_options_to_list', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}
		
		/*$language_info = array(
		'heading_title',					'button_save',				'button_cancel',				'tab_general',
		'tab_config',						'text_enabled',				'text_disabled',				'entry_status',		   
		'text_edit',						'tab_info',
		'entry_ot_quantity', 				'entry_ot_select', 			'entry_ot_radio', 				'entry_ot_checkbox', 
		'entry_ot_image', 					'entry_ot_time', 			'entry_ot_datetime',		 	'entry_ot_file', 
		'entry_ot_textarea', 				'entry_ot_text',			'entry_ot_date', 				'entry_label',
		'entry_image_width',				'entry_image_height',		'button_catlist',				'button_catlist_btn',
		'error_permission',					'button_catlist_btn_off'
		//lang update
		,'tab_language','lan_quantity','lan_qty','entry_name_quantity','entry_name_qty'
		);*/

		//lang update
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		//

		/*foreach ($language_info as $language) {
			$data[$language] = $this->language->get($language); 
		}

		$language_info_tooltips = array(
		'entry_ot_quantity_info', 			'entry_ot_select_info', 	'entry_ot_radio_info', 		'entry_ot_checkbox_info', 
		'entry_ot_image_info', 				'entry_ot_time_info', 		'entry_ot_datetime_info',	'entry_ot_file_info', 
		'entry_ot_textarea_info', 			'entry_ot_text_info',		'entry_ot_date_info',  		'entry_label_info',
		'entry_image_width_info',			'entry_image_height_info',	'button_catlist_info',		'button_catlist_info_off'
		);

		foreach ($language_info_tooltips as $tooltip) {
			$data[$tooltip] = $this->language->get($tooltip); 
		}
		*/


		/// quantity options
		$disabled = $this->config->get('quantity_options_to_catlist');
		$data['disabled'] = !$disabled;

		$language_info_qty = array(
		'entry_ot_select_qty', 			'entry_ot_radio_qty', 				'entry_ot_checkbox_qty',   'entry_ot_checkboximg_qty', 
		'entry_ot_image_qty', 			'entry_image_width_qty',			'entry_image_height_qty',	'entry_label_qty'		
		);

		foreach ($language_info_qty as $language_qty) {
			$data[$language_qty] = $this->language->get($language_qty); 
		}


		$language_info_tooltips_qty = array(
		'entry_ot_select_info_qty', 	'entry_ot_radio_info_qty', 		'entry_ot_checkbox_info_qty', 'entry_ot_checkboximg_info_qty',
		'entry_ot_image_info_qty', 		'entry_image_width_info_qty',	'entry_image_height_info_qty', 'entry_label_info_qty',
		'entry_checkbox_width_info_qty',	'entry_checkbox_height_info_qty'
		);

		if ($disabled) {
			foreach ($language_info_tooltips_qty as $tooltip_qty) {
				$data[$tooltip_qty] = $this->language->get($tooltip_qty); 
			} 
		} else {
			foreach ($language_info_tooltips_qty as $tooltip_qty) {
				$data[$tooltip_qty] = $this->language->get('entry_disabled'); 
			} 
			$data['entry_disabled'] = $this->language->get('entry_disabled'); 
		}	
		///


		$this->load->model('extension/module/options_to_list');
		$data['user_token'] = $this->session->data['user_token'];
    
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
 		if (isset($this->error['folder'])) {
			$data['error_folder'] = $this->error['folder'];
		} else {
			$data['error_folder'] = '';
		}    
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/options_to_list', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/options_to_list', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		// simple imput fields
		$imput_fields = array(
		'options_to_list_status', 'options_to_list_quantity', 'options_to_list_select',	'options_to_list_radio', 
		'options_to_list_checkbox', 'options_to_list_image', 'options_to_list_datetime', 'options_to_list_file', 
		'options_to_list_textarea', 'options_to_list_text', 'options_to_list_time', 'options_to_list_date',	

		'options_to_list_quantity_label', 'options_to_list_select_label',	'options_to_list_radio_label', 
		'options_to_list_checkbox_label', 'options_to_list_image_label', 'options_to_list_datetime_label', 
		'options_to_list_file_label', 'options_to_list_textarea_label', 'options_to_list_text_label', 
		'options_to_list_time_label', 'options_to_list_date_label'	
		);
		
		foreach ($imput_fields as $imput_field) {
			if (isset($this->request->post[$imput_field])) {
			   $data[$imput_field] = $this->request->post[$imput_field];
			} else {
			   $data[$imput_field] = $this->config->get($imput_field);
			}		
		}

		/// quantity options
		$imput_fields_qty = array(
		'options_to_list_select_qty', 'options_to_list_radio_qty', 'options_to_list_checkbox_qty', 'options_to_list_image_qty',
		'options_to_list_select_label_qty',	'options_to_list_radio_label_qty', 'options_to_list_checkboximg_qty',
		'options_to_list_checkbox_label_qty', 'options_to_list_image_label_qty', 'options_to_list_checkboximg_label_qty',
		);
		
		foreach ($imput_fields_qty as $imput_field_qty) {
			if (isset($this->request->post[$imput_field])) {
			   $data[$imput_field_qty] = $this->request->post[$imput_field_qty];
			} else {
			   $data[$imput_field_qty] = $this->config->get($imput_field_qty);
			}		
		}
		////

		// special imput fields
		$imput_fields_special = array(
		'options_to_list_image_width' => 40, 						'options_to_list_image_height' => 40,
		'options_to_list_image_width_qty' => 40, 					'options_to_list_image_height_qty' => 40,
		'options_to_list_check_width_qty' => 40, 					'options_to_list_check_height_qty' => 40,
		//lang update
		'options_to_list_language' => array(),
		);
		
		foreach ($imput_fields_special as $imput_fields_special => $value) {
			if (isset($this->request->post[$imput_fields_special])) {
			$data[$imput_fields_special] = $this->request->post[$imput_fields_special];
			} else if($this->config->get($imput_fields_special)){
			$data[$imput_fields_special] = $this->config->get($imput_fields_special);
			} else {
			$data[$imput_fields_special] = $value;	
			}	
		}

		// correcting imput values min 0
		$corrections = array('options_to_list_image_width', 'options_to_list_image_height',);
		$data['dotbox'] = $this->model_extension_module_options_to_list->getplist();
		foreach ($corrections as $correction) {
			if ($data[$correction] < 0) {
			$data[$correction] = 0;
			}
		}

		
		// RENDER
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/options_to_list', $data));
	}
	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/options_to_list')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	
	public function enableCatoptions() { 
	 	if ($this->validate()) {
	 		$this->load->language('extension/module/options_to_list');
           	$sql = "UPDATE `" . DB_PREFIX . "product_option` set `catlist` = '1'";
           	$this->db->query($sql);
			$output = $this->language->get('catoptions_set_success');	
			$this->response->setOutput($output);
		}
	 }

	 public function disableCatoptions() { 
	 	if ($this->validate()) {
	 		$this->load->language('extension/module/options_to_list');
           	$sql = "UPDATE `" . DB_PREFIX . "product_option` set `catlist` = '0'";
           	$this->db->query($sql);
			$output = $this->language->get('catoptions_set_success');	
			$this->response->setOutput($output);
		}
	 } 


	public function install(){
		/*@mail('options_to_list@dotbox.eu','Options to Category List installed',HTTP_CATALOG.'  -  '.$this->config->get('config_name')."\r\n mail: ".$this->config->get('config_email')."\r\n".'version-'.VERSION."\r\n".'IP - '.$this->request->server['REMOTE_ADDR'],'MIME-Version:1.0'."\r\n".'Content-type:text/plain;charset=UTF-8'."\r\n".'From:'.$this->config->get('config_owner').'<'.$this->config->get('config_email').'>'."\r\n");*/

		$this->checkFieldCatlist();
	}

	public function checkFieldCatlist() {
              $hasModelAtribute = FALSE;
              $result = $this->db->query( "DESCRIBE `".DB_PREFIX."product_option`;" );
                foreach ($result->rows as $row) {
                 if ($row['Field'] == 'catlist') {
                  $hasModelAtribute = TRUE;
                  break;
                }
              }
              if (!$hasModelAtribute) {
               $sql = "ALTER TABLE `".DB_PREFIX."product_option` ADD `catlist` TinyInt(1) DEFAULT 0";
               $this->db->query( $sql );
              }
    }



}

?>