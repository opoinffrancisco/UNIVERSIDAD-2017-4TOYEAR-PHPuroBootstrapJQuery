	

		<!-- Panel de Ventana modal-->
		<div id="vtnFinalizarSolicitud" class="panel panel-primary ventana-modal-panel-expandido ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Finalizar mantenimiento 
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarSinReinicPublic('ventana-modal-capa2')">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
				<form id="form" method="POST" >
						<input type="text" id="datoControl" value="" style="display:none;"></input>
						<input type="text" id="datoControlId" value="" style="display:none;"></input>
						<br>
						<div class="row">
							<div class="col-md-12" style="text-align: center;">
							¿ Realmente desea finalizar el mantenimiento ?
							</div>
						</div>
						<br>
						<hr>						
						<div class="row" style="margin-bottom: 10px;">
							<div class="col-md-6 col-md-offset-3">
								<div class="btn-group" role="group" style="width: 100%;">
									<button type="button" class="btn btn-default abrir-panel-datos" style="width: 100%; "
										 onclick="$('.panel-observacion-extra').css('display', 'block'),
												  $('.abrir-panel-datos').css('display', 'none'),
												  $('.cerrar-panel-datos').css('display', 'block')" 
									>Necesito ingresar una observación extra</button>
								</div>	
								<div class="btn-group" role="group" style="width: 100%;">
									<button type="button" class="btn btn-default cerrar-panel-datos" style="width: 100%; display:none;"
										 onclick="$('.panel-observacion-extra').css('display', 'none'),
												  $('.abrir-panel-datos').css('display', 'block'),
												  $('.cerrar-panel-datos').css('display', 'none')" 
									>Ya no necesito ingresar una observación extra</button>
								</div>									
							</div>
						</div> 								
						<div  class="row panel-observacion-extra" style="display:none;">
							<div class="col-md-8 col-md-offset-2">
						
						    	<textarea type="text" name="observacion" class="campo-control form-control input-sm textarea" id="observacionTxt" 
						    		placeholder="Ingresar observación" 
						  			onkeyup="nucleo.verificarDatosPublic('','','vtnFinalizarSolicitud observacionTxt','')"
						  			rows="5" 
						    		data-descripcion="1" required="true"
									onblur="
										if($('#observacionTxt').val().length>255 ){
											if($('#observacionTxt').val().length>255){
												nucleo.alertaErrorPublic('La observación tiene :'+$('#observacionTxt').val().length+' caracteres, máximo 255 ');
												$('#btnAceptarFinalizar').attr('disabled', true);
											}
										}else{
											$('#btnAceptarFinalizar').attr('disabled', false);
										}
									" 
									onkeypress="
										if($('#observacionTxt').val().length>255 ){
											if($('#observacionTxt').val().length>255){
												nucleo.alertaErrorPublic('La observación tiene :'+$('#observacionTxt').val().length+' caracteres, máximo 255 ');
												$('#btnAceptarFinalizar').attr('disabled', true);
											}
											
										}else{
											$('#btnAceptarFinalizar').attr('disabled', false);
										}
									" 
						    		></textarea>		

							</div>					
						</div>
						<hr>
						<div class="row">
							<div class="col-md-2 col-md-offset-10">
						  	  	<div id="divDetalles" class="form-group">								
									<a href="javascript:;" onclick="">
									    <button type="button" class="btn btn-default" id="btnAceptarFinalizar" 
									    	onclick="mtdMantenimientoEquipo.guardarFinalizacionSolicitudPublic();">
									    <!-- disabled="false" -->
									  		Aceptar<!--<span class="glyphicon glyphicon-plus-sign"></span>-->
									  	</button>
									</a>	
								</div>	
							</div>		
						</div>					
				</form>
				<?php 

					include '../../../../secciones/dialogo/procesandoDatos.php';

				?>
			</div>				
		</div>



<!-- carga de complementos catalogo/ventana modal relacionados // Estos complementos deben de ser los ultimos en cargar-->
<script type="text/javascript">

</script>
