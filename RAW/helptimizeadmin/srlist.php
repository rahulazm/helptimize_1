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

$sql_get_sr  = "SELECT b.srId,s.title,s.descr,s.create_dateTime from bids as b,serviceRequests as s where b.srId=s.id group by b.srId HAVING(count(*)) <2 ";

$result_get_sr = $db_get_sr->query($sql_get_sr);

$db_get_sr->close();

?>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
		
	<h3> <i class="fa fa-list fa-1x"></i> SR with few bids </h3>
	
	<br>
	
	<table id="main_catgeories"  name="main_catgeories" class="table table-striped table-bordered" cellspacing="0" width="100%">
        	<thead>
            	<tr>
                	<th>SR ID</th>
                	<th>Title</th>
                	<th>Description</th>
                	<th>DateTime</th>
                </tr>
        	</thead>
        	
        	<tbody>
        	
        	<?php
        	$row = $result_get_sr->fetch_assoc();

			//print_r($row);
			//echo $result_get_sr;
        	
        	  while ($row = $result_get_sr->fetch_assoc()) {
        	     	 	//$category_id  = $row['id'];
        	 ?>
        	 
        	    <tr>
        	 		<td style="width: 220px"><?php echo $row['srId']?></td> 
             	<td style="width: 400px"><?=$row['title']?></td> 
             	<td style="width: 400px"><?=$row['descr']?></td>  
             	<td style="width: 400px"><?=$row['create_dateTime']?></td> 
             </tr>
             	
        	 
        	 <?php
        	 }
        	 
        	 ?>
        	 
        	  </tbody>
   		 </table>
   	</div>	 
</div>