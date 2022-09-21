

<!-- Panel principal (Catalogo) -->
<div class="panel panel-primary"> 
	<!-- Cabecera de panel para catalogos -->
	<div class="panel-heading" style="padding: 5px 5px  0px 0px;">
		<ul class="nav nav-tabs">
		  	<li role="presentation" name="Personas" class="opcion10" data-permisos=""  >
			  	<a href="javascript:;" class="pestana-tab-activo" id="tabGestionarPersona" 
			  		onclick="panelTabs.cambiarPulico(
				  		configuracion.urlsPublic().modPersona.tabs.persona.catalogo, 
				  		configuracion.urlsPublic().modPersona.tabs.persona.ventanaModal,
			      		datosIdsTabs=['tabGestionarPersona','tabPerfil','tabCargo']
			   	)">
		      		Personas
		    	</a>
	      	</li>
		  	<li role="presentation"  name="Perfiles" class="opcion11" data-permisos="">
		  		<a href="javascript:;" class="pestana-tab-inactivo" id="tabPerfil" 
		  			onclick="panelTabs.cambiarPulico(
		  			configuracion.urlsPublic().modPersona.tabs.perfil.catalogo, 
		  			configuracion.urlsPublic().modPersona.tabs.perfil.ventanaModal, 
		  			datosIdsTabs=['tabPerfil','tabGestionarPersona','tabCargo']
		  		)">
		  			Perfiles
		  		</a>
		  	</li>	  	
		</ul>
	</div> 
	<!--Catalogo-->
	<div id="catalogo">

		<!-- Espacio para catalogos -->

	</div>
</div>

<!--////////////////////////////////////////////////////////////////////////////////////////////////-->
<!-- Ventana Modal -->
	<!-- Fondo/Capa de venta -->
<div id="ventana-modal" class="ventana-modal ventana-modal-panel-accionCerrar" style="overflow:auto;">

	<!-- Espacio para ventanas modales -->

</div>
<div id="ventana-modal-capa2" class="ventana-modal-capa2 ventana-modal-panel-accionCerrar">

	<!-- Espacio para ventanas modales -->

</div>
<!-- Iniciando carga de complementos -->

	<script type="text/javascript">
	    nucleo.asignarSubPermisosPublic(10);
    	panelTabs.cambiarCatalogoPublic(configuracion.urlsPublic().modPersona.tabs.persona.catalogo);
		panelTabs.cambiarVentanaModalPublic(configuracion.urlsPublic().modPersona.tabs.persona.ventanaModal);
	</script>

<!-- Fin de cargar complementos -->
