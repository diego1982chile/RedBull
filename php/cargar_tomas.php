<?php


error_reporting(-1);
ini_set("display_errors", 1);

$serverName = "200.29.139.244"; //serverName\instanceName

$dbn1="MAESTRA";
$dbn2="encuesta_redbull";

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
// $connectionInfo = array( "Database"=>"MAESTRA", "UID"=>"admin", "PWD"=>"Jgh240482710", "CharacterSet" => "UTF-8");
	
$conn1 = mssql_connect( ".","admin","Jgh240482710");
$conn2 = mssql_connect( ".","admin","Jgh240482710");

mssql_select_db($dbn1,$conn1);
mssql_select_db($dbn2,$conn2);
	
$result=array();	
$auditores=array();
$salas=array();						
	
	// Obtener maestra de auditores
	
	$sql="SELECT * FROM [MAESTRA].[dbo].[AUDITOR] where id_rol=2";
	$data = mssql_query( $sql, $conn1);
	
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
		$auditores[$format_row['codigo_auditor']]=$format_row['nombre_auditor'];
	}
	
	// Obtener maestra de salas
	
	$sql="SELECT folio,direccion,calle,numero FROM [MAESTRA].[dbo].[SALA]";
	$data = mssql_query( $sql, $conn2);
	
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
		$salas[$format_row['folio']]=$format_row['folio'];
	}
		
	
	// Obtener todas las tomas
	
	$sql="SELECT * FROM [encuesta_redbull].[dbo].[TOMA]";
	$data = mssql_query( $sql, $conn2);
	
	while( $row =  mssql_fetch_assoc ( $data ) )
	{			
		$format_row=array();
		foreach($row as $key=>$value)
		{
			$format_row['id']=$row['ID_TOMA'];
			$format_row['sala']=$salas[intval(trim($row['ID_SALA']))];
			$format_row['auditor']=$auditores[intval(trim($row['ID_AUDITOR']))];
			$format_row['fecha']=$row['FECHA_TOMA'];
			$format_row['estado']=$row['ESTADO_TOMA'];		
		}
		// print_r($format_row);
		$result[]=$format_row;
	}		
	// print_r($result);	
	echo json_encode($result);	
?>
