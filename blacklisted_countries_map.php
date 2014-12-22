<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Blacklisted countries</title>
  <script src="./vendor/js/infobubble.js" type="text/javascript"></script>
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
  <link rel="stylesheet" type="text/css" href="vendor/shared/style.css" />
  <link rel="stylesheet" type="text/css" href="./vendor/css/default.css" />
   <style type="text/css">
      #map-canvas {
        
        height: 800px;}
	#map-canvas img {
		  max-width: none;
	}   
	  #map1 {
        
        height: 800px;}
	#map1 img {
		  max-width: none;
	}   
	body {
		
		color:#aaa;
		//font-family:Verdana, Geneva, sans-serif;
	}
    </style>
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
		  maxWidth: 80,
		  minWidth: 25,
		  minHeight: 14,
		  maxHeight: 30
		};
	function DistanceWidget(map) {
        this.set('map', map);
        this.set('position', map.getCenter());

        marker = new google.maps.Marker({
			draggable: true,
			title: 'Move me!',
			icon: './vendor/img/center.png'});

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
				$file_handle_location=fopen("blacklisted_ips_match_count.csv","r");
				$values=fgetcsv($file_handle_location,1024);
				$c=0;
				$top20=0;
				
				while(!feof($file_handle_location))
				{
					$values=fgetcsv($file_handle_location,1024);
					$check_lat=trim($values[7]);
					if($check_lat!="NA")
					{
						array_push($location,$values[7]);
						array_push($totalip,$values[4]);
						array_push($division,$values[7]);
						array_push($lat,$values[12]); 
						array_push($lon,$values[13]); 
						$c+=1;
					}
				}
				fclose($file_handle_location);
			?> 
			
			var latlng = new google.maps.LatLng(22.636807906238474, 79.48347014843506);
			var options = {center: latlng,	zoom: 3, mapTypeId: google.maps.MapTypeId.ROADMAP};
			map = new google.maps.Map(mapDiv, options);
			distanceWidget = new DistanceWidget(map);
			<?php
			echo "//make".count($lat)."\n\n";
			for($i=0;$i<count($lat)-1;$i++)
			{
				echo 'markers['.$i.'] = new google.maps.Marker({position: new google.maps.LatLng(';
				echo $lat[$i].','.$lon[$i].'),map: map,title:"Location: '.$location[$i].'",draggable:true,icon:"./vendor/img/locations.png",});';
			
				echo 'infoBubble['.$i.'] = new InfoBubble(infobubblestyle);';	
				if($totalip[$i]<10)
				{
					echo 'infoBubble['.$i.'].setContent("<a style=\'color:white;\' href=\'#\' title=\''.$location[$i].'\'>0'.$totalip[$i].'</a><br/>'.$location[$i].'");';
				}
				else
				{
					echo 'infoBubble['.$i.'].setContent("<a style=\'color:white;\' href=\'#\' title=\''.$location[$i].'\'>'.$totalip[$i].'</a><br/>'.$location[$i].'");';
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
    
<?php //print_r($lat); echo '<br/><br/>';?>
<?php // print_r($lon);echo '<br/><br/>';?>
<?php //print_r($division); echo '<br/><br/>';?>
<?php //print_r($location); echo '<br/><br/>';?>
<?php //print_r($totalip); echo '<br/><br/>';?>

	
</head>
<body style="padding-top:0px;">
<div class="container-fluid">
 
<div class="page-header">

  <h1> Blacklisted IPS across countries<small></small>

  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input id="target" type="text" style="width:300px;" placeholder="Search Box"></h1>

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
		<ul class="nav nav-tabs nav-stacked"><li><a href="violation_countries_map.php">Show violated countries map</a></li></ul>
			<ul class="nav nav-tabs nav-stacked"><li><a href="violation_countries.php">Show violated countries chart</a></li></ul>
			<ul class="nav nav-tabs nav-stacked"><li><a href="violation_cities.php">Show violated cities chart</a></li></ul>
			<ul class="nav nav-tabs nav-stacked"><li><a href="blacklisted_ips.php">Show blacklisted chart</a></li></ul>
			<ul class="nav nav-tabs nav-stacked"><li><a href="blacklisted_countries_map.php">Show blacklisted map</a></li></ul>
		
    </div>
    <div class="span9">
      <!--Body content-->
<?php
	
	$map="<div class='row-fluid'><ul class='thumbnails'>";
	$map.="<li class='span12'><div class='caption'><div class='thumbnail'>";
	$map.='<div id="panel" style="left:48%;">Top 30 countries</div>';
	
	
	$map.=" <div id='map-canvas'></div>";
	
	$map.="</div></div></li></ul></div>";
        echo $map;
		
		echo " <div id='map1'></div>";
	/*$rowcss_start="<div class='row-fluid'><ul class='thumbnails'>";
	$rowcss_end="</ul></div>";
	$span1='';
	$span2='';
	$span3='';
	$c=0;
	echo $rowcss_start;
	while(!feof($file_handle_location))
	{
		//echo "<h1>IP: ".$values[0]."</h1>";
		if($values[2]===$_GET['location'])
		{
			//echo $values;
			$details="<br/><b>Division:       </b>". $values[1]."<div class='clearfix'></div>"."<b>Location:       </b>". $values[2]."<div class='clearfix'></div>";
			$details.="<br/><b>Tower:          </b>". $values[3]."<div class='clearfix'></div>"."<br/><b>Floor:          </b>". $values[4]."<div class='clearfix'></div>"; 
			$details.="<br/><b>Wing:           </b>". $values[5]."<div class='clearfix'></div>"."<br/><b>Subnet:         </b>". $values[6]."<div class='clearfix'></div>"; 
			$details.="<br/><b>SubnetCat:      </b>". $values[7]."<div class='clearfix'></div>"."<br/><b>Subnet Mask:    </b>". $values[8]."<div class='clearfix'></div>"; 
			$details.="<br/><b>Number of Hosts:</b>". $values[9]."<div class='clearfix'></div>"."<br/><b>Host Range:     </b>". $values[10]."<div class='clearfix'></div>"; 
			$span1="<li class='span3'><div class='thumbnail'><img src='./vendor/img/download.png' alt=''><div class='caption'>";
			$span1.="<h3>IP: ".$values[0]."</h3><p>".$details."</p><p><a href='#' class='btn btn-primary'>Action</a>";
			$span1.="<a href='#' class='btn'>Action</a></p></div></div></li>";
			//$c+=1;
			echo $span1;
		}
		
		$span1='';
		$values=fgetcsv($file_handle_location,1024);
	}
	fclose($file_handle_location);
	echo $rowcss_end;*/
?>

    
</div></div></div>
</body>
</html>