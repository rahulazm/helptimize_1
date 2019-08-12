<?php
session_start();
$configs = require_once("/etc/helptimize/conf.php");

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

// Stripe library
require_once 'stripe/Stripe.php';


//$transAmnt ="10.88"; //Pass this ACTUAL AMOUNT

$transAmnt = $_POST['stripe_amnt_cents'];
//$amount_cents = str_replace(".","",$transAmnt);
$amount_cents = $transAmnt;




?>
<script src="js/jquery-3.2.1.min.js"></script>

<div align="center" id="calcFee">
  <form action="" method="POST" id="frmCheckout">
   <!--  <input type="hidden" id="stripe_amnt_cents" />
    <input type="hidden" id="stripe_db_data" />
    <input type="hidden" id="stripe_db_script" /> -->
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="<?php echo $configs['public_test_key'];?>"
    data-amount="<?php echo $amount_cents;?>"
    data-name="Helptimize"
    data-description="Service"
    data-image="img/helptimizeapp_logo_small.png"
    data-locale="auto"
	data-email="customeremail@emailsss.com"
	data-allow-remember-me="false"
    data-zip-code="false">
  </script>
</form>
</div>
<script src="js/bootstrap.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script type="text/javascript">
  
   //hang on event of form with id=myform

$('#frmCheckout').get(0).submit = function() {

        var transAmnt=<?php echo $amount_cents;?>;
        //var transAmnt = $('#stripe_amnt_cents').val();
        var invoiceid="2055";
        var description="safwsfsfsf";

        /*console.log("stripe_amnt_cents: "+$("#stripe_amnt_cents").val());
        console.log("stripe_db_data: "+$("#stripe_db_data").val());
        console.log("stripe_db_script: "+$("#stripe_db_script").val());*/
        //var stripeToken = "<?php //echo $_POST['stripeToken'];?>";
        //do your own request an handle the results
        $.post("stripe_process.php",
        {
          transAmnt : transAmnt,
          invoiceid:invoiceid,
          description:description,
          source:'tok_visa',
          bidid: '<?php echo $_POST["bidid"];?>'
          //stripeToken:stripeToken
        },
        function(data,status){
         
         console.log("Data: " + data + "\nStatus: " + status);

         //formData = JSON.parse($('#stripe_db_data').val());
         //pageurl = $('#stripe_db_script').val();
         formData = JSON.parse('<?php echo $_POST['stripe_db_data']; ?>');
         pageurl = '<?php echo $_POST['stripe_db_script']; ?>';
         console.log(formData);
         console.log(pageurl);

         var feedback = $.ajax({
                type: "POST",
                url: pageurl,
                data: formData,         
                async: false,
                
            });
         console.log(feedback);
         if(feedback.responseText=="success"){
            swal({
                title: "Success",
                text: "Payment done successfully",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#5CB85C",
                confirmButtonText: "OK",
                closeOnConfirm: true
              },
              function(){
                //location.href = "service_request_saved_list.php";
                $('#modal_approve_pay').modal('hide');
              });
             //console.log(jsonData);
         }
      });
   }
    
</script>

<!--
data-label="Proceed to Pay with Card"

-->


