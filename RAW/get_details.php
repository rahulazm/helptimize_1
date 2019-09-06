<?php
require_once("./common.inc.php");
require_once("/etc/helptimize/conf.php");
require_once("./mysql_lib.php");
require_once("./resize_image.php");

session_start();
if($_POST['service']=='bids'){
	
	$bdrdetails=$_sqlObj->query("SELECT bids.id,bids.srId,bids.title,bids.ownerId,bids.shortlist, bids.summ,bids.descr,bids.payType,bids.payAmt,bids.dateTimeTo,bids.dateTimeFrom, bids.create_dateTime,users.username,users.firstName,users.midName ,categ.name,bids.categId,paytype.name as paytype , view_bids.status as status, view_bids.srOwnerId as srOwnerId FROM `bids`, users,categ,paytype,view_bids WHERE bids.`srId` = '$_POST[srid]' and users.id=bids.ownerId and bids.ownerId='$_POST[ownerid]' and bids.bidstatus != 'cancel' and bids.categId=categ.id and paytype.id=bids.payType and view_bids.id = bids.id");

	$bdrAddress = $_sqlObj->query("SELECT * from address where srId = '$_POST[srid]' or (bidId = NULL or bidId = '$bdrdetails[0][id]')");
	$rowBdrAddress=@reset($bdrAddress);

	$bdrdetails[0]['address'] = "";
	if(!empty($rowBdrAddress))
	{
		while($rowBdrAddress) 
		{
			$bdrdetails[0]['address'] .= "<p><i class='fas fa-map-marker-alt'></i>&nbsp;".$rowBdrAddress['address']."<span>";
			$rowBdrAddress=next($bdrAddress);
		}	
	}
	else
	{

			$bdrdetails[0]['address'] .= "<p>Address Not Available<span>";
		
	}
	
	$dateFrom = date("jS M Y-h:i A",strtotime($bdrdetails[0]['dateTimeTo']));
	//echo $dateFrom;
	$dateTo = date("jS M Y-h:i A",strtotime($bdrdetails[0]['dateTimeFrom']));

	$dateFromArr = explode("-", $dateFrom);
	$timeFrm = $dateFromArr[1];
	$dtFrm = $dateFromArr[0];
	$bdrdetails[0]['loggedin_user_id'] = $_SESSION['id'];
	$bdrdetails[0]['timeFrm']=$timeFrm;
	$bdrdetails[0]['dtFrm']=$dtFrm;

	$dateToArr = explode("-", $dateTo);
	$timeTo = $dateToArr[1];
	$dtTo = $dateToArr[0];
	$bdrdetails[0]['timeTo']=$timeTo;
	$bdrdetails[0]['dtTo']=$dtTo;
	
	#########Bidder/Requestor Gold rating
	require_once("userdetails_new.php");
	$bdrdetails[0]['bluestar_Percentage']=$bluestar_Percentage."%";
	$bdrdetails[0]['diamondrtng']=$silver_rating.$bluestar_rating.$gold_rating_bidder;

	#########BLUE STAR rating details
	require_once("bluestardetails_new.php");
	//echo $dispBlue;
	$bdrdetails[0]['bluedetls']=$dispBlue;

	#########SILVER STAR rating details
	require_once("silverstardetails_new.php");
	//echo $dispSilver;
	$bdrdetails[0]['silverdetls']=$dispSilver;


	#########GOLD STAR rating details
	require_once("goldstardetails_new.php");
	$bdrdetails[0]['goldstarresp']=$goldstarresp;


	######### Payment calculation

		$sql_get_saved_bids = "SELECT * FROM bidPayments WHERE bidid='".$bdrdetails[0]['id']."' AND status='18' AND usertype='seller' order by id desc limit 1 ";
        $result_get_saved_bids = $_sqlObj->query($sql_get_saved_bids);
        $bdrdetails[0]['request_amnt']=$result_get_saved_bids[0]['payAmt'];
        if($bdrdetails[0]['request_amnt'] < $bdrdetails[0]['payAmt']){
        	$bdrdetails[0]['amnt_type'] = 'Partial Amount';
        }else{
        	$bdrdetails[0]['amnt_type'] = 'Full Amount';
        }

	######### Request Payment calculation
		$sql_get_saved_bids = "SELECT SUM(payAmt) AS paidamt FROM bidpayments WHERE bidid='".$bdrdetails[0]['id']."' AND status='19' AND usertype='buyer'";
        $result_get_saved_bids = $_sqlObj->query($sql_get_saved_bids);
        $bdrdetails[0]['paid_amnt']= $result_get_saved_bids[0]['paidamt'];


	#########MILESTONES
	//require_once("view_bid_new.php?id=".$_POST[srid]);
	//require_once("work_bid_new.php?id=".$bdrdetails[0]['id']);
	//$bdrdetails[0]['milestones']=$inOffTmpl;

    $bid_data = "SELECT * FROM `bids` WHERE id='".$bdrdetails[0]['id']."'";
    $bid_results = $_sqlObj->query($bid_data);

    $bdrdetails[0]['bid_owner_id'] = $bid_results[0]['ownerId'];
    $bdrdetails[0]['bid_srId'] = $bid_results[0]['srId'];
     
    $address_data = "SELECT * FROM `pics` WHERE srId='".$bdrdetails[0]['bid_srId']."' AND userId='".$bdrdetails[0]['bid_owner_id']."'";
    $address_results = $_sqlObj->query($address_data);
 	$address_size = sizeof($address_results);
    $row=@reset($address_results); 
    $j=0;
    if(!empty($row))
    {
    	while ($j < $address_size) 
	    {
	        $imgurl =  imgPath2Url(smallPicName($row["url"]));
	        $bdrdetails[0]['bid_pics'][$j]="<img src='".$imgurl."' class='img-rounded' alt='Imag' style='width: 150px;'>"; 
	        $row=next($address_results);
	         $j++;
	    }	
    }
    else
    {
    	$bdrdetails[0]['bid_pics']="No Images Available";
    }
    


    if($_SESSION['id']==$bidArr['srOwnerId']) 
    {
    	$id=$_sqlObj->escape($_GET['id']);
		$bidArr=reset($_sqlObj->query('select * from view_bids where id='.$id.';'));
		$srId=$bidArr['srId'];
		$milestones=$_sqlObj->query('select * from milestones where bidId='.$id.';');
		$milestone_count=count($milestones);

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
		<th style="width: 20%;">Date</th>`````````
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
		$bdrdetails[0]['milestone'] = $inOffTmpl;
	    }
	    else
		{
			$bdrdetails[0]['milestone'] = 'Milestone Not Available';
		}
	}
	else
	{
		 $bidArr=@reset($_sqlObj->query('select * from view_bids where srId='.$bdrdetails[0]['bid_srId'].' and ownerId='.$bdrdetails[0]['bid_owner_id'].' and bidstatus != "cancel";'));

	    $bdrdetails[0]['milestone_query'] = $_SESSION['id'];

		$srId=$bidArr['srId'];
		$srId=$_GET['id'];
		$id=$bidArr['id'];
		$milestones=$_sqlObj->query('select * from milestones where bidId='.$id.';');

		$milestone_count=count($milestones);
		if($milestone_count > 1)
		{
			$bdrdetails[0]['milestone_test_data'] = 'select * from milestones where bidId='.$id.';';
		$inOffTmpl.='<table id="open_bid_milestone" class="table table-striped table-bordered" cellspacing="0" width="100%" style="border-radius: 8px 8px 0px 0px;">
		
	                                                <thead>
	                                                <tr>
	                                                <th colspan="5" id="titleHeaders" style="background: none; color: black; border-right: 0px;">Milestones</th>
	                                                <th style="text-align: right;">
	                                                </th> 
	                                                </tr>
	                                                <tr class="colHeader"><th style="width: 10%;">Name</th><th style="width: 10%;">Request Pay</th> <th style="width: 10%;">Status</th>
	                                                <th style="width: 20%;">Date</th>
	                                                <th>Description</th><th style="width: 5%;">% of Agreement Sum</th>
	                                                </tr>
	                                                
	                                               

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
		$status=$bidArr['status'];  
		$requestp="<input class='' type='checkbox' data-amount='".$row['amount']."'  value='".$row['id']."' ".$checkedDisabled." name='checkArray[]' id='checkArray'>";
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

		$bdrdetails[0]['milestone'] = $inOffTmpl;
		}
		else
		{
			$bdrdetails[0]['milestone'] = 'Milestone Not Available';
		}
	}

    

  	
  	$id=$_sqlObj->escape($bdrdetails[0]['id']);
	$qstr=($_sqlObj->query('
	select count(id) as totbid from bids_revision where bidid='.$id));
	 $total_count= $qstr[0]["totbid"];
	$srArr=reset($_sqlObj->query('select * from view_bids where id='.$id.';'));
	$srId=$srArr['srId'];
	$bidInfo=reset($_sqlObj->query('select * from view_bidsrevision where bidid='.$id.' and refno = '.$total_count));
	$bdrdetails[0]['refid'] = $bidInfo['id'];
	
	if(($srArr['statususer'] =='seller' && $srArr['bidstatus'] =='editbid' && $srArr['srOwnerId'] == $_SESSION['id']) || ($srArr['statususer'] =='buyer' && $srArr['bidstatus'] =='editbid' && $srArr['ownerId'] == $_SESSION['id'])) {
	 $html.='<input href="#demo" data-toggle="collapse" style="margin-left:15px;" type="button" class="btn btn-success" value="View Previous Revision" >';
	  	$html.='<input  style="margin-left:25px;" type="button" class="btn btn-info bidapproveclick" value="Approve" data-bidid="'.$id.'" data-refid="'.$bidInfo['id'].'" >';
	  	$html.='<input  style="margin-left:15px;" type="button" class="btn btn-danger rejectclick" value="Reject"  data-bidid="'.$id.'" data-refid="'.$bidInfo['id'].'" >';
	}

  	$bdrdetails[0]['buttons'] = $html;
	

	echo json_encode($bdrdetails[0]);
	exit();
}
?>