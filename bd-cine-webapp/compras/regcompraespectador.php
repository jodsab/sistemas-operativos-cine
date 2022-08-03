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
	    
	$idespectador =	$dataObject-> idespectador;
    
  if ($nueva_consulta = $mysqli->prepare("INSERT INTO `t_compra_has_t_espectador`(`T_compra_idT_compra`, `T_espectador_idT_espectador`) VALUES ((SELECT MAX(t_compra.idT_compra) FROM t_compra), ?);"
 )) {
        $nueva_consulta->bind_param('s', $idespectador);
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