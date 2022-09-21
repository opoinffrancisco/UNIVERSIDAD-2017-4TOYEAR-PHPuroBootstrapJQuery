<!-- Panel principal (Catalogo) -->
<div class="panel panel-primary"> 
	<!-- Cabecera de panel para catalogos -->
	<div class="panel-heading" style="padding: 5px 5px  0px 0px;">
		<ul class="nav nav-tabs">
		  	<li role="presentation" name="Fabricante" class="opcion19" data-permisos="">
			  	<a href="javascript:;" class="pestana-tab-activo" id="tabTipo" 
			  		onclick="panelTabs.cambiarPulico(
				  		configuracion.urlsPublic().modCFisica.tabs.tipo.catalogo, 
				  		configuracion.urlsPublic().modCFisica.tabs.tipo.ventanaModal,
			      		datosIdsTabs=[ 'tabTipo' , 'tabModelo' , 'tabMarca' , 'tabInterfaz' , 'tabUnidadMedida' , ]
			   	)">
		      		Tipo
		    	</a>
	      	</li>
		  	<li role="presentation" name="Fabricante" class="opcion20" data-permisos="">
		  		<a href="javascript:;" class="pestana-tab-inactivo" id="tabMarca" 
		  			onclick="panelTabs.cambiarPulico(
		  				configuracion.urlsPublic().modCFisica.tabs.marca.catalogo, 
		  				configuracion.urlsPublic().modCFisica.tabs.marca.ventanaModal, 
		  				datosIdsTabs=[ 'tabMarca' , 'tabTipo' , 'tabModelo' , 'tabUnidadMedida' , 'tabInterfaz' ]
		  		)">
		  			Marca
		  		</a>
		  	</li>
		  	<li role="presentation" name="Fabricante" class="opcion21" data-permisos="">
		  		<a href="javascript:;" class="pestana-tab-inactivo" id="tabModelo" 
		  			onclick="panelTabs.cambiarPulico(
		  			configuracion.urlsPublic().modCFisica.tabs.modelo.catalogo, 
		  			configuracion.urlsPublic().modCFisica.tabs.modelo.ventanaModal, 
		  			datosIdsTabs=[ 'tabModelo' , 'tabTipo' , 'tabMarca' ,  'tabInterfaz' , 'tabUnidadMedida' ]
		  		)">
		  			Modelo
		  		</a>
		  	</li>		  	
		  	<li role="presentation" name="Fabricante" class="opcion22" data-permisos="">
		  		<a href="javascript:;" class="pestana-tab-inactivo" id="tabInterfaz" 
		  			onclick="panelTabs.cambiarPulico(
		  				configuracion.urlsPublic().modCFisica.tabs.interfaz.catalogo, 
		  				configuracion.urlsPublic().modCFisica.tabs.interfaz.ventanaModal, 
		  				datosIdsTabs=[ 'tabInterfaz' , 'tabTipo' , 'tabModelo' , 'tabMarca' , 'tabUnidadMedida']
		  		)">
		  			Interfaz de conexión
		  		</a>
		  	</li>
		  	<li role="presentation" name="Fabricante" class="opcion23" data-permisos="">
		  		<a href="javascript:;" class="pestana-tab-inactivo" id="tabUnidadMedida" 
		  			onclick="panelTabs.cambiarPulico(
		  				configuracion.urlsPublic().modCFisica.tabs.umCapacidad.catalogo, 
		  				configuracion.urlsPublic().modCFisica.tabs.umCapacidad.ventanaModal, 
		  				datosIdsTabs=[ 'tabUnidadMedida' , 'tabTipo' , 'tabModelo' , 'tabMarca' , 'tabInterfaz']
		  		)">
		  			Unidad de medida
		  		</a>	  	
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
       	panelTabs.cambiarCatalogoPublic(configuracion.urlsPublic().modCFisica.tabs.tipo.catalogo);
		panelTabs.cambiarVentanaModalPublic(configuracion.urlsPublic().modCFisica.tabs.tipo.ventanaModal);
		nucleo.asignarSubPermisosPublic(25);
	</script>

<!-- Fin de cargar complementos -->

<script type="text/javascript">
	nucleo.guardarBitacoraPublic("INGRESO EN EL MODULO DE CONFIGURACIÓN - CARACTERISTICAS DE LOGICAS"); 	
</script>