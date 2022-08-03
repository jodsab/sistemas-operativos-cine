<?php
	header('Access-Control-Allow-Origin: *');  
	header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
	header("Content-Type: text/html; charset=utf-8");
    header("Content-type: image/jpg"); 
	header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");

$method = $_SERVER['REQUEST_METHOD'];
    include "../conectar.php";
    $mysqli = conectarDB();
    //sleep(1);	
	$JSONData = file_get_contents("php://input");
	$dataObject = json_decode($JSONData);    
    session_start();    

    $mysqli->set_charset('utf8');

    $productos = [];
    
  if ($nueva_consulta = $mysqli->prepare("SELECT * FROM t_pelicula AS P INNER JOIN t_genero ON P.T_genero_idT_genero= t_genero.idT_genero INNER JOIN (select t_pais.idT_pais, t_pais.nombre as PAIS from t_pais) AS S ON P.T_pais_idT_pais=S.idT_pais;"
 )) {
        $nueva_consulta->execute();
        $resultado = $nueva_consulta->get_result();
        if ($resultado->num_rows >= 1) {

            while($row = $resultado->fetch_assoc()){
                $productos[] = (array('idpelicula'=>$row['idT_pelicula'],
                'peliId'=>$row['titulo'],
                'pelifoto'=>base64_encode($row['imagefile']),
                'pelisinopsis'=>$row['sinopsis'],
                'pelidirector'=>$row['director'],
                'peliactores'=>$row['actores'], 
                'peliduracion'=>$row['duracion'], 
                'peliestreno'=>$row['fechaEstreno'], 
                'pelicensura'=>$row['censura'], 
                'peliestado'=>$row['estado'], 
                'peliestado'=>$row['estado'], 
                'pelipais'=>$row['PAIS'], 
                'peligenero'=>$row['nombre'] 
            ));
            } 

            echo json_encode($productos);
        }
        else {
              echo json_encode(array('connection'=>false, 'error' => 'No existe ni un producto'));
        }
        $nueva_consulta->close();
      }
      else{
        echo json_encode(array('connection'=>false, 'error' => 'No se ha podido conectar'));
      }
 // }
$mysqli->close();
?>