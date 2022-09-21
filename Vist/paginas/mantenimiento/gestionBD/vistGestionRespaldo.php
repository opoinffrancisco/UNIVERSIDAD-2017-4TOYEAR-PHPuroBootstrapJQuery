<?php
require_once '../../../../Mod/conexion.php';

$Objcon= new classConexion();
$conn = $Objcon->getConexion();
$dbname="sigmanstec";
$tabla[] = null;
$query = "SELECT TABLE_NAME FROM information_schema.tables WHERE table_type='BASE TABLE' and TABLE_SCHEMA ='sigmanstec'";
$result_table = $conn->prepare($query);

?>

 
<!-- Fin de cargar complementos -->
<script type="text/javascript" src="Vist/js/metodos/mantenimiento/mtd-respaldo.js"></script>    


<!-- Panel principal (Catalogo) -->
<div class="panel panel-primary"> 
	<!-- Cabecera de panel para catalogos -->
	<div class="panel-heading" >
		<h3 class="panel-title">Respaldo : </h3> 
	</div>
	

	<div class="row" >
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <table style="width: 100%;" >
                    <tr>
                        <td style="width: 45%;height: 400px;">
                            <h4 style="margin-bottom: 4px;">Tablas Disponibles</h4>
                            <select multiple="100" style="margin: 10px;width: 98%;height: 400px; background-repeat: no-repeat;" id="disponible_table" >
                                <?php
                                if($result_table->execute())
                                      {
                            
                                 while ($row = $result_table->fetch()) {
                                    echo '<option value="' .$tabla[0] = $row[0]. '"  style="background-image: url(Vist/img/table24.png);background-repeat: no-repeat;padding-left: 30px;">'.$tabla[0] = $row[0]. '</option>';
                                }
                              }
                                ?>
                            </select>
                        </td>
                        <td style="width: 2%;text-align: center;vertical-align: middle;">
                            <button type="button" class="btn btn-primary" id="pasar_table" style="margin: 10px;"> > </button>
                            <button type="button" class="btn btn-primary" id="devolver_table" style="margin: 10px;"> < </button>
                        </td>

                        <td style="width: 45%;height: 400px;margin-bottom: 4px;">
                            <h4 style="margin-bottom: 4px;">Tablas Seleccionadas</h4>
                            <select multiple="100" style="margin: 10px;width: 98%;height: 400px;"  id="selected_table">
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                             <button type="button" id="comenzar_respaldo" class="btn btn-default" style="margin: 10px;float: right;" >Guardar</button>
                        </td>
                    </tr>
                </table>
                <div id="emergenteSQL">

                </div>

            </div>
        </div>
    </div>
</div>
	
</div>

<!--////////////////////////////////////////////////////////////////////////////////////////////////-->
<!-- Ventana Modal -->
	<!-- Fondo/Capa de venta -->
<div id="ventana-modal" class="ventana-modal ventana-modal-panel-accionCerrar">
	<!-- Espacio para ventanas modales -->


        <!-- Panel de Ventana modal-->
        <div id="vtnRespaldo" class="panel panel-primary ventana-modal-panel-grande">
            <!-- Cabecera -->
            <div class="panel-heading">
                <h3 class="panel-title">
                    Respaldar base de datos
                    <a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
                    onclick="ventanaModal.ocultarPulico('ventana-modal');">x</a>
                </h3> 
            </div> 
            <!-- Contenido/Formulario -->
            <div class="panel-body"> 
                    <form id="form" method="POST" >
                            <input type="text" id="datoControl" value="" style="display:none;"></input>
                            <input type="text" id="datoControlId" value="" style="display:none;"></input>
                            <pre style="white-space: pre-wrap !important;" class="brush: sql" id="content-sql">                          
                            </pre>                                                        
                            <button type="button" id="btnGuardarFloatR" class="btn btn-default" 
                                    style="position: fixed; z-index: 99; float: right; right: 2%; bottom: 5%;"
                                    onclick="guararArchivoSQL()" 
                            >Guardar</button>
                    </form>
                <?php 

                    include '../../../secciones/dialogo/procesandoDatos.php';

                ?>
            </div>              
        </div>

</div>
<script type="text/javascript">
    nucleo.guardarBitacoraPublic("INGRESO EN EL MODULO - RESPALDO DE BASE DE DATOS");    
</script>
