
		<!-- Cuerpo de catalogo -->
		<div id="ctlgCaracteristicasSoftware" class="panel-body" style="height: 74%;"> 
		  
			<div id="listas">													
			    <div class="row">
					<div class="col-md-4 col-md-offset-0">
					    <label for="recurso">Filtrar por nombre:</label>							  
				  	  	<div id="divNombreTxt" class="form-group">
							<div class="input-group">
							  <!--<span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon2"></span>-->
							  <span class="input-group-addon" id="sizing-addon2" >Buscar</span>
						    	<input type="text" name="nombre" class="filtro_1 form-control input-sm" id="buscardorTxt" placeholder="Ingresar nombre"
									onkeypress="nucleo.verificarDatosInputPublic(event,'','',this,'buscardorTxt')"
						    		data-cantmax="100" maxlength="100" data-cantmin="2" data-vexistencia="0"  >
						    </div>
					  	</div>						  	
					</div>
					<div class="col-md-4 col-md-offset-0">
						    <label for="Tipo">Filtrar por Tipo : </label>							  
					  	<div id="divTipoListD" class="form-group">
						    <select  id="btipoListD" class=" selectpicker lista-control filtro_2" data-select="1" name="Tipo" data-show-subtext="true" data-live-search="true"  >								
								<option data-subtext="" value="0">No hay datos</option>								   		
						   	</select>
						</div>				  	
					</div>
					<div class="col-md-1 nuevoBtnDiv" >
					    <label for="Fabricante" style="color:#FFFFFF;" >|||||||:</label>							  
					  	<div id="divNuevoBtn" class="form-group">
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
					    <button type="button" class="btn btn-default" id="btnGenerarReporte" onclick="reportes.generarFiltrarPublic('CFG-3COLL-SOFTWARE','SOFTWARE EN EL SISTEMA')" >
					  		Generar reporte
					  	</button>
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
						   <th  class="col-md-4">Nombre</th>
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
		<div id="pgnCaracteristicasSoftware" style="position: relative;bottom: 0;width: 100%;height: 14%;">
			<hr>
			<nav id="pagination" aria-label="Page navigation" class="paginacion">


			</nav>
		</div> 
	<!-- carga de complementos catalogo/ventana modal relacionados-->
<script type="text/javascript">
		mtdCaracteristicasSoftware.Iniciar();
		mtdCaracteristicasSoftware.cargarCatalogoPublic(1,"","");	
		mtdCaracteristicasSoftware.inicioItemsCatalogoPublic();
				
</script>