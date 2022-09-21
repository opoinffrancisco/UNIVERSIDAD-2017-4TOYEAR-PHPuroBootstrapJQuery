<?php
    session_start();
?>  
 
<!-- Fin de cargar complementos -->
<script type="text/javascript" src="Vist/js/metodos/mantenimiento/mtd-restauracion.js"></script>    


<!-- Panel principal (Catalogo) -->
<div class="panel panel-primary"> 
	<!-- Cabecera de panel para catalogos -->
	<div class="panel-heading" >
		<h3 class="panel-title">Restauración : </h3> 
	</div>
	

	<div class="row" >
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <br /> 
               <!--<button type="button" class="btn btn-primary" id="verPdf" <a href="#/file-pdf-o"> <i class="fa fa-file-pdf-o"></i> Exportar</button>-->
                <form id="enviar_datos" name="enviar_datos" method="POST" enctype="multipart/form-data">
                    <table style="width: 100%;">
                        <tr>
                            <td><input type="file" id="archivo_sql" name="archivo_sql" /></td>
                            
                        </tr>
                    </table>
                    </form>
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
    <div id="vtnRestauracion" class="panel panel-primary ventana-modal-panel-grande">
        <!-- Cabecera -->
        <div class="panel-heading">
            <h3 class="panel-title">
                Restaurar base de datos
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
                            onclick="restaurarDBSQL()" 
                        >Guardar</button>
                </form>
            <?php 

                include '../../../secciones/dialogo/procesandoDatos.php';

            ?>
        </div>              
    </div>
</div>
<script type="text/javascript">
  nucleo.guardarBitacoraPublic("INGRESO EN EL MODULO - RESTAURACIÓN DE BASE DE DATOS");    
</script>