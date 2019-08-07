<?php
require_once("./header_main.php");


//preserve previously unsubmitted SR if it exists.
if($_POST){
$_SESSION['new_sr']=$_POST;
}


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

<style>
.continue_button_border_radius {border-radius: 15px !important;}
.continue_button_size {padding: 5px 25px !important;}
.continue_button_background {background-color:#E65825 !important;}
.continue_button_no_border {border: none !important;}


.general_orange_button_border_radius {border-radius: 15px !important;}
.general_orange_button_size {padding: 5px 25px !important;}
.general_orange_button_background {background-color:#E65825 !important;}
.general_orange_button_no_border {border: none !important;}

.general_blue_button_border_radius {border-radius: 15px !important;}
.general_blue_button_size {padding: 5px 25px !important;}
.general_blue_button_background {background-color:#3E78A6 !important;}
.general_blue_button_no_border {border: none !important;}




a[href^="http://maps.google.com/maps"]{display:none !important}
a[href^="https://maps.google.com/maps"]{display:none !important}

.gmnoprint a, .gmnoprint span, .gm-style-cc {
    display:none;
}
.gmnoprint div {
    background:none !important;
}

.panel_white {
    margin: 0 !important; 
    padding:0 !important;
    background:#33b5e5 !important;

}

</style>

<?php echo $_template["header"]; ?>

     <meta name="mobile-web-app-capable" content="yes">

<?php echo $_template["nav"]; ?>

<div style="margin:10px">

<br>



 <label><?php echo ADD_TAKE_NEW_PICTURE;?></label> 
<div class="panel panel-default">
  <div class="panel-body">

<form id="uploadimage" method="POST" enctype="multipart/form-data">
 <input type="hidden" name="<?php echo ini_get("session.upload_progress.name")?>" value="pics" />



            <label><?php echo TAKE_PICTURE_OR_SELECT_FILE;?></label> 
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                      Take/Select&hellip; 
                        <!-- <input type="file"  name="img[]" id="file" accept=".heic,image/*,application/octet-stream" capture="camera"  style="display: none; " /> -->
                        <input type="file"  name="img[]" id="file" accept=".heic,image/*,application/octet-stream"  style="display: none; " />
                                       
                    </span>
                </label>
                <input type="text" id="filepath" name="filepath" class="form-control" readonly value="">
            </div>
           
            <label><?php echo FILE_SPECIFICATIONS;?></label> 
            <br>
            
            
            <div class="form-group">
    <label><?php echo PICTURE_TITEL;?></label> 
    <input type="input" class="form-control text_input_radius" id="picture_titel" name="title[]" value="<?php echo $location_count+1; ?>">
  </div>
  
             <br>
              
             <center>
            <span id="picture_submit_button">
            <input type="submit" id="picture_submit" name="picture_submit" value="<?php echo UPLOAD_PICTURE;?>" class = "btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border" />
				<img src="img/loader.gif" alt="loader1" style="display:none; height:30px; width:auto;" id="loaderImg">            
            </div>
             </center>
   </form>

</div>




</div>

<div style="margin:10px" id="existing_pics">
 </div>


<!--<center>
   <button onclick="go_back()" type="button" class="btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border"><?php echo CONTINUE_BUTTON;?></button>
   
  </center>-->
  
  <br>
  <br>
  
  
<div id="big_picture" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        	<div class="modal-content">
        		
            		<div class="modal-body">
            		
            
            		
            		
            		<center>
            		<span id="show_big_image_in_modal">  </span>
            		<br>
            		
            		<span id="modal_picturename"></span>
            		<br>
            		<span id="modal_datetime"></span>
            		</center>
            		<br>
            		
            		<center>
   <button onclick="close_big_picture()" type="button" class="btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border"><?php echo CLOSE;?></button>
   
  </center>

            		
	    
	     		
            </div>
        </div>
    </div>


  
  
<script>



function close_big_picture()
{
     $('#big_picture').modal('hide'); 
} 


  function go_back()
{
     location.href = "create_new_service_request.php";
} 

  function show_big_image(id)
{
          
      var formData = {
        				'id'     : id,
       			}
    	
    	   var feedback = $.ajax({
    			type: "POST",
    			url: "receive_sr_large_image_filename.php",
    		    data: formData,
    		
    		    async: false,
    			
    		}).complete(function(){
    		
    		
    		}).responseText;
    		
    		var feedback_array = feedback.split("|");
    		
    		var image_link = feedback_array[0];
    		var image_title = feedback_array[1];
    		var image_date_time = feedback_array[2];
    		
    $('#modal_picturename').html("<font size='3'>" + image_title + "</font>");
    $('#modal_datetime').html("<font size='2'>" + image_date_time + "</font>");
    		
     
     $('#show_big_image_in_modal').html("<img src='uploads/" + image_link + "' class='img-rounded' alt='Image'>");
     
     $('#big_picture').modal('show'); 
     


} 




function delete_image(id)
{
     
     
     var sr_number = '<?php echo $sr_number; ?>';
     
     var picture_delete_confirm_header =  '<?php echo PICTURE_DELETE_CONFIRM_HEADER; ?>';
     var picture_delete_confirm_text =  '<?php echo PICTURE_DELETE_CONFIRM_TEXT; ?>';
     var picture_delete_confirm_yes =  '<?php echo PICTURE_DELETE_CONFIRM_YES; ?>';
     
     var picture_delete_confirm_header_done =  '<?php echo PICTURE_DELETE_CONFIRM_HEADER_DONE; ?>';
     var picture_delete_confirm_text_done =  '<?php echo PICTURE_DELETE_CONFIRM_TEXT_DONE; ?>';
     
     swal({
  					title: picture_delete_confirm_header,
 					text: picture_delete_confirm_text,
  					type: "warning",
  					showCancelButton: true,
  					confirmButtonColor: "#5CB85C",
  					confirmButtonText: "",
  					closeOnConfirm: true
				},
				function(){
				 var formData1 = {
             'id'     : id,
            };
        $.ajax({
                type:"POST",
                url: "delete_uploaded_sr_picture.php",
                data: formData1,
                async: false,    
         
                success: function(data)   
                  {
                    $.ajax({
                      url: "show_existing_pics.php", 
                      type: "GET",             
                      //data: new FormData(this), 
                      contentType: false,       
                      cache: false,
                      async: true,             
                      processData:false,      
                      
                      success: function(data)   
                        {
                          var result_allpics = data;
                          $("#existing_pics").html(result_allpics);
                          console.log(result_allpics);
                        }
                      })

                  }
              });    
            
    	/*
    	   var feedback = $.ajax({
    			type: "POST",
    			url: "delete_uploaded_sr_picture.php",
    		    data: formData,
    		
    		    async: false,
    			
    		}).complete(function(){
    		  		  
            $.ajax({
                url: "show_existing_pics.php", 
                type: "GET",             
                //data: new FormData(this), 
                contentType: false,       
                cache: false,
                async: true,             
                processData:false,      
                
                success: function(data)   
                  {
                    var result_allpics = data;
                    $("#existing_pics").html(result_allpics);
                    console.log(result_allpics);
                  }
                })

    			swal({
  					title: picture_delete_confirm_header_done,
 					  text: picture_delete_confirm_text_done,
  					type: "success",
  					showCancelButton: false,
  					confirmButtonColor: "#5CB85C",
  					confirmButtonText: "OK",
  					closeOnConfirm: true
				},
				function(){
	 			
				});
    		
 	    });

   */     
	
	});

} 

$("#uploadimage").on('submit',(function(e) {


    var sr_number = '<?php echo $sr_number; ?>';
    var picture_titel = $("#picture_titel").val();
    
    
	function formatFileSize(bytes,decimalPoint) {
   		if(bytes == 0) return '0 Bytes';
   			var k = 1000,
       		dm = decimalPoint || 2,
       		sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
       		i = Math.floor(Math.log(bytes) / Math.log(k));
   			return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
	}
	console.log("1");
   $("#picture_submit").prop("disabled",true);
     $("#picture_submit").css("cursor", "not-allowed");
$("#loaderImg").show(); 
    e.preventDefault();
	console.log("2");
   	var filerequired = $("#filepath").val();
   	
   	var oops = '<?php echo OOPS; ?>';
   	var file_required = '<?php echo FILE_REQUIRED; ?>';
   	var title_required = '<?php echo FILE_TITLE_REQUIRED; ?>';
   	if(filerequired == ""){
console.log("3");
   	  swal(oops, file_required, "error");
			$("#picture_submit").prop("disabled",false);
   	  $("#picture_submit").css("cursor","pointer");
        $("#loaderImg").hide(); 
        console.log("4");
   	  return;
   	
   	
   	}
   	
   	if(picture_titel == ""){
   		console.log("5");
   		swal(oops, title_required, "error");
		   $("#picture_submit").prop("disabled",false);
    	  $("#picture_submit").css("cursor","pointer");
        $("#loaderImg").hide();
        console.log("5");
   	  return;
   
   	
   	}
 $("#loaderImg").show(); 
  var result = "";
  $.ajax({
	url: "uploadImage.php", 
	type: "POST",             
	data: new FormData(this), 
	contentType: false,       
	cache: false,
	async: true,             
	processData:false,      
	
	success: function(data)   
		{
			console.log("6");

		    result = data;

	
	
	  var oops = '<?php echo OOPS; ?>';
   	var file_exist = '<?php echo FILE_EXIST; ?>';
   	var file_to_big = '<?php echo FILE_TO_BIG; ?>';
   	var file_to_big_2 = '<?php echo FILE_TO_BIG_2; ?>';
   	var porn_upload = '<?php echo FILE_PORN; ?>';
   	var success_upload = '<?php echo FILE_NO_PORN; ?>';
   	var done = '<?php echo DONE; ?>';
//alert(result);
	result=JSON.parse(result);
	//result=result[0]; //only uploading one at a time
	//console.log(JSON.stringify(result));
   			console.log("7");
   	if(result['status'] == 1){
   		console.log("8");
   		$("#picture_submit").prop("disabled",false);
   	  $("#picture_submit").css("cursor","pointer");
        $("#loaderImg").hide();
	    swal(oops, result['msg'], "error");
	        	console.log("9");
	}else{
		console.log("10");
	    $("#picture_submit").prop("disabled",false);
   	  $("#picture_submit").css("cursor","pointer");
        $("#loaderImg").hide(); 
	    var success_upload_header = '<?php echo SUCCESS_UPLOAD_HEADER; ?>';
	    var success_upload_text = '<?php echo SUCCESS_UPLOAD_TEXT; ?>';

	    $("#loaderImg").hide(); 
	    swal({
  					title: success_upload_header,
 					  text: success_upload_text,
  					type: "success",
  					showCancelButton: false,
  					confirmButtonColor: "#5CB85C",
  					confirmButtonText: "OK",
  					closeOnConfirm: true
				},
				function(){
				$.ajax({
            url: "show_existing_pics.php", 
            type: "GET",             
            //data: new FormData(this), 
            contentType: false,       
            cache: false,
            async: true,             
            processData:false,      
            
            success: function(data)   
              {
                //alert(data);
                var result_allpics = data;
                $("#existing_pics").html(result_allpics);
                //console.log(result_allpics);
              }
            })
				//location.href = "create_new_service_request_take_pictures.php?sr_number=" + sr_number;
		
				});
	    

	    
	        	
	}
	
	
		}
	});		
	


}));

$(document).on('change', ':file', function() {
    
    var input = $(this);
       
   
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
        
        
        $("#filepath").val(label);
        
    
});


</script>
<!-- <script src="js/heictojpg/libde265-selector.js"></script>
<script src="js/heictojpg/heif-api.js"></script>
<script src="js/heictojpg/heif-extension.js"></script>
<script src="js/heictojpg/hevc-decoder.js"></script>
<script src="js/heictojpg/image-provider.js"></script>
<script src="js/heictojpg/footer.js"></script> -->