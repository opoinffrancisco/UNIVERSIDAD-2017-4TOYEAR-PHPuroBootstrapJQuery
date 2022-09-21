

		<!-- Panel de Ventana modal-->
		<div id="vtnCargo" class="panel panel-primary ventana-modal-panel-expandido ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestione el cargo
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal'),mtdCargo.restablecerFormPublic()">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body" style="margin: 0px;padding: 15px 0px 15px 0px;"> 
					<form id="form" method="POST" >
							<input type="text" id="datoControl" value="" style="display:none;"></input>
							<input type="text" id="datoControlId" value="" style="display:none;"></input>
							<div class="row">
								<div class="col-md-6 col-md-offset-1 ">
								      <label for="modulo">Nombre:</label>							  
									  	<div id="divNombreTxt" class="form-group">
								    	<input type="text" name="nombre" class="campo-clave campo-control form-control input-sm" id="nombreTxt" placeholder="Ingresar nombre" 
								  			onkeypress="nucleo.verificarDatosInputPublic(event,this,'divNombreTxt')"
											onkeyup="nucleo.verificarDatosPublic('cfg_pn_cargo','nombre','nombreTxt','divNombreTxt')" 								  											    		
								    		data-cantmax="30" maxlength="30" data-cantmin="4" data-vexistencia="1" 
								    		data-sololetrayespacio="1" required="true" >

								  	</div>				  	
								</div>
								<div class="col-md-5 col-md-offset-0 ">
									<br>
								  	<div class="checkbox">
								    	<label>
								      		<input type="checkbox" id="responsableCbox"> Responsable de departamento
								    	</label>
								  	</div>
								</div>								
							</div> 
							 	
						<hr>
							<div class="row">
								<div class="col-md-2 col-md-offset-10">
							  		<button type="submit" id="btnGuardar" class="btn btn-default" >Guardar</button>
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
		mtdCargo.Iniciar();
		nucleo.asignarPermisosBotonesPublic(13);
		nucleo.guardarBitacoraPublic("INGRESO EN EL MODULO DE CONFIGURACIÓN - DEPARTAMENTOS - SECCIÓN : CARGOS"); 				
</script>
