



<div class="panel panel-primary"> 
	<div class="panel-heading">

		<h3 class="panel-title">Ajustes del sistema</h3> 

	</div> 
	<div id="divAjustesSistema" class="panel-body"> 
					<form id="form" method="post" enctype="multipart/form-data">
						<input type="text" id="datoControl" value="" style="display:none;"></input>
						<input type="text" id="datoControlId" value="" style="display:none;"></input>
						<input id="moduloAjustesSistema" style="display:none;"></input>
						<div class="row">
						    <div class="col-md-6 ">
							      <label for="recurso">Frecuencia de suspensión del sistema : ( Minutos )</label>							  
						  	  	<div id="divFrecuenciaSuspencionTxt" class="form-group">
							    	<input type="number" name="Frecuencia de suspensión" class="campo-control form-control input-sm" id="frecuenciaSuspencionTxt" placeholder="Ingresar minutos" 
							    		onblur="nucleo.validadorPublic()" 
								  		onkeypress="nucleo.verificarDatosInputPublic(event,this,'divNombreTxt')"								    		
							    		maxlength="3" data-cantmin="1"  
							    		data-solonumero="1" >
							  	</div>				  	
						    </div>
						</div>									
						<div class="row">
						    <div class="col-md-6 ">
							      <label for="recurso">Tiempo de proximidad para avisos en las tareas : ( Dias )</label>							  
						  	  	<div id="divTiempoProximidadTTxt" class="form-group">
							    	<input type="number" name="Proximidad" class="campo-control form-control input-sm" id="tiempoProximidadTTxt" placeholder="Ingresar dias" 
							    		onblur="nucleo.validadorPublic()" 
								  		onkeypress="nucleo.verificarDatosInputPublic(event,this,'divTiempoProximidadTTxt')"
							    		maxlength="2" data-cantmin="1"  
							    		data-solonumero="1" >
							  	</div>				  	
						    </div>
						</div>															
						<hr>
						<div class="row">
							<div class="col-md-2 col-md-offset-10 ">
						  		<button type="submit" id="btnGuardar" class="btn btn-default editarBtnDiv" >Guardar</button>
						  	</div>
					  	</div>							
					</form>						
				<?php 

					include '../../secciones/dialogo/procesandoDatos.php';

				?>					
	</div> 
</div>

<script type="text/javascript">
	configuracion.iniciarModuloPublic('as');
	nucleo.asignarPermisosBotonesPublic(8);
	nucleo.guardarBitacoraPublic("INGRESO EN EL MODULO - AJUSTES DE SISTEMA"); 

</script>
