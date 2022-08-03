<?php
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");
$method = $_SERVER['REQUEST_METHOD'];
    include "../conectar.php";
    $mysqli = conectarDB();
    //sleep(1);	
	$JSONData = file_get_contents("php://input");
	$dataObject = json_decode($JSONData);    
    session_start();    
    $mysqli->set_charset('utf8');
	    
	$nombre= $dataObject-> user_nombre;
	$appaterno= $dataObject-> user_appaterno;
	$apmaterno= $dataObject-> user_apmaterno;
	$email= $dataObject-> user_email;
	$password = $dataObject-> user_password;
    
  if ($nueva_consulta = $mysqli->prepare("INSERT INTO t_espectador ( 
  `contrasena`, 
  `nombres`,
  `apellidoPaterno`,
  `apellidoMaterno`,
  `sexo`,
  `telefono`,
  `celular`,
  `email`
  ) 
  VALUES (?, ?,?,?,'F', '123456789','123456789',?)
  "
 )) {
        $nueva_consulta->bind_param('sssss',$password,$nombre,$appaterno,$apmaterno,$email);
        $nueva_consulta->execute();
/*         $resultado = $nueva_consulta->get_result();
        if ($resultado->num_rows >= 1) {
            $datos = $resultado->fetch_assoc(); */

            if(mysqli_affected_rows($mysqli) == 1){
                echo json_encode(array('conectado'=>true));
            }
            else{
                echo json_encode(array('conectado'=>false));
            }
/* 
        }
        else {
              echo json_encode(array('conectado'=>false, 'error' => 'El usuario no existe.'));
        }
        $nueva_consulta->close(); */
      }
      else{
        echo json_encode(array('conectado'=>false, 'error' => 'No existe Login'));
      }
 // }
$mysqli->close();
?>