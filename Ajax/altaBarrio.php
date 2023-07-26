<?php
    require '../Modelos/conexiones.php';

    // recibimos las variables
    $TramitesNombre = $_POST['tramiteNombre'];
    $TramitesDescripcion =  $_POST['tramiteDescipcion'];
    
    if(isset($_POST['tramiteNombre'])){

        $Calle = Conexiones::conMunicipalidadDigital()->prepare("INSERT INTO Barrios
        ([Detalle]
        ,[NroLR]
        ,[Activo])
        VALUES
        ('$TramitesNombre'
        ,'$TramitesDescripcion'
        , 1 )");

        if ($Calle->execute()) {
            $response = array(
                "messagge" => 'El barrio se agrego correctamente',
                "status" => 'success',
                "code" => 200
            );
        } else {
            $response = array(
                "messagge" => 'Error al agregar barrio',
                "status" => 'error',
                "code" => 400
            );
        }

    } else {
        $response = array(
            "messagge" => 'Debe enviar un parametro valido',
            "status" => 'error',
            "code" => 400
        );
    }

    echo json_encode($response);

    exit();