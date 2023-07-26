<?php

if (isset($_SESSION['codusu1'])) {
    $usuario = $_SESSION['nombre1'];
    $id = $_SESSION['codusu1'];
    $area = $_SESSION['Detalle1'];
    $dependencia = $_SESSION['Dependencia1'];
    $nivel = $_SESSION['nivel'];
  //  //sino, calculamos el tiempo transcurrido
  $fechaGuardada = $_SESSION["ultimoAcceso"];
  $ahora = Modelos::mdlFecha();
  $fechaAhora=date('m-d-Y H:i:s',strtotime($ahora[0][0]));
  $tiempo_transcurrido = (strtotime($fechaAhora) - strtotime($fechaGuardada));
  //comparamos el tiempo transcurrido
  if ($tiempo_transcurrido >= 3000) {
    //si pasaron 10 minutos o más
    session_destroy(); // destruyo la sesión
    $mensaje = 'YES';
    header("Location: login.php?SESSION_EXPIRED=$mensaje");
    //header("index.php:SESSION_EXPIRED=$mensaje"); envío al usuario a la pag. de autenticación
    // //sino, actualizo la fecha de la sesión
  } else {
    $_SESSION["ultimoAcceso"] = $fechaAhora;
    $_SESSION["ultimoAcceso"];
  }
} else {
  header("Location: login.php");
}


?>

<nav class="navbar navbar-expand-lg header" style="padding-left: 0px !important;">
  <div class="container-fluid">
    <a href="index.php"><img class="logo_header" src="librerias/img/original.png"></a> 
    <span class="lblMuniDigital"><!-- Municipalidad Digital <br> -->
      <span class="lblDigitalizacion fw-bold text-uppercase"><h5 class="lblBienvenido text-uppercase fw-bold">¡HOLA! <?php echo $usuario ?> </h5></span></span>
    <button class="navbar-toggler btnNav" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation" style="border: solid 1px grey; color: white">
      <i class="fas fa-bars iconoNav"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <form class="d-flex btnesRIGHT "  id="navbarTogglerDemo02">
        <a class="btn btn-sm btnLista" href="index.php?pagina=listaTramite"> Lista de Consultas <i class="fas fa-list"></i></a>
      </form>
      <a class="btn btn-sm btnLista mt-3" href="index.php">Buscar <i class="fas fa-sign-in-alt"></i></a>
      <?php if($nivel == 1){ ?>
      <a class="btn btn-sm btnLista mt-3" href="index.php?pagina=gestorTramite">ABM Trámites <i class="fas fa-plus"></i></a>
      <a class="btn btn-sm btnLista mt-3" href="index.php?pagina=gestorBarrios">ABM Barrios <i class="fas fa-plus"></i></a>
      <?php } ?>
      <a class="btn btn-sm btnSalir mt-3" href="cerrarSession.php">Salir <i class="fas fa-sign-in-alt"></i></a>
    </div>
  </div>
</nav>