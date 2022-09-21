 <!-- uncomment code for absolute positioning tweek see top comment in css -->
    <!-- <div class="absolute-wrapper"> </div> -->
    <!-- Menu -->
    <div class="side-menu">
    
        <nav class="navbar navbar-default" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <div class="brand-wrapper">
                    <!-- logo-Nombre -->
                    <div class="brand-name-wrapper">
                        <img id="logo-menu" src="Vist/img/logo.png" style="display:none; width: 50px;float: left;margin-left: 15%;margin-top: 1%;">
                        <a class="navbar-brand" href="javascript:;" style="float: left;">
                            SIGMANSTEC
                        </a>
                    </div>
                </div>

            </div>

            <!-- Main Menu -->
            <div class="side-menu-container">
                <ul id="menu-principal" class="nav navbar-nav" style="background:rgb(80, 133, 179);">

                    <li class="menu-border item-menu" name="Inicio" id="InicioLI" data-permisos="" data-idmodulo="1">
                        <a  id="Inicio" href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/pagInicio.php');return false;">
                            <span class="glyphicon glyphicon-home"></span> 
                                Inicio
                        </a>
                    </li>
                    <li class="menu-border item-menu" name="Soporte Técnico" id="SolicitudLI" data-permisos="" data-idmodulo="2" >
                        <a id="Solicitud" href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/procesos/solicitud/vistGestionSolicitud.php');return false;">
                            <span class="glyphicon glyphicon-file"></span> 
                                Solicitud
                        </a>
                    </li>
                    <li class="menu-border item-menu" name="Servicio Técnico" id="Mantenimiento-EquipoLI"  data-idmodulo="3">
                        <a  id="Mantenimiento-Equipo" data-permisos="" href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/procesos/mantenimientoEquipo/vistGestionMantenimientoEquipo.php');return false;">
                            <span class="glyphicon glyphicon glyphicon-wrench"></span> 
                                Mantenimiento
                        </a>
                    </li>
                    <li class="menu-border item-menu" name="Inventario" id="Tareas-equipoLI" data-permisos="" data-idmodulo="4">
                        <a  id="Tareas-equipo" href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/procesos/tareasProgramadas/vistGestionTareasProgramadas.php');return false;">
                            <span class="glyphicon glyphicon-calendar"></span> 
                                Tareas Programadas
                        </a>
                    </li>          
                    <li class="menu-border item-menu" name="Calendario" id="equipos-personaLI" data-permisos="" data-idmodulo="5">
                        <a  id="equipos-persona" href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/procesos/asginarEquipoPersona/vistGestionAsignarEquipoPersona.php');return false;">
                            <span class="glyphicon glyphicon-duplicate"></span> 
                                Asignaciones 
                        </a>
                    </li>   
                    <li class="menu-border item-menu" name="Calendario"  id="Agregar-equipoLI"  data-idmodulo="6">
                        <a  id="Agregar-equipo" data-permisos="" href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/procesos/agregar/equipo/vistGestionEquipo.php');return false;">
                            <span class="glyphicon glyphicon-plus-sign"></span> 
                                Equipos
                        </a>
                    </li>   
                    <!-- Dropdown-->
                    <li name="Configuración" class="menu panel panel-default item-menu" id="dropdown" 
                      style="border-right: 1px solid rgb(80, 133, 179);" id="ConfiguracionLI" data-permisos="" data-idmodulo="7">
                        <a id="Configuracion" data-toggle="collapse"
                         class="menu despegable" data-idmenu="dropdown-lvl1"  href="javascript:;#dropdown-lvl1" 
                         href="javascript:;" onclick="nucleo.asignarSubPermisosPublic(7); navegacion.cambiarPaginaPublic('Vist/paginas/configuracion/pagConfiguracion.php');return false;">
                            <span class="glyphicon glyphicon-cog"></span> Configuración <span class="caret"></span>
                        </a>

                        <!-- Dropdown level 1 -->
                        <div id="dropdown-lvl1" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav" style="height: 165px;overflow-y: auto;">
                                    <li id="opcion10" name="Personas" class="opcion10" data-permisos="" data-idmodulo="10">
                                        <a id="Personas" class="despegable-menu" data-menucontent="Configuracion" href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/configuracion/gestionPersona/vistGestionPersona.php');return false;">
                                            <span class="glyphicon glyphicon-user"></span> 
                                                Personas
                                        </a>
                                    </li>
                                    <li id="opcion12" name="Departamentos" class="opcion12" data-permisos="" data-idmodulo="12">
                                        <a id="Departamentos" class="despegable-menu" data-menucontent="Configuracion" href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/configuracion/gestionDepartamentos/vistGestionDepartamento.php');return false;">
                                            <span class="glyphicon glyphicon-home"></span> 
                                                Departamentos
                                        </a>
                                    </li>
                                    <li id="opcion14" name="Tareas" class="opcion14" data-permisos="" data-idmodulo="14">
                                        <a id="Tareas" class="despegable-menu" data-menucontent="Configuracion" href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/configuracion/gestionTareas/vistGestionTareas.php');">
                                            <span class="glyphicon glyphicon-shopping-cart"></span> 
                                                Tareas
                                        </a>
                                    </li>
                                    <li id="opcion24" name="Características logicas" class="opcion24" data-permisos="" data-idmodulo="24">
                                        <a id="Caracteristicas-logicas" class="despegable-menu" data-menucontent="Configuracion" href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/configuracion/gestionConfigCLogica/vistGestionConfigCLogica.php');return false;">
                                            <span class="glyphicon glyphicon-hdd"></span> 
                                                Características logicas
                                        </a>
                                    </li>                                                                        
                                    <li id="opcion25" name="Características físicas" class="opcion25" data-permisos="" data-idmodulo="25">
                                        <a id="Caracteristicas-físicas" class="despegable-menu" data-menucontent="Configuracion" href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/configuracion/gestionConfigCFisica/vistGestionConfigCFisica.php');return false;">
                                            <span class="glyphicon glyphicon-object-align-left"></span> 
                                                Características físicas
                                        </a>
                                    </li>
                                    <li id="opcion26" name="Caracteristicas de equipos" class="opcion26" data-permisos="" data-idmodulo="26">
                                        <a id="Caracteristicas-equipos" class="despegable-menu" data-menucontent="Configuracion" href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/configuracion/gestionCaracteristicasEquipo/vistGestionCaracteristicasEquipo.php');return false;">
                                            <span class="glyphicon glyphicon-bullhorn"></span> 
                                                Caracteristicas de equipos
                                        </a>
                                    </li> 
                                   <li id="opcion28" name="Caracteristicas de perifericos" class="opcion28" data-permisos="" data-idmodulo="28">
                                        <a id="Caracteristicas-perifericos" class="despegable-menu" data-menucontent="Configuracion" href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/configuracion/gestionCaracteristicasPeriferico/vistGestionCaracteristicasPeriferico.php');return false;">
                                            <span class="glyphicon glyphicon-bullhorn"></span> 
                                                Caracteristicas de perifericos
                                        </a>
                                    </li>                                          
                                    <li id="opcion27" name="Caracteristicas de componentes" class="opcion27" data-permisos="" data-idmodulo="27">
                                        <a id="Caracteristicas-componentes" class="despegable-menu" data-menucontent="Configuracion" href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/configuracion/gestionCaracteristicasComponente/vistGestionCaracteristicasComponente.php');return false;">
                                            <span class="glyphicon glyphicon-bullhorn"></span> 
                                                Caracteristicas de componentes
                                        </a>
                                    </li>  
                                   <li id="opcion29" name="Software" class="opcion29"  data-permisos="" data-idmodulo="29">
                                        <a id="Caracteristicas-softwares" class="despegable-menu" data-menucontent="Configuracion" href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/configuracion/gestionCaracteristicasSoftware/vistGestionCaracteristicasSoftware.php');return false;">
                                            <span class="glyphicon glyphicon-bullhorn"></span> 
                                                Software
                                        </a>
                                    </li>                                                                                                                                                 
                                </ul>
                            </div>
                        </div>
                    </li>
                    <!-- Dropdown-->
                    <li name="Mantenimiento-SISTEMA" class="menu panel panel-default item-menu" id="dropdown" style="border-right: 1px solid rgb(80, 133, 179);"  data-permisos="" data-idmodulo="8">
                        <a  id="Mantenimiento-SISTEMA" data-toggle="collapse" class="menu despegable" data-idmenu="dropdown2-lvl1" href="javascript:;#dropdown2-lvl1"
                            onclick="nucleo.asignarSubPermisosPublic(8); navegacion.cambiarPaginaPublic('Vist/paginas/mantenimiento/pagSistema.php');return false;">
                            <span class="glyphicon glyphicon-wrench"></span> Ajustes de sistema <span class="caret"></span>
                        </a>
                        <!-- Dropdown level 1 -->
                        <div id="dropdown2-lvl1" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">
                                    <li>
                                        <a id="Modulos" class="despegable-menu" data-menucontent="Mantenimiento-SISTEMA"href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/mantenimiento/gestionModulos/vistGestionModulo.php');return false;">
                                            <span class="glyphicon glyphicon-th"></span> 
                                                Modulos
                                        </a>
                                    </li>         
                                    <li>
                                        <a id="Bitacora" class="despegable-menu" data-menucontent="Mantenimiento-SISTEMA"href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/mantenimiento/gestionBitacora/vistGestionBitacora.php');return false;">
                                            <span class="glyphicon glyphicon-th"></span> 
                                                Bitácora
                                        </a>
                                    </li>
                                     <li>
                                        <a id="Respaldo" class="despegable-menu" data-menucontent="Mantenimiento-SISTEMA"href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/mantenimiento/gestionBD/vistGestionRespaldo.php');return false;">
                                            <span class="glyphicon glyphicon-th"></span> 
                                                Respaldo de BD
                                        </a>
                                    </li>
                                      <li>
                                        <a id="Restauracion" class="despegable-menu" data-menucontent="Mantenimiento-SISTEMA"href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/mantenimiento/gestionBD/vistGestionRestauracion.php');return false;">
                                            <span class="glyphicon glyphicon-th"></span> 
                                                Restauración de BD
                                        </a>
                                    </li>                                                                                                                                        
                                </ul>
                            </div>
                        </div>
                    </li>

                    <!-- Dropdown-->
                    <li name="Reportes" class="menu panel panel-default item-menu" id="dropdown" 
                            style="border-right: 1px solid rgb(80, 133, 179);" id="ReportesLI" data-permisos="" data-idmodulo="9">
                        <a  id="Reportes" data-toggle="collapse" 
                            class="menu despegable" data-idmenu="dropdown3-lvl1" href="javascript:;#dropdown3-lvl1"
                            href="javascript:;" onclick="nucleo.asignarSubPermisosPublic(9);">
                            <span class="glyphicon glyphicon-print"></span> Reportes <span class="caret"></span>
                        </a>
                        <!-- Dropdown level 1 -->
                        <div id="dropdown3-lvl1" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">
                                    <li id="opcion30" name="Gerenciales" class="opcion30"  data-permisos="" data-idmodulo="30">
                                        <a id="Gerenciales" class="despegable-menu" data-menucontent="Reportes"href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/reportes/vistGestionReportesGerenciales.php');return false;">
                                            <span class="glyphicon glyphicon-th"></span> 
                                                Gerenciales
                                        </a>
                                    </li>         
                                    <li id="opcion31" name="Estrategicos" class="opcion31"  data-permisos="" data-idmodulo="31">
                                        <a id="Estrategicos" class="despegable-menu" data-menucontent="Reportes"href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/reportes/vistGestionReportesEstrategicos.php');return false;">
                                            <span class="glyphicon glyphicon-th"></span> 
                                                Estrategicos
                                        </a>
                                    </li>
                                     <li id="opcion32" name="Operativos" class="opcion32"  data-permisos="" data-idmodulo="32">
                                        <a id="Operativos" class="despegable-menu" data-menucontent="Reportes"href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/reportes/vistGestionReportesOperativos.php');return false;">
                                            <span class="glyphicon glyphicon-th"></span> 
                                                Operativos
                                        </a>
                                    </li>                                                                                                                                     
                                </ul>
                            </div>
                        </div>
                    </li>                    
<!--
                    <li class="menu-border item-menu" name="Reportes" id="ReportesLI" data-permisos="" data-idmodulo="9">
                        <a id="Reportes" href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/reportes/vistGestionReportes.php');return false;">
                            <span class="glyphicon glyphicon-print"></span> 
                                Reportes
                        </a>
                    </li>      
-->
                    <li class="menu" style="border-right: 1px solid rgb(80, 133, 179); border-bottom: 1px solid #e7e7e7;" >
                        <a id="Ayuda" href="javascript:;" onclick="navegacion.cambiarPaginaPublic('Vist/paginas/pagAyuda.php');return false;">
                            <span class="glyphicon glyphicon-question-sign"></span>Ayuda
                        </a>
                    </li>   
                    <li class="menu" style="border-right: 1px solid rgb(80, 133, 179);">
                        <a id="CerrarSesion" href="javascript:;" onclick="nucleo.cerrarSesionPublic();">
                            <span class="glyphicon glyphicon-off"></span>Cerrar Sesión
                        </a>
                    </li>       

                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    
    </div>