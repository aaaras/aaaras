<?php
					// Seleziona Province e Comuni. 
					
					$conn=mysql_connect("localhost", "root", "") or die("Error");
					mysql_select_db("votailprof", $conn) or die("Error");
					
					if (isset($_GET['regionid']) /*and is_numeric($_GET['regionid'])*/) {
					  if (isset($_GET['requestItems']) and $_GET['requestItems']==='province') {
						 $regionID = $_GET['regionid'];
						 $query = "
					SELECT * 
					FROM province 
					WHERE regione = '".$regionID."' 
					ORDER BY provincia";
					echo $query;
						 $result = mysql_query($query, $conn);
						 $returnProvince = '';
						 while ($row = mysql_fetch_array($result)) {
							$returnProvince .= "||".$row['id'].",".$row['provincia'];
						 }
						 print_r($returnProvince);
					  } 
					}
					?>
				