<?php 
require_once('res/funciones.php');
ini_set('display_errors', 'On');
ini_set('display_errors', 1); 
if(!isset($_SESSION)) 
{ 
    session_start();
} 

// // $diaActual = date("d");
// // $anioActual = date("Y");
// // $dia = date("d",strtotime($datafecha['fecha']));
// // $anio = date("Y",strtotime($datafecha['fecha']));
// // $mes2 = strtotime("$mes +3 month");

$datafecha = valor_actual();
$ultima = $datafecha['fecha'];
$f = date("d/m/Y H:i:s",strtotime($ultima));

$mesActual = date("m");
$nuevafecha = strtotime ( '+3 month' , strtotime ($ultima));
$nuevafecha = date ( 'Y-m-d H:i:s' , $nuevafecha );
$mes = date("m",strtotime($nuevafecha));
if ($mesActual>=$mes){
  $mjs = '<div id="mjs" class="col-xl-12 col-sm-12 col-md-12" style="margin-bottom:1em;margin-top:1em;"><div class="alert alert-danger alert-dismissible text-justify" role="alert">
  La última actualización realizada al tipo de cambio fue el: <strong>'.$f.'</strong>. 
  Esta bajo su propia responsabilidad generar ordenes de pago con un tipo de cambio <strong>desactualizado!</strong> Desea
  <a href="?ac=cambio" class="Colet" >
    Actualizar Tipo de Cambio
  </a></div>';
  echo $mjs;
}


//if(isset($_SESSION['id'])&&!empty($_SESSION['id'])){ 
if(1){ 
 ?>
<p>
<h1 class="text-center">
<span class="label label-info">Orden de Pago</span>
</h1></p><br>
<div role="tabpanel">
  <!-- Nav tabs -->
  <ul id="myTab" class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#generar" aria-controls="generar" role="tab" data-toggle="tab"><b>Generar Orden de Pago</b></a></li>
    <li role="presentation" ><a href="#consulta" aria-controls="consulta" role="tab" data-toggle="tab"><b>Consulta Ordenes de Pago</b></a></li>
    <li role="presentation"><a href="#multa" aria-controls="multa" role="tab" data-toggle="tab"><b>Multa por Permanencia Ilegal</b></a></li>
  </ul>

  <div class="tab-content">
    <!-- PANEL DE ORDEN -->
    <div role="tabpanel" class="tab-pane active" id="generar">
      <div  id="ordenPago">
      	<h4 class="text-center Colet"></h4>
  	  	<form method="post" id="FormOrdenPago" class="col-xl-12 col-sm-12 col-md-12">
      	  	<div class="form-group col-xl-6 col-sm-6 col-md-6">
      	    	<label for="Pnombre" class="Colet">Primer Nombre: <span class="sm">(Campo Obligatorio)</span></label>
      	    	<input type="text" class="form-control" id="Pnombre" data-toggle="tooltip" data-placement="right" title="Ingresar Primer Nombre" data-campo="Pnombre" placeholder="Primer Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required autofocus>
      	  	</div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="Snombre" class="Colet">Segundo Nombre: </label>
              <input type="text" class="form-control" id="Snombre" placeholder="Segundo Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
            </div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="Papellido" class="Colet">Primer Apellido: <span class="sm">(Campo Obligatorio)</span></label>
              <input type="text" class="form-control" id="Papellido" data-toggle="tooltip" data-placement="right" title="Ingresar Primer Apellido" placeholder="Primer Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
            </div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="Sapellido" class="Colet">Segundo Apellido: </label>
              <input type="text" class="form-control" id="Sapellido" placeholder="Segundo Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
            </div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="Capellido" class="Colet">Apellido de Casada: </label>
              <input type="text" class="form-control" id="Capellido" placeholder="Apellido de Casada" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
            </div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="nacionalidad" class="Colet">Nacionalidad <span class="sm">(Campo Obligatorio)</span></label>
              <select id="cboNacionalidad" class="form-control" data-toggle="tooltip" data-placement="right" title="Seleccione la Nacionalidad" style="text-transform:uppercase;">
                <option value="0">Seleccionar...</option>
                <?php
                  $paises = obtenerPaises();
                  foreach ($paises as $pais) { 
                      echo '<option value="'.$pais->id.'">'.$pais->nacionalidad.'</option>';        
                  }
                ?>
            </select>
            </div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="TipoDoc" class="Colet">Tipo de Documento: <span class="sm">(Campo Obligatorio)</span></label>
              <select id="cboTipoDoc" class="form-control" data-toggle="tooltip" data-placement="right" title="Seleccione Tipo de Documento" style="text-transform:uppercase;">
                <option value="0">Seleccionar...</option>
                <option value="1">DOCUMENTO PERSONAL DE IDENTIFICACIÓN</option>
                <option value="2">PASAPORTE</option>
                <option value="3">VISA</option>
                <option value="4">TARJETA DE VISITANTE</option>
                <option value="5">CERTIFICACION DE NACIMIENTO</option>
              </select required>
            </div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="NumDoc" class="Colet">Numero de Documento: <span class="sm">(Campo Obligatorio)</span></label>
              <input type="text" class="form-control" id="NumDoc" placeholder="Numero de Documento" data-toggle="tooltip" data-placement="right" title="Ingrese Numero de Documento" style="text-transform:uppercase;" required>
            </div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="paisExtDoc" class="Colet">Pais donde se extendio el Documento: <span class="sm">(Campo Obligatorio)</span></label>
              <select id="cboPais" class="form-control" data-toggle="tooltip" data-placement="right" title="Seleccione Pais donde se extendio el Documento" style="text-transform:uppercase;">
                <option value="0">Seleccionar...</option>
                <?php
                  $paises;
                  foreach ($paises as $pais) { 
                      echo '<option value="'.$pais->id.'">'.$pais->nombre.'</option>';        
                  }
                ?>
            </select required>
            </div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="LugarExtDoc" class="Colet">Lugar donde se extendio el Documento: <span class="sm">(Campo Obligatorio)</span></label>
              <input type="text" class="form-control" id="LugarExtDoc" placeholder="Lugar donde se extendio el Documento" data-toggle="tooltip" data-placement="right" title="Ingrese lugar donde se extendio el Documento" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
            </div>
            <div class="form-group col-xl-12 col-sm-12 col-md-12">
                <label for="TipoDoc" class="Colet text-right">Motivo de la solicitud por Visa: <span class="sm">(Campo Obligatorio)</span></label>
                <select id="cboTipoDoc" class="form-control" data-toggle="tooltip" data-placement="right" title="Seleccione Tipo de Documento" style="text-transform:uppercase;">
                  <option value="0">PARTICULAR</option>
                  <?php 
                    foreach ($paises as $pais) { 
                      echo '<option value="'.$pais->id.'">'.$pais->nacionalidad.'</option>';        
                    }
                   ?>
                </select required>
                
            </div>
      	  	<div class="form-group col-xl-6 col-sm-6 col-md-6">
      	    	<label for="concepto" class="Colet">Concepto de monto Fijo: <span class="sm">(Campo Obligatorio)</span></label>
      	    	<select id="cboConcepto" class="form-control" data-toggle="tooltip" data-placement="right" title="Seleccione Concepto" style="text-transform:uppercase;">
        				<option value="0">Seleccionar...</option>
                 <?php
                  $conceptos = obtenerConcepto();
                  $data="<script>";
                  foreach ($conceptos as $concepto) { 
                      $data.="$( 'body' ).data( '".$concepto->id."', ".$concepto->valor." );";
                      echo '<option value="'.$concepto->id.'">'.$concepto->nombre.'</option>';        
                  }
                  $data.="</script>";
                  echo $data;
                ?>
      			</select required>
      	  	</div>
      	  	<div id="Vconcepto" class="form-group col-xl-6 col-sm-6 col-md-6">
      	    	<label for="nacionalidad" class="Colet">Valor Concepto: <span class="sm">(Campo Obligatorio)</span></label>
      	  		<div class="input-group">
            		<div class="input-group-addon">Q.</div>
      	    		<input type="text" class="form-control" id="ValorConcepto" placeholder="Ingresar Valor Concepto" data-toggle="tooltip" data-placement="right" title="Ingresar Valor de Concepto" onkeypress="return checkSoloNum(event)" required>
          		</div>
      	  	</div>
            <div id="Cmulta" class="col-xl-12 col-sm-12 col-md-12 col-md-offset-0 well" hidden>
              <legend><span class="Colet">Calculo de Multa</span></legend>
              <div class="form-group col-xl-6 col-sm-6 col-md-6">
                  <label for="Del" class="Colet" >Fecha Inicio:</label>
                  <label for="Al"  class="Colet" style="margin-left:11em;">Fecha Final:</label>
                <div class="input-group ">
                  <input type="text" readonly onchange="calDias();calDescuento();" class="input-group date form-control text-center" id="Finicio" data-toggle="tooltip" data-placement="right" title="Fecha Inicio" data-campo="Del" placeholder="Fecha Inicio" required>
                      <span class="input-group-addon">
                        AL
                      </span>
                  <input type="text" readonly onchange="calDias();calDescuento();" class="input-group date form-control text-center" id="Ffinal" data-toggle="tooltip" data-placement="right" title="Fecha Final" data-campo="Del" placeholder="Fecha Final" required>
                </div>
              </div>
              <div class="col-xl-3 col-sm-3 col-md-3">
                <label for="nacionalidad" class="Colet">Dias:</label>
                <input readonly type="text" class="form-control" id="Dias" placeholder="Dias" required>
              </div>
              <div class="col-xl-3 col-sm-3 col-md-3">
                <label for="nacionalidad" class="Colet">Total:</label>
                <div class="input-group">
                  <div class="input-group-addon">Q.</div>
                  <input readonly type="text" class="form-control" id="total" placeholder="Valor Concepto" data-toggle="tooltip" data-placement="right" title="Ingresar Valor de Concepto" onkeypress="return checkSoloNum(event)" required>
                </div>
              </div>
              <br>
              <div class="col-xl-12 col-sm-12 col-md-12" style="padding-bottom:1em;">
                <a class="btn btn-default dropdown-toggle" onclick="exonera()">EXONERACIÓN
                  <span class="caret"></span>
                </a>
              </div>

              <div id="Cexonera" class="col-xl-12 col-sm-12 col-md-12 well" hidden>
                <legend><span class="Colet">EXONERACIÓN PRESIDENCIAL</span></legend>
                <div class="form-group col-xl-12 col-sm-12 col-md-12" >
                  <div class="form-group col-xl-3 col-sm-3 col-md-3">
                    <label for="Pnombre" class="Colet">Según expediente</label>
                    <div class="input-group">
                      <div class="input-group-addon">No.</div>
                      <input type="text" class="form-control" id="Nexpediente" data-toggle="tooltip" data-placement="right" title="Numero de Expediente" data-campo="Nexpediente" placeholder="Numero de Expediente" style="text-transform:uppercase;" required autofocus>
                    </div>
                  </div>
                  <div class="form-group col-xl-3 col-sm-3 col-md-3">
                    <label for="Pnombre" class="Colet">Se exonera el</label>
                    <div class="input-group">
                      <input type="text" onchange="calDescuento();" class="form-control" id="Pexonera" data-toggle="tooltip" data-placement="right" title="Porcentaje de Exoneración" data-campo="Pexonera" placeholder="Porcentaje de Exoneración" onkeypress="return checkSoloNum(event)" required autofocus>
                      <div class="input-group-addon">%</div>
                    </div>
                  </div>
                  <div class="form-group col-xl-3 col-sm-3 col-md-3" >
                    <label for="Pnombre" class="Colet">Descuento</label>
                    <div class="input-group">
                      <div class="input-group-addon">Q.-</div>
                      <input readonly type="text" class="form-control" id="Dexonera" data-toggle="tooltip" data-placement="right" title="Total de Descuento" data-campo="Dexonera" placeholder="Porcentaje de Exoneración" >
                    </div>
                  </div>
                  <div class="form-group col-xl-3 col-sm-3 col-md-3" >
                    <label for="Pnombre" class="Colet">Total Orden</label>
                    <div class="input-group">
                      <div class="input-group-addon">Q.</div>
                      <input readonly type="text" class="form-control" id="Texonera" data-toggle="tooltip" data-placement="right" title="Total de Orden" data-campo="Texonera" placeholder="Total de Orden" >
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <div class="form-group col-xl-12 col-sm-12 col-md-12">
              <label for="Observaciones" class="Colet">Observaciones: </label>
              <textarea class="form-control" rows="2" id="resolucion" style="text-transform:uppercase;" ></textarea>
            </div>
      		  <div class="col-xl-6 col-sm-6 col-md-6 col-md-offset-5">
      	  		<button type="button" id="btn_confirm"  class="btn btn-primary btn-shadow">
      	  			<span style="font-size:1.5em;margin:0; padding:0;" class="glyphicon glyphicon-print"></span><br>
      	  			Generar / Imprimir
      	  		</button>	
      		  </div>
  		  </form>
      </div>

      <div id="respOrden" class="col-xl-12 col-sm-12 col-md-12" style="margin-top:3em;">
        
      </div>
    </div>
    <!-- FIN PANEL DE ORDEN -->

    <!-- PANEL DE CONSULTA -->
    <div role="tabpanel" class="tab-pane" id="consulta">
      <br>
      <div id="consultaOrden">
        <!-- BUSCAR ORDEN -->
        <div id="buscarOrden" class="col-xl-12 col-sm-12 col-md-12 well">
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="OrdenBuscar" class="Colet">Orden de Pago:</label>
              <input type="number" class="form-control" id="OrdenBuscar" placeholder="Numero de Orden de Pago" onkeypress="return checkSoloNum(event)" >
            </div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="Del" class="Colet" style="padding-right:15.7em;">Del:</label>
              <label for="Al"  class="Colet">Al:</label>
              <div class="input-group ">
                <input type="text" onchange="VerDias();" readonly class="input-group date form-control text-center FechaB" id="FechaBdel" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                <span class="input-group-addon">AL</span>
                <input type="text" onchange="VerDias();" readonly class="input-group date form-control text-center FechaB" id="FechaBal" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
              </div>
            </div>            
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="Pnombre" class="Colet">Primer Nombre: <span class="sm">(Campo Obligatorio)</span></label>
              <input type="text" class="form-control" id="PnombreBuscar" data-toggle="tooltip" data-placement="right" title="Ingresar Primer Nombre" data-campo="Pnombre" placeholder="Primer Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required autofocus>
            </div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="Snombre" class="Colet">Segundo Nombre: </label>
              <input type="text" class="form-control" id="SnombreBuscar" placeholder="Segundo Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
            </div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="Papellido" class="Colet">Primer Apellido: <span class="sm">(Campo Obligatorio)</span></label>
              <input type="text" class="form-control" id="PapellidoBuscar" data-toggle="tooltip" data-placement="right" title="Ingresar Primer Apellido" placeholder="Primer Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
            </div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="Sapellido" class="Colet">Segundo Apellido: </label>
              <input type="text" class="form-control" id="SapellidoBuscar" placeholder="Segundo Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
            </div>
            <div class="col-xl-6 col-sm-6 col-md-6 col-md-offset-5">
              <button type="button" id="btnBuscarOrden"  class="btn btn-lg btn-primary btn-shadow" style="padding: 0.5em 34px;">
                <span style="font-size:1.5em;margin:0; padding:0;" class="glyphicon glyphicon-search"></span><br>
                Buscar
              </button> 
            </div>
        </div>
        <!-- FIN BUSCAR ORDEN -->
        <!-- DATOS DE ORDENES -->
        <div id="tblOrden" class="col-xl-12 col-sm-12 col-md-12 well" hidden>
          <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-0">
            <span class="pull-left">
              <button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="atrasBusc()" tabindex=1 >
                <span class="glyphicon glyphicon-chevron-left"> </span>
                Atras
              </button>
            </span>
          </div>
          <div class="col-xl-12 col-sm-12 col-md-12" style="height:auto;overflow:scroll;max-height:600px;"> 
            <table id="tabla" class="table table-hover col-xl-12 col-sm-12 col-md-12"> <!-- table-bordered -->
              <thead>
                <tr>
                  <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Orden No.</th>
                  <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Primer Nombre</th>
                  <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Segundo Nombre</th>
                  <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Primer Apellido</th>
                  <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Segundo Apellido</th>
                  <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Apellido de Casada</th>
                  <th class="col-xl-3 col-sm-3 col-md-3 Colet" >Concepto</th>
                  <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Fecha</th>
                  <th class="col-xl-2 col-sm-2 col-md-2 Colet" >Acción</th>
                </tr>
              </thead>
              <tbody id="bodyTable">
              </tbody>
            </table>
          </div>
        </div>
        <!-- FIN DATOS DE ORDENES -->

        <!-- MODIFICIACION DE ORDEN -->
        <div id="modOrden" class="col-xl-12 col-sm-12 col-md-12 well" hidden>
            <legend class="Colet">
              Orden de Pago No.
              <span id="idOrdenModificar"></span>
            </legend>        
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="Pnombre" class="Colet">Primer Nombre: <span class="sm">(Campo Obligatorio)</span></label>
              <input type="text" class="form-control" onchange="mOrden(this);" id="PnombreModForm" data-toggle="tooltip" data-placement="right" title="Ingresar Primer Nombre" data-campo="Pnombre" placeholder="Primer Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required autofocus>
            </div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="Snombre" class="Colet">Segundo Nombre: </label>
              <input type="text" class="form-control" onchange="mOrden(this);" id="SnombreModForm" placeholder="Segundo Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
            </div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="Papellido" class="Colet">Primer Apellido: <span class="sm">(Campo Obligatorio)</span></label>
              <input type="text" class="form-control" onchange="mOrden(this);" id="PapellidoModForm" data-toggle="tooltip" data-placement="right" title="Ingresar Primer Apellido" placeholder="Primer Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
            </div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="Sapellido" class="Colet">Segundo Apellido: </label>
              <input type="text" class="form-control" onchange="mOrden(this);" id="SapellidoModForm" placeholder="Segundo Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
            </div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="Capellido" class="Colet">Apellido de Casada: </label>
              <input type="text" class="form-control" onchange="mOrden(this);" id="CapellidoModForm" placeholder="Apellido de Casada" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
            </div>

            <!-- MODIFICACION MULTA -->
            <div id="CmultaMod" class="col-xl-12 col-sm-12 col-md-12 col-md-offset-0 well" hidden>
              <legend><span class="Colet">Calculo de Multa</span></legend>
              <div class="form-group col-xl-6 col-sm-6 col-md-6">
                  <label for="Del" class="Colet" >Fecha Inicio:</label>
                  <label for="Al"  class="Colet" style="margin-left:11em;">Fecha Final:</label>
                <div class="input-group ">
                  <input type="text" readonly onchange="mOrden(this);calDiasMod();calDescuentoMod();" class="input-group date form-control text-center" id="FinicioModForm" data-toggle="tooltip" data-placement="top" title="Fecha Inicio" data-campo="Del" placeholder="" required />
                      <span class="input-group-addon">
                        AL
                      </span>
                  <input type="text" readonly onchange="mOrden(this);calDiasMod();calDescuentoMod();" class="input-group date form-control text-center" id="FfinalModForm" data-toggle="tooltip" data-placement="top" title="Fecha Final" data-campo="Del" placeholder="" required>
                </div>
              </div>
              <div class="col-xl-3 col-sm-3 col-md-3">
                <label for="Dias" class="Colet">Dias:</label>
                <input readonly type="text" onchange="mOrden(this);" class="form-control" id="DiasModForm" placeholder="Dias" required>
              </div>
              <div class="col-xl-3 col-sm-3 col-md-3">
                <label for="Total" class="Colet">Total:</label>
                <div class="input-group">
                  <div class="input-group-addon">Q.</div>
                  <input readonly type="text" onchange="mOrden(this);" class="form-control" id="totalModForm" placeholder="Ingresar Valor Concepto" data-toggle="tooltip" data-placement="right" title="Ingresar Valor de Concepto" onkeypress="return checkSoloNum(event)" required>
                </div>
              </div>
              <br>
              <div class="col-xl-12 col-sm-12 col-md-12" style="padding-bottom:1em;">
                <a class="btn btn-default dropdown-toggle" onclick="exoneraMod();">EXONERACIÓN
                  <span class="caret"></span>
                </a>
              </div>
              <!-- MODIFICACION EXONERACION -->
              <div id="CexoneraMod" class="col-xl-12 col-sm-12 col-md-12 well" hidden>
                <legend><span class="Colet">EXONERACIÓN PRESIDENCIAL</span></legend>
                <div class="form-group col-xl-12 col-sm-12 col-md-12" >
                  <div class="form-group col-xl-3 col-sm-3 col-md-3">
                    <label for="Pnombre" class="Colet">Según expediente</label>
                    <div class="input-group">
                      <div class="input-group-addon">No.</div>
                      <input type="text" onchange="mOrden(this);" class="form-control" id="NexpedienteMod" data-toggle="tooltip" data-placement="right" title="Numero de Expediente" data-campo="Nexpediente" placeholder="Numero de Expediente" style="text-transform:uppercase;" required autofocus>
                    </div>
                  </div>
                  <div class="form-group col-xl-3 col-sm-3 col-md-3">
                    <label for="Pnombre" class="Colet">Se exonera el</label>
                    <div class="input-group">
                      <input type="text" onchange="mOrden(this);calDescuentoMod();" class="form-control" id="PexoneraMod" data-toggle="tooltip" data-placement="right" title="Porcentaje de Exoneración" data-campo="Pexonera" placeholder="Porcentaje de Exoneración" onkeypress="return checkSoloNum(event)" required autofocus>
                      <div class="input-group-addon">%</div>
                    </div>
                  </div>
                  <div class="form-group col-xl-3 col-sm-3 col-md-3" >
                    <label for="Pnombre" class="Colet">Descuento</label>
                    <div class="input-group">
                      <div class="input-group-addon">Q.-</div>
                      <input readonly type="text" onchange="mOrden(this);" class="form-control" id="DexoneraMod" data-toggle="tooltip" data-placement="right" title="Total de Descuento" data-campo="Dexonera" placeholder="Porcentaje de Exoneración" >
                    </div>
                  </div>
                  <div class="form-group col-xl-3 col-sm-3 col-md-3" >
                    <label for="Pnombre" class="Colet">Total Orden</label>
                    <div class="input-group">
                      <div class="input-group-addon">Q.</div>
                      <input readonly type="text" onchange="mOrden(this);" class="form-control" id="TexoneraMod" data-toggle="tooltip" data-placement="right" title="Total de Orden" data-campo="Texonera" placeholder="Total de Orden" >
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-12 col-sm-12 col-md-12" style="padding-top:2em;">
              <div class="col-xl-5 col-sm-5 col-md-5">
                <span class="pull-left">
                  <button type="button" id="atrasMod"  class="btn btn-default btn-lg btn-shadow" onclick="atrasMod()" tabindex=1 >
                    <span class="glyphicon glyphicon-chevron-left"> </span>
                    Atras
                  </button>
                </span>
              </div>
              <div class="col-xl-6 col-sm-6 col-md-6">
                <button type="button" id="btnModOrden"  class="btn btn-lg btn-primary btn-shadow" style="padding: 0.5em 34px;">
                  <span style="font-size:1.5em;margin:0; padding:0;" class="glyphicon glyphicon-pencil"></span><br>
                  Modificar
                </button> 
              </div>
            </div>
        </div>
        <!-- FIN MODIFICIACION DE ORDEN -->

        <div id="respBuscar" class="col-xl-12 col-sm-12 col-md-12" style="margin-top:3em;">
        </div>

      </div>
    </div>
    <!-- FIN PANEL DE CONSULTA -->

    <!-- PANEL DE MULTA -->
    <div role="tabpanel" class="tab-pane" id="multa">
      <h4 class="Colet text-center"><b>MULTA POR PERMANENCIA ILEGAL EN EL PAIS</b></h4>
      <div id="multaBoleta" class="col-xl-12 col-sm-12 col-md-12">
        <div class="form-group col-xl-6 col-sm-6 col-md-6">
          <label for="MulOrden" class="Colet">Orden No.: <span class="sm">(Campo Obligatorio)</span></label>
          <input type="text" class="form-control" id="MulOrden" data-toggle="tooltip" data-placement="right" title="Ingresar Orden de Pago" data-campo="MulOrden" placeholder="Orden de Pago"  onkeypress="return checkSoloNum(event)" >
        </div>
        <div class="form-group col-xl-6 col-sm-6 col-md-6">
          <label for="MulBoleta" class="Colet">Boleta de Banco No.: <span class="sm">(Campo Obligatorio)</span></label>
          <input type="text" class="form-control" id="MulBoleta" data-toggle="tooltip" data-placement="right" title="Ingresar Boleta de Banco" data-campo="MulBoleta" placeholder="Boleta de Banco" >
        </div>

        <div class="col-xl-6 col-sm-6 col-md-6 col-md-offset-5">
          <button type="button" id="btnMulta"  class="btn btn-lg btn-primary btn-shadow" style="margin-left: 1em;">
            <span style="font-size:1.5em;margin:0; padding:0;" class="glyphicon glyphicon-save"></span><br>
            Guardar
          </button> 
        </div>
      </div>

      <div id="respMulta" class="col-xl-12 col-sm-12 col-md-12" style="margin-top:3em;">
        
      </div>
      
    </div>
    <!-- FIN PANEL DE MULTA -->

  </div>


<!-- Modal de confirmacion -->
<div id="ModalConfirm" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Los datos ingresados son Correctos?</h4>
      </div>
      <div class="modal-body">
        <ul class='list-group'>
          <dl id="ConfData" class="ConfData dl-horizontal">
          </dl>
        </ul>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="btn_guardar" type="button" class="btn btn-success">
          <span class="glyphicon glyphicon-floppy-save"></span>
          Guardar
        </button>
      </div>
    </div>
  </div>
</div>

<div id="confImp" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Los datos ingresados son Correctos?</h4>
      </div>
      <div class="modal-body">
        <ul class='list-group'>
          <dl id="ConfData" class="ConfData dl-horizontal">
          </dl>
        </ul>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="btn_guardar" type="button" class="btn btn-success">
          <span class="glyphicon glyphicon-floppy-save"></span>
          Guardar
        </button>
      </div>
    </div>
  </div>
</div>

<div id="confReimp" class="modal fade">
  <div class="modal-dialog modal-dialog-center">
    <div class="modal-content">
      <div class="modal-body">
        <b>Desea reimprimir la orden de pago?</b>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
        <button type="button" data-dismiss="modal" class="btn btn-success" id="reimprimir">Reimprimir</button>
      </div>
    </div>
  </div>
</div>

<div id="ModalGuardarMod" class="modal fade">
  <div class="modal-dialog modal-dialog-center">
    <div class="modal-content">
      <div class="modal-body">
        <b>Esta segúro de los datos que modificará?</b>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
        <button type="button" data-dismiss="modal" class="btn btn-danger" id="ModalguardarMod">Guardar</button>
      </div>

    </div>
  </div>
</div>

<script>
function exonera() {
  if ($('#Cexonera').is(':visible')){
    $('#Cexonera').slideUp("slow");
  }else{
    $('#Cexonera').slideDown("slow");
  }
}

function exoneraMod() {
  if ($('#CexoneraMod').is(':visible')){
    $('#CexoneraMod').slideUp("slow");
  }else{
    $('#CexoneraMod').slideDown("slow");
  }
}

function calDescuento() {
  var total = $('#total').val();
  var porcen = $('#Pexonera').val();
  if (total==""&&porcen!="") {
    if ($('#Finicio').val()==""){
      $('#Finicio').focus();
      $('#Finicio').tooltip('show');
    }else{
      if ($('#Ffinal').val()==""){
        $('#Ffinal').focus();
        $('#Ffinal').tooltip('show');
      }
    }
  }else if(porcen!=""){
    var desc = total*(porcen/100);
    var totaOrn = total-desc;
    $('#Dexonera').val(desc.toFixed(2));
    $('#Texonera').val(totaOrn.toFixed(2));
  }
}

function calDescuentoMod() {
  var total = $('#totalModForm').val();
  var porcen = $('#PexoneraMod').val();
  if (total==""&&porcen!="") {
    if ($('#FinicioModForm').val()==""){
      $('#FinicioModForm').focus();
      $('#FinicioModForm').tooltip('show');
    }else{
      if ($('#FfinalModForm').val()==""){
        $('#FfinalModForm').focus();
        $('#FfinalModForm').tooltip('show');
      }
    }
  }else if(porcen!=""){
    var desc = total*(porcen/100);
    var totaOrn = total-desc;
    $('#DexoneraMod').val(desc.toFixed(2));
    $('#TexoneraMod').val(totaOrn.toFixed(2));
  }
}


function mOrden(dat) {
  if ($( "body" ).data(dat.id)!=$("#"+dat.id).val().toUpperCase()) {
    $("#"+dat.id).css({"color": "red", "border-color": "red"});
  }else{
    $("#"+dat.id).css({"color": "#555", "border-color": "#CCC"});
  }
}



$("#btnModOrden").click(function(){
  if ($("#PnombreModForm").val()=="") {
    $('#PnombreModForm').focus();
    $('#PnombreModForm').tooltip('show');
  }else{
    if ($("#PapellidoModForm").val()=="") {
      $('#PapellidoModForm').focus();
      $('#PapellidoModForm').tooltip('show');
    }else{
      datosModi = "";
      if ($('#PnombreModForm').val().toUpperCase()!=$("body").data('PnombreModForm')) {
        datosModi+="&Pnombre="+$.trim($('#PnombreModForm').val().toUpperCase());
      }
      if ($('#SnombreModForm').val().toUpperCase()!=$("body").data('SnombreModForm')) {
        datosModi+="&Snombre="+$.trim($('#SnombreModForm').val().toUpperCase());
      }
      if ($('#PapellidoModForm').val().toUpperCase()!=$("body").data('PapellidoModForm')) {
        datosModi+="&Papellido="+$.trim($('#PapellidoModForm').val().toUpperCase());
      }
      if ($('#SapellidoModForm').val().toUpperCase()!=$("body").data('SapellidoModForm')) {
        datosModi+="&Sapellido="+$.trim($('#SapellidoModForm').val().toUpperCase());
      }
      if ($('#CapellidoModForm').val().toUpperCase()!=$("body").data('CapellidoModForm')) {
        datosModi+="&Capellido="+$.trim($('#CapellidoModForm').val().toUpperCase());
      }

      if ($('#FinicioModForm').val().toUpperCase()!=$("body").data('FinicioModForm')) {
        datosModi+="&Finicio="+$.trim($('#FinicioModForm').val().toUpperCase());
      }
      if ($('#FfinalModForm').val().toUpperCase()!=$("body").data('FfinalModForm')) {
        datosModi+="&Ffinal="+$.trim($('#FfinalModForm').val().toUpperCase());
      }
      if ($('#CexoneraMod').is(':visible')){
        if ($('#NexpedienteMod').val().toUpperCase()!=$("body").data('NexpedienteMod')) {
          datosModi+="&Nexpediente="+$.trim($('#NexpedienteMod').val().toUpperCase());
        }
        if ($('#PexoneraMod').val().toUpperCase()!=$("body").data('PexoneraMod')) {
          datosModi+="&Pexonera="+$.trim($('#PexoneraMod').val().toUpperCase());
        }
        if ($('#DexoneraMod').val().toUpperCase()!=$("body").data('DexoneraMod')) {
          datosModi+="&Dexonera="+$.trim($('#DexoneraMod').val().toUpperCase());
        }
        if ($('#TexoneraMod').val().toUpperCase()!=$("body").data('TexoneraMod')) {
          datosModi+="&Texonera="+$.trim($('#TexoneraMod').val().toUpperCase());
        }
        // datosModi+="&Dexonera="+$.trim($('#DexoneraMod').val())+"&Texonera="+$.trim($('#TexoneraMod').val());
      }else if($('#CexoneraMod').is(':hidden')){
        datosModi+="&exon=0";
      } 
      // if ($('#DiasModForm').val().toUpperCase()!=$("body").data('DiasModForm')) {
      //   datosModi+="&Dias="+$.trim($('#DiasModForm').val().toUpperCase());
      // }
      // if ($('#totalModForm').val().toUpperCase()!=$("body").data('totalModForm')) {
      //   datosModi+="&total="+$.trim($('#totalModForm').val().toUpperCase());
      // }
      if (datosModi!="") {
        if ($('#totalModForm').is(':visible')){
          datosModi+="&total="+$.trim($('#totalModForm').val())+"&Dias="+$.trim($('#DiasModForm').val());
        } 
        console.log("entro"+datosModi);
        guardarModificacion(datosModi);
        // datosModi+="&NfolioEntrada="+$('#NfolioEntradaMod').text();
        // $( ".ConfData" ).html(list);
        // $("#ModalConfirm").modal('show');
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

});

function guardarModificacion(datos) {
  $('#ModalGuardarMod').modal({ backdrop: 'static', keyboard: false })
  .one('click', '#ModalguardarMod', function (e) {
  
    var datMod = datos+"&fun=6&OrdenMod="+$('#idOrdenModificar').text();
    console.log(datMod);
    var url = "ordenpago/funcion_ordenpago.php";
    $.ajax({
      type: "POST",
      url: url,
      data: datMod,
      success: function(data)
      {
        console.log(data);
        var jorden = JSON.parse(data);
        switch(jorden.case){
            case 1:
              $("#respBuscar").html(jorden.message);
            break;
            case 2:
              printOrden(jorden.message);
            break;
        }
      }
    });

  });
}

$("#btnMulta").click(function(){
  
  if($('#MulOrden').val()==""){
    $('#MulOrden').focus();
    $('#MulOrden').tooltip('show');
  }else{
    if($('#MulBoleta').val()==""){
      $('#MulBoleta').focus();
      $('#MulBoleta').tooltip('show');
    }else{
      var datMul = "fun=5&Orden="+$('#MulOrden').val()+"&Boleta="+$('#MulBoleta').val();
      var url = "ordenpago/funcion_ordenpago.php";
      $.ajax({
        type: "POST",
        url: url,
        data: datMul,
        success: function(data)
        {
          console.log(data);
          var jorden = JSON.parse(data);
          switch(jorden.case){
            case 1:
              $("#respMulta").html(jorden.message);
            break;
            case 2:
              // printOrden(jorden.message);
              $.bootstrapGrowl("<h4 class='text-center' style='margin-top:1px;margin-bottom:-3px;'>Se guardo la boleta No."+$('#MulBoleta').val()+" con la Boleta de Pago No."+$('#MulOrden').val()+"</h4>", {
                type: 'success',
                width: '500',
                offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
                delay: 4000,
                stackup_spacing: 10
              });
              $('#MulBoleta').val("");
              $('#MulOrden').val("");
              $("#respMulta").html("");
            break;
          }
        }
      });
    }
  }
});

function modificarOrden(idOrden){
  //Limpiar
  $('#idOrdenModificar').text("");
  $("#PnombreModForm").val("").css({"color": "#555", "border-color": "#CCC"});
  $("#SnombreModForm").val("").css({"color": "#555", "border-color": "#CCC"});
  $("#PapellidoModForm").val("").css({"color": "#555", "border-color": "#CCC"});
  $("#SapellidoModForm").val("").css({"color": "#555", "border-color": "#CCC"});
  $("#CapellidoModForm").val("").css({"color": "#555", "border-color": "#CCC"});

  $('#FinicioModForm').datepicker('update', '');
  $('#FfinalModForm').datepicker('update', '');

  $("#FinicioModForm").css({"color": "#555", "border-color": "#CCC"});
  $("#FfinalModForm").css({"color": "#555", "border-color": "#CCC"});

  $("#DiasModForm").val("").css({"color": "#555", "border-color": "#CCC"});
  $("#totalModForm").val("").css({"color": "#555", "border-color": "#CCC"});
  $("#NexpedienteMod").val("").css({"color": "#555", "border-color": "#CCC"});
  $("#PexoneraMod").val("").css({"color": "#555", "border-color": "#CCC"});
  $("#DexoneraMod").val("").css({"color": "#555", "border-color": "#CCC"});
  $("#TexoneraMod").val("").css({"color": "#555", "border-color": "#CCC"});

  $("#CmultaMod").hide();
  $("#CexoneraMod").hide();
  // Agrega Datos
  $('#idOrdenModificar').text(idOrden);
  $("#PnombreModForm").val($("#PnombreMod"+idOrden).text());
  $("#SnombreModForm").val($("#SnombreMod"+idOrden).text());
  $("#PapellidoModForm").val($("#PapellidoMod"+idOrden).text());
  $("#SapellidoModForm").val($("#SapellidoMod"+idOrden).text());
  $("#CapellidoModForm").val($("#CapellidoMod"+idOrden).text());

  if ($("#FechaInicioMod"+idOrden).text()!="") {
    $('#FinicioModForm').datepicker('update', $("#FechaInicioMod"+idOrden).text());
    $('#FfinalModForm').datepicker('update', $("#FechaFinalMod"+idOrden).text());
    // $("#FinicioModForm").val($("#FechaInicioMod"+idOrden).text());
    // $("#FfinalModForm").val($("#FechaFinalMod"+idOrden).text());
    $("#DiasModForm").val($("#DiasMod"+idOrden).text());
    $("#totalModForm").val($("#DiasMod"+idOrden).text()*10);
    $("#CmultaMod").show();

    if ($("#expedienteMod"+idOrden).text()!="") {
      $("#NexpedienteMod").val($("#expedienteMod"+idOrden).text());
      $("#PexoneraMod").val($("#exoneraMod"+idOrden).text());
      var total = $('#totalModForm').val();
      var porcen = $('#PexoneraMod').val();
      var desc = total*(porcen/100);
      var totaOrn = total-desc;
      $('#DexoneraMod').val(desc.toFixed(2));
      $('#TexoneraMod').val(totaOrn.toFixed(2));
      $("#CexoneraMod").show();
    }
  }
  $("#modOrden").slideDown("slow");
  $("#tblOrden").slideUp("slow");
  $("html, body").animate({ scrollTop: 0 }, "slow");
  cargarOrden(idOrden);
}

function cargarOrden (ordenID) {  
  $( "body" ).data( "PnombreModForm", $.trim($("#PnombreModForm").val()));
  $( "body" ).data( "SnombreModForm", $.trim($("#SnombreModForm").val()));
  $( "body" ).data( "PapellidoModForm", $.trim($("#PapellidoModForm").val()));
  $( "body" ).data( "SapellidoModForm", $.trim($("#SapellidoModForm").val()));
  $( "body" ).data( "CapellidoModForm", $.trim($("#CapellidoModForm").val()));
  $( "body" ).data( "FinicioModForm", $.trim($("#FechaInicioMod"+ordenID).text()));
  $( "body" ).data( "FfinalModForm", $.trim($("#FechaFinalMod"+ordenID).text()));
  $( "body" ).data( "DiasModForm", $("#DiasModForm").val());
  $( "body" ).data( "totalModForm", $("#totalModForm").val());
  $( "body" ).data( "NexpedienteMod", $("#NexpedienteMod").val());
  $( "body" ).data( "PexoneraMod", $("#PexoneraMod").val());
  $( "body" ).data( "DexoneraMod", $("#DexoneraMod").val());
  $( "body" ).data( "TexoneraMod", $("#TexoneraMod").val());
  $("#FinicioModForm").css({"color": "#555", "border-color": "#CCC"});
  $("#FfinalModForm").css({"color": "#555", "border-color": "#CCC"});
}

function anularOrden(op){
  $('#confirm').modal({ backdrop: 'static', keyboard: false })
  .one('click', '#anular', function (e) {
    var datAnular = "fun=3&OrdenAnular="+op;
    var url = "ordenpago/funcion_ordenpago.php";
    $.ajax({
      type: "POST",
      url: url,
      data: datAnular,
      success: function(data)
      {
        console.log(data);
        var jorden = JSON.parse(data);
        switch(jorden.case){
            case 1:
              $("#respBuscar").html(jorden.message);
            break;
            case 2:
              $("#estado"+op).removeClass("label-success").addClass("label-danger");
              $("#mod"+op).attr('disabled','disabled');
              $("#imp"+op).attr('disabled','disabled');
              $("#anu"+op).attr('disabled','disabled');
              $("#estado"+op).text("ANULADO");
              $.bootstrapGrowl("<h4 class='text-center' style='margin-top:1px;margin-bottom:-3px;'>Orden de Pago No."+op+" Anulada!</h4>", {
                type: 'info',
                width: '500',
                offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
                delay: 3000,
                stackup_spacing: 10
              });
            break;
        }
      }
    });
  });
}

function imprimirOrden(op){
  $('#confReimp').modal({ backdrop: 'static', keyboard: false })
  .one('click', '#reimprimir', function (e) {
  
    var datImpr = "fun=4&OrdenImpr="+op;
    var url = "ordenpago/funcion_ordenpago.php";
    $.ajax({
      type: "POST",
      url: url,
      data: datImpr,
      success: function(data)
      {
        console.log(data);
        var jorden = JSON.parse(data);
        switch(jorden.case){
            case 1:
              $("#respBuscar").html(jorden.message);
            break;
            case 2:
              printOrden(jorden.message);
            break;
        }
      }
    });

  });
}
function printOrden (datos) {
  var dat = datos;
  $.ajax({
    type: "POST",
    url: "ordenpago/printOrdenPago.php",
    data: dat,
    success: function(data)
    {
      $("#consultaOrden").html(data);
      $("#consultaOrden").printArea();
      
      setTimeout(function() {
          $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>ORDEN DE PAGO</strong> Impresa!</h3>", {
            type: 'success',
            width: '500',
            offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
            delay: 4000,
            stackup_spacing: 10
          });
        setTimeout ("redirection('?ac=ordenpago')", 3000);
      }, 3000);
      setTimeout(function() {
        window.location = '?ac=ordenpago';
      },3000)
    }
  });  
}

function atrasBusc() {
  $("html, body").animate({ scrollTop: 0 }, "slow");
  $("#respBuscar").html("");
  $("#bodyTable").html("");
  $("#tblOrden").slideUp("slow");
  $("#buscarOrden").slideDown("slow");
}
function atrasMod() {
  $("#tblOrden").slideDown("slow");
  $("#modOrden").slideUp("slow");
}

$(".FechaB").datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    autoclose: true,
    clearBtn: true,
    orientation: "top auto",
    endDate: '1d',
    todayHighlight: true,
});
$("#Finicio").datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    autoclose: true,
    orientation: "top auto",
    todayHighlight: true
});
$("#Ffinal").datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    autoclose: true,
    orientation: "top auto",
    todayHighlight: true
});
$("#FinicioModForm").datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    autoclose: true,
    orientation: "top auto",
    todayHighlight: true
});
$("#FfinalModForm").datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    autoclose: true,
    orientation: "top auto",
    todayHighlight: true
});


function calDiasMod () {
  var inicio = $('#FinicioModForm').datepicker('getDate');
  var fin   = $('#FfinalModForm').datepicker('getDate');
  console.log("inicio="+$('#FinicioModForm').val());
  console.log("fin="+$('#FfinalModForm').val());
  if ($('#FinicioModForm')==""){
    $('#FinicioModForm').focus();
    $('#FinicioModForm').tooltip('show');
  }else{
    if ($('#FfinalModForm')==""){
      $('#FfinalModForm').focus();
      $('#FfinalModForm').tooltip('show');
    }else{
      var Fdel = $('#FinicioModForm').val().split("-");
      var date1 = new Date(Fdel[2], Fdel[1], Fdel[0]);
      var Fal = $('#FfinalModForm').val().split("-");
      var date2 = new Date(Fal[2], Fal[1], Fal[0]);

      if (date1>date2) {
        // $('#FinalModForm').val('');
        $('#FfinalModForm').tooltip('show');
        $.bootstrapGrowl("<h5 class='text-center' style='margin-top:1px;margin-bottom:-3px;'>Debe ingresar una fecha posterior al <strong>"+$('#FinicioModForm').val()+"</strong>!</h5>", {
            type: 'danger',
            width: '500',
            offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
            stackup_spacing: 10
        });
        $('#DiasModForm').val("");
        $('#totalModForm').val("");
      }else{
        var dias   = ((fin - inicio)/1000/60/60/24)+1;
        if (dias>0) {
          $('#DiasModForm').val(dias);
          $('#totalModForm').val((dias*10).toFixed(2));
        }
      }
    }
  }
}



function VerDias () {
  var inicio = $('#FechaBdel').datepicker('getDate');
  var fin   = $('#FechaBal').datepicker('getDate');

  if (inicio==null){
    $('#FechaBdel').focus();
    $('#FechaBdel').tooltip('show');
  }else{
    if (fin==null){
      $('#FechaBal').focus();
      $('#FechaBal').tooltip('show');
    }else{
      var Fdel = $('#FechaBdel').val().split("-");
      var date1 = new Date(Fdel[2], Fdel[1], Fdel[0]);
      var Fal = $('#FechaBal').val().split("-");
      var date2 = new Date(Fal[2], Fal[1], Fal[0]);

      if (date1>date2) {
        $('#FechaBal').val('');
        $('#FechaBal').tooltip('show');
        $.bootstrapGrowl("<h5 class='text-center' style='margin-top:1px;margin-bottom:-3px;'>Debe ingresar una fecha posterior al <strong>"+$('#FechaBdel').val()+"</strong>!</h5>", {
            type: 'danger',
            width: '500',
            offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
            stackup_spacing: 10
        });
      }else{
        var dias   = ((fin - inicio)/1000/60/60/24)+1;
        if (dias>0) {
          
        }
      }
    }
  }

}


function calDias () {
  var inicio = $('#Finicio').datepicker('getDate');
  var fin   = $('#Ffinal').datepicker('getDate');

  if (inicio==null){
    $('#Finicio').focus();
    $('#Finicio').tooltip('show');
  }else{
    if (fin==null){
      $('#Ffinal').focus();
      $('#Ffinal').tooltip('show');
    }else{
      var Fdel = $('#Finicio').val().split("-");
      var date1 = new Date(Fdel[2], Fdel[1], Fdel[0]);
      var Fal = $('#Ffinal').val().split("-");
      var date2 = new Date(Fal[2], Fal[1], Fal[0]);

      if (date1>date2) {
        $('#Ffinal').val('');
        $('#Ffinal').tooltip('show');
        $.bootstrapGrowl("<h5 class='text-center' style='margin-top:1px;margin-bottom:-3px;'>Debe ingresar una fecha posterior al <strong>"+$('#Finicio').val()+"</strong>!</h5>", {
            type: 'danger',
            width: '500',
            offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
            stackup_spacing: 10
        });
        $('#Dias').val("");
        $('#total').val("");
      }else{
        var dias   = ((fin - inicio)/1000/60/60/24)+1;
        if (dias>0) {
          $('#Dias').val(dias);
          $('#total').val((dias*10).toFixed(2));
        }
      }
    }
  }

}
$("#btnBuscarOrden").click(function(){
  var datBuscar = "";
  if($('#OrdenBuscar').val()!=""){
    tmpModal.showModal();
    datBuscar+="OrdenB="+$('#OrdenBuscar').val()+"&fun=2";
    var url = "ordenpago/funcion_ordenpago.php"; 
    $.ajax({
        type: "POST",
        url: url,
        data: datBuscar,
        success: function(data)
        {
          tmpModal.hideModal();
          console.log("Data----"+data);
          var jorden = JSON.parse(data);
          switch(jorden.case){
              case 1:
                $("#respBuscar").html(jorden.message);
                $('#OrdenBuscar').val("");
                $('#OrdenBuscar').focus();
              break;
              case 2:
                $("#respBuscar").html("");
                $("#bodyTable").html(jorden.fila);
                $("#buscarOrden").slideUp("slow");
                $("#tblOrden").slideDown("slow");
              break;
          }
        }
    });

  }else{
    if ($('#FechaBdel').val()!=""&&$('#FechaBal').val()!="") {
      tmpModal.showModal();
      if ($('#PnombreBuscar').val()!="") {
        datBuscar+="&Pnombre="+$('#PnombreBuscar').val().toUpperCase();
      }
      if ($('#PapellidoBuscar').val()!="") {
        datBuscar+="&Papellido="+$('#PapellidoBuscar').val().toUpperCase();
      }
      if ($('#SnombreBuscar').val()!="") {
        datBuscar+="&Snombre="+$('#SnombreBuscar').val().toUpperCase();
      }

      if ($('#SapellidoBuscar').val()!="") {
        datBuscar+="&Sapellido="+$('#SapellidoBuscar').val().toUpperCase();
      }
      datBuscar+="&FechaBdel="+$('#FechaBdel').val()+"&FechaBal="+$('#FechaBal').val();
      datBuscar+="&fun=2";
      console.log("DAtos=="+datBuscar);
      var url = "ordenpago/funcion_ordenpago.php";
      $.ajax({
          type: "POST",
          url: url,
          data: datBuscar,
          success: function(data)
          {
            tmpModal.hideModal();
            console.log("Data----"+data);
            var jorden = JSON.parse(data);
            switch(jorden.case){
                case 1:
                  $("#respBuscar").html(jorden.message);
                  $('#OrdenBuscar').val("");
                  $('#OrdenBuscar').focus();
                break;
                case 2:
                  if (jorden.fila=="") {
                    $.bootstrapGrowl("<h4 class='text-center' style='margin-top:1px;margin-bottom:-3px;'>No se ha encontrado ningun registro con los datos proporcionados!</h4>", {
                      type: 'danger',
                      width: '500',
                      offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
                      delay: 3000,
                      stackup_spacing: 10
                    });
                  }else{
                    $("#respBuscar").html("");
                    $("#bodyTable").html(jorden.fila);
                    $("#buscarOrden").slideUp("slow");
                    $("#tblOrden").slideDown("slow");
                  }
                break;
            }
          }
      });

    }else{
      if($('#PnombreBuscar').val()==""){
        $('#PnombreBuscar').focus();
        $('#PnombreBuscar').tooltip('show');
      }else{
        if($('#PapellidoBuscar').val()==""){
          $('#PapellidoBuscar').focus();
          $('#PapellidoBuscar').tooltip('show');
        }else{
          datBuscar = "Pnombre="+$('#PnombreBuscar').val().toUpperCase()+"&Papellido="+$('#PapellidoBuscar').val().toUpperCase();
          if ($('#FechaBdel').val()!=""&&$('#FechaBal').val()!="") {
            datBuscar+="&FechaBdel="+$('#FechaBdel').val()+"&FechaBal="+$('#FechaBal').val();
            if ($('#SnombreBuscar').val()!="") {
              datBuscar+="&Snombre="+$('#SnombreBuscar').val().toUpperCase();
            }

            if ($('#SapellidoBuscar').val()!="") {
              datBuscar+="&Sapellido="+$('#SapellidoBuscar').val().toUpperCase();
            }
            datBuscar+="&fun=2";
            // console.log("DAtos=="+datBuscar);
            tmpModal.showModal();
            var url = "ordenpago/funcion_ordenpago.php";
            $.ajax({
                type: "POST",
                url: url,
                data: datBuscar,
                success: function(data)
                {
                  tmpModal.hideModal();
                  var jorden = JSON.parse(data);
                  switch(jorden.case){
                      case 1:
                        $("#respBuscar").html(jorden.message);
                        $('#OrdenBuscar').val("");
                        $('#OrdenBuscar').focus();
                      break;
                      case 2:
                        if (jorden.fila=="") {
                            $.bootstrapGrowl("<h4 class='text-center' style='margin-top:1px;margin-bottom:-3px;'>No se ha encontrado ningun registro con los datos proporcionados!</h4>", {
                              type: 'danger',
                              width: '500',
                              offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
                              delay: 3000,
                              stackup_spacing: 10
                            });
                          }else{
                            $("#respBuscar").html("");
                            $("#bodyTable").html(jorden.fila);
                            $("#buscarOrden").slideUp("slow");
                            $("#tblOrden").slideDown("slow");
                          }
                      break;
                  }
                }
            });
          }else{
            if ($('#FechaBdel').val()!=""&&$('#FechaBal').val()==""){
              $('#FechaBal').focus();
              $('#FechaBal').tooltip('show');
            }else if ($('#FechaBdel').val()==""&&$('#FechaBal').val()!=""){
              $('#FechaBdel').focus();
              $('#FechaBdel').tooltip('show');
            }else if ($('#FechaBdel').val()==""&&$('#FechaBal').val()==""){
              
              if ($('#SnombreBuscar').val()!="") {
                datBuscar+="&Snombre="+$('#SnombreBuscar').val().toUpperCase();
              }

              if ($('#SapellidoBuscar').val()!="") {
                datBuscar+="&Sapellido="+$('#SapellidoBuscar').val().toUpperCase();
              }
              datBuscar+="&fun=2";
              // console.log("DAtos2=="+datBuscar);
              tmpModal.showModal();
              var url = "ordenpago/funcion_ordenpago.php";
              $.ajax({
                  type: "POST",
                  url: url,
                  data: datBuscar,
                  success: function(data)
                  {
                    // console.log("Data----"+data);
                    tmpModal.hideModal();
                    var jorden = JSON.parse(data);
                    switch(jorden.case){
                        case 1:
                          $("#respBuscar").html(jorden.message);
                          $('#OrdenBuscar').val("");
                          $('#OrdenBuscar').focus();
                        break;
                        case 2:
                          if (jorden.fila=="") {
                            $.bootstrapGrowl("<h4 class='text-center' style='margin-top:1px;margin-bottom:-3px;'>No se ha encontrado ningun registro con los datos proporcionados!</h4>", {
                              type: 'danger',
                              width: '500',
                              offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
                              delay: 3000,
                              stackup_spacing: 10
                            });
                          }else{
                            $("#respBuscar").html("");
                            $("#bodyTable").html(jorden.fila);
                            $("#buscarOrden").slideUp("slow");
                            $("#tblOrden").slideDown("slow");
                          }
                        break;
                    }
                  }
              });
            }

          }
        }
      }
    }
  }
});
//Post guardar datos y realizar impresion
var datos="";
$("#btn_guardar").click(function(){
  //alert("Guardar");
   var bar = "<div class='progress'><div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='45' aria-valuemin='0' aria-valuemax='100' style='width: 1%'></div></div>";
  $( ".modal-header" ).html("");
  $( ".ConfData" ).html(bar);
  $( ".modal-footer" ).html("");
  datos+="&fun=1";
  console.log(datos);
  $('.progress-bar').css('width','50%');
  var url = "ordenpago/funcion_ordenpago.php"; 
    $.ajax({
        type: "POST",
        url: url,
        data: datos,
        success: function(data)
        {
          console.log("ssss="+data);
          var jorden = JSON.parse(data);
          switch(jorden.case){
              case 1:
                $("#respOrden").html(jorden.message);
              break;
              case 2:
                $('.progress-bar').css('width','100%');
                pOrden(jorden.message);
                $("#ModalConfirm").modal('hide');
              break;
          }
        },
        error: function() {
          // Error 
        }
    });
    return false;


});
//Imprime orden de pago
function pOrden (datos) {
  var dat = datos;
  $.ajax({
    type: "POST",
    url: "ordenpago/printOrdenPago.php",
    data: dat,
    success: function(data)
    {
      $("#ordenPago").html(data);
      $("#ordenPago").printArea();
      
      setTimeout(function() {
          $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>ORDEN DE PAGO</strong> Generada e Impresa!</h3>", {
            type: 'success',
            width: '500',
            offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
            delay: 4000,
            stackup_spacing: 10
          });
        setTimeout ("redirection('?ac=ordenpago')", 3000);
      }, 3000);
      // setTimeout(function() {
      //   window.location = '?ac=ordenpago';
      // },3000)
    }
  });  
}
function redirection(dir){  
  window.location=dir;
}

//Verificacion de los datos y desplega modal
$("#btn_confirm").click(function(){
  var list="";
  datos="";
  valido = true;
  if($('#Pnombre').val()==""){
    $('#Pnombre').focus();
    $('#Pnombre').tooltip('show');
  }else{
    list+="<li class='list-group-item'><dt>Primer Nombre:</dt><dd>"+$('#Pnombre').val().toUpperCase()+"</dd></li>";
    datos+="Pnombre="+$('#Pnombre').val().toUpperCase();
    if ($('#Snombre').val()!="") {
      list+="<li class='list-group-item'><dt>Segundo Nombre:</dt><dd>"+$('#Snombre').val().toUpperCase()+"</dd></li>";
      datos+="&Snombre="+$('#Snombre').val().toUpperCase();
    }
    if ($('#Papellido').val()=="") {
        $('#Papellido').focus();
        $('#Papellido').tooltip('show');
    }else{
      list+="<li class='list-group-item'><dt>Primer Apellido:</dt><dd>"+$('#Papellido').val().toUpperCase()+"</dd></li>";
      datos+="&Papellido="+$('#Papellido').val().toUpperCase();
      if ($('#Sapellido').val()!="") {
          list+="<li class='list-group-item'><dt>Segundo Apellido:</dt><dd>"+$('#Sapellido').val().toUpperCase()+"</dd></li>";
          datos+="&Sapellido="+$('#Sapellido').val().toUpperCase();
      }
      if ($('#Capellido').val()!="") {
          list+="<li class='list-group-item'><dt>Apellido de Casada:</dt><dd>"+$('#Capellido').val().toUpperCase()+"</dd></li>";
          datos+="&Capellido="+$('#Capellido').val().toUpperCase();
      }
      if ($("#cboNacionalidad").val()==0) {
        $('#cboNacionalidad').focus();
        $('#cboNacionalidad').tooltip('show');
      }else{
        list+="<li class='list-group-item'><dt>Nacionalidad:</dt><dd>"+$('#cboNacionalidad option:selected').text().toUpperCase()+"</dd></li>";
        datos+="&cboNacionalidad="+$("#cboNacionalidad").val();
        if ($("#cboTipoDoc").val()==0) {
          $('#cboTipoDoc').focus();
          $('#cboTipoDoc').tooltip('show');
        }else{
          list+="<li class='list-group-item'><dt>Tipo de Documento:</dt><dd>"+$('#cboTipoDoc option:selected').text().toUpperCase()+"</dd></li>";
          datos+="&cboTipoDoc="+$('#cboTipoDoc option:selected').text().toUpperCase();
          if ($("#NumDoc").val()=="") {
            $('#NumDoc').focus();
            $('#NumDoc').tooltip('show');
          }else{
            list+="<li class='list-group-item'><dt>Numero de Documento:</dt><dd>"+$("#NumDoc").val().toUpperCase()+"</dd></li>";
            datos+="&NumDoc="+$("#NumDoc").val().toUpperCase();
            if ($("#cboPais").val()==0) {
              $('#cboPais').focus();
              $('#cboPais').tooltip('show');
            }else{
              list+="<li class='list-group-item'><dt>Pais donde se <br>extendio el Documento:</dt><dd style='padding-top: 10px;'>"+$('#cboPais option:selected').text().toUpperCase()+"</dd></li>";
              datos+="&cboPais="+$("#cboPais").val();
              if ($("#LugarExtDoc").val()=="") {
                $('#LugarExtDoc').focus();
                $('#LugarExtDoc').tooltip('show');
              }else{
                list+="<li class='list-group-item'><dt>Lugar donde se <br>extendio el Documento:</dt><dd style='padding-top: 10px;'>"+$("#LugarExtDoc").val().toUpperCase()+"</dd></li>";
                datos+="&LugarExtDoc="+$("#LugarExtDoc").val().toUpperCase();
                if ($("#cboConcepto").val()==0) {
                  $('#cboConcepto').focus();
                  $('#cboConcepto').tooltip('show');
                }else{
                  list+="<li class='list-group-item'><dt>Concepto de Monto Fijo:</dt><dd>"+$('#cboConcepto option:selected').text()+"</dd></li>";
                  datos+="&cboConcepto="+$("#cboConcepto").val();
                  datos+="&NConcepto="+$('#cboConcepto option:selected').text();
                  //datos+="&VConcepto="+$('body').data($("#cboConcepto").val());
                  if ($("#cboConcepto").val()==1) {
                    if ($("#Finicio").val()=="") {
                      $('#Finicio').focus();
                      $('#Finicio').tooltip('show');
                    }else{
                      if ($("#Ffinal").val()=="") {
                        $('#Ffinal').focus();
                        $('#Ffinal').tooltip('show');
                      }else{
                        list+="<li class='list-group-item'><dt>Fecha Inicio - Final:</dt><dd>"+$("#Finicio").val()+" - "+$("#Ffinal").val()+"</dd></li>";
                        list+="<li class='list-group-item'><dt>Dias - Total:</dt><dd>"+$("#Dias").val()+" - Q."+$("#total").val()+"</dd></li>";
                        datos+="&VConcepto="+$("#total").val()+"&Finicio="+$("#Finicio").val()+"&Ffinal="+$("#Ffinal").val()+"&Dias="+$("#Dias").val()+"&total="+$("#total").val();
                        
                        if ($('#Cexonera').is(':visible')){
                          if ($("#Nexpediente").val()=="") {
                            $('#Nexpediente').focus();
                            $('#Nexpediente').tooltip('show');
                            valido = false;
                          }else{
                            if ($("#Pexonera").val()=="") {
                              $('#Pexonera').focus();
                              $('#Pexonera').tooltip('show');
                              valido = false;
                            }else{
                              list+="<li class='list-group-item'><dt>Expediente No.:</dt><dd>"+$("#Nexpediente").val().toUpperCase()+"</dd></li>";
                              list+="<li class='list-group-item'><dt>Porcentaje exoneración:</dt><dd>"+$("#Pexonera").val()+"%</dd></li>";
                              list+="<li class='list-group-item'><dt>Descuento:</dt><dd>Q."+$("#Dexonera").val()+"</dd></li>";
                              list+="<li class='list-group-item'><dt>Total Orden Pago:</dt><dd>Q."+$("#Texonera").val()+"</dd></li>";
                              datos+="&expediente="+$("#Nexpediente").val().toUpperCase()+"&Pexonera="+$("#Pexonera").val()+"&Dexonera="+$("#Dexonera").val()+"&Texonera="+$("#Texonera").val();
                            }
                          }
                        }

                        // datos+="&VConcepto="+$("#ValorConcepto").val();
                        if ($('#resolucion').val()!="") {
                          list+="<li class='list-group-item'><dt>Resolucion:</dt><dd>"+$('#resolucion').val()+"</dd></li>";
                          datos+="&resolucion="+$('#resolucion').val().toUpperCase();
                        }

                        if (valido) {
                          console.log(datos);
                          $( ".ConfData" ).html(list);
                          $("#ModalConfirm").modal('show');
                        }
                      }
                    }
                  }else{
                    if ($("#ValorConcepto").val()=="") {
                      $('#ValorConcepto').focus();
                      $('#ValorConcepto').tooltip('show');
                    }else{
                      list+="<li class='list-group-item'><dt>Valor Concepto:</dt><dd>"+$("#ValorConcepto").val()+"</dd></li>";
                      datos+="&VConcepto="+$("#ValorConcepto").val();
                      if ($('#resolucion').val()!="") {
                        list+="<li class='list-group-item'><dt>Resolucion:</dt><dd>"+$('#resolucion').val()+"</dd></li>";
                        datos+="&resolucion="+$('#resolucion').val().toUpperCase();
                      }
                      $( ".ConfData" ).html(list);
                      $("#ModalConfirm").modal('show');
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
 });

$(document).ready(function(){  
    $("#cboConcepto").change(function() {
        var concept = $(this).val();
        if(concept > 0)
        {
          if (concept==1) {
            $("#Vconcepto").fadeOut("slow");
            $("#Cmulta").slideDown("slow");
            $("html, body").animate({ scrollTop: 95 }, "slow");
            // $("#Vconcepto").hide();
          }else{
            $("#Vconcepto").fadeIn("slow");
            $("#Cmulta").slideUp("slow");
            $("#ValorConcepto").val($( 'body' ).data(concept));
            $('#ValorConcepto').prop('readonly', true);
            $("html, body").animate({ scrollTop: 30 }, "slow");
          }
        }
        else
        {
            $("#ValorConcepto").val("");
        }
    });
}); 
</script>


<?php 
}else{
  include 'login.php';
}

?>