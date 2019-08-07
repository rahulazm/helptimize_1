<?php
session_start();

$configs = require_once("/etc/helptimize/conf.php");
require_once("./common.inc.php");
require_once("./mysql_lib.php");

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//$id=$_sqlObj->escape($_GET['id']);
//$bidArr=@reset($_sqlObj->query('select * from view_bids where id='.$id.';'));
//$srId=$bidArr['srId'];
$srId=$_GET['id'];
#########Redirect to preview page if bid is edited
if($bidArr['bidstatus'] =='editbid')
    header('Location: editbid_preview.php?id='.$id);
$srArr=@reset($_sqlObj->query('select * from view_serviceRequests where id='.$srId.';'));
//"select * from view_pics where srId='".$bidArr['id']."' and userId=".$bidArr['ownerId']." order by datetime, orderNum"

$bidInfo=@reset($_sqlObj->query('select count(id) as bidNum, (select avg(payAmt) from view_bids where srId='.$srArr['id'].' and payType="fixed") as avgFix, (select avg(payAmt) from view_bids where srId='.$srArr['id'].' and payType="hourly") as avgHr from view_bids where srId='.$srArr['id']));


if( !($_SESSION['id']==$bidArr['ownerId'] || $_SESSION['id']==$bidArr['srOwnerId']) ){
//echo "You don't have permssion to view this bid.";
//exit;


}$ReqPay='';
$job="no" ;$reject="no";
if($bidArr["status"] == "job completed") $job="yes" ;
if($bidArr['bidstatus'] == "rejected")
        { 
             $rejectnotes=$bidArr["rejectnotes"];
             $reject="yes";
         }
#############Get Bid Address Location
   
      $qstr="select * from address where (srId='".$srId."' and userId  = '".$srArr['ownerId']."') or (srId='".$srId."' and bidId = '".$id."') order by orderNum";
          $addr=$_sqlObj->query($qstr);
         $row=@reset($addr); 
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
   $row=@next($addr);
   }
##########Check bid is accepted in thi SR
$qstr=($_sqlObj->query('
select count(id) as totbid from view_bids where srId='.$srId.' and srBidAwardId is not null')); $accept_count= $qstr[0]["totbid"];
if($accept_count=="0")$pr_title="Revised Proposed Agreement";
else $pr_title="Awarded Agreement";
$milestones=$_sqlObj->query('select * from milestones where bidId='.$id.';');
$milestone_count=count($milestones);
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
if( $_SESSION['id']==$bidArr['ownerId'] && ($bidArr['status'] == "in work" || $bidArr['status'] == "approved payment" || $bidArr['status'] == "payment rejected"))
{


     if($paidamt<$bid_actual_amount && $milestone_count == 0) ///check if bid amount is less than paid amount and no milestone is added
     $ReqPay='<input type="button" value="Request Payment" id="bidReceivePaymentBtn" name="bidRequestPayment" class="requestpaypopup btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border">';
}
/*if( $bidArr['status'] == "awarded" && $_SESSION['id']==$bidArr['ownerId'])
{
     $ReqPay='<input type="button" value="Accept SR" id="bidReceivePaymentBtn" data-status="16" name="bidRequestPayment" class="changeinwork btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border">';
}*/

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
                                

                               
                                <label for="requesterBox">Communicate: </label>
                                <label class="SRRequesterName" for="requesterBoxB">
                                         <a href="javascript:void()" class="videoclick" data-from="buyer" data-user="'.$bidArr['ownerName'].'" >
                                        <img  src="img/chat.png"   width="50px" >
                                        </a> <a href="javascript:void()" class="democlick" >View Chat Demo</a>
											</label><br>';
$userBoxArr['requester']='
                       <div class="requester">
                                
                                
                                <label for="requesterBox">
                                Communicate:
                                </label>
                                <label class="SRRequesterName" for="requesterBoxB">
                                        <a href="javascript:void()" class="videoclick" data-from="seller" data-user="'.$bidArr['srOwnerName'].'">
                                         <img  src="img/chat.png" width="50px"  >
                                        </a> <a href="javascript:void()" class="democlick" >View Chat Demo</a>
											</label>';

$userBox="";


/*$actionBox['bidder']='
 <div class="SRActionBox dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
  </button>

  <ul class="dropdown-menu dropdown-menu-right">
    <li>
        <a href="" data-toggle="modal" onclick="doneBid(\''.$id.'\')">Completed</a>
    </li>';*/
if($bidArr['status'] != "job completed")
{
    $actionBox['bidder'].='<div>';
   if($bidArr['bidstatus']!='cancel'){ 
      if($bidArr['status']=='submitted'  || $bidArr['status']=='waiting for approval'){
      $actionBox['bidder'].='<li><a href="#" class="statusclick">Cancel</a></li>';
      $actionBox['bidder'].=' <li><a href="javascript:void(0)" data-from="resubmit" class="statusclick" >Cancel and Resubmit</a></li>';
    }
    else {
    $actionBox['bidder'].='<li><a href="#" data-toggle="modal" data-target="#confCncModal">Cancel</a></li>';
    $actionBox['bidder'].=' <li><a href="javascript:void(0)" data-toggle="modal" data-target="#confResModal" >Cancel and Resubmit</a></li>';
    }
}
else
{
  $actionBox['bidder'].='<li><a href="bid_interested.php?id='.$srId.'">Resubmit</a></li>';
}
if($bidArr['bidstatus'] =='editbid')
    $actionBox['bidder'].='<li><a href="editbid_preview.php?id='.$id.'" >Revised Bid</a></li>';
    else
       $actionBox['bidder'].='<li><a href="bid_reupdate.php?id='.$id.'" >Edit Agreement</a></li>';

  
  $actionBox['bidder'].=' <li>
         <a href="" data-toggle="modal" onclick="doneBid(\''.$id.'\')">Completed Job</a>
    </li></ul>
</div> 
';
}
$actionBox['requester']='
<div class="SRActionBox dropdown">';

if(!$bidArr['srBidAwardId'] && $bidArr['shortlist'] != "yes"){
$actionBox['requester'].='
';
}

    if(!$bidArr['srBidAwardId']){
    $actionBox['requester'].='
        
';
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
    case $bidArr['ownerId']:
    //bidder
        $userBox=$userBoxArr['requester'];
        //if($bidArr['status']=='submitted'){
         $actionhtml=$actionBox['bidder'];
        //$notifBox=$notifBoxArr['bidder'];
        //}
    break;
    case $bidArr['srOwnerId']:
    //requester
    $userBox=$userBoxArr['bidder'];
    $actionhtml=$actionBox['requester'];
    $notifBox=$notifBoxArr['requester'];
    break;
    default:
   // exit;
    break;
}


$srPicsB=$_sqlObj->query('select * from view_pics where bidId='.$id.' and userId='.$bidArr['ownerId'].' order by datetime, orderNum asc;');
$picsRowB=picsRow($srPicsB);

$orig_sr=$bidArr;

$dtFrom=explode(' ',$bidArr['dateTimeFrom']);
$dtTo=explode(' ',$bidArr['dateTimeTo']);




if($bidArr['payType'] == "hourly")
$cols=6;
else
$cols=5;


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
if($milestone_count > 0)
{
 $inOffTmpl.='<table id="open_bid_milestone" class="" cellspacing="0" width="100%" style="border-radius: 8px 8px 0px 0px;">
                <thead>
                
                <tr class="colHeader">';
                //if($cols==4)
                   $inOffTmpl.='';
                       $inOffTmpl.='';
                        if($bidArr['payType'] == "hourly") { $inOffTmpl.='<th>Hours</th>'; }
                        $inOffTmpl.='
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
if( $_SESSION['id']==$bidArr['ownerId'] && ($bidArr['status'] == "in work" || $bidArr['status'] == "approved payment" || $bidArr['status'] == "payment rejected"|| $bidArr['status'] == "request for payment"|| $bidArr['status'] == "job completed"))
{
     $requestp="<input class='checkHideShowBare' type='checkbox' value='".$row['id']."' ".$checkedDisabled." name='checkArray[]' id='checkArray'>";
     
      $status="In work"; $cbCell=$requestp; 
     if(count($milestones_last_payment) > 0)
     {
         $milestonestaus= $milestones_last_payment[0]["status"];     
         if($milestonestaus == "18") 
         {
          $cbCell='<i class="material-icons" style="color:royalblue" id="material-icons">
            payment
            </i>';   $status="Payment Requested";
         }
         elseif($milestonestaus == "20") 
         {
            $status='Rejected<br><a href="javascript:void(0)" data-notes="'.$milestones_last_payment[0]["notes"].'" class="notesclick">Why?</a>';$cbCell=$requestp;
         }     
         elseif($milestonestaus == "19")  
         {
            $status="Paid"; 
            $cbCell='<i class="material-icons" style="color: green" id="material-icons">thumb_up</i>';
         }
     }

     if($cbCell==$requestp) $view++;
     
 $cbCelld="<td style='text-align: center;'>".$cbCell."</td>";

 }

  if($status =="In work")
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
        
                $inOffTmpl.='
                </tbody>
                <tfoot>
                        <tr>';if($view>0) {
                        $cols=$cols-2; 
                                 $inOffTmpl.="<td colspan=2><button onclick='doneMileStone(this, \"".$row['bidId']."\", \"".$row['name']."\", \"".$row['amount']."\")' class='btn btn-primary'>Request Pay</button></td>";
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

        function bidSubmitOK(){
        submitRslt=postCall($(\'#bidConfirm\').serialize(), "./bid_submit.php");
        sRslt=JSON.parse(submitRslt);
            if(sRslt[\'status\']==1){
                swal({
                  title: "Bid Submitted",
                  text: "Bid Successfully Submitted"
                });
            location.href = "main.php";
            return 1;
            }
            swal({
              title: "Bid unsuccessful",
              text: sRslt[\'msg\']
            });
        return 0;
        }


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
                                  text: "Bid has been Awarded",
                                  type: "success"
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
            hideByClass("checkHideShowBare", "rmStyleOnCheck");
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
'.$_template["nav"];



if(!$srArr['bidAwardId']) {
$html.='
<div id="demo" class="collapse" style="margin-left: 15px; margin-top: 20px;">


<table id="open_sr_list" class="" cellspacing="0" width="100%">
                <thead>
                <tr>
                        <th colspan="2" id="titleHeaders" >
                        <label for="comment">Proposed Agreement: '.$srArr['title'].' <strong>('.$srArr['id'].')</strong>
                        </label>
                        </th>
                </tr>
    </thead>
                <tbody class="tbodyBorder" id="bidInterested">
                <tr class="colHeader">
    <td>
      <div class="requester">
        <label >
        Username:       </label>

        <label class="SRRequesterName" >
        '.$srArr['ownerUsername'].'   
        
        </label><br>
                             
                              <label for="requesterBox">
                                Communicate:
                                </label>
          <a href="javascript:void()" class="videoclick" data-from="seller" data-user="'.$srArr['ownerUsername'].'" >
                                        <img  src="img/chat.png"   width="50px" >
                                        </a> <a href="javascript:void()" class="democlick" >View Chat Demo</a>
<br>
                    
                               
                               
       
        
        <div class="checkHideShowHide">
          <label>Name: '.$srArr['ownerFirstName'].' '.$srArr['ownerSurName'].'</label> <br>

                <label> Star Rating:</label>
                                <label>
                                '.$Requestor_bluestar_Percentage.'%</label><br>
                                <label>
                                Diamond Rating:</label>
                                <label>
                                '.$silver_rating_requestor.$bluestar_rating_requestor.$gold_rating_requestor.' </label><br>Number of bids: </label><span class="label label-success">'.$bidInfo['bidNum'].'</span><br>
                  <label>Average fix cost amount: </label>'.$bidInfo['avgFix'].'<br>
  
          <label>Average hourly cost amount: </label>'.$bidInfo['avgHr'].'
        </div> 

      </div>
  
      
      <div class="form-group">
    
        
            </td>
    </tr>
    <tr>
    <td>

            
 
    </td>
    </tr>
    <tr>
    <td>
      
      
          
          
          

          
                     
           
            </tbody>
       </table>


  
</div>
                </td>
        </tr>
        <tr>
    <td class="sr_details">

      <!--  <div class="bidDueDate">
        <label>Bid Deadline:</label>
        <br>
        <span class="countDown" name="bidExpiring"></span>
        <span class="dateTime">'.$srArr['bidDueDate'].'</span>
        </div>  -->



        ';

        if($srArr['paytype'] == "hourly")
        {
          $payamt=$srArr['rateperhour']."/".$srArr['totalhours']."hours"; 
        }
        else
        {
          $payamt=$srArr['payAmt'];
        }
        
         $html.='<div>        
        
        </div>';
            if($srArr['paytype'] == "fixed")
                {
           $html.=' <div class="SRDueDate">
        ';
         if($srArr['set_schedule'] != "1")
                {
        $html.='';
      }
        $html.='</div>';
      }

                $html.='


                </td>
    </tr>
    </div> 
    

    <tr>
    <td>
 

       
      </div>


      </td>
    </tr>

    
</tbody>
</table>
</div>
';}
$html.='<form id="bidConfirm" action="javascript:void(0);" method="POST"><div class="SRDetailsBox"><span align="left"></span>
'.$notifBox.$actionhtml.'


<table id="open_sr_list" class="" cellspacing="0" width="100%">
                <thead>
                <tr>
                        <th colspan="2" id="titleHeaders" >
                        <!--<label for="comment">'.$pr_title.': '.$bidArr['title'].' <strong>('.$bidArr['id'].')</strong>
                        </label>-->
                        </th>
                </tr>
        </thead>
                <tbody class="tbodyBorder" id="bidInterested">
                <tr class="colHeader">
        <td>
        '.$userBox.'    
        
        <div class="form-group">
        
            
                    '.$ReqPay.'</td>
        </tr>
           


        <tr>
        <td class="sr_details">

                <div class="SRDueDate">
               
               
                            
                </div>';

                if($bidArr['payType'] == "hourly")
                {
                  $pay_amount=$bidArr['rateperhour']."/".$bidArr['totalhours']."Hours";
                }
                else $pay_amount=$bidArr['payAmt'];
                $html.='<div>
                
                <br>
               
                </div>
            </div>';
            if($bidArr['payType'] == "fixed")
                {
           $html.=' <div class="SRDueDate">
        ';
         if($bidArr['set_schedule'] != "1")
                {
        $html.='';
      }
        $html.='</div>';
      }

                $html.='</td>
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
        </tr> -->  

               ';

//$inOffTmpl = "";               
    
$html.='
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
    </div>


    
    </body>
</html>
';

echo $html;

?>

 <div id="modal_request_pay" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="color:#000000";><center><i class="fa fa-info-circle fa-2x" aria-hidden="true"></i> <?php echo REQUEST_PAYMEN_LONG ;?></center></h4>
                </div>
                    <div class="modal-body">
                    
                
                <form id="request_payment">
                <div class="form-group">
                        <label><font color="black"><span class="dyn_content"></span></font></label>
                       
                    </div>
                
                   <div class="form-group">
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
                    
                    
                    <input type="hidden" name="bidid" value="<?php echo $id;?>" id="bidid">
            <input type="hidden" name="bidamount" value="<?php echo $bidArr['payAmt'];?>" id="bidamount">
                    
                    
                    <center>
                    
                    <button type="submit" class="btn btn-success" ><?php echo SUBMIT;?></button>
                    
                        </form>
                    
                    </center>
                            
                    </div>
            </div>
        </div>
    </div>

    <div id="modal_description_click" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <h4 class="modal-title" style="color:#000000";><center>Notes</center></h4>
                   
                </div>
                    <div class="modal-body">
                    
                
                    <div>
                        
                                <p class="text-center" id="desc_popup">

                                </p>
                            </div>
                                       
                    </div>
            </div>
        </div>
    </div>

   

<script src="./js/jquery-1.11.3.min.js"></script>
   <!--  <script src="./js/bootstrap.min.js"></script> -->
    <script src="./js/framework/bootstrap.min.js"></script>
    <script src="./js/sweetalert.min.js"></script>
    <script src="./js/intlTelInput.min.js"></script>
    <script src="./js/helptimize.js"></script>    
  <script src="./js/formValidation.min.js"></script>
    <script src="./js/framework/bootstrap.min.js"></script>  
     <link rel="stylesheet" href="./css/formValidation.min.css">
    
<script type="text/javascript" >
  /**
$( document ).ready(function() {
  <?php if($job == "yes"){ ?>
    swal({
                                        title: "Job Completed",
                                        text: "This project is completed! ",
                                        type: "warning"
                                        
                    
                    
              
                        }); 

  <?php } else if($reject == "yes"){ ?>
    swal({
                                        title: "Change Request - Rejected",
                                        text: "<?php echo $rejectnotes; ?>",
                                        type: "warning"
                                        
                    
                    
              
                        }); 

  <?php } ?>

});
**/
$(".showamount").hide();

$(document).on("click", ".requestpaypopup", function(e) {

    var bidamount = parseInt($("#bidamount").val());
    var paidamt = <?php echo $paidamt; ?>;
    var remain = bidamount - parseInt(paidamt);
    $(".dyn_content").html("Request Pay - Received Amount $"+paidamt+" (Remaining Balance $"+remain+")");
    $('#modal_request_pay').modal('show');


});

$(document).on("click", ".requestmileopopup", function(e) {

            var amount_type = 2;
            var amount = $(this).data('mamount');
            var bidid = $("#bidid").val();
            var mid = $(this).data('mid');
    
            //alert(mid);
            var formData = {
                'amount_type'     : amount_type,
                'amount'     : amount,
                'bidid' : bidid,
                'mid' : mid,
                'userid' : <?php echo $_SESSION['id']; ?>
            }
    
      
            var feedback = $.ajax({
                type: "POST",
                url: "service_request_payment.php",
                data: formData,         
                async: false,
                
            }).complete(function(){
            
            
            }).responseText;
       
  
            if(feedback == "success"){
            
              swal({
                    type : "success",
                    title: "Success",
                    text: "Payment request submitted successfully"
               },
                function(){
                       $('#modal_request_pay').modal('hide');
                      window.location.href="main.php";
                }
                );
              
            
            }


});



$(document).on("change", "#amount_type", function(e) {

    if($('#amount_type').val() == "2")
    $(".showamount").show();
    else {
        $(".showamount").hide();
    }

});

$('#request_payment').formValidation({
        framework: 'bootstrap',
        
        fields: {
            amount_type: {
                validators: {
                    notEmpty: {
                        message: "Please select amount type"
                    }
                    
                }
            },
            amount: {
                validators: {
                    notEmpty: {
                        message: "Please enter partial amount"
                    }
                    
                }
            }
                
            
        }
    }).on('success.form.fv', function(e) {
    
            e.preventDefault();
        
            
            var amount_type = $('#amount_type').val();
            var amount = $('#amount').val();
            var bidid = $("#bidid").val();
            var bidamount = parseInt($("#bidamount").val());
            var paidamt = <?php echo $paidamt; ?>;

            ///if amount type is full then save bid amount otherwise get entered amount
            if($('#amount_type').val() == "1")
                var amount = parseInt(bidamount);
            else
                var amount = parseInt($('#amount').val());

            ///Total amount calculation (add already paid amount with current entered amount)
            var total=parseInt(paidamt)+parseInt(amount);

            // check if amount exceed the bid amount
            if(amount>bidamount || total>bidamount)
            {
                 swal("Error", "The amount exceeded your bid amount", "error");
                 return false;
            }
            
    
            
            var formData = {
                'amount_type'     : amount_type,
                'amount'     : amount,
                'bidid' : bidid,
                'mid' : 0,
                'userid' : <?php echo $_SESSION['id']; ?>
            }
    
      
            var feedback = $.ajax({
                type: "POST",
                url: "service_request_payment.php",
                data: formData,         
                async: false,
                
            }).complete(function(){
            
            
            }).responseText;
        //alert(feedback);
  
            if(feedback == "success"){
            
              swal({
                    type : "success",
                    title: "Success",
                    text: "Payment request submitted successfully"
               },
                function(){
                       $('#modal_request_pay').modal('hide');
                      window.location.href="main.php";
                }
                );
              
            
            }
  
            
            
    
     });
    ///////////Add to short list functionality --- start
$(document).on("click", ".btnshortlist", function(e) {
    var id =($(this).data('bidid'));

  

  var formData = {
                'bidid' : id
            }
    
      
            var feedback = $.ajax({
                type: "POST",
                url: "addshortlist.php",
                data: formData,         
                async: false,
                
            }).complete(function(){
            
            
            }).responseText;        
  
            if(feedback == "success"){
            
          
            swal({
                    type : "success",
                    title: "Success",
                    text: "Added to 'shortlist' successfully"
               },
                function(){                      
                      window.location.href="main.php";
                }
                );
            
            }


});
///////////Add to short list functionality --- End

////////Milestone payment request function ---- Start
function doneMileStone( inObj , bidId, bidName,amount){
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
    var bidId= '<?php echo $id; ?>';  
           
            swal({
                                        title: "Done with milestone ?",//\""+bidName+"\"
                                        text: "You can\'t unconfirm a milestone once confirmed and payment request will be sent. Are you sure?",
                                        type: "warning",
                                        showCancelButton: true,
                    cancelButtonText: "I better double check...",
                                        confirmButtonColor: "#5cb85c",
                                        confirmButtonText: "Yep, All done!",
                                        closeOnConfirm: true
                                },

                                function(conf){
                    if(conf){
                    swal.close();
                    
                    //call here for request milestone payment                    
           
            var rtrnObj=(urlCall('./service_request_payment.php?mid='+milestone+'&amount_type=2&amount='+amount+'&bidid='+bidId));
        
  if(rtrnObj=="success"){
    localStorage.setItem("milestonepayment", "yes");
     window.location.href="view_bid.php?id="+bidId;
                    } }
                    
              
                        }); 
                        }        
    
        }
    ////////Milestone payment request function ---- End
</script>
<script type="text/javascript">

    /////Refund Notes Popup Start - 02.04.2019
$(document).on("click", ".notesclick", function(e) {

    $('#modal_description_click').modal('show');
    if(($(this).data("notes") == null))
     $("#desc_popup").html("No Notes Here");   
    else
    $("#desc_popup").html($(this).data("notes"));


});
/////Refund Notes Popup End - 02.04.2019

    $(document).on("click", ".resubmitbtn", function(e) {
        var id = <?php echo $id; ?>;
        window.location.href="bid_reupdate.php?id="+id;
    });
     ///check page comes after milestone payment
         var milestonepayment = localStorage.getItem("milestonepayment");  
         if(milestonepayment=="yes") 
         {
             localStorage.removeItem("milestonepayment");
             swal({
                    type : "success",
                    title: "Success",
                    text: "Milestone Payment Request added successfully"
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
         if(milestonepayment=="payment") 
         {
             localStorage.removeItem("milestonepayment");
             swal({
                    type : "success",
                    title: "Success",
                    text: "Payment Request added successfully"
               });
         }

         /////Cancel Bid Start - 16.04.2019
$(document).on("click", ".statusclick", function(e) {

    var from =$(this).data("from");
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
    
    var rtrnObj=(urlCall('./bid_button_status.php?statususer=seller&penalty=yes&bidid='+bidid+'&srid='+srid+'&buttonstatus='+buttonstatus));
  
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

 function doneBid(id){
          var remainingamount='<?php echo $remainingamount; ?>';
          var milestone_count='<?php echo $milestone_count; ?>';
          var amount_type='<?php echo $amount_type; ?>';
          if(remainingamount == 0)
          {
            var msg="Are you sure you want to complete the project";
            var button="Complete";
            var typelocal="complete";
          }
          else
          {
            var msg="There is a pending payment of $"+remainingamount+". Do you want to Request payment?.";
            var button="Request Payment";
            var typelocal="payment";
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
          var rtrnObj=(urlCall('./complete_approve_payment.php?usertype=seller&notes=&status_type=1&mid='+milestone_count+'&amount_type='+amount_type+'&amount='+remainingamount+'&bidid='+id));
            if(rtrnObj=="success"){
                             localStorage.setItem("milestonepayment", typelocal);
                             window.location.href="view_bid.php?id="+id;
                    }
            
          }
                        });       
    }
</script>
<?php

$_SESSION['username']=$bidArr['ownerName'];
$_SESSION['chatwith']=$bidArr['srOwnerName'];

//print_r($_SESSION);

?>



