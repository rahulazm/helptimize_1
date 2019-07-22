<?php
include("header_main.php");
$categs=$_sqlObj->query("select * from categ where parent_id='' or parent_id is null");
$cur=reset($categs);
//print_r($cur);
?>
<script type="text/javascript">
 // This example adds a search box to a map, using the Google Place Autocomplete
      // feature. People can enter geographical searches. The search box will return a
      // pick list containing a mix of places and predicted search terms.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 47.6062, lng: -122.3321},
          zoom: 13,
          mapTypeId: 'roadmap'
        });

        var infoWindow = new google.maps.InfoWindow;
        var curaddr;
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            var google_map_pos = new google.maps.LatLng( pos.lat, pos.lng );
 
                /* Use Geocoder to get address */
                var google_maps_geocoder = new google.maps.Geocoder();
                google_maps_geocoder.geocode(
                    { 'latLng': google_map_pos },
                    function( results, status ) {
                        if ( status == google.maps.GeocoderStatus.OK && results[0] ) {
                            curaddr = results[0].formatted_address;
                            console.log( results[0].formatted_address );
                            $('#pac-input').val(curaddr);
                            infoWindow.setContent("You are here!");
                        }
                    }
                );

            
            infoWindow.setPosition(pos);
            infoWindow.open(map);
            map.setCenter(pos);
            //alert(results[0].formatted_address);
           
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            //alert(place.geometry.location.lat());
            //alert(place.geometry.location.lng());
            $('#lat').val(place.geometry.location.lat());
            $('#lng').val(place.geometry.location.lng());

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
          
          //alert("position-->"+place.geometry.lat);
        });

        //alert("lat"+lat+"lng"+lng);
        $('#lat').val(lat);
        $('#lng').val(lng);
      }
</script>

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
      #description {
        font-weight: normal;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        /* font-weight: 300; */
        margin-left: 12px;
        /*padding: 10px 115px 0 13px; */
        text-overflow: ellipsis;
        width: 400px;
        margin-top: 10px
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
      #target {
        width: 345px;
      }
    </style>

<section class="wrapper">
            <aside class="super-widget-tab">
                <div><input type="radio" id="location" name="location" checked/><label for="location">1.Location</label></div>
                <div><input type="radio" id="jobdetails" name="jobdetails" disabled/><label for="jobdetails">2.Job Details</label></div>
                <div><input type="radio" id="payment" name="payment" disabled/><label for="payment">3.Payment</label></div>
                <div><input type="radio" id="review" name="review" disabled/><label for="review">4.Review</label></div>
                <div><input type="radio" id="finish" name="finish" disabled/><label for="finish">5.Finish!</label></div>
            </aside>
            <aside class="super-widget-tab-info">
              <summary class="location WDTH90 MRGCenter">
                <h2><b>Where do you need the help?</b></h2>
                <!--<div class="flex-layout">
                    <input type="text" id="getaddr" name="getaddr"/>
                    <i class="fas fa-crosshairs location-icon"></i>
                </div>
                 <div id="map"></div>-->
                  <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                  <div id="map" style="height: 250px;"></div>
                  <p>&nbsp;</p>
                   <button onclick="addAddress();" id="addAddress" class="button-primary">Add Address</button>
                   <div id="addAddressDetails" style="display: none">
                     <p>&nbsp;</p>
                     <h2><b>New Address </h2><b>
                      <textarea id="newaddress"></textarea>
                      <input type="hidden" id="lat">
                      <input type="hidden" id="lng">
                   </div>
                <!-- Replace the value of the key parameter with your own API key. -->
                <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7Y4opceNAVG8qp53FvFNV3IG7aUHU2GU&libraries=places&callback=initAutocomplete">
                </script>

              </summary>
              <summary class="jobdetails WDTH90 MRGCenter" style="display: none">
                  <h2><b>Describe What you need</b></h2>
                  <textarea id="desc"></textarea>
                  <h2><b>Category</b></h2>
                  <?php while ($cur) { ?>
                    
                  <input type="radio" id="<?php echo $cur['id'];?>" value="<?php echo $cur['id'];?>" name="serv"/><label class="service" for="<?php echo $cur['id'];?>"><?php echo $cur['name'];?></label>
                  <?php $cur=next($categs); } ?>
                  <div class="row">
                      <div class="col-sm-6 col-md-6 col-lg-6">
                          <h2><b>When do you need it?</b></h2>
                      </div>
                      <div class="col-sm-6 col-md-6 col-lg-6 text-right">
                        Recurring? <select class="custom-drop-down" id="recurring">
                          <option>One Time</option>
                          <option>Weekly</option>
                          <option>Twice Monthly</option>
                          <option>Monthly</option>
                          <option>Every Other Month</option>
                        </select>
                        <!-- <input type="radio" class="recurring" id="recurring"/> <label for="recurring"><small>Recurring?</small></label> -->
                      </div>
                  </div>
                  <iframe src="calendar.html" class="calendar-view"></iframe>
                  <p>&nbsp;</p>
                  <?php include('create_new_service_request_take_pictures_new.php');?>

              </summary>
              <summary class="payment WDTH90 MRGCenter" style="display: none">
                  <h2><b>How do you like to Pay?</b></h2>
                  <input type="radio" checked id="fixed" name="pay" value="fixed" /><label for="fixed">Fixed</label>
                  <input type="radio" id="hourly" name="pay" value="hourly" /><label for="hourly">Hourly</label>
                  <div class="form-group MRGT10PX">
                    <label class="form-label" for="first">Amount</label>
                    <input id="first" class="form-input" type="text" />
                  </div>
                  <div class="form-group MRGT10PX" id="recamnt" style="display:none;">
                    <label>Total Amount</label>
                    <input id="totalamnt" class="form-input" type="text" readonly="true" value="$100" />
                  </div>
                  <textarea class="MRGT10PX" id="schedule_note"></textarea>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <h2><b>Payment Method</b></h2>
                    </div>
                    <div class="col-sm-8 col-md-8 col-lg-8">
                        <button class="button-secondary MRG10PX">+ New Method</button>
                    </div>
                </div>
                  <div class="account-details">
                  <input type="radio" name="bank" value="bank1" /> <label>My Bank Account</label><br/>
                  <input type="radio" name="bank" value="bank2" /> <label>My Bank Account</label>
                </div>

              </summary>
              <summary class="review WDTH90 MRGCenter" style="display: none">
                  <h2><b>Review your request</b></h2>
                  <p><b>Description</b></p>
                  <span id="description"></span>
                  <p class="MRGT20PX"><b>Particulars</b></p>
                  <div class="row">
                      <div class="col-sm-4 col-md-4 col-lg-4">
                        <div ><i class="far fa-clock"></i><span id="startMin"></span> - <span id="endMin"></span></div>
                        <div><i class="far fa-calendar-alt"></i> <span id="startdate"></span> - <span id="enddate"></span></div>
                      </div>
                      <div class="col-sm-8 col-md-8 col-lg-8">
                         <div><i class="fas fa-map-marker-alt"></i> Address</div> 
                         <span id="address"></span>
                    </div>
                  </div>
                  <p class="MRGT20PX"><b>Amount</b></p>
                  <label>
                    <span id="amnt"></span>
                  </label>
              </summary>
              <summary class="finish WDTH90 MRGCenter" style="display: none">
                  <h2><b>Congratulations!</b></h2>
                  <p class="MRGT20PX">Tour help requested has been posted. Sit back and relax.</p>
                  <a href="#">Go to Dashboard</a>
              </summary>
              <div class="flex-layout actions WDTH90 MRGCenter MRGT20PX">
                <button onclick="prev()" id="prev" class="button-secondary" style="visibility: hidden;">BACK</button>
                <button onclick="next()" id="next" class="button-primary">NEXT</button>
            </div>
            </aside>
        </section>
    </div>

<?php
include("footer.php");
?>
