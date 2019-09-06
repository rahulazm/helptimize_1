<?php
include("header_main.php");

$childid = $_GET['childid'];

$sql_child_details = "SELECT * FROM users WHERE id='" . $childid . "'";
$child_details=$_sqlObj->query($sql_child_details);
?>
<style>
p{
	margin-bottom: 25px !important;
	line-height: 26px;
	width: 100%;
}
</style>
<section class="wrapper" style="width: 60%;margin: auto;text-align: left;">

<h2>CUSTODIAL GUARDIAN/PARENT LINK ACCOUNT REQUEST (CLICKWRAP) AGREEMENT</h2>

<p>I verify <?php echo $child_details[0]['firstName']; ?>, <?php echo $child_details[0]['midName'];?>, <?php echo $child_details[0]['surName']; ?> per ClickWrap agreement that they are between 14 and 18 years old and request to link their account (<?php echo $child_details[0]['username'];?>) with me who they claim is their legal custodian/parent. Please note that Helptimize uses legal contracts for all services and only those who are 18 and older can be legally bound by the contract terms/details. In this regard, all request for services or bids submitted for this user linked to your account will need to be accomplished by the custodial guardian/parent signing this agreement.</p>
<br>
<p>YOU ACKNOWLEDGE THAT HELPTIMIZE DOES NOT PROVIDE THE SERVICES OR LOGISTICS SERVICES OR FUNCTION AS A SERVICE PRIVIDER AND THAT ALL SUCH SERVICES OR LOGISTICS SERVICES ARE PROVIDED BY INDEPENDENT THIRD PARTY CONTRACTORS WHO ARE NOT EMPLOYED BY HELPTIMIZE OR ANY OF ITS AFFILIATES.</p>
<br>
<p>THE SERVICES ARE PROVIDED “AS IS” AND “AS AVAILABLE.” HELPTIMIZE DISCLAIMS ALL REPRESENTATIONS AND WARRANTIES, EXPRESS, IMPLIED OR STATUTORY, NOT EXPRESSLY SET OUT IN THESE TERMS, INCLUDING THE IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT. IN ADDITION, HELPTIMIZE MAKES NO REPRESENTATION, WARRANTY, OR GUARANTEE REGARDING THE RELIABILITY, TIMELINESS, QUALITY, SUITABILITY OR AVAILABILITY OF THE SERVICES OR ANY SERVICES OR GOODS REQUESTED THROUGH THE USE OF THE SERVICES, OR THAT THE SERVICES WILL BE UNINTERRUPTED OR ERROR-FREE. HELPTIMIZE DOES NOT GUARANTEE THE QUALITY, SUITABILITY, SAFETY OR ABILITY OF THIRD PARTY PROVIDERS. YOU AGREE THAT THE ENTIRE RISK ARISING OUT OF YOUR USE OF THE SERVICES, AND ANY SERVICE OR GOOD REQUESTED IN CONNECTION THEREWITH, REMAINS SOLELY WITH YOU, TO THE MAXIMUM EXTENT PERMITTED UNDER APPLICABLE LAW.</p>
<br>
<p>BY CLICKING THE ACCEPTANCE BUTTON USER EXPRESSLY AGREES TO AND CONSENTS TO BE BOUND BY ALL OF THE TERMS OF THIS AGREEMENT AND YOU AGREE THAT YOU ARE THE LEGAL CUSTODIAL GUARDIAN/PARENT FOR THE USER REQUESTING TO LINK ACCOUNT AND WILL TAKE FULL RESPONSIBILITY FOR SAFETY OF MINOR AND LIMIT LIABILITY AND INDEMNIFY HELPTIMZE PER TERMS AND SERVICES AS PREVIOUSLY AGREED VIA CLICKWRAP AGREEMENT.  </p>
<br>
<p style="text-align: left;"><input type="radio" name="agree" id="agreed" value="1">&nbsp; Yes, I Acknowledge that User (<?php echo $child_details[0]['firstName']; ?>, <?php echo $child_details[0]['midName'];?>, <?php echo $child_details[0]['surName']; ?>) is my Custodial Responsibility and Agree to Link this Account (<?php echo $child_details[0]['username'];?>) to My Account.   I Also Acknowledge That I will Be the Sole Signatory For Contracts Linked To My Account.</p>
<br>
<p style="text-align: left;"><input type="radio" name="agree" id="disagreed" value="2">&nbsp; No, I Don’t Agree and Decline Linking User (<?php echo $child_details[0]['firstName']; ?>, <?php echo $child_details[0]['midName'];?>, <?php echo $child_details[0]['surName']; ?>) to My Account.</p>

<p><input type="button" id="submit" value="Submit" onclick="child_account_update('<?php echo $child_details[0]['id']; ?>')"></p>
</section>

<?php include("footer.php"); ?>  