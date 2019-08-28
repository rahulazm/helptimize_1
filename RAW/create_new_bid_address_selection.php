<?php
require_once("./header_main.php");

if(!$_SESSION['id']){
echo "Not logged in.";
exit(0);
}
$sr_number=$_sqlObj->escape($_GET['sr_number']);
//preserve previously unsubmitted SR if it exists.
if($_POST){
$_SESSION['new_sr']=$_POST;
}

$configs=$_configs;

// load all addresses for this SR

$db_get_sr_addresses = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_sr_addresses ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_sr_addresses ->connect_error . ']');
}

$sql_get_sr_addresses = "SELECT * FROM address WHERE userId='".$_SESSION['id']."' and personal IS NULL and bidId is NULL and srId ='".$sr_number."' and (pob is null or pob=0)";

$result_get_sr_addresses = $db_get_sr_addresses->query($sql_get_sr_addresses);
$location_count = $result_get_sr_addresses->num_rows;

$db_get_sr_addresses->close();


// get stored addresses

$db_get_addresses = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_addresses ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_addresses ->connect_error . ']');
}

$sql_get_addresses = "SELECT * FROM address WHERE userId='$account_id'";

$result_get_addresses = $db_get_addresses->query($sql_get_addresses);

$db_get_addresses->close();




$sql_get_addresses = "SELECT * FROM address WHERE userId=".$_SESSION['id']." and personal IS NOT NULL order by datetime, title";
$result_get_addresses_edit=$_sqlObj->query($sql_get_addresses);

$stored_addresses="";

foreach($result_get_addresses_edit as $row){

$stored_addresses.='
                        <tr>
                        <td style="width: 75px">'.$row['title'].'</td>
                        <td style="width: 75px">'.$row['address'].'</td>
                    <td style="width:10px">
			<button address_id="' . $row['id'] . '"  class="btn btn-danger delete_address general_blue_button_border_radius general_blue_button_background general_blue_button_no_border" ><i class="fa fa-trash-o fa-lg"></i></button>

		</td>
		</tr>
';


}


$stored_addrs=$_sqlObj->query("select * from address where userId=".$_SESSION['id']." and personal IS NOT NULL order by datetime, title;");
$storeAddrHtml="";
foreach($stored_addrs as $row){
        $storeAddrHtml.="<option value=" . $row ['id'] . ">" . $row ['title'] . " | " . $row ['address'] .  "</option>";
}



/* already done in header

$db_count_unread_messages = new mysqli("$host", "$username", "$password", "$db_name");

if($db_count_unread_messages ->connect_errno > 0){
    die('Unable to connect to database [' . $db_count_unread_messages ->connect_error . ']');
}

$sql_count_unread_messages = "SELECT id FROM message_list WHERE user_id='$account_id' AND read_status='0'";

$result_count_unread_messages = $db_count_unread_messages->query($sql_count_unread_messages);
$count_unread_messages = $result_count_unread_messages->num_rows;

$db_count_unread_messages->close();
*/

echo $_template["header"];

if(count($_POST)==0){
$_POST=$_SESSION['new_sr'];
}

?>

<style>

.general_orange_button_brder_radius {border-radius: 15px !important;}
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

</style>


     <meta name="mobile-web-app-capable" content="yes">

<?php echo $_template["nav"]; ?>


<div class="row">
  <div class="col-xs-12 col-md-12">
  
  <div class="panel panel-default">
  <div class="panel-body">
  
<center>
<h4><font color="#000000"><?php echo SELECT_ADDRESS;?></font></h4>
 </center>

  </div>
    </div>
  
  <style>
  
  .pac-container {
    background-color: #FFF;
    z-index: 20;
    position: fixed;
    display: inline-block;
    float: left;
}
.modal{
    z-index: 20;   
}
.modal-backdrop{
    z-index: 10;        
}
  
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      
      #mapdiv {
	margin: 0;
	padding: 0;
	width: 100%;
	height: 300px;
    resize:both;
    overflow:auto; 
}
      
    </style>
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <style>
      #locationField, #controls {
        position: relative;
        width: 480px;
      }
      
      #locationField2, #controls {
        position: relative;
        width: 480px;
      }
      
      #autocomplete {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 350px;
      }
      
       #autocomplete2 {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 350px;
      }
      
      
      
      .label {
        text-align: right;
        font-weight: bold;
        width: 100px;
      }
      #address {
        border: 1px solid #000090;
        background-color: #f0f0ff;
        width: 480px;
        padding-right: 2px;
      }
      #address td {
        font-size: 10pt;
      }
      .field {
        width: 99%;
      }
      .slimField {
        width: 80px;
      }
      .wideField {
        width: 200px;
      }
      #locationField {
        height: 20px;
        margin-bottom: 2px;
      }
      #locationField2 {
        height: 20px;
        margin-bottom: 2px;
      }
      
      
      .panel {
    margin: 0 !important; 
    padding:0 !important;
    background:#FFFFFF !important;

}


.panel_white {
    margin: 0 !important; 
    padding:0 !important;
    background:#33b5e5 !important;

}
      
      .panel-heading .accordion-toggle:after {
    /* symbol for "opening" panels */
    font-family: 'Glyphicons Halflings';  /* essential for enabling glyphicon */
    content: "\e114";    /* adjust as needed, taken from bootstrap.css */
    float: right;        /* adjust as needed */
    color: grey;         /* adjust as needed */
}
.panel-heading .accordion-toggle.collapsed:after {
    /* symbol for "collapsed" panels */
    content: "\e080";    /* adjust as needed, taken from bootstrap.css */
}
    </style>



    <div style="margin:10px">
    
    <?php 
    
    if($location_count == 0){
    ?>
    
    <div class="panel panel-default text_input_radius">
  <div class="panel-body">
 <?php echo NO_SR_LOCATION?></div>
</div>
    
    <?php
    }
    ?>

    
   <br>
    
    <div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
       
        <button class="btn btn-primary general_blue_button_border_radius general_blue_button_size general_blue_button_background general_blue_button_no_border" type="button" data-toggle="collapse" data-target="#collapseOne">Add</button>
          <?php echo SELECT_FROM_GPS_LOCATION?>
      
      
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse out">
      <div class="panel-body">
    
    
    <label><?php echo MY_CURRENT_LOCATION?></label>
    
 
  
  <p id ='mapdiv' name='mapdiv'></p>
  
  <br>
  <div class="form-group">
  <label for="usr"><?php echo CURRENT_ADDRESS?></label>
  <input type="text" class="form-control text_input_radius" id="curent_address"  name="curent_address">
  </div>
  
  
   <div class="form-group">
  <label for="usr"><?php echo ENTER_PROJECT_ADDRESS_NAME?></label>
  <input type="text" class="form-control text_input_radius" id="current_address_name"  name="current_address_name"   value="<?php echo $location_count+1; ?>">
</div>
  
  
   <div class="form-group">
  <label for="comment"><?php echo ENTER_PROJECT_ADDRESS_DESCRIPTION?></label>
  <textarea placeholder="<?php echo ADRESS_DESCRIPTION;?>" class="form-control text_input_radius" rows="2" id="current_address_description" name="current_address_description"></textarea>
</div>
  
  <center>
<button class="btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border" type="button" onclick="add_current_address()"><?php echo ADD_ADDRESS;?></button>
  </center>
  
  </div>
   </div>
    </div>
    </div>
    
<div class="panel-group" id="accordion3">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
      
        
         <button class="btn btn-primary general_blue_button_border_radius general_blue_button_size general_blue_button_background general_blue_button_no_border" type="button" data-toggle="collapse" data-target="#collapseThree">Add</button>
          <?php echo SELECT_NEW_LOCATION?>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse out">
      <div class="panel-body">
    
		<div class="form-group">
     		<label><?php echo ENTER_PROJECT_ADDRESS_LOCATION;?></label>
    		<div id="locationField" >
   
      		<input id="autocomplete" placeholder="<?php echo ENTER_YOUR_ADDRESS;?>"
             	onclick="geolocate()" type="text" class="form-control text_input_radius"></input>
    		</div>
		</div>
    
    	<div class="form-group">
  			<label for="usr"><?php echo ENTER_PROJECT_ADDRESS_NAME?></label>
  			<input type="text" class="form-control text_input_radius" id="new_address_name"  name="new_address_name"  value="<?php echo $location_count+1; ?>">
		</div>
    
    	<div class="form-group">
  			<label for="comment"><?php echo ENTER_PROJECT_ADDRESS_DESCRIPTION?></label>
  			<textarea placeholder="<?php echo ADRESS_DESCRIPTION;?>"  class="form-control text_input_radius" rows="2" id="new_address_description" name="new_address_description"></textarea>
		</div>
		<center>
		<button class="btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border" type="button" onclick="add_new_address()"><?php echo ADD_ADDRESS;?></button>
		</center>
	</div>
	</div>
    </div>
    </div>
    
    <div class="panel-group" id="accordion2">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
       
        
         <button class="btn btn-primary general_blue_button_border_radius general_blue_button_size general_blue_button_background general_blue_button_no_border" type="button" data-toggle="collapse" data-target="#collapseTwo">Add</button>
          <?php echo SELECT_FROM_STORED_LOCATION?>
        
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse out">
      <div class="panel-body">
    
    

     <div class="form-group">
    <label><?php echo SELECT_STORED_ADDRESS?></label>
    <select class="form-control" id="select_stored_address" name="select_stored_address">
    <?php
	echo $storeAddrHtml;    
    ?>
    
</select>
 <div class="form-group">
  <label for="comment"><?php echo ENTER_PROJECT_ADDRESS_DESCRIPTION?></label>
  <textarea placeholder="<?php echo ADRESS_DESCRIPTION;?>" class="form-control text_input_radius" rows="2" id="existing_address_description" name="existing_address_description"></textarea>
</div>

<center>
<button class="btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border" type="button" onclick="add_stored_address()"><?php echo ADD_ADDRESS;?></button>

 <button onclick="edit_stored_addresses()" type="button" class="btn btn-primary general_blue_button_border_radius general_blue_button_size general_blue_button_background general_blue_button_no_border"><?php echo EDIT_ADDRESSES;?></button>
</center>

 </div>
   </div>
    </div>
    </div>
    
    <hr>
    
    <table id="sr_address_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
   		 </table>
   		 

    

</div>


    
<center>
   <button onclick="go_back()" type="button" class="btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border"><?php echo CONTINUE_BUTTON;?></button>
   
  </center>
  
  
  
  <div id="address_details" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        	<div class="modal-content">
        		<div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            		<h4 class="modal-title"><?php echo ADDRESS_DETAILS ;?></h4>
            	</div>
            		<div class="modal-body">
            		
            		
            		  <input type="hidden"  id="address_detail_id" name="address_detail_id" value="">
            		
            		<table>
            		<tr>
            			<td width="110px"><?php echo ADDRESS_NAME ;?></td><td></td><td width="180px"> <span id="address_name_detail"></span></td>
            		</tr>
            		</table>
            		<br>
            		
            		<table>
            		<tr>
            		
            		
            		<tr>
            			<td width="110px"><?php echo ADDRESS ;?></td><td></td><td> <span id="address_detail"></span></td>
            		</tr>
            		</table>
            		<br>
            		<table>
            		<tr>
            			<td width="110px"><?php echo DESCRIPTION ;?></td><td></td><td> <span id="address_detail_description"></span></td>
            		</tr>
            		
            		</table>
            		
            		<br>
            		
            		<center>
            		<table>
            		
            		<tr>
            		<td><?php
        	        echo '<button address_id="' . $address_id . '"  class="btn btn-default btn_detail_address_close general_blue_button_border_radius general_blue_button_size general_blue_button_background general_blue_button_no_border" style="color:white">' . CANCEL . '</button>';
        	        
        	      
        	      ?></td><td width="10px"></td><td><?php
        	       
        	       echo '<button address_id_update="' . $address_id . '"  class="btn btn-success btn_detail_address_update general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border" >' . UPDATE . '</button>';
        	      
        	      ?></td>
            		
            		</tr>
            		
            		</table>
            			</center>
            		
            	
  
            		
            		</div>
            </div>
        </div>
    </div>
    
    
<div id="edit_stored_addresses" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        	<div class="modal-content">
        		<div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            		<center>
            		<h4 class="modal-title"><?php echo EDIT_STORED_ADDRESSES ;?></h4>
            		</center>
            	</div>
            		<div class="modal-body">
            		
            		
            		<div class="form-group">
     					<label><?php echo ENTER_ADDRESS_LOCATION;?></label>
    					<div id="locationField2" >
   							<input id="autocomplete2" placeholder="<?php echo ENTER_YOUR_ADDRESS;?>"
             				onclick="geolocate2()" type="text" class="form-control text_input_radius"></input>
    					</div>
		   			</div>
		   			
		   			<div class="form-group">
  						<label for="usr"><?php echo ENTER_PROJECT_ADDRESS_NAME?></label>
  						<input type="text" class="form-control text_input_radius" id="new_address_name_modal"  name="new_address_name_modal">
					</div>
    
					<center>
						<button class="btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border" type="button" onclick="add_new_address_modal()"><?php echo STORE_LOCATION;?></button>
					</center>
		   			
		   			
		   			
            		<br>
            		
            		
            		
            		 <table id="sr_address_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
        	<thead>
        	<tr>
        	<th  bgcolor="#3E78A6" colspan="4" style="text-align:center"><font color="#FFFFFF"><?php echo DELETE_STORED_ADDRESSES;?></font></th>
        	
        	</tr>
            	<tr>
                	<th><?php echo SR_ADDRESS_NAME ;?></th>
                	<th><?php echo SR_ADDRESS ;?></th>

                	<th></th>
              		</tr>
        	</thead>
        	
        	<tbody>
        	
        	<?php
        	
		echo $stored_addresses;
        	      ?>
        	 
        	 
        	  </tbody>
        	 
   		 </table>
            		
            		
            		
            		
            		  
            		
            		</div>
            </div>
        </div>
    </div>




<script>

function edit_stored_addresses() {
   $('#edit_stored_addresses').modal('show');
}
   



var longitude = "";
var latitude = "";

      var placeSearch, autocomplete,placeSearch2, autocomplete2;
      
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };
      
       var componentForm2 = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress2);
        
        
         autocomplete2 = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete2')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete2.addListener('place_changed', fillInAddress3);
   
      
      }
      
      
      
      function fillInAddress2() {
      
      	 var place = autocomplete.getPlace();
      	 var address = place.formatted_address;
      	 
         latitude =  place.geometry.location.lat();
      	 longitude =  place.geometry.location.lng();
      
         //alert("latitude: " + latitude + " longitude: " + longitude);
      
      }
      
      function fillInAddress3() {
      
      	 var place = autocomplete2.getPlace();
      	 var address = place.formatted_address;
      	 
         latitude_3 =  place.geometry.location.lat();
      	 longitude_3 =  place.geometry.location.lng();
      
         //alert("latitude: " + latitude + " longitude: " + longitude);
      
      }


      

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
              
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
      
      function geolocate2() {
        if (navigator.geolocation) {
        
        
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete2.setBounds(circle.getBounds());
            
          });
        }
      }
    </script>
    
    
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $configs['google_map_api']; ?>&libraries=places&callback=initAutocomplete"
        async defer></script>
        
       
 



<script>

var address_missing = '<?php echo ADDRESS_MISSING; ?>';
var address_name_missing = '<?php echo ADDRESS_NAME_MISSING; ?>';

var address_delete_OK = '<?php echo ADDRESS_DELETE_OK; ?>';
var address_delete_OK_text = '<?php echo ADDRESS_DELETE_OK_TEXT; ?>';

var address_delete = '<?php echo SR_ADDRESS_DELETE; ?>';
var address_delete_text = '<?php echo SR_ADDRESS_DELETE_TEXT; ?>';

var address_saved_OK = '<?php echo ADDRESS_SAVED_OK; ?>';
var address_saved_OK_text = '<?php echo ADDRESS_SAVED_OK_TEXT; ?>';
var address_saved_OK_text_2 = '<?php echo ADDRESS_SAVED_OK_TEXT_2; ?>';

var description_missing = '<?php echo ADDRESS_DESCRIPTION_MISSING; ?>';


var sr_number = '<?php echo $sr_number; ?>';

var from = '<?php echo $_REQUEST["from"]; ?>';

var bid_id = '<?php echo $_REQUEST["bidid"]; ?>';

function go_back()
{
     if(from == "submit")
       location.href = "bid_reupdate.php?id="+bid_id;
     else 
       location.href = "bid_interested.php?id="+sr_number;
} 



function add_stored_address(){

    var description = $('#existing_address_description').val();	
	var id = $('#select_stored_address').val();
	var addr_descr=$('#existing_address_description').val();
	
	if(id > 0){
/*---------- descided descr is not required
		if(description == ""){
	
		 swal({
  			title: "Warning!",
  			text: "Please describe the service you need at this location.",
			type: "warning",
			confirmButtonText: 'OK',
			confirmButtonColor: '#E65825',
		});
		 
		 
		 exit;	
		}
*/		
	var formData = {
        'addrId'     : id,
	'descr': addr_descr,
        'action' : 'copy'
    	}
    	
    	
    	var feedback = $.ajax({
    			type: "POST",
    			url: "manageLocation.php",
    		    data: formData,
    		
    		    async: false,
    			
    		}).complete(function(){
    		
    		
    		
    		swal({
  				title: address_saved_OK,
  				text: address_saved_OK_text_2,
  				type: "success",
  				confirmButtonColor: "#E65825",
  				cancelButtonText: "No",
  				confirmButtonText: "OK",
  				closeOnConfirm: false
				},
				function(){
  					location.href = "create_new_bid_address_selection.php?from=" + from+"&bidid=" + bid_id+"&sr_number=" + sr_number;
				});
    		
				
    			}).responseText;
    	
	
	}

}

function add_new_address_modal(){
	var address = $('#autocomplete2').val();
	var name = $('#new_address_name_modal').val();	
	
	
	if(address == ""){
	
		 swal({
  			title: "Warning!",
  			text: "Please search an address.",
			type: "warning",
			confirmButtonText: 'OK',
			confirmButtonColor: '#E65825',
		});
		 exit;	
	}
	
	
	/*if(name == ""){
	
		swal({
  			title: "Warning!",
  			text: "Please enter a address name for this location",
			type: "warning",
			confirmButtonText: 'OK',
			confirmButtonColor: '#E65825',
		});
		 exit;	
	}*/
	
	
	// store address in service_request_addresses
	
	var formData = {
        'name'     : name,
        'address'     : address,
        'lat'     : latitude_3,
        'lng'     : longitude_3,
	      'type'    : 'personal',
	      'action'  : 'add'
    }
	
	
	    var feedback = $.ajax({
    			type: "POST",
    			url: "manageLocation.php",
    		    data: formData,
    		
    		    async: false,
    			
    		}).complete(function(){
    		
    		
    
    		}).responseText;
    		
    	
    	var address_stored_OK = '<?php echo ADDRESS_STORED_OK; ?>';
    		
    		
    	swal({
  				title: address_saved_OK,
  				text: address_stored_OK,
  				type: "success",
  				confirmButtonColor: "#5cb85c",
  				confirmButtonText: "OK",
  				closeOnConfirm: true
				},
				function(){
				    
  					 location.href = "create_new_bid_address_selection.php?from=" + from+"&bidid=" + bid_id+"&sr_number=" + sr_number;
				});
    		
    



}

function add_new_address()

{
		
	var address = $('#autocomplete').val();
	var name = $('#new_address_name').val();	
	var description = $('#new_address_description').val();
	var service_id = $('#service_id').val();
	if(address == ""){
	
		 swal({
  			title: "Warning!",
  			text: "Please search an address.",
			type: "warning",
			confirmButtonText: 'OK',
			confirmButtonColor: '#E65825',
		});
		 exit;	
	}
	
/*	if(name == ""){
	
		swal({
  			title: "Warning!",
  			text: "Please enter a address name for this location",
			type: "warning",
			confirmButtonText: 'OK',
			confirmButtonColor: '#E65825',
		});
		 exit;	
	}
	
	if(description == ""){
	
		swal({
  			title: "Warning!",
  			text: "Please describe the service you need at this location.",
			type: "warning",
			confirmButtonText: 'OK',
			confirmButtonColor: '#E65825',
		});
		
		exit;
	
	
	
	}*/
	
	// store address in service_request_addresses
	
	var formData = {
        'sr_number'     : service_id,
        'name'     : name,
        'address'     : address,
        'description'     : description,
        'latitude'     : latitude,
        'longitude'     : longitude
    }
    
    
     var feedback = $.ajax({
    			type: "POST",
    			url: "bid_address_add_new.php",
    		    data: formData,
    		
    		    async: false,
    			
    		}).complete(function(data){
    		
    		console.log(data);
    		/*
    		swal({
  				title: address_saved_OK,
  				text: address_saved_OK_text_2,
  				type: "success",
  				confirmButtonColor: "#5cb85c",
  				confirmButtonText: "OK",
  				closeOnConfirm: false
				},
				function(){
  					location.href = "create_new_bid_address_selection.php?sr_number=" + sr_number;
				});
    		*/
    		
    		
    		
				
    			}).responseText;
    			
    			 var address_id = feedback;
    			 
    			 swal({
  				title: address_saved_OK,
  				text: address_saved_OK_text,
  				type: "success",
  				showCancelButton: true,
  				confirmButtonColor: "#E65825",
  				confirmButtonText: "Yes",
  				cancelButtonText: "No",
  				closeOnConfirm: false,
                closeOnCancel: false
  			
				},
				function(isConfirm){
  				if (isConfirm) {
  				    stored_address_during_add_address(address_id, formData);
    				
    				//location.href = "create_new_bid_address_selection.php?sr_number=" + sr_number;
  				
  				} else {
    			location.href = "create_new_bid_address_selection.php?from=" + from+"&bidid=" + bid_id+"&sr_number=" + sr_number;
  				
  				}

				});

  
	
} 


function add_current_address()

{
		
	var address = $('#curent_address').val();
	var name = $('#current_address_name').val();	
	var description = $('#current_address_description').val();
	
	if(address == ""){
	
		swal({
  			title: "Warning!",
  			text: "Please enter a address name for this location",
			type: "warning",
			confirmButtonText: 'OK',
			confirmButtonColor: '#E65825',
		});
		// exit;	
	}
	
	/*if(name == ""){
	
		swal({
  			title: "Warning!",
  			text: "Please enter a address name for this location",
			type: "warning",
			confirmButtonText: 'OK',
			confirmButtonColor: '#E65825',
		});
		 exit;	
	}
	
	if(description == ""){
	
		swal({
  			title: "Warning!",
  			text: "Please describe the service you need at this location.",
			type: "warning",
			confirmButtonText: 'OK',
			confirmButtonColor: '#E65825',
		});
		
		exit;
	
	
	
	}*/
	
	// store address in service_request_addresses
	
	var formData = {
        'sr_number'     : sr_number,
        'name'     : name,
        'address'     : address,
        'description'     : description,
        'latitude'     : current_latitude,
        'longitude'     : current_longitude
    }
    
    
     var feedback = $.ajax({
    			type: "POST",
    			url: "bid_address_add_new.php",
    		    data: formData,
    		
    		    async: false,
    			
    		}).complete(function(){
    		
    		
    		

  		     }).responseText;
  		     
  		  
  		     var address_id = feedback;
  		     
  		     swal({
  				title: address_saved_OK,
  				text: address_saved_OK_text,
  				type: "success",
  				showCancelButton: true,
  				confirmButtonColor: "#E65825",
  				confirmButtonText: "Yes",
  				cancelButtonText: "No",
  				closeOnConfirm: false,
                closeOnCancel: false
  			
				},
				function(isConfirm){
  				if (isConfirm) {
  				    stored_address_during_add_address(address_id,formData);
    				
    				//location.href = "create_new_bid_address_selection.php?sr_number=" + sr_number;
  				
  				} else {
    			location.href = "create_new_bid_address_selection.php?from=" + from+"&bidid=" + bid_id+"&sr_number=" + sr_number;
  				
  				}

				});

} 




$(document).on("click", ".btn_detail_address_update", function(e) {

    var address_id =  $('#address_detail_id').val();
    
    var name =  $('#address_name_detail_text').val();
    var address =  $('#address_detail_text').val();
    var description =  $('#address_detail_description_text').val();
    
    
    var address_update_ok = '<?php echo ADDRESS_UPDATE_OK; ?>';
    var address_update_ok_text = '<?php echo ADDRESS_UPDATE_OK_TEXT; ?>';
    
    
    var formData = {
        'address_id'    : address_id,
        'name'    : name,
        'address'    : address,
        'description'    : description
       
    }
    	
  	var feedback = $.ajax({
    			type: "POST",
    			url: "service_request_address_update.php",
    		    data: formData,
    		
    		    async: false,
    			
    }).complete(function(){
    
       swal({
  					title: address_update_ok,
 					text: address_update_ok_text,
  					type: "success",
  					showCancelButton: false,
  					confirmButtonColor: "#E65825",
  					confirmButtonText: "OK",
  					closeOnConfirm: false
				},
				function(){
				
				location.href = "create_new_bid_address_selection.php?from=" + from+"&bidid=" + bid_id+"&sr_number=" + sr_number;
  
				});
        				
   
    }).responseText;
    
    
   
    
    
   



});

$(document).on("click", ".btn_detail_address_close", function(e) {

	$('#address_details').modal('hide');
	
	


});




$(document).on("click", ".stored_address_info", function(e) {

    var address_id = ($(this).attr('stored_address_info_id'));
    
    
    var formData = {
        'address_id'    : address_id
       
    	}
    	
  var feedback = $.ajax({
    			type: "POST",
    			url: "service_request_address_details.php",
    		    data: formData,
    		
    		    async: false,
    			
    }).complete(function(){
        				
    }).responseText;
        				
   var split_address = feedback;
  
   var split_address=JSON.parse(split_address);
 
   var address_name = split_address['title'];
   var address = split_address['address'];
   var address_description = split_address['descr'];
  		
    $('#address_detail_id').val(address_id);
    
 	$('#address_name_detail').html("<input type='text' id='address_name_detail_text' class='form-control text_input_radius'  value='" +  address_name + "'>");
	$('#address_detail').html("<textarea id='address_detail_text' class='form-control text_input_radius' rows='5' readonly>" + address + "</textarea>");
	$('#address_detail_description').html("<textarea  id='address_detail_description_text' class='form-control text_input_radius' rows='5' >" + address_description + "</textarea>");

	$('#address_details').modal('show');

});


function stored_address_during_add_address(address_id, formD){


	var account_id =  '<?php echo $account_id; ?>';
  
 	var store_address_confirm = '<?php echo SR_ADDRESS_STORE_CONFIRM; ?>';
  	var store_address_confirm_text = '<?php echo SR_ADDRESS_STORE_CONFIRM_TEXT; ?>';
    
    var store_address_success = '<?php echo SR_ADDRESS_STORE_SUCCESS; ?>';
    var store_address_success_text = '<?php echo SR_ADDRESS_STORE_SUCCESS_TEXT; ?>';
    
/*
        'name'     : name,
        'address'     : address,
        'description'     : description,
        'latitude'     : latitude,
        'longitude'     : longitude


*/
 
    var formData = {
	'name'	: formD['name'],
	'description'	: formD['description'],
	'address'	: formD['address'],
	'posLong'	: formD['longitude'],
	'posLat'	: formD['latitude']
    	}
    	  
 
    var feedback = $.ajax({
    	type: "POST",
    	url: "service_request_address_store.php",
    	data: formData,
    		
    	async: false,
    			
    }).complete(function(){
    		
    	swal({
  			title: store_address_success,
 			text: store_address_success_text,
  			type: "success",
  			showCancelButton: false,
  			confirmButtonColor: "#5CB85C",
  			confirmButtonText: "OK",
  			closeOnConfirm: false
			},
				
			function(){
				location.href = "create_new_bid_address_selection.php?from=" + from+"&bidid=" + bid_id+"&sr_number=" + sr_number;
  
		});
    		 		
    		
    });
  	
}



$(document).on("click", ".stored_address", function(e) {

	var address_id = ($(this).attr('address_id_store'));
	
	var account_id =  '<?php echo $account_id; ?>';


	
	
	var store_address_confirm = '<?php echo SR_ADDRESS_STORE_CONFIRM; ?>';
    var store_address_confirm_text = '<?php echo SR_ADDRESS_STORE_CONFIRM_TEXT; ?>';
    
    var store_address_success = '<?php echo SR_ADDRESS_STORE_SUCCESS; ?>';
    var store_address_success_text = '<?php echo SR_ADDRESS_STORE_SUCCESS_TEXT; ?>';
	
	swal({
  		title: store_address_confirm,
  		text: store_address_confirm_text,
  		type: "warning",
  		showCancelButton: true,
  		confirmButtonColor: "#DD6B55",
  		confirmButtonText: "Yes, store it!",
  		closeOnConfirm: false
	},
	function(){
  		
  		var formData = {
        'address_id'    : address_id,
        'account_id'	: account_id
       
    	}
    	  
    
    	
    	   var feedback = $.ajax({
    			type: "POST",
    			url: "service_request_address_store.php",
    		    data: formData,
    		
    		    async: false,
    			
    		}).complete(function(){
    		
    		
    			swal({
  					title: store_address_success,
 					text: store_address_success_text,
  					type: "success",
  					showCancelButton: false,
  					confirmButtonColor: "#5CB85C",
  					confirmButtonText: "OK",
  					closeOnConfirm: false
				},
				function(){
				
			
				location.href = "create_new_bid_address_selection.php?from=" + from+"&bidid=" + bid_id+"&sr_number=" + sr_number;
  
				});
    		
    		
    		
    		});
  	
	
	
	});



});






$(document).on("click", ".delete_stored_address", function(e) {

    var address_delete_success = '<?php echo SR_ADDRESS_DELETE_SUCCESS; ?>';
    var address_delete_success_text = '<?php echo SR_ADDRESS_DELETE_SUCCESS_TEXT; ?>';

	var address_id = ($(this).attr('address_id'));
	
	swal({
  		title: address_delete,
  		text: address_delete_text,
  		type: "warning",
  		showCancelButton: true,
  		confirmButtonColor: "#E65825",
  		confirmButtonText: "Yes, delete it!",
  		cancelButtonColor: "#FFFFFF",
  		cancelButtonText: "No",
  		closeOnConfirm: false
	},
	function(){
  		
  		var formData = {
        'addrId'     : address_id,
        'action'  : 'del'
    	}
    	
    	   var feedback = $.ajax({
    			type: "POST",
    			url: "manageLocation.php",
    		    data: formData,
    		
    		    async: false,
    			
    		}).complete(function(){
    		
    		
    			swal({
  					title: address_delete_success,
 					text: address_delete_success_text,
  					type: "success",
  					showCancelButton: false,
  					confirmButtonColor: "#5CB85C",
  					confirmButtonText: "OK",
  					closeOnConfirm: false
				},
				function(){
				
				location.href = "create_new_bid_address_selection.php?from=" + from+"&bidid=" + bid_id+"&sr_number=" + sr_number;
  
				});
    		
    		
    		
    		});
  		
  		
  		
	
	
	
	
	});


});


$(document).on("click", ".delete_address", function(e) {

    var address_delete_success = '<?php echo SR_ADDRESS_DELETE_SUCCESS; ?>';
    var address_delete_success_text = '<?php echo SR_ADDRESS_DELETE_SUCCESS_TEXT; ?>';

	var address_id = ($(this).attr('address_id'));
	
	 var stored_delete_confirm = '<?php echo STORED_ADDRESS_DELETE_CONFIRM; ?>';
	 var stored_delete_success = '<?php echo STORED_ADDRESS_DELETE_SUCESS; ?>';
	 
	 
	
	swal({
  		title: address_delete,
  		text: stored_delete_confirm,
  		type: "warning",
  		showCancelButton: true,
  		confirmButtonColor: "#E65825",
  		confirmButtonText: "Yes, delete it!",
  		cancelButtonColor: "#FFFFFF",
  		cancelButtonText: "No",
  		closeOnConfirm: false
	},
	function(){
  		
  		var formData = {
        'addrId'     : address_id,
      	'action': 'del' 
    	}
    	
    	   var feedback = $.ajax({
    			type: "POST",
    			url: "manageLocation.php",
    		    data: formData,
    		
    		    async: false,
    			
    		}).complete(function(){
    		
    		
    			swal({
  					title: address_delete_success,
 					text: stored_delete_success,
  					type: "success",
  					showCancelButton: false,
  					confirmButtonColor: "#5CB85C",
  					confirmButtonText: "OK",
  					closeOnConfirm: false
				},
				function(){
				
				location.href = "create_new_bid_address_selection.php?from=" + from+"&bidid=" + bid_id+"&sr_number=" + sr_number;
  
				});
    		
    		
    		
    		});
  		
  		
  		
	
	
	
	
	});


});

</script>

<script>




    var googlePos = "";
    var googleMap = "";
    var googleMarker = "";
    var geoCircle ="";
	var watchId = null;
	
	var current_longitude = "";
	var current_latitude = "";
	var current_address = "";
	
	function geoloc() {
	
	
	if (navigator.geolocation) {
		var optn = {
				enableHighAccuracy : true,
				timeout : 3000,
				maximumAge : Infinity
		};
	//watchId = navigator.geolocation.watchPosition(showPosition, showError, optn);
	
	watchId = navigator.geolocation.getCurrentPosition(showPosition, showError, optn);
	
	
	
	} else {
			alert('Geolocation is not supported in your browser');
	}
	}
	
	 

function showPosition(position) {
     
     
       console.log(position); 
       
		
		googlePos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		
	    
	    current_longitude = position.coords.longitude;
		current_latitude = position.coords.latitude;
		
		var actual_latlng = {lat: parseFloat(current_latitude), lng: parseFloat(current_longitude)};
		
		var geocoder = new google.maps.Geocoder();
		
		geocoder.geocode({'location': actual_latlng}, function(results, status) {
 				 

                 var jsonConvertedData = JSON.stringify(results);
                 
                 //alert(jsonConvertedData);
                  
                 current_address = results[0].formatted_address;
                 
               
                 
                 $("#curent_address").val(current_address);
 			
 				 
 				 });
	

		
		var mapOptions = {
			zoom : 16,
			center : googlePos,
			zoomControl: true,
			disableDefaultUI: true,
			mapTypeId : google.maps.MapTypeId.ROADMAP,
			styles:
	[
  {
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#ebe3cd"
      }
    ]
  },
  {
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#523735"
      }
    ]
  },
  {
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#f5f1e6"
      }
    ]
  },
  {
    "featureType": "administrative",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#c9b2a6"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "visibility": "simplified"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "visibility": "on"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#ae9e90"
      }
    ]
  },
  {
    "featureType": "landscape.man_made",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#e6e6e6"
      }
    ]
  },
  {
    "featureType": "landscape.natural",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "landscape.natural.landcover",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#93817c"
      }
    ]
  },
  {
    "featureType": "poi.attraction",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi.business",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi.government",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi.medical",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#a5b076"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#447530"
      }
    ]
  },
  {
    "featureType": "poi.place_of_worship",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi.school",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "poi.sports_complex",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#f5f1e6"
      }
    ]
  },
  {
    "featureType": "road.arterial",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#fdfcf8"
      }
    ]
  },
  {
    "featureType": "road.arterial",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#3E78A6"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#f8c967"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#3E78A6"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#e9bc62"
      }
    ]
  },
  {
    "featureType": "road.highway.controlled_access",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#e98d58"
      }
    ]
  },
  {
    "featureType": "road.highway.controlled_access",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#3E78A6"
      }
    ]
  },
  {
    "featureType": "road.highway.controlled_access",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#db8555"
      }
    ]
  },
  {
    "featureType": "road.local",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#ffffff"
      }
    ]
  },
  {
    "featureType": "road.local",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#806b63"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "stylers": [
      {
        "visibility": "on"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#8f7d77"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#ebe3cd"
      }
    ]
  },
  {
    "featureType": "transit.station",
    "stylers": [
      {
        "visibility": "off"
      }
    ]
  },
  {
    "featureType": "transit.station",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#b9d3c2"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#92998d"
      }
    ]
  }
]
			
			
			
		};
		
		var mapObj = document.getElementById('mapdiv');
		
		googleMap = new google.maps.Map(mapObj, mapOptions);
		
		var pinColor = "E65825";
        var pinImage = new google.maps.MarkerImage("https://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
        new google.maps.Size(21, 34),
        new google.maps.Point(0,0),
        new google.maps.Point(10, 34));
		
		var markerOpt = {
			map : googleMap,
			position : googlePos,
			fontWeight: 'bold',
			label: 
			{
    text: 'You are here. Drag to change..',
    color: '#E65825',
    fontWeight: "bold"
  },
			
	
			icon: {
			url: "img/map_marker.svg",
			scaledSize: new google.maps.Size(45, 45),
			labelOrigin: new google.maps.Point(5, -10)
		},
			draggable:true,
			animation : google.maps.Animation.DROP
		};
		
		googleMarker = new google.maps.Marker(markerOpt);
		
		
		
		
		
		google.maps.event.addListener(googleMarker, 'dragend', function(evt){

 				//alert("New Latitute: " + evt.latLng.lat());
 				//alert("New Longitude: " + evt.latLng.lng());
 				
 				current_longitude = evt.latLng.lng();
				current_latitude = evt.latLng.lat();
		
 				
 				var latlng = {lat: parseFloat(evt.latLng.lat()), lng: parseFloat(evt.latLng.lng())};
 				
 				 geocoder.geocode({'location': latlng}, function(results, status) {
 				 

                 var jsonConvertedData = JSON.stringify(results);
                 
                 //alert(jsonConvertedData);
                  
                 current_address = results[0].formatted_address;
                 
                 
                 $("#curent_address").val(current_address);
                 
                
 			
 				 
 				 });

			});
		
		  	

 
    
//}
		
	
		
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({
			'latLng' : googlePos
			}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
				if (results[1]) {
					var popOpts = {
						content : results[1].formatted_address,
						position : googlePos
					};
				var popup = new google.maps.InfoWindow(popOpts);
				google.maps.event.addListener(googleMarker, 'click', function() {
				popup.open(googleMap);
			});
				} else {
					alert('No results found');
				}
				} else {
					alert('Geocoder failed due to: ' + status);
				}
			});
			}


			

		function showError(error) {
		var err = document.getElementById('mapdiv');
		switch(error.code) {
		case error.PERMISSION_DENIED:
		err.innerHTML = "User denied the request for Geolocation."
		break;
		case error.POSITION_UNAVAILABLE:
		err.innerHTML = "Location information is unavailable."
		break;
		case error.TIMEOUT:
		//err.innerHTML = "The request to get user location timed out."
		    $.get("https://ipinfo.io", function(response) {
  					console.log("ipinfo get response: "+response.loc+ ", "+response.country);
					var loc = response.loc.split(',');
  					var pos = {coords : {
        							latitude: loc[0],
        							longitude: loc[1]}};
        			showPosition(pos);
				}, "jsonp");

		break;
		case error.UNKNOWN_ERROR:
		err.innerHTML = "An unknown error occurred."
		break;
		}
		}
		
		
		

		
</script>

<script>


var l_m = "<?php echo DISPLAY_X_RECORDS; ?>";
var info = "<?php echo DISPLAY_PAGE_X_FROM_X; ?>";
var next = "<?php echo DISPLAY_NEXT; ?>";
var previous = "<?php echo DISPLAY_PREVIOUS; ?>";
var search = "<?php echo DISPLAY_SEARCH; ?>";
var no_records = "<?php echo DISPLAY_NO_RECORDS; ?>";
var filtered = "<?php echo DISPLAY_FILTERED; ?>";
var display_nothing = "<?php echo DISPLAY_NO_ADDRESS_SELECTED; ?>";
var display_first = "<?php echo DISPLAY_FIRST; ?>";
var display_last = "<?php echo DISPLAY_LAST; ?>";


$(document).ready(function() {


    geoloc();
    $('#sr_address_list').dataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false,
         "dom": 'lrtip',
       
      
        "language": {
            "lengthMenu": l_m,
            "search":         search,
            "zeroRecords": display_nothing,
            "info": info,
            "paginate": {
        		"first":      display_first,
        		"last":       display_last,
       		    "next":       next,
                "previous":   previous
   			 },
            "infoEmpty": no_records,
            "infoFiltered": filtered
        }
    } );
} );


 $('#accordion').on('hidden.bs.collapse', function () {
     
      geoloc();
    })
    $('#accordion').on('shown.bs.collapse', function () {
   
      geoloc(); 
    })
     

</script>
