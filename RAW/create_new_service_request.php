
<?php
echo "<html>
<head>
";

require_once("./header_main.php");
########delete address/pictures table when loading
$today=date("Y-m-d");
 $frompage= basename($_SERVER['HTTP_REFERER'], '?' . $_SERVER['QUERY_STRING']);
if (strpos($frompage, 'create_new_service_request_take_pictures') === false && strpos($frompage, 'create_new_service_request_address_selection') === false ) {
  $sql_get_str = "DELETE FROM address WHERE userId='".$_SESSION['id']."' and personal IS NULL and bidId is NULL and srId is null and (pob is null or pob=0)  order by datetime";
  $sr_addresses=$_sqlObj->query($sql_get_str);
  $rslt="DELETE from pics where userId='".$_SESSION['id']."' and srId is NULL";
  $sr_addresses=$_sqlObj->query($rslt);


}



 $new_request_for_help_text = $_GET['new_request_for_help_text'];

$scheduleArray=array("weekly","twice monthly","monthly","every other month");
//setting new SR title
	if($_GET['new_request_for_help_text']){
	$_POST['title']=$_GET['new_request_for_help_text'];
	}	

	if(count($_SESSION['new_sr'])>0 && $set ==1){
	$_POST=array_replace_recursive($_SESSION['new_sr'], $_POST);//array_replace_recursive
    
	}
    $set=1;
	if(!array_key_exists("time_from_value", $_POST) || !array_key_exists("time_from_value", $_POST) || !array_key_exists("date_from_value", $_POST) || !array_key_exists("date_to_value", $_POST)){
	 $datetime=time();
	
	$btime=dateAddHr($datetime);
	$ntime=nextAt($btime);
	
	$sr_date_from = dateFormat($datetime, 'date');
	$sr_date_to = dateFormat($ntime, 'date');

	$sr_time_from = dateFormat($datetime, 'time');
	$sr_time_to = dateFormat($ntime, 'time');
	}
	else{
	$sr_date_from=$_POST["date_from_value"];
	$sr_date_to=$_POST["date_to_value"];

	$sr_time_from=$_POST["time_from_value"];
	$sr_time_to=$_POST["time_to_value"];
	}

echo $_template["header"];

if(count($_POST)==0){
$_POST=$_SESSION['new_sr'];
}

$_SESSION['new_sr']=$_POST;

$_POST['payAmt']=$_POST['payAmt']?$_POST['payAmt']:"";


 $sql_get_str = "SELECT * FROM address WHERE userId='".$_SESSION['id']."' and personal IS NULL and bidId is NULL and srId is null and (pob is null or pob=0) and datetime LIKE '%$today%' order by datetime";
$sr_addresses=$_sqlObj->query($sql_get_str);



?>

<style>

.back_button_border_radius {border-radius: 15px !important;}
.back_button_size {padding: 5px 25px !important;}
.back_button_background {background-color:#E65825 !important;}
.back_button_no_border {border: none !important;}

.general_orange_button_border_radius {border-radius: 15px !important;}
.general_orange_button_size {padding: 5px 25px !important;}
.general_orange_button_background {background-color:#E65825 !important;}
.general_orange_button_no_border {border: none !important;}

.general_blue_button_border_radius {border-radius: 15px !important;}
.general_blue_button_size {padding: 5px 25px !important;}
.general_blue_button_background {background-color:#3E78A6 !important;}
.general_blue_button_no_border {border: none !important;}


tr.spaceUnder>td {
  padding-bottom: 1em !important;
}


label.btn span {
  font-size: 1.5em ;
}
div[data-toggle="buttons"] label.active{
    color: #000000;
}

div[data-toggle="buttons"] label {
display: inline-block;
padding: 6px 12px;
margin-bottom: 0;
font-size: 12px;
font-weight: normal;
line-height: 2em;
text-align: left;
white-space: nowrap;
vertical-align: top;
cursor: pointer;
background-color: none;
border: 0px solid 
#c8c8c8;
border-radius: 3px;
color: #c8c8c8;
-webkit-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
-o-user-select: none;
user-select: none;
}

div[data-toggle="buttons"] label:hover {
color: #000000;
}

div[data-toggle="buttons"] label:active, div[data-toggle="buttons"] label.active {
-webkit-box-shadow: none;
box-shadow: none;
}


.navbar {
    margin-bottom: 0 !important;
    
}
      .panel {
    margin: 0 !important; 
    padding:0 !important;

}


.panel_white {
    margin: 0 !important; 
    padding:0 !important;
    background:#33b5e5 !important;

}
    
</style>
<script type="text/javascript" src="js/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="js/bootstrap-switch.min.js"></script>
<script src="js/bootstrap-multiselect.js"></script>
<script src="js/jquery.bootstrap-touchspin.min.js"></script>
<script src="js/jquery.maskMoney.min.js"></script>
<script type="text/javascript" src="js/moment.min.js"></script>
<script type="text/javascript" src="js/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/daterangepicker.css" />


<link rel="stylesheet" type="text/css" href="css/bootstrap-clockpicker.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker3.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-switch.min.css">
<link href="css/bootstrap-multiselect.css" rel="stylesheet">
<link href="css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">


<script>

function geoloc() {


        if (navigator.geolocation) {
                var optn = {
                enableHighAccuracy : true,
                timeout : 3000,
                maximumAge : Infinity
                };
                watchId = navigator.geolocation.getCurrentPosition(showPosition, showError, optn);

        }
        else {
                alert('Geolocation is not supported in your browser');
        }
}



function delete_image(id)
{
     
     
     var sr_number = '<?php echo $current_sr_number; ?>';
     
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
    			url: "delete_uploaded_sr_picture.php",
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
				
				
				location.href = "create_new_service_request.php?sr_number=" + sr_number;
  
				
				});
    		
 		
    		
    		});
	
	
  
				});
$(".sweet-alert").get(0).scrollIntoView();

} 


function close_big_picture()
{
     $('#big_picture').modal('hide'); 
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



$(document).on('change', ':file', function() {
    
    var input = $(this);
       
   
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
        
        
        $("#filepath").val(label);
        
    
});




$("#radio_all_provider").change(function(){
     	var status = this.value;
    
     	$("#radio_specific_provider").removeAttr('checked');
     	$("#radio_previous_provider").removeAttr('checked');
     	$("#radio_my_provider").removeAttr('checked');
     	
     	$("#provider_name").prop('disabled', true);
     	$("#select_service_providers").multiselect("disable");
     	
     	 $('#found_not_found').html("");
     	 $('#provider_name').css('border', '1px #CCC solid');
     	 $('#provider_name').val("");
     	 $('#username_found').val("0");
     });



$("#radio_my_provider").change(function(){
     	var status = this.value;
     	
     	
     	$("#radio_specific_provider").removeAttr('checked');
     	$("#radio_previous_provider").removeAttr('checked');
     	$("#radio_all_provider").removeAttr('checked');
     	
     	$("#provider_name").prop('disabled', true);
     	$("#select_service_providers").multiselect("disable");
     	
     	 $('#found_not_found').html("");
     	 $('#provider_name').css('border', '1px #CCC solid');
     	 $('#provider_name').val("");
     	 $('#username_found').val("0");
		    
     });

     
$("#radio_specific_provider").change(function(){
     	var status = this.value;
     

	
        $("#radio_all_provider").removeAttr('checked');
    	$("#radio_previous_provider").removeAttr('checked');
    	$("#radio_my_provider").removeAttr('checked');
    	
    	$("#provider_name").prop('disabled', false);
		$("#select_service_providers").multiselect("disable");
     });
     
$("#radio_previous_provider").change(function(){
     	var status = this.value;
     	
        $("#radio_all_provider").removeAttr('checked');
    	$("#radio_specific_provider").removeAttr('checked');
    	$("#radio_my_provider").removeAttr('checked');
    	$("#provider_name").prop('disabled', true);
    	$("#select_service_providers").multiselect("enable");
    	$('#provider_name').css('border', '1px #CCC solid');
    	$('#provider_name').val("");
    	$('#found_not_found').html("");
    	$('#username_found').val("0");

     });


$("#project_category").change(function() {

        sub_category_Html = "";
        $('#form_sub_category').html(sub_category_Html);
        
        resultHtml = "";
        $('#form_html').html(resultHtml);
        

        var resultHtml = '';
        $('#form_html').html(resultHtml);
        
        var project_category = $("#project_category").val();
        
        var category_id = $("#project_category").val();
       
        
        var category_title =  $("#project_category option:selected").text();
        
        // check if category has sub categories
        
        
         var formData = {
        'category_id'     : category_id,
    
    	}
    	
    	  var sub_category = $.ajax({
    			type: "POST",
    			url: "check_if_sub_category.php",
    		    data: formData,
    		
    		    async: false,
    			
    	}).complete(function(){
        				
    	}).responseText;
    	
    	
    	
    	if(sub_category != "no_sub"){
    	
    	    sub_category_Html = "";
    	
    	
    		var obj = jQuery.parseJSON(sub_category);
    		
    		sub_category_Html+= '<label ><?php echo SELECT_SUB_CATEGORY;?></label>';
    		sub_category_Html+='<div class="panel panel-default" id="sub_category" name="sub_category" style="background:#FFFFFF !important">';
    		sub_category_Html+='<div class="panel-body">'; 
			sub_category_Html+= '<div class="form-group">';
    		sub_category_Html+='<select class="form-control" name="sub_category_drop_down"  name="sub_category_drop_down">';
    		
    		var counter = 0;
    		
    		var super_id = "";
    		
    		$.each(obj, function(key,value){    
    		
    		    if(counter == 0){
    		    
    		      super_id = value.id;
    		    
    		    }
    		    counter = counter + 1;
    		
    		  	var id = value.id;
    		  	var category_id = value.category_id;
    		  	var sub_category_name = value.name;
    		  	  	
    		  	sub_category_Html+=' <option value="' + id + '">' +  sub_category_name + '</option>';
    	
    		

    		
    		});
    		
    		
    			sub_category_Html+='</select>';
    			sub_category_Html+= '</div>';
    		   	sub_category_Html+='</div>';
                sub_category_Html+='</div><br>';
    
    
                $('#form_sub_category').html(sub_category_Html);
    	
    	    }
    	    
    	    
    
        
        
        // check if category demands more info
        
        var formData = {
        'category_id'     : category_id,
    
    	}
    	
    	  var feedback = $.ajax({
    			type: "POST",
    			url: "check_category.php",
    		    data: formData,
    		
    		    async: false,
    			
    	}).complete(function(){
        				
    	}).responseText;
    	
        
        if(feedback == "1"){
        
   
        
           // select all category options and create the html insert
           
           var formData = {
        	'category_id'     : super_id,
    
    		}
    	
    	  	var feedback = $.ajax({
    			type: "POST",
    			url: "get_category_detail.php",
    		    data: formData,
    		
    		    async: false,
    			
    		}).complete(function(){
        				
    		}).responseText;
    		
    		
    		
    		
    
    		
    		
    		
    		var obj = jQuery.parseJSON(feedback);
    		
    		$.each(obj, function(key,value){       
    	
    		  
    		  var id = value.id;
    		  var category_id = value.category_id;
    		  var type = value.field_type;
    		  var text = value.text;
    		  var mandatory = value.mandatory;
    		  var field_range = value.field_range;

    		  
    		  if(value.field_type == "textarea"){
    		    resultHtml+='<div class="panel panel-default" id="pan_' + id + '" name="pan_' + id + '" style="background:#FFFFFF !important">';
    		    resultHtml+='<div class="panel-body">';
    		    resultHtml+='<div class="form-group">';
    		  	resultHtml+='<label for="cat_' + id + '">' + text + '</label>';
    		  	resultHtml+='  <textarea class="form-control" rows="5" id="cat_' + id + '" name="cat_' + id + '"></textarea>';
    		    resultHtml+='</div>';
    		    resultHtml+='</div>';
                resultHtml+='</div><br>';
    		    
    		
    		  
    		  }
    		  
    		  
    		  if(value.field_type == "checkbox"){
    		  
    		    resultHtml+='<div class="panel panel-default" id="pan_' + id + '" name="pan_' + id + '" style="background:#FFFFFF !important">';
    		    resultHtml+='<div class="panel-body">';
    		    resultHtml+='<div class="form-group">';
    		  	resultHtml+='<label class="checkbox-inline"><input id="cat_' + id + '" name="cat_' + id + '"  style="height: 26px; width:26px; margin-left:-30px" value="' + id + '" type="checkbox">' + text + '</label><br><br>';
                resultHtml+='</div>';
                resultHtml+='</div>';
                resultHtml+='</div><br>';
                
    		  
    		  }
    		  
    		  
    		  if(value.field_type == "textbox"){
    		  
    		    resultHtml+='<div class="panel panel-default" id="pan_' + id + '" name="pan_' + id + '" style="background:#FFFFFF !important">';
    		    resultHtml+='<div class="panel-body">';  
    		  	resultHtml+='<div class="form-group">';
    		  	resultHtml+='<label for="cat_' + id + '">' + text + '</label>';
    		  	resultHtml+='<input type="text" class="form-control" id="cat_' + id + '" name="cat_' + id + '">';
    		    resultHtml+='</div>';
    		    resultHtml+='</div>';
                resultHtml+='</div><br>';
    		    
    		    
    		     
    		    

    		  }
    		
    		  
    		   if(value.field_type == "slider"){
    		   
    		        var split_range = field_range.split("-");
    		        
    		        var range_start = split_range[0];
    		        var range_end = split_range[1];
    		        
                    resultHtml+='<div class="panel panel-default" id="pan_' + id + '" name="pan_' + id + '" style="background:#FFFFFF !important">';
    		        resultHtml+='<div class="panel-body">'; 
					resultHtml+= '<div class="form-group">';
					resultHtml+= '<label for="cat_' + id + '">' + text + '</label>';
    		   		resultHtml+='<select class="form-control" name="cat_' + id + '"  name="cat_' + id + '">';
    		   		
    		   		while (range_start <= range_end) {
    		   		
    		   			resultHtml+=' <option>' +  range_start + '</option>';
    
    					range_start++;
					}
    		   		
    		   		resultHtml+='</select>';
    		   		resultHtml+= '</div>';
    		   		resultHtml+='</div>';
                    resultHtml+='</div><br>';

    		   
    		   }

    		$('#form_html').html(resultHtml);
    		
    		    
    	
			});
			
			
			// check mandetory fields
			
    		$.each(obj, function(key,value){       
    			var id = value.id;
    		  	var mandatory = value.mandatory;
    		  
    		  	if(mandatory == "1"){
    		  	
    		  	 
    		  	 	
    		  	 	$('#pan_' + id).css('border', '3px #d9534f solid');
    		    }
    		});
    		
    		
        
          // open category modal
          
          //$('#modal_category_details').modal('show'); 
          
          // $('#category_title').text(category_title);
          

        
        }
    
        
        
     //   var formData = {
     //   'project_category'     : project_category,
    
    //	}
    	
    //	  var feedback = $.ajax({
    //			type: "POST",
    //			url: "count_service_provider.php",
    //		    data: formData,
    		
    //		    async: false,
    			
    //	}).complete(function(){
        				
    //	}).responseText;
    
    //	$("#service_provider_count").text(feedback);


if(sub_category != "no_sub"){


$('#modal_category_details').modal('show'); 
          
$('#category_title').text(category_title);


}        
        
        
    });


$( document ).ready(function() {


$(".hourly").click(function() {
   $("#target_fix_rate").attr("readonly", false); 
    $("#target_fix_rate").attr("placeholder", "Rate / Hour");
    var label = $(this).text();    
    $("#paytypehidden").val("hourly");
    $(".hideamt").show(); 
    $(".hour_rate").show(); 
    $(".setschedule").hide(); 
});

$(".payRateToggle").find(".btn.btn-primary").click(function(){
    $(this).attr('style','pointer-events:none;');
    $(this).removeClass('btn-info');
    $(this).removeClass('btn-sm');
    $(this).removeAttr('style');
    $(this).siblings(".btn.btn-primary").addClass('btn-info');
    $(this).siblings(".btn.btn-primary").addClass('btn-sm');
});
$(".fair").click(function() {
  $("#target_fix_rate").attr("readonly", false); 
    var label = $(this).text();    
    $("#paytypehidden").val("fair");
    $(".hideamt").hide();  
    $(".hour_rate").hide(); 
    $(".setschedule").hide(); 
});
$(".fixed").click(function() {
  if($("#set_schedule").val() == "1") 
    $("#target_fix_rate").attr("readonly", false); 
  else
      $("#target_fix_rate").attr("readonly", true); 

  $("#target_fix_rate").attr("placeholder", "Fixed Rate");
    var label = $(this).text();    
    $("#paytypehidden").val("fixed");
    $(".hideamt").show();   
    $(".hour_rate").hide();
    $(".setschedule").show();     
});



alternateLabels("altLbls"); //function that allows alternating buttons to work

hideByClass("checkHideShowBare", "rmStyleOnCheck");
flipByClass("urgentBool", "hideDateTimeAlt", "hideDateTime");
hideByClassAllHideAff("dateTime_bool", "calInput", "rmStyleOnCheck");


initMap();


cId=$("#project_category").val(); //setting the value of the category for the map
mapDivW=document.getElementById("googleMap").clientWidth;
mapDivH=document.getElementById("googleMap").clientHeight;



//why not .resize? Simple, it doesn't work on divs
//this breaks the "onclick" listener on the markers because populateMap despawns all markers first. Hence, the lister gets deleted ebfore it's 
//event is fired. can fix later by makeing delMark smarter.
$("#googleMap").mouseup(function(){
mapDivW=document.getElementById("googleMap").clientWidth;
mapDivH=document.getElementById("googleMap").clientHeight;
console.log("#googleMap resized to: "+mapDivW+", "+mapDivH);
populateMap();
});


$("#project_category").change(function(){
cId=$("#project_category").val();
// repopulate helpers map for this category
initMap();
populateMap();
});



$("#radio_all_provider").change(function(){
     	var status = this.value;
     	
     	$("#radio_specific_provider").removeAttr('checked');
     	$("#radio_previous_provider").removeAttr('checked');
     	$("#radio_my_provider").removeAttr('checked');
     	
     	$("#provider_name").prop('disabled', true);
     	$("#select_service_providers").multiselect("disable");
     	
     	 $('#found_not_found').html("");
     	 $('#provider_name').css('border', '1px #CCC solid');
     	 $('#provider_name').val("");
     	 $('#username_found').val("0");



	var postD={
	lat:gLat,
	lng:gLng,
	rng:'10',
	categId: '11'
	};
       //function newMark(lat, lng, title, icn, lbl){

	console.log(JSON.stringify(postD));
	var helpers=postCall(postD, 'findHelperNear.php');
	console.log(JSON.stringify(helpers));



     });



$("#radio_my_provider").change(function(){
     	var status = this.value;
     	
     	
     	$("#radio_specific_provider").removeAttr('checked');
     	$("#radio_previous_provider").removeAttr('checked');
     	$("#radio_all_provider").removeAttr('checked');
     	
     	$("#provider_name").prop('disabled', true);
     	$("#select_service_providers").multiselect("disable");
     	
     	 $('#found_not_found').html("");
     	 $('#provider_name').css('border', '1px #CCC solid');
     	 $('#provider_name').val("");
     	 $('#username_found').val("0");
		    
     });

     
$("#radio_specific_provider").change(function(){
     	var status = this.value;
     

	
        $("#radio_all_provider").removeAttr('checked');
    	$("#radio_previous_provider").removeAttr('checked');
    	$("#radio_my_provider").removeAttr('checked');
    	
    	$("#provider_name").prop('disabled', false);
		$("#select_service_providers").multiselect("disable");
     });
     
$("#radio_previous_provider").change(function(){
     	var status = this.value;
     	
        $("#radio_all_provider").removeAttr('checked');
    	$("#radio_specific_provider").removeAttr('checked');
    	$("#radio_my_provider").removeAttr('checked');
    	$("#provider_name").prop('disabled', true);
    	$("#select_service_providers").multiselect("enable");
    	$('#provider_name').css('border', '1px #CCC solid');
    	$('#provider_name').val("");
    	$('#found_not_found').html("");
    	$('#username_found').val("0");

     });



    
    $('.time_from').clockpicker({
	autoclose: true

	});
	
	
	$('.time_to').clockpicker({
	autoclose: true

	});
	
	

$('#date_to .input-group.date').datepicker({
    calendarWeeks: true,
    autoclose: true,
    format: "yyyy-mm-dd",
    todayHighlight: true,
    orientation: "top left",
    todayBtn: "linked"
    
    
});

$(function() {

    var start = moment();
    var end = moment();
    var label;
    function cb(start, end,label) {
      
        if(label == "Custom Range")
            $('#reportrange').html(start.format('D MMMM, YYYY') + ' to ' + end.format('D MMMM, YYYY'));
          else
             $('#reportrange').html(label);

        $("#date_from_value").val(start.format('YYYY-MM-DD'));
        $("#date_to_value").val(end.format('YYYY-MM-DD'));
       $("#open_sr_list").css("margin-bottom: 250px");
       ScheduleTotalFunc();
   }
    
    

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        //autoApply: true,
        ranges: {
           'Today': [moment(), moment()],
           //'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           //'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          // 'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Week': [moment().startOf('week'), moment().endOf('week')],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           
           //'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end, label);
    
    $("#reportrange").on('show.daterangepicker', function(ev, picker){
    	$('html, body').animate({scrollTop: $(document).height()}, 1000);
    });
    
    $("#reportrange").on('showCalendar.daterangepicker', function(ev, picker){
    	$('html, body').animate({scrollTop: $(document).height()}, 1000);
    });
});


$('#date_from .input-group.date').datepicker({
    calendarWeeks: true,
    autoclose: true,
    format: "yyyy-mm-dd",
    todayHighlight: true,
    orientation: "top left",
    todayBtn: "linked"
    
    
});


    var sr_hourly_rate = '<?php echo $sr_hourly_rate; ?>';
    var sr_fix_rate = '<?php echo $sr_fix_rate; ?>';
    

    $('input[name="fix_rate"]').bootstrapSwitch('state', true, true);
 

    var primary_address = $("#assigned_addresses").val();
	var primary_address_id = $("#assigned_address_id").val();
	
	var res = primary_address_id.split("|");
	primary_address_id =res[0];
	
	if(primary_address_id != ""){
	
	    var project_category = $("#project_category option:selected").val();
		
	    // count registered service provider in this area
	    
	    var formData = {
        'project_category'     : project_category,
    
    	}
    	
    	  var feedback = $.ajax({
    			type: "POST",
    			url: "count_service_provider.php",
    		    data: formData,
    		
    		    async: false,
    			
    }).complete(function(){
        				
    }).responseText;
    
    $("#service_provider_count").text(feedback);
    
   
	    
	
	    
	
	}
   

        $(window).unload(function(){ 
        postCall($('#new_sr_form').serialize(), "updateSession.php");
        });


});


function additional_info_close(){


    $('#modal_category_details').modal('hide'); 
    
    //$("#project_category").val($("#target option:first").val());
    $("#project_category").prop("selectedIndex", 0);

   
}




function sr_submit(buttonstatus){

     
     // check form validation
	 
	 var radio_specific_provider = $('#radio_specific_provider').is(':checked');
	 var radio_all_provider = $('#radio_all_provider').is(':checked');
	 var radio_previous_provider = $('#radio_previous_provider').is(':checked');

	
	 
	 // provider type 1 = all provider, 2 specific provider, 3 previous provider
	 
	 var provider_type = "";
	 var selected_provider = "";

	if($("#project_category").val()==0){
	swal({title: "Category not selected",
                text: "Category needs to be selected",
                type: "warning",
                confirmButtonColor: "#5CB85C",
                confirmButtonText: "OK",
                closeOnConfirm: true
        });
	$(".sweet-alert").get(0).scrollIntoView();
	exit;
	}
	 if(($("#target_fix_rate").val()==0 || $("#target_fix_rate").val()=="" || $("#target_fix_rate").val()<=0) && $("#paytypehidden").val() != "fair"){
  swal({title: "Pay Rate",
                text: "Enter Pay Rate",
                type: "warning",
                confirmButtonColor: "#5CB85C",
                confirmButtonText: "OK",
                closeOnConfirm: true
        });
  $(".sweet-alert").get(0).scrollIntoView();
  exit;
  }
	 
	 if(radio_specific_provider ==  true){
	 
	 	var username_found = $("#username_found").val();
	 	
	 	provider_type = "2"
	 	
	 	if(username_found != "1"){
	 	
	 	    var oops = '<?php echo OOPS; ?>';
	        var wrong_username = '<?php echo WRONG_SERVICE_PROVIDER_NAME; ?>';
	 	
	 	   swal(oops, wrong_username, "error");
		   $(".sweet-alert").get(0).scrollIntoView();
	 	   exit;
	 
	 	
	 	}else{
	 	
	 	selected_provider = $("#provider_name").val();
	
	 	
	 	}

	 }
	 
	 
	 
	if(radio_all_provider ==  true){
	
		provider_type = "1"
	  
	  
	}
	
	if(radio_previous_provider ==  true){
	
		provider_type = "3"
		
		selected_provider = $("#select_service_providers").val();
  
	}

	 var name = $("#sr_name").val();
     var description = $("#service_description").val();
     var pers_summ = $("#pers_summ").val();
     var bid_bool = $("#bid_urgent_bool").prop('checked');
     var bid_days= $("#bidDueDays").val();
     var bid_hrs = $("#bidDueHrs").val();
	    
 
     var is18 = '<?php echo "1"; //$_SESSION['is18']; ?>';
    
     var datetimeBool = $("#dateTime_bool").val(); 
     var date_from = $("#date_from_value").val();
     var date_to = $("#date_to_value").val();
     
     var time_from = $("#time_from_value").val();
     var time_to = $("#time_to_value").val();

     var set_schedule = $("#set_schedule").val();
     var schedule_note = $("#schedule_note").val();
     var schedule_amount = $("#schedule_amount").val();
     if(schedule_amount =="")schedule_amount="0.00";
     //var payType=$('#pay_rate_type_bool').prop('checked'); 
    
     var payType=$("#paytypehidden").val();
     var  payRate = $('#target_fix_rate').val();
     var  rateperhour = "0.00";
     var totalhours ="0.00";
    // alert(payType);

     if(payType =="fair") payRate ="0.00";
     
     if(payType =="hourly")
        {
             totalhours = $("#totalhours").val();
             rateperhour = payRate;
             payRate =  parseFloat(totalhours) * parseFloat(rateperhour);
        }
        if(payRate =="0")payRate ="0.00";
    //alert(totalhours);
    //return false;
     var category = $("#project_category").val();
         
     // db datetime format 2017-05-11 09:46:58
     
     time_from = time_from ;//+ ":00";
     time_to = time_to ;//+ ":00";
     
     var date_time_from = date_from + " " + time_from;
     var date_time_to = date_to + " " + time_to;


	var sr_submit = '<?php echo SR_SUBMIT; ?>';
    var sr_submit_text = '<?php echo SR_SUBMIT_TEXT; ?>';
    if(buttonstatus=="save")
    var sr_submit_text = '<?php echo SR_SAVE_TEXT; ?>';
    else if(buttonstatus=="cancel")
    var sr_submit_text = '<?php echo SR_CANCEL_TEXT; ?>';
    
    
    sr_submit_success = '<?php echo SR_SUBMIT_SUCCESS; ?>';
    sr_submit_success_text = '<?php echo SR_SUBMIT_TEXT_SUCCESS; ?>';
    if(buttonstatus=="save")
    sr_submit_success_text = '<?php echo SR_SAVE_TEXT_SUCCESS; ?>';
    else if(buttonstatus=="cancel")
    sr_submit_success_text = '<?php echo SR_CANCEL_TEXT_SUCCESS; ?>';
    
    var sr_id = '<?php echo $current_sr_number; ?>';


	//processing bid due datetime
	if(bid_bool){
	bid_bool='now';
	}
	else{
	bid_bool={};
    bid_bool['days']=400;
    bid_bool['hrs']=0;

	//bid_bool['days']=bid_days;
	//bid_bool['hrs']=bid_hrs;
	}



	/*//setting string paytype
	if(payType){
	payType='fixed';
	}
	else{
	payType='hourly';
	}*/



	var imgs=[];
	$('#sr_imgs input[type="hidden"]').each(function(){
	imgs[this.id]=this.value;
   // alert(this.value);
	});

//return false;
        var addr=[];
        $('#sr_addrs input[type="hidden"]').each(function(){
        addr[this.id]=this.value;
        });
	


	swal({
  		title: sr_submit,
  		text: sr_submit_text,
  		type: "warning",
  		showCancelButton: true,
  		confirmButtonColor: "#5CB85C",
  		confirmButtonText: "Yes, "+buttonstatus+" it!",
  		closeOnConfirm: false
	},
	function(){
	
	var formData = {
        'title'     : name,
        'descr' : description,
        'summ' : pers_summ,
        'bidDate' : bid_bool,
	    'dateTimeBool': datetimeBool,
        'dateTimeFrom' : date_time_from,
        'dateTimeTo' : date_time_to,
        'set_schedule' : set_schedule,
        'schedule_note' : schedule_note,
        'schedule_amount' : schedule_amount,
        'payAmt' : payRate,
        'payType' : payType,
        'totalhours' : totalhours,
        'rateperhour' : rateperhour,
        'category' : category,
        'is18' : is18,
        'provider_type' : provider_type,
        'reqstedBidId' : selected_provider,
	    'imgs' : imgs,
	    'addr' : addr,
        'buttonstatus' : buttonstatus,
        'current' : "",
        'sr_number' : '',
    	}
       // alert(formData);
    	
    	   var feedback = $.ajax({
    			type: "POST",
    			url: "service_request_submit.php",
    		    data: formData,
    		
    		    async: false,
    			
    		}).complete(function(){
        		
        		localStorage.removeItem('latitude_address');
                localStorage.removeItem('longitude_address');
    			if(is18 != 1){
    		     
    		     	var custodial_firstname = '<?php echo $custodial_firstname; ?>';
    				var custodial_name = '<?php echo $custodial_name; ?>';
    				var custodial_id = '<?php echo $custodial_id; ?>';
    	
    				var fullname = custodial_firstname + " " + custodial_name;
    	
    				var custodial_submit_information = '<?php echo CUSTODIAL_SUBMIT_INFORMATION; ?>';
    				var custodial_submit_information_text_1 = '<?php echo CUSTODIAL_SUBMIT_INFORMATION_TEXT_1; ?>';
    				var custodial_submit_information_text_2 = '<?php echo CUSTODIAL_SUBMIT_INFORMATION_TEXT_2; ?>';
    				
    				
    				swal({
  					title: custodial_submit_information,
 					text: custodial_submit_information_text_1  + fullname + custodial_submit_information_text_2,
  					type: "success",
  					showCancelButton: false,
  					confirmButtonColor: "#5CB85C",
  					confirmButtonText: "OK",
  					closeOnConfirm: false
					},
					function(){
				
						location.href = "service_request_saved_list.php";
  	
					});
    		     
    		     
    		     }else{
    		     
    		     	swal({
  					title: sr_submit_success,
 					text: sr_submit_success_text,
  					type: "success",
  					showCancelButton: false,
  					confirmButtonColor: "#5CB85C",
  					confirmButtonText: "OK",
  					closeOnConfirm: false
					},
					function(){
				
						location.href = "main.php";
  	
					});
    		     
    		     }
    		
    		});
    		
	
	});
$(".sweet-alert").get(0).scrollIntoView();

}


function sr_delete( offers){

	var sr_delete = '<?php echo SR_DELETE; ?>';
    var sr_delete_text = '<?php echo SR_DELETE_TEXT; ?>';

    var sr_delete_add = '<?php echo SR_DELETE_ADD?>';
    
    sr_delete_success = '<?php echo SR_DELETE_SUCCESS; ?>';
    sr_delete_success_text = '<?php echo SR_DELETE_TEXT_SUCCESS; ?>';

    var profAckDel = '<?php echo $_SESSION["profile"]["ackDel"]; ?>';
    
	if(offers >= 2 && profAckDel == 'false'){
	sr_delete_text = sr_delete_add;
	}

    var sr_id = '<?php echo $current_sr_number; ?>';
    
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
				
				location.href = "main.php";
  
				});
    		
    		});
	
	
	});
$(".sweet-alert").get(0).scrollIntoView();
}



// Save SR

function sr_save()
{

	 // check form validation
	 
	 var radio_specific_provider = $('#radio_specific_provider').is(':checked');
	 var radio_all_provider = $('#radio_all_provider').is(':checked');
	 var radio_previous_provider = $('#radio_previous_provider').is(':checked');
	 
	 // provider type 1 = all provider, 2 specific provider, 3 previous provider
	 
	 var provider_type = "";
	 var selected_provider = "";
	 
	 
	 if(radio_specific_provider ==  true){
	 
	 	var username_found = $("#username_found").val();
	 	
	 	provider_type = "2"
	 	
	 	if(username_found != "1"){
	 	
	 	    var oops = '<?php echo OOPS; ?>';
	        var wrong_username = '<?php echo WRONG_SERVICE_PROVIDER_NAME; ?>';
	 	
	 	   swal(oops, wrong_username, "error");
		   $(".sweet-alert").get(0).scrollIntoView();
	 	   exit;
	 
	 	
	 	}else{
	 	
	 	selected_provider = $("#provider_name").val();
	
	 	
	 	}

	 }
	 
	 
	 
	if(radio_all_provider ==  true){
	
		provider_type = "1"
	  
	  
	}
	
	if(radio_previous_provider ==  true){
	
		provider_type = "3"
		
		selected_provider = $("#select_service_providers").val();
  
	}
	

     var name = $("#sr_name").val();
     var description = $("#service_description").val();
     var sr_number = '<?php echo $current_sr_number; ?>';
     
     var date_from = $("#date_from_value").val();
     var date_to = $("#date_to_value").val();
     
     var time_from = $("#time_from_value").val();
     var time_to = $("#time_to_value").val();
     
     var not_urgent = $('#not_urgent').bootstrapSwitch('state');
     var urgent = $('#urgent').bootstrapSwitch('state');
     var very_urgent = $('#very_urgent').bootstrapSwitch('state');
     
     
     var hourly_rate = $('#hourly_rate').bootstrapSwitch('state');
     var fix_rate = $('#fix_rate').bootstrapSwitch('state');
     
     var target_fix_rate = $("#target_fix_rate").val();
     var target_hourly_rate = $("#target_hourly_rate").val();
     

         

     
     if(not_urgent == true){
     	not_urgent = 1;
     }else{
     	not_urgent = 0;
     }
     
     if(urgent == true){
     	urgent = 1;
     }else{
     	urgent = 0;
     }
     
      if(very_urgent == true){
     	very_urgent = 1;
     }else{
     	very_urgent = 0;
     }
     
     
     if(hourly_rate == true){
     	hourly_rate = 1;
     }else{
     	hourly_rate = 0;
     }
     
     if(fix_rate == true){
     	fix_rate = 1;
     }else{
     	fix_rate  = 0;
     }
    
     
     // db datetime format 2017-05-11 09:46:58
     
     time_from = time_from + ":00";
     time_to = time_to + ":00";
     
     var date_time_from = date_from + " " + time_from;
     var date_time_to = date_to + " " + time_to;
          
     var sr_update_OK = '<?php echo SR_UPDATE_OK; ?>';
	 var sr_update_text = '<?php echo SR_UPDATE_OK_TEXT; ?>';
	 
	 
     
     
     var formData = {
        'name'     : name,
        'description' : description,
        'sr_number' : sr_number,
        'date_time_from' : date_time_from,
        'date_time_to' : date_time_to,
        'not_urgent' : not_urgent,
        'urgent' : urgent,
        'very_urgent' : very_urgent,
        'hourly_rate' : hourly_rate,
        'fix_rate' : fix_rate,
        'provider_type' : provider_type,
        'selected_provider' : selected_provider,
        'target_fix_rate' : target_fix_rate,
        'target_hourly_rate' : target_hourly_rate
    
    	}
    	

    	
    var feedback = $.ajax({
    			type: "POST",
    			url: "service_request_update.php",
    		    data: formData,
    		
    		    async: false,
    			
    		}).complete(function(){
    		
    		
    		
    		
    		swal({
  				title: sr_update_OK,
  				text:  sr_update_text,
  				type: "success",
  				showCancelButton: false,
  				confirmButtonColor: "#5cb85c",
  				confirmButtonText: "OK",
  				closeOnConfirm: false
				},
				function(){
  					location.href = "main.php";
				});
			$(".sweet-alert").get(0).scrollIntoView();
    		
				
    			}).responseText;
    
  
} 


var current_sr_number = '<?php echo $current_sr_number; ?>';

function go_back()
{
     location.href = "main.php";
} 

function go_map_view()
{

     // check if there is a primary address
     
	var primary_address = $("#assigned_addresses").val();
	var primary_address_id = $("#assigned_address_id").val();
	
	var category = $("#project_category").val(); 
     
	var res = primary_address_id.split("|");
	primary_address_id =res[0];
	
	var selected_category = $('#project_category').val();
	
	
	var need_to_add_service_category = '<?php echo NEED_TO_ADD_SERVICE_CATEGORY; ?>';
	
	
	if(selected_category == "nothing"){
	
		swal("Ooops....!", need_to_add_service_category, "error");
		$(".sweet-alert").get(0).scrollIntoView();
	
	
	exit;
	
	
	}
	
	
	
	
	if(primary_address_id >= "1"){
		location.href = "service_provider_map_view.php?adress_id=" + primary_address_id +"&category=" +category;
	}else{
	
	swal("Ooops....!", "You need to add a service address location", "error");
	$(".sweet-alert").get(0).scrollIntoView();
	
	
	}
	
	// check if a category is selected
	
	
	
	
	
} 

function go_select_address()
{


     location.href = "create_new_service_request_address_selection.php?sr_number=" + current_sr_number;
} 


function go_take_picture()
{


     location.href = "create_new_service_request_take_pictures.php?sr_number=" + current_sr_number;
} 


function goToSubmit(name, url){
document.forms[name].action=url;
document.forms[name].submit();
}



    
    $('.time_from').clockpicker({
	autoclose: true

	});
	
	
	$('.time_to').clockpicker({
	autoclose: true

	});
	
	

$('#date_to .input-group.date').datepicker({
    calendarWeeks: true,
    autoclose: true,
    format: "yyyy-mm-dd",
    todayHighlight: true,
    orientation: "top left",
    todayBtn: "linked"
    
    
});


$('#date_from .input-group.date').datepicker({
    calendarWeeks: true,
    autoclose: true,
    format: "yyyy-mm-dd",
    todayHighlight: true,
    orientation: "top left",
    todayBtn: "linked"
    
    
});



$('#very_urgent').on('change.bootstrapSwitch', function(e, state) {

    if(e.target.checked == true){
	$('.hideDateTime').attr('style','max-height: 0px;'); 
	$('.hideDateTimeAlt').attr('style','max-height: 30px;'); 
    }
    else{
	$('.hideDateTime').attr('style','max-height: 30px;'); 
	$('.hideDateTimeAlt').attr('style','max-height: 0px;'); 
    }
    
    console.log(e.target.checked);
})




$('input[name=sr_due_select]').on('change.bootstrapSwitch', function(e, state) {


    if(e.target.checked == true){

    	$('input[name="very_urgent"]').bootstrapSwitch('state', true, true);
	$('.calInput').attr('style','max-height: 0px; padding: 0px;'); 
    }
    else{
	$('.calInput').attr('style','max-height: 210px;'); 
    }
   
    
})

$('input[name=sr_due_today]').on('change.bootstrapSwitch', function(e, state) {

	if(e.target.checked == true){
    	$('input[name="urgent"]').bootstrapSwitch('state', true, true);
    	$('input[name="sr_due_select"]').bootstrapSwitch('state', false, false);
    	$('input[name="sr_due_asap"]').bootstrapSwitch('state', false, false);
    
    }

    
})


$('input[name=sr_due_asap]').on('change.bootstrapSwitch', function(e, state) {

	if(e.target.checked == true){
    	$('input[name="very_urgent"]').bootstrapSwitch('state', true, true);
    	$('input[name="sr_due_select"]').bootstrapSwitch('state', false, false);
    	$('input[name="sr_due_today"]').bootstrapSwitch('state', false, false);
    
    }
  
})








$('#fix_rate').on('change.bootstrapSwitch', function(e, state) {

	if(e.target.checked == true){
       
    

    	$('input[name="hourly_rate"]').bootstrapSwitch('state', false, false);
    	
    
    }
  
})


$('#hourly_rate').on('change.bootstrapSwitch', function(e, state) {

	if(e.target.checked == true){
       
    

    	$('input[name="fix_rate"]').bootstrapSwitch('state', false, false);
    	
    
    }
  
})


var service_provider_check_all = '<?php echo SERVICE_PROVIDER_CHECK_ALL; ?>';
var service_provider_nothing_selected = '<?php echo SERVICE_PROVIDER_NOTHING_SELECTED; ?>';
var service_provider_all_selected = '<?php echo SEEVICE_PROVIDER_ALL_SELECTED; ?>';
	

	
	
  
function username_check(){	
	var provider_name_key = $('#provider_name').val();  
	
	
	jQuery.ajax({
   		type: "POST",
   		url: "check_username.php",
   		data: 'provider_name_key='+ provider_name_key,
   		cache: false,
   		success: function(response){
   		
   		var arr_response = response.split('|');
   		
   	    var found = arr_response[0];
   		
		if(found == 1){
		
		    $('#username_found').val("1");
		    $('#provider_name').css('border', '3px #5cb85c solid');
		    var firstname = arr_response[1];
		    var name = arr_response[2];
		    $('#found_not_found').html("<font color='#5cb85c'><strong><p>Name: " + firstname + " " + name + "</p></strong></font>");
		    
		

		}else{
           
           $('#username_found').val("0");
           $('#provider_name').css('border', '3px #d9534f solid');
           $('#found_not_found').html("<font color='#d9534f'><strong><p> We cannot find a user with this username</p></strong></font>");
        

		}
	}	
		
	});

	
};

$("#form_sub_category").on('change','select',function () { 

     //alert($(this).val())
     
     var id = $(this).val();
     
     resultHtml = "";
    
     
    
     $('#form_html').html("");
     
     
     var formData = {
        	'category_id'     : id
    
    		}
    	
    	  	var feedback = $.ajax({
    			type: "POST",
    			url: "get_category_detail.php",
    		    data: formData,
    		
    		    async: false,
    			
    		}).complete(function(){
        				
    		}).responseText;
    		
    		
     
     
    var obj = jQuery.parseJSON(feedback);
    
    var mark_red = [];
    		
    		$.each(obj, function(key,value){       
    	
    		  
    		  var id = value.id;
    		  var category_id = value.category_id;
    		  var type = value.field_type;
    		  var text = value.text;
    		  var mandatory = value.mandatory;
    		  var field_range = value.field_range;
    		  
    		  
    		  if(mandatory == 1){
    		     //mark_red.push(id); 
    		  }
    		  
    		  
    		  

    		  
    		  if(value.field_type == "textarea"){
    		    resultHtml+='<div class="panel panel-default" id="pan_' + id + '" name="pan_' + id + '" style="background:#FFFFFF !important">';
    		    resultHtml+='<div class="panel-body">';
    		    resultHtml+='<div class="form-group">';
    		  	resultHtml+='<label for="cat_' + id + '">' + text + '</label>';
    		  	resultHtml+='  <textarea class="form-control" rows="5" id="cat_' + id + '" name="cat_' + id + '"></textarea>';
    		    resultHtml+='</div>';
    		    resultHtml+='</div>';
                resultHtml+='</div><br>';
    		    
    		
    		  
    		  }
    		  
    		  
    		  if(value.field_type == "checkbox"){
    		  
    		    resultHtml+='<div class="panel panel-default" id="pan_' + id + '" name="pan_' + id + '" style="background:#FFFFFF !important">';
    		    resultHtml+='<div class="panel-body">';
    		    resultHtml+='<div class="form-group">';
    		  	resultHtml+='<label class="checkbox-inline"><input id="cat_' + id + '" name="cat_' + id + '"  style="height: 26px; width:26px; margin-left:-30px" value="' + id + '" type="checkbox">' + text + '</label><br><br>';
                resultHtml+='</div>';
                resultHtml+='</div>';
                resultHtml+='</div><br>';
                
    		  
    		  }
    		  
    		  
    		  if(value.field_type == "textbox"){
    		  
    		    resultHtml+='<div class="panel panel-default" id="pan_' + id + '" name="pan_' + id + '" style="background:#FFFFFF !important">';
    		    resultHtml+='<div class="panel-body">';  
    		  	resultHtml+='<div class="form-group">';
    		  	resultHtml+='<label for="cat_' + id + '">' + text + '</label>';
    		  	resultHtml+='<input type="text" class="form-control" id="cat_' + id + '" name="cat_' + id + '">';
    		    resultHtml+='</div>';
    		    resultHtml+='</div>';
                resultHtml+='</div><br>';
    		    
    		    
    		     
    		    

    		  }
    		
    		  
    		   if(value.field_type == "slider"){
    		   
    		        var split_range = field_range.split("-");
    		        
    		        var range_start = split_range[0];
    		        var range_end = split_range[1];
    		        
                    resultHtml+='<div class="panel panel-default" id="pan_' + id + '" name="pan_' + id + '" style="background:#FFFFFF !important">';
    		        resultHtml+='<div class="panel-body">'; 
					resultHtml+= '<div class="form-group">';
					resultHtml+= '<label for="cat_' + id + '">' + text + '</label>';
    		   		resultHtml+='<select class="form-control" name="cat_' + id + '"  name="cat_' + id + '">';
    		   		
    		   		while (range_start <= range_end) {
    		   		
    		   			resultHtml+=' <option>' +  range_start + '</option>';
    
    					range_start++;
					}
    		   		
    		   		resultHtml+='</select>';
    		   		resultHtml+= '</div>';
    		   		resultHtml+='</div>';
                    resultHtml+='</div><br>';

    		   
    		   }
    		   
    		   
    		   

           //$('#pan_' + id).css('border', '3px #d9534f solid');
    		
    		    
    		
    		
    		
    		
    		
			});
     
     $('#form_html').html(resultHtml);
     
     mark_red_len = mark_red.length;
     
     for (i = 0; i < mark_red_len; i++) {
     
        $('#pan_' + mark_red[i]).css('border', '3px #d9534f solid');
	 
	 }
     

    

});



function load_message_list(){
 
 	location.href = "message_list.php";
 
 }
  

function geoloc() {


	if (navigator.geolocation) {
		var optn = {
		enableHighAccuracy : true,
		timeout : Infinity,
		maximumAge : 0
		};
		watchId = navigator.geolocation.getCurrentPosition(showPosition, showError, optn);

	}
	else {
		alert('Geolocation is not supported in your browser');
	}
}


  
</script>


<script>
var Lat = localStorage.getItem("latitude_address"); 
var Lng = localStorage.getItem("longitude_address"); 

if(localStorage.getItem("latitude_address"))
{
var gLat=Lat;
var gLng=Lng;
}
else
{
var gLat=47.6062;
var gLng=-122.3321;
}
var categId=$("#project_category").val();
</script>
<script src="js/googleMap.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $configs['google_map_api']; ?>&libraries=places"></script>

</head>

<body>

<meta name="mobile-web-app-capable" content="yes">

<?php echo $_template["nav"]; ?>

  <div class="col-xs-12 col-md-12">

<div style="margin:0px">

<br>



<form id="new_sr_form" name="new_sr_form" acttion="./create_new_service_request.php" method="POST">
  <div class="form-group">
    
    <input type="text" placeholder="<?php echo ENTER_PROJECT_NAM_PLACEHOLDER;?>" class="form-control SRName" id="sr_name" name="title" value="<?php echo $_POST['title'];?>">
  </div>
 
<div class="SRDetailsBox">
<!-- <table id="open_sr_list" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                <th colspan="3" id="titleHeaders" ><label for="comment"><?php echo SERVICE_NEEDED_WITHIN?></label></th>
                </tr>
                </thead>


                <tbody class="tbodyBorder" id="custTblPd">
  	<tr>
  		<td>



<?php/*

//checks the incoming data, whether it's brand new SR or an old one. Checks the box accordingly.
$bidUrgent=checkboxPostDateUrg('bidDueDate', 'bidUrgent', 'bidUrgent');

	if(array_key_exists('bidDueDate', $_POST)){
	//get bidDueDate as epoch
	// if bidDueDate less than time() (in the past), both values are 0.
	//if not, figure out how many hours and days left.
	$bidDueDT=is_numeric($_POST['bidDueDate'])?$_POST['bidDueDate']:strtotime($_POST['bidDueDate']);
	$now=time();
		if($now>=$bidDueDT){
		$bidDue['days']='0';
		$bidDue['hrs']='0';
		}
		else{
		$timeDiff=$bidDueDT-$now;
		$bidDue=sec2DaysHrs($timeDiff);
		}
	}
	else{
		if(!is_numeric($_POST['bidDue']['days']) && !is_numeric($_POST['bidDue']['hrs'])){
		$_POST['bidDue']['days']=0;
		$_POST['bidDue']['hrs']=$_urgHr;
		}
	$bidDue['days']=$_POST['bidDate']['days'];
	$bidDue['hrs']=$_POST['bidDate']['hrs'];
	}*/
?>
		<div class="payRateToggle" style=" vertical-align: middle; padding: auto; margin-top: 0px;">
			<label for="bid_urgent_bool" class="btn btn-primary" id="onButton">Yes</label>
			<input type="checkbox" name="bidUrgent" class="altLbls urgentBool" id="bid_urgent_bool" value="bidUrgent" <?php echo $bidUrgent; ?> ></input>
			<label for="bid_urgent_bool" class="btn btn-primary" id="offButton">No</label>
                        <div class="form-group has-feedback" style="padding: 0px 0px 0px 10px; margin: 0px; text-align: left; display: inline-block; vertical-align: middle;">
				<div class="hideDateTime">
				<?php echo SERVICE_URGENT?>
				</div>

				<div class="hideDateTimeAlt" >

				<?php echo SERVICE_NOT_URGENT?>
				<input id="bidDueDays" name="bidDue[days]" type="text" class="dateTimeInput" maxlength="2" value="<?php echo $bidDue['days']; ?>">days
				<input id="bidDueHrs" name="bidDue[hrs]" type="text" class="dateTimeInput" maxlength="2" value="<?php echo $bidDue['hrs']; ?>">hrs
				</div>

                        </div>
                </div>				
		</td>
  	</tr>
</tbody>
</table> -->
</div>

<div class="SRDetailsBox">
<table id="open_sr_list" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                <th colspan="3" id="titleHeaders" ><label for="comment"><?php echo ENTER_PROJECT_ADDRESS_LOCATION;?></label></th>
                </tr>
                </thead>

                <tbody class="tbodyBorder">
        <tr>

    <td> 
 
 
 <?php
$row_cnt_sr_addresses = count($sr_addresses); 
 if($row_cnt_sr_addresses == 0){
 ?>
  <br>
  <br>
  <input id="assigned_address_id" name="assigned_address_id" type="hidden" class="form-control" value="<?php echo $_POST['assigned_address_id'];?> ">
  <center>
  <button class="btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border" type="button" onclick="goToSubmit('new_sr_form', './create_new_service_request_address_selection.php')"><?php echo ADD_EDIT_LOCATIONS;?></button>
  </center>

 <?php
 }else{
 ?>

 
 <ul class="list-group" id="sr_addrs">
 <?php
 $tohtml="";
    foreach($sr_addresses as $key => $row){
    $tohtml.='<li class="list-group-item">'.($key+1).')  '.$row['address'].'</li> <input type="hidden" id="'.$key.'" value="'.$row['id'].'">';
    }
echo $tohtml;
 ?>
 </ul>
 
 
  
  <input id="assigned_address_id" name="assigned_address_id" type="hidden" class="form-control" value="<?php echo $_POST['assigned_address_id'];?> ">
  <center>
  <button class="btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border" type="button" onclick="go_select_address()"><?php echo ADD_EDIT_LOCATIONS;?></button>
<?php
/*
  <button class="btn btn-default general_blue_button_border_radius general_blue_button_size general_blue_button_background general_blue_button_no_border" type="button" onclick="go_map_view()" style="color:white"><?php echo CHECK_MAP;?></button>
*/
?>
  </center>
  
<?php

}

?>
</td>
</tr>
</tbody>
</table>
</div>






<div class="SRDetailsBox">
<table id="open_sr_list" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                <th colspan="3" id="titleHeaders" ><label for="comment"><?php echo SERVICE_DESCRIPTION;?></label></th>
                </tr>
                </thead>

                <tbody class="tbodyBorder">
        <tr>
        <td>
  
  <div class="form-group">
  <textarea placeholder="<?php echo SERVICE_DESCRIPTION_TEXT;?>"  class="form-control text_input_radius" rows="4" id="service_description" name="service_description"><?php echo $_POST['service_description'];?></textarea>
  </div>
  
  
   <label for="comment"><?php echo SERVICE_DESCRIPTION_IMAGES?></label>
   
   <?php
   
   if($count_all_sr_images == "0"){
   ?>
   
    <div class="panel panel-default text_input_radius">
   <div class="panel-body" align="center" style="color:#000000;">
   
   <?php echo UPLOAD_TAKE_PICTURE;?>
   <br>
    <br>
   <button class="btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border" type="button" onclick="goToSubmit('new_sr_form', './create_new_service_request_take_pictures.php')"><?php echo TAKE_UPLOAD_PICTURE;?></button>
  

  
  </div>
  </div>
  
   
   
   <?php
   }else{
   ?>
   
   
   <div class="panel panel-default text_input_radius">
   <div class="panel-body" align="" style="color:#000000;">
   
   <?php echo UPLOAD_TAKE_PICTURE;?>
   
 
   <br>
    <br>
    <table id='sr_imgs'>
    <?php

    $rslt=$_sqlObj->query("select * from view_pics where userId='".$_SESSION['id']."' and srId is NULL and datetime LIKE '%$today%'");

$row=reset($rslt);
$ordNum=1;
     while ($row) {
      echo "<tr class='spaceUnder'>";
   echo "<td width='60px'><img onclick='show_big_image(" . $row['id'] . ")' src='".imgPath2Url(smallPicName($row['url'])). "' class='img-rounded' alt='Imag'><input id='".$ordNum."' value='".$row['id']."' type='hidden'/></td><td width='200px'><font size='3'>" . $row['title'] . "</font></td>";
  
   
  /* echo "<td width='100px' align='right'><button class='btn btn-danger general_orange_button_border_radius' type='button' onclick='delete_image(" . $row['id'] . ")'><i class='fa fa-trash' aria-hidden='true'></i></button></td>";*/
  
  echo "</tr>";
     
     $row=next($rslt);
     $ordNum++;
     }
     ?>
    </table>
    
    <center>
    
    <?php
    
    if($count_all_sr_images < 10){
    ?>
   <button class="btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border" type="button" onclick="goToSubmit('new_sr_form', './create_new_service_request_take_pictures.php')"><?php echo TAKE_UPLOAD_PICTURE;?></button>
   <?php
   }else{
   
   ?>
   
  <div class="panel panel-default text_input_radius">
   <div class="panel-body" align="center" style="color:#E65825;">
   <?php echo MAX_UPLOAD_SR_PICTURE_REACHED;?>   
   </div>
      </div>
   <?php
   }
   ?>
  </center>
  
  </div>
  </div>
   
   <?php
   }
   
   
   ?>
   
 </td>
</tr>
</tbody>
</table>
</div>

<div class="SRDetailsBox">
<table id="open_sr_list" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                <th colspan="3" id="titleHeaders" ><label for="comment"><?php echo SR_CATG;?></label></th>
                </tr>
                </thead>

                <tbody class="tbodyBorder">
        <tr>

        <td>

   <div class="form-group">

    <select class="form-control " id="project_category" name="project_category">
                <?php
                echo "<option value='0'>Please select a category.....</option>";
                $categs=$_sqlObj->query("select * from categ where parent_id='' or parent_id is null");
                $category=$_POST['project_category'];
                $cur=reset($categs);
                while ($cur) {
                                if($category == $cur['id']){
                                echo "<option value=" . $cur['id'] . " selected='selected'>" . $cur['name'] . "</option>";

                                }else{
                                echo "<option value=" . $cur['id'] . ">" . $cur['name'] . "</option>";
                                }
                        $cur=next($categs);
                        }
                        ?>
                </select>
  </div>
</td>
</tr>
</tbody>
</table>
</div>

<div class="SRDetailsBox">
<table id="open_sr_list" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                <th colspan="3" id="titleHeaders" ><label for="comment"><?php echo SELECT_SERVICE_PROVIDER?></label></th>
                </tr>
                </thead>

                <tbody class="tbodyBorder">
        <tr>

    <td> 
  <div class="btn-group btn-group-vertical" data-toggle="buttons">
        <label class="btn active">
          <input type="radio" name='radio_all_provider' id='radio_all_provider' checked value="all_provder"><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i> <span><?php echo ALL_SERVICE_PROVIDERS ;?></span>

        </label>
        <label class="btn">
          <input type="radio" name='radio_my_provider' id='radio_my_provider' value="my_provder"><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i> <span><?php echo SELECT_SPECIFIC_SERVICE_PROVIDERS ;?></span>
        </label>
        <label class="btn">
          <input type="radio" name='radio_specific_provider' id='radio_specific_provider' value="specific_provider"><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i> <span><?php echo SELECT_SPECIFIC_SERVICE_PROVIDER ;?></span>
          
        </label>
        <div style="margin:10px">
        <input type="text" placeholder="<?php echo KEY_IN_PROVIDER_USERNAME;?>" class="form-control" id="provider_name" name="provider_name" value="<?php echo $_POST['provider_name'];?>">
         </div>
         <div style="margin:10px">
         <span id="found_not_found" name="found_not_found"></span>
         </div>
         
         <label class="btn">
          <input type="radio" name='radio_previous_provider' id='radio_previous_provider'  value="previous_provider"><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i> <span><?php echo PREVIOUS_SERVICE_PROVIDERS ;?></span>
        </label>
        <div style="margin:10px">
        <select class="form-control" name="select_service_providers" id="select_service_providers">
        
        <?php

    //getting all the previous bidders.
    $qstr="select distinct(bidderId), bidderExternId, bidderUsername from view_serviceRequests where ownerId='".$_SESSION['id']."' and bidderId!='' and bidderId is NOT NULL;";

    $sqlhndl= new mysqli("$host", "$username", "$password", "$db_name");

    if($sqlhndl->connect_errno > 0){
    die('Unable to connect to database [' . $sqlhndl->connect_error . ']');
    }

    $sqlhndl->query($qstr);
    $SRBidders=$sqlhndl->query($qstr)->fetch_assoc();
    $sqlhndl->close();


    $cur=reset($SRBidders);
            while ($cur) {
                echo "<option value='" .  $cur['bidderId']  . "'>" . $cur['bidderUsername'] .  "</option>";
            $cur=next($SRBidders);
            }
        ?>
        </select>
        </div>
</div>
    </td>

    <td style="width: 100%;">
    <div id="googleMap" ></div>
    </td>

    </tr>
</table>
</div>


<div class="SRDetailsBox">
<table id="open_sr_list" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                <th colspan="3" id="titleHeaders" ><label for="comment"><?php echo SERVICE_INVOICE_TYPE?></label></th>
                </tr>
                </thead>

                <tbody class="tbodyBorder">
        <tr>
<?php

if(array_key_exists('paytpe', $_POST)){
$paytype=$_POST['paytype']=="fixed"?"checked":"";
}
else{
$paytype='checked';
}

?>
		<td id="custTblPd" style="vertical-align: middle; padding-left: 15px;">
                                <div class="payRateToggle" style=" vertical-align: middle; padding: auto; margin-top: 0px;">
					<label for="pay_rate_type_bool" class="btn btn-primary fair btn-info btn-sm offButton">Fair Market</label> 
                    <label for="pay_rate_type_bool" class="btn btn-primary fixed onButton">Fixed</label>
					<!--<input type="checkbox" name="paytype" class="altLbls testcheck" id="pay_rate_type_bool" value="fixed" <?php /*echo $paytype;*/ ?>></input>-->
					<label for="pay_rate_type_bool" class="btn btn-primary hourly btn-info btn-sm offButton">Hourly</label>
                     
                     <input type="hidden" name="paytypehidden" value="fixed" id="paytypehidden">
					<div class="form-group has-feedback hideamt" style="padding: 0px 0px 0px 10px; margin: 0px; width: 200px; text-align: left; display: inline-block; vertical-align: middle;">
					<input  type="text"  style="text-align:center;" class="form-control" id="target_fix_rate" name="payAmt" value="<?php echo $_POST['payAmt'];?>" placeholder="Fixed Rate" onkeypress="return isNumberKey(event)" onchange='HourlyTotalFunc()' >
					<i class="glyphicon glyphicon-usd form-control-feedback"></i>
					</div>
                    <div class="form-group has-feedback hour_rate" style="padding: 0px 0px 0px 10px; margin: 0px; width: 300px; text-align: left; display: inline-block; vertical-align: middle; display: none">
                    <input  type="text"  style="text-align:center;width:48%;float:left" class="form-control" id="totalhours" name="totalhours" value="<?php echo $_POST['totalhours'];?>" placeholder="Total Hours" onkeypress="return isNumberKey(event)" onchange='HourlyTotalFunc()'>
                   <input  type="text"  style="text-align:center;width:48%;margin-left:2%;float: left;" class="form-control" id="calchours" name="calchours" value="<?php echo $_POST['calchours'];?>" placeholder="Total Amount" readonly>
                    </div>
				</div>

                </td>
        </tr>
        
         <tr class="setschedule"><td style="vertical-align: top;"><span style="font-weight: bold">Set Recurrence</span>
            <select name="set_schedule" id="set_schedule">
              
            <?php foreach($_configs['scheduleArray'] as $key => $value)
            { ?>
            <option value="<?php echo $key; ?>" <?php if($_POST['set_schedule'] == $key) echo "selected"; ?>><?php echo $value; ?></option>
        <?php } ?>
          </select></td></tr>
          <tr class="setschedule showscheduleamount" style="display: none;"><td style="" >
            <input type="text" placeholder="Schedule Amount" class="form-control" id="schedule_amount" name="schedule_amount" style="width: 200px;margin-left: 103px;" value="<?php echo $_POST['schedule_amount'];?>" onkeypress="return isNumberKey(event)" onchange='ScheduleTotalFunc()'>
            <i class="glyphicon glyphicon-usd form-control-feedback"></i>
      </td></tr>
      <tr class="setschedule showscheduleamount" style="display: none;"><td style="" >
            <textarea placeholder="Schedule Note" style="height:105px !important;width: 300px;margin-left: 103px;"  class="form-control text_input_radius" rows="2" id="schedule_note" name="schedule_note" rows="2"><?php echo $_POST['schedule_note'];?></textarea>
      </td></tr>
 </table>
</div>


<div class="SRDetailsBox" id="ScheduleServiceWrapper">
<table id="open_sr_list" class="table table-striped" cellspacing="0" width="100%">
        <thead>
                <tr>
                <th colspan="3" id="titleHeaders" ><label for="comment"><?php echo SR_DUE_DATE_Q?></label></th>
                </tr>
        </thead>

    <tbody class="tbodyBorder" id="custTblPd">
    <tr>
        <td style="vertical-align: middle; width: 150px; border-right: 0px;"> 


<?php

$SRDueDate="";
$SRDueDate=checkboxPostDateUrg('dateTimeTo', 'SRDueDateTime', 'urgent');

?>
            <div class="payRateToggle" style=" vertical-align: middle; padding: auto; margin-top: 0px; display: inline-block; min-width: 170px;">
                <label for="dateTime_bool" class="btn btn-primary onButton">Urgent</label>
                <input type="checkbox" name="SRDueDateTime" class="altLbls dateTime_bool" id="dateTime_bool" value="urgent" <?php echo $SRDueDate?> ></input>
                <label for="dateTime_bool" class="btn btn-primary offButton">Select</label>
            </div>              
    </td>
    <td>

                <div class="calInput">
                <b><?php echo SR_DUE_SELECT?></b>
                <table class="chooseDateTime">
                   <tr align="left">
                   	<td colspan="2" style="text-align: left;">
                            <div style=" cursor: pointer; " id="reportrange" class="btn btn-primary" >
                                                Select Date Range
                                                </div></td>
                   </tr>
                	<tr>
                        <td colspan="2">
                          <div class="form-group" style="margin-top:5px;float:left;display:none;">

                 				<label style="text-align:left;display:none"><?php echo DATE_FROM ;?></label>
            
                        	<div id='date_from'>
                            <div class="input-group "><!-- date -->
                                <input style="background:transparent;border:0px;width:100px;box-shadow: none;" type="text" id="date_from_value" name="date_from_value" class="form-control text_input_radius" value="<?php echo $sr_date_from;?>" readonly >
                             </div>
                         	</div>
                 			 </div>

								<!--<span style="float:left;margin-top: 11px;">&nbsp;-&nbsp;</span>-->
                        

                        <div class="form-group" style="margin-top:5px;float:left;display:none;">
                        	<label style="text-align:left;display:none;"><?php echo DATE_TO ;?></label>
                        	<div id='date_to'>
                              <div class="input-group "><!-- date -->
											<input  style="background:transparent;border:0px;width:100px;box-shadow: none;" type="text" id="date_to_value" name="date_to_value" class="form-control text_input_radius" value="<?php echo $sr_date_to;?>" readonly >
                                               <!-- <div style="background: #fff; cursor: pointer; " id="reportrange" class="input-group-addon text_input_radius" >
                                                <i class="material-icons" id="reportrange">calendar_today</i>
                                                </div> -->
                              </div>
                            </div>
                        </div>

                        </td>
                  </tr>
                   <tr align="left"><td colspan="2" style="text-align: left;"><div >
                            <div style="padding-top: 10px;" >
                                            <select name="timeselect" id="timeselect">
                <option value="">Select Time Range</option>
            <?php foreach($_configs['time_type'] as $key => $value)
            { ?>
            <option value="<?php echo $key; ?>" <?php if($_POST['timeselect'] == $key) echo "selected"; ?>><?php echo $value; ?></option>
        <?php } ?>
          </select>
                                                </div></td></tr>
                  <tr class="showtime" style="display: none;">
                        <td style="text-align: left;">

                          <label style="margin-top: 10px;font-weight: normal;font-size: 14px;"><?php echo TIME_FROM?></label>
                  <div class="input-group time_from" data-align="top" data-placement="top">

                    <input type="text" class="form-control text_input_radius" id="time_from_value" name="time_from_value" value="<?php echo $sr_time_from;?>">
                        <span class="input-group-addon text_input_radius">
                        <i class="material-icons">access_time</i>
                        </span>
                </div>


                        </td>


                  <td style="text-align: left;">
                        <label style="margin-top: 10px;font-weight: normal;font-size: 14px;"><?php echo TIME_TO?></label>
                        <div class="input-group time_to" data-align="top" data-placement="top">
                    <input type="text" class="form-control text_input_radius" id="time_to_value" name="time_to_value" value="<?php echo $sr_time_to;?>">
                        <span class="input-group-addon text_input_radius">
                        <i class="material-icons">access_time</i>
                        </span>
                </div>

                </div>
                </td>

          </tr>
         

         </table>
        </div>




        </td>
    </tr>
    </tbody>
</table>
</div><label for="checkPerSumm" class="btn btn-success" style="margin-top: 30px;">Add Personal Note</label>
                        <input type="checkbox" class="checkHideShowBare" id="checkPerSumm" style="display: none;"></input>
                        <div class="SRPerSumm rmStyleOnCheck">

<div class="SRDetailsBox">
<table id="open_sr_list" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                <th colspan="3" id="titleHeaders" ><label for="comment"><?php echo SR_SUMMARY?></label></th>
                </tr>
                </thead>


                <tbody class="tbodyBorder" id="custTblPd">
  	<tr>
  		<td>
  
		  <div class="form-group">
		  <textarea placeholder="<?php echo SERVICE_SUMM_TEXT;?>"  class="form-control text_input_radius" rows="4" id="pers_summ" name="pers_summ"><?php echo $_POST['pers_summ'];?></textarea>
		  </div>
		 
		</td>
  	</tr>
</tbody>
</table>
</div>
			</div>


  
  
    
  <hr>
 
 <center>
 
 <table>
 
 <tr class="SRButtons" >
 <td width="85px"> <button class="btn btn-info" type="button" onclick="go_back()" > <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo BACK;?></button> </td> <!-- onclick="go_back()" -->
 <td width="85px"> <button class="btn btn-success" type="button"  onclick="sr_submit('save')"> <i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo SAVE_SR;?></button> </td> <!-- onclick="sr_save()" -->
 <td width="100px"> <button class="btn btn-warning" type="button" onclick="sr_submit('submit')"><i class="fa fa-check" aria-hidden="true"></i> <?php echo SUBMIT_SR;?></button></td>
 <td width="100px" style="margin-left: 80px;" >  <button class="btn btn-danger" type="button" onclick="sr_delete(<?php echo $offers;?>)"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo DELETE_SR;?></button></td>
 
 </tr>
 
 </table>

 </center>

 
</form>
</div>


  </div>
</div>


<input type="hidden" id="username_found" name="username_found" value="">




<div id="modal_category_details" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        	<div class="modal-content">
        		<div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            		<h4 class="modal-title" style="color:#000000";><center><span id="category_title"></span> - <?php echo CATEGORY_DETAILS ;?></center></h4>
            	</div>
            		<div class="modal-body">
            		
            		
            		<div style="margin:10px">

            		<p><?php echo CATEGORY_DETAILS_TEXT_1;?></p>
            		<p><?php echo CATEGORY_DETAILS_TEXT_2;?></p>
            		<br>
            		
            		<span id="form_sub_category"></span>
            		
            		<span id="form_html"></span>
            		
            		</div>
            		
            	    <p><?php echo CATEGORY_DETAILS_TEXT_3;?></p>
            	    
            	                	    <center>







 
 <table>
 
 <tr>
 
 <td width="100px"> <button class="btn btn-default" type="button" onclick="additional_info_close()"> <?php echo CANCEL;?></button></td>
 <td width="100px">  <button class="btn btn-success" type="button" onclick=""> <?php echo CONTINUE_SR;?></button></td>
 
 </tr>
 
 </table>
 


 </center>
            
            	    
	    
            	    
            		
            		
            		           		
            		</div>
            </div>
        </div>
    </div>



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


</body>
</html>
