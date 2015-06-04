<br>
<div class="col-xl-10 col-sm-10 col-md-10 col-md-offset-2">
  <div id="bc1" class="btn-group btn-breadcrumb">
      <a href="?ac=certificacion" id="bread1" class="btn btn-info"><div>1.- Tipo de Solicitud</div></a>
      <a href="#" id="bread2" class="btn btn-info"><div>2.- Datos Generales</div></a>
      <a href="#" id="bread3" class="btn btn-default"><div>3.- Confirmación</div></a>
      <a href="#" id="bread4" class="btn btn-default"><div>4.- Impresión</div></a>
  </div>
</div>
<br><br>

<div id="ordenBoleta"> 
<!--   <p><h4 class="text-center">
  <span class="label label-danger">Particular</span>
  </h4></p><br> -->
  <div class="col-xl-12 col-sm-12 col-md-12 col-md-offset-1"> 
   <h3>
    <span class="label label-default">Orden de Pago:</span>
    </h3>
  </div>
  <br><br>
  <div class="col-xl-12 col-sm-12 col-md-12 col-md-offset-1">
      <form method="post" id="FormOrdenPago" >
          <div class="form-group col-xl-6 col-sm-6 col-md-6 col-md-offset-2">
            <label for="Norden" class="Colet">Orden de Pago No.: <span class="sm">(Campo Obligatorio)</span></label>
            <input type="text" class="form-control" id="Norden" data-toggle="tooltip" data-placement="right" title="Ingresar Numero de orden de Pago" data-campo="Norden" placeholder="Orden de Pago Numero" onkeypress="return checkSoloNum(event)" required autofocus>
          </div>
          <br>
          <div class="col-xl-6 col-sm-6 col-md-6 col-md-offset-4">
            <button type="button" id="btn_ingresar"  class="btn btn-primary btn-lg btn-shadow">
              <span class="glyphicon glyphicon-search"> </span>
              Verificar
            </button> 
          </div>
      </form>
  </div>
</div>

<div id="respOrdenBoleta" class="col-xl-12 col-sm-12 col-md-12" style="margin-top:3em;">

</div>

<div id="ModalBoletaOrden" class="modal fade">
  <div class="modal-dialog modal-dialog-center">
    <div class="modal-content">
      <div class="modal-body">
        <b>Esta segúro del numero de boleta de banco que ingreso?</b>
        <p>La boleta de banco No.<b><span id="IBoleta"></span></b> es igual a la orden de pago No.<b><span id="IOrden"></span></b></p>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
        <button type="button" data-dismiss="modal" class="btn btn-danger" id="ModalContinuar">Continuar</button>
      </div>

    </div>
  </div>
</div>

<script>
$("#btn_ingresar").click(function(){
  var datosOrden="";
  if($('#Norden').val()==""){
    $('#Norden').focus();
    $('#Norden').tooltip('show');
  }else{
    datosOrden+="Norden="+$('#Norden').val();
    datosOrden+="&fun=1";
    var url = "certificacion/funcion_certificacion.php"; 
    $.ajax({
      type: "POST",
      url: url,
      data: datosOrden,
      success: function(data)
      {
        console.log(data);
        var jorden = JSON.parse(data);
        switch(jorden.case){
          case 0:
            window.location.reload();
          break;
          case 1:
            $("#respOrdenBoleta").html(jorden.message);
            $('#Norden').val(""); 
            $('#Norden').focus(); 
          break;
          case 2:
            $("#respOrdenBoleta").html(jorden.message);
            $('#Norden').val(""); 
            $('#Norden').focus(); 
          break;
          case 3:
            $("#respOrdenBoleta").html("");
            $("html, body").animate({ scrollTop: 250 }, 1000);
            $("#ordenBoleta").html(jorden.message);
          break;
          default:

        }

      }
    });

  }
 });

function atras() {
  window.location = "?ac=certificacion&tipo=particular";
}

function comprobar_datos() {
  var datosBoleta="&Norden="+$('#nOrden').text();
  if($('#Nboleta').val()==""){
    $('#Nboleta').focus();
    $('#Nboleta').tooltip('show');
  }else{
    if ($('#nOrden').text()==$('#Nboleta').val().toUpperCase()) {
      $("#IBoleta").text($('#Nboleta').val());
      $("#IOrden").text($('#nOrden').text());
      $('#ModalBoletaOrden').modal({ backdrop: 'static', keyboard: false })
      .one('click', '#ModalContinuar', function (e) {
        if ($('#NfolioEntrada').val()=="") {
          $('#NfolioEntrada').focus();
          $('#NfolioEntrada').tooltip('show');
        }else{
          datosBoleta+="&Nboleta="+$.trim($('#Nboleta').val().toUpperCase())+"&NfolioEntrada="+$.trim($('#NfolioEntrada').val().toUpperCase());
          if($('#idConcepto').text()==9){
            if($('#InFrontera').val()==""){
              $('#InFrontera').focus();
              $('#InFrontera').tooltip('show');
            }else{
              if($('#Fingreso').val()==""){
                $('#Fingreso').focus();
                $('#Fingreso').tooltip('show');
              }else{
                if($('#Sdias').val()==""){
                  $('#Sdias').focus();
                  $('#Sdias').tooltip('show');
                }else{
                    datosBoleta+="&InFrontera="+$('#InFrontera').val().toUpperCase()+"&Fingreso="+$('#Fingreso').val()+"&Sdias="+$('#Sdias').val();
                    datosBoleta+="&fun=2";
                    console.log(datosBoleta);
                    var url = "certificacion/funcion_certificacion.php"; 
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: datosBoleta,
                        success: function(data)
                        {
                          console.log(data);
                          var jorden = JSON.parse(data);
                          switch(jorden.case){
                            case 0:
                              window.location.reload();
                            break;
                            case 1:
                              $("#respOrdenBoleta").html(jorden.message);
                              $('#Norden').val(""); 
                              $('#Norden').focus(); 
                            break;
                            case 2:
                              $("#respOrdenBoleta").html(jorden.message);
                              $("html, body").animate({ scrollTop: 350 }, "slow");
                              $('#Nboleta').focus(); 
                            break;
                            case 3:
                              $("#respOrdenBoleta").html("");
                              $("#ordenBoleta").html(jorden.message);
                              $("html, body").animate({ scrollTop: 200 }, "slow");
                              $("#bread2").addClass("btn-info");
                              $("#bread3").addClass("btn-info");
                            break;
                            default:
                          }
                        }
                    });
                } 
              } 
            }
          }else{
            if(!$("#checkSI").prop("checked")&&!$("#checkNO").prop("checked")){
              $('#chekMovimiento').focus();
              $('#chekMovimiento').tooltip('show');
            }else{
              if($("#checkSI").prop("checked")){
                if($('#Nfolio').val()=="") {
                  $('#Nfolio').focus();
                  $('#Nfolio').tooltip('show');
                }else{
                  datosBoleta+="&Nfolio="+$('#Nfolio').val();

                  if(!$("#checkSiDeportado").prop("checked")&&!$("#checkNoDeportado").prop("checked")){
                    $('#checkDep').focus();
                    $('#checkDep').tooltip('show');
                  }else{

                    if($("#checkSiDeportado").prop("checked")){
                      // if($('#FechaDepor').val()==""){
                      //   $('#FechaDepor').focus();
                      //   $('#FechaDepor').tooltip('show');
                      // }else{
                        if($('#Vproveniente').val()==""){
                          $('#Vproveniente').focus();
                          $('#Vproveniente').tooltip('show');
                        }else{
                          datosBoleta+="&FechaDepor="+$('#FechaDepor').val();
                          datosBoleta+="&Vproveniente="+$('#Vproveniente').val().toUpperCase();
                          datosBoleta+="&fun=2";
                          console.log(datosBoleta);
                          var url = "certificacion/funcion_certificacion.php"; 
                          $.ajax({
                              type: "POST",
                              url: url,
                              data: datosBoleta,
                              success: function(data)
                              {
                                console.log(data);
                                var jorden = JSON.parse(data);
                                switch(jorden.case){
                                  case 0:
                                    window.location.reload();
                                  break;
                                  case 1:
                                    $("#respOrdenBoleta").html(jorden.message);
                                    $('#Norden').val(""); 
                                    $('#Norden').focus(); 
                                  break;
                                  case 2:
                                    $("#respOrdenBoleta").html(jorden.message);
                                    $("html, body").animate({ scrollTop: 350 }, "slow");
                                    $('#Nboleta').focus(); 
                                  break;
                                  case 3:
                                    $("#respOrdenBoleta").html("");
                                    $("#ordenBoleta").html(jorden.message);
                                    $("html, body").animate({ scrollTop: 200 }, "slow");
                                    $("#bread2").addClass("btn-info");
                                    $("#bread3").addClass("btn-info");
                                  break;
                                  default:
                                }
                              }
                            });
                        }
                      // }--
                    }
                    else if($("#checkNoDeportado").prop("checked")){
                      datosBoleta+="&fun=2";
                      console.log(datosBoleta);

                      var url = "certificacion/funcion_certificacion.php"; 
                          $.ajax({
                              type: "POST",
                              url: url,
                              data: datosBoleta,
                              success: function(data)
                              {
                                console.log(data);
                                var jorden = JSON.parse(data);
                                switch(jorden.case){
                                  case 0:
                                    window.location.reload();
                                  break;
                                  case 1:
                                    $("#respOrdenBoleta").html(jorden.message);
                                    $('#Norden').val(""); 
                                    $('#Norden').focus(); 
                                  break;
                                  case 2:
                                    $("#respOrdenBoleta").html(jorden.message);
                                    $("html, body").animate({ scrollTop: 350 }, "slow");
                                    $('#Nboleta').focus(); 
                                  break;
                                  case 3:
                                    $("#respOrdenBoleta").html("");
                                    $("#ordenBoleta").html(jorden.message);
                                    $("html, body").animate({ scrollTop: 200 }, "slow");
                                    $("#bread2").addClass("btn-info");
                                    $("#bread3").addClass("btn-info");
                                  break;
                                  default:
                                }
                              }
                            });

                    }
                    
                  }
                }

              }else if($("#checkNO").prop("checked")){
                var negativa = $("#cboNegativa").val();
                // if($("#checkSiDeportado").prop("checked")){
                //   negativa=4;
                // }
                if (negativa==0) {
                  $('#cboNegativa').focus();
                  $('#cboNegativa').tooltip('show');
                }else{
                  datosBoleta+="&negativa="+negativa;
                  
                  if(negativa == 3 && $('#txtsolicitud').val()=="")
                  {
                    $('#txtsolicitud').focus();
                    $('#txtsolicitud').tooltip('show');
                  }else if(negativa == 3){
                    datosBoleta+="&txtsolicitud="+$('#txtsolicitud').val().toUpperCase();

                    if(!$("#checkSiDeportado").prop("checked")&&!$("#checkNoDeportado").prop("checked")){
                    $('#checkDep').focus();
                    $('#checkDep').tooltip('show');
                    }else{

                      if($("#checkSiDeportado").prop("checked")){
                        // if($('#FechaDepor').val()==""){
                        //   $('#FechaDepor').focus();
                        //   $('#FechaDepor').tooltip('show');
                        // }else{
                          if($('#Vproveniente').val()==""){
                            $('#Vproveniente').focus();
                            $('#Vproveniente').tooltip('show');
                          }else{
                            datosBoleta+="&FechaDepor="+$('#FechaDepor').val();
                            datosBoleta+="&Vproveniente="+$('#Vproveniente').val().toUpperCase();
                            datosBoleta+="&fun=2";
                            console.log(datosBoleta);
                            var url = "certificacion/funcion_certificacion.php"; 
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: datosBoleta,
                                success: function(data)
                                {
                                  console.log(data);
                                  var jorden = JSON.parse(data);
                                  switch(jorden.case){
                                    case 0:
                                      window.location.reload();
                                    break;
                                    case 1:
                                      $("#respOrdenBoleta").html(jorden.message);
                                      $('#Norden').val(""); 
                                      $('#Norden').focus(); 
                                    break;
                                    case 2:
                                      $("#respOrdenBoleta").html(jorden.message);
                                      $("html, body").animate({ scrollTop: 400 }, "slow");
                                      $('#Nboleta').focus();
                                    break;
                                    case 3:
                                      $("#respOrdenBoleta").html("");
                                      $("#ordenBoleta").html(jorden.message);
                                      $("html, body").animate({ scrollTop: 200 }, "slow");
                                      $("#bread2").addClass("btn-info");
                                      $("#bread3").addClass("btn-info");
                                    break;
                                    default:
                                  }
                                }
                              });
                          }
                        // }--
                      }
                      else if($("#checkNoDeportado").prop("checked")){
                        datosBoleta+="&fun=2";
                        console.log(datosBoleta);

                        var url = "certificacion/funcion_certificacion.php"; 
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: datosBoleta,
                            success: function(data)
                            {
                              console.log(data);
                              var jorden = JSON.parse(data);
                              switch(jorden.case){
                                case 0:
                                  window.location.reload();
                                break;
                                case 1:
                                  $("#respOrdenBoleta").html(jorden.message);
                                  $('#Norden').val(""); 
                                  $('#Norden').focus(); 
                                break;
                                case 2:
                                  $("#respOrdenBoleta").html(jorden.message);
                                  $("html, body").animate({ scrollTop: 400 }, "slow");
                                  $('#Nboleta').focus(); 
                                break;
                                case 3:
                                  $("#respOrdenBoleta").html("");
                                  $("#ordenBoleta").html(jorden.message);
                                  $("html, body").animate({ scrollTop: 200 }, "slow");
                                  $("#bread2").addClass("btn-info");
                                  $("#bread3").addClass("btn-info");
                                break;
                                default:
                              }
                            }
                          });

                      }
                      
                    }

                  }else{

                    if(!$("#checkSiDeportado").prop("checked")&&!$("#checkNoDeportado").prop("checked")){
                    $('#checkDep').focus();
                    $('#checkDep').tooltip('show');
                  }else{

                    if($("#checkSiDeportado").prop("checked")){
                      // if($('#FechaDepor').val()==""){
                      //   $('#FechaDepor').focus();
                      //   $('#FechaDepor').tooltip('show');
                      // }else{
                        if($('#Vproveniente').val()==""){
                          $('#Vproveniente').focus();
                          $('#Vproveniente').tooltip('show');
                        }else{
                          datosBoleta+="&FechaDepor="+$('#FechaDepor').val();
                          datosBoleta+="&Vproveniente="+$('#Vproveniente').val().toUpperCase();
                          datosBoleta+="&fun=2";
                          console.log(datosBoleta);
                          var url = "certificacion/funcion_certificacion.php"; 
                          $.ajax({
                              type: "POST",
                              url: url,
                              data: datosBoleta,
                              success: function(data)
                              {
                                console.log(data);
                                var jorden = JSON.parse(data);
                                switch(jorden.case){
                                  case 0:
                                    window.location.reload();
                                  break;
                                  case 1:
                                    $("#respOrdenBoleta").html(jorden.message);
                                    $('#Norden').val(""); 
                                    $('#Norden').focus(); 
                                  break;
                                  case 2:
                                    $("#respOrdenBoleta").html(jorden.message);
                                    $("html, body").animate({ scrollTop: 350 }, "slow");
                                    $('#Nboleta').focus(); 
                                  break;
                                  case 3:
                                    $("#respOrdenBoleta").html("");
                                    $("#ordenBoleta").html(jorden.message);
                                    $("html, body").animate({ scrollTop: 200 }, "slow");
                                    $("#bread2").addClass("btn-info");
                                    $("#bread3").addClass("btn-info");
                                  break;
                                  default:
                                }
                              }
                            });
                        }
                      // }--
                    }
                    else if($("#checkNoDeportado").prop("checked")){
                      datosBoleta+="&fun=2";
                      console.log(datosBoleta);

                      var url = "certificacion/funcion_certificacion.php"; 
                          $.ajax({
                              type: "POST",
                              url: url,
                              data: datosBoleta,
                              success: function(data)
                              {
                                console.log(data);
                                var jorden = JSON.parse(data);
                                switch(jorden.case){
                                  case 0:
                                    window.location.reload();
                                  break;
                                  case 1:
                                    $("#respOrdenBoleta").html(jorden.message);
                                    $('#Norden').val(""); 
                                    $('#Norden').focus(); 
                                  break;
                                  case 2:
                                    $("#respOrdenBoleta").html(jorden.message);
                                    $("html, body").animate({ scrollTop: 350 }, "slow");
                                    $('#Nboleta').focus(); 
                                  break;
                                  case 3:
                                    $("#respOrdenBoleta").html("");
                                    $("#ordenBoleta").html(jorden.message);
                                    $("html, body").animate({ scrollTop: 200 }, "slow");
                                    $("#bread2").addClass("btn-info");
                                    $("#bread3").addClass("btn-info");
                                  break;
                                  default:
                                }
                              }
                          });

                      }
                      
                    }

                  }
                }
              }
            }
          }
        }
      });
    }else{
      if ($('#NfolioEntrada').val()=="") {
        $('#NfolioEntrada').focus();
        $('#NfolioEntrada').tooltip('show');
      }else{
        datosBoleta+="&Nboleta="+$.trim($('#Nboleta').val().toUpperCase())+"&NfolioEntrada="+$.trim($('#NfolioEntrada').val().toUpperCase());
        if($('#idConcepto').text()==9){
          if($('#InFrontera').val()==""){
            $('#InFrontera').focus();
            $('#InFrontera').tooltip('show');
          }else{
            if($('#Fingreso').val()==""){
              $('#Fingreso').focus();
              $('#Fingreso').tooltip('show');
            }else{
              if($('#Sdias').val()==""){
                $('#Sdias').focus();
                $('#Sdias').tooltip('show');
              }else{
                  datosBoleta+="&InFrontera="+$('#InFrontera').val().toUpperCase()+"&Fingreso="+$('#Fingreso').val()+"&Sdias="+$('#Sdias').val();
                  datosBoleta+="&fun=2";
                  console.log(datosBoleta);
                  var url = "certificacion/funcion_certificacion.php"; 
                  $.ajax({
                      type: "POST",
                      url: url,
                      data: datosBoleta,
                      success: function(data)
                      {
                        console.log(data);
                        var jorden = JSON.parse(data);
                        switch(jorden.case){
                          case 0:
                            window.location.reload();
                          break;
                          case 1:
                            $("#respOrdenBoleta").html(jorden.message);
                            $('#Norden').val(""); 
                            $('#Norden').focus(); 
                          break;
                          case 2:
                            $("#respOrdenBoleta").html(jorden.message);
                            $("html, body").animate({ scrollTop: 350 }, "slow");
                            $('#Nboleta').focus(); 
                          break;
                          case 3:
                            $("#respOrdenBoleta").html("");
                            $("#ordenBoleta").html(jorden.message);
                            $("html, body").animate({ scrollTop: 200 }, "slow");
                            $("#bread2").addClass("btn-info");
                            $("#bread3").addClass("btn-info");
                          break;
                          default:
                        }
                      }
                  });
              } 
            } 
          }
        }else{
          if(!$("#checkSI").prop("checked")&&!$("#checkNO").prop("checked")){
            $('#chekMovimiento').focus();
            $('#chekMovimiento').tooltip('show');
          }else{
            if($("#checkSI").prop("checked")){
              if($('#Nfolio').val()=="") {
                $('#Nfolio').focus();
                $('#Nfolio').tooltip('show');
              }else{
                datosBoleta+="&Nfolio="+$('#Nfolio').val();

                if(!$("#checkSiDeportado").prop("checked")&&!$("#checkNoDeportado").prop("checked")){
                  $('#checkDep').focus();
                  $('#checkDep').tooltip('show');
                }else{

                  if($("#checkSiDeportado").prop("checked")){
                    // if($('#FechaDepor').val()==""){
                    //   $('#FechaDepor').focus();
                    //   $('#FechaDepor').tooltip('show');
                    // }else{
                      if($('#Vproveniente').val()==""){
                        $('#Vproveniente').focus();
                        $('#Vproveniente').tooltip('show');
                      }else{
                        datosBoleta+="&FechaDepor="+$('#FechaDepor').val();
                        datosBoleta+="&Vproveniente="+$('#Vproveniente').val().toUpperCase();
                        datosBoleta+="&fun=2";
                        console.log(datosBoleta);
                        var url = "certificacion/funcion_certificacion.php"; 
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: datosBoleta,
                            success: function(data)
                            {
                              console.log(data);
                              var jorden = JSON.parse(data);
                              switch(jorden.case){
                                case 0:
                                  window.location.reload();
                                break;
                                case 1:
                                  $("#respOrdenBoleta").html(jorden.message);
                                  $('#Norden').val(""); 
                                  $('#Norden').focus(); 
                                break;
                                case 2:
                                  $("#respOrdenBoleta").html(jorden.message);
                                  $("html, body").animate({ scrollTop: 350 }, "slow");
                                  $('#Nboleta').focus(); 
                                break;
                                case 3:
                                  $("#respOrdenBoleta").html("");
                                  $("#ordenBoleta").html(jorden.message);
                                  $("html, body").animate({ scrollTop: 200 }, "slow");
                                  $("#bread2").addClass("btn-info");
                                  $("#bread3").addClass("btn-info");
                                break;
                                default:
                              }
                            }
                          });
                      }
                    // }--
                  }
                  else if($("#checkNoDeportado").prop("checked")){
                    datosBoleta+="&fun=2";
                    console.log(datosBoleta);

                    var url = "certificacion/funcion_certificacion.php"; 
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: datosBoleta,
                            success: function(data)
                            {
                              console.log(data);
                              var jorden = JSON.parse(data);
                              switch(jorden.case){
                                case 0:
                                  window.location.reload();
                                break;
                                case 1:
                                  $("#respOrdenBoleta").html(jorden.message);
                                  $('#Norden').val(""); 
                                  $('#Norden').focus(); 
                                break;
                                case 2:
                                  $("#respOrdenBoleta").html(jorden.message);
                                  $("html, body").animate({ scrollTop: 350 }, "slow");
                                  $('#Nboleta').focus(); 
                                break;
                                case 3:
                                  $("#respOrdenBoleta").html("");
                                  $("#ordenBoleta").html(jorden.message);
                                  $("html, body").animate({ scrollTop: 200 }, "slow");
                                  $("#bread2").addClass("btn-info");
                                  $("#bread3").addClass("btn-info");
                                break;
                                default:
                              }
                            }
                          });

                  }
                  
                }
              }

            }else if($("#checkNO").prop("checked")){
              var negativa = $("#cboNegativa").val();
              // if($("#checkSiDeportado").prop("checked")){
              //   negativa=4;
              // }
              if (negativa==0) {
                $('#cboNegativa').focus();
                $('#cboNegativa').tooltip('show');
              }else{
                datosBoleta+="&negativa="+negativa;
                
                if(negativa == 3 && $('#txtsolicitud').val()=="")
                {
                  $('#txtsolicitud').focus();
                  $('#txtsolicitud').tooltip('show');
                }else if(negativa == 3){
                  datosBoleta+="&txtsolicitud="+$('#txtsolicitud').val().toUpperCase();

                  if(!$("#checkSiDeportado").prop("checked")&&!$("#checkNoDeportado").prop("checked")){
                  $('#checkDep').focus();
                  $('#checkDep').tooltip('show');
                  }else{

                    if($("#checkSiDeportado").prop("checked")){
                      // if($('#FechaDepor').val()==""){
                      //   $('#FechaDepor').focus();
                      //   $('#FechaDepor').tooltip('show');
                      // }else{
                        if($('#Vproveniente').val()==""){
                          $('#Vproveniente').focus();
                          $('#Vproveniente').tooltip('show');
                        }else{
                          datosBoleta+="&FechaDepor="+$('#FechaDepor').val();
                          datosBoleta+="&Vproveniente="+$('#Vproveniente').val().toUpperCase();
                          datosBoleta+="&fun=2";
                          console.log(datosBoleta);
                          var url = "certificacion/funcion_certificacion.php"; 
                          $.ajax({
                              type: "POST",
                              url: url,
                              data: datosBoleta,
                              success: function(data)
                              {
                                console.log(data);
                                var jorden = JSON.parse(data);
                                switch(jorden.case){
                                  case 0:
                                    window.location.reload();
                                  break;
                                  case 1:
                                    $("#respOrdenBoleta").html(jorden.message);
                                    $('#Norden').val(""); 
                                    $('#Norden').focus(); 
                                  break;
                                  case 2:
                                    $("#respOrdenBoleta").html(jorden.message);
                                    $("html, body").animate({ scrollTop: 400 }, "slow");
                                    $('#Nboleta').focus();
                                  break;
                                  case 3:
                                    $("#respOrdenBoleta").html("");
                                    $("#ordenBoleta").html(jorden.message);
                                    $("html, body").animate({ scrollTop: 200 }, "slow");
                                    $("#bread2").addClass("btn-info");
                                    $("#bread3").addClass("btn-info");
                                  break;
                                  default:
                                }
                              }
                            });
                        }
                      // }--
                    }
                    else if($("#checkNoDeportado").prop("checked")){
                      datosBoleta+="&fun=2";
                      console.log(datosBoleta);

                      var url = "certificacion/funcion_certificacion.php"; 
                      $.ajax({
                          type: "POST",
                          url: url,
                          data: datosBoleta,
                          success: function(data)
                          {
                            console.log(data);
                            var jorden = JSON.parse(data);
                            switch(jorden.case){
                              case 0:
                                window.location.reload();
                              break;
                              case 1:
                                $("#respOrdenBoleta").html(jorden.message);
                                $('#Norden').val(""); 
                                $('#Norden').focus(); 
                              break;
                              case 2:
                                $("#respOrdenBoleta").html(jorden.message);
                                $("html, body").animate({ scrollTop: 400 }, "slow");
                                $('#Nboleta').focus(); 
                              break;
                              case 3:
                                $("#respOrdenBoleta").html("");
                                $("#ordenBoleta").html(jorden.message);
                                $("html, body").animate({ scrollTop: 200 }, "slow");
                                $("#bread2").addClass("btn-info");
                                $("#bread3").addClass("btn-info");
                              break;
                              default:
                            }
                          }
                        });

                    }
                    
                  }

                }else{

                  if(!$("#checkSiDeportado").prop("checked")&&!$("#checkNoDeportado").prop("checked")){
                  $('#checkDep').focus();
                  $('#checkDep').tooltip('show');
                }else{

                  if($("#checkSiDeportado").prop("checked")){
                    // if($('#FechaDepor').val()==""){
                    //   $('#FechaDepor').focus();
                    //   $('#FechaDepor').tooltip('show');
                    // }else{
                      if($('#Vproveniente').val()==""){
                        $('#Vproveniente').focus();
                        $('#Vproveniente').tooltip('show');
                      }else{
                        datosBoleta+="&FechaDepor="+$('#FechaDepor').val();
                        datosBoleta+="&Vproveniente="+$('#Vproveniente').val().toUpperCase();
                        datosBoleta+="&fun=2";
                        console.log(datosBoleta);
                        var url = "certificacion/funcion_certificacion.php"; 
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: datosBoleta,
                            success: function(data)
                            {
                              console.log(data);
                              var jorden = JSON.parse(data);
                              switch(jorden.case){
                                case 0:
                                  window.location.reload();
                                break;
                                case 1:
                                  $("#respOrdenBoleta").html(jorden.message);
                                  $('#Norden').val(""); 
                                  $('#Norden').focus(); 
                                break;
                                case 2:
                                  $("#respOrdenBoleta").html(jorden.message);
                                  $("html, body").animate({ scrollTop: 350 }, "slow");
                                  $('#Nboleta').focus(); 
                                break;
                                case 3:
                                  $("#respOrdenBoleta").html("");
                                  $("#ordenBoleta").html(jorden.message);
                                  $("html, body").animate({ scrollTop: 200 }, "slow");
                                  $("#bread2").addClass("btn-info");
                                  $("#bread3").addClass("btn-info");
                                break;
                                default:
                              }
                            }
                          });
                      }
                    // }--
                  }
                  else if($("#checkNoDeportado").prop("checked")){
                    datosBoleta+="&fun=2";
                    console.log(datosBoleta);

                    var url = "certificacion/funcion_certificacion.php"; 
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: datosBoleta,
                            success: function(data)
                            {
                              console.log(data);
                              var jorden = JSON.parse(data);
                              switch(jorden.case){
                                case 0:
                                  window.location.reload();
                                break;
                                case 1:
                                  $("#respOrdenBoleta").html(jorden.message);
                                  $('#Norden').val(""); 
                                  $('#Norden').focus(); 
                                break;
                                case 2:
                                  $("#respOrdenBoleta").html(jorden.message);
                                  $("html, body").animate({ scrollTop: 350 }, "slow");
                                  $('#Nboleta').focus(); 
                                break;
                                case 3:
                                  $("#respOrdenBoleta").html("");
                                  $("#ordenBoleta").html(jorden.message);
                                  $("html, body").animate({ scrollTop: 200 }, "slow");
                                  $("#bread2").addClass("btn-info");
                                  $("#bread3").addClass("btn-info");
                                break;
                                default:
                              }
                            }
                        });

                    }
                    
                  }

                }
              }
            }
          }
        }
      }
    }
  }
}

function imprimirCertificacion() {
  
  var datosCertificacion="&Norden="+$('#nOrden').text();
  datosCertificacion+="&Nboleta="+$('#tb-Nboleta').text()+"&NfolioEntrada="+$('#tb-NFolioEntrada').text();
  if($('#idConceptoP').text()==9){
    datosCertificacion+="&Infrontera="+$('#tb-Infrontera').text();
    datosCertificacion+="&Fingreso="+$('#tb-Fingreso').text();
    datosCertificacion+="&Sdias="+$('#tb-Sdias').text();
  }else{
    datosCertificacion+="&Nnegativa="+$('#tb-Nnegativa').text();
    datosCertificacion+="&txtsolicitud="+$('#tb-txtsolicitud').text();
    datosCertificacion+="&Nfolio="+$('#tb-Nfolio').text();
    datosCertificacion+="&FechaDepor="+$('#tb-FechaDepor').text();
    datosCertificacion+="&Vproveniente="+$('#tb-Vproveniente').text();
  }
  datosCertificacion+="&fun=3";
  console.log(datosCertificacion);
  var url = "certificacion/funcion_certificacion.php"; 
  $.ajax({
      type: "POST",
      url: url,
      data: datosCertificacion,
      success: function(data)
      {
        console.log(data);
        var jorden = JSON.parse(data);
        switch(jorden.case){
          case 0:
            window.location.reload();
          break;
          case 1:
            // Impresion Deportado
            printDeportado(jorden.message);
          break;
          case 2:
            // Impresion Particular
            printParticular(jorden.message);
          break;
          case 3:
            $("#respOrdenBoleta").html("");
            $("#ordenBoleta").html(jorden.message);
            $("#bread2").addClass("btn-info");
            $("#bread3").addClass("btn-info");
          break;
          case 4:
            // Impresion de Negativa y Certificacion
            printNegativa(jorden.tipoNegativa, jorden.negativaDatos, jorden.message, jorden.tipoCertificacion);
          break;
          case 5:
            // Impresion de certificacion estatus
            printEstatus(jorden.message);
          break;
          default:

        }

      }
    });
}
function printNegativa (tipoNegativa, datosNegativa, datosCert, tipoCert) {
  var dat = datosNegativa;

  console.log("Tipo Negativa===="+tipoNegativa);
  console.log("Datos negrati======="+datosNegativa);
  console.log("Mensaa========"+datosCert);
  
  if (tipoNegativa==1) {
    var dir = "certificacion/plantilla/Pnegativa.php";
  }
  else if (tipoNegativa==2) {
    var dir = "certificacion/plantilla/PnegativaComun.php";
  }
  else if (tipoNegativa==3) {
    var dir = "certificacion/plantilla/PnegativaSolicitud.php";
  }
  console.log("Dat======"+dir);
  $.ajax({
    type: "POST",
    url: dir,
    data: dat,
    success: function(data)
    {
      
      $("#bread3").addClass("btn-info");
      $("#bread4").addClass("btn-info");
      $("#ordenBoleta").html(data);
      $("#printArea").printArea({
        mode:"iframe",
        popHt: 500,
        popWd: 400,
        popX: 500,
        popY: 600,
        popTitle: "Impresion de Negativa",
        popClose: true
        });
      
      setTimeout(function() {
          $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>Negativa Impresa</strong></h3>", {
            type: 'success',
            width: '500',
            offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
            delay: 3000,
            stackup_spacing: 10
          });

          if (tipoCert==0) {
            printParticular(datosCert);
          }else if(tipoCert==1){
            printDeportado(datosCert);
          }
      }, 3000);
    }
  });  

}


function printDeportado(datos) {
  // console.log("printDeportado");
  var dat = datos;
  $.ajax({
    type: "POST",
    url: "certificacion/plantilla/pln-deportado.php",
    data: dat,
    success: function(data)
    {
      
      $("#bread3").addClass("btn-info");
      $("#bread4").addClass("btn-info");
      $("#ordenBoleta").html(data);
      $("#printArea").printArea({
        mode:"iframe",
        popHt: 500,
        popWd: 400,
        popX: 500,
        popY: 600,
        popTitle: "Impresion de Certificacion",
        popClose: true
        });
      
      setTimeout(function() {
          $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>CERTIFICACIÓN</strong> Generada e Impresa!</h3>", {
            type: 'success',
            width: '500',
            offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
            delay: 4000,
            stackup_spacing: 10
          });
        setTimeout ("redirection('?ac=certificacion')", 3000);
      }, 3000);
      setTimeout(function() {
        window.location = '?ac=certificacion';
      },3000)
    }
  });  
}
function printParticular(datos) {
  //console.log("printParticular");
  var dat = datos;
  $.ajax({
    type: "POST",
    url: "certificacion/plantilla/pln-particular.php",
    data: dat,
    success: function(data)
    {
      
      $("#bread3").addClass("btn-info");
      $("#bread4").addClass("btn-info");
      $("#ordenBoleta").html(data);
      $("#printArea").printArea({
        mode:"iframe",
        popHt: 500,
        popWd: 400,
        popX: 500,
        popY: 600,
        popTitle: "Impresion de Certificacion",
        popClose: true
        });
      
      setTimeout(function() {
          $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>CERTIFICACIÓN</strong> Generada e Impresa!</h3>", {
            type: 'success',
            width: '500',
            offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
            delay: 4000,
            stackup_spacing: 10
          });
        setTimeout ("redirection('?ac=certificacion')", 3000);
      }, 3000);
      setTimeout(function() {
        window.location = '?ac=certificacion';
      },3000)
    }
  });  
}
function printEstatus(datos) {
  //console.log("printParticular");
  var dat = datos;
  $.ajax({
    type: "POST",
    url: "certificacion/plantilla/pln-estatus.php",
    data: dat,
    success: function(data)
    {
      
      $("#bread3").addClass("btn-info");
      $("#bread4").addClass("btn-info");
      $("#ordenBoleta").html(data);
      $("#printArea").printArea({
        mode:"iframe",
        popHt: 500,
        popWd: 400,
        popX: 500,
        popY: 600,
        popTitle: "Impresion de Certificacion",
        popClose: true
        });
      
      setTimeout(function() {
          $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>CERTIFICACIÓN</strong> Generada e Impresa!</h3>", {
            type: 'success',
            width: '500',
            offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
            delay: 4000,
            stackup_spacing: 10
          });
        setTimeout ("redirection('?ac=certificacion')", 3000);
      }, 3000);
      setTimeout(function() {
        window.location = '?ac=certificacion';
      },3000)
    }
  });  
}
function redirection(dir){  
  window.location=dir;
}
</script>







