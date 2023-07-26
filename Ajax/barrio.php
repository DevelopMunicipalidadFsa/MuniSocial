<?php
    require '../Modelos/conexiones.php';
		
    // Número de registros recuperados
    $numberofrecords = 5;

    if(!isset($_POST['searchTerm'])){

        $Barrio = Conexiones::conMunicipalidadDigital()->prepare("SELECT Id, Detalle FROM Barrios WHERE Activo = 1");
        $Barrio->execute();

        $Lista_barrios = $Barrio->fetchAll();

    }else{

    $search = $_POST['searchTerm'];// Search text

    // Mostrar resultados
    $Barrio = Conexiones::conMunicipalidadDigital()->prepare("SELECT  Id, Detalle FROM Barrios WHERE Detalle like '%$search%' AND  Activo = 1");

    // $Barrio->bindParam(':nombre', '%'.$search.'%', PDO::PARAM_STR);
    $Barrio->execute();

    $Lista_barrios = $Barrio->fetchAll();

    }
   

$response = array();

// Leer los datos de MySQL
foreach($Lista_barrios as $pro){
    $response[] = array(
    "id" => $pro['Id'],
    "text" => $pro['Detalle']
    );
}

echo json_encode($response);
exit();