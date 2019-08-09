<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


// get all categories


$db_get_categories = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_categories ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_categories ->connect_error . ']');
}

$sql_get_categories  = "SELECT * FROM categ";

$result_get_categories = $db_get_categories->query($sql_get_categories);

$db_get_categories->close();



include "menu.php";

?>


<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
	
	<h3> <i class="fa fa-list fa-1x"></i> Category Management </h3>
	
	<br>
	
	<table id="main_catgeories"  name="main_catgeories" class="table table-striped table-bordered" cellspacing="0" width="100%">
        	<thead>
            	<tr>
                	<th>Name</th>
                	<th>Description</th>
                	<th>Status</th>
                	<th></th>
                </tr>
        	</thead>
        	
        	<tbody>
        	
        	<?php
        	
        
        	 
        	 while ($row = $result_get_categories->fetch_assoc()) {
        	 
        	 	$category_id  = $row['id'];
            $status = ($row['status']==0)?"Active":"Inactive";
        	 ?>
        	 
        	    <tr>
        	 	  <td style="width: 220px"><?=$row['name']?></td> 
             	<td style="width: 400px"><?=$row['descr']?></td> 
              <td style="width: 200px"><?=$status?></td> 
             	<td>
             	
             	<?php
             	echo '<button category_id="' . $category_id . '"  class="btn btn-default edit_category" ><i class="fa  fa-pencil fa-lg"></i> Edit</button>';
             	?>
             	
             	</td> 
             	</tr>
             	
        	 
        	 <?php
        	 }
        	 
        	 ?>
        	 
        	  </tbody>
   		 </table>
   		 
   	
        
        <?php
             	echo '<button class="btn btn-success add_category" ><i class="fa fa-plus fa-lg"></i> Add Category</button>';
        ?>
        	
	
	
	
	</div>
</div>	



<div id="modal_add_category" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        	<div class="modal-content">
        		<div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            		<h4 class="modal-title" style="color:#000000";><center>Add Category</center></h4>
            	</div>
            		<div class="modal-body">
            		
            		
            		<div class="form-group">
		 	<label for="sel1">Name</label>
		 	<input type="text" class="form-control" id="new_category_name" name="new_category_name" value="">
		 	</div>
		 	
		 	<div class="form-group">
        <label for="comment">Description:</label>
        <textarea class="form-control" rows="5" id="new_category_description" name="new_category_description"></textarea>
      </div>


<center>
		 	<table>
            			<tr>
            			 <td><button class="btn btn-default" onclick="new_category_close()">Close</button></td><td width="10px"></td><td><button class="btn btn-success" onclick="new_category_add()">Save</button></td><td width="10px"></td>
            			
            			</tr>
            		
            		
            		</table>
		 	</center>
            		
            		
            		
            		
            		
            		
		 	
            		
            
            		
            		</div>
            </div>
        </div>
    </div>
    



<script>



function new_category_close(){
   $('#modal_add_category').modal('hide');
   
};


function new_category_add(){

   	var name = $('#new_category_name').val();
  	var description = $('#new_category_description').val();
  	if(name=='' || description==''){
      alert("Please provide full details");
      return;
    }
  	
  	var formData = {
        	'name'     : name,
        	'description'     : description
        	
	}
	
	
	 var feedback = $.ajax({
    			type: "POST",
    			url: "add_category.php",
    		    data: formData,
    		
    		    async: true,
    			
    	}).complete(function(result){
        alert(result.responseText);
        				
    	}).responseText;
  	
  	
  	swal({
  			title: "Success",
  			text: "The category was added",
  			type: "success",
  			showCancelButton: false,
  			confirmButtonColor: "#5cb85c",
  			confirmButtonText: "OK",
  			closeOnConfirm: false
		},
		function(){
 			swal.close();
 		
	
 			location.href = "category_management_main_list.php";
 			

		});
  	
  	


};



$(document).on("click", ".add_category", function(e) {


   
   $('#modal_add_category').modal('show');
   
});



var l_m = "Display _MENU_ records per page";
var search = "Search";
var display_nothing = "No Leads to display";
var info = "Showing page _PAGE_ of _PAGES_ ";
var display_first = "First";
var display_last = "First";
var next = "Next";
var previous = "Previous";
var no_records = "No records available";
var filtered = " (filtered from _MAX_ total records)";


    
    $('#main_catgeories').dataTable( {
    "paging": false,
    "order": [[ 0, "desc" ]],
        "language": {
            "lengthMenu": l_m,
            "search":         search,
            "zeroRecords": display_nothing,
            "info": info,
            "paginate": {
        		"first":      display_first,
        		"last":       display_last,
       		    "next":       next,
                "previous":   previous
    },
            "infoEmpty": no_records,
            "infoFiltered": filtered
        }
    } );


$(document).on("click", ".edit_category", function(e) {
	
	var category_id = ($(this).attr('category_id'));
	
	location.href = "category_management_main_edit.php?category_id=" + category_id;
	
	
	
});



</script>