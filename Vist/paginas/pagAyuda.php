<div class="panel panel-default">
<!-- Panel principal (Catalogo) -->
<div class="panel panel-primary"> 
	<!-- Cabecera de panel para catalogos -->
	<div class="panel-heading" style="padding: 5px 5px  0px 0px;">
		<ul class="nav nav-tabs">
		  	<li role="presentation" name="Consumibles" class="opcion12" data-permisos="">
			  	<a href="javascript:;" class="pestana-tab-activo" id="tabBasico" 
			  		onclick="panelTabs.cambiarCatalogoTabsPublic(
				  		'manuales/Manual-usuario-comun.php', 
			      		datosIdsTabs=['tabBasico','tabUsuario','tabSistema']
			   	)">
		      		Basíco 
		    	</a>
	      	</li>
		  	<li role="presentation" name="Consumibles" class="opcion13" data-permisos="">
			  	<a href="javascript:;" class="pestana-tab-inactivo" id="tabUsuario" 
			  		onclick="panelTabs.cambiarCatalogoTabsPublic(
				  		'manuales/Manual-de-usuario.php', 
			      		datosIdsTabs=['tabUsuario','tabBasico','tabSistema']
			   	)">
		      		Usuario 
		    	</a>
	      	</li>
		  	<li role="presentation" name="Consumibles" class="opcion14" data-permisos="" style="display:none;">
			  	<a href="javascript:;" class="pestana-tab-inactivo" id="tabSistema"
			  		onclick="panelTabs.cambiarCatalogoTabsPublic(
				  		'manuales/Manual-del-sistema.php', 
			      		datosIdsTabs=['tabSistema','tabBasico','tabUsuario' ]
			   	)">
		      		Sistema 
		    	</a>
	      	</li>

		</ul>
	</div> 
	<!--Catalogo-->
	<div id="catalogo" style="width: 100%;height: 90%;">

		<!-- Espacio para catalogos -->

	</div>
</div>
<!-- Iniciando carga de complementos -->

	<script type="text/javascript">
		var id_perfil_ = sessionStorage.getItem('id_perfil-US');
		// 'tabBasico','','tabSistema']
		switch(id_perfil_){


			case '3':			
				$('a#tabBasico').css('display','block');			
				$('a#tabUsuario').css('display','none');
				$('a#tabSistema').css('display','none');
				panelTabs.cambiarCatalogoTabsPublic(
				  		'manuales/Manual-usuario-comun.php',
			      		datosIdsTabs=['tabUsuario','tabBasico','tabSistema']
			   	);				
			break;
			default:
				$('a#tabBasico').css('display','none');			
				$('a#tabUsuario').css('display','block');
				//$('a#tabSistema').css('display','block');
				panelTabs.cambiarCatalogoTabsPublic(
				  		'manuales/Manual-de-usuario.php', 
			      		datosIdsTabs=['tabUsuario','tabBasico','tabSistema']
			   	)				
			break;
		};
	</script>

<!-- Fin de cargar complementos --></div>