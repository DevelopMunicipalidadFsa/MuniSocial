<?php
    require '../Modelos/conexiones.php';

    
    if(isset($_POST['idTramite'])){
        
        // recibimos las variables
        $idTramite = $_POST['idTramite'];

        $Calle = Conexiones::conMunicipalidadDigital()->prepare("DELETE [MunicipalidadDigital].[dbo].[Tramites_por_Contribuyentes] WHERE [idTamites_por_Contribuyentes] = $idTramite");

        if ($Calle->execute()) {
            $response = array(
                "messagge" => 'El tramite o tema de interes se elimino correctamente',
                "status" => 'success',
                "code" => 200
            );
        } else {
            $response = array(
                "messagge" => 'Error al eliminar tramite o tema de interes',
                "status" => 'error',
                "code" => 400
            );
        }

    } else {
        $response = array(
            "messagge" => 'Debe enviar parametro valido',
            "status" => 'error',
            "code" => 400
        );
    }

    echo json_encode($response);

    exit();