<?php
include("header_main.php");
//print_r($_SESSION);
$id= $_SESSION['id'];
$sqlPaymnt="SELECT sum(payAmt) as totalPayAmnt FROM view_bids WHERE ownerId='$id'";
$res=$_sqlObj->query($sqlPaymnt);
$totalPayAmnt = $res[0]['totalPayAmnt'];

$sqlSpent="SELECT sum(payAmt) as totalSpent FROM view_bids WHERE srOwnerId='$id'";
$res=$_sqlObj->query($sqlSpent);
$totalSpent = $res[0]['totalSpent'];

$sqlJobs="SELECT COUNT(*) as jobs FROM `view_bids` WHERE `ownerId`='$id' or srOwnerId='$id'";
$res=$_sqlObj->query($sqlJobs);
$jobs = $res[0]['jobs'];

//$sqlList="select * from view_bids where srOwnerId='$id' and srBidAwardId is null and shortlist = 'yes' and buttonstatus is null and bidstatus != 'cancel' order by last_updated desc";
$sqlList = "select * from view_bids where srOwnerId='$id' order by last_updated desc";
$resList=$_sqlObj->query($sqlList);

$sqlRecm="select * from view_serviceRequests where ownerId='$id' and bidAwardId is not null and buttonstatus != 'cancel'  order by last_updated desc";
$resRecm=$_sqlObj->query($sqlRecm);

$sqlReqtrAllJobs="select * from view_bids where srOwnerId='$id' and srBidAwardId is null and shortlist is null and buttonstatus is null and bidstatus != 'cancel' order by last_updated desc";
$resReqtrAllJobs=$_sqlObj->query($sqlReqtrAllJobs);
?>
<script>
  // A $( document ).ready() block.
$( document ).ready(function() {
    //console.log( "ready!" );
    var seller = document.getElementById("seller");
    var requester1 = document.getElementById("requester1");
    requester1.style.display="none";
    seller.style.display="block";
});

  function getDetails(obj){
    //alert(obj);
    var seller = document.getElementById("seller");
    var requester1 = document.getElementById("requester1");
    if(obj=='seller'){
		 //alert("inseller-"+obj);
         requester1.style.display="none";
		 seller.style.display="block";

    }
    if(obj=='requester1'){
		// alert("inrequester1-"+obj);
         requester1.style.display="block";
		 seller.style.display="none";
       
    }
  
	return;
  }

</script>

<section class="banner">
            <div class="row">
                <div class="col-sm-4">
                  <div class="card">
                    <div class="card-body">
                      <p class="card-text">Total Earning</p>
                      <h5><b><?php echo $totalPayAmnt;?> $</b></h5>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="card">
                    <div class="card-body">
                      <p class="card-text">Total Spent</p>
                      <h5><b><?php echo $totalSpent;?> $</b></h5>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                      <div class="card-body">
                        <p class="card-text">All Jobs</p>
                        <h5><b><?php echo $jobs;?></b></h5>
                      </div>
                    </div>
                  </div>
            </div>
        
   </section> 

    
       <section class="wrapper">
	    <div id="seller" style="width: 1070px;">    
            <aside class="WDTH80">
              <div class="flex-layout" style="width: 1070px;">
                  <div><h1>Job Requests seller</h1></div>
                  <div>
                      <button class="btn-orange">Search Jobs</button>
                      <div class="btn-group dropdown-btn" role="group">
                          <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              All Jobs
                          </button>
                          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                              <a class="dropdown-item" href="#">Dropdown link</a>
                              <a class="dropdown-item" href="#">Dropdown link</a>
                          </div>
                      </div>
                  </div>
              </div>
              
          </aside> 
          <div class="row MRGB10PX" style="width:1090px">
                <?php for($i=0;$i<count($resReqtrAllJobs);$i++){ ?>
                  <div class="col-sm-4">
                    <div class="card">
                      <div class="card-body">
                        <p class="card-text"><?php //echo $resReqtrAllJobs[$i]['id']?></p>
                          <div class="card-title">
                              <h5><?php echo $resReqtrAllJobs[$i]['sr_title']?></h5>
                              <!-- <div>
                                  <span class="ongoing"><?php echo $resReqtrAllJobs[$i]['status']?></span>
                                  <span class="badge badge-secondary"><?php echo $resReqtrAllJobs[$i]['srid']?> 5</span>
                              </div> -->
                          </div>
                          <label class="post-date">Posted: <?php echo $resReqtrAllJobs[$i]['create_dateTime']?></label>
                          <p class="card-info">Bidder: <?php echo $resReqtrAllJobs[$i]['srOwnerName']?> </p>
                           <p class="card-info">Price: <?php echo $resReqtrAllJobs[$i]['payAmt']." ".$resReqtrAllJobs[$i]['payType']?> </p>
                      </div>
                    </div>
                  </div>
                <?php } ?>
            </div>
          <aside class="WDTH80">
            <div class="flex-layout" style="width: 1070px;">
              <h1>Recommended Jobs</h1>
            </div>
            <div class="row MRGB10PX" style="width:1090px">
                <?php for($i=0;$i<count($resRecm);$i++){ ?>
                  <div class="col-sm-4">
                    <div class="card">
                      <div class="card-body">
                        
                          <div class="card-title">
                              <h5><?php echo $resRecm[$i]['title']?></h5>
                          </div>
                          <label class="post-date">Posted: <?php echo $resRecm[$i]['create_dateTime']?></label>
                          <p class="card-info"><?php echo $resRecm[$i]['descr']?> </p>
                          <!-- <div class="text-right"><a href="#">View Details</a></div> -->
                      </div>
                    </div>
                  </div>
                <?php } ?>
            </div>
          </aside>
      
     </div>
        <!--SECTION requester1 STARTS-->
     <div id="requester1" style="width: 1070px;">
        
            <aside class="WDTH80">
              <div class="flex-layout" style="width: 1070px;">
                  <div><h1>All Jobs</h1></div>
                  <div>
                      <button class="btn-orange" onclick="addSR();">+ Post New Job</button>
                      <div class="btn-group dropdown-btn" role="group">
                          <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              All Jobs
                          </button>
                          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                              <a class="dropdown-item" href="#">Dropdown link</a>
                              <a class="dropdown-item" href="#">Dropdown link</a>
                          </div>
                      </div>
                  </div>
              </div>
              
          </aside> 
          <div class="row MRGB10PX" style="width:1090px">
                <?php for($i=0;$i<count($resList);$i++){ ?>
                  <div class="col-sm-4">
                    <div class="card">
                      <div class="card-body">
                        <p class="card-text"><?php echo $resList[$i]['srExternId']?>;</p>
                          <div class="card-title">
                              <h5><?php echo $resList[$i]['sr_title']?></h5>
                              <div>
                                  <span class="ongoing"><?php echo $resList[$i]['status']?></span>
                                  <span class="badge badge-secondary"><?php echo $resList[$i]['srid']?> 5</span>
                              </div>
                          </div>
                          <label class="post-date">Posted: <?php echo $resList[$i]['create_dateTime']?></label>
                          <p class="card-info"><?php echo $resList[$i]['descr']?> </p>
                          <div class="text-right"><a href="view_service_details.php?id=<?php echo $resList[$i]['id'];?>">View Details</a></div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
            </div>
      <!--
          <aside class="WDTH80 MRGT20PX">
            <div class="flex-layout" style="width: 1070px;">
              <h1>Shortlisted Jobs</h1>
            </div>
            <div class="row MRGB10PX" style="width:1090px">
                <?php for($i=0;$i<count($resRecm);$i++){ ?>
                  <div class="col-sm-4">
                    <div class="card">
                      <div class="card-body">
                        
                          <div class="card-title">
                              <h5><?php echo $resRecm[$i]['title']?></h5>
                          </div>
                          <label class="post-date">Posted: <?php echo $resRecm[$i]['create_dateTime']?></label>
                          <p class="card-info"><?php echo $resRecm[$i]['descr']?> </p>
                          <!-- <div class="text-right"><a href="#">View Details</a></div> -->
                <!--          
                      </div>
                    </div>
                  </div>
                <?php } ?>
            </div>
          </aside>-->

       
     </div>
	  </section>
  <?php include("footer.php"); ?>  