<?php
require_once (APPPATH.'/libraries/Credentials.php');
Class Discovery extends Credentials{
  public function queryDiscovery($consultar="") {
    if ($consultar==="") {
      echo "La consulta no puede ser vacía";
      return;
    }
    $consultar=str_replace(" ","%",$consultar);
    $consulta="natural_language_query=".$consultar;// lenguaje natural

    $url = "https://gateway.watsonplatform.net/discovery/api/v1";
    $url .="/environments/".$this->get_Discovery_Enviroment();
    $url .="/collections/".$this->get_Discovery_Collection();
    $url .="/query?version=2017-11-07";
    $url .="&&".$consulta;// query


    $curl = curl_init();
    // curl -u "{username}":"{password}" 'https://gateway.watsonplatform.net/discovery/api/v1/environments/{environment_id}/collections/{collection_id}/query?version=2017-11-07&query=enriched_text.entities.text:IBM'
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, $this->get_Discovery_User().":".$this->get_Discovery_Pass());

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($curl);
		if (curl_errno($curl)) {
			echo 'Error:' . curl_error($curl);
		}
		curl_close($curl);
		$decoded = json_decode($result, true);
		return $decoded;
  }

}// fin clase

?>
