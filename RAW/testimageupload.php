 <?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if(count($_FILES) > 0){

	print_r($_FILES);

	$files=reset($_FILES);
	$inputname=key($_FILES);
	$names=reset($files['name']);
	$i=0;
	$max=count($files['name']);

	$curtime = time();

	while($i<$max){

		if(move_uploaded_file($files['tmp_name'][$i], "uploads/".$curtime."_".$files['name'][$i])){
			echo "uploaded";
		}else{
			echo "Error";
		}
		$i++;
	}
}

?>

<form  method="POST" enctype="multipart/form-data">
	<span class="btn btn-primary">
      	Take/Select&hellip; 
        <input type="file"  name="img[]" id="file" accept=".heic,image/*" capture="camera" />
                       
    </span>
    <input type="submit" value="Upload" />
</form>				