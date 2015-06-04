<?php 
  // require_once('../../res/funciones.php');
  // sessionExp();

 ?>
<br>
	<p>
  		<h3 class="text-center Colet">
  			Reimpresion de Certificación <span class="label label-info">Particular</span>
  		</h3>
  	</p>	
<div id="reimprimir-particular"> 
  <br>
	<div class="col-xl-12 col-sm-12 col-md-12 col-md-offset-1">
	    <form method="post" id="FormOrdenPago" >
	        <div class="form-group col-xl-6 col-sm-6 col-md-6 col-md-offset-2">
	          <label for="Norden" class="Colet">Orden de Pago de la certifiación: <span class="sm">(Campo Obligatorio)</span></label>
	          <input type="text" class="form-control" id="NordenReim" data-toggle="tooltip" data-placement="right" title="Ingresar Numero de orden de Pago de la certificacion a reimprimir" data-campo="Norden" placeholder="Orden de Pago Numero" onkeypress="return checkSoloNum(event)" autofocus>
	        </div>
	        <br>
        	<div class="col-xl-12 col-sm-12 col-md-12">
	         <div class="col-xl-3 col-sm-3 col-md-3">
	          <span class="pull-left">
		          <button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="tiporeimp()" tabindex=1>
			            <span class="glyphicon glyphicon-chevron-left"> </span>
			            Atras
		          </button>
	          </span>
	         </div>
	         <div class="col-xl-6 col-sm-6 col-md-6 col-md-offset-1">
	           <button type="button" id="btn_reimprimirParticular"  class="btn btn-primary btn-lg btn-shadow" tabindex=0>
	             <span class="glyphicon glyphicon-print"> </span>
	             Reimprimir
	           </button> 
	         </div>
	        </div>
	     </form>
	</div>
</div>

<div id="respReim" class="col-xl-12 col-sm-12 col-md-12" style="margin-top:3em;">
	
</div>


<script>
$("#btn_reimprimirParticular").click(function(){
  // console.log("click");
  if($('#NordenReim').val()==""){
    $('#NordenReim').focus();
    $('#NordenReim').tooltip('show');
  }else{

    var Mod="NordenReim="+$('#NordenReim').val();
    Mod+="&fun=9";
    var url = "certificacion/funcion_certificacion.php"; 
    $.ajax({
      type: "POST",
      url: url,
      data: Mod,
      success: function(data)
      {
        console.log(data);
        var jorden = JSON.parse(data);
        switch(jorden.case){
          case 1:
            $("#respReim").html(jorden.message);
            $('#NordenReim').val(""); 
            $('#NordenReim').focus(); 
          break;
          case 2:
            $("#respReim").html(jorden.message);
            $('#NordenReim').val(""); 
            $('#NordenReim').focus(); 
          break;
          case 3:
            $("#respReim").html("");
            $("#reimprimir-particular").html(jorden.message);
            $("html, body").animate({ scrollTop: 200 }, "slow");
          break;
          default:
        }

      }
    });

  }
 });


function reimprimir_datos() {
  if($('#motivoReimpresion').val()==""){
    $('#motivoReimpresion').focus();
    $('#motivoReimpresion').tooltip('show');
  }else{
  	var reimparticular="motivo="+$('#motivoReimpresion').val().toUpperCase()+"&Norden="+$('#nOrden').text();
    if ($('#idConceptoReim').text()==9) {
      reimparticular+="&idConcepto="+$('#idConceptoReim').text()
    }
    reimparticular+="&fun=10";
    if ($('#printNegativa').is(":checked"))
    {
      reimparticular+="&ReimNeg=1";
    }
    // console.log(reimparticular);
    var url = "certificacion/funcion_certificacion.php"; 
    $.ajax({
      type: "POST",
      url: url,
      data: reimparticular,
      success: function(data)
      {
        // console.log(data);
        var jorden = JSON.parse(data);
        switch(jorden.case){
          case 1:
            $("html, body").animate({ scrollTop: 0 }, "slow");
          	printParticularReim(jorden.message)
          break;
          case 2:
            $("html, body").animate({ scrollTop: 0 }, "slow");
            printDeportadoReim(jorden.message);
          break;
          case 3:
            $("#respReim").html("");
            $("#reimprimir-particular").html(jorden.message);
          break;
          case 4:
            $("#respReim").html("");
            $("#reimprimir-particular").html(jorden.message);
          case 5:
            $("html, body").animate({ scrollTop: 0 }, "slow");
            printNegativa(jorden.printN,jorden.tipoNegativa, jorden.negativaDatos, jorden.message, jorden.tipoCertificacion);
          break;
          case 6:
            // Impresion de certificacion estatus
            $("html, body").animate({ scrollTop: 0 }, "slow");
            printEstatus(jorden.message);
          break;
        }

      }
    });

  }
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
      
      $("#reimprimir-particular").html(data);
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
          $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>CERTIFICACIÓN</strong> reimpresa!</h3>", {
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

function printNegativa (reprintNeg, tipoNegativa, datosNegativa, datosCert, tipoCert) {
  var dat = datosNegativa;
  // console.log("Tipo Negativa===="+tipoNegativa);
  // console.log("Datos negrati======="+datosNegativa);
  // console.log("Mensaa========"+datosCert);
  // console.log("Print negativa========"+reprintNeg);
  if (!reprintNeg) {
    if (tipoCert==0) {
      printParticularReim(datosCert);
    }else if(tipoCert==1){
      printDeportadoReim(datosCert);
    }

  }else{

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
        
        $("#reimprimir-particular").html(data);
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
              printParticularReim(datosCert);
            }else if(tipoCert==1){
              printDeportadoReim(datosCert);
            }
        }, 3000);
      }
    }); 
  } 

}

function printDeportadoReim(datos) {
  // console.log("printDeportado");
  var dat = datos;
  $.ajax({
    type: "POST",
    url: "certificacion/plantilla/pln-deportado.php",
    data: dat,
    success: function(data)
    {
      $("#reimprimir-particular").html(data);
      $("#printArea").printArea();
      
      setTimeout(function() {
          $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>CERTIFICACIÓN</strong> reimpresa!</h3>", {
            type: 'success',
            width: '500',
            offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
            delay: 4000,
            stackup_spacing: 10
          });
        tiporeimp();
      }, 3000);
    }
  });  
}

function printParticularReim(datos) {
  var dat = datos;
  $.ajax({
    type: "POST",
    url: "certificacion/plantilla/pln-particular.php",
    data: dat,
    success: function(data)
    {
      $("#reimprimir-particular").html(data);
      $("#printArea").printArea();
      
      setTimeout(function() {
          $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>CERTIFICACIÓN</strong> reimpresa!</h3>", {
            type: 'success',
            width: '500',
            offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
            delay: 4000,
            stackup_spacing: 10
          });
        tiporeimp();
      }, 3000);
    }
  });  
}
</script>