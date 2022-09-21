		<!-- Cuerpo de catalogo -->
		<div id="ctlgPerfil" class="panel-body" style="height: 74%;"> 
		    <div class="row">
		      <div class="col-md-5"  >
				<div class="input-group">
				  <!--<span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon2"></span>-->
					<span class="input-group-addon" id="sizing-addon2" >Buscar</span>
					<input type="text" class="dato_1 form-control" id="buscardorTxt" 	
						placeholder="Ingresar nombre" aria-describedby="sizing-addon2"  
			  			onkeypress="nucleo.verificarDatosInputPublic(event,this,'buscardorTxt')"
			  			onkeyup="mtdPerfil.cargarCatalogoPublic(1)" 
		    			data-sololetrayespacio="1" >
				</div>
		      </div>    
				<div class="col-md-1 nuevoBtnDiv" >
					<a href="javascript:;" onclick="ventanaModal.cambiaMuestraVentanaModalPublic(configuracion.urlsPublic().modPersona.tabs.perfil.ventanaModal,1,1)">
					    <button type="button" class="btn btn-default" id="btnNuevo" disabled="true">
					    <!-- disabled="false" -->
					  		Nuevo<!--<span class="glyphicon glyphicon-plus-sign"></span>-->
					  	</button>
					</a>  	
				</div>
				<div class="col-md-4 col-md-offset-1 generarRptBtnDiv" >
				    <button type="button" class="btn btn-default" id="btnGenerarReporte" onclick="reportes.generar2Public(['cfg_pn_perfil'],['nombre'],'CFG-2COLL','PERFILES DE USUARIO EN EL SISTEMA')" >
				  		Generar Reporte
				  	</button>
				</div>	 	                  
		    </div>
		    <br>
		    <div class="row">
			    <div class="col-md-12"  style="background-color:#fff">
					<div class="catalogo">
						<table id="catalogo" class="table table-bordered table-hover table-striped">
						 <thead>
						  <tr class="row">
						   <th class="col-md-8">Nombre</th>
						   <th class="col-md-4">Opciones</th> 
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
		<div id="pgnPerfil" style="position: relative;bottom: 0;width: 100%;height: 14%;">
			<hr>
			<nav id="pagination" aria-label="Page navigation" class="paginacion">


			</nav>
		</div> 