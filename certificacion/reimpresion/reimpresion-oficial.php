<?php 
  // require_once('../../res/funciones.php');
  // sessionExp();

 ?>
<br>
	<p>
  		<h3 class="text-center Colet">
  			Reimpresion de Certificación <span class="label label-info">OFICIAL</span>
  		</h3>
  	</p>	
<div id="reimprimir-oficial"> 
  <br>
	<div class="col-xl-12 col-sm-12 col-md-12 col-md-offset-1">
	    <form method="post" id="FormOrdenPago" >
	        <div class="form-group col-xl-6 col-sm-6 col-md-6 col-md-offset-2">
	          <label for="NfolioEntrada" class="Colet">Folio de Entrada: <span class="sm">(Campo Obligatorio)</span></label>
	          <input type="text" class="form-control" id="NfolioEntradaReim" data-toggle="tooltip" data-placement="right" title="Ingresar Numero Folio de Entrada" data-campo="NfolioEntrada" placeholder="Ej. 10-2015" autofocus>
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
	           <button type="button" id="btn_reimprimirOficial"  class="btn btn-primary btn-lg btn-shadow" tabindex=0>
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
$("#btn_reimprimirOficial").click(function(){
  // console.log("click");
  if($('#NfolioEntradaReim').val()==""){
    $('#NfolioEntradaReim').focus();
    $('#NfolioEntradaReim').tooltip('show');
  }else{

    var Mod="NfolioEntrada="+$('#NfolioEntradaReim').val();
    Mod+="&fun=11";
    // console.log(Mod);
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
            $('#NfolioEntrada').val(""); 
            $('#NfolioEntrada').focus(); 
          break;
          case 2:
            $("#respReim").html(jorden.message);
            $('#NfolioEntrada').val(""); 
            $('#NfolioEntrada').focus(); 
          break;
          case 3:
            $("#respReim").html("");
            $("html, body").animate({ scrollTop: 237 }, 1000);
            $("#reimprimir-oficial").html(jorden.message);
          break;
          default:
        }

      }
    });

  }
 });


function reimprimir_oficial() {
  if($('#motivoReimpresion').val()==""){
    $('#motivoReimpresion').focus();
    $('#motivoReimpresion').tooltip('show');
  }else{
  	var reimoficial="motivo="+$('#motivoReimpresion').val().toUpperCase()+"&NfolioEntrada="+$('#NfolioEntradaReim').text();
    reimoficial+="&fun=12";
    if ($('#printNegativa').is(":checked"))
    {
      reimoficial+="&ReimNeg=1";
    }
    console.log(reimoficial);
    var url = "certificacion/funcion_certificacion.php"; 
    $.ajax({
      type: "POST",
      url: url,
      data: reimoficial,
      success: function(data)
      {
        // console.log(data);
        var jorden = JSON.parse(data);
        switch(jorden.case){
          case 1:
          	printOficialReim(jorden.message);
          break;
          case 2:
          	$("#respReim").html(jorden.message);
          break;
          case 3:
            $("#respReim").html("");
            $("#reimprimir-particular").html(jorden.message);
          break;
          case 4:
            printNegativa(jorden.printN,jorden.tipoNegativa, jorden.negativaDatos, jorden.message);
          break;
          case 5:
            tmpModal.showPleaseWait();
            if (!jorden.printN) {
              printOficialVarios(jorden.dataCertificacion);
            }else{
              printNegativaVarias(jorden, 0);
            }
            // if (!jorden.printN) {
            //   printOficialVarios(jorden.dataCertificacion);
            // }else{
            //     console.log(jorden);
            //     tmpModal.showPleaseWait();
            //     var tam = Object.keys(jorden).length-3;
            //     var tt = tam;
            //     tt--;
            //     console.log(tt);
            //     for (var i = 0, len = tam; i < len; i++) {
            //       console.log("dentro="+i);
            //       console.log("Nombre="+jorden[i].nombre);
            //       if (jorden[i].tipoNegativa!=0) {
            //         var ejec = function (jorden, i) {
            //           return function() {
            //             if (jorden[i].tipoNegativa==3) {
            //               printNegativaVarias(jorden[i].tipoNegativa, "nombre="+jorden[i].nombre+"&fecha="+jorden[i].fecha+"&datosolicitar="+jorden[i].negativaDatos);
            //             }else{
            //               printNegativaVarias(jorden[i].tipoNegativa, "nombre="+jorden[i].nombre+"&fecha="+jorden[i].fecha);
            //             }
            //             console.log(i);
            //             if (i==tt) {
            //               console.log("Print Certificacion--"+tt);
            //               setTimeout(cert(jorden), 6000 * tt);
            //             }
            //           }
            //         };

            //         var cert = function (jorden) {
            //           return function() {
            //             printOficialVarios(jorden.dataCertificacion);
            //           }
            //         };

            //         if(i==0){
            //           setTimeout(ejec(jorden, i), 1000);
            //         }else{
            //           setTimeout(ejec(jorden, i), 4000 * i);
                      
            //         }
            //       }else{
            //         if (i==tt) {
            //           console.log("Print Certificacion--"+tt);
            //           setTimeout(cert(jorden), 6000 * tt);
            //         }
            //       }

            //     }
            // }
          break;
        }

      }
    });

  }
}

function printOficialVarios (datos) {
  tmpModal.hidePleaseWait();
  console.log("printOficial");
  var dat = datos;
  console.log(dat);
  $.ajax({
  type: "POST",
  url: "certificacion/plantilla/pln-oficialV.php",
  data: dat,
  success: function(data)
  {  
    $("#reimprimir-oficial").html(data);
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
        $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>CERTIFICACIÓN</strong> Impresa!</h3>", {
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

function printNegativaVarias(jorden, it)
{
  tmpModal.hidePleaseWait();
  var tam = Object.keys(jorden).length-3;
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
          
          $("#reimprimir-oficial").html(data);
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

// function printNegativaVarias2(tipoNegativa, datosNegativa)
// {
//   tmpModal.hidePleaseWait();
//   var dat = datosNegativa;
//   // $printNegativa = "nombre=".$nombreCompeto."&fecha=".$fechaL;  
//   if (tipoNegativa==1) {
//     var dir = "certificacion/plantilla/Pnegativa.php";
//   }
//   else if (tipoNegativa==2) {
//     var dir = "certificacion/plantilla/PnegativaComun.php";
//   }
//   else if (tipoNegativa==3) {
//     var dir = "certificacion/plantilla/PnegativaSolicitud.php";
//   }
//   // console.log("Dat======"+dir);
//   $.ajax({
//     type: "POST",
//     url: dir,
//     data: dat,
//     success: function(data)
//     {
      
//       $("#reimprimir-oficial").html(data);
//       $("#printArea").printArea({
//         mode:"iframe",
//         popHt: 500,
//         popWd: 400,
//         popX: 500,
//         popY: 600,
//         popTitle: "Impresion de Negativa",
//         popClose: true
//         });
//         $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>Negativa Impresa</strong></h3>", {
//           type: 'success',
//           width: '500',
//           offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
//           stackup_spacing: 10
//         });        
//     }
//   });  

// }


function printNegativa (reprintNeg, tipoNegativa, datosNegativa, datosCert) {
  tmpModal.hidePleaseWait();
  var dat = datosNegativa;
  if (!reprintNeg) {
    printOficialReim(datosCert);

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
        
        $("#reimprimir-oficial").html(data);
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

            printOficialReim(datosCert);
        }, 3000);
      }
    }); 
  } 

}



function printOficialReim (datos) {
  tmpModal.hidePleaseWait();
  // console.log("printOficial");
  var dat = datos;
  $.ajax({
    type: "POST",
    url: "certificacion/plantilla/pln-oficial.php",
    data: dat,
    success: function(data)
    {
      
      $("#reimprimir-oficial").html(data);
      // $("#reimprimir-oficial").hide();
      $("#printArea").printArea();
      
      setTimeout(function() {
          $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>CERTIFICACIÓN</strong> Reimpresa!</h3>", {
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