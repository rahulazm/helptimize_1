  <?php
/*require_once("./header_main.php");*/
session_start();

$configs = require_once("/etc/helptimize/conf.php");
require_once("./common.inc.php");
require_once("./mysql_lib.php");

$id=$_sqlObj->escape($_GET['id']);
$bidArr=reset($_sqlObj->query('select * from view_bids where id='.$id.';'));
$srId=$bidArr['srId'];
#########Redirect to preview page if bid is edited
if($bidArr['bidstatus'] =='editbid')
    header('Location: editbid_preview.php?id='.$id);

$srArr=reset($_sqlObj->query('select * from view_serviceRequests where id='.$srId.';'));

$bidInfo=reset($_sqlObj->query('select count(id) as bidNum, (select avg(payAmt) from view_bids where srId='.$srArr['id'].' and payType="fixed") as avgFix, (select avg(payAmt) from view_bids where srId='.$srArr['id'].' and payType="hourly") as avgHr from view_bids where srId='.$srArr['id']));

//"select * from view_pics where srId='".$bidArr['id']."' and userId=".$bidArr['ownerId']." order by datetime, orderNum"

if( $_SESSION['id']!=$bidArr['ownerId'] && $_SESSION['id']!=$bidArr['srOwnerId']){
//echo "You don't have permssion to view this bid.";
//exit;
} $reject="no";
if($bidArr['bidstatus'] == "rejected")
        { 
              $rejectnotes=$bidArr["rejectnotes"];
              $reject="yes";
         }
#############Get Bid Address Location
   $reslt=$_sqlObj->query('SELECT * FROM address WHERE srId="'.$srId.'" and userId = "'.$srArr['ownerId'].'" order by orderNum limit 0,1;');
 $count_addr=count($reslt);
 if( $count_addr > 0)
 {
    $row=reset($reslt);
    $lat=$row['posLat'];
    $lng=$row['posLong']; 
  }
        if($bidArr['status']=='submitted')
          {
            $qstr="select * from address where (srId='".$srId."' and bidId = '".$id."') order by orderNum";
          }
          else
          {
              $qstr="select * from address where (srId='".$srId."' and userId  = '".$srArr['ownerId']."') or (srId='".$srId."' and bidId = '".$id."') order by orderNum";
          }
          $addr=$_sqlObj->query($qstr);
         $row=reset($addr); 
   while ($row) {
   
   $address_id = $row['id'];
   
   $tblRows4.='<tr>
    <td >'.$row['address'].'</td> 
    <td >'.$row['title'].'</td> 
    <td >'.$row['descr'].'</td> 
    <td style="width: 50px">
     <img id="adress_id" adress_id = "' . $address_id . '" src="img/googleicon.png"  height="30" width="30" class="show_address">
    </td> 
        </tr>';
   $row=next($addr);
   }
##########Check bid is accepted in thi SR
$qstr=($_sqlObj->query('
select count(id) as totbid from view_bids where srId='.$srId.' and srBidAwardId is not null'));
$accept_count= $qstr[0]["totbid"];
if($accept_count=="0")$pr_title="Revised Proposed Agreement";
else $pr_title="Awarded Agreement";
$milestones=$_sqlObj->query('select * from milestones where bidId='.$id.';');
$milestone_count=count($milestones);
$ReqPay='';$Popup="no"; $job="no" ;
if($bidArr["status"] == "job completed") $job="yes" ;
                ########Get sum of all Partial/Full amount for this bid from buyer
                    $paidamt=0;
                    $db_get_saved_bids = new mysqli("$host", "$username", "$password", "$db_name");

                    if($db_get_saved_bids ->connect_errno > 0){
                    die('Unable to connect to database [' . $db_get_saved_bids ->connect_error . ']');
                    }
                     $sql_get_saved_bids = "SELECT SUM(payAmt) AS paidamt FROM bidPayments WHERE bidid='".$id."' AND status='19' AND usertype='buyer'";
                    $result_get_saved_bids = $db_get_saved_bids->query($sql_get_saved_bids);
                    $result_get_saved_bids_2 = $db_get_saved_bids->query($sql_get_saved_bids);
                     $count_saved_bids = $result_get_saved_bids->num_rows;
                     $fetch_saved_bids = $result_get_saved_bids->fetch_assoc();
                     $db_get_saved_bids->close();
                     $bid_actual_amount=$remainingamount=$bidArr['payAmt'];
                     $amount_type=1;
                     if($fetch_saved_bids['paidamt'] >0)
                      $paidamt=$fetch_saved_bids['paidamt'];

                      $remainingamount=$bid_actual_amount-$paidamt;
                      $amount_type=2;$bidstatus="";
                     //$bid_actual_amount=$bidArr['payAmt'];
                       if($bid_actual_amount <=$paidamt)
                         {
                           $bidstatus="Job Completed"; 
                           $job="yes" ;
                         }
                    if($row['status'] == "request for payment")
                    {
                   $status="Payment Requested";
                    }
            if( $_SESSION['id']==$bidArr['srOwnerId'] && ($bidArr['status'] == "in work"))
            {
            if($paidamt<$bid_actual_amount && $milestone_count == 0) ///check if bid amount is less than paid amount and no milestone is added
            $ReqPay='<input type="button" value="Make Payment" id="bidReceivePaymentBtn" name="bidRequestPayment"  data-bidid="'.$id.'" data-amount="'.$payAmt.'"  data-amounttype="'.$amt.'" data-actualamount="'.$bidArr['payAmt'].'"  data-paidamt="'.$paidamt.'" data-from="yes" class="approveclick btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border">';
            }
                  else if( $bidArr['status'] == "awarded" && $_SESSION['id']==$bidArr['ownerId'] && $bidArr['bidstatus'] != "cancel")
{
   $Popup="yes";
   $ReqPay='<input type="button" value="ACCEPT AGREEMENT" id="bidReceivePaymentBtn" data-status="16" name="bidRequestPayment" class="changeinwork btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border" style="background-color:red; border-color: red;font-weight:bold;">';
}
   #########Bidder Gold rating
   $qstr="select * from checkr_verification where user_id = '".$bidArr['ownerId']."' order by id desc";
  $document=$_sqlObj->query($qstr);
   $count_doc_bidder=count($document);
  if($count_doc_bidder>0) $gold_rating_bidder='<a href="javascript:void()" class="gold_star_click" data-userid="'.$bidArr['ownerId'].'  "><img src="img/goldstar.jpg" width="25px"></a>';
  #########Requestor Gold rating
   $qstr="select * from checkr_verification where user_id = '".$bidArr['srOwnerId']."' order by id desc";
  $document=$_sqlObj->query($qstr);
   $count_doc_bidder=count($document);
  if($count_doc_bidder>0) $gold_rating_requestor='<a href="javascript:void()" class="gold_star_click" data-userid="'.$bidArr['srOwnerId'].'  "><img src="img/goldstar.jpg" width="25px"></a>';
   #########Bidder Silver rating
  $qstr="select * from verifyDocs where userId = '".$bidArr['ownerId']."' order by id desc";
  $document=$_sqlObj->query($qstr);
  $count_doc_bidder=count($document);
  if($count_doc_bidder>0) $silver_rating_bidder='<a href="javascript:void()" class="silver_star_click" data-userid="'.$bidArr['ownerId'].'  "><img src="img/silverstar.jpg" width="25px"></a>';
  #########Requestor Silver rating
  $qstr="select * from verifyDocs where userId = '".$bidArr['srOwnerId']."' order by id desc";
  $document=$_sqlObj->query($qstr);
  $count_doc_requestor=count($document);
  if($count_doc_requestor>0) $silver_rating_requestor='<a href="javascript:void()" class="silver_star_click" data-userid="'.$bidArr['srOwnerId'].'  "><img src="img/silverstar.jpg" width="25px"></a>';
   #########Bidder Blue star rating
   $sql_rating = "SELECT AVG(rating) AS rating FROM ratings WHERE toUserId='".$bidArr['ownerId']."' ";
   $rating=$_sqlObj->query($sql_rating);   
   $Bidder_bluestar_Percentage=($rating[0]['rating']*100)/5;
   $sql_rating = "SELECT * FROM view_serviceRequests WHERE bidderId='".$bidArr['ownerId']."' or ownerId='".$bidArr['ownerId']."' ";
    $rating=$_sqlObj->query($sql_rating); 
    $count_rating_bidder=count($rating); 
    if($count_rating_bidder>5 && $Bidder_bluestar_Percentage>80) $bluestar_rating_bidder='<a href="javascript:void()" class="blue_star_click" data-userid="'.$bidArr['ownerId'].'  "><img src="img/bluestar.png" width="25px"></a>'; 
#########Requestor Blue star rating
   $sql_rating = "SELECT AVG(rating) AS rating FROM ratings WHERE toUserId='".$bidArr['srOwnerId']."' ";
   $rating=$_sqlObj->query($sql_rating);   
   $Requestor_bluestar_Percentage=($rating[0]['rating']*100)/5;
  $sql_rating = "SELECT * FROM view_serviceRequests WHERE bidderId='".$bidArr['srOwnerId']."' or ownerId='".$bidArr['srOwnerId']."' ";
    $rating=$_sqlObj->query($sql_rating); 
    $count_rating_requestor=count($rating); 
    if($count_rating_requestor>5 && $Requestor_bluestar_Percentage>80) $bluestar_rating_requestor='<a href="javascript:void()" class="blue_star_click" data-userid="'.$bidArr['srOwnerId'].'  "><img src="img/bluestar.png" width="25px"></a>'; 
   
   
$userBoxArr['bidder']='
                       <div class="requester">
                                <label for="requesterBox">
                                Username:                               </label>

                                <label class="SRRequesterName" for="requesterBox" style="cursor: pointer;">
                                '.$bidArr['ownerName'].' 
                                <img id="profile_click_published" profile_id_published = "" src="profile_pictures/helptimizesmall.png" class="img-circle" >
                                </label><br>
                                <label for="requesterBox">Communicate: </label>
                                <label class="SRRequesterName" for="requesterBoxB">
                                        <a href="javascript:void()" class="videoclick" data-from="buyer" data-user="'.$bidArr['ownerName'].'" >
                                        <img  src="img/chat.png"   width="50px" >
                                        </a><a href="javascript:void()" class="democlick" >View Chat Demo</a>
										  </label><br>
										 <!-- <label for="requesterBox">
                                Star Rating:</label>
                                <label class="SRRequesterName" for="requesterBoxB">'.
                                $Bidder_bluestar_Percentage
                                .'%</label><br>
                                <label for="requesterBox">
                                Diamond Rating:</label>
                                <label class="SRRequesterName" for="requesterBoxB">
                                <input type="checkbox" id="requesterBoxB" class="checkHideShow" style="display: none;"> 
                                </input>'.$silver_rating_bidder.$bluestar_rating_bidder.$gold_rating_bidder.'
                                </label>-->
                                 <input type="checkbox" id="requesterBox" class="checkHideShow" style="display: none;"> 
        </input>
        
        <div class="checkHideShowHide">
          <label>Name: '.$bidArr['ownerFirstName'].' '.$srArr['ownerSurName'].'</label> <br>
           <label>
                                Star Rating:</label>
                                <label>
                                '.$Bidder_bluestar_Percentage.'%</label><br>
                                <label>
                                Diamond Rating:</label>
                                <label>
                                '.$silver_rating_bidder.$bluestar_rating_bidder.$gold_rating_bidder.'
                                </label><br>
                <label>Number of bids: </label><span class="label label-success">'.$bidInfo['bidNum'].'</span><br>
                  <label>Average fix cost amount: </label>'.$bidInfo['avgFix'].'<br>
  
          <label>Average hourly cost amount: </label>'.$bidInfo['avgHr'].'
        </div> 
                        </div>
'; $var='';
   if($bidArr['status']=='awarded')
  {
   $var='<label>Name: '.$srArr['ownerFirstName'].' '.$srArr['ownerSurName'].'</label>';
  }
$userBoxArr['requester']='
                       <div class="requester">
                                <label for="requesterBox">
                                Username:                               </label>

                                <label class="SRRequesterName" for="requesterBox" style="cursor: pointer;">
                                '.$bidArr['srOwnerName']  ;
                                 if($bidArr['status']=='awarded')
  {          
                               $userBoxArr['requester'].=' <img id="profile_click_published" profile_id_published = "" src="profile_pictures/helptimizesmall.png" class="img-circle" >'; }
                                $userBoxArr['requester'].='  </label><br>
                             
                              <label for="requesterBox">
                                Communicate:
                                </label>
                                <label class="SRRequesterName" for="requesterBoxB">
                                        <a href="javascript:void()" class="videoclick" data-from="seller" data-user="'.$bidArr['srOwnerName'].'">
                                         <img  src="img/chat.png" width="50px"  >
                                        </a><a href="javascript:void()" class="democlick" >View Chat Demo</a>
											</label><br>
										 <!--	<label for="requesterBox">
                                Star Rating:</label>
                                <label class="SRRequesterName" for="requesterBoxB">'.
                                $Requestor_bluestar_Percentage
                                .'%</label><br>
                                <label for="requesterBox">
                                Diamond Rating:</label>
                                <label class="SRRequesterName" for="requesterBoxB">
                                <input type="checkbox" id="requesterBoxB" class="checkHideShow" style="display: none;"> 
                                </input>'.$silver_rating_requestor.$bluestar_rating_requestor.$gold_rating_requestor.'
                                </label>
                                <br>-->
                     
        <input type="checkbox" id="requesterBox" class="checkHideShow" style="display: none;"> 
        </input>
        
        <div class="checkHideShowHide">'. $var.'
          <!--<label>Name: '.$srArr['ownerFirstName'].' '.$srArr['ownerSurName'].'</label> --><br>
           <label>
                                Star Rating:</label>
                                <label>
                                '.$Requestor_bluestar_Percentage.'%</label><br>
                                <label>
                                Diamond Rating:</label>
                                <label>
                                '.$silver_rating_requestor.$bluestar_rating_requestor.$gold_rating_requestor.'
                                </label><br>
                <label>Number of bids: </label><span class="label label-success">'.$bidInfo['bidNum'].'</span><br>
                  <label>Average fix cost amount: </label>'.$bidInfo['avgFix'].'<br>
  
          <label>Average hourly cost amount: </label>'.$bidInfo['avgHr'].'
        </div> 
                        </div>
';

$userBox="";


$actionBox['bidder']='
 <div class="SRActionBox dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
  <span class="caret"></span></button>

  <ul class="dropdown-menu dropdown-menu-right">
    <li>
        <a href="" data-toggle="modal" onclick="doneBid(\''.$id.'\')">Completed</a>
    </li>';
    if($bidArr['bidstatus']!='cancel'){ 
      if($bidArr['status']=='submitted'  || $bidArr['status']=='waiting for approval'){
      $actionBox['bidder'].='<li><a href="#" class="statusclick">Cancel</a></li>';
      $actionBox['bidder'].=' <li><a href="javascript:void(0)" data-from="resubmit" class="statusclick" >Cancel and Resubmit</a></li>';
      
    }
    if($bidArr['status']=='awarded'){
    $actionBox['bidder'].='<li><a href="#" data-toggle="modal" data-target="#confCncModal">Cancel</a></li>';
    $actionBox['bidder'].=' <li><a href="javascript:void(0)" data-toggle="modal" data-target="#confResModal" >Cancel and Resubmit</a></li>';
    }
    if($bidArr['bidstatus'] =='editbid')
    $actionBox['bidder'].='<li><a href="editbid_preview.php?id='.$id.'" >Revised Bid</a></li>';
    else
       $actionBox['bidder'].='<li><a href="bid_reupdate.php?id='.$id.'" >Edit Agreement</a></li>';

}
else
{
  $actionBox['bidder'].='<li><a href="bid_interested.php?id='.$srId.'">Resubmit</a></li>';
}
  $actionBox['bidder'].='</ul>
</div> 
';
if($bidArr['status'] != "job completed")
{
$actionBox['requester']='
 <div class="SRActionBox dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
  <span class="caret"></span></button>

  <ul class="dropdown-menu dropdown-menu-right">
   <li>
        <a href="" data-toggle="modal" onclick="doneBid(\''.$id.'\')">Completed Job</a>
    </li>
   ';
   
       if($bidArr['status']=='awarded'){ 
    $actionBox['requester'].='<li><a href="#" class="statusclick">Cancel</a></li>';
   }
    if($bidArr['bidstatus'] =='editbid')
    $actionBox['requester'].='<li><a href="editbid_preview.php?id='.$id.'" >Revised Bid</a></li>';
    else
       $actionBox['requester'].='<li><a href="bid_reupdate.php?id='.$id.'" >Edit Agreement</a></li>';

  $actionBox['requester'].='</ul>
</div> 
';
}
$actionBox['requester'].='
<div class="SRActionBox dropdown">';

  
  if($bidArr['status']=='request for payment'){
                    ########Get Partial/Full amount
                    $db_get_saved_bids = new mysqli("$host", "$username", "$password", "$db_name");

                    if($db_get_saved_bids ->connect_errno > 0){
                    die('Unable to connect to database [' . $db_get_saved_bids ->connect_error . ']');
                    }
                    $sql_get_saved_bids = "SELECT * FROM bidPayments WHERE bidid='".$id."' AND status='18' AND usertype='seller' order by id desc limit 1 ";
                    $result_get_saved_bids = $db_get_saved_bids->query($sql_get_saved_bids);
                    $result_get_saved_bids_2 = $db_get_saved_bids->query($sql_get_saved_bids);
                     $count_saved_bids = $result_get_saved_bids->num_rows;
                     $fetch_saved_bids = $result_get_saved_bids->fetch_assoc();
                     $db_get_saved_bids->close();
                     $amounttype=$fetch_saved_bids['amounttype'];
                     $payAmt=$fetch_saved_bids['payAmt'];
                     if( $amounttype == "1")
                     {
                         //$payAmt=$row['payAmt'];
                         $amt="Full Payment";
                     }
                     else $amt="Partial Payment";
                     if($milestone_count==0)
            $actionBox['requester'].='
                <a href="javascript:void();" class="bidAwardLbl approveclick" style="padding: 8px 20px 8px 20px; margin-left: 10px;" data-bidid="'.$id.'" data-amount="'.$payAmt.'"  data-amounttype="'.$amt.'" data-actualamount="'.$bidArr['payAmt'].'"  data-paidamt="'.$paidamt.'"  data-from="no"><i class="material-icons" id="material-icons" >local_atm</i><span style="margin-left: 5px;">Approve Payment</span></a>';

  }
$actionBox['requester'].='</div>';




$notifBoxArr['bidder']="
<div class='SRDetailsBox'>
<div class='alert alert-warning'>
        Submitted Bid:
</div>
";
$notifBoxArr['requester']="";

$actionhtml='';

switch($_SESSION['id']){
  case $bidArr['srOwnerId']:
  //bidder
    $userBox=$userBoxArr['bidder'];
    $actionhtml=$actionBox['bidder'];
  break;
  case $bidArr['ownerId']:
  //requester
  $userBox=$userBoxArr['requester'];
  $actionhtml=$actionBox['requester'];
  $notifBox=$notifBoxArr['requester'];
  break;
  default:
  exit;
  break;
}


$srPicsB=$_sqlObj->query('select * from view_pics where (bidId='.$id.' and userId='.$bidArr['ownerId'].') or (srId='.$srArr['id'].' and userId='.$srArr['ownerId'].') order by datetime, orderNum asc;');
$picsRowB=picsRow($srPicsB);

$orig_sr=$bidArr;

$dtFrom=explode(' ',$bidArr['dateTimeFrom']);
$dtTo=explode(' ',$bidArr['dateTimeTo']);





//milestone html
                $inOffTmpl='

                 <!-- Modal -->
  <div id="confCncModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content" style="padding: 0px;">
        <div class="alert alert-danger" style="margin: 0px;">

    <div style="margin-bottom: 10px; font-weight: bold;">
    Warning! 
    </div>

    <div style="margin-bottom: 15px;">Cancelling a  bid  will affect your rating and there will be a penalty charge of 5 USD</div>

    <div style="width: 100%; text-align: right;">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      <a href="javascript:void()"  data-status="cancel"  role="button" class="btn btn-default statusclick">I understand and accept</a>
    </div>

        </div>
      </div>

    </div>
  </div>

   <!-- Modal -->
  <div id="confResModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content" style="padding: 0px;">
        <div class="alert alert-danger" style="margin: 0px;">

    <div style="margin-bottom: 10px; font-weight: bold;">
    Warning! 
    </div>

    <div style="margin-bottom: 15px;">Cancelling and Resubmitting a  bid  will affect your rating and there will be a penalty charge of 5 USD</div>

    <div style="width: 100%; text-align: right;">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      <a href="javascript:void()"  data-status="cancel"  role="button" class="btn btn-default statusclick" data-from="resubmit">I understand and accept</a>
    </div>

        </div>
      </div>

    </div>
  </div>';
  if($bidArr['payType'] == "hourly")
$cols=6;
else
$cols=5;
 if($milestone_count > 0)
{
 $inOffTmpl.=' 

<table id="open_bid_milestone" class="table table-striped table-bordered" cellspacing="0" width="100%" style="border-radius: 8px 8px 0px 0px;">
                <thead>
                <tr>
                <th colspan="5" id="titleHeaders" style="background: none; color: black; border-right: 0px;">Milestones</th>
                <th style="text-align: right;">
               </th> 
                </tr>
                <tr class="colHeader">
                         <th style="width: 10%;">Name</th>
                         <th style="width: 10%;">Request Pay</th>
                         <th style="width: 10%;">Status</th>
                        <th style="width: 20%;">Date</th>
                        <th>Description</th>';
                        if($bidArr['payType'] == "hourly") { $inOffTmpl.='<th>Hours</th>'; }
                        $inOffTmpl.='
                        <th style="width: 5%;">% of Agreement Sum</th>
                        </tr>
                </thead>
                
                <tbody class="tbodyBorder" id="milestoneBody">';
$view=0;$amt=0;
                if(is_array($milestones)){
                $row=reset($milestones);
                      $i=key($milestones);
        while($row){
          #########Get status of milestone payment
              
              $milestones_last_payment=$_sqlObj->query( "SELECT *  FROM bidPayments WHERE bidid='".$id."' AND milestoneId='".$row['id']."'  order by id desc limit 1");  
             
            $dsbl="readonly";$checkedDisabled='';
            $cbCelld="<td style='text-align: center;'></td>"; 
            $cbCell='<i class="material-icons" style="color:orange" id="material-icons">
      build
      </i>';
      $status=$bidArr['status'];  $requestp="<input class='' type='checkbox' data-amount='".$row['amount']."'  value='".$row['id']."' ".$checkedDisabled." name='checkArray[]' id='checkArray'>";
if( $_SESSION['id']==$bidArr['srOwnerId'] && ($bidArr['status'] == "approved payment" || $bidArr['status'] == "payment rejected"|| $bidArr['status'] == "request for payment"|| $bidArr['status'] == "job completed"))
{
    
     $status="In work"; 
     $cbCell='<i class="material-icons" style="color:orange" id="material-icons">
      build
      </i>';
     if(count($milestones_last_payment) > 0)
     {
         $milestonestaus= $milestones_last_payment[0]["status"];     
         if($milestonestaus == "18") 
         {
           $cbCell=$requestp;   $status="Payment Requested";
         }
         elseif($milestonestaus == "20") 
         {
            $status="Rejected";
            $cbCell='<i class="material-icons" style="color:red" id="material-icons">
      thumb_down
      </i>';
         }     
         elseif($milestonestaus == "19")  
         {
            $status="Paid"; 
            $cbCell='<i class="material-icons" style="color:green" id="material-icons">
      thumb_up
      </i>';
         }
     }
   
     if($cbCell==$requestp) $view++; $button="Approve/Reject"; $from="both";
 }
 if($status =="in work")
 {
  $cbCell=$requestp; $view++;
  $button="Approve Payment"; $from="one";
 }
 $cbCelld="<td style='text-align: center;'>".$cbCell."</td>";

               
         $inOffTmpl.='<tr><td><input type=\'input\' name=\'milestones[][name]\' value=\''.$row['name'].'\' '.$dsbl.' /></td>'.$cbCelld.'<td>'.$status.'</td><td><input type=\'input\' name=\'milestones[][due_datetime]\' value=\''.changeDateFormat($row['due_datetime']).'\' '.$dsbl.' /></td><td><input type=\'input\' name=\'milestones[][descr]\' value=\''.$row['descr'].'\' '.$dsbl.' /></td>';
                        if($bidArr['payType'] == "hourly") { $inOffTmpl.='
                        <td><input class="milestoneAmt" type=\'input\' name=\'milestones[][totalhours]\'  value=\''.$row['totalhours'].'\' '.$dsbl.' /></td>'; }
                        $inOffTmpl.='<td><input class="milestoneAmt" type=\'input\' name=\'milestones[][amount]\' onchange=\'milestoneTotalFunc(".milestoneAmt", "#milestoneTotal")\' value=\''.$row['amount'].'\' '.$dsbl.' /></td></tr>';
        $amt+=$row['amount'];
         $row=next($milestones);
        $i=key($milestones);

        }

    }
//$cols=5;
  //  $inOffTmpl.=mileStoneRow($milestones, true, true);
                $inOffTmpl.='
                </tbody>
                <tfoot>
                        <tr>';if($view>0) {
                        $cols=$cols-2; 
                                 $inOffTmpl.="<td colspan=2><button onclick='doneMileStone(this, \"".$row['bidId']."\", \"".$from."\", \"".$row['amount']."\")' class='btn btn-primary'>".$button."</button></td>";
                              }
                                $inOffTmpl.='<td colspan='.$cols.'>
                                Sum
                                </td>
                                <td>
                                <input type="input" id="milestoneTotal" placeholder="total" value="'.$amt.'" />
                                </td>
                        </tr>
                <tfoot>
</table>';


}


$html='
<!DOCTYPE html>
<html>
  <head>
'.$_template["header"].'
    <script>


    





    


    /*---------------------------
    pre: everything in this page
    post: database updated
    sends the update to the database of setting the bidAwardedId
    ----------------------------*/
    function awardBid(srId, bidId){
    rslt=urlCall("./bid_award.php?srId="+srId+"&bidId="+bidId);
      
                sRslt=JSON.parse(rslt);
                        if(sRslt[\'status\']==1){
                                swal({
                                  title: "Bid Awarded",
                                  text: "Bid has been Awarded"
                                },
        function(){
                                location.href = "main.php";
                                }
        );
                        }
      else{
        swal({
          title: "Bid award unsuccessful",
          text: sRslt[\'msg\']
        });
      }

                return 0;
    }

    $( document ).ready(function() {

      alternateLabels("pay_rate");
      permaHideShow("checkHideShowBare");
      //milestoneTotalFunc(".milestoneAmt", "#milestoneTotal")

      $(\'input[type="checkbox"].checkHideShow\').click(function() {
          if (this.checked) {
        $(this).next(\'div\').attr(\'class\', \'checkHideShowShow\');
          } else {
        $(this).next(\'div\').attr(\'class\', \'checkHideShowHide\');
          }
      });
  

    });

    </script>

  </head>

  <body>
'.$_template["nav"].'


<form id="bidConfirm" action="javascript:void(0);" method="POST">
<div class="SRDetailsBox"><span align="left" ><button onclick="goBack()" class="btn btn-primary">Back</button></span>
'.$notifBox.$actionhtml.'


<table id="open_sr_list" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                        <th colspan="2" id="titleHeaders" >
                        <label for="comment">'.$pr_title.': '.$bidArr['title'].' <strong>('.$bidArr['id'].')</strong>
                        </label>
                        </th>
                </tr>
    </thead>
                <tbody class="tbodyBorder" id="bidInterested">
                <tr class="colHeader">
    <td>
    '.$userBox.'  
      
      <div class="form-group">
    
        <label>Category:  '.$bidArr['categ_name'].'</label>
            '.$ReqPay.'</td>
    </tr>
    
    <tr>
    <td class="sr_details">

        <div class="SRDueDate">
        <label for="comment">Target Service Request Start and End Date/Time:</label><br>
        <input type="text" name="dateTimeFrom" value="'.changeDateFormat($bidArr['dateTimeFrom']).'" readonly">
         - 
        <input name="dateTimeTo" type="text" value="'.changeDateFormat($bidArr['dateTimeTo']).'" readonly">
        </div>';

                if($bidArr['payType'] == "hourly")
                {
                  $pay_amount=$bidArr['rateperhour']."/".$bidArr['totalhours']."Hours";
                }
                else $pay_amount=$bidArr['payAmt'];
                $html.='<div>
        <label for="comment">Payment rate/type:</label>
        <br>
        <span><input name="payType" type="input" value="'.$bidArr['payType'].'" style=" width: 60px;" readonly />$<input name="payAmt" type="input" value="'.$pay_amount.'" style="width: 60px;" readonly/></span>
        </div>
      </div>';
            if($bidArr['payType'] == "fixed")
                {
           $html.=' <div class="SRDueDate">
        <label for="comment">Set Schedule & Notes</label><br>
        <input type="text" name="set_schedule" value="'.$_configs['scheduleArray'][$bidArr['set_schedule']].'"  readonly>';
         if($bidArr['set_schedule'] != "1")
                {
        $html.='<input name="schedule_amount" type="text" value="'.$bidArr['schedule_amount'].'"  readonly>
        <input name="schedule_note" type="text"value="'.$bidArr['schedule_note'].'"  readonly>';
      }
        $html.='</div>';
      }

                $html.='

                </td>
    </tr>

               <!-- <tr>
                <td>

                        <div>
                                <label for="comment">'.BIDS_CANCEL_FEE.'</label>
                        </div>

                        <div class="form-group has-feedback" style="padding: 0px 0px 0px 10px; margin: 0px; width: 200px; text-align: left; display: inline-block; vertical-align: middle;">
                                <input  type="text"  style="text-align:center;" class="form-control" id="target_fix_rate" name="cancelFee" value="'. $bidArr['cancelFee'].'">
                                <i class="glyphicon glyphicon-usd form-control-feedback"></i>
                        </div>


                </td>
    </tr>--!>

    <tr>
    <td>

      <div class="form-group">
        <label for="comment">Proposed Agreement Detail Description</label>
      <textarea readonly placeholder="Describe the details of services required and upload any supporting data and pictures to help explain services needed"  class="form-control" rows="4" id="service_description" name="descr">'.$bidArr['descr'].'</textarea>

      </div>
 
    </td>
    </tr>

    <tr>
    <td>
 

       <label for="comment">Pictures</label>

      <div class="panel panel-default text_input_radius">
      <div class="panel-body" style="color:#000000;">
      '.$picsRowB.'
      </div>
      </div>

      </td>
    </tr>
';
    if($srArr['ownerId'] == $_SESSION['id'])
{

  $html.='<tr>
    <td>
 

       <label for="comment">Personal Notes</label>
       <div class="form-group">
        
      <textarea readonly placeholder="<?php echo SERVICE_DESCRIPTION_TEXT;?>"  class="form-control" rows="4" id="service_description" name="service_description">'.$srArr['summ'].'</textarea>
      </div>
       </td></tr>';
    }
$html.='
    <tr>
    <td>
      
      <table id="awarded_sr_list" class="table table-striped table-bordered" cellspacing="0" width="100%" style="border-radius: 8px 8px 0px 0px;">
          <thead>
              <tr>
                  <th>Location</th>
                   <th>Title</th>
                  <th>Description</th>
                  <th></th>
                  
                  </tr>
          </thead>
          
          <tbody>';

          if($bidArr['status']=='submitted')
          {
            if($count_addr > 0)
        { 
      
          $html.='<tr> <td style="width: 100%;" colspan="4"><p>Once buyer award the project to you, the actual address will be displayed"</p>
        <div id="googleMap" ></div>
        </td></tr>';

        }
          }
          $html.=$tblRows4.' 
            </tbody>
       </table>


                </td>
        </tr>
  <tr>
    <td>
'.$inOffTmpl.'

    </td>
  </tr>
</tbody>
</table>
</div>



</form>


<div id="modal_profile_published" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" style="color:#000000";><center> USER_PROFILE </center></h4>
                </div>
                        <div class="modal-body">
                        
                        <br>
                        <center>
                        
                        <span id="large_profile_picture"></span>
                        
                        
                        </center>
                        <br>
                        <br>
                        
                        <table>
                                <tr>
                                        <td width="120px"><?php echo PROFILE_USERNAME;?></td><td></td><td><span id="profile_username"></span></td>
                                </tr>
                                <tr>
                                        <td><?php echo PROFILE_NAME;?></td><td><t/d><td><span id="profile_name"></span></td>
                                        
                        
                        
                                </tr>
                        </table>
                        
                        <br>
                        
                        <center>
                        
                        <button class="btn btn-success" onclick="profile_close_published()">'.CLOSE.'</button>
                        
                        </center>
                                                
                        </div>
            </div>
        </div>
    </div>';


  

//echo $html;

?>
<div id="modal_request_pay" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h6 class="modal-title" style="color:#000000";><center><i class="fa fa-info-circle" aria-hidden="true"></i><span class="approvehead">Approve / Reject Payment Request</span></center></h6>
                </div>
                    <div class="modal-body">
                    
                
                <form id="request_payment">


                <div class="form-group">
                        <label><font color="black"><span class="dyn_content"></span></font></label>
                       
                    </div>

                <div class="form-group statusclass">
                        <label><font color="black">Status</font></label>
                        <select class="form-control" id="status_type" name="status_type">

                                <option value="1">Approved</option>
                                <option value="2">Rejected
                                </option>
                            </select>
                    </div>
                    <div class="hideclass"><input type="hidden" name="status_type" id="status_type" value="1"> 
                      <input type="hidden" id="userid" value="<?php echo $_SESSION ?>"></div>
                
                  
                    <div class="form-group shownotes">
                        <label><font color="black">Notes</font></label>
                        <textarea class="form-control" id="notes" name="notes">
</textarea>

                    </div> 
                    
                    <div class="form-group showtype">
                        <label><font color="black"><?php echo AMOUNT_TYPE;?></font></label>
                        <select class="form-control" id="amount_type" name="amount_type">
<option value=""><?php echo SELECT_AMOUNT_TYPE; ?></option>
                                <option value="1"><?php echo FULL_AMOUNT; ?></option>
                                <option value="2"><?php echo PARTIAL_AMOUNT; ?>
                                </option>
                            </select>
                    </div>
                
                    
                    <div class="form-group showamount">
                        <label><font color="black"><?php echo ENTER_PAMOUNT;?></font></label>
                        <input placeholder="<?php echo ENTER_PAMOUNT;?>" type="text" class="form-control" id="amount" name="amount">
                    </div>
                    
                    
                    <input type="hidden" name="bidid" value="" id="bidid">
            <input type="hidden" name="bidamount" value="" id="bidamount">

            <input type="hidden" name="paidamt" value="" id="paidamt">
                    
                    
                    <center>
                    
                    <button type="submit" class="btn btn-success" ><?php echo SUBMIT;?></button>
                    
                        </form>
                    
                    </center>
                            
                    </div>
            </div>
        </div>
    </div>

    <div id="modal_milestone_pay" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="color:#000000";><center><i class="fa fa-info-circle fa-2x" aria-hidden="true"></i>Reject Milestone Payment</center></h4>
                </div>
                    <div class="modal-body">
                    
                
                <form id="milestone_payment">

                <div class="form-group">
                        <label><font color="black">Milestone Amount :  <span class="mdyn_content"></span></font></label>
                       
                    </div>

                      
                
                  
                    <div class="form-group ">
                        <label><font color="black">Notes</font></label>
                        <textarea class="form-control" id="mnotes" name="notes">
</textarea>

                    </div> 
                    
                
                    
                    
                    <input type="hidden" name="mid" value="" id="mid">
           <input type="hidden" name="mamount" value="" id="mamount">
                    
                    
                    <center>
                    
                    <button type="submit" class="btn btn-success" ><?php echo SUBMIT;?></button>
                    
                        </form>
                    
                    </center>
                            
                    </div>
            </div>
        </div>
    </div>


    
<script type="text/javascript">

    
///Accept popup
$( document ).ready(function() {
  <?php if($reject == "yes"){ ?>
    swal({
                                        title: "Change Request - Rejected",
                                        text: "<?php echo $rejectnotes; ?>",
                                        type: "warning"
                                        
                    
                    
              
                        }); 

  <?php }  else if($Popup == "yes"){ ?>
    swal({
                                        title: "Accept Agreement",
                                        text: "You have been awarded the project. Please accept and start work!",
                                        type: "warning"
                                       
                    
              
                        }); 

  <?php } else if($job == "yes"){ ?>
    swal({
                                        title: "Job Completed",
                                        text: "This project is completed! ",
                                        type: "warning"
                                        
                    
                    
              
                        }); 

  <?php } ?>

});
 $(document).on("click", ".democlick", function(e) {
 $('#modal_demovideo_click').modal('show');
    });

  
///////////Video call click script --- Start - 13.05.19
$(document).on("click", ".videoclick", function(e) {
    var from =($(this).data('from'));
    var user =($(this).data('user'));
    var sr_id = <?php echo $srId; ?>;
    var status = "<?php echo $bidArr['status']; ?>";
    var bidstatus = "<?php echo $bidstatus; ?>";
    var addi="";
    if((status == "job completed" || bidstatus =="Job Completed") && from == "buyer")
    {
        var addi="Additionally you will be charged 5 USD as the Agreement is completed.";
    }
    if(from == "buyer")
      var tle= "Communicate to Provider";
      else if(from == "seller")
    var tle= "Communicate to Requestor";
  
  if(from == "buyer")
  var msg1=" Should you cancel this request after communicating with this seller a small fee will be charged per terms and services agreement. ";
  else 
  var msg1="";

  var msg="Your communication request will be sent to " + user + ". " + msg1 +  addi + " Are you sure to continue?";

  
   swal({
                                        title: tle,
                                        text: msg,
                                        type: "warning",
                                        showCancelButton: true,
                                        cancelButtonText: "Cancel",
                                        confirmButtonColor: "#5cb85c",
                                        confirmButtonText: "Chat Now",
                                        closeOnConfirm: true
                                },

                                function(conf){
          if(conf){         
         
          //call here for         
          var rtrnObj=(urlCall('./videocall.php?usertype='+from+'&sr_id='+sr_id));
            if(rtrnObj=="success"){
                           
                             window.open("messaging_specific.php?sr_id="+sr_id);
                    }
            
          }
                        }); 

});
 ///////////Video call click script --- End - 13.05.19

    //////////Approve/Reject Form Submit -- Start
$(".showamount").hide();$(".shownotes").hide();

$(document).on("click", ".approveclick", function(e) {
    var id =($(this).data('bidid'));
    var bidamount =($(this).data('amount'));
    var amounttype =($(this).data('amounttype'));
    var actualamount =($(this).data('actualamount'));
    var paidamt =($(this).data('paidamt')); 
    var from =($(this).data('from')); 
       
   $("#bidid").val(id);
   $("#bidamount").val(actualamount); 
   $("#paidamt").val(paidamt); 
   if(from =="no")
   {   
   $(".dyn_content").html("Requested Amount :  $"+bidamount+" ("+amounttype+")");
    $(".statusclass").show();
    $(".hideclass").hide();
    }
    else
    {
      $(".dyn_content").html("");
     $(".approvehead").html("Make Payment"); 
     $(".statusclass").hide();
     $(".hideclass").show();
    }

    $('#modal_request_pay').modal('show');

});
$(document).on("change", "#amount_type", function(e) {

    if($('#amount_type').val() == "2")
    $(".showamount").show();
    else {
        $(".showamount").hide();
    }

});

$(document).on("change", "#status_type", function(e) {

    if($('#status_type').val() == "1")
    {
    $(".showtype").show();
    $(".shownotes").hide();
}
    else {
        $(".shownotes").show();
        $(".showtype").hide();
        $(".showamount").hide();
    }

});

$('#request_payment').formValidation({
        framework: 'bootstrap',
        
        fields: {
            amount_type: {
                validators: {
                    notEmpty: {
                        message: "Please select Amount type"
                    }
                    
                }
            },
            amount: {
                validators: {
                    notEmpty: {
                        message: "Please Enter Partial Amount"
                    }
                    
                }
            }
                
            
        }
    }).on('success.form.fv', function(e) {
    
            e.preventDefault();
        
            
            var amount_type = $('#amount_type').val();
            var status_type = $('#status_type').val();
            var bidid = $("#bidid").val();
            var notes = $("#notes").val();  
            var bidamount = parseInt($("#bidamount").val()); 
            var paidamt = $("#paidamt").val();

           
            ///if status type is approved only check amount condition
            if($('#status_type').val() == "1")
            {
            ///if amount type is full then save bid amount
            if($('#amount_type').val() == "1")
                var amount = parseInt(bidamount);
            else
                var amount = parseInt($('#amount').val());

            ///Total amount calculation (add already paid amount with current entered amount)
            var total=parseInt(paidamt)+parseInt(amount);

            // check if amount exceed the bid amount
            if(amount>bidamount || total>bidamount)
            {
                 swal("Error", "Amount exceeded bid amount", "error");
                 return false;
            }       
        
            }
            
            var formData = {
                'amount_type'     : amount_type,
                'status_type'     : status_type,
                'amount'     : amount,
                'bidid' : bidid,
                'mid' : 0,
                'notes' : notes,
                'userid' : <?php echo $_SESSION['id']; ?>
            }
    
      
            var feedback = $.ajax({
                type: "POST",
                url: "service_approve_payment.php",
                data: formData,         
                async: false,
                
            }).complete(function(){
            
            
            }).responseText;
        
  
            if(feedback == "success"){
            
              swal({
                    type : "success",
                    title: "Success",
                    text: "Payment Requested responded successfully"
               },
                function(){
                       $('#modal_request_pay').modal('hide');
                      window.location.href="main.php";
                }
                );

            
            }
  
            
            
    
     });
  
//////////Approve/Reject Form Submit -- End

/////Milestone Reject Form Submit -- Start
$('#milestone_payment').formValidation({
        framework: 'bootstrap',
        
        fields: {
            
            notes: {
                validators: {
                    notEmpty: {
                        message: "Please Enter notes"
                    }
                    
                }
            }
                
            
        }
    }).on('success.form.fv', function(e) {
    
            e.preventDefault();
       
            
            var mid = $("#mid").val();
            var bidid = <?php echo $id; ?>;
            var notes = $("#mnotes").val();              
            var amount = $("#mamount").val();          
           
            
            var formData = {
                'amount_type'     : "2",
                'status_type'     : "2",
                'amount'     : amount,
                'bidid' : bidid,
                'mid' : mid,
                'notes' : notes,
                'userid' : <?php echo $_SESSION['id']; ?>
            }
    
      
            var feedback = $.ajax({
                type: "POST",
                url: "service_approve_payment.php",
                data: formData,         
                async: false,
                
            }).complete(function(){
            
            
            }).responseText;
        
  
            if(feedback == "success"){
            
              swal({
                    type : "success",
                    title: "Success",
                    text: "Milestone Payment Request Rejected successfully"
               },
                function(){
                       $('#modal_milestone_pay').modal('hide');
                      window.location.href="work_bid.php?id="+bidid;
                }
                );

            
            } 
            
           
    
     });

    /////Milestone Reject Form submit --- End

////Accept Sr Form Submit --- Start
$(document).on("click", ".changeinwork", function(e) {
  var status=$(this).data('status');

  var formData = {
            
            'status'     : status,
            'bidid' : <?php echo $id; ?>,
            'userid' : <?php echo $_SESSION['id']; ?>
      }
  
    
      var feedback = $.ajax({
          type: "POST",
          url: "changestatus.php",
            data: formData,       
            async: false,
          
        }).complete(function(){
        
        
        }).responseText;
      
  
            if(feedback == "success"){            
           
              swal({
                    type : "success",
                    title: "Success",
                    text: "Accepted service request successfully!"
                                },
                function(){
                               localStorage.setItem("pushfrom","award");
                                window.location.href="main.php";
                }
                );
            
           
            
            }


});
////Accept Sr Form Submit --- End

  /////Cancel Bid Start - 16.04.2019
$(document).on("click", ".statusclick", function(e) {
  var from =$(this).data("from");
 
    var penalty="";var usertype="seller";
    <?php if($bidArr['status'] == "awarded" &&  $_SESSION['id']==$bidArr['ownerId']) { ?>
      var penalty="yes";      
    <?php } ?>
     <?php if($_SESSION['id']==$bidArr['srOwnerId']) {?>
      var usertype="buyer";
     <?php } ?>
    var srid ="<?php echo $srId; ?>";
    var bidid ="<?php echo $id; ?>";
    //var buttonstatus =($(this).data('status'));
    var buttonstatus ="cancel";
    var sr_submit = '<?php echo SR_SUBMIT; ?>';  
    if(from == "resubmit") 
    var sr_submit_text = '<?php echo BID_CANCELRESUBMIT_TEXT; ?>';
  else
    var sr_submit_text = '<?php echo BID_CANCEL_TEXT; ?>';
    sr_submit_success = '<?php echo SR_SUBMIT_SUCCESS; ?>';
    sr_submit_success_text = '<?php echo BID_CANCEL_TEXT_SUCCESS; ?>';

    swal({
      title: sr_submit,
      text: sr_submit_text,
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#5CB85C",
      confirmButtonText: "Yes, "+buttonstatus+" it!",
      closeOnConfirm: false
  },
  function(){
    
    var rtrnObj=(urlCall('./bid_button_status.php?statususer='+usertype+'&penalty='+penalty+'&bidid='+bidid+'&srid='+srid+'&buttonstatus='+buttonstatus));
  
    if(rtrnObj=="success"){
      if(from == "resubmit") 
      {
         location.href = "bid_interested.php?id="+srid;
      }
      else
      {
    swal({
            title: sr_submit_success,
          text: sr_submit_success_text,
            type: "success",
            showCancelButton: false,
            confirmButtonColor: "#5CB85C",
            confirmButtonText: "OK",
            closeOnConfirm: false
          },
          function(){
            <?php if($_SESSION['id']==$bidArr['ownerId']) {?>
            localStorage.setItem("pushfrom","sr");
           <?php } ?>
            location.href = "main.php";
    
          });
  }
  }
 
  });


});
/////Cancel Bid End - 16.04.2019




////////Milestone payment Approve/Reject function ---- Start
function doneMileStone( inObj , bidId, bidName,amount){
  
  if(bidName == "one")
    var cancelbtn="Cancel";
  else
    var cancelbtn="Reject";

  var atLeastOneIsChecked = $('[name="checkArray[]"]:checked').length;
  if(atLeastOneIsChecked == 0) 
    {
      swal("Error", "Select atleast one milestone", "error");
      return false;
    }else 
     {
    var milestone = $('[name="checkArray[]"]:checked').map(function(){
      return $(this).val();
    }).get(); 
    var am = $('[name="checkArray[]"]:checked').map(function(){
      return $(this).data("amount");
    }).get(); var m_amount=0; 
    $('[name="checkArray[]"]:checked').each(function () {
    var sThisVal = $(this).data("amount");
    m_amount = (m_amount + sThisVal);
});
   
    var bidId= '<?php echo $id; ?>'; 
            swal({
                                        title: "Make payment for milestone ?",//\""+bidName+"\"?",
                                        text: "Are you sure you want to make the payment for this milestone?",
                                        type: "warning",
                                        showCancelButton: true,
                                        cancelButtonText: cancelbtn,
                                        confirmButtonColor: "#5cb85c",
                                        confirmButtonText: "Approve",
                                        closeOnConfirm: true
                                },

                                function(conf){
                    if(conf){
                      
                    //call here for request milestone payment                    
           
            var rtrnObj=(urlCall('./service_approve_payment.php?notes=&status_type=1&mid='+milestone+'&amount_type=2&amount='+amount+'&bidid='+bidId));
        
                 if(rtrnObj=="success"){
                             localStorage.setItem("milestonepayment", "yes");
                             window.location.href="work_bid.php?id="+bidId;
                    } }
                    else
                    {
                      swal.close();
                       if(bidName == "both")
                       {
                      $("#mid").val(milestone);
                      $("#mamount").val(m_amount);
                      $(".mdyn_content").html("$"+m_amount);
                      $('#modal_milestone_pay').modal('show');
                    }
                    
                    }
                    
              
                        });         
    
        }
      }
    ////////Milestone payment request function ---- End
    ///check page comes after milestone payment
         var milestonepayment = localStorage.getItem("milestonepayment");  
         if(milestonepayment=="yes") 
         {
             localStorage.removeItem("milestonepayment");
             swal({
                    type : "success",
                    title: "Success",
                    text: "Milestone Payment Request Approved successfully"
               });
         }
         if(milestonepayment=="complete") 
         {
             localStorage.removeItem("milestonepayment");
             swal({
                    type : "success",
                    title: "Success",
                    text: "Agreement has been completed successfully"
               });
         }
         if(milestonepayment=="no") 
         
{             localStorage.removeItem("milestonepayment");
             swal({
                    type : "success",
                    title: "Success",
                    text: "Milestone Payment Request Rejected successfully"
               });
         }

         function doneBid(id){
          var remainingamount='<?php echo $remainingamount; ?>';
          var milestone_count='<?php echo $milestone_count; ?>';
          var amount_type='<?php echo $amount_type; ?>';
          if(remainingamount == 0)
          {
            var msg="Are you sure you want to complete the project";
            var button="Complete";
          }
          else
          {
            var msg="There is a pending payment of $"+remainingamount+". Do you want to make payment to complete the project.";
            var button="Pay & Complete";
          }


          swal({
                                        title: "Complete Project ?",
                                        text: msg,
                                        type: "warning",
                                        showCancelButton: true,
                                    cancelButtonText: "Cancel",
                                        confirmButtonColor: "#5cb85c",
                                        confirmButtonText: button,
                                        closeOnConfirm: true
                                },

                                function(conf){
          if(conf){         
          
          //call here for         
          var rtrnObj=(urlCall('./complete_approve_payment.php?usertype=buyer&notes=&status_type=1&mid='+milestone_count+'&amount_type='+amount_type+'&amount='+remainingamount+'&bidid='+id));
            if(rtrnObj=="success"){
                             localStorage.setItem("milestonepayment", "complete");
                             window.location.href="work_bid.php?id="+id;
                    }
            
          }
                        });       
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
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo $configs['google_map_api']; ?>&callback=initMap">    
    </script>
<?php  echo '</body>
</html>
';
?>