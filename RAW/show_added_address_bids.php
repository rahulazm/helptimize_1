<?php 

session_start();
require_once('./common.inc.php');
require_once('./mysql_lib.php');
require_once("./en.lang.inc.php");

$configs=$_configs;

// load all addresses for this SR

//$db_get_sr_addresses = new mysqli("$host", "$username", "$password", "$db_name");

$db_get_sr_addresses = new mysqli($_configs["host"], $_configs["username"], $_configs["password"], $_configs["db_name"]);

if($db_get_sr_addresses ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_sr_addresses ->connect_error . ']');
}
$today=date("Y-m-d");
$sql_get_sr_addresses = "SELECT * FROM address WHERE userId='".$_SESSION['id']."' and personal IS NULL and bidId is NULL and srId = ".$_GET['sr_number']." and (pob is null or pob=0)";

$result_get_sr_addresses = $db_get_sr_addresses->query($sql_get_sr_addresses);
$location_count = $result_get_sr_addresses->num_rows;

$db_get_sr_addresses->close();

?>        

        <thead>
        	<tr>
        	<th  bgcolor="#3E78A6" colspan="4" style="text-align:center"><font color="#FFFFFF"><?php echo SR_ADDRESS_LOCATIONS;?></font></th>
        	
        	</tr>
            	<tr>
                	<th><?php echo SR_ADDRESS_NAME ;?></th>
                	<th><?php echo SR_ADDRESS ;?></th>
                	<th></th>
                	<th></th>
              		</tr>
        	</thead>
        	
        	<tbody>
        	
        	<?php
        	 
        	 while ($row = $result_get_sr_addresses->fetch_assoc()) {
        	 
        	 $address_id = $row['id'];
        	 
        	 ?>
        	 	<tr>
             		<td style="width: 75px"><?=$row['title']?></td> 
             		<td style="width: 75px"><?=$row['address']?></td>
             		
             		<td style="width:10px">
        	        <?php
        	        echo '<button stored_address_info_id ="' . $address_id . '"  class="btn btn-default general_blue_button_background stored_address_info general_blue_button_border_radius general_blue_button_no_border" ><i class="fa fa-pencil-square-o" style="color:white"></i></button>';

        	      
        	      ?>
        	          </td>
             	
             	    <td style="width:10px">
        	        <?php
        	       
        	        echo '<button address_id="' . $address_id . '"  class="btn btn-danger delete_stored_address general_blue_button_border_radius general_blue_button_background general_blue_button_no_border" ><i class="fa fa-trash-o fa-lg"></i></button>';
        	      
        	      ?>
        	          </td>
        	               
        	          
        	      </tr>
        	 
        	 
        	 <?php
        	 }
        	 ?>
        	 
        	 
        	  </tbody>