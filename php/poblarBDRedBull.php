<?php
// $serverName = "localhost"; //serverName\instanceName
$serverName = "200.29.139.244";
// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
// $connectionInfo = array( "Database"=>"RedBull",  "CharacterSet" => "UTF-8");

$connectionInfo = array( "Database"=>"encuesta_redbull", "UID"=>"admin", "PWD"=>"Jgh240482710", "CharacterSet" => "UTF-8");
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
					case '1': // La entidad es topico
					
					foreach ($entidad as $objeto)				
					{									
						$sql="INSERT INTO topico (numero_topico,nombre_topico,color_topico,color_letra_topico) VALUES(?,?,?,?)";
						// $nombre_topico=utf8_decode($objeto->nombre_topico);
						$params=array(&$objeto->numero_topico, &$objeto->nombre_topico, &$objeto->color_topico, &$objeto->color_letra);
						$stmt = sqlsrv_prepare($conn,$sql,$params);					
						if(!$stmt) 
							die( print_r( sqlsrv_errors(), true));						
						 if( sqlsrv_execute( $stmt ) === false )
							die( print_r( sqlsrv_errors(), true));    																																													
					}																																					
					break;	
					
					case '2': // La entidad es seccion
					
					foreach ($entidad as $objeto)				
					{									
						$sql="INSERT INTO seccion (numero_seccion,nombre_seccion,color_seccion,id_topico) VALUES(?,?,?,?)";
						// $nombre_seccion=utf8_decode($objeto->nombre_seccion);
						$params=array(&$objeto->numero_seccion,&$objeto->nombre_seccion, &$objeto->color_seccion, &$objeto->id_topico);
						$stmt = sqlsrv_prepare($conn,$sql,$params);					
						if(!$stmt) 
							die( print_r( sqlsrv_errors(), true));						
						 if( sqlsrv_execute( $stmt ) === false )
							die( print_r( sqlsrv_errors(), true));    																																													
					}																																					
					break;						
					
					case '3': // La entidad es categoria
					
					foreach ($entidad as $objeto)				
					{									
						$sql="INSERT INTO categoria (nombre_categoria) VALUES(?)";
						// $nombre_categoria=utf8_decode($objeto->nombre_categoria);
						$params=array(&$objeto->nombre_categoria);
						$stmt = sqlsrv_prepare($conn,$sql,$params);					
						if(!$stmt) 
							die( print_r( sqlsrv_errors(), true));						
						 if( sqlsrv_execute( $stmt ) === false )
							die( print_r( sqlsrv_errors(), true));    																																													
					}																																					
					break;					
					
					case '4': // La entidad es pregunta
					
					foreach ($entidad as $objeto)				
					{									
						$sql="INSERT INTO pregunta (id_seccion,numero_pregunta,contenido_pregunta,tipo,tipo2) VALUES(?,?,?,?,?)";
						// $contenido_pregunta=utf8_decode($objeto->contenido_pregunta);
						$params=array(&$objeto->id_seccion,&$objeto->numero_pregunta,&$objeto->contenido_pregunta, &$objeto->tipo, &$objeto->tipo2);
						$stmt = sqlsrv_prepare($conn,$sql,$params);					
						if(!$stmt) 
							die( print_r( sqlsrv_errors(), true));						
						 if( sqlsrv_execute( $stmt ) === false )
							die( print_r( sqlsrv_errors(), true));    																																													
					}																																					
					break;	
	
					case '5': // La entidad es pregunta_categoria
					
					foreach ($entidad as $objeto)				
					{									
						$sql="INSERT INTO pregunta_categoria (id_pregunta,id_categoria) VALUES(?,?)";
						$params=array(&$objeto->id_pregunta, &$objeto->id_categoria);
						$stmt = sqlsrv_prepare($conn,$sql,$params);					
						if(!$stmt) 
							die( print_r( sqlsrv_errors(), true));						
						 if( sqlsrv_execute( $stmt ) === false )
							die( print_r( sqlsrv_errors(), true));    																																													
					}																																					
					break;

					case '6': // La entidad es item
					
					foreach ($entidad as $objeto)				
					{									
						$sql="INSERT INTO item (nombre_item) VALUES(?)";
						// $nombre_item=utf8_decode($objeto->nombre_pregunta);
						$params=array(&$objeto->nombre_item);						
						$stmt = sqlsrv_prepare($conn,$sql,$params);					
						if(!$stmt) 
							die( print_r( sqlsrv_errors(), true));						
						 if( sqlsrv_execute( $stmt ) === false )
							die( print_r( sqlsrv_errors(), true));    																																													
					}																																					
					break;						
	
					case '7': // La entidad es alternativa
					
					foreach ($entidad as $objeto)				
					{									
						$sql="INSERT INTO alternativa (id_pregunta,id_categoria,id_item) VALUES(?,?,?)";
						$params=array(&$objeto->id_pregunta, &$objeto->id_categoria, &$objeto->id_item);
						$stmt = sqlsrv_prepare($conn,$sql,$params);					
						if(!$stmt) 
							die( print_r( sqlsrv_errors(), true));						
						 if( sqlsrv_execute( $stmt ) === false )
							die( print_r( sqlsrv_errors(), true));    																																													
					}																																					
					break;			

					case '8': // La entidad es medicion
					
					foreach ($entidad as $objeto)				
					{				
						$fecha_ini;
						$fecha_fin;
						switch($objeto->id_medicion)
						{
							case '1':
								$fecha_ini=new DateTime("2013-03-05");
								$fecha_fin=new DateTime("2013-04-28");
								break;
							case '2':
								$fecha_ini=new DateTime("2013-05-22");
								$fecha_fin=new DateTime("2013-06-27");							
								break;								
							case '3':
								$fecha_ini=new DateTime("2013-07-22");
								$fecha_fin=new DateTime("2013-09-23");	
								break;								
							case '4':
								$fecha_ini=new DateTime("2013-10-21");
								$fecha_fin=new DateTime("2013-12-20");	
								break;
						}
						$sql="INSERT INTO medicion (nombre_medicion,descripcion,fecha_ini,fecha_fin) VALUES(?,?,?,?)";
						$params=array(&$objeto->nombre_medicion, &$objeto->descripcion, &$fecha_ini, &$fecha_fin);
						$stmt = sqlsrv_prepare($conn,$sql,$params);					
						if(!$stmt) 
							die( print_r( sqlsrv_errors(), true));						
						 if( sqlsrv_execute( $stmt ) === false )
							die( print_r( sqlsrv_errors(), true));    																																													
					}																																					
					break;						
										
				}																									
?>
