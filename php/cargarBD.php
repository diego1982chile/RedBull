<?php
header("Content-Type: text/html;charset=utf-8");

$serverName = "localhost"; //serverName\instanceName

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
$connectionInfo = array( "Database"=>"RedBull",  "CharacterSet" => "UTF-8");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( !$conn )      
	die( print_r( sqlsrv_errors(), true));

// print_r($_POST);

$caso= json_decode(stripslashes($_REQUEST['caso']));

$result=array();	

				// Entidades posibles
				
				switch($caso)
				{
					case '1': // La entidad es topico
													
						$sql="SELECT * FROM topico";
						$params=array();
						$stmt = sqlsrv_prepare($conn,$sql,$params);					
						if(!$stmt) 
							die( print_r( sqlsrv_errors(), true));						
						 if( sqlsrv_execute( $stmt ) === false )
							die( print_r( sqlsrv_errors(), true));    																																													
																																										
					break;	
					
					case '2': // La entidad es seccion
									
						$sql="SELECT * FROM seccion";
						$params=array();
						$stmt = sqlsrv_prepare($conn,$sql,$params);					
						if(!$stmt) 
							die( print_r( sqlsrv_errors(), true));						
						 if( sqlsrv_execute( $stmt ) === false )
							die( print_r( sqlsrv_errors(), true));    																																													
																																										
					break;						
					
					case '3': // La entidad es categoria
													
						$sql="SELECT * FROM categoria";
						$params=array();
						$stmt = sqlsrv_prepare($conn,$sql,$params);					
						if(!$stmt) 
							die( print_r( sqlsrv_errors(), true));						
						 if( sqlsrv_execute( $stmt ) === false )
							die( print_r( sqlsrv_errors(), true));    																																													
																																										
					break;					
					
					case '4': // La entidad es pregunta
					
								
						$sql="SELECT * FROM pregunta";
						$params=array();
						$stmt = sqlsrv_prepare($conn,$sql,$params);					
						if(!$stmt) 
							die( print_r( sqlsrv_errors(), true));						
						 if( sqlsrv_execute( $stmt ) === false )
							die( print_r( sqlsrv_errors(), true));    																																													
																																										
					break;	
	
					case '5': // La entidad es pregunta_categoria
					
									
						$sql="SELECT * FROM pregunta_categoria";
						$params=array();
						$stmt = sqlsrv_prepare($conn,$sql,$params);					
						if(!$stmt) 
							die( print_r( sqlsrv_errors(), true));						
						 if( sqlsrv_execute( $stmt ) === false )
							die( print_r( sqlsrv_errors(), true));    																																													
																																										
					break;

					case '6': // La entidad es item
					
								
						$sql="SELECT * FROM item";
						$params=array();
						$stmt = sqlsrv_prepare($conn,$sql,$params);					
						if(!$stmt) 
							die( print_r( sqlsrv_errors(), true));						
						 if( sqlsrv_execute( $stmt ) === false )
							die( print_r( sqlsrv_errors(), true));    																																													
																																									
					break;						
	
					case '7': // La entidad es alternativa
					
									
						$sql="SELECT * FROM alternativa";
						$params=array();
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
	
	echo json_encode($result);
?>
