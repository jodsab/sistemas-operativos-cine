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
	    
	$elnrodesala = $dataObject-> nsala;

  $locales = [];
    
  if ($nueva_consulta = $mysqli->prepare("SELECT * from t_butaca where t_butaca.funcion= ?"
 )) {
        $nueva_consulta->bind_param('s', $elnrodesala);
        $nueva_consulta->execute();
        $resultado = $nueva_consulta->get_result();

        while($datos = $resultado->fetch_assoc()){
          $locales[] = (array('conectado'=>true,
          'numero'=>$datos['numero'],
          'fila'=>$datos['fila'],
          'funcion'=>$datos['funcion'],
          'ocupado'=>$datos['OCUPADO']));
      } 

      echo json_encode($locales);

        $nueva_consulta->close();
      }
      else{
        echo json_encode(array('conectado'=>false, 'error' => 'No existe Login'));
      }
 // }
$mysqli->close();
?>