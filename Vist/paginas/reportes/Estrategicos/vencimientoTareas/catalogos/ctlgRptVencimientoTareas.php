
		<!-- Cuerpo de catalogo -->
		<div id="ctlgRtpVT" class="panel-body" style="height: 74%;"> 
		    <div class="row" style=" margin-bottom: 5px;">

				<div class="col-md-6"   id="listas">
					<div class="">
						<select   class="select campo-control selectpicker lista-control " data-select="1" id="tareaListD"
							name="Tarea" data-show-subtext="true" data-live-search="true" 
							onchange="mtdVencimientoTareas.cargarCatalogoPublic(1);">
							<option data-subtext="" value="0">No hay datos</option>		
						</select>
					</div>
				</div>				
				<div class="col-md-6"  >
					<div class=" "> 
					  <input type="text" maxlength="30" min="6" class="form-control input-sm dato_1" id="buscardorTxt"
					   onkeyup="mtdVencimientoTareas.cargarCatalogoPublic(1)" 
					   placeholder="Ingresar serial o serial de bien nacional del equipo" aria-describedby="sizing-addon2">
					</div>
				</div>
		    </div>
		    <div class="row" style=" margin-bottom: 5px;">
				<div class="col-md-4"  >
					<div class="input-group">
						<span class="input-group-addon" id="sizing-addon2" >Desde:</span>
						<input type="date" maxlength="30" min="6" class="form-control input-sm" id="fecha_desde"
						onkeyup="mtdVencimientoTareas.cargarCatalogoPublic(1)"
						onchange="mtdVencimientoTareas.cargarCatalogoPublic(1)"
						placeholder="Ingresar fecha" aria-describedby="sizing-addon2">
					</div>				
				</div>    
				<div class="col-md-4"  style="margin-left: -0.5%;" >
					<div class="input-group">
					  	<span class="input-group-addon" id="sizing-addon2" >Hasta:</span>
						<input type="date" maxlength="30" min="6" class="form-control input-sm" id="fecha_hasta"
						onkeyup="mtdVencimientoTareas.cargarCatalogoPublic(1)"
						onchange="mtdVencimientoTareas.cargarCatalogoPublic(1)"
						placeholder="Ingresar fecha" aria-describedby="sizing-addon2">
					</div>				
				</div>
				<div class="col-md-4 busquedaAvanzadaBtnDiv"  style="/*width: 18%;margin-left: -1%;*/" >
					<button type="button" class="btn btn-default  input-sm" id="btnGenerarReporte"
						onclick="mtdVencimientoTareas.generarProcesoFiltrarPublic()" style="width: 100%;">
						Generar reporte
					</button>
				</div>	         				    	
		    </div>   
	    	<div class="row">
			    <div class="col-md-12"  style="background-color:#fff">
					<div class="catalogo">
						<table id="catalogo" class="table table-bordered table-hover table-striped">
							<thead>
								<tr  class="row">
								<th  class="col-md-3">Vencimiento</th>
								<th  class="col-md-7">Tarea</th>
								<th  class="col-md-2">Serial equipo</th>

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
		<div id="pngRtpVT" style="position: relative;bottom: 0;width: 100%;height: 14%;">
			<hr>
			<nav id="pagination" aria-label="Page navigation" class="paginacion">


			</nav>
		</div> 

	<!-- carga de complementos catalogo/ventana modal relacionados-->
<script type="text/javascript">		
		mtdVencimientoTareas.Iniciar();
		nucleo.fechaMaxPublic();		
</script>
