<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Country violation by city</title>
  <link rel="stylesheet" type="text/css" href="examples/shared/style.css" />
   <style type="text/css">
      #map-canvas {
        
        height: 500px;}
	#map-canvas img {
		  max-width: none;
	}   
	body {
		color:#aaa;
		//font-family:Verdana, Geneva, sans-serif;
	}

    </style>
			

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <script src="./assets/js/infobubble.js" type="text/javascript"></script>
    <script type="text/javascript">
	var map;
	var marker;
	//Risks or Infection
	var markers=[];
	var infoBubble=[];
	
	var distanceWidget;
	var infobubblestyle = {
		  shadowStyle: 1,
		  padding: 5,
		  backgroundColor: '#333',
		  borderRadius: 4,
		  arrowSize: 10,
		  borderWidth: 0,
		  borderColor: '#fff',
		  disableAutoPan: true,
		  hideCloseButton: true,
		  arrowPosition: 50,
		  color:'white',
		  arrowStyle: 0,
		  maxWidth: 40,
		  minWidth: 16,
		  minHeight: 14,
		  maxHeight: 14
		};
	function DistanceWidget(map) {
        this.set('map', map);
        this.set('position', map.getCenter());

        marker = new google.maps.Marker({
			draggable: true,
			title: 'Move me!',
			icon: './assets/img/center.png'});

        // Bind the marker map property to the DistanceWidget map property
        marker.bindTo('map', this);

        // Bind the marker position property to the DistanceWidget position property
        marker.bindTo('position', this);

    }
	DistanceWidget.prototype = new google.maps.MVCObject();

    function init(){
	
			var mapDiv = document.getElementById('map-canvas');
			//getting all locations information in arrays
			<?php	
				$lat=array();
				$lon=array();
				$location=array();
				$totalip=array();
				$division=array();
				//risk_found_ip_count_location.csv
				$file_handle_location=fopen("violated_ips_match_count_by_city.csv","r");
				$values=fgetcsv($file_handle_location,1024);
				$c=0;
				$top20=0;
				
				while(!feof($file_handle_location))
				{
					$values=fgetcsv($file_handle_location,1024);
					$check_lat=trim($values[6]);
					if($_GET['location']==$values[6])
					{
						array_push($location,$values[7]);
						array_push($totalip,$values[3]);
						array_push($division,$values[6]);
						array_push($lat,$values[8]); 
						array_push($lon,$values[9]); 
						$c+=1;
					}
				}
				fclose($file_handle_location);
			?> 
			
			var latlng = new google.maps.LatLng(22.636807906238474, 79.48347014843506);
			var options = {center: latlng,	zoom: 5, mapTypeId: google.maps.MapTypeId.ROADMAP};
			map = new google.maps.Map(mapDiv, options);
			distanceWidget = new DistanceWidget(map);
			<?php
			echo "//make".count($lat)."\n\n";
			for($i=0;$i<20;$i++)
			{
				echo 'markers['.$i.'] = new google.maps.Marker({position: new google.maps.LatLng(';
				echo $lat[$i].','.$lon[$i].'),map: map,title:"Location: '.$location[$i].'",draggable:true,icon:"./assets/img/locations.png",});';
			
				echo 'infoBubble['.$i.'] = new InfoBubble(infobubblestyle);';	
				if($totalip[$i]<10)
				{
					echo 'infoBubble['.$i.'].setContent("<a style=\'color:white;\' href=\'./violation_country_map.php?location='.$location[$i].'\' title=\''.$location[$i].'\'>0'.$totalip[$i].'</a>");';
				}
				else
				{
					echo 'infoBubble['.$i.'].setContent("<a style=\'color:white;\' href=\'./violation_country_map.php?location='.$location[$i].'\' title=\''.$location[$i].'\'>'.$totalip[$i].'</a>");';
				}
				
				//markers[i].setMap(map);
				echo 'infoBubble['.$i.'].open(map,markers['.$i.']);';
			}
			
			?>
		//search 
	  var input = document.getElementById("target");
	  var searchBox = new google.maps.places.SearchBox(input);
	  
	 google.maps.event.addListener(map, 'zoom_changed', function() {
			distanceWidget = new DistanceWidget(map);	
		});
	  google.maps.event.addListener(searchBox, 'places_changed', function() 
	  {
		    var defaultBounds = new google.maps.LatLngBounds(new google.maps.LatLng(19.01, 72.7),
		    new google.maps.LatLng(19.03, 72.9));
		    map.fitBounds(defaultBounds);
		    var places = searchBox.getPlaces();

		    var bounds = new google.maps.LatLngBounds();
		    var lat,lon;
		    for (var i = 0, place; place = places[i]; i++) 
		    {			    
			  bounds.extend(place.geometry.location);
			  lat=place.geometry.location.lat();
			  lon=place.geometry.location.lng();
		    }		    
			circle.setMap(null);
			map = new google.maps.Map(mapDiv, {
			  center: new google.maps.LatLng(lat, lon),
			  zoom: 14,
			  mapTypeId: google.maps.MapTypeId.ROADMAP,
			  noClear: false
			}); 
			//map.setLatLng(lat, lon);
			rad="3";
			distanceWidget = new DistanceWidget(map);
			for(var i=0;i<infoBubble.length;i++)
			{
				markers[i].setMap(map);
				infoBubble[i].open(map,markers[i]);
			}
			map.fitBounds(bounds);
			map.setZoom(14);			
	  });
	    google.maps.event.addListener(map, 'bounds_changed', function() {
	    var bounds = map.getBounds();
	    searchBox.setBounds(bounds);
	    //alert('s');
		});
	}
	google.maps.event.addDomListener(window, 'load', init);
    </script>
	<style type="text/css" title="currentStyle">
			@import "./assets/css/demo_page.css";
			@import "./assets/css/demo_table.css";
			
		</style>
	<script type="text/javascript" language="javascript" src="./assets/js/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="./assets/js/jquery.dataTables.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
    oTable = $('#details').dataTable({
        
        "sPaginationType": "full_numbers"
    });
} );
	</script>
	

</head>
<body style="padding-top:0px;">
<div class="container-fluid">
   
<?php

if(isset($_SERVER['REQUEST_METHOD']))
{
?>
<div class="page-header">
  <h1> <?php echo $_GET['location']; ?><small>&nbsp&nbsp&nbsp&nbspTotal violated cities: <?php echo count($location);?></small></h1>&nbsp&nbsp&nbsp&nbsp<a href="./violation_ips.php">All</a>&nbsp&nbsp&nbsp&nbsp<a href="./violation_countries_map.php">Countries map</a>&nbsp&nbsp&nbsp&nbsp<a href="./violation_countries.php">Countries BarChart</a>
</div>
<div class="row-fluid">
    <div class="span3">
      <!--Sidebar content-->
	   <ul class="nav nav-tabs nav-stacked">
	<?php
			$details='';
			for($i=0;$i<count($totalip)-1;$i++)
			{
				$details.="<li><a tabindex='-1' href='#'><b>". $location[$i]."</b>:&nbsp&nbsp".$totalip[$i]."</a></li>";
			}
			echo $details;
		?> 
	</ul>
      <ul class="nav nav-tabs nav-stacked">
		<?php
			$file_handle_location=fopen("risk_found_ip_details.csv","r");
			$values=fgetcsv($file_handle_location,1024);
			$ld=array();
			//$ld[0]=array();
			$tower='';
			$floor='';
			$wing='';
			$count=0;
			while(!feof($file_handle_location))
			{
				
				$values=fgetcsv($file_handle_location,1024);
				
				if($_GET['location']==$values[2])
				{
					if($count==0)
					{
						$details="<li><a tabindex='-1' href='#'><b>Division:       </b>". $values[1]."</a></li>";
						$details.="<li><a tabindex='-1' href='#'><b>Location:       </b>". $values[2]."</a></li>";
						$details.="<li><a tabindex='-1' href='#'><b>Tower:          </b>". $values[3]."</a></li>";
						$details.="<li><a tabindex='-1' href='#'><b>Floor:          </b>". $values[4]."</a></li>"; 
						$details.="<li><a tabindex='-1' href='#'><b>Wing:           </b>". $values[5]."</a></li>";
						$details.="<li><a tabindex='-1' href='#'><b>Subnet:         </b>". $values[6]."</a></li>";
						$details.="<li><a tabindex='-1' href='#'><b>SubnetCat:      </b>". $values[7]."</a></li>";
						$details.="<li><a tabindex='-1' href='#'><b>Subnet Mask:    </b>". $values[8]."</a></li>"; 
						$details.="<li><a tabindex='-1' href='#'><b>Number of Hosts: </b>". $values[9]."</a></li>";
						$details.="<li><a tabindex='-1' href='#'><b>Host Range:     </b>". $values[10]."</a></li>"; 
						echo $details;
						$count=1;
					}
					$tower="".$values[3]."";
					$floor="".$values[4]."";
					$wing="".$values[5]."";
					$ld[$tower][$floor][$wing]=0;
					//break;
				}
				
			}
			/* echo "<pre>";
			echo  print_r($ld);
			echo "</pre>"; */
			fclose($file_handle_location);
		?> 
	</ul>
		
    </div>
    <div class="span9">
      <!--Body content-->
<?php
	$location= $_GET['location'];
	$file_handle_location=fopen("risk_found_ip_details.csv","r");
	$values=fgetcsv($file_handle_location,1024);
	$values=fgetcsv($file_handle_location,1024);
	//echo "<div class='row-fluid'><div class='span12'>Fluid 12<div class='row-fluid'><div class='span6'>Fluid 6<div class='row-fluid'>";
        //echo "<div class='span6'>Fluid 6</div><div class='span6'>Fluid 6</div></div></div><div class='span6'>Fluid 6</div></div></div></div>";
	//echo "<div class='row-fluid'><div class='span4'>...</div><div class='span4'>...</div><div class='span4'>...</div></div>";
	
	$map="<div class='row-fluid'><ul class='thumbnails'>";
	$map.="<li class='span12'><div class='thumbnail'><div id='map-canvas'></div><div class='caption'>";
	$map.="</div></div></li></ul></div>";
        echo $map;
	$rowcss_start="<div class='row-fluid'><ul class='thumbnails'>";
	$rowcss_end="</ul></div>";
	$span1='';
	$span2='';
	$span3='';
	$c=0;
	echo $rowcss_start;
	//echo '<table class="table"><tr><th>Location</th><th>Tower</th><th>Wing</th><th>Infection</th></tr>';
		$row = 0;
		
		if (($handle = fopen("violated_ips_match_count_by_city.csv", "r")) !== FALSE) 
		{
			echo '<table cellpadding="0" cellspacing="0" border="0" class="display table" style="color:black;" id="details">';
			echo '<thead><tr><th>Subtype</th><th>Pri</th><th>Status</th><th>Total hits</th><th>Country Code</th><th>Country</th><th>City</th><th>Time zone</th>';	
			echo '</tr></thead><tbody>';
				
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
			{				
				if($_GET['location']==$data[6])
				{
					echo "<tr>";
					echo "<td>".$data[0]."</td>";					
					echo "<td>".$data[1]."</td>";
					echo "<td>".$data[2]."</td>";
					echo "<td>".$data[3]."</td>";
					echo "<td>".$data[4]."</td>";
					echo "<td>".$data[6]."</td>";
					echo "<td>".$data[7]."</td>";
					echo "<td>".$data[10]."</td>";
					
					
					echo "</tr>";
				}
				
			}
			
			echo "</tbody></table>";
			fclose($handle);
		}
		
	
	echo $rowcss_end;
}
?>

</div></div></div>
</body>
</html>