<?php
include("header_main.php");
//print_r($_SESSION);
$id= $_SESSION['id'];
if($id==''){
    header("Location:index.php");
}
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

?>        
        <section class="wrapper">
            <aside class="layout">
                <div class="card-header tab-card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">Detail</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false">Bids</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="three-tab" data-toggle="tab" href="#three" role="tab" aria-controls="Three" aria-selected="false">Shortlisted</a>
                        </li>
                        <li class="nav-item">
                                <a class="nav-link" id="three-tab" data-toggle="tab" href="#four" role="tab" aria-controls="four" aria-selected="false">Contact</a>
                        </li>
                        <li class="nav-item">
                                <a class="nav-link" id="three-tab" data-toggle="tab" href="#five" role="tab" aria-controls="five" aria-selected="false">Communication</a>
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
                        <button class="button-secondary">Edit Bid</button>
                                
                    </div>
                    <div class="tab-pane fade p-3" id="two" role="tabpanel" aria-labelledby="two-tab">
                        <h5 class="card-title">Tab Card Two</h5>
                        <div class="row">
                            <div class="col-md-3 col-lg-3 col-sm-3">
                                <aside class="users-list">
                                    <div class="flex-layout">
                                        <div><span><i class="fas fa-user"></i></span></div>
                                        <div>
                                            <div>Steve McMohan</div>
                                            <small>05:16 pm 12.06.2019</small>
                                        </div>
                                        <div><i class="fas fa-user"></i></div>
                                    </div>
                                    <div class="flex-layout">
                                            <div><span><i class="fas fa-user"></i></span></div>
                                            <div>
                                                <div>Steve MCMohan</div>
                                                <small>05:16 pm 12.06.2019</small>
                                            </div>
                                            <div><i class="fas fa-user"></i></div>
                                        </div>
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
                                            <div>Blue Member</div>
                                            <div class="user-diomand">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-layout user-name">
                                        <div class="text-center">
                                            Steve McMohan<br/>
                                            <small>Software Engineer</small>
                                        </div>
                                        <div>
                                            <div class="user-details-tab">
                                                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="bid-details-tab" data-toggle="tab" href="#bid" role="tab" aria-controls="One" aria-selected="true">Bid Detail</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="Two" aria-selected="false">Profile</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="feedback-tab" data-toggle="tab" href="#feedback" role="tab" aria-controls="Three" aria-selected="false">Feedback</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active p-3" id="bid" role="tabpanel" aria-labelledby="one-tab">
                                            <p><b>Comment</b></p>
                                            <textarea></textarea>
                                            <p class="MRGT20PX"><b>Bid Details</b></p>
                                            <div class="form-group MRGT10PX">
                                                <label class="form-label" for="first">Amount</label>
                                                <input id="first" class="form-input" type="text" />
                                            </div>
                                            <div class="form-group MRGT10PX">
                                                <label class="form-label" for="date">Duration</label>
                                                <input id="date" class="form-input" type="text" />
                                            </div>
                                            <div class="MRGT20PX">
                                                <button class="orange-btn">Hire Now!</button>
                                                <button class="button-secondary">Shortlist</button>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade p-3" id="profile" role="tabpanel" aria-labelledby="one-tab">
                                            Profile Details here
                                        </div>
                                        <div class="tab-pane fade p-3" id="feedback" role="tabpanel" aria-labelledby="one-tab">
                                                Feedback Details here
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade p-3" id="three" role="tabpanel" aria-labelledby="three-tab">
                        <h5 class="card-title">Tab Card Three</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>              
                    </div>
                </div>
            </aside>
        </section>
    </div>
<?php include("footer.php"); ?>  