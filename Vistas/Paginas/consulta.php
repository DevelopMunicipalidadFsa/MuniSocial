<?php 
    $fecha=Controladores::ctrFecha();
    if(isset($_REQUEST['dni'])){
      $datosPersona=Controladores::CtrlConsultaPersona($_REQUEST['dni']);

      if(empty($datosPersona)){
        $datosPersona[0][0] = 'FormularioVacio'; 
      }else{
        $datosPersona[0][0] = $datosPersona[0][0];
      }
    }else{
      $datosPersona[0][0]='Inicio';
    }
    
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

<div class="Container mb-5">
    <form method="POST" id="FormContribu" onsubmit="enviar_ajax(); return false" style="display:none;">
      <div class="row mt-3">
        <div class="p-3 mb-2 bg-secondary text-white">
          <h5 class="text-center">DATOS PERSONALES</h5>
      </div>
      <div class="col-12 mt-2 mb-2">
          <div class="form-floating">
            <input type="hidden" value="<?php echo $id; ?>" name="descripcionTramite">
            <input type="text" class="form-control shadow-sm fw-bold azul" id="Contribuyente" name="Contribuyente" value="<?php if(isset($datosPersona[0][1])){echo $datosPersona[0][1];}?>" required>
            <label for="floatingInputGrid" class="text-danger">APELLIDO Y NOMBRE (*)</label>
          </div>
      </div>
      <div class="col-6 mt-2 mb-2">
          <div class="form-floating">
            <input type="text" class="form-control shadow-sm fw-bold azul" id="NroDni" name="NroDni" value="<?php if(isset($datosPersona[0][7])){echo $datosPersona[0][7];}else if(isset($_REQUEST['dni'])){echo $_REQUEST['dni'];}?>" required>
            <label for="floatingInputGrid" class="text-danger" >DNI (*)</label>
          </div>
      </div>
      <div class="col-6 mt-2 mb-2">
          <div class="form-floating">
            <input class="form-control shadow-sm fw-bold azul" id="FechaNacimiento" name="FechaNacimientoN"  value="<?php if(isset($datosPersona[0][2])){echo date('d/m/Y', strtotime($datosPersona[0][2]));}?>" required>
            <input type="hidden" name="FechaNacimiento" value="<?php if(isset($datosPersona[0][2])){echo $datosPersona[0][2];}?>">

            <label for="floatingInputGrid" class="text-danger">F. NAC. (*)</label>
          </div>
      </div>
      <div class="p-3 mb-2 bg-secondary text-white">
        <h5 class="text-center" class="text-danger">CONTACTOS</h5>
      </div>
      <div class="col-12 mt-2 mb-2">
          <div class="form-floating">
            <input type="email" class="form-control shadow-sm fw-bold azul" id="Mail" name="Mail" value="<?php if(isset($datosPersona[0][4])){echo $datosPersona[0][4];}?>" required>
            <label for="floatingInputGrid" class="text-danger">MAIL (*)</label>
          </div>
      </div>
      <div class="col-12 mt-2 mb-2">
          <div class="form-floating">
            <input type="number" class="form-control shadow-sm fw-bold azul" id="Telefono" name="Telefono" value="<?php if(isset($datosPersona[0][5])){echo $datosPersona[0][5];}?>" required>
            <label for="floatingInputGrid" class="text-danger">CELULAR (*)</label>
          </div>
      </div>
      <div class="p-3 mb-2 bg-secondary text-white">
        <h5 class="text-center">BARRIO</h5>
      </div>
      <div class="col-12 mt-2 mb-2">
          <div class="form-floating">
          </div>
          <div class="form-floating">
            <select class="form-select form-select-lg mb-2" id='buscarBarrio' name="CodBar" lang="es" required>
              <option value='0'>BUSCAR BARRIO</option>
            </select>
            <br>
          </div>
      </div>
      <div class="p-3 mb-2 bg-secondary text-white">
        <h5 class="text-center">TRAMITE O TEMA DE INTERES</h5>
      </div>
      <div class="col-12 mt-2 mb-2">
          <div class="form-floating">
          <select class="form-select form-select-lg mb-2" id='buscarTramite' lang="es" name="Tramite" required>
            <option value='0'>BUSCAR </option>
          </select>
            <br>
          </div>
      </div>
      <div class="col-12 mt-2 mb-2">
          <div class="form-floating">
            <textarea class="form-control shadow-sm fw-bold azul" id="observacionTramite" name="observacionTramite" maxlength="255"></textarea>
            <label for="floatingInputGrid" class="text-danger">DESCRIPCION (*)</label>
          </div>
      </div>
      <input type="hidden" class="form-control shadow-sm fw-bold azul" id="idContribuyente" name="idContribuyente" value="<?php if(isset($datosPersona[0][0])){echo $datosPersona[0][0];}?>">
      <div class="col-12 mt-4 mb-4 d-flex justify-content-center">
          <button type="submit" class="btn btn-outline-success">Guardar Datos <i class="fa fa-save"></i></button>
      </div>
    </form>   
</div>
<center>
    <div class="row mensajeArchivos vw-100" id="mensajeArchivos">
      <div class="col-md-12">
        <h5>Ingrese el DNI</h5>
      </div>
      <div class="col-md-12">
        <h1><img src="Librerias/img/lupa.svg" class="imagenSearch"/></h1>
      </div>
        
        
    </div>
</center>
<form class="ContenedorBuscador" method="POST" action="" id="formulario">
    <input class="form-control inputBusqueda" type="number" name="dni" size="8" maxlength="8" required autocomplete="off" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
    <button type="submit" class="botonBuscar"><span class="icon fa fa-search" aria-hidden="true"></span></button>
</form>

<script>
    // configuramos las vistas del formulario
    var idContribuyente = document.getElementById('idContribuyente').value != '' ? document.getElementById('idContribuyente').value : 'Inicio';
    
    $('#Contribuyente').prop('readonly', true);
    $("#FechaNacimiento").prop('readonly', true);
    $("#NroDni").prop('readonly', true);

    if(idContribuyente != '' && idContribuyente != null && idContribuyente != 'FormularioVacio'&& idContribuyente != 'Inicio'){
      document.getElementById("FormContribu").style.display = "block";
      document.getElementById("mensajeArchivos").style.display = "none";
    }else if(idContribuyente == 'Inicio'){
      document.getElementById("FormContribu").style.display = "none";
      document.getElementById("mensajeArchivos").style.display = "block";
    }else if(idContribuyente == 'FormularioVacio'){

      Swal.fire({
          icon: 'info',
          title: 'El contribuyente no se encuentra en nuestra base de datos. Desea darlo de alta?',
          showDenyButton: true,
          confirmButtonText: 'Si',
          denyButtonText: `No`,
          }).then((result) => {
             if (result.isDenied) {
              window.location.href = 'index.php';
            }
      })
      document.getElementById("FormContribu").style.display = "block";
      $('#Contribuyente').prop('readonly', false);
      $("#FechaNacimiento").prop('readonly', false);
      $("#NroDni").prop('readonly', false);

      document.getElementById("mensajeArchivos").style.display = "none";
      document.getElementById("FechaNacimiento").type = "date";
    }else if(is_numeric(idContribuyente)){
      document.getElementById("FormContribu").style.display = "block";
      document.getElementById("FechaNacimiento").type = "text";
    }

    $(document).ready(function(){
    // buscamos los barrios 
    $("#buscarBarrio").select2({  
        theme: "bootstrap-5",
        selectionCssClass: "select2--medium",
        dropdownCssClass: "select2--medium",      
        ajax: {
          url: "Ajax/barrio.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              searchTerm: params.term // search term
            };
          },
          processResults: function (response) {
            return {
              results: response
            };
          },
        }
      });

      // bucamos las calles
      $("#buscarCalle").select2({ 
        theme: "bootstrap-5",
        selectionCssClass: "select2--medium",
        dropdownCssClass: "select2--medium",       
        ajax: {
          url: "Ajax/calle.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function (params2) {
            return {
              searchTerm2: params2.term // search term
            };
          },
          processResults: function (response2) {
            return {
              results: response2
            };
          },
        }
      });
    });

    // buscamos tema de interes y tramites
    $("#buscarTramite").select2({  
        theme: "bootstrap-5",
        selectionCssClass: "select2--medium",
        dropdownCssClass: "select2--medium",      
        ajax: {
          url: "Ajax/tramite.php",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              searchTerm: params.term // search term
            };
          },
          processResults: function (response) {
            return {
              results: response
            };
          },
        }
      });

      // enviamos formulario con datos
      function enviar_ajax(){	
        
        var form = $('#FormContribu').serialize();
        var barrio = document.getElementById('buscarBarrio').value;
        var tramite = document.getElementById('buscarTramite').value;
        var observacionTramite = document.getElementById('observacionTramite').value;
        var NroDni = document.getElementById('NroDni').value;
        var Contribuyente = document.getElementById('Contribuyente').value;
        var FechaNacimiento = document.getElementById('FechaNacimiento').value;
        var Mail = document.getElementById('Mail').value;
        var Telefono = document.getElementById('Telefono').value;

        if(Contribuyente == '' || Contribuyente == null){
          Swal.fire({
            icon: 'warning',
            title: 'Debe ingresar Apellido y Nombre v&aacute;lido',
          })
          return;
        }
        if(NroDni == 0 || NroDni == '' || NroDni == null){
          Swal.fire({
            icon: 'warning',
            title: 'Debe ingresar un DNI v&aacute;lido',
          })
          return;
        }

        if(FechaNacimiento == 0 || FechaNacimiento == '' || FechaNacimiento == null){
          Swal.fire({
            icon: 'warning',
            title: 'Debe Fecha de Nacimiento v&aacute;lido',
          })
          return;
        }
        if(Mail == '' || Mail == null){
          Swal.fire({
            icon: 'warning',
            title: 'Debe ingresar un mail v&aacute;lido',
          })
          return;
        }

        if(Telefono == 0 || Telefono == '' || Telefono == null){
          Swal.fire({
            icon: 'warning',
            title: 'Debe ingresar un telefono v&aacute;lido',
          })
          return;
        } 

        if(barrio == 0 || barrio == '' || barrio == null){
          Swal.fire({
            icon: 'warning',
            title: 'Debe seleccionar un barrio v&aacute;lido',
          })
          return;
        }

        if(tramite == 0 || tramite == '' || tramite == null){
          Swal.fire({
            icon: 'warning',
            title: 'Debe seleccionar un tr&aacute;mite v&aacute;lido',
          })
          return;
        }

        if(observacionTramite == 0 || observacionTramite == '' || observacionTramite == null){
          Swal.fire({
            icon: 'warning',
            title: 'Debe enviar una descripci&oacute;n de tr&aacute;mite v&aacute;lido',
          })
          return;
        }
        
        $.ajax({
        type: 'POST',
        url: 'Ajax/createUpdateTramite.php',
        dataType : 'json',
        data: form,
          success: function(respuesta) {
            console.log(respuesta);
            if(respuesta.code === 200){
              Swal.fire({
                icon: 'success',
                title: 'El tr&aacute;mite se guardo correctamente',
                showDenyButton: true,
                showDenyButton:false,
                confirmButtonText: 'ok',
                            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                  if (result.isConfirmed) {
                    window.location.href = window.location.href;
                  } else{
                    window.location.href = window.location.href;
                  }
              })
             
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error al dar de alta el tramite, ante cualquier duda comuniquese con el administador',
              })
            }
          }
        });
      }
</script>



    