<!DOCTYPE html>
<html>
<?php// echo phpinfo();?>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>City wise violation.</title> 
  <link rel="stylesheet" type="text/css" href="vendor/shared/style.css" />
  <link rel="stylesheet" type="text/css" href="vendor/shared/style.css" />
  <link rel="stylesheet" type="text/css" href="./assets/css/default.css" />
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
	  #c2 {
        width : 600px;
        height: 384px;
        margin: 8px auto;
      }
    </style>
</head>

<body style="padding-top:0px;">
<div class="container-fluid">
 
<div class="page-header">

  <h1> Violated IPS across cities<small></small></h1>


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
		<div id="vendor"></div>
		<div id="c2"></div>
	
	 </div>
	 <div class="span3">	 		
	 </div>
</div>
<div class="row-fluid">
<div class="span12">
	      <?php
	
		$row = 1;
		if (($handle = fopen("violated_ips_match_count.csv", "r")) !== FALSE) 
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
   </div></div>
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
		$counter=0;
		if (($handle = fopen("violated_ips_match_count.csv", "r")) !== FALSE) 
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
					if($counter==10)
					{
						break;
					}
					$counter++;
				//}
			}
		fclose($handle);
		}
		?>
		/*for (i = 0; i < 4; i++) {

        if (horizontal) {
            point = [Math.ceil(Math.random() * 10), i];
        } else {
            point = [i, Math.ceil(Math.random() * 10)];
        }

        d1.push(point);

        if (horizontal) {
            point = [Math.ceil(Math.random() * 10), i + 0.5];
        } else {
            point = [i + 0.5, Math.ceil(Math.random() * 10)];
        }

        d2.push(point);
    };*/

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



(function color_gradients(container) {

  var
    bars = {
      data: [],
      bars: {
        show: true,
        barWidth: 0.8,
        lineWidth: 0,
        fillColor: {
          colors: ['#CB4B4B', '#fff'],
          start: 'top',
          end: 'bottom'
        },
        fillOpacity: 0.8
      }
    }, markers = {
      data: [],
      markers: {
        show: true,
        position: 'ct'
      }
    }, lines = {
      data: [],
      lines: {
        show: true,
        fillColor: ['#00A8F0', '#fff'],
        fill: true,
        fillOpacity: 1
      }
    },
    point,
    graph,
    i;
  
  <?php
	
		$row = 1;
		$counter=0;
		$max=0;
		if (($handle = fopen("violated_ips_match_count.csv", "r")) !== FALSE) 
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
					{	echo "point = [".($row-3).",$data[4]];";
						echo "bars.data.push(point);";
						echo "markers.data.push(\"$data[0]\");";
						
					}
					if($counter==10)
					{
						break;
					}
					if($counter==1)
						$max=$data[4];
					$counter++;
				//}
			}
		fclose($handle);
		}
		?>
  /* for (i = 0; i < 8; i++) {
    point = [i, Math.ceil(Math.random() * 10)];
    bars.data.push(point);
    markers.data.push(point);
  } */
  /* 
  for (i = -1; i < 9; i += 0.01){
    lines.data.push([i, i*i/8+2]);
  } */
  
  graph = Flotr.draw(
    container,
    [lines, bars, markers], {
      yaxis: {
        min: 0,
        <?php echo "max:".$max;?>
      },
      xaxis: {
        min: -0.5,
        max: 7.5
      },
      grid: {
        verticalLines: false,
        backgroundColor: ['#fff', '#ccc']
      }
    }
  );
})(document.getElementById("c2"));
  </script>
</body>
</html>
