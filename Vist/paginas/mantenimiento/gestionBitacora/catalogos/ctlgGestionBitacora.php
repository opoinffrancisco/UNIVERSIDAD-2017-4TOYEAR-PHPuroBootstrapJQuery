
		<!-- Cuerpo de catalogo -->
		<div id="ctlgBitacora" class="panel-body" style="height: 74%;"> 
		    <div class="row">
		      <div class="col-md-4"  >
				<div class="input-group">
				  <!--<span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon2"></span>-->
				  	<span class="input-group-addon" id="sizing-addon2" >Usuario:</span>
				  	<input type="text" class="form-control input-sm" 
				  		id="buscardorUsuarioTxt" placeholder="Ingresar usuario "
				  		aria-describedby="sizing-addon2"
				  		onkeyup="
				  				mtdBitacora.cargarCatalogoPublic(1),
				  				nucleo.verificarDatosPublic('','','buscardorTxt','buscardorTxt')
				  				" 
			    		data-cantmax="30" maxlength="30" data-cantmin="4" min="4" 
			    		data-sololetrayespacio="1" >
				</div>

		      </div>    
		      <div class="col-md-8"  >
				<div class="input-group">
				  <!--<span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon2"></span>-->
				  	<span class="input-group-addon" id="sizing-addon2" >Operación:</span>
				  	<input type="text" class="form-control input-sm" 
				  		id="buscardorOperacionTxt" placeholder="Ingresar datos de búsqueda "
				  		aria-describedby="sizing-addon2"
				  		onkeyup="
				  				mtdBitacora.cargarCatalogoPublic(1),
				  				nucleo.verificarDatosPublic('','','buscardorTxt','buscardorTxt')
				  				" 
			    		data-cantmax="30" maxlength="30" data-cantmin="4" min="4" 
			    		data-sololetrayespacio="1" >
				</div>
				
		      </div>    
  		      	
		    </div>
			<div class="row" style="margin-top:5px;">
		      <div class="col-md-4"  >
			    <label for="Tipo"  style=""> Perfil : </label>							  
			  	<div id="divTipoListD" class="form-group">
				    <select  id="bperfilListD" class=" selectpicker lista-control " data-select="1" name="Tipo" data-show-subtext="true" data-live-search="true" 
				    	onchange="mtdBitacora.cargarCatalogoPublic(1)" >
						<option data-subtext="" value="0">No hay datos</option>								   		
				   	</select>
				</div>
		      </div>    
				<div class="col-md-4"  >
	  			<label for="Tipo"  style=""> Rango de fechas : </label>							  
					<div class="input-group">
						<span class="input-group-addon" id="sizing-addon2" >Desde:</span>
						<input type="date" maxlength="30" min="6" class="form-control" id="buscardorDesde"
						onkeyup="mtdBitacora.cargarCatalogoPublic(1)"
						onchange="mtdBitacora.cargarCatalogoPublic(1)"
						placeholder="Ingresar fecha" aria-describedby="sizing-addon2">
					</div>				
				</div>    
				<div class="col-md-4"  >
	    		<label for="Tipo"  style="color:#fff;">  : </label>							  				
					<div class="input-group">
					  	<span class="input-group-addon" id="sizing-addon2" >Hasta:</span>
						<input type="date" maxlength="30" min="6" class="form-control" id="buscardorHasta" 
						onkeyup="mtdBitacora.cargarCatalogoPublic(1)"
						onchange="mtdBitacora.cargarCatalogoPublic(1)"
						placeholder="Ingresar fecha" aria-describedby="sizing-addon2">
					</div>				
				</div>  
  		      	
		    </div>
		    <div style=" height: 270px; overflow-y: auto;">
			    <div class="row">
				    <div class="col-md-12"  style="background-color:#fff">
						<div class="catalogo">
							<table id="catalogo" class="table table-bordered table-hover table-striped">
							 <thead>
							  <tr  class="row">
					              <th class="col-md-2">Usuario</th>
					              <th class="col-md-2">Nivel De Usuario</th>
					              <th class="col-md-6">Operación</th>
					              <th class="col-md-2" >Fecha</th>
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
		</div>	
		<!-- paginacion de catalogo / footer-->	
		<div id="pgnBitacora" style="position: relative;bottom: 0;width: 100%;height: 14%;">
			<hr>
			<nav id="pagination" aria-label="Page navigation" class="paginacion">


			</nav>
		</div> 
	<!-- carga de complementos catalogo/ventana modal relacionados-->
<script type="text/javascript">
		mtdBitacora.Iniciar();
		mtdBitacora.cargarCatalogoPublic(1);	

		//refrescar item
			$('#bperfilListD').popover({
			    html: true, 
				placement: "right",
				content: function() {
			          return $('#procesandoDatosInput').html();
			        }
			})

				nucleo.cargarListaDespegableListasPublic('bperfilListD','cfg_pn_perfil','tipo');


        	$('#bperfilListD').popover('show');

		    setTimeout(function(){ 

            	$('#bperfilListD').popover('destroy');

			  	$('#bperfilListD').selectpicker('refresh');

		        $('#ctlgBitacora #btnSelectElegido0').attr('style','width:100%;');

		    }, 300);

	nucleo.guardarBitacoraPublic("INGRESO EN EL MODULO - BITACORA");		
	nucleo.fechaMaxPublic();
</script>