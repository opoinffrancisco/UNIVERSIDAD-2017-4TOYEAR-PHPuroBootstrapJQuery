<!--Inicializacion de complementos-->
<script type="text/javascript">
	
	navegacion.Iniciar();
	panelTabs.Iniciar();
	ventanaModal.Iniciar();				
	listas.Iniciar();
	reportes.Iniciar();
	//
	nucleo.activarSuspensionPublic();	
</script>
<!-- Archivos Personalizados de Js Para metodos -->

<!--Estilos -->
<!--Mantenimiento-->
<link  rel="stylesheet" type="text/css" href="Vist/css/modulos/bitacora.css">

<!--procesos-->
<script type="text/javascript" src="Vist/js/metodos/procesos/mantenimiento-equipo/mtd-mantenimiento-equipo.js"></script>
<script type="text/javascript" src="Vist/js/metodos/procesos/solicitud/mtd-solicitud.js"></script>
<script type="text/javascript" src="Vist/js/metodos/procesos/tarea-programada/mtd-tarea-programada.js"></script>
<script type="text/javascript" src="Vist/js/metodos/procesos/asignar/mtd-asignar.js"></script>
<script type="text/javascript" src="Vist/js/metodos/procesos/agregar/mtd-equipo.js"></script>
<script type="text/javascript" src="Vist/js/metodos/procesos/agregar/mtd-componente.js"></script>
<script type="text/javascript" src="Vist/js/metodos/procesos/agregar/mtd-periferico.js"></script>

<!--configuracion-->
<script type="text/javascript" src="Vist/js/metodos/configuracion/mtd-persona.js"></script>
<script type="text/javascript" src="Vist/js/metodos/configuracion/mtd-pn-perfil.js"></script>
<script type="text/javascript" src="Vist/js/metodos/configuracion/mtd-pn-cargo.js"></script>
<script type="text/javascript" src="Vist/js/metodos/configuracion/mtd-departamento.js"></script>
<script type="text/javascript" src="Vist/js/metodos/configuracion/mtd-tarea.js"></script>
<script type="text/javascript" src="Vist/js/metodos/configuracion/mtd-c-equipo.js"></script>
<script type="text/javascript" src="Vist/js/metodos/configuracion/mtd-c-componente.js"></script>
<script type="text/javascript" src="Vist/js/metodos/configuracion/mtd-c-periferico.js"></script>
<script type="text/javascript" src="Vist/js/metodos/configuracion/mtd-c-software.js"></script>
<script type="text/javascript" src="Vist/js/metodos/configuracion/mtd-c-logc-distribucion.js"></script>
<script type="text/javascript" src="Vist/js/metodos/configuracion/mtd-c-logc-tipo.js"></script>
<script type="text/javascript" src="Vist/js/metodos/configuracion/mtd-c-fisc-tipo.js"></script>
<script type="text/javascript" src="Vist/js/metodos/configuracion/mtd-c-fisc-modelo.js"></script>
<script type="text/javascript" src="Vist/js/metodos/configuracion/mtd-c-fisc-marca.js"></script>
<script type="text/javascript" src="Vist/js/metodos/configuracion/mtd-c-fisc-interfaz.js"></script>
<script type="text/javascript" src="Vist/js/metodos/configuracion/mtd-c-fisc-unidad-medida.js"></script>

<!--mantenimiento-->
<script type="text/javascript" src="Vist/js/metodos/mantenimiento/mtd-modulo.js"></script>	
<script type="text/javascript" src="Vist/js/metodos/mantenimiento/mtd-bitacora.js"></script>	

<!--reportes-->
<script type="text/javascript" src="vendor/lib/html2canvas/html2canvas.js"></script>	

<script type="text/javascript" src="Vist/js/metodos/reportes/mtd-rendimiento.js"></script>	
<script type="text/javascript" src="Vist/js/metodos/reportes/mtd-areas-concurrentes-tareas-correctivas.js"></script>	
<script type="text/javascript" src="Vist/js/metodos/reportes/mtd-desincorporaciones-concurrentes.js"></script>	
<script type="text/javascript" src="Vist/js/metodos/reportes/mtd-mantenimiento-preventivo.js"></script>	
<script type="text/javascript" src="Vist/js/metodos/reportes/mtd-vencimiento-tareas.js"></script>	
<script type="text/javascript" src="Vist/js/metodos/reportes/mtd-tareas-concurrentes.js"></script>	
<script type="text/javascript" src="Vist/js/metodos/reportes/mtd-actividades-solicitud.js"></script>	


<header onclick="nucleo.actualizarContadorSuspensionPublic(0);">

   <?php include 'secciones/menu/menuPrincipal.php';?>

   <?php include 'secciones/menu-usuario/menu-usuario.php';?>

</header>
<main onclick="nucleo.actualizarContadorSuspensionPublic(0);">
	<!--side-body-->
	<div class="side-body container-fluid" >	
		<div id="contenido" class="contenido">

			<?php include 'paginas/pagInicio.php';?>

		</div>
	</div>		           
</main>
<footer onclick="nucleo.actualizarContadorSuspensionPublic(0);">

	<?php include 'secciones/menu-footer/menu-footer.php';?>

</footer>

