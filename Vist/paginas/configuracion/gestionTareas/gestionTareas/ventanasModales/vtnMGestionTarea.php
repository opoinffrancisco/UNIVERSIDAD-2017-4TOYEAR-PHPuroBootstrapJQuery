

		<!-- Panel de Ventana modal-->
		<div id="vtnTarea" class="panel panel-primary ventana-modal-panel-expandido ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestionar la tarea
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal'),mtdTarea.restablecerFormPublic()">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
					<form id="form" method="POST" >
							<input type="text" id="datoControl" value="" style="display:none;"></input>
							<input type="text" id="datoControlId" value="" style="display:none;"></input>
							<div class="row">
								<div class="col-md-5 col-md-offset-1">
								      <label for="modulo">Nombre:</label>							  
									  	<div id="divNombreTxt" class="form-group">
								    	<input type="text" name="nombre" class="campo-clave campo-control form-control input-sm" id="nombreTxt" placeholder="Ingresar nombre" 
								  			onkeypress="nucleo.verificarDatosInputPublic(event,this,'divNombreTxt')"
											onkeyup="nucleo.verificarDatosPublic('cfg_tarea','nombre','nombreTxt','divNombreTxt')" 
								    		data-cantmax="100" maxlength="100" data-cantmin="5"  data-vexistencia="1"
								    		data-sololetrayespacio="1" required="true" >
								  	</div>				  	
								</div>
								<div class="col-md-5 col-md-offset-0 ">
									<br>
								  	<div class="checkbox">
								    	<label>
								      		<input type="checkbox" id="tareaCorrectivaCbox"> Es una tarea de mantenimiento correctiva.
								    	</label>
								  	</div>
								</div>									
							</div>  
							<div class="row">
								<div class="col-md-8 col-md-offset-1">
								      <label for="modulo">Descripción:</label>							  
									  	<div id="divDescripcionTxt" class="form-group">
								    	<textarea type="text" name="descripcion" class="campo-control form-control input-sm textarea" id="descripcionTxt" placeholder="Ingresar descripcion"
								  			onkeypress="nucleo.verificarDatosInputPublic(event,'','',this,'')"
								  			rows="3" 
								    		data-cantmax="255" maxlength="255" data-cantmin="0" data-descripcion="1" required="FALSE" >
								  		</textarea>
								  	</div>				  	
								</div>
							</div> 
												
							<hr>
								<div class="row">
									<div class="col-md-2 col-md-offset-10">
								  		<button type="button" id="btnGuardar" class="btn btn-default" >Guardar</button>
								  	</div>
							  	</div>
					</form>
				<?php 

					include '../../../../../secciones/dialogo/procesandoDatos.php';

				?>
			</div>				
		</div>



	<!-- carga de complementos catalogo/ventana modal relacionados // Estos complementos deben de ser los ultimos en cargar-->
<script type="text/javascript">
		mtdTarea.Iniciar();
</script>