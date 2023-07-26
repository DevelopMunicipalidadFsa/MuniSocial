<?php
class Conexiones
{
		// CONEXIÓN A LA BASE DE DATOS CON FUNCION DE MunicipalidadDigital
		public function conMunicipalidadDigital(){
			
			$usuario = "racosta";
			$contraseña = "38577190Ra";
			$nombreBaseDeDatos = "MunicipalidadDigital";
			# Puede ser 127.0.0.1 o el nombre de tu equipo; o la IP de un servidor remoto
			$rutaServidor = "192.168.0.4";
			try {
			    $base_de_datos = new PDO("sqlsrv:server=$rutaServidor;database=$nombreBaseDeDatos", $usuario, $contraseña);
			    $base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $base_de_datos;
			} catch (Exception $e) {
			   echo "<script>	
							jQuery(function(){
								Swal.fire({
									icon: 'error',
									title: '¡Error de Sistema!',
									text: 'En estos momentos no podemos procesar su pedido. Por favor intenta más tarde',
									showConfirmButton: true
									}).then((result) => {
									/* Read more about isConfirmed, isDenied below */
									window.location.href = 'cerrarSession.php';
								})
							});
					   </script>";
			}
					
		}
	// CONEXIÓN A LA BASE DE DATOS CON FUNCION DE municipio
		public function conSW(){
			$usuario = 'racosta';
			$contraseña ='38577190Ra';
			$nombreBaseDeDatos = "SeguridadWEB";
			# Puede ser 127.0.0.1 o el nombre de tu equipo; o la IP de un servidor remoto
			$rutaServidor = "192.168.0.4";
			try {
			    $base_de_datos = new PDO("sqlsrv:server=$rutaServidor;database=$nombreBaseDeDatos", $usuario, $contraseña);
			    $base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $base_de_datos;
			} catch (Exception $e) {
			   echo "<script>	
							jQuery(function(){
								Swal.fire({
									icon: 'error',
									title: '¡Error de Sistema!',
									text: 'En estos momentos no podemos procesar su pedido. Por favor intenta más tarde',
									showConfirmButton: true
									}).then((result) => {
									/* Read more about isConfirmed, isDenied below */
									window.location.href = 'cerrarSession.php';
								})
							});
					   </script>";
			
			}
		}

	// CONEXIÓN A LA BASE DE DATOS CON FUNCION DE MunicipalidadDigital
		public function conMunicipio(){

			$usuario = 'racosta';
			$contraseña ='38577190Ra';
			$nombreBaseDeDatos = "municipio";
			# Puede ser 127.0.0.1 o el nombre de tu equipo; o la IP de un servidor remoto
			$rutaServidor = "192.168.0.4";
			try {
			    $base_de_datos = new PDO("sqlsrv:server=$rutaServidor;database=$nombreBaseDeDatos", $usuario, $contraseña);
			    $base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $base_de_datos;
			} catch (Exception $e) {
			   echo "<script>	
							jQuery(function(){
								Swal.fire({
									icon: 'error',
									title: '¡Error de Sistema!',
									text: 'En estos momentos no podemos procesar su pedido. Por favor intenta más tarde',
									showConfirmButton: true
									}).then((result) => {
									/* Read more about isConfirmed, isDenied below */
									window.location.href = 'cerrarSession.php';
								})
							});
					   </script>";
			
			}
		}
}
