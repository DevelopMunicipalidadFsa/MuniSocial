<?php
    require '../Modelos/conexiones.php';

    // recibimos las variables
    $TramitesNombre = $_POST['tramiteNombre'];
    $TramitesDescripcion =  $_POST['tramiteDescipcion'];
    
    if(isset($_POST['tramiteNombre'])){

        $Calle = Conexiones::conMunicipalidadDigital()->prepare("INSERT INTO [MunicipalidadDigital].[dbo].[Tramites]
        ([idRubro]
        ,[TramitesNombre]
        ,[TramitesDescripcion]
        ,[TramitesCosto]
        ,[TramitesDuracion]
        ,[Activo])
        VALUES
        (2
        ,'$TramitesNombre'
        ,'$TramitesDescripcion'
        ,null
        ,null
        ,1)");

        if ($Calle->execute()) {
            $response = array(
                "messagge" => 'El tramite o tema de interes se agrego correctamente',
                "status" => 'success',
                "code" => 200
            );
        } else {
            $response = array(
                "messagge" => 'Error al agregar tramite o tema de interes',
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