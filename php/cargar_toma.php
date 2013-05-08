<?php

error_reporting(-1);
ini_set("display_errors", 1);

$serverName = "200.29.139.244"; //serverName\instanceName

$dbn="encuesta_redbull";

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
// $connectionInfo = array( "Database"=>"MAESTRA", "UID"=>"admin", "PWD"=>"Jgh240482710", "CharacterSet" => "UTF-8");
	
$conn = mssql_connect( ".","admin","Jgh240482710");

mssql_select_db($dbn,$conn);
	
$result=array();	
$auditores=array();
$salas=array();							
	
	
	// Obtener todas las tomas
	
	$sql="SELECT ID_RESPUESTA,ID_CATEGORIA,ID_PREGUNTA,ID_ITEM,VALOR_RESPUESTA FROM [encuesta_redbull].[dbo].[RESPUESTA] WHERE ID_TOMA=$id_toma";
	$data = mssql_query( $sql, $conn);
	
	while( $row =  mssql_fetch_assoc ( $data ) )
	{			
		$format_row=array();
		foreach($row as $key=>$value)
		{
			$format_row['id_respuesta']=intval($row['ID_RESPUESTA']);
			$format_row['valor_respuesta']=$row['VALOR_RESPUESTA'];
			$format_row['id_item']=$row['ID_ITEM'];
			$format_row['id_pregunta']=intval($row['ID_PREGUNTA']);		
			$format_row['id_categoria']=$row['ID_CATEGORIA'];					
		}
		// print_r($format_row);
		$result[]=$format_row;
	}		
	// print_r($result);	
	echo json_encode($result);	
?>
