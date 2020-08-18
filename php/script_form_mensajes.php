<?php
header("Content-type: application/json; charset=utf-8");

//Decodificar la informacion obtenida del Cliente
$informacion=json_decode(file_get_contents("php://input"),true);
$nom=$informacion["_nombre"];
$coment=$informacion ["_comentario"];

//variable de conexión a la BD
$host="localhost";
$bd="bd_sac";
$usuario="root";
$passwd="vertrigo";

try{
	//establecer conexión a la BD
	$con=new PDO("mysql:host=$host;dbname=$bd;charset=utf8",$usuario,$passwd);
	$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	
	//Preparar la sentencia SQL 
	$stm=$con->prepare("INSERT INTO tbl_mensajes (c_nombre, c_comentario)VALUES(:nombre,:comentario)");
	
	//Ejecutar la sentencia SQL y procesar resultados
	$stm->execute(array(":nombre"=>$nom,":comentario"=>$coment));
	
	//***OBTENER LOS REGISTROS DE LA BD***/
		//Preparar la sentencia SQL (SELECT)
		$stm=$con->prepare("SELECT*FROM tbl_mensajes");
		
		//Ejecutar sentencia SQL
		$stm->execute();
		
		//Declarar un arreglo que contendra los registros de la BD
		$registros=array();
		
		//Obtener información
		while($fila=$stm->fetch(PDO::FETCH_ASSOC)){
			$registros[]=$fila;
		}
	//***OBTENER LOS REGISTROS DE LA BD***/
	
	
	//cerrar la conexion
	$stp=null;
	$con=null;	
	
	echo json_encode($registros);	
}catch(PDOException $ex){
	echo "error: ".$ex->getMessage();
	
}

//Enviando la respuesta Al Cliente (JSON)
//echo json_encode($informacion);

?>