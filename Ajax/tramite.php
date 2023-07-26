<?php
    require '../Modelos/conexiones.php';
		
    // Número de registros recuperados
    $numberofrecords = 5;

    if(!isset($_POST['searchTerm'])){

        $TemaInteres_tramites = Conexiones::conMunicipalidadDigital()->prepare("SELECT idTramites, idRubro, TramitesNombre, TramitesDescripcion, TramitesCosto, TramitesDuracion, Activo
        FROM Tramites WHERE (idRubro = 2) AND (Activo = 1)");
        $TemaInteres_tramites->execute();

        $Lista_TemaInteres_tramites = $TemaInteres_tramites->fetchAll();

    }else{

    $search = $_POST['searchTerm'];// Search text

    // Mostrar resultados
    $TemaInteres_tramites = Conexiones::conMunicipalidadDigital()->prepare("SELECT idTramites, idRubro, TramitesNombre, TramitesDescripcion, TramitesCosto, TramitesDuracion, Activo
    FROM Tramites WHERE (idRubro = 2) AND (Activo = 1) AND TramitesNombre like '%$search%'");
    
    $TemaInteres_tramites->execute();

    $Lista_TemaInteres_tramites = $TemaInteres_tramites->fetchAll();

    }
   

$response = array();

// Leer los datos de MySQL
foreach($Lista_TemaInteres_tramites as $pro){
    $response[] = array(
    "id" => $pro['idTramites'],
    "text" => $pro['TramitesNombre']
    );
}

echo json_encode($response);
exit();