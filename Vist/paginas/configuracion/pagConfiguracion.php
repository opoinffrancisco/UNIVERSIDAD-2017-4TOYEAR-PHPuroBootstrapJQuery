



<div class="panel panel-primary"> 
	<div class="panel-heading">

		<h3 class="panel-title">Configuración</h3> 

	</div> 
	<div id="divConfiguracion" class="panel-body"> 
					<form id="form" method="post" enctype="multipart/form-data">
						<input type="text" id="datoControl" value="" style="display:none;"></input>
						<input type="text" id="datoControlId" value="" style="display:none;"></input>
						<div class="row">
								<div class="col-md-3">
									<div id="cfgFotoPerfil" class="cfgFotoPerfil" 
										style="	width: 100%; float:left; border: ridge;">
										<img id="preViewImg" src="" style="width: 100%;height: 150px;  display:none;" >
										<img id="sinImg" src="Vist/img/image-no.png" style="width: 100%;height: 150px;  display:block;">
									</div>
									<div style="width: 100%;float:left;margin-top: 2%;">
								  		<input type="file" id="fotografia" accept="image/jpeg, image/png"  class="btn btn-default" style="width: 100%;float: left;color: transparent;" required="TRUE">
								  		<button type="button" id="btnFotografiar" class="btn btn-default" style="width: 100%;float: left; display:none;">Fotografiar</button>
									</div>
								</div>

								<div class="col-md-9 ">
									<div class="row">
									    <div class="col-md-12 ">
		   							      <label for="recurso">Nombre de la universidad:</label>							  
									  	  	<div id="divNombreTxt" class="form-group">
										    	<input type="text" name="nombre" class="campo-clave campo-control form-control input-sm" id="nombreTxt" placeholder="Ingresar institución" 
										    		onblur="nucleo.validadorPublic()" 
   											  		onkeypress="nucleo.verificarDatosInputPublic(event,this,'divNombreTxt')"								    		
										    		data-cantmax="100" maxlength="100" data-cantmin="20"
										    		data-sololetraynumero="1"  >
										  	</div>				  	
									    </div>
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
	configuracion.iniciarModuloPublic('c');
	nucleo.asignarPermisosBotonesPublic(7);
	nucleo.guardarBitacoraPublic("INGRESO EN EL MODULO - CONFIGURACIÓN"); 

</script>
