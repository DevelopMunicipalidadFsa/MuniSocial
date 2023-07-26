$(document).ready(function () {
  $("#username").on("blur", function () {
    $("#resultadoUsuario")
      .html(
        '<img class="Gifcargando" src="Librerias/img/loading.gif" width="30px" height="30px"/>'
      )
      .fadeOut(100);

    var username = $(this).val();
    var dataString = "username=" + username;

    $.ajax({
      type: "POST",
      url: "Librerias/ajax/ValidacionUsuario.php",
      data: dataString,
      success: function (data) {
        $("#resultadoUsuario").fadeIn(1000).html(data);
      },
    });
  });
});

$(document).ready(function () {
  var height = $(window).height();
  var alto = height - 120;
  $("#Ajuste").height(alto);
});

function DescargarPdf(numero, tramite) {
  // console.log(numero, persona);
  var id_solicitud = numero;
  var tramite = tramite;

  alert(id_solicitud + tramite);
  document.addEventListener("DOMContentLoaded", () => {
    //click del botón
    const $boton = document.querySelector("#Descargar");
    $boton.addEventListener("click", () => {
      const $elementoParaConvertir = document.body; // <-- Aquí puedes elegir cualquier elemento del DOM
      html2pdf()
        .set({
          margin: 1,
          filename:
            'MunicipalidadeFormosa<?php echo "_Solicitud_de_HabilitacionComercial_" . $idSolicitud . ".pdf"; ?>',
          image: {
            type: "jpeg",
            quality: 100,
          },
          html2canvas: {
            scale: 5, // A mayor escala, mejores gráficos, pero más peso
            letterRendering: false,
          },
          jsPDF: {
            unit: "in",
            format: "A4",
            orientation: "portrait", // landscape o portrait
          },
        })
        .from($elementoParaConvertir)
        .save()
        .catch((err) => console.log(err))
        .finally();
    });
  });
}

$(document).ready(function () {
  var height = $(window).height();
  var alto = height - 120;
  $("#Ajuste").height(alto);
});

$(obtener_registros());
function obtener_registros(solicitud) {
  $.ajax({
    url: "Librerias/ajax/ListadoSolicitudes.php",
    type: "POST",
    dataType: "html",
    data: { solicitud: solicitud },
  }).done(function (resultado) {
    $("#Solicitudes").html(resultado);
  });
}

$(document).on("keyup", "#solicitud", function () {
  var valorBusqueda = $(this).val();
console.log(valorBusqueda);
  // if (valorBusqueda != "") {
  //   obtener_registros(valorBusqueda);
  // } else {
  //   obtener_registros();
  // }
});

$(document).on("click", ".btnBack", function () {
  window.location.href = "Plantillas.php?pagina=Modulos/AdministrarSolicitudes";
});

$(document).on("click", ".btnAprobarSolicitud", function () {
  var id_solicitud = $(this).attr("id_solicitud");
  var id_contribuyente = $(this).attr("id_contribuyente");
  var idTramiteEstado = $(this).attr("idTramiteEstado");

  $("#AprobarSolicitud input[name=idSolicitud]").val(id_solicitud);
  $("#AprobarSolicitud input[name=idContribuyente]").val(id_contribuyente);
  $("#AprobarSolicitud input[name=Estado]").val(idTramiteEstado);
  $("#AprobarSolicitud").showModal();
});

$(document).on("click", ".btnRechazarSolicitud", function () {
  var id_solicitud = $(this).attr("id_solicitud");
  var id_contribuyente = $(this).attr("id_contribuyente");
  var idTramiteEstado = $(this).attr("idTramiteEstado");

  $("#RechazarSolicitud input[name=idSolicitud]").val(id_solicitud);
  $("#RechazarSolicitud input[name=idContribuyente]").val(id_contribuyente);
  $("#RechazarSolicitud input[name=Estado]").val(idTramiteEstado);
  $("#RechazarSolicitud").showModal();
});

$(document).on("click", ".btnBorrarSolicitud", function () {
  var id_solicitud = $(this).attr("id_solicitud");
  var id_contribuyente = $(this).attr("id_contribuyente");
  // var idTramiteEstado = $(this).attr("idTramiteEstado");

  $("#BorrarSolicitud input[name=idSolicitud]").val(id_solicitud);
  $("#BorrarSolicitud input[name=idContribuyente]").val(id_contribuyente);
  // $("#BorrarSolicitud input[name=Estado]").val(idTramiteEstado);
  $("#BorrarSolicitud").showModal();
});
