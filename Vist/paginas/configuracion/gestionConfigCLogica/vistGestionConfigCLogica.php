

<!-- Panel principal (Catalogo) -->
<div class="panel panel-primary"> 
	<!-- Cabecera de panel para catalogos -->
	<div class="panel-heading" style="padding: 5px 5px  0px 0px;">
		<ul class="nav nav-tabs">
		  	<li role="presentation" name="Tipo" class="opcion17" data-permisos="">
			  	<a href="javascript:;" class="pestana-tab-activo" id="tabTipo" 
			  		onclick="panelTabs.cambiarPulico(
				  		configuracion.urlsPublic().modCLogica.tabs.tipo.catalogo, 
				  		configuracion.urlsPublic().modCLogica.tabs.tipo.ventanaModal,
			      		datosIdsTabs=[ 'tabTipo' , 'tabDistribucion'  ]
			   	)">
		      		Tipo
		    	</a>
	      	</li>
		  	<li role="presentation" name="Fabricante" class="opcion18" data-permisos="">
		  		<a href="javascript:;" class="pestana-tab-inactivo" id="tabDistribucion" 
		  			onclick="panelTabs.cambiarPulico(
		  				configuracion.urlsPublic().modCLogica.tabs.distribucion.catalogo, 
		  				configuracion.urlsPublic().modCLogica.tabs.distribucion.ventanaModal, 
		  				datosIdsTabs=[ 'tabDistribucion' , 'tabTipo'  ]
		  		)">
		  			Distribución
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
	<div id="ventana-modal" class="ventana-modal ventana-modal-panel-accionCerrar" >

		<!-- Espacio para ventanas modales -->

	</div>
<!-- Iniciando carga de complementos -->

	<script type="text/javascript">
		//para iniciar la primera carga
	        panelTabs.cambiarCatalogoPublic(configuracion.urlsPublic().modCLogica.tabs.tipo.catalogo);
			panelTabs.cambiarVentanaModalPublic(configuracion.urlsPublic().modCLogica.tabs.tipo.ventanaModal);
			nucleo.asignarSubPermisosPublic(24);
	</script>

<!-- Fin de cargar complementos -->
<script type="text/javascript">
		nucleo.guardarBitacoraPublic("INGRESO EN EL MODULO DE CONFIGURACIÓN - CARACTERISTICAS LOGICAS");
</script>
