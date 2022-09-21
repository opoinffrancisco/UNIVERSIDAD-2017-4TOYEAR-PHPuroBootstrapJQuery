
		<!-- Cuerpo de catalogo -->
		<div id="ctlgCaracteristicasComponentes" class="panel-body" style="height: 74%;"> 
		    <div class="row">
				<div class="col-md-4"  >

				    <label for="Tipo" >Filtrar por modelo : </label>					
				  	<div id="divBuscadorTxt" class="form-group">
						<div class="input-group">
						  <!--<span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon2"></span>-->
						  <span class="input-group-addon" id="sizing-addon2" >Buscar</span>
						  <input type="text" maxlength="30" min="1" class="filtro_1 form-control input-sm" id="buscardorTxt" placeholder="Ingresar modelo" aria-describedby="sizing-addon2"
							  onkeyup="
									mtdCaracteristicasComponentes.cargarCatalogoPublic(1);
							  ">
						</div>
					</div>
				</div>
				<div class="col-md-4 col-md-offset-0">
					    <label for="Tipo" > Filtrar  por tipo : </label>							  
				  	<div id="divTipoListD" class="form-group">
					    <select  id="btipoListD" class=" selectpicker lista-control filtro_2" data-select="1" name="Tipo" data-show-subtext="true" data-live-search="true"  >								
							<option data-subtext="" value="0">No hay datos</option>								   		
					   	</select>
					</div>				  	
				</div>				    
				<div class="col-md-1 nuevoBtnDiv" >
					    <label for="Tipo" style="color: #fff;">nuevo </label>							  

					<div id="divBtnNuevoTxt" class="form-group">

						<a href="javascript:;" onclick="ventanaModal.mostrarPulico('ventana-modal', datosIdsTabs=['scroll','no'])">
						    <button type="button" class="btn btn-default" id="btnNuevo" disabled="true">
						    <!-- disabled="false" -->
						  		Nuevo<!--<span class="glyphicon glyphicon-plus-sign"></span>-->
						  	</button>
						</a> 
					</div>
				</div>
				<div class="col-md-2 col-md-offset-0" >
				    <label for="Tipo" style="color: #fff;">||||||||||||||</label>
				    <button type="button" class="btn btn-default" id="btnGenerarReporte" onclick="reportes.generarFiltrarPublic('CFG-3COLL-C-COMPONENTES','CARACTERÍSTICAS PRINCIPALES PARA COMPONENTES EN EL SISTEMA')" >
				  		Generar reporte
				  	</button>
				</div>	            
		    </div>
		    <br>
		    <div class="row">
			    <div class="col-md-12"  style="background-color:#fff">
					<div class="catalogo">
						<table id="catalogo" class="table table-bordered table-hover table-striped ">
						 <thead>
						  <tr  class="row">
						   <th  class="col-md-2">Modelo</th>
						   <th  class="col-md-2">Marca</th>
						   <th  class="col-md-4">Tipo</th>
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
		<div id="pgnCaracteristicasComponentes" style="position: relative;bottom: 0;width: 100%;height: 14%;">
			<hr>
			<nav id="pagination" aria-label="Page navigation" class="paginacion">


			</nav>
		</div> 
