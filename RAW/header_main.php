<?php
/*ini_set('display_errors', 1);
error_reporting(E_ALL);
$_configs = include("/etc/helptimize/conf.php");*/
require("common.inc.php");

require_once "check_session.php";

require_once("mysql_lib.php");

require_once("en.lang.inc.php");



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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" crossorigin="anonymous">

    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script src="js/googleMap.js"></script>
    <!-- <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo $_configs['google_map_api'];?>&libraries=places&callback=initAutocomplete">
        </script> -->
    <!-- <script src="js/jquery-3.4.1.js"></script> -->
    <script src="js/bootstrap.js"></script>
    <script src="./js/formValidation.min.js"></script>
    <!-- <script src="./js/framework/bootstrap.min.js"></script>   -->
    <link rel="stylesheet" href="./css/formValidation.min.css">

    <script src="js/helptimize.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.js"></script>
    <script src="js/sweetalert.min.js"></script>
    
    <!--<script src="js/custom.js"></script>-->
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
    <style>
    .modal-open .modal{
      position: absolute;
        height: auto;
        z-index: 99999;
        top: 25%;
        margin: auto;
        left: 33%;
    }

    .modal-header .close{
          right: -5px;
        position: absolute;
        top: -33px;
    }
    </style>
    
    <title>HELPTIMIZE</title>
  </head>
  <body>
    <div class="container-fluid">
        <header>
            <div class="row align-header">
                <div class="col-sm-2 col-md-6 col-lg-2 col-xl-2 col-12">
                    <img src="./assets/images/helptimize.png"/>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-12">
                    <nav class="nav">
                    <a class="nav-link active" href="main.php">Dashboard</a>
                    <a class="nav-link" href="#">Payments</a>
                    <a class="nav-link" href="my_account.php">Settings</a>
                    </nav>
                </div>
                <div class="col-sm-3 col-md-6 col-lg-3 col-xl-3 col-12">
                    <div class="switch-btn">
                    <span><input type="radio" id="requester" name="switch" onclick="getDetails('requester1');" /><label for="requester">Requester</label></span>
                    <span><input type="radio" id="provider" name="switch" onclick="getDetails('seller');"/><label for="provider">Provider</label></span>
                    </div>
                </div>
                <div class="col-sm-1 col-md-6 col-lg-1 col-xl-1 text-right" style="padding: 0 10px">
                    <span>
                        <a href="message_list.php" class="btn btn-default message_button_background message_button_border" style="padding: 0"> <i class="fa fa-bell " aria-hidden="true" style="color:#ff9900"></i>  <span class="label label-danger message_counter"><?php echo $count_unread_messages; ?></span></a> 
                    </span>
                    <div class="btn-group" role="group" style="position: unset;">
                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle profile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="my_account.php">My Account</a>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
<div id="modal_push_notification" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="width:100%"><center>
                    <?php echo PUSH_NOTIFICATION_HEADER; ?></center></h4>
              </div>
                <div class="modal-body">
                
                <center>
                <span id="modal_push_notification_icon"></span>
                
                <br>
                <span id="modal_push_notification_text"></span>
                <br>
                
                <a class="btn btn-success" href="" id="pushurl">View</a>
                    <button class="btn btn-success" onclick="push_notification_close()"><?php echo CLOSE; ?></button>
                
                </center>
                
                </div>
            </div>
        </div>
    </div>

    <script>
Pusher.logToConsole = true;  

    var account_id_pop_up = "<?php echo $_SESSION['id']; ?>";
    console.log(account_id_pop_up);
    var pusher = new Pusher("<?php echo $_configs['push_app_key']; ?>", {
         cluster: "mt1",
      encrypted: true
    });
    
    var channel_pop_up = pusher.subscribe("pop_up_message");
    channel_pop_up.bind(account_id_pop_up, function(data) {
    
       var message = data.message;
       
       var message = message.split("|");
       
       var message_text = message[0];
       var message_type = message[1];
       var message_url = message[2];
       
       console.log(message_text);
         console.log(message_type);
        localStorage.setItem("pushfrom", message_type);
       if(message_type == "info" || message_type == "sr"|| message_type == "newbid"|| message_type == "award" || message_type == "shortlist"|| message_type == "accept"){
       
        $("#modal_push_notification_icon").html(" <i class=\'fa fa-info-circle fa-2\' aria-hidden=\'true\'></i>");
          }
          
          if(message_type == "alert"){
       
        $("#modal_push_notification_icon").html(" <i class=\'fa fa-exclamation-triangle fa-2\' aria-hidden=\'true\'></i>");
          }
       
      
       
      $("#modal_push_notification_text").html("<h5>" + message_text + "</h5>");
      
       


$("#pushurl").attr("href", message_url);


      $("#modal_push_notification").modal("show");
    
    
    });
    
    
    function push_notification_close(){
   
   $("#modal_push_notification").modal("hide");
   
  
   
};

function push_notification_view(){
   
   $("#modal_push_notification").modal("hide");
   
   //location.reload();
   window.location.href="main.php";
   
   
};
    </script>