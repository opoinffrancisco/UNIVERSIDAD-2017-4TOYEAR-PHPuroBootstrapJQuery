	

		<!-- Panel de Ventana modal-->
		<div id="vtnFinalizarTarea" class="panel panel-primary ventana-modal-panel-mediano-sintop ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Finalizar tarea
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarSinReinicPublic('ventana-modal-capa2')">x</a>
				</h3>  
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
				<form id="form" method="POST" >
						<input type="text" id="datoControl" value="" style="display:none;"></input>
						<input type="text" id="datoControlId" value="" style="display:none;"></input>
						<div class="row">
							<div class="col-md-8">
								<b>
								Observación de la tarea realizada :
								</b>
							</div>
						</div>
						<div  class="row">
							<div class="col-md-12">
						
						    	<textarea type="text" name="descripcion" class="campo-control form-control input-sm textarea" id="observacionTxt" placeholder="Ingresar descripcion" 
						  			onkeyup="nucleo.verificarDatosPublic('','','observacionTxt','')"
						  			rows="10" 
						    		data-cantmax="255" maxlength="255" data-cantmin="15" data-descripcion="1" required="true" 
									onblur="
										if($('#observacionTxt').val().length>255 || $('#observacionTxt').val().length<15){
											if($('#observacionTxt').val().length>255){
												nucleo.alertaErrorPublic('La observación tiene :'+$('#observacionTxt').val().length+' caracteres, máximo 255 ');
												$('#btnGuardar').attr('disabled', true);
											}
											if($('#observacionTxt').val().length<15){
												nucleo.alertaErrorPublic('La observación tiene :'+$('#observacionTxt').val().length+' caracteres, minimo 15 ');
												$('#btnGuardar').attr('disabled', true);
											}
										}else{
											$('#btnGuardar').attr('disabled', false);
										}
									" 
									onkeypress="
										if($(' #observacionTxt').val().length>255 || $('#observacionTxt').val().length<15){
											if($('#observacionTxt').val().length>255){
												$('#btnGuardar').attr('disabled', true);
											}
											if($('#observacionTxt').val().length<15){
												$('#btnGuardar').attr('disabled', true);
											}
										}else{
											$('#btnGuardar').attr('disabled', false);
										}
										nucleo.verificarDatosInputPublic(event,this,'');
									" data-descripcionnumero="1"


						    	></textarea>		

							</div>					
						</div>
						<hr>
						<div class="row">
							<div class="col-md-2 col-md-offset-10">
						      	<label for="recurso" style="color:#ffffff;">|||||||||||||||||:</label>							  
						  	  	<div id="divDetalles" class="form-group">								
									<a href="javascript:;" onclick="mtdMantenimientoEquipo.cambiarEstadoTareaEquipoPublic(0,0,0,2);">
									    <button type="button" class="btn btn-default" id="btnGuardar" >
									    <!-- disabled="false" -->
									  		Guardar<!--<span class="glyphicon glyphicon-plus-sign"></span>-->
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
//		mtdCaracteristicasComponentes.Iniciar();
//		mtdCaracteristicasComponentes.cargarCatalogoPublic(1);	
$(function () {
	$('#observacionTxt').val('TAREA REALIZADA EXITOSAMENTE');
});


</script>
