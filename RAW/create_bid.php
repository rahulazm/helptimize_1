<?php
include("header_main.php");
require_once("/etc/helptimize/conf.php");

$job_id = $_GET['job_id'];

$job_data = $_sqlObj->query("select * from serviceRequests where id=$job_id");
/*echo $job_data[0]['title'];
echo '<pre>';
print_r($job_data);
echo '</pre>';*/

$categs=$_sqlObj->query("select * from categ where parent_id='' or parent_id is null");
$cur=reset($categs);

//fetch all address lat,lon
$addMrkr=$_sqlObj->query("select posLong,posLat from address");
$addMrkrRes=@reset($addMrkr);
$new = array();
$i=0;
while($addMrkrRes){
  $new[$i]['lat'] = $addMrkrRes['posLong'];
  $new[$i]['lon'] = $addMrkrRes['posLat'];
  $addMrkrRes=next($addMrkr);
  $i++;
}
$addMrkrRes = json_encode($new);
//echo "<pre>";
//print_r($_SERVER);
//echo "</pre>";

$_sqlObj->query('delete from address where userId='.$_SESSION['id'].' and srId is NULL');
$_sqlObj->query('delete from pics where userId='.$_SESSION['id'].' and srId is NULL');
?>
<script type="text/javascript">

      

$( document ).ready(function() {

  initMap();


  //cId=$("#project_category").val(); //setting the value of the category for the map
  cId=$('input:radio[name=serv]:checked').val();
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

$('input:radio[name=serv]').on("click", function(){
  cId=$('input:radio[name=serv]:checked').val();
  initMap();
  populateMap();
});
/*  $("#project_category").change(function(){
  cId=$("#project_category").val();
  // repopulate helpers map for this category
  initMap();
  populateMap();
  });*/

});
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
//var categId=$("#project_category").val();
</script>
<!-- <script src="js/googleMap.js"></script> -->

<style>
      /*.collapse:not(.show){
        display: block !important;
      }*/
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
                <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=<?php echo $_configs['google_map_api'];?>&libraries=places&callback=initAutocomplete">
                </script>
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
                <input type="hidden" id="service_id" value="<?php echo $job_id; ?>">
                <h1><b>1.Location</b></h1>
                <h2><b>Job Title</b></h2>
                <input type="text" id="jobtitle" value="<?php echo $job_data[0]['title'];?>" readonly>
                <h2><b>Where do you need the help?</b></h2>
                <!--<div class="flex-layout">
                    <input type="text" id="getaddr" name="getaddr"/>
                    <i class="fas fa-crosshairs location-icon"></i>
                </div>
                 <div id="map"></div>-->
                  <!-- <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                  <div id="map" style="height: 250px;"></div> -->
                  <div id="googleMap" style="height:300px"></div>
                  <p>&nbsp;</p>
                   <button onclick="addAddress();" id="addAddress" class="button-primary">Add Address</button>
                   <div id="addAddressDetails" style="display: none">
                     <!-- <p>&nbsp;</p>
                     <h2><b>New Address </h2><b> -->
                      <!-- <textarea id="newaddress"></textarea>
                      <input type="hidden" id="lat">
                      <input type="hidden" id="lng"> -->
                      <?php include('create_new_service_request_address_selection_new.php');?>
                   </div>
                <!-- Replace the value of the key parameter with your own API key. -->


              </summary>
              <summary class="jobdetails WDTH90 MRGCenter" style="display: none">
                  <h1><b>2.Job Details</b></h1>
                  <h2><b>Describe What you need</b></h2>
                  <textarea id="desc"><?php echo $job_data[0]['descr'];?></textarea>
                  <h2><b>Category</b></h2>
                  <?php while ($cur) { 
                   
                  ?>
                    
                  <input type="radio" id="<?php echo $cur['id'];?>" value="<?php echo $cur['id'];?>" <?php if($cur['id'] == $job_data[0]['categId']){echo 'checked'; }?> disabled name="serv"/><label class="service" for="<?php echo $cur['id'];?>"><?php echo $cur['name'];?></label>
                  <?php $cur=next($categs); } ?>
                  <div class="row">
                      <div class="col-sm-6 col-md-6 col-lg-6">
                          <h2><b>When do you need it?</b></h2>
                      </div>
                      <div class="col-sm-6 col-md-6 col-lg-6 text-right">
                        <!-- Recurring? <select class="custom-drop-down" id="recurring">
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
                  <h1><b>3. Payment</b></h1>

                  <h2><b>How do you like to Pay?</b></h2>
                  <div style="font-weight: normal;">
                    <input type="radio" id="fairMarket" <?php if($job_data[0]['payType'] == 3){ echo 'checked';} ?> name="pay"/><label for="fairMarket">Fair Market</label>
                    <input type="radio" <?php if($job_data[0]['payType'] == 1){ echo 'checked';} ?> id="fixed" name="pay" value="fixed" /><label for="fixed">Fixed</label>
                    <input type="radio" <?php if($job_data[0]['payType'] == 2){ echo 'checked';} ?> id="hourly" name="pay" value="hourly" /><label for="hourly">Hourly</label>
                  </div>
                  <div class="row WDTH300PX actHourly">
                      <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group MRGT10PX">
                          <label class="form-label" for="rateHour">Rate/Hour</label>
                          <input id="rateHour" class="form-input" type="number" value="<?php echo $job_data[0]['rateperhour']; ?>" />
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group MRGT10PX">
                            <label class="form-label" for="tHour">Total Hours</label>
                            <input id="tHour" class="form-input" type="number" value="<?php echo $job_data[0]['totalhours']; ?>"/>
                        </div>
                      </div>
                  </div>
                  <div class="form-group MRGT10PX WDTH300PX ramount" id="recamnt" style="display:none">
                      <label class="form-label" for="ramount">Recurrence Amount</label>
                      <input id="ramount" class="form-input" type="text" />
                   </div>       
                  <div class="form-group MRGT10PX WDTH300PX amount">
                    <label class="form-label" for="amount">Amount</label>
                    <input id="amount" class="form-input" value="<?php echo $job_data[0]['schedule_amount']; ?>" type="text" />
                  </div>           
                  <!-- <div class="form-group MRGT10PX">
                    <label class="form-label" for="first">Amount</label>
                    <input id="first" class="form-input" type="text" />
                  </div> -->
                  <!-- <div class="form-group MRGT10PX" id="recamnt" style="display:none;">
                    <label>Total Amount</label>
                    <input id="totalamnt" class="form-input" type="text" readonly="true" value="$100" />
                  </div> -->
                  <div class="form-group MRGT10PX notes">
                    <label class="form-label" for="notes">Notes</label>
                    <textarea class="form-input" id="schedule_note"><?php echo $job_data[0]['schedule_note']; ?></textarea>
                    </div>
                  
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
                  <h1><b>4. Review</b></h1>
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
                  <h1><b>5. Finish!</b></h1>
                  <h2><b>Congratulations!</b></h2>
                  <p class="MRGT20PX">Tour help requested has been posted. Sit back and relax.</p>
                  <a href="main.php">Go to Dashboard</a>
              </summary>
              <div class="flex-layout actions WDTH90 MRGCenter MRGT20PX">
                <button onclick="create_bid_prev()" id="prev" class="button-secondary" style="visibility: hidden;">BACK</button>
                <button onclick="create_bid_next()" id="next" class="button-primary">NEXT</button>
            </div>
            </aside>
        </section>

<?php
include("footer.php");
?>
