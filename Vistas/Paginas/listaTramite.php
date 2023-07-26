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
    if($nivel == 1){
        $sql="SELECT tc.idTramites,t.TramitesNombre,tc.idContribuyentes, c.Contribuyente, c.NroDni,tc.idSolicitud,tc.TramiteFechaInicio, tc.TramiteFechaFin, tc.TramiteObjeto, tc.TramiteObservacion, t.idTramites AS idTramite, t.idRubro, tc.TramiteDescripcion,tc.idTamites_por_Contribuyentes,b.Detalle
        FROM Tramites_por_Contribuyentes AS tc 
        INNER JOIN Tramites AS t ON t.idTramites = tc.idTramites 
        INNER JOIN Personas AS c ON tc.idContribuyentes = c.Id
        INNER JOIN Barrios AS b ON tc.idBarrio = b.Id
        WHERE t.idRubro=2 
        ORDER BY tc.idTamites_por_Contribuyentes DESC";
    }else{
      $sql="SELECT tc.idTramites,t.TramitesNombre,tc.idContribuyentes, c.Contribuyente, c.NroDni,tc.idSolicitud,tc.TramiteFechaInicio, tc.TramiteFechaFin, tc.TramiteObjeto, tc.TramiteObservacion, t.idTramites AS idTramite, t.idRubro, tc.TramiteDescripcion,tc.idTamites_por_Contribuyentes,b.Detalle
      FROM Tramites_por_Contribuyentes AS tc 
      INNER JOIN Tramites AS t ON t.idTramites = tc.idTramites 
      INNER JOIN Personas AS c ON tc.idContribuyentes = c.Id
      INNER JOIN Barrios AS b ON tc.idBarrio = b.Id
      WHERE t.idRubro=2 and
      tc.TramiteDescripcion = $id
      ORDER BY tc.idTamites_por_Contribuyentes DESC";
    }
  $tramitesLista=Conexiones::conMunicipalidadDigital()->prepare($sql);

  $tramitesLista->execute();

  $Lista =  $tramitesLista->fetchAll();
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
 <h1 class="text-center mt-3 mb-3 text-uppercase">Lista de trámites o temas de interés</h1>
  <?php if($Lista){ ?>
    
    <table class="table table-hover"id="ListaTramites" role="table">
      <thead class="bg-primary text-white" role="rowgroup">
        <tr role="row">
          <td class="text-center" role="columnheader">N° de Consulta</td>
          <td class="text-center" role="columnheader">Tramite</td>
          <td class="text-center" role="columnheader">Fecha Inicio</td>
          <td class="text-center" role="columnheader">Descripción</td>
          <td class="text-center datos" role="columnheader">Contribuyente</td>
          <td class="text-center datos" role="columnheader">Barrio</td>
          <td class="text-center datos" role="columnheader">Dni</td>
          <td class="text-center datos" role="columnheader">Eliminar</td>
        </tr>
      </thead>
      <tbody role="rowgroup">
        <?php
        foreach ($Lista as $value): ?> 
        <tr role="row">
          <td role="cell"><?php echo $value[13]; ?></td>
          <td role="cell"><?php echo $value[1] ?></td>
          <td role="cell"><?php echo date('d-m-Y',strtotime($value[6])); ?></td>
          <td role="cell"><?php echo $value[9] ?></td>
          <td role="cell"><?php echo $value[3] ?></td>
          <td role="cell"><?php echo $value[14] ?></td>
          <td role="cell"><?php echo $value[4] ?></td>
          <td role="cell"><button class="btn btn-danger" onclick="eliminarTramite(<?php echo $value[13]; ?>)"><i class="fa fa-trash"></i></button></td>
          
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  <?php }else{?>
    <div class="col-auto p-2 m-1 text-center">
      <div class="alert alert-danger text-center" role="alert">
        <p class="mb-0">No hay tramites cargados</p>
      </div>
    </div>
      
    
  <?php } ?>
</div>

<script>
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
                url: 'Ajax/eliminarTramiteLista.php',
                dataType : 'json',
                data: {idTramite: idTramites},
                  success: function(respuesta) {
                    // console.log(respuesta);
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
    // configuramos las vistas del formulario
    var idContribuyente = document.getElementById('idContribuyente').value != '' ? document.getElementById('idContribuyente').value : 'Inicio';
    
    document.getElementById('Contribuyente').disabled = true;
    document.getElementById("FechaNacimiento").disabled = true;
    document.getElementById("NroDni").disabled = true;

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
      document.getElementById("Contribuyente").disabled = false;
      document.getElementById("FechaNacimiento").disabled = false;
      document.getElementById("NroDni").disabled = false;
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
        var calle = document.getElementById('buscarCalle').value;
        var tramite = document.getElementById('buscarTramite').value;
        var descripcionTramite = document.getElementById('descripcionTramite').value;


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

        if(descripcionTramite == 0 || descripcionTramite == '' || descripcionTramite == null){
          Swal.fire({
            icon: 'warning',
            title: 'Debe enviar una descripci&oacute;n de tr&aacute;mite v&aacute;lido',
          })
          return;
        }
        
        // console.log(form);

        $.ajax({
        type: 'POST',
        url: 'Ajax/createUpdateTramite.php',
        dataType : 'json',
        data: $('#FormContribu').serialize(),
          success: function(respuesta) {
            if(respuesta.rta == 'ok'){
              Swal.fire({
            icon: 'success',
            title: 'El tr&aacute;mite se guardo correctamente',
          })
            }
            else {
              Swal.fire({
            icon: 'error',
            title: 'Error al dar de alta el tramite, ante cualquier duda comuniquese con el administador',
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
    
		td:nth-of-type(1):before { content: "Consulta"; text-transform: uppercase;font-weight: bold;}
		td:nth-of-type(2):before { content: "Trámite"; text-transform: uppercase;font-weight: bold;}
		td:nth-of-type(3):before { content: "Fecha Inicio"; text-transform: uppercase;font-weight: bold;}
		td:nth-of-type(4):before { content: "Descripción"; text-transform: uppercase;font-weight: bold;}
		td:nth-of-type(5):before { content: "Persona"; text-transform: uppercase;font-weight: bold;}
		td:nth-of-type(6):before { content: "Barrio"; text-transform: uppercase;font-weight: bold;}
		td:nth-of-type(7):before { content: "Dni"; text-transform: uppercase;font-weight: bold;}
		td:nth-of-type(8):before { content: "Eliminar"; text-transform: uppercase;font-weight: bold; text-align: left;}
	}
</style>



    