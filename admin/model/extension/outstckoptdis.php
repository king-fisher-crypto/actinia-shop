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
	public function gethtml($store_info) {
		$this->checkdb();
		
		$lang = $this->load->language('extension/outstckoptdis');
		
		$langs = $this->getLang();
		
		if (isset($this->request->post['config_outstckoptdis'])) {
			$data['config_outstckoptdis'] = $this->request->post['config_outstckoptdis'];
		} elseif (!empty($store_info)) {
			$data['config_outstckoptdis'] = isset($store_info['config_outstckoptdis']) ? $store_info['config_outstckoptdis'] : '';
		} else {
			$data['config_outstckoptdis'] = $this->config->get('config_outstckoptdis');
		}
		
		if (isset($this->request->post['config_outstckoptdis_themenm'])) {
			$data['config_outstckoptdis_themenm'] = $this->request->post['config_outstckoptdis_themenm'];
		} elseif (!empty($store_info)) {
			$data['config_outstckoptdis_themenm'] = isset($store_info['config_outstckoptdis_themenm']) ? $store_info['config_outstckoptdis_themenm'] : '';
		} else {
			$data['config_outstckoptdis_themenm'] = $this->config->get('config_outstckoptdis_themenm');
		}
		
		if (isset($this->request->post['config_outstckoptdis_disopt'])) {
			$data['config_outstckoptdis_disopt'] = $this->request->post['config_outstckoptdis_disopt'];
		} elseif (!empty($store_info)) {
			$data['config_outstckoptdis_disopt'] = isset($store_info['config_outstckoptdis_disopt']) ? $store_info['config_outstckoptdis_disopt'] : '';
		} else {
			$data['config_outstckoptdis_disopt'] = $this->config->get('config_outstckoptdis_disopt');
		}
		
		if (isset($this->request->post['config_outstckoptdis_outstcktext'])) {
			$data['config_outstckoptdis_outstcktext'] = $this->request->post['config_outstckoptdis_outstcktext'];
		} elseif (!empty($store_info)) {
			$data['config_outstckoptdis_outstcktext'] = isset($store_info['config_outstckoptdis_outstcktext']) ? $store_info['config_outstckoptdis_outstcktext'] : '';
		} else {
			$data['config_outstckoptdis_outstcktext'] = $this->config->get('config_outstckoptdis_outstcktext');
		}
				
		$sel0 = $data['config_outstckoptdis'] == 0 ? 'checked="checked"' : '';
		$sel1 = $data['config_outstckoptdis'] == 1 ? 'checked="checked"' : '';
 		$html1 = sprintf('<div class="form-group"> <label class="col-sm-2 control-label">%s</label><div class="col-sm-10"> <label class="radio-inline"> <input type="radio" name="config_outstckoptdis" value="1" %s/> %s </label> <label class="radio-inline"> <input type="radio" name="config_outstckoptdis" value="0" %s/> %s </label> </div> </div>', $lang['entry_status'], $sel1, $lang['text_yes'], $sel0, $lang['text_no']);
		
		$sel0 = $data['config_outstckoptdis_themenm'] == 'def' ? 'checked="checked"' : '';
		$sel1 = $data['config_outstckoptdis_themenm'] == 'j2' ? 'checked="checked"' : '';
		$sel2 = $data['config_outstckoptdis_themenm'] == 'j3' ? 'checked="checked"' : '';
 		$html2 = sprintf('<div class="form-group"> <label class="col-sm-2 control-label">%s</label><div class="col-sm-10"> <label class="radio-inline"> <input type="radio" name="config_outstckoptdis_themenm" value="def" %s/> Default </label> <label class="radio-inline"> <input type="radio" name="config_outstckoptdis_themenm" value="j2" %s/> Journal2 </label> <label class="radio-inline"> <input type="radio" name="config_outstckoptdis_themenm" value="j3" %s/> Journal3 </label> </div> </div>', $lang['entry_themenm'], $sel0, $sel1, $sel2);
		
		$html3_opt = '';
		foreach ($langs as $lng) {
			$val = isset($data['config_outstckoptdis_outstcktext'][$lng['language_id']]) ? $data['config_outstckoptdis_outstcktext'][$lng['language_id']] : '';
			$html3_opt .= sprintf('<div class="input-group pull-left"> <span class="input-group-addon"><img src="%s"/> </span> <input type="text" name="config_outstckoptdis_outstcktext[%s]" value="%s" class="form-control"/> </div>', $lng['imgsrc'], $lng['language_id'], $val);
		}
		$html3 = sprintf('<div class="form-group"> <label class="col-sm-2 control-label">%s</label><div class="col-sm-10"> %s </div> </div>', $lang['entry_outstcktext'], $html3_opt);
		
		$sel0 = $data['config_outstckoptdis_disopt'] == 0 ? 'checked="checked"' : '';
		$sel1 = $data['config_outstckoptdis_disopt'] == 1 ? 'checked="checked"' : '';
 		$html4 = sprintf('<div class="form-group"> <label class="col-sm-2 control-label">%s</label><div class="col-sm-10"> <label class="radio-inline"> <input type="radio" name="config_outstckoptdis_disopt" value="1" %s/> %s </label> <label class="radio-inline"> <input type="radio" name="config_outstckoptdis_disopt" value="0" %s/> %s </label> </div> </div>', $lang['entry_disopt'], $sel1, $lang['text_yes'], $sel0, $lang['text_no']);
		
 		$html = sprintf('<div class="panel panel-primary"><div class="panel-heading">%s</div><div class="panel-body">%s</div> </div>', $lang['text_panel_title'], ($html1. $html2. $html3));
 		
		return $html;
	}
	
	// helper classes
	public function getLang() {
 		$data['languages'] = array();
		$this->load->model('localisation/language');
  		$languages = $this->model_localisation_language->getLanguages();
		foreach($languages as $language) {
			if(substr(VERSION,0,3)>='3.0' || substr(VERSION,0,3)=='2.3' || substr(VERSION,0,3)=='2.2') {
				$imgsrc = "language/".$language['code']."/".$language['code'].".png";
			} else {
				$imgsrc = "view/image/flags/".$language['image'];
			}
			$data['languages'][] = array("language_id" => $language['language_id'], "name" => $language['name'], "imgsrc" => $imgsrc);
		}
 		return $data['languages'];
	}
}