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
	    
	$sala =	$dataObject-> sala;
	$local =	$dataObject-> local;
	$funcion =	$dataObject-> funcion;
	$numero =	$dataObject-> numero;
	$fila =	$dataObject-> fila;
    
  if ($nueva_consulta = $mysqli->prepare("UPDATE t_butaca SET OCUPADO = 1 WHERE T_sala_idT_sala = ? AND T_sala_T_local_idT_local = ? AND funcion = ? AND numero = ? AND fila = ?;"
 )) {
        $nueva_consulta->bind_param('sssss', $sala, $local, $funcion, $numero, $fila);
        $nueva_consulta->execute();
        $resultado = $nueva_consulta->get_result();

            if(mysqli_affected_rows($mysqli) == 1){
                echo json_encode(array('conectado'=>true,'exitoso'=>'Compra exitosa'));
            }
            else{
                echo json_encode(array('conectado'=>false));
            }


      }
      else{
        echo json_encode(array('conectado'=>false, 'error' => 'No se puede pagar'));
      }
 // }
$mysqli->close();
?>