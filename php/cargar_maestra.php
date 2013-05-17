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

date_default_timezone_set('America/Santiago');

// if( !$conn )      
	// die( print_r( sqlsrv_errors(), true));

$caso= $_GET['caso'];

// $caso='1';

if($caso=='2')
{
	$id_auditor= $_GET['id_auditor'];
	$id_medicion= $_GET['id_medicion'];
}
	
$result=array();
$result2=array();	

	try
	{	
		// Entidades posibles
				
		switch($caso)
		{
			case '1': // La entidad es auditor y medicion
																	
				// $sql="SELECT id_auditor,codigo_auditor,nombre_auditor,id_auditor_padre FROM [MAESTRA].[dbo].[AUDITOR] where id_rol=2";
				$sql="SELECT * FROM [MAESTRA].[dbo].[AUDITOR] where id_rol=2";   
				
				$data = mssql_query( $sql, $conn);
				
				while( $row =  mssql_fetch_assoc ( $data ) )
				{			
					$format_row=array();
					foreach($row as $key=>$value)
					{
						$tokens=explode('_',$key);					
						
						if($tokens[0]=='id')
							$format_row[strtolower($key)]=(is_null($value)? 0:intval(trim($value)));			
						else
							$format_row[strtolower($key)]=trim(utf8_encode($value));			
					}
					// print_r($format_row);
					$result[]=$format_row;					
				}		
				$sql="SELECT id_medicion,nombre_medicion,descripcion,fecha_ini,fecha_fin FROM [encuesta_redbull].[dbo].[MEDICION]"; 
				$data = mssql_query( $sql, $conn);				
				$fecha_actual=date('Y-m-d');				
				$flag=true;				
								
				while( $row =  mssql_fetch_assoc ( $data ) )
				{			
					$format_row=array();
					foreach($row as $key=>$value)
					{
						$tokens=explode('_',$key);					
						
						if($tokens[0]=='id')
							$format_row[strtolower($key)]=(is_null($value)? 0:intval(trim($value)));			
						else
							$format_row[strtolower($key)]=trim(utf8_encode($value));			
					}	
					
					// echo "fecha_actual=$fecha_actual fecha_ini=".date('Y-m-d',strtotime($format_row['fecha_ini']))." fecha_fin=".date('Y-m-d',strtotime($format_row['fecha_fin']));
					// Si la fecha actual es menor que la fecha de fin de esta medición, dejar esta medicion como activa
					if($fecha_actual<date('Y-m-d',strtotime($format_row['fecha_fin'])) && $flag)
					{
						$format_row['activa']='selected';
						$flag=false;
					}
					else
					{
						$format_row['activa']='';
					}
					// print_r($format_row);
					$result2[]=$format_row;					
				}	
				echo json_encode(array("Codigo"=>1,"Mensaje"=>"Datos recuperados exitosamente","auditores"=>$result,"mediciones"=>$result2));								
			break;	
			
			case '2': // La entidad es sala
							
				$sql="SELECT folio,direccion,calle,numero,id_toma FROM [MAESTRA].[dbo].[AUDITOR_SALA] AS asala INNER JOIN [MAESTRA].[dbo].[SALA] AS s on asala.id_sala=s.id_sala and asala.id_auditor=$id_auditor LEFT JOIN [encuesta_redbull].[dbo].[TOMA] AS t on t.id_sala=s.folio and t.id_medicion=$id_medicion";  																																													
				
				$data = mssql_query( $sql, $conn);	
				// print_r($data);		

				while( $row =  mssql_fetch_assoc ( $data ) )
				{			
					$format_row=array();
					foreach($row as $key=>$value)
					{
						$tokens=explode('_',$key);					
						
						if($tokens[0]=='id')
							$format_row[strtolower($key)]=(is_null($value)? 0:intval(trim($value)));			
						else
							$format_row[strtolower($key)]=strlen(trim($value))>20? substr(trim(utf8_encode($value)),0,20).'...':trim(utf8_encode($value));			
					}
					// print_r($format_row);
					$result[]=$format_row;
				}				
				echo json_encode(array("Codigo"=>1,"Mensaje"=>"Datos recuperados exitosamente","salas"=>$result));
			break;																							
		}			
	}
	catch (Exception $e)
	{
		$msg = "Error Code: ".$e->getCode()."##Error Message: ".$e->getMessage()."##Strack Trace: ".nl2br($e->getTraceAsString());
		echo json_encode (array('Codigo' => 0, 'Mensaje' => $msg));
		$db->rollback();
	}
	// print_r($result);					
?>
