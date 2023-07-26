<?php
include_once('conexiones.php');
class Modelos
{
	public function mdlIngresoUsu($usu,$pass,$modulo){
		
		//$stmt = Conexiones::conlocal()->prepare("SELECT * FROM [MunicipalidadDigital].[dbo].[todos_loguin1] (1446,'7190',204)");
		$stmt = Conexiones::conMunicipalidadDigital()->prepare("SELECT * FROM login (?,?,?)");

		$stmt->bindParam(1, $usu, PDO::PARAM_INT);
		$stmt->bindParam(2, $pass, PDO::PARAM_STR);
		$stmt->bindParam(3, $modulo, PDO::PARAM_INT);
		
		$stmt->execute();

		return $stmt -> fetch();

		$stmt->close();

		$stmt = null; 
	}
	public function mdlIntentoIngreso($usu){
		
		
		$stmt = Conexiones::conSW()->prepare("SELECT intentos  FROM [municipio].[dbo].[Usuarios2] WHERE CODUSU=$usu");

		
		$stmt->execute();

		return $stmt -> fetch();
		
		// $stmt->close();

		// $stmt = null; 
	}
	public function mdlDatosUsu($usu){
		$modulo=237;	
		$stmt = Conexiones::conMunicipalidadDigital()->prepare("EXECUTE [MunicipalidadDigital].[dbo].[Datos_usuarios_acceso] ?,?");

		$stmt->bindParam(1, $usu, PDO::PARAM_INT);
		$stmt->bindParam(2, $modulo, PDO::PARAM_INT);
		
		$stmt->execute();

		return $stmt-> fetchAll();

		$stmt->close();

		$stmt = null; 
	}
	public function mdlFecha(){
		//SP fecha extraida del servidor municipal
		$consultaFecha= Conexiones::conSW()->prepare("EXEC [municipio].[dbo].[Fecha]");
		$consultaFecha->execute();

		return $consultaFecha->fetchAll();

		$consultaFecha ->close();
	}
	public function MdlSolicitudes()
	{
		$solicitudes = Conexiones::conMunicipalidadDigital()->prepare("SELECT TC.TramiteFechaInicio, TC.idTamites_por_Contribuyentes, TC.idContribuyentes, TE.idEstados, CON.NroDni, CON.Contribuyente
		FROM Tramites_por_Contribuyentes TC
		JOIN TramitesContribuyentes_por_Estados TE ON TE.idTamites_por_Contribuyentes = TC.idTamites_por_Contribuyentes
		JOIN Personas CON ON CON.Id = TC.idContribuyentes
		WHERE TC.idTramites = 11 ORDER BY TE.idEstados");
		$solicitudes->execute();

		return $solicitudes->fetchAll();
	}

	public function MdlConsultaPersona($dni)
	{
		// return $dni;

		$solicitudes = Conexiones::conMunicipalidadDigital()->prepare("EXEC [dbo].[Contribuyentes_Select_DNI_Nombre] ?");

		$solicitudes->bindParam(1, $dni, PDO::PARAM_INT);

		$solicitudes->execute(); 

		$rta = $solicitudes->fetchAll();

		if (!$rta) {
			
			$solicitudes = Conexiones::conMunicipalidadDigital()->prepare("SELECT * FROM Personas WHERE (NroDni = $dni)");

			$solicitudes->bindParam(1, $dni, PDO::PARAM_INT);

			$solicitudes->execute(); 

			$rta = $solicitudes->fetchAll();
		}

		return $rta;
		// $solicitudes->close(); 

	}
	public function MdlConsultaBarrio($numberofrecords,$search)
	{

		if($search == ''){
			$Barrio = Conexiones::conSW()->prepare("SELECT TOP ($numberofrecords) Id, IdCatastro, Detalle, Eliminar, IdReemplazo, Zona FROM Barrios");

		}else{

		// Mostrar resultados
		$Barrio = Conexiones::conSW()->prepare("SELECT TOP ($numberofrecords) Id, IdCatastro, Detalle, Eliminar, IdReemplazo, Zona FROM Barrios WHERE Detalle like :nombre");

		$Barrio->bindParam(':nombre', '%'.$search.'%', PDO::PARAM_STR);

		}


		$Barrio->execute();

		return $Barrio->fetchAll();
		$Barrio->close(); 

	}




		public function mdlListaTramites(){
			
			//CONSULTA el periodo del ESTADO DE CUENTA DEL DOMINIO SELECCIONADO ANTERIORMENTE

			$consultaDeudaPeriodo=Conexiones::conMunicipalidadDigital()->prepare("SELECT tc.idTramites,tc.idContribuyentes, c.Contribuyente, c.NroDni,tc.idSolicitud,tc.TramiteFechaInicio, tc.TramiteFechaFin, tc.TramiteObjeto, tc.TramiteObservacion, t.idTramites AS idTramite, t.idRubro, tc.TramiteObservacion,tc.idTamites_por_Contribuyentes
			FROM Tramites_por_Contribuyentes AS tc 
			INNER JOIN Tramites AS t ON t.idTramites = tc.idTramites 
			INNER JOIN Personas AS c ON tc.idContribuyentes = c.Id
			WHERE t.idRubro=2
			ORDER BY tc.idTamites_por_Contribuyentes DESC");

			$consultaDeudaPeriodo->execute();
			return $consultaDeudaPeriodo->fetchAll();

		}
		public function mdlBarrioNombre($id){
			
			//CONSULTA el periodo del ESTADO DE CUENTA DEL DOMINIO SELECCIONADO ANTERIORMENTE

			$consultaDeudaPeriodo=Conexiones::conSW()->prepare("SELECT  Id, Detalle FROM Barrios WHERE Id = $id");

			$consultaDeudaPeriodo->execute();
			return $consultaDeudaPeriodo->fetchAll();

		}
		public function mdlCalleNombre($id){
			
			//CONSULTA el periodo del ESTADO DE CUENTA DEL DOMINIO SELECCIONADO ANTERIORMENTE

			$consultaDeudaPeriodo=Conexiones::conSW()->prepare("SELECT  * FROM Calles WHERE IdcalleCatastro = $id");

			$consultaDeudaPeriodo->execute();
			return $consultaDeudaPeriodo->fetchAll();

		}
		// 	if ($Auditoria->execute()) {
		// 		return "<script>
		// 		jQuery(function(){	
		// 			Swal.fire({
		// 				icon: 'success',
		// 				title: '¡Muy bien!',
		// 				text: 'Respuesta enviada correctamente',
		// 				showConfirmButton: true,
		// 				}).then((result) => {
		// 					document.EnviarRespuesta.submit();
		// 			});
		// 		});
		// 			</script>";
		// 	} else {
		// 		return "<script>
		// 		jQuery(function(){	
		// 			Swal.fire({
		// 				icon: 'danger',
		// 				title: '¡Error!',
		// 				text: 'Se produjo un error al enviar la respuesta',
		// 				showConfirmButton: true,
		// 				}).then((result) => {
		// 					document.EnviarRespuesta.submit();
		// 			});
		// 		});
		// 			</script>";
		// 	}
		// } else {
		// 	return "<script>
		// 		jQuery(function(){	
		// 			Swal.fire({
		// 				icon: 'danger',
		// 				title: '¡Error!',
		// 				text: 'Se produjo un error al enviar la respuesta',
		// 				showConfirmButton: true,
		// 				}).then((result) => {
		// 					document.EnviarRespuesta.submit();
		// 			});
		// 		});
		// 			</script>";
		// }
	
}
