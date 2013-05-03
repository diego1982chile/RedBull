<?php
header("Content-Type: text/html;charset=utf-8;Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Origin: *');
$serverName = "200.29.139.244"; //serverName\instanceName

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
$connectionInfo = array( "Database"=>"MAESTRA", "UID"=>"admin", "PWD"=>"Jgh240482710", "CharacterSet" => "UTF-8");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( !$conn )      
	die( print_r( sqlsrv_errors(), true));

// print_r($_POST);

$caso= json_decode(stripslashes($_REQUEST['caso']));
if($caso=='2')
	$id_auditor= json_decode(stripslashes($_REQUEST['id_auditor']));

$result=array();	

				// Entidades posibles
				
				switch($caso)
				{
					case '1': // La entidad es auditor
													
						$sql="SELECT id_auditor,codigo_auditor,nombre_auditor,id_auditor_padre FROM auditor where id_rol=2";
						$params=array();
						$stmt = sqlsrv_prepare($conn,$sql,$params);					
						if(!$stmt) 
							die( print_r( sqlsrv_errors(), true));						
						 if( sqlsrv_execute( $stmt ) === false )
							die( print_r( sqlsrv_errors(), true));    																																													
																																										
					break;	
					
					case '2': // La entidad es sala
									
						$sql="SELECT * FROM auditor_sala as inner join sala s on as.id_sala=s.id_sala and as.id_auditor=?";
						$params=array(&$id_auditor);
						$stmt = sqlsrv_prepare($conn,$sql,$params);					
						if(!$stmt) 
							die( print_r( sqlsrv_errors(), true));						
						 if( sqlsrv_execute( $stmt ) === false )
							die( print_r( sqlsrv_errors(), true));    																																													
																																										
					break;						
																					
				}							

	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) )
	{
		$format_row=array();
		foreach($row as $key=>$value)
		{
			$tokens=explode('_',$key);					
			
			if($tokens[0]=='ID')
				$format_row[strtolower($key)]=intval(trim($value));			
			else
				$format_row[strtolower($key)]=trim($value);			
		}
		$result[]=$format_row;
	}
	// print_r($result);				
	
	if(isset($_GET['callback'])){ // Si es una petición cross-domain
           echo $_GET['callback'].'('.json_encode($result).')';
        }
        else // Si es una normal, respondemos de forma normal
           echo json_encode($result);			
?>
