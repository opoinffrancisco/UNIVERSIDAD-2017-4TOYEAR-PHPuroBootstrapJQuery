<!-- Iniciando carga de complementos -->

	<script type="text/javascript">
        panelTabs.cambiarCatalogoPublic(configuracion.urlsPublic().modReporte.tabs.rendimientoServicio.catalogo);
    </script>

<!-- Fin de cargar complementos -->


<!-- Panel principal (Catalogo) -->
<div class="panel panel-primary"> 
	<!-- Cabecera de panel para catalogos -->
	<div class="panel-heading" style="padding: 5px 5px  0px 0px;">
		<ul class="nav nav-tabs">
		  	<li role="presentation" name="Consumibles" class="opcion12" data-permisos="">
			  	<a href="javascript:;" class="pestana-tab-activo" id="tabRendiServicio" 
			  		onclick="panelTabs.cambiarCatalogoTabsPublic(
				  		configuracion.urlsPublic().modReporte.tabs.rendimientoServicio.catalogo, 
			      		['tabRendiServicio','tabAreasConcurrentesTareasCorrectivas','tabDesincorporacionesConcurrentes']
			   	)">
		      		Rendimiento de servicio
		    	</a>
	      	</li>
		  	<li role="presentation" name="Consumibles" class="opcion12" data-permisos="">
			  	<a href="javascript:;" class="pestana-tab-inactivo" id="tabAreasConcurrentesTareasCorrectivas" 
			  		onclick="panelTabs.cambiarCatalogoTabsPublic(
				  		'reportes/Gerenciales/areasConcurrentesTareasCorrectivas/catalogos/ctlgGestionAreasConcurrentesTareasCorrectivas.php', 
			      		['tabAreasConcurrentesTareasCorrectivas','tabRendiServicio','tabDesincorporacionesConcurrentes']
			   	)">
		      		Areas concurrentes de tareas correctivas
		    	</a>
	      	</li>
		  	<li role="presentation" name="Consumibles" class="opcion12" data-permisos="">
			  	<a href="javascript:;" class="pestana-tab-inactivo" id="tabDesincorporacionesConcurrentes" 
			  		onclick="panelTabs.cambiarCatalogoTabsPublic(
				  		'reportes/Gerenciales/desincorporacionesConcurrentes/catalogos/ctlgGestionDesincorporacionesConcurrentes.php', 
			      		['tabDesincorporacionesConcurrentes','tabAreasConcurrentesTareasCorrectivas','tabRendiServicio']
			   	)">
		      		Desincorporaciones y cambios concurrentes
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
<div id="ventana-modal-capa-base" class="ventana-modal ventana-modal-panel-accionCerrar" style="overflow:auto;">

	<!-- Espacio para ventanas modales -->

</div>
<!-- Ventana Modal - basica-->
	<!-- Fondo/Capa de venta -->
<div id="ventana-modal" class="ventana-modal ventana-modal-panel-accionCerrar">

	<!-- Espacio para ventanas modales -->

</div>
<script type="text/javascript">
	nucleo.guardarBitacoraPublic("INGRESO EN EL MODULO - REPORTES"); 
</script>