<?php

// 	// load library PHPExcel
// 	require_once ("lib/PHPExcel/Classes/PHPExcel.php");
// 	// load libarry IOFactory 
// 	include ("lib/PHPExcel/Classes/PHPExcel/IOFactory.php");
	
// 	date_default_timezone_set('Asia/Bangkok');
	
// 	//ini_set('display_errors','0');
	
// 	if(!empty($_FILES['file_upload']['name']))
// 	{
// 		$file_import = 'netclub2.xls';
		
// 		move_uploaded_file($_FILES['file_upload']['tmp_name'],$file_import);
		
// 		$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
// 		$cacheSettings = array( ' memoryCacheSize ' => '50MB');
// 		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
		
// 		$inputFileName = $file_import; 
// 		$inputFileType = PHPExcel_IOFactory::identify($inputFileName);  
// 		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		
// 		// $objReader->setReadDataOnly(true);  
// 		$objPHPExcel = $objReader->load($inputFileName);  
		
// 		$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

// 		$highestRow = $objWorksheet->getHighestRow();
		
// 		$highestColumn = $objWorksheet->getHighestColumn();
		
// 		$main_col = 'A';
		
// 		$headingsArray = $objWorksheet->rangeToArray($main_col.'3:'.$highestColumn.'3',null, true, true, true);

// 		$headingsArray = $headingsArray[3];
		
		
// 		$arr_column = array(
// 								'username',
// 								'password',
// 								'firstname',
// 								'lastname',
// 								'nick_name',
//     							'room',
//     							'building',
//     							'email',
//    								'jobtitle',
//     							'user_group_id'
// 						);
						
		
// 			foreach($arr_column as $column_val){
// 					if(!in_array($column_val,$headingsArray)){	
// 						$output = 'รูปแบบไฟล์ไม่ถูกต้องกรุณาตรวจสอบ';		
// 						if(is_file($file_import)){
// 							@unlink($file_import);
// 						}
// 						echo $output;
// 						die();
// 					}
// 			}
						
						
// 			$r = -1;
// 			$namedDataArray = array();
// 			for ($row = 4; $row <= $highestRow; ++$row) {
// 			    $dataRow = $objWorksheet->rangeToArray($main_col.$row.':'.$highestColumn.$row,null, true, true, true);
// 			    if ((isset($dataRow[$row][$main_col])) && ($dataRow[$row][$main_col] > '')) {
// 			        ++$r;
// 			        foreach($headingsArray as $columnKey => $columnHeading) {
// 			            $namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];	
// 			        }
// 			    }
	
// 			}
			
// 			$status = '';
			
// 			foreach ($namedDataArray as $result) {
				
				
				
// 				$username = $result['username'];
// 				$password = $result['password'];
// 				$firstname = $result['firstname'];
// 				$lastname = $result['lastname'];
// 				$nick_name = $result['nick_name'];
// 				$room = $result['room'];
// 				$building = $result['building'];
// 				$email = $result['email'];
// 				$jobtitle = $result['jobtitle'];
// 				$user_group_id = !empty($result['user_group_id']) ? $result['user_group_id'] :0;
// 				$date_add = date('Y-m-d H:i:s');

				
// 				if( check_username_not_unique($result['username']) == TRUE )
// 				{
				
// 					$sql  = "INSERT INTO the_user (";
// 					$sql .= "username,";
// 					$sql .= "password,";
// 					$sql .= "firstname,";
// 					$sql .= "lastname,";
// 					$sql .= "nick_name,";
// 					$sql .= "room,";
// 					$sql .= "building,";
// 					$sql .= "email,";
// 					$sql .= "jobtitle,";
// 					$sql .= "status,";
// 					$sql .= "date_added,";
// 					$sql .= "user_group_id ) VALUES ('";
// 					$sql .=  $username."','";
// 					$sql .=  md5($password)."','";
// 					$sql .=  $firstname."','";
// 					$sql .=  $lastname."','";
// 					$sql .=  $nick_name."','";
// 					$sql .=  $room."','";
// 					$sql .=  $building."','";
// 					$sql .=  $email."','";
// 					$sql .=  $jobtitle."','1','";
// 					$sql .=  $date_add."','";
// 					$sql .=  $user_group_id."')";
					
// 					$query = mysql_query($sql) or die("ERROR : ".mysql_error()."$sql<br>");
					
// 					$status = 'Import DONE !!!!!';
// 				}
// 				else
// 				{
// 					$status = 'Have Data !!!!';	
// 				}
// 			}
// 		echo $status;
// 	}

?>
<?php

	
require_once ("lib/PHPExcel/Classes/PHPExcel.php");
	
include ("lib/PHPExcel/Classes/PHPExcel/IOFactory.php");

date_default_timezone_set('Asia/Bangkok');

	//ini_set('display_errors','0');

if(!empty($_FILES['file_upload']['name']))
{
	$file_import = 'netclub2.xls';

	move_uploaded_file($_FILES['file_upload']['tmp_name'],$file_import);

	header('Content-Type: text/html; charset=utf-8');

	$objPHPExcel = PHPExcel_IOFactory::load($file_import);
	foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
		$worksheetTitle     = $worksheet->getTitle();
		$highestRow         = $worksheet->getHighestRow(); // e.g. 10
		$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		$nrColumns = ord($highestColumn) - 64;

		// echo '<table width="100%" cellpadding="3" cellspacing="0"><tr>';
		$sql  = "INSERT INTO the_user (";
		for ($row = 1; $row <= $highestRow; ++ $row) {

			// echo '<tr>';
			for ($col = 0; $col < $highestColumnIndex; ++ $col) {
				$cell = $worksheet->getCellByColumnAndRow($col, $row);
				$val = $cell->getValue();
				if($row === 1)
				// echo '<td style="background:#000; color:#fff;">' . $val . '</td>';

					$sql .= $val.',';

				else
					$sql .= $val .',';				
			}
			$sql .= ')';
			echo $sql;

			die();
			echo "<br>";
		}
		// echo '</table>';


	}
}


					// $sql  = "INSERT INTO the_user (";
					// $sql .= "username,";
					// $sql .= "password,";
					// $sql .= "firstname,";
					// $sql .= "lastname,";
					// $sql .= "nick_name,";
					// $sql .= "room,";
					// $sql .= "building,";
					// $sql .= "email,";
					// $sql .= "jobtitle,";
					// $sql .= "status,";
					// $sql .= "date_added,";
					// $sql .= "user_group_id ) VALUES ('";
					// $sql .=  $username."','";
					// $sql .=  md5($password)."','";
					// $sql .=  $firstname."','";
					// $sql .=  $lastname."','";
					// $sql .=  $nick_name."','";
					// $sql .=  $room."','";
					// $sql .=  $building."','";
					// $sql .=  $email."','";
					// $sql .=  $jobtitle."','1','";
					// $sql .=  $date_add."','";
					// $sql .=  $user_group_id."')";

?>