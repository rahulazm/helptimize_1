<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];

$category_id = $_POST["category_id"];

$db_get_category = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_category ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_category ->connect_error . ']');
}

$sql_get_category = "SELECT * FROM main_categories WHERE id='$category_id'";

$result_get_category = $db_get_category->query($sql_get_category);

$row_category = $result_get_category->fetch_assoc();

$sub_category = $row_category['sub_category'];

$db_get_category->close();

if($sub_category == "1"){

	// get sub category
	
	$db_get_sub_category = new mysqli("$host", "$username", "$password", "$db_name");

	$myArray = array();
	if ($result = $db_get_sub_category->query("SELECT * FROM category_subcategory WHERE category_id='$category_id'")) {

    while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
    }
    
}

$result->close();
$db_get_category->close();

echo json_encode($myArray);
      

}else{

  echo "no_sub";


}





?>