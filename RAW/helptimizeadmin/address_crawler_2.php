<?php


?>

<script
  src="https://code.jquery.com/jquery-1.12.4.min.js"
  integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
  crossorigin="anonymous"></script>


<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>





  <style>
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
	height: 400px;
}
      
    </style>
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
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
  <input type="text" class="form-control" id="longitude"  name="longitude">
  
  </div>
  
  <div class="col-md-2">
  
  <label for="usr">Latitude</label>
  <input type="text" class="form-control" id="latitude"  name="latitude">
  
  </div>
  </div>




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
  
  <button class="btn btn-primary" type="button" onclick="crawl_address()">Crawl Addresse</button>
 

  
</div>  
  
 <p id = 'map'></p>


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
	watchId = navigator.geolocation.watchPosition(showPosition, showError, optn);
	
	} else {
			alert('Geolocation is not supported in your browser');
	}
}


function showPosition(position) {

       
       
       //googlePos = new google.maps.LatLng(-122.4217528,47.5823731);
		
	   googlePos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		

	
	    
	    //current_longitude = position.coords.longitude;
		//current_latitude = position.coords.latitude;
		
		current_longitude = '-122.32321916962889';
		current_latitude =  '47.600664829092715';
		
		
		
		
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
			center : {lat: 47.600664829092715, lng: -122.32321916962889},
			disableDefaultUI: true,
			mapTypeId : google.maps.MapTypeId.ROADMAP
		};
		
		var mapObj = document.getElementById('mapdiv');
		
		googleMap = new google.maps.Map(mapObj, mapOptions);
		
		var markerOpt = {
			map : googleMap,
			position : {lat: 47.600664829092715, lng: -122.32321916962889},
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


    
    geoloc();
    
    

</script>


<script>

function crawl_address(){


  var keyword = $('#keyword').val();
  var range = $('#range').val();
  var longitude = $('#longitude').val();
  var latitude = $('#latitude').val();
  

  
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
  
    

  
  	if (status == google.maps.places.PlacesServiceStatus.OK) {
  	
  		console.log(results);
  		
  		var name = results.name;
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
        	'longitude'     : longitude  	
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
   
       //console.log(place);
    }
  }
  
  
  

}
  
  
  


}
	
</script>	
	
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCObfRwjqHg1e5v62Pms3sUbipXKdzN9I4&libraries=places"></script>
	
	