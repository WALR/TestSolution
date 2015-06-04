<div id="CriReport" class="row">
  <div class="col-xl-12 col-sm-12 col-md-12">
    <div class="thumbnail">
      <div class="caption">
        <h2 class="text-center Colet">Criterios del Reporte de Orden de Pago</h2>
        <p>
			
		<form action="reporte/reportepdf.php" method="post" id="FormReporte" class="col-xl-12 col-sm-12 col-md-12">
		  	<div class="col-xl-12 col-sm-12 col-md-12">
              <div class="panel panel-default">
                <div class="panel-heading"><b class="Colet">Rango</b></div>
                <div class="panel-body">
                	<div class="col-xl-8 col-sm-8 col-md-8 col-md-offset-5">
	                  <label for="rango" class="control-label input-group">Rango del Reporte</label>
	                  <div id="chekRango" class="btn-group" data-toggle="buttons" data-toggle="tooltip" data-placement="top" title="Seleccione Rango" data-campo="chekRango">
	                      <label class="btn btn-default">
	                          <input id="checkDia" type="radio" name="rango" value="Dia" >Por Dia
	                      </label>
	                     <!--  <label class="btn btn-default">
	                          <input id="checkMes" type="radio" name="rango" value="Mes" >Por Mes
	                      </label> -->
	                      <label class="btn btn-default">
	                          <input id="checkFechas" type="radio" name="rango" value="Fechas">Por Periodo
	                      </label>
	                  </div>
	                </div>
                  
                  <div id="porDia" class="col-xl-12 col-sm-12 col-md-12 well" style="margin-top:1em;" hidden>
                    <span class="text-left"><h4 style="margin-bottom:0;padding-bottom:0;"><legend><span class="Colet">Dia</span></legend></h4></span>
                    
                    <div class="form-group col-xl-12 col-sm-12 col-md-12" style="padding-right:0;">
                      <label for="Del" class="Colet" style="padding-right:11.5em;">Dia:</label>
                      <div class="input-group ">
                        <input type="text" readonly class="input-group date form-control text-center" id="Rdia" data-toggle="tooltip" data-placement="right" title="Dia del Reporte" data-campo="Rdia">
                        <span class="input-group input-group-addon">
		                  <i class="glyphicon glyphicon-calendar"></i>
		                </span>
                      </div>
                      <span class="text-center sm">Campo Obligatorio</span>
                    </div>
                  </div>
				  

                  <!-- <div id="rangoMes" class="col-xl-12 col-sm-12 col-md-12 well" style="margin-top:1em;" hidden>
                    <span class="text-left"><h4 style="padding-bottom:0;"><legend style="margin-bottom:-0.5em;"><span class="Colet">Mes o Meses</span></legend></h4></span>
	                    <div class="form-group col-xl-12 col-sm-12 col-md-12" style="padding-right:0;">
	                        <div class="control-group">
	                          	<div class="controls span2">
		                            <label class="checkbox">
		                                <input type="checkbox" value="option1" id="inlineCheckbox1"> Enero
		                            </label>
		                            <label class="checkbox">
		                                <input type="checkbox" value="option1" id="inlineCheckbox1"> Julio
		                            </label>	                            
	                          	</div>                         
	                          	<div class="controls span2">
									<label class="checkbox">
	                                  <input type="checkbox" value="option2" id="inlineCheckbox2"> Febrero
	                              	</label>
	                              	<label class="checkbox">
		                                <input type="checkbox" value="option1" id="inlineCheckbox1"> Agosto
		                            </label>
	                          	</div>
	                          	<div class="controls span2">
									<label class="checkbox">
		                                <input type="checkbox" value="option3" id="inlineCheckbox3"> Marzo
		                            </label>
									<label class="checkbox">
		                                <input type="checkbox" value="option1" id="inlineCheckbox1"> Septiembre
		                            </label>
	                          	</div>
	                          	<div class="controls span2">
	                          		<label class="checkbox">
		                                <input type="checkbox" value="option3" id="inlineCheckbox3"> Abril
		                            </label>
		                            <label class="checkbox">
		                                <input type="checkbox" value="option1" id="inlineCheckbox1"> Octubre
		                            </label>
									
	                          	</div>
	                          	<div class="controls span2">
	                          		<label class="checkbox">
		                                <input type="checkbox" value="option3" id="inlineCheckbox3"> Mayo
		                            </label>
		                            <label class="checkbox">
		                                <input type="checkbox" value="option1" id="inlineCheckbox1"> Noviembre
		                            </label>
	                          	</div>
	                          	<div class="controls span2">
	                          		<label class="checkbox">
		                                <input type="checkbox" value="option3" id="inlineCheckbox3"> Junio
		                            </label>
		                            <label class="checkbox">
		                                <input type="checkbox" value="option1" id="inlineCheckbox1"> Diciembre
		                            </label>
	                          	</div>
	                      	</div>
	                    </div>
                  </div> -->

                  <div id="rangoFechas" class="col-xl-12 col-sm-12 col-md-12 well" style="margin-top:1em;" hidden>
                    <span class="text-left"><h4 style="margin-bottom:0;padding-bottom:0;"><legend><span class="Colet">Periodo</span></legend></h4></span>
                    
                    <div class="form-group col-xl-12 col-sm-12 col-md-12" style="padding-right:0;">
                      <label for="Del" class="Colet">Del:</label>
                        <label for="Al"  class="Colet" style="margin-left: 29.5em;">Al:</label>
                      <div class="input-group ">
                        <input type="text" readonly class="input-group date form-control text-center" id="Rdel" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del" >
                            <span class="input-group-addon">
                              AL
                            </span>
                        <input type="text" readonly class="input-group date form-control text-center" id="Ral" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del" >
                      </div>
                      <span class="text-center sm">Campos Obligatorios</span>
                    </div>
                  </div>

                </div>
              </div>
            </div>
		  	<!-- <div class=" col-xl-8 col-sm-8 col-md-8">
		  		<span class="Colet text-center"><h4 style="margin-bottom:0;"><b>Periodo</b></h4></span>
			  	<div class="form-group col-xl-12 col-sm-12 col-md-12" style="padding-right:0;">
			    	<label for="Del" class="Colet" style="padding-right:12.5em;">Del: <span class="sm">(Campo Obligatorio)</span></label>
			        <label for="Al"  class="Colet">Al: <span class="sm">(Campo Obligatorio)</span></label>
			    	<div class="input-group ">
			    		<input type="text" readonly class="input-group date form-control text-center" id="Fdel" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
			            <span class="input-group-addon">
			              AL
			            </span>
			    		<input type="text" readonly class="input-group date form-control text-center" id="Fal" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
	          		</div>
			  	</div>
		  	</div> -->
		  	<!-- <div id="tipo" class="col-xl-4 col-sm-4 col-md-4" data-toggle="tooltip" data-placement="top" title="Seleccione Tipo" data-campo="Del">
		  		<span class="Colet text-center"><h4><b>Tipo</b></h4></span>
		        <div class="form-group col-xl-12 col-sm-12 col-md-12 caja">
			        <label>
					    <input id="checkParticular" type="checkbox">
					    <span class="Colet">Particular</span>
					</label>
					<label>
					    <input id="checkOficial" type="checkbox">
					    <span class="Colet">Oficial</span>
					</label>
					<label>
					    <input id="checkDeportado" type="checkbox">
					    <span class="Colet">Particular Deportado</span>
					</label>
		        </div>
		    </div> -->
	
		</form>    	
        </p>
	        <p class="text-center">
	        	<button type="button" id="ReporteOrden" class="btn btn-lg btn-primary" role="button">
	        		Generar Reporte
	        	</button>
	        </p>
      </div>
    </div>
  </div>
</div>

<div id="reportePDF" >
	
</div>

<script>
// $(".input-group.date").datepicker({
// 	format: "dd-mm-yyyy",
// 	language: "es",
// 	orientation: "top auto"
// });window.location = page;

// var page='mydownload.php';
// $.ajax({
//     url: page,
//     type: 'POST',
//     success: function() {
//         window.location = page;// you can use window.open also
//     }
// });

$("#chekRango input:radio").change(function() { 
	
	if($("#checkDia").prop("checked")){
		$( "#porDia" ).slideDown("slow");
		$( "#rangoMes" ).slideUp("slow");
		$( "#rangoFechas" ).slideUp("slow");
	}else if($("#checkFechas").prop("checked")){
		$( "#rangoFechas" ).slideDown("slow");
		$( "#porDia" ).slideUp("slow");
		$( "#rangoMes" ).slideUp("slow");
	} else if($("#checkMes").prop("checked")) {
		$( "#rangoMes" ).slideDown("slow");
		$( "#porDia" ).slideUp("slow");
		$( "#rangoFechas" ).slideUp("slow");
	}
});


$(".input-group.date").datepicker({
	format: "dd-mm-yyyy",
	language: "es",
	autoclose: true,
	endDate: '1d',
	orientation: "top auto",
	todayHighlight: true
});

$("#ReporteOrden").click(function(){
var repor="";
  if($("#checkDia").prop("checked")){
		if ($( "#Rdia" ).val()=="") {
			$('#Rdia').focus();
    		$('#Rdia').tooltip('show');
		}else{
			var datos = "&Rdia="+$( "#Rdia" ).val();
	        // console.log(datos);
	        var url = "reporte/reporteExcel.php?"+datos; 
	        window.location = url;
		}
	}else if($("#checkFechas").prop("checked")){
		if ($( "#Rdel" ).val()=="") {
			$('#Rdel').focus();
    		$('#Rdel').tooltip('show');
		}else{
			if ($( "#Ral" ).val()=="") {
				$('#Ral').focus();
	    		$('#Ral').tooltip('show');
			}else{
				var datos = "&Rdel="+$( "#Rdel" ).val()+"&Ral="+$( "#Ral" ).val();
		        // console.log(datos);
		        var url = "reporte/reporteExcel.php?"+datos; 
	        	window.location = url; 
			}
		}
	}else{
		$('#chekRango').focus();
	    $('#chekRango').tooltip('show');
	}

});

$("#Generar_Reporte").click(function(){
  var repor="";
  if($('#Fdel').val()==""){
    $('#Fdel').focus();
    $('#Fdel').tooltip('show');
  }else{
  	repor="FechaDel="+$('#Fdel').val();
  	if($('#Fal').val()==""){
	    $('#Fal').focus();
	    $('#Fal').tooltip('show');
  	}else{
  		var Fdel = $('#Fdel').val().split("-");
		var date1 = new Date(Fdel[2], Fdel[1], Fdel[0]);
		var Fal = $('#Fal').val().split("-");
		var date2 = new Date(Fal[2], Fal[1], Fal[0]);
  		if (date1>date2) {
  			// console.log("Debe ingresar una fecha posterior");
  			$.bootstrapGrowl("<h5 class='text-center' style='margin-top:1px;margin-bottom:-3px;'>Debe ingresar una fecha posterior al <strong>"+$('#Fdel').val()+"</strong>!</h5>", {
            type: 'warning',
            width: '500',
            offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
            delay: 4000,
            stackup_spacing: 10
          	});
  		}else{
  			repor+="&FechaAl="+$('#Fal').val();
	  		if(!$("#checkParticular").prop("checked")&!$("#checkOficial").prop("checked")&!$("#checkDeportado").prop("checked")){
	        	$('#tipo').focus();
		    	$('#tipo').tooltip('show');
	        }else{

	        	if($("#checkParticular").prop("checked")){
  					repor+="&particular=1";
	        	}
	        	if($("#checkOficial").prop("checked")){
  					repor+="&oficial=1";
	        	}
	        	if($("#checkDeportado").prop("checked")){
  					repor+="&deportado=1";
	        	}
	        	// console.log("aaaa");
	        	tmpModal.showPleaseWait();
			    $("#reportePDF").fadeIn("slow", function() {
			    	// $('#reportePDF').html('<center><img src="img/wait.gif" width="25" height="25" /></center>');
			    	$('#reportePDF').html('<div class="col-xl-3 col-sm-3 col-md-3" style="margin-bottom:1em;"><span class="pull-left"><button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="reportAtras()"><span class="glyphicon glyphicon-chevron-left"></span>Atras</button></span></div><iframe src="reporte/reportepdf.php?'+repor+'" height="650" frameborder="0" id="reportepdf" class="col-xl-12 col-sm-12 col-md-12"></iframe>');
			    	tmpModal.hidePleaseWait();
			    });
			    $("#CriReport").fadeOut("slow");
			    // $("#CriReport").hide();
	        } 
  		}
  	}
  }
});

function reportAtras () {
	window.location = "?ac=reporte";
}
</script>