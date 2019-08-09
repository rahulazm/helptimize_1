<?php


$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


$category_id = $_GET['category_id'];


// get all categories


$db_get_categories = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_categories ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_categories ->connect_error . ']');
}

$sql_get_categories  = "SELECT * FROM categ WHERE id='$category_id'";

$result_get_categories = $db_get_categories->query($sql_get_categories);
$row = $result_get_categories->fetch_assoc();

$db_get_categories->close();

$category_name = $row['name'];
$category_description = $row['descr'];



// get all repective sub-categories


$db_get_sub_categories = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_sub_categories ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_sub_categories ->connect_error . ']');
}

$sql_get_sub_categories  = "SELECT * FROM categ WHERE id='$category_id'";

$result_get_sub_categories = $db_get_sub_categories->query($sql_get_sub_categories);


$db_get_sub_categories->close();



include "menu.php";



?>

<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
	
	<h3> <i class="fa fa-list fa-1x"></i> Category Management </h3>
	
	<br>
	
	<label>Category Name</label>
		<br>
		<input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $category_name;?>">

	
		<br>
		
		<div class="form-group">
  			<label for="comment">Category Description</label>
  			<textarea class="form-control" rows="3" id="category_description" name="category_description"><?php echo $category_description;?></textarea>
		</div>
		
		<?php
             	echo '<button class="btn btn-success update_category" ><i class="fa fa-floppy-o fa-lg"></i> Update Category</button>';
        ?>
        
        
        <?php
             	echo '<button class="btn btn-danger delete_category" ><i class="fa fa-trash fa-lg"></i> Delete Category</button>';
        ?>
        
        <hr>
      
      <!--
        <label>Sub-Categories</label>
        <table id="sub_catgeories"  name="main_catgeories" class="table table-striped table-bordered" cellspacing="0" width="100%">
        	<thead>
            	<tr>
                	<th>Name</th>
                	<th>Description</th>
                	<th></th>
                	<th></th>
                </tr>
        	</thead>
        	
        	<tbody>
        	
        	<?php
        	while ($row = $result_get_sub_categories->fetch_assoc()) {
        	 
        	 	$sub_category_id  = $row['id'];
        	 ?>
        	 
        	    <tr>
        	 	<td style="width: 220px"><?=$row['name']?></td> 
             	<td style="width: 400px"><?=$row['description']?></td> 
             	<td></td> 
             	<td>
             	
             	<?php
             	echo '<button sub_category_id="' . $sub_category_id . '"  class="btn btn-default edit_sub_category" ><i class="fa  fa-pencil fa-lg"></i> Edit</button>';
             	?>
             	
             	</td> 
             	</tr>
             	
        	 
        	 <?php
        	 }
        	 
        	 ?>
        	 
        	  </tbody>
   		 </table>
   		 
   		 <?php
             	echo '<button class="btn btn-success add_sub_category" ><i class="fa fa-plus fa-lg"></i> Add Sub-Category</button>';
        ?>
        
        
        
	
	
</div>
</div>




<div id="modal_add_sub_category" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        	<div class="modal-content">
        		<div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            		<h4 class="modal-title" style="color:#000000";><center>Add Sub-Category</center></h4>
            	</div>
            		<div class="modal-body">
            		
            		
            		<div class="form-group">
		 	<label for="sel1">Name</label>
		 	<input type="text" class="form-control" id="new_sub_category_name" name="new_sub_category_name" value="">
		 	</div>
		 	
		 	
		 	<div class="form-group">
  <label for="comment">Description:</label>
  <textarea class="form-control" rows="5" id="new_sub_category_description" name="new_sub_category_description"></textarea>
</div>
		 	
		 
<center>
		 	<table>
            			<tr>
            			 <td><button class="btn btn-default" onclick="new_sub_category_close()">Close</button></td><td width="10px"></td><td><button class="btn btn-success" onclick="new_sub_category_add()">Save</button></td><td width="10px"></td>
            			
            			</tr>
            		
            		
            		</table>
		 	</center>
            		
            		
            		
            		
            		
            		
		 	
            		
            
            		
            		</div>
            </div>
        </div>
    </div>
    
-->

<script>


function new_sub_category_add(){

   	var name = $('#new_sub_category_name').val();
  	var description = $('#new_sub_category_description').val();
  	var category_id = "<?php echo $category_id;?>";
  	
  	
  	var formData = {
        	'name'     : name,
        	'description'     : description,
        	'category_id'     : category_id
        	
	}
	
	 var feedback = $.ajax({
    			type: "POST",
    			url: "add_sub_category.php",
    		    data: formData,
    		
    		    async: true,
    			
    	}).complete(function(){
        				
    	}).responseText;
  	
  	
  	swal({
  			title: "Success",
  			text: "The sub-category was added",
  			type: "success",
  			showCancelButton: false,
  			confirmButtonColor: "#5cb85c",
  			confirmButtonText: "OK",
  			closeOnConfirm: false
		},
		function(){
 			swal.close();
 		
	
 			location.href = "category_management_main_edit.php?category_id=" + category_id;
 			

		});
  	


};




function new_sub_category_close(){
   $('#modal_add_sub_category').modal('hide');
   
};


$(document).on("click", ".add_sub_category", function(e) {

   
   $('#modal_add_sub_category').modal('show');
   
});



$(document).on("click", ".edit_sub_category", function(e) {
	
	var sub_category_id = ($(this).attr('sub_category_id'));
	
	location.href = "category_management_sub_edit.php?sub_category_id=" + sub_category_id;
	
	
});


var l_m = "Display _MENU_ records per page";
var search = "Search";
var display_nothing = "No sub-categories to display";
var info = "Showing page _PAGE_ of _PAGES_ ";
var display_first = "First";
var display_last = "First";
var next = "Next";
var previous = "Previous";
var no_records = "No records available";
var filtered = " (filtered from _MAX_ total records)";


    
    $('#sub_catgeories').dataTable( {
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
    
$(document).on("click", ".delete_category", function(e) {


    var category_id = "<?php echo $category_id;?>";


	swal({
  			title: "Warning",
  			text: "Are you sure you want to delete this category and all its sub-categories",
  			type: "warning",
  			showCancelButton: true,
  			confirmButtonColor: "#d9534f",
  			confirmButtonText: "OK",
  			closeOnConfirm: false
		},
		function(){
 			swal.close();
 			
 			 var formData = {
			     'category_id'     : category_id
    		}
    		
    	
    		var feedback = $.ajax({
    			type: "POST",
    			url: "delete_category.php",
    			data: formData,
    		
    			async: true,
    			
    			}).complete(function(result){
            //alert(result.responseText);
    			
    			swal({
        			title: "Success",
        			text: "The category was deleted",
        			type: "success",
        			showCancelButton: false,
        			confirmButtonColor: "#5CB85C",
        			confirmButtonText: "OK",
        			closeOnConfirm: false
            },
		function(){
 			swal.close();
 			
 			location.href = "category_management_main_list.php";
 			
 			
		});     	
    			
    			
    			
        				
        		}).responseText;
 			
		});
		
		
		
		
		
		
        		

  


});

$(document).on("click", ".update_category", function(e) {

   var category_id = "<?php echo $category_id;?>";
   var category_name = $('#category_name').val();
   var category_decription = $('#category_description').val();

   
   var formData = {
	'category_id'     : category_id,
	'category_name'     : category_name,
	'category_decription'     : category_decription
    
	}
    		
    var feedback = $.ajax({
    	type: "POST",
    	url: "category_management_main_catgeory_update.php",
    	data: formData,
    		
    	async: false,
    			
    	}).complete(function(result){
        	 //alert(result.responseText);			
        }).responseText;
        
         swal({
  			title: "Success",
  			text: "The category was updated",
  			type: "success",
  			showCancelButton: false,
  			confirmButtonColor: "#5CB85C",
  			confirmButtonText: "OK",
  			closeOnConfirm: false
		},
		function(){
 			swal.close();
 			
 			location.href = "category_management_main_list.php";
 			
 			
		});
   
   

   
	
});


</script>
	