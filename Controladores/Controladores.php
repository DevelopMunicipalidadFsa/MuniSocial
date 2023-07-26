<?php
class Controladores
{
	/*=============================================
	 =            LOGUEO USUARIOS          		=
	 =============================================*/ 
	
	public function CtrIngresoUsu($usu,$pass){

		/* pasa el parametro $tabla al modelo  ModelosSeguimientoExpedientes::mdlListaUsuarios($tabla)*/
		$modulo=237;
		$rta= Modelos::mdlIngresoUsu($usu,$pass,$modulo);
		// if($rta[0] == 'CLAVE INCORRECTA'){
		
		// 	$intento= ModelosSeguimientoExpedientes::mdlIntentoIngreso($usu);
		// 	return $intento;
		// }else{
		return $rta;
		// }
		
	}
	/*=============================================
	 =            DATOS USUARIOS          		=
	 =============================================*/ 
	
	public function CtrDatosUsu($usu){

		/* pasa el parametro $tabla al modelo  ModelosSeguimientoExpedientes::mdlDatosUsu($usu)*/

		$rta= Modelos::mdlDatosUsu($usu);

		return $rta;
	}

	public function ctrLogueo($username, $clave)
	{
		$rta = Modelos::mdlLogueo($username, $clave);

		return $rta;
	}

	public function CtrlSolicitudes()
	{
		$respuesta = Modelos::MdlSolicitudes();
		return $respuesta;
	}

	public function CtrlConsultaPersona($dni)
	{
		
		    $respuesta = Modelos::MdlConsultaPersona($dni);
			return $respuesta;
		
	}

	public function CtrlConsultaBarrio()
	{	// Número de registros recuperados
		$numberofrecords = 5;

		if(isset($_POST['searchTerm'])){
		    $respuesta = Modelos::MdlConsultaBarrio($numberofrecords,$_POST['searchTerm']);
		}else{
			$respuesta = Modelos::MdlConsultaBarrio($numberofrecords,'');
		}
			return $respuesta;
		
	}

	/*=============================================
	 =            OBTENER fecha          =
	 =============================================*/
	 
	
	public function ctrFecha(){

		/* pasa los parametros $IdRubro, $idContribuyente al MODELO Modelos::mdlObtenerObjetos() */
		
		$rta=Modelos::mdlFecha();
		$fecha=$rta[0][0];
		$FechaFormateada=date('d/m/Y',strtotime($fecha));// 

		return $FechaFormateada;/*$fecha */
	}

	/*=============================================
	 =            		OBTENER Lista			  =
	 =============================================*/
	 
	
	 public function ctrListaTramites(){
		
		$rta=Modelos::mdlListaTramites();

		return $rta;
	}
	/*=============================================
	 =            		OBTENER Lista			  =
	 =============================================*/
	 
	
	 public function CtrlBarrioNombre($id){
		
		$rta=Modelos::mdlBarrioNombre($id);

		return $rta;
	}
	public function CtrlCalleNombre($id){
		
		$rta=Modelos::mdlCalleNombre($id);

		return $rta;
	}
	
}
