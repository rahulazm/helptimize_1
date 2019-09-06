<?php
$sid=session_start();
$_SESSION['sid']=session_id();


$language = $_GET['language'];

if($language =="en" or $language =="" ){
 	$_SESSION["language"] = "en";
    include 'en.lang.inc.php';

}

if($language =="de"){
	$_SESSION["language"] = "de";
	include 'de.lang.inc.php';
}


?>


<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

  <head>
   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="helptimizehelptimize "/>
    <link rel="shortcut icon" href="./favicon.png">
    <script src="./js/jquery-1.11.3.min.js"></script>
    <script src="js/formValidation.min.js"></script>
    <script src="js/framework/bootstrap.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<script src="./js/framework/bootstrap.min.js"></script>
	<script src="./js/sweetalert.min.js"></script>
	<script src="./js/intlTelInput.min.js"></script>
	<script src="./js/helptimize.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.3.0/zxcvbn.js"></script>

        <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" crossorigin="anonymous">
	<title>HELPTIMIZE</title>
    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.css" rel="stylesheet">
     <link href="./css/sweetalert.css" rel="stylesheet">
     <link rel="stylesheet" href="./css/intlTelInput.css" />
     <link rel="stylesheet" href="./css/formValidation.min.css">
     
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="mobile-web-app-capable" content="yes">

 <link rel="apple-touch-icon-precomposed" sizes="57x57" href="./apple-touch-icon-57x57.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="./apple-touch-icon-114x114.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="./apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="./apple-touch-icon-144x144.png" />
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="./apple-touch-icon-60x60.png" />
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="./apple-touch-icon-120x120.png" />
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="./apple-touch-icon-76x76.png" />
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="./apple-touch-icon-152x152.png" />
<link rel="icon" type="image/png" href="./favicon-196x196.png" sizes="196x196" />
<link rel="icon" type="image/png" href="./favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/png" href="./favicon-32x32.png" sizes="32x32" />
<link rel="icon" type="image/png" href="./favicon-16x16.png" sizes="16x16" />
<link rel="icon" type="image/png" href="./favicon-128.png" sizes="128x128" />
<meta name="application-name" content="&nbsp;"/>
<meta name="msapplication-TileColor" content="#FFFFFF" />
<meta name="msapplication-TileImage" content="mstile-144x144.png" />
<meta name="msapplication-square70x70logo" content="mstile-70x70.png" />
<meta name="msapplication-square150x150logo" content="mstile-150x150.png" />
<meta name="msapplication-wide310x150logo" content="mstile-310x150.png" />
<meta name="msapplication-square310x310logo" content="mstile-310x310.png" />


    <!-- Custom styles for this template -->
    <link href="./css/login-theme-1.css" rel="stylesheet">

    <link href="./css/formValidation.min.css" rel="stylesheet">


    <style>
body { color: inherit;}
.password-progress {   margin-top: 10px;   margin-bottom: 0;}
#login-block{padding:0px !important;}
testbody{background:url('./assets/images/loginbg.jpg');background-repeat: no-repeat;}
body{background:#fff; padding:0px !important;}
.login-box{margin-top:0px !important;}
.nopadding{padding:0px !important;}
.new_register{float: none;width: 36%;margin: 0 auto;text-align: center;}
.row {  margin: 0px;}
.login-box{max-width:100% !important;width:100% !important;}
#login{margin:0 auto;}
#login input[type="text"]{background:#f5f5f5;border:none !important;box-shadow: none !important;height: 39px;}
#login input[type="password"]{background:#f5f5f5;border:none !important;box-shadow: none !important;height: 39px;}
.login-logo img{width:22%;}
.loginbtn{width:100%; background:#108ab1;color:#fff;height: 39px;}
.forgetpwd{text-align: right;display: block;padding: 10px 0px;color:#0085ff !important;  }
.loginwith{margin-top:5%;}
.loginwrap{width:50%;float: none;text-align: center;margin: 0 auto;}
.loginwrap h6{float: left;width: 60%;text-align: left;}
.loginwrap h6 span{color: #939393;display: block;}
.loginwithlink{background:url('./assets/images/loginwithlinkedin.png');background-repeat: no-repeat;height: 39px;width: 301px;display: block;margin: 24px auto;}
.loginwithgoogle{background:url('./assets/images/loginwithgoogle.png');background-repeat: no-repeat;height: 39px;width: 301px;display: block;margin: 24px auto;}
.new_register{background:#f69a13; color:#fff; width:100px;border:none;}
.clr{clear:both;}
.agbtn{font-size: 13px;background: orange;width: 155px;padding: 7px 13px;border-radius: 20px;float: none;font-weight: bold;text-align: center;  }
.agreebox{display: block; border:1px solid #ccc;  padding: 10px;    margin-bottom: 20px;}
.agreebox ul{padding: 0px; list-style: disc;  margin-left: 3%;}
#age{border: 1px solid #ccc;
padding: 7px 11px;
border-radius: 11px;
margin-left: 11px;}
.login-form input{
  width: 100% !important;
}
.modal-dialog{
  max-width: 600px !important;
}
.modal-header .close{
  padding: 0px !important;
  margin: 0px !important;
}
.modal-title{
  width: 100% !important;
}

@media only screen  and (max-width: 1023px) {
  .login-carousel{
    height: auto;
  }
  .login-carousel,
  .login{
    width: 100% !important;
    margin-bottom: 50px;
  }
}

@media only screen  and (max-width: 768px) {
  .flex-layout{
    flex-direction: column;
  }
  }
#frmCheckUsername {border-top:#F0F0F0 2px solid;background:#FAF8F8;padding:10px;}
.demoInputBox{padding:7px; border:#F0F0F0 1px solid; border-radius:4px;}
.status-available{color:#2FC332;}
.status-not-available{color:#D60202;}
#user-availability-status {display: block;}
</style>

<script type="text/javascript">

function checkAvailability() {
	//$("#loaderIcon").show();
	jQuery.ajax({
	url: "check_availability.php",
	data:'username='+$("#customer_parent_username").val(),
	type: "POST",
	success:function(data){
		$("#user-availability-status").html(data);
		//$("#loaderIcon").hide();
	},
	error:function (){}
	});
}

/*jQuery( document ).ready(function() {
     jQuery(".agreeboxtermandcond").hide();
     jQuery(".agreeboxprivacy").hide();
      jQuery(".agreeboxagevar").hide();


    
     jQuery(".agbtn").on("click",function() {
         jQuery(".agreeboxtermandcond").hide();
    });
    
     $(".form-check-input-termcond").click(function () {
            if ($(this).is(":checked")) {
                $(".agreeboxtermandcond").show();

            } else {
                $(".agreeboxtermandcond").hide();

            }
        });
        
          $(".form-check-input-privacy").click(function () {
            if ($(this).is(":checked")) {
                $(".agreeboxprivacy").show();

            } else {
                $(".agreeboxprivacy").hide();

            }
            
            $(".form-check-input-agevar").click(function () {
            if ($(this).is(":checked")) {
                $(".agreeboxagevar").show();

            } else {
                $(".agreeboxagevar").hide();

            }
            
        });
        
        
$(".signupf").on("click",function(){
    if (($("input[name*='term']:checked").length) > 0) {

    }   else{  //alert("Agree To Term and Condition");
  }
    return true;
});

$(".signupf").on("click",function(){
    if (($("input[name*='privacy']:checked").length) > 0) {

    }   else{  //alert("You must agree to Privacy Policy");
  }
    return true;
});

    

});*/





</script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


  </head>
    <body>



<script type="text/javascript">
$( document ).ready(function() {
$('.parentName').hide();
  // jQuery("#age").html(age+' Enter The Parent Name');
  $("#customer_dob").datepicker({
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
      minDate: "-80Y", 
      maxDate: "-14Y"
    });
 $("#customer_dob").on('change',function(){
       var dob1 = $(this).val();
       var dob = $.datepicker.formatDate('yy-mm-dd', new Date(dob1));
       var str = dob.split('-');
       var firstdate=new Date(str[0],str[1],str[2]);
       var today = new Date();
       var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
       var age = parseInt(dayDiff);
      if((age => 14) && (age <= 18)){
          $('.parentName').show();
      }else{
          $('.parentName').hide();
      }


       });

 $(".signupf").on("click",function(){
    if($("#frmCheckUsername").css("display") == "block"){
      if($.trim($("#customer_parent_username").val()) == ""){
        swal("Ooops!", "Please enter your parent / guardian username as you are below 18 years of age", "error");
        //alert("You must agree to Privacy Policy");
        return false;
      }
      if (($("input[name*='age_verf']:checked").length) > 0) {

      }else {  
        swal("Ooops!", "Please read and agree Age Verification Policy", "error");
        //alert("You must agree to Privacy Policy");
        return false;
      }


    }

    if (($("input[name*='terms']:checked").length) > 0) {

    } else{  
      swal("Ooops!", "Please read and agree to Terms and Conditions", "error");
      return false;
    }

    if (($("input[name*='privacy']:checked").length) > 0) {

    }else{  
      swal("Ooops!", "Please read and agree to Privacy Policy", "error");
      //alert("You must agree to Privacy Policy");
      return false;
    }


    return true;
  });
});
</script>







    <div id="modal_new_sign_up" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        	<div class="modal-content">
        		<div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            		<h4 class="modal-title" style="color:#000000";><center><!-- <i class="fa fa-info-circle fa-2x" aria-hidden="true"></i>  --><?php echo NEW_SIGN_UP ;?></center></h4>
            	</div>
            		<div class="modal-body">

            	<?php //echo NEW_SIGN_UP ;?>


            	<form id="new_sign_up">


            	   <!--<div class="form-group">
  						<label><font color="black"><?php /*echo CUSTOMER_COMPANY_NAME;*/?><?font></label>
  						<input placeholder="<?php /*echo CUSTOMER_COMPANY_NAME_PLACEHOLDER;*/?>" type="text" class="form-control" id="customer_company_name" name="customer_company_name">
					</div>-->


            		<div class="form-group">
  						<label><?php echo CUSTOMER_FIRST_NAME;?></label>
  						<input placeholder="<?php echo CUSTOMER_FIRST_NAME_PLACEHOLDER;?>" type="text" class="form-control" id="customer_first_name" name="customer_first_name">
					</div>

					<div class="form-group">
  						<label<?php echo CUSTOMER_FAMILY_NAME;?></label>
  						<input placeholder="<?php echo CUSTOMER_FAMILY_NAME_PLACEHOLDER;?>" type="text" class="form-control" id="customer_family_name" name="customer_family_name">
					</div>


					<div class="form-group">
  						<label><?php echo CUSTOMER_USERNAME;?></label>
  						<input placeholder="<?php echo CUSTOMER_USERNAME_PLACEHOLDER;?>" type="text" class="form-control" id="customer_username" name="customer_username">
					</div>

					<div class="form-group">
					<label for="usr"><?php echo CUSTOMER_EMAIL;?></label>
  						<input type="text" class="form-control" id="customer_email" name="customer_email">
					</div>

<div class="form-group">
    <label for="usr">Enter Date Of Birth</label>
    <input type="text" id="customer_dob" class="form-control" name="customer_dob" readonly />
    <!--<p id="age"></p>         -->


</div>

<div class="form-group parentName" id="frmCheckUsername">
     <label for="usr">Enter Parent / Guardian Username</label>
  <input name="customer_parent_username" type="text" id="customer_parent_username" class="demoInputBox form-control" onBlur="checkAvailability()"><span id="user-availability-status"></span>

<!-- <p><img src="img/LoaderIcon.gif" id="loaderIcon" style="display:none" /></p> -->


            		 <input type="checkbox" class="form-check-input-agevar" name="age_verf" value="1" />


I read and agree to the  <a href="#" onclick="javascript:window.open('parenttermandcondition.html','RefundPolicyHelp', 'top=20, left=20, width=620, height=750, scrollbars=yes, resizable=yes') ;return false;">age verification</a> terms of service.
                    

</div>



					<div class="form-group">
  						<label for="usr"><?php echo CUSTOMER_MOBILE;?></label>
  						<br>
  						<input type="tel" class="form-control" id="customer_mobile" name="customer_mobile">
  						<br><?php echo PLEASE_KEY_IN_A_VALID_MOBILE_NUMBER ;?>
					</div>



					<div class="form-group">
  						<label for="usr"><?php echo CUSTOMER_PASSWORD;?></label>
  						<input type="password" class="form-control" id="customer_password" name="customer_password">
					</div>

					<div class="progress password-progress">
    <div id="strengthBar" class="progress-bar" role="progressbar" style="width: 0;"></div>
</div>

					<div class="form-group">
  						<label for="usr"><?php echo CUSTOMER_PASSWORD_CONFIRM;?></label>
  						<input type="password" class="form-control" id="customer_password_confirm" name="customer_password_confirm">
					</div>




            		<div class="form-group">
            		 <input type="checkbox" class="form-check-input-termcond" name="terms" value="1" />

                I read and agree to the  <a href="#" onclick="javascript:window.open('termandcondition.html','RefundPolicyHelp', 'top=20, left=20, width=620, height=750, scrollbars=yes, resizable=yes') ;return false;">terms and condition.</a>

                     </div>

                    <div class="form-group">
            		 <input type="checkbox" class="form-check-input-privacy" name="privacy" value="1" />
                         I read and agree the  <a href="#" onclick="javascript:window.open('privacypolicy.html','RefundPolicyHelp', 'top=20, left=20, width=620, height=750, scrollbars=yes, resizable=yes') ;return false;">privacy policy.</a>
                          </div>

                     <div class="form-group">
            		<button type="submit" class="btn btn-success signupf" ><?php echo SIGN_UP;?></button>
                      </div>
                      
            			</form>

            		</center>

            		</div>
            </div>
        </div>
    </div>




     <div id="modal_activation_key" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        	<div class="modal-content">
        		<div class="modal-header">

            		<h4 class="modal-title" style="color:#000000";><center><i class="fa fa-info-circle fa-2x" aria-hidden="true"></i> <?php echo ACTIVATE_ACCOUNT ;?></center></h4>
            	</div>
            		<div class="modal-body">

            		<p><?php echo ACTIVATE_ACCOUNT_TEXT;?></p>
            		<br>

            		<center>
            		<table>
            		<tr>

            		  <td width="150px"> <label><?php echo ACTIVATE_ACCOUNT ;?></label></td>

            		   </tr>
            		  <tr>

            		  <td width="150px">
            		   <form name='activate_account_check' id='activate_account_check' method="post">

            		   <input type="hidden" name="account_id_hidden" id="account_id_hidden" value="">

            		  <div class="form-group">
            		  <input type='text' name='activation_code' id='activation_code' class='form-control'>
            		  </div>
            		  </td>

            		   </tr>


            		</table>
            		</center>
            		<br>

            		<center>
            		<button class="btn btn-default resend_code" ><?php echo RESEND;?></button> &nbsp; &nbsp; &nbsp;<button type="submit" class="btn btn-success" ><?php echo ACTIVATE;?></button>
            		</center>

            		</form>





            		</div>
            </div>
        </div>
    </div>



    <div id="modal_forgot_password" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        	<div class="modal-content">
        		<div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            		<h4 class="modal-title" style="color:#000000";><center><!-- <i class="fa fa-info-circle fa-2x" aria-hidden="true"></i> --> <?php echo PASSWORD_REMINDER ;?></center></h4>
            	</div>
            		<div class="modal-body">

            		<form id="password_forgot_code">
            		<div class="radio">
  						<label><input type="radio" checked name="optradio" id="optradio" value="mail"><?php echo PASSWORD_REMINDER_EMAIL;?></label>
					</div>

					<div class="radio">
  						<label><input type="radio" name="optradio" name="optradio" value="sms"><?php echo PASSWORD_REMINDER_SMS;?></label>
					</div>

					<div class="form-group">
					<label for="usr"><?php echo FORGOT_EMAIL;?></label>
  						<input placeholder="<?php echo FORGOT_EMAIL_PLACEHOLDER;?>" type="text" class="form-control" id="forgot_email" name="forgot_email">
					</div>

					<br>

            		<center>
            		<button type="submit" class="btn btn-success" ><?php echo GET_CODE;?></button>
            		</center>

            		</form>



            		</div>
            </div>
        </div>
    </div>



    <div id="modal_forgot_password_reset" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        	<div class="modal-content">
        		<div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            		<h4 class="modal-title" style="color:#000000";><center><i class="fa fa-info-circle fa-2x" aria-hidden="true"></i> <?php echo PASSWORD_REMINDER ;?></center></h4>
            	</div>
            		<div class="modal-body">
            		<form id="password_forgot_code_reset">


            		 <label><?php echo RESET_CODE ;?></label>

            		   <input type="hidden" name="account_id_hidden_reset" id="account_id_hidden_reset" value="">

            		  <div class="form-group">
            		  <input type='text' name='reset_code' id='reset_code' class='form-control'>
            		  </div>


					<br>

            		<center>
            		<button type="submit" class="btn btn-success" ><?php echo VALIDATE_RESET;?></button>
            		</center>

            		</form>



            		</div>
            </div>
        </div>
    </div>


    <div id="modal_forgot_password_reset_insert" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        	<div class="modal-content">
        		<div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            		<h4 class="modal-title" style="color:#000000";><center><i class="fa fa-info-circle fa-2x" aria-hidden="true"></i> <?php echo PASSWORD_REMINDER ;?></center></h4>
            	</div>
            		<div class="modal-body">
            		<form id="password_forgot_code_reset_insert">

            		 <input type="hidden" name="account_id_hidden_reset_insert" id="account_id_hidden_reset_insert" value="">


            		<div class="form-group">
  						<label for="usr"><?php echo NEW_CUSTOMER_PASSWORD;?></label>
  						<input type="password" class="form-control" id="customer_password_insert" name="customer_password_insert">
					</div>

					<div class="progress password-progress">
    <div id="strengthBar2" class="progress-bar" role="progressbar" style="width: 0;"></div>
</div>

					<div class="form-group">
  						<label for="usr"><?php echo NEW_CUSTOMER_PASSWORD_CONFIRM;?></label>
  						<input type="password" class="form-control" id="customer_password_confirm_insert" name="customer_password_confirm_insert">
					</div>





            		<center>
            		<button type="submit" class="btn btn-success" ><?php echo UPDATE_PASSWORD;?></button>
            		</center>

            		</form>



            		</div>
            </div>
        </div>
    </div>









    	<!-- start Login box -->
<div class="container-fluid" id="login-block">
        <div class="flex-layout">
            <div class="login-carousel">
                <!-- <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active"> -->
                        <img class="d-block w-100" src="./assets/images/login_bg.png" alt="First slide" >
                        <!-- </div>
                        <div class="carousel-item">
                        <img class="d-block w-100" src="./assets/images/login_bg.png" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                        <img class="d-block w-100" src="./assets/images/login_bg.png" alt="Third slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>-->
            </div>
            <div class="login">
              <div class="login-form">
			        	<img src="./assets/images/helptimize.png"/>
			        	<form name='login' id='login' method="post">
	                <div class="form-group">
        					   <input type='text' name='myusername' id='myusername' class='form-control' placeholder='<?php echo USERNAME;?>'>
        					</div>
        					<div class="form-group">
        					   <input type='password' name='mypassword' id='mypassword' class='form-control' placeholder='<?php echo PASSWORD;?>'>
        					</div>
                  <div class="login-links forgetpwd">
					             <p class="text-right" id="forgot_password"><?php echo FORGOT_PASSWORD;?></p>
      						</div>
                  <div>
      						  <button type="submit" class="button-primary WDTH100"><?php echo LOGIN_BUTTON ;?></button>
                  </div>
  							</form>
                <hr/>
                <div>
                    <button class="button-primary WDTH100"><i class="fab fa-linkedin-in"></i>&nbsp;&nbsp;Login with LinkedIn</button>
                </div>
                <div>
                    <button class="button-google WDTH100"><i class="fab fa-google-plus-g"></i>&nbsp;
Login with Google</button>
                </div>
                <div class="flex-layout MRGT20PX">
                  <div class="text-left account">Don't have an account? <br/> <span>Get your free account now.</span></div>
                  <div><button class="orange-btn new_register">Sign Up</button></div>
                </div>
              </div>
            </div>
       </div>
    </div>
    </body>
</html>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!--     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="./assets/js/app.js"></script> -->



<script>




$(document).on("click", ".resend_code", function(e) {

     $('.datepicker').datepicker({
    format: 'mm/dd/yyyy',
    startDate: '-3d'
});

 var account_id = $('#account_id_hidden').val();

  var formData = {
        		'account_id'     : account_id

				}


				var feedback = $.ajax({

    			type: "POST",
    			url: "resend_activation_code.php",
    		    data: formData,

    		    async: false,

    			}).complete(function(){



    			}).responseText;

    			 swal("Success", "You will receive your activation code vis SMS shortly.", "success")



});

$(document).on("click", ".activate_account", function(e) {


$('#modal_activation_key').modal({
  backdrop: 'static',
  keyboard: false
});

	$('#modal_activation_key').modal('show');


});

$(document).on("click", ".new_register", function(e) {

	$('#modal_new_sign_up').modal('show');


});



$(document).ready(function(){

    $('#forgot_password').click(function() {

    	$('#modal_forgot_password').modal('show');


    });




    $('#modal_forgot_password_reset_insert').formValidation({
        framework: 'bootstrap',

        fields: {
            customer_password_insert: {
                validators: {
                    notEmpty: {
                        message: 'You need to enter a password'
                    },

                    callback: {
                        callback: function(value, validator, $field) {
                            var password = $field.val();
                            if (password == '') {
                                return true;
                            }

                            var result  = zxcvbn(password),
                                score   = result.score,
                                message = result.feedback.warning || 'The password is weak';

                            // Update the progress bar width and add alert class
                            var $bar = $('#strengthBar2');
                            switch (score) {
                                case 0:
                                    $bar.attr('class', 'progress-bar progress-bar-danger')
                                        .css('width', '1%');
                                    break;
                                case 1:
                                    $bar.attr('class', 'progress-bar progress-bar-danger')
                                        .css('width', '25%');
                                    break;
                                case 2:
                                    $bar.attr('class', 'progress-bar progress-bar-danger')
                                        .css('width', '50%');
                                    break;
                                case 3:
                                    $bar.attr('class', 'progress-bar progress-bar-warning')
                                        .css('width', '75%');
                                    break;
                                case 4:
                                    $bar.attr('class', 'progress-bar progress-bar-success')
                                        .css('width', '100%');
                                    break;
                            }

                            // We will treat the password as an invalid one if the score is less than 3
                            if (score < 3) {
                                return {
                                    valid: false,
                                    message: message
                                }
                            }

                            return true;
                        }
                    }

                  }
                },

                customer_password_confirm_insert: {
                validators: {
                    identical: {
                        field: 'customer_password_insert',
                        message: 'The password and its confirm are not the same'
                    }
                }
            },




        }
    }).on('success.form.fv', function(e) {

    	 e.preventDefault();

    	 var new_password = $('#customer_password_insert').val();
    	 var account = $('#account_id_hidden_reset_insert').val();

    	 // update password

    	  var formData = {
        		'new_password'     : new_password,
        		'account'     : account

				}

				var feedback = $.ajax({

    			type: "POST",
    			url: "update_password.php",
    		    data: formData,

    		    async: false,

    			}).complete(function(){



    			}).responseText;

    			var password_update_success_header = '<?php echo PASSWORD_UPDATE_SUCCESS_HEADER;?>';
    			var password_update_success_text = '<?php echo PASSWORD_UPDATE_SUCCESS_TEXT;?>';


    			swal({
  				title: password_update_success_header,
  				text: password_update_success_text,
  				type: "success",
  				showCancelButton: false,
  				confirmButtonColor: "#5cb85c",
  				confirmButtonText: "Login",
  				closeOnConfirm: false
				},
				function(){

  				location.reload();

				});





    });



    $('#password_forgot_code_reset').formValidation({
        framework: 'bootstrap',

        fields: {
            reset_code: {
                validators: {
                    notEmpty: {
                        message: "Please key in your password reset code."
                    }

                }
            }


        }
    }).on('success.form.fv', function(e) {

    	 e.preventDefault();

    	 var account = $('#account_id_hidden_reset').val();
    	 var reset_code = $('#reset_code').val();


    	 // check reset code

    	 var formData = {
        		'account'     : account,
        		'reset_code'     : reset_code

				}

				var feedback = $.ajax({

    			type: "POST",
    			url: "check_reset_code.php",
    		    data: formData,

    		    async: false,

    			}).complete(function(){



    			}).responseText;

    			if(feedback == "ok"){


    			$('#account_id_hidden_reset_insert').val(account);
    			$('#modal_forgot_password_reset').modal('hide');
    	        $('#modal_forgot_password_reset_insert').modal('show');



    			}


    			if(feedback == "nok"){

    			 var no_valid_reset_code_header = '<?php echo NO_VALID_RESET_CODE_HEADER;?>';
    	  		 var no_valid_reset_code_text = '<?php echo NO_VALID_RESET_CODE_TEXT;?>';

    	  		swal(no_valid_reset_code_header, no_valid_reset_code_text, "error");



    			}



    });


    $('#password_forgot_code').formValidation({
        framework: 'bootstrap',

        fields: {
            forgot_email: {
                validators: {
                    notEmpty: {
                        message: "Please key in your e-mail address."
                    },
                    emailAddress: {
                        message: "Please key in a valid e-mail address"
                    }

                }
            }


        }
    }).on('success.form.fv', function(e) {

        e.preventDefault();

        var send_type  = $('input[name=optradio]:checked').val();
        var forgot_email = $('#forgot_email').val();

        var formData = {
        		'send_type'     : send_type,
        		'forgot_email'     : forgot_email

				}

				var feedback = $.ajax({

    			type: "POST",
    			url: "send_reset_password_code.php",
    		    data: formData,

    		    async: false,

    			}).complete(function(){



    			}).responseText;

        // echo "ok|" . $account_id . "|" . $reset_code;

    	var feedback_array = feedback.split("|");

    	var feedback_status = feedback_array[0];




    	if(feedback_status == 1){



    	 var account_id = feedback_array[1];

    	 $('#modal_forgot_password').modal('hide');
    	 $('#modal_forgot_password_reset').modal('show');
    	 $('#account_id_hidden_reset').val(account_id);




    	}

    	if(feedback_status == 2){

    	  var no_email_found_header = '<?php echo NO_EMAIL_FOUND_HEADER;?>';
    	  var no_email_found_text = '<?php echo NO_EMAIL_FOUND_TEXT;?>';

    	  swal(no_email_found_header, no_email_found_text, "error");



    	}





        });



    $('#activate_account_check').formValidation({
        framework: 'bootstrap',

        fields: {
            activation_code: {
                validators: {
                    notEmpty: {
                        message: "Please key in your activation code"
                    },
                    integer: {
                        message: "Please only use numbers"
                    }

                }
            }


        }
    }).on('success.form.fv', function(e) {

        e.preventDefault();

        var activation_code = $('#activation_code').val();

        var formData = {
        		'activation_code'     : activation_code

				}


				var feedback = $.ajax({

    			type: "POST",
    			url: "check_activation_code.php",
    		    data: formData,

    		    async: false,

    			}).complete(function(){



    			}).responseText;

        if(feedback == "1"){

            $('#modal_activation_key').modal('hide');

        	swal({
  				title: "Account Active",
  				text: "Bravo! Your account was activated. Please login.",
  				type: "success",
  				showCancelButton: false,
  				confirmButtonColor: "#5cb85c",
  				confirmButtonText: "OK",
  				closeOnConfirm: false
			},
			function(){

  				location.reload();
			});



        }else{

           swal("Wrong Code", "Please try again. Or request a new activation code", "error")


        }



    });



	$('#login').formValidation({
        framework: 'bootstrap',

        fields: {
            myusername: {
                validators: {
                    notEmpty: {
                        message: "Please key in your username"
                    }

                }
            },
            mypassword: {
                validators: {
                    notEmpty: {
                        message: "Please key in your password"
                    }

                }
            }


        }
    }).on('success.form.fv', function(e) {

    		e.preventDefault();


    		var username = $('#myusername').val();
    		var password = $('#mypassword').val();

    		// check if username and password exist



    		var formData = {
        		'username'     : username,
        		'password'     : password,
			}


			var feedback = $.ajax({
    			type: "POST",
    			url: "check_login.php",
    		    data: formData,

    		    async: false,

    		}).complete(function(){


    		}).responseText;


            if(feedback == ""){

              swal("Ooops....!", "Wrong username or password", "error");



            }else{

            var session_id='<?php echo $_SESSION['sid']; ?>';
            	// create session in db and go to main page
            	var formData = {
        		'session_id'     : '<?php echo $_SESSION['sid']; ?>',
        		'id'     : feedback,
			'username': username
				}

	  //alert(feedback);
			var feedback = $.ajax({

    			type: "POST",
    			url: "create_session.php",
    		    data: formData,
    		    async: false,

    			}).complete(function(){


					if (navigator.geolocation) {
						var optn = {
							enableHighAccuracy : true,
							timeout : Infinity,
							maximumAge : 0
						};
						watchId = navigator.geolocation.getCurrentPosition(
							function(position){

								var data={
									'posLat':position.coords.latitude,
									'posLng':position.coords.longitude
								}
								postCall(data, './updatePos.php');
							}, function(){},
						optn);
					}


    			}).responseText;

    		  	window.location.href = "main.php?session_id=" + session_id;



         }




     });


     $('#new_sign_up')
        .find('[name="customer_mobile"]')
            .intlTelInput({
                utilsScript: 'js/utils.js',
                autoPlaceholder: true,
                preferredCountries: ['us']
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

     FormValidation.Validator.username_exist = {
        validate: function(validator, $field, options) {
            var value = $field.val();

            // ajax to check if mail is already in the database

            var formData = {
        		'provider_name_key'     : value
				}


				var feedback = $.ajax({

    			type: "POST",
    			url: "check_username.php",
    		    data: formData,

    		    async: false,

    			}).complete(function(){

    			}).responseText;


    			var arr_response = feedback.split('|');

    			var exist = arr_response[0];

            if(exist > 0){

              return false;

            }else{
            return true;

            }


        }
    };


	$('#new_sign_up')
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
                customer_email: {
                validators: {
                    emailAddress: {
                        message: 'The value is not a valid email address'
                    },
                    notEmpty: {
                        message: 'The e-mail is required'
                    },

                    email_exist: {
                        message: 'This e-mail address already exist! Please use a different one.'
                    }


                  }
                },

                customer_username: {
                validators: {
                    notEmpty: {
                        message: 'The username is required'
                    },

                    username_exist: {
                        message: 'This username already exist! Please use a different one.'
                    }


                  }
                },


                customer_password_confirm: {
                validators: {
                    identical: {
                        field: 'customer_password',
                        message: 'The password and its confirm are not the same'
                    }
                }
            },


                
                 customer_first_name: {
                validators: {
                    notEmpty: {
                        message: 'The firstname is required'
                    }


                  }
                },

                customer_family_name: {
                validators: {
                    notEmpty: {
                        message: 'The family name is required'
                    }


                  }
                },



                customer_password: {
                validators: {
                    notEmpty: {
                        message: 'You need to enter a password'
                    },stringLength: {
                        min : 6,
                        max: 12,
                        message: 'password length must be 6 -12 characters'
                    },

                     terms: {
                    validators: {
                        notEmpty: {
                            message: 'The size is required'
                        }
                    }
                }


                 /*,

                   callback: {
                        callback: function(value, validator, $field) {
                            var password = $field.val();
                            if (password == '') {
                                return true;
                            }

                            var result  = zxcvbn(password),
                                score   = result.score,
                                message = result.feedback.warning || 'The password is weak';

                            // Update the progress bar width and add alert class
                            var $bar = $('#strengthBar');
                            switch (score) {
                                case 0:
                                    $bar.attr('class', 'progress-bar progress-bar-danger')
                                        .css('width', '1%');
                                    break;
                                case 1:
                                    $bar.attr('class', 'progress-bar progress-bar-danger')
                                        .css('width', '25%');
                                    break;
                                case 2:
                                    $bar.attr('class', 'progress-bar progress-bar-danger')
                                        .css('width', '50%');
                                    break;
                                case 3:
                                    $bar.attr('class', 'progress-bar progress-bar-warning')
                                        .css('width', '75%');
                                    break;
                                case 4:
                                    $bar.attr('class', 'progress-bar progress-bar-success')
                                        .css('width', '100%');
                                    break;
                            }

                            // We will treat the password as an invalid one if the score is less than 3
                            if (score < 3) {
                                return {
                                    valid: false,
                                    message: message
                                }
                            }

                            return true;
                        }
                    }*/

                  }
                }

            },
        }).on('success.form.fv', function(e) {
            // Prevent form submission
            e.preventDefault();


            // submit info and create account

            var company_name =  $('#customer_company_name').val();

            var firstname =  $('#customer_first_name').val();
            var familyname = $('#customer_family_name').val();

            var customer_username = $('#customer_username').val();
            var customer_email = $('#customer_email').val();

            var customer_mobile = $('#customer_mobile').val();

            var input = $("#customer_mobile")

            var intlNumber = input.intlTelInput("getNumber");
            var customer_password = $('#customer_password').val();

            var dateofbirth = $("#customer_dob").val();

            if($.trim($("#customer_parent_username").val()) != "" )
              var parent_username = $("#customer_parent_username").val();
            else
              var parent_username = "";

              var formData = {
        		'firstname'     : firstname,
        		'familyname'     : familyname,
        		'customer_username'     : customer_username,
        		'customer_email'     : customer_email,
        		'customer_mobile'     : intlNumber,
        		'customer_password'     : customer_password,
        		'company_name'     : company_name,
            'dob' : dateofbirth,
            'guard_username' : parent_username

				}

				var feedback = $.ajax({

    			type: "POST",
    			url: "create_account.php",
    		    data: formData,

    		    async: false,

    			}).complete(function(){

    			}).responseText;

console.log(feedback);
    			$('#account_id_hidden').val(feedback);

    			$('#modal_new_sign_up').modal('hide');

                swal({
                title: "Account Active",
                text: "Bravo! Your account was created. Please login.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#5cb85c",
                confirmButtonText: "OK",
                closeOnConfirm: false
            },
            function(){

                //location.reload();
                swal.close();
            });

    			//$('#modal_activation_key').modal('show');


        })




        // Revalidate the number when changing the country
        .on('click', '.country-list', function() {
            $('#new_sign_up').formValidation('revalidateField', 'customer_mobile');
        });



 $('#customer_email').keyup(email_check);

 function email_check(){



 };




});





</script>



