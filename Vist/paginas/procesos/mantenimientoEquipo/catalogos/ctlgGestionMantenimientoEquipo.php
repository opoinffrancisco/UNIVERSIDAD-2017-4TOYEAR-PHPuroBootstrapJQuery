
		<!-- Cuerpo de catalogo -->
		<div id="ctlgSolicitud" class="panel-body" style="height: 74%;"> 
		    <div class="row">
				<div class="col-md-8"  >
					<div class="input-group">
					  <span class="input-group-addon" id="sizing-addon2" >Buscar :</span>
					  <input type="text" maxlength="30" min="6" class="form-control" id="buscardorTxt"
					   onkeyup="mtdMantenimientoEquipo.cargarCatalogoPublic(1)"
					   placeholder="Ingresar serial o serial de bien nacional" aria-describedby="sizing-addon2">
					</div>
				</div>
		    </div>
		    <br>
		    <div class="row">
				<div class="col-md-5"  >
					<div class="input-group">
						<span class="input-group-addon" id="sizing-addon2" >Desde:</span>
						<input type="date" maxlength="30" min="6" class="form-control" id="buscardorDesde"
						onkeyup="mtdMantenimientoEquipo.cargarCatalogoPublic(1)"
						onchange="mtdMantenimientoEquipo.cargarCatalogoPublic(1)"
						placeholder="Ingresar fecha" aria-describedby="sizing-addon2">
					</div>				
				</div>    
				<div class="col-md-4"  >
					<div class="input-group">
					  	<span class="input-group-addon" id="sizing-addon2" >Hasta:</span>
						<input type="date" maxlength="30" min="6" class="form-control" id="buscardorHasta" 
						onkeyup="mtdMantenimientoEquipo.cargarCatalogoPublic(1)"
						onchange="mtdMantenimientoEquipo.cargarCatalogoPublic(1)"
						placeholder="Ingresar fecha" aria-describedby="sizing-addon2">
					</div>				
				</div>    		    	
		    </div>
		    <br>
		    <div class="row">
			    <div class="col-md-12"  style="background-color:#fff">
					<div class="catalogo">
						<table id="catalogo" class="table table-bordered table-hover table-striped">
						 <thead>
						  <tr  class="row">
						   <th  class="col-md-4">Asunto</th>
						   <th  class="col-md-3">Serial y serial de bien nacional del equipo</th>
						   <th  class="col-md-2">Estado</th> 						   
						   <th  class="col-md-1">Fecha</th>
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
		<div id="pngSolicitud" style="position: relative;bottom: 0;width: 100%;height: 14%;">
			<hr>
			<nav id="pagination" aria-label="Page navigation" class="paginacion">


			</nav>
		</div> 
	<!-- carga de complementos catalogo/ventana modal relacionados-->
<script type="text/javascript">
	mtdMantenimientoEquipo.cargarCatalogoPublic(1);
	nucleo.fechaMaxPublic();
</script>
