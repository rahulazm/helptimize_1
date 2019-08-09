<?php

session_start();

if (isset($_GET['session_id'])) {

	$session_id = $_GET['session_id'];
	$_SESSION["session_id"] = $session_id;

}else{

	$session_id = $_SESSION["session_id"];

}

include "check_session.php";


?>



<script
  src="https://code.jquery.com/jquery-1.12.4.min.js"
  integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
  crossorigin="anonymous"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- FormValidation CSS file -->
<link rel="stylesheet" href="css/formValidation.min.css">

<link rel="stylesheet" type="text/css" href="css/sweetalert.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-switch.min.css">
<link rel="stylesheet" type="text/css" href="css/jquery.bootstrap-touchspin.min.css">


<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="js/bootstrap-switch.min.js"></script>

<!-- FormValidation plugin and the class supports validating Bootstrap form -->
<script src="js/formValidation.min.js"></script>
<script src="js/framework/bootstrap.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script src="js/jquery.bootstrap-touchspin.min.js"></script>


<script src="https://use.fontawesome.com/ad58aaa527.js"></script>


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

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><img alt="Brand" src="img/helptimizeapp_logo_small.png"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Lead Management <span class="caret"></span></a>
          <ul class="dropdown-menu">
            
            <li><a href="address_crawler.php">Crawl Addresses</a></li>
            <li><a href="manage_addresses_search.php">Manage Addresses</a></li>
             

          </ul>
        </li>
        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Settings<span class="caret"></span></a>
          <ul class="dropdown-menu">
          <li><a href="category_management_main_list.php">Categories</a></li>
            <li><a href="pipedrive_settings.php">Pipedrive</a></li>
            <li><a href="phone_number_settings.php">Phone Number Format</a></li>
            <li><a href="various_settings.php">Various</a></li>
          

          </ul>
        </li>
        
        
      </ul>
     
     
     <ul class="nav navbar-nav navbar-right">
        
        <li><a href="logout.php">Logout</a></li>
        
        
      </ul>
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>