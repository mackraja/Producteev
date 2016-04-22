<?php
session_start ();
define ( 'ACCESS', true );
define('CLASSES', 'classes/');
include CLASSES.'producteev/producteevApi.php';
ini_set('max_execution_time', 300);
// local Host details
$producteev_object = new producteevApi ( array (
		'clientId' => '570495522adaea8530000005_dpum4ochgdsso4okgc88wwgs4ocogo8cg808wwo044s0sw0cs',
		'clientSecret' => '45c84vl3r8u8sgosks008g08kgw44kkoo4gsookkg0so0ggwcg',
		'redirectUrl' => 'http://admin.affilired.local/Producteev/addTask.php',		
		'defaultMethod' => 'POST'
) );

// Dev details 
// $producteev_object = new producteevApi ( array (
// 		'clientId' => '5715e945b0fa092348000002_33883edb5yskw084ockswkc48skg8o4kgsc4g4gwg4kggsk8ko',
// 		'clientSecret' => 'i5xxpgxsymg4cc8gcwcgsccwk0k080osco0kc4gos4gk4wok8',
// 		'redirectUrl' => 'http://dev.admin.affilired.com/Producteev/addTask.php',
// 		'defaultMethod' => 'POST'
// ) ); 

 $client_id      		 = $producteev_object->getClientId(); 
 $client_secret   		 = $producteev_object->getClientSecret(); 
 $redirect_url    		 = $producteev_object->getRedirectUrl();  
 $method                 = $producteev_object->getDefaultMethod();  
if (!empty( $_REQUEST ['code'] )) {	
		$args_parameters = array('client_id'=>$client_id,
								'client_secret'=>$client_secret,
								'redirect_url'=> $redirect_url,
								'code' =>$_REQUEST ['code']);
		$authData = $producteev_object->producteevconnection($args_parameters);	//,$connection	
}
if (! $_SESSION ['producteev_access_token']) { 
	?>
<a	href="https://www.producteev.com/oauth/v2/auth?client_id=<?php echo $client_id;?>&response_type=code&redirect_uri=<?php echo $redirect_url;?>">Please log in to Producteev</a>
<?
} else { // / We have a valid Producteev Session
	/*
	 *
	 * Create Task
	 */
	 $get_network_array = $producteev_object->getnetworks();
switch(true)
{    
    case isset($_POST['create']):
    	$create_taskparams = array('title'=>$_POST['title'],'projectId'=>$_POST['network_name'],'deadline'=>$_POST['deadline']);
    	$create_taskid = $producteev_object ->create_task($create_taskparams);
    	if(!empty($create_taskid)){
    		$result['success']= true;
    		$result['message']= "1" ;
    	}      
    break;
    case isset($_POST['notecreate']):
		$note_params = array('message'=>$_POST['notemessage'],'taskId'=>$_POST['task_id']);
		/*
		 * uploading file
		 * **/	
		$note_params['file_id']= '';
		if(!empty($_FILES)){
			$path = "../producteev_docs/";
			$name = $_FILES['file']['name'];
			$size = $_FILES['file']['size'];
			list($txt, $ext) = explode(".", $name);
			$actual_image_name = time().".".$ext;			
			$tmp = $_FILES['file']['tmp_name'];
			move_uploaded_file($tmp, $path.$actual_image_name);		
			$filepath = '../producteev_docs/'.$actual_image_name;		
			$file_id = $producteev_object->upload_file($filepath,$actual_image_name);				
			!empty($file_id)?$note_params['file_id'] = $file_id:'';
		}		
		$create_notedata = $producteev_object->createnotetask($note_params);	 	
	 	if(!empty($create_notedata)){
	 		$result['success']= true;
	 		$result['message']= "2" ;
	 	}
    break;
    case isset($_POST['prioritysubmit']):
    	$priority_array = array('priority'=>$_POST['priority'],'task_id'=>trim($_POST['task_id']));
    	$response = $producteev_object ->priorityset($priority_array);
    	if(!empty($response) && $response==1){
    		$result['success']= true;
    		$result['message']= "5" ;
    	}
    break;
    case isset($_POST['assigntask']):
    	$affilired_idsArray = $producteev_object ->get_affilireduserIds($_POST['users_list']);  
	 	$assigntaskresults = $producteev_object ->assignTasktousers($affilired_idsArray,$_POST['task_id']);
	 	$result['success']= true;
	 	$result['message']= "3" ;
    break;
    case isset($_POST['follower_assign']):
    	$followers_idsArray = $producteev_object ->get_affilireduserIds($_POST['followersusers_list']);
		$assigntaskresults = $producteev_object ->assignFollowerstoTask($followers_idsArray,$_POST['task_id']);
		$result['success']= true;
		$result['message']= "4" ;
    break;
} 	 
	 if($result['success']==1){	
	 	$message = $result['message'];
	 	header('Location: '.$redirect_url.'?message='.$message);	 	 	
	   }

	   if( !empty( $_REQUEST['message'] ) )	{ 
	   
	   	switch($_GET['message'])
	   	{
	   		case 1:
	   			$message ="Task created successfully!!!"; 
	   	    break;
	   	    case 2:
	   	    	$message ="Task note created successfully!!!";
	   	    break;
	   	    case 3:
	   	    	$message ="Task assign successfully!!!";
	   	    break;
	   	    case 4:
	   	    	$message ="Task followers assign successfully!!!";
	   	    break;
	   	    case 5:
	   	        $message ="Task priority set successfully!!!";
	   	    break;   	
	   	}	   	
	   	?>
   		 		<div class="isa_info">
                    <i class="fa fa-info-circle"></i> <?php echo $message; ?> 
                   </div>
	   		 <?php 	}	   
	            $tasks_Array = $producteev_object ->get_alluserstasks();
	            include 'header.php';  	   
   	      		include 'create_taskform.php';   	          
       	        include 'create_noteform.php';               
                include 'assign_taskform.php';         
       	        include 'followers_taskform.php';      	      
       	        include 'add_priority.php';       	 
       	 ?>
       </div></fieldset>
       </body> 
    <?php    
}
?>

       