<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
// header('CharacterSet: UTF-8');

$serverName = "200.29.139.244"; //serverName\instanceName

$dbn="MAESTRA";

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
// $connectionInfo = array( "Database"=>"MAESTRA", "UID"=>"admin", "PWD"=>"Jgh240482710", "CharacterSet" => "UTF-8");

error_reporting(-1);
ini_set("display_errors", 1);
	
$conn = mssql_connect( ".","admin","Jgh240482710");
mssql_select_db($dbn,$conn);

// if( !$conn )      
	// die( print_r( sqlsrv_errors(), true));

$caso= $_GET['caso'];

// $caso='1';

if($caso=='2')
	$id_auditor= $_GET['id_auditor'];
	
$result=array();	

				// Entidades posibles
				
				switch($caso)
				{
					case '1': // La entidad es auditor
																			
						// $sql="SELECT id_auditor,codigo_auditor,nombre_auditor,id_auditor_padre FROM [MAESTRA].[dbo].[AUDITOR] where id_rol=2";
						$sql="SELECT * FROM [MAESTRA].[dbo].[AUDITOR]";
						// $params=array();
						// $stmt = sqlsrv_prepare($conn,$sql,$params);					
						// if(!$stmt) 
							// die( print_r( sqlsrv_errors(), true));						
						 // if( sqlsrv_execute( $stmt ) === false )
							// die( print_r( sqlsrv_errors(), true));    
						
						$data = mssql_query( $sql, $conn);
																																					
					break;	
					
					case '2': // La entidad es sala
									
						$sql="SELECT * FROM [MAESTRA].[dbo].[AUDITOR_SALA] AS asala INNER JOIN [MAESTRA].[dbo].[SALA] AS s on asala.id_sala=s.id_sala and asala.id_auditor=$id_auditor";
						// $params=array(&$id_auditor);
						// $stmt = sqlsrv_prepare($conn,$sql,$params);					
						// if(!$stmt) 
							// die( print_r( sqlsrv_errors(), true));						
						 // if( sqlsrv_execute( $stmt ) === false )
							// die( print_r( sqlsrv_errors(), true));    																																													
						
						$data = mssql_query( $sql, $conn);						
					break;						
																					
				}							

	// while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) )
	// {
		// $format_row=array();
		// foreach($row as $key=>$value)
		// {
			// $tokens=explode('_',$key);					
			
			// if($tokens[0]=='ID')
				// $format_row[strtolower($key)]=intval(trim($value));			
			// else
				// $format_row[strtolower($key)]=trim($value);			
		// }
		// $result[]=$format_row;
	// }
		
	// if (!mssql_num_rows($data)) {
		// echo 'No records found';
	// }
	// else
	// {
		while( $row =  mssql_fetch_assoc ( $data ) )
		{			
			$format_row=array();
			foreach($row as $key=>$value)
			{
				$tokens=explode('_',$key);					
				
				if($tokens[0]=='ID')
					$format_row[strtolower($key)]=intval(trim($value));			
				else
					$format_row[strtolower($key)]=trim(utf8_encode($value));			
			}
			// print_r($format_row);
			$result[]=$format_row;
		}
	// }
	// print_r($result);				
	echo json_encode($result);	
	
		// if(isset($_GET['callback'])){ // Si es una petición cross-domain
			// // echo "HAY CALLBACK";
			// // echo $_GET['callback'].'('.json_encode($result).')';
			// echo json_encode($result);	
        // }
        // else // Si es una normal, respondemos de forma normal
		// {
			// // echo "NO HAY CALLBACK";
            // echo json_encode($result);	
		// }
?>
