<?php 
  require_once('res/funciones.php');
 ?>
<br>
<div class="col-xl-10 col-sm-10 col-md-10 col-md-offset-2">
  <div id="bc1" class="btn-group btn-breadcrumb">
      <a href="?ac=certificacion" id="bread1" class="btn btn-info"><div>1.- Tipo de Solicitud</div></a>
      <a href="#" id="bread2" class="btn btn-info"><div>2.- Datos Generales</div></a>
      <a href="#" id="bread3" class="btn btn-default"><div>3.- Confirmación</div></a>
      <a href="#" id="bread4" class="btn btn-default"><div>4.- Impresión</div></a>
  </div>
</div>
<br><br>

<div id="datosOficial">

  <div id="plConf" hidden>
    <div class="panel panel-danger">
      <div class="panel-heading">
        <h3 class="panel-title">Confirmación de Datos de la <strong>Certificación Oficial</strong></span>
        </h3>
      </div>
      <div id="panelbody" class="panel-body" style="padding-left: 0px;">

      </div>
      </div>
      <br>
      <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-0">
        <span class="pull-left">
          <button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="atrasOficial()">
            <span class="glyphicon glyphicon-chevron-left"></span>Atras
          </button>
        </span>
      </div>
      <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-2">
        <button type="button" id="btn_imprimirCertificacion"  class="btn btn-success btn-shadow" onclick="imprimirOficial()">
          <span style="font-size:1.5em;margin:0; padding:0;" class="glyphicon glyphicon-print"></span>
          <br>Imprimir Certificación
        </button>
      </div>
  </div>
  

  <div > 
    <div id="mdData" class="col-xl-12 col-sm-12 col-md-12 col-md-offset-1"> 
     <h3>
      <span class="label label-default">Datos Certificación Oficial:</span>
      </h3>
    </div>
    <br><br><br>     
    <div id="plData" class="col-xl-12 col-sm-12 col-md-12 ">
        <form method="post" id="FormOficial" >
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="NfolioEntrada" class="Colet">Folio de Entrada Numero: <span class="sm">(Campo Obligatorio)</span></label>
              <div class="input-group">
                <input type="number" class="form-control" id="NfolioEntrada" data-toggle="tooltip" data-placement="right" title="Ingresar Numero de Folio de Entrada" data-campo="NfolioEntrada" placeholder="Numero de Folio de Entrada" onkeypress="return checkSoloNum(event)" required autofocus>
                <div class="input-group-addon" id="NfolioEntradaAnio">-<?php echo date('Y'); ?></div>
              </div>
            </div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="FechaRedaccion">Fecha Redacción: <span class="sm">(Campo Obligatorio)</span></label>
              <div id="Fredaccion" class="input-group date">
                <input type="text" class="form-control" id="FechaRedaccion" data-toggle="tooltip" data-placement="top" title="Fecha de Redacción" data-campo="Fdeportacion" required readonly>
                <span id="Bredaccion" class="input-group-addon">
                  <i class="glyphicon glyphicon-calendar"></i>
                </span>
              </div>
            </div>
            <div class="form-group col-xl-12 col-sm-12 col-md-12">
              <label for="Asunto" class="Colet">Asunto: <span class="sm">(Campo Obligatorio)</span></label>
              <div class="input-group">
                <select id="cboAsunto"  num="" class="form-control" data-toggle="tooltip" data-placement="top" title="Seleccione Asunto de la Certificación" data-campo="Asunto" >
                  <option value="0">SELECCIONAR...</option>
                  <?php
                    $asuntos = obtenerAsunto();
                    foreach ($asuntos as $asunto) { 
                        echo '<option value="'.$asunto->id.'" title="Cargo:'.$asunto->cargo.'||Asunto:'.$asunto->asunto.'||Dependencia:'.$asunto->dependencia.'">'.$asunto->nombre.'</option>';        
                    }
                  ?>
                </select>
                <!-- <input type="text" class="form-control" id="Asunto" data-toggle="tooltip" data-placement="right" title="Ingresar el Asunto de la Certificación" data-campo="Asunto" placeholder="Asunto de la Certificación" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required autofocus> -->
                <a style="cursor:pointer" id="addAsunto" class="input-group-addon" onclick="agregarAsunto();" title="Agregar Asunto">
                  <span >
                    <i class="glyphicon glyphicon-plus"></i>
                  </span>
                </a>
              </div>
            </div>

              <table id="tabla" class="table table-hover table-fixed col-xl-12 col-sm-12 col-md-12 Colet">
              <thead>
                <tr>
                  <th class="col-xl-1 col-sm-1 col-md-1" style="padding-left: 0px; padding-right: 0px;width: 46px;">
                    <span style="">#</span>
                  </th>
                  <th class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0px;margin-left: 5px;">Primer Nombre<span class="Colet">*</span></th>
                  <th class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0px;margin-left: 5px;">Segundo Nombre</th>
                  <th class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0px;margin-left: 5px;">Primer Apellido<span class="Colet">*</span></th>
                  <th class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0px;margin-left: 5px;">Segundo Apellido</th>
                  <th class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0px;margin-left: 5px;">Apellido de Casada</th>
                  <th class="col-xl-1 col-sm-1 col-md-1" style="padding-right: 0px;margin-left: 5px;">Movimiento<span class="Colet">*</span></th>
                </tr>
              </thead>

              <tbody>
                <tr id="fila1" name="fila" class="cont">
                  <td class="col-xl-2 col-sm-2 col-md-2" style="padding-left: 0px; padding-right: 0px;width: 46px;">
                    <span  class="close" id="1" style="font-size:28px;float: left;padding: 0;" >1</span>
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0px;">
                    <input type="text" name="Pnombre" class="form-control Pnombre" style="text-transform:uppercase;" id="Pnombre" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Nombre" data-campo="Pnombre" placeholder="Primer Nombre"  onkeypress="return validarLetras(event)" required autofocus>
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;">
                    <input type="text" name="Snombre" class="form-control" id="Snombre" placeholder="Segundo Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;">
                    <input type="text" name="Papellido" class="form-control Papellido" id="Papellido" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Apellido" placeholder="Primer Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;">
                    <input type="text" name="Sapellido" class="form-control" id="Sapellido" placeholder="Segundo Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
                  </td>
                  <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;">
                    <input type="text" name="Capellido" class="form-control" id="Capellido" placeholder="Apellido de Casada" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
                  </td>
                  <td class="col-xl-1 col-sm-1 col-md-1" style="padding-right: 0;">
                    <div class="col-xl-12 col-sm-12 col-md-12" style="padding-right: 0;padding-left: 0;width: 102px;">
                      <div id="chekMovimiento" name="chekMovimiento" class="btn-group chekMovimiento" data-toggle="buttons" style="padding-left:0;padding-right:0;margin-right: -1em;" data-toggle="tooltip" data-placement="bottom" title="Tiene Movimiento Migratorio" data-campo="chekMovimiento">
                        <a class="btn btn-primary checkSI" style="font-weight: bold;" onclick="checkMov(checkSI)">
                            <input id="checkSI" num=""  type="radio" name="chekMovimiento" value="SI" >SI
                        </a>
                        <a class="btn btn-primary checkNO" style="font-weight: bold;" onclick="checkMov(checkNO)">
                            <input id="checkNO" num=""  type="radio" name="chekMovimiento" value="NO">NO
                        </a>
                      </div>
                      <button type="button" class="close" aria-hidden="true" style="margin-right:-0.1em;font-size:30px;" title="Eliminar" onclick="eliminarFila(1)">&times;</button>
                    </div>
                    
                  </td>
                </tr>
                <tr class="op" id="filb1">
                  <td class="op" colspan="7">
                    <div id="Mtrue" class="col-xl-12 col-sm-12 col-md-12 well" hidden>
                      <span class="pull-right dropup">
                        <a class="btn btn-default dropdown-toggle" onclick="ocultar(Mtrue)">
                          <span class="caret"></span>
                        </a>
                      </span>
                      <div class="form-group col-xl-4 col-sm-4 col-md-4" style="margin-top:1.7em;">
                        <label for="Nfolio">Numero de Folio(s): <span class="sm">(Campo Obligatorio)</span></label>
                        <input type="number" class="form-control" id="Nfolio" data-toggle="tooltip" data-placement="top" title="Ingresar Numero de Folio(s) del Reporte" data-campo="Nfolio" placeholder="Numero de Folio(s) del Reporte" onkeypress="return checkSoloNum(event)" required>
                      </div>
                      <div class="form-group col-xl-7 col-sm-7 col-md-7" style="padding-right:0;">
                        <label for="Durante" class="Colet" style="margin-left: 13em;">Durante el Periodo</label><br>
                        <label for="Del" class="Colet" style="padding-right:18.5em;">Del:</label>
                        <label for="Al"  class="Colet">Al:</label>
                        <div class="input-group ">
                          <input type="text" readonly class="input-group date form-control text-center" id="DuranteDel" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                            <span class="input-group-addon">AL</span>
                          <input type="text" readonly class="input-group date form-control text-center" id="DuranteAl" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                        </div>
                      </div>
                    </div>
                    <div id="Mfalse" class="col-xl-12 col-sm-12 col-md-12 well" hidden>
                      <span class="pull-right dropup">
                        <a class="btn btn-default dropdown-toggle" onclick="ocultar(Mfalse)">
                          <span class="caret"></span>
                        </a>
                      </span>
                      <legend><span class="Colet">Negativa</span></legend>
                      <div class="col-xl-6 col-sm-6 col-md-6" style="margin-top:1.7em;">
                        <div class="form-group col-xl-12 col-sm-12 col-md-12">
                          <label for="Negativa" >Tipo de Negativa: <span class="sm">(Campo Obligatorio)</span></label>
                          <select id="cboNegativa"  num="" onblur="cboNegativaCambio(cboNegativa, value)" class="form-control cboNegativa" data-toggle="tooltip" data-placement="top" title="Seleccione Tipo de Negativa">
                            <option value="0">SELECCIONAR...</option>
                            <option value="1" onclick="cboNegativaCambio(cboNegativa, 1)">NEGATIVA</option>
                            <option value="2" onclick="cboNegativaCambio(cboNegativa, 2)">NEGATIVA COMÚN</option>
                            <option value="3" onclick="cboNegativaCambio(cboNegativa, 3)">NEGATIVA SOLICITUD DE DATOS</option>
                          </select>
                        </div>
                        <div id="Dsolicitud" class="form-group col-xl-12 col-sm-12 col-md-12" hidden>
                          <label for="Dsolicitud">Datos a solicitar: <span class="sm">(Campo Obligatorio)</span></label>
                          <input type="text" class="form-control" id="txtsolicitud" placeholder="EJ. FAVOR ENVIAR FECHA DE NACIMIENTO..." data-toggle="tooltip" data-placement="top" title="Datos a solicitar" data-campo="Dsolicitud" style="text-transform:uppercase;" required>
                        </div>
                      </div>
                      <div class="form-group col-xl-6 col-sm-6 col-md-6" style="padding-right:0;">
                        <label for="Durante" class="Colet" style="margin-left: 11em;">Durante el Periodo</label><br>
                        <label for="Del" class="Colet" style="padding-right:18.5em;">Del:</label>
                        <label for="Al"  class="Colet">Al:</label>
                        <div class="input-group ">
                          <input type="text" readonly class="input-group date form-control text-center" id="NegDuranteDel" data-toggle="tooltip" data-placement="bottom" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                            <span class="input-group-addon">AL</span>
                          <input type="text" readonly class="input-group date form-control text-center" id="NegDuranteAl" data-toggle="tooltip" data-placement="bottom" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>

              </tbody>
              </table>

          <span class="pull-left sm">( * Campos Obligatorios)</span>
          <div class="dropup" style="float:left;position:relative;left:29%;">
            <a class="btn btn-default dropdown-toggle" onclick="minim()" style="padding: 0px 5em; font-size: 11px;">
              <span class="caret"></span>
            </a>
          </div>
          <span class="pull-right">
            <button type="button" class="btn btn-default" onclick="addFila()">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar
            </button>
          </span>
          <div id="btn_guardarP" class="col-xl-6 col-sm-6 col-md-6 col-md-offset-5" style="top:2em;">
            <button style="padding:0.5em 1.5em;" type="button" id="btn_oficial"  class="btn btn-primary btn-lg btn-shadow" >
              <span class="glyphicon glyphicon-floppy-disk"></span><br>
              Guardar
            </button> 
          </div>
        </form>
    </div>
  </div>

</div>

<div id="respOficial" class="col-xl-12 col-sm-12 col-md-12" style="margin-top:3em;">

</div>
<div id="respOficial1" class="col-xl-12 col-sm-12 col-md-12" style="margin-top:3em;">
	
</div>


<!-- Modal de Agregar Asunto -->
<div id="ModalAsunto" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div id="pnladdAsunto">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title Colet" style="font-weight: 700;">Agregar Nuevo Asunto</h4>
        </div>
        <div class="modal-body">
          <form method="post" id="FormModalAsunto" >
            <div class="form-group">
              <label for="Anombre" class="Colet">Nombre: <span class="sm">(Campo Obligatorio)</span></label>
              <input type="text" class="form-control" id="Anombre" data-toggle="tooltip" data-placement="right" title="Ingresar Nombre" data-campo="Pnombre" placeholder="Ingresar Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required autofocus>
            </div>
            <div class="form-group ">
              <label for="Acargo" class="Colet">Cargo: <span class="sm">(Campo Obligatorio)</span></label>
              <input type="text" class="form-control" id="Acargo" data-toggle="tooltip" data-placement="right" title="Ingresar Cargo" data-campo="Pnombre" placeholder="Ingresar Cargo" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
            </div>
            <div class="form-group ">
              <label for="Adependencia" class="Colet">Dependencia: <span class="sm">(Campo Obligatorio)</span></label>
              <input type="text" class="form-control" id="Adependencia" data-toggle="tooltip" data-placement="right" title="Ingresar Dependencia" data-campo="Pnombre" placeholder="Ingresar Dependencia" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
            </div>
            <div class="form-group">
              <label for="Asunto" class="Colet">Asunto: </label>
              <textarea class="form-control" rows="5" id="Asunto" style="text-transform:uppercase;" placeholder="Ingresar Asunto"></textarea>
            </div>
          </form> 
        </div>
          <div class="modal-footer">
            <div class="pull-left" id="opModAsunto">
              <button id="btnModAsunto" type="button" class="btn btn-default">
              <span class="glyphicon glyphicon-pencil"></span>
                Modificar Asunto
            </button>
            </div>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button id="btn_addAsunto" type="button" class="btn btn-success">
              <span class="glyphicon glyphicon-floppy-save"></span>
              Guardar
            </button>
          </div>
      </div>
      <div id="pnlModAsunto" hidden>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title Colet" style="font-weight: 700;">Modificar Asunto</h4>
        </div>
        <div class="modal-body">
          <table id="tablaAsunto" class="table table-hover"> <!-- table-bordered -->
            <thead>
              <tr>
                <th class="col-xl-3 col-sm-3 col-md-3 Colet" >Nombre</th>
                <th class="col-xl-2 col-sm-2 col-md-2 Colet" >Cargo</th>
                <th class="col-xl-2 col-sm-2 col-md-2 Colet" >Dependencia</th>
                <th class="col-xl-4 col-sm-4 col-md-4 Colet" >Asunto</th>
                <th class="col-xl-1 col-sm-1 col-md-1 Colet" >Acción</th>
              </tr>
            </thead>
            <tbody id="AsuntobodyTable">
              <?php
                echo DatosAsunto();
              ?>
            </tbody>
          </table>
          <form method="post" id="ModAsunto" hidden>
            <div id="idAsuntoMod" hidden></div>
            <div class="form-group">
              <label for="Anombre" class="Colet">Nombre: <span class="sm">(Campo Obligatorio)</span></label>
              <input type="text" onchange="mAsunto(this);" class="form-control" id="AnombreMod" data-toggle="tooltip" data-placement="right" title="Ingresar Nombre" data-campo="Pnombre" placeholder="Ingresar Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required autofocus>
            </div>
            <div class="form-group ">
              <label for="Acargo" class="Colet">Cargo: <span class="sm">(Campo Obligatorio)</span></label>
              <input type="text" onchange="mAsunto(this);" class="form-control" id="AcargoMod" data-toggle="tooltip" data-placement="right" title="Ingresar Cargo" data-campo="Pnombre" placeholder="Ingresar Cargo" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
            </div>
            <div class="form-group ">
              <label for="Adependencia" class="Colet">Dependencia: <span class="sm">(Campo Obligatorio)</span></label>
              <input type="text" onchange="mAsunto(this);" class="form-control" id="AdependenciaMod" data-toggle="tooltip" data-placement="right" title="Ingresar Dependencia" data-campo="Pnombre" placeholder="Ingresar Dependencia" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
            </div>
            <div class="form-group">
              <label for="Asunto" class="Colet">Asunto: </label>
              <textarea class="form-control" onchange="mAsunto(this);" rows="5" id="AsuntoMod" style="text-transform:uppercase;" placeholder="Ingresar Asunto"></textarea>
            </div>
          </form> 
        </div>
        <div class="modal-footer">
            <div class="pull-left" id="opaddAsunto">
              <button id="btnadAsunto" type="button" class="btn btn-default">
              <span class="glyphicon glyphicon-plus"></span>
                Agregar Asunto
            </button>
            </div>
            <div class="pull-left" id="opAtras" hidden>
              <button id="btnModAtras" type="button" class="btn btn-default">
              <span class="glyphicon glyphicon-chevron-left"></span>
                Atras
            </button>
            </div>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button id="ModAsun" type="button" class="btn btn-success" disabled>
              <span class="glyphicon glyphicon-floppy-save"></span>
              Guardar
            </button>
        </div>
      </div>

    </div>
  </div>
</div>


<script>
function mAsunto(dat) {
  if ($( "body" ).data(dat.id)!=$("#"+dat.id).val().toUpperCase()) {
    $("#"+dat.id).css({"color": "red", "border-color": "red"});

  }else{
    $("#"+dat.id).css({"color": "#555", "border-color": "#CCC"});
  }
}

function modificarA(asuntoID) {
  
  $("#idAsuntoMod").text(asuntoID);
  $("#AnombreMod").val($("#nombre"+asuntoID).text()).css({"color": "#555", "border-color": "#CCC"});
  $("#AcargoMod").val($("#cargo"+asuntoID).text()).css({"color": "#555", "border-color": "#CCC"});
  $("#AdependenciaMod").val($("#dependencia"+asuntoID).text()).css({"color": "#555", "border-color": "#CCC"});
  $("#AsuntoMod").val($("#asunto"+asuntoID).text()).css({"color": "#555", "border-color": "#CCC"});
  $("#ModAsunto").slideDown('slow');
  $("#tablaAsunto").hide();
  $("#opAtras").show();
  $("#opaddAsunto").hide();
  $("#ModAsun").removeAttr('disabled');
  cargarAsunto(asuntoID);
}

function cargarAsunto (asuntoID) {  
  $( "body" ).data( "AnombreMod", $("#nombre"+asuntoID).text());
  $( "body" ).data( "AcargoMod", $("#cargo"+asuntoID).text());
  $( "body" ).data( "AdependenciaMod", $("#dependencia"+asuntoID).text());
  $( "body" ).data( "AsuntoMod", $("#asunto"+asuntoID).text());
}

$("#btnModAtras").click(function(){
  $("#ModAsun").attr("disabled", "disabled");
  $("#tablaAsunto").slideDown('slow');
  $("#ModAsunto").hide();
  $("#opaddAsunto").show();
  $("#opAtras").hide();
});

$("#btnModAsunto").click(function(){
  $("#pnlModAsunto").slideDown('slow');
  $("#pnladdAsunto").slideUp('slow');
  
});
$("#btnadAsunto").click(function(){
  $("#pnladdAsunto").slideDown('slow');
  $("#pnlModAsunto").slideUp('slow');
});


$("#ModAsun").click(function(){
  if($('#AnombreMod').val()==""){
    $('#AnombreMod').focus();
    $('#AnombreMod').tooltip('show');
  }else{
    if ($('#AcargoMod').val()=="") {
      $('#AcargoMod').focus();
      $('#AcargoMod').tooltip('show');
    }else{
      if ($('#AdependenciaMod').val()=="") {
      $('#AdependenciaMod').focus();
      $('#AdependenciaMod').tooltip('show');
      }else{
        if ($( "body" ).data("AnombreMod")!=$("#AnombreMod").val().toUpperCase()||$( "body" ).data("AcargoMod")!=$("#AcargoMod").val().toUpperCase()||$( "body" ).data("AdependenciaMod")!=$("#AdependenciaMod").val().toUpperCase()||$( "body" ).data("AsuntoMod")!=$("#AsuntoMod").val().toUpperCase()) {        
          var datos = "idAsunto="+$("#idAsuntoMod").text()+"&Anombre="+$("#AnombreMod").val().toUpperCase()+"&Acargo="+$("#AcargoMod").val().toUpperCase()+"&Adependencia="+$("#AdependenciaMod").val().toUpperCase()+"&Asunto="+$("#AsuntoMod").val().toUpperCase();
          
          datos += "&fun=14";
          console.log(datos);
          var url = "certificacion/funcion_certificacion.php"; 
          $.ajax({
            type: "POST",
            url: url,
            data: datos,
            success: function(data)
            {
              console.log(data);
              var jorden = JSON.parse(data);
              switch(jorden.case){
                case 1:
                  $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>Asunto</strong> Modificado correctamente!</h3>", {
                    type: 'success',
                    width: '500',
                    offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
                    stackup_spacing: 10
                  });
                  $("#ModalAsunto").modal('hide');
                  setTimeout ("redirection('?ac=certificacion&tipo=oficial')", 2000);
                break;
                case 2:
                  $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>Error al guardar el asunto</strong></h3>", {
                    type: 'danger',
                    width: '500',
                    offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
                    stackup_spacing: 10
                  });
                break;
                case 3:
                  $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>Error al realizar la transaccion</strong></h3>", {
                    type: 'danger',
                    width: '500',
                    offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
                    stackup_spacing: 10
                  });
                  $("#ModalAsunto").modal('hide');
                break;

              }
            }
          });
          return false;

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
  }

});



$("#btn_addAsunto").click(function(){
  if($('#Anombre').val()==""){
    $('#Anombre').focus();
    $('#Anombre').tooltip('show');
  }else{
    if ($('#Acargo').val()=="") {
      $('#Acargo').focus();
      $('#Acargo').tooltip('show');
    }else{
      if ($('#Adependencia').val()=="") {
      $('#Adependencia').focus();
      $('#Adependencia').tooltip('show');
      }else{
        var datos = "Anombre="+$.trim($("#Anombre").val().toUpperCase())+"&Acargo="+$.trim($("#Acargo").val().toUpperCase())+"&Adependencia="+$.trim($("#Adependencia").val().toUpperCase());
        
        if ($('#Asunto').val()!="") {
          datos += "&Asunto="+$.trim($("#Asunto").val().toUpperCase());
        }

        datos += "&fun=13";
        // console.log(datos);
        var url = "certificacion/funcion_certificacion.php"; 
        $.ajax({
          type: "POST",
          url: url,
          data: datos,
          success: function(data)
          {
            console.log(data);
            var jorden = JSON.parse(data);
            switch(jorden.case){
              case 1:
                $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>Asunto</strong> Guardado correctamente!</h3>", {
                  type: 'success',
                  width: '500',
                  offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
                  stackup_spacing: 10
                });
                $("#ModalAsunto").modal('hide');
                setTimeout ("redirection('?ac=certificacion&tipo=oficial')", 2000);
              break;
              case 2:
                $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>Error al guardar el asunto</strong></h3>", {
                  type: 'danger',
                  width: '500',
                  offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
                  stackup_spacing: 10
                });
              break;
              case 3:
                $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>Error al realizar la transaccion</strong></h3>", {
                  type: 'danger',
                  width: '500',
                  offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
                  stackup_spacing: 10
                });
                $("#ModalAsunto").modal('hide');
              break;

            }
          }
        });
        return false; 
      }
    }
  }

});
function agregarAsunto() {
  $("#ModalAsunto").modal('show');
}

$(".input-group.date").datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    autoclose: true,
    orientation: "top auto",
    endDate: '1d',
    clearBtn: true,
    todayHighlight: true,
});
function cargarDate () {
  $(".input-group.date").datepicker({
      format: "dd-mm-yyyy",
      language: "es",
      autoclose: true,
      orientation: "top auto",
      endDate: '1d',
      clearBtn: true,
      todayHighlight: true,
  });
}

$("#FechaRedaccion").datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    autoclose: true,
    orientation: "top auto",
    startDate: '-6d',
    endDate: '1d',
    todayHighlight: true,
});

$( document ).ready(function() {
  $('#FechaRedaccion').datepicker('update', fechaHoy());
  // $('#FechaRedaccion').val(fechaHoy());
});


function cboNegativaCambio(d, v) {
  var num = $(d).attr('num');
  var negativa = v;
  if(negativa == 3)
  {
    $( "#Dsolicitud"+num ).fadeIn("slow");
    $( "#txtsolicitud"+num ).focus();
  }else{
    $( "#Dsolicitud"+num ).fadeOut("slow");
  }
}

function checkMov(ch) {
  var num = $(ch).attr('num');
  // console.log(num);
  if(ch.value=='SI'){
    $( "#Mtrue"+num).slideDown("slow");
    $( "#Nfolio"+num).focus();
    $( "#Mfalse"+num).hide();
  } else if(ch.value=='NO') {
    $( "#Mfalse"+num).slideDown("slow");
    $( "#Mtrue"+num).hide();
  }
}

function ocultar(ocul) {
  $( "#"+ocul.id ).slideUp("slow");
}

function addFila () {
  var n = $('#tabla >tbody >.cont').length;
  i=1;
  $('#tabla >tbody >.cont').each(function () {
    $(this).find("td>span").eq(0).text(i);
    i++
  });

  n++; 
  var fila = '<tr id="fila'+n+'" name="fila" class="cont">\
                <td class="col-xl-2 col-sm-2 col-md-2" style="padding-left: 0px; padding-right: 0px;width: 46px;">\
                  <span id="'+n+'" class="close" style="font-size:28px;float: left;padding: 0;" >'+n+'</span>\
                </td>\
                <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0px;">\
                  <input type="text" name="Pnombre" class="form-control Pnombre" style="text-transform:uppercase;" id="Pnombre'+n+'" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Nombre" data-campo="Pnombre" placeholder="Primer Nombre"  onkeypress="return validarLetras(event)" required autofocus>\
                </td>\
                <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;">\
                  <input type="text" name="Snombre" class="form-control" id="Snombre'+n+'" placeholder="Segundo Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">\
                </td>\
                <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;">\
                  <input type="text" name="Papellido" class="form-control Papellido" id="Papellido'+n+'" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Apellido" placeholder="Primer Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                </td>\
                <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;">\
                  <input type="text" name="Sapellido" class="form-control" id="Sapellido'+n+'" placeholder="Segundo Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">\
                </td>\
                <td class="col-xl-2 col-sm-2 col-md-2" style="padding-right: 0;">\
                  <input type="text" name="Capellido" class="form-control" id="Capellido'+n+'" placeholder="Apellido de Casada" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">\
                </td>\
                <td class="col-xl-1 col-sm-1 col-md-1" style="padding-right: 0;">\
                  <div class="col-xl-12 col-sm-12 col-md-12" style="padding-right: 0;padding-left: 0;width: 102px;">\
                    <div id="chekMovimiento'+n+'" name="chekMovimiento" class="btn-group chekMovimiento" data-toggle="buttons" style="padding-left:0;padding-right:0;margin-right: -1em;" data-toggle="tooltip" data-placement="bottom" title="Tiene Movimiento Migratorio" data-campo="chekMovimiento'+n+'">\
                      <a class="btn btn-primary checkSI"  style="font-weight: bold;" onclick="checkMov(checkSI'+n+')">\
                          <input id="checkSI'+n+'"  num="'+n+'" type="radio" name="chekMovimiento'+n+'" value="SI" >SI\
                      </a>\
                      <a class="btn btn-primary checkNO" style="font-weight: bold;" onclick="checkMov(checkNO'+n+')">\
                          <input id="checkNO'+n+'" num="'+n+'"  type="radio" name="chekMovimiento'+n+'" value="NO">NO\
                      </a>\
                    </div>\
                    <button type="button" class="close" aria-hidden="true" style="margin-right:-0.1em;font-size:30px;" title="Eliminar" onclick="eliminarFila('+n+')">&times;</button>\
                  </div>\
                </td>\
              </tr>\
              <tr class="op" id="filb'+n+'">\
                <td class="op" colspan="7">\
                  <div id="Mtrue'+n+'" class="col-xl-12 col-sm-12 col-md-12 well" hidden>\
                    <span class="pull-right dropup">\
                      <a class="btn btn-default dropdown-toggle" onclick="ocultar(Mtrue'+n+')">\
                        <span class="caret"></span>\
                      </a>\
                    </span>\
                    <div class="form-group col-xl-4 col-sm-4 col-md-4" style="margin-top:1.7em;">\
                        <label for="Nfolio">Numero de Folio(s): <span class="sm">(Campo Obligatorio)</span></label>\
                        <input type="number" class="form-control" id="Nfolio'+n+'" data-toggle="tooltip" data-placement="top" title="Ingresar Numero de Folio(s) del Reporte" data-campo="Nfolio" placeholder="Numero de Folio(s) del Reporte" onkeypress="return checkSoloNum(event)" required>\
                      </div>\
                      <div class="form-group col-xl-7 col-sm-7 col-md-7" style="padding-right:0;">\
                        <label for="Durante" class="Colet" style="margin-left: 13em;">Durante el Periodo</label><br>\
                        <label for="Del" class="Colet" style="padding-right:18.5em;">Del:</label>\
                        <label for="Al"  class="Colet">Al:</label>\
                        <div class="input-group ">\
                        <input type="text" readonly class="input-group date form-control text-center" id="DuranteDel'+n+'" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                          <span class="input-group-addon">AL</span>\
                        <input type="text" readonly class="input-group date form-control text-center" id="DuranteAl'+n+'" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                      </div>\
                    </div>\
                  </div>\
                  <div id="Mfalse'+n+'" class="col-xl-12 col-sm-12 col-md-12 well" hidden>\
                    <span class="pull-right dropup">\
                      <a class="btn btn-default dropdown-toggle" onclick="ocultar(Mfalse'+n+')">\
                        <span class="caret"></span>\
                      </a>\
                    </span>\
                    <legend><span class="Colet">Negativa</span></legend>\
                    <div class="col-xl-6 col-sm-6 col-md-6" style="margin-top:1.7em;">\
                      <div class="form-group col-xl-12 col-sm-12 col-md-12">\
                        <label for="Negativa" >Tipo de Negativa: <span class="sm">(Campo Obligatorio)</span></label>\
                        <select id="cboNegativa'+n+'" num="'+n+'"  onblur="cboNegativaCambio(cboNegativa'+n+', value)" class="form-control" data-toggle="tooltip" data-placement="top" title="Seleccione Tipo de Negativa">\
                          <option value="0" onclick="cboNegativaCambio(cboNegativa'+n+', 0)" >Seleccionar...</option>\
                          <option value="1" onclick="cboNegativaCambio(cboNegativa'+n+', 1)" >NEGATIVA</option>\
                          <option value="2" onclick="cboNegativaCambio(cboNegativa'+n+', 2)" >NEGATIVA COMÚN</option>\
                          <option value="3" onclick="cboNegativaCambio(cboNegativa'+n+', 3)" >NEGATIVA SOLICITUD DE DATOS</option>\
                        </select>\
                      </div>\
                      <div id="Dsolicitud'+n+'" class="form-group col-xl-12 col-sm-12 col-md-12" hidden>\
                        <label for="Dsolicitud">Datos a solicitar: <span class="sm">(Campo Obligatorio)</span></label>\
                        <input type="text" class="form-control" id="txtsolicitud'+n+'" placeholder="Ej. FAVOR ENVIAR FECHA DE NACIMIENTO..." data-toggle="tooltip" data-placement="top" title="Datos a solicitar" data-campo="Dsolicitud" style="text-transform:uppercase;" required>\
                      </div>\
                    </div>\
                    <div class="form-group col-xl-6 col-sm-6 col-md-6" style="padding-right:0;">\
                      <label for="Durante" class="Colet" style="margin-left: 11em;">Durante el Periodo</label><br>\
                      <label for="Del" class="Colet" style="padding-right:18.5em;">Del:</label>\
                      <label for="Al"  class="Colet">Al:</label>\
                      <div class="input-group ">\
                        <input type="text" readonly class="input-group date form-control text-center" id="NegDuranteDel'+n+'" data-toggle="tooltip" data-placement="bottom" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                          <span class="input-group-addon">AL</span>\
                        <input type="text" readonly class="input-group date form-control text-center" id="NegDuranteAl'+n+'" data-toggle="tooltip" data-placement="bottom" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                      </div>\
                    </div>\
                  </div>\
                </td>\
              </tr>';
  if (n==8) {
    $("html, body").animate({ scrollTop: 175 }, "slow");
  }else if(n==11){
    $(".table-fixed tbody").css("height", "600px");
    $("html, body").animate({ scrollTop: 275 }, "slow");
  }  
  $("#tabla").find("tbody tr:last").after(fila); 
  cargarDate();                      
}

function minim () {
  $(".table-fixed tbody").css("height", "auto");
}

function eliminarFila (fl) {
  var n = $('#tabla >tbody >.cont').length;
  if(n!=1){
    if (n==10) {
      $(".table-fixed tbody").css("height", "auto");
      $("html, body").animate({ scrollTop: 150 }, "slow");
    }

    $("#fila"+fl).remove(); 
    $("#filb"+fl).remove(); 

    i=1;
    $('#tabla >tbody >.cont').each(function () {
      $(this).find("td>span").eq(0).text(i);
      i++
    });
  }

}                          

// var datosOficial="";
var jsondata ="";

$("#btn_oficial").click(function(){
	var datbl="", datbl2="";
	if($('#NfolioEntrada').val()==""){
		$('#NfolioEntrada').focus();
		$('#NfolioEntrada').tooltip('show');
	}else{
    if ($('#FechaRedaccion').val()=="") {
      $('#FechaRedaccion').focus();
      $('#FechaRedaccion').tooltip('show');
    }else{
  		if($('#cboAsunto').val()=="0"){
  	    	$('#cboAsunto').focus();
  	    	$('#cboAsunto').tooltip('show');
      	}else{
        var it = true;
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
          
          var check = $(this).find("td").eq(6).html();
          var checkS =  $(check).find(".checkSI").html();
          var checknum = $(checkS).attr('num');
          var checkSI= $(checkS).prop('id');
          var checkN =  $(check).find(".checkNO").html();
          var checkNO= $(checkN).prop('id');

          if ($('#'+nombre).val()=="") {
            $('#'+nombre).tooltip('show');
            it=false;
          }else{
            // datbl+='<tr><td>Nombre '+checknum+':</td><td id="tb-asunti" style="font-weight: 700;">'+$('#'+nombre).val().toUpperCase()+'</td></tr>';
          }
          if($('#Snombre'+checknum).val()!=""){
           // datbl+='<tr><td>Segundo Nombre '+checknum+':</td><td id="tb-Snombre" style="font-weight: 700;">'+$('#Snombre'+checknum).val().toUpperCase()+'</td></tr>';

           }
          if ($('#'+apellido).val()=="") {
            $('#'+apellido).tooltip('show');
            it=false;
          }else{
            // datbl2+='<tr><td>Apellido '+checknum+':</td><td id="tb-asunti" style="font-weight: 700;">'+$('#'+apellido).val().toUpperCase()+'</td></tr>';
          }

          if($('#Sapellido'+checknum).val()!=""){
            // datbl+='<tr><td >Segundo Apellido '+checknum+':</td><td id="tb-Sapellido" style="font-weight: 700;">'+$('#Sapellido'+checknum).val().toUpperCase()+'</td></tr>';

          }
          if($('#Capellido'+checknum).val()!=""){
            // datbl+='<tr><td >Apellido de Casada '+checknum+':</td><td id="tb-Capellido" style="font-weight: 700;">'+$('#Capellido'+checknum).val().toUpperCase()+'</td></tr>';
          }

          if(!$("#"+checkSI).prop("checked")&&!$("#"+checkNO).prop("checked")){
              $(".table-fixed tbody").css("height", "600px");
              $("html, body").animate({ scrollTop: 275 }, "slow");
              $("#chekMovimiento"+checknum).tooltip('show');
              it=false;
          }else{

            if ($("#"+checkSI).prop("checked")) {
              if($('#Nfolio'+checknum).val()==""){
                if (!$('#Mtrue'+checknum).is(':visible')){
                  $("#Mtrue"+checknum).fadeIn("slow");
                }
                $('#Nfolio'+checknum).tooltip('show');
                it=false;
              }else{
                folio +=parseInt($('#Nfolio'+checknum).val());
              }
              if($('#DuranteDel'+checknum).val()!=""||$('#DuranteAl'+checknum).val()!=""){
                if($('#DuranteDel'+checknum).val()==""&&$('#DuranteAl'+checknum).val()!=""){
                  if (!$('#Mtrue'+checknum).is(':visible')){
                    $("#Mtrue"+checknum).fadeIn("slow");
                  }
                  $('#DuranteDel'+checknum).tooltip('show');
                  it=false;
                }else if($('#DuranteDel'+checknum).val()!=""&&$('#DuranteAl'+checknum).val()==""){
                  if (!$('#Mtrue'+checknum).is(':visible')){
                    $("#Mtrue"+checknum).fadeIn("slow");
                  }
                  $('#DuranteAl'+checknum).tooltip('show');
                  it=false;
                }else if($('#DuranteDel'+checknum).val()!=""&&$('#DuranteAl'+checknum).val()!=""){
                  row['DuranteDel']=$('#DuranteDel'+checknum).val();
                  row['DuranteAl']=$('#DuranteAl'+checknum).val();
                  
                }
              }
            }else if ($("#"+checkNO).prop("checked")){
              var negativa = $("#cboNegativa"+checknum).val();
              row['negativa']=$("#cboNegativa"+checknum).val(); 
              folio++;

              if (negativa==0) {
                if (!$('#Mfalse'+checknum).is (':visible')){
                  $("#Mfalse"+checknum).fadeIn("slow");
                }
                $('#cboNegativa'+checknum).tooltip('show');
                it=false;
              }else{
                if(negativa == 3 && $('#txtsolicitud'+checknum).val()=="")
                {
                  if (!$('#Mfalse'+checknum).is (':visible')){
                    $("#Mfalse"+checknum).fadeIn("slow");
                  }
                  $('#txtsolicitud'+checknum).tooltip('show');
                  it=false;
                }else if(negativa == 3){
                  row['txtsolicitud']=$.trim($('#txtsolicitud'+checknum).val().toUpperCase());
                }
              }

              if($('#NegDuranteDel'+checknum).val()!=""||$('#NegDuranteAl'+checknum).val()!=""){
                if($('#NegDuranteDel'+checknum).val()==""&&$('#NegDuranteAl'+checknum).val()!=""){
                  if (!$('#Mfalse'+checknum).is(':visible')){
                    $("#Mfalse"+checknum).fadeIn("slow");
                  }
                  $('#NegDuranteDel'+checknum).tooltip('show');
                  it=false;
                }else if($('#NegDuranteDel'+checknum).val()!=""&&$('#NegDuranteAl'+checknum).val()==""){
                  if (!$('#Mfalse'+checknum).is(':visible')){
                    $("#Mfalse"+checknum).fadeIn("slow");
                  }
                  $('#NegDuranteAl'+checknum).tooltip('show');
                  it=false;
                }else if($('#NegDuranteDel'+checknum).val()!=""&&$('#NegDuranteAl'+checknum).val()!=""){
                  row['DuranteDel']=$('#NegDuranteDel'+checknum).val();
                  row['DuranteAl']=$('#NegDuranteAl'+checknum).val();
                  
                }
              }
              console.log("DURANTE--"+$('#NegDuranteDel'+checknum).val()+$('#NegDuranteAl'+checknum).val());
            }
          }
          data[id]=row;  
        });
         
        if (it) {

          data['folio']=folio;
          data['NfolioEntrada']=$('#NfolioEntrada').val()+$('#NfolioEntradaAnio').text();
          data['Asunto']=$('#cboAsunto').val();
          data['Fredaccion']=$('#FechaRedaccion').val();

          jsondata = "datos=";
          jsondata += JSON.stringify(data);
          jsondata+="&fun=4";
          console.log(jsondata);
          // datbl+='<tr><td>Folio(s):</td><td id="tb-folio" style="font-weight: 700;">'+$('#Nfolio').val()+'</td></tr>';
          confirmacion();         
        }
    }
	 }
  }
 });


function confirmacion() {
  $("#plData input").attr('disabled','disabled');
  $("#addAsunto").attr('onclick','return false;');
  $("#plData button").attr('disabled','disabled');
  $("#plData select").attr('disabled','disabled');
  $('#plData').appendTo('#panelbody');
  $('#plConf').show();
  $('#mdData').hide();
  $('#btn_guardarP').hide();
  $(".table-fixed tbody").css("height", "auto");
  $("html, body").animate({ scrollTop: 175 }, "slow");
  $("#bread2").addClass("btn-info");
  $("#bread3").addClass("btn-info");
} 
function atrasOficial(){
  $("#bread3").removeClass("btn-info");
  $("#plData input").removeAttr('disabled');
  $("#Bredaccion").show();
  $("#addAsunto").attr('onclick','agregarAsunto();');
  $("#plData a").removeAttr('disabled');
  $("#plData button").removeAttr('disabled');
  $("#plData select").removeAttr('disabled');
  $('#plData').appendTo('#datosOficial');
  $('#plConf').hide();
  $('#mdData').show();
  $('#btn_guardarP').show();
	// window.location = "?ac=certificacion&tipo=oficial";
}         

function imprimirOficial() {
	// console.log(jsondata);
	var url = "certificacion/funcion_certificacion.php"; 
    $.ajax({
      type: "POST",
      url: url,
      data: jsondata,
      success: function(data)
      {
        console.log("Data----"+data);
        var jorden = JSON.parse(data);
        // console.log(jorden);
        
        switch(jorden.case){
          case 1:
            atrasOficial();
            $("#respOficial1").html(jorden.message);
            // $('#NfolioEntrada').val(""); 
            $('#NfolioEntrada').focus(); 
          break;
          case 2:
          	// console.log(jorden.message);
            printOficial(jorden.message); 
          break;
          case 3:
            // $("#respOrdenBoleta").html("");
            $("#respOficial1").html(jorden.message);
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
            //         printNegativa(jorden[i].tipoNegativa, "nombre="+jorden[i].nombre+"&fecha="+jorden[i].fecha);

            //         }
            //         console.log("III-------"+i);
            //         if (i==tt) {
            //           console.log("Print Certificacion--"+tt);
            //           setTimeout(cert(jorden), 6000 * tt);
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
            //       // printOficialVarios(jorden.dataCertificacion);
            //       setTimeout(cert(jorden), 6000 * tt);
            //     }
            //   }

            // }
          break;
        }
        
      }
    });
     	
}

function printOficialVarios (datos) {
  tmpModal.hidePleaseWait();
  // console.log("printOficial");
  var dat = datos;
  console.log(dat);
  $.ajax({
  type: "POST",
  url: "certificacion/plantilla/pln-oficialV.php",
  data: dat,
  success: function(data)
  {
    
    $("#bread3").addClass("btn-info");
    $("#bread4").addClass("btn-info");
    $("#respOficial").hide();
    $("#datosOficial").show();
    $("#datosOficial").html(data);
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
        $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>CERTIFICACIÓN</strong> Generada e Impresa!</h3>", {
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
          
          $("#bread3").addClass("btn-info");
          $("#bread4").addClass("btn-info");
          $("#datosOficial").html(data);
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

// function printNegativa2(tipoNegativa, datosNegativa)
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
      
//       $("#bread3").addClass("btn-info");
//       $("#bread4").addClass("btn-info");
//       $("#datosOficial").html(data);
//       $("#printArea").printArea({
//         mode:"iframe",
//         popHt: 500,
//         popWd: 400,
//         popX: 500,
//         popY: 600,
//         popTitle: "Impresion de Negativa",
//         popClose: true
//         });
//       // sleep(5000);

//       // setTimeout(function() {
//         $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>Negativa Impresa</strong></h3>", {
//           type: 'success',
//           width: '500',
//           offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
//           stackup_spacing: 10
//         });
//       // }, 2000);         

//     }
//   });  

// }

function printNegativaOficial(tipoNegativa, datosNegativa, datosCert) {
  tmpModal.hidePleaseWait();
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
      
      $("#bread3").addClass("btn-info");
      $("#bread4").addClass("btn-info");
      $("#datosOficial").html(data);
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
  tmpModal.hidePleaseWait();
	// console.log("printOficial");
	var dat = datos;
	$.ajax({
	type: "POST",
	url: "certificacion/plantilla/pln-oficial.php",
	data: dat,
	success: function(data)
	{
	  
	  $("#bread3").addClass("btn-info");
	  $("#bread4").addClass("btn-info");
	  $("#respOficial").hide();
	  $("#datosOficial").show();
	  $("#datosOficial").html(data);
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
	      $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'><strong>CERTIFICACIÓN</strong> Generada e Impresa!</h3>", {
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
        
  // <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-0">
  //   <span class="pull-left">
  //   <button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="atrasOficial()">
  //     <span class="glyphicon glyphicon-chevron-left"> </span>
  //     Atras
  //   </button>
  //   </span>
  //   </div>
  // <div class="col-xl-3 col-sm-3 col-md-3 col-md-offset-2">
  //   <button type="button" id="btn_imprimirCertificacion"  class="btn btn-success btn-shadow" onclick="imprimirCertificacion()">
  //     <span style="font-size:1.5em;margin:0; padding:0;" class="glyphicon glyphicon-print"></span><br>
  //     Imprimir Certificación
  //   </button> 
  // </div>


</script>