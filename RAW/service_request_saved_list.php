<?php

error_reporting(E_ALL);
require_once("./header_main.php");


// get all service requests

$db_get_service_requests = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_service_requests ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_service_requests ->connect_error . ']');
}

 $sql_get_service_requests = "SELECT * FROM service_requests WHERE status ='open' AND account_id='$account_id' AND save_status='1' AND submit_status='0'";

$result_get_service_requests = $db_get_service_requests->query($sql_get_service_requests);

$db_get_service_requests->close();


// get all submitted service requests without any bids

$db_get_submitted_service_requests = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_submitted_service_requests ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_service_requests ->connect_error . ']');
}

$sql_get_submitted_service_requests = "SELECT * FROM service_requests WHERE status ='open' AND account_id='$account_id' AND submit_status='1'";

$result_get_submitted_service_requests = $db_get_submitted_service_requests->query($sql_get_submitted_service_requests);
$result_get_submitted_service_requests_bids = $db_get_submitted_service_requests->query($sql_get_submitted_service_requests);


$db_get_submitted_service_requests->close();



// get max sr delete time frame


$db_get_sr_delete_time = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_sr_delete_time ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_sr_delete_time ->connect_error . ']');
}

 //$sql_get_delete_time = "SELECT sr_delete_max_time,sr_delete_max_time_penalty_fee FROM accounts WHERE account_id='$account_id'";

//$result_get_delete_time = $db_get_sr_delete_time->query($sql_get_delete_time);

//$row_get_delete_time = $result_get_delete_time->fetch_assoc();


//$db_get_sr_delete_time->close();

$sr_delete_max_time = 5;//$row_get_delete_time['sr_delete_max_time'];
$sr_delete_max_time_penalty_fee = 5;//$row_get_delete_time['sr_delete_max_time_penalty_fee'];

echo $_template["header"];

?>


<style>

.panel {
    margin: 0 !important; 
    padding:0 !important;
    background:#33b5e5 !important;

}
</style>

<script type="text/javascript" src="js/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="js/bootstrap-switch.min.js"></script>


<link rel="stylesheet" type="text/css" href="css/bootstrap-clockpicker.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker3.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-switch.min.css">

<?php echo $_template["nav"]; ?>

<div class="row">
  <div class="col-xs-12 col-md-12">
  
  <div class="panel panel-default">
  <div class="panel-body">
  
  <table>
  <tr>
  <td><button onclick="go_back()" type="button" class="btn btn-primary"><?php echo BACK;?></button></td><td width="30"></td><td> <h4><font color="#ffffff"><?php echo EDIT_SR;?></font></h4></td>
  </tr>
  </table>

  </div>
</div>

<br>

<div style="margin-left:10px;margin-right:10px">

<h4><?php echo MY_SAVED_SERVICE_REQUESTS;?></h4>
<table id="saved_sr_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
        	<thead>
            	<tr>
                	<th width="110px"><?php echo SR_NUMBER ;?></th>
                	<th><?php echo SR_DESCRIPTION ;?></th>
                	<th></th>
                	<th></th>
                	
              		</tr>
        	</thead>
        	
        	<tbody>
        	
        	<?php
        	 
        	 while ($row = $result_get_service_requests->fetch_assoc()) {
        	 
        	 	echo $service_id = $row['number'];
        	 	
        	 
        	 ?>
        	 	<tr>
        	 	    
             		<td style="width: 75px"><?=$row['number']?></td> 
             		<td style="width: 75px"><?=$row['name']?></td> 
             		
             		<td style="width:10px">
        	        <?php
        	        echo '<button edit_service_id ="' . $service_id . '"  class="btn btn-default edit_sr" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
        	       
        	      ?>
        	          </td>
        	          
        	          <td style="width:10px">
        	        <?php
        	        echo '<button delete_service_id ="' . $service_id . '"  class="btn btn-danger delete_sr" ><i class="fa fa-trash" aria-hidden="true"></i></button>';
        	       
        	      ?>
        	          </td>
             			
        	 
        	      </tr>
        	 
        	 
        	 <?php
        	 
        	 }
        	 ?>
        	 
        	 
        	  </tbody>
   		 </table>
   		 
   		 <hr>
   		 
   		<h4><?php echo MY_SAVED_SERVICE_REQUESTS_NON_BIDS;?></h4>
   		 
   		
   		 <table id="submitted_no_bids_sr_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
        	<thead>
            	<tr>
                	<th width="110px"><?php echo SR_NUMBER ;?></th>
                	<th><?php echo SR_DESCRIPTION ;?></th>
                	<th></th>
                	<th></th>
                	
              		</tr>
        	</thead>
        	
        	<tbody>
        	
        	<?php
        	 
        	 while ($row = $result_get_submitted_service_requests->fetch_assoc()) {
        	 
        	 	$id = $row['number'];
        	 	
        	 	
        	 	
        	 	$db_get_bids = new mysqli("$host", "$username", "$password", "$db_name");

				if($db_get_bids ->connect_errno > 0){
    				die('Unable to connect to database [' . $db_get_bids ->connect_error . ']');
				}

				$sql_get_bids = "SELECT id FROM service_bids WHERE request_number='$id'";

				$result_get_bids = $db_get_bids->query($sql_get_bids);
				
				$row_cnt_bids = $result_get_bids->num_rows;

				$db_get_bids->close();
				
				
				
				if($row_cnt_bids < 1){
        	 	
        	 	
        	 
        	 ?>
        	 	<tr>
             		<td style="width: 75px"><?=$row['number']?></td> 
             		<td style="width: 75px"><?=$row['name']?></td> 
             		
             		<td style="width:10px">
        	        <?php
        	        echo '<button edit_service_id ="' . $id . '"  class="btn btn-default edit_sr" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
        	       
        	      ?>
        	          </td>
        	          
        	          <td style="width:10px">
        	        <?php
        	        echo '<button delete_service_id ="' . $id . '"  class="btn btn-danger delete_sr" ><i class="fa fa-trash" aria-hidden="true"></i></button>';
        	       
        	      ?>
        	          </td>
             			
        	 
        	      </tr>
        	 
        	 
        	 <?php
        	 }
        	 }
        	 ?>
        	 
        	 
        	  </tbody>
   		 </table>
   		 
   		 
   		  <hr>
   		 
   		 <h4><?php echo MY_SUBMITTED_SERVICE_REQUESTS_WITH_BIDS;?></h4>
   		 
   		 
   		 <table id="submitted_with_bids_sr_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
        	<thead>
            	<tr>
                	<th width="110px"><?php echo SR_NUMBER ;?></th>
                	<th><?php echo SR_DESCRIPTION ;?></th>
                	<th></th>
                	<th></th>
                	
              		</tr>
        	</thead>
        	
        	<tbody>
        	
        	<?php
        	 
        	 while ($row = $result_get_submitted_service_requests_bids->fetch_assoc()) {
        	 
        	 	$id = $row['number'];
        	 	
        	 	
        	 	
        	 	$db_get_bids = new mysqli("$host", "$username", "$password", "$db_name");

				if($db_get_bids ->connect_errno > 0){
    				die('Unable to connect to database [' . $db_get_bids ->connect_error . ']');
				}

				$sql_get_bids = "SELECT id FROM service_bids WHERE request_number='$id'";

				$result_get_bids = $db_get_bids->query($sql_get_bids);
				
				$row_cnt_bids = $result_get_bids->num_rows;

				$db_get_bids->close();
				
				
				
				if($row_cnt_bids > 0){
        	 	
        	 	
        	 
        	 ?>
        	 	<tr>
             		<td style="width: 75px"><?=$row['number']?></td> 
             		<td style="width: 75px"><?=$row['name']?></td> 
             		
             		<td style="width:10px">
        	        <?php
        	        echo '<button edit_service_id ="' . $id . '"  class="btn btn-default edit_sr_bids" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
        	       
        	      ?>
        	          </td>
        	          
        	          <td style="width:10px">
        	        <?php
        	        echo '<button delete_service_id ="' . $id . '"  class="btn btn-danger delete_sr" ><i class="fa fa-trash" aria-hidden="true"></i></button>';
        	       
        	      ?>
        	          </td>
             			
        	 
        	      </tr>
        	 
        	 
        	 <?php
        	 }
        	 }
        	 ?>
        	 
        	 
        	  </tbody>
   		 </table>
   		 

   		 
   		
   		 
   		 
   		 
</div>





<script>



function go_back()
{
     location.href = "main.php";
} 


$(document).on("click", ".edit_sr_bids", function(e) {

	var sr_oops = '<?php echo SR_OOPS; ?>';
	var sr_edit_with_bids_alert = '<?php echo SR_EDIT_WITH_BIDS_ALERT; ?>';

	swal(sr_oops, sr_edit_with_bids_alert, "error");


});



$(document).on("click", ".edit_sr", function(e) {

 var sr_id = ($(this).attr('edit_service_id'));

 
 location.href = "service_request_edit.php?sr_id=" + sr_id;


});

$(document).on("click", ".delete_sr", function(e) {

    var sr_delete = '<?php echo SR_DELETE; ?>';
    var sr_delete_text = '<?php echo SR_DELETE_TEXT; ?>';
    var sr_delete_max = '<?php echo $sr_delete_max_time; ?>';
    
    var sr_delete_max_time_penalty_fee = '<?php echo $sr_delete_max_time_penalty_fee; ?>';
    
    
    sr_delete_success = '<?php echo SR_DELETE_SUCCESS; ?>';
    sr_delete_success_text = '<?php echo SR_DELETE_TEXT_SUCCESS; ?>';
    
    sr_delete_max_time = '<?php echo SR_DELETE_MAX_TIME; ?>';
    sr_delete_max_time_text = '<?php echo SR_DELETE_MAX_TIME_TEXT; ?>';
    sr_delete_max_time_text_2 = '<?php echo SR_DELETE_MAX_TIME_TEXT_2; ?>';
    
    

    
    

    
    var sr_id = ($(this).attr('delete_service_id'));
    
    // get sr_first save time and check if its less than 5 minutes.
    
    var formData = {
        'sr_id'     : sr_id,
    
    	}
    	
    	  var feedback = $.ajax({
    			type: "POST",
    			url: "check_if_sr_older_than_5_minutes.php",
    		    data: formData,
    		
    		    async: false,
    			
    	}).complete(function(){
        				
    	}).responseText;
    
    
       var minutes = parseInt(feedback);
   
       
       
       if(minutes > sr_delete_max){
       
    
       
       	swal({
  		title: sr_delete_max_time,
  		text: sr_delete_max_time_text + " " + sr_delete_max_time_penalty_fee + " " + sr_delete_max_time_text_2,
  		type: "warning",
  		showCancelButton: true,
  		confirmButtonColor: "#DD6B55",
  		confirmButtonText: "Yes, delete it!",
  		closeOnConfirm: false
	},
	function(){
	
	
		var formData = {
        'sr_id'     : sr_id,
       
    	}
    	
    	   var feedback = $.ajax({
    			type: "POST",
    			url: "service_request_delete.php",
    		    data: formData,
    		
    		    async: false,
    			
    		}).complete(function(){
    		
    		
    			swal({
  					title: sr_delete_success,
 					text: sr_delete_success_text,
  					type: "success",
  					showCancelButton: false,
  					confirmButtonColor: "#5CB85C",
  					confirmButtonText: "OK",
  					closeOnConfirm: false
				},
				function(){
				
				// **********************************
				// module to write
				// deduct penalty fee from service request
			    // **********************************

				
				location.href = "service_request_saved_list.php";
  
				});
    		
    		
    		
    		});
	
	
	});
       
      
       
       
       }else{
       
       
       
       		swal({
  		title: sr_delete,
  		text: sr_delete_text,
  		type: "warning",
  		showCancelButton: true,
  		confirmButtonColor: "#DD6B55",
  		confirmButtonText: "Yes, delete it!",
  		closeOnConfirm: false
	},
	function(){
	
	
		var formData = {
        'sr_id'     : sr_id,
       
    	}
    	
    	   var feedback = $.ajax({
    			type: "POST",
    			url: "service_request_delete.php",
    		    data: formData,
    		
    		    async: false,
    			
    		}).complete(function(){
    		
    		
    			swal({
  					title: sr_delete_success,
 					text: sr_delete_success_text,
  					type: "success",
  					showCancelButton: false,
  					confirmButtonColor: "#5CB85C",
  					confirmButtonText: "OK",
  					closeOnConfirm: false
				},
				function(){
				
				location.href = "service_request_saved_list.php";
  
				});
    		
    		
    		
    		});
	
	
		});
       
       
       
       
       }
    


	


});


var l_m = "<?php echo DISPLAY_X_RECORDS; ?>";
var info = "<?php echo DISPLAY_PAGE_X_FROM_X; ?>";
var next = "<?php echo DISPLAY_NEXT; ?>";
var previous = "<?php echo DISPLAY_PREVIOUS; ?>";
var search = "<?php echo DISPLAY_SEARCH; ?>";
var no_records = "<?php echo DISPLAY_NO_RECORDS; ?>";
var filtered = "<?php echo DISPLAY_FILTERED; ?>";
var display_nothing_saved = "<?php echo DISPLAY_NO_SAVED_SR; ?>";
var display_submitted_no_bids = "<?php echo DISPLAY_SUBMITTED_NO_BIDS; ?>";
var display_no_submitted_sr = "<?php echo DISPLAY_NO_SUBMITTED_SR; ?>";
var display_first = "<?php echo DISPLAY_FIRST; ?>";
var display_last = "<?php echo DISPLAY_LAST; ?>";


$(document).ready(function() {
    $('#saved_sr_list').dataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false,
         "dom": 'lrtip',
       
      
        "language": {
            "lengthMenu": l_m,
            "search":         search,
            "zeroRecords": display_nothing_saved,
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
    
    $('#submitted_with_bids_sr_list').dataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false,
         "dom": 'lrtip',
       
      
        "language": {
            "lengthMenu": l_m,
            "search":         search,
            "zeroRecords": display_submitted_no_bids,
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
    
     $('#submitted_no_bids_sr_list').dataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false,
         "dom": 'lrtip',
       
      
        "language": {
            "lengthMenu": l_m,
            "search":         search,
            "zeroRecords": display_no_submitted_sr,
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
    
    
    



} );
     





</script>
