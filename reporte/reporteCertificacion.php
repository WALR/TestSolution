<div id="CriReport" class="row">
  <div class="col-xl-12 col-sm-12 col-md-12">
    <div class="thumbnail">
      <div class="caption">
        <h2 class="text-center Colet">Criterios del Reporte de Certificación</h2>
        <p>
			
		<form action="reporte/reportepdf.php" method="post" id="FormReporte" class="col-xl-12 col-sm-12 col-md-12">
		  	<div class=" col-xl-8 col-sm-8 col-md-8">
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
		  	</div>
		  	<div id="tipo" class="col-xl-4 col-sm-4 col-md-4" data-toggle="tooltip" data-placement="top" title="Seleccione Tipo" data-campo="Del">
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
		    </div>
	
		</form>    	
        </p>
        <p class="text-center"><button type="submit" id="Generar_Reporte" class="btn btn-lg btn-primary" role="button">Generar Reporte</button></p>
      </div>
    </div>
  </div>
</div>

<div id="reportePDF" >
	
</div>

<script>
$(".input-group.date").datepicker({
	format: "dd-mm-yyyy",
	language: "es",
	autoclose: true,
	endDate: '1d',
	orientation: "top auto",
	todayHighlight: true,
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
	        	tmpModal.showModal();
			    $("#reportePDF").fadeIn("slow", function() {
			    	// $('#reportePDF').html('<center><img src="img/wait.gif" width="25" height="25" /></center>');
			    	$('#reportePDF').html('<div class="col-xl-3 col-sm-3 col-md-3" style="margin-bottom:1em;"><span class="pull-left"><button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="reportAtras()"><span class="glyphicon glyphicon-chevron-left"></span>Atras</button></span></div><iframe src="reporte/reportepdf.php?'+repor+'" height="650" frameborder="0" id="reportepdf" class="col-xl-12 col-sm-12 col-md-12"></iframe>');
			    	tmpModal.hideModal();
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