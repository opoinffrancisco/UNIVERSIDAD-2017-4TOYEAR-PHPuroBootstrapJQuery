
<!-- Fin de cargar complementos -->


<!-- Panel principal (Catalogo) -->
<div class="panel panel-primary"> 
	<!-- Cabecera de panel para catalogos -->
	<div class="panel-heading" style="padding: 5px 5px  0px 0px;">
	<!-- Cabecera de panel para catalogos -->
	<div class="panel-heading" >
		<h3 class="panel-title">Tareas : </h3> 
	</div> 
	</div>
	<!--Catalogo-->
	<div id="catalogo">

		<!-- Espacio para catalogos -->

	</div>
</div>





<!--////////////////////////////////////////////////////////////////////////////////////////////////-->
<!-- Ventana Modal -->
	<!-- Fondo/Capa de venta -->
	<div id="ventana-modal" class="ventana-modal ventana-modal-panel-accionCerrar" >

		<!-- Espacio para ventanas modales -->

	</div>
<!-- Iniciando carga de complementos -->

	<script type="text/javascript">
		//para iniciar la primera carga 

    	panelTabs.cambiarCatalogoPublic(configuracion.urlsPublic().modTareas.tabs.tarea.catalogo);
		panelTabs.cambiarVentanaModalPublic(configuracion.urlsPublic().modTareas.tabs.tarea.ventanaModal);
		$(document).ready(function () {
			    nucleo.asignarSubPermisosPublic(14);
		});
	    

	</script>
