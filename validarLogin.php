<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="icon" type="image/png" href="Librerias/img/logo.png"/>
<title>Tu Ciudad Digital - Sistema de Consulta de Patentes</title>
<?php include_once"header.php"; ?>
<!-- <link rel="stylesheet" href="vistas/librerias/css/style.css"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<!-- <link rel="stylesheet" href="Vistas/librerias/jcrop/css/jquery.Jcrop.css" type="text/css" /> -->
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" type="text/javascript"></script>
<!-- <script src="Vistas/librerias/js/dataTable.js" type="text/javascript"></script> -->
<script src="Librerias/js/sweetalert.2.10.js" type="text/javascript"></script>
<!-- <script src="Vistas/librerias/jcrop/js/jquery.Jcrop.js"></script> -->
	<?php

	require_once 'Controladores/Controladores.php';
	require_once 'Modelos/Modelos.php';
	//Se abre el código php para lo que es el inicio de la sesión
	//Se reanuda la sesion que se abrió en ValidaLogin.php

	if (isset($_POST['username']) && isset($_POST['clave'])) {


		$usu = $_POST['username'];
		$pass = $_POST['clave'];

		$logueoRta = Controladores::CtrIngresoUsu($usu,"$pass");
			// print_r($logueoRta);
				if($logueoRta['rta']=='OK'){
					$respuesta = Controladores::CtrDatosUsu($usu);
					
					if(isset($respuesta[0]["codusu"])){
					// 	// //Si los datos coinciden, se crea una sesión para el usuario
					// 	// //Comienza la sesión
						session_start();

						//defino la sesión que demuestra que el usuario está autorizado
						// Llamamos al modelo que trae fecha y hora del servidor
						$hora = Modelos::mdlFecha();

						$fechaConexion=date('m-d-Y H:i:s',strtotime($hora[0][0]));
						// //Se crean las variables de la sesión
						$_SESSION["ultimoAcceso"]= $fechaConexion;
						//defino la fecha y hora de inicio de sesión en formato aaaa-mm-dd hh:mm:ss
						$_SESSION['nombre1'] = $respuesta[0]["nombre"];
						$_SESSION['codusu1'] = $respuesta[0]["codusu"];
						$_SESSION['Dependencia1'] = $respuesta[0]["Dependencia"];
						$_SESSION['Detalle1'] = $respuesta[0]["Detalle"];
						$_SESSION['nivel'] = $respuesta[0]["nivel"];
						$_SESSION['validarIngreso'] = "ok";
						//Redirecciona a la página principal
						header("Location:index.php");
					}else{
						// ECHO "error";
						echo "<script>	
								jQuery(function(){
									Swal.fire({
										icon: 'error',
										title: '¡Error!',
										text: 'Verificar datos ingresados',
										showConfirmButton: true,
          								allowOutsideClick: false, 
										confirmButtonText: 'Ok'
										}).then((result) => {
											/* Read more about isConfirmed, isDenied below */
											if (result.isConfirmed) {
												if(window.history.replaceState){
													window.history.replaceState(null, null, window.location.href );
												}
												window.location = 'login.php';
									}
									})
								});
							</script>";
					} // end if($respuesta[0]["Cuit"] == true) ELSE
				}else{
					echo "<script>	
							jQuery(function(){
								Swal.fire({
									icon: 'error',
									title: '¡Error!',
									text: '".$logueoRta['rta']."',
									showConfirmButton: true,
          							allowOutsideClick: false, 									
									confirmButtonText: 'Ok'
									}).then((result) => {
										/* Read more about isConfirmed, isDenied below */
										if (result.isConfirmed) {
											if(window.history.replaceState){
												window.history.replaceState(null, null, window.location.href );
											}
											window.location = 'login.php';
										}
									})
							});
						</script>";
				}

}else{
	echo "<script>	
			jQuery(function(){
				Swal.fire({
					icon: 'error',
					title: '¡Error!',
					text: 'Debe Mandar un parametro válido',
					showConfirmButton: true,
					allowOutsideClick: false, 
					confirmButtonText: 'Ok'
					}).then((result) => {
						/* Read more about isConfirmed, isDenied below */
						if (result.isConfirmed) {
							if(window.history.replaceState){
								window.history.replaceState(null, null, window.location.href );
							}
							window.location = 'login.php';
						}
					})
			});
		</script>";
} //end if(isset($json->message))
