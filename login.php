
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="google" value="notranslate">
    <link rel="shortcut icon" type="image/x-icon" style="border-radius: 50% !important" href="Librerias/img/logoMunicipalidadFsa.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap // CSS -->
    <link rel="stylesheet" href="Librerias/css/Bootstrap5/bootstrap.min.css">
    <link rel="stylesheet" href="Librerias/css/Estilos/Login.css">
    <link rel="stylesheet" href="Librerias/css/Estilos/Responsive.css">
    <link rel="stylesheet" href="Librerias/css/FontAwesome/font-awesome.5.14.0.min.css">
    <!-- <link rel="stylesheet" href="Librerias/css/Bootstrap4/bootstrap.4.4.1.min.css"> -->

    <!-- SCRIPTS -->
    <script src="Librerias/js/Scripts/jquery-3.5.1.min.js"></script>
    <script src="Librerias/js/Scripts/script.js"></script>
    <title>Iniciar Sesión en Muni Social</title>
</head>
<style>
    @media (max-width: 626px) {
        body {
            background-color: #ebebeb !important;
        }
    }
</style>

<body>
    <center>
        <img class="logoLoginResponsive" src="Librerias/img/logoMunicipalidadFsa.png">
    </center>
    <h3 class="TituloLogin">Municipalidad de Formosa <i class="fas fa-chevron-right"></i> Sistema Muni Social</h3>
    <h3 class="TituloLoginResponsive">Municipalidad de Formosa <br> Sistema de Muni Social</h3>

    <div class="LoginMuniDigital">
        <form method="POST" action="validarLogin.php">
            <center>
                <img class="logoLogin" src="Librerias/img/logoMunicipalidadFsa.png">
            </center>

            <h4 class="h4 text-center mt-0">Iniciar sesión</h4>
            <input class="form-control mb-2 inputLogin" type="number" id="username" autocomplete="off" name="username" placeholder="Usuario" required autocomplete="off"> 
            <div class="d-flex justify-content-center my-3 resultadoUsuario" id="resultadoUsuario"></div>
            <input class="form-control mb-2 inputLogin" type="password" name="clave" placeholder="Contraseña" required autocomplete="off">
            <button class="btn btn-primary btn-block w-100 m-0 mb-2" type="submit">Ingresar</button>
            <?php
            if (isset($_GET['err_user'])) { ?>
                <div class="toast show mt-2 err_user px-1 py-1" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header py-1">
                        <strong class="me-auto">Error de Logueo</strong>
                        <button form="login" type="submit" class="btn-close" data-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body py-1">
                        <span class="mensaje_err_user">El usuario o contraseña ingresados son incorrectos</span>
                    </div>
                </div>
            <?php }
            if (isset($_GET["SESSION_EXPIRED"])) { ?>
                <div class="toast show mt-2 err_user px-1 py-1" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header py-1">
                        <strong class="me-auto">Expiró Sesion</strong>
                        <button form="login" type="submit" class="btn-close" data-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body py-1">
                        <span class="mensaje_err_user">Vuelva a Iniciar sesión</span>
                    </div>
                </div>
            <?php }
            if (isset($_GET["err_servMd"])) { ?>
                <div class="toast show mt-2 err_user px-1 py-1" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header py-1">
                        <strong class="me-auto">Error en el Sistema</strong>
                        <button form="login" type="submit" class="btn-close" data-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body py-1 text-left">
                        <span class="mensaje_err_user">En estos momentos no podemos procesar su pedido. Por favor intenta más tarde</span>
                    </div>
                </div>
            <?php }
            if (isset($_GET["err_servMcp"])) { ?>
                <div class="toast show mt-2 err_user px-1 py-1" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header py-1">
                        <strong class="me-auto">Error en el Sistema</strong>
                        <button form="login" type="submit" class="btn-close" data-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body py-1 text-left">
                        <span class="mensaje_err_user">En estos momentos no podemos procesar su pedido. Por favor intenta más tarde</span>
                    </div>
                </div>
            <?php }
            ?>
            <img src='Librerias/img/tuciudaddigitalciudad5.png' width='100%' height='95' style="image-rendering: pixelated;" />
        </form>
    </div>
</body>
</html>