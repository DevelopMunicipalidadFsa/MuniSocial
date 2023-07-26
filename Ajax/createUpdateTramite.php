<?php
    require '../Modelos/conexiones.php';
		
    // Número de registros recuperados
    $numberofrecords = 5;

    if($_POST['idContribuyente'] == 'FormularioVacio'){
        // COMBIAMOS EL FORMATO DE LA FECHA
        $fechaNacimiento= $_POST["FechaNacimientoN"] ? date('Y-m-d',strtotime($_POST["FechaNacimientoN"])) : $_POST["FechaNacimiento"];
        $verificarPersona = consultaPersona($_POST['NroDni']);

        if ($verificarPersona['idContribuyente'] != 0 && $verificarPersona['code'] == 200) {
            // si el contribuyente existe en la tabla persona tomamos su id de lo contrario se da de alta en persona
            $maxID = $verificarPersona['idContribuyente'];
        } else {
            // INSERTAMOS EN LA TABLA Personas LOS DATOS DEL Contribuyente
            $altContribu = Conexiones::conMunicipalidadDigital()->prepare("INSERT INTO Personas(
                [Contribuyente],[FechaNacimiento],[Sexo],[Mail],[Telefono],[FechaAlta],[NroDni],[IdNacionalidad]) 
                VALUES('$_POST[Contribuyente]','$fechaNacimiento',null,'$_POST[Mail]', $_POST[Telefono], GETDATE(),$_POST[NroDni],1)");

            $altContribu->execute();
            
            // RECUPERAMOS EL ID DEL ULTIMO REGISTRO INSERTADO
            $lastInsertId = Conexiones::conMunicipalidadDigital()->prepare("SELECT Id FROM  Personas WHERE NroDni = $_POST[NroDni]");
            $lastInsertId->execute();
            $rtaID = $lastInsertId->fetchAll();
            $maxID=$rtaID[0]['Id'];
        }
        
    

        // DAMOS DE ALTA EL TRAMITE O RECLAMO
        $altTramites = Conexiones::conMunicipalidadDigital()->prepare("INSERT INTO [MunicipalidadDigital].[dbo].[Tramites_por_Contribuyentes]
        ([idTramites]
        ,[idContribuyentes]
        ,[TramiteFechaInicio]
        ,[TramiteObjeto]
        ,[TramiteObservacion]
        ,[TramiteDescripcion]
        ,[idBarrio])
        VALUES
        ($_POST[Tramite],$maxID,GETDATE(),'MUNISOCIAL','$_POST[observacionTramite]','$_POST[descripcionTramite]',$_POST[CodBar])");

        if($altTramites->execute()){
            $idContribuyente = $maxID;
            $rta = 'ok';
            $code = 200;
            $message = 'Usuario y el Tramite se dieron de alta correctamente';
        }else{
            $idContribuyente = "error";
            $rta = 'error';
            $code = 404;
            $message = 'Error al dar de alta el usuario y el tramite';
        }

    $response = array(
    "idContribuyente"=> $idContribuyente,
    "rta" => $rta,
    "code" => $code,
    "message" => $message
    );

    echo json_encode($response);

}elseif(isset($_POST['idContribuyente']) && $_POST['idContribuyente'] != null && $_POST['idContribuyente'] != ''){
    
     $Mail=$_REQUEST['Mail'] ? $_REQUEST['Mail']: '';
     $fechaNacimiento= isset($_POST["FechaNacimiento"]) ? date("Y-m-d H:i:s", strtotime($_POST["FechaNacimiento"])) : $_POST["FechaNacimientoN"];
     $Telefono=$_REQUEST['Telefono'] ? $_REQUEST['Telefono']: '';
     $CodBar=$_REQUEST['CodBar'] ? $_REQUEST['CodBar']: '';
     $Tramite=$_REQUEST['Tramite'] ? $_REQUEST['Tramite']: '';
     $observacionTramite=$_REQUEST['observacionTramite'] ? $_REQUEST['observacionTramite'] : '';

     $verificarPersona = consultaPersona($_POST['NroDni']);
     if ($verificarPersona['idContribuyente'] != 0 && $verificarPersona['code'] == 200) {
         // si el contribuyente existe en la tabla persona tomamos su id de lo contrario se da de alta en persona
         $maxID = $verificarPersona['idContribuyente'];
     } else {
         // INSERTAMOS EN LA TABLA Personas LOS DATOS DEL Contribuyente
         $altContribu = Conexiones::conMunicipalidadDigital()->prepare("INSERT INTO Personas(
             [Contribuyente],[FechaNacimiento],[Sexo],[Mail],[Telefono],[FechaAlta],[NroDni],[IdNacionalidad]) 
             VALUES('$_POST[Contribuyente]','$fechaNacimiento',null,'$_POST[Mail]', $_POST[Telefono], GETDATE(),$_POST[NroDni],1)");

         $altContribu->execute();
         
         // RECUPERAMOS EL ID DEL ULTIMO REGISTRO INSERTADO
         $lastInsertId = Conexiones::conMunicipalidadDigital()->prepare("SELECT Id FROM  Personas WHERE NroDni = $_POST[NroDni]");
         $lastInsertId->execute();
         $rtaID = $lastInsertId->fetchAll();
         $maxID=$rtaID[0]['Id'];
     }
     
    
    // DAMOS DE ALTA EL TRAMITE O RECLAMO
    $altTramites = Conexiones::conMunicipalidadDigital()->prepare("INSERT INTO [MunicipalidadDigital].[dbo].[Tramites_por_Contribuyentes]
    ([idTramites]
    ,[idContribuyentes]
    ,[TramiteFechaInicio]
    ,[TramiteObjeto]
    ,[TramiteObservacion]
    ,[TramiteDescripcion]
    ,[idBarrio])
    VALUES
    ($Tramite,$maxID,GETDATE(),'MUNISOCIAL','$observacionTramite','$_POST[descripcionTramite]',$CodBar)");

    if($altTramites->execute()){
        $idContribuyente = $maxID;
        $rta = 'ok';
        $code = 200;
        $message = 'Usuario y el Tramite se dieron de alta correctamente';
    }else{
        $idContribuyente = "error";
        $rta = 'error';
        $code = 404;
        $message = 'Error al dar de alta el usuario y el tramite';
    }
    
    $response = array(
    "idContribuyente"=> $maxID,
    "rta" => $rta,
    "code" => $code,
    "message" => $message
    );
    
    echo json_encode($response);

}

function consultaPersona($dni){

    // RECUPERAMOS EL ID DEL ULTIMO REGISTRO INSERTADO
    $lastInsertId = Conexiones::conMunicipalidadDigital()->prepare("SELECT * FROM Personas WHERE (NroDni = $dni)");
    $lastInsertId->execute();
    $rtaID = $lastInsertId->fetchAll();
    if (isset($rtaID[0]['Id'])) {
        $rta= true;
        $response = array(
            "idContribuyente"=> $rtaID[0]['Id'],
            "rta" => $rta,
            "code" => 200
            );
        
    } else {
        $rta= false;
        $maxID = 0;
        $response = array(
            "idContribuyente"=> $maxID,
            "rta" => $rta,
            "code" => 400
            );
    }
    
    return $response;
}