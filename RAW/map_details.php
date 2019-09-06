<?php
require_once("./header_main.php");
require_once("/etc/helptimize/conf.php");

$id=$_sqlObj->escape($_GET['id']);

   $sql_rating = "SELECT * FROM range_area WHERE id='".$id."' ";
   $rating=reset($_sqlObj->query($sql_rating)); 
  $lat=$rating['posLat'];
 $lng=$rating['posLong'];
  $title=$rating['address'];
 $range_distance=$rating['range_distance'];	
if($range_distance="" || $range_distance== NULL)
$range_distance=1;
else
 $range_distance=$rating['range_distance'];	


echo $_template["header"];



?>



<script src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>

<script type="text/javascript" src="js/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="js/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="js/moment.min.js"></script>
<script type="text/javascript" src="js/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-clockpicker.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker3.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-switch.min.css">

<script src="js/bootstrap-multiselect.js"></script>
<script src="js/jquery.bootstrap-touchspin.min.js"></script>
<script src="js/jquery.maskMoney.min.js"></script>


<link href="css/bootstrap-multiselect.css" rel="stylesheet">
<link href="css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">

<script>
</script>


<?php 
echo $_template["nav"];

  

?>

<div style="padding:15px;width:70%;margin: auto;">
	<p><b>Title</b> : <?php echo $rating['title']; ?></p>
	<p><b>Address</b> : <?php echo $rating['address']; ?></p>
	<p><b>Area in Miles</b> : <?php echo $rating['range_distance']; ?></p>
	<p><b>Category</b> : <?php 
	$cateid=$rating['categId'];
	$explode=explode(",",$cateid);
	foreach($explode as $key => $value)
	{	
        $sql_categ = "SELECT * FROM categ WHERE id='".$value."' ";
   $categ=reset($_sqlObj->query($sql_categ)); 
  echo $categ['name'];
  echo ", ";
	}
 
	 ?></p>


    <div id="googleMap" style="height: 400px"></div>
</div>   
        	 
        	





                      
<script>
var gLat=47.6062;
var gLng=-122.3321;


/////google map circle radius location start - 08.05.19
    
      
     var gLat=<?php echo $lat; ?>;
	 var gLng=<?php echo $lng; ?>;
      var citymap = {
        chicago: {
          center: {lat: gLat, lng: gLng},
          population: 2714856
        }
      };

      function initMap() {
        // Create the map.
        var map = new google.maps.Map(document.getElementById('googleMap'), {
          zoom: 12,
          center: {lat: gLat, lng: gLng},
          mapTypeId: 'terrain'
        });

        // Marker Icons Implementation
        markers = new google.maps.Marker({
            position: {lat: gLat, lng: gLng},
            map: map,
            title: '<?php echo $title; ?>'
        });
        for (var city in citymap) {
        	var rad=<?php echo $range_distance; ?>;
        	 //rad *= 1600;
          // Add the circle for this city to the map.
          var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#BBD8E9',
            fillOpacity: 0.35,
            map: map,
            center: citymap[city].center,
            radius: rad
          });
        }
      }

   
      /////google map circle radius location End - 08.05.19

     
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo $_configs['google_map_api']; ?>&callback=initMap">    
    </script>
  
<?php
include("footer.php");
?>
