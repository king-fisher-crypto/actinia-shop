<?php
class ControllerExtensionoutstckoptdis extends Controller {	
	public function getdata() {
		$json = array();
		if(!empty($this->request->post['product_id'])) {
			$this->load->model('extension/outstckoptdis');
			$json = $this->model_extension_outstckoptdis->getdata($this->request->post['product_id']);
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));	
	}
}