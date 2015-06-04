<br>
<div class="col-xl-12 col-sm-12 col-md-12 col-md-offset-1">	
	<h3>
	<span class="Colet">Certificación a <strong>Reimprimir</strong>:</span>
	</h3>
	<div class="col-xl-6 col-sm-6 col-md-6 col-md-offset-3">
	    <a id="" onclick="reimparticular()" type="button" class="btn btn-info btn-lg btn-shadow" style="margin:1em;">
	    	<span class="glyphicon glyphicon-user"></span><br>
	    	Particular
	    </a>
	    <a type="button" onclick="reimoficial()" class="btn btn-info btn-lg btn-shadow" style="padding-left:1.8em;padding-right:1.8em;">
	    	<span class="glyphicon glyphicon-list-alt"></span><br>
	    	Oficial
	    </a>
	</div>
</div>

<script>

$(".input-group.date").datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    orientation: "top auto"
});

function reimparticular() {
    $("#reimpresion").load('certificacion/reimpresion/reimpresion-particular.php');
}
function reimoficial() {
    $("#reimpresion").load('certificacion/reimpresion/reimpresion-oficial.php');
}

</script>