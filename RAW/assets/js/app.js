localStorage.removeItem('recurring');
//jQuery('button#review').hide(); 
$("button#next").html('Next'); 
function next() {
  //$('#amount, #ramount').val('')
  //console.log("getId: "+getId.length);

//  if(!getId.length){
    var getId = $('.super-widget-tab input[type="radio"]:checked').last().parent().next().children('input').attr('id');
//  }  
    var address = $('#getaddr').val();
    var jobtitle = $('#jobtitle').val();
    var desc  = $('#desc').val();
    var serv  = $('input:radio[name=serv]:checked').val();
    var pay  = $('input:radio[name=pay]:checked').val();
    var amount  = $('#amount').val();
    var bank  = $('input:radio[name=bank]:checked').val();
    var mapaddress = $('#pac-input').val();
    //var newaddress = $('#newaddress').val();
    var newaddress = '';
    if(!($("#sr_address_list").children("tbody").children("tr").children("td").hasClass("dataTables_empty"))){
      $("#sr_address_list").children("tbody").children("tr").each(function(i){
        adrs = $(this).children("td:nth-child(2)").html();
        newaddress += "<p>"+i+". "+adrs+"</p>";
      });
    }
    var recurringtype = localStorage.getItem('recurring');
    var lat=$('#lat').val();
    var lng=$('#lng').val();
    var ramount=$('#ramount').val();
    var cancelfee = $("#cancelfee").val();
    var personalnote = $("#personal_notes").val();

    //var time = '10:15 AM';
    //var startdate = '10/10/2018';
    //var enddate = '11/10/2018';
    var pic_id = $('#pic_id').val();
    var schedule_note = $('#schedule_note').val();
    var address;
    //alert(schedule_note);

    if((getId=='jobdetails' || getId=='finish' ) && (jobtitle == "" || jobtitle == null)){
      swal({
        title: "Warning",
         type: "warning",
        text: "Please enter the job title!"
      });
      return false;
    }

    if((getId=='payment' || getId=='finish' ) && (serv == "" || serv == null)){
      swal({
        title: "Warning",
         type: "warning",
        text: "Please select the category!"
      });
      return false;
    }


    if($('#description').length){
       $('#description').text(desc);
    }
    //alert($('#amnt').length);
    //alert(pay+", "+ amount+" $");

    //alert("startDate1" + localStorage.getItem('startDate1'));
    //alert("endDate1" + localStorage.getItem('endDate1'));  


    if($('#amnt').length){
      if(recurringtype == "One Time"){
        var newtext = recurringtype + ", "+pay+", $"+ amount;
      }else{
        var newtext = recurringtype + " ($"+ramount+"), Total ($"+amount+"), "+pay;
      }
      $('#amnt').text(newtext);
    }

    if(mapaddress!=""){
      $('#address').text(mapaddress);
      address = mapaddress;
    }

    if(newaddress!=""){
      $('#address').html(newaddress);
      address = newaddress;
    }
if(recurringtype!='One Time'){
  $('#recamnt').show();
  $('#recamnt label').html("Amount ("+recurringtype+")");
  $('.notes').show();
}

if(getId=='finish'){
  var startDate1 = localStorage.getItem('startDate1') ; 
  var endDate1   = localStorage.getItem('endDate1') ; 
  var startMin  = localStorage.getItem('startMin') ; 
  var endMin    = localStorage.getItem('endMin') ; 
  var dbStartDate = localStorage.getItem('dbStartDate') ; 
  var dbEndDate   =localStorage.getItem('dbEndDate') ; 
  var dbStartMin = localStorage.getItem('dbStartMin');
  var dbEndMin = localStorage.getItem('dbEndMin');

  console.log("Finish tab:");
  console.log("startDate1: "+startDate1);
  console.log("endDate1: "+endDate1);
  console.log("startMin: "+startMin);
  console.log("endMin: "+endMin);
  console.log("dbStartDate: "+dbStartDate);
  console.log("dbEndDate: "+dbEndDate);

 
}
 
if(startDate1!=""){
      $('#startdate').text(localStorage.getItem('startDate1'));
  }
if(startMin!=""){
  $('#startMin').text(localStorage.getItem('startMin'));
}
if(endDate1!=""){
      $('#enddate').text(localStorage.getItem('endDate1'));
    }
if(endMin!=""){
  $('#endMin').text(localStorage.getItem('endMin'));
}


//alert("desc----"+desc);
//alert(address);
/*if($('#start-date').length){
  alert($('#start-date').val());
}*/
var bid_bool="";
var totalhours="";
var rateperhour="";
var is18=1;
var selected_provider="";
var buttonstatus='submit';
var provider_type="";
var time="";

var imgs=[];
  $('#sr_imgs input[type="hidden"]').each(function(){
  imgs[this.id]=this.value;
   //alert(this.value);
   console.log('images');
  });

if(getId=='finish'){
  
  /*
  var tmp= {title : desc,
      descr : desc,
      summ : desc,
      bidDate : bid_bool,
      dateTimeBool: time,
      dateTimeFrom : dbStartDate,
      dateTimeTo : dbEndDate,
      set_schedule : recurringtype,
      schedule_note : schedule_note,
      schedule_amount : ramount,
      payAmt : amount,
      payType : pay,
      totalhours : totalhours,
      rateperhour : rateperhour,
      category : serv,
      is18 : is18,
      provider_type : provider_type,
      reqstedBidId : selected_provider,
      imgs : imgs,
      addr : address,
      buttonstatus : buttonstatus,
      current : "11",
      sr_number : "108",
      posLong:lng,
      posLat:lat};
      console.log(tmp);
  */

  $.post("service_request_submit_new.php",
    {
      title : jobtitle,
      descr : desc,
      summ : personalnote,
      bidDate : bid_bool,
      dateTimeBool: time,
      dateTimeFrom : dbStartDate,
      dateTimeTo : dbEndDate,
      timeFrom: dbStartMin,
      timeTo: dbEndMin,
      set_schedule : recurringtype,
      schedule_note : schedule_note,
      schedule_amount : ramount,
      payAmt : amount,
      payType : pay,
      totalhours : totalhours,
      rateperhour : rateperhour,
      category : serv,
      is18 : is18,
      cancelfee : cancelfee,
      provider_type : provider_type,
      reqstedBidId : selected_provider,
      imgs : imgs,
      addr : address,
      buttonstatus : buttonstatus,
      current : "submit",
      sr_number : "",
      posLong:lng,
      posLat:lat
    },
    function(data,status){
      console.log("Data: " + data + "\nStatus: " + status);
    });

}

    

    $('.super-widget-tab input[type="radio"]:checked').last().parent().next().children('input').prop('checked', true);
    $('.super-widget-tab-info summary').hide();
    $('.'+getId).show();
    if($('#prev').css('visibility') == 'hidden' && $('.super-widget-tab input[type="radio"]:checked').length > 1) { 
        $('#prev').css('visibility', 'visible');
    } else if(($('.super-widget-tab input[type="radio"]').last().is(':checked'))) {
        $('#next').hide()
    }

    if(getId == "payment"){
      //alert('test: '+ localStorage.getItem('recurring'))
      payTypeSetting();
      $("#schedule_note").focus();
      $("#amount").focus();
      $("#cancelfee").focus();
      $("#personalnote").focus();
      if($("#recamnt").css("display") != 'none'){
        $("#ramount").focus();
      }
    }

}

function prev() {
    var getId = $('.super-widget-tab input[type="radio"]:checked').last().parent().prev().children('input').attr('id');
    $('.super-widget-tab input[type="radio"]:checked').last().prop('checked', false);
    $('.super-widget-tab-info summary').hide();
    $('.'+getId).show();
    if($('.super-widget-tab input[type="radio"]:checked').length < 2) {
        $('#prev').css('visibility', 'hidden');
        $('#next').show();
    } 
    if(getId == "payment"){
      payTypeSetting();
      $("#schedule_note").focus();
      $("#amount").focus();
      $("#cancelfee").focus();
      $("#personalnote").focus();
      if($("#recamnt").css("display") != 'none'){
        $("#ramount").focus();
      }
    }
}



function create_bid_next() {
   
    var queryArr = [];
   $('input[name^="milestones"]').each(function()
    {   
        
        data = $(this).val();
        queryArr.push(data);
    });
   console.log(queryArr);
    var getId = $('.super-widget-tab input[type="radio"]:checked').last().parent().next().children('input').attr('id');
    var address = $('#getaddr').val();
    var jobtitle = $('#jobtitle').val();
    var desc  = $('#desc').val();
    var serv  = $('input:radio[name=serv]:checked').val();
    var pay  = $('input:radio[name=pay]:checked').val();
    var amount  = $('#amount').val();
    var bank  = $('input:radio[name=bank]:checked').val();
    var mapaddress = $('#pac-input').val();
    //var newaddress = $('#newaddress').val();
    var newaddress = '';
    if(!($("#sr_address_list").children("tbody").children("tr").children("td").hasClass("dataTables_empty"))){
      $("#sr_address_list").children("tbody").children("tr").each(function(i){
        adrs = $(this).children("td:nth-child(2)").html();
        newaddress += "<p>"+i+". "+adrs+"</p>";
      });
    }
    var recurringtype = localStorage.getItem('recurring');
    var lat=$('#lat').val();
    var lng=$('#lng').val();
    var ramount=$('#ramount').val();
    var service_id=$('#service_id').val();
    var milestones = queryArr;
    var cancelfee = $("#cancelfee").val();

    //var time = '10:15 AM';
    //var startdate = '10/10/2018';
    //var enddate = '11/10/2018';
    var pic_id = $('#pic_id').val();
    var schedule_note = $('#schedule_note').val();
    var address;
    //alert(schedule_note);


    if($('#description').length){
       $('#description').text(desc);
    }
    //alert($('#amnt').length);
    //alert(pay+", "+ amount+" $");

    //alert("startDate1" + localStorage.getItem('startDate1'));
    //alert("endDate1" + localStorage.getItem('endDate1'));  


    if($('#amnt').length){
      if(recurringtype == "One Time"){
        var newtext = recurringtype + ", "+pay+", $"+ amount;
      }else{
        var newtext = recurringtype + " ($"+ramount+"), Total ($"+amount+"), "+pay;
      }
      $('#amnt').text(newtext);
    }

    if(mapaddress!=""){
      $('#address').text(mapaddress);
      address = mapaddress;
    }

    if(newaddress!=""){
      $('#address').html(newaddress);
      address = newaddress;
    }
if(recurringtype!='One Time'){
  $('#recamnt').show();
  $('#recamnt label').html("Amount ("+recurringtype+")");
  $('.notes').show();
}

if(getId=='finish'){
  var startDate1 = localStorage.getItem('startDate1') ; 
  var endDate1   = localStorage.getItem('endDate1') ; 
  var startMin  = localStorage.getItem('startMin') ; 
  var endMin    = localStorage.getItem('endMin') ; 
  var dbStartDate = localStorage.getItem('dbStartDate') ; 
  var dbEndDate   =localStorage.getItem('dbEndDate') ; 
  var dbStartMin = localStorage.getItem('dbStartMin');
  var dbEndMin = localStorage.getItem('dbEndMin');
}
 
if(startDate1!=""){
      $('#startdate').text(localStorage.getItem('startDate1'));
  }
if(startMin!=""){
  $('#startMin').text(localStorage.getItem('startMin'));
}
if(endDate1!=""){
      $('#enddate').text(localStorage.getItem('endDate1'));
    }
if(endMin!=""){
  $('#endMin').text(localStorage.getItem('endMin'));
}


//alert("desc----"+desc);
//alert(address);
/*if($('#start-date').length){
  alert($('#start-date').val());
}*/
var bid_bool="";
var totalhours="";
var rateperhour="";
var is18=1;
var selected_provider="";
var buttonstatus='submit';
var provider_type="";
var time="";

var imgs=[];
  $('#sr_imgs input[type="hidden"]').each(function(){
  imgs[this.id]=this.value;
   //alert(this.value);
   console.log('images');
  });

if(getId=='finish'){
  
  /*
  var tmp= {title : desc,
      descr : desc,
      summ : desc,
      bidDate : bid_bool,
      dateTimeBool: time,
      dateTimeFrom : dbStartDate,
      dateTimeTo : dbEndDate,
      set_schedule : recurringtype,
      schedule_note : schedule_note,
      schedule_amount : ramount,
      payAmt : amount,
      payType : pay,
      totalhours : totalhours,
      rateperhour : rateperhour,
      category : serv,
      is18 : is18,
      provider_type : provider_type,
      reqstedBidId : selected_provider,
      imgs : imgs,
      addr : address,
      buttonstatus : buttonstatus,
      current : "11",
      sr_number : "108",
      posLong:lng,
      posLat:lat};
      console.log(tmp);
  */

  $.post("bid_submit_new.php",
    {
      title : jobtitle,
      descr : desc,
      summ : desc,
      bidDate : bid_bool,
      dateTimeBool: time,
      dateTimeFrom : dbStartDate,
      dateTimeTo : dbEndDate,
      timeFrom: dbStartMin,
      timeTo: dbEndMin,
      set_schedule : recurringtype,
      schedule_note : schedule_note,
      schedule_amount : ramount,
      payAmt : amount,
      payType : pay,
      totalhours : totalhours,
      rateperhour : rateperhour,
      category : serv,
      is18 : is18,
      cancelfee : cancelfee,
      provider_type : provider_type,
      reqstedBidId : selected_provider,
      imgs : imgs,
      addr : address,
      buttonstatus : buttonstatus,
      current : "11",
      sr_number : "108",
      service_id : service_id,
      milestones : queryArr,
      posLong:lng,
      posLat:lat
    },
    function(data,status){
      console.log("Data: " + data + "\nStatus: " + status);
    });

}

    

    $('.super-widget-tab input[type="radio"]:checked').last().parent().next().children('input').prop('checked', true);
    $('.super-widget-tab-info summary').hide();
    $('.'+getId).show();
    if($('#prev').css('visibility') == 'hidden' && $('.super-widget-tab input[type="radio"]:checked').length > 1) { 
        $('#prev').css('visibility', 'visible');
    } else if(($('.super-widget-tab input[type="radio"]').last().is(':checked'))) {
        $('#next').hide()
    }

   
    if(getId == "jobdetails")
    {
      jQuery('button#review_btn').show(); 
      $("button#next").html('Next'); 
    }
    else if(getId == "location")
    {
      jQuery('button#review_btn').show();  
      $("button#next").html('Next'); 
    }
    else if(getId == "payment")
    {
      jQuery('button#review_btn').show();  
      $("button#next").html('Next'); 
    }
    else if(getId == "review")
    {
      jQuery('button#review_btn').hide(); 
      if($('#review').is(':checked')) 
      { 
        $("button#next").html('Create Bid'); 
      }
    }else
    {
      jQuery('button#review_btn').hide(); 
      $("button#next").html('Next'); 
    }

    

    if(getId == "payment"){
      //alert('test: '+ localStorage.getItem('recurring'))
      payTypeSetting();
      $("#schedule_note").focus();
      $("#amount").focus();
      $("#cancelfee").focus();
      $("#personalnote").focus();
      if($("#recamnt").css("display") != 'none'){
        $("#ramount").focus();
      }
    }
}

function create_bid_prev() {
    var getId = $('.super-widget-tab input[type="radio"]:checked').last().parent().prev().children('input').attr('id');
    $('.super-widget-tab input[type="radio"]:checked').last().prop('checked', false);
    $('.super-widget-tab-info summary').hide();
    $('.'+getId).show();
    if($('.super-widget-tab input[type="radio"]:checked').length < 2) {
        $('#prev').css('visibility', 'hidden');
        $('#next').show();
    } 
    if(getId == "payment"){
      payTypeSetting();
      $("#schedule_note").focus();
      $("#amount").focus();
      $("#cancelfee").focus();
      $("#personalnote").focus();
      if($("#recamnt").css("display") != 'none'){
        $("#ramount").focus();
      }
    }

    if(getId == "jobdetails")
    {
      jQuery('button#review_btn').show(); 
      $("button#next").html('Next'); 
    }
    else if(getId == "location")
    {
      jQuery('button#review_btn').show();  
      $("button#next").html('Next'); 
    }
    else if(getId == "payment")
    {
      jQuery('button#review_btn').show();  
      $("button#next").html('Next'); 
    }
    else
    {
      jQuery('button#review_btn').hide(); 
    }

    if(getId == "review")
    {
      $("button#next").html('Create Bid'); 
    }

}



function review() 
{
    
   $("button#next").html('Create Bid');
   jQuery('summary.location.WDTH90.MRGCenter').hide();
   jQuery('summary.jobdetails.WDTH90.MRGCenter').hide();
   jQuery('summary.payment.WDTH90.MRGCenter').hide();
   jQuery('summary.finish.WDTH90.MRGCenter').hide();
   jQuery('summary.review.WDTH90.MRGCenter').show();
   var getId = $('.super-widget-tab input[type="radio"]:checked').last().parent().next().children('input').attr('id');
   if(getId == 'payment')
    {
        

            var amount= parseFloat($("#amount").val());
            var payType = $('input[name=pay]:checked').val();
            var total= parseFloat($("#milestoneTotal").val());

            var text="Milestone total amount must be equal to bid amount";
            if(!isNaN(total))
            {

               if(payType == 'fixed' || payType == 'hourly')
              {
                 if(total !== amount)
                 {
                    swal({
                      title: "Warning",
                       type: "warning",
                      text: text
                    });
                    jQuery('summary.location.WDTH90.MRGCenter').hide();
                    jQuery('summary.jobdetails.WDTH90.MRGCenter').hide();
                    jQuery('summary.payment.WDTH90.MRGCenter').show();
                    jQuery('summary.finish.WDTH90.MRGCenter').hide();
                    jQuery('summary.review.WDTH90.MRGCenter').hide();
                    $('#review').prop('checked', false);
                    return false;
                 }

              } 
            }
           
          

    }

   $('#payment').prop('checked', true);
   $('#review').prop('checked', true);
   $('#jobdetails').prop('checked', true);
   $('#location').prop('checked', true);
   
    var queryArr = [];
   $('input[name^="milestones"]').each(function()
    {   
        
        data = $(this).val();
        queryArr.push(data);
    });
   console.log(queryArr);
    
    var address = $('#getaddr').val();
    var jobtitle = $('#jobtitle').val();
    var desc  = $('#desc').val();
    var serv  = $('input:radio[name=serv]:checked').val();
    var pay  = $('input:radio[name=pay]:checked').val();
    var amount  = $('#amount').val();
    var bank  = $('input:radio[name=bank]:checked').val();
    var mapaddress = $('#pac-input').val();
    //var newaddress = $('#newaddress').val();
    var newaddress = '';
    if(!($("#sr_address_list").children("tbody").children("tr").children("td").hasClass("dataTables_empty"))){
      $("#sr_address_list").children("tbody").children("tr").each(function(i){
        adrs = $(this).children("td:nth-child(2)").html();
        newaddress += "<p>"+i+". "+adrs+"</p>";
      });
    }
    var recurringtype = localStorage.getItem('recurring');
    var lat=$('#lat').val();
    var lng=$('#lng').val();
    var ramount=$('#ramount').val();
    var service_id=$('#service_id').val();
    var milestones = queryArr;
    var cancelfee = $("#cancelfee").val();

    //var time = '10:15 AM';
    //var startdate = '10/10/2018';
    //var enddate = '11/10/2018';
    var pic_id = $('#pic_id').val();
    var schedule_note = $('#schedule_note').val();
    var address;
    //alert(schedule_note);


    if($('#description').length){
       $('#description').text(desc);
    }
    //alert($('#amnt').length);
    //alert(pay+", "+ amount+" $");

    //alert("startDate1" + localStorage.getItem('startDate1'));
    //alert("endDate1" + localStorage.getItem('endDate1'));  


    if($('#amnt').length){
      if(recurringtype == "One Time"){
        var newtext = recurringtype + ", "+pay+", $"+ amount;
      }else{
        var newtext = recurringtype + " ($"+ramount+"), Total ($"+amount+"), "+pay;
      }
      $('#amnt').text(newtext);
    }

    if(mapaddress!=""){
      $('#address').text(mapaddress);
      address = mapaddress;
    }

    if(newaddress!=""){
      $('#address').html(newaddress);
      address = newaddress;
    }
if(recurringtype!='One Time'){
  $('#recamnt').show();
  $('#recamnt label').html("Amount ("+recurringtype+")");
  $('.notes').show();
}

if(getId=='finish'){
  var startDate1 = localStorage.getItem('startDate1') ; 
  var endDate1   = localStorage.getItem('endDate1') ; 
  var startMin  = localStorage.getItem('startMin') ; 
  var endMin    = localStorage.getItem('endMin') ; 
  var dbStartDate = localStorage.getItem('dbStartDate') ; 
  var dbEndDate   =localStorage.getItem('dbEndDate') ; 
 
}
 
if(startDate1!=""){
      $('#startdate').text(localStorage.getItem('startDate1'));
  }
if(startMin!=""){
  $('#startMin').text(localStorage.getItem('startMin'));
}
if(endDate1!=""){
      $('#enddate').text(localStorage.getItem('endDate1'));
    }
if(endMin!=""){
  $('#endMin').text(localStorage.getItem('endMin'));
}

}






function update_bid_next() {
   
    var queryArr = [];
   $('input[name^="milestones"]').each(function()
    {   
        
        data = $(this).val();
        queryArr.push(data);
    });
   console.log(queryArr);
    var getId = $('.super-widget-tab input[type="radio"]:checked').last().parent().next().children('input').attr('id');
    var address = $('#getaddr').val();
    var jobtitle = $('#jobtitle').val();
    var desc  = $('#desc').val();
    var serv  = $('input:radio[name=serv]:checked').val();
    var pay  = $('input:radio[name=pay]:checked').val();
    var amount  = $('#amount').val();
    var bank  = $('input:radio[name=bank]:checked').val();
    var mapaddress = $('#pac-input').val();
    //var newaddress = $('#newaddress').val();
    var newaddress = '';
    if(!($("#sr_address_list").children("tbody").children("tr").children("td").hasClass("dataTables_empty"))){
      $("#sr_address_list").children("tbody").children("tr").each(function(i){
        adrs = $(this).children("td:nth-child(2)").html();
        newaddress += "<p>"+i+". "+adrs+"</p>";
      });
    }
    var recurringtype = localStorage.getItem('recurring');
    var lat=$('#lat').val();
    var lng=$('#lng').val();
    var ramount=$('#ramount').val();
    var service_id=$('#service_id').val();
    var bid_id=$('#bid_id').val();
    var milestones = queryArr;
    var cancelfee = $("#cancelfee").val();
    //var time = '10:15 AM';
    //var startdate = '10/10/2018';
    //var enddate = '11/10/2018';
    var pic_id = $('#pic_id').val();
    var schedule_note = $('#schedule_note').val();
    var address;
    //alert(schedule_note);


    if($('#description').length){
       $('#description').text(desc);
    }
    //alert($('#amnt').length);
    //alert(pay+", "+ amount+" $");

    //alert("startDate1" + localStorage.getItem('startDate1'));
    //alert("endDate1" + localStorage.getItem('endDate1'));  


    if($('#amnt').length){
      if(recurringtype == "One Time"){
        var newtext = recurringtype + ", "+pay+", $"+ amount;
      }else{
        var newtext = recurringtype + " ($"+ramount+"), Total ($"+amount+"), "+pay;
      }
      $('#amnt').text(newtext);
    }

    if(mapaddress!=""){
      $('#address').text(mapaddress);
      address = mapaddress;
    }

    if(newaddress!=""){
      $('#address').html(newaddress);
      address = newaddress;
    }
if(recurringtype!='One Time'){
  $('#recamnt').show();
  $('#recamnt label').html("Amount ("+recurringtype+")");
  $('.notes').show();
}

if(getId=='finish'){
  var startDate1 = localStorage.getItem('startDate1') ; 
  var endDate1   = localStorage.getItem('endDate1') ; 
  var startMin  = localStorage.getItem('startMin') ; 
  var endMin    = localStorage.getItem('endMin') ; 
  var dbStartDate = localStorage.getItem('dbStartDate') ; 
  var dbEndDate   =localStorage.getItem('dbEndDate') ; 
  var dbStartMin = localStorage.getItem('dbStartMin');
  var dbEndMin = localStorage.getItem('dbEndMin');
}
 
if(startDate1!=""){
      $('#startdate').text(localStorage.getItem('startDate1'));
  }
if(startMin!=""){
  $('#startMin').text(localStorage.getItem('startMin'));
}
if(endDate1!=""){
      $('#enddate').text(localStorage.getItem('endDate1'));
    }
if(endMin!=""){
  $('#endMin').text(localStorage.getItem('endMin'));
}


//alert("desc----"+desc);
//alert(address);
/*if($('#start-date').length){
  alert($('#start-date').val());
}*/
var bid_bool="";
var totalhours="";
var rateperhour="";
var is18=1;
var selected_provider="";
var buttonstatus='submit';
var provider_type="";
var time="";

var imgs=[];
  $('#sr_imgs input[type="hidden"]').each(function(){
  imgs[this.id]=this.value;
   alert(this.value);
   console.log('images');
  });

if(getId=='finish'){
  
  /*
  var tmp= {title : desc,
      descr : desc,
      summ : desc,
      bidDate : bid_bool,
      dateTimeBool: time,
      dateTimeFrom : dbStartDate,
      dateTimeTo : dbEndDate,
      set_schedule : recurringtype,
      schedule_note : schedule_note,
      schedule_amount : ramount,
      payAmt : amount,
      payType : pay,
      totalhours : totalhours,
      rateperhour : rateperhour,
      category : serv,
      is18 : is18,
      provider_type : provider_type,
      reqstedBidId : selected_provider,
      imgs : imgs,
      addr : address,
      buttonstatus : buttonstatus,
      current : "11",
      sr_number : "108",
      posLong:lng,
      posLat:lat};
      console.log(tmp);
  */

  $.post("update_bid_new.php",
    {
      title : jobtitle,
      descr : desc,
      summ : desc,
      bidDate : bid_bool,
      dateTimeBool: time,
      dateTimeFrom : dbStartDate,
      dateTimeTo : dbEndDate,
      timeFrom: dbStartMin,
      timeTo: dbEndMin,
      set_schedule : recurringtype,
      schedule_note : schedule_note,
      schedule_amount : ramount,
      payAmt : amount,
      payType : pay,
      totalhours : totalhours,
      rateperhour : rateperhour,
      category : serv,
      is18 : is18,
      cancelfee : cancelfee,
      provider_type : provider_type,
      reqstedBidId : selected_provider,
      imgs : imgs,
      addr : address,
      buttonstatus : buttonstatus,
      current : "11",
      sr_number : "108",
      service_id : service_id,
      bid_id : bid_id,
      milestones : queryArr,
      posLong:lng,
      posLat:lat
    },
    function(data,status){
      console.log("Data: " + data + "\nStatus: " + status);
    });

}

    

    $('.super-widget-tab input[type="radio"]:checked').last().parent().next().children('input').prop('checked', true);
    $('.super-widget-tab-info summary').hide();
    $('.'+getId).show();
    if($('#prev').css('visibility') == 'hidden' && $('.super-widget-tab input[type="radio"]:checked').length > 1) { 
        $('#prev').css('visibility', 'visible');
    } else if(($('.super-widget-tab input[type="radio"]').last().is(':checked'))) {
        $('#next').hide()
    }

   
    if(getId == "jobdetails")
    {
      jQuery('button#review_btn').show(); 
      $("button#next").html('Next'); 
    }
    else if(getId == "location")
    {
      jQuery('button#review_btn').show();  
      $("button#next").html('Next'); 
    }
    else if(getId == "payment")
    {
      jQuery('button#review_btn').show();  
      $("button#next").html('Next'); 
    }
    else if(getId == "review")
    {
      jQuery('button#review_btn').hide(); 
      $("button#next").html('Edit Bid'); 
    }else
    {
      jQuery('button#review_btn').hide(); 
      $("button#next").html('Next'); 
    }

    

    if(getId == "payment"){
      //alert('test: '+ localStorage.getItem('recurring'))
      payTypeSetting();
      $("#schedule_note").focus();
      $("#amount").focus();
      $("#cancelfee").focus();
      $("#personalnote").focus();
      if($("#recamnt").css("display") != 'none'){
        $("#ramount").focus();
      }
    }
}



function update_bid_prev() {
    var getId = $('.super-widget-tab input[type="radio"]:checked').last().parent().prev().children('input').attr('id');
    $('.super-widget-tab input[type="radio"]:checked').last().prop('checked', false);
    $('.super-widget-tab-info summary').hide();
    $('.'+getId).show();
    if($('.super-widget-tab input[type="radio"]:checked').length < 2) {
        $('#prev').css('visibility', 'hidden');
        $('#next').show();
    } 
    if(getId == "payment"){
      payTypeSetting();
      $("#schedule_note").focus();
      $("#amount").focus();
      $("#cancelfee").focus();
      $("#personalnote").focus();
      if($("#recamnt").css("display") != 'none'){
        $("#ramount").focus();
      }
    }

    if(getId == "jobdetails")
    {
      jQuery('button#review_btn').show(); 
      $("button#next").html('Next'); 
    }
    else if(getId == "location")
    {
      jQuery('button#review_btn').show();  
      $("button#next").html('Next'); 
    }
    else if(getId == "payment")
    {
      jQuery('button#review_btn').show();  
      $("button#next").html('Next'); 
    }
    else
    {
      jQuery('button#review_btn').hide(); 
    }

    if(getId == "review")
    {
      $("button#next").html('Edit Bid'); 
    }

}



function update_review() 
{
    
   $("button#next").html('Create Bid');
   jQuery('summary.location.WDTH90.MRGCenter').hide();
   jQuery('summary.jobdetails.WDTH90.MRGCenter').hide();
   jQuery('summary.payment.WDTH90.MRGCenter').hide();
   jQuery('summary.finish.WDTH90.MRGCenter').hide();
   jQuery('summary.review.WDTH90.MRGCenter').show();
   var getId = $('.super-widget-tab input[type="radio"]:checked').last().parent().next().children('input').attr('id');
   if(getId == 'payment')
    {
        

            var amount= parseFloat($("#amount").val());
            var payType = $('input[name=pay]:checked').val();
            var total= parseFloat($("#milestoneTotal").val());

            console.log(total + 'Total');
            var text="Milestone total amount must be equal to bid amount";
            if(!isNaN(total))
            {

               if(payType == 'fixed' || payType == 'hourly')
              {
                 if(total !== amount)
                 {
                    swal({
                      title: "Warning",
                       type: "warning",
                      text: text
                    });
                    jQuery('summary.location.WDTH90.MRGCenter').hide();
                    jQuery('summary.jobdetails.WDTH90.MRGCenter').hide();
                    jQuery('summary.payment.WDTH90.MRGCenter').show();
                    jQuery('summary.finish.WDTH90.MRGCenter').hide();
                    jQuery('summary.review.WDTH90.MRGCenter').hide();
                    $('#review').prop('checked', false);
                    return false;
                 }

              } 
            }
           
          

    }

   $('#payment').prop('checked', true);
   $('#review').prop('checked', true);
   $('#jobdetails').prop('checked', true);
   $('#location').prop('checked', true);
   
    var queryArr = [];
   $('input[name^="milestones"]').each(function()
    {   
        
        data = $(this).val();
        queryArr.push(data);
    });
   console.log(queryArr);
    
    var address = $('#getaddr').val();
    var jobtitle = $('#jobtitle').val();
    var desc  = $('#desc').val();
    var serv  = $('input:radio[name=serv]:checked').val();
    var pay  = $('input:radio[name=pay]:checked').val();
    var amount  = $('#amount').val();
    var bank  = $('input:radio[name=bank]:checked').val();
    var mapaddress = $('#pac-input').val();
    //var newaddress = $('#newaddress').val();
    var newaddress = '';
    if(!($("#sr_address_list").children("tbody").children("tr").children("td").hasClass("dataTables_empty"))){
      $("#sr_address_list").children("tbody").children("tr").each(function(i){
        adrs = $(this).children("td:nth-child(2)").html();
        newaddress += "<p>"+i+". "+adrs+"</p>";
      });
    }
    var recurringtype = localStorage.getItem('recurring');
    var lat=$('#lat').val();
    var lng=$('#lng').val();
    var ramount=$('#ramount').val();
    var service_id=$('#service_id').val();
    var milestones = queryArr;

    //var time = '10:15 AM';
    //var startdate = '10/10/2018';
    //var enddate = '11/10/2018';
    var pic_id = $('#pic_id').val();
    var schedule_note = $('#schedule_note').val();
    var address;
    //alert(schedule_note);


    if($('#description').length){
       $('#description').text(desc);
    }
    //alert($('#amnt').length);
    //alert(pay+", "+ amount+" $");

    //alert("startDate1" + localStorage.getItem('startDate1'));
    //alert("endDate1" + localStorage.getItem('endDate1'));  


    if($('#amnt').length){
      if(recurringtype == "One Time"){
        var newtext = recurringtype + ", "+pay+", $"+ amount;
      }else{
        var newtext = recurringtype + " ($"+ramount+"), Total ($"+amount+"), "+pay;
      }
      $('#amnt').text(newtext);
    }

    if(mapaddress!=""){
      $('#address').text(mapaddress);
      address = mapaddress;
    }

    if(newaddress!=""){
      $('#address').html(newaddress);
      address = newaddress;
    }
if(recurringtype!='One Time'){
  $('#recamnt').show();
  $('#recamnt label').html("Amount ("+recurringtype+")");
  $('.notes').show();
}

if(getId=='finish'){
  var startDate1 = localStorage.getItem('startDate1') ; 
  var endDate1   = localStorage.getItem('endDate1') ; 
  var startMin  = localStorage.getItem('startMin') ; 
  var endMin    = localStorage.getItem('endMin') ; 
  var dbStartDate = localStorage.getItem('dbStartDate') ; 
  var dbEndDate   =localStorage.getItem('dbEndDate') ; 
 
}
 
if(startDate1!=""){
      $('#startdate').text(localStorage.getItem('startDate1'));
  }
if(startMin!=""){
  $('#startMin').text(localStorage.getItem('startMin'));
}
if(endDate1!=""){
      $('#enddate').text(localStorage.getItem('endDate1'));
    }
if(endMin!=""){
  $('#endMin').text(localStorage.getItem('endMin'));
}

}


function getDetails(obj){
    //alert(obj);
    var seller = $("#seller").length;
    var requester1 = $("#requester1").length;

    if(seller>0 && requester1>0 ){
      //alert(requester1);
      if(obj=='seller'){
       //alert("inseller-"+obj);
           document.getElementById("requester1").style.display="none";
           document.getElementById("seller").style.display="block";

      }
      if(obj=='requester1'){
      // alert("inrequester1-"+obj);
       document.getElementById("requester1").style.display="block";
       document.getElementById("seller").style.display="none";
         
      }
    }
  localStorage.setItem('utype',obj) ; 
  return;
  }

function convertTo12Hour (time) {
  // Check correct time format and split into components
  time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

  if (time.length > 1) { // If time format correct
    time = time.slice (1);  // Remove full string match value
    time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
    time[0] = +time[0] % 12 || 12; // Adjust hours
  }
  return time.join (''); // return adjusted time or original string
}

function payTypeSetting(){

  recurringType = localStorage.getItem('recurring');
  noOfDays = localStorage.getItem('noofdays');

  //alert("tab change recurring: "+recurringType);
  switch (recurringType) {
    case 'One Time':
      $('#amount').prop('readonly', false);
      $('.ramount').css('display','none');
      $('#ramount').prop('readonly', true);
      break;
    case 'Weekly':
    case 'Twice Weekly':
    case 'Monthly':
    case 'Every other month':
      //alert("dsfsdF");
      $('#amount').prop('readonly', true);
      $('.ramount').css('display','block');
      $('#ramount').prop('readonly', false);
    break;
  }

}

$('input, textarea').focus(function(){
    $(this).parents('.form-group').addClass('focused');
  });
  
  $('input, textarea').blur(function(){
    //if($('#desc').length){
      //var inputValue = $('#desc').val();
      var inputValue = $(this).val();
      //alert(inputValue);
      if ( inputValue == "" ) {
        $(this).removeClass('filled');
        $(this).parents('.form-group').removeClass('focused');  
      } else {
        $(this).addClass('filled');
      }
    //}
  })  

  function addAddress(){
    $('#pac-input').val("");
    $('#addAddressDetails').show();
  }

  function _recurring(val) {
    //alert(val.target.value);
    switch (val.target.value) {
      case 'One Time':
        $('#amount').prop('readonly', false);
        $('#ramount').prop('readonly', true);
        break;
      case 'Weekly':
      case 'Twice Weekly':
      case 'Monthly':
      case 'Every other month':
        $('#amount').prop('readonly', true);
        $('#ramount').prop('readonly', false);
      break;
    }
  }

  function addSR(){
      window.location.href='create_new_service_request_new.php';
  }

    if(localStorage.getItem('recurring') == undefined){
      localStorage.setItem('recurring', "One Time");
    }
    $('#recurring').on('change', function(val) {
      // if(val.target.value !== 'One Time'){
      //   $('#amount').prop('readonly', true)
      //   $('#ramount').prop('readonly', false)
      // } else {
        
      //   $('#amount').prop('readonly', false)
      //   $('#ramount').prop('readonly', true)
      // }

      localStorage.setItem('recurring', val.target.value);
      console.log("localstorage value: "+localStorage.getItem('recurring'));
      _recurring(val);
          //alert(val.target.value);
          
      
    })

    function _getDateDiff(s, e) {
      var sDate = new Date(s);
      var eDate =new Date(e);
      var dt = Math.abs(eDate.getTime() - sDate.getTime());
      var dd = Math.ceil(dt/(1000*60*60*24));
      return dd;
    }

    $('#ramount').on('blur', function(val) {

      console.log("localStorage Start Date : " + localStorage.getItem('startDate'));
      console.log("localStorage End Date : " + localStorage.getItem('endDate'));
      
      //var difDate = _getDateDiff(localStorage.getItem('startDate'), localStorage.getItem('endDate'))
      var difDate = localStorage.getItem('noofdays');
      var rval = localStorage.getItem('recurring');
      //alert(difDate);
      //alert(rval);
      console.log("Dif Date : "+difDate);
      console.log("localstorage noofdays : "+localStorage.getItem('noofdays'));
      if(rval === 'Weekly') {
        var math = Math.floor(difDate/7)
        var amnt = math*val.target.value;
      }else if(rval === 'Twice Monthly') {
        var math = Math.floor(difDate/14)
        var amnt = math*val.target.value;
      }else if(rval === 'Monthly') {
        var math = Math.floor(difDate/30)
        var amnt = math*val.target.value;
      }else if(rval === 'Every other month') {
        var math = Math.floor(difDate/60)
        var amnt = math*val.target.value;
      } 
      console.log("Total Amount : "+amnt);
      $('#amount').val(amnt);
      $('#amount').focus();

    })
    $('.actHourly').hide();

    $('#hourly, #fixed, #fairMarket').on('click', function() {
      if($('#hourly').is(':checked')) {
        $('.actHourly').show();
        $('#amount, .amount').show().prop('readonly', true);
        $('.ramount').hide();
        $('#schedule_note').hide();
      }else if($('#fixed').is(':checked')) {
        $('.amount').show();
        $('.actHourly').hide();
        // $('#ramount').prop('readonly', true);
        //alert(localStorage.getItem('recurring'));
        if(localStorage.getItem('recurring') != 'One Time'){
          $('.ramount').show();
          $('#ramount').prop('readonly', false);
          $('#amount').prop('readonly', true);
          $('#schedule_note').show();
        }else{
          $('#amount').prop('readonly', false);
          $('#schedule_note').hide();
        }

      }else if($('#fairMarket').is(':checked')) {
        $('.amount, .actHourly').hide();
        $('.ramount').hide();
        $('#ramount').prop('readonly', false);
        $('#schedule_note').hide();
      }
    })

    $('#rateHour, #tHour').keyup(function(){
      var amt = $('#rateHour').val() * $('#tHour').val();
      $('#amount').val(amt)
    })

   function getUserDetails(obj,srid,type) {
           
      if(obj==0 && type=='stl'){
        //alert("test");
          $('#three').html("No bids shortlised yet!");
        return;
      }
      if(obj==0 && type=='bids'){
        //alert("test");
          $('#two').html("No bids received!");
        return;
      }
      if(obj==0 && type=='agrm'){
        //alert("test");
          $('#four').html("No records found");
        return;
      }
      //alert(obj);
      //var currentUrl = window.location.href + "&srid="+obj;
      //location.href=currentUrl;        
        $.post("get_details.php",
        {
          srid : srid,
          ownerid:obj,
          service:"bids"
        },
        function(data,status){
         // alert("Data: " + data + "\nStatus: " + status);
          var jsonData = JSON.parse(data);   
          var hrlypay; 
          var fixedpay;

          if(jsonData.paytype=='hourly'){
            hrlypay = jsonData.payAmt;
          }
          if(jsonData.paytype=='fixed'){
            fixedpay = jsonData.payAmt;
          }

          $('#bid_comment_stl').html(jsonData.descr);
          $('#bid_comment').html(jsonData.descr);
          $('#bid_comment_agrm').html(jsonData.descr);
          $('#bid_amnt').html(jsonData.paytype+", $"+jsonData.payAmt);
          $('#bid_amnt_stl').html(jsonData.paytype+", $"+jsonData.payAmt);
          $('#bid_amnt_agrm').html(jsonData.paytype+", $"+jsonData.payAmt);
          $('#bid_duration').html(jsonData.dtFrm+" "+jsonData.timeFrm+" - "+ jsonData.dtTo+" "+jsonData.timeTo);
          $('#bid_duration_stl').html(jsonData.dtFrm+" "+jsonData.timeFrm+" - "+ jsonData.dtTo+" "+jsonData.timeTo);
          $('#bid_duration_agrm').html(jsonData.dtFrm+" "+jsonData.timeFrm+" - "+ jsonData.dtTo+" "+jsonData.timeTo);
          $('#full_name_stl').text(jsonData.firstName+" "+jsonData.midName);
          $('#full_name_stl1').text(jsonData.firstName+" "+jsonData.midName);
          $('#full_name_agrm').text(jsonData.firstName+" "+jsonData.midName);
          $('#full_name_agrm1').text(jsonData.firstName+" "+jsonData.midName);
          $('#full_name').text(jsonData.firstName+" "+jsonData.midName);
          $('#full_name1').text(jsonData.firstName+" "+jsonData.midName);
          $('#catg_stl').text(jsonData.name);
          $('#catg_stl1').text(jsonData.name);
          $('#catg_agrm').text(jsonData.name);
          $('#catg_agrm1').text(jsonData.name);
          $('#catg').text(jsonData.name);
          $('#catg1').text(jsonData.name);
          $('#uname').text(jsonData.username);
          $('#uname_stl').text(jsonData.username);
          $('#uname_agrm').text(jsonData.username);
          $('#bidscnt').text("1");
          $('#avgfixcostamnt').text(fixedpay);
          $('#avghrlycostamnt').text(hrlypay);
          $('#agreedesc').text(jsonData.desc);
          $('#starr').text(jsonData.bluestar_Percentage);
          $('#starr_stl').text(jsonData.bluestar_Percentage);
          $('#starr_agrm').text(jsonData.bluestar_Percentage);
          $('#diamndr').html(jsonData.diamondrtng);
          $('#diamndr1').html(jsonData.diamondrtng);
          $('#diamndr2').html(jsonData.diamondrtng);
          $('#diamndr_stl').html(jsonData.diamondrtng);
          $('#diamndr1_stl').html(jsonData.diamondrtng);
          $('#diamndr2_stl').html(jsonData.diamondrtng);
          $('#diamndr_agrm').html(jsonData.diamondrtng);
          $('#diamndr1_agrm').html(jsonData.diamondrtng);
          $('#diamndr2_agrm').html(jsonData.diamondrtng);
          $('#bluestrdetails_stl').html(jsonData.bluedetls);
          $('#bluestrdetails').html(jsonData.bluedetls);
          $('#bluestrdetails_agrm').html(jsonData.bluedetls);
          $('#slvrstrdetails').html(jsonData.silverdetls);
          $('#slvrstrdetails_stl').html(jsonData.silverdetls);
          $('#slvrstrdetails_agrm').html(jsonData.silverdetls);
          $('#goldstarresp_stl').html(jsonData.goldstarresp);
          $('#goldstarresp').html(jsonData.goldstarresp);
          $('#goldstarresp_agrm').html(jsonData.goldstarresp);
          $('#hire').attr("data-bidid",jsonData.id);
          $('#hire_stl').attr("data-bidid",jsonData.id);
          $('#shortlist').attr("data-bidid",jsonData.id);

          $('#accept_agreement_btn').attr('data-bidid',jsonData.id);
          $('#accept_agreement_btn').attr('data-userid',jsonData.ownerId);

          $('#request_pay').attr('data-bidamount',jsonData.payAmt);
          $('#request_pay').attr('data-paidamt',jsonData.paid_amnt);

          $('#approve_pay').attr('data-bidid',jsonData.id);
          $('#approve_pay').attr('data-amount',jsonData.request_amnt);
          $('#approve_pay').attr('data-amounttype',jsonData.amnt_type);
          $('#approve_pay').attr('data-actualamount',jsonData.payAmt);
          $('#approve_pay').attr('data-paidamt',jsonData.paid_amnt);

          $('#make_pay').attr('data-bidamount',jsonData.payAmt);
          $('#make_pay').attr('data-paidamt',jsonData.paid_amnt);

          $('#bid_address_agrm').html(jsonData.address);

          $('#bid_milestone_agrm').html(jsonData.milestones);

          if(jsonData.shortlist == "yes"){
            $("#shortlist").hide();
          }
          if(jsonData.loggedin_user_id != jsonData.srOwnerId){
            $('#hire').hide();
            $('#hire_stl').hide();
            $('#shortlist').hide();
          }

          $('#request_pay').hide();
          $('#make_pay').hide();
          $('#approve_pay').hide();
          $('#accept_agreement_btn').hide();

          if(jsonData.loggedin_user_id == jsonData.ownerId || jsonData.loggedin_user_id == jsonData.srOwnerId){
             
            switch(jsonData.status){
              case 'submitted':
              case 'job completed':
                  break;
              case 'awarded':
                  if(jsonData.loggedin_user_id == jsonData.ownerId){
                    $('#accept_agreement_btn').show();
                  }
                  break;
              case 'request for payment':
                  if(jsonData.loggedin_user_id == jsonData.srOwnerId){
                      $('#approve_pay').show();
                  }
                  break;
              case 'approved payment':
              case 'payment rejected':
                if(jsonData.loggedin_user_id == jsonData.ownerId){
                      $('#request_pay').show();
                }else if(jsonData.loggedin_user_id == jsonData.srOwnerId){
                      $('#make_pay').show();
                }
              break;
              case 'in work':
                if(jsonData.loggedin_user_id == jsonData.ownerId){
                      $('#request_pay').show();
                }else if(jsonData.loggedin_user_id == jsonData.srOwnerId){
                      $('#make_pay').show();
                }
              break;  
            }
          }
          /*if(jsonData.loggedin_user_id == jsonData.ownerId || jsonData.loggedin_user_id == jsonData.srOwnerId){
            $('edit_agreement').show();
          }else{
            $('edit_agreement').hide();
          }*/

          console.log("getUserDetails: ");
          console.log(jsonData);
        });
  }          
      

    
    let noA = 1, countA = 1, cardLnthA;
    let noB = 1, countB = 1, cardLnthB;
    let noC = 1, countC = 1, cardLnthC;

    function prevPagerA(id, cls) {
      cardLnthA = Math.ceil($('.'+cls+' .card').length/6);
      if(cardLnthA > countA) {
        --noA;
        countA = noA;
        if(countA == 1) {
          $('#'+id+' li:eq(0)').addClass('disabled');
          $('#'+id+' li:eq(1)').removeClass('disabled');
        }
        _initCard(countA, cls) 
      }
    }

    function nextPageA(id, cls) {
      cardLnthA = Math.ceil($('.'+cls+' .card').length/6);
      if(cardLnthA > countA) {
        noA++;
        countA = noA;
        if(cardLnthA == countA) {
          $('#'+id+' li:eq(1)').addClass('disabled');
        }
        else {
          $('#'+id+' li:eq(0)').removeClass('disabled');
        }
        _initCard(countA, cls) 
      }
    }

    function prevPagerB(id, cls) {
      cardLnthB = Math.ceil($('.'+cls+' .card').length/6);
      if(cardLnthB > countB) {
        --noB;
        countB = noB;
        if(countB == 1) {
          $('#'+id+' li:eq(0)').addClass('disabled');
          $('#'+id+' li:eq(1)').removeClass('disabled');
        }
        _initCard(countB, cls) 
      }
    }

    function nextPageB(id, cls) {
      cardLnthB = Math.ceil($('.'+cls+' .card').length/6);
      if(cardLnthB > countB) {
        noB++;
        countB = noB;
        if(cardLnthB == countB) {
          $('#'+id+' li:eq(1)').addClass('disabled');
        }
        else {
          $('#'+id+' li:eq(0)').removeClass('disabled');
        }
        _initCard(countB, cls) 
      }
    }

    function prevPagerC(id, cls) {
      cardLnthC = Math.ceil($('.'+cls+' .card').length/6);
      if(cardLnthC > countC) {
        --noC;
        countC = noC;
        if(countC == 1) {
          $('#'+id+' li:eq(0)').addClass('disabled');
          $('#'+id+' li:eq(1)').removeClass('disabled');
        }
        _initCard(countC, cls) 
      }
    }

    function nextPageC(id, cls) {
      cardLnthC = Math.ceil($('.'+cls+' .card').length/6);
      if(cardLnthC > countC) {
        noC++;
        countC = noC;
        if(cardLnthC == countC) {
          $('#'+id+' li:eq(1)').addClass('disabled');
        }
        else {
          $('#'+id+' li:eq(0)').removeClass('disabled');
        }
        _initCard(countC, cls) 
      }
    }

    function _initCard(pageNo, block) {
      var i = null, noOfRec = pageNo * 6, start = 6 * (pageNo-1), eleIndex;
      i = start;
      $('.'+block+' .card').hide();
      while (i < noOfRec) {
        eleIndex = $('.'+block+' .card').eq(i);
        (eleIndex.length != 0)? eleIndex.show() : '';        
        i++;
      }
    }

   

    

function shortlist(elm) {
      var bidid = ($(elm).data('bidid'));
      $.post("addshortlist_new.php",
        {
          bidid : bidid
        },
        function(data,status){
         
         //alert("Data: " + data + "\nStatus: " + status);
         if(status=="success"){
            swal({
                title: "Success",
                text: "Bid shortlisted successfully",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#5CB85C",
                confirmButtonText: "OK",
                closeOnConfirm: true
              },
              function(){
                //location.href = "service_request_saved_list.php";
              });
             //console.log(jsonData);
         }
      });
    }      

function hire(elm, serv_id) {


      var bid_id = ($(elm).data('bidid'));

      $.get("bid_award.php",
        {
          bidId : bid_id,
          srId:serv_id
        },
        function(data,status){
         
         //alert("Data: " + data + "\nStatus: " + status);
         var obj= JSON.parse(data);
         //if(status=="success"){
            swal({
                title: "Status",
                text: obj.msg,
                //type: "success",
                showCancelButton: false,
                confirmButtonColor: "#5CB85C",
                confirmButtonText: "OK",
                closeOnConfirm: true
              },
              function(){
                location.href = "view_service_details.php?id="+serv_id;
              });
             //console.log(jsonData);
         //}
      });
    }      
      
$(document).ready(function() {

    _initCard(1, 'jobRequests');
    _initCard(1, 'recommended');
    _initCard(1, 'jobRequests2');



    $("#timeselect").on("change", function(){
      var time_v = $(this).val();
      if(time_v == "4"){
        $(".showtime").show();
      }else
      {
        $(".showtime").hide(); 
        if(time_v == "0"){
          $("#time_from_value").val("09:00AM");
          $("#time_to_value").val("09:00PM");
        }
        if(time_v == "1")
        {
            $("#time_from_value").val("07:00AM");
            $("#time_to_value").val("12:00PM");
        }
        else if(time_v == "2")
        {
            $("#time_from_value").val("12:00PM");
            $("#time_to_value").val("05:00PM");
        }
        else if(time_v == "3")
        {
            $("#time_from_value").val("05:00PM");
            $("#time_to_value").val("10:00PM");
        }
      }
    })
 

$(document).on("click", ".requestpaypopup", function(e) {

    //var bidamount = parseInt($("#bidamount").val());
    var bidamount = ($(this).data('bidamount'));
    //var paidamt = <?php echo $paidamt; ?>;
    var paidamt = ($(this).data('paidamt'));
    var remain = bidamount - parseInt(paidamt);
    $(".dyn_content").html("Request Pay - Received Amount $"+paidamt+" (Remaining Balance $"+remain+")");
    $('#modal_request_pay').modal('show');


});

    
$(document).on("click", ".gen_inv", function(e) {

   var owner_id =($(this).data('ownerid'));
   var sr_id =($(this).data('srid'));
   var formData1 = {
                'owner_id'     : owner_id,
                'sr_id'     : sr_id
                
            }
    
      
            var feedback1 = $.ajax({
                type: "POST",
                url: "gen_invoice.php",
                data: formData1,         
                async: false,
                
            }).complete(function(){
                        
            }).responseText;

            //alert(feedback1);
            if(feedback1 != ""){            
              swal("Invoice generated successfully");

              $("#view_inv").html('<i class="fa fa-money"></i><a href="'+feedback1+'" target="blank">View invoice</a>');
              $("#send_inv").attr('data-invid',feedback1);
              $("#gen_inv").css("display","none");
              $("#view_inv").css("display","block");
              $("#send_inv").css("display","block");
          }
   //alert(id);
});

$(document).on("click", ".send_inv", function(e) {
  
  var inv =($(this).data('invid'));
  var srid =($(this).data('srid'));
  var userid =($(this).data('ownerid'));
  var frmdata = {
                'inv': inv,
                'srid': srid,
                'userid':userid
                
            };
  var feedback2 = $.ajax({
                type: "POST",
                url: "inv_pusher.php",
                data: frmdata,         
                async: true,
                
            }).complete(function(){
                        
            }).responseText;
  
  //alert(feedback2);

});




$(document).on("click", ".approveclick", function(e) {
    var id =($(this).data('bidid'));
    var bidamount =($(this).data('amount'));
    var amounttype =($(this).data('amounttype'));
    var actualamount =($(this).data('actualamount'));
    var paidamt =($(this).data('paidamt')); 
    var from =($(this).data('from')); 
       
   $('#approve_payment').find("#bidid").val(id);
   $('#approve_payment').find("#bidamount").val(actualamount); 
   $('#approve_payment').find("#paidamt").val(paidamt); 
   $('#request_payment').find("#bidid").val(id);
   $('#request_payment').find("#bidamount").val(actualamount); 
   $('#request_payment').find("#paidamt").val(paidamt); 
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

    $('#modal_approve_pay').modal('show');

});
$(document).on("change", "#amount_type", function(e) {

    if($(this).val() == "2")
    $(".showamount").show();
    else {
        $(".showamount").hide();
    }

});

$(document).on("change", "#status_type", function(e) {

    if($(this).val() == "1")
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
        
            
            var amount_type = $('#request_payment').find('#amount_type').val();
            var amount = $('#request_payment').find('#amount').val();
            var bidid = $('#request_payment').find("#bidid").val();
            var bidamount = parseInt($('#request_payment').find("#bidamount").val());
            var paidamt = $('#request_payment').find("#paidamt").val();

            ///if amount type is full then save bid amount otherwise get entered amount
            if($('#request_payment').find('#amount_type').val() == "1")
                var amount = parseInt(bidamount);
            else
                var amount = parseInt($('#request_payment').find('#amount').val());

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
                'userid' : $('#userid_session1').val()
            }
    
      
            var feedback = $.ajax({
                type: "POST",
                url: "service_request_payment.php",
                data: formData,         
                async: true,
                
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
                      //window.location.href="main.php";
                }
                );
              
            
            }
  
            
            
    
     });
$('#approve_payment').formValidation({
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
        
            
            var amount_type = $('#approve_payment').find('#amount_type').val();
            var status_type = $('#approve_payment').find('#status_type').val();
            var bidid = $('#approve_payment').find("#bidid").val();
            var notes = $('#approve_payment').find("#notes").val();  
            var bidamount = parseInt($('#approve_payment').find("#bidamount").val()); 
            var paidamt = $('#approve_payment').find("#paidamt").val();
            var userid = $('#approve_payment').find("#userid").val();

           /*alert($('#approve_payment').find('#status_type').val());
           alert($('#approve_payment').find('#amount_type').val());*/
            ///if status type is approved only check amount condition
            if($('#approve_payment').find('#status_type').val() == "1")
            {
            ///if amount type is full then save bid amount
            if($('#approve_payment').find('#amount_type').val() == "1")
                var amount = parseInt(bidamount);
            else
                var amount = parseInt($('#approve_payment').find('#amount').val());

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
                'userid' : userid
            }
    
            
            /*$('#stripe_amnt_cents').val(amount*100);
            $('#stripe_db_data').val(JSON.stringify(formData));
            $('#stripe_db_script').val('service_approve_payment.php');*/

            var stripeData = {
              'stripe_amnt_cents' : (amount*100),
              'stripe_db_data' : JSON.stringify(formData),
              'stripe_db_script' : 'service_approve_payment.php',
              'bidid' : bidid
            }

            var stripeForm = $.ajax({
                type: "POST",
                url: "stripe_checkout.php",
                data: stripeData,         
                async: false,
                
            }).complete(function(data){
              
            
            }).responseText;

            $("#stripe_pay").css("display","block");
            $("#stripe_pay").html(stripeForm);

            /*var feedback = $.ajax({
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
                      //window.location.href="main.php";
                }
                );

            
            }*/
  
            
            
    
     });
/*

$('#approve_payment').formValidation({
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
                'userid' : $('#userid_session').val()
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
                       $('#modal_approve_pay').modal('hide');
                      //window.location.href="main.php";
                }
                );

            
            }
  
            
            
    
     });*/
  

    $(document).on("click", ".changeinwork", function(e) {
  var status=$(this).data('status');

  var formData = {
            
            'status'     : '16',
            'bidid' : ($(this).data('bidid')),
            'userid' : ($(this).data('userid'))
      }
  
    
      var feedback = $.ajax({
          type: "POST",
          url: "changestatus.php",
            data: formData,       
            async: false,
          
        }).complete(function(){
        
        
        }).responseText;
      
  console.log(feedback);
            if(feedback == "success"){            
           
              swal({
                    type : "success",
                    title: "Success",
                    text: "Accepted service request successfully!"
                                },
                function(){
                               localStorage.setItem("pushfrom","award");
                                //window.location.href="main.php";
                                location.reload();
                }
                );
            
           
            
            }


});


/*$(document).on("click", ".videoclick", function(e) {
    var from =($(this).data('from'));
    var user =($(this).data('user'));
    var sr_id = ($(this).data('srid'));
    var status = ($(this).data('status'));
    var bidstatus = ($(this).data('bidstatus'));
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
                           
                             //window.open("messaging_specific.php?sr_id="+sr_id);
                    }
            
          }
                        }); 

    });*/

 });