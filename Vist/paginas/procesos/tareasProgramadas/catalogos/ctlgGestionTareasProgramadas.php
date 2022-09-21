
		<!-- Cuerpo de catalogo -->
		<div id="ctlgTareaProgramada" class="panel-body" style="height: 74%;"> 
		    <div class="row">
				<div class="col-md-6"  >
					<div class="input-group">
					  <span class="input-group-addon" id="sizing-addon2" >Buscar :</span>
					  <input type="text" maxlength="30" min="6" class="form-control" id="buscardorTxt" onkeyup="mtdTareaProgramada.cargarCatalogoPublic(1)" placeholder="Ingresar serial o serial de bien nacional" aria-describedby="sizing-addon2">
					</div>
				</div>
				<div class="col-md-3 busquedaAvanzadaBtnDiv"  >
					<a href="javascript:;" onclick="ventanaModal.cambiaMuestraVentanaModalPublic('procesos/tareasProgramadas/ventanasModales/vtnMGestionBusquedaAvanzada.php',1,1)">
					    <button type="button" class="btn btn-default" >
					  		Búsqueda avanzada
					  	</button>
					</a>  	
				</div>	   
				<div class="col-md-1 programarTareaBtnDiv" >
					<a href="javascript:;" onclick="ventanaModal.cambiaMuestraVentanaModalPublic('procesos/tareasProgramadas/ventanasModales/vtnMGestionTareasProgramadas.php',1,1)">
					    <button type="button" class="btn btn-default"  >
					  		Programar tarea 
					  	</button>
					</a>  	
				</div>     
		    </div>
		    <br>
		    <div class="row">
			    <div class="col-md-12"  style="background-color:#fff">
					<div class="catalogo">
						<table id="catalogo" class="table table-bordered table-hover table-striped">
						 <thead>
						  <tr  class="row">
						   <th  class="col-md-2">Serial Equipo</th>
						   <th  class="col-md-3">Tarea</th>
						   <th  class="col-md-2">Fechas</th> 
						   <th  class="col-md-1">Proximidad</th>
						   <th  class="col-md-1">Estado</th> 
						   <th  class="col-md-3">Opciones</th> 
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
		<div id="pgnTareaProgramada" style="position: relative;bottom: 0;width: 100%;height: 14%;">
			<hr>
			<nav id="pagination" aria-label="Page navigation" class="paginacion">


			</nav>
		</div> 

<script type="text/javascript">
	nucleo.asignarPermisosBotonesPublic(4);
</script>