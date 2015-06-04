<?php 
ini_set('display_errors', 'On');
ini_set('display_errors', 1); 
require_once('res/funciones.php');
if(isset($_SESSION['id'])&&!empty($_SESSION['id'])){ 
// if(1){ 

$valor = valor_actual();
//echo $valor;
 ?>
<p>
<h1 class="text-center">
<span class="label label-info">Tipo de Cambio</span>
</h1></p><br>

<div class="col-xl-6 col-sm-6 col-md-6"> 
	<div class="form-group col-xl-12 col-sm-12 col-md-12">
		<div class="form-group col-xl-8 col-sm-8 col-md-8 col-md-offset-4">
			<h3 class="text-center">
				<span class="label label-default">Valor Actual</span>
			</h3>
				<div class="input-group">
					<div class="input-group-addon">$</div>
					<input type="text" readonly class="form-control input-sm text-center" style="width: 7em;font-size:14px;margin:0;" id="ValorConcepto" value="1.00">
					<div class="input-group-addon">Q</div>
					<input type="text" readonly class="form-control input-sm text-center" style="width: 7em;font-size:14px;margin:0;" id="ValorConcepto" value="<?php echo $valor['valor_dolar'] ?>">
				</div>
			<span class="sm">(Ultima Actualización: <?php  echo date("d/m/Y H:i:s",strtotime($valor['fecha'])); ?>)</span>	
		</div>
	</div>
</div>


<div class="col-xl-6 col-sm-6 col-md-6"> 
	<div class="form-group col-xl-12 col-sm-12 col-md-12">
		<div class="form-group col-xl-8 col-sm-8 col-md-8 col-md-offset-0">
			<h3 class="text-center">
				<span class="label label-info">Valor Nuevo</span>
			</h3>
				<div class="input-group">
					<div class="input-group-addon">$</div>
					<input type="text" readonly class="form-control input-sm text-center" style="width: 7em;font-size:14px;margin:0;" id="ValorQuet" value="1.00">
					<div class="input-group-addon">Q</div>
					<input type="text"  class="form-control input-sm text-center" style="width: 7em;font-size:14px;margin:0;" id="ValorDolar" value="" placeholder="Valor Nuevo" data-toggle="tooltip" data-placement="right" title="Ingresar Valor Nuevo" onkeypress="return checkSoloNum(event)" required autofocus>
				</div>
		</div>
	</div>
</div>

<div class="col-xl-12 col-sm-12 col-md-12 text-center">
	<button type="button" id="btn_confirmCambio"  class="btn btn-primary btn-lg btn-shadow">
			<span style="font-size:1.5em;margin:0; padding:0;" class="glyphicon glyphicon-save"></span><br>
			Guardar
	</button>	
</div>


<!-- Modal de confirmacion -->
<div id="ModalConfirm" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">El valor ingresado es <strong>Correcto!</strong> </h4>
      </div>
      <div class="modal-body">
        <ul class='list-group'>
          <dl id="ConfData" class="ConfData dl-horizontal">
          </dl>
        </ul>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="btn_guardarCambio" type="button" class="btn btn-success">
          <span class="glyphicon glyphicon-floppy-save"></span>
          Guardar
        </button>
      </div>
    </div>
  </div>
</div>

<div id="respTipoCambio" class="col-xl-12 col-sm-12 col-md-12" style="margin-top:3em;">

</div>

<script>
var datos = "";
$("#btn_confirmCambio").click(function(){
	var list="";
	console.log("entro");
	if($('#ValorDolar').val()==""){
		$('#ValorDolar').focus();
		$('#ValorDolar').tooltip('show');
	}else{
		list+="<li class='list-group-item'><dt>Valor Nuevo:</dt><dd> $.1.00 = Q."+$('#ValorDolar').val()+"</dd></li>";
		datos="&ValorDolar="+$('#ValorDolar').val();
		console.log(list);
		$( "#ConfData" ).html(list);
	    $("#ModalConfirm").modal('show');
	}
});


$("#btn_guardarCambio").click(function(){
  datos+="&fun=1";
  console.log(datos);
  $("#ModalConfirm").modal('hide');
  var url = "tipo-cambio/funcion-cambio.php"; 
    $.ajax({
          type: "POST",
          url: url,
          data: datos,
          success: function(data)
          {
	          	console.log(data);
	        	var jorden = JSON.parse(data);
	        	console.log(jorden);
	        	switch(jorden.case){
		          case 1:
		            $("#respTipoCambio").html(jorden.message);
		            $('#ValorDolar').val(""); 
		            $('#ValorDolar').focus(); 
		          break;
		          case 2:
		          		$.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'>Tipo de Cambio actualizado <strong>Correctamente!</strong></h3>", {
				            type: 'success',
				            width: '500',
				            offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
				            delay: 3000,
				            stackup_spacing: 10
				        });
		            	setTimeout(function() {
				          window.location = '?ac=cambio';
				      	}, 3000);
		          break;


	        	}
		        // for (var i = jorden.length - 1; i >= 0; i--) {
		        	
		        // 	console.log(jorden[i]);
		        // }
	            // $('.progress-bar').css('width','100%');
	            // console.log(data);
	            // pOrden(data);
	            // $("#ModalConfirm").modal('hide');
          }
    });
    return false; 
});

</script>


<?php 
}else{
  include 'login.php';
}
 ?>

