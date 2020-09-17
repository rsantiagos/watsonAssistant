$(document).ready(function() {
  function checkTime(i) {
    if (i < 10) {
      i = "0" + i;
    }
    return i;
  }

  function getTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    return h + ":" + m + ":" + s;
  }

  function pintaEstados(edoid) {
    var array = ["AGUASCALIENTES", "BAJA CALIFORNIA NORTE", "BAJA CALIFORNIA SUR", "CAMPECHE", "CHIAPAS", "CHIHUAHUA", "CIUDAD DE MEXICO", "COAHUILA DE ZARAGOZA", "COLIMA", "DURANGO", "GUANAJUATO", "GUERRERO", "HIDALGO", "JALISCO", "MEXICO", "MICHOACAN DE OCAMPO", "MORELOS", "NAYARIT", "NUEVO LEON", "OAXACA", "PUEBLA", "QUERETARO DE ARTEAGA", "QUINTANA ROO", "SAN LUIS POTOSI", "SINALOA", "SONORA", "TABASCO", "TAMAULIPAS", "TLAXCALA", "VERACRUZ"];
    for (var i = 0; i < array.length; i++) {
      $('.pintaEstados').append('<option value="opc1" selected="selected">' + array[i] + '</option>');
    }
  }

  function pintaMeses(mesid) {
    var array = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
    for (var i = 0; i < array.length; i++) {
      $('.pintaMeses').append('<option value="opc1">' + array[i] + '</option>');
    }
  }

  function pintaAnios(anioid) {
    $('.pintaAnio').append('<option value="opc1" selected>2017</option>');
    $('.pintaAnio').append('<option value="opc1">2018</option>');
  }

  $("#hora_inicio").text(getTime());

  var enviar_mensaje = (function(datos) {
    var mensaje = $("#text_nvo_mensaje").val();
    $("#cont_mensajes_chat").
    append('' +
      '<div class="media chat-messages">' +
      '<div class="media-body chat-menu-reply">' +
      '<div class="">' +
      '<p class="chat-cont">' +
      $("#text_nvo_mensaje").val() +
      '</p>' +
      '<p class="chat-time">' +
      getTime() +
      '</p>' +
      '</div>' +
      '</div>' +
      '<div class="media-right photo-table">' +
      '<a href="#!">' +
      '<img alt="Generic placeholder image" class="media-object img-circle m-t-5" src="public/assets/images/avatar-2.png">' +
      '</img>' +
      '</a>' +
      '</div>' +
      '</div>'
    );
    $("#text_nvo_mensaje").val("");
    //Aquí solicitamos la respuesta
    $.ajax({
      type: "POST",
      url: BASE_URL + "preguntar",
      data: datos,
      success: (function(data) {
        //console.log(data);
        if (data.not_logged_in) {
          $("#sign-in").modal('show');
          $(function() {
            new PNotify({
              title: 'Atención',
              text: 'Debes loguearte para poder continuar',
              icon: 'icofont icofont-info-circle',
              type: 'default'
            })
          });
        } else {
          if (data['chat_ui']) {
            if (data['chat_ui']['datepicker']) {
              console.log('GOT IN');
              $("#text_nvo_mensaje").replaceWith('<input type="text" name="daterange" class="form-control" id="text_nvo_mensaje">');
            }
          }
          //llamado al mapa o la grafica
          if (data['output']) {
            if (data['output']['datos']) {
              if (data['output']['datos']['pintaFrame']) {
                if (data['output']['datos']['pintaFrame'] == "Mapa") {

                  var post_array = {
                    "entrada": data['output']['datos']['region'] ? data['output']['datos']['region'] : data['output']['datos']['estados'],
                    "estado": data['output']['datos']['estados'] ? true : false
                  }
                  $.post(BASE_URL + "GeneraJSON/mapa", post_array,
                    function(data) {
                      setTimeout(ocultarMapa, 250);
                      setTimeout(ocultarGrafica, 250);
                      $("#resMapa").html(data);
                      setTimeout(mostrarMapa, 1000);
                    });


                }
                if (data['output']['datos']['pintaFrame'] == "Grafica") {
                  //setTimeout(mostrarGrafica, 1000);

                  var post_array = {
                    //"entrada" : data['output']['datos']['region'] ? data['output']['datos']['region'] : data['output']['datos']['estados'],
                    //"estado" : data['output']['datos']['estados'] ? true : false,
                    "region": data['output']['datos']['region'] ? data['output']['datos']['region'] : null,
                    "estado": data['output']['datos']['estados'] ? data['output']['datos']['estados'] : null,
                    "mes": data['output']['datos']['mes'] ? data['output']['datos']['mes'] : null,
                    "anio": data['output']['datos']['anio'] ? data['output']['datos']['anio'] : null,
                    "top": data['output']['datos']['top'] ? data['output']['datos']['top'] : null,
                    "fInicial": data['output']['datos']['f_inicial'] ? data['output']['datos']['f_inicial'] : null,
                    "fFinal": data['output']['datos']['f_final'] ? data['output']['datos']['f_final'] : null,
                    "rol": data['output']['datos']['rol'] ? data['output']['datos']['rol'] : null,
                    "condicional": data['output']['datos']['condicional'] ? data['output']['datos']['condicional'] : null,
                    "pregunta": data['output']['datos']['pregunta'] ? data['output']['datos']['pregunta'] : null
                  }
                  $.post(BASE_URL + "GeneraJSON/charts", post_array,
                    function(data) {
                      setTimeout(ocultarMapa, 250);
                      setTimeout(ocultarGrafica, 250);
                      $("#resGrafica").html(data);
                      setTimeout(mostrarGrafica, 1000);
                    });

                }
              }
              // $.ajax({ // pruebas Discovery
              //   url: 'Welcome/mostrarDiscovery',
              //   type: 'POST',
              //   data: {
              //     query: mensaje
              //   },
              //   success: function(response) {
              //     $("#visjs").html(response);
              //   },
              //   error: function(request, status, error) {
              //     alert(request.responseText);
              //   }
              // });
            }
          }

          var respWatson = "";
          var resultado = 0;
          if (data.chat_ui) {
            if (data.chat_ui.datos) {
              if (data.chat_ui.datos.length == 1) {
                if (data.chat_ui.datos[0].totalLineas) {
                  resultado = data.chat_ui.datos[0].totalLineas;
                } else {
                  if (data.chat_ui.datos[0].TotalMG) {
                    if (data.output.estados != '') {
                      resultado = ' <b>' + data.chat_ui.datos[0].TotalMG + ' MB.</b>';
                    } else {
                      resultado = ' <b>' + data.chat_ui.datos[0].nombre + ' con ' + data.chat_ui.datos[0].TotalMG + ' MB.</b>';
                    }
                  }
                }
              }
            }
          }
          for (var i = 0; i < (data.output.text).length; i++) {
            if (data.output.text[i] != '') {
              $("#cont_mensajes_chat").
              append('' +
                '<div class="media chat-messages">' +
                '<a class="media-left photo-table" href="#!">' +
                '<img alt="Generic placeholder image" class="media-object img-circle m-t-5" src="public/assets/images/watson.png">' +
                '</img>' +
                '</a>' +
                '<div class="media-body chat-menu-content">' +
                '<div class="">' +
                '<p class="chat-cont">' +
                data.output.text[i] + ((data.output.text[i].substr(data.output.text[i].length - 1) == ':') ? ' ' + resultado : '') +
                '</p>' +
                '<p class="chat-time">' +
                getTime() +
                '</p>' +
                '</div>' +
                '</div>' +
                '</div>'
              );
              $("#cont_mensajes_chat").scrollTop($("#cont_mensajes_chat")[0].scrollHeight);
              respWatson += data.output.text[i];
            }
          }

          respWatson = respWatson.replace(/:/g, "").replace(/"/g, "");
          //getAudio(respWatson,1);// asistente de voz

          //Bandera para controlar cuando pinta los combos
          $banSegMsn = 0;
          //Llamado a los combos
          if (data['output']) {
            if (data['output']['datos']) {
              if (data['output']['datos']['pintaMes']) {
                if (data['output']['datos']['pintaMes'] == 'true') {
                  $banSegMsn = 1;
                  $comboMes = 'Mes: <select id="pintaMeses" class="pintaMeses"></select><br/>';
                } else {
                  $comboMes = "";
                }
                if (data['output']['datos']['pintaAnio'] == 'true') {
                  $banSegMsn = 1;
                  $comboAnios = 'Año: <select id="pintaAnio" class="pintaAnio"></select><br/>';
                } else {
                  $comboAnios = "";
                }
                if (data['output']['datos']['PintaEstado'] == 'true') {
                  $banSegMsn = 1;
                  $comboEstados = 'Estado: <select id="pintaEstados" class="pintaEstados"></select><br/>';
                } else {
                  $comboEstados = "";
                }
              }
            }
          }
          if ($banSegMsn == 1) {
            //Pinta segundo mensaje
            $("#cont_mensajes_chat").
            append('' +
              '<div class="media chat-messages">' +
              '<a class="media-left photo-table" href="#!">' +
              '<img alt="Generic placeholder image" class="media-object img-circle m-t-5" src="public/assets/images/watson.png">' +
              '</img>' +
              '</a>' +
              '<div class="media-body chat-menu-content">' +
              '<div class="">' +
              '<p class="chat-cont">' +
              $comboMes +
              $comboAnios +
              $comboEstados +
              '<br/>' +
              '<input type="button" name="btnPreg1" id="btnPreg1" class="btnPreg1"  value="Enviar">' +
              '</p>' +
              '<p class="chat-time">' +
              '</p>' +
              '</div>' +
              '</div>' +
              '</div>'
            );
            pintaMeses();
            pintaAnios();
            pintaEstados();
            $(".btnPreg1").click(function() {
              $("#text_nvo_mensaje").val($('#pintaMeses option:selected').text() + " " +
                $('#pintaAnio option:selected').text() +
                (data['output']['datos']['PintaEstado'] ? (" " + $('#pintaEstados option:selected').text()) : ''));
              $("#form_mensaje").submit();
            });
          }
          $("#cont_mensajes_chat").scrollTop($("#cont_mensajes_chat")[0].scrollHeight);
        }
      })
    });
    $("#cont_mensajes_chat").scrollTop($("#cont_mensajes_chat")[0].scrollHeight);
  });

  $("#form_mensaje").on("submit", function(event) {
    event.preventDefault();
    enviar_mensaje($(this).serialize());
  });

  $("#text_nvo_mensaje").keydown(function(e) {
    var code = e.which;
    if (code == 13) {
      e.preventDefault();
      $("#text_nvo_mensaje").val($("#text_nvo_mensaje").val().replace(/(\r\n\t|\n|\r\t)/gm, ""));
      $("#form_mensaje").submit();
    }
  });
});