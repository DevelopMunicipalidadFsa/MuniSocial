<?php
    require '../Modelos/conexiones.php';
		
    // Número de registros recuperados
    $numberofrecords = 5;

    if(!isset($_POST['searchTerm2'])){

        $Calle = Conexiones::conSW()->prepare("SELECT Id, IdcalleCatastro, Detalle, Eliminar, IdReemplazo FROM Calles");
        $Calle->execute();

        $Lista_Calles = $Calle->fetchAll();
        
    }else{

    $search2 = $_POST['searchTerm2'];// Search text

    // Mostrar resultados
    $Calle = Conexiones::conSW()->prepare("SELECT  Id, IdcalleCatastro, Detalle, Eliminar, IdReemplazo FROM Calles WHERE Detalle like '%$search2%'");

    // $Calle->bindParam(':nombre', '%'.$search.'%', PDO::PARAM_STR);
    $Calle->execute();

    $Lista_Calles = $Calle->fetchAll();

    }
   

$response = array();

// Leer los datos de MySQL
foreach($Lista_Calles as $pro){
    $response[] = array(
    "id" => $pro['Id'],
    "text" => $pro['Detalle']
    );
}

echo json_encode($response);
exit();