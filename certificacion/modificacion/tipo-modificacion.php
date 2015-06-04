<br>
<div class="col-xl-12 col-sm-12 col-md-12 col-md-offset-1">	
	<h3>
	<span class="Colet">Certificación a <strong>Modificar</strong>:</span>
	</h3>
	<div class="col-xl-6 col-sm-6 col-md-6 col-md-offset-3">
	    <a id="" onclick="modparticular()" type="button" class="btn btn-info btn-lg btn-shadow" style="margin:1em;">
	    	<span class="glyphicon glyphicon-user"></span><br>
	    	Particular
	    </a>
	    <a type="button" onclick="modoficial()" class="btn btn-info btn-lg btn-shadow" style="padding-left:1.8em;padding-right:1.8em;">
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

function modparticular() {
    $("#modificar").load('certificacion/modificacion/mod-particular.php');
}
function modoficial() {
    $("#modificar").load('certificacion/modificacion/mod-oficial.php');
}

</script>
