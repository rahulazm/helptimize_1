<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include("header_main.php");


//print_r($_SESSION);
$id= $_SESSION['id'];
if($id==''){
    header("Location:index.php");
}
///////////////////////////////Details section///////////////////////////////////
$servID=$_GET['id']; 
$sqlServ="select a.title ,a.id,a.summ,a.payAmt,a.payType,a.totalhours,a.dateTimeTo,a.dateTimeFrom, b.address ,c.name from servicerequests as a , address as b,payType as c where a.id=b.srId and a.id='$servID' and a.payType=c.id";
//echo $sqlServ;
$res=$_sqlObj->query($sqlServ);
$dateFrom = date("d/m/y H:i:s A",strtotime($res[0]['dateTimeTo']));
//echo $dateFrom;
$dateTo = date("d/m/y H:i:s A",strtotime($res[0]['dateTimeFrom']));

$dateFromArr = explode(" ", $dateFrom);
$timeFrm = $dateFromArr[1];
$dtFrm = $dateFromArr[0];

$dateToArr = explode(" ", $dateTo);
$timeTo = $dateToArr[1];
$dtTo = $dateToArr[0];

//echo "<pre>";
//print_r($res);
//print_r($dateToArr);
//$jobs = $res[0]['jobs'];
///////////////////////////////BIDS section///////////////////////////////////

$sqlBids="SELECT bids.title,bids.ownerid , bids.summ,bids.descr,bids.payType,bids.payAmt,bids.dateTimeTo,bids.dateTimeFrom, bids.create_dateTime,users.username,users.firstName,users.midName FROM `bids`, users WHERE bids.`srId` = '$servID' and users.id=bids.ownerId ORDER by bids.create_dateTime desc";
//echo $sqlBids;

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
$bidInfoShlstd=$_sqlObj->query('select * from view_bids where srId='.$servID.' and srBidAwardId is null and shortlist = "yes" and buttonstatus is null  and bidstatus != "cancel" order by last_updated desc');
$rowbidInfoShlstd=@reset($bidInfoShlstd);
//$cntShrtltd = @count($bidInfoShlstd);
//$rowbidInfoShlstd['ownerId']=0;
//$rowbidInfoShlstd['ownerId'] = ($cntShrtltd > 0 ) ? $rowbidInfoShlstd['ownerId'] : 0;
//echo $cntShrtltd;
//echo 'select * from view_bids where srId='.$servID.' and srBidAwardId is null and shortlist = "yes" and buttonstatus is null  and bidstatus != "cancel" order by last_updated desc';

//print_r($bidInfo);
//echo "</pre>";

?>        
        <section class="wrapper">
            <aside class="layout">
                <div class="card-header tab-card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">Detail</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false" onclick="getUserDetails(<?php $rowBids['ownerid']=(isset($rowBids['ownerid']))?$rowBids['ownerid']:0;echo $rowBids['ownerid']." ,".$servID;?>,'bids')">Bids</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="three-tab" data-toggle="tab" href="#three" role="tab" aria-controls="Three" aria-selected="false" onclick="getUserDetails(<?php $rowbidInfoShlstd['ownerId']=isset($rowbidInfoShlstd['ownerId'])?$rowbidInfoShlstd['ownerId']:0;echo $rowbidInfoShlstd['ownerId']." ,".$servID;?>,'stl')">Shortlisted</a>
                        </li>
                        <li class="nav-item">
                                <a class="nav-link" id="four-tab" data-toggle="tab" href="#four" role="tab" aria-controls="Four" aria-selected="false">Agreement</a>
                        </li>
                        <li class="nav-item">
                                <a class="nav-link" id="five-tab" data-toggle="tab" href="#five" role="tab" aria-controls="Five" aria-selected="false">Communication</a>
                        </li>
                    </ul>
                    <div class="search">
                        <input type="text"/>
                        <button><i class="fas fa-search"></i></button>
                    </div>
                </div>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
                        <p class="MRGT20PX"><b>Description</b></p>
                        <p class="card-text"><?php echo $res[0]['title'] ?></p>
                        <p class="MRGT20PX"><b>Particulars</b></p>  
                        <div class="row">
                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <div><i class="far fa-clock"></i> <?php echo $dateFromArr[1]." ".$dateFromArr[2]." - ".$dateToArr[1]." ".$dateToArr[2]; ?></div>
                                <div><i class="far fa-calendar-alt"></i> <?php echo $dateFromArr[0]." - ".$dateToArr[0];?></div>
                            </div>
                            <div class="col-sm-8 col-md-8 col-lg-8">
                                <div><i class="fas fa-map-marker-alt"></i> Address 
                                    <p><?php echo $res[0]['address'] ?></p>
                                </div> 
                            </div>
                        </div>  
                        <p class="MRGT20PX"><b>Amount</b></p>
                        <p><?php echo $res[0]['name'] ?>, <?php echo $res[0]['payAmt'] ?> $</p> 
                        <button class="button-secondary">Edit Service Request</button>
                                
                    </div>
                    <div class="tab-pane fade p-3" id="two" role="tabpanel" aria-labelledby="two-tab">
                        <h5 class="card-title"></h5>
                        <div class="row">
                            <div class="col-md-3 col-lg-3 col-sm-3">
                                <aside class="users-list">
                                <?php while($rowBids) {?>
                                    <div class="flex-layout" onclick="getUserDetails(<?php echo $rowBids['ownerid']." ,".$servID;?>)">
                                        <div><span><i class="fas fa-user"></i></span></div>
                                        <div>
                                            <div><?php echo $rowBids['username'];?></div>
                                            <small><?php echo $rowBids['create_dateTime'];?></small>
                                        </div>
                                        <div id="diamndr1"></div>
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
                                            <p id="full_name"></p>
                                            <small id="catg"></small>
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
                                            <p><b>Comment</b></p>
                                            <textarea id="bid_comment"></textarea>
                                            <p class="MRGT20PX"><b>Bid Details</b></p>
                                            <div class="form-group MRGT10PX">
                                                <label class="form-label" for="first">Amount</label>
                                                <input id="bid_amnt" class="form-input" type="text" value=""/>
                                            </div>
                                            <div class="form-group MRGT10PX">
                                                <label class="form-label" for="date">Duration</label>
                                                <input id="bid_duration" class="form-input" type="text" />
                                            </div>
                                            <div class="MRGT20PX">
                                                <button class="orange-btn" id="hire"
                                                onclick="hire(<?php echo $bidInfo['id'].",".$servID;?>);">Hire Now!</button>
                                                <button class="button-secondary" id="shortlist" onclick="shortlist(<?php echo $bidInfo['id'];?>);">Shortlist</button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade p-3" id="bid-profile" role="tabpanel" aria-labelledby="one-tab">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                    <button class="orange-btn">View Original Service Request</button>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right">
                                                    <button class="button-secondary">+ Add to Shortlist</button>
                                                    <button class="button-secondary"><i class="fas fa-user-check"></i> Award Bid</button>
                                                </div>
                                            </div>
                                            <h2><b>Revised Proposed Agreement: Pants(98)</b></h2>
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
                                                            <b>Communicate</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        View Chart Demo
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
                                            <p class="MRGT20PX"><b>Proposed Agreement Detail Description</b></p>
                                            <textarea id="agreedesc"></textarea>
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
                                    <div class="flex-layout" onclick="getUserDetails(<?php echo $rowbidInfoShlstd['ownerId']." ,".$servID;?>)">
                                        <div><span><i class="fas fa-user"></i></span></div>
                                        <div>
                                            <div><?php echo $rowbidInfoShlstd['ownerName'];?></div>
                                            <small><?php echo date("m/d/Y H:i A",strtotime($rowbidInfoShlstd['create_dateTime']));?></small>
                                        </div>
                                        <div id="diamndr1"></div>
                                    </div>
                                <?php $rowbidInfoShlstd=@next($bidInfoShlstd); } ?>
                                    
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
                                            <p id="full_name_stl"></p>
                                            <small id="catg_stl"></small>
                                        </div>
                                        <div>
                                            <div class="user-details-tab">
                                                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="bid-details-tab" data-toggle="tab" href="#bid-detail" role="tab" aria-controls="One" aria-selected="true">Bid Details</a>
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
                                        <div class="tab-pane fade show active p-3" id="bid-detail" role="tabpanel" aria-labelledby="one-tab">
                                            <p><b>Comment</b></p>
                                            <textarea id="bid_comment_stl"></textarea>
                                            <p class="MRGT20PX"><b>Bid Details</b></p>
                                            <div class="form-group MRGT10PX">
                                                <label class="form-label" for="first">Amount</label>
                                                <input id="bid_amnt_stl" class="form-input" type="text" value=""/>
                                            </div>
                                            <div class="form-group MRGT10PX">
                                                <label class="form-label" for="date">Duration</label>
                                                <input id="bid_duration_stl" class="form-input" type="text" />
                                            </div>
                                            <div class="MRGT20PX">
                                                <button class="orange-btn" id="hire"
                                                onclick="hire(<?php echo $bidInfo['id'].",".$servID;?>);">Hire Now!</button>
                                                <button class="button-secondary" id="shortlist" onclick="shortlist(<?php echo $bidInfo['id'];?>);">Shortlist</button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade p-3" id="bid-profile-stl" role="tabpanel" aria-labelledby="one-tab">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                    <button class="orange-btn">View Original Service Request</button>
                                                </div>
                                                <!--<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right">
                                                    <button class="button-secondary">+ Add to Shortlist</button>
                                                    <button class="button-secondary"><i class="fas fa-user-check"></i> Award Bid</button>
                                                </div>-->
                                            </div>
                                            <h2><b>Revised Proposed Agreement:</b></h2>
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
                                                            <b>Communicate</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        View Chart Demo
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <b>Name</b>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="full_name_stl">
                                                        
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
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="diamndr-stl">
                                                        
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
                                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" id="catg_stl">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="MRGT20PX"><b>Proposed Agreement Detail Description</b></p>
                                            <textarea id="agreedesc"></textarea>
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
                    <div class="tab-pane fade p-3" id="four" role="tabpanel" aria-labelledby="four-tab">
                        
                            
                           Agreement section ... 
                            
                     
                    </div>
                    <div class="tab-pane fade p-3" id="five" role="tabpanel" aria-labelledby="five-tab">
                        <!--<label for="requesterBox">
                                <b>Communicate:</b>
                        </label>
                        <label class="SRRequesterName" for="requesterBoxB">
                                <a href="javascript:void()" class="videoclick" data-from="seller" data-user="'.$bidArr['srOwnerName'].'">
                                 <img  src="img/chat.png" width="50px"  >
                                </a> <a href="javascript:void()" class="democlick" >View Chat Demo</a>
                        </label>-->
                         <div class="col-md-9 col-lg-9 col-sm-9">
                            <div class="user-details" id="cnt_stl">
                                 <div class="tab-content">
                                    <div class="tab-pane fade show active p-3" id="bid-detail" role="tabpanel" aria-labelledby="one-tab">
                                        <?php  include_once("view_bid_new.php");?>
                                    </div>
                                </div>
                            </div>
                         </div>   
                    </div>
                </div>
            </aside>
        </section>
    </div>
<?php include("footer.php"); ?>  