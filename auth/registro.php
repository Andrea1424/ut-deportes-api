<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");

$json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR

$params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE

require "../config/conexion.php"; // IMPORTA EL ARCHIVO CON LA CONEXION A LA DB

// GENERA LOS DATOS DE RESPUESTA
$response = new Result();
class Result {}

// REALIZA LA QUERY A LA DB
$res = mysqli_query($conexion, "SELECT * FROM `usuarios` WHERE `telefono`='".$params->telefono."'");
  if($res->num_rows > 0) {
    $response->resultado = false;
    $response->mensaje = 'Usuario existente';
  }else{

    $resultado = mysqli_query($conexion,"INSERT INTO `usuarios` (`idUsuario`, `idCarrera`, `nombres`, `apellidos`, `matricula`, `telefono`, `sexo`, `grupo`) VALUES
      (NULL, '".$params->idCarrera."', '".$params->nombres."', '".$params->apellidos."', '".$params->matricula."', '".$params->telefono."', '".$params->sexo."', '".$params->grupo."');");

      if($resultado){
        $response->resultado = true;
        $response->mensaje = 'Registro completado';
      } else {
        $response->resultado = false;
        $response->mensaje = 'No se pudo registrar';
      }
}

header('Content-Type: text/html');

echo json_encode($response); // MUESTRA EL JSON GENERADO
?>
