<?php
/* 
 $Project: Ka Extensions $
 $Author: karapuz team <support@ka-station.com> $
 $Version: 4.1.0.26 $ ($Revision: 245 $) 
*/

class ControllerExtensionExtensionKaExtensions extends KaController {

	protected $tables;
	protected $infolog;

	protected function onLoad() {
	
		$this->infolog = new \Log('ka_extensions.log');
	
		$this->load->language('extension/extension/ka_extensions');
		if (!method_exists($this->load, 'kamodel')) {
			$modifications_link = $this->url->link('marketplace/modification', 'user_token=' . $this->session->data['user_token'], true);
			echo 'The modifications cache is not complete or empty. Refresh the modifications cache on the <a href="' . $modifications_link . '">Modifications</a> page. <br />If it does not help, 
			install <a href="https://www.opencart.com/index.php?route=marketplace/extension/info&extension_id=31427">the latest ka-extensions library</a> from Opencart marketplace.';
			die;
		}
		$this->load->kamodel('extension/ka_extensions');
		
		$this->load->model('setting/extension');
		$this->load->model('setting/setting');
		$this->load->model('setting/modification');

 		$this->tables = array(
 			'extension' => array(
 				'fields' => array(
 					'show_related' => array(
 						'type' => 'tinyint(1)',
 						'query' => "ALTER TABLE `" . DB_PREFIX . "extension` ADD `show_related` TINYINT(1) NOT NULL DEFAULT '0'"
 					),
 				),
 			),
		);
		
		$messages = array();
		if (!$this->model_extension_ka_extensions->checkDBCompatibility($this->tables, $messages)) {
			die('Sorry, the database is not compatible with Ka-Extensions.');
		}
		if (!$this->model_extension_ka_extensions->patchDB($this->tables, $messages)) {
			die('Sorry, the database cannot be patched for Ka-Extensions.');
		}
		
		return parent::onLoad();
	}
	

	public function index() {
	
		$messages = array();
		if ($this->model_extension_ka_extensions->checkDBCompatibility($this->tables, $messages)) {
			if (!$this->model_extension_ka_extensions->patchDB($this->tables, $messages)) {
				$this->addTopMessage($messages, "E");
			}
		} else {
			$this->addTopMessage($messages, "E");
		}
	
		$this->getList();
	}
	
			
	public function getList() {
		
		$this->updateInfoByDomain();
	
		$this->data['heading_title']   = $this->language->get('heading_title');
		$this->data['text_confirm']    = $this->language->get('text_confirm');

		$this->data['extension_version'] = \KaInstaller::$ka_extensions_version;
		
		$this->document->setTitle($this->data['heading_title']);
		
		$this->data['http_catalog'] = HTTP_CATALOG;
		$this->data['oc_version']   = VERSION;
		
		$installed_extensions = $this->model_extension_ka_extensions->getKaInstalled('ka_extensions');
		$installed_extension_codes = array_keys($installed_extensions);
		
		foreach ($installed_extensions as $key => $value) {
			if (!file_exists(DIR_APPLICATION . 'controller/extension/ka_extensions/' . $key . '.php')) {
				$this->model_setting_extension->uninstall('ka_extensions', $key);				
				unset($installed_extensions[$key]);
			}
		}
	
		$this->data['extensions'] = array();
		$files = glob(DIR_APPLICATION . 'controller/extension/ka_extensions/*.php');

		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');
				
				$this->load->language('ka_extensions/' . $extension);

				require_once(modification(DIR_APPLICATION . 'controller/extension/ka_extensions/' . $extension . '.php'));
				$class = 'ControllerExtensionKaExtensions' . str_replace('_', '', $extension);
				$class = new $class($this->registry);

				if (method_exists($class, 'getTitle')) {
					$heading_title = $class->getTitle();
				} else {
					$heading_title = $this->language->get('heading_title');
				}
				
				$modification = $this->model_setting_modification->getModificationByCode($extension);
				if (empty($modification)) {
					$modification = $this->model_setting_modification->getModificationByCode('ka_' . $extension);
				}
								
				$action = array();
				
				$ext = array(
					'name'      => $heading_title,
					'extension' => $extension,
				);
				
				// get a link to an external extension page
				//
				if (!empty($modification['link'])) {
					$ext['ext_link'] = $modification['link'];
				}
				if (empty($ext['ext_link'])) {
					if (method_exists($class, 'getExtLink')) {
						$ext['ext_link'] = $class->getExtLink();
					}
				}
				if (method_exists($class, 'getDocsLink')) {
					$ext['docs_link'] = $class->getDocsLink();
				}
				
				if (!empty($installed_extensions[$extension])) {				
					$ext['show_related'] = (!empty($installed_extensions[$extension]['show_related'])) ? true : false;
				}
				
				$ext['is_registered'] = $this->model_extension_ka_extensions->isRegistered($extension);

				$ext = array_merge($ext, $this->model_extension_ka_extensions->getExtensionInfoByObject($class, $heading_title));

				$ext = array_merge($ext, $this->model_extension_ka_extensions->getExtensionInfo($extension));

				if (!empty($ext['expiry_date'])) {
					$ext['expiry_date'] = date($this->language->get('date_format_long'), strtotime($ext['expiry_date']));
				}
				
				if (!in_array($extension, $installed_extension_codes)) {
					$action['install'] = array(
						'text' => $this->language->get('button_install'),
						'href' => $this->url->link('extension/extension/ka_extensions/install', 'user_token=' . $this->session->data['user_token'] . '&extension=' . $extension, true)
					);
					
				} else {
					$ext['is_installed'] = true;
					$action['edit'] = array(
						'text' => $this->language->get('button_edit'),
						'href' => $this->url->link('extension/ka_extensions/' . $extension . '', 'user_token=' . $this->session->data['user_token'], true)
					);
					
					$action['uninstall'] = array(
						'text' => $this->language->get('button_uninstall'),
						'href' => $this->url->link('extension/extension/ka_extensions/uninstall', 'user_token=' . $this->session->data['user_token'] . '&extension=' . $extension, true)
					);
				}
				
				$ext['action'] = $action;

				$this->data['extensions'][] = $ext;
			}
		}

		$this->data['activate_action'] = $this->url->link('extension/extension/ka_extensions/input_key', 'user_token=' . $this->session->data['user_token'], true);
		
		$this->data['breadcrumbs'] = array();
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module', 'user_token=' . $this->session->data['user_token'], true)
		);

		$this->data['ka_station_url'] = \KaGlobal::getKaStoreURL();

		$this->data['user_token'] = $this->session->data['user_token'];
		$this->template = 'extension/extension/ka_extensions';
		$this->children = array();
		$this->response->setOutput($this->render());
	}

	
	public function install() {

		if ($this->validate()) {	
			$success = $this->load->controller('extension/ka_extensions/' . $this->request->get['extension'] . '/install');
			if ($success) {
				$this->model_setting_extension->install('ka_extensions', $this->request->get['extension']);

				$this->load->model('user/user_group');
				$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/ka_extensions/' . $this->request->get['extension']);
				$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/ka_extensions/' . $this->request->get['extension']);
				
				$this->addTopMessage($this->language->get('installation_successful'));
			} else {
				$this->addTopMessage($this->language->get("installation_failed"), 'E');
			}
		}

		$this->children = array();
		$this->getList();			
	}

	
	public function uninstall() {

		if ($this->validate()) {
			$this->model_setting_extension->uninstall('ka_extensions', $this->request->get['extension']);

			$success = $this->load->controller('extension/ka_extensions/' . $this->request->get['extension'] . '/uninstall');
			if ($success) {
				$this->addTopMessage($this->language->get('uninstallation_successful'));
			} else {
				$this->addTopMessage($this->language->get('uninstallation_failed'), 'E');
			}
		}		
		
		$this->children = array();
		$this->getList();			
	}

		
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/extension/ka_extensions')) {
			$this->addTopMessage($this->language->get('error_permission'));
			return false;
		}

		return true;
	}
	

	/*
		This function shows a 'License Registration' dialog
	*/	
	public function inputKey() {	
	
		$this->data['user_token'] = $this->session->data['user_token'];
		$this->data['extension'] = $this->request->get['extension'];
	
		$this->template = 'extension/ka_extensions/ka_ext/input_key';
		$this->response->setOutput($this->render());
	}
	

	/*
		This function processes input of 'Extension Registration' dialog
	*/
	public function activateKey() {

		$json = array();
	
		$key       = $this->request->post['license_key'];
		$extension = $this->request->post['extension'];
		
		if ($this->model_extension_ka_extensions->registerKey($key, $extension)) {
			$json['redirect'] = $this->url->link('marketplace/extension', '', true) . '&type=ka_extensions&user_token=' . $this->session->data['user_token'];
			$this->addTopMessage('The license key was validated successfully.');
			$this->response->addHeader('Content-Type: application/json');	
			$this->response->setOutput(json_encode($json));
			return;
		}

		$json['error'] = $this->model_extension_ka_extensions->getLastError();
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	/*	
		Retrieve all extension information by domain.
		
		At this time it is supposed to return an array of registered extensions only. But maybe
		it will change in the future.
		
	*/
	protected function getInfoByDomain() {
	
		$kacurl = new \KaCurl();
		
		$request_url = \KaGlobal::getKaStoreURL() . "?route=extension/domain_info";
		
		$data = array(
			'url' => HTTP_CATALOG
		);
		$result = $kacurl->request($request_url, $data);
		
		$info = var_export($request_url, true) . var_export($result, true) . var_export($data, true);
		
		// process the response from the remote server
		//
		if (empty($result)) {
			$this->lastError = 'A request to the license registration server failed with this error:'
				. $kacurl->getLastError();
				

			$this->infolog->write($this->lastError . ' extra:' . $info);
				
			return null;
		}
		
		$result = json_decode($result, true);
		if (!empty($result['error'])) {
			$this->lastError = $result['error'];
			return null;
		}

		if (empty($result['result']) || $result['result'] != 'ok') {
			$this->lastError = 'Server response does not contain a successful result.';
			return null;
		}
		
		if (!isset($result['extensions'])) {
			$this->lastError = 'Unknwon result format.';
			return null;
		}

		return $result['extensions'];
	}
	
	/*
		This function is called periodically to update the registration information of all extensions
		in the database. An updated info is retrieved from the ka-station server.
	*/
	protected function updateInfoByDomain() {
		$registered_extensions = $this->getInfoByDomain();
		
		if (!$this->model_extension_ka_extensions->saveRegAll($registered_extensions)) {
			$this->infolog->write("saveReg failed." . $this->model_extension_ka_extensions->getLastError());
			return false;
		}
		
		return true;
	}
	
	
	public function updateRelated() {
	
		$related = $this->request->post;
		$this->model_extension_ka_extensions->updateRelated($related);
		
		$json = array();
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}