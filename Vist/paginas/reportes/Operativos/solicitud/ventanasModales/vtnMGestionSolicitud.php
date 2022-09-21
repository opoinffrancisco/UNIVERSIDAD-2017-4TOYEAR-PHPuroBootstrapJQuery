<div id="vtnSolicitud" class="panel panel-primary ventana-modal-panel-grande " style="margin-left: 5%;">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestionar su solicitud
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar cerrarSolicitud"  onclick="ventanaModal.ocultarPulico('ventana-modal')">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
				<form id="form" method="POST" style="display: block;">
						<input type="text" id="datoControl" value="" style="display:none;">
						<input type="text" id="datoControlId" value="" style="display:none;">
						<div class="row" style="margin-bottom: 10px;">
							<div class="col-md-3 col-md-offset-9">
								<div class="btn-group" role="group" style="width: 100%;">
									<button type="button" class="btn btn-default abrir-panel-datos" style="width: 100%; display:none;"
										 onclick="$('.datos-responsables-solicitud').css('display', 'block'),
												  $('.abrir-panel-datos').css('display', 'none'),
												  $('.cerrar-panel-datos').css('display', 'block')" 
									>Ver datos de responsables</button>
								</div>	
								<div class="btn-group" role="group" style="width: 100%;">
									<button type="button" class="btn btn-default cerrar-panel-datos" style="width: 100%; display:none;"
										 onclick="$('.datos-responsables-solicitud').css('display', 'none'),
												  $('.abrir-panel-datos').css('display', 'block'),
												  $('.cerrar-panel-datos').css('display', 'none')" 
									>Cerrar datos de responsables</button>
								</div>									
							</div>
						</div> 
						<!-- DATOS DE RESPONSABLES EN SOLICITUD-->
						<div class="row datos-responsables-solicitud" style="display: none;">
							<!-- DATOS DEL SOLICITANTE -->
							<div class="col-md-12 datos-solicitante" style="display: none;">
								<div class="row">
									<div class="col-md-9">
										<h4><b>Datos del solicitante</b></h4>
										<div class="row">
											<div class="col-md-6">											
												<div class="form-group">
												    <label for="1">Cedula :</label>
												    <input type="text" class="form-control input-sm" id="cedulaTxt" placeholder="" disabled="TRUE">
												</div>											
											</div>				
											<div class="col-md-6">
												<div class="form-group">
													<label for="1">Nombre y Apellido :</label>
												    <input type="text" class="form-control input-sm" id="nombreApellidoTxt" placeholder="" disabled="TRUE">
												</div>																						
											</div>																					
										</div>
										<div class="row">
											<div class="col-md-6">											
												<div class="form-group">
												    <label for="1">Cargo :</label>
												    <input type="text" class="form-control input-sm" id="cargoTxt" placeholder="" disabled="TRUE">
												</div>											
											</div>				
											<div class="col-md-6">											
												<div class="form-group">
												    <label for="1">Departamento :</label>
												    <input type="text" class="form-control input-sm" id="departamentoTxt" placeholder="" disabled="TRUE">
												</div>											
											</div>				
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Correo electronico</label>
													<input type="text" class="form-control input-sm" id="correoTxt" placeholder="" disabled="TRUE">
												</div>
											</div>																		
										</div>
									</div>				
									<div class="col-md-3">
										<label for="1">Fotografia :</label>
										<div id="cfgFotoPerfil" class="cfgFotoPerfil" style="	width: 100%; float:left; border: ridge;">
											<img id="preViewImg" src="" style="width: 100%;height: 150px;  display:none;">
											<img id="sinImg" src="Vist/img/cfg_persona_sin-foto.png" style="width: 100%;height: 150px;  display:block;">
										</div>
									</div>																					
								</div>
							</div>
							<!-- FIN DE DATOS DEL SOLICITANTE -->
							<!-- DATOS DE LA PERSONA ASIGNADA AL EQUIPO -->
							<div class="col-md-12 datos-persona-asignada" style="display: none;">
								<div class="row">
									<div class="col-md-9">										
										<h4><b>Datos de persona asignada al equipo:</b></h4>
										<div class="row">
											<div class="col-md-6">											
												<div class="form-group">
												    <label for="1">Cedula :</label>
												    <input type="text" class="form-control input-sm" id="cedulaTxtPA" placeholder="" disabled="TRUE">
												</div>											
											</div>				
											<div class="col-md-6">
												<div class="form-group">
													<label for="1">Nombre y Apellido :</label>
												    <input type="text" class="form-control input-sm" id="nombreApellidoTxtPA" placeholder="" disabled="TRUE">
												</div>																						
											</div>																					
										</div>
										<div class="row">
											<div class="col-md-6">											
												<div class="form-group">
												    <label for="1">Cargo :</label>
												    <input type="text" class="form-control input-sm" id="cargoTxtPA" placeholder="" disabled="TRUE">
												</div>											
											</div>				
											<div class="col-md-6">											
												<div class="form-group">
												    <label for="1">Departamento :</label>
												    <input type="text" class="form-control input-sm" id="departamentoTxtPA" placeholder="" disabled="TRUE">
												</div>											
											</div>				
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Correo electronico</label>
													<input type="text" class="form-control input-sm" id="correoTxtPA" placeholder="" disabled="TRUE">
												</div>
											</div>																		
										</div>
									</div>				
									<div class="col-md-3">
										<label for="1">Fotografia :</label>
										<div id="cfgFotoPerfil" class="cfgFotoPerfil" style="	width: 100%; float:left; border: ridge;">
											<img id="preViewImgPA" src="" style="width: 100%;height: 150px;  display:none;">
											<img id="sinImgPA" src="Vist/img/cfg_persona_sin-foto.png" style="width: 100%;height: 150px;  display:block;">
										</div>
									</div>																					
								</div>
							</div>
							<!-- FIN DEDATOS DE LA PERSONA ASIGNADA AL EQUIPO -->							
						</div>
						<!-- FIN DATOS DE RESPONSABLES EN SOLICITUD-->
						<br>
					<hr style="display: none;">
						<div class="row" style="padding: 0px 15px 0px 15px;">
							<div class="col-md-12" style="border: 1px solid white;margin-left: 0px;padding: 0px;background: hsla(0, 0%, 83%, 0.64);">
									<div id="panelModalSolicitud">

										<div class="row">
											<div class="col-md-6" style="margin: 0px;padding-right: 15px;padding-left: 15px; background: rgb(35, 95, 146); color: white;border-right: 1px solid #ccc;">
									    <label for="1">El equipo seleccionado es sobre el que se realiza la solicitud</label>										
											</div>
											<div class="col-md-6" style="margin: 0px;padding-right: 15px;padding-left: 15px; background: rgb(35, 95, 146); color: white;">
													<label for="1">Detalles</label>
											</div>											
										</div>

										<div id="" class="row panel-body" style="height: 74%;"> 
											<div class="col-md-6" style="background: #fff;">
												<!-- INICIO DE PANEL DE SELECCION DE EQUIPO-->
												<br>
												<!-- Nav tabs -->
												<ul class="nav nav-tabs" role="tablist" id="pestañasEquiposSolicitud">
													<li role="presentation" class="active" id="tab-personales">
														<a href="#personales" aria-controls="personales" role="tab" data-toggle="tab" onclick="mtdSolicitud.cargarListaEquipoPersonaPublic(1),					   setTimeout(function(){ 
																	   		mtdSolicitud.actListEquiposPublic();
																	   		mtdSolicitud.reinicioSelectEquiposDptPublic();		
																	   },500); 
																	   $('#btnSolicitar').data('id_equipo','');
																	   ">
															 Personales 
														</a>
													</li>
													<li role="presentation" id="tab-responsabilidad">
														<a href="#responsabilidad" aria-controls="responsabilidad" role="tab" data-toggle="tab"
														onclick="
																							setTimeout(function(){ 
																								mtdSolicitud.actListEquiposDptPublic();	
																								mtdSolicitud.reinicioSelectEquiposDptPublic();	
																							},500);
																				   $('#btnSolicitar').data('id_equipo','');																							
														"> Responsabilidad en departamentos
														</a>
													</li>
												</ul>
											    <div class="tab-content">
												    <!--PRIMER PANEL TAB-->
											    	 <div role="tabpanel" class="tab-pane active" id="personales">
														<div id="equiposSolicitanteList" class="list-group" style="FONT-SIZE: smaller;">
														</div>							
														<div id="pgnEquiposSolicitanteList">
															<div id="pagination">
															</div>
														</div>
													</div> 
												    <!--SEGUNDO PANEL TAB-->
											    	 <div role="tabpanel" class="tab-pane " id="responsabilidad">
														<div class="row">
															<div class="col-md-6 col-md-offset-0">
		  					   							        <label for="donde">Seleccionar departamento :</label>  
															  	<div id="divDepartamentoListD" class="form-group">
														    		<select  id="departamentoListD" class="select campo-control selectpicker lista-control" data-select="1" name="Departamento (Opcional)" data-show-subtext="true" data-live-search="true"  
														    		 onchange="
																							mtdSolicitud.cargarListaEquiposDepartamentoPublic(1),					   
																							setTimeout(function(){ 
																								mtdSolicitud.actListEquiposDptPublic();	
																							},500);
														    		 ">
																		<option data-subtext="" value="0" data-idcargo="0" >No hay datos</option>
														   			</select>
																</div>	
	
														  	</div>
														</div>
														<div id="equiposResponsabilidadList" class="list-group" style="FONT-SIZE: smaller;">
														</div>							
														<div id="pgnEquiposResponsabilidadList">
															<div id="pagination">
															</div>
														</div>
													</div> 
												</div>

												<!-- FIN DE PANEL DE SELECCION DE EQUIPO-->
											</div>			
											<div class="col-md-6 col-md-offset-0" style="border: 1px solid #ccc;">
											<br>
												<div class="row" style="background: rgba(216, 216, 216, 0.63); border: 1px solid #ccc;">
													<div class="col-md-12">
														<div class="form-group">
															<label for="1">Asunto : (Titulo/Resumen de la solicitud)</label>														
															<input type="text" class="campo-control form-control" name="Asunto" id="asuntoTxt" placeholder="Introducir asunto..."
															onblur="
													    			if($('#asuntoTxt').val().length>100 || $('#asuntoTxt').val().length<8){
														    			if($('#asuntoTxt').val().length>100){
						    												nucleo.alertaErrorPublic('El asunto tiene :'+$('#asuntoTxt').val().length+' caracteres, máximo 100 ');
														    				$('#btnSolicitar').attr('disabled', true);
														    			}
														    			if($('#asuntoTxt').val().length<8){
						    												nucleo.alertaErrorPublic('El asunto tiene :'+$('#asuntoTxt').val().length+' caracteres, minimo 8 ');
														    				$('#btnSolicitar').attr('disabled', true);
														    			}
													    			}else{
													    				$('#btnSolicitar').attr('disabled', false);
													    			}
													    		" 
													    		onkeypress="
													    			if($('#asuntoTxt').val().length>100 || $('#asuntoTxt').val().length<8){
														    			if($('#asuntoTxt').val().length>100){
														    				$('#btnSolicitar').attr('disabled', true);
														    			}
														    			if($('#asuntoTxt').val().length<8){
														    				$('#btnSolicitar').attr('disabled', true);
														    			}
													    			}else{
													    				$('#btnSolicitar').attr('disabled', false);
													    			}
													    			nucleo.verificarDatosInputPublic(event,this,'');
													    		" 
															onkeyup="nucleo.verificarDatosPublic('','','asuntoTxt','asuntoTxt')"
															rows="10" data-sololetrayespacio="1"required="true" >
														</div>						
													</div>				
												</div>
											    <div class="row" id="mensajeDescripcion">

													    <div class="col-md-12" style="background: rgba(216, 216, 216, 0.63); border: 1px solid #ccc;">
															<br>

															<label>Descripcion de solicitud :</label>
													    	<textarea type="text" name="descripcion" class="campo-control form-control input-sm textarea" id="descripcionTxt" placeholder="Ingresar descripcion" 
													    		onblur="
													    			if($('#descripcionTxt').val().length>255 || $('#descripcionTxt').val().length<15){
														    			if($('#descripcionTxt').val().length>255){
						    												nucleo.alertaErrorPublic('La descripción tiene :'+$('#descripcionTxt').val().length+' caracteres, máximo 255 ');
														    				$('#btnSolicitar').attr('disabled', true);
														    			}
														    			if($('#descripcionTxt').val().length<15){
						    												nucleo.alertaErrorPublic('La descripción tiene :'+$('#descripcionTxt').val().length+' caracteres, minimo 15 ');
														    				$('#btnSolicitar').attr('disabled', true);
														    			}
													    			}else{
													    				$('#btnSolicitar').attr('disabled', false);
													    			}
													    		" 
													    		onkeypress="
													    			if($('#descripcionTxt').val().length>255 || $('#descripcionTxt').val().length<15){
														    			if($('#descripcionTxt').val().length>255){
														    				$('#btnSolicitar').attr('disabled', true);
														    			}
														    			if($('#descripcionTxt').val().length<15){
														    				$('#btnSolicitar').attr('disabled', true);
														    			}
													    			}else{
													    				$('#btnSolicitar').attr('disabled', false);
													    			}
													    			nucleo.verificarDatosInputPublic(event,this,'');
													    		" 
																rows="10" 
																maxlength="255"required="true" data-descripcionnumero="1"
													    	 ></textarea>		
															<div id="fechaSolicitado"></div>
															<br>
													    </div>
												</div>
												<br>
												<div class="row">
													    <div  id="atencionSolicitud" class="col-md-12" style=" display: none; background: rgba(216, 216, 216, 0.63);border: 1px solid #ccc;padding: 5px;">
														</div>
												</div>																			
												<br>
												<div class="row">
													    <div id="equipoSolicitudDanado"  class="col-md-12" style="display: none; background: rgba(216, 216, 216, 0.63);border: 1px solid #ccc;padding: 5px;">
													  		El equipo se encuentra dañado, porfador espere que los técnicos le asignen uno disponible y se lo entreguen.
														</div>
												</div>																			
												<br>												
												<div id="mensajeRespuesta" class="row" style="display: none;">
									    <div class="col-md-12 col-md-offset-0" style="background: rgba(216, 216, 216, 0.63); border: 1px solid #ccc;">
														<br>
														<label>Respuesta de la solicitud :</label>  
												    	<textarea type="text" name="observacion" class=" form-control input-sm textarea" id="observacionTxt" onkeyup="nucleo.verificarDatosPublic('','','observacionTxt','')" rows="3" data-cantmax="255" maxlength="255" data-cantmin="15" data-vexistencia="0" data-solonumero="0" data-sololetra="0" data-sololetrayespacio="0" data-descripcion="1" data-vcorreo="0" disabled="true"></textarea>	
														<div id="respuestaFecha"></div>		    	
														<br>
													</div>
											 </div>
											    <br>

												<div id="mensajesConformidad" class="row" style="display: none;">
													 <div class="col-md-12 col-md-offset-0" style="background: rgba(216, 216, 216, 0.63); border: 1px solid #ccc;">
															<br>
															<div id="listaConformidades" style="display: none;">
																<label>Inconformidades</label>
																<div id="contenido">
															
																</div>
																<hr>
															</div>
															<div class="row" >
																<div class="col-md-12">
												      <label id="conformidadAtencion" style="display: none;text-align: center;"></label>																	
												      <label id="conformidad" style="display: none;text-align: center;">	
												      ¿ Se encuentra conforme con el servicio reciente ?</label>	
												      <label id="conformidadAceptada" style="display: none; text-align: center;"></label>					  
												      <label id="fechaConformidadAceptada" style="display: none; text-align: center;"></label>					  
																		<div id="conformidadOpciones" class="btn-group" data-toggle="buttons">
																		  <label class="btn btn-primary"  onclick="
																		  				 $('#siCbox').val(1);$('#noCbox').val(0);	
																		  							$('#mensajesConformidad #btnConformidad').attr('disabled', false);
																										$('.panel-no').collapse('hide'); " >
																		    <input type="radio" name="options" id="siCbox" value="0" autocomplete="off">
																		     Si
																		  </label>
																		  
																		  <label class="btn btn-primary" onclick="$('.panel-no').collapse('show'); 
																								$('#siCbox').val(0);$('#noCbox').val(1); 
																								$('#mensajesConformidad #btnConformidad').attr('disabled', true);
																								">
																		    <input type="radio" name="options" id="noCbox" value="1" autocomplete="off" style="background:#f2dede;" > No
																		  </label>
																		</div>
																		<br>
																		<br>

																	<div class="collapse panel-no" id="collapseExample">
																	  <div class="well">

																			  <label>Observación:</label>
																	    	<textarea type="text" name="observacion" class=" form-control input-sm textarea" id="observacionTxt" 
																	    			rows="3" placeholder="Introduzca porque no esta conforme con el servicio" 
																	    			onkeyup="nucleo.verificarDatosPublic('','','mensajesConformidad #observacionTxt','mensajesConformidad #observacionTxt')" 
																	    			data-descripcion="1" 
																								onblur="
																									if($('#mensajesConformidad #observacionTxt').val().length>100 || $('#mensajesConformidad  #observacionTxt').val().length<15){
																										if($('#mensajesConformidad #observacionTxt').val().length>100){
																											nucleo.alertaErrorPublic('La observación tiene :'+$('#mensajesConformidad  #observacionTxt').val().length+' caracteres, máximo 100 ');
																											$('#mensajesConformidad #btnConformidad').attr('disabled', true);
																										}
																										if($('#mensajesConformidad  #observacionTxt').val().length<15){
																											nucleo.alertaErrorPublic('La observación tiene :'+$('#mensajesConformidad  #observacionTxt').val().length+' caracteres, minimo 15 ');
																											$('#mensajesConformidad  #btnConformidad').attr('disabled', true);
																										}
																									}else{
																										$('#mensajesConformidad  #btnConformidad').attr('disabled', false);
																									}
																								" 
																								onkeypress="
																									if($('#mensajesConformidad  #observacionTxt').val().length>100 || $('#mensajesConformidad  #observacionTxt').val().length<15){
																										if($('#mensajesConformidad  #observacionTxt').val().length>100){
																											$('#mensajesConformidad  #btnConformidad').attr('disabled', true);
																										}
																										if($('#mensajesConformidad #observacionTxt').val().length<15){
																											$('#mensajesConformidad #btnConformidad').attr('disabled', true);
																										}
																									}else{
																										$('#mensajesConformidad #btnConformidad').attr('disabled', false);
																									}
																								" 

																	    	></textarea>	
																		
																			</div>
																  </div>
																				<div class="row" style="margin-top: 10px;">
																				<div class="col-md-4 col-md-offset-8">
																					<div class="btn-group" role="group" style="width: 100%;">
																						<button type="button" class="btn btn-default" id="btnConformidad" data-id_solicitud="" onclick="mtdSolicitud.guardarConformidadPublic();" style="width: 100%;" disabled="TRUE">Enviar</button>
																					</div>																			
																				</div>
																			</div> 
																</div>																
															</div>
		    	
															<br>
													    </div>
											    </div>



											    <br>

												<div id="confirmarEquipoRecibido" class="row" style="display: none;">
													 <div class="col-md-12 col-md-offset-0" style="background: rgba(216, 216, 216, 0.63); border: 1px solid #ccc;">
															<br>
															<div id="listaConformidades" style="display: block;">
																<label>Confirmación:</label>
																<div id="contenido">
															
																</div>
																<hr>
															</div>
															<div class="row" >
																<div class="col-md-12">
												      <label id="conformidad" style="display: block;text-align: center;">	
												      ¿ El equipo asignado, ha sido recibido ?</label>	
																		<div id="conformidadOpciones" class="" data-toggle="buttons"><!--class-btn-group-->
																		  <label class="btn btn-primary"  onclick="
																		  				 $('#siCbox').val(1);$('#noCbox').val(0);	
																		  							$('#confirmarEquipoRecibido #btnConformidad').attr('disabled', false);
																										$('.panel-no').collapse('hide'); " >
																		    <input type="radio" name="options" id="siCbox" value="0" autocomplete="off">
																		     Si
																		  </label>
																		</div>
																		<br>
																		<br>

																				<div class="row" style="margin-top: 10px;">
																				<div class="col-md-4 col-md-offset-8">
																					<div class="btn-group" role="group" style="width: 100%;">
																						<button type="button" class="btn btn-default" id="btnConformidad" data-id_solicitud="" onclick="mtdSolicitud.guardarConformidadPublic();" style="width: 100%;" disabled="TRUE">Enviar</button>
																					</div>																			
																				</div>
																			</div> 
																</div>																
															</div>
		    	
															<br>
													    </div>
											    </div>

												<div class="row" id="mensajeFinalizacion" style="display:none;">

													    <div class="col-md-12" style="background: rgba(216, 216, 216, 0.63); border: 1px solid #ccc;">
															<br>

															<label id="lbObservacionFinal" style="display:none;">Observación de finalización :</label>
													    	<textarea type="text" name="descripcion" class="campo-control form-control input-sm textarea" id="mensajeFinalizacionTxt" placeholder="Ingresar descripcion" 
																rows="5" style="display:none;" 
																maxlength="255"required="true" data-descripcionnumero="1"
													    	 ></textarea>		
															<div id="fechaCierre"></div>
															<br>
													    </div>
												</div>

											    <br>
											</div>
											</div>


										</div>	




									</div>
							</div>							
						</div>
								<br>
								<div class="row" style="margin-bottom: 10px;">
									<div class="col-md-3 col-md-offset-9">
										<div class="btn-group" role="group" style="width: 100%;">
											<button type="submit" class="btn btn-default" id="btnSolicitar" data-id_equipo=""  onclick="mtdSolicitud.guardarPublic()" style="width: 100%;">Enviar Solicitud</button>
										</div>	
										<br>									
								
									</div>
								</div> 
				</form>
				<div id="procesandoDatosDialg" style="display:none;">
	<img src="Vist/img/cargando2.gif" class="img-cargando" style="
	    width: 15%;
	    height: 30%;
	    margin-left: 43%;
	    margin-right: 42%;
	    margin-top: 17%;
	    margin-bottom: 14.3%;
	">
</div>

<div id="procesandoDatosInput" style="display:none;">
	<img src="Vist/img/cargando2.gif" style="
	    width: 20%;
	    height: 25px;
	    margin-left: 40%;
	    margin-right: 40%;	    
	">
</div>
			</div>				
		</div>

<script type="text/javascript">
	$('#vtnSolicitud #form').css("display", "none");
	$('#vtnSolicitud #procesandoDatosDialg').css("display", "block");
//		mtdSolicitud.Iniciar();
</script>