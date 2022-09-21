
		<!-- Cuerpo de catalogo -->
		<div id="ctlgDiagnosticosSolicitud" class="panel-body" style="height: 74%;"> 

			<div class="row">	
				<div class="col-md-2 col-md-offset-0">
			  	  	<div id="divDetalles" class="form-group diagnosticarBtnDiv">								
						<a href="javascript:;" onclick="ventanaModal.cambiaMuestraVentanaModalCapa2Public('procesos/mantenimientoEquipo/ventanasModales/vtnMGestionMantenimientoEquipo-realizarDiagnostico.php',1,1)">
						    <button type="button" class="btn btn-default" id="btnNuevo" >
						    <!-- disabled="false" -->
						  		Diagnosticar<!--<span class="glyphicon glyphicon-plus-sign"></span>-->
						  	</button>
						</a>	
					</div>	
				</div>																					
			</div>
		    <div class="row">
			    <div class="col-md-12"  style="background-color:#fff;padding: 0px;border: 1px solid #ccc;">
					<div  class="row">
					   <div  class="col-md-12" style="padding: 10px; border: 1px solid #ccc;">
					   		<b>Observaciones diagnosticadas</b>
					   	</div> 
					</div>  
	 				<!-- Resultados de Datos -->
	 				<div id="catalogoDatos" class="catalogo-datos" style="overflow-y: auto; height: 300px;">
 						
 					</div>		 										 					
	 				<!-- Img de Carga de Datos -->
				</div>
			</div>	
		</div>	
<script type="text/javascript">
	nucleo.asignarPermisosBotonesPublic(3);	
</script>		