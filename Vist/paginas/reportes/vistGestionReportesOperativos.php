<!-- Iniciando carga de complementos -->

	<script type="text/javascript">
		panelTabs.cambiarCatalogoPublic(configuracion.urlsPublic().modReporte.tabs.actividadesSolicitud.catalogo);
    </script>

<!-- Fin de cargar complementos -->


<!-- Panel principal (Catalogo) -->
<div class="panel panel-primary"> 
	<!-- Cabecera de panel para catalogos -->
	<div class="panel-heading" style="padding: 5px 5px  0px 0px;">
		<ul class="nav nav-tabs">
		  	<li role="presentation" name="Consumibles" class="opcion13" data-permisos="">
		  		<a href="javascript:;" class="pestana-tab-activo" id="tabSolicitud" 
		  			onclick="panelTabs.cambiarCatalogoTabsPublic(
				  		configuracion.urlsPublic().modReporte.tabs.actividadesSolicitud.catalogo, 
			      		['tabSolicitud','tabMantPreventivo','tabRendiServicio']
			   	)">
		  			Actividades de solicitud
		  		</a>
		  	</li>		 		  	 	
		  	<li role="presentation" name="Mant preventivo" class="opcion13" data-permisos="">
		  		<a href="javascript:;" class="pestana-tab-inactivo" id="tabMantPreventivo" 
		  			onclick="panelTabs.cambiarCatalogoTabsPublic(
				  		configuracion.urlsPublic().modReporte.tabs.mantPreventivo.catalogo, 
			      		['tabMantPreventivo','tabSolicitud' ]
			   	)">
		  			Mantenimiento preventivo
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