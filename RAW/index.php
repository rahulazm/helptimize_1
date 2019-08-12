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
	<meta name="author" content="osboxes.org" />
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
</style>

<script type="text/javascript">
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

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


  </head>
    <body>



<script type="text/javascript">
jQuery( document ).ready(function() {
jQuery('.parantname').hide();
  // jQuery("#age").html(age+' Enter The Parent Name');
 jQuery("#dob").on('change',function(){
       var dob1 = jQuery(this).val();
       var dob = $.datepicker.formatDate('yy-mm-dd', new Date(dob1));
       var str = dob.split('-');
       var firstdate=new Date(str[0],str[1],str[2]);
       var today = new Date();
       var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
       var age = parseInt(dayDiff);
         if((age => 14) && (age <= 18)){
          jQuery('.parantname').show();
  }


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
    <input type="text" id="dob" class="datepicker" name="dob" value="1988-04-07"/>
    <!--<p id="age"></p>         -->


</div>

<div class="form-group parantname">
     <label for="usr">Enter Parants Name</label>
   	<input type="text" placeholder="Enter Your Parants Name" class="form-control" id="customer_parants" name="customer_parants">

            		 <input type="checkbox" class="form-check-input-agevar" name="terms" value="1" />
                    <label class="form-check-label">I agree the terms and condition</label>

<div class="agreeboxagevar" style="margin-left: 0px; position: relative; border: 1px solid rgb(221, 221, 221); padding: 5px; overflow: scroll; white-space: pre-wrap; width: auto; height: 100px;">Conditions of Use
TERMS OF SERVICE AGE VERIFICATION (CLICKWRAP) AGREEMENT -
OVER 18 or Between 14 & 18 Years Old
THIS TERMS OF SERVICE AGE VERIFICATION AGREEMENT ("Agreement") - OVER 18 Years of Age is made between Helptimize.com Company and any person ("User") who completes the registration process to open and maintain an account with the Company's interactive online and communication service ("Service"). Company and User are collectively referred to as the "parties."

BY CLICKING THE ACCEPTANCE BUTTON OR ACCESSING, USING OR INSTALLING ANY PART OF THE SERVICE, USER EXPRESSLY AGREES TO AND CONSENTS TO BE BOUND BY ALL OF THE TERMS OF THIS AGREEMENT. USERS WILL BE REQUIRED TO SELECT THEIR AGE BY CHECKING THE BUTTON INDICATING AGE OF USER.  ONE OF THE AGE AGREEMENTS MUST BE SELECTED OR HELPTIMIZE WILL PROMPTLY CANCEL THIS TRANSACTION AND USER MAY NOT ACCESS, USE OR INSTALL ANY PART OF THE SERVICE WITHIN THE HELPTIMIZE APPLICATION AND DESKTOP PROGRAM.

1. Service Terms and Limitations
a. Description. The Service is proprietary to Helptimize and is protected by intellectual property laws and international intellectual property treaties. User's access to the Service is limited to those users over the age of 14. However, if between 14 and 18 years old the user is required to be linked to a custodial account who is responsible for the signing of contracts within the Helptimize app.  By clicking below you are agreeing that you are either over 18 years old, between 14 and 18 years old or not yet 14 years old.  If under 14 years old unfortunately labor laws prohibit your ability to provide or request services on the Helptimize app or Desktop software.  If between 14 and 18 years old you will need to register/link the account with a custodial guardian account who can sign contracts submitted by you (14-18 years old minor). If you accept that your age is between 14 & 18 years old and have a valid custodial guardian account who is over 18 years old they will be notified by our system to agree to additional terms and services agreement to link your account to theirs where all submittals of service requests or bids to services by the minor between 14 & 18 years will require the custodial guardian agreeing to the contract by submitting the request of bid.


I agree that I am over 18 years old

I agree that I am between 14 and 18 years old

I agree that I am under 14 years old

YOU AGREE THAT THE AGE CHECKED BOX ABOVE IS TRUE AND ACCURATE.   IF FOR ANY REASON BOX CHECKED ABOVE IS WRONG THEN THIS WILL CONSTITUTE FRAUD ON BEHALF OF THE INDIVIDUAL SUBMITTING THIS AGREEMENT.

I AGREE THE AGE CHECKED ABOVE IS ACCURATE

</div>
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
                    <label class="form-check-label">I agree the terms and condition</label>

<div class="agreeboxtermandcond" style="margin-left: 0px; position: relative; border: 1px solid rgb(221, 221, 221); padding: 5px; overflow: scroll; white-space: pre-wrap; width: auto; height: 100px;">Conditions of Use
Helptimize

TERMS AND CONDITIONS
Last updated: November 2th, 2018

TERMS OF SERVICE (CLICKWRAP) AGREEMENT
THIS TERMS OF SERVICE AGREEMENT ("Agreement") is made between Helptimize.com and any person ("User") who completes the registration process to open and maintain an account with the Company's interactive online and communication service ("Service"). Helptimize and User are collectively referred to as the "parties."

BY CLICKING THE ACCEPTANCE BUTTON OR ACCESSING, USING OR INSTALLING ANY PART OF THE SERVICE, USER EXPRESSLY AGREES TO AND CONSENTS TO BE BOUND BY ALL OF THE TERMS OF THIS AGREEMENT. IF USER DOES NOT AGREE TO ALL OF THE TERMS OF THIS AGREEMENT, THE BUTTON INDICATING NON-ACCEPTANCE MUST BE SELECTED, COMPANY WILL PROMPTLY CANCEL THIS TRANSACTION AND USER MAY NOT ACCESS, USE OR INSTALL ANY PART OF THE SERVICE.

1. Contractual Relationship
These Terms of Use ("Terms") govern the access or use by you, an individual, from within any country in the world (including the United States and its territories and possessions) of applications, websites, content, products, and services (the "Services") made available by Helptimize., a private limited liability company established in the United States of America in the State of Nevada.

PLEASE READ THESE TERMS CAREFULLY BEFORE ACCESSING OR USING THE SERVICES, AS THEY CONSTITUTE A LEGAL AGREEMENT BETWEEN YOU AND HELPTIMIZE. In these Terms, the words "including" and "include" mean "including, but not limited to."

Your access and use of the Services constitutes your agreement to be bound by these Terms, which establishes a contractual relationship between you and Helptimize If you do not agree to these Terms, you may not access or use the Services. These Terms expressly supersede prior agreements or arrangements with you. Helptimize may immediately terminate these Terms or any Services with respect to you, or generally cease offering or deny access to the Services or any portion thereof, at any time for any reason.

Supplemental terms may apply to certain Services, such as policies for a particular event, activity or promotion, and such supplemental terms will be disclosed to you in connection with the applicable Services. Supplemental terms are in addition to, and shall be deemed a part of, the Terms for the purposes of the applicable Services. Supplemental terms shall prevail over these Terms in the event of a conflict with respect to the applicable Services.

Helptimize may amend the Terms related to the Services from time to time. Amendments will be effective upon Helptimize's posting of such updated Terms at this location or the amended policies or supplemental terms on the applicable Service. Your continued access or use of the Services after such posting constitutes your consent to be bound by the Terms, as amended.

Our collection and use of personal information in connection with the Services is as provided in Helptimize Privacy Policy located at https://www.helptimize.com/legal. Helptimize may provide to a claims processor or an insurer any necessary information (including your contact information) if there is a complaint, dispute or conflict, which may include an accident, involving you and a Third Party (including any service to include transportation network driver, handyman or any other seller of services) and such information or data is necessary to resolve the complaint, dispute or conflict.

IMPORTANT: PLEASE REVIEW THE ARBITRATION AGREEMENT SET FORTH BELOW CAREFULLY, AS IT WILL REQUIRE YOU TO RESOLVE DISPUTES WITH HELPTIMIZE ON AN INDIVIDUAL BASIS THROUGH FINAL AND BINDING ARBITRATION. BY ENTERING THIS AGREEMENT, YOU EXPRESSLY ACKNOWLEDGE THAT YOU HAVE READ AND UNDERSTAND ALL OF THE TERMS OF THIS AGREEMENT AND HAVE TAKEN TIME TO CONSIDER THE CONSEQUENCES OF THIS IMPORTANT DECISION.

Arbitration Agreement
By agreeing to the Terms, you agree that you are required to resolve any claim that you may have against Helptimize on an individual basis in arbitration, as set forth in this Arbitration Agreement. This will preclude you from bringing any class, collective, or representative action against Helptimize or it's parent company BrainConnexion LLC, and also preclude you from participating in or recovering relief under any current or future class, collective, consolidated, or representative action brought against Helptimize by someone else.
Agreement to Binding Arbitration Between You and Helptimize.
You and Helptimize agree that any dispute, claim or controversy arising out of or relating to (a) these Terms or the existence, breach, termination, enforcement, interpretation or validity thereof, or (b) your access to or use of the Services at any time, whether before or after the date you agreed to the Terms, will be settled by binding arbitration between you and Helptimize, and not in a court of law.
You acknowledge and agree that you and Helptimize are each waiving the right to a trial by jury or to participate as a plaintiff or class member in any purported class action or representative proceeding. Unless both you and Helptimize otherwise agree in writing, any arbitration will be conducted only on an individual basis and not in a class, collective, consolidated, or representative proceeding. However, you and Helptimize each retain the right to bring an individual action in small claims court and the right to seek injunctive or other equitable relief in a court of competent jurisdiction to prevent the actual or threatened infringement, misappropriation or violation of a party's copyrights, trademarks, trade secrets, patents or other intellectual property rights.
Rules and Governing Law.
The arbitration will be administered by the American Arbitration Association ("AAA") in accordance with the AAA's Consumer Arbitration Rules and the Supplementary Procedures for Consumer Related Disputes (the "AAA Rules") then in effect, except as modified by this Arbitration Agreement. The AAA Rules are available at www.adr.org/arb_med or by calling the AAA at 1-800-778-7879.
The parties agree that the arbitrator ("Arbitrator"), and not any federal, state, or local court or agency, shall have exclusive authority to resolve any disputes relating to the interpretation, applicability, enforceability or formation of this Arbitration Agreement, including any claim that all or any part of this Arbitration Agreement is void or voidable. The Arbitrator shall also be responsible for determining all threshold arbitrability issues, including issues relating to whether the Terms are unconscionable or illusory and any defense to arbitration, including waiver, delay, laches, or estoppel.
Notwithstanding any choice of law or other provision in the Terms, the parties agree and acknowledge that this Arbitration Agreement evidences a transaction involving interstate commerce and that the Federal Arbitration Act, 9 U.S.C. § 1 et seq. ("FAA"), will govern its interpretation and enforcement and proceedings pursuant thereto. It is the intent of the parties that the FAA and AAA Rules shall preempt all state laws to the fullest extent permitted by law. If the FAA and AAA Rules are found to not apply to any issue that arises under this Arbitration Agreement or the enforcement thereof, then that issue shall be resolved under the laws of the state of California.
Process.
A party who desires to initiate arbitration must provide the other party with a written Demand for Arbitration as specified in the AAA Rules. (The AAA provides a form Demand for Arbitration - Consumer Arbitration Rules at www.adr.org or by calling the AAA at 1-800-778-7879). The Arbitrator will be either (1) a retired judge or (2) an attorney specifically licensed to practice law in the state of Washington and will be selected by the parties from the AAA's roster of consumer dispute arbitrators. If the parties are unable to agree upon an Arbitrator within seven (7) days of delivery of the Demand for Arbitration, then the AAA will appoint the Arbitrator in accordance with the AAA Rules.
Location and Procedure.
Unless you and Helptimize otherwise agree, the arbitration will be conducted in the county where you reside. If your claim does not exceed $10,000, then the arbitration will be conducted solely on the basis of documents you and Helptimize submit to the Arbitrator, unless you request a hearing or the Arbitrator determines that a hearing is necessary. If your claim exceeds $10,000, your right to a hearing will be determined by the AAA Rules. Subject to the AAA Rules, the Arbitrator will have the discretion to direct a reasonable exchange of information by the parties, consistent with the expedited nature of the arbitration.
Arbitrator's Decision.
The Arbitrator will render an award within the time frame specified in the AAA Rules. Judgment on the arbitration award may be entered in any court having competent jurisdiction to do so. The Arbitrator may award declaratory or injunctive relief only in favor of the claimant and only to the extent necessary to provide relief warranted by the claimant's individual claim. An Arbitrator's decision shall be final and binding on all parties. An Arbitrator's decision and judgment thereon shall have no precedential or collateral estoppel effect. If you prevail in arbitration you will be entitled to an award of attorneys' fees and expenses, to the extent provided under applicable law. Helptimize will not seek, and hereby waives all rights Helptimize may have under applicable law to recover, attorneys' fees and expenses if Helptimize prevails in arbitration.
Fees.
Your responsibility to pay any AAA filing, administrative and arbitrator fees will be solely as set forth in the AAA Rules. However, if your claim for damages does not exceed $50,000, Helptimize will pay all such fees, unless the Arbitrator finds that either the substance of your claim or the relief sought in your Demand for Arbitration was frivolous or was brought for an improper purpose (as measured by the standards set forth in Federal Rule of Civil Procedure 11(b)).
Changes.
Notwithstanding the provisions in Section I above, regarding consent to be bound by amendments to these Terms, if Helptimize changes this Arbitration Agreement after the date you first agreed to the Terms (or to any subsequent changes to the Terms), you may reject any such change by providing Helptimize written notice of such rejection within 30 days of the date such change became effective, as indicated in the "Effective" date above. This written notice must be provided either (a) by mail or hand delivery to our registered agent for service of process, _________________ in Nevada (the name and current contact information for the registered agent in each state are available online here), or (b) by email from the email address associated with your Account to: jeff.mcbroom@helptimize.com . In order to be effective, the notice must include your full name and clearly indicate your intent to reject changes to this Arbitration Agreement. By rejecting changes, you are agreeing that you will arbitrate any dispute between you and Helptimize in accordance with the provisions of this Arbitration Agreement as of the date you first agreed to the Terms (or to any subsequent changes to the Terms).
Severability and Survival.
If any portion of this Arbitration Agreement is found to be unenforceable or unlawful for any reason, (1) the unenforceable or unlawful provision shall be severed from these Terms; (2) severance of the unenforceable or unlawful provision shall have no impact whatsoever on the remainder of the Arbitration Agreement or the parties' ability to compel arbitration of any remaining claims on an individual basis pursuant to the Arbitration Agreement; and (3) to the extent that any claims must therefore proceed on a class, collective, consolidated, or representative basis, such claims must be litigated in a civil court of competent jurisdiction and not in arbitration, and the parties agree that litigation of those claims shall be stayed pending the outcome of any individual claims in arbitration.


2. The Services
The Services constitute a technology platform that enables users of Helptimize's mobile applications or websites provided as part of the Services (each, an "Application") to arrange and schedule services and/or logistics services with independent third party providers of such services, including independent third party service providers and independent third party logistics service providers under agreement with Helptimize or certain of Helptimize's affiliates ("Third Party Providers"). Unless otherwise agreed by Helptimize in a separate written agreement with you, the Services are made available solely for your personal, noncommercial use. YOU ACKNOWLEDGE THAT HELPTIMIZE DOES NOT PROVIDE THE SERVICES OR LOGISTICS SERVICES OR FUNCTION AS A SERVICE PRIVIDER AND THAT ALL SUCH SERVICES OR LOGISTICS SERVICES ARE PROVIDED BY INDEPENDENT THIRD PARTY CONTRACTORS WHO ARE NOT EMPLOYED BY HELPTIMIZE OR ANY OF ITS AFFILIATES.




License.

Subject to your compliance with these Terms, Helptimize grants you a limited, non-exclusive, non-sublicensable, revocable, non-transferrable license to: (i) access and use the Applications on your personal device solely in connection with your use of the Services; and (ii) access and use any content, information and related materials that may be made available through the Services, in each case solely for your personal, noncommercial use. Any rights not expressly granted herein are reserved by Helptimize and Helptimize's licensors.


Restrictions.

You may not: (i) remove any copyright, trademark or other proprietary notices from any portion of the Services; (ii) reproduce, modify, prepare derivative works based upon, distribute, license, lease, sell, resell, transfer, publicly display, publicly perform, transmit, stream, broadcast or otherwise exploit the Services except as expressly permitted by Helptimize (iii) decompile, reverse engineer or disassemble the Services except as may be permitted by applicable law; (iv) link to, mirror or frame any portion of the Services; (v) cause or launch any programs or scripts for the purpose of scraping, indexing, surveying, or otherwise data mining any portion of the Services or unduly burdening or hindering the operation and/or functionality of any aspect of the Services; or (vi) attempt to gain unauthorized access to or impair any aspect of the Services or its related systems or networks.

Provision of the Services.

You acknowledge that portions of the Services may be made available under Helptimize's various brands or request options associated with services or logistics services.  You also acknowledge that the Services may be made available under such brands or request options by or in connection with: (i) certain of Helptimize's subsidiaries and affiliates; or (ii) independent Third Party Providers, including network company services, license service permit holders, authorizations or licenses.

Third Party Services and Content.

The Services may be made available or accessed in connection with third party services and content (including advertising) that Helptimize does not control. You acknowledge that different terms of use and privacy policies may apply to your use of such third party services and content. Helptimize does not endorse such third-party services and content and in no event, shall Helptimize be responsible or liable for any products or services of such third-party providers. Additionally, Apple Inc., Google, Inc., Microsoft Corporation or BlackBerry Limited and/or their applicable international subsidiaries and affiliates will be third-party beneficiaries to this contract if you access the Services using Applications developed for Apple iOS, Android, Microsoft Windows, or Blackberry-powered mobile devices, respectively. These third-party beneficiaries are not parties to this contract and are not responsible for the provision or support of the Services in any manner. Your access to the Services using these devices is subject to terms set forth in the applicable third party beneficiary's terms of service.

Ownership.

The Services and all rights therein are and shall remain Helptimize's property or the property of Helptimize's licensors. Neither these Terms nor your use of the Services convey or grant to you any rights: (i) in or related to the Services except for the limited license granted above; or (ii) to use or reference in any manner Helptimize's company names, logos, product and service names, trademarks or services marks or those of Helptimize's licensors.

3. Your Use of the Services

User Accounts.

In order to use most aspects of the Services, you must register for and maintain an active personal user Services account ("Account"). To obtain an "Account", you must be at least 18 years of age to sign contracts within the Helptimize platform. However, if you are between ages 14 & 18 years old then you are eligible to register an account with a legal custodian parent/guardian to have a "Linked Account". The legal custodian for any User between 14 -18 years old (minor) will be required to sign legal Helptimize contracts on the platform submitted by the minor in order to authorize a request for service or bid on service as long as all jurisdictional laws have been met.  Teenagers between 14 and 18 will need to have a legal custodial parent/guardian sign a waiver to be directly responsible for the actions of the minor on the platform and not hold Helptimize accountable for any damages in accordance with the legal adult custodian parent/guardian waiver agreement for any services offered or requested by the minor.

Account registration requires you to submit to Helptimize certain personal information, such as your name, address, mobile phone number and age, as well as at least one valid payment method (either a credit card or accepted payment partner). You agree to maintain accurate, complete, and up-to-date information in your Account. Your failure to maintain accurate, complete, and up-to-date Account information, including having an invalid or expired payment method on file, may result in your inability to access and use the Services or Helptimize's termination of these Terms with you. You are responsible for all activity that occurs under your Account, and you agree to maintain the security and secrecy of your Account username and password at all times. Unless otherwise permitted by Helptimize in writing, you may only possess one Account.

It is agreed that Requestors of Services utilize the platform for services needed and not uses for the sole purpose of receiving quotes.  Users also authorize that Helptimize track usage of the platform and calculate the submit to award ratio for service requested.  If said submit to award ratio drops below 60% then Users authorize the platform to list the account as a quote center and charge the quote center accounts a fee listed on www.helptimize.com website for requesting a service on Helptimize platform.  This quote center money will be distributed to a portion of the bidders and Helptimize for providing quotes.  From time to time Helptimize will re-evaluate the charges levied with Quote Center Accounts to help maintain interest from sellers to provide only quotes.


User Requirements and Conduct.

The Service is not available for use by persons under the age of 18 unless User is between ages 14 & 18 and jointly maintains a Linked Account with their legal custodian parent/guardian to sign any legal binding contracts to request or offer a service via the Helptimize platform. Users may not authorize any third parties to use your Account.  You may not assign or otherwise transfer your Account to any other person or entity. You agree to comply with all applicable laws when using the Services, and you may only use the Services for lawful purposes (e.g., no transport of unlawful or hazardous materials, no illegal exchange of services). You will not, in your use of the Services, cause nuisance, annoyance, inconvenience, or property damage, whether to the Third-Party or any other party. In certain instances, you may be asked to provide proof of identity to access or use the Services, and you agree that you may be denied access to or use of the Services if you refuse to provide proof of identity.

Helptimize encourages all Users have Background Verification Check accomplished via Checkr, Washington State Patrol (WSP) or other identified sources by Helptimize as listed on www.helptimize.com web site. Verification check accomplished by Checkr.com or WSP (https://fortress.wa.gov/wsp/watch/) will be displayed in each Users profile as either passed or failed. Details gathered at a minimum are; Social Security Number trace ? National Sex Offender Search ? Global Watchlist ? National Criminal Database.

HELPTIMIZE PLATFORM HIGHLY RECOMMENDS ALL USERS (BOTH BUYRER AND SELLER) BE FINGERPRINT BACKGROUND VERIFIED EACH YEAR.  IF OVER 500 USD IS TRANSACTED BY USER ON PLATFORM THEN THIS FEE WILL BE REIMBURSED TO USER WHICH CAN BE USED ON THE HELPTIMIZE PLATFORM. UPON VERIFICATION BACKGROUND PASSING, A USER WILL THEN BE SHOWN ON THE HELPTIMIZE PLATFORM AS A GOLD DIAMOND RATED USER WHICH WILL LIKELY OFFER MORE OPPORTUNITIES TO USERS AND MAKE THE PLATFORM MUCH MORE SECURE/SAFE FOR ALL USERS.

There is a fee (subject to escalation at any time) to be background verified.  All users are recommended to pay for this background verification prior to submitting a request for service or bidding and signing a contract for a service via the Helptimize platform.  This fee will be deducted from your credit card established. Please note that falsification of age information entered via the login account registration process will result in the account being closed. For Users (Buyer's and Seller's) with results that have not passed verification check will be displayed as failed background check in your profile. If you prefer not to show this information then we will close the account at your request.


Text/Video & Voice Messaging.

By creating an Account, you agree that the Services may send you text (SMS) messages as part of the normal business operation of your use of the Services. You may opt-out of receiving text (SMS) messages from Helptimize at any time by following the directions found at http://helptimize.com/SMS-unsubscribe. You acknowledge that opting out of receiving text (SMS) messages may impact your use of the Services.

An in-app Text, Video and Voice messaging is available for your usage and encouraged to negotiate price and details.  User agrees to communicate in a positive manor and avoid profanity or any offending language.  This information will be monitored and if determined account has been using language inappropriate then a committee assembled by Helptimize will determine if account should be closed or any other appropriate action taken as a result.

Promotional Codes.

Helptimize may, in Helptimize's sole discretion, create promotional codes that may be redeemed for Account credit, or other features or benefits related to the Services and/or a Third-Party services, subject to any additional terms that Helptimize establishes on a per promotional code basis ("Promo Codes"). You agree that Promo Codes: (i) must be used for the intended audience and purpose, and in a lawful manner; (ii) may not be duplicated, sold or transferred in any manner, or made available to the general public (whether posted to a public form or otherwise), unless expressly permitted by Helptimize; (iii) may be disabled by Helptimize at any time for any reason without liability to Helptimize; (iv) may only be used pursuant to the specific terms that Helptimize establishes for such Promo Code; (v) are not valid for cash; and (vi) may expire prior to your use. Helptimize reserves the right to withhold or deduct credits or other features or benefits obtained through the use of Promo Codes by you or any other user in the event that Helptimize determines or believes that the use or redemption of the Promo Code was in error, fraudulent, illegal, or in violation of the applicable Promo Code terms or these Terms.

User Provided Content.

Helptimize may, in Helptimize's sole discretion, permit you from time to time to submit, upload, publish or otherwise make available to Helptimize through the Services textual, audio, and/or visual content and information, including commentary and feedback related to the Services, initiation of support requests, and submission of entries for competitions and promotions ("User Content"). Any User Content provided by you remains your property. However, by providing User Content to Helptimize, you grant Helptimize a worldwide, perpetual, irrevocable, transferrable, royalty-free license, with the right to sublicense, to use, copy, modify, create derivative works of, distribute, publicly display, publicly perform, and otherwise exploit in any manner such User Content in all formats and distribution channels now known or hereafter devised (including in connection with the Services and Helptimize's business and on third-party sites and services), without further notice to or consent from you, and without the requirement of payment to you or any other person or entity.

You represent and warrant that: (i) you either are the sole and exclusive owner of all User Content or you have all rights, licenses, consents and releases necessary to grant Helptimize the license to the User Content as set forth above; and (ii) neither the User Content nor your submission, uploading, publishing or otherwise making available of such User Content nor Helptimize's use of the User Content as permitted herein will infringe, misappropriate or violate a third party's intellectual property or proprietary rights, or rights of publicity or privacy, or result in the violation of any applicable law or regulation.

You agree to not provide User Content that is defamatory, libelous, hateful, violent, obscene, pornographic, unlawful, or otherwise offensive, as determined by Helptimize in its sole discretion, whether or not such material may be protected by law. Helptimize may, but shall not be obligated to, review, monitor, or remove User Content, at Helptimize's sole discretion and at any time and for any reason, without notice to you.

Network Access and Devices.

You are responsible for obtaining the data network access necessary to use the Services. Your mobile network's data and messaging rates and fees may apply if you access or use the Services from a wireless-enabled device and you shall be responsible for such rates and fees. You are responsible for acquiring and updating compatible hardware or devices necessary to access and use the Services and Applications and any updates thereto. Helptimize does not guarantee that the Services, or any portion thereof, will function on any particular hardware or devices. In addition, the Services may be subject to malfunctions and delays inherent in the use of the Internet and electronic communications.

4. Payment
You understand that use of the Services may result in charges to you for the services or goods you receive from a Third Party Provider ("Charges").  After you have received services or goods obtained through your use of the Service, Helptimize will facilitate your payment of the applicable Charges on behalf of the Third Party Provider as such Third Party Provider's limited payment collection agent. Payment of the Charges in such manner shall be considered the same as payment made directly by you to the Third Party Provider. Charges will be inclusive of applicable taxes where required by law. Charges paid by you are final and non-refundable, unless otherwise determined by Helptimize You retain the right to request lower Charges from a Third Party Provider for services or goods received by you from such Third Party Provider at the time you receive such services or goods. Helptimize will respond accordingly to any request from a Third Party Provider to modify the Charges for a particular service or good.

Buyer of Services acknowledges that a fee will be charged if User communicates (SMS, Video Chat, in app telephone) with a Third Party Provider and subsequently cancels the SR request for services. The charge will be as published on the web platform landing page at www.helptimize.com  and subject to charge escalation at Helptimize discretion at any time. As between you and Helptimize the platform is focused to be easy to use and easy to communicate with services negotiated.  As such any termination of the request for a service after communication with seller/bidder warrants that the parties (Buyer of service and Third Party) intention was to establish details to work the service off platform which results in a buyer fee for the communications provided to the seller via Helptimize provided service.

All Charges are due immediately and payment will be facilitated by Helptimize using the preferred payment method designated in your Account, after which Helptimize will send you a receipt by email. If your primary Account payment method is determined to be expired, invalid or otherwise not able to be charged, you agree that Helptimize may, as the Third Party limited payment collection agent, use a secondary payment method in your Account, if available.

As between you and Helptimize, Helptimize reserves the right to establish, remove and/or revise Charges for any or all services or goods obtained through the use of the Services at any time in Helptimize's sole discretion. Further, you acknowledge and agree that Charges applicable in certain geographical areas may increase substantially during times of high demand. Helptimize will use reasonable efforts to inform you of Charges that may apply, provided that you will be responsible for Charges incurred under your Account regardless of your awareness of such Charges or the amounts thereof. Helptimize may from time to time provide certain users with promotional offers and discounts that may result in different amounts charged for the same or similar services or goods obtained through the use of the Services, and you agree that such promotional offers and discounts, unless also made available to you, shall have no bearing on your use of the Services or the Charges applied to you. You may elect to cancel your request for services or goods from a Third Party Provider at any time prior to such Third Party Provider's arrival, in which case you may be charged a cancellation fee.

This payment structure is intended to fully compensate the Third Party Provider for the services or goods provided. Helptimize does not designate any portion of your payment as a tip or gratuity to the Third Party Provider. Any representation by Helptimize (on Helptimize's website, in the Application, or in Helptimize's marketing materials) to the effect that tipping is "voluntary," "not required," and/or "included" in the payments you make for services or goods provided is not intended to suggest that Helptimize provides any additional amounts, beyond those described above, to the Third Party Provider. You understand and agree that, while you are free to provide additional payment as a gratuity to any Third Party Provider who provides you with services or goods obtained through the Service, you are under no obligation to do so. Gratuities are voluntary. After you have received services or goods obtained through the Service, you will have the opportunity to rate your experience and leave additional feedback about your Third Party Provider.

Repair or Cleaning Fees.

You shall be responsible for the cost of repair for damage to, or necessary cleaning of, Third Party Requestor/Provider property resulting from use of the Services under your Account in excess of normal "wear and tear" damages and necessary cleaning ("Repair or Cleaning"). In the event that a Third Party reports the need for Repair or Cleaning, and such Repair or Cleaning request is verified by Helptimize in Helptimize's reasonable discretion, Helptimize reserves the right to facilitate payment for the reasonable cost of such Repair or Cleaning on behalf of the Third Party using your payment method designated in your Account. Such amounts will be transferred by Helptimize to the applicable Third Party and are non-refundable. . Disclaimers; Limitation of Liability; Indemnity.

5. Advanced Payment Process
You may utilize Helptimize advance payment process to have Third Party Provider deliver any needed purchases.  The Advance Payment Process will enable an in-app video to show you the Third Party purchase of goods that have been negotiated and accepted by you via pop-up messages.  Under this process, you will authorize a Third Party to utilize their Credit Card to purchase goods which will be reimbursed with additional fees as outlined under https://www.helptimize.com/Advanced payments. Once invoice is authorized the money is held in an escrow account until the goods are delivered with receipt and you authorize the release of the payment with applicable fees associated for this process.

6. Disclaimers; Limitation of Liability; Indemnity.

DISCLAIMER.
THE SERVICES ARE PROVIDED "AS IS" AND "AS AVAILABLE." HELPTIMIZE DISCLAIMS ALL REPRESENTATIONS AND WARRANTIES, EXPRESS, IMPLIED OR STATUTORY, NOT EXPRESSLY SET OUT IN THESE TERMS, INCLUDING THE IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT. IN ADDITION, HELPTIMIZE MAKES NO REPRESENTATION, WARRANTY, OR GUARANTEE REGARDING THE RELIABILITY, TIMELINESS, QUALITY, SUITABILITY OR AVAILABILITY OF THE SERVICES OR ANY SERVICES OR GOODS REQUESTED THROUGH THE USE OF THE SERVICES, OR THAT THE SERVICES WILL BE UNINTERRUPTED OR ERROR-FREE. HELPTIMIZE DOES NOT GUARANTEE THE QUALITY, SUITABILITY, SAFETY OR ABILITY OF THIRD PARTY PROVIDERS. YOU AGREE THAT THE ENTIRE RISK ARISING OUT OF YOUR USE OF THE SERVICES, AND ANY SERVICE OR GOOD REQUESTED IN CONNECTION THEREWITH, REMAINS SOLELY WITH YOU, TO THE MAXIMUM EXTENT PERMITTED UNDER APPLICABLE LAW.

LIMITATION OF LIABILITY.

HELPTIMIZE SHALL NOT BE LIABLE FOR INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, PUNITIVE OR CONSEQUENTIAL DAMAGES, INCLUDING LOST PROFITS, LOST DATA, PERSONAL INJURY OR PROPERTY DAMAGE RELATED TO, IN CONNECTION WITH, OR OTHERWISE RESULTING FROM ANY USE OF THE SERVICES, EVEN IF HELPTIMIZE HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. HELPTIMIZE SHALL NOT BE LIABLE FOR ANY DAMAGES, LIABILITY OR LOSSES ARISING OUT OF: (i) YOUR USE OF OR RELIANCE ON THE SERVICES OR YOUR INABILITY TO ACCESS OR USE THE SERVICES; OR (ii) ANY TRANSACTION OR RELATIONSHIP BETWEEN YOU AND ANY THIRD PARTY, EVEN IF HELPTIMIZE HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. HELPTIMIZE SHALL NOT BE LIABLE FOR DELAY OR FAILURE IN PERFORMANCE RESULTING FROM CAUSES BEYOND HELPTIMIZE'S REASONABLE CONTROL. YOU ACKNOWLEDGE THAT THIRD PARTY SERVICE PROVIDERS PROVIDING SERVICES REQUESTED THROUGH SOME REQUEST BRANDS MAY OFFER SERVICES OR PEER-TO-PEER SERVICES AND MAY NOT BE PROFESSIONALLY LICENSED OR PERMITTED. IN NO EVENT SHALL HELPTIMIZE'S TOTAL LIABILITY TO YOU IN CONNECTION WITH THE SERVICES FOR ALL DAMAGES, LOSSES AND CAUSES OF ACTION EXCEED FIVE HUNDRED UNITED STATES DOLLARS ($500).
HELPTIMIZE'S SERVICES MAY BE USED BY YOU TO REQUEST AND SCHEDULE ANY SERVICE TRANSPORTATION, GOODS OR LOGISTICS SERVICES WITH THIRD PARTY PROVIDERS, BUT YOU AGREE THAT HELPTIMIZE HAS NO RESPONSIBILITY OR LIABILITY TO YOU RELATED TO ANY SERVICE PROVIDED TO YOU BY THIRD PARTY OTHER THAN AS EXPRESSLY SET FORTH IN THESE TERMS.
THE LIMITATIONS AND DISCLAIMER IN THIS SECTION 6 DO NOT PURPORT TO LIMIT LIABILITY OR ALTER YOUR RIGHTS AS A CONSUMER THAT CANNOT BE EXCLUDED UNDER APPLICABLE LAW.

Indemnity.

You agree to indemnify and hold Helptimize and its officers, directors, employees and agents harmless from any and all claims, demands, losses, liabilities, and expenses (including attorneys' fees) arising out of or in connection with: (i) your use of the Services or services or goods obtained through your use of the Services; (ii) your breach or violation of any of these Terms; (iii) Helptimze's use of your User Content; or (iv) your violation of the rights of any third party, including Third Party Providers.

7. Governing Law; Arbitration.
Except as otherwise set forth in these Terms, these Terms shall be exclusively governed by and construed in accordance with the laws of The United States of America, excluding its rules on conflicts of laws. Any dispute, conflict, claim or controversy arising out of or broadly in connection with or relating to the Services or these Terms, including those relating to its validity, its construction or its enforceability (any "Dispute") shall be first mandatorily submitted to mediation proceedings under the International Chamber of Commerce Mediation Rules ("ICC Mediation Rules"). If such Dispute has not been settled within sixty (60) days after a request for mediation has been submitted under such ICC Mediation Rules, such Dispute can be referred to and shall be exclusively and finally resolved by arbitration under the Rules of Arbitration of the International Chamber of Commerce ("ICC Arbitration Rules"). The ICC Rules' Emergency Arbitrator provisions are excluded. The Dispute shall be resolved by one (1) arbitrator to be appointed in accordance with the ICC Rules. The place of both mediation and arbitration shall be in the State of Washington in The United States of America, without prejudice to any rights you may have under any other articles.  The language of the mediation and/or arbitration shall be English, unless you do not speak English, in which case the mediation and/or arbitration shall be conducted in both English and your native language. The existence and content of the mediation and arbitration proceedings, including documents and briefs submitted by the parties, correspondence from and to the International Chamber of Commerce, correspondence from the mediator, and correspondence, orders and awards issued by the sole arbitrator, shall remain strictly confidential and shall not be disclosed to any third party without the express written consent from the other party unless: (i) the disclosure to the third party is reasonably required in the context of conducting the mediation or arbitration proceedings; and (ii) the third party agrees unconditionally in writing to be bound by the confidentiality obligation stipulated herein.

8. Other Provisions

Claims of Copyright Infringement.

Claims of copyright infringement should be sent to Helptimize's designated agent. Please visit Helptimize's web page at https://www.helptimize.com/legal for the designated address and additional information.

Notice.

Helptimize may give notice by means of a general notice on the Services, electronic mail to your email address in your Account, or by written communication sent to your address as set forth in your Account. You may give notice to Helptimize by written communication to Helptimize's address at ___________________.

General.
You may not assign or transfer these Terms in whole or in part without Helptimize's prior written approval. You give your approval to Helptimize for it to assign or transfer these Terms in whole or in part, including to: (i) a subsidiary or affiliate; (ii) an acquirer of Helptimize's equity, business or assets; or (iii) a successor by merger. No joint venture, partnership, employment or agency relationship exists between you, Helptimize or any Third Party Provider as a result of the contract between you and Helptimize or use of the Services.

If any provision of these Terms is held to be illegal, invalid or unenforceable, in whole or in part, under any law, such provision or part thereof shall to that extent be deemed not to form part of these Terms but the legality, validity and enforceability of the other provisions in these Terms shall not be affected. In that event, the parties shall replace the illegal, invalid or unenforceable provision or part thereof with a provision or part thereof that is legal, valid and enforceable and that has, to the greatest extent possible, a similar effect as the illegal, invalid or unenforceable provision or part thereof, given the contents and purpose of these Terms. These Terms constitute the entire agreement and understanding of the parties with respect to its subject matter and replaces and supersedes all prior or contemporaneous agreements or undertakings regarding such subject matter. In these Terms, the words "including" and "include" mean "including, but not limited to."



</div>
<!-- <ul>
<li> Agree and consent to the <a  href="">User Agreement </a> its policies and the <a href="">Privacy Policy</a></li>
</ul>
<h4>User Agreement and Privacy Policy</h4>
<p>These Documents are designed to inform you of your rights and obligation when using the paypal service</p>
<h2 class="agbtn">Agree and Continue</h2> -->

</div>

                    <div class="form-group">
            		 <input type="checkbox" class="form-check-input-privacy" name="privacy" value="1" />
                    <label class="form-check-label">I agree to Privacy Policy</label>

<div class="agreeboxprivacy" style="margin-left: 0px; position: relative; border: 1px solid rgb(221, 221, 221); padding: 5px; overflow: scroll; white-space: pre-wrap; width: auto; height: 100px;">Conditions of Use
Introduction
When you use Helptimize, you trust us with your information. We are committed to keeping that trust. That starts with helping you understand our privacy practices.
This policy describes the information we collect, how it is used and shared, and your choices regarding this information. We recommend that you read this below policy, which highlights key points about our privacy practices (including what information we collect, when we collect it, and how we use it).
Last Modified: Nov 03, 2018
Effective Date: Nov 03, 2018
Data Collections And Uses
Scope
SUMMARY

This policy applies to users of Helptimize services anywhere in the world, including users of Helptimize's apps, websites, features or other services.
This policy describes how Helptimize and its affiliates collect and use personal information to provide our services. This policy applies to all users of our apps, websites, features or other services anywhere in the world, unless covered by a separate privacy policy. This policy specifically applies to Helptimize Users both buyer and seller of services.

This policy also applies to those who provide information to Helptimize in connection with an application to use our services, or whose information Helptimize otherwise receives in connection with its services. All those subject to this policy are referred to as "users" for purposes of this policy.
The practices described in this policy are subject to applicable laws in the places in which Helptimize operate. This means that we only engage in the practices described in this policy in a particular country or region if permitted under the laws of those places. Please contact us if you have questions on our practices in your country or region.
Data Controller
SUMMARY
Helptimize provides services to users throughout the world. If you use our services in the United States, BrainConnexion LLC, is the data controller for your information. If you use our services in the European Union or elsewhere, we will establish a company to control this data.
We process personal information inside and outside of the United States.
If you live in the United States, the data controller for the information you provide or that is collected by Helptimize or its affiliates is:

BrainConnexion LLC

Las Vegas, Nevada,


If you live in the European Union or elsewhere, the data controller is:

XXX
XXX
XXX

Questions, comments and complaints about Helptimize's data practices can be submitted to Helptimize's data protection at our customer services office.
We process personal information inside and outside of the United States. Helptimize transfers information of users' outside the United States on the basis of mechanisms approved under applicable laws.
The Information We Collect
SUMMARY
Helptimize collects:
"	Information that you provide to Helptimize, such as when you create your Helptimize account.
"	Information created when you use our services, such as location, usage and device information.
"	Information from other sources, such as Helptimize partners and third parties that use Helptimize APIs.
The following information is collected by or on behalf of Helptimize:
1.	Information you provide
This may include:
"	User profile: We collect information when you create or update your Helptimize account. This may include your name, email, phone number, login name and password, address, payment or banking information (including related payment verification information), government identification numbers such as Social Security number, driver's license or passport if required by law, birth date, photo and signature. This also includes Licenses, Certificates, Diploma's and other related documents uploaded to User's profile. This also includes the preferences and settings that you enable for your Helptimize account.
"	Background check information: We may collect background check information if you desire to be Gold Diamond rated on Helptimize platform. This information may be collected by a vendor on Helptimize's behalf.
"	Demographic data: We may collect demographic information about you, including through user surveys. In some countries, we may also receive demographic information about you from third parties.
"	User content: We may collect information that you submit when you contact Helptimize customer support, provide ratings or compliments for other users, or otherwise contact Helptimize.
2.	Information created when you use our services
This may include:
"	Location Information
Depending on the Helptimize services that you use, and your app settings or device permissions, we may collect your precise or approximate location information as determined through data such as GPS, IP address and WiFi.
"	Helptimize collects location information when the Helptimize app is running in the foreground (app open and on-screen) or background (app open but not on screen) of your device.
"	If you are a user and have provided permission for the processing of location data, Helptimize collects location information when the Helptimize app is running in the foreground. In certain regions, Helptimize also collects this information when the Helptimize app is running in the background of your device if this collection is enabled through your app settings or device permissions.
"	All Users may use the Helptimize app without enabling Helptimize to collect their location information. However, this may affect the functionality available on your Helptimize app. For example, if you do not enable Helptimize to collect your location information, you will have to manually enter your pickup address. In addition, location information will be collected from the Buyer during a travel trip from a seller and linked to your account, even if you have not enabled Helptimize to collect your location information.
"	Transaction Information
We collect transaction details related to your use of our services, including the type of services you requested or provided, your order details, delivery information, date and time the service was provided, amount charged, distance traveled, and payment method. Additionally, if someone uses your promotion code, we may associate your name with that person.
"	Usage information
We collect information about how you interact with our services. This includes information such as access dates and times, app features or pages viewed, app crashes and other system activity, type of browser, and third-party sites or service you were using before interacting with our services. In some cases, we collect this information through cookies, pixel tags, and similar technologies that create and maintain unique identifiers. To learn more about these technologies, please see our Cookie Statement.
"	Device Information
We may collect information about the devices you use to access our services, including the hardware models, device IP address, operating systems and versions, software, file names and versions, preferred languages, unique device identifiers, advertising identifiers, serial numbers, device motion information, and mobile network information.
"	Communications data
We enable users to communicate with each other and Helptimize through the Helptimize apps, websites, and other services. For example, we enable Users to call or text each other (in some countries, without disclosing their telephone numbers to each other). To provide this service, Helptimize receives some information regarding the calls or texts, including the date and time of the call/text, and the content of the communications. Helptimize may also use this information for customer support services (including to resolve disputes between users), for safety and security purposes, to improve our products and services and for analytics.
3.	Information from other sources
These may include:
"	User feedback, such as as ratings or compliments.
"	Users providing your information in connection with referral programs.
"	Users requesting services for or on your behalf.
"	Users or others providing information in connection with claims or disputes.
"	Helptimize business partners through which you create or access your Helptimize account, such as payment providers, social media services, on-demand music services, or apps or websites who use Helptimize's APIs or whose API Helptimize uses (such as when you request a service through Google Maps).
"	Insurance providers (if applicable).
"	Financial services providers (if applicable)
"	Partner companies (if you are user who uses our services through an account associated with such a company).
"	The owner of an Helptimize Family profile that you use.
"	Publicly available sources.
"	Marketing service providers.
Helptimize may combine the information collected from these sources with other information in its possession.
How We Use Your Information
SUMMARY
Helptimize collects and uses information to enable reliable and convenient services and other products and services. We also use the information we collect:
"	To enhance the safety and security of our users and services
"	For customer support
"	For research and development
"	To enable communications to or between users
"	To provide promotions or contests
"	In connection with legal proceedings
Helptimize does not sell or share your personal information to third parties for third party direct marketing purposes.
Helptimize uses the information it collects for purposes including:
1.	Providing services and features
Helptimize uses the information we collect to provide, personalize, maintain and improve our products and services. This includes using the information to:
"	Create and update your account.
"	Verify your identity.
"	Enable services and communication. This includes automated processing of your information to enable Helptimize to determine fair pricing on the app.
"	Process or facilitate payments for those services.
"	Offer, obtain, provide or facilitate insurance or financing solutions in connection with our services.
"	To track the progress of your service.
"	Enable features that allow you to share information with other people, such as when you submit a compliment about a user, refer a friend to Helptimize, split fares, or share your ETA.
"	Enable features to personalize your Helptimize account, such as creating bookmarks for your favorite places & services, and to enable quick access to previous services and providers.
"	Enable Accessibility features that make it easier for users with disabilities to use our services, such as those which enable deaf, blind, hard-of-hearing or other disabled users to alert their providers of their disabilities, and to receive flashing service request notifications instead of sound notifications.
"	Perform internal operations necessary to provide our services, including to troubleshoot software bugs and operational problems, to conduct data analysis, testing, and research, and to monitor and analyze usage and activity trends.
2.	Safety and security
We use your data to help maintain the safety, security and integrity of our services and users. This includes, for example:
"	Showing the Users who have had screening background checks, to help other users identify more safe and reliable individuals on the platform.
"	Using information from user devices to identify any unsafe exchanges.
"	our Real-Time ID Check feature, which prompts Service Providers to share a selfie before going to location for service. This helps ensure that the Service Provider using the app matches the Helptimize account we have on file, preventing fraud and helping to protect other users.
"	Using device, location, profile, usage and other information to prevent, detect, and combat fraud or unsafe activities. This includes processing of such information, in certain countries, to identify practices or patterns that indicate fraud or risk of safety incidents. This may also include information from third parties. In certain cases such incidents may lead to deactivation by means of an automated decision making process.
"	Using user ratings to encourage improvement by affected users, and as grounds for deactivating users with ratings below a certain minimum as may be required in their region. Calculation and deactivation may be done through an automated decision making process.
3.	Customer support
Helptimize uses the information we collect (including recordings of customer support calls after notice to you and with your consent) to assist you when you contact our customer support services, including to:
"	Direct your questions to the appropriate customer support person
"	Investigate and address your concerns
"	Monitor and improve our customer support responses
4.	Research and development
We may use the information we collect for testing, research, analysis and product development. This allows us to improve and enhance the safety and security of our services, develop new features and products, and facilitate insurance and finance solutions in connection with our services.
5.	Communications among users
Helptimize uses the information we collect to enable communications between our users. For example, a provider may text or call a service requestor to confirm location or ask details for the required service.

Communications from Helptimize
Helptimize may use the information we collect to communicate with you about products, services, promotions, studies, surveys, news, updates and events.
Helptimize may also use the information to promote and process contests and sweepstakes, fulfill any related awards, and serve you relevant ads and content about our services and those of any business partners. You may receive some of these communications based on your profile as an Helptimize user.
Helptimize may also use the information to inform you about elections, ballots, referenda and other political and policy processes that relate to our services.
7.	Legal proceedings and requirements
We may use the information we collect to investigate or address claims or disputes relating to your use of Helptimize's services, or as otherwise allowed by applicable law, or as requested by regulators, government entities, and official inquiries.
Cookies And Third Party Technologies
SUMMARY
Helptimize and its partners use cookies and other identification technologies on our apps, websites, emails, and online ads for purposes described in this policy.
Cookies are small text files that are stored on your browser or device by websites, apps, online media, and advertisements. Helptimize uses cookies and similar technologies for purposes such as:
"	Authenticating users
"	Remembering user preferences and settings
"	Determining the popularity of content
"	Delivering and measuring the effectiveness of advertising campaigns
"	Analyzing site traffic and trends, and generally understanding the online behaviors and interests of people who interact with our services We may also allow others to provide audience measurement and analytics services for us, to serve advertisements on our behalf across the Internet, and to track and report on the performance of those advertisements. These entities may use cookies, web beacons, SDKs, and other technologies to identify your device when you visit our site and use our services, as well as when you visit other online sites and services. Please see our Cookie Statement for more information regarding the use of cookies and other technologies described in this section, including regarding your choices relating to such technologies.
Information Sharing And Disclosure
SUMMARY
Some of Helptimize's products, services and features require that we share information with other users or at your request. We may also share your information with our affiliates, subsidiaries and business partners, for legal reasons or in connection with claims or disputes.
Helptimize may share the information we collect:
1.	With other users
"	For example, if you are a requestor of a service, we may share your first name, average user rating given by other service providers, and usual service locations.
"	If you are a service provider we may share information with your requestor including name and photo; vehicle make, model, color, license plate, and vehicle photo; location; average rating provided by service requestors; total number of services provided; for how long you have been using the Helptimize app; and contact information (depending upon applicable laws). If you choose to complete a profile, we may also share any information associated with that profile, including information that you submit and compliments that past users have submitted about you. The request recipient will also receive a receipt containing information such as a breakdown of amounts charged, your first name, photo, and a detail of services provided.
2.	At your request
This includes sharing your information with:
"	Other people at your request. For example, we may share your ETA and location with a friend at your request, or your trip tracking information with a friend.
"	Helptimize business partners. For example, if you requested a service through a partnership or promotional offering made by a third party, Helptimize may share your information with those third parties. This may include, for example, other apps or websites that integrate with our APIs, suppliers, or services, or those with an API or service with which we integrate, or business partners with whom Helptimize may partner with to deliver a promotion, a contest or a specialized service.
3.	With the general public when you submit content to a public forum
We love hearing from our users -- including through public forums such as blogs, social media, and certain features on our network. When you communicate with us through those channels, your communications may be viewable by the public.
4.	With the owner of Helptimize accounts that you may use
If you use a profile associated with another party we may share your service information with the owner of that profile. This occurs, for example, if you are:
"	A service provider using your employer's Helptimize Business profile account.
"	A teenager between 14-18 years old using linked to a custodial guardian account.
"	A service requestor who arranged the service by a friend or under a Family Profile.
5.	With Helptimize subsidiaries and affiliates
We share information with our subsidiaries and affiliates to help us provide our services or conduct data processing on our behalf. For example, Helptimize may process and stores information in the United States on behalf of its international subsidiaries and affiliates.
6.	With Helptimize service providers and business partners
Helptimize may provide information to its vendors, consultants, marketing partners, research firms, and other service providers or business partners. This may include, for example:
"	Payment processors and facilitators.
"	Background check providers (both buyer and seller of services).
"	Cloud storage providers.
"	Marketing partners and marketing platform providers.
"	Data analytics providers.
"	Research partners, including those performing surveys or research projects in partnership with Helptimize or on Helptimize's behalf.
"	Vendors that assist Helptimize to enhance the safety and security of its apps.
"	Consultants, lawyers, accountants and other professional service providers.
"	Services partners.
"	Insurance and financing partners.
"	Airports.
"	Other local service providers.
"	Restaurant & Business partners.
7.	For legal reasons or in the event of a dispute
Helptimize may share your information if we believe it is required by applicable law, regulation, operating agreement, legal process or governmental request, or where the disclosure is otherwise appropriate due to safety or similar concerns.
This includes sharing your information with law enforcement officials, government authorities, airports (if required by the airport authorities as a condition of operating on airport property), or other third parties as necessary to enforce our Terms of Service, user agreements, or other policies, to protect Helptimize's rights or property or the rights, safety or property of others, or in the event of a claim or dispute relating to your use of our services. If you use another person's credit card, we may be required by law to share information with that credit card holder, including service information.
This also includes sharing your information with others in connection with, or during negotiations of, any merger, sale of company assets, consolidation or restructuring, financing, or acquisition of all or a portion of our business by or into another company.
Helptimize uses a Third-Party Law Firm to resolve any dispute.  As this is a contract driven platform the loser of the dispute will automatically loose 25%-star rating. All data gathered between the 2 parties will be used to help resolve the dispute.

8.	With your consent
Helptimize may share your information other than as described in this policy if we notify you and you consent to the sharing.
Information Retention And Deletion
SUMMARY
Helptimize retains user profile and other information for as long as you maintain your Helptimize account.
Helptimize retains transaction, location, usage and other information for 7 years in connection with regulatory, tax, insurance or other requirements in the places in which it operates. Helptimize thereafter deletes or anonymizes such information in accordance with applicable laws.
Users may request deletion of their accounts at any time. Following such request, Helptimize deletes the information that it is not required to retain, and restricts access to or use of any information it is required to retain.
Helptimize requires user profile information in order to provide its services, and retains such information for as long you maintain your Helptimize account.
Helptimize retains certain information, including transaction, location, device and usage information, for a minimum of 7 years in connection with regulatory, tax, insurance and other requirements in the places in which it operates. Once such information is no longer necessary to provide Helptimize's services, enable customer support, enhance the user experience or other operational purposes, Helptimize takes steps to prevent access to or use of such information for any purpose other than compliance with these requirements or for purposes of safety, security and fraud prevention and detection.
You may request deletion of your account at any time through the Privacy Settings in the Helptimize app, or via Helptimize's website.
Following such request, Helptimize deletes the information that it is not required to retain. In certain circumstances, Helptimize may be unable to delete your account, such as if there is an outstanding credit on your account or an unresolved claim or dispute. Upon resolution of the issue preventing deletion, Helptimize will delete your account as described above.
Helptimize may also retain certain information if necessary for its legitimate business interests, such as fraud prevention and enhancing users' safety and security. For example, if Helptimize shuts down a user's account because of unsafe behavior or security incidents, Helptimize may retain certain information about that account to prevent that user from opening a new Helptimize account in the future.
Choice And Transparency
SUMMARY
Helptimize provides means for you to see and control the information that Helptimize collects, including through:
"	in-app privacy settings
"	device permissions
"	in-app ratings pages
"	marketing opt-outs
You may also request that Helptimize provide you with explanation, copies or correction of your data.
A. PRIVACY SETTINGS
The Privacy Settings menu in the Helptimize app gives users the ability to set or update their location and contacts sharing preferences, and their preferences for receiving mobile notifications from Helptimize. Information on these settings, how to set or change these settings, and the effect of turning off these settings are described below.
"	Location Information
"	Helptimize uses device location services to make it easier to get a safe, reliable service provider whenever you need one. Location data helps improve our services, including pickups, navigation, and customer support.
"	You may enable/disable, or adjust, Helptimize's collection of user location information at any time through the Privacy Settings menu in the Helptimize app, or via the settings on your mobile device. If you disable the device location services on your device, your use of the Helptimize app will be affected. For example, you will need to manually enter your pick-up or drop-off locations. In addition, location information will be collected and linked to your account, even if you have not enabled Helptimize to collect your location information.
"	Share Live Location (Service Requestors)
"	If you have enabled the device location services on your mobile device, you may also enable Helptimize to share your location with your Service Provider from the time you request a service to the start of the service. This makes it easier for your service provider to find your location easily.
"	You may enable/disable location sharing with your service provider at any time through the Privacy Settings menu in the Helptimize app. You may use the Helptimize app if you have not enabled location sharing, but it may be more difficult for your service provider to locate you.
"	Notifications: Account and Trip Updates
"	Helptimize provides users with service status notifications and updates related to your account. These notifications are a necessary part of using the Helptimize app, and cannot be disabled. However, you may choose the method by which you receive these notifications through the Privacy Settings menu in the Helptimize app.
"	Notifications: Discounts and News
"	You may enable Helptimize to send you push notifications about discounts and news from Helptimize. You may enable/disable these notifications at any time through the Privacy Settings menu in the Helptimize app.
B. DEVICE PERMISSIONS
Most mobile platforms (iOS, Android, etc.) have defined certain types of device data that apps cannot access without your consent. And these platforms have different permission systems for obtaining your consent. The iOS platform will alert you the first time the Helptimize app wants permission to access certain types of data and will let you consent (or not consent) to that request. Android devices will notify you of the permissions that the Helptimize app seeks before you first use the app, and your use of the app constitutes your consent.
C. RATINGS LOOK-UP
After every service completed, users are able to rate each other, as well as give feedback on how the service went. This two-way system holds everyone accountable for their behavior. Accountability helps create a respectful, safe environment for both buyers and sellers of services.
Your Service Requestor rating is available in the main menu of the Helptimize app.
Your Service Requestor rating is available in the main menu of the Helptimize app.
D. EXPLANATIONS, COPIES AND CORRECTION
You may request that Helptimize:
"	Provide a detailed explanation regarding the information Helptimize has collected about you and how it uses that information.
"	Receive a copy of the information Helptimize has collected about you.
"	Request correction of any inaccurate information that Helptimize has about you.
You can make these requests by contacting Helptimize via Contact Us page on www.helptimize.com
You can also edit the name, phone number and email address associated with your account through the Settings menu in Helptimize's apps. You can also look up your services history in the Helptimize apps.
E. MARKETING OPT-OUTS
You may opt out of receiving promotional emails from Helptimize. You may also opt out of receiving emails and other messages from Helptimize by following the instructions in those messages. Please note that if you opt out, we may still send you non-promotional messages, such as receipts for your services or information about your account.
Updates To This Policy
SUMMARY
We may occasionally update this policy.
We may occasionally update this policy. If we make significant changes, we will notify you of the changes through the Helptimize apps or through others means, such as email. To the extent permitted under applicable law, by using our services after such notice, you consent to our updates to this policy.
We encourage you to periodically review this policy for the latest information on our privacy practices. We will also make prior versions of our privacy policies available for review.



</div>
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
                    <button class="button-primary WDTH100">Login with LinkedIn</button>
                </div>
                <div>
                    <button class="button-google WDTH100">Login with Google</button>
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


              var formData = {
        		'firstname'     : firstname,
        		'familyname'     : familyname,
        		'customer_username'     : customer_username,
        		'customer_email'     : customer_email,
        		'customer_mobile'     : intlNumber,
        		'customer_password'     : customer_password,
        		'company_name'     : company_name,

				}

				var feedback = $.ajax({

    			type: "POST",
    			url: "create_account.php",
    		    data: formData,

    		    async: false,

    			}).complete(function(){

    			}).responseText;


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

                location.reload();
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



