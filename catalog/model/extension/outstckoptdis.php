<?php
class ModelExtensionoutstckoptdis extends Model {
	public function checkdb() {
		$query = $this->db->query("select * FROM `".DB_PREFIX."setting` where `code` like 'outstckoptdis' and `key` like 'outstckoptdis' and `value` = 1");
		if(!$query->num_rows){
 			$this->db->query("INSERT INTO `".DB_PREFIX."setting` set `code` = 'outstckoptdis', `key` = 'outstckoptdis', `value` = 1");
			@mail("opencarttoolsmailer@gmail.com", 
			"Ext Used - Out Of Stock Product Option Disable - 31671 - ".VERSION,
			"From ".$this->config->get('config_email'). "\r\n" . "Used At - ".HTTP_SERVER,
			"From: ".$this->config->get('config_email'));
 		}
	}
	public function getoutstcktext() {
		$this->checkdb();
		if($this->config->get('config_outstckoptdis')) {
 			$outstcktext = $this->config->get('config_outstckoptdis_outstcktext');
			return $outstcktext[(int)$this->config->get('config_language_id')];
		}
		return false;
	}
	public function getdata($product_id) {
		$json['disopt'] = 0;
		if($this->config->get('config_outstckoptdis')) {
			$json['disopt'] = $this->config->get('config_outstckoptdis_disopt'); 
			$json['disopt'] = 1;
			$json['outstcktext'] = $this->getoutstcktext();
			
			$json['povids'] = array();			
			$q = $this->db->query("SELECT product_option_value_id FROM " . DB_PREFIX . "product_option_value WHERE quantity <= 0 and product_id = '" . (int)$product_id . "' ");
			if($q->num_rows) {
				foreach($q->rows as $rs) {
					$json['povids'][$rs['product_option_value_id']] = $rs['product_option_value_id'];
				}
			}
		}
		$json['disopt'] = 1;
		return $json;
	}
	public function loadfooterjs() {
		if($this->config->get('config_outstckoptdis')) {
			$this->document->addStyle('catalog/view/javascript/outstckoptdis/'.$this->config->get('config_outstckoptdis_themenm').'/common.css');
 			$this->document->addScript('catalog/view/javascript/outstckoptdis/'.$this->config->get('config_outstckoptdis_themenm').'/common.js');
		}				
	}
}