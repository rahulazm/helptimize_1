<?php 
session_start();
require_once('./common.inc.php');
require_once('./mysql_lib.php');

$db_get_all_sr_images = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_all_sr_images ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_all_sr_images ->connect_error . ']');
}

$sql_get_all_sr_images = "SELECT * FROM service_requests_images WHERE service_request_id ='$sr_number'";

$result_get_all_sr_images = $db_get_all_sr_images->query($sql_get_all_sr_images);
$count_all_sr_images = $result_get_all_sr_images->num_rows;
$today=date("Y-m-d");
$db_get_all_sr_images->close();
$str="select * from view_pics where userId='".$_SESSION['id']."' and (srId is NULL or srId='') and datetime LIKE '%$today%'";
$images=$_sqlObj->query($str);
$location_count = $images->num_rows;
?>
<br>
 <label><?php echo EXISTING_PICTURES;?></label> 
 <div class="panel panel-default">
  <div class="panel-body">
  <table id='sr_imgs'>
  
  <?php
 
$row=@reset($images); 
  while ($row) {
?>
  <tr>
   <td><font size='3'><?php echo $row['title'];?></font></td>
  
  </tr>
  <tr>
   <td><font size='2'><?php echo $row['datetime'];?></font></td>
  
  </tr>
  
  <tr>
   <td>
  <img onclick='show_big_image(<?php echo $row['id'];?>)' src='<?php imgPath2Url(smallPicName($row["url"]));?>' class='img-rounded' alt='Imag' style='width: 150px;'>
  <input id='<?php echo $ordNum;?>' value='<?php echo $row['id'];?>' type='hidden'/>
  <br><br>
   </td>
     <td width='110px'>
     
     
  
   </td>
   <td>
   <button class='btn btn-danger general_orange_button_border_radius' type='button' onclick='delete_image(<?php echo $row['id'];?>)'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>
   <input type="hidden" name="pic_id" value="<?php $row['id'];?>">
   </td>
   </tr>
 <?php  
  $row=next($images);
  }
  
  ?>
</table>
    
  </div>
  </div>
 
