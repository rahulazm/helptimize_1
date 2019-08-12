<?php

$configs = include("/etc/helptimize/conf.php");
$username = $configs["username"];
$password = $configs["password"];
$host = $configs["host"];
$db_name = $configs["db_name"];


// get all categories

$db_get_service_categories = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_service_categories ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_service_categories ->connect_error . ']');
}

$sql_get_service_categories = "SELECT * FROM main_categories";

$result_get_service_categories = $db_get_service_categories->query($sql_get_service_categories);

$db_get_service_categories->close();



// get pipedrive API  

$db_get_pipedrive_settings = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_pipedrive_settings ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_pipedrive_settings ->connect_error . ']');
}

$sql_get_pipedrive_settings = "SELECT value FROM admin_settings WHERE keyword ='pipedrive_api_token'";

$result_get_pipedrive_settings = $db_get_pipedrive_settings->query($sql_get_pipedrive_settings);

$row_value = $result_get_pipedrive_settings->fetch_assoc();

$db_get_pipedrive_settings->close();

$pipedrive_api_token = $row_value['value'];


$url = "https://api.pipedrive.com/v1/users?api_token=" . $pipedrive_api_token;
 
 	$ch = curl_init();
 	curl_setopt($ch, CURLOPT_URL, $url);
 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 	curl_setopt($ch, CURLOPT_POST, false);
 	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
 	curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
 	$output = curl_exec($ch);
	curl_close($ch);
	$pipedrive_result_user = json_decode($output, 1);




include "menu.php";


	
	

?>


<style>
.loader {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

    
     <div style="margin:10px">
<h3>Helptimize Address Crawler</h3>

<p id = 'mapdiv'></p>


 
 <div class="row">
  <div class="col-md-4">
  
   <div class="form-group">
  <label for="usr">Location</label>
  <input type="text" class="form-control" id="curent_address"  readonly name="curent_address">
  </div>
  
  </div>
  <div class="col-md-4"></div>
  <div class="col-md-4"></div>
</div>


 <div class="row">
  <div class="col-md-2">
  
  <label for="usr">Longitute</label>
  <input type="text" class="form-control" id="longitude"  readonly name="longitude">
  
  </div>
  
  <div class="col-md-2">
  
  <label for="usr">Latitude</label>
  <input type="text" class="form-control" id="latitude"  readonly name="latitude">
  
  </div>
  </div>

<br>


 <div class="row">
  <div class="col-md-2">
  
  <label for="usr">Keyword Search</label>
  <input type="text" class="form-control" id="keyword"  name="keyword">
  
  </div>
  
  <div class="col-md-2">
  
  <label for="usr">KM Range</label>
  <input type="text" class="form-control" id="range"  name="range">
  
  </div>
  </div>
  <br>
  
  <div class="row">
  <div class="col-md-4">
  
    <div class="form-group">
    <label>Lead Category</label>
    <select class="form-control" id="project_category" name="project_category">
    		<?php
    		echo "<option value='nothing'>Please select a category.....</option>";
    		while ($row = $result_get_service_categories->fetch_assoc()) {
    		
    		    
				
				if($category == $row['id']){
				
				echo "<option value=" . $row ['id'] . " selected='selected'>" . $row ['name'] . "</option>";
				
				}else{
				echo "<option value=" . $row ['id'] . ">" . $row ['name'] . "</option>";
				
				}
			
			
			}
 			?>
    		</select>
  </div>
  
  
   <div class="form-group">
    <label>Sub Category</label>
    <select class="form-control" id="sub_project_category" name="sub_project_category">
    
    <select>
    </div>
    
    
    <div class="form-group">
    <label>Assign to Pipedrive user</label>
    <select class="form-control" id="pipedrive_user" name="pipedrive_user">
    
      <?php
       				
       				foreach($pipedrive_result_user as $item) { 
   						$i = 0;
    
    					foreach($item as $user){
    					
    					    echo "<option value='" . $user['id']   . "'>" . $user['name']  . "</option>";

		 				}
					}
       				
       				
       				?>
    
    
    
    <select>
    </div>
  
  
  
  </div>
  <div class="col-md-4"></div>
  <div class="col-md-4"></div>
</div>
  
  
  
  
  
  
  <button class="btn btn-success" type="button" onclick="crawl_address()">Crawl Addresse</button>
 

  
</div>  
  
 <p id = 'map'></p>
 
 
 <div id="spinner" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        	<div class="modal-content">
        		<div class="modal-header">
            		
            		<h4 class="modal-title" style="color:#000000";><center>Pipedrive</center></h4>
            	</div>
            		<div class="modal-body">
            		
            	<center>
            		
            		<div class="loader"></div>
            		<h3>Crawling leads....</h3>
            		
            	</center>

   		
            		</div>
            </div>
        </div>
    </div>


<script>

var current_longitude = "";
var current_latitude = "";
var current_address = "";


function geoloc() {
	
	
	if (navigator.geolocation) {
		var optn = {
				enableHighAccuracy : true,
				timeout : Infinity,
				maximumAge : 0
		};
	watchId = navigator.geolocation.getCurrentPosition(showPosition, showError, optn);
	
	} else {
			alert('Geolocation is not supported in your browser');
	}
}


function showPosition(position) {

       
       
       //googlePos = new google.maps.LatLng(-122.4217528,47.5823731);
		
	   googlePos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		

	
	    
	    //current_longitude = position.coords.longitude;
		//current_latitude = position.coords.latitude;
		
		//51.5287352,-0.3817852
		
		current_longitude = '-73.98881034648434';
		current_latitude =  '40.748189059882236';
		
		
		
		
		var actual_latlng = {lat: parseFloat(current_latitude), lng: parseFloat(current_longitude)};
		
		var geocoder = new google.maps.Geocoder();
		
		geocoder.geocode({'location': actual_latlng}, function(results, status) {
 				 

                 var jsonConvertedData = JSON.stringify(results);
                 
                 //alert(jsonConvertedData);
                  
                 current_address = results[0].formatted_address;
                 
               
                $("#longitude").val(current_longitude);
                $("#latitude").val(current_latitude);
                 
                 $("#curent_address").val(current_address);
 			
 				 
 				 });
		
		
		
		var mapOptions = {
			zoom : 14,
			center : {lat: 40.748189059882236, lng: -73.98881034648434},
			disableDefaultUI: false,
			mapTypeId : google.maps.MapTypeId.ROADMAP
		};
		
		var mapObj = document.getElementById('mapdiv');
		
		googleMap = new google.maps.Map(mapObj, mapOptions);
		
		var markerOpt = {
			map : googleMap,
			position : {lat:  40.748189059882236, lng: -73.98881034648434},
			title : 'You are here',
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
                  
                 var current_address = results[0].formatted_address;
                 
            
                 
                  $("#longitude").val(current_longitude);
                $("#latitude").val(current_latitude);
                 $("#curent_address").val(current_address);
                 
 			
 				 
 				 });

			});

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
		err.innerHTML = "The request to get user location timed out."
		break;
		case error.UNKNOWN_ERROR:
		err.innerHTML = "An unknown error occurred."
		break;
		}
		}


</script>

<script>

function myMap() {
var mapProp= {
    center:new google.maps.LatLng(40.748189059882236,-73.98881034648434),
    zoom:5,
};
var map=new google.maps.Map(document.getElementById("mapdiv"),mapProp);
}


</script>

	
<script>


    
geoloc();
    
    

</script>


<script>

function crawl_address(){


   // check if keyword and range was entered
   
   
   var keyword = $("#keyword").val();
   var range = $("#range").val();
   
   if(keyword == ""){
   
   		sweetAlert("Oops...", "Please key in keyword", "error");
   
   
   return;
   
   
   }
   
   if(range == ""){
   
  sweetAlert("Oops...", "Please key in a range in KM", "error");
   
   
   return;
   
   
   }
   
   
   
   


  $('#spinner').modal('show');


  var keyword = $('#keyword').val();
  var range = $('#range').val();
  var longitude = $('#longitude').val();
  var latitude = $('#latitude').val();
  
  range = range * 1000;
  
  var map;
  var service;
  var infowindow;
  

  
  var pyrmont = new google.maps.LatLng(latitude,longitude);
  
  

  map = new google.maps.Map(document.getElementById('mapdiv'), {
      center: pyrmont,
      zoom: 15
    });


  var request = {
    location: pyrmont,
    radius: range,
    query: keyword
  };
  
 

  service = new google.maps.places.PlacesService(map);
  service.textSearch(request, callback);
  
  
  function callback_2(results, status) {
  
     //alert("count");
  
  	if (status == google.maps.places.PlacesServiceStatus.OK) {
  	
  		var category = $("#project_category").val();
  		var sub_category = $("#sub_project_category").val();
  		var pipedrive_user = $("#pipedrive_user").val();
  
    
  		if (results.name != null){
  		var name = results.name;
  		}
  		var formatted_address = results.formatted_address;
  		var formatted_phone_number = results.formatted_phone_number;
  		var place_id = results.place_id;
  		var website = results.website;

  	
  		var latitude = $("#latitude").val();
  		var longitude =  $("#longitude").val();
  		
  		
  		var formData = {
        	'name'     : name,
        	'formatted_address'     : formatted_address,
        	'formatted_phone_number'     : formatted_phone_number,
        	'place_id'     : place_id,
        	'website'     : website,
        	'latitude'     : latitude,
        	'longitude'     : longitude,
        	'category'     : category,
        	'sub_category'     : sub_category,
        	'pipedrive_user'     : pipedrive_user
  		
        }
        
        var feedback = $.ajax({
    			type: "POST",
    			url: "backend_insert_potential_service_provider.php",
    		    data: formData,
    		
    		    async: false,
    			
    	}).complete(function(){
        				
    	}).responseText;
  		
  		
  
  	}
  
  
  }
  
function callback(results, status) {

  
  var counter = 0;
   

  if (status == google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
    
    	var place = results[i];
      	var address = place.formatted_address;
      	var place_id = place.place_id;
      
      	// check if placeid exist in db
      
      	var formData = {
        	'place_id'     : place_id
      	}
      
    	var feedback = $.ajax({
    			type: "POST",
    			url: "backend_check_if_pace_id_exist.php",
    		    data: formData,
    		
    		    async: false,
    			
    	}).complete(function(){
        				
    	}).responseText;
    	
    	
     
    
    	if(feedback == "0"){
        			
			var request = {
  			placeId: place_id
	  		};

	  		service = new google.maps.places.PlacesService(map);
	  		service.getDetails(request, callback_2);
	  	
	  	
	  	}
      
      counter = counter + 1;
       
    }
    
// sweet alert

$('#spinner').modal('hide');


swal({
  title: "Success",
  text: "Leads where crawled",
  type: "success",
  showCancelButton: false,
  confirmButtonColor: "#007E33",
  confirmButtonText: "OK",
  closeOnConfirm: false
},
function(){

	location.reload();

  
});
 


  
  }
  
  
   


}
  
  
     
 

}

$("#project_category").change(function() {

     $("#sub_project_category option").remove();

	 var category_id = $("#project_category").val();
	 
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
    	
    		$.each(obj, function(key,value){    
    		
    		  	var id = value.id;
    		  	var category_id = value.id;
    		  	var sub_category_name = value.name;
    		  	
    		  	
    		  	$('#sub_project_category').append($('<option>', { 
        			value: value.id,
       				 text : value.name 
    			}));
    		  	
    		  	

    		
    		});
    		
    		
    	}


});
	
</script>	
	
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCObfRwjqHg1e5v62Pms3sUbipXKdzN9I4&libraries=places"></script>
	
	