<?php 
if (!empty($_POST['vigencia'])) {
	$vig="UN DIA";
}else{
	$vig="TRES DIAS";
}

if (!empty($_POST['MulDel'])) {
	$multa="<br><div class='izq' style='font-size:12px;'>LA MULTA CORRESPONDE AL PERIODO DEL: ".$_POST['MulDel']." AL ".$_POST['MulAl'].".</div>";
	if (!empty($_POST['Expediente'])) {
		$multa.="<div class='izq' style='font-size:12px;'>SEGÚN EXONERACIÓN PRESIDENCIAL EXPEDIENTE No.".$_POST['Expediente']." SE EXONERA EL ".$_POST['Pexonera']."% DE Q.".$_POST['TotalEx']." (TOTAL DE LA MULTA).</div>";
	}
}else{ 
	$multa="";
}
 
$html="
<style>
/*Area de Impresion*/
.PrintArea{
  background-color: white;
  text-align: center;
  font-family: arial, verdana;
  font-size: 16px;
  padding-bottom: 3em;
  padding-top: 0.5em;
}
.izq{
	text-align: left;
	margin-left: 2em;
}
.der{
	text-align: right;
	margin-right: 2em;
}
.ordenNo{
	font-size: 30px;
	margin-top: -2.1em;
	padding-bottom: 0.5em;
}
.bold{
	font-weight: bold;
}
</style>


<div  id='printArea' class='PrintArea' >
<div style='text-align: center;'>
<div class='izq' style='margin-bottom: -8.9em;margin-left: -1.8em;'>
<img src='img/migraLogo.png' alt='Logo' width='164px' height='119px'>
</div>
<h1>DIRECCION GENERAL DE MIGRACION<br>
ORDEN DE PAGO</h1>
</div>
<h3>CONTROL MIGRATORIO</h3>
<div>___________________________________________________________________________________________________________</div>
<p class='izq'>Nombre: ".$_POST['nombre']. " </p>
<p class='izq'>Nacionalidad: ".$_POST['nacionalidad']."</p>
<div class='izq'>Fecha: ".$_POST['fecha']."</div>
<div class='der ordenNo'>Orden No.".$_POST['NoOrden']."</div>
<div>___________________________________________________________________________________________________________</div>

<h3 class='izq' style='margin-left: 1.4em;'>DETALLE  DE LA ORDEN:</h3>
<div class='izq bold'>Nombre del concepto</div>
<div class='der bold' style='margin-top: -1.5em;'>Valor del concepto</div>

<div class='izq'>".$_POST['concepto']."</div>
<div class='der' style='margin-right: 5em;margin-top: -1.5em;'>Q.".$_POST['valorConcepto']."</div>
".$multa."
<div>___________________________________________________________________________________________________________</div>
<p>
	<h5 class='izq'>TOTAL: Q.".$_POST['valorConcepto']."</h5>
</p>
<p>
	<h5 class='izq'>TOTAL EN LETRAS: ".$_POST['valorConceptoLetras']."</h5>
	<h5 class='izq'><b>ESTA ORDEN DE PAGO TIENE VIGENCIA DE ".$vig.".</b></h5>
</p>


</div>
";

echo $html;

 ?>

