<?php 
  require_once('res/funciones.php');

if(isset($_SESSION['id'])&&!empty($_SESSION['id'])){ 

  if ($_SESSION['permiso']==0) {
  
 ?>

<p><h1 class="text-center">
<span class="label label-info">Datos de Oficial</span>
</h1></p><br>
<div role="tabpanel">
  <!-- Nav tabs -->
  <ul id="myTab" class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#IngresarDatos" aria-controls="IngresarDatos" role="tab" data-toggle="tab"><b>Datos Oficial</b></a></li>
    <li role="presentation" ><a href="#consultaOFICIAL" aria-controls="consultaOFICIAL" role="tab" data-toggle="tab"><b>Consulta Oficial</b></a></li>
    <!-- <li role="presentation"><a href="#multa" aria-controls="multa" role="tab" data-toggle="tab"><b>Multa por Permanencia Ilegal</b></a></li> -->
  </ul>
</div>

<div class="tab-content">
    <!-- PANEL DATOS OFICIAL -->
    <div role="tabpanel" class="tab-pane active" id="IngresarDatos">
        <div id="datosOficial" style="margin-top:2em;">
          <div id="plData" class="col-xl-12 col-sm-12 col-md-12 ">
            <form method="post" id="FormOficial" >
                <div class="form-group col-xl-12 col-sm-12 col-md-12">
                  <label for="Asunto" class="Colet">Asunto: <span class="sm">(Campo Obligatorio)</span></label>
                  <div class="input-group">
                    <select id="cboAsunto"  num="" class="form-control" data-toggle="tooltip" data-placement="top" title="Seleccione Asunto" data-campo="Asunto" >
                      <option value="0">SELECCIONAR...</option>
                      <?php
                        $asuntos = obtenerAsunto();
                        foreach ($asuntos as $asunto) { 
                            echo '<option value="'.$asunto->id.'" title="Cargo:'.$asunto->cargo.'||Asunto:'.$asunto->asunto.'||Dependencia:'.$asunto->dependencia.'">'.$asunto->nombre.'</option>';        
                        }
                      ?>
                    </select>
                    <a style="cursor:pointer" id="addAsunto" class="input-group-addon" onclick="agregarAsunto();" title="Agregar Asunto">
                      <span >
                        <i class="glyphicon glyphicon-plus"></i>
                      </span>
                    </a>
                  </div>
                </div>
                <div class="col-xl-12 col-sm-12 col-md-12" style="height:auto;overflow:scroll;max-height:600px;">
                  <table id="tabla" class="table table-hover col-xl-12 col-sm-12 col-md-12 Colet">
                    <thead>
                      <tr>
                        <th class="col-xl-1 col-sm-1 col-md-1">#</th>
                        <th class="col-xl-2 col-sm-2 col-md-2">Primer Nombre*</th>
                        <th class="col-xl-2 col-sm-2 col-md-2" >Segundo Nombre</th>
                        <th class="col-xl-2 col-sm-2 col-md-2">Primer Apellido*</th>
                        <th class="col-xl-2 col-sm-2 col-md-2" >Segundo Apellido</th>
                        <th class="col-xl-2 col-sm-2 col-md-2" >Apellido de Casada</th>
                        <th class="col-xl-1 col-sm-1 col-md-1" style="padding-left: 0px;padding-right: 0px;">
                          <span style="margin-left: -0.8em;">Y/O Periodo</span>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr id="fila1" name="fila" num="1" class="cont">
                        <td class="col-xl-1 col-sm-1 col-md-1" >
                          <span  class="close" id="1" style="font-size:28px;padding-left: 50%;padding-right: 50%;" >1</span>
                        </td>
                        <td class="col-xl-2 col-sm-2 col-md-2" >
                          <input type="text" name="Pnombre" class="form-control Pnombre" style="text-transform:uppercase;" id="Pnombre" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Nombre" data-campo="Pnombre" placeholder="Primer Nombre"  onkeypress="return validarLetras(event)" required autofocus>
                        </td>
                        <td class="col-xl-2 col-sm-2 col-md-2" >
                          <input type="text" name="Snombre" class="form-control" id="Snombre" placeholder="Segundo Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
                        </td>
                        <td class="col-xl-2 col-sm-2 col-md-2" >
                          <input type="text" name="Papellido" class="form-control Papellido" id="Papellido" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Apellido" placeholder="Primer Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                        </td>
                        <td class="col-xl-2 col-sm-2 col-md-2" >
                          <input type="text" name="Sapellido" class="form-control" id="Sapellido" placeholder="Segundo Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
                        </td>
                        <td class="col-xl-2 col-sm-2 col-md-2" >
                          <input type="text" name="Capellido" class="form-control" id="Capellido" placeholder="Apellido de Casada" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">
                        </td>
                        <td class="col-xl-1 col-sm-1 col-md-1" style="padding-left: 0px;padding-right: 0px;">
                          <div style="padding-left: 0;" class="col-xl-4 col-sm-4 col-md-4">
                            <button type="button" class="btn btn-primary btn-xs" onclick="addYO(1)" title="Agregar Y/O">
                              <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                            </button>
                          </div>
                          <div style="padding-left: 0;float:left;" class="col-xl-4 col-sm-4 col-md-4">
                            <button type="button" class="btn btn-primary btn-xs" num="1" onclick="periodocheck(this)" >
                              <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                            </button>
                          </div>
                          <div style="padding-right: 0px; margin-top: -0.2em;" class="col-xl-4 col-sm-4 col-md-4">
                            <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarFila(1)">&times;</button>
                          </div>
                        </td>
                      </tr>
                      <tr class="op" id="filb1">
                        <td class="op" colspan="7">
                          <div id="Periodo1" class="col-xl-12 col-sm-12 col-md-12 well" hidden>
                            <span class="pull-right dropup">
                              <a class="btn btn-default dropdown-toggle" onclick="ocultar(Periodo1)">
                                <span class="caret"></span>
                              </a>
                            </span>
                            <legend><span class="Colet">Periodo</span></legend>
                            <div class=" col-xl-12 col-sm-12 col-md-12">
                              <div class="col-xl-12 col-sm-12 col-md-12">
                                <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>
                                <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>
                                <label for="Al"  class="Colet">Al:</label>
                                <span class="pull-right">
                                  <button type="button" class="btn btn-default" onclick="addDurante(1)" style="margin-top: -2em;">
                                      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Periodo
                                  </button>
                                </span>
                              </div>
                              <div id="inpDurante1" num="1" class="form-group col-xl-12 col-sm-12 col-md-12">
                                <div id="P1" class="cant" style="padding-bottom: 2.7em;">
                                  <div class="col-xl-11 col-sm-11 col-md-11">
                                    <div class="input-group ">
                                      <input type="text" readonly class="input-group date form-control text-center" id="DuranteDel" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                                        <span class="input-group-addon">AL</span>
                                      <input type="text" readonly class="input-group date form-control text-center" id="DuranteAl" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>
                                    </div>
                                  </div>
                                  <div class="col-xl-1 col-sm-1 col-md-1">
                                    <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarDurante(1,1)">&times;</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
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
          <div id="plConf" hidden>
            <div class="panel panel-danger">
              <div class="panel-heading">
                <h3 class="panel-title">Confirmación de <strong>Datos Oficial</strong></span>
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
                  <span style="font-size:1.5em;margin:0; padding:0;" class="glyphicon glyphicon-save"></span>
                  <br>Guardar Datos
                </button>
              </div>
          </div>
        </div>
        <div id="respOficial1" class="col-xl-12 col-sm-12 col-md-12" style="margin-top:3em;">
        </div>
    </div>
    <!-- FIN DATOS OFICIAL -->

    <!-- PANEL CONSULTA OFICIAL -->
    <div role="tabpanel" class="tab-pane" id="consultaOFICIAL">
      <br>
      <div id="consultaOficial">
        <!-- BUSCAR ORDEN -->
        <div id="buscarOficial" class="col-xl-12 col-sm-12 col-md-12 well">
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="Folio" class="Colet">Folio de Entrada No.:</label>
              <input type="text" class="form-control" id="FolioBuscar" placeholder="Ej. 10-2015">
            </div>
            <div class="form-group col-xl-6 col-sm-6 col-md-6">
              <label for="Del" class="Colet" style="padding-right:15.7em;">Del:</label>
              <label for="Al"  class="Colet">Al:</label>
              <div class="input-group">
                <input type="text" readonly onchange="VerDiasOficial();" class="search form-control text-center" id="FechaOdel" data-toggle="tooltip" data-placement="right" title="Fecha Del">
                <span class="input-group-addon">AL</span>
                <input type="text" readonly onchange="VerDiasOficial();" class="search form-control text-center" id="FechaOal" data-toggle="tooltip" data-placement="right" title="Fecha Al">
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
              <button type="button" id="btnBuscarOficial"  class="btn btn-lg btn-primary btn-shadow" style="padding: 0.5em 34px;">
                <span style="font-size:1.5em;margin:0; padding:0;" class="glyphicon glyphicon-search"></span><br>
                Buscar
              </button> 
            </div>
        </div>
        <!-- FIN BUSCAR ORDEN -->
        <!-- DATOS DE OFICIAL -->
        <div id="tblOficial" class="col-xl-12 col-sm-12 col-md-12 well" hidden>
          <div class="col-xl-3 col-sm-3 col-md-3">
            <span class="pull-left">
              <button type="button" id="btn_atras"  class="btn btn-default btn-lg btn-shadow" onclick="atrasBuscOfical()" tabindex=1 >
                <span class="glyphicon glyphicon-chevron-left"> </span>
                Atras
              </button>
            </span>
          </div>
          <div id="bodyTable" class="col-xl-12 col-sm-12 col-md-12" style="height:auto;max-height:600px;width:auto;overflow:scroll;max-width:100%;padding-left:0px; padding-right:0px;">
          </div>
        </div>
        <!-- FIN DATOS DE OFICIAL -->

        <!-- MODIFICIACION DE OFICIAL -->
        <div id="modOficial" class="col-xl-12 col-sm-12 col-md-12" style="padding-left:0;padding-right:0;" hidden>
          <form method="post" id="FormOficialMod" >
              
          </form>
        </div>
        <!-- FIN MODIFICIACION DE OFICIAL -->

        <div id="respBuscarOficial" class="col-xl-12 col-sm-12 col-md-12" style="margin-top:3em;">
        </div>

      </div>
    </div>
    <!-- FIN PANEL CONSULTA OFICIAL -->

    <!-- PANEL DE MULTA -->
<!--     <div role="tabpanel" class="tab-pane" id="multa">
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
      
    </div> -->
    <!-- FIN PANEL DE MULTA -->

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
        <div class="modal-body" style="height:auto;overflow:scroll;max-height:600px;">
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

<div id="ModalOficial" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div id="pnlOficial">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title Colet" style="font-weight: 700;" id="titleDataOficial">Dato Oficial Folio No.</h4>
        </div>
        <div class="modal-body" style="height:auto;overflow:scroll;max-height:600px;">
          <div id="datAsunto"></div>
          <table id="tabla" class="table table-hover col-xl-12 col-sm-12 col-md-12 Colet">
            <thead>
              <tr>
                <th class="col-xl-1 col-sm-1 col-md-1">
                  <span style="">#</span>
                </th>
                <th class="col-xl-3 col-sm-3 col-md-3 text-center">Primer Nombre</th>
                <th class="col-xl-2 col-sm-2 col-md-2 text-center">Segundo Nombre</th>
                <th class="col-xl-2 col-sm-2 col-md-2 text-center">Primer Apellido</th>
                <th class="col-xl-2 col-sm-2 col-md-2 text-center">Segundo Apellido</th>
                <th class="col-xl-2 col-sm-2 col-md-2 text-center">Apellido de Casada</th>
              </tr>
            </thead>
            <tbody id="bodyDataOficial">
              
            </tbody>
          </table> 
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="ModalConfOficial" class="modal fade">
  <div class="modal-dialog modal-dialog-center">
    <div class="modal-content">
      <div class="modal-body">
        <b>Desea modificar los datos?</b>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
        <button type="button" data-dismiss="modal" class="btn btn-danger" id="ModalModOficial">Modificar</button>
      </div>
    </div>
  </div>
</div>

<div id="ModalModOf" class="modal fade">
  <div class="modal-dialog modal-dialog-center">
    <div class="modal-content">
      <div class="modal-body">
        <b>Esta seguro de los datos que modificara?</b>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
        <button type="button" data-dismiss="modal" class="btn btn-danger" id="ModalGuardarOficial">Guardar</button>
      </div>
    </div>
  </div>
</div>

<script>
function atrasModOfical() {
  $("#respBuscarOficial").html("");
  $("#FormOficialMod").html("");
  $("#modOficial").slideUp("slow");
  $("#tblOficial").slideDown("slow");
}

function modificarOficial(fol, anio) {
  $('#ModalConfOficial').modal({ backdrop: 'static', keyboard: false })
  .one('click', '#ModalModOficial', function (e) {
    tmpModal.showModal();
    var datMod="FolioB="+fol+"&anio="+anio+"&fun=3";
    // console.log(datMod);
    var url = "oficial/funcion_oficial.php"; 
    $.ajax({
        type: "POST",
        url: url,
        data: datMod,
        success: function(data)
        {
          tmpModal.hideModal();
          // console.log("Data----"+data);
          var jorden = JSON.parse(data);
          switch(jorden.case){
              case 1:
                $("#respBuscarOficial").html(jorden.message);
              break;
              case 2:
                $("#respBuscarOficial").html("");
                $("#FormOficialMod").html(jorden.fila);
                $("#tblOficial").slideUp("slow");
                $("#modOficial").slideDown("slow");
              break;
          }
        }
    });
  });
}

function verOficial(fl) {
  $("#datAsunto").html($("#datosAsuntoOf"+fl).html());
  $("#titleDataOficial").text("Dato Oficial Folio No."+$("#folio"+fl).text());
  $('#bodyDataOficial').html($("#datosOf"+fl).html());
  $("#ModalOficial").modal('show');
}

$("#btnBuscarOficial").click(function(){
  var datBuscar = "";
  if($('#FolioBuscar').val()!=""){
    tmpModal.showModal();
    datBuscar+="FolioB="+$('#FolioBuscar').val()+"&fun=2";
    var url = "oficial/funcion_oficial.php"; 
    $.ajax({
        type: "POST",
        url: url,
        data: datBuscar,
        success: function(data)
        {
          tmpModal.hideModal();
          // console.log("Data----"+data);
          var jorden = JSON.parse(data);
          switch(jorden.case){
              case 1:
                $("#respBuscarOficial").html(jorden.message);
                $('#FolioBuscar').val("");
                $('#FolioBuscar').focus();
              break;
              case 2:
                $("#respBuscarOficial").html("");
                $("#bodyTable").html(jorden.fila);
                $("#buscarOficial").slideUp("slow");
                $("#tblOficial").slideDown("slow");
              break;
          }
        }
    });

  }else{
    if ($('#FechaOdel').val()!=""&&$('#FechaOal').val()!="") {
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
      datBuscar+="&FechaOdel="+$('#FechaOdel').val()+"&FechaOal="+$('#FechaOal').val();
      datBuscar+="&fun=2";
      // console.log("DAtos=="+datBuscar);
      var url = "oficial/funcion_oficial.php";
      $.ajax({
          type: "POST",
          url: url,
          data: datBuscar,
          success: function(data)
          {
            tmpModal.hideModal();
            // console.log("Data----"+data);
            var jorden = JSON.parse(data);
            switch(jorden.case){
                case 1:
                  $("#respBuscarOficial").html(jorden.message);
                  $('#FolioBuscar').val("");
                  $('#FolioBuscar').focus();
                break;
                case 2:
                  $("#respBuscarOficial").html("");
                  $("#bodyTable").html(jorden.fila);
                  $("#buscarOficial").slideUp("slow");
                  $("#tblOficial").slideDown("slow");
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
          if ($('#FechaOdel').val()!=""&&$('#FechaOal').val()!="") {
            datBuscar+="&FechaOdel="+$('#FechaOdel').val()+"&FechaOal="+$('#FechaOal').val();
            if ($('#SnombreBuscar').val()!="") {
              datBuscar+="&Snombre="+$('#SnombreBuscar').val().toUpperCase();
            }

            if ($('#SapellidoBuscar').val()!="") {
              datBuscar+="&Sapellido="+$('#SapellidoBuscar').val().toUpperCase();
            }
            datBuscar+="&fun=2";
            // console.log("DAtos=="+datBuscar);
            tmpModal.showModal();
            var url = "oficial/funcion_oficial.php";
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
                      $("#respBuscarOficial").html(jorden.message);
                      $('#FolioBuscar').val("");
                      $('#FolioBuscar').focus();
                    break;
                    case 2:
                      $("#respBuscarOficial").html("");
                      $("#bodyTable").html(jorden.fila);
                      $("#buscarOficial").slideUp("slow");
                      $("#tblOficial").slideDown("slow");
                    break;
                  }
                }
            });
          }else{
            if ($('#FechaOdel').val()!=""&&$('#FechaOal').val()==""){
              $('#FechaOal').focus();
              $('#FechaOal').tooltip('show');
            }else if ($('#FechaOdel').val()==""&&$('#FechaOal').val()!=""){
              $('#FechaOdel').focus();
              $('#FechaOdel').tooltip('show');
            }else if ($('#FechaOdel').val()==""&&$('#FechaOal').val()==""){
              
              if ($('#SnombreBuscar').val()!="") {
                datBuscar+="&Snombre="+$('#SnombreBuscar').val().toUpperCase();
              }

              if ($('#SapellidoBuscar').val()!="") {
                datBuscar+="&Sapellido="+$('#SapellidoBuscar').val().toUpperCase();
              }
              datBuscar+="&fun=2";
              // console.log("DAtos2=="+datBuscar);
              tmpModal.showModal();
              var url = "oficial/funcion_oficial.php";
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
                        $("#respBuscarOficial").html(jorden.message);
                        $('#FolioBuscar').val("");
                        $('#FolioBuscar').focus();
                      break;
                      case 2:
                        $("#respBuscarOficial").html("");
                        $("#bodyTable").html(jorden.fila);
                        $("#buscarOficial").slideUp("slow");
                        $("#tblOficial").slideDown("slow");
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

function atrasBuscOfical() {
  $("html, body").animate({ scrollTop: 0 }, "slow");
  $("#respBuscarOficial").html("");
  $("#bodyTable").html("");
  $("#tblOficial").slideUp("slow");
  $("#buscarOficial").slideDown("slow");
}

function VerDiasOficial() {
  var inicio = $('#FechaOdel').datepicker('getDate');
  var fin   = $('#FechaOal').datepicker('getDate');

  if (inicio==null){
    $('#FechaOdel').focus();
    $('#FechaOdel').tooltip('show');
  }else{
    if (fin==null){
      $('#FechaOal').focus();
      $('#FechaOal').tooltip('show');
    }else{
      var Fdel = $('#FechaOdel').val().split("-");
      var date1 = new Date(Fdel[2], Fdel[1], Fdel[0]);
      var Fal = $('#FechaOal').val().split("-");
      var date2 = new Date(Fal[2], Fal[1], Fal[0]);

      if (date1>date2) {
        $('#FechaOal').val('');
        $('#FechaOal').tooltip('show');
        $.bootstrapGrowl("<h5 class='text-center' style='margin-top:1px;margin-bottom:-3px;'>Debe ingresar una fecha posterior al <strong>"+$('#FechaOdel').val()+"</strong>!</h5>", {
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

$(".search").datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    autoclose: true,
    orientation: "top auto",
    endDate: '1d',
    clearBtn: true,
    todayHighlight: true,
});

function contiOficial() {
  window.location.reload();
}

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

$(".input-group.date").datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    autoclose: true,
    orientation: "top auto",
    endDate: '1d',
    clearBtn: true,
    todayHighlight: true,
});

function periodocheck(ch){
  var num = $(ch).attr('num');
  if ($('#Periodo'+num).is(':visible')){
    $("#Periodo"+num).slideUp("slow");
  }else{
    $("#Periodo"+num).slideDown("slow");
  }
}

function periodocheckMod(ch){
  var num = $(ch).attr('num');
  if ($('#PeriodoMod'+num).is(':visible')){
    $("#PeriodoMod"+num).slideUp("slow");
  }else{
    $("#PeriodoMod"+num).slideDown("slow");
  }
}

function periodocheckYO(fl, yo){
  if ($('#PeriodoYO'+yo+'.fYO'+fl).is(':visible')){
    $('#PeriodoYO'+yo+'.fYO'+fl).slideUp("slow");
  }else{
    $('#PeriodoYO'+yo+'.fYO'+fl).slideDown("slow");
  }
}

function ocultar(ocul) {
  $( "#"+ocul.id ).slideUp("slow");
}

function addDurante(fl) {
  var n = $('#inpDurante'+fl+' >.cant').length;
  console.log(fl);
  n++;
  var num; 
  $('#inpDurante'+fl+' >.cant').each(function() {
    num=$(this).attr('num');
    if (num==n) {
      n++;
    }
  });
  var html = '<div id="P'+n+'" class="cant" num="'+n+'" style="padding-bottom: 2.7em;">\
                <div class="col-xl-11 col-sm-11 col-md-11">\
                  <div class="input-group ">\
                    <input type="text" readonly class="input-group date form-control text-center" id="DuranteDel'+n+'" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                      <span class="input-group-addon">AL</span>\
                    <input type="text" readonly class="input-group date form-control text-center" id="DuranteAl'+n+'" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                  </div>\
                </div>\
                <div class="col-xl-1 col-sm-1 col-md-1">\
                  <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarDurante('+fl+','+n+')">&times;</button>\
                </div>\
              </div>';
  $("#inpDurante"+fl).find(".cant:last").after(html); 
  cargarDate();
}

function addDuranteMod(fl) {
  var n = $('#inpDuranteMod'+fl+' >.cant').length;
  console.log(fl);
  n++;
  var num; 
  $('#inpDuranteMod'+fl+' >.cant').each(function() {
    num=$(this).attr('num');
    if (num==n) {
      n++;
    }
  });
  var html = '<div id="P'+n+'" class="cant" num="'+n+'" style="padding-bottom: 2.7em;">\
                <div class="col-xl-11 col-sm-11 col-md-11">\
                  <div class="input-group ">\
                    <input type="text" readonly class="input-group date form-control text-center" id="DuranteDel'+n+'" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                      <span class="input-group-addon">AL</span>\
                    <input type="text" readonly class="input-group date form-control text-center" id="DuranteAl'+n+'" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                  </div>\
                </div>\
                <div class="col-xl-1 col-sm-1 col-md-1">\
                  <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarDurante('+fl+','+n+')">&times;</button>\
                </div>\
              </div>';
  $("#inpDuranteMod"+fl).find(".cant:last").after(html); 
  cargarDate();
}

function addDuranteYO(fl, yo) {
  var n = $('#inpDurante'+yo+'.IND'+fl+'>.canti').length;
  n++;
  // console.log(n);
  var num; 
  $('#inpDurante'+yo+'.IND'+fl+'>.canti').each(function() {
    num=$(this).attr('num');
    console.log("numero:"+num);
    if (num==n) {
      n++;
    }
  });
  var html = '<div id="P'+n+'" class="IND'+fl+' canti" num="'+n+'" style="padding-bottom: 2.7em;">\
                <div class="col-xl-11 col-sm-11 col-md-11">\
                  <div class="input-group ">\
                    <input type="text" readonly name="DuranteDel" class="input-group date form-control text-center" id="DuranteDel'+n+'" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                      <span class="input-group-addon">AL</span>\
                    <input type="text" readonly name="DuranteAl" class="input-group date form-control text-center" id="DuranteAl'+n+'" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                  </div>\
                </div>\
                <div class="col-xl-1 col-sm-1 col-md-1">\
                  <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarDuranteYO('+fl+', '+yo+','+n+')">&times;</button>\
                </div>\
              </div>';
  $("#inpDurante"+yo+'.IND'+fl).find(".canti:last").after(html); 
  cargarDate();
}

function addDuranteYOMod(fl, yo) {
  var n = $('#inpDuranteMod'+yo+'.INDMod'+fl+'>.canti').length;
  n++;
  // console.log(n);
  var num; 
  $('#inpDuranteMod'+yo+'.INDMod'+fl+'>.canti').each(function() {
    num=$(this).attr('num');
    console.log("numero:"+num);
    if (num==n) {
      n++;
    }
  });
  var html = '<div id="P'+n+'" class="INDMod'+fl+' canti" num="'+n+'" style="padding-bottom: 2.7em;">\
                <div class="col-xl-11 col-sm-11 col-md-11">\
                  <div class="input-group ">\
                    <input type="text" readonly name="DuranteDel" class="input-group date form-control text-center" id="DuranteDel'+n+'" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                      <span class="input-group-addon">AL</span>\
                    <input type="text" readonly name="DuranteAl" class="input-group date form-control text-center" id="DuranteAl'+n+'" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                  </div>\
                </div>\
                <div class="col-xl-1 col-sm-1 col-md-1">\
                  <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarDuranteYOMod(this)">&times;</button>\
                </div>\
              </div>';
  $("#inpDuranteMod"+yo+'.INDMod'+fl).find(".canti:last").after(html); 
  cargarDate();
}

function addFila(){
  var n = $('#tabla >tbody >.cont').length;
  
  n++;
  var num; 
  $('#tabla >tbody >.cont').each(function() {
    num=$(this).attr('num');
    if (num==n) {
      n++;
    }
  });
  var fila = '<tr id="fila'+n+'" name="fila" num="'+n+'" class="cont">\
              <td class="col-xl-1 col-sm-1 col-md-1" >\
                <span  class="close" id="'+n+'" style="font-size:28px;padding-left: 50%;padding-right: 50%;" >'+n+'</span>\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2" >\
                <input type="text" name="Pnombre" class="form-control Pnombre" style="text-transform:uppercase;" id="Pnombre'+n+'" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Nombre" data-campo="Pnombre" placeholder="Primer Nombre"  onkeypress="return validarLetras(event)" required autofocus>\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2" >\
                <input type="text" name="Snombre" class="form-control" id="Snombre'+n+'"placeholder="Segundo Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2" >\
                <input type="text" name="Papellido" class="form-control Papellido" id="Papellido'+n+'" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Apellido" placeholder="Primer Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2" >\
                <input type="text" name="Sapellido" class="form-control" id="Sapellido'+n+'" placeholder="Segundo Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2" >\
                <input type="text" name="Capellido" class="form-control" id="Capellido'+n+'" placeholder="Apellido de Casada" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">\
              </td>\
              <td class="col-xl-1 col-sm-1 col-md-1" style="padding-left: 0px;padding-right: 0px;">\
                <div style="padding-left: 0;" class="col-xl-4 col-sm-4 col-md-4">\
                  <button type="button" class="btn btn-primary btn-xs" onclick="addYO('+n+')" title="Agregar Y/O">\
                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>\
                  </button>\
                </div>\
                <div style="padding-left: 0;float:left;" class="col-xl-4 col-sm-4 col-md-4">\
                  <button type="button" class="btn btn-primary btn-xs" num="'+n+'" onclick="periodocheck(this)" >\
                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>\
                  </button>\
                </div>\
                <div style="padding-right: 0px; margin-top: -0.2em;" class="col-xl-4 col-sm-4 col-md-4">\
                  <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarFila('+n+')">&times;</button>\
                </div>\
              </td>\
            </tr>\
            <tr class="op" id="filb'+n+'">\
              <td class="op" colspan="7">\
                <div id="Periodo'+n+'" class="col-xl-12 col-sm-12 col-md-12 well" hidden>\
                  <span class="pull-right dropup">\
                    <a class="btn btn-default dropdown-toggle" onclick="ocultar(Periodo'+n+')">\
                      <span class="caret"></span>\
                    </a>\
                  </span>\
                  <legend><span class="Colet">Periodo</span></legend>\
                  <div class=" col-xl-12 col-sm-12 col-md-12">\
                    <div class="col-xl-12 col-sm-12 col-md-12">\
                      <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>\
                      <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>\
                      <label for="Al"  class="Colet">Al:</label>\
                      <span class="pull-right">\
                        <button type="button" class="btn btn-default" onclick="addDurante('+n+')" style="margin-top: -2em;">\
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Periodo\
                        </button>\
                      </span>\
                    </div>\
                    <div id="inpDurante'+n+'" num="'+n+'" class="form-group col-xl-12 col-sm-12 col-md-12">\
                      <div id="P1" class="cant" style="padding-bottom: 2.7em;">\
                        <div class="col-xl-11 col-sm-11 col-md-11">\
                          <div class="input-group ">\
                            <input type="text" readonly class="input-group date form-control text-center" id="DuranteDel" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                              <span class="input-group-addon">AL</span>\
                            <input type="text" readonly class="input-group date form-control text-center" id="DuranteAl" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                          </div>\
                        </div>\
                        <div class="col-xl-1 col-sm-1 col-md-1">\
                          <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarDurante('+n+',1)">&times;</button>\
                        </div>\
                      </div>\
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
  i=1;
  $('#tabla >tbody >.cont').each(function () {
    $(this).find("td>span").eq(0).text(i);
    i++
  });                      
}

function addFilaMod(){
  var n = $('#tablaMod >tbody >.cont').length;
  // console.log(n);
  n++;
  var num; 
  $('#tablaMod >tbody >.cont').each(function() {
    num=$(this).attr('num');
    if (num==n) {
      n++;
    }
  });
  var fila = '<tr id="filaMod'+n+'" name="fila" num="'+n+'" class="cont">\
              <td class="col-xl-1 col-sm-1 col-md-1" >\
                <span  class="close" id="'+n+'" style="font-size:28px;padding-left: 50%;padding-right: 50%;" >'+n+'</span>\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2" >\
                <input type="text" name="Pnombre" class="form-control Pnombre" style="text-transform:uppercase;" id="PnombreMod'+n+'" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Nombre" data-campo="Pnombre" placeholder="Primer Nombre"  onkeypress="return validarLetras(event)" required autofocus>\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2" >\
                <input type="text" name="Snombre" class="form-control" id="SnombreMod'+n+'"placeholder="Segundo Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2" >\
                <input type="text" name="Papellido" class="form-control Papellido" id="PapellidoMod'+n+'" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Apellido" placeholder="Primer Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2" >\
                <input type="text" name="Sapellido" class="form-control" id="SapellidoMod'+n+'" placeholder="Segundo Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2" >\
                <input type="text" name="Capellido" class="form-control" id="CapellidoMod'+n+'" placeholder="Apellido de Casada" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">\
              </td>\
              <td class="col-xl-1 col-sm-1 col-md-1" style="padding-left: 0px;padding-right: 0px;">\
                <div style="padding-left: 0;" class="col-xl-4 col-sm-4 col-md-4">\
                  <button type="button" class="btn btn-primary btn-xs" onclick="addYOMod('+n+')" title="Agregar Y/O">\
                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>\
                  </button>\
                </div>\
                <div style="padding-left: 0;float:left;" class="col-xl-4 col-sm-4 col-md-4">\
                  <button type="button" class="btn btn-primary btn-xs" num="'+n+'" onclick="periodocheckMod(this)" >\
                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>\
                  </button>\
                </div>\
                <div style="padding-right: 0px; margin-top: -0.2em;" class="col-xl-4 col-sm-4 col-md-4">\
                  <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarFilaMod('+n+')">&times;</button>\
                </div>\
              </td>\
            </tr>\
            <tr class="op" id="filbMod'+n+'">\
              <td class="op" colspan="7">\
                <div id="PeriodoMod'+n+'" class="col-xl-12 col-sm-12 col-md-12 well" hidden>\
                  <legend><span class="Colet">Periodo</span></legend>\
                  <div class=" col-xl-12 col-sm-12 col-md-12">\
                    <div class="col-xl-12 col-sm-12 col-md-12">\
                      <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>\
                      <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>\
                      <label for="Al"  class="Colet">Al:</label>\
                      <span class="pull-right">\
                        <button type="button" class="btn btn-default" onclick="addDurante('+n+')" style="margin-top: -2em;">\
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Periodo\
                        </button>\
                      </span>\
                    </div>\
                    <div id="inpDurante'+n+'" num="'+n+'" class="form-group col-xl-12 col-sm-12 col-md-12">\
                      <div id="P1" class="cant" style="padding-bottom: 2.7em;">\
                        <div class="col-xl-11 col-sm-11 col-md-11">\
                          <div class="input-group ">\
                            <input type="text" readonly class="input-group date form-control text-center" id="DuranteDel" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                              <span class="input-group-addon">AL</span>\
                            <input type="text" readonly class="input-group date form-control text-center" id="DuranteAl" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                          </div>\
                        </div>\
                        <div class="col-xl-1 col-sm-1 col-md-1">\
                          <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarDurante('+n+',1)">&times;</button>\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
              </td>\
            </tr>';
  if (n==8) {
    $("html, body").animate({ scrollTop: 175 }, "slow");
  }
  $("#tablaMod").find("tbody tr:last").after(fila); 
  cargarDate();
  i=1;
  $('#tablaMod >tbody >.cont').each(function () {
    $(this).find("td>span").eq(0).text(i);
    i++
  });                      
}

function addYO(fl){
  var n = $('#tabla >tbody >.filaYO'+fl).length;
  // console.log("numero "+fl);
  n++; 
  var num; 
  $('#tabla >tbody >.filaYO'+fl).each(function() {
    num=$(this).attr('num');
    console.log(num);
    if (num==n) {
      n++;
    }
  });
  var fila = '<tr id="filaYO'+n+'" num="'+n+'" class="YO filaYO'+fl+'">\
              <td class="col-xl-1 col-sm-1 col-md-1">\
                <span  class="close" id="YO" style="font-size:28px;padding-left: 50%;padding-right: 30%;" >Y/O</span>\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2">\
                <input type="text" name="Pnombre" class="form-control Pnombre datoYO'+fl+'" style="text-transform:uppercase;" id="Pnombre'+n+'" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Nombre" data-campo="Pnombre" placeholder="Primer Nombre"  onkeypress="return validarLetras(event)" required autofocus>\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2">\
                <input type="text" name="Snombre" class="form-control datoYO'+fl+'" id="Snombre'+n+'" placeholder="Segundo Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2 ">\
                <input type="text" name="Papellido" class="form-control Papellido datoYO'+fl+'" id="Papellido'+n+'" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Apellido" placeholder="Primer Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2 ">\
                <input type="text" name="Sapellido" class="form-control datoYO'+fl+'" id="Sapellido'+n+'" placeholder="Segundo Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2 ">\
                <input type="text" name="Capellido" class="form-control datoYO'+fl+'" id="Capellido'+n+'" placeholder="Apellido de Casada" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">\
              </td>\
              <td class="col-xl-1 col-sm-1 col-md-1" style="padding-left: 0px;padding-right: 0px;">\
                <div style="padding-left: 35%;">\
                  <button type="button" class="btn btn-primary btn-xs" num="'+n+'" onclick="periodocheckYO('+fl+','+n+')">\
                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>\
                  </button>\
                </div>\
                <div style="padding-left: 25%; padding-right: 0px; margin-top: -2em;">\
                  <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarYO('+fl+','+n+')">&times;</button>\
                </div>\
              </td>\
            </tr>\
            <tr id="filbYO'+n+'" class="filbYO'+fl+' YO">\
              <td class="op" colspan="7">\
                <div id="PeriodoYO'+n+'" class="fYO'+fl+' col-xl-12 col-sm-12 col-md-12 well" hidden>\
                  <legend><span class="Colet">Periodo</span></legend>\
                  <div class=" col-xl-12 col-sm-12 col-md-12">\
                    <div class="col-xl-12 col-sm-12 col-md-12">\
                      <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>\
                      <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>\
                      <label for="Al"  class="Colet">Al:</label>\
                      <span class="pull-right">\
                        <button type="button" class="btn btn-default" onclick="addDuranteYO('+fl+', '+n+')" style="margin-top: -2em;">\
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Periodo\
                        </button>\
                      </span>\
                    </div>\
                    <div id="inpDurante'+n+'" class="IND'+fl+' form-group col-xl-12 col-sm-12 col-md-12">\
                      <div id="P1" class="canti" style="padding-bottom: 2.7em;">\
                        <div class="col-xl-11 col-sm-11 col-md-11">\
                          <div class="input-group ">\
                            <input type="text" name="DuranteDel" readonly class="input-group date form-control text-center" id="DuranteDel" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                              <span class="input-group-addon">AL</span>\
                            <input type="text" name="DuranteAl" readonly class="input-group date form-control text-center" id="DuranteAl" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                          </div>\
                        </div>\
                        <div class="col-xl-1 col-sm-1 col-md-1">\
                          <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarDuranteYOMod(this)">&times;</button>\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
              </td>\
            </tr>';
  $("#tabla").find("tbody #filb"+fl+":last").after(fila); 
  cargarDate();                      
}

function addYOMod(fl){
  var n = $('#tablaMod >tbody >.filaYOMod'+fl).length;
  // console.log("numero "+fl);
  n++; 
  var num; 
  $('#tablaMod >tbody >.filaYO'+fl).each(function() {
    num=$(this).attr('num');
    console.log(num);
    if (num==n) {
      n++;
    }
  });
  var fila = '<tr id="filaYOMod'+n+'" num="'+n+'" class="YO filaYOMod'+fl+'">\
              <td class="col-xl-1 col-sm-1 col-md-1">\
                <span  class="close" id="YO" style="font-size:28px;padding-left: 50%;padding-right: 30%;" >Y/O</span>\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2">\
                <input type="text" name="Pnombre" class="form-control Pnombre datoYO'+fl+'" style="text-transform:uppercase;" id="PnombreMod'+n+'" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Nombre" data-campo="Pnombre" placeholder="Primer Nombre"  onkeypress="return validarLetras(event)" required autofocus>\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2">\
                <input type="text" name="Snombre" class="form-control datoYO'+fl+'" id="SnombreMod'+n+'" placeholder="Segundo Nombre" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2 ">\
                <input type="text" name="Papellido" class="form-control Papellido datoYO'+fl+'" id="PapellidoMod'+n+'" data-toggle="tooltip" data-placement="left" title="Ingresar Primer Apellido" placeholder="Primer Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2 ">\
                <input type="text" name="Sapellido" class="form-control datoYO'+fl+'" id="SapellidoMod'+n+'" placeholder="Segundo Apellido" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">\
              </td>\
              <td class="col-xl-2 col-sm-2 col-md-2 ">\
                <input type="text" name="Capellido" class="form-control datoYO'+fl+'" id="CapellidoMod'+n+'" placeholder="Apellido de Casada" style="text-transform:uppercase;" onkeypress="return validarLetras(event)">\
              </td>\
              <td class="col-xl-1 col-sm-1 col-md-1" style="padding-left: 0px;padding-right: 0px;">\
                <div style="padding-left: 35%;">\
                  <button type="button" class="btn btn-primary btn-xs" num="'+n+'" onclick="periodocheckYO('+fl+','+n+')">\
                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>\
                  </button>\
                </div>\
                <div style="padding-left: 25%; padding-right: 0px; margin-top: -2em;">\
                  <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarYOMod('+fl+','+n+')">&times;</button>\
                </div>\
              </td>\
            </tr>\
            <tr id="filbYOMod'+n+'" class="filbYOMod'+fl+' YO">\
              <td class="op" colspan="7">\
                <div id="PeriodoYO'+n+'" class="fYO'+fl+' col-xl-12 col-sm-12 col-md-12 well" hidden>\
                  <legend><span class="Colet">Periodo</span></legend>\
                  <div class=" col-xl-12 col-sm-12 col-md-12">\
                    <div class="col-xl-12 col-sm-12 col-md-12">\
                      <label for="Durante" class="Colet" style="margin-left: 23em;">Durante el Periodo</label><br>\
                      <label for="Del" class="Colet" style="padding-right: 26.5em; padding-left: 2em;">Del:</label>\
                      <label for="Al"  class="Colet">Al:</label>\
                      <span class="pull-right">\
                        <button type="button" class="btn btn-default" onclick="addDuranteYOMod('+fl+', '+n+')" style="margin-top: -2em;">\
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Periodo\
                        </button>\
                      </span>\
                    </div>\
                    <div id="inpDuranteMod'+n+'" class="INDMod'+fl+' form-group col-xl-12 col-sm-12 col-md-12">\
                      <div id="P1" class="canti" style="padding-bottom: 2.7em;">\
                        <div class="col-xl-11 col-sm-11 col-md-11">\
                          <div class="input-group ">\
                            <input type="text" name="DuranteDel" readonly class="input-group date form-control text-center" id="DuranteDel" data-toggle="tooltip" data-placement="right" title="Fecha Del" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                              <span class="input-group-addon">AL</span>\
                            <input type="text" name="DuranteAl" readonly class="input-group date form-control text-center" id="DuranteAl" data-toggle="tooltip" data-placement="right" title="Fecha Al" data-campo="Del" placeholder="" style="text-transform:uppercase;" onkeypress="return validarLetras(event)" required>\
                          </div>\
                        </div>\
                        <div class="col-xl-1 col-sm-1 col-md-1">\
                          <button type="button" class="close" aria-hidden="true" style="font-size:30px;" title="Eliminar" onclick="eliminarDuranteYOMod(this)">&times;</button>\
                        </div>\
                      </div>\
                    </div>\
                  </div>\
                </div>\
              </td>\
            </tr>';
  $("#tablaMod").find("tbody #filbMod"+fl+":last").after(fila); 
  cargarDate();                      
}


function minim () {
  $(".table-fixed tbody").css("height", "auto");
}

function eliminarDurante(fl,el) {
  var n = $('#inpDurante'+fl+' >.cant').length;
  // n++;
  console.log(n);
  if (n!=1) {
    $("#inpDurante"+fl+" >#P"+el).remove(); 
  }
}

function eliminarDuranteYOMod(fl) {
  // var n = $('#inpDurante'+fl+' >.cant').length;
  // n++;
  // console.log($($(fl).parent()).parent());
  $($(fl).parent()).parent().remove();
  // if (n!=1) {
  //   $("#inpDurante"+fl+" >#P"+el).remove(); 
  // }
}

function eliminarDuranteYO(fl, yo,el) {
  var n = $('#inpDurante'+yo+'.IND'+fl+'>.canti').length;
  // console.log(fl);
  // var n = $('#inpDurante'+fl+' >.cant').length;
  if (n!=1) {
    $('#inpDurante'+yo+'.IND'+fl+' >#P'+el).remove(); 
  }
}

function eliminarFila (fl) {
  console.log(fl);
  var n = $('#tabla >tbody >.cont').length;
  if(n!=1){
    if (n==10) {
      $(".table-fixed tbody").css("height", "auto");
      $("html, body").animate({ scrollTop: 150 }, "slow");
    }

    $("#fila"+fl).remove(); 
    $("#filb"+fl).remove();
    $(".filaYO"+fl).remove(); 
    $(".filbYO"+fl).remove(); 
    i=1;
    $('#tabla >tbody >.cont').each(function () {
      $(this).find("td>span").eq(0).text(i);
      i++
    });
  }
}

function eliminarFilaMod (fl) {
  console.log(fl);
  // $(fl).remove();
  var n = $('#tablaMod >tbody >.cont').length;
  if(n!=1){
    if (n==10) {
      $(".table-fixed tbody").css("height", "auto");
      $("html, body").animate({ scrollTop: 150 }, "slow");
    }

    $("#filaMod"+fl).remove(); 
    $("#filbMod"+fl).remove();
    $(".filaYOMod"+fl).remove(); 
    $(".filbYOMod"+fl).remove(); 
    i=1;
    $('#tablaMod >tbody >.cont').each(function () {
      $(this).find("td>span").eq(0).text(i);
      i++
    });
  }
}

function eliminarYO(fl, yo) {
  $("#filaYO"+yo+".filaYO"+fl).remove(); 
  $("#filbYO"+yo+".filaYO"+fl).remove(); 
} 

function eliminarYOMod(fl, yo) {
  $("#filaYOMod"+yo+".filaYOMod"+fl).remove(); 
  $("#filbYOMod"+yo+".filbYOMod"+fl).remove(); 
} 


var jsondata ="";
$("#btn_oficial").click(function(){
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
        if ($(this).attr('type')=="checkbox") {
          if( $(this).is(':checked') ) {
            row[$(this).attr('id')]='SI';
          }else{
            row[$(this).attr('id')]='NO';
          }
        }else{
          if ($(this).attr('name')=='Pnombre'||$(this).attr('name')=='Papellido') {
            if ($(this).val()=="") {
              $(this).tooltip('show');
              it=false;
            }              
          }
          row[$(this).attr('id')]=$(this).val().toUpperCase();
        }
      });

      var pernum=$(this).attr('num');
      var iter = 1;
      var ct = 0;
      var duran={};
      $("#filb"+pernum).find('.cant').each(function(){
          var dat1;
          var dat2;
          $(this).find('input').each(function(){
            if (iter==1) {
              dat1 = $(this).attr('id');
            }else if(iter==2){
              dat2 = $(this).attr('id');
              if ($('#'+dat1).val()!=""&&$('#'+dat2).val()=="") {
                $('#'+dat2).tooltip('show');
                it=false;
              }else if($('#'+dat1).val()==""&&$('#'+dat2).val()!=""){
                $('#'+dat1).tooltip('show');
                it=false;
              }
            }
            if (iter==1) {
              duran['DuranteDel'+ct]=$(this).val();

            }else if(iter==2){
              duran['DuranteAl'+ct]=$(this).val();
            }

            iter++;
          });
          iter=1;
          ct++;
      });
      // row['DuranteCant']=ct;
      row['Durante'] = duran;

      var nombre = $(this).find("td").eq(1).html();
      nombre = $(nombre).attr('id');
      var apellido = $(this).find("td").eq(3).html();
      apellido = $(apellido).attr('id');
      

      if ($('#'+nombre).val()=="") {
        $('#'+nombre).tooltip('show');
        it=false;
      }
      if ($('#'+apellido).val()=="") {
        $('#'+apellido).tooltip('show');
        it=false;
      }

      var YOcantidad = 0;
      var numid=$(this).attr('num');
      // console.log("Numero==="+$('.filaYO'+numid).length);
      var nt = 1;
      var fYO ={};
      $('.filaYO'+numid).each(function () {
        var row2YO={};
        $(this).find('td input').each(function(){
          if ($(this).attr('name')=='Pnombre'||$(this).attr('name')=='Papellido') {
            if ($(this).val()=="") {
              $(this).tooltip('show');
              it=false;
            }              
          }
          row2YO[$(this).attr('name')+YOcantidad]=$(this).val().toUpperCase();
        });
        YOcantidad++;

        var ct = 0;
        var duranYO={};
        $(".filbYO"+numid).find('input').each(function(){
          // console.log($(this).val());
          duranYO[$(this).attr('name')+ct]=$(this).val();
          ct++;
        });
        row2YO['Durante'] = duranYO;
        // row2['DuranteCant']=ct/2;
        fYO['YO'+YOcantidad]=row2YO;
      });

      // fYO['YO'+YOcantidad]=row2;
      // row['YOcantidad']=YOcantidad;
      row['filaYO']=fYO;
      data[id]=row;

    });
     
    if (it) {

      // data['NfolioEntrada']=$('#NfolioEntrada').val()+$('#NfolioEntradaAnio').text();
      data['Asunto']=$('#cboAsunto').val();

      jsondata = "datos=";
      jsondata += JSON.stringify(data);
      jsondata+="&fun=1";
      console.log(jsondata);
      confirmacion();
    }
  }
 });

function modDatoOficial(){
  $('#ModalModOf').modal({ backdrop: 'static', keyboard: false })
  .one('click', '#ModalGuardarOficial', function (e) {
    var it = true;
    var folio = 0;
    var data={};

    $('#tablaMod >tbody >.cont').each(function () {
      var id=$(this).attr('id');
      var row={};
      
      $(this).find('td input').each(function(){
          if ($(this).attr('name')=='Pnombre'||$(this).attr('name')=='Papellido') {
            if ($(this).val()=="") {
              $(this).tooltip('show');
              it=false;
            }              
          }
          row[$(this).attr('id')]=$(this).val().toUpperCase();
      });

      var pernum=$(this).attr('num');
      var iter = 1;
      var ct = 0;
      var duran={};
      $("#filbMod"+pernum).find('.cant').each(function(){
          var dat1;
          var dat2;
          $(this).find('input').each(function(){
            if (iter==1) {
              dat1 = $(this).attr('id');
            }else if(iter==2){
              dat2 = $(this).attr('id');
              if ($('#'+dat1).val()!=""&&$('#'+dat2).val()=="") {
                $('#'+dat2).tooltip('show');
                // it=false;
              }else if($('#'+dat1).val()==""&&$('#'+dat2).val()!=""){
                $('#'+dat1).tooltip('show');
                // it=false;
              }
            }
            if (iter==1) {
              duran['DuranteDel'+ct]=$(this).val();

            }else if(iter==2){
              duran['DuranteAl'+ct]=$(this).val();
            }

            iter++;
          });
          iter=1;
          ct++;
      });

      row['Durante'] = duran;
      var YOcantidad = 0;
      var numid=$(this).attr('num');
      var nt = 1;
      var fYO ={};

      $('.filaYOMod'+numid).each(function () {
        var row2YO={};
        $(this).find('td input').each(function(){
          if ($(this).attr('name')=='Pnombre'||$(this).attr('name')=='Papellido') {
            if ($(this).val()=="") {
              $(this).tooltip('show');
              it=false;
            }              
          }
          row2YO[$(this).attr('name')+YOcantidad]=$(this).val().toUpperCase();
        });
        YOcantidad++;

        var ct = 0;
        var duranYO={};
        $(".filbYOMod"+numid).find('input').each(function(){
          console.log($(this).val());
          duranYO[$(this).attr('name')+ct]=$(this).val();
          ct++;
        });
        row2YO['Durante'] = duranYO;
        // row2['DuranteCant']=ct/2;
        fYO['YO'+YOcantidad]=row2YO;
      });

      // fYO['YO'+YOcantidad]=row2;
      // row['YOcantidad']=YOcantidad;
      row['filaYO']=fYO;
      data[id]=row;

    });
    if (it) {
      data['Asunto']=$('#cboAsuntoMod').val();
      data['FolioOficial']=$('#folOficialMod').text();

      jsondata = "datos=";
      jsondata += JSON.stringify(data);
      jsondata+="&fun=1";
      console.log(jsondata);
      // confirmacion();
    }
  });
}

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
  $("html, body").animate({ scrollTop: 0 }, "slow");
}

function atrasOficial(){
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
}         

function imprimirOficial() {
  tmpModal.showModal();
  var url = "oficial/funcion_oficial.php"; 
    $.ajax({
      type: "POST",
      url: url,
      data: jsondata,
      success: function(data)
      {
        console.log("Data----"+data);
        var jorden = JSON.parse(data);
        console.log(jorden);
        tmpModal.hideModal();
        switch(jorden.case){
          case 1:
            atrasOficial();
            $("#respOficial1").html(jorden.message);
          break;
          case 2:
            printOficial(jorden.message); 
          break;
          case 3:
            $("#datosOficial").html(jorden.message);
            $.bootstrapGrowl("<h3 class='text-center' style='margin-top:1px;margin-bottom:-3px;'>Datos guardados <strong>exitosamente!</strong></h3>", {
              type: 'success',
              width: '500',
              offset: {from: 'top', amount: 90}, // 'top', or 'bottom'
              delay: 4000,
              stackup_spacing: 10
            });
          break;
        }
        
      }
    });
      
}

function redirection(dir){  
  window.location=dir;
}     
        
</script>

<?php
  }else{
      echo '
          <br><br><br>
          <p>
            <h3 class="text-center">
              <span style="font-size: 87px;color:#D9534F;" class="glyphicon glyphicon-warning-sign"></span><br>
              <span class="label label-danger">Usted no tiene permisos para esta area.</span>
            </h3>
          </p>
        ';
  }

}else{
  include 'login.php';
}
 ?>