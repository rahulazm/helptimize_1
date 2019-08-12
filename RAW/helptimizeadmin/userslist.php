<?php
$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

include "menu.php";

// get all sr

 
$db_get_sr = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_sr ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_sr ->connect_error . ']');
}

$sql_get_sr  = "select u.id, u.username, u.email, u.loginDatetime, (select count(*) from bids as b where  b.ownerId=u.id) as totalbids, (select count(*) from serviceRequests as s where s.ownerId=u.id) as totalServReq  from users as u GROUP BY u.id ";
$result_get_sr = $db_get_sr->query($sql_get_sr);
//$row1=$result_get_sr->fetch_assoc();




?>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
		
	<h3> <i class="fa fa-list fa-1x"></i> Registered Users list </h3>
	
	<br>
	
	<table id="main_catgeories"  name="main_catgeories" class="table table-striped table-bordered" cellspacing="0" width="100%">
        
            	<tr>
                	<td><b>Name</b></td>
                	<td><b>Email</b></td>
                	<td><b>Date</b></td>
                	<td><b>Sr Count</b></td>
                	<td><b>Bids Count</b></td>
                </tr>
        	
        	
        	<tbody>
        	
        	<?php
        	//$row = $result_get_sr->fetch_assoc();

			//print_r($row);
			//echo $result_get_sr;
        	
        	while($row = $result_get_sr->fetch_assoc()){
        	     	 	
        	 ?>
        	 
        	    <tr>
        	 		<td style="width: 220px"><?php echo $row['username']?></td> 
             	<td style="width: 400px"><?=$row['email']?></td> 
             	<td style="width: 220px"><?=$row['loginDatetime']?></td>  
             	<td style="width: 220px"><?=$row['totalServReq']?></td> 
             	<td style="width: 220px"><?=$row['totalbids']?></td> 
             </tr>
             	
        	 
        	 <?php
        	 }
        	 
        	 ?>
        	 
        	  </tbody>
   		 </table>
   	</div>	 
</div>