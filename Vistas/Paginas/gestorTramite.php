<?php 
include_once('Modelos/conexiones.php');

    $fecha=Controladores::ctrFecha();
    if(isset($_REQUEST['dni'])){
      $datosPersona=Controladores::CtrlConsultaPersona();
      // print_r($datosPersona);
      if(empty($datosPersona)){
        $datosPersona[0][0] = 'FormularioVacio'; 
      }else{
        $datosPersona[0][0] = $datosPersona[0][0];
      }
    }else{
      $datosPersona[0][0]='Inicio';
    }
    $tramitesLista=Conexiones::conMunicipalidadDigital()->prepare("SELECT idTramites, idRubro, TramitesNombre, TramitesDescripcion, TramitesCosto, TramitesDuracion, Activo
    FROM Tramites WHERE (idRubro = 2) AND (Activo = 1) ORDER BY idTramites DESC");

  $tramitesLista->execute();

  $Lista =  $tramitesLista->fetchAll();
// print_r($Lista);
?>
<script src="Librerias/js/Scripts/script.js"></script>

	<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="Librerias/css/Select2/css/select2.min.css" rel="stylesheet" />
<link href="Librerias/css/Select2/css/select2-bootstrap-5-theme.min.css" rel="stylesheet"/>
<link href="Librerias/poncho-master/dist/css/icono-arg.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="Librerias/css/Select2/js/select2.min.js"></script>
<script src="Librerias/css/Select2/js/filtroSelect2.js"></script>

<div class="container">
 <h1 class="text-center mt-3 mb-3 text-uppercase">Gestion de trámites o temas de interés</h1>
  <div class="d-flex justify-content-end">
    <button type="button" class="btn btn-primary mt-3 mb-3" data-bs-toggle="modal" data-bs-target="#modalAlta">
      Agregar <i class="fas fa-plus"></i>
    </button>
  </div>
 
  <?php if($Lista){ ?>
    
    <table class="table table-hover"id="ListaTramites" role="table">
      <thead class="bg-primary text-white" role="rowgroup">
        <tr role="row">
          <td class="text-center" role="columnheader">N° Trámite</td>
          <td class="text-center" role="columnheader">Tramite</td>
          <td class="text-center" role="columnheader">Descripción</td>
          <td class="text-center datos" role="columnheader">Acciones</td>
        </tr>
      </thead>
      <tbody role="rowgroup">
        <?php
        foreach ($Lista as $value): ?> 
        <tr role="row">
          <td role="cell"><?php echo $value[0]; ?></td>
          <td role="cell"><?php echo $value[2]; ?></td>
          <td role="cell"><?php if ($value[3] == '' || $value[3] == null) {
            echo "--";
          } else {
            echo $value[3];
          }?></td>
          <td role="cell">
              <button class="btn btn-danger" onclick="eliminarTramite(<?php echo $value[0]; ?>)"><i class="fa fa-trash"></i></button>
              <button class="btn btn-warning ml-2" onclick="asignarEdicionTramite('<?php echo $value[0]; ?>','<?php echo $value[2]; ?>','<?php echo $value[3]; ?>')" id="editarTramite" data-bs-toggle="modal" data-bs-target="#modalEditar"><i class="fa fa-edit"></i></button>
          </td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  <?php }else{?>
    <div class="col-auto p-5 m-5 text-center">
      <div class="alert alert-danger text-center" role="alert">
        <h4 class="alert-heading">Atención!</h4>
        <p class="mb-0">No hay tramites procesados</p>
      </div>
    </div>
  <?php } ?>
</div>
<!-- Modal de Alta de Tramites -->
<div class="modal fade" id="modalAlta" tabindex="-1" aria-labelledby="exampleModalLabel"data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Agregar un Trámite o Tema de Interés</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form action="POST" id="altaTramites" onsubmit="altaTramite(); return false">
          <div class="col-md mt-2">
              <div class="form-floating">
                <input type="text" class="form-control" id="floatingInputGrid" name="tramiteNombre" autocomplete="off" required>
                <label for="floatingInputGrid">Nombre</label>
              </div>
            </div>
            <div class="form-floating mt-2">
              <textarea class="form-control" id="floatingTextarea" name="tramiteDescipcion"></textarea>
              <label for="floatingTextarea">Descripción</label>
              <small class="text-muted d-flex justify-content-end font-weight-bold">No mas de 250 caracteres</small>
            </div>
      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-success">Agregar</button>
        </form>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Edicion de Tramites -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel"data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Editar Trámite o Tema de Interés</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form action="POST" id="editarTramites" onsubmit="editarTramite(); return false">
        <input type="hidden" class="form-control" id="editarIdTramite" name="editarIdTramite" autocomplete="off" required>

          <div class="col-md mt-2">
              <div class="form-floating">
                <input type="text" class="form-control" id="editarTramiteNombre" name="editarTramiteNombre" autocomplete="off" required>
                <label for="editarTramiteNombre">Nombre</label>
              </div>
            </div>
            <div class="form-floating mt-2">
              <textarea class="form-control" id="editarTramiteDescipcion" name="editarTramiteDescipcion"></textarea>
              <label for="editarTramiteDescipcion">Descripción</label>
              <small class="text-muted d-flex justify-content-end font-weight-bold">No mas de 250 caracteres</small>
            </div>
          </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-success">Agregar</button>
        </form>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<script>

  function asignarEdicionTramite(idTramite,nombreTramite,descripciontramite){

    // asignar datos al formulario de edicion
    document.getElementById("editarIdTramite").value = idTramite;
    document.getElementById("editarTramiteNombre").value = nombreTramite;
    document.getElementById("editarTramiteDescipcion").value = descripciontramite;

  }
    
  // quitar clase de tabla al tener dispositivo pequeño para que tome el estilo css de  @media
  if($(window).width() < 1000){
    var element1 = document.getElementById("ListaTramites");
    element1.classList.remove("table");
    element1.classList.remove("table-hover");
    
  }else{
    var element1 = document.getElementById("ListaTramites");
    element1.classList.add("table");
    element1.classList.add("table-hover");

  }

  // enviamos formulario de alta de tramites
  function altaTramite(){	
    
    var form = $('#altaTramites').serialize();
    // enviamos el formulario
    $.ajax({
    type: 'POST',
    url: 'Ajax/altaTramite.php',
    dataType : 'json',
    data: form,
      success: function(respuesta) {
        console.log(respuesta);
        if(respuesta.code == 200){
          Swal.fire({
            icon: 'success',
            title: respuesta.messagge,
          })
          window.location.href = window.location.href;
        }
        else {
          Swal.fire({
            icon: 'error',
            title: respuesta.messagge,
          })
        }
      }
    });
  }
    // vamos a eliminar datos de tramites
    function eliminarTramite(idTramites){	
      if(idTramites != '' && idTramites != null && idTramites != undefined ){
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
          buttonsStyling: false
        })

          swalWithBootstrapButtons.fire({
            title: 'Estas seguro que deseas eliminar?',
            text: "Este proceso no se podra deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                type: 'POST',
                url: 'Ajax/eliminarTramite.php',
                dataType : 'json',
                data: {idTramite: idTramites},
                  success: function(respuesta) {
                    console.log(respuesta);
                    if(respuesta.code == 200){
                      Swal.fire({
                        icon: 'success',
                        title: respuesta.messagge,
                        confirmButtonText: 'Ok'
                      }).then((result) => {
                          if (result.isConfirmed) {
                            window.location.href = window.location.href;
                          } 
                      })
                    }
                    else {
                      Swal.fire({
                        icon: 'error',
                        title: respuesta.messagge,
                      })
                    }
                  }
                });
            } 
          })
        
      }else{
        Swal.fire({
            icon: 'error',
            title: 'Debe mandar un parametro valido',
          })
      }
        
  }

  // vamos a editar datos de tramites
  function editarTramite(){	
    
    var form = $('#editarTramites').serialize();
    // console.log(form);
    // enviamos el formulario
    $.ajax({
    type: 'POST',
    url: 'Ajax/editarTramite.php',
    dataType : 'json',
    data: form,
      success: function(respuesta) {
        console.log(respuesta);
        if(respuesta.code == 200){
          Swal.fire({
            icon: 'success',
            title: respuesta.messagge,
            confirmButtonText: 'Ok'
          }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = window.location.href;
              } 
          })
        }
        else {
          Swal.fire({
            icon: 'error',
            title: respuesta.messagge,
          })
        }
      }
    });
  }

  //Eliminamos tramites
  function altaTramite(){	
    
    var form = $('#altaTramites').serialize();
    // enviamos el formulario
    $.ajax({
    type: 'POST',
    url: 'Ajax/altaTramite.php',
    dataType : 'json',
    data: form,
      success: function(respuesta) {
        console.log(respuesta);
        if(respuesta.code == 200){
          Swal.fire({
            icon: 'success',
            title: respuesta.messagge,
          })
          window.location.href = window.location.href;
        }
        else {
          Swal.fire({
            icon: 'error',
            title: respuesta.messagge,
          })
        }
      }
    });
  }
</script>
<style>
  /*
	  Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
	*/
	@media
	  only screen 
    and (max-width: 760px), (min-device-width: 768px) 
    and (max-device-width: 1024px)  {

      /* Force table to not be like tables anymore */
      table, thead, tbody, th, td, tr {
        display: block;
      }

      /* Hide table headers (but not display: none;, for accessibility) */
      thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
      }
      tr td:first-child {
            background: #13496d;
            color:white;
            font-weight:bold;
            font-size:1.3em;
            text-align:center;
      }
      tr td:last-child {
        text-align:center;
      }
      tr {
        margin: 0 0 1rem 0;
        background: #ccc;
      }
        
      tr:nth-child(odd) {
        background: #ccc;
      }
      
      td {
        /* Behave  like a "row" */
        border: none;
        border-bottom: 2px solid #f0f0f0;
        position: relative;
        padding-left: 50%;
      }

      td:before {
        /* Now like a table header */
        position: absolute;
        /* Top/left values mimic padding */
        top: 0;
        left: 6px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
      }

      /*
      Label the data
      You could also use a data-* attribute and content for this. That way "bloats" the HTML, this way means you need to keep HTML and CSS in sync. Lea Verou has a clever way to handle with text-shadow.
      */
      
      td:nth-of-type(1):before { content: "Nro."; text-transform: uppercase;font-weight: bold;}
      td:nth-of-type(2):before { content: "Trámite"; text-transform: uppercase;font-weight: bold;}
      td:nth-of-type(3):before { content: "Descripción"; text-transform: uppercase;font-weight: bold;}
      td:nth-of-type(4):before { content: "Acciones"; text-transform: uppercase;font-weight: bold; text-align: left;}
	}
</style>



    