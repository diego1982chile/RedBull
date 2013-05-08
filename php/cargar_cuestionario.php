<?php
// header("Content-Type: text/html;charset=utf-8");

$serverName = "200.29.139.244"; //serverName\instanceName

$dbn="MAESTRA";

$conn = mssql_connect( ".","admin","Jgh240482710");
mssql_select_db($dbn,$conn);

error_reporting(-1);
ini_set("display_errors", 1);
	
$conn = mssql_connect( ".","admin","Jgh240482710");
mssql_select_db($dbn,$conn);

$caso= $_GET['caso'];

$result=array();	

				// Entidades posibles
				
				switch($caso)
				{
					case '1': // La entidad es topico													
						$sql="SELECT * FROM [encuesta_redbull].[dbo].[TOPICO]";
						$data = mssql_query( $sql, $conn);    																																																																																						
					break;	
					
					case '2': // La entidad es seccion									  																																													
						$sql="SELECT * FROM [encuesta_redbull].[dbo].[SECCION]";
						$data = mssql_query( $sql, $conn);   																																			
					break;						
					
					case '3': // La entidad es categoria
						$sql="SELECT * FROM [encuesta_redbull].[dbo].[CATEGORIA]";
						$data = mssql_query( $sql, $conn);   																																																																																						
					break;					
					
					case '4': // La entidad es pregunta
 						$sql="SELECT * FROM [encuesta_redbull].[dbo].[PREGUNTA]";
						$data = mssql_query( $sql, $conn);   																																																																																							
					break;	
	
					case '5': // La entidad es pregunta_categoria  																																													
 						$sql="SELECT * FROM [encuesta_redbull].[dbo].[PREGUNTA_CATEGORIA]";
						$data = mssql_query( $sql, $conn); 																																										
					break;

					case '6': // La entidad es item
  						$sql="SELECT * FROM [encuesta_redbull].[dbo].[ITEM]";
						$data = mssql_query( $sql, $conn);  																																																																																				
					break;						
	
					case '7': // La entidad es alternativa														
  						$sql="SELECT * FROM [encuesta_redbull].[dbo].[ALTERNATIVA]";
						$data = mssql_query( $sql, $conn);   																																																																																						
					break;														
				}							

	while( $row = mssql_fetch_assoc ( $data ) )
	{
		$format_row=array();
		foreach($row as $key=>$value)
		{
			$tokens=explode('_',$key);					
			
			if($tokens[0]=='ID')
				$format_row[strtolower($key)]=intval(trim(utf8_encode($value)));			
			else
				$format_row[strtolower($key)]=trim(utf8_encode($value));			
		}
		$result[]=$format_row;
	}
	// print_r($result);				
	
	echo json_encode($result);
?>
