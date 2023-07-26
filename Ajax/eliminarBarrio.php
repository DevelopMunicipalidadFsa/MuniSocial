<?php
    require '../Modelos/conexiones.php';

    
    if(isset($_POST['idTramite'])){
        
        // recibimos las variables
        $idTramite = $_POST['idTramite'];

        $Calle = Conexiones::conMunicipalidadDigital()->prepare("UPDATE [MunicipalidadDigital].[dbo].[Barrios] SET [Activo] = 0 WHERE [Id] = $idTramite");

        if ($Calle->execute()) {
            $response = array(
                "messagge" => 'El Barrio se elimino correctamente',
                "status" => 'success',
                "code" => 200
            );
        } else {
            $response = array(
                "messagge" => 'Error al eliminar Barrio',
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