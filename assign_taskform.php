<div id="tabs-3">

<table class="gridtable">

<tr>
	<th>Task Name</th>
	<th>Prioject</th>
	<th>Priority</th>
	<th>Operation</th>
</tr>
 <?php 
        $tasksArray =$tasks_Array->tasks;
    	for($i=0;$i<count($tasksArray);$i++){	    
   ?>
<tr>
	<td><?=$tasksArray[$i]->title?></td>
	<td><?=$tasksArray[$i]->project->title?></td>
	<td class="priority_set" id="priority_<?=$tasksArray[$i]->id?>"><?=$tasksArray[$i]->priority?></td>
	<td class="assignedit_task"><a href="javascript:void(0);" id="<?=$tasksArray[$i]->id?>">Add</a></td>
</tr>
<?  } ?> 
</table>

<div style="display:none;" id="assign_forms">
<form action="addTask.php#tabs-3" method="post" id="assignform"><span id="closeassign_form">Close</span>
        <h1>Assign task to users </h1>        
        <fieldset>
          <legend><span class="number">1</span> Information </legend>          
          <label for="task_id">Task Id:</label>
          <input type="text" id="taskassign_id" name="task_id" readonly>           
          <input type="checkbox" name="users_list[]" value="monty.khanna@affilired.com">Monty khanna<br/>
          <input type="checkbox" name="users_list[]" value="anil@affilired.com">Anil Kumar<br/>
          <input type="checkbox" name="users_list[]" value="harsh.kumar@affilired.com">Harsh Kumar<br/>                                  
        </fieldset>              
        <button type="submit" name="assigntask" >Assign Task</button>
</form> 

</div>
</div>