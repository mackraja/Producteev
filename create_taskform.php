    <div id="tabs-1">    
     <form action="addTask.php#tabs-1" method="post" id="createtask">
        <h1>Create task </h1>        
        <fieldset>
          <legend><span class="number">1</span> Information</legend>          
          <label for="title">Title:</label>
          <input type="text" id="title" name="title">          
          <label for="datepicker">Deadline:</label>
          <input type="text" id="datepicker" name="deadline">
          <label for="network_name">Network:</label>
        <select id="network_name" name="network_name">
          <optgroup label="Networks">
            <option value="" selected>--Select network--</option>
            <?php foreach($get_network_array as $key=>$values ){?>
            <option value="<?php echo $key; ?>"><?php echo $values; ?></option>
            <?php } ?>            
          </optgroup>         
        </select>       
        </fieldset>       
        <button type="submit" name="create" >Create Task</button>
     </form>
</div>