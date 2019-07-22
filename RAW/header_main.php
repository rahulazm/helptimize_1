<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require("common.inc.php");

require_once "check_session.php";

require_once("mysql_lib.php");



/*--------------------- daniel's notification message grabber -------------*/
$db_count_unread_messages = new mysqli("$host", "$username", "$password", "$db_name");

if($db_count_unread_messages ->connect_errno > 0){
    die('Unable to connect to database [' . $db_count_unread_messages ->connect_error . ']');
}

$sql_count_unread_messages = "SELECT id FROM message_list WHERE receiver_id='".$_SESSION['id']."' AND read_status='0'";

$result_count_unread_messages = $db_count_unread_messages->query($sql_count_unread_messages);
$count_unread_messages = $result_count_unread_messages->num_rows;

$db_count_unread_messages->close();
//$_template["footer"]=include "push_notification_listener.php"; 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="js/jquery-3.4.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="./formvalidation/js/formValidation.min.js"></script>
    <script src="./formvalidation/js/framework/bootstrap.min.js"></script>  
    <link rel="stylesheet" href="./formvalidation/css/formValidation.min.css">

    <script src="js/helptimize.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/googleMap.js"></script>
    <script src="js/custom.js"></script>
    <script src="assets/js/jquerysession.js"></script>
    <script src="js/moment.min.js"></script>
    <link href="css/sweetalert.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />


    <!--<link href="css/bootstrap-square.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    
    <link href="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/helptimize_main.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
    <script src="https://use.fontawesome.com/a91275e4b2.js"></script>
    <script src="https://js.pusher.com/4.0/pusher.min.js"></script> 

    <title>HELPTIMIZE</title>
  </head>
  <body>
    <div class="container-fluid">
        <header>
            <div class="row align-header">
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <img src="./assets/images/helptimize.png"/>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <nav class="nav">
                    <a class="nav-link active" href="#">Dashboard</a>
                    <a class="nav-link" href="#">Payments</a>
                    <a class="nav-link" href="#">Settings</a>
                    </nav>
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="switch-btn">
                    <span><input type="radio" id="requester" name="switch" onclick="getDetails('requester1');" /><label for="requester">Requester</label></span>
                    <span><input type="radio" id="provider" name="switch" onclick="getDetails('seller');" checked/><label for="provider">Provider</label></span>
                    </div>
                </div>
                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1 text-right">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle profile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="#">link1</a>
                            <a class="dropdown-item" href="#">link2</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
