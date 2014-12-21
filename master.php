<?php
			$arrCSV = array();
			$arrCSVCity = array();
			$arrCSVCountry = array();
			// Open the CSV
			if (($read_handle = fopen("violated_ips_match_count.csv", "r")) !==FALSE) 
			{
				// Set the parent array key to 0
				$key = 0;
				$index=0;
				// While there is data available loop through unlimited times (0) using separator (,)
				while (($data = fgetcsv($read_handle, 0, ",")) !==FALSE) 
				{
					//Count the total keys in each row
					//$c = count($data);
					//Populate the array
					if($key!=0)
					//for($x=1;$x<3;$x++)
					{
						//$arrCSV[$index++] = $data[1];
						$arrCSVCountry[$index++] = $data[7];
						$arrCSVCity[$index++] = $data[8];
					}				   
					$key++;
				} // end while
				// Close the CSV file
				fclose($read_handle);
			} // end if

			$l=array_values(array_unique($arrCSV));			
			$co=array_values(array_unique($arrCSVCountry));
			$ci=array_values(array_unique($arrCSVCity));
			// echo print_r($l).'<br/>';
			// echo print_r($co).'<br/>';
			// echo print_r($ci).'<br/>';
			$locations=array();
			$cities=array();
			$countries=array();
			for($x=0;$x<count($l);$x++)
				$locations[$l[$x]]=0;
			for($x=0;$x<count($ci);$x++)
				$cities[$ci[$x]]=0;
			for($x=0;$x<count($co);$x++)
				$countries[$co[$x]]=0;
			echo "<pre>";
			echo "<br/>";
			echo print_r($countries);
			echo "</pre>";
			echo "<pre>";
			echo "<br/>";
			//echo print_r($cities);
			echo "</pre>";
		?>
		
		
		
		<!-- Match Splunk IPs to Subnet range.-->
		<?php

			//Read first line from file and ignore it bcoz it is for header of column.
			$file_handle_ip_input = fopen("violated_ips_match_count.csv", "r");
			$line_of_text_ip_input = fgetcsv($file_handle_ip_input, 1024);
			$count=0;//IPs counter.
			//Read first/next IP.
						
			while (!feof($file_handle_ip_input) ) 
			{
				//Counter for record no.
				$count+=1;
				$line_of_text_ip_input = fgetcsv($file_handle_ip_input, 1024);
				foreach($countries as $key=>$value)
				{
						if(trim($line_of_text_ip_input[7])==trim($key))
						{
							$countries[$key]=$countries[$key]+$line_of_text_ip_input[4];							
						}													
				}				
			}
			fclose($file_handle_ip_input);
			array_multisort($countries,SORT_DESC);
			
			echo "<pre>";
			echo "<br/>";
			echo print_r($countries);
			echo "</pre>";
			
			
			$file_handle_ip_count_country = fopen("violated_ips_match_count_by_country.csv", "w");			
			$fields=array('Subtype','Pri','Status_IP','Total hits','country_code','country_code3','country_name','latitude','longitude','time_zone');
			fputcsv($file_handle_ip_count_country,$fields);
			
			foreach($countries as $key=>$value)
			{
				$file_handle_ip_input = fopen("violated_ips_match_count.csv", "r");
				$line_of_text_ip_input = fgetcsv($file_handle_ip_input, 1024);
				while (!feof($file_handle_ip_input)) 
				{
						$line_of_text_ip_input = fgetcsv($file_handle_ip_input, 1024);
						if(trim($line_of_text_ip_input[7])==trim($key))
						{//
							//$countries[$key]=$countries[$key]+$line_of_text_ip_input[4];
							print $key;
							$values=array($line_of_text_ip_input[1],$line_of_text_ip_input[2],$line_of_text_ip_input[3],$value,$line_of_text_ip_input[5],$line_of_text_ip_input[6],$line_of_text_ip_input[7],$line_of_text_ip_input[12],$line_of_text_ip_input[13],$line_of_text_ip_input[15]);
							fputcsv($file_handle_ip_count_country,$values);							
							break;
						}																		
				}		 				
				fclose($file_handle_ip_input);
			}
			fclose($file_handle_ip_count_country);			
		?>
		<!-- Match Splunk IPs to Subnet range.-->
		<?php

			//Read first line from file and ignore it bcoz it is for header of column.
			$file_handle_ip_input = fopen("violated_ips_match_count.csv", "r");
			$line_of_text_ip_input = fgetcsv($file_handle_ip_input, 1024);

			$count=0;//IPs counter.
			
			while (!feof($file_handle_ip_input) ) 
			{
				//Counter for record no.
				$count+=1;
				$line_of_text_ip_input = fgetcsv($file_handle_ip_input, 1024);
				foreach($cities as $key=>$value)
				{
						if(trim($line_of_text_ip_input[8])==trim($key))
						{
							$cities[$key]=$cities[$key]+$line_of_text_ip_input[4];
						}													
				}				
			}
			array_multisort($countries,SORT_DESC);
			
			echo "<pre>";
			echo "<br/>";
			echo print_r($cities);
			echo "</pre>";
			fclose($file_handle_ip_input);
			
			$file_handle_ip_count_city = fopen("violated_ips_match_count_by_city.csv", "w");			
			$fields=array('Subtype','Pri','Status_IP','Total hits','country_code','country_code3','country_name','city_name','latitude','longitude','time_zone');
			fputcsv($file_handle_ip_count_city,$fields);
			
			foreach($cities as $key=>$value)
			{
				$file_handle_ip_input = fopen("violated_ips_match_count.csv", "r");
				$line_of_text_ip_input = fgetcsv($file_handle_ip_input, 1024);
				while (!feof($file_handle_ip_input)) 
				{
						$line_of_text_ip_input = fgetcsv($file_handle_ip_input, 1024);
						if(trim($line_of_text_ip_input[8])==trim($key))
						{
							print $key;
							$values=array($line_of_text_ip_input[1],$line_of_text_ip_input[2],$line_of_text_ip_input[3],$value,$line_of_text_ip_input[5],$line_of_text_ip_input[6],$line_of_text_ip_input[7],$line_of_text_ip_input[8],$line_of_text_ip_input[12],$line_of_text_ip_input[13],$line_of_text_ip_input[15]);
							fputcsv($file_handle_ip_count_city,$values);							
							break;
						}																		
				}		 				
				fclose($file_handle_ip_input);
			}
			fclose($file_handle_ip_count_city);		
			
		?>