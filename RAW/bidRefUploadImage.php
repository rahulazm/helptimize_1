<?php
require_once("./header_main.php");
$srid=$_sqlObj->escape($_GET['sr_id']);
$bidid=$_REQUEST["bidid"];

##########Check Total bid in Review bid table
$qstr=($_sqlObj->query('
select count(id) as totbid from bids_revision where bidid='.$bidid));
$total_count= $qstr[0]["totbid"]+1;


// find all images uploaded by this bidder for this SR.
$getstr='select * from pics_revision where userId="'.$_SESSION['id'].'" and bidId='.$bidid.'  and refno ="'.$total_count.'" order by datetime, orderNum;';
$images=$_sqlObj->query($getstr);
$location_count = count($images);



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

<h2>
  <b>

 <label><?php echo ADD_TAKE_NEW_PICTURE;?></label> 
  </b>
</h2>
<div class="panel panel-default">
  <div class="panel-body">

<form id="uploadimage" method="POST" enctype="multipart/form-data">
 <input type="hidden" name="<?php echo ini_get("session.upload_progress.name")?>" value="pics" />



            <label><?php echo TAKE_PICTURE_OR_SELECT_FILE;?></label> 
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                      Take/Select&hellip; 
                        <input type="file"  name="img[]" id="file" accept="image/*" capture="camera"  style="display: none; " />
                                       
                    </span>
                </label>
                <input type="text" id="filepath" name="filepath" class="form-control" readonly value="">
            </div>
           
            <label><?php echo FILE_SPECIFICATIONS;?></label> 
            <br>
            
            
            <div class="form-group">
    <label><?php echo PICTURE_TITEL;?></label> 
    <input type="input" class="form-control text_input_radius" id="picture_titel" name="title[]" value="<?php echo $location_count+1; ?>">
    <input type="hidden" class="form-control text_input_radius" name="srId[]" value="<?php echo $srid; ?>">
     <input type="hidden" class="form-control text_input_radius" name="bidId" value="<?php echo $bidid; ?>">
     <input type="hidden" class="form-control text_input_radius" name="totalreview" value="<?php echo $total_count; ?>">
  </div>
  
             <br>
             <center>
            <span id="picture_submit_button">
            <input type="submit" id="picture_submit" name="picture_submit"value="<?php echo UPLOAD_PICTURE;?>" class = "btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border" />
           <img src="img/loader.gif" alt="loader1" style="display:none; height:30px; width:auto;" id="loaderImg">  </div>
             </center>
   </form>

</div>




</div>

<div style="margin:10px">
<br>
 <label><?php echo EXISTING_PICTURES;?></label> 
 <div class="panel panel-default">
  <div class="panel-body">
  <table>
  
  <?php
$row=reset($images); 
  while ($row) {
  echo "<tr>";
   echo "<td><font size='3'>" . $row['title'] . "</font></td>";
  
  echo "</tr>";
  echo "<tr>";
   echo "<td><font size='2'>" . $row['datetime'] . "</font></td>";;
  
  echo "</tr>";
  
  echo "<tr>";
   echo "<td>";
  echo "<img onclick='show_big_image(" . $row['id'] . ")' src='".imgPath2Url(smallPicName($row['url'])). "' class='img-rounded' alt='Imag' style='width: 150px;'><br><br>";
   echo "</td>";
     echo "<td width='110px'>";
     
     
  
   echo "</td>";
   echo "<td>";
   echo "<button class='btn btn-danger general_orange_button_border_radius' type='button' onclick='delete_image(" . $row['id'] . ")'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
   echo "</td>";
   echo "</tr>";
   
  $row=next($images);
  }
  
  ?>
  
    </table>
    
  </div>
  </div>
 
 </div>


<center>
   <button onclick="go_back()" type="button" class="btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border"><?php echo CONTINUE_BUTTON;?></button>
   
  </center>
  
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
    
     location.href = "bid_reupdate.php?id=<?php echo $bidid; ?>";
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
    		
     
     $('#show_big_image_in_modal').html("<img src='image_upload/" + image_link + "' class='img-rounded' alt='Image'>");
     
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
  					closeOnConfirm: false
				},
				function(){
				
	
	              var formData = {
        				'id'     : id,
       			}
    	
    	   var feedback = $.ajax({
    			type: "POST",
    			url: "delete_uploaded_bid_picture.php",
    		    data: formData,
    		
    		    async: false,
    			
    		}).complete(function(){
    		
    		
    			swal({
  					title: picture_delete_confirm_header_done,
 					text: picture_delete_confirm_text_done,
  					type: "success",
  					showCancelButton: false,
  					confirmButtonColor: "#5CB85C",
  					confirmButtonText: "OK",
  					closeOnConfirm: false
				},
				function(){
				
				
				location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
  
				
				});
    		
 		
    		
    		});
	
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


    $("#picture_submit").prop("disabled",true);
    $("#picture_submit").css("cursor", "not-allowed");
    $("#loaderImg").show();

    e.preventDefault();


   	var filerequired = $("#filepath").val();
   	
   	var oops = '<?php echo OOPS; ?>';
   	var file_required = '<?php echo FILE_REQUIRED; ?>';
   	var title_required = '<?php echo FILE_TITLE_REQUIRED; ?>';
   	
   	if(filerequired == ""){
   	
   	  swal(oops, file_required, "error");
   	 $("#picture_submit").prop("disabled",false);
      $("#picture_submit").css("cursor","pointer");
      $("#loaderImg").hide();
   	  return;
   	
   	
   	}
   	
   	if(picture_titel == ""){
   	
   		swal(oops, title_required, "error");
   	$("#picture_submit").prop("disabled",false);
      $("#picture_submit").css("cursor","pointer");
      $("#loaderImg").hide();
   	  return;
   
   	
   	}
    $("#loaderImg").show(); 
  var result = "";
  $.ajax({
	url: "uploadRefImage.php", 
	type: "POST",             
	data: new FormData(this), 
	contentType: false,       
	cache: false,
	async: true,             
	processData:false,        
	success: function(data)   
		{
		    result = data;
		    
	var oops = '<?php echo OOPS; ?>';
   	var file_exist = '<?php echo FILE_EXIST; ?>';
   	var file_to_big = '<?php echo FILE_TO_BIG; ?>';
   	var file_to_big_2 = '<?php echo FILE_TO_BIG_2; ?>';
   	var porn_upload = '<?php echo FILE_PORN; ?>';
   	var success_upload = '<?php echo FILE_NO_PORN; ?>';
   	var done = '<?php echo DONE; ?>';

	result=JSON.parse(result);
	result=result[0]; //only uploading one at a time
	console.log(JSON.stringify(result));

   			
   	if(result['status'] == 1){
		  $("#picture_submit").prop("disabled",false);
      $("#picture_submit").css("cursor","pointer");
      $("#loaderImg").hide();
	    swal(oops, result['msg'], "error");
	        	
	}
	
	
	if(result['status'] == 0){
		
	    
	    $("#picture_submit").prop("disabled",false);
      $("#picture_submit").css("cursor","pointer");
        $("#loaderImg").hide(); 
	    
	    var success_upload_header = '<?php echo SUCCESS_UPLOAD_HEADER; ?>';
	    var success_upload_text = '<?php echo SUCCESS_UPLOAD_TEXT; ?>';
	    
	    
	    swal({
  					title: success_upload_header,
 					text: success_upload_text,
  					type: "success",
  					showCancelButton: false,
  					confirmButtonColor: "#5CB85C",
  					confirmButtonText: "OK",
  					closeOnConfirm: false
				},
				function(){
				
				
				location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
  
				
				});
	    
  
	    
	        	
	}
	
		}
	});
	

	
	
		
//	$("#picture_submit").prop("disabled",false);


}));

$(document).on('change', ':file', function() {
    
    var input = $(this);
       
   
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
        
        
        $("#filepath").val(label);
        
    
});


</script>
