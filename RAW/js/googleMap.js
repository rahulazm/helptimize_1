/*-----------------
because of how unique (and finicky) javascript is, this is what's needed to include it into a page

for initing position
<script>
var gLat=-34.397;
var gLng=150.644;
</script>

includes this script
<script src="js/googleMap.js"></script>

providing key ad runs init
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMU6SOKe_BeAfS8hopKSBNlTp5etaAwZA&callback=initMap" async defer></script>

html element to draw map
    <div id="map"></div>
-------------------*/
var baseurl="http://localhost/helptimize_app/helptimize/";
var symbols=[];
symbols['locksmith']=baseurl+"svg/round-https-24px.svg";
symbols['driver']=baseurl+"svg/round-time_to_leave-24px.svg";
symbols['bakery']=baseurl+"svg/round-cake-24px.svg";
symbols['dog_walker']=baseurl+"svg/round-pets-24px.svg";
symbols['baby_sit']=baseurl+"svg/round-child_friendly-24px.svg";
symbols['other']=baseurl+"svg/round-more-24px.svg";
var urhere="You are here";
var defZoom=15;
var maxZoom=21;
var minZoom=0;
var lat=47.6062;
var lng=-122.3321;
var mapDivW=1000;
var mapDivH=420;
var cId=0; //categ Id

var markers={}; //an array of markers to go back to 

//basic map setup
var map;
var geocoder;

      function initMap() {
      	
	if(isNaN(gLat) || isNaN(gLng)){
	gLat=0;
	gLong=0;

	}

	cId;// remember that it's getting cId from the page calling these functions
	mapDivW; //these too
	mapDivH; //these too
		
        map = new google.maps.Map(document.getElementById('googleMap'), {
          center: {lat: gLat, lng: gLng},
          zoom: defZoom
        });
        //////Create sr page after add the address, corresponding address is marked
		var Lat = localStorage.getItem("latitude_address"); 
		var Lng = localStorage.getItem("longitude_address"); 

		console.log("Lat: "+Lat);
		console.log("Lng: "+lng);
		console.log("Cat ID: "+cId);
		//if(localStorage.getItem("latitude_address") && cId == 0)
		if(localStorage.getItem("latitude_address") != "")
		{		
			 newMark(parseFloat(gLat), parseFloat(gLng), urhere,'', '');
			 centerMap(parseFloat(gLat), parseFloat(gLng));
		}
		else		
			getPos();
	
	// what to do if map zoom is changed	
	google.maps.event.addListener(map, 'zoom_changed',(function(){
	console.log("map resized: " + map.getZoom());
	
	populateMap(map);
	}));

	google.maps.event.addListener(map, 'dragend',(function(){
	console.log("map dragged: "+map.getCenter().lat()+", "+map.getCenter().lng());
	lat=map.getCenter().lat();
	lng=map.getCenter().lng();
	populateMap(map);	
	}));

      }

	//adds markers to the map
        function newMark(lat, lng, title, icn, lbl){
	if(title in markers){
	return null;
	}

	var markD={
		  position: {lat: lat, lng: lng},
		  map: map,
		  title: title
                  }

		//sets the icon marker
		if(icn in symbols){
			var icon = {
		                labelOrigin: new google.maps.Point(12, -12),
				url: symbols[icn]
			}
		markD['icon']=icon;

			// sets the label		
			if(typeof lbl === 'string' || lbl instanceof String){
			markD['label']={
				color: '#EA4335',
				text: lbl
				};
			}
		}

		var marker = new google.maps.Marker(markD);

	markers[title]=marker;
	markers[title].addListener('click', function() {
                map.setCenter(this.getPosition());
                alert("centering to "+this.title);
                });

        return marker;
        }


	//centers the map on the coordinates
	function centerMap(lat, lng, zm){
	map.setCenter({lat:lat, lng:lng});
	var zoom=zm;
		if(isNaN(zm) || zm<=minZoom || zm>=maxZoom){
		zoom=defZoom;
		}
	map.setZoom(zoom);	
	}

	//deletes marker from map 
	//if elNm is null, deletes all markers,
	//if excp is given, all but elNm is deleted.
	function delMark(elNm, excp){
		if(elNm == null){
			for(var key in markers){
			markers[key].setMap(null);
			delete markers[key];
			}
		return 0;
		}
		
		if(excp){
			for(var key in markers){
				if(key!=elNm){
				markers[key].setMap(null);
				delete markers[key];
				}
			}
		return 0;
		}


		if(elNm in markers){
		markers[elNm].setMap(null);
		delete markers[elNm];
		}
	}

	//get postion of user and center map on that position. 
	function getPos(){

		if(!navigator.geolocation || navigator.geolocation=='undefined'){
		//swal("Location sharing not available on your device/computer/browser.");
			$.get("https://ipinfo.io", function(response) {
  					console.log("ipinfo get response: "+response.loc+ ", "+response.country);
					var loc = response.loc.split(',');
  					var pos = {coords : {
        							latitude: loc[0],
        							longitude: loc[1]}};
        			newMark(parseFloat(pos.coords.latitude), parseFloat(pos.coords.longitude), urhere,'', '');
				  lat=pos.coords.latitude;
				  lng=pos.coords.longitude;
				 // alert(lat);
				  console.log('User coord pos: '+pos.coords.latitude+', '+pos.coords.longitude);
				  centerMap(parseFloat(pos.coords.latitude), parseFloat(pos.coords.longitude));
				
				}, "jsonp");

		}
		else{
			//note with geolocation, in firefox, if you hit the x to close location sharing or the "not now" you don't grant OR deny. 
			//It just sits forever expecting some answer it'll never get. so the DENY action is never sent to run the failure option
			//And no, timeout doesn't solve this.
			navigator.geolocation.getCurrentPosition(
				function(position) {
				  newMark(position.coords.latitude, position.coords.longitude, urhere,'', '');
				  lat=position.coords.latitude;
				  lng=position.coords.longitude;
				 // alert(lat);
				 console.log("position stringify: "+JSON.stringify(position));
				  console.log('User coord pos: '+position.coords.latitude+', '+position.coords.longitude);
				  centerMap(position.coords.latitude, position.coords.longitude);
				}, 
				function(error){ 
				/*swal("Location sharing is disabled on your broswers. Please enable it on your browser settings.");//Location sharing denied. Using default location
                                  newMark(lat, lng, urhere,'', '');
                                  console.log('loc sharing denied. default coord pos: '+lat+', '+lng);
                                  centerMap(lat, lng);*/
            $.get("https://ipinfo.io", function(response) {
  					console.log("ipinfo get response: "+response.loc+ ", "+response.country);
					var loc = response.loc.split(',');
  					var pos = {coords : {
        							latitude: loc[0],
        							longitude: loc[1]}};
        			newMark(parseFloat(pos.coords.latitude), parseFloat(pos.coords.longitude), urhere,'', '');
				  lat=pos.coords.latitude;
				  lng=pos.coords.longitude;
				 // alert(lat);
				  console.log('User coord pos: '+pos.coords.latitude+', '+pos.coords.longitude);
				  centerMap(parseFloat(pos.coords.latitude), parseFloat(pos.coords.longitude));
				
				}, "jsonp");

				}, 
				{enableHighAccuracy: true,timeout: 3000,maximumAge: Infinity}
			);
		}
	}

	//sends the object to google's geocoder
        //geocoding url example https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=YOUR_API_KEY
        //reverse geocoding url example https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&key=YOUR_API_KEY

	//why obj? 
	//{'address': '123 example rd. city, stat zip'} gives coordinates, geometry.location:{"lat":47.6062446,"lng":-122.33199289999999},
	// {'location': {'lat': 50.000, 'lng': 120.000}} gives address (results[0].formatted_address)
      function toGeocode(obj, func, out){
	 var geocoder = new google.maps.Geocoder();
        var reslt=geocoder.geocode(obj, function(results, status) {
          if (status === 'OK') {
            if (results[0]) {
		if(out=='data'){
		func(results[0]);
		}
		else{
			if('location' in obj){
			func(results[0].formatted_address);
			} 
			else if('address' in obj){
			func(results[0].geometry.location);
			}
		}

            } else {
              window.alert('No results found');
            }
          } else {
            window.alert('Geocoder failed due to: ' + status);
          }
        });

      }

	//marks all helpers nearby on map by distance and category
	function markAllHelpers(rngLat, rngLng, catId, hlpType){
	console.log("Center to search from: "+lat+", "+lng);	
	        var helpers=postCall({lat: lat, lng: lng, rngLat: rngLat, rngLng: rngLng, categId: catId, helperType: hlpType}, 'findHelperarea.php');
		helpers=JSON.parse(helpers);

		if(helpers){
			console.log("Number of Helpers found at "+rngLat+"mi x "+rngLng+"mi area, at coord("+lat+", "+lng+") with category Id "+catId+": "+ helpers.length);
		}
		else{

			console.log("Number of Helpers found at "+rngLat+"mi x "+rngLng+"mi area, at coord("+lat+", "+lng+") with category Id "+catId+": 0");
		}
		delMark(urhere,1);
		for( var key in helpers){
			console.log("Inside for :"+helpers[key]['username']);
        	//newMark(parseFloat(helpers[key]['lat']), parseFloat(helpers[key]['lng']), helpers[key]['username']);
        	newMark(parseFloat(helpers[key]['posLat']), parseFloat(helpers[key]['posLong']), helpers[key]['username']);
        	
		}
	}

	//calcs map zooming to miles.
	function zmToMile(lat, px ,zoom){
	//gotten from google employee on a forum
	var metersPerPx = 156543.03392 * Math.cos(lat * Math.PI / 180) / Math.pow(2, zoom);
	var meters= metersPerPx * px ; //convert to meters
	var km = meters / 1000; //convert to meters.
	var miles= km / 1.609; //convert km to miles.
	return miles;
	}


	//meant to run on initmap's event when zoom (or scroll later) is changed.
	function populateMap(map){
	
	//if catgeory Id cId is zero, get all helpers. if not, get categ helpers;
	//get zoom level
	var zm=map.getZoom();
	//convert zoomlevel to miles
	var latMi=zmToMile(lat, ( mapDivH / 1.7 ), zm); //width/1.9 because want the radius a little larger than the radius, not the full width of the map box
	var lngMi=zmToMile(lat, ( mapDivW / 1.7 ), zm); //width/1.9 because want the radius, not the full width of the map box
	

	//use zoomlevel and category ID to mark map 
	markAllHelpers(latMi, lngMi, cId, 'all');
	}