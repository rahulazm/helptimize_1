<?php
require_once("./header_main.php");

// count all unread messages 


$db_count_unread_messages = new mysqli("$host", "$username", "$password", "$db_name");

if($db_count_unread_messages ->connect_errno > 0){
    die('Unable to connect to database [' . $db_count_unread_messages ->connect_error . ']');
}

$sql_count_unread_messages = "SELECT * FROM message_list WHERE receiver_id='".$_SESSION['id']."' AND read_status='0' order by id desc";

$result_count_unread_messages = $db_count_unread_messages->query($sql_count_unread_messages);
$count_unread_messages = $result_count_unread_messages->num_rows;

$db_count_unread_messages->close();

echo $_template["header"];


echo $_template["nav"];

?>

       <section class="wrapper" style="width: 80%;margin: auto;">

<div class="row">
  <div class="col-xs-12 col-md-12">
  
  <div class="panel panel-default">
  <div class="panel-body">
  
  <table style="margin-top: 20px">
  <tr>
 <!--  <td><button onclick="go_back()" type="button" class="btn btn-primary"><?php echo BACK;?></button></td> <td width="30"></td>--><td> <h4><font><?php echo MESSAGE_LIST;?></font></h4></td>
  </tr>
  </table>

  </div>
</div>


<br>
<div style="margin-left:10px;margin-right:10px">
<label><?php echo UNREAD_MESSAGES;?></label> 
<table id="unread_message_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
        	<thead>
            	<tr>
                	<th><?php echo MESSAGE_TYPE ;?></th>
                	<th><?php echo MESSAGE_TITLE ;?></th>
                	<th><?php echo MESSAGE_DATE_TIME ;?></th>
                	<th></th>
                	
              		</tr>
        	</thead>
        	
        	<tbody>
        	
        	<?php
        	 
        	 while ($row = $result_count_unread_messages->fetch_assoc()) {
        	 
        	 
        	 	$sr_id = $row['sr_id'];
        	
        	 	
        	 
        	 ?>
        	 	<tr <?php if($row['read_status'] == "1") { ?>bgcolor="#CCCCCC"<?php } ?>>
        	 	    
        	 	    <?php 
                   if($row['message_type'] != ""){
        	 	    	echo "<td style='width: 150px' align='left'><i class='fa fa-info-circle fa-2x' aria-hidden='true'></i>&nbsp;".$row['message_type']."</td>";
        	 	    
        	 	    }        	 	    
        	 	    ?>
        	 	    
             		
             		<td ><?=$row['message_title']?></td> 
             		<td style="width: 175px"><?=changeDateFormat($row['date_time'])?></td> 
             		<td style="width: 75px">
             		
             		<?php
             		
                if($row['url'] != ""){
             		?>
        	 	    	<a href="message_update.php?id=<?php echo $row['id']; ?>" class="btn btn-default"> <i class="fa fa-eye" aria-hidden="true"></i></a>
        	 	    
        	 	    <?php
        	 	    }
        	 	    
        	 	    
        	 	    
        	 	    
        	 	    ?>
        	 	    
        	 	    
        	 	    
             		
             		

             		
             		
             		</td> 
        	 
        	      </tr>
        	 
        	 
        	 <?php
        	 }
        	 ?>
        	 
        	 
        	  </tbody>
   		 </table>

</div>
</section>

<?php include("footer.php"); ?>  
<script>


$(document).on("click", ".btn_load_sr_message_list", function(e) {

    var sr_id =  $(this).attr('sr_id');

	location.href = "messaging_sr.php?sr_id=" + sr_id;
	

});

function go_back()
{
     location.href = "main.php";
} 


var l_m = "<?php echo DISPLAY_X_RECORDS; ?>";
var info = "<?php echo DISPLAY_PAGE_X_FROM_X; ?>";
var next = "<?php echo DISPLAY_NEXT; ?>";
var previous = "<?php echo DISPLAY_PREVIOUS; ?>";
var search = "<?php echo DISPLAY_SEARCH; ?>";
var no_records = "<?php echo DISPLAY_NO_RECORDS; ?>";
var filtered = "<?php echo DISPLAY_FILTERED; ?>";
var display_nothing = "<?php echo DISPLAY_NO_SUBMITTED_SR; ?>";
var no_awarded_sr = "<?php echo NO_AWARDED_SR_YET; ?>";
var no_completed_sr = "<?php echo NO_COMPLETED_SR_YET; ?>";
var no_co_sign = "<?php echo NO_CO_SIGN; ?>";
var no_unread_messages = "<?php echo NO_UNREAD_MESSAGES; ?>";
var display_first = "<?php echo DISPLAY_FIRST; ?>";
var display_last = "<?php echo DISPLAY_LAST; ?>";


$(document).ready(function() {
    $('#unread_message_list').dataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false,
         "dom": 'lrtip',
       
      
        "language": {
            "lengthMenu": l_m,
            "search":         search,
            "zeroRecords": no_unread_messages,
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
