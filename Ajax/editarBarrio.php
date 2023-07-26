<?php
    require '../Modelos/conexiones.php';

    
    if(isset($_POST['editarIdTramite']) && isset($_POST['editarTramiteNombre'])){
        
        // recibimos las variables
        $editarIdTramite = $_POST['editarIdTramite'];
        $editarTramiteNombre = $_POST['editarTramiteNombre'];
        $editarTramiteDescipcion =  $_POST['editarTramiteDescipcion'];

        $Calle = Conexiones::conMunicipalidadDigital()->prepare("UPDATE [MunicipalidadDigital].[dbo].[Barrios]
                                                                SET [Detalle] = '$editarTramiteNombre'
                                                                    ,[NroLR] = '$editarTramiteDescipcion'
                                                                    ,[Activo] = 1
                                                                WHERE [Id] = $editarIdTramite");

        if ($Calle->execute()) {
            $response = array(
                "messagge" => 'El Barrio se actualizo correctamente',
                "status" => 'success',
                "code" => 200
            );
        } else {
            $response = array(
                "messagge" => 'Error al actualizar Barrio',
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