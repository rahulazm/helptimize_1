<?php
session_start();
$configs = require_once("/etc/helptimize/conf.php");
// Stripe library
require_once 'stripe/Stripe.php';


$transAmnt ="10.88"; //Pass this ACTUAL AMOUNT
$amount_cents = str_replace(".","",$transAmnt);
?>
<script src="js/jquery-3.2.1.min.js"></script>

<div align="center" id="calcFee">
  <form action="" method="POST" id="frmCheckout">
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="<?php echo $params['public_test_key']; ?>"
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script type="text/javascript">
  
   //hang on event of form with id=myform
    $('#frmCheckout').get(0).submit = function() {

        var transAmnt=<?php echo $amount_cents;?>;
        var invoiceid="2055";
        var description="safwsfsfsf";
        //var stripeToken = "<?php echo $_POST['stripeToken'];?>";
        //do your own request an handle the results
        $.post("stripe_process.php",
        {
          transAmnt : transAmnt,
          invoiceid:invoiceid,
          description:description,
          source:'tok_visa'
          //stripeToken:stripeToken
        },
        function(data,status){
         
         //alert("Data: " + data + "\nStatus: " + status);
         if(status=="success"){
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
              });
             //console.log(jsonData);
         }
      });
   }
</script>

<!--
data-label="Proceed to Pay with Card"

-->

