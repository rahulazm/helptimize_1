
function next() {
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
}

$('input').focus(function(){
    $(this).parents('.form-group').addClass('focused');
  });
  
  $('input').blur(function(){
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