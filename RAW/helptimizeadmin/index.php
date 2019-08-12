<?php
session_start();


$language = $_GET['language'];

if($language =="en" or $language =="" ){
 	$_SESSION["language"] = "en";
    include 'en.lang.inc.php';

}

if($language =="de"){
	$_SESSION["language"] = "de";
	include 'de.lang.inc.php';
}


?>


<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

  <head>  	
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
	<meta name="description" content="helptimizehelptimize "/>
	<meta name="author" content="helptimize"/>
    <link rel="shortcut icon" href="favicon.png"> 
    
<script
  src="https://code.jquery.com/jquery-1.12.4.min.js"
  integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
  crossorigin="anonymous"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- FormValidation CSS file -->
<link rel="stylesheet" href="css/formValidation.min.css">

<link rel="stylesheet" type="text/css" href="css/sweetalert.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-switch.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="js/bootstrap-switch.min.js"></script>

<!-- FormValidation plugin and the class supports validating Bootstrap form -->
<script src="js/formValidation.min.js"></script>
<script src="js/framework/bootstrap.min.js"></script>
<script src="js/sweetalert.min.js"></script>

<script src="https://use.fontawesome.com/ad58aaa527.js"></script>
     
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="mobile-web-app-capable" content="yes">
     
 <link rel="apple-touch-icon-precomposed" sizes="57x57" href="apple-touch-icon-57x57.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="apple-touch-icon-114x114.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="apple-touch-icon-144x144.png" />
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="apple-touch-icon-60x60.png" />
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="apple-touch-icon-120x120.png" />
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="apple-touch-icon-76x76.png" />
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="apple-touch-icon-152x152.png" />
<link rel="icon" type="image/png" href="favicon-196x196.png" sizes="196x196" />
<link rel="icon" type="image/png" href="favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
<link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />
<link rel="icon" type="image/png" href="favicon-128.png" sizes="128x128" />
<meta name="application-name" content="&nbsp;"/>
<meta name="msapplication-TileColor" content="#FFFFFF" />
<meta name="msapplication-TileImage" content="mstile-144x144.png" />
<meta name="msapplication-square70x70logo" content="mstile-70x70.png" />
<meta name="msapplication-square150x150logo" content="mstile-150x150.png" />
<meta name="msapplication-wide310x150logo" content="mstile-310x150.png" />
<meta name="msapplication-square310x310logo" content="mstile-310x310.png" />

    


    <!-- Custom styles for this template -->
    <link href="css/login-theme-1.css" rel="stylesheet">
    
  
    

   
  </head>
    <body>
    
    <style>
.password-progress {
    margin-top: 10px;
    margin-bottom: 0;
}
</style>
    
    
    
    	<!-- start Login box -->
    	<div class="container" id="login-block">
    		<div class="row">
			    <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
			    	 
			       <div class="login-box clearfix animated flipInY">
			       		
			        	<div class="login-logo">
			        		<a href="#"><img src="img/helptimizesmall.png"  alt="helptimize" /></a>
			        	</div> 
			        	<h3>Administration-Tools</h3>
			        	<hr/>
			        	
			        	<div class="row">
			        	<div class="col-xs-3"></div>
			        	<div class="col-xs-6">

			        		 <form name='login' id='login' method="post">
			        		   						
			  				<br>
			                
			                <div class="form-group">
        					<input type='text' name='myusername' id='myusername' class='form-control' placeholder='Username'>
        					</div>
        					
        					<div class="form-group">
        					<input type='password' name='mypassword' id='mypassword' class='form-control' placeholder='Password'>
        					</div>
        					
						   	<center>
						   <button type="submit" class="btn btn-success">Login</button> 
						   	</center> 

							
							</form>
												  
						</div> 
							
							
						</div> 
	 		
			        				        	
			       </div>
			        
			        
			    </div>
			</div>
    	</div>
     
      	<!-- End Login box -->
     	<footer class="container">
     		<p id="footer-text"><small>Copyright &copy; 2017 <a href="http://www.helptimize.com">HELPTIMIZE.</a></small></p>
     	</footer>

        
      
        
    </body>
</html>





<script>



$(document).ready(function(){


	$('#login').formValidation({
        framework: 'bootstrap',
        
        fields: {
            myusername: {
                validators: {
                    notEmpty: {
                        message: "Please key in your username"
                    }
                    
                }
            },
            mypassword: {
                validators: {
                    notEmpty: {
                        message: "Please key in your password"
                    }
                    
                }
            }
                
            
        }
    }).on('success.form.fv', function(e) {
    
    		e.preventDefault();
    	
    		
    		var username = $('#myusername').val();
    		var password = $('#mypassword').val();
    		
    		// check if username and password exist
    		
    
    		
    		var formData = {
        		'username'     : username,
        		'password'     : password
      
			}
	
	  
			var feedback = $.ajax({
    			type: "POST",
    			url: "check_login.php",
    		    data: formData,
    		
    		    async: false,
    			
    		}).complete(function(){
    		
    		
    		}).responseText;
    		
  
            if(feedback == ""){
            
              swal("Ooops....!", "Wrong username or password", "error");
            
            
            
            }else{
            
            
            	// create session in db and go to main page
            	
            	var session_id = Math.random().toString(36).slice(-8);
            	
            	var formData = {
        		'session_id'     : session_id,
        		'id'     : feedback
      
				}
	
	  
				var feedback = $.ajax({
    			
    			type: "POST",
    			url: "create_session.php",
    		    data: formData,
    		
    		    async: false,
    			
    			}).complete(function(){
    			
    			
    		
    		
    			}).responseText;
    			
    		    window.location.href = "main.php?session_id=" + session_id;
    		    
    		
            
            }
  
    		
    		
    
     });
     
    
 
 

});





</script>



