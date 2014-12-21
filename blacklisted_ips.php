<!DOCTYPE html>
<html>
<?php// echo phpinfo();?>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Blacklisted IPs violation.</title> 
  <link rel="stylesheet" type="text/css" href="examples/shared/style.css" />
  <link rel="stylesheet" type="text/css" href="examples/shared/style.css" />
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
 <style type="text/css" title="currentStyle">
			@import "./vendor/css/demo_page.css";
			@import "./vendor/css/demo_table.css";
			
</style>
	<script type="text/javascript" language="javascript" src="./vendor/js/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="./vendor/js/jquery.dataTables.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function() {
    oTable = $('#details').dataTable({
        
        "sPaginationType": "full_numbers"
    });
} );
	</script>
	<script type="text/javascript" src="flotr2.min.js"></script>
 <style type="text/css">
      body {
        margin: 0px;
        padding: 0px;
      }
      #container {
        width : 600px;
        height: 384px;
        margin: 8px auto;
      }
    </style>
</head>

<body style="padding-top:0px;">
<div class="container-fluid">
 
<div class="page-header">

  <h1> Blacklisted IPS<small></small></h1>


</div>

<div class="row-fluid">
	
    <div class="span3">
			<ul class="nav nav-tabs nav-stacked"><li><a href="violation_countries_map.php">Show violated countries map</a></li></ul>
			<ul class="nav nav-tabs nav-stacked"><li><a href="violation_countries.php">Show violated countries chart</a></li></ul>
			<ul class="nav nav-tabs nav-stacked"><li><a href="violation_cities.php">Show violated cities chart</a></li></ul>
			<ul class="nav nav-tabs nav-stacked"><li><a href="blacklisted_ips.php">Show blacklisted chart</a></li></ul>
			<ul class="nav nav-tabs nav-stacked"><li><a href="blacklisted_countries_map.php">Show blacklisted map</a></li></ul>
	</div>
	 <div class="span6">	 		
		
		<div id="container"></div>
		<div id="examples"></div>
		<div id="c2"></div>
	
	 </div>
	 <div class="span3">	 		
	 </div>
</div>
<div class="row-fluid">
<div class="span12">
	 
     <?php
	
		$row = 1;
		if (($handle = fopen("blacklisted_ips_match_count.csv", "r")) !== FALSE) 
		{
			echo '<table cellpadding="0" cellspacing="0" border="0" class="display table" style="color:black;" id="details">';
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
			{
				$num = count($data);
				//echo "<p> $num fields in line $row: <br /></p>\n";
				if($row==1)
				{
					echo '<thead><tr>';
					for ($c=0; $c < $num; $c++) 
					{
						echo "<th>".$data[$c]."</th>";					
					}
					echo '</tr></thead><tbody>';
				}
				else
				{
					echo "<tr>";
					for ($c=0; $c < $num; $c++) 
					{
						echo "<td>".$data[$c]."</td>";					
					}
					echo "</tr>";
				}
				$row++;
			}
			echo "</tbody></table>";
		fclose($handle);
		}
		?>  
   </div>	
   
</div>
</div>
   <script>
	(function basic_bars(container, horizontal) {   
		var   horizontal = (horizontal ? true : false), 
		d1 = [], 
		d2 = [],
		point, 
		i;

	<?php
	
		$row = 1;
		if (($handle = fopen("blacklisted_ips_match_count.csv", "r")) !== FALSE) 
		{
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
			{
				$num = count($data);
				//echo "<p> $num fields in line $row: <br /></p>\n";
				$row++;
				/*for ($c=1; $c < $num; $c++) 
				{*/
					//echo $data[$c] . "<br />\n";
					if($row>=3)
					{	echo "point = [$row-2,$data[4]];";
						echo "d1.push(point);";
					}
				//}
			}
		fclose($handle);
		}
		?>


    // Draw the graph
    Flotr.draw(
    container, [d1, d2], {
        bars: {
            show: true,
            horizontal: horizontal,
            shadowSize: 0,
            barWidth: 0.5
        },
        mouse: {
            track: true,
            relative: true
        },
        yaxis: {
            min: 0,
            autoscaleMargin: 1
        }
    });
})(document.getElementById("container"));
  </script>
</body>
</html>
