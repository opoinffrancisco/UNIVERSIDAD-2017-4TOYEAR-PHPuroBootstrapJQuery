

		<!-- Panel de Ventana modal-->
		<div id="vtnPerfil" class="vtnPerfilPermisos panel panel-primary ventana-modal-panel-expandido " style="width: 86%;margin-left: 7%;margin-right: 7%;">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Permisos de acceso
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal'),mtdPerfil.restablecerFormPublic()">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body" style="margin: 0px;padding: 15px 0px 15px 0px;"> 
					<form id="form" method="POST" >
							<input type="text" id="datoControl" value="" style="display:none;"></input>
							<input type="text" id="datoControlId" value="" style="display:none;"></input>
							<div class="row">
								<div class="col-md-6 col-md-offset-3 ">
								      <label for="modulo">Nombre de perfil :</label>							  
									  	<div id="divNombreTxt" class="form-group">
								    	<input type="text" name="nombre" class="campo-clave campo-control form-control input-sm" id="nombreTxt" placeholder="Ingresar nombre" 
								    		onblur="nucleo.validadorPublic()" 
								  			onkeyup="nucleo.verificarDatosPublic('mtn_modulo','nombre','nombreTxt','divNombreTxt')"
								    		data-cantmax="30" maxlength="30" data-cantmin="4" data-vexistencia="1" 
								    		data-solonumero="0" data-sololetra="0" data-sololetrayespacio="1" data-vcorreo="0" required="true" disabled="true">
								  	</div>				  	
								</div>
							</div>  
						 
						    <div class="row" style="display:block; margin: 0px; padding: 0px;">



							    <div class="col-md-12" style="margin: 0px; padding: 0px;" >
									<div class="form-group">
								    	<div for="permisos" style=" background: rgba(130, 130, 130, 0.19);width: 100%; margin-bottom: -1px; padding: 1%; padding-bottom:0%;">

											<div class="panel-heading" style="padding: 5px 5px  0px 0px;">
										    	<label for="permisos" style="background: rgb(255, 255, 255);width: 100%;margin-bottom: 0px;padding: 1%;">
										    		Permiso de acceso a modulos:
										    	</label>										

											</div> 

								    	</div>	
								    	<div class="" style="background-color:#fff;overflow-y: auto;height: 100%;background: #d7d7d7;border:1px solid #ccc;padding-bottom: 10px;">
									    	<div class="row">
									    		<div class="col-md-6">
											    	<label for="permisos" style="background: rgb(255, 255, 255);width: 100%;margin-bottom: 0px;padding: 1%; margin:0px;">
											    		Modulos asignados:
											    	</label>																				    			
									    		</div>
									    		<div class="col-md-6">
											    	<label for="permisos" style="background: rgb(255, 255, 255);width: 100%;margin-bottom: 0px;padding: 1%;margin:0px;">
											    		Modulos sin asignar:
											    	</label>																				    			
									    		</div>										    		
									    	</div>
										    <div id="vtnCatalogoDatos" class="catalogo-datos" style="padding: 1%;"> 


												<div id="vtnCtlgModulosPermitidos" style=" background: rgb(80, 133, 179);width: 49.5%;float: left;left: 0px;  ">

												</div>	

												<div id="vtnCtlgModulos" style=" background: rgb(80, 133, 179);width: 49.5%;float: right;right: 0px;">

												</div>
		
											</div>

										</div>

									</div>
								</div>	
								
							</div>								 							

					</form>
				<?php 

					include '../../../../../secciones/dialogo/procesandoDatos.php';

				?>
			</div>				
		</div>

