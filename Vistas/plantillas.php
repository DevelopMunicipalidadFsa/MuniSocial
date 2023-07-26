<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="Librerias/img/logoMunicipalidadFsa.png">
	<link rel="stylesheet" href="Librerias/css/Bootstrap5/bootstrap.min.css">
	<link rel="stylesheet" href="Librerias/css/Estilos/Generales.css">
	<link rel="stylesheet" href="Librerias/css/Estilos/Plantillas.css">
	<link rel="stylesheet" href="Librerias/css/Estilos/Responsive.css">
	<link rel="stylesheet" href="Librerias/css/FontAwesome/font-awesome.5.14.0.min.css">
	<title>Sistema Muni Social</title>

	<script src="Librerias/js/SweetAlert/sweetalert.2.10.js"></script>
	
</head>

<body>
	<?php include_once('nav.php') ?>
		<div class="container" id="Ajuste">
			<?php
			if (isset($_GET['pagina'])) {
				if (
					$_GET['pagina'] == "AdministrarSolicitudes" ||
					$_GET['pagina'] == "listaTramite" ||
					$_GET['pagina'] == "gestorTramite" ||
					$_GET['pagina'] == "gestorBarrios"
				) {
					include_once "Vistas/Paginas/" . $_GET['pagina'] . ".php";
				}
			} else {
				include_once "Vistas/Paginas/consulta.php";
			}
			?>
		</div>
		<div class="col-md-12 Botonera">
				<a href="index.php" class="btn BotonVolver"><i class="fas fa-reply"></i> Volver</a>
				<p class="text-center copy d-flex justify-content-center">Municipalidad de la Ciudad de Formosa <br> República Argentina 
					<br> Todos los Derechos Reservados © 2021</p>
				<div class="relleno mt-3 mb-3"></div>
			</div>
	<script src="Librerias/js/Bootstrap5/bootstrap.bundle.min.js"></script>
	<script src="Librerias/js/Scripts/script.js"></script>
	<script>history.forward()</script>
</body>

</html>
