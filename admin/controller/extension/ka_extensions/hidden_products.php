<?php
/*
	$Project: Hidden Products $
	$Author: karapuz team <support@ka-station.com> $
	$Version: 1.0.2 $ ($Revision: 17 $)
*/
namespace extension\ka_extensions;

class ControllerHiddenProducts extends \KaInstaller {

	protected $extension_version = '1.0.2.0';
	protected $min_store_version = '3.0.0.0';
	protected $max_store_version = '3.0.3.9';
	protected $min_ka_extensions_version = '4.1.0.22';
	protected $max_ka_extensions_version = '4.1.1.9';
		
	protected $tables;

	public function getTitle() {
		$str = str_replace('{{version}}', $this->extension_version, $this->language->get('heading_title_ver'));
		return $str;
	}

	protected function onLoad() {
		$this->load->language('extension/ka_extensions/hidden_products');

 		$this->tables = array(
 			'product' => array(
 				'fields' => array(
 					'is_hidden_product' => array(
 						'type' => 'tinyint(1)',
 						'query' => "ALTER TABLE `" . DB_PREFIX . "product` ADD `is_hidden_product` TINYINT(1) NOT NULL DEFAULT '0'"
 					),
 				),
 				'indexes' => array(
 					'model' => array()
 				)
 			),
		);

		return true;
	}

	public function index() {

		$heading_title = $this->getTitle();
		$this->document->setTitle($heading_title);
		
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		
			$this->model_setting_setting->editSetting('ka_hidden_products', $this->request->post);
			$this->addTopMessage($this->language->get('Settings have been stored sucessfully.'));
			
			$this->response->redirect($this->url->link('marketplace/extension', 'type=ka_extensions&user_token=' . $this->session->data['user_token'], true));
		}
				
		$this->data['heading_title']   = $heading_title;
	
		$this->data['button_save']     = $this->language->get('button_save');
		$this->data['button_cancel']   = $this->language->get('button_cancel');
		$this->data['extension_version']  = $this->extension_version;
		
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], true),
			'separator' => false
		);
  		$this->data['breadcrumbs'][] = array(
	 		'text'      => $this->language->get('Ka Extensions'),
			'href'      => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true),
   			'separator' => ' :: '
 		);
		
 		$this->data['breadcrumbs'][] = array(
	 		'text'      => $heading_title,
			'href'      => $this->url->link('extension/ka_extensions/hidden_products', 'user_token=' . $this->session->data['user_token'], true),
   			'separator' => ' :: '
 		);
		
		$this->data['action'] = $this->url->link('extension/ka_extensions/hidden_products', 'user_token=' . $this->session->data['user_token'], true);
		$this->data['cancel'] = $this->url->link('marketplace/extension', 'type=ka_extensions&user_token=' . $this->session->data['user_token'], true);

		$this->template = 'extension/ka_extensions/hidden_products/settings';
		$this->children = array(
			'common/header',
			'common/column_left',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	
	protected function validate() {
	
		if (!$this->user->hasPermission('modify', 'extension/ka_extensions/hidden_products')) {
			$this->addTopMessage($this->language->get('error_permission'), 'E');
			
			return false;
		}

		return true;		
	}

	
	public function install() {

		if (parent::install()) {
			$this->load->model('user/user_group');
			
			// no new permissions needed

			return true;
		}
		
		return false;
	}
	

	public function uninstall() {
		return true;
	}
}

class_alias(__NAMESPACE__ . '\ControllerHiddenProducts', 'ControllerExtensionKaExtensionsHiddenProducts');