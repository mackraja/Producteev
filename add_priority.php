
<div id="tabs-5">
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
	<td class="edit_task"><a href="javascript:void(0);" id="<?=$tasksArray[$i]->id?>">Add</a></td>
</tr>
<?  } ?> 
</table> 
 				<div style="display:none;" id="editforms">
					<form action="addTask.php#tabs-5" method="post" id="priorityform"><span id="close_forms">Close</span>
					        <h1>Priority set </h1>        
					        <fieldset>
					          <legend><span class="number">1</span> Information</legend>          
					          <label for="task_id">Task Id:</label>
					          <input type="text" id="task_idd" name="task_id" readonly>          
					          <label for="priority">Priority </label>
					          <select id="priority" name="priority">
					          <optgroup label="Priority">
					            <option value="" selected >--Set priority--</option>            
					            <option value="0">None</option>
					            <option value="1">Very Low</option>
					            <option value="2">Low</option>
					            <option value="3">Medium</option>
					            <option value="4">High</option>
					            <option value="5">Very High</option>                   
					          </optgroup>         
					        </select>                 
					        </fieldset>                
					        <button type="submit" name="prioritysubmit">Set Priority</button>					        
					</form>
                 </div>
</div>  