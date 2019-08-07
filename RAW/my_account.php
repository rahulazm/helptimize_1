<?php

require_once("./header_main.php");



$accordion_id = $_GET['accordion_id'];
$user_id= $row_accout_id['id'];
$billing_state = $row_accout_id['billing_state'];
$mobile_number = $row_accout_id['mobile_number'];
$email = $row_accout_id['email'];

$billing_street_1 = $row_accout_id['billing_street_1'];
$billing_street_2 = $row_accout_id['billing_street_2'];
$billing_zip = $row_accout_id['billing_zip'];
$billing_city = $row_accout_id['billing_city'];
$billing_state = $row_accout_id['billing_state'];

$company_name = $row_accout_id['company_name'];
$firstname = $row_accout_id['firstname'];
$name = $row_accout_id['name'];


$mobile_number = "+" . $mobile_number;

$db_get_states = new mysqli("$host", "$username", "$password", "$db_name");

if($db_get_states ->connect_errno > 0){
    die('Unable to connect to database [' . $db_get_states ->connect_error . ']');
}

$sql_get_states = "SELECT * FROM states";

$result_get_states = $db_get_states->query($sql_get_states);

$db_get_states->close();


// get verified document


$db_verified_documents = new mysqli("$host", "$username", "$password", "$db_name");

if($db_verified_documents ->connect_errno > 0){
    die('Unable to connect to database [' . $db_verifized_documents ->connect_error . ']');
}

$sql_verified_documents = "SELECT * FROM accounts_id_verified WHERE account_id ='$account_id'";

$result_get_verified_documents = $db_verified_documents->query($sql_verified_documents);
$row_cnt_verified_documents = $result_get_verified_documents->num_rows;

$db_verified_documents->close();

$_sqlObj = new mysqli("$host", "$username", "$password", "$db_name");
if($_sqlObj->connect_errno > 0){
    die('Unable to connect to database [' . $_sqlObj ->connect_error . ']');
}
#######Document Verification
  $qstr="select * from verifyDocs where userId = '".$_SESSION['id']."' order by id desc";
  $document=$_sqlObj->query($qstr);
  $count_doc=count($document);
#######Category range area
  $qstr="select * from range_area where userId = '".$_SESSION['id']."' order by id desc";
  $rangearea=$_sqlObj->query($qstr);
  $count_area=count($rangearea);
  
  
  $qstrChckr="SELECT * FROM checkr_verification WHERE user_id = '".$_SESSION['id']."'";
  $resChkr=$_sqlObj->query($qstrChckr);
  $row=$resChkr->fetch_assoc();
  $chkrResp = $row['full_response'];
  $chkrResp=json_decode($chkrResp); 
  //echo $chkrResp;
  $msgSexOff = ($chkrResp->sex_offender_search_id!="")?"Sex offender check - <span style='color:green'>PASSED</span>":"Sex offender check - <span style='color:red'>FAILED</span>";
  $msgTrrOff = ($chkrResp->global_watchlist_search_id!="")?"Global watchlist check - <span style='color:green'>PASSED</span>":"Global watchlist check - <span style='color:red'>FAILED</span>";
  $msgGlOff = ($chkrResp->terrorist_watchlist_search_id!="")?"National Criminal Database Check - <span style='color:green'>PASSED</span>":"National Criminal Database Check - <span style='color:red'>FAILED</span>";
  $msgSsn = ($chkrResp->ssn_trace_id!="")?"SSN verification - <span style='color:green'>PASSED</span>":"SSN verification - <span style='color:red'>FAILED</span>";
  echo $_template["header"];
  

?>

<style>

.continue_button_border_radius {border-radius: 15px !important;}
.continue_button_size {padding: 5px 25px !important;}
.continue_button_background {background-color:#E65825 !important;}
.continue_button_no_border {border: none !important;}


.text_input_radius {border-radius: 5px !important;}


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



.navbar-default {
    background-color: #3E78A6 !important;
    border-color: #3E78A6 !important;
}

.navbar-nav>li>a {
 color : white !important;
}


.navbar-default .navbar-toggle .icon-bar {
    background-color: white !important;
}
</style>
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
      
     
      
       #autocomplete2 {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 350px;
      }
      
      .collapse:not(.show) {
    display: block !important;
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


<style>
.loader {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 8px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>


<script src="js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.3.0/zxcvbn.js"></script>
<script src="formvalidation/js/formValidation.min.js"></script>
<script src="js/framework/bootstrap.min.js"></script>

<link href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
 <link rel="stylesheet" href="formvalidation/css/formValidation.min.css">
  <link href="css/formValidation.min.css" rel="stylesheet">


<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript">
$( document ).ready(function() {
         // Change tab class and display content
$('.tabs-nav a').on('click', function (event) {
    event.preventDefault();

    $('.tab-active').removeClass('tab-active');
    $(this).parent().addClass('tab-active');
    $('.tabs-stage div').hide();
    $($(this).attr('href')).show();
});

$('.tabs-nav a:first').trigger('click'); // Default

});
</script>

<style type="text/css">
<!-- renu css code -->
body .collapse:not(.show) {   display: block !important;}
.form-group{  display: block !important;}
ul, li, div {   background: hsla(0, 0%, 0%, 0);   border: 0;   font-size: 100%;   margin: 0;   outline: 0;   padding: 0;   vertical-align: baseline;    font: 13px/20px "Droid Sans", Arial, "Helvetica Neue", "Lucida Grande", sans-serif;   text-shadow: 0 1px 0 hsl(0, 100%, 100%);}
li {   display: list-item;   text-align: -webkit-match-parent;}
.tabs-nav { list-style: none;   margin: 0;   padding: 0; float:right;}
.tabs-nav li:first-child a { border-right: 0; -moz-border-radius-topleft: 6px;   -webkit-border-top-left-radius: 6px;   border-top-left-radius: 6px;}
.tabs-nav .tab-active a {   border-bottom:2px solid #118ab2;   color: #000;   cursor: default;}
.tabs-nav a {color:#000; display: block; font-size: 11px; font-weight: bold; height: 40px; line-height: 44px; text-align: center; text-transform: uppercase;  width: 140px;}
.tabs-nav li {float: left;}
.tabs-stage { clear: both; margin-bottom: 20px; position: relative; top: -1px;   width: auto;}
.tabs-stage p {  margin: 0;  padding: 1px;    color: hsl(0, 0%, 33%);}
.lwrap { padding: 47px 18px 0 18px; align-items: baseline; box-shadow: 0 0 4px #00000059; float:left;width:100%;}
.tabscnt{ padding: 19px 18px 25px 18px; align-items: baseline; box-shadow: 0 0 4px #00000059; float:left;width:100%;margin-top:1%;}
.layout {  width: 60%;  margin:0 auto;  margin-top:4%;}
.topblock{background:#f5e100;padding: 3% 2% 1%;position: relative;float: left;width: 100%;}
.user-image {position: absolute;top: 30%;text-align:center;}
.user-image h5{margin-bottom:0px !important;}
.user-image img {   width: 100px;   height: 100px;   border-radius: 50%;   background: #fff;   object-fit: cover;   border: 2px solid #fff;}
.user-diomand {  float: right;  width: 50px;  height: 50px;    border-radius: 50%;  background: #fff; padding: 18px;   margin-left: 10px;}
.flex-layout-left { float:left }
.flex-layout-right { float:right;width:22%; }
.memberg{position: absolute;top: 48%;font-size: 20px;}
.btn-default{background:#ccc;}
#doc_submit{background:#ccc;}
.clr{clear:both;}
</style>

<?php

echo $_template["nav"];
//echo $currentLocationCoords = getCurrentLoction();


?>


<!-- layout and tab div--><div class="layout">
<div class="topblock">
            <div class="flex-layout-lrft">
            <div class="user-image"> <img src="./assets/images/user.jpg"> <br> <h5>Member Name </h5><small>Designation</small> </div>
            </div>
            <div class="flex-layout-right"><div class="memberg">Gold Member</div>
                                    <div class="user-diomand">
                                        <i class="fas fa-user"></i>
                                    </div>
            </div>
</div>
<div class="clr"></div>
<div class="lwrap">
<ul class="tabs-nav">
    <li class="tab-active"><a href="#tab-1" rel="nofollow">Contact Info<?php //echo CONTACT_INFORMATION?></a></li>
    <li class=""><a href="#tab-2" rel="nofollow">Billing Info</a> </li>
     <li class=""><a href="#tab-3" rel="nofollow">Checkr Vari.</a>  </li>
     <li class=""><a href="#tab-4" rel="nofollow">Document Vari.</a>  </li>
      <li class=""><a href="#tab-5" rel="nofollow">Job Type</a>  </li>
</ul>
</div>
<div class="tabs-stage">
    <div id="tab-1" style="display: block;" class="tabscnt">
   <!-- contact info form -->
   <form id="contact_info" name="contact_info" >
   <!--   <div class="form-group">
              <label for="usr"><font color="black"><?php echo CUSTOMER_MOBILE;?><?font></label>
              <input type="tel" class="form-control" id="customer_mobile" name="customer_mobile" value="<?php echo $mobile_number;?>">
              <br><?php //echo PLEASE_KEY_IN_A_VALID_MOBILE_NUMBER_VERIFY ;?>
  </div>  -->
  <div class="form-group">
          <label for="usr"><font color="black"><?php echo CURRENT_CUSTOMER_EMAIL;?><?font></label>
              <input type="text" readonly class="form-control" id="current_email" name="current_email" value="<?php echo $email;?>">
          </div>
  <div class="form-group">
          <label for="usr"><font color="black"><?php echo NEW_CUSTOMER_EMAIL;?><?font></label>
              <input type="text"  class="form-control" id="new_email" name="new_email">
          </div>
          <center>
  <button type="submit" class="btn btn-success" ><?php echo UPDATE_CONTACT_INFO;?></button>
  </center>
  </form>
   <!-- contact info form -->
    </div>
     <div id="tab-2" style="display: none;" class="tabscnt">
<!-- billing info Form -->
<form id="billing_info" name="billing_info">
<div class="form-group"><label for="usr"><?php echo COMPANY_NAME;?></label>
<input placeholder="Company Name" type="text" class="form-control" id="company_name" name="company_name" value="<?php echo $company_name;?>">
</div>
<div class="form-group">
           <label for="usr"><?php echo NAME;?></label>
        <input placeholder="Firstname" type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $firstname;?>">
</div>
      <div class="form-group">
           <label for="usr"><?php echo FAMILY_NAME;?></label>
        <input placeholder="Name" type="text" class="form-control" id="name" name="name" value="<?php echo $name;?>">
      </div>

<div class="form-group">
           <label for="usr"><?php echo STREET_1;?></label>
        <input placeholder="Street 1" type="text" class="form-control" id="street_1" name="street_1" value="<?php echo $billing_street_1;?>">
      </div>
<div class="form-group">
             <label for="usr"><?php echo STREET_2;?></label>
        <input placeholder="Street 2" type="text" class="form-control" id="street_2" name="street_2" value="<?php echo $billing_street_2;?>">
      </div>
      <div class="form-group">
              <label for="usr"><?php echo ZIP;?></label>
    <input type="text" class="form-control" placeholder="ZIP" id="zip" name="zip" value="<?php echo $billing_zip;?>"/>
      </div>
<div class="form-group">
            <label for="usr"><?php echo CITY;?></label>
    <input type="text" class="form-control" placeholder="City" id="city" name="city" value="<?php echo $billing_city;?>"/>
</div>
<div class="form-group">
              <label for="usr"><?php echo STATE;?></label>
        <select class="form-control" id="states" name="states">
        <?php
        while ($row = $result_get_states->fetch_assoc()) {

        if($billing_state == $row['name']){

        echo "<option value=" . $row ['name'] . " selected='selected'>" . $row ['name'] . "</option>";

        }else{
        echo "<option value=" . $row ['name'] . ">" . $row ['name'] . "</option>";

        }
      }
      ?>
        </select>
      </div>
      <button type="submit" class="btn btn-success" ><?php echo UPDATE_BILLING_INFO;?></button>
     </form>
     <!-- billinginfo form -->
     </div>
<div id="tab-3" style="display: none;" class="tabscnt">
 <!-- chekervarification tabs -->
      <div id="checkr_response" style="display:none;margin-left: 20px">
      <div class="form-group has-feedback has-success">
        <div id="checkrerror" style="color:red"></div>
        <div id="checkrssn"></div>
        <div id="checkrsex"></div>
        <div id="checkrgwtch"></div>
        <div id="checkterrwl"></div>
        </div>
       </div>
      <?php
       echo "<label>$msgSsn</label><br><label>$msgSexOff</label><br><label>$msgTrrOff</label><br><label>$msgGlOff</label><br><br><br>"; ?>
      <?php /*if($msgSexOff=='' || $msgTrrOff=='' ||   $msgGlOff=='' || $msgSsn=='' ) { */?>
      <form id="checkr_info" name="checkr_info">
      <div class="form-group"><label for="usr">SSN#</label>
              <input type="text" class="form-control" id="customer_ssn" name="customer_ssn" value="">
              <?php //echo PLEASE_KEY_IN_A_VALID_MOBILE_NUMBER_VERIFY ;?>
      </div>
      <div class="form-group">
          <label for="usr">Zip Code</label>
              <input type="text" class="form-control" id="zipcode" name="zipcode" value="" >
      </div>
      <?php/* if($msgSexOff=='' || $msgTrrOff=='' ||   $msgGlOff=='' || $msgSsn=='' ) {  */ ?>
       <button type="submit" class="btn btn-success" >Verify</button>
       <?php/* }else{ */?>
       <!--<button type="submit" class="btn btn-default" disabled="">Verify</button>-->
       <?php/* } */?>
     </form>
     <?php /*} else{
		echo "<label>$msgSsn</label><br><label>$msgSexOff</label><br><label>$msgTrrOff</label><br><label>$msgGlOff</label>";
    } */?>
 <!-- cheker varification -->
    </div>
     <div id="tab-4" style="display: none;" class="tabscnt">
      <!-- document varification -->
      <?php  if($row_cnt_verified_documents > 0){ ?>
      <?php echo DOCUMENT_ID_CONFIRMED ;?></p>
      <?php echo DOCUMENT_DETAILS ;?></p>
      <table id="verified_document" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th><p><?php echo TYPE ;?></p></th>
                  <th><p><?php echo NUMBER ;?></p></th>
                  <th><p><?php echo EXPIRATION ;?></p></th>
                  </tr>
          </thead>
          <tbody>
          <?php    while ($row = $result_get_verified_documents->fetch_assoc()) {    ?>
           <tr>
                <td><?php echo $row['document_type'];?></td>
                <td><?php echo $row['document_number'];?> </td>
                <td><?php echo $row['document_expiration_date'];?>  </td>

           </tr>
           <?php
           }
           ?>
            </tbody>
       </table>
       <button type='button'  class='btn btn-danger' onclick='id_verified_delete()'><i class="fa fa-trash-o" aria-hidden="true"></i> <?php echo DELETE;?></button>
    <?php   }else{  ?>
      <p><?php echo ACCEPTED_DOCUMENT;?></p>
       <p><?php echo ACCEPTED_DOCUMENT_2;?></p>
<form id="uploadimage" action="" method="post" enctype="multipart/form-data">
  <input type="hidden" id="sr_id" name="sr_id" value="<?php echo $sr_id;?>">
            <label><?php echo TAKE_PICTURE_OR_SELECT_FILE;?></label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                      Select&hellip;
                      <input type="file"  name="file" id="file" accept="image/*" capture="camera"  style="display: none;" />
                    </span>
                </label>
                <input type="text" id="filepath" name="filepath" class="form-control" readonly value="">
            </div>
            <br>
            <input type="submit" id="picture_submit" name="picture_submit"value="<?php echo UPLOAD_DOCUMENT;?>" class = "btn btn-default" />
   </form>
      <?php  } ?>
      <?php   if($count_doc > 0){   ?>
       <?php //echo DOCUMENT_ID_CONFIRMED ;?></p>
      <?php //echo DOCUMENT_DETAILS ;?></p>
      <table id="awarded_sr_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th><p>#</p></th>
                  <th><p>Name</p></th>
                  <th><p>File</p></th>
                  </tr>
          </thead>
          <tbody>
          <?php $j=0;
           $row=reset($document);
        //  while ($row) {
while ($row = $document->fetch_assoc()) {
            $j++;
           ?>
           <tr>
                <td><?php echo $j;?></td>
                <td><?php echo $row['document_number'];?> </td>
                <td><a href="<?php echo imgPath2Url($row['document_identfication']);?>" target="_blank">View</a>|<a href="javascript:void()" class="document_verified_delete" data-id="<?php echo $row['id'];?>">Delete</a></td>

           </tr>
           <?php
            $row=next($document);
           }
           ?>
            </tbody>
       </table>
      <!--  <button type='button'  class='btn btn-danger' onclick='id_verified_delete()'><i class="fa fa-trash-o" aria-hidden="true"></i> <?php //echo DELETE;?></button> -->
    <?php  }//else{  ?>
      <p><?php echo ACCEPTED_DOCUMENTS;?></p>
       <p><?php //echo ACCEPTED_DOCUMENT_2;?></p>
      <form id="uploaddocument" action="" method="post" enctype="multipart/form-data"><input type="hidden" name="<?php echo ini_get("session.upload_progress.name")?>" value="pics" />
  <input type="hidden" id="sr_id" name="sr_id" value="<?php echo $sr_id;?>">
            <label><?php echo TAKE_PICTURE_OR_SELECT_FILE;?></label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                      Select&hellip;
                     <input type="file" class="file1"  name="img[]" id="file" accept="image/*" capture="camera"  style="display: none;" />
                    </span>
                </label>
                <input type="text" id="filepath1" name="filepath" class="form-control" readonly value="">
            </div>
             <label>Name</label>
             <div class="input-group">
          <input type="text"   name="title[]" id="title" />
            </div>
             <div class="input-group">
              <input type="checkbox"   name="che_status" id="che_status" />I accept that the document is not fraudulent
            </div>
            <input type="submit" id="doc_submit" name="doc_submit"value="<?php echo UPLOAD_DOCUMENT;?>" class = "btn btn-default" />
   </form>
      <!-- dociment varification -->
    </div>
     <div id="tab-5" style="display: none;" class="tabscnt">
    <!-- service area -->
                        <input type="hidden" name="googleclick" id="googleclick">
    <p><?php echo SERVICE_PROVIDED_AREAS_TEXT;?></p>
    <?php if($count_area > 0){  ?>
      <table id="awarded_sr_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th><p>Title</p></th>
                  <th><p>Address</p></th>
                  <th><p>Area in miles</p></th>
                   <th><p>Delete</p></th>
                  </tr>
          </thead>

          <tbody>


          <?php $j=0;
           $row=reset($rangearea);
        //  while ($row) {
while ($row = $rangearea->fetch_assoc()) {
            $j++;
           ?>
           <tr>
                <td <?php if($row['pob'] =="1") { ?>style="color: green;font-weight: bold"<?php } ?>><?php echo $row['title'];?></td>
                <td <?php if($row['pob'] =="1") { ?>style="color: green;font-weight: bold"<?php } ?>><?php echo $row['address'];?> </td>
                <td <?php if($row['pob'] =="1") { ?>style="color: green;font-weight: bold"<?php } ?>><?php echo $row['range_distance'];?></td>
               <td> <a href="javascript:void()" class="range_area_delete" data-id="<?php echo $row['id'];?>">Delete</a>||<a href="map_details.php?id=<?php echo $row['id'];?>">View Map</a></td>
           </tr>

           <?php
            $row=next($rangearea);
           }
           ?>

            </tbody>
       </table>

    <?php

    }

    ?>
    <label><?php echo MY_CURRENT_LOCATION?></label>



  <p id ='mapdiv' name='mapdiv'></p>

  <br>
  <div class="form-group">
  <label for="usr"><?php echo CURRENT_ADDRESS?></label>
  <input type="text" class="form-control text_input_radius" id="autocomplete"  name="curent_address" onclick="geolocate()">
  </div>



   <div class="form-group">
  <label for="usr"><?php echo ENTER_PROJECT_ADDRESS_NAME?></label>
  <input type="text" class="form-control text_input_radius" id="current_address_name"  name="current_address_name"  value="<?php echo $location_count+1; ?>">
</div>


   <!-- <div class="form-group">
  <label for="comment"><?php //echo ENTER_PROJECT_ADDRESS_DESCRIPTION?></label>
  <textarea placeholder="<?php //echo ADRESS_DESCRIPTION;?>" class="form-control text_input_radius" rows="2" id="current_address_description" name="current_address_description"></textarea>
</div> -->
<div class="form-group">
  <label for="usr"><?php echo ENTER_DISTANCE?> in Miles</label>
  <input type="text" class="form-control text_input_radius" id="range_distance"  name="range_distance"  value="" onkeypress="return isNumberKey(event)">
</div>

  <div class="form-group">
  <label for="usr"><?php echo REQUEST_CATEGORY?>  <!-- (To select multiple categories press CTRL and select) --> </label>

                <?php
               // echo "<option value='0'>Please select a category.....</option>";
                $categs=$_sqlObj->query("select * from categ where parent_id='' or parent_id is null");
                $cur=reset($categs);
               while ($cur = $categs->fetch_assoc()) {

                                echo '<br><input type="checkbox" value="'. $cur['id'].'" id="categId" name="categId[]"><span style="padding-left: 10px;top: -6px; position: relative;">' . $cur['name'] . '</span>';

                        $cur=next($categs);
                        }
                        ?>

</div>

  <input type="checkbox" style="float:left" name="pos" id="pos" value="1" checked=""><span style="margin-left: 7px;margin-top: 5px;float: left;">Set as Default address</span>
  <center>
<button class="btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border" type="button" onclick="add_current_address()"><?php echo ADD_ADDRESS;?></button>
  </center>

  </div>



         </div>
    </div>
 </div>
 </div>

    <!-- service area-->
    </div>
    
</div>
<div class="clr"></div>
<!-- layout and tab div--></div>
 <div class="clr"></div>
          
          
<div style="margin:10px">



 


  
  <div id="modal_viewmapclick" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <h4 class="modal-title" style="color:#000000";><center><p class="head_title">View Map</p></center></h4>
                   
                </div>
                    <div class="modal-body">
                    
                
                    <div>
                        
                                <p class="bluedet_id">

                                </p>
                            </div>
                                       
                    </div>
            </div>
        </div>
    </div>

  
<div id="modal_confirm_contact_change" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="color:#000000";><center><i class="fa fa-info-circle fa-2x" aria-hidden="true"></i> <?php echo VALIDATION ;?></center></h4>
              </div>
                <div class="modal-body">
                <form id="validation_reset">
                
                
                 <label><?php echo VALIDATION_CODE ;?></label>
                 
                   <input type="hidden" name="account_id_hidden_reset" id="account_id_hidden_reset" value="">
                   
                  <div class="form-group">
                  <input type='text' name='confirmaton_code' id='confirmaton_code' class='form-control'> 
                  </div>
                  <p><?php echo VALIDATION_CODE_TEXT ;?></p>
            
  
          <br>
                
                <center>
                <button type="submit" class="btn btn-success" ><?php echo VALIDATE_RESET;?></button>
                </center>
                
                </form>
                
    
                    
                </div>
            </div>
        </div>
    </div>  
    


<div id="spinner" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                
                <h4 class="modal-title" style="color:#000000";><center><?php echo DOCUMENT_VERIFICATION;?></center></h4>
              </div>
                <div class="modal-body">
                
              <center>
                
                <div class="loader"></div>
                <h5><?php echo ANALAZYING_DOCUMENT;?></h5>
                
              </center>

      
                </div>
            </div>
        </div>
    </div> 
    
    
    
  <div id="modal_document_ok" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                
                <h4 class="modal-title" style="color:#000000";><center><?php echo DOCUMENT_VERIFICATION;?></center></h4>
              </div>
                <div class="modal-body">
                
                <center>
                <img src="img/document_success.png">
                <h4><?php echo DOCUMENT_VERIFICATION_SUCCESS;?></h4>
                <br>
                <label><?php echo DOCUMENT_VERIFICATION_PRIVACY_HEADER;?></label>
                <div class="panel panel-default">
              <p><div class="panel-body"><?php echo DOCUMENT_DESTROYED;?></div></p>
          </div>
                </center>
                <br>
                
                <h4><?php echo DOCUMENT_VERIFICATION_PASS_PARAMETER;?></h4>
                
                <table>
                <tr>
              <td><?php echo DOCUMENT_IDENTIFIED?></td><td width="10px"></td><td><span id="document_identfication"></span></td>
              </tr>
               <tr>
              <td><?php echo DOCUMENT_FALSIFIED?></td><td width="10px"></td><td><span id="document_falsification_detection"></span></td>
              </tr>
               <tr>
              <td><?php echo DOCUMENT_SAMPLE?></td><td width="10px"></td><td><span id="document_sample_detection"></span></td>
              </tr>
              <tr>
              <td><?php echo DOCUMENT_EXPIRATION?></td><td width="10px"></td><td><span id="document_expiration_detection"></span></td>
              </tr>
              
              
      
            </table>
                
            
            <h4><?php echo DOCUMENT_VERIFICATION_DETAILS;?></h4>
            
            <table>
                <tr>
              <td><?php echo DOCUMENT_TYPE?></td><td width="10px"></td><td><span id="document_type"></span></td>
              </tr>
              <tr>
              <td><?php echo DOCUMENT_ISSUEING_COUNTRY;?></td><td width="10px"></td><td><span id="issuing_country"></span></td>
              </tr>
              <tr>
              <td><?php echo DOCUMENT_NUMBER;?></td><td width="10px"></td><td><span id="document_number"></span></td>
              </tr>
              <tr>
              <td><?php echo DOCUMENT_EXPIRATION;?></td><td width="10px"></td><td><span id="document_expiration_date"></span></td>
              </tr>
              <tr>
              <td></td><td width="10px"></td><td></span></td>
              </tr>
              
              
            </table>
            <br>
            <table>
            
            <tr>
              <td><?php echo DOCUMENT_HOLDER_NAME;?></td><td width="10px"></td><td><span id="document_holder_lastname"></span></td><td width="10px"></td><td><span id="document_holder_firstname"></span></td>
            </tr>
            
            <tr>
              <td><?php echo DOCUMENT_HOLDER_NATIONALITY;?></td><td width="10px"></td><td><span id="document_holder_nationality"></span></td>
            </tr>
            
          
            
            <tr>
              <td><?php echo DOCUMENT_HOLDER_GENDER;?></td><td width="10px"></td><td><span id="document_holder_gender"></span></td>
            </tr>
            
            <tr>
              <td><?php echo DOCUMENT_HOLDER_BIRTHDAY;?></td><td width="10px"></td><td><span id="document_holder_birthday"></span></td>
            </tr>
            
            </table>
            <br>
            <br>
             <center>
              <button type='button'  class='btn btn-success' onclick='modal_document_ok_close()'></i>OK</button>
                </center>
                

      
                </div>
            </div>
        </div>
    </div>   
  
  
  <script>
  
  
  function id_verified_delete(){
  
    var document_id_verified_delete_header = "<?php echo DOCUMENT_ID_VERIFIED_DELETE_HEADER ;?>";
    var document_id_verified_delete_text = "<?php echo DOCUMENT_ID_VERIFIED_DELETE_TEXT ;?>";
    var account_id = "<?php echo $account_id;?>";
  
  
    swal({
            title: document_id_verified_delete_header,
            text: document_id_verified_delete_text,
            type: "error",
            showCancelButton: true,
            confirmButtonColor: "#5cb85c",
            confirmButtonText: "OK",
            closeOnConfirm: false
          },
            function(){
            
                var formData = {
                    'account_id'    : account_id
            
                  } 
            
            
              var feedback = $.ajax({
          
                type: "POST",
                url: "delete_validated_id.php",
                  data: formData,
        
                  async: false,
          
              }).complete(function(){
              
              
              
                     swal({
                  title: "Success",
                  text: "Your verified ID document was removed.",
                  type: "success",
                  showCancelButton: false,
                  confirmButtonColor: "#5cb85c",
                  confirmButtonText: "OK",
                  closeOnConfirm: false
                },
                function(){
 
                                    location.reload();
 
                });
              
              
      
        
              }).responseText;
            
            

            
            
            
          
            
  
          
          });
  
  
  
  
  
  }
  
$(document).on("click", ".document_verified_delete", function(e) { 
  
    var document_id_verified_delete_header = "Remove Verified Document";
    var document_id_verified_delete_text = "Are you sure to remove document?";
    var account_id = $(this).data("id");
  
  
    swal({
            title: document_id_verified_delete_header,
            text: document_id_verified_delete_text,
            type: "error",
            showCancelButton: true,
            confirmButtonColor: "#5cb85c",
            confirmButtonText: "OK",
            closeOnConfirm: false
          },
            function(){
            
                var formData = {
                    'account_id'    : account_id
            
                  } 
            
            
              var feedback = $.ajax({
          
                type: "POST",
                url: "delete_verification.php",
                  data: formData,
        
                  async: false,
          
              }).complete(function(){
              
              
              
                     swal({
                  title: "Success",
                  text: "Your verified  document was removed.",
                  type: "success",
                  showCancelButton: false,
                  confirmButtonColor: "#5cb85c",
                  confirmButtonText: "OK",
                  closeOnConfirm: false
                },
                function(){
 
                                    location.reload();
 
                });
        
              }).responseText;
          
          });
  
  
   });

$(document).on("click", ".range_area_delete", function(e) { 
  
    var document_id_verified_delete_header = "Remove Category Area";
    var document_id_verified_delete_text = "Are you sure to remove Area?";
    var account_id = $(this).data("id");
  
  
    swal({
            title: document_id_verified_delete_header,
            text: document_id_verified_delete_text,
            type: "error",
            showCancelButton: true,
            confirmButtonColor: "#5cb85c",
            confirmButtonText: "OK",
            closeOnConfirm: false
          },
            function(){
            
                var formData = {
                    'account_id'    : account_id
            
                  } 
            
            
              var feedback = $.ajax({
          
                type: "POST",
                url: "delete_area.php",
                  data: formData,
        
                  async: false,
          
              }).complete(function(){
              
              
              
                     swal({
                  title: "Success",
                  text: "Your Area was removed.",
                  type: "success",
                  showCancelButton: false,
                  confirmButtonColor: "#5cb85c",
                  confirmButtonText: "OK",
                  closeOnConfirm: false
                },
                function(){
 
                                    location.reload();
 
                });
        
              }).responseText;
          
          });
  
  
   });
  function modal_document_ok_close(){
     
     $('#modal_document_ok').modal('hide');
      location.reload();

  }
  
  $("#uploaddocument").on('submit',(function(e) {


    $("#doc_submit").prop("disabled",true);

    e.preventDefault();
    
    
   
  

    var filerequired = $("#filepath1").val();
    var name = $("#title").val();
    var atLeastOneIsChecked = $('[name="che_status"]:checked').length;
    var oops = '<?php echo OOPS; ?>';
    var file_required = '<?php echo FILE_REQUIRED; ?>';
    
    if(filerequired == ""){
    
      swal(oops, file_required, "error");
      $("#doc_submit").prop("disabled",false);
      return;  
    }
     else if(name == ""){
    
      swal(oops, "Name Required", "error");
      $("#doc_submit").prop("disabled",false);
      return;  
    }     
    else if(atLeastOneIsChecked == 0) 
    {
      swal("Error", "Please accept Condition", "error");
      $("#doc_submit").prop("disabled",false);
      return;  
    }
    else
    {

  
  var result = "";
  
  $.ajax({
  url: "verify_document.php", 
  type: "POST",             
  data: new FormData(this), 
  contentType: false,       
  cache: false,
  async: true,             
  processData:false,        
  success: function(data)   
    {
    $("#doc_submit").prop("disabled",false);
     window.location.href="my_account.php";

      }
    });
    } 
}));
  
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
  url: "upload_document.php", 
  type: "POST",             
  data: new FormData(this), 
  contentType: false,       
  cache: false,
  async: true,             
  processData:false,        
  success: function(data)   
    {
    
    $('#spinner').modal('hide');
        result = data;
    
        
        var obj = jQuery.parseJSON(result);
        
        var document_identfication = obj.document_summary.document_identfication;
        var document_falsification_detection = obj.document_summary.document_falsification_detection;
        var document_sample_detection = obj.document_summary.document_sample_detection;
        var document_expiration_detection = obj.document_summary.document_expiration_detection;
        var document_copy_detection = obj.document_summary.document_copy_detection;
        
        var document_issueing_country = obj.document_detail.document_issueing_country;
        var document_expirationdate_day = obj.document_detail.document_expirationdate_day;
        var document_expirationdate_month = obj.document_detail.document_expirationdate_month;
        var document_expirationdate_year = obj.document_detail.document_expirationdate_year;
        var document_number = obj.document_detail.document_number;
        
        var document_holder_lastname = obj.document_holder_detail.document_holder_lastname;
        var document_holder_firstname = obj.document_holder_detail.document_holder_firstname;
        var document_holder_nationality = obj.document_holder_detail.document_holder_nationality;
        var document_holder_gender = obj.document_holder_detail.document_holder_gender;
        var document_holder_birthday_day = obj.document_holder_detail.document_holder_birthday_day;
        var document_holder_birthday_month = obj.document_holder_detail.document_holder_birthday_month;
        var document_holder_birthday_year = obj.document_holder_detail.document_holder_birthday_year;
        
        var document_mrz_line_1 = obj.document_mrz.document_mrz_line_1;
        var document_mrz_line_2 = obj.document_mrz.document_mrz_line_2;
        var document_mrz_line_3 = obj.document_mrz.document_mrz_line_3;
        
        var type = obj.document_type.type;
        
        var account_id = "<?php echo $account_id;?>";
        
        //document_identfication = "NOK";
        
                
        if(document_identfication == "OK" && document_falsification_detection == "OK" && document_sample_detection == "OK" && document_expiration_detection == "OK" && document_copy_detection == "OK"){
        
            $("#issuing_country").text(document_issueing_country);
            $("#document_type").text(type);
            $("#document_number").text(document_number);
            
            $("#document_identfication").html("<img src='img/ok.jpg'>");
            $("#document_falsification_detection").html("<img src='img/ok.jpg'>");
            $("#document_sample_detection").html("<img src='img/ok.jpg'>");
            $("#document_expiration_detection").html("<img src='img/ok.jpg'>");
             
            
            var document_expiration_date = document_expirationdate_day + "/" + document_expirationdate_month + "/" + document_expirationdate_year;
            
            $("#document_expiration_date").text(document_expiration_date);
            
            $("#document_holder_lastname").text(document_holder_lastname);
            $("#document_holder_firstname").text(document_holder_firstname);
            $("#document_holder_nationality").text(document_holder_nationality);
            $("#document_holder_gender").text(document_holder_gender);
            
            var document_holder_birthday = document_holder_birthday_day + "/" + document_holder_birthday_month + "/" + document_holder_birthday_year;
            $("#document_holder_birthday").text(document_holder_birthday);
            
            
            // store idendity information in database
            
            
            var formData = {
            'account_id'    : account_id,
            'issuing_country'    : document_issueing_country,
            'document_type'    : type,
            'document_number'    : document_number,
            'document_identfication'    : document_identfication,
            'document_falsification_detection'    : document_falsification_detection,
            'document_sample_detection'    : document_sample_detection,
            'document_expiration_detection'    : document_expiration_detection,
            'document_expiration_date'    : document_expiration_date,
            'document_holder_lastname'    : document_holder_lastname,
            'document_holder_firstname'    : document_holder_firstname,
            'document_holder_nationality'    : document_holder_nationality,
            'document_holder_gender'    : document_holder_gender,
            'document_holder_birthday'    : document_holder_birthday        
            
        } 
        
        
        var feedback = $.ajax({
          
          type: "POST",
          url: "store_validated_id.php",
            data: formData,
        
            async: false,
          
          }).complete(function(){
        
          }).responseText;
          
          
           $('#modal_document_ok').modal('show');
           
        
        }else{
        
            var document_upload_error_header = "<?php echo DOCUMENT_UPLAOD_ERROR_HEADER;?>"
            var document_upload_error_text = "<?php echo DOCUMENT_UPLAOD_ERROR_TEXT;?>"
            var document_upload_error_read_guidelines = "<?php echo DOCUMENT_UPLAOD_ERROR_READ_GUIDELINES;?>"
        
            swal({
            title: document_upload_error_header,
            text: document_upload_error_text,
            type: "error",
            showCancelButton: true,
            confirmButtonColor: "#5cb85c",
            confirmButtonText: document_upload_error_read_guidelines,
            closeOnConfirm: false
          },
            function(){

            location.href = "upload_document_guidelines.php";
            
  
          
          });
        
        
        
        
        
        
        }

    }
  });
  
  

  
     $('#spinner').modal({
      backdrop: 'static',
        keyboard: false
    });
        $('#spinner').modal('show');
  
     

  
    
  $("#picture_submit").prop("disabled",false);


}));

$(document).on('change', ':file', function() {
    
    var input = $(this);
       
   
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
        
        
        $("#filepath").val(label);
        
    
});
  
  
 $(document).on('change', '.file1', function() {
    
    var input = $(this);
       
   
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
        
        
        $("#filepath1").val(label);
        
    
}); 
  
  
  
  
  $(document).ready(function() {
 
 		$('#collapseFour').on('shown.bs.collapse', function () {
      	geoloc();
		});

google.maps.event.addDomListener(window, 'resize', function() {
     
    });
    
    // check if ID documents need validaton
    var accordion_id = "<?php echo $accordion_id;?>";
  if(accordion_id == "3"){
      $( "#collapseTree" ).collapse("show");
    }
    
    $('#awarded_sr_list').DataTable(//,#awarded_list
        {
            "iDisplayLength" : 5,
            "bLengthChange": false,
            "ordering": false,
            "searching": false,
            "info": false,
            "pagingType": "simple",
        "drawCallback": function ( settings ) {
        if (Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength) > 1) {
            $('#awarded_sr_list_paginate').css("display", "block");     
        } else {                
            $('#awarded_sr_list_paginate').css("display", "none");
        }
        }

        });
/*
    $('#verified_document').dataTable( {
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
  
*/
  
  });
  
  
  
  
  
   $('#contact_info')
        .find('[name="customer_mobile"]')
            .intlTelInput({
                utilsScript: 'js/utils.js',
                autoPlaceholder: true,

                preferredCountries: ['my']
            });
   
   
   
   FormValidation.Validator.email_exist = {
        validate: function(validator, $field, options) {
            var value = $field.val();
            
            // ajax to check if mail is already in the database
            
            var formData = {
            'email'     : value
        }
  
    
        var feedback = $.ajax({
          
          type: "POST",
          url: "check_if_email_exist.php",
            data: formData,
        
            async: false,
          
          }).complete(function(){
        
          }).responseText;
            
            
            if(feedback > 0){
            
              return false;
            
            }else{
            return true;
            
            }

         
        }
    };
    
            
   $('#contact_info')
        .formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                customer_mobile: {
                    validators: {
                        callback: {
                            message: 'The phone number is not valid',
                            callback: function(value, validator, $field) {
                                return value === '' || $field.intlTelInput('isValidNumber');
                            }
                        },
                        
                        notEmpty: {
                        message: 'The mobile phone is required',
                    },
                    }
                },
                new_email: {
                validators: {
                    emailAddress: {
                        message: 'The value is not a valid email address'
                    },
                    
                    email_exist: {
                        message: 'This e-mail address already exist! Please use a different one.'
                    }
                    
                    
                  }
                }
            }
                

                
        }).on('success.form.fv', function(e) {
         e.preventDefault();
        
        var input = $("#customer_mobile")
        var new_mobile_number = input.intlTelInput("getNumber");
        var old_number = "<?php echo $mobile_number;?>";
        
        var account_id = "<?php echo $account_id;?>";
        
      var new_email = $('#new_email').val();
    
        var number_need_update = 0;
        var email_need_update = 0;
        
        if(old_number != new_mobile_number){
        
          number_need_update = 1;
        
        }
        
        if(new_email != ""){
        
          email_need_update = 1;
        
        }
    
        var nothig_to_upate_headline = "<?php echo NOTHING_TO_UPDATE_HEADLINE;?>";
        var nothig_to_upate_text = "<?php echo NOTHING_TO_UPDATE_TEXT;?>";
        
        if(number_need_update == 0 && email_need_update == 0){
        
          swal(nothig_to_upate_headline, nothig_to_upate_text, "info");

        
        }else{
        
        
         /* var formData = {
            'account_id'    : account_id
            
        } 
    
        var feedback = $.ajax({
          
          type: "POST",
          url: "send_contact_information_update_code.php",
            data: formData,
        
            async: false,
          
          }).complete(function(){
        
          }).responseText;
          
          
          $('#modal_confirm_contact_change').modal('show');*/
          
          var account_id =  "<?php echo $user_id;?>";
          var new_email = $('#new_email').val();

          var new_mobile_number = input.intlTelInput("getNumber");
      

           var formData = {
            'account_id'    : account_id,
            'new_email'    : new_email,
            'new_mobile_number'    : new_mobile_number
            
        } 
    
        var feedback = $.ajax({
          
          type: "POST",
          url: "update_contact_information.php",
            data: formData,
        
            async: false,
          
          }).complete(function(){
        
          }).responseText;
          
          
          var contact_update_success = "<?php echo CONTACT_UPDATE_SUCCESS;?>";
          var contact_update_success_text = "<?php echo CONTACT_UPDATE_SUCCESS_TEXT;?>";
          var contact_update_success_ok = "<?php echo CONTACT_UPDATE_SUCCESS_OK;?>";
          
          swal({
            title: contact_update_success,
            text: contact_update_success_text,
            type: "success",
            showCancelButton: false,
            confirmButtonColor: "#5cb85c",
            confirmButtonText: contact_update_success_ok,
            closeOnConfirm: false
        },
        function(){
            location.reload();
        });

        
        }
    
        
        
        
        
        });
        
        
        
$('#validation_reset')
        .formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                confirmaton_code: {
                validators: {
                    notEmpty: {
                        message: 'Please key in the confirmation code'
                    }
                    
                    
                  }
                }
            }
                

                
        }).on('success.form.fv', function(e) {
         e.preventDefault();
         
         
         confirmaton_code
         
         var confirmation_code = $('#confirmaton_code').val();
         var account_id =  "<?php echo $account_id;?>";
         
         var formData = {
            'account_id'    : account_id,
            'confirmation_code'    : confirmation_code
            
        } 
    
        var feedback = $.ajax({
          
          type: "POST",
          url: "verify_confirmation_code.php",
            data: formData,
        
            async: false,
          
          }).complete(function(){
        
          }).responseText;
          
          
          
      if(feedback == "ok"){
      
          var account_id =  "<?php echo $account_id;?>";
          var new_email = $('#new_email').val();
          var input = $("#customer_mobile")
          var new_mobile_number = input.intlTelInput("getNumber");
      

           var formData = {
            'account_id'    : account_id,
            'new_email'    : new_email,
            'new_mobile_number'    : new_mobile_number
            
        } 
    
        var feedback = $.ajax({
          
          type: "POST",
          url: "update_contact_information.php",
            data: formData,
        
            async: false,
          
          }).complete(function(){
        
          }).responseText;
          
          
          var contact_update_success = "<?php echo CONTACT_UPDATE_SUCCESS;?>";
          var contact_update_success_text = "<?php echo CONTACT_UPDATE_SUCCESS_TEXT;?>";
          var contact_update_success_ok = "<?php echo CONTACT_UPDATE_SUCCESS_OK;?>";
          
          swal({
            title: contact_update_success,
            text: contact_update_success_text,
            type: "success",
            showCancelButton: false,
            confirmButtonColor: "#5cb85c",
            confirmButtonText: contact_update_success_ok,
            closeOnConfirm: false
        },
        function(){
            location.reload();
        });
          
          
        
      }
      
      
      if(feedback == "nok"){
      
              var contact_update_error = "<?php echo CONTACT_UPDATE_ERROR;?>";
          var contact_update_error_text = "<?php echo CONTACT_UPDATE_ERROR_TEXT;?>";
          var contact_update_error_ok = "<?php echo CONTACT_UPDATE_ERROR_OK;?>";
      
      
          swal({
            title: contact_update_error,
            text: contact_update_error_text,
            type: "error",
            showCancelButton: false,
            confirmButtonColor: "#5cb85c",
            confirmButtonText: contact_update_error_ok,
            closeOnConfirm: false
        },
        function(){
            location.reload();
        });
        

      
      }
      
      
         
         

         
    
         
         
         });
        
        
var name_error =   "<?php echo NAME_ERROR;?>";
var firstname_error =    "<?php echo FIRSTNAME_ERROR;?>";  
var street_1_error =    "<?php echo STREET_1_ERROR;?>"; 
var zip_error =    "<?php echo ZIP_ERROR;?>"; 
var city_error =    "<?php echo CITY_ERROR;?>"; 

var billing_update_success = "<?php echo BILLING_UPDATE_SUCCESS;?>";
var billing_update_success_text = "<?php echo BILLING_UPDATE_SUCCESS_TEXT;?>";

 
        
$('#billing_info')
        .formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                firstname: {
                validators: {
                    notEmpty: {
                        message: name_error
                    }
                    
                    
                  }
                },
                
                name: {
                validators: {
                    notEmpty: {
                        message: firstname_error
                    }
                    
                    
                  }
                },
                
                street_1: {
                validators: {
                    notEmpty: {
                        message: street_1_error
                    }
                    
                    
                  }
                },
                
                zip: {
                validators: {
                    notEmpty: {
                        message: zip_error
                    }
                    
                    
                  }
                },
                
                city: {
                validators: {
                    notEmpty: {
                        message: city_error
                    }
                    
                    
                  }
                }
            }
                

                
        }).on('success.form.fv', function(e) {
         e.preventDefault();
         
          var company_name = $('#company_name').val();
      var firstname  = $('#firstname').val();
      var name  = $('#name').val();
      var billing_street_1  = $('#street_1').val();
      var billing_street_2  = $('#street_2').val();
      var billing_zip  = $('#zip').val();
      var billing_city  = $('#city').val();
      var billing_state  = $('#state').val();
      var account_id =  "<?php echo $account_id;?>";
      
      
      var formData = {
            'company_name'    : company_name,
            'firstname'    : firstname,
            'name'    : name,
            'billing_street_1'    : billing_street_1,
            'billing_street_2'    : billing_street_2,
            'billing_zip'    : billing_zip,
            'billing_city'    : billing_city,
            'billing_state'    : billing_state,
            'account_id'    : account_id
                      
        }
      
      
      var feedback = $.ajax({
          
          type: "POST",
          url: "update_billing_information.php",
            data: formData,
        
            async: false,
          
          }).complete(function(){
        
          }).responseText;
          
          
        swal({
            title: billing_update_success,
            text: billing_update_success_text,
            type: "success",
            showCancelButton: false,
            confirmButtonColor: "#5cb85c",
            confirmButtonText: "OK",
            closeOnConfirm: false
        },
        function(){
            location.reload();
        });
         
         
         
         
         
         });
        
     
//checkinfo form starts
$('#checkr_info')
        .formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                customer_ssn: {
                    validators: {
                        callback: {
                            message: 'The SSN number is not valid',
                            callback: function(value, validator, $field) {
                                return value === '' || $field.intlTelInput('isValidNumber');
                            }
                        },
                        
                        notEmpty: {
                        message: 'The SSN number is required',
                    },
                    }
                },
                zipcode: {
                  validators: {
                                               
                        notEmpty: {
                        message: 'The Zip code is required',
                    }
                  }
                }
            }
                

                
        }).on('success.form.fv', function(e) {
         e.preventDefault();
        
		  document.getElementById('checkrsex').innerHTML='';
	     document.getElementById('checkrerror').innerHTML='';
	     document.getElementById('checkrssn').innerHTML='';
	     document.getElementById('checkterrwl').innerHTML='';
	     document.getElementById('checkrgwtch').innerHTML='';        
        var ssn = $("#customer_ssn").val();
        var zipcode = $("#zipcode").val();
        var account_id = "<?php echo $row_accout_id['id'];?>";
        var first_name = "<?php echo $row_accout_id['firstName'];?>";
        var mid_name= "<?php echo $row_accout_id['midName'];?>";
        var last_name = "<?php echo $row_accout_id['surName'];?>";
        var dob="<?php echo $row_accout_id['dob'];?>";
        var email = "<?php echo $row_accout_id['email'];?>";
        var phone="<?php echo $row_accout_id['phone'];?>";
        
        
        var formData = {
            'account_id':account_id,
            'ssn' : ssn,
            'zipcode':zipcode,
            'first_name':first_name,
            'mid_name':mid_name,
            'last_name':last_name,
            'dob':dob,
            'email':email,
            'phone':phone
            
            
        }; 
        
       // alert(mid_name);
       

        ///
        var feedback = $.ajax({
          
          type: "POST",
          url: "checkr/validate_user.php",
            data: formData,
        
            async: false,
          
          }).complete(function(){
          /**
            swal({
                  title: "Success",
                  text: "Your Checkr verfication completed successfully with status Pending ",
                  type: "success",
                  showCancelButton: false,
                  confirmButtonColor: "#5cb85c",
                  confirmButtonText: "OK",
                  closeOnConfirm: false
                },function(){
 
                                    location.reload();
 
                });
         **/
          }).responseText;
        //alert(feedback); 
        //console.log(feedback); 
		  //return;        
        
        var obj=JSON.parse(feedback);
        var objerr = obj[0].error;
        var objstatus = obj[0].status;
        var objssn_trace_id = obj[0].ssn_trace_id;
        var objsex_offender_search_id = obj[0].sex_offender_search_id;
        var objglobal_watchlist_search_id = obj[0].global_watchlist_search_id;
        var objterrorist_watchlist_search_id = obj[0].terrorist_watchlist_search_id;
        var msg;
             
        //alert("status"+objstatus);
        //alert("objssn_trace_id"+objssn_trace_id);
        
        if(typeof objsex_offender_search_id!=='undefined'){
          document.getElementById('checkrsex').innerHTML='Sex offender search - <span style="color:green">PASSED</span>';
        }else{
        	 document.getElementById('checkrsex').innerHTML='Sex offender search - <span style="color:red">FAILED</span>';
        }
        if(typeof objglobal_watchlist_search_id!=='undefined'){        
          document.getElementById('checkrgwtch').innerHTML='Global watchlist search - <span style="color:green">PASSED</span>';
        }else{
			 document.getElementById('checkrgwtch').innerHTML='Global watchlist search - <span style="color:red">FAILED</span>';        
        }
        if(typeof objterrorist_watchlist_search_id!=='undefined'){
          document.getElementById('checkterrwl').innerHTML='Terrorist wathlist search - <span style="color:green">PASSED</span>';
        }else{
          document.getElementById('checkterrwl').innerHTML='Terrorist wathlist search - <span style="color:red">FAILED</span>';        
        }
        if(typeof objerr!=='undefined'){
         document.getElementById('checkrerror').innerHTML=objerr;
        }
        if(typeof objssn_trace_id!=='undefined' ){
         document.getElementById('checkrssn').innerHTML='SSN verification  - <span style="color:green">PASSED</span>';
        }else {
        	 document.getElementById('checkrssn').innerHTML='SSN verification  - <span style="color:red">FAILED</span>';
        }
       
        document.getElementById('checkr_response').style.display='block';
        
	     



        
        
          
        //  $('#modal_confirm_contact_change').modal('show');
        });
//////////////////        

        


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
         
         current_latitude =  place.geometry.location.lat();
         current_longitude =  place.geometry.location.lng();
         
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
        ></script>
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
    	$.get("https://ipinfo.io/geo", function(response) {
  					console.log("ipinfo get response: "+response.loc+ ", "+response.country);
					var loc = response.loc.split(',');
  					var pos = {coords : {
        							latitude: loc[0],
        							longitude: loc[1]}};
        			showPosition(pos);
				}, "jsonp");
		
	/*$.get("https://www.googleapis.com/geolocation/v1/geolocate?key=<?php echo $configs['google_map_api']; ?>", function(response)
		{
  					//alert(data);
  					response = JSON.parse(data);
  					console.log("googleapi location picker:"+data);
    				var pos = {coords : {
        							latitude: response.location.lat,
        							longitude: resopnse.location.lng}};
        							
        			showPosition(pos);
    				
   }, "jsonp");*/
   /*locurl = "https://www.googleapis.com/geolocation/v1/geolocate?key=<?php echo $configs['google_map_api']; ?>&libraries=places";
   
   $.ajax({
          type: "GET",
          url: locurl,
     		 dataType: "json",
     		 crossOrigin: true,
          async: true,
          success: function(data){
          	alert(data);
          }
       }).complete(function(){
		 });*/
		 
    break;
    case error.UNKNOWN_ERROR:
    err.innerHTML = "An unknown error occurred."
    break;
    }
    }
  
   

function showPosition(position) {
     

       console.log(position); 
       //alert("showPosition: "+position);
    
    googlePos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    
      
      current_longitude = position.coords.longitude;
    current_latitude = position.coords.latitude;
    
    var actual_latlng = {lat: parseFloat(current_latitude), lng: parseFloat(current_longitude)};
    
    var geocoder = new google.maps.Geocoder();
    
    geocoder.geocode({'location': actual_latlng}, function(results, status) {
         

                 var jsonConvertedData = JSON.stringify(results);
                 
                 //alert(jsonConvertedData);
                  
                 current_address = results[0].formatted_address;
                 
               
                 
                 $("#autocomplete").val(current_address);
      
         
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
                 
                 
                 $("#autocomplete").val(current_address);
                 
                
      
         
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


      

    
    
    
  
 $('#googleclick').on('click', function () {
		//alert("hi");     
      //geoloc();
    });


$( "#googleclick" ).trigger( "click" );

 function add_current_address()

{
  // alert(current_latitude);alert(current_longitude); return false; 
  var address = $('#autocomplete').val();
  var name = $('#current_address_name').val();  
  //var description = $('#current_address_description').val();
  var categId = $('#categId').val();
  m_amount="";
   $('[name="categId[]"]:checked').each(function () {
    var sThisVal = $(this).val();
    m_amount += ","+ sThisVal;
});
  m_amount=m_amount+",";
  var range_distance = $('#range_distance').val();
  var pos = $('[name="pos"]:checked').length;
var atLeastOneIsChecked = $('[name="checkArray[]"]:checked').length;

if(current_latitude == "" || current_longitude == ""){
  
    swal({
        title: "Warning!",
        text: "Please select current address",
      type: "warning",
      confirmButtonText: 'OK',
      confirmButtonColor: '#E65825',
    });
     return false;  
  }

  if(address == ""){
  
    swal({
        title: "Warning!",
        text: "Please enter a address name for this location",
      type: "warning",
      confirmButtonText: 'OK',
      confirmButtonColor: '#E65825',
    });
     return false;  
  }
  
  if(name == ""){
  
    swal({
        title: "Warning!",
        text: "Please enter a address name for this location",
      type: "warning",
      confirmButtonText: 'OK',
      confirmButtonColor: '#E65825',
    });
     return false;  
  }
  
   if(range_distance == ""){
  
    swal({
        title: "Warning!",
        text: "Please Enter Area distance",
      type: "warning",
      confirmButtonText: 'OK',
      confirmButtonColor: '#E65825',
    });
    
    return false; 
  
  }
  
var atLeastOneIsChecked = $('[name="categId[]"]:checked').length;     
   if(atLeastOneIsChecked == 0){
  
    swal({
        title: "Warning!",
        text: "Please Select Category.",
      type: "warning",
      confirmButtonText: 'OK',
      confirmButtonColor: '#E65825',
    });
    
    return false; 
  
  }

  
  
  // store address in service_request_addresses
  
  var formData = {
        'pos'     : pos,
        'name'     : name,
        'address'     : address,
       // 'description'     : description,
        'latitude'     : current_latitude,
        'categId'     : m_amount,
        'range_distance'     : range_distance,
        'longitude'     : current_longitude
    }
    
    
     var feedback = $.ajax({
          type: "POST",
          url: "range_area_add.php",
            data: formData,
        
            async: false,
          
                
         }).complete(function(){
        
          }).responseText;


        if(feedback != "fail")
        {
         swal({
                  title: "Success",
                  text: "Your Location is added.",
                  type: "success",
                  showCancelButton: false,
                  confirmButtonColor: "#5cb85c",
                  confirmButtonText: "OK",
                  closeOnConfirm: false
                },
                function(){
 
                                    location.reload();
 
                });
        }
        else
        {
          swal({
                  title: "Error",
                  text: "Your Location is already added.",
                  type: "warning",
                  showCancelButton: false,
                  confirmButtonColor: "#5cb85c",
                  confirmButtonText: "OK",
                  closeOnConfirm: false
                });
        }
        

           
           
        
          
           
       

} 

   function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;
         
         if (charCode == 46 && evt.srcElement.value.split('.').length>1) { return false; } 

          return true;
       } 

       /////google map circle radius location start - 08.05.19
      <?php if($count_addr > 0)
    {  ?>
      
     var gLat=<?php echo $lat; ?>;
   var gLng=<?php echo $lng; ?>;
      var citymap = {
        chicago: {
          center: {lat: gLat, lng: gLng},
          population: 2714856
        }
      };

      function initMap() {
        // Create the map.
        var map = new google.maps.Map(document.getElementById('googleMap'), {
          zoom: 12,
          center: {lat: gLat, lng: gLng},
          mapTypeId: 'terrain'
        });

        
        for (var city in citymap) {
          // Add the circle for this city to the map.
          var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map,
            center: citymap[city].center,
            radius: Math.sqrt(citymap[city].population) * 1
          });
        }
      }

      <?php } ?>
      /////google map circle radius location End - 08.05.19

      $(document).on("click", ".viewmapclick", function(e) {
     var id = $(this).data("id"); 

     var rtrnObj=(urlCall('./viewmap.php?id='+id));
    $('#modal_viewmapclick').modal('show');   
    $(".bluedet_id").html(rtrnObj);
    
    });
      var mainpageclick = localStorage.getItem("mainpageclick");    
      if(mainpageclick == "buyer")
      {        
      
       $("#accordion_4").children().bind('click', function(){ return false; });
       //$(".ui-accordion-header").css("background-color","yellow");
		 $("#accordion_4").children().css("cursor","not-allowed");
		 $("#accordion_4").find("a").css("cursor","not-allowed");
		 $("#accordion_4").find(".panel-heading").css("background-color", "#dedede");
      }else{
      	$("#accordion_4").children().bind('click', function(){});
      }
</script>
