
		<!-- Cuerpo de catalogo -->
		<div id="ctlgProcsEquipo" class="panel-body" style="height: 74%;"> 
		    <div class="row">
				<div class="col-md-7"  >
					<div class="input-group ">
					  <!--<span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon2"></span>-->
					  <span class="input-group-addon" id="sizing-addon2" >Buscar :</span>
					  <input type="text" maxlength="30" min="6" class="form-control" id="buscardorTxt" onkeyup="mtdEquipo.cargarCatalogoPublic(1)" placeholder="Ingresar serial o serial de bien nacional" aria-describedby="sizing-addon2">
					</div>
				</div>
				<div class="col-md-3 busquedaAvanzadaBtnDiv"  >

					<a href="javascript:;" onclick="ventanaModal.cambiaMuestraVentanaModalCapaBasePublic('procesos/agregar/equipo/ventanasModales/vtnMGestionBusquedaAvanzada.php',1,1)">
					    <button type="button" class="btn btn-default" >
					    <!-- disabled="false" -->
					  		Búsqueda avanzada<!--<span class="glyphicon glyphicon-plus-sign"></span>-->
					  	</button>
					</a>  	

				</div>	   
				<div class="col-md-1 nuevoBtnDiv" >
					<a href="javascript:;" onclick="ventanaModal.cambiaMuestraVentanaModalCapaBasePublic('procesos/agregar/equipo/ventanasModales/vtnMGestionEquipo.php',1,1)">
					    <button type="button" class="btn btn-default"  >
					    <!-- disabled="false" -->
					  		Nuevo<!--<span class="glyphicon glyphicon-plus-sign"></span>-->
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
								<th  class="col-md-4">Tipo</th>
								<th  class="col-md-2">Marca y Modelo</th>
								<th  class="col-md-2">Serial y Serial Bien Nacional</th>
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
		mtdEquipo.Iniciar();
		nucleo.asignarPermisosBotonesPublic(6);
</script>
