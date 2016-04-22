<div id="tabs-4">
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
	<td class="editfollowers_task"><a href="javascript:void(0);" id="<?=$tasksArray[$i]->id?>">Add</a></td>
</tr>
<?  } ?> 
</table>
<div style="display:none;" id="followers_form">
<form action="addTask.php#tabs-4" method="post" id="followersform"><span id="closefollower_form">Close</span>
        <h1>Followers assign to task </h1>        
        <fieldset>
          <legend><span class="number">1</span> Information</legend>          
          <label for="task_id">Task Id:</label>
          <input type="text" id="taskfollowers_id" name="task_id" readonly>
          <input type="checkbox" name="followersusers_list[]" value="monty.khanna@affilired.com" class="follow" >Monty khanna<br/>
          <input type="checkbox" name="followersusers_list[]" value="anil@affilired.com" class="follow" >Anil Kumar<br/>
          <input type="checkbox" name="followersusers_list[]" value="harsh.kumar@affilired.com" class="follow">Harsh Kumar<br/>                                   
        </fieldset>               
        <button type="submit" name="follower_assign" >Assign follower</button>
         </form>
 </div>
</div> 