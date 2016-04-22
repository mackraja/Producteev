<div id="tabs-2">
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
	<td class="editnote_task"><a href="javascript:void(0);" id="<?=$tasksArray[$i]->id?>">Add</a></td>
</tr>
<?  } ?> 
</table>
<div style="display:none;" id="note_form">
      <form action="addTask.php#tabs-2" method="post" id="noteform" enctype="multipart/form-data"><span id="closenote_form">Close</span>
        <h1>Note Create  </h1>        
        <fieldset>
          <legend><span class="number">1</span> Information</legend>          
          <label for="task_id">Task Id:</label>
          <input type="text" id="tasknote_id" name="task_id" readonly>          
          <label for="notemessage">Message:</label>
         <textarea rows="4" cols="12" name="notemessage" id="notemessage"></textarea>         
         <label for="file">File Upload</label>
           <input type="file" name="file" id="file" />                  
        </fieldset>              
        <button type="submit" name="notecreate" >Create note</button>
        </form>        
        </div>        
 </div>  