
function next() {
  $('#amount, #ramount').val('')
    var getId = $('.super-widget-tab input[type="radio"]:checked').last().parent().next().children('input').attr('id');
     var address = $('#getaddr').val();
    var desc  = $('#desc').val();
    var serv  = $('input:radio[name=serv]:checked').val();
    var pay  = $('input:radio[name=pay]:checked').val();
    var first  = $('#first').val();
    var bank  = $('input:radio[name=bank]:checked').val();
    var mapaddress = $('#pac-input').val();
    var newaddress = $('#newaddress').val();
    var recurringtype = $('#recurring').find(":selected").text();
    var lat=$('#lat').val();
    var lng=$('#lng').val();

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
    if($('#amnt').length){
      var newtext = pay+", "+ first+" $";
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

var startDate = $.session.get('startDate') ; 
var endDate = $.session.get('endDate') ; 
var startMin = $.session.get('startMin') ; 
var endMin = $.session.get('endMin') ; 
var dbStartDate = $.session.get('dbStartDate') ; 
var dbEndDate = $.session.get('dbEndDate') ; 

//alert(startDate);   


if(startDate!=""){
      $('#startdate').text(startDate);
    }
if(startMin!=""){
  $('#startMin').text(startMin);
}
if(endDate!=""){
      $('#enddate').text(endDate);
    }
if(endMin!=""){
  $('#endMin').text(endMin);
}

//alert(lat+"----"+lng);
//alert(address);
//alert("Start date--" + startDate);
//alert("endDate date--" + endDate);
//alert("startMin---"+startMin);
//alert("endMin--"+endMin);
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
      schedule_amount : first,
      payAmt : first,
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
      alert("Data: " + data + "\nStatus: " + status);
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

function payTypeSetting(){

  recurringType = localStorage.getItem('recurring');
  noOfDays = localStorage.getItem('noofdays');
alert("tab change recurring: "+recurringType);
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
    alert("dsfsdF");
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
    var inputValue = $(this).val();
    if ( inputValue == "" ) {
      $(this).removeClass('filled');
      $(this).parents('.form-group').removeClass('focused');  
    } else {
      $(this).addClass('filled');
    }
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
      localStorage.removeItem('recurring');
      localStorage.setItem('recurring', val.target.value);
      alert("Session value: "+localStorage.getItem('recurring'));
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
alert(difDate);
alert(rval);
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
        alert(localStorage.getItem('recurring'));
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