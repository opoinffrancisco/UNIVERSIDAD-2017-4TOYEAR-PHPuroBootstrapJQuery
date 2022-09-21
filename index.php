<!DOCTYPE html>
<html 	onclick="
			menuContextual.ocultarMenuPulic('menu-contextual');
			nucleo.activarSuspensionPublic();
	" 
	oncontextmenu="menuContextual.mostrarMenuPulic(event, this.id, 'menu-contextual'); return false;" >
<!--
	onclick="
			menuContextual.ocultarMenuPulic('menu-contextual');
			nucleo.activarSuspensionPublic();
	" 
	oncontextmenu="menuContextual.mostrarMenuPulic(event, this.id, 'menu-contextual'); return false;"
-->
<head>
		<title>SIGMANSTEC</title>
		<meta charset="utf-8">
		<link rel="icon" type="image/png" href="Vist/img/logo-16px.png" />
	<!-- Librerias Css -->
		<link rel="stylesheet" type="text/css" href="vendor/lib/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="vendor/lib/bootstrap-select/bootstrap-select.min.css">

	  	<!-- Resportes -->
		<link rel="stylesheet" type="text/css" href="vendor/lib/morris/morris.css">		
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" charset="utf-8" >
	<!-- para complementar en Css a alertifyjs -->
		<link rel="stylesheet" type="text/css" href="vendor/lib/alertifyjs/css/alertify.min.css">		
		<link rel="stylesheet" type="text/css" href="vendor/lib/alertifyjs/css/themes/default.min.css">	

	<!-- Archivos Personalizados de Css -->
		<link rel="stylesheet" type="text/css" href="Vist/css/estilo.css">
		<link rel="stylesheet" type="text/css" href="Vist/css/menu-contextual.css">
		<link rel="stylesheet" type="text/css" href="Vist/css/navegacion.css">
		<link rel="stylesheet" type="text/css" href="Vist/css/menu-usuario.css">
		<link rel="stylesheet" type="text/css" href="Vist/css/menu-footer.css">
		<link rel="stylesheet" type="text/css" href="Vist/css/catalogo.css">
		<link rel="stylesheet" type="text/css" href="Vist/css/formulario.css">
		<link rel="stylesheet" type="text/css" href="Vist/css/ventana-modal.css">
	<!-- CSS MODULOS -->		
		<link rel="stylesheet" type="text/css" href="Vist/css/modulos/solicitud.css">
		<link rel="stylesheet" type="text/css" href="Vist/css/modulos/persona.css">
		<link rel="stylesheet" type="text/css" href="Vist/css/modulos/tarea.css">

	<!-- Librerias Js -->
		<script type="text/javascript" src="vendor/lib/JQuery/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="vendor/lib/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="vendor/lib/bootstrap-select/bootstrap-extencion-sigmanstec.min.js"></script>
		<script type="text/javascript" src="vendor/lib/bootstrap-select/bootstrap-select.min.js"></script>
		<script type="text/javascript" src="vendor/lib/bootstrap-select/i18n/defaults-es_ES.js"></script>
	  	<script type="text/javascript" src="vendor/lib/md5-pack/md5.pack.js"></script>

	  	<!-- Resportes -->
	  	<script type="text/javascript" src="vendor/lib/morris/raphael-min.js"></script>		  
	  	<script type="text/javascript" src="vendor/lib/morris/morris.min.js"></script>		  

	<!-- Configuraciones -->
		<script type="text/javascript" src="Vist/js/utilidades/configuracion.js"></script>		
	<!-- Fin de Configuraciones -->	
	<!-- Archivos Personalizados de Js para funcionalidades de seguridad-->	
		<script type="text/javascript" src="Vist/js/utilidades/seguridad.js"></script>
	<!-- Archivos Personalizados de Js para funcionalidades -->	
		<script type="text/javascript" src="Vist/js/utilidades/menu-contextual.js"></script>
		<script type="text/javascript" src="Vist/js/utilidades/mensajes.js"></script>
		<script type="text/javascript" src="Vist/js/utilidades/panel-tabs.js"></script>
		<script type="text/javascript" src="Vist/js/utilidades/navegacion.js"></script>
		<script type="text/javascript" src="Vist/js/utilidades/ventana-modal.js"></script>
		<script type="text/javascript" src="Vist/js/utilidades/listas.js"></script>
		<script type="text/javascript" src="Vist/js/utilidades/obtener-ip.js"></script>
		<script type="text/javascript" src="Vist/js/utilidades/reportes.js"></script>


	<!-- nucleo-->
		<script type="text/javascript" src="Vist/js/utilidades/nucleo.js"></script>
	<!--Fin Nucleo-->

	<script type="text/javascript">
		$(function() {
			nucleo.Iniciar();
		});
	</script>

</head>
<body onkeydown="seguridad.sensorKeyPublic(event);">
	
	<div id="index" >

	</div>

	
	<div id="utilidades">

		<ul id="menu-contextual">
			<li>
				<div class="row">
					<div  align="center">
						<img src="Vist/img/logo-16px.png"/>
							<b>SIGMANSTEC</b>
					</div>
				</div>
			</li>
			<li style="padding:0px;">
				<button onclick="menuContextual.copiarMCPublic()" class="" style="width: 100%; border:0px; margin:0px; background:#fff; text-align:left;" >
					Copiar
				</button>
			</li>
			<li style="padding:0px;">
				<button onclick="menuContextual.pegarMCPublic()" class="" style="width: 100%; border:0px; margin:0px; background:#fff; text-align:left;" >
					Pegar
				</button>
			</li>			
		</ul>

		<div style="display:none;">
			<input type="text" id="portapapelesMC" style="display:none;" />
		</div>
		<div id="suspension">
			<!-- Fondo/Capa de venta -->
			<div id="ventana-modal-suspension" class="ventana-modal-suspension ventana-modal-panel-accionCerrar">
			</div>
		</div>
		<div id="administracion">
			<!-- Fondo/Capa de venta -->
			<div id="ventana-modal-cfg" class="ventana-modal-cfg ventana-modal-panel-accionCerrar">
			</div>
			<!-- Fondo/Capa de venta -->
			<div id="ventana-modal-cfg-internos" class="ventana-modal-cfg-internos ventana-modal-panel-accionCerrar">
			</div>
		</div>
	</div>

	<!-- Librerias Js -->
	<script type="text/javascript" src="vendor/lib/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="vendor/lib/alertifyjs/alertify.js"></script>	
</body>
</html>
