<?php
/*
	$Project: Ka Extensions $
	$Author: karapuz team <support@ka-station.com> $

	$Version: 4.1.0.26 $ ($Revision: 250 $)
*/

class ModelExtensionKaExtensions extends KaModel {
	protected $settings;
	protected $kacurl;
	
	protected function onLoad() {

		$this->load->model('setting/setting');
		$this->settings = $this->model_setting_setting->getSetting('ka_extensions');
		
		$this->kacurl = new \KaCURL();
		
		return parent::onLoad();
	}
	
	/*
		Compatible db may be fully patched or not patched at all. Partial changes are
		treated as a corrupted db.

		The method extends tables information with an 'exists' flag for existing elements.
		
		Returns
			true  - db is compatible
			false - db is not compatible

	*/
	public function checkDBCompatibility(&$tables, &$messages) {
		$messages = array();

		if (empty($tables)) {
			return true;
		}

		foreach ($tables as $tk => $tv) {

			$tbl = DB_PREFIX . $tk;
			$res = $this->kadb->safeQuery("SHOW TABLES LIKE '$tbl'");

			if (!empty($res->rows)) {
				$tables[$tk]['exists'] = true;
			} else {
				continue;
			}

			$fields = $this->kadb->safeQuery("DESCRIBE `$tbl`");
			if (empty($fields->rows)) {
				$messages[] = "Table '$tbl' exists in the database but it is empty.";
				return false;
			}

			// check fields 

			$db_fields = array();
			foreach ($fields->rows as $v) {
				$db_fields[$v['Field']] = array(
					'type'  => $v['Type']
				);
			}

			foreach ($tv['fields'] as $fk => $field) {
			
				if (empty($db_fields[$fk])) {
					continue;
				}

				// if the field is found we validate its type

				$db_field = $db_fields[$fk];
				
/* we disable type checking for now because integer types do not have numbers anymore
				if ($field['type'] != $db_field['type']) {
					if (empty($field['query_change'])) {
						$messages[] = "Field type '$db_field[type]' for '$fk' in the table '$tbl' does not match the required field type '$field[type]'.";
						return false;
					} else {
						$tables[$tk]['fields'][$fk]['exists_different'] = true;
					}
				} else {
					$tables[$tk]['fields'][$fk]['exists'] = true;
				}
*/				
				$tables[$tk]['fields'][$fk]['exists'] = true;
			}

			// check indexes
			/*
				We do not compare index fields yet, just ensure that the index with the appropriate
				name exists for the table.
			*/
			if (!empty($tv['indexes'])) {

				$rec = $this->kadb->safeQuery("SHOW INDEXES FROM `$tbl`");
				$db_indexes = array();
				foreach ($rec->rows as $v) {
					$db_indexes[$v['Key_name']]['columns'][] = $v['Column_name'];
				}

				foreach ($tv['indexes'] as $ik => $index) {
					if (!empty($db_indexes[$ik])) {
						$tables[$tk]['indexes'][$ik]['exists'] = true;
					}
				}
			}
		}

		return true;
	}

			
	public function patchDB($tables, &$messages) {
		$messages = array();
		
		if (empty($tables)) {
			return true;
		}

		$this->db->query("SET sql_mode = ''");
		
		foreach ($tables as $tk => $tv) {
			if (empty($tv['exists'])) {
				$this->kadb->safeQuery($tv['query']);
				continue;
			}

			if (!empty($tv['fields'])) {
				foreach ($tv['fields'] as $fk => $fv) {
					if (empty($fv['exists'])) {
					
						if (!empty($fv['exists_different'])) {

							if (!empty($fv['query_change'])) {
								$this->kadb->safeQuery($fv['query_change']);
							} else {
								$messages[] = "Installation error. The field with a different type cannot be changed: " . $tk . "." . $fk;
								return false;
							}
							continue;
							
						} else if (!empty($fv['query'])) {
							$this->kadb->safeQuery($fv['query']);
							continue;
						}
						
						$messages[] = "Installation error. Cannot create '$tk.$fk' field.";
						return false;
					}
				}
			}

			if (!empty($tv['indexes'])) {
				foreach ($tv['indexes'] as $ik => $iv) {
					if (empty($iv['exists']) && !empty($iv['query'])) {
						$this->kadb->safeQuery($iv['query']);
					}
				}
			}
		}
	
		return true;
	}
	
	
	public function getExtensionInfo($extension) {
	
		$return = array();
	
		$ka_reg = $this->model_setting_setting->getSetting('kareg');

		$idx = 'kareg' . $extension;
		
		if (empty($ka_reg) || empty($ka_reg[$idx])) {
			return $return;
		}
		
		return $ka_reg[$idx];
	}
	
	
	public function getExtensionInfoByObject($class, $heading_title = '') {

		$ext_info = array(
			'name'    => '',
			'version' => '',
		);

		// retrieve version and name from old headers
		//
		if (preg_match("/(.*)[\(]*ver\.(.*)[\)]*$/U", $heading_title, $matches)) {
			$ext_info['name']    = trim(preg_replace("/ver$/", "", preg_replace("/\(.*/", "", trim($matches[1]))));
			$ext_info['version'] = trim(preg_replace("/\(\)/", "", trim($matches[2])), '.');
		} else {
			$ext_info['name'] = $heading_title;
			$ext_info['version'] = '';
		}
			
		// get version with a method when available
		//
		if (method_exists($class, 'getVersion')) {
			if (empty($ext_info['name'])) {
				$ext_info['name'] = $heading_title;
			}
			$ext_info['version'] = $class->getVersion();
		}
		
		if (method_exists($class, 'isFree')) {
			$ext_info['is_free'] = $class->isFree();
		}

		return $ext_info;
	}
	
	
	public function updateRelated($related) {
	
		if (empty($related)) {
			return false;
		}
		
		foreach ($related as $k => $v) {
			$this->db->query("UPDATE " . DB_PREFIX . "extension SET show_related = " . (int)$v . " 
				WHERE code = '" . $this->db->escape($k) . "'"
			);
		}
	}
	
	public function getKaInstalled($type = 'ka_extensions') {
		$extension_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension 
			WHERE `type` = '" . $this->db->escape($type) . "'
		");
		
		if (empty($query->rows)) {
			return $extension_data;
		}
		
		foreach ($query->rows as $row) {
			$extension_data[$row['code']] = $row;
		}
		
		return $extension_data;
	}
	
	
/*
	Returns

		$ka_st_data = array(
			'result' => 'OK'
		);

		$ka_st_data = array(
			'result'  => 'ERROR',
			'message' => 'The code is not valid.'
		);
	
*/	
	public function registerKey($key, $extension) {

		$ret = '';
		
		// send code to the remote server
		//
		$data = array(
			'key'       => $key,
			'url'       => HTTP_CATALOG,
			'extension' => $extension,
		);
		
		$request_url = \KaGlobal::getKaStoreURL() . '?route=extension/register_key';

		$result = $this->kacurl->request($request_url, $data);

		// process the response from the remote server
		//
		if (empty($result)) {
			$this->lastError = 'A request to the license registration server failed with this error:' 
				. $this->kacurl->getLastError()
				. '<br />Please try again later.<br /><br />If you cannot activate the license key within 3 ' 
				. 'days please contact us at support@ka-station.com.
			';
				
			return false;
		} 
		
		$result = json_decode($result, true);		
		if (!empty($result['error'])) {
			$this->lastError = $result['error'];
			return false;
		}	

		
		if (empty($result['ext_code'])) {
			$this->lastError = 'Wrong request parameters:' . var_export($result, true);
			return false;
		}
		
		$data['is_registered'] = true;
		if (!$this->saveReg($result['ext_code'], $data)) {
			$this->lastError = 'saveReg failed';
			return false;
		}
		
		return true;
	}
	

	
	
	public function isRegistered($extension_code) {
		$ka_reg = $this->model_setting_setting->getSetting('kareg');

		if (empty($ka_reg)) {
			return false;
		}

		if (isset($ka_reg['kareg' . $extension_code]['is_registered'])) {
			return true;
		}
		
		return false;
	}

		
	public function saveRegAll($data = array()) {

		if ($data === null) {
			return true;
		}
		
		// get installed extensions
		//
		$installed_extensions = $this->getKaInstalled('ka_extensions');
		$installed_extension_codes = array_keys($installed_extensions);
		
		$url = HTTP_CATALOG;
		$kareg = array(
			'kareg' => 1
		);
		
		// get existing registrations
		//
		$existing = $this->model_setting_setting->getSetting('kareg');
		
		if (!empty($data)) {
			foreach ($data as $k => $v) {
			
				$v['url']           = $url;
				$v['is_registered'] = 1;
			
				$kareg['kareg' . $k] = $v;

				if (!empty($existing['kareg' . $k])) {
					unset($existing['kareg' . $k]);
				}
			}
		}
		
		// copy installed licenses to the new array
		//
		if (!empty($existing['kareg'])) {
			unset($existing['kareg']);
		}
		
		if (!empty($existing)) {
			foreach ($existing as $ek => $ev) {
				$ext_code = substr($ek, 5);
				if (in_array($ext_code, $installed_extension_codes)) {
					$ev['is_wrong_license'] = true;
					$kareg[$ek] = $ev;
				}
			}
		}

		$this->model_setting_setting->editSetting('kareg', $kareg);
		
		return true;
	}

	public function saveReg($ext_code, $data = array()) {

		$url = HTTP_CATALOG;
	
		$ka_reg = $this->model_setting_setting->getSetting('kareg');
	
		$ka_reg['kareg' . $ext_code] = array();
		
		if (isset($data['is_registered'])) {
			$ka_reg['kareg' . $ext_code]['is_registered'] = 1;
			$ka_reg['kareg' . $ext_code]['url'] = $url;
		}
		
		$this->model_setting_setting->editSetting('kareg', $ka_reg);
		
		return true;
	}	

	
	/*
		Service function for updating or creating a new Opencart setting
	*/
	public function saveSetting($code, $key, $value) {
		$this->load->model('setting/setting');
		
		$setting = $this->model_setting_setting->getSetting($code);
		$setting[$key] = $value;
		$this->model_setting_setting->editSetting($code, $setting);
	}
}