
		<!-- Cuerpo de catalogo -->
		<div id="ctlgAsignar" class="panel-body" style="height: 74%;"> 
	

		    <div class="row">
				<div class="col-md-7"  >
					<div class="input-group">
					  <span class="input-group-addon" id="sizing-addon2" >Buscar :</span>
					  <input type="text" maxlength="30" min="6" class="form-control" id="buscardorTxt" onkeyup="mtdAsignar.cargarCatalogoPublic(1)" placeholder="Ingresar serial o serial de bien nacional" aria-describedby="sizing-addon2">
					</div>
				</div>
				<div class="col-md-3 busquedaAvanzadaBtnDiv"  >
					<a href="javascript:;" onclick="ventanaModal.cambiaMuestraVentanaModalPublic('procesos/asginarEquipoPersona/ventanasModales/vtnMGestionBusquedaAvanzada.php',1,1)">
					    <button type="button" class="btn btn-default" >
					  		Búsqueda avanzada
					  	</button>
					</a>  	
				</div>	   
				<div class="col-md-1 asignarBtnDiv" >
					<a href="javascript:;" onclick="ventanaModal.cambiaMuestraVentanaModalPublic('procesos/asginarEquipoPersona/ventanasModales/vtnMGestionAsignarEquipoPersona.php',1,1)">
					    <button type="button" class="btn btn-default"  >
					  		Asginar
					  	</button>
					</a>  	
				</div>     
		    </div>

<!--
		    <div class="row">	    
				<div class="col-md-4 "  >
					<div class="input-group">
					  <span class="input-group-addon" id="sizing-addon2" >Cedula :</span>
					  <input type="text" maxlength="30" min="6" class="form-control" id="buscardorTxt" onkeyup="mtdCaracteristicasComponentes.cargarCatalogoPublic(1)" placeholder="Ingresar cedula de la persona "aria-describedby="sizing-addon2">
					</div>	
				</div>	
				<div class="col-md-2 col-md-offset-1"  >

					<a href="javascript:;" onclick="ventanaModal.cambiaMuestraVentanaModalPublic('procesos/asginarEquipoPersona/ventanasModales/vtnMGestionBusquedaAvanzada.php',1,1)">
					    <button type="button" class="btn btn-default" id="btnNuevo" >
					  		Buscar Equipo
					  	</button>
					</a>  	

				</div>		
								
				<div class="col-md-2 col-md-offset-1" >
					<a href="javascript:;" onclick="ventanaModal.cambiaMuestraVentanaModalPublic('procesos/asginarEquipoPersona/ventanasModales/vtnMGestionAsignarEquipoPersona.php',1,1)">
					    <button type="button" class="btn btn-default" id="btnNuevo" >
					  		Asignar
					  	</button>
					</a>  	
				</div>
		    </div>

-->


		    <br>
		    <div class="row">
			    <div class="col-md-12"  style="background-color:#fff">
					<div class="catalogo">
						<table id="catalogo" class="table table-bordered table-hover table-striped">
						 <thead>
						  <tr  class="row">
						   <th  class="col-md-4">Serial y Serial Bien Nacional del Equipo</th>
						   <th  class="col-md-3">Persona</th>
						   <th  class="col-md-3">Cargo y Departamento</th>
						   <th  class="col-md-2">Opciones</th> 
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
		<div id="pgnAsignar" style="position: relative;bottom: 0;width: 100%;height: 14%;">
			<hr>
			<nav id="pagination" aria-label="Page navigation" class="paginacion">


			</nav>
		</div> 
	<!-- carga de complementos catalogo/ventana modal relacionados-->
<script type="text/javascript">
		//mtdCaracteristicasComponentes.Iniciar();
		mtdAsignar.cargarCatalogoPublic(1);	
		nucleo.asignarPermisosBotonesPublic(5);
</script>
