	
	<script type="text/javascript">
		//para iniciar la primera carga 
		panelTabs.cambiarFormularioPublico(
			configuracion.urlsPublic().equipo.tabsDetallar.detalles, 
	  		'form',
      		datosIdsTabs=[ 'tabDetalles' , 'tabPerifericos' , 'tabComponentes' , 'tabSoftware'  ]
		);
	</script>

		<!-- Panel de Ventana modal-->
		<div id="vtnProcsEquipoConsulta" class="panel panel-primary ventana-modal-panel-grande panel-vtn-content-datos" style="margin-left: 5%;">
	
			<!-- Cabecera -->
			<div class="panel-heading" style="padding: 5px 5px  0px 0px;">
					<ul class="nav nav-tabs">
					  	<li role="presentation" >
						  	<a href="javascript:;" class="pestana-tab-activo" id="tabDetalles" 
						  		onclick="panelTabs.cambiarFormularioPublico(
									configuracion.urlsPublic().equipo.tabsDetallar.detalles, 
							  		'form',
						      		datosIdsTabs=[ 'tabDetalles' , 'tabSoftware'  ]
						   	)">
					      		Detalles del equipo
					    	</a>
				      	</li>  	
						<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="top: 10px;right: 10px; position: relative;" 
						onclick="ventanaModal.ocultarPulico('ventana-modal-capa-base');
								 mtdEquipo.cargarCatalogoPublic(1);">x</a>
					</ul>


			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body" style="padding: 0px;"> 
				<input type="text" id="datoControl" value="" style="display:none;"></input>
				<input type="text" id="datoControlId" value="" style="display:none;"></input>
				<form id="form" method="POST" >
				
				</form>
				<?php 

					include '../../../../../../secciones/dialogo/procesandoDatos.php';

				?>
			</div>				
		</div>