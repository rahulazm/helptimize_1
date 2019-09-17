<?php

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
include("header_main.php");


//print_r($_SESSION);
$id= $_SESSION['id'];
if($id==''){
    header("Location:index.php");
}
///////////////////////////////Details section///////////////////////////////////
$servID=$_GET['id']; 
$sqlServ="select a.*, b.address from view_serviceRequests as a left join address as b on a.id=b.srId where a.id='$servID'";
$res=$_sqlObj->query($sqlServ);

$sr_attachments = "SELECT * FROM `pics` WHERE srId=".$servID." AND userId=".$res[0]['ownerId']."";
$images = $_sqlObj->query($sr_attachments);
 
$dateFrom = date("jS M Y-h:i A",strtotime($res[0]['dateTimeTo']));
//echo $dateFrom;
$dateTo = date("jS M Y-h:i A",strtotime($res[0]['dateTimeFrom']));

$dateFromArr = explode("-", $dateFrom);
$timeFrm = $dateFromArr[1];
$dtFrm = $dateFromArr[0];

$dateToArr = explode("-", $dateTo);
$timeTo = $dateToArr[1];
$dtTo = $dateToArr[0];

//echo "<pre>";
//print_r($res);
//print_r($dateToArr);
//$jobs = $res[0]['jobs'];
///////////////////////////////BIDS section///////////////////////////////////

$sqlBids="SELECT vb.*,u.username,u.firstName,u.midName FROM view_bids as vb, users as u WHERE vb.srId = '$servID' and u.id=vb.ownerId and vb.bidstatus != 'cancel' ORDER by vb.create_dateTime desc";

$resBids=$_sqlObj->query($sqlBids);
$rowBids=@reset($resBids);


##########Get total number of bids in this SR
$count=($_sqlObj->query('select count(id) as totbid from view_bids where srId='.$servID.';'));
$totalbid_count=$count[0]["totbid"];

##########Get avg of bids in this SR
$bidInfo=@reset($_sqlObj->query('select id,count(id) as bidNum, (select avg(payAmt) from view_bids where srId='.$servID.' and payType="fixed") as avgFix, (select avg(payAmt) from view_bids where srId='.$servID.' and payType="hourly") as avgHr from view_bids where srId='.$servID));
//$rowBids['ownerid']=0;
//$cntBids = count($bidInfo);
//echo $cntBids;
//$rowBids['ownerid'] = ($cntBids > 0 ) ? $rowBids['ownerid'] : 0;
##############Get shortlisted bids info

$bidInfoShlstd=$_sqlObj->query('select view_bids.*,users.username,users.firstName,users.midName from view_bids, users where srId='.$servID.' and shortlist = "yes" and buttonstatus is null  and bidstatus != "cancel" and users.id = view_bids.ownerId group by view_bids.id order by last_updated desc');
$rowbidInfoShlstd=@reset($bidInfoShlstd);

//$cntShrtltd = @count($bidInfoShlstd);
//$rowbidInfoShlstd['ownerId']=0;
//$rowbidInfoShlstd['ownerId'] = ($cntShrtltd > 0 ) ? $rowbidInfoShlstd['ownerId'] : 0;
//echo $cntShrtltd;
//echo 'select * from view_bids where srId='.$servID.' and srBidAwardId is null and shortlist = "yes" and buttonstatus is null  and bidstatus != "cancel" order by last_updated desc';

//print_r($bidInfo);
//echo "</pre>";

################Get agreement info
$bidInfoAgremnt=$_sqlObj->query('select view_bids.*,users.username,users.firstName,users.midName from view_bids, users where srId='.$servID.' and srBidAwardId is not NULL and buttonstatus is null  and bidstatus != "cancel" and users.id = view_bids.ownerId order by last_updated desc');
$rowbidInfoAgremnt=@reset($bidInfoAgremnt);

######### Payment calculation

$sql_get_saved_bids = "SELECT * FROM bidPayments WHERE bidid='".$rowbidInfoAgremnt['id']."' AND status='18' AND usertype='seller' order by id desc limit 1 ";
                    $result_get_saved_bids = $_sqlObj->query($sql_get_saved_bids);
                     //$count_saved_bids = $result_get_saved_bids->num_rows;
                     /*$fetch_saved_bids = $result_get_saved_bids->fetch_assoc();
                     $db_get_saved_bids->close();*/
                     $amounttype=$result_get_saved_bids[0]['amounttype'];
                     $payAmt=$result_get_saved_bids[0]['payAmt'];
                     if( $amounttype == "1")
                         $amt_type="Full Payment";
                     else $amt_type="Partial Payment";

############# Current Users 
$userTypeInfo=$_sqlObj->query('select view_bids.* from view_bids where srId='.$servID.' and ownerId = '.$id.' and bidstatus != "cancel"');
$rowuserTypeInfo=@reset($userTypeInfo);

//print_r($rowuserTypeInfo);

//echo $rowuserTypeInfo['id'];


######### Request Payment calculation
$sql_get_saved_bids = "SELECT SUM(payAmt) AS paidamt FROM bidpayments WHERE bidid='".$rowbidInfoAgremnt['id']."' AND status='19' AND usertype='buyer'";
                    $result_get_saved_bids = $_sqlObj->query($sql_get_saved_bids);
                    /*$result_get_saved_bids_2 = $db_get_saved_bids->query($sql_get_saved_bids);
                     $count_saved_bids = $result_get_saved_bids->num_rows;
                     $fetch_saved_bids = $result_get_saved_bids->fetch_assoc();
                     $db_get_saved_bids->close();*/
                    $bid_actual_amount=$remainingamount=$rowbidInfoAgremnt['payAmt'];
                     $amount_type=1;
                     echo "<br>".$result_get_saved_bids['paidamt'];
                     if($result_get_saved_bids[0]['paidamt'] >0)
                      $paidamt=$result_get_saved_bids[0]['paidamt'];
                      $remainingamount=$bid_actual_amount-$paidamt;
                      $amounttype=2;$bidstatus="";$amt_type = "Partial Payment";
                     //$bid_actual_amount=$bidArr['payAmt'];
                       /*if($bid_actual_amount <=$paidamt)
                         {
                           $bidstatus="Job Completed"; 
                           $job="yes" ;
                         } */                    


######### Chat Console

$firstname = $_SESSION['firstName'];
$name = $row_accout_id['name']." test";
$fullname = $firstname . " " . $_SESSION['surName'];


// get sr_details

$sql_get_sr_details = "SELECT * FROM view_serviceRequests WHERE id='$servID'";
$srArr = reset($_sqlObj->query($sql_get_sr_details));

$sr_name = $srArr['title'];

// imported when mesage is cretaed
$sr_user_id = $srArr['ownerId'];
$sender_user_id = $account_id;






// get all sr related messages from messages_sr

$qstr = "SELECT * FROM messages_sr WHERE sr_id='$servID'";
$result_get_sr_messages = $_sqlObj->query($qstr);
$messages =  json_encode($result_get_sr_messages);
//var_dump($messages);
 echo $_template["header"];
 

$json = json_encode(array("username" => $_SESSION['chatwith'], "password" => "rahuls13", "gender" => "male", "role" => "guest", 
"profile" => "", "image" => "https://html5-chat.com/img/malecostume.svg"));
//echo $json;
//$encoded = file_get_contents("https://jwt.html5-chat.com/protect/".base64_encode($json));
if($_SESSION['id'] == $sr_user_id){
    $qstr = "SELECT username FROM users WHERE id='$sr_user_id'";
    $result_username = $_sqlObj->query($qstr);
    $buyer_name = $result_username[0]['username'];
    //$chaturl = "https://helptimize.webtv.fr/enter.php?buyerid=".$sr_user_id;
    //$chaturl = "chat/enter.php?buyerid=(".$buyer_name.")";
    //$chaturl = "chat/enter.php?buyerid=".$sr_user_id;
    $chaturl = "https://app.helptimize.com/chat/enter.php?buyerid=".$sr_user_id;
}else{
    $qstr = "SELECT username FROM users WHERE id='$sr_user_id'";
    $result_username = $_sqlObj->query($qstr);
    $buyer_name = $result_username[0]['username'];
    $qstr = "SELECT username FROM users WHERE id='".$_SESSION['id']."'";
    $result_username = $_sqlObj->query($qstr);
    $seller_name = $result_username[0]['username'];
    //$chaturl = "https://helptimize.webtv.fr/enter.php?buyerid=".$sr_user_id."&sellerid=".$_SESSION['id'];
    //$chaturl = "chat/enter.php?buyerid=(".$buyer_name.")&sellerid=(".$seller_name.")";
    //$chaturl = "chat/enter.php?buyerid=".$sr_user_id."&sellerid=".$_SESSION['id'];
    $chaturl = "https://app.helptimize.com/chat/enter.php?buyerid=".$sr_user_id."&sellerid=".$_SESSION['id'];
}




?>        
        <section class="wrapper">

            <aside class="layout">
                <div>
                    <h4 class="display-inline"><?php echo $res[0]['title'] ?></h4><span>( <?php echo $res[0]['categ'] ?> )</span>
                </div>
                <div class="card-header tab-card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                        <!-- Session user is SR owner (Requester) -->
                        <?php if($res[0]['ownerId'] == $id){ ?>   
                        <li class="nav-item">
                            <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">Detail</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false" onclick="getUserDetails(<?php $rowBids['ownerId']=(isset($rowBids['ownerId']))?$rowBids['ownerId']:0;echo $rowBids['ownerId']." ,".$servID;?>,'bids')">Incoming Bids</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="three-tab" data-toggle="tab" href="#three" role="tab" aria-controls="Three" aria-selected="false" onclick="getUserDetails(<?php $rowbidInfoShlstd['ownerId']=isset($rowbidInfoShlstd['ownerId'])?$rowbidInfoShlstd['ownerId']:0;echo $rowbidInfoShlstd['ownerId']." ,".$servID;?>,'stl')">Shortlisted</a>
                        </li>
                        <?php if($res[0]['bidAwardId'] != NULL){ ?>
                        <li class="nav-item">
                                <a class="nav-link" id="four-tab" data-toggle="tab" href="#four" role="tab" aria-controls="Four" aria-selected="false" onclick="getUserDetails(<?php $rowbidInfoAgremnt['ownerId']=isset($rowbidInfoAgremnt['ownerId'])?$rowbidInfoAgremnt['ownerId']:0;echo $rowbidInfoAgremnt['ownerId']." ,".$servID;?>,'agrm')">Agreement</a>
                        </li>
                        <?php } ?>                        
                        <?php } ?>
                        <!-- Session User is a bidder (Provider) -->
                        <?php if($rowuserTypeInfo['id'] != ''){  ?>
                        <li class="nav-item">
                            <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">Original SR</a>
                        </li>
                        <?php if($rowuserTypeInfo['srBidAwardId'] == NULL){ ?>
                        <li class="nav-item">
                                <a class="nav-link " id="four-tab" data-toggle="tab" href="#four" role="tab" aria-controls="Four" aria-selected="false" onclick="getUserDetails(<?php $rowuserTypeInfo['ownerId']=isset($rowuserTypeInfo['ownerId'])?$rowuserTypeInfo['ownerId']:0;echo $rowuserTypeInfo['ownerId']." ,".$servID;?>,'agrm')">Your Bid</a>
                        </li>
                        <?php }else{ ?>
                        <li class="nav-item">
                                <a class="nav-link" id="four-tab" data-toggle="tab" href="#four" role="tab" aria-controls="Four" aria-selected="false" onclick="getUserDetails(<?php $rowuserTypeInfo['ownerId']=isset($rowuserTypeInfo['ownerId'])?$rowuserTypeInfo['ownerId']:0;echo $rowuserTypeInfo['ownerId']." ,".$servID;?>,'agrm')">Agreement</a>
                        </li>
                        <?php } ?> 
                        <?php }elseif($res[0]['ownerId'] != $id){ ?>
                        <!-- Session user is a non-bidder -->
                        <li class="nav-item">
                            <a class="nav-link active" id="placebid-tab" data-toggle="tab" href="#placebid" role="tab" aria-controls="Placebid" aria-selected="true">Details</a>
                        </li>
                        <?php } ?>
                        <li class="nav-item">
                            <?php if($res[0]['ownerId'] == $id){ 
                                $fromval = "buyer";

                            }else{
                                $fromval = "seller";
                            }

                                $userval = $rowBids['ownerName'];
                                $bidstatusval = $rowBids['bidstatus'];
                                $statusval = $rowBids['status'];
                            ?>
                                <a class="nav-link videoclick" data-from="<?php echo $fromval; ?>" data-user="<?php echo $userval; ?>" data-bidstatus="<?php echo $bidstatusval; ?>" data-status="<?php echo $statusval; ?>" data-srid="<?php echo $servID; ?>" id="five-tab" data-toggle="tab" href="#five" role="tab" aria-controls="Five" aria-selected="false">Communication</a>
                        </li>
                    </ul>
                    <div class="search">
                        <input type="text"/>
                        <button><i class="fas fa-search"></i></button>
                    </div>
                </div>

                <div class="tab-content" id="myTabContent">
                    <?php if(($res[0]['ownerId'] == $id) || ($rowuserTypeInfo['id'] != '')){ ?>   
                    <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
                    <?php }else{ ?>
                    <div class="tab-pane fade p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
                    <?php } ?>
                        <!-- <p class="MRGT20PX"><b>Title</b> : <?php echo $res[0]['title'] ?></p> -->
                        <h5  class="MRGT20PX">Location</h5>
                        <?php if(($res[0]['ownerId'] == $id) || (($res[0]['bidAwardId'] != NULL) && ($rowuserTypeInfo['id'] != ''))) { ?>
                        <div class="MRGT10PX"><i class="fas fa-map-marker-alt"></i> 
                            <span><?php echo $res[0]['address'] ?></span>
                        </div>
                        <?php } ?>

                         <!-- <p class="MRGT20PX"><b>Title</b> : <?php echo $res[0]['title'] ?></p> -->
                        <p class="MRGT10PX"><b>Pictures</b></p>
                        <div class="attachment_container" style="width:100%;float:left;">
                        <?php

                        $row=@reset($images);
                        if(!empty($row))
                        {
                            while ($row) 
                            {
                                $imgurl =  imgPath2Url(smallPicName($row["url"]));
                            ?>
                            <div class="sr_pics" style="float:left;">
                            <img onclick='show_big_image(<?php echo $row['id'];?>)' src='<?php echo $imgurl;?>' class='img-rounded' alt='Imag' style='width: 150px;'>
                            </div>
                            <?php  
                              $row=next($images);
                            }
                            
                        }
                        else
                        {
                            echo 'No Images Available';
                        } 
                        ?>
                        </div>
                        <h5 class="MRGT20PX">Job Details</h5>
                        <p class="MRGT10PX"><b>Description</b></p>
                        <p class="card-text"><?php echo $res[0]['descr'] ?></p>
                        <p class="MRGT10PX"><b>Particulars</b></p>
                        <p>
                            <!-- <div><i class="far fa-clock"></i> <?php echo $dateFromArr[1]." ".$dateFromArr[2]." - ".$dateToArr[1]." ".$dateToArr[2]; ?></div> -->
                            <div><i class="far fa-clock"></i> <span class="serreq_time"></span></div>
                            <div><i class="far fa-calendar-alt"></i> <?php echo $dateFromArr[0]." - ".$dateToArr[0];?></div>
                        </p>  

                        <h5 class="MRGT20PX">Payment</h5>
                        <p class="MRGT10PX"><b>Amount</b></p>
                        <p style="text-transform: capitalize; "><?php echo $res[0]['paytype'] ?>, $<?php echo $res[0]['payAmt'] ?> </p> 
                        <?php if($res[0]['ownerId'] == $id){ ?>
                        <p class="MRGT10PX"><b>Personal Note</b></p>
                        <p class="card-text"><?php echo $res[0]['summ'] ?></p>


                        <button class="button-secondary cancelSR float-right" data-srid="<?php echo $res[0]['id'] ?>" data-from="" data-btnstatus="cancel" style="border:solid red 1px; color: red;margin-left:15px"><i class="fa fa-ban" aria-hidden="true"></i>&nbsp;Cancel Job</button>&nbsp;
                        <button class="button-secondary cancelSR float-right" data-srid="<?php echo $res[0]['id'] ?>" data-from="resubmit" data-btnstatus="cancel" style="border:solid orange 1px; color: orange;"><i class="fa fa-ban" aria-hidden="true"></i>&nbsp;Cancel & Re-Submit Job</button>
                        <?php }else if($res[0]['bidAwardId'] == NULL && $_GET['new'] == 1){ ?>
<!--                         <a  href="create_bid.php?job_id=<?php echo $_GET['id']; ?>"><button class="button-secondary">Place Your Bid</button></a> -->
                        <?php } ?>        
                    </div>
                    <?php if($rowuserTypeInfo['id'] == '' && $res[0]['ownerId'] != $id) { ?>
                        <div class="tab-pane fade show active p-3" id="placebid" role="tabpanel" aria-labelledby="one-tab">
                    <?php }else{ ?>
                    <div class="tab-pane fade p-3" id="placebid" role="tabpanel" aria-labelledby="one-tab">
                    <?php } ?>
                        <!-- <p class="MRGT20PX"><b>Title</b> : <?php echo $res[0]['title'] ?></p> -->
                        <h5 class="MRGT20PX">Location &nbsp;<span class="FONTSIZE12px"><a href="create_bid.php?job_id=<?php echo $res[0]['id']; ?>&tab=location"><i class="fa fa-pencil" aria-hidden="true"></i>
                            &nbsp;Edit</a></span></h5>
                        <?php if(($res[0]['ownerId'] == $id) || (($res[0]['bidAwardId'] != NULL) && ($rowuserTypeInfo['id'] != ''))) { ?>          
                        <p><i class="fas fa-map-marker-alt"></i> 
                            <span><?php echo $res[0]['address'] ?></span>
                        </p>
                        <?php } ?>

                        <h5 class="MRGT20PX">Job Details &nbsp;<span class="FONTSIZE12px"><a href="create_bid.php?job_id=<?php echo $res[0]['id']; ?>&tab=jobdetails"><i class="fa fa-pencil" aria-hidden="true"></i>
                            &nbsp;Edit</a></span></h5>
                        <p class="MRGT10PX"><b>Description</b></p>
                        <p class="card-text"><?php echo $res[0]['descr'] ?></p>
                        <p class="MRGT10PX"><b>Particulars</b></p>
                        <p>
                            <!-- <div><i class="far fa-clock"></i> <?php echo $dateFromArr[1]." ".$dateFromArr[2]." - ".$dateToArr[1]." ".$dateToArr[2]; ?></div> -->
                            <div><i class="far fa-clock"></i> <span class="serreq_time"></span></div>
                            <div><i class="far fa-calendar-alt"></i> <?php echo $dateFromArr[0]." - ".$dateToArr[0];?></div>
                        </p>  

                        <h5 class="MRGT20PX">Payment &nbsp;<span class="FONTSIZE12px"><a href="create_bid.php?job_id=<?php echo $res[0]['id']; ?>&tab=payment"><i class="fa fa-pencil" aria-hidden="true"></i>
                            &nbsp;Edit</a></span></h5>
                        <p class="MRGT20PX"><b>Amount</b></p>
                        <p style="text-transform: capitalize; "><?php echo $res[0]['paytype'] ?>, $<?php echo $res[0]['payAmt'] ?> </p> 
                        <a href="create_bid.php?job_id=<?php echo $res[0]['id']; ?>&tab=payment"><button class="button-secondary">Add Milestones</button></a>
                        <a href="create_bid.php?job_id=<?php echo $res[0]['id']; ?>&tab=payment"><button class="button-secondary">Add Cancellation Fee</button></a>
                        <a href="create_bid.php?job_id=<?php echo $res[0]['id']; ?>&tab=review"><button class="button-secondary">Make Offer</button></a>
                        <?php if($res[0]['ownerId'] == $id){ ?>
                        <p class="MRGT20PX"><b>Personal Note</b></p>
                        <p class="card-text"><?php echo $res[0]['summ'] ?></p>

                        
                        <button class="button-secondary">Cancel Job</button>&nbsp;
                        <button class="button-secondary">Cancel & Re-Submit Job</button>
                        <?php }else if($res[0]['bidAwardId'] == NULL && $_GET['new'] == 1){ ?>
<!--                         <a  href="create_bid.php?job_id=<?php echo $_GET['id']; ?>"><button class="button-secondary">Place Your Bid</button></a> -->
                        <?php } ?>        
                    </div>
                    <div class="tab-pane fade p-3" id="two" role="tabpanel" aria-labelledby="two-tab">
                        <h5 class="card-title"></h5>
                        <div class="row">
                            <div class="col-md-3 col-lg-3 col-sm-3">
                                <aside class="users-list">
                                <?php while($rowBids) {?>
                                    <div class="flex-layout" style="cursor:pointer" onclick="getUserDetails(<?php echo $rowBids['ownerId']." ,".$servID;?>)">
                                        <div><span><i class="fas fa-user"></i></span></div>
                                        <div>
                                            <div><?php echo $rowBids['firstName']." ".$rowBids['midName']."( ".$rowBids['username']." )";?></div>
                                            <small><?php echo date("h:i A d M Y ",strtotime($rowBids['create_dateTime']));?></small>
                                        </div>
                                        <div id="diamndr1" style="min-width: 100px"></div>
                                    </div>
                                <?php $rowBids=next($resBids); } ?>
                                    
                                </aside>
                            </div>
                            <div class="col-md-9 col-lg-9 col-sm-9">
                                <div class="user-details">
                                    <div class="flex-layout blue">
                                        <div>
                                            <div class="user-image">
                                                <img src="./assets/images/user.jpg"/>
                                            </div>
                                        </div>
                                        <div class="flex-layout">
                                            <div></div>
                                            <div class="">
                                                <p id="diamndr2"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-layout user-name">
                                        <div class="text-center">
                                            <span id="full_name"></span>
                                             (<small id="catg"></small>)
                                        </div>
                                        <div>
                                            <div class="user-details-tab">
                                                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="bid-details-tab" data-toggle="tab" href="#bid-detail" role="tab" aria-controls="One" aria-selected="true">Bid Details</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="bid-profile-tab" data-toggle="tab" href="#bid-profile" role="tab" aria-controls="Two" aria-selected="false">Profile</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="bid-feedback-tab" data-toggle="tab" href="#bid-feedback" role="tab" aria-controls="Three" aria-selected="false">Feedback</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active p-3" id="bid-detail" role="tabpanel" aria-labelledby="one-tab">
                                            
                                            <P><b>Comments: </b></p>
                                            <label id="bid_comment"></label>
                                            
                                            <div class="form-group MRGT10PX">
                                                <label ><b>Amount:</b></label>
                                                <label id="bid_amnt" style="text-transform: capitalize;"></label>
                                            </div>
                                            <div class="form-group MRGT10PX">
                                                <label><b>Duration:</b> </label>
                                                <label id="bid_duration"></label>
                                            </div>

                                            <div class="form-group MRGT10PX">
                                                <label ><b>Location:</b></label>
                                                <label id="location" style="text-transform: capitalize;"></label>
                                            </div>

                                             <div class="form-group MRGT10PX">
                                                <label><b>Pictures:</b></label>
                                                <label id="bid_attachment" style="text-transform: capitalize;"></label>
                                            </div>

                                            <div class="form-group MRGT10PX" id="milestones">
                                    
                                            </div>

                                           
                                            <div class="MRGT20PX">
                                                <?php if($res[0]['bidAwardId'] == NULL){ ?>
                                                <button class="orange-btn" id="hire" data-bidid=""
                                                onclick="hire(this, <?php echo $servID;?>);">Hire Now!</button>
                                                <?php } ?>
                                                <button class="button-secondary" id="shortlist" data-bidid="" onclick="shortlist(this);">Shortlist</button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade p-3" id="bid-profile" role="tabpanel" aria-labelledby="one-tab">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                   <!--  <button class="orange-btn">View Original Service Request</button> -->
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right">
                                                    <!-- <button class="button-secondary">+ Add to Shortlist</button>
                                                    <button class="button-secondary"><i class="fas fa-user-check"></i> Award Bid</button> -->
                                                </div>
                                            </div>
                                            <!-- <h2><b>Revised Proposed Agreement: Pants(98)</b></h2> -->
                                            <div class="grid">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        <b>Username</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="uname">
                                                        
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <b>Name</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="full_name1">
                                                        
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <b>Star Rating</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="starr">
                                                       
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <b>Diamond Rating</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="diamndr">
                                                        
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <b>Number of bids</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="">
                                                        <?php echo $bidInfo['bidNum'];?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <b>Average fix cost amount</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="">
                                                        <?php echo $bidInfo['avgFix'];?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        <b>Average hourly cost amount</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="">
                                                        <?php echo $bidInfo['avgHr'];?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        <b>Category</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="catg1">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <p class="MRGT20PX"><b>Proposed Agreement Detail Description</b></p>
                                            <textarea id="agreedesc"></textarea> -->
                                        </div>
                                        <div class="tab-pane fade p-3" id="bid-feedback" role="tabpanel" aria-labelledby="one-tab">
                                            <h2><b>Blue Star Rating</b></h2>
                                            <div class="grid">
                                                <div class="row">
                                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <b>SR</b>
                                                    </div>
                                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <b>Rating</b>
                                                    </div>
                                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <b>Comments</b>
                                                    </div>
                                                </div>

                                                <div id="bluestrdetails"></div>
                                             
                                            </div>
                                         <p>
                                            <h2><b>Silver Star Rating</b></h2>
                                            <div class="grid">
                                                <div class="row">
                                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <b>SR</b>
                                                    </div>
                                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <b>Name</b>
                                                    </div>
                                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <b>View</b>
                                                    </div>
                                                </div>

                                                <div id="slvrstrdetails"></div>
                                             
                                            </div>
                                        </p>
                                        <p>
                                            <h2><b>Gold Star Rating</b></h2>
                                             <div class="grid">
                                                <div id="goldstarresp"></div>

                                              </div>                                            
                                        </p>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="tab-pane fade p-3" id="three" role="tabpanel" aria-labelledby="three-tab">
                        <div class="row" id="row">
                            <div class="col-md-3 col-lg-3 col-sm-3">
                                <aside class="users-list">
                                <?php while($rowbidInfoShlstd) {?>
                                    <div class="flex-layout" style="cursor: pointer;" onclick="getUserDetails(<?php echo $rowbidInfoShlstd['ownerId']." ,".$servID;?>)">
                                        <div><span><i class="fas fa-user"></i></span></div>
                                        <div>
                                            <div><?php echo $rowbidInfoShlstd['firstName']." ".$rowbidInfoShlstd['midName']. "( ".$rowbidInfoShlstd['ownerName']." )";?></div>
                                            <small><?php echo date("h:i A d M Y",strtotime($rowbidInfoShlstd['create_dateTime']));?></small>
                                        </div>
                                        <div id="diamndr1_stl" style="min-width: 100px"></div>
                                    </div>
                                <?php $rowbidInfoShlstd=@next($bidInfoShlstd); }?>
                                    
                                </aside>
                            </div>
                            <div class="col-md-9 col-lg-9 col-sm-9">
                                <div class="user-details" id="cnt_stl">
                                    <div class="flex-layout blue">
                                        <div>
                                            <div class="user-image">
                                                <img src="./assets/images/user.jpg"/>
                                            </div>
                                        </div>
                                        <div class="flex-layout">
                                            <div></div>
                                            <div class="">
                                                <p id="diamndr2_stl"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-layout user-name">
                                        <div class="text-center">
                                            <span id="full_name_stl"></span>
                                             (<small id="catg_stl"></small>)
                                        </div>
                                        <div>
                                            <div class="user-details-tab">
                                                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="bid-details-tab" data-toggle="tab" href="#bid-detail-stl" role="tab" aria-controls="One" aria-selected="true">Bid Details</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="bid-profile-tab" data-toggle="tab" href="#bid-profile-stl" role="tab" aria-controls="Two" aria-selected="false">Profile</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="bid-feedback-tab" data-toggle="tab" href="#bid-feedback-stl" role="tab" aria-controls="Three" aria-selected="false">Feedback</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active p-3" id="bid-detail-stl" role="tabpanel" aria-labelledby="one-tab">
                                            <P><b>Comments: </b></p>
                                            <label id="bid_comment_stl"></label>
                                            
                                            <div class="form-group MRGT10PX">
                                                <label ><b>Amount:</b></label>
                                                <label id="bid_amnt_stl" style="text-transform: capitalize;"></label>
                                            </div>
                                            <div class="form-group MRGT10PX">
                                                <label><b>Duration:</b> </label>
                                                <label id="bid_duration_stl"></label>
                                            </div>

                                            <label ><b>Pictures:</b></label>
                                            <div id="bid_attachment_stl" class="form-group MRGT10PX">
                                            </div>

                                            <div id="bid_milestone_stl" class="form-group MRGT10PX">
                                            </div>
                                          

                                            <div class="MRGT20PX">
                                                <?php if($res[0]['bidAwardId'] == NULL){ ?>
                                                <button class="orange-btn" data-bidid="" id="hire_stl"
                                                onclick="hire(this, <?php echo $servID;?>);">Hire Now!</button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade p-3" id="bid-profile-stl" role="tabpanel" aria-labelledby="one-tab">
                                            <div class="row">
                                                <!-- <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                    <button class="orange-btn">View Original Service Request</button>
                                                </div> -->
                                                <!--<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right">
                                                    <button class="button-secondary">+ Add to Shortlist</button>
                                                    <button class="button-secondary"><i class="fas fa-user-check"></i> Award Bid</button>
                                                </div>-->
                                            </div>
                                            <!-- <h2><b>Revised Proposed Agreement:</b></h2> -->
                                            <div class="grid">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        <b>Username</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="uname_stl">
                                                        
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <b>Name</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="full_name_stl1">
                                                        
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <b>Star Rating</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="starr_stl">
                                                       
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <b>Diamond Rating</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="diamndr_stl">
                                                        
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <b>Number of bids</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="">
                                                        <?php echo $bidInfo['bidNum'];?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <b>Average fix cost amount</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="">
                                                        <?php echo $bidInfo['avgFix'];?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        <b>Average hourly cost amount</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="">
                                                        <?php echo $bidInfo['avgHr'];?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        <b>Category</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="catg_stl1">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <p class="MRGT20PX"><b>Proposed Agreement Detail Description</b></p>
                                            <textarea id="agreedesc"></textarea> -->
                                        </div>
                                        <div class="tab-pane fade p-3" id="bid-feedback-stl" role="tabpanel" aria-labelledby="one-tab">
                                            <h2><b>Blue Star Rating</b></h2>
                                            <div class="grid">
                                                <div class="row">
                                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <b>SR</b>
                                                    </div>
                                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <b>Rating</b>
                                                    </div>
                                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <b>Comments</b>
                                                    </div>
                                                </div>

                                                <div id="bluestrdetails_stl"></div>
                                             
                                            </div>
                                         <p>
                                            <h2><b>Silver Star Rating</b></h2>
                                            <div class="grid">
                                                <div class="row">
                                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <b>SR</b>
                                                    </div>
                                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <b>Name</b>
                                                    </div>
                                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <b>View</b>
                                                    </div>
                                                </div>

                                                <div id="slvrstrdetails_stl"></div>
                                             
                                            </div>
                                        </p>
                                        <p>
                                            <h2><b>Gold Star Rating</b></h2>
                                             <div class="grid">
                                                <div id="goldstarresp_stl"></div>

                                              </div>                                            
                                        </p>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="tab-pane fade p-3" id="four" role="tabpanel" aria-labelledby="four-tab">
                        <div class="row" id="row">
                            
                            <div class="col-md-12 col-lg-12 col-sm-12">
                                <div class="user-details" id="cnt_agrm">
                                    <div class="flex-layout blue">
                                        <div>
                                            <div class="user-image">
                                                <img src="./assets/images/user.jpg"/>
                                            </div>
                                        </div>
                                        <div class="flex-layout">
                                            <div></div>
                                            <div class="">
                                                <p id="diamndr2_agrm"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-layout user-name">
                                        <div class="text-center">
                                            <span id="full_name_agrm"></span>
                                             (<small id="catg_agrm"></small>)
                                        </div>
                                        <div>
                                            <div class="user-details-tab">
                                                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="bid-details-tab" data-toggle="tab" href="#bid-detail-agrm" role="tab" aria-controls="One" aria-selected="true">Bid Details</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="bid-profile-tab" data-toggle="tab" href="#bid-profile-agrm" role="tab" aria-controls="Two" aria-selected="false">Profile</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="bid-feedback-tab" data-toggle="tab" href="#bid-feedback-agrm" role="tab" aria-controls="Three" aria-selected="false">Feedback</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active p-3" id="bid-detail-agrm" role="tabpanel" aria-labelledby="one-tab">
                                            <div id="approve_recject_buttons">
                                                </div>
                                            <h5 class="MRGT20PX">Location&nbsp;<span class="FONTSIZE12px"><a href="edit_bid_new.php?job_id=<?php echo $res[0]['id']; ?>&id=<?php echo $rowuserTypeInfo['ownerId'];?>&tab=location"><i class="fa fa-pencil" aria-hidden="true"></i>
                            &nbsp;Edit</a></span></h5>
                                            <P class="MRGT10PX"><b>Address: </b></p>
                                            <div class="MRGT10PX" id="bid_address_agrm"></div>
                                            <h5 class="MRGT20PX">Job Details&nbsp;<span class="FONTSIZE12px"><a href="edit_bid_new.php?job_id=<?php echo $res[0]['id']; ?>&id=<?php echo $rowuserTypeInfo['ownerId'];?>&tab=jobdetails"><i class="fa fa-pencil" aria-hidden="true"></i>
                            &nbsp;Edit</a></span></h5>
                                            <P class="MRGT10PX"><b>Comments: </b></p>
                                            <label id="bid_comment_agrm"></label>
                                            <div class="form-group MRGT10PX">
                                                <label><b>Duration:</b> </label>
                                                <label id="bid_duration_agrm"></label>
                                            </div>

                                            <h5 class="MRGT20PX">Payment&nbsp;<span class="FONTSIZE12px"><a href="edit_bid_new.php?job_id=<?php echo $res[0]['id']; ?>&id=<?php echo $rowuserTypeInfo['ownerId'];?>&tab=payment"><i class="fa fa-pencil" aria-hidden="true"></i>
                            &nbsp;Edit</a></span></h5>
                                            <div class="form-group MRGT10PX">
                                                <label ><b>Amount:</b></label>
                                                <label id="bid_amnt_agrm" style="text-transform: capitalize;"></label>
                                            </div>

                                            <label ><b>Pictures:</b></label>
                                            <div id="bid_attachment_agrm" class="form-group MRGT10PX">
                                            </div>

                                            <div id="bid_milestone_agrm" class="form-group MRGT10PX">
                                            </div>

                                            <input type="hidden" value="" id="refid">
                                            <input type="hidden" value="" id="bidid">                                         

                                            <div class="MRGT20PX">

                                                

                                                <input id="accept_agreement_btn" type="button" value="ACCEPT AGREEMENT" data-status="16" name="accept_agreement_btn" data-bidid="" data-userid="" class="changeinwork btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border" style="background-color:red; border-color: red;font-weight:bold;">


                                                <!-- <button id="edit_agreement" class="orange-btn"
                                                onclick="edit_agreement(this, <?php echo $servID;?>);">Edit Agreement</button> -->

                                                
                                                <button id="request_pay" class="button-secondary requestpaypopup" data-bidamount="" data-paidamt="" style="display:none"><i class="fa fa-money"></i> Request Payment</button>


                                                <button id="approve_pay" data-bidid="" data-amount=""  data-amounttype="" data-actualamount=""  data-paidamt="" data-from="no" class="approveclick button-secondary"><i class="fa fa-money"></i> Approve / Reject Payment</button>

                                                
                                                <button id="make_pay" class="button-secondary requestpaypopup" data-bidamount="" data-paidamt=""><i class="fa fa-money"></i> Make Payment</button>

                                            <?php if($_SESSION['id']==$sr_user_id){?>
                                                <button id="gen_inv" class="button-secondary gen_inv" data-ownerid="<?php echo $sr_user_id;?>" data-srid="<?php echo $servID;?>" ><i class="fa fa-money"></i> Generate invoice</button>

                                                <button id="view_inv" style="display:none" class="button-secondary view_inv" ></button>

                                                <button id="send_inv" style="display:none" class="button-secondary send_inv" data-invid="" data-ownerid="<?php echo $sr_user_id;?>" data-srid="<?php echo $servID;?>"><i class="fa fa-money"></i>Send invoice</button>
                                            <?php } ?>    
                                                <button id="cancel_agreement" class="button-secondary cancelAgreement float-right" data-from="" data-srid="" data-bidid="" style="border:solid red 1px; color: red;margin-left:15px;"><i class="fa fa-ban" aria-hidden="true"></i>&nbsp;Cancel Agreement</button>

                                                <!-- &nbsp;

                                                <button id="cancel_resubmit_agreement" class="button-secondary cancelAgreement float-right" data-from="resubmit" data-srid="" data-bidid="" style="border:solid orange 1px; color: orange;"><i class="fa fa-ban" aria-hidden="true"></i>&nbsp;Cancel & Resubmit Agreement</button> -->

                                                <!-- <?php if($rowbidInfoAgremnt['status'] == "awarded" && $rowbidInfoAgremnt['ownerId'] == $_SESSION['id']){ ?>
                                                    <input type="button" value="ACCEPT AGREEMENT" id="accept_agreement_btn" data-status="16" name="accept_agreement_btn" data-bidid="" data-userid="" class="changeinwork btn btn-primary general_orange_button_border_radius general_orange_button_size general_orange_button_background general_orange_button_no_border" style="background-color:red; border-color: red;font-weight:bold;">
                                                <?php }else if($rowbidInfoAgremnt['status'] != "job completed"){ ?>
                                                <button class="orange-btn" id="edit_agreement"
                                                onclick="edit_agreement(this, <?php echo $servID;?>);">Edit Agreement</button>
                                                
                                                <button class="button-secondary requestpaypopup" data-bidamount="" id="request_pay" data-paidamt="" style="display:none"><i class="fa fa-money"></i> Request Payment</button>
                                                <?php } ?>
                                                <?php if($rowbidInfoAgremnt['srOwnerId'] == $_SESSION['id']){ ?>
                                                    <?php if($rowbidInfoAgremnt['status'] == 'request for payment'){ ?>
                                                <button  data-bidid="<?php echo $rowbidInfoAgremnt['id'];?>" data-amount="<?php echo $payAmt ?>"  data-amounttype="<?php echo $amt_type?>" data-actualamount="<?php echo $rowbidInfoAgremnt['payAmt'] ?>"  data-paidamt="<?php echo $paidamt ?>" data-from="no" class="approveclick button-secondary" id="approve_pay"><i class="fa fa-money"></i> Approve / Reject Payment</button>
                                                <?php }else if($rowbidInfoAgremnt['status'] != 'job completed'){ ?>
                                                    <button class=" button-secondary requestpaypopup" data-bidamount="<?php echo $bid_actual_amount; ?>" data-paidamt="<?php echo $paidamt; ?>" id="make_pay"><i class="fa fa-money"></i> Make Payment</button>
                                                        <?php } ?>
                                                     <?php } ?> -->
                                            </div>
                                        </div>
                                        <div class="tab-pane fade p-3" id="bid-profile-agrm" role="tabpanel" aria-labelledby="one-tab">
                                            <div class="row">
                                                <!-- <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                    <button class="orange-btn">View Original Service Request</button>
                                                </div> -->
                                                <!--<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right">
                                                    <button class="button-secondary">+ Add to Shortlist</button>
                                                    <button class="button-secondary"><i class="fas fa-user-check"></i> Award Bid</button>
                                                </div>-->
                                            </div>
                                            <!-- <h2><b>Revised Proposed Agreement:</b></h2> -->
                                            <div class="grid">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        <b>Username</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="uname_agrm">
                                                        
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <b>Name</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="full_name_agrm1">
                                                        
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <b>Star Rating</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="starr_agrm">
                                                       
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <b>Diamond Rating</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="diamndr_agrm">
                                                        
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <b>Number of bids</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="">
                                                        <?php echo $bidInfo['bidNum'];?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <b>Average fix cost amount</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="">
                                                        <?php echo $bidInfo['avgFix'];?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        <b>Average hourly cost amount</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="">
                                                        <?php echo $bidInfo['avgHr'];?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        <b>Category</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="catg_agrm1">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <p class="MRGT20PX"><b>Proposed Agreement Detail Description</b></p>
                                            <textarea id="agreedesc"></textarea> -->
                                        </div>
                                        <div class="tab-pane fade p-3" id="bid-feedback-agrm" role="tabpanel" aria-labelledby="one-tab">
                                            <h2><b>Blue Star Rating</b></h2>
                                            <div class="grid">
                                                <div class="row">
                                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <b>SR</b>
                                                    </div>
                                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <b>Rating</b>
                                                    </div>
                                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <b>Comments</b>
                                                    </div>
                                                </div>

                                                <div id="bluestrdetails_agrm"></div>
                                             
                                            </div>
                                         <p>
                                            <h2><b>Silver Star Rating</b></h2>
                                            <div class="grid">
                                                <div class="row">
                                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <b>SR</b>
                                                    </div>
                                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <b>Name</b>
                                                    </div>
                                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <b>View</b>
                                                    </div>
                                                </div>

                                                <div id="slvrstrdetails_agrm"></div>
                                             
                                            </div>
                                        </p>
                                        <p>
                                            <h2><b>Gold Star Rating</b></h2>
                                             <div class="grid">
                                                <div id="goldstarresp_agrm"></div>

                                              </div>                                            
                                        </p>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="tab-pane fade p-3" id="five" role="tabpanel" aria-labelledby="five-tab">
                         <iframe style="border:0px;" src="<?php echo $chaturl ?>" width="100%" height="700px" allow="geolocation; camera; microphone;"></iframe>  

                    </div>
                </div>
            </aside>
        </section>
    </div>
     <?php  include_once("view_bid_new.php");?>

<?php include("footer.php"); ?>  

<script>
$(document).ready(function() {
    console.log("time From");
    console.log("<?php echo $res[0]['timeFrom']; ?>");
    var serreq_time_from = convertTo12Hour('<?php echo $res[0]['timeFrom']; ?>');
    var serreq_time_to = convertTo12Hour('<?php echo $res[0]['timeTo']; ?>');
    $(".serreq_time").text(serreq_time_from+ " - "+serreq_time_to);
});
</script>