<html>
<body>
<?php
echo "PASE";

$serverName = "200.29.139.244"; //serverName\instanceName

$dbn="MAESTRA";

error_reporting(-1);
ini_set("display_errors", 1);
	
$conn = mssql_connect( ".","admin","Jgh240482710");
mssql_select_db($dbn,$conn);
		

	// function mssql_insert_id() {
		// $id = 0;
		// $res = mssql_query("SELECT @@identity AS id");
		// if ($row = mssql_fetch_array($res, MSSQL_ASSOC)) 
			// $id = $row["id"];		
		// return $id;
	// }
		
	mssql_query("BEGIN TRAN");  
	
	$codigo_auditor=$_POST['codigo_auditor'];
	$folio_sala=$_POST['folio_sala'];
	
	echo $codigo_auditor;
	echo $folio_sala;
	
	$sql="INSERT INTO [encuesta_redbull].[dbo].[TOMA] (id_auditor,id_sala,fecha_toma,estado_toma) values ($codigo_auditor,$folio_sala,NOW(),2)";
	$objQuery1 = mssql_query($sql); 
	
	if(!$objQuery1)  
	{  
		mssql_query("ROLLBACK");  
		echo "Error Save [".$strSQL."]";  
		exit();  
	}  
	
	mssql_query("COMMIT"); 
	
	$id_toma=mssql_insert_id();
	$cont=0;
	
	while($cont<44)
	{
		$id_categoria=$_POST['categoria'.cont];
		$id_pregunta=$_POST['pregunta'.cont];
		$id_item=$_POST['item'.cont];
		$valor=$_POST['valor'.cont];
		echo $id_categoria;
		echo $id_pregunta;
		echo $id_item;
		echo $valor;
		
		$sql="INSERT INTO [encuesta_redbull].[dbo].[RESPUESTA] (id_categoria,id_pregunta,id_item,id_toma,valor_respuesta) values ($id_categoria,$id_pregunta,$id_item,$id_toma,$valor)";
		$objQuery1 = mssql_query($sql); 
	
		if(!$objQuery1)  
		{  
			mssql_query("ROLLBACK");  
			echo "Error Save [".$strSQL."]";  
			exit();  
		}
		mssql_query("COMMIT"); 		
		$cont++;
	}
	echo "Toma ingresada exitosamente";
	// }
	// print_r($result);				
	// echo json_encode($result);	
?>
</body>
</html>
