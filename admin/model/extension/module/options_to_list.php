<?php
class ModelExtensionModuleOptionsToList extends Model {
	public function getplist() {
    $data = array();
    $source  = 'http://files.dotbox.eu/ocimg/db-prod.xml';
    if (ini_get('allow_url_fopen')) {
      $results = simplexml_load_file($source);
    } else {    
      $curl = curl_init($source);    
      curl_setopt ($curl, CURLOPT_HEADER, false); 
      curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);    
      $xml = curl_exec($curl);    
      $results = simplexml_load_string($xml);
    }
    if ($results !== false) {
      foreach ($results->extension as $extension) {
        $data[0][] = array(
          'id'     => (int)$extension->id,
          'title'  => (string)$extension->title,
          'img'    => (string)$extension->img,
        );
      }
      foreach ($results->info as $info) {
        $data[1][] = array(
          'id'     => (int)$info->id,
          'title'  => (string)$info->title,
          'textb'  => (string)$info->textb,
          'texta'  => (string)$info->texta,
          'style'    => (string)$info->style,
          'url'    => (string)$info->url,
        );
      }
    }
    return $data;
  }
}
?>