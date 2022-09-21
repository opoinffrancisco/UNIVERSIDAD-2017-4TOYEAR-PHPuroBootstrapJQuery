
		<!-- Cuerpo de catalogo -->
		<div id="ctlgProcsEquipo" class="panel-body" style="height: 74%;"> 
		    <div class="row">
		    	<div class="col-md-4">
			    	<h5><b>Para filtrar equipos:</b></h5>		    		
		    	</div>
				<div class="col-md-5"  >
					<div class="">
					  <input type="text" maxlength="30" min="6" class="form-control input-sm dato_1" id="buscardorTxt" onkeyup="mtdMantenimientoPreventivo.cargarCatalogoPublic(1)" placeholder="Ingresar serial o serial de bien nacional" aria-describedby="sizing-addon2">
					</div>
				</div>
				<div class="col-md-3 busquedaAvanzadaBtnDiv"  >
					<a href="javascript:;" onclick="ventanaModal.cambiaMuestraVentanaModalCapaBasePublic(configuracion.urlsPublic().modReporte.tabs.mantPreventivo.vM.busquedaAvanzada,1,1)">
					    <button type="button" class="btn btn-default input-sm" >
					    <!-- disabled="false" -->
					  		Búsqueda avanzada<!--<span class="glyphicon glyphicon-plus-sign"></span>-->
					  	</button>
					</a>  	

				</div>	         
		    </div>
		    <div class="row">
		    	<div class="col-md-4">
			    	<h5><b>Para filtrar resultados del reporte:</b></h5>		    		
		    	</div>
				<div class="col-md-4"  >
					<div class="input-group">
						<span class="input-group-addon" id="sizing-addon2" >Desde:</span>
						<input type="date" maxlength="30" min="6" class="form-control input-sm" id="fecha_desde"
						onkeyup="mtdSolicitud.cargarCatalogoPublic(1)"
						onchange="mtdSolicitud.cargarCatalogoPublic(1)"
						placeholder="Ingresar fecha" aria-describedby="sizing-addon2">
					</div>				
				</div>    
				<div class="col-md-4 "  style="margin-left: 0%;" >
					<div class="input-group">
					  	<span class="input-group-addon" id="sizing-addon2" >Hasta:</span>
						<input type="date" maxlength="30" min="6" class="form-control input-sm" id="fecha_hasta"
						onkeyup="mtdSolicitud.cargarCatalogoPublic(1)"
						onchange="mtdSolicitud.cargarCatalogoPublic(1)"
						placeholder="Ingresar fecha" aria-describedby="sizing-addon2">
					</div>				
				</div>  			    	
		    </div>   
	    	<div class="row">
			    <div class="col-md-12"  style="background-color:#fff">
					<div class="catalogo">
						<table id="catalogo" class="table table-bordered table-hover table-striped">
							<thead>
								<tr  class="row">
								<th  class="col-md-4">Tipo</th>
								<th  class="col-md-2">Marca y modelo</th>
								<th  class="col-md-2">Serial y serial bien nacional</th>
								<th  class="col-md-4">Opciones</th> 
								</tr> 
							</thead> 
						 <tbody id="catalogoDatos" class="catalogo-datos"> 
		 					<!-- Resultados de Datos -->



		 					<!-- Img de Carga de Datos -->
						  </tbody> 
						</table>
					</div>
				</div>
			</div>	
		</div>	
		<!-- paginacion de catalogo / footer-->	
		<div id="pngProcsEquipo" style="position: relative;bottom: 0;width: 100%;height: 14%;">
			<hr>
			<nav id="pagination" aria-label="Page navigation" class="paginacion">


			</nav>
		</div> 

	<!-- carga de complementos catalogo/ventana modal relacionados-->
<script type="text/javascript">
		mtdMantenimientoPreventivo.Iniciar();
		nucleo.fechaMaxPublic();
</script>
