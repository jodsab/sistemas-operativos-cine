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
	    
	$pelicula = $dataObject-> pelicula;

  $locales = [];
    
  if ($nueva_consulta = $mysqli->prepare("SELECT * from t_sala INNER JOIN t_funcion on t_sala.idT_sala=t_funcion.T_sala_idT_sala inner JOIN t_local ON t_sala.T_local_idT_local=t_local.idT_local WHERE t_funcion.T_pelicula_idT_pelicula= ?;"
 )) {
        $nueva_consulta->bind_param('s', $pelicula);
        $nueva_consulta->execute();
        $resultado = $nueva_consulta->get_result();

        while($datos = $resultado->fetch_assoc()){
          $locales[] = (array('conectado'=>true,
          'local'=>$datos['direccion'],
          'idpelicula'=>$datos['T_pelicula_idT_pelicula'],
          'idsala'=>$datos['idT_sala'],
          'localnombre'=>$datos['nombre'],
          'tiposala'=>$datos['tipoSala'],
          'funcion'=>$datos['idT_funcion'],
          'horario'=>$datos['horario']));
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