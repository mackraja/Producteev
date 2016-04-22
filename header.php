<head>	
	<title>Producteev Manage Task </title> 
	<link rel="stylesheet" type="text/css" href="css/style_producteev.css">
	<link href="css/jquery-ui.css" rel="stylesheet">
    <script src="js/main_producteev.js"></script>
    <script src="js/jquery-ui.js"></script>   
    <script src="js/jquery.validate.min.js"></script>   
    <script type="text/javascript">
		$(function() {
			
		  $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
		  
		  $('.edit_task a').click(function() {
			    var id = this.id;
		   		var priority = $("#priority_"+id).text();		   		
		   	 $("#priority option[value="+priority+"]").prop('selected', true);			        
			 $('#editforms').show();			 
			 $('#task_idd').val(id);			 
		  });	

		  $('.editnote_task a').click(function() {
			    var id = this.id; 		
			 $('#note_form').show();			
			 $('#tasknote_id').val(id);			 
			});			  
    
		  $('#closenote_form').click(function() {			    
			    $('#note_form').hide();			    
			    		  
			});					

		  $('#close_forms').click(function() {			    
			    $('#editforms').hide();			    
			    		  
			});
		  $('.assignedit_task a').click(function() {
			    var id = this.id;			    	
			 $('#assign_forms').show();			
			 $('#taskassign_id').val(id);

			 var all_array = <?php echo json_encode($tasks_Array); ?>;
             var responseArray = new Array();
             $.each(all_array.tasks, function(i, v) {
                 if (v.id == id) {
                 	$.each(v.responsibles, function(i, s) {                   			                        
		                        responseArray.push(s.email);		                        
                 	 });
                 }
             });
             $("input[name='users_list[]']").prop("checked",false);
             $("input[name='users_list[]']").each(function ()
             		   {
		                	if($.inArray($(this).val(), responseArray) != -1){
		                		var name = $(this).val();	                		
		                		$("input[name='users_list[]'][value='"+name+"']").prop("checked",true);		                		 		                		                		 
		               }                		   
             	});
			 			 
			});			

		  $('#closeassign_form').click(function() {			    
			    $('#assign_forms').hide();			   			  
			});

		  $('.editfollowers_task a').click(function() {
			    var id = this.id;			   			    			    	
			 $('#followers_form').show();			
			 $('#taskfollowers_id').val(id);
			 
                var all_array = <?php echo json_encode($tasks_Array); ?>;
                var followersArray = new Array();
                $.each(all_array.tasks, function(i, v) {
                    if (v.id == id) {
                    	$.each(v.followers, function(i, s) {                   			                        
		                        followersArray.push(s.email);		                        
                    	 });
                    }
                });
                $("input[name='followersusers_list[]']").prop("checked",false);
                $("input[name='followersusers_list[]']").each(function ()
                		   {
		                	if($.inArray($(this).val(), followersArray) != -1){
		                		var name = $(this).val();	                		
		                		$("input[name='followersusers_list[]'][value='"+name+"']").prop("checked",true);		                		 		                		                		 
		                    }                		   
                	});  
			 			 
			});			

		  $('#closefollower_form').click(function() {			    
			    $('#followers_form').hide();			   			  
			});			 
				  
		});			
</script>   
   <!-- Js for Tabs  -->   
     <script>
  $(function() {
    $( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
    $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
  });
  </script>  
  <script>            
            $(function() {
       //  Create Task form validation //////////////////////////////////////////////////////////////////                                
                $("#createtask").validate({                    
                    rules: {
                        "title" : {
                            required : true                            
                        },                        
                        "network_name": {
                            required : true
                           }
                    },
                    messages: {
                        "title": {
                            required: "You must enter title Field  value"                            
                        },  
                        "network_name": {
                            required: "You must choose network  options"                            
                        }
                    }
                });
                $.validator.addMethod("customFunction", function(value) {
                    return value == "input";
                }, 'Please enter "input"!'); 

     //  Note form validation //////////////////////////////////////////////////////////////////
                $("#noteform").validate({                    
                    rules: {
                        "task_id" : {
                            required : true                            
                        },                        
                        "notemessage": {
                            required : true
                           }
                    },
                    messages: {
                        "task_id": {
                            required: "You must enter task id Field  value"                            
                        },  
                        "notemessage": {
                            required: "You must enter Message value"                            
                        }
                    }
                });
                $.validator.addMethod("customFunction", function(value) {
                    return value == "input";
                }, 'Please enter "input"!');

    //  Assign form validation //////////////////////////////////////////////////////////////////
                $("#assignform").validate({                    
                    rules: {
                        "task_id" : {
                            required : true                            
                        },
                        "users_list[]":{
                        	required : true 
                          }
                    },
                    messages: {
                        "task_id": {
                            required: "You must enter task id Field  value"                            
                        },"users_list[]":{
                        	required: "You must check user value" 
                         }
                    }
                });
                $.validator.addMethod("customFunction", function(value) {
                    return value == "input";
                }, 'Please enter "input"!');

  //  Followers form validation ////////////////////////////////////////////////////////////////// 
                $("#followersform").validate({                    
                    rules: {
                        "task_id" : {
                            required : true                            
                        },
                        "followersusers_list[]":{
                        	required : true 
                          }
                    },
                    messages: {
                        "task_id": {
                            required: "You must enter task id Field  value"                            
                        },
                        "followersusers_list[]":{
                        	required: "You must check follower user value" 
                        }
                    }
                });
                $.validator.addMethod("customFunction", function(value) {
                    return value == "input";
                }, 'Please enter "input"!');

//  Priority form validation //////////////////////////////////////////////////////////////////                
                $("#priorityform").validate({                    
                    rules: {
                        "task_id" : {
                            required : true                            
                        },                        
                        "priority": {
                            required : true
                           }
                    },
                    messages: {
                        "task_id": {
                            required: "You must enter task id Field  value"                            
                        },  
                        "priority": {
                            required: "You must choose priority  options"                            
                        }
                    }                 
                });
                $.validator.addMethod("customFunction", function(value) {
                    return value == "input";
                }, 'Please enter "input"!');                  
            });
        </script>  
  <style> 
  .ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 12em; }
  .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
  .ui-tabs-vertical .ui-tabs-nav li a { display:block; }
  .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; }
  .ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: right; width: 40em;}
  
  
  table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:14px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
	width :100%
}
table.gridtable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}
  
  
  </style>   
    <!-- Js for Tabs  -->   
</head>	
<body>   
   <fieldset style="border: 1px black solid">
     <legend style="border: 1px black solid; margin-left: 1em; padding: 0.2em 0.8em ">Producteev Manager</legend>   	 
	 <div id="tabs">
		  <ul>
		    <li><a href="#tabs-1">Create task</a></li>
		    <li><a href="#tabs-2">Note create for Task</a></li>
		    <li><a href="#tabs-3">Assign task to users</a></li>
		    <li><a href="#tabs-4">Assign followers</a></li>		    
		    <li><a href="#tabs-5">Priority Set </a></li>
		  </ul>