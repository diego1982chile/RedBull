<?php
// $serverName = "localhost"; //serverName\instanceName
$serverName = "200.29.139.244";
// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
// $connectionInfo = array( "Database"=>"RedBull",  "CharacterSet" => "UTF-8");

$connectionInfo = array( "Database"=>"MAESTRA", "UID"=>"admin", "PWD"=>"Jgh240482710", "CharacterSet" => "UTF-8");
$conn = sqlsrv_connect( $serverName, $connectionInfo);


if( $conn ) {
     echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}

// print_r($_POST);

$caso= json_decode(stripslashes($_REQUEST['caso']));
$entidad= json_decode(stripslashes($_REQUEST['entidad']));

print_r($entidad);

// die($entidad);		
	// Entidades posibles
	
	switch($caso)
	{
		case '1': // La entidad es supervisor
		
		foreach ($entidad as $objeto)				
		{									
			$sql="INSERT INTO auditor (codigo_auditor,nombre_auditor,id_rol) VALUES(?,?,1)";
			// $nombre_topico=utf8_decode($objeto->nombre_topico);
			$params=array(&$objeto->COD_SUP, &$objeto->NOM_SUP);
			$stmt = sqlsrv_prepare($conn,$sql,$params);					
			if(!$stmt) 
				die( print_r( sqlsrv_errors(), true));						
			if( sqlsrv_execute( $stmt ) === false )
				die( print_r( sqlsrv_errors(), true));    																																																				
		}																																					
		break;	
		
		case '2': // La entidad es auditor
		
		foreach ($entidad as $objeto)				
		{									
			$sql="SELECT id_auditor from auditor where codigo_auditor=?";
			$params=array(&$objeto->COD_SUP);
			$stmt = sqlsrv_prepare($conn,$sql,$params);					
			if(!$stmt) 
				die( print_r( sqlsrv_errors(), true));						
			if( sqlsrv_execute( $stmt ) === false )
				die( print_r( sqlsrv_errors(), true)); 
			
			while( $obj = sqlsrv_fetch_object( $stmt)) {
				$id_supervisor=$obj->id_auditor;
			}
			
			$sql="INSERT INTO auditor (codigo_auditor,nombre_auditor,id_rol,id_auditor_padre) VALUES(?,?,2,?)";
			// $nombre_seccion=utf8_decode($objeto->nombre_seccion);
			$params=array(&$objeto->COD_AUD, &$objeto->NOM_AUD,&$id_supervisor);
			$stmt = sqlsrv_prepare($conn,$sql,$params);					
			if(!$stmt) 
				die( print_r( sqlsrv_errors(), true));						
			if( sqlsrv_execute( $stmt ) === false )
				die( print_r( sqlsrv_errors(), true));    																																													
		}																																					
		break;						
		
		case '3': // La entidad es auditor_sala
		
		foreach ($entidad as $objeto)				
		{							
			$sql="SELECT id_sala from sala where folio=?";
			$params=array(&$objeto->FOLIO);
			$stmt = sqlsrv_prepare($conn,$sql,$params);					
			if(!$stmt) 
				die( print_r( sqlsrv_errors(), true));						
			if( sqlsrv_execute( $stmt ) === false )
				die( print_r( sqlsrv_errors(), true)); 

			while( $obj = sqlsrv_fetch_object( $stmt)) {
				$id_sala=$obj->id_sala;
			}

			$sql="SELECT id_auditor from auditor where codigo_auditor=?";
			$params=array(&$objeto->COD_AUD);
			$stmt = sqlsrv_prepare($conn,$sql,$params);					
			if(!$stmt) 
				die( print_r( sqlsrv_errors(), true));						
			if( sqlsrv_execute( $stmt ) === false )
				die( print_r( sqlsrv_errors(), true)); 
			
			while( $obj = sqlsrv_fetch_object( $stmt)) {
				$id_auditor=$obj->id_auditor;
			}			
						
			$sql="INSERT INTO auditor_sala (id_auditor,id_sala,id_tipo) VALUES(?,?,1)";
			// $nombre_categoria=utf8_decode($objeto->nombre_categoria);
			$params=array(&$id_auditor,&$id_sala);
			$stmt = sqlsrv_prepare($conn,$sql,$params);					
			if(!$stmt) 
				die( print_r( sqlsrv_errors(), true));						
			 if( sqlsrv_execute( $stmt ) === false )
				die( print_r( sqlsrv_errors(), true));    	

			set_time_limit(0); 				
		}																																					
		break;															
	}																									
?>
