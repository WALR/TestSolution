<?php 
  // require_once('../../res/funciones.php');
  // sessionExp();

 ?>
<br>
	<p>
  		<h3 class="text-center">
  			<span class="label label-danger">Modificacion de Certificación OFICIAL</span>
  		</h3>
  	</p>	
<div id="modifica-oficial"> 
  <br>
	<div class="col-xl-12 col-sm-12 col-md-12 col-md-offset-1">
	    <form method="post" id="FormOrdenPago" >
	        <div class="form-group col-xl-6 col-sm-6 col-md-6 col-md-offset-2">
	          <label for="Nfolio" class="Colet">Ingrese Oficio de Entrada: <span class="sm">(Campo Obligatorio)</span></label>
	          <input type="text" class="form-control" id="NfolioMod" data-toggle="tooltip" data-placement="right" title="Ingresar Folio de entrada de la certificacion oficial a modificar" data-campo="Nfolio" placeholder="Ej. 20-2015"  autofocus>
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
	           <button type="button" id="btn_modificarOficial"  class="btn btn-primary btn-lg btn-shadow" tabindex=0>
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
<div id="ModalConfirm" class="modal">
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


<!-- Modal Confirmacion Varios -->
<div id="ModalConfirmVarios" class="modal" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><strong>Esta seguro de los datos que modificada?</strong></h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="btnguardarModVarios" type="button" class="btn btn-success">
          <span class="glyphicon glyphicon-floppy-save"></span>
          Guardar
        </button>
      </div>
    </div>
  </div>
</div>


<script>
function cargarData (cant) {	
  $( "body" ).data( "cboAsuntoMod", $('#cboAsuntoMod').val());
  $( "body" ).data( "cboNegativaMod", $('#cboNegativaMod').val());
  $( "body" ).data( "txtsolicitudMod", $('#txtsolicitudMod').val());
  $( "body" ).data( "NfolioMod", $('#NfolioMod').val());
  if (cant==0) {
    $( "body" ).data( "PnombreMod", $('#PnombreMod').val());
    $( "body" ).data( "SnombreMod", $('#SnombreMod').val());
    $( "body" ).data( "PapellidoMod", $('#PapellidoMod').val());
    $( "body" ).data( "SapellidoMod", $('#SapellidoMod').val());
    $( "body" ).data( "CapellidoMod", $('#CapellidoMod').val());

  }else{
    for (var i = 1; i <= cant; i++) {
      $( "body" ).data( "Pnombre"+i, $('#Pnombre'+i).val());
      $( "body" ).data( "Snombre"+i, $('#Snombre'+i).val());
      $( "body" ).data( "Papellido"+i, $('#Papellido'+i).val());
      $( "body" ).data( "Sapellido"+i, $('#Sapellido'+i).val());
      $( "body" ).data( "Capellido"+i, $('#Capellido'+i).val());
    }
  } 
}

function modif(dat) {
	if ($( "body" ).data(dat.id)!=$("#"+dat.id).val().toUpperCase()) {
		$("#"+dat.id).css({"color": "red", "border-color": "red"});

	}else{
		$("#"+dat.id).css({"color": "#555", "border-color": "#CCC"});
	}
}
$("#btn_modificarOficial").click(function(){
  // console.log("click");
  if($('#NfolioMod').val()==""){
    $('#NfolioMod').focus();
    $('#NfolioMod').tooltip('show');
  }else{

    var ModOficial="NfolioEntrada="+$('#NfolioMod').val();
    ModOficial+="&fun=7";
    var url = "certificacion/funcion_certificacion.php"; 
    $.ajax({
      type: "POST",
      url: url,
      data: ModOficial,
      success: function(data)
      {
        console.log(data);
        var jorden = JSON.parse(data);
        switch(jorden.case){
          case 1:
            $("#respMod").html(jorden.message);
            $('#NfolioMod').val(""); 
            $('#NfolioMod').focus(); 
          break;
          case 2:
            // $("#respMod").html(jorden.message);
            // $('#NordenMod').val(""); 
            // $('#NordenMod').focus(); 
          break;
          case 3:
            $("#respMod").html("");
            $("html, body").animate({ scrollTop: 238 }, 1000);
            $("#modifica-oficial").html(jorden.message);
          break;
          default:
        }

      }
    });

  }
 });



var datosModi= "";
function confirmarOficial() {

  var list="";
if (comprobar()) {
    if($('#cboAsuntoMod').val().toUpperCase()!=$("body").data('cboAsuntoMod')){
      list+="<li class='list-group-item'><dt>Asunto:</dt><dd>"+$('#cboAsuntoMod option:selected').text().toUpperCase()+"</dd></li>";
      datosModi+="asunto="+$('#cboAsuntoMod').val().toUpperCase()+"&asuntoANT="+$("body").data('cboAsuntoMod');
    }
    if($('#PnombreMod').val().toUpperCase()!=$("body").data('PnombreMod')){
      list+="<li class='list-group-item'><dt>Primer Nombre:</dt><dd>"+$('#PnombreMod').val().toUpperCase()+"</dd></li>";
      datosModi+="&Pnombre="+$('#PnombreMod').val().toUpperCase()+"&PnombreANT="+$("body").data('PnombreMod');
    }
    if($('#SnombreMod').val().toUpperCase()!=$("body").data('SnombreMod')){
      list+="<li class='list-group-item'><dt>Primer Nombre:</dt><dd>"+$('#SnombreMod').val().toUpperCase()+"</dd></li>";
      datosModi+="&Snombre="+$('#SnombreMod').val().toUpperCase()+"&SnombreANT="+$("body").data('SnombreMod');
    }
    if($('#PapellidoMod').val().toUpperCase()!=$("body").data('PapellidoMod')){
      list+="<li class='list-group-item'><dt>Primer Nombre:</dt><dd>"+$('#PapellidoMod').val().toUpperCase()+"</dd></li>";
      datosModi+="&Papellido="+$('#PapellidoMod').val().toUpperCase()+"&PapellidoANT="+$("body").data('PapellidoMod');
    }
    if($('#SapellidoMod').val().toUpperCase()!=$("body").data('SapellidoMod')){
      list+="<li class='list-group-item'><dt>Primer Nombre:</dt><dd>"+$('#SapellidoMod').val().toUpperCase()+"</dd></li>";
      datosModi+="&Sapellido="+$('#SapellidoMod').val().toUpperCase()+"&SapellidoANT="+$("body").data('SapellidoMod');
    }
    if($('#CapellidoMod').val().toUpperCase()!=$("body").data('CapellidoMod')){
      list+="<li class='list-group-item'><dt>Primer Nombre:</dt><dd>"+$('#CapellidoMod').val().toUpperCase()+"</dd></li>";
      datosModi+="&Capellido="+$('#CapellidoMod').val().toUpperCase()+"&CapellidoANT="+$("body").data('CapellidoMod');
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
    if (list!="") {
  	    // console.log("entro");
        datosModi+="&NfolioEntrada="+$('#NfolioEntradaMod').text();
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
      if ($("#NfolioMod").val()=="") {
        $('#NfolioMod').focus();
        $('#NfolioMod').tooltip('show');
        return false;
      }else{
        if ($('#txtsolicitudMod').is (':visible')&&$("#txtsolicitudMod").val()=="") {
          $('#txtsolicitudMod').focus();
          $('#txtsolicitudMod').tooltip('show');
          return false;
        }else{
        return true;
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
  datosModi+="&fun=8&varios=0";
  console.log(datosModi);
  $('.progress-bar').css('width','50%');
  var url = "certificacion/funcion_certificacion.php"; 
    $.ajax({
          type: "POST",
          url: url,
          data: datosModi,
          success: function(data)
          {
            // console.log(data);
            var jorden = JSON.parse(data);
            switch(jorden.case){
              case 1:
                // console.log(jorden.message);
                // Impresion sin negativa
                $('.progress-bar').css('width','100%');
                $("#ModalConfirm").modal('hide');
                printOficial(jorden.message);
              break;
              case 2:
                // Impresion con negativa
                $('.progress-bar').css('width','100%');
                $("#ModalConfirm").modal('hide');
                printNegativa(jorden.tipoNegativa, jorden.negativaDatos, jorden.message);
              break;
              case 3:
                // $("#respOrdenBoleta").html("");
              break;
              default:

            }

          },
          error: function() {
            // Error 
          }

    });
    return false; 
});

function printNegativa (tipoNegativa, datosNegativa, datosCert) {
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
        
        $("#modifica-oficial").html(data);
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

            printOficial(datosCert);
        }, 3000);
      }
    }); 
}

function printOficial (datos) {

  // console.log("printOficial");
  var dat = datos;
  $.ajax({
    type: "POST",
    url: "certificacion/plantilla/pln-oficial.php",
    data: dat,
    success: function(data)
    {
      
      $("#modifica-oficial").html(data);
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
var jsondata ="";
function confOficialV (argument) {
  var it = true;
  var Mod = false;
  var folio = 0;
  var data={};
  
  $('#tabla >tbody >.cont').each(function () {
    var id=$(this).attr('id');
    var row={};
    $(this).find('td input').each(function(){
      if ($(this).attr('type')!="radio") {
        row[$(this).attr('id')]=$(this).val().toUpperCase();
      }
    });
    
    var nombre = $(this).find("td").eq(1).html();
    nombre = $(nombre).attr('id');
    var apellido = $(this).find("td").eq(3).html();
    apellido = $(apellido).attr('id');

    if ($('#'+nombre).val()=="") {
      $('#'+nombre).tooltip('show');
      it=false;
    }else if($('#'+nombre).val().toUpperCase()!=$("body").data(nombre)){
      Mod=true;
    }
    if ($('#'+apellido).val()=="") {
      $('#'+apellido).tooltip('show');
      it=false;
    }else if($('#'+apellido).val().toUpperCase()!=$("body").data(apellido)){
      Mod=true;
    }
    data[id]=row;  
  });
           
  if (it) {
    if(Mod){    
        data['Asunto']=$('#cboAsuntoMod').val();
        jsondata = "datos=";
        jsondata += JSON.stringify(data);
        jsondata+="&fun=8&varios=1&NfolioEntrada="+$("#NfolioEntradaMod").text();
        $("#ModalConfirmVarios").modal('show');
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
  }else{
    console.log("False");
  }
}
$("#btnguardarModVarios").click(function(){
  $("#ModalConfirmVarios").modal('hide');
  var url = "certificacion/funcion_certificacion.php"; 
  $.ajax({
    type: "POST",
    url: url,
    data: jsondata,
    success: function(data)
    {
      // console.log("Data----"+data);
      var jorden = JSON.parse(data);
      console.log(jorden);
      
      switch(jorden.case){
        case 1:
          console.log("1="+jorden.message) 
        break;
        case 2:
          console.log("2="+jorden.message) 
        break;
        case 3:
          $("#respMod").html(jorden.message);
        break;
        case 4:
          printNegativaOficial(jorden.tipoNegativa, jorden.negativaDatos, jorden.message);
        break;
        case 5:
          tmpModal.showPleaseWait();
          printNegativaVarias(jorden, 0);
          // var tam = Object.keys(jorden).length-2;
          // var tt = tam;
          // tt--;
          // console.log("TT------"+tt);
          // for (var i = 0, len = tam; i < len; i++) {
          //   console.log(i);
          //   console.log("Nombre="+jorden[i].nombre);
          //   if (jorden[i].tipoNegativa!=0) {
          //     var ejec = function (jorden, i) {
          //       return function() {
          //         if (jorden[i].tipoNegativa==3) {
          //           printNegativa(jorden[i].tipoNegativa, "nombre="+jorden[i].nombre+"&fecha="+jorden[i].fecha+"&datosolicitar="+jorden[i].negativaDatos);
          //         }else{
          //           printNegativa(jorden[i].tipoNegativa, "nombre="+jorden[i].nombre+"&fecha="+jorden[i].fecha);

          //         }
          //         console.log("III-------"+i);
          //         if (i==tt) {
          //           console.log("Print Certificacion--"+tt);
          //           setTimeout(cert(jorden), 4000 );
          //         }
          //       }
          //     };

          //     var cert = function (jorden) {
          //       return function() {
          //         printOficialVarios(jorden.dataCertificacion);
          //       }
          //     };

          //     if(i==0){
          //       setTimeout(ejec(jorden, i), 1000);

          //     }else{
          //       setTimeout(ejec(jorden, i), 4000 * i);
                
          //     }
          //   }else{
          //     if (i==tt) {
          //       console.log("Print Certificacion-AAA-"+tt);
          //       setTimeout(cert(jorden), 4000);
          //       // printOficialVarios(jorden.dataCertificacion);
          //     }
          //   }

          // }
        break;
      }
      
    }
  });
});

function printOficialVarios (datos) {

  console.log("printOficial");
  var dat = datos;
  console.log(dat);
  $.ajax({
  type: "POST",
  url: "certificacion/plantilla/pln-oficialV.php",
  data: dat,
  success: function(data)
  {
    

    $("#modifica-oficial").html(data);
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

function printNegativaVarias(jorden, it)
{
  tmpModal.hidePleaseWait();
  var tam = Object.keys(jorden).length-2;
  var tt = tam;
  tt--;
  var i = it; 
  if (jorden[i].tipoNegativa!=0) {
    var dat = "nombre="+jorden[i].nombre+"&fecha="+jorden[i].fecha;
    // $printNegativa = "nombre=".$nombreCompeto."&fecha=".$fechaL;  
    if (jorden[i].tipoNegativa==1) {
      var dir = "certificacion/plantilla/Pnegativa.php";
    }
    else if (jorden[i].tipoNegativa==2) {
      var dir = "certificacion/plantilla/PnegativaComun.php";
    }
    else if (jorden[i].tipoNegativa==3) {
      var dir = "certificacion/plantilla/PnegativaSolicitud.php";
      dat = "nombre="+jorden[i].nombre+"&fecha="+jorden[i].fecha+"&datosolicitar="+jorden[i].negativaDatos;
    }
    // console.log("Dat======"+dir);
      $.ajax({
        type: "POST",
        url: dir,
        data: dat,
        success: function(data)
        {
          $("#modifica-oficial").html(data);
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
              if (i==tt) {
                printOficialVarios(jorden.dataCertificacion);
              }else{
                printNegativaVarias(jorden, i+1);
              }
            }, 3000);        
        }
      });
  }else{
    if (i==tt) {
      printOficialVarios(jorden.dataCertificacion);
    }else{
      printNegativaVarias(jorden, i+1);
    }
  }  

}

// function printNegativa2 (tipoNegativa, datosNegativa, datosCert) {
//   var dat = datosNegativa;
//     if (tipoNegativa==1) {
//       var dir = "certificacion/plantilla/Pnegativa.php";
//     }
//     else if (tipoNegativa==2) {
//       var dir = "certificacion/plantilla/PnegativaComun.php";
//     }
//     else if (tipoNegativa==3) {
//       var dir = "certificacion/plantilla/PnegativaSolicitud.php";
//     }
//     // console.log("Dat======"+dir);
//     $.ajax({
//       type: "POST",
//       url: dir,
//       data: dat,
//       success: function(data)
//       {
        
//         $("#modifica-oficial").html(data);
//         $("#printArea").printArea({
//           mode:"iframe",
//           popHt: 500,
//           popWd: 400,
//           popX: 500,
//           popY: 600,
//           popTitle: "Impresion de Negativa",
//           popClose: true
//           });
        
//         setTimeout(function() {
//             $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>Negativa Impresa</strong></h3>", {
//               type: 'success',
//               width: '500',
//               offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
//               delay: 3000,
//               stackup_spacing: 10
//             });

//             printOficialReim(datosCert);
//         }, 3000);
//       }
//     }); 

// }



function printOficialReim (datos) {

  // console.log("printOficial");
  var dat = datos;
  $.ajax({
    type: "POST",
    url: "certificacion/plantilla/pln-oficial.php",
    data: dat,
    success: function(data)
    {
      
      $("#modifica-oficial").html(data);
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