<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
require_once("./header_main.php");
require_once("./common.inc.php");
require_once("./mysql_lib.php");

$sr_id = $_sqlObj->escape($_GET['sr_id']);

$goback_url = $_GET['goback_url'];
$goback_parmeter = $_GET['goback_parmeter'];

$firstname = $_SESSION['firstName'];
$name = $row_accout_id['name']." test";
$fullname = $firstname . " " . $_SESSION['surName'];


// get sr_details

$sql_get_sr_details = "SELECT * FROM view_serviceRequests WHERE id='$sr_id'";
$srArr = reset($_sqlObj->query($sql_get_sr_details));

$sr_name = $srArr['title'];

// imported when mesage is cretaed
$sr_user_id = $srArr['ownerId'];
$sender_user_id = $account_id;






// get all sr related messages from messages_sr

$qstr = "SELECT * FROM messages_sr WHERE sr_id='$sr_id'";
$result_get_sr_messages = $_sqlObj->query($qstr);
$messages =  json_encode($result_get_sr_messages);
//var_dump($messages);
 echo $_template["header"];
 

$json = json_encode(array("username" => $_SESSION['chatwith'], "password" => "rahuls13", "gender" => "male", "role" => "guest", 
"profile" => "", "image" => "https://html5-chat.com/img/malecostume.svg"));
//echo $json;
//$encoded = file_get_contents("https://jwt.html5-chat.com/protect/".base64_encode($json));
if($_SESSION['id'] == $sr_user_id){
	$qstr = "SELECT username FROM users WHERE id='$sr_user_id'";
	$result_username = $_sqlObj->query($qstr);
	$buyer_name = $result_username[0]['username'];
	//$chaturl = "https://helptimize.webtv.fr/enter.php?buyerid=".$sr_user_id;
	//$chaturl = "chat/enter.php?buyerid=(".$buyer_name.")";
  $chaturl = "chat/enter.php?buyerid=".$sr_user_id;
}else{
	$qstr = "SELECT username FROM users WHERE id='$sr_user_id'";
	$result_username = $_sqlObj->query($qstr);
	$buyer_name = $result_username[0]['username'];
	$qstr = "SELECT username FROM users WHERE id='".$_SESSION['id']."'";
	$result_username = $_sqlObj->query($qstr);
	$seller_name = $result_username[0]['username'];
	//$chaturl = "https://helptimize.webtv.fr/enter.php?buyerid=".$sr_user_id."&sellerid=".$_SESSION['id'];
	//$chaturl = "chat/enter.php?buyerid=(".$buyer_name.")&sellerid=(".$seller_name.")";
  $chaturl = "chat/enter.php?buyerid=".$sr_user_id."&sellerid=".$_SESSION['id'];
}
//header("Location:".$chaturl);
//echo $chaturl;
	$encoded = file_get_contents($chaturl);
?>

<style>

.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}


   .modal-dialog {width:600px;}
.thumbnail {margin-bottom:6px;} 
</style>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.3.0/bootbox.min.js" type="text/javascript" ></script>


<style = "text/css">
<!--        
.messages_display {height: 300px; overflow: auto;}      
.messages_display .message_item {padding: 0; margin: 0; }       
.bg-danger {padding: 10px;} --> 
</style>


<?php echo $_template["nav"];  ?>

<div class="row" style="padding: 15px; margin: 0px; border-bottom: 1px #e8e8e8 solid;">
  
  <table>
  <tr>
  <td>
	<button onclick="go_back()" type="button" class="btn btn-primary">
	<?php echo BACK;?></button>
  </td>
  </td>
  <td>
    <h4>
      <font color="#ffffff">SR - <?php echo $sr_id;?>  <?php echo $sr_name;?>
      </font>
    </h4>
  </td>
  </tr>
  </table>

</div>


<br>



<div class = "container">       

	<!--
    <div class = "col-md-6 chat_box">   
        <label><?php echo CHAT_MESSAGES;?></label>                      
        <div class = "form-control messages_display"></div>         
        <br />                      
                       
            
        <div class = "form-group">              
            <label><?php echo NEW_MESSAGE;?></label>              
            <textarea class = "input_message form-control" placeholder = "Message"></textarea>          
        </div>   
        
     <div class = "form-group input_send_holder">                
            <input type = "submit" value = "Send Message" class = "btn btn-primary input_send" />           
        </div> 
        
        
        
         
   
  <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
  <input type="hidden" id="sr_id" name="sr_id" value="<?php echo $sr_id;?>">
  
  <input type="hidden" id="sr_user_id" name="sr_user_id" value="<?php echo $sr_user_id;?>">
  <input type="hidden" id="sender_user_id" name="sender_user_id" value="<?php echo $sender_user_id;?>">
  

  
            <label><?php echo TAKE_PICTURE_OR_SELECT_FILE;?></label> 
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                      Select&hellip; 
                                       <input type="file"  name="img[]" id="file" accept="image/*" capture="camera"  style="display: none;" />
                                       
                    </span>
                </label>
                <input type="text" id="filepath" name="filepath" class="form-control" readonly value="">
            </div>
            <br>
            
            <input type="submit" id="picture_submit" name="picture_submit"value="<?php echo UPLOAD_PICTURE;?>" class = "btn btn-default" />
            
   </form>

           <br>
		   <br>
       
    		
 
                      
                        
    </div>  
    -->
    <!--<div style="">
    <span style="color:red">Click on user name for private chat</span></h2>
    <script src="https://html5-chat.com/script/11733/<?php echo $encoded; ?>"></script>
	</div>-->
	<iframe style="border:0px;" src="<?php echo $chaturl ?>" width="100%" height="700px" allow="geolocation; camera; microphone;"></iframe> 




<script>

$("#uploadimage").on('submit',(function(e) {

    $("#picture_submit").prop("disabled",true);

    e.preventDefault();
  

   	var filerequired = $("#filepath").val();
   	
   	var oops = '<?php echo OOPS; ?>';
   	var file_required = '<?php echo FILE_REQUIRED; ?>';
   	
   	if(filerequired == ""){
   	
   	  swal(oops, file_required, "error");
   	  $("#picture_submit").prop("disabled",false);
   	  return;
   	
   	
   	}

  
  var result = "";
  
  $.ajax({
	url: "uploadImage.php", 
	type: "POST",             
	data: new FormData(this), 
	contentType: false,       
	cache: false,
	async: false,             
	processData:false,        
	success: function(data)   
		{
		    result = data;
		}
	});


        result=JSON.parse(result);
        result=result[0]; //only uploading one at a time
        console.log(JSON.stringify(result));


	
	var oops = '<?php echo OOPS; ?>';
   	var file_exist = '<?php echo FILE_EXIST; ?>';
   	var porn_upload = '<?php echo FILE_PORN; ?>';
   	var success_upload = '<?php echo FILE_NO_PORN; ?>';
   	var done = '<?php echo DONE; ?>';
   	
 
   	/*		
   	if(result == "file_already_exist"){
		
	    swal(oops, file_exist, "error");
	        	
	}
	
	
	if(result == "porn"){
		
	    swal(oops, porn_upload, "error");
	        	
	}
	
	
	if(result == "no_porn"){
		
	    swal(done, success_upload, "success");
	        	
	}
	*/

	if(result['status'] == 1){
                
            swal(oops, result['msg'], "error");
                        
        }
	
		
	$("#picture_submit").prop("disabled",false);

var myName = '<?php echo $_SESSION['firstName'].' '.$_SESSION['surName']; ?>';
var srid = '<?php echo $sr_id; ?>';
	//posting image in chat
	sendToChatImg(myName, srid , '<?php echo imgPath2Url($_configs['uploads_dir']); ?>'+result['filename']);
}));

$(document).on('change', ':file', function() {
    
    var input = $(this);
       
   
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
        
        
        $("#filepath").val(label);
        
    
});




// AJAX request
function ajaxCall(ajax_url, ajax_data) {
    $.ajax({
        type: "POST",
        url: ajax_url,
        dataType: "json",
        data: ajax_data,
        success: function(response, textStatus, jqXHR) {
            console.log(jqXHR.responseText);
        },
        error: function(msg) {}
    });
}



function storeMsg(uid, myName, srid, msg){
     var formData = {
        'message'     : msg,
        'sr_id'     : srid,
        'sr_user_id'     : uid,
        'sender_user_id' : '',
        'fullname'     : myName
        }
        
          var feedback = $.ajax({
                        type: "POST",
                        url: "store_sr_message.php",
                    data: formData,
                
                    async: false,
                        
        }).complete(function(){
        }).responseText;
}



//send line to chat
function sendToChat(myName, srid, msg){
// code to tell when someone's logged on.
var chat_message = {
            name: myName, 
            sr_id: srid,
            message: msg
        }
        ajaxCall('message_relay.php', chat_message);
	$('.messages_display').append(msg);
var id='<?php echo $_SESSION['id'] ?>';
	storeMsg(id, myName, srid, msg);
}



//send line to chat
function sendToChatImg(myName, srid, filepath){
// code to tell when someone's logged on
var picMsg='<div id="chatImg"><strong>'+myName+'</strong> has uploaded an image.<img src="'+filepath+'"/></div>';

var chat_message = {
            name: myName, 
            sr_id: srid,
            message: picMsg
        }
        ajaxCall('message_relay.php', chat_message);
var id='<?php echo $_SESSION['id'] ?>';
	storeMsg(id, myName, srid, picMsg);
}






$(document).ready(function() {

	var arrayFromPHP = "<?php echo addslashes($messages); ?>";
	//var arrayFromPHP = '<?php echo $messages; ?>';
	var JSONObject = JSON.parse(arrayFromPHP);

	for (var key in JSONObject) {


    if (JSONObject.hasOwnProperty(key)) {
      
      var date_time = JSONObject[key]["date_time"];
     
	/* 
      if(JSONObject[key]["message_text"] == "image"){
      
     

       var message_append = "<strong>" + JSONObject[key]["fullname"] + "</strong>: Image Upload <br> <a href='image_upload/" + JSONObject[key]['image'] + "'  title='Image 1'><img src='image_upload/" + JSONObject[key]['image'] + "' class='thumbnail img-responsive'></a>";
       
      
      	$('.messages_display').append('<small>Date/Time:' + date_time +'</small><br><p class = "message_item">' + message_append + '</p><br>');
      
      }else{
      
      	var message_append = "<strong>" + JSONObject[key]["fullname"] + "</strong>:" + JSONObject[key]["message_text"];
      
      	$('.messages_display').append('<small>Date/Time:' + date_time +'</small><br><p class = "message_item">' + message_append + '</p><br>');
      }	
	*/

	$('.messages_display').append('<div id="chatRecall">[' + date_time +']'+JSONObject[key]["message_text"]+'</div><br>');
    }
  }
   
var myName = '<?php echo $_SESSION['firstName'].' '.$_SESSION['surName']; ?>';
var srid = '<?php echo $sr_id; ?>';
// code to tell when someone's logged on.
var signOnMsg='<div id="chatSignOnMsg"><strong>' + myName + '</strong> has signed on </div>';

sendToChat(myName, srid, signOnMsg);

$(window).unload(function(){

var signOffMsg='<div id="chatSignOffMsg"><strong>' + myName + '</strong> has signed off </div>';

  sendToChat(myName, srid, signOffMsg);
});

});


</script>

<script type="text/javascript"> 

function go_back()
{
     
   var goback_url  = "<?php echo $goback_url; ?>";
   var goback_parmeter = "<?php echo $goback_parmeter; ?>";
   
   var goback_string = goback_url + goback_parmeter;
   


     
     location.href = goback_string;



}   

// Enable pusher logging - don't include this in production
    Pusher.log = function(message) {
      if (window.console && window.console.log) {
        window.console.log(message);
      }
    };

      
// Enter your own Pusher App key
var pusher = new Pusher('e0351b1ebb3e8a8e9964');

var channel_id = "<?php echo $sr_id; ?>";



// Enter a unique channel you wish your users to be subscribed in.
var channel = pusher.subscribe(channel_id);
channel.bind('my_event', function(data) {
    // Add the new message to the container
    $('.messages_display').append('<p class = "message_item">' + data.message + '</p>');
    // Display the send button
    $('.input_send_holder').html('<input type = "submit" value = "Send" class = "btn btn-primary input_send" />');
    // Scroll to the bottom of the container when a new message becomes available
    $(".messages_display").scrollTop($(".messages_display")[0].scrollHeight);
});









// Trigger for the Enter key when clicked.
$.fn.enterKey = function(fnc) {
    return this.each(function() {
        $(this).keypress(function(ev) {
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if (keycode == '13') {
                fnc.call(this, ev);
            }
        });
    });
}

// Send the Message
$('body').on('click', '.chat_box .input_send', function(e) {
    e.preventDefault();
    
    var message = $('.chat_box .input_message').val();
	var name  = "<?php echo $fullname; ?>";
	var sr_id = "<?php echo $sr_id; ?>";
	var account_id = "<?php echo $account_id; ?>";
	
	var sr_user_id = "<?php echo $sr_user_id; ?>";
	var sender_user_id = "<?php echo $sender_user_id; ?>";
	
	var test_if_phone = /(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?/img;
    var emailExp = /([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/img;
    
     var exp = /\b(\d+)\b/img;
    
     message = message.replace(test_if_phone, "################");
     
     message = message.replace(exp, "################");
     
     message = message.replace(emailExp, "********************");
    
    // store the message in the database
    
	message =  '<div id="chatNorm"><strong>' + name + '</strong>: ' + message+'</div>';
     var formData = {
        'message'     : message,
        'sr_id'     : sr_id,
        'sr_user_id'     : sr_user_id,
        'sender_user_id' : sender_user_id,
        'fullname'     : name,
    
    	}
    	
    	  var feedback = $.ajax({
    			type: "POST",
    			url: "store_sr_message.php",
    		    data: formData,
    		
    		    async: false,
    			
    	}).complete(function(){
        				
    	}).responseText;
    
    

    
    // Validate Name field
    if (name === '') {
        bootbox.alert('<br /><p class = "bg-danger">Please enter a Name.</p>');
    
    } else if (message !== '') {
        // Define ajax data
        var chat_message = {
            name: name,
            sr_id: sr_id,
            message: message
        }
        // Send the message to the server
        ajaxCall('message_relay.php', chat_message);
        
        // Clear the message input field
        $('.chat_box .input_message').val('');
        // Show a loading image while sending
        //$('.input_send_holder').html('<input type = "submit" value = "Send" class = "btn btn-primary" disabled /> &nbsp;<img src = "loading.gif" />');
    }
});

// Send the message when enter key is clicked
$('.chat_box .input_message').enterKey(function(e) {
    e.preventDefault();
    $('.chat_box .input_send').click();
});


</script>
