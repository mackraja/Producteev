<?php

require_once CLASSES.'object/container.inc';
if (! class_exists('producteevApi')) {

class producteevApi {	
	
	public $param = array ();
	public $clientId = null;
	public $clientSecret = null;
	public $redirectUrl = null;
	public $producteevUserEmail = array ();
	public $followersEmail=array();
	public $defaultMethod = null;
	public function __construct() {
		$this->param = func_get_args ()[0];
		$this->setClientId ();
		$this->setClientSecret ();
		$this->setRedirectUrl ();
		$this->setProducteevUserEmail ();
		$this->setFollowersEmail ();
		$this->setDefaultMethod ();
	}
	
	// Getter Methods
	public function getClientId() {
		return $this->clientId;
	}
	public function getClientSecret() {
		return $this->clientSecret;
	}
	public function getRedirectUrl() {
		return $this->redirectUrl;
	}
	public function getProducteevUserEmail() {
		return $this->producteevUserEmail;
	}
	
	public function getFollowersEmail() {
		return $this->followersEmail;
	}
	
	public function getDefaultMethod() {
		return $this->defaultMethod;
	}
	
	// Setter Methods
	public function setClientId() {
		$this->clientId = ($this->param ['clientId'] !== null) ? $this->param ['clientId'] : $this->getClientId ();
	}
	public function setClientSecret() {
		$this->clientSecret = ($this->param ['clientSecret'] !== null) ? $this->param ['clientSecret'] : $this->getClientSecret ();
	}
	public function setRedirectUrl() {
		$this->redirectUrl = ($this->param ['redirectUrl'] !== null) ? $this->param ['redirectUrl'] : $this->getRedirectUrl ();
	}
	public function setProducteevUserEmail() {
		if(is_array($this->param['producteevUserEmail'])){
			$this->producteevUserEmail = (! empty ( $this->param ['producteevUserEmail'] )) ? $this->param ['producteevUserEmail'] : $this->getProducteevUserEmail ();
		}
	}
	
	public function setFollowersEmail() {
		if(is_array($this->param['followersEmail'])){
			$this->followersEmail = (! empty ( $this->param ['followersEmail'] )) ? $this->param ['followersEmail'] : $this->getFollowersEmail ();
		}
	}	
	
	public function setDefaultMethod() {
		$this->defaultMethod = ($this->param ['defaultMethod'] !== null) ? $this->param ['defaultMethod'] : $this->getDefaultMethod ();
	}		
	function  producteevconnection($args_parameters= array()){    //,&$connection             
                 !empty($args_parameters)?extract($args_parameters):null;		
		try {                   
	    $url = "https://www.producteev.com/oauth/v2/token?client_id=$client_id&client_secret=$client_secret&grant_type=authorization_code&redirect_uri=$redirect_url&code=$code";
                  $output = $this->makeAPICall ( $url );
                   $authData_get = json_decode ( $output['content'] );                   
                   $_SESSION ['producteev_access_token'] = $authData_get->access_token;                   
                 /* $query = "SELECT count(id) FROM affilired.producteev_accessuser WHERE access_token = '$authData_get->access_token'";
                   $res_useraccess = $connection -> queryRow($query); */
                   return $authData_get->access_token;                    
              } catch ( Exception $e ) {
                    	echo $e->getMessage ();
                    }	
	}	
	
 	function makeAPICall($url, $postFields = "", $optionsIn = "POST") {
		$options = array (
				CURLOPT_RETURNTRANSFER => true, // return web page
				CURLOPT_HEADER => false, // don't return headers
				CURLOPT_FOLLOWLOCATION => true, // follow redirects
				CURLOPT_ENCODING => "", // handle all encodings
				CURLOPT_USERAGENT => "harsh.kumar@affilired.com", // who am i
				CURLOPT_AUTOREFERER => true, // set referer on redirect
				CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
				CURLOPT_TIMEOUT => 120, // timeout on response
				CURLOPT_MAXREDIRS => 10, // stop after 10 redirects */ */
				CURLOPT_HTTPHEADER => array (
						'Content-type: application/json'
				),
				CURLOPT_HTTPHEADER => array (
						"Authorization:Bearer " . $_SESSION ['producteev_access_token']
				),
				CURLOPT_SSL_VERIFYPEER => false
		) // Disabled SSL Cert checks
		;
		if ($optionsIn == "POST" && $postFields) {
			$options [CURLOPT_CUSTOMREQUEST] = 'POST';
			$options [CURLOPT_POSTFIELDS] = $postFields;
		}	
		if($optionsIn=="PUT"&&$postFields){
			$options[CURLOPT_CUSTOMREQUEST] = 'PUT';
			$options[CURLOPT_POSTFIELDS] = $postFields;
		}
		/*
		 * if($optionsIn=="DELETE"){
		 * $options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
		 * }
		 */
	
		$ch = curl_init ( $url );
		curl_setopt_array ( $ch, $options );
		$content = curl_exec ( $ch );
		$err = curl_errno ( $ch );
		$errmsg = curl_error ( $ch );
		$header = curl_getinfo ( $ch );
		curl_close ( $ch );
		$header ['errno'] = $err;
		$header ['errmsg'] = $errmsg;
		$header ['content'] = $content;
		return $header;
	}	
	  function getnetworks(){		
			$projectData = $this ->makeAPICall ( "https://www.producteev.com/api/networks" );
			$get_networks = json_decode ( $projectData ['content'] );
			$all_networks = $get_networks->networks;
			$projects_array = array ();
			foreach ( $all_networks as $keys => $values ) {
				$producteevNetworkID = $values->id;
				for($j = 1; $j < 6; $j ++) {
					$projects = $this ->makeAPICall ( "https://www.producteev.com/api/networks/" . $producteevNetworkID . "/projects?page=$j" );
					$projectsObj = json_decode ( $projects ['content'] );
					$projectsArray = $projectsObj->projects;					
					for($i = 0; $i < count ( $projectsArray ); $i ++) {
						$projectsId = $projectsArray [$i]->id;
						$projectsName = $projectsArray [$i]->title;											
					           $projects_array [$projectsId]  = $projectsName;				           
					}
				}
			}
			
			return $projects_array;		
	}
	
	 function create_task($params = array()){		 
		!empty($params)?extract($params):null;	
	    $taskData = '{"task":{"title":"' . addslashes ( $title ) . '","deadline": "'.$deadline.'","project":{"id":"' . $projectId . '"}}}';
		$newTaskData = $this->makeAPICall ("https://www.producteev.com/api/tasks", $taskData );		
		if ($newTaskData ['http_code'] == "201") {      // / task created successfully			
			$createdTaskData = json_decode ( $newTaskData ['content'] );
			 $newTaskID = $createdTaskData->task->id;			
		}		
		return $newTaskID;
	}	
	
	 function get_affilireduserIds($usersemail = array()){
		$user_idsall=array();
		foreach($usersemail as $keys=>$values){
			$user_idsdata = $this ->makeAPICall ( "https://www.producteev.com/api/users/search?email=".$values);
			$user_ids = json_decode($user_idsdata['content']);
			$user_idsall[] =  $user_ids->users[0]->id;
		}		
		return $user_idsall;
	}
	
	 function assignTasktousers($userids = array(),$created_taskid){	
	 	$updateTaskData='{}';
		foreach($userids as $key=>$val){
			$user_assigntask = $this ->makeAPICall ("https://www.producteev.com/api/tasks/".$created_taskid."/responsibles/".$val,$updateTaskData,"PUT");
			
		}	
		
	}	
	
	function createnotetask($params = array()){
		!empty($params)?extract($params):null;		
	    $task_data	= '{"note":{ "message":"'.$message.'","task":{"id":"'.$taskId.'"} } }';
	    $task_response = $this ->makeAPICall ("https://www.producteev.com/api/notes".$val,$task_data);   
	    $responseget = json_decode($task_response['content']);
	  return    ($task_response['http_code']=='201')?true:false;	 
	}	
	
	function assignFollowerstoTask($followers_idsArray=array(),$task_id){
		$updateTaskData='{}';
		foreach($followers_idsArray as $keys=>$vals){			
		    $user_assigntask = $this ->makeAPICall ("https://www.producteev.com/api/tasks/".$task_id."/followers/".$vals,$updateTaskData,"PUT");
		}
		
	}	
	function priorityset($data_array=array()){	
		 $priority = $data_array['priority'];
	     $task_id = $data_array['task_id'];		 
		  $Data_parameters =  '{"tasks":[{"id":"'.$task_id.'","priority":'.$priority.'}]}';
		  $priority_response = $this ->makeAPICall ("https://www.producteev.com/api/tasks",$Data_parameters,"PUT");		  
		  return    ($priority_response['http_code']=='200')?true:false;
	}

	
	function get_alluserstasks(){
		//https://searchcode.com/codesearch/view/100236391/
		$producteevNetworkID ="559a478eb2fa09a47a000011";
		//$data='{ "networks":[], "projects":["'.$producteevNetworkID.'"], "priorities":[0,1,2], "statuses":[0,1], "responsibles":[],"creators":[], "labels":[], "deadline":{}, "created_at":{}, "updated_at":{}, "search":{}}';
		$data='{ "projects":["'.$producteevNetworkID.'"], "priorities":[0,1,2,3,4,5], "statuses":[0,1]}';
		$tasks=$this ->makeAPICall("https://www.producteev.com/api/tasks/search?sort=created_at&order=desc&page=1",$data);
		$tasksObj=json_decode($tasks['content']);
		return    ($tasks['http_code']=='200')?$tasksObj:false;	
	}	
	
	
}

}
?>
