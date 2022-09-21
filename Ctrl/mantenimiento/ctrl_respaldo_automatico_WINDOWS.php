<?php 

   $data = "bitacora,cfg_c_fisc_interfaz_conexion,cfg_c_fisc_mod_marca,cfg_c_fisc_modelo,cfg_c_fisc_tipo,cfg_c_fisc_unidad_medida,cfg_c_logc_fabricante,cfg_c_logc_tipo,cfg_caracteristicas_fisc_comp,cfg_caracteristicas_fisc_eq,cfg_caracteristicas_fisc_perif,cfg_configuracion,cfg_departamento,cfg_departamento_cargo,cfg_interfaz_caracteristicas_fisicas_comp,cfg_interfaz_caracteristicas_fisicas_eq,cfg_persona,cfg_persona_departamento,cfg_pn_cargo,cfg_pn_perfil,cfg_pn_perfil_permiso,cfg_pn_usuario,cfg_t_consumible,cfg_t_herramienta,cfg_tarea,cfg_tarea_consumible,cfg_tarea_herramienta,eq_componente,eq_periferico,eq_software,equipo,equipo_componente,equipo_periferico,equipo_software,mant_tipo_mantenimiento,mantenimiento,mtn_modulo,persona_ejecuta,persona_equipo,pnej_funcion_persona,solicitud,solt_diagnostico,solt_respuesta,tarea_equipo,historial_mtn_modulo,historial_cfg_pn_perfil_permiso";

    $tables = explode(",", $data);
    $str_tables = "";
    for ($i = 0; $i < count($tables); $i++) {
        $str_tables .= "\"" . $tables[$i] . "\" ";
    }

	$tables = $str_tables;
    
    date_default_timezone_set('America/Caracas');
    $fecha_completa = date("Y-m-d_H.i.s"); //opcional
    $db_host = 'localhost';
    $db_name = 'sigmanstec';
    $db_user = 'root';
    $db_pass = '123456';
    $salida_sql = $db_name.'_'.$fecha_completa.'.sql';


    $comando='C:/xampp/mysql/bin/mysqldump --skip-opt --add-drop-table --user=' . $db_user . ' ' . $db_name . '> "C:/xampp/htdocs/SIGMANSTEC/backup/'.$salida_sql.'" --tables ' . $tables . '';

	exec('C:\WINDOWS\system32\cmd.exe /c '.$comando.'');   
   
    system('mysql -uroot -p123456 sigmanstec -e "insert into bitacora (tipo_operacion,fecha,ip,id_usuario) values (\'SE REALIZO UN RESPALDO DE LA BASE DE DATOS - AUTOMATICAMENTE\',sysdate(3),\'127.0.0.1\',2);"');   
    
?>