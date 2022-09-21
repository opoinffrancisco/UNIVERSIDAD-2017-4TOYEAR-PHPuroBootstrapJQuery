
		<!-- Cuerpo de catalogo -->
		<div id="ctlgCCompModelo" class="panel-body" style="height: 74%;"> 
		    <div class="row">
		      <div class="col-md-5"  >
				<div class="input-group">
				  <!--<span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon2"></span>-->
				  	<span class="input-group-addon" id="sizing-addon2" >Buscar</span>
				  	<input type="text" class="dato_1 form-control" id="buscardorTxt" 
				  		placeholder="Ingresar nombre " aria-describedby="sizing-addon2"
				  		onkeyup="
				  				mtdCFiscModelo.cargarCatalogoPublic(1)
				  				" >
				</div>
		      </div>    
				<div class="col-md-1 nuevoBtnDiv" >
					<a href="javascript:;" onclick="ventanaModal.mostrarPulico('ventana-modal', datosIdsTabs=['hola','hola2'])">
					    <button type="button" class="btn btn-default" id="btnNuevo" disabled="true">
					    <!-- disabled="false" -->
					  		Nuevo<!--<span class="glyphicon glyphicon-plus-sign"></span>-->
					  	</button>
					</a>  	
				</div>
				<div class="col-md-4 col-md-offset-1 generarRptBtnDiv" >
				    <button type="button" class="btn btn-default" id="btnGenerarReporte" onclick="reportes.generar2Public(['cfg_c_fisc_modelo','cfg_c_fisc_mod_marca','id_marca'],['nombre','marca'],'CFG-3COLL-1REL','MODELOS EN LAS CARACTERISTICAS FISICAS')" >
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
						  <tr  class="row">
						   <th  class="col-md-6">Nombre</th>
						   <th  class="col-md-2">Marca</th>
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
		<div id="pgnCCompModelo" style="position: relative;bottom: 0;width: 100%;height: 14%;">
			<hr>
			<nav id="pagination" aria-label="Page navigation" class="paginacion">


			</nav>
		</div> 
	<!-- carga de complementos catalogo/ventana modal relacionados-->
<script type="text/javascript">
		mtdCFiscModelo.Iniciar();
		mtdCFiscModelo.cargarCatalogoPublic(1);	
		nucleo.guardarBitacoraPublic("INGRESO EN EL MODULO DE CONFIGURACIÓN - CARACTERISTICAS FISÍCAS : SECCIÓN - MODELO");
</script>