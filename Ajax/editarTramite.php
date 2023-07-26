<?php
    require '../Modelos/conexiones.php';

    
    if(isset($_POST['editarIdTramite']) && isset($_POST['editarTramiteNombre'])){
        
        // recibimos las variables
        $editarIdTramite = $_POST['editarIdTramite'];
        $editarTramiteNombre = $_POST['editarTramiteNombre'];
        $editarTramiteDescipcion =  $_POST['editarTramiteDescipcion'];

        $Calle = Conexiones::conMunicipalidadDigital()->prepare("UPDATE [MunicipalidadDigital].[dbo].[Tramites]
                                                                SET [TramitesNombre] = '$editarTramiteNombre'
                                                                    ,[TramitesDescripcion] = '$editarTramiteDescipcion'
                                                                    ,[Activo] = 1
                                                                WHERE [idTramites] = $editarIdTramite");

        if ($Calle->execute()) {
            $response = array(
                "messagge" => 'El tramite o tema de interes se actualizo correctamente',
                "status" => 'success',
                "code" => 200
            );
        } else {
            $response = array(
                "messagge" => 'Error al actualizar tramite o tema de interes',
                "status" => 'error',
                "code" => 400
            );
        }

    } else {
        $response = array(
            "messagge" => 'Debe enviar parametros validos',
            "status" => 'error',
            "code" => 400
        );
    }

    echo json_encode($response);

    exit();