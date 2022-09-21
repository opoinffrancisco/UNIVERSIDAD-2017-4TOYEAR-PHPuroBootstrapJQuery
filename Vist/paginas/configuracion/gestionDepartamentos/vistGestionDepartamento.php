<!-- Panel principal (Catalogo) -->
<div class="panel panel-primary"> 
	<!-- Cabecera de panel para catalogos -->
	<div class="panel-heading" style="padding: 5px 5px  0px 0px;">
		<ul class="nav nav-tabs">
		  	<li role="presentation" name="Consumibles" class="opcion12" data-permisos="">
			  	<a href="javascript:;" class="pestana-tab-activo" id="tabDepartamento" 
			  		onclick="panelTabs.cambiarPulico(
				  		configuracion.urlsPublic().modDepartamento.departamento.catalogo, 
				  		configuracion.urlsPublic().modDepartamento.departamento.ventanaModal,
			      		datosIdsTabs=['tabDepartamento','tabCargo']
			   	)">
		      		Departamentos
		    	</a>
	      	</li>

		  	<li role="presentation" name="Consumibles" class="opcion13" data-permisos="">
		  		<a href="javascript:;" class="pestana-tab-inactivo" id="tabCargo" 
		  			onclick="panelTabs.cambiarPulico(
			  		configuracion.urlsPublic().modDepartamento.cargo.catalogo, 
			  		configuracion.urlsPublic().modDepartamento.cargo.ventanaModal,
		  			datosIdsTabs=['tabCargo','tabDepartamento']
		  		)">
		  			Cargos
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
<div id="ventana-modal" class="ventana-modal ventana-modal-panel-accionCerrar" style="overflow: auto;">

	<!-- Espacio para ventanas modales -->

</div>
<!-- Iniciando carga de complementos -->

	<script type="text/javascript">
    	    panelTabs.cambiarCatalogoPublic(configuracion.urlsPublic().modDepartamento.departamento.catalogo);
			panelTabs.cambiarVentanaModalPublic(configuracion.urlsPublic().modDepartamento.departamento.ventanaModal);        
			
    		nucleo.asignarSubPermisosPublic(12);
	</script>

<!-- Fin de cargar complementos -->