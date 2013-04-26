<?php
header("Content-Type: text/html;charset=utf-8");

$serverName = "localhost"; //serverName\instanceName

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
$connectionInfo = array( "Database"=>"RedBull");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}

print_r($_POST);

$caso= json_decode(stripslashes($_REQUEST['caso']));
$entidad= json_decode(stripslashes($_REQUEST['entidad']));

function refValues($arr){ 
    if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+ 
    { 
        $refs = array(); 
        foreach($arr as $key => $value) 
            $refs[$key] = &$arr[$key]; 
        return $refs; 
    } 
    return $arr; 
} 

    $db->autocommit(FALSE);
	
            try
			{			
				// Hitos posibles
				
				switch($caso)
				{
					case '1': // La entidad es topico
					
					foreach ($entidad as $objeto)				
					{																																											
						$stmt = $db->prepare("INSERT INTO topico (`numero_topico`,`nombre_topico`,`color_topico`,`color_letra_topico`) VALUES(?,?,?,?)");					
						if(!$stmt) 
							throw new Exception($db->error, $db->errno);						
						if(!$stmt->bind_param("ssss", $objeto->numero_topico, $objeto->nombre_topico, $objeto->color_topico, $objeto->color_letra))
							throw new Exception("Binding input parameters failed: (" . $db->error . ") ", $db->errno);														
						if(!$stmt->execute())
							throw new Exception("Execute failed: (" . $db->error . ") " , $db->errno);																	
						if($db->affected_rows != 1) 
							throw new Exception('No se pudo ingresar la entidad topico');																																																	
					}																																					
					break;	
					case '2': // La entidad es seccion
					
					foreach ($entidad as $objeto)				
					{																																											
						$stmt = $db->prepare("INSERT INTO seccion (`numero_seccion`,`nombre_seccion`,`color_seccion`) VALUES(?,?,?)");					
						if(!$stmt) 
							throw new Exception($db->error, $db->errno);						
						if(!$stmt->bind_param("sss", $objeto->numero_seccion, $objeto->nombre_seccion, $objeto->color_seccion))
							throw new Exception("Binding input parameters failed: (" . $db->error . ") ", $db->errno);														
						if(!$stmt->execute())
							throw new Exception("Execute failed: (" . $db->error . ") " , $db->errno);																	
						if($db->affected_rows != 1) 
							throw new Exception('No se pudo ingresar la entidad seccion');																																																	
					}																																					
					break;
					
					case '3': // La entidad es categoria
					
					foreach ($entidad as $objeto)				
					{																																											
						$stmt = $db->prepare("INSERT INTO categoria (`numero_categoria`,`nombre_categoria`) VALUES(?,?)");					
						if(!$stmt) 
							throw new Exception($db->error, $db->errno);						
						if(!$stmt->bind_param("ss", $objeto->numero_categoria, $objeto->nombre_categoria))
							throw new Exception("Binding input parameters failed: (" . $db->error . ") ", $db->errno);														
						if(!$stmt->execute())
							throw new Exception("Execute failed: (" . $db->error . ") " , $db->errno);																	
						if($db->affected_rows != 1) 
							throw new Exception('No se pudo ingresar la entidad categoria');																																																	
					}																																					
					break;	

					case '4': // La entidad es pregunta
					
					foreach ($entidad as $objeto)				
					{																																											
						$stmt = $db->prepare("INSERT INTO pregunta (`numero_pregunta`,`contenido_pregunta`,`tipo`,`tipo2`) VALUES(?,?,?,?)");					
						if(!$stmt) 
							throw new Exception($db->error, $db->errno);						
						if(!$stmt->bind_param("ssss", $objeto->numero_pregunta, $objeto->contenido_pregunta, $objeto->tipo, $objeto->tipo2))
							throw new Exception("Binding input parameters failed: (" . $db->error . ") ", $db->errno);														
						if(!$stmt->execute())
							throw new Exception("Execute failed: (" . $db->error . ") " , $db->errno);																	
						if($db->affected_rows != 1) 
							throw new Exception('No se pudo ingresar la entidad categoria');																																																	
					}																																					
					break;		

					case '5': // La entidad es pregunta_categoria
					
					foreach ($entidad as $objeto)				
					{																																											
						$stmt = $db->prepare("INSERT INTO pregunta_categoria (`id_pregunta`,`id_categoria`) VALUES(?,?)");					
						if(!$stmt) 
							throw new Exception($db->error, $db->errno);						
						if(!$stmt->bind_param("ss", $objeto->id_pregunta, $objeto->id_categoria))
							throw new Exception("Binding input parameters failed: (" . $db->error . ") ", $db->errno);														
						if(!$stmt->execute())
							throw new Exception("Execute failed: (" . $db->error . ") " , $db->errno);																	
						if($db->affected_rows != 1) 
							throw new Exception('No se pudo ingresar la entidad categoria');																																																	
					}																																					
					break;			

					case '6': // La entidad es pregunta_categoria
					
					foreach ($entidad as $objeto)				
					{																																											
						$stmt = $db->prepare("INSERT INTO item (`id_item`,`nombre_item`) VALUES(?,?)");					
						if(!$stmt) 
							throw new Exception($db->error, $db->errno);						
						if(!$stmt->bind_param("ss", $objeto->id_item, $objeto->nombre_item))
							throw new Exception("Binding input parameters failed: (" . $db->error . ") ", $db->errno);														
						if(!$stmt->execute())
							throw new Exception("Execute failed: (" . $db->error . ") " , $db->errno);																	
						if($db->affected_rows != 1) 
							throw new Exception('No se pudo ingresar la entidad categoria');																																																	
					}																																					
					break;		

					case '7': // La entidad es alternativa
					
					foreach ($entidad as $objeto)				
					{																																											
						$stmt = $db->prepare("INSERT INTO alternativa (`id_pregunta`,`id_categoria`,`id_item`) VALUES(?,?,?)");					
						if(!$stmt) 
							throw new Exception($db->error, $db->errno);						
						if(!$stmt->bind_param("sss", $objeto->id_pregunta, $objeto->id_categoria, $objeto->id_item))
							throw new Exception("Binding input parameters failed: (" . $db->error . ") ", $db->errno);														
						if(!$stmt->execute())
							throw new Exception("Execute failed: (" . $db->error . ") " , $db->errno);																	
						if($db->affected_rows != 1) 
							throw new Exception('No se pudo ingresar la entidad categoria');																																																	
					}																																					
					break;					
										
				}																						
				echo json_encode(array('resultado' => true, 'mensaje' => 'Entidad agregada con éxito'));
				$db->commit();				
				$stmt->close();				
            } 			
			catch (Exception $e){
                $msg = "Error Code: ".$e->getCode()."##Error Message: ".$e->getMessage()."##Strack Trace: ".nl2br($e->getTraceAsString());
                echo json_encode (array('resultado' => false, 'mensaje' => $msg));
                $db->rollback();
            }
	$db->close();
?>
