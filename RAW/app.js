localStorage.removeItem('recurring');

function next() {
  //$('#amount, #ramount').val('')
    var getId = $('.super-widget-tab input[type="radio"]:checked').last().parent().next().children('input').attr('id');
      var address = $('#getaddr').val();
    var desc  = $('#desc').val();
    var serv  = $('input:radio[name=serv]:checked').val();
    var pay  = $('input:radio[name=pay]:checked').val();
    var amount  = $('#amount').val();
    var bank  = $('input:radio[name=bank]:checked').val();
    var mapaddress = $('#pac-input').val();
    var newaddress = $('#newaddress').val();
    var recurringtype = localStorage.getItem('recurring');
    var lat=$('#lat').val();
    var lng=$('#lng').val();
    var ramount=$('#ramount').val();

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
      var newtext = pay+", "+ amount+" $";
      $('#amnt').text(newtext);
    }

    if(mapaddress!=""){
      $('#address').text(mapaddress);
      address = mapaddress;
    }

    if(newaddress!=""){
      $('#address').text(newaddress);
      address = newaddress;
    }
if(recurringtype!='One Time'){
  $('#recamnt').show();
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
      title : desc,
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
      posLat:lat
    },
    function(data,status){
      //alert("Data: " + data + "\nStatus: " + status);
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
      //alert("Session value: "+localStorage.getItem('recurring'));
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

      var difDate = _getDateDiff(localStorage.getItem('startDate'), localStorage.getItem('endDate'))
      var rval = localStorage.getItem('recurring');
      //alert(difDate);
      //alert(rval);
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
      $('#amount').val(amnt);
      $('#amount').focus();

    })
    $('.actHourly').hide();

    $('#hourly, #fixed, #fairMarket').on('click', function() {
      if($('#hourly').is(':checked')) {
        $('.actHourly').show();
        $('#amount, .amount').show().prop('readonly', true);
        $('.ramount').hide();
      }else if($('#fixed').is(':checked')) {
        $('.amount').show();
        $('.actHourly').hide();
        // $('#ramount').prop('readonly', true);
        //alert(localStorage.getItem('recurring'));
        if(localStorage.getItem('recurring') != 'One Time'){
          $('.ramount').show();
          $('#ramount').prop('readonly', false);
          $('#amount').prop('readonly', true);
        }else{
          $('#amount').prop('readonly', false);
        }

      }else if($('#fairMarket').is(':checked')) {
        $('.amount, .actHourly').hide();
        $('.ramount').hide();
        $('#ramount').prop('readonly', false);
      }
    })

    $('#rateHour, #tHour').keyup(function(){
      var amt = $('#rateHour').val() * $('#tHour').val();
      $('#amount').val(amt)
    })

   function getUserDetails(obj,srid) {
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

          $('#bid_comment').val(jsonData.summ);
          $('#bid_amnt').val(jsonData.payAmt);
          $('#bid_duration').val(jsonData.dtFrm+" "+jsonData.timeFrm+" - "+ jsonData.dtTo+" "+jsonData.timeTo);
          $('#full_name').text(jsonData.firstName+" "+jsonData.midName);
          $('#full_name1').text(jsonData.firstName+" "+jsonData.midName);
          $('#catg').text(jsonData.name);
          $('#catg1').text(jsonData.name);
          $('#uname').text(jsonData.username);
          $('#bidscnt').text("1");
          $('#avgfixcostamnt').text(fixedpay);
          $('#avghrlycostamnt').text(hrlypay);
          $('#agreedesc').text(jsonData.desc);
          $('#starr').text(jsonData.bluestar_Percentage);
          $('#diamndr').html(jsonData.diamondrtng);
          $('#diamndr1').html(jsonData.diamondrtng);
          $('#diamndr2').html(jsonData.diamondrtng);
          $('#bluestrdetails').html(jsonData.bluedetls);
          $('#goldstarresp').html(jsonData.goldstarresp);
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

   

  $(document).ready(function() {

    _initCard(1, 'jobRequests');
    _initCard(1, 'recommended');
    _initCard(1, 'jobRequests2');
  });

      

function shortlist(id) {
      var bidid = id;
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

function hire(bid_id,serv_id) {


      //var bidid = id;
      $.get("bid_award_new.php",
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
                //location.href = "service_request_saved_list.php";
              });
             //console.log(jsonData);
         //}
      });
    }      
      

    