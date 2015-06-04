<?php 
  // require_once('../../res/funciones.php');
  // sessionExp();

 ?>
<br>
	<p>
  		<h3 class="text-center">
  			<span class="label label-danger">Modificacion de Certificación Particular</span>
  		</h3>
  	</p>	
<div id="modifica-particular"> 
  <br>
	<div class="col-xl-12 col-sm-12 col-md-12 col-md-offset-1">
	    <form method="post" id="FormOrdenPago" >
	        <div class="form-group col-xl-6 col-sm-6 col-md-6 col-md-offset-2">
	          <label for="Norden" class="Colet">Ingrese la Orden de Pago de la certifiación: <span class="sm">(Campo Obligatorio)</span></label>
	          <input type="text" class="form-control" id="NordenMod" data-toggle="tooltip" data-placement="right" title="Ingresar Numero de orden de Pago de la certificacion a modificar" data-campo="Norden" placeholder="Orden de Pago Numero" onkeypress="return checkSoloNum(event)" autofocus>
	        </div>
	        <br>
        	<div class="col-xl-12 col-sm-12 col-md-12">
	         <div class="col-xl-3 col-sm-3 col-md-3">
	          <span class="pull-left">
		          <button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="tipomod()" tabindex=1>
			            <span class="glyphicon glyphicon-chevron-left"> </span>
			            Atras
		          </button>
	          </span>
	         </div>
	         <div class="col-xl-6 col-sm-6 col-md-6 col-md-offset-1">
	           <button type="button" id="btn_modificarParticular"  class="btn btn-primary btn-lg btn-shadow" tabindex=0>
	             <span class="glyphicon glyphicon-pencil"> </span>
	             Modificar
	           </button> 
	         </div>
	        </div>

	     </form>
	</div>
</div>

<div id="respMod" class="col-xl-12 col-sm-12 col-md-12" style="margin-top:3em;">
	
</div>


<!-- Modal de confirmacion -->
<div id="ModalConfirm" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Los datos que <strong>Modificara son correctos?</strong></h4>
      </div>
      <div class="modal-body">
        <ul class='list-group'>
          <dl id="ConfData" class="ConfData dl-horizontal">
          </dl>
        </ul>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="btn_guardarMod" type="button" class="btn btn-success">
          <span class="glyphicon glyphicon-floppy-save"></span>
          Guardar
        </button>
      </div>
    </div>
  </div>
</div>


<script>
function cargarData () {	
	$( "body" ).data( "PnombreMod", $('#PnombreMod').val() );
	$( "body" ).data( "SnombreMod", $('#SnombreMod').val() );
	$( "body" ).data( "PapellidoMod", $('#PapellidoMod').val() );
	$( "body" ).data( "SapellidoMod", $('#SapellidoMod').val() );
	$( "body" ).data( "CapellidoMod", $('#CapellidoMod').val() );
	$( "body" ).data( "cboNacionalidadMod", $('#cboNacionalidadMod').val() );
	$( "body" ).data( "cboTipoDocMod", $('#cboTipoDocMod').val() );
	$( "body" ).data( "NumDocMod", $('#NumDocMod').val() );
	$( "body" ).data( "cboPaisMod", $('#cboPaisMod').val() );
	$( "body" ).data( "LugarExtDocMod", $('#LugarExtDocMod').val() );
	$( "body" ).data( "txtsolicitudMod", $('#txtsolicitudMod').val() );
  $( "body" ).data( "cboNegativaMod", $('#cboNegativaMod').val() );
  $( "body" ).data( "Nboleta", $('#Nboleta').val() );
  $( "body" ).data( "NfolioMod", $('#NfolioMod').val() );
  $( "body" ).data( "VprovenienteMod", $('#VprovenienteMod').val());
  $( "body" ).data( "FechaDeporMod", $('#FechaDeporMod').val());
  $( "body" ).data( "InFronteraMod", $('#InFronteraMod').val());
  $( "body" ).data( "FingresoMod", $('#FingresoMod').val());
  $( "body" ).data( "SdiasMod", $('#SdiasMod').val());

}

function modif(dat) {
	if ($( "body" ).data(dat.id)!=$("#"+dat.id).val().toUpperCase()) {
		$("#"+dat.id).css({"color": "red", "border-color": "red"});

	}else{
		$("#"+dat.id).css({"color": "#555", "border-color": "#CCC"});
	}
}


$("#btn_modificarParticular").click(function(){
  if($('#NordenMod').val()==""){
    $('#NordenMod').focus();
    $('#NordenMod').tooltip('show');
  }else{

    var Mod="NordenMod="+$('#NordenMod').val();
    Mod+="&fun=5";
    var url = "certificacion/funcion_certificacion.php"; 
    $.ajax({
      type: "POST",
      url: url,
      data: Mod,
      success: function(data)
      {
        // console.log(data);
        var jorden = JSON.parse(data);
        switch(jorden.case){
          case 1:
            $("#respMod").html(jorden.message);
            $('#NordenMod').val(""); 
            $('#NordenMod').focus(); 
          break;
          case 2:
            $("#respMod").html(jorden.message);
            $('#NordenMod').val(""); 
            $('#NordenMod').focus(); 
          break;
          case 3:
            $("#respMod").html("");
            $("#modifica-particular").html(jorden.message);
          break;
          default:
        }

      }
    });

  }
 });

var datosModi= "";
function confirmarParticular() {
var list="";
if (comprobar()) {
  if($('#PnombreMod').val().toUpperCase()!=$("body").data('PnombreMod')){
    list+="<li class='list-group-item'><dt>Primer Nombre:</dt><dd>"+$('#PnombreMod').val().toUpperCase()+"</dd></li>";
    datosModi+="Pnombre="+$('#PnombreMod').val().toUpperCase()+"&PnombreANT="+$("body").data('PnombreMod');
  }
  if($('#SnombreMod').val().toUpperCase()!=$("body").data('SnombreMod')){
    list+="<li class='list-group-item'><dt>Segundo Nombre:</dt><dd>"+$('#SnombreMod').val().toUpperCase()+"</dd></li>";
    datosModi+="&Snombre="+$('#SnombreMod').val().toUpperCase()+"&SnombreANT="+$("body").data('SnombreMod');
  }
  if($('#PapellidoMod').val().toUpperCase()!=$("body").data('PapellidoMod')){
    list+="<li class='list-group-item'><dt>Primer Apellido:</dt><dd>"+$('#PapellidoMod').val().toUpperCase()+"</dd></li>";
    datosModi+="&Papellido="+$('#PapellidoMod').val().toUpperCase()+"&PapellidoANT="+$("body").data('PapellidoMod');
  }
  if($('#SapellidoMod').val().toUpperCase()!=$("body").data('SapellidoMod')){
    list+="<li class='list-group-item'><dt>Segundo Apellido:</dt><dd>"+$('#SapellidoMod').val().toUpperCase()+"</dd></li>";
    datosModi+="&Sapellido="+$('#SapellidoMod').val().toUpperCase()+"&SapellidoANT="+$("body").data('SapellidoMod');
  }
  if($('#CapellidoMod').val().toUpperCase()!=$("body").data('CapellidoMod')){
    list+="<li class='list-group-item'><dt>Apellido de Casada:</dt><dd>"+$('#CapellidoMod').val().toUpperCase()+"</dd></li>";
    datosModi+="&Capellido="+$('#CapellidoMod').val().toUpperCase()+"&CapellidoANT="+$("body").data('CapellidoMod');
  }
  if($('#cboNacionalidadMod').val().toUpperCase()!=$("body").data('cboNacionalidadMod')){
    list+="<li class='list-group-item'><dt>Nacionalidad:</dt><dd>"+$('#cboNacionalidadMod option:selected').text().toUpperCase()+"</dd></li>";
    datosModi+="&cboNacionalidad="+$("#cboNacionalidadMod").val()+"&cboNacionalidadANT="+$("body").data('cboNacionalidadMod');
  }
  if($('#cboTipoDocMod').val().toUpperCase()!=$("body").data('cboTipoDocMod')){
    list+="<li class='list-group-item'><dt>Tipo de Documento:</dt><dd>"+$('#cboTipoDocMod option:selected').text().toUpperCase()+"</dd></li>";
        datosModi+="&cboTipoDoc="+$('#cboTipoDocMod').val().toUpperCase()+"&cboTipoDocANT="+$("body").data('cboTipoDocMod');
  }
  if($('#NumDocMod').val().toUpperCase()!=$("body").data('NumDocMod')){
    list+="<li class='list-group-item'><dt>Numero de Documento:</dt><dd>"+$("#NumDocMod").val().toUpperCase()+"</dd></li>";
        datosModi+="&NumDoc="+$("#NumDocMod").val()+"&NumDocANT="+$("body").data('NumDocMod');
  }
  if($('#cboPaisMod').val().toUpperCase()!=$("body").data('cboPaisMod')){
        list+="<li class='list-group-item'><dt>Pais donde se <br>extendio el Documento:</dt><dd style='padding-top: 10px;'>"+$('#cboPaisMod option:selected').text().toUpperCase()+"</dd></li>";
        datosModi+="&cboPais="+$("#cboPaisMod").val()+"&cboPaisANT="+$("body").data('cboPaisMod');
  }
  if($('#LugarExtDocMod').val().toUpperCase()!=$("body").data('LugarExtDocMod')){
        list+="<li class='list-group-item'><dt>Lugar donde se <br>extendio el Documento:</dt><dd style='padding-top: 10px;'>"+$("#LugarExtDocMod").val().toUpperCase()+"</dd></li>";
        datosModi+="&LugarExtDoc="+$("#LugarExtDocMod").val().toUpperCase()+"&LugarExtDocANT="+$("body").data('LugarExtDocMod');
  }
  if($('#NfolioMod').length!=0){  
    if($('#NfolioMod').val().toUpperCase()!=$("body").data('NfolioMod')){
          list+="<li class='list-group-item'><dt>Numero de Folio(s).:</dt><dd>"+$('#NfolioMod').val().toUpperCase()+"</dd></li>";
          datosModi+="&Nfolio="+$('#NfolioMod').val().toUpperCase()+"&NfolioANT="+$("body").data('NfolioMod');
    }
  }
  if($('#cboNegativaMod').length!=0){    
    if($('#cboNegativaMod').val().toUpperCase()!=$("body").data('cboNegativaMod')){
      list+="<li class='list-group-item'><dt>Tipo de Negativa:</dt><dd>"+$('#cboNegativaMod option:selected').text().toUpperCase()+"</dd></li>";
      datosModi+="&cboNegativa="+$('#cboNegativaMod').val()+"&cboNegativaANT="+$("body").data('cboNegativaMod');
    }
  }
  if($('#txtsolicitudMod').length!=0){    
    if($('#txtsolicitudMod').val().toUpperCase()!=$("body").data('txtsolicitudMod')){
      list+="<li class='list-group-item'><dt>Datos a solicitar:</dt><dd>"+$('#txtsolicitudMod').val().toUpperCase()+"</dd></li>";
      datosModi+="&txtsolicitud="+$('#txtsolicitudMod').val().toUpperCase()+"&txtsolicitudANT="+$("body").data('txtsolicitudMod');
    }
  }
  if($('#FechaDeporMod').length!=0){  
    if($('#FechaDeporMod').val().toUpperCase()!=$("body").data('FechaDeporMod')){
        list+="<li class='list-group-item'><dt>Fecha Deportado:</dt><dd>"+$('#FechaDeporMod').val().toUpperCase()+"</dd></li>";
        datosModi+="&FechaDepor="+$('#FechaDeporMod').val().toUpperCase()+"&FechaDeporANT="+$("body").data('FechaDeporMod');
    }
  }
  if($('#VprovenienteMod').length!=0){  
    if($('#VprovenienteMod').val().toUpperCase()!=$("body").data('VprovenienteMod')){
          list+="<li class='list-group-item'><dt>Vuelo Proveniente:</dt><dd>"+$('#VprovenienteMod').val().toUpperCase()+"</dd></li>";
          datosModi+="&Vproveniente="+$('#VprovenienteMod').val().toUpperCase()+"&VprovenienteANT="+$("body").data('VprovenienteMod');
    }
  }
  if($('#InFronteraMod').length!=0){  
    if($('#InFronteraMod').val().toUpperCase()!=$("body").data('InFronteraMod')){
          list+="<li class='list-group-item'><dt>Ingreso por la Frontera:</dt><dd>"+$('#InFronteraMod').val().toUpperCase()+"</dd></li>";
          datosModi+="&InFrontera="+$('#InFronteraMod').val().toUpperCase()+"&InFronteraANT="+$("body").data('InFronteraMod');
    }
  } 
  if($('#FingresoMod').length!=0){  
    if($('#FingresoMod').val().toUpperCase()!=$("body").data('FingresoMod')){
          list+="<li class='list-group-item'><dt>Fecha:</dt><dd>"+$('#FingresoMod').val().toUpperCase()+"</dd></li>";
          datosModi+="&Fingreso="+$('#FingresoMod').val().toUpperCase()+"&FingresoANT="+$("body").data('FingresoMod');
    }
  }     
  if($('#SdiasMod').length!=0){  
    if($('#SdiasMod').val().toUpperCase()!=$("body").data('SdiasMod')){
          list+="<li class='list-group-item'><dt>Dias para salir:</dt><dd>"+$('#SdiasMod').val().toUpperCase()+"</dd></li>";
          datosModi+="&Sdias="+$('#SdiasMod').val().toUpperCase()+"&SdiasANT="+$("body").data('SdiasMod');
    }
  }      
  if (list!="") {
	    // console.log("entro");
      datosModi+="&Norden="+$('#nOrden').text();
      $( ".ConfData" ).html(list);
      $("#ModalConfirm").modal('show');
  }else{
    $.bootstrapGrowl("<h4 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>No ha realizado ningún cambio.</strong></h4>", 
      {
        type: 'warning',
        width: '500',
        offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
        delay: 4000,
        stackup_spacing: 10
      });
  }            
}
}

function comprobar() {
  if($('#PnombreMod').val()==""){
    $('#PnombreMod').focus();
    $('#PnombreMod').tooltip('show');
    return false;
  }else{
    if ($('#PapellidoMod').val()=="") {
        $('#PapellidoMod').focus();
        $('#PapellidoMod').tooltip('show');
        return false;
    }else{
      if ($("#cboNacionalidadMod").val()==0) {
        $('#cboNacionalidadMod').focus();
        $('#cboNacionalidadMod').tooltip('show');
        return false;
      }else{
        if ($("#cboTipoDocMod").val()==0) {
          $('#cboTipoDocMod').focus();
          $('#cboTipoDocMod').tooltip('show');
          return false;
        }else{
          if ($("#NumDocMod").val()=="") {
            $('#NumDocMod').focus();
            $('#NumDocMod').tooltip('show');
            return false;
          }else{
            if ($("#cboPaisMod").val()==0) {
              $('#cboPaisMod').focus();
              $('#cboPaisMod').tooltip('show');
              return false;
            }else{
              if ($("#LugarExtDocMod").val()=="") {
                $('#LugarExtDocMod').focus();
                $('#LugarExtDocMod').tooltip('show');
                return false;
              }else{
                if ($('#txtsolicitudMod').is (':visible')&&$("#txtsolicitudMod").val()=="") {
                  $('#txtsolicitudMod').focus();
                  $('#txtsolicitudMod').tooltip('show');
                  return false;
                }else{                
                  if ($("#VprovenienteMod").val()=="") {
                    $('#VprovenienteMod').focus();
                    $('#VprovenienteMod').tooltip('show');
                    return false;
                  }else{
                    if ($("#NfolioMod").val()=="") {
                      $('#NfolioMod').focus();
                      $('#NfolioMod').tooltip('show');
                      return false;
                    }else{
                      if ($("#InFronteraMod").val()=="") {
                        $('#InFronteraMod').focus();
                        $('#InFronteraMod').tooltip('show');
                        return false;
                      }else{
                        if ($("#FingresoMod").val()=="") {
                          $('#FingresoMod').focus();
                          $('#FingresoMod').tooltip('show');
                          return false;
                        }else{
                          if ($("#SdiasMod").val()=="") {
                            $('#SdiasMod').focus();
                            $('#SdiasMod').tooltip('show');
                            return false;
                          }else{
                            return true;
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
    }
  }
}


$("#btn_guardarMod").click(function () {
  //alert("Guardar");
   var bar = "<div class='progress'><div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='45' aria-valuemin='0' aria-valuemax='100' style='width: 1%'></div></div>";
  $( ".modal-header" ).html("");
  $( ".ConfData" ).html(bar);
  $( ".modal-footer" ).html("");
  datosModi+="&fun=6";
  console.log(datosModi);
  $('.progress-bar').css('width','50%');
  $("#ModalConfirm").modal('hide');
  var url = "certificacion/funcion_certificacion.php"; 
    $.ajax({
      type: "POST",
      url: url,
      data: datosModi,
      success: function(data)
      {
        console.log(data);
        var jorden = JSON.parse(data);
        switch(jorden.case){
          case 1:
            //console.log(jorden.message);
            $('.progress-bar').css('width','100%');
            $("#ModalConfirm").modal('hide');
            printDeportadoMod(jorden.message);
          break;
          case 2:
            // console.log(jorden.message);
            $('.progress-bar').css('width','100%');
            $("#ModalConfirm").modal('hide');
            printParticularMod(jorden.message);
          break;
          case 3:
            $('.progress-bar').css('width','100%');
            $("#ModalConfirm").modal('hide');
            $("#respMod").html(jorden.message);
          break;
          case 5:
          // Impresion de Negativa y Certificacion
           printNegativa(jorden.tipoNegativa, jorden.negativaDatos, jorden.message, jorden.tipoCertificacion);
          break;
          case 6:
            // Impresion de certificacion estatus
            $("html, body").animate({ scrollTop: 0 }, "slow");
            printEstatus(jorden.message);
          break;

        }

      },
      error: function() {
        // Error 
      }

    });
    return false; 


});
function printEstatus(datos) {
  //console.log("printParticular");
  var dat = datos;
  $.ajax({
    type: "POST",
    url: "certificacion/plantilla/pln-estatus.php",
    data: dat,
    success: function(data)
    {
      

      $("#modifica-particular").html(data);
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
          $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>CERTIFICACIÓN</strong> modificada y reimpresa!</h3>", {
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

function printNegativa (tipoNegativa, datosNegativa, datosCert, tipoCert) {
  var dat = datosNegativa;
  
  if (tipoNegativa==1) {
    var dir = "certificacion/plantilla/Pnegativa.php";
  }
  else if (tipoNegativa==2) {
    var dir = "certificacion/plantilla/PnegativaComun.php";
  }
  else if (tipoNegativa==3) {
    var dir = "certificacion/plantilla/PnegativaSolicitud.php";
  }
  // console.log("Dat======"+dir);
  $.ajax({
    type: "POST",
    url: dir,
    data: dat,
    success: function(data)
    {
      
      // console.log(data);
      $("#modifica-particular").html(data);
      
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
            delay: 4000,
            stackup_spacing: 10
          });

          if (tipoCert==0) {
            printParticularMod(datosCert);
          }else if(tipoCert==1){
            printDeportadoMod(datosCert);
          }
      }, 4000);
    }
  });  

}

function printDeportadoMod(datos) {
  // console.log("printDeportado");
  var dat = datos;
  $.ajax({
    type: "POST",
    url: "certificacion/plantilla/pln-deportado.php",
    data: dat,
    success: function(data)
    {
      // console.log(data);
      $("#modifica-particular").html(data);
      $("#printArea").printArea();
      
      setTimeout(function() {
          $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>CERTIFICACIÓN</strong> Modificada e Impresa!</h3>", {
            type: 'success',
            width: '500',
            offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
            delay: 4000,
            stackup_spacing: 10
          });
        tipomod();
      }, 3000);
    }
  });  
}

function printParticularMod(datos) {
  // console.log("printDeportado");
  var dat = datos;
  $.ajax({
    type: "POST",
    url: "certificacion/plantilla/pln-particular.php",
    data: dat,
    success: function(data)
    {
      // console.log(data);
      $("#modifica-particular").html(data);
      $("#printArea").printArea();
      
      setTimeout(function() {
          $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>CERTIFICACIÓN</strong> Modificada e Impresa!</h3>", {
            type: 'success',
            width: '500',
            offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
            delay: 4000,
            stackup_spacing: 10
          });
        tipomod();
      }, 3000);
    }
  });  
}

</script>