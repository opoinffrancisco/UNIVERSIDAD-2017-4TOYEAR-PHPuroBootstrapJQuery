<?php


class Mantenimiento  {




    function respaldar($tables,$sistema) {//database name
        //$conn = parent::conectarBD();
        
        $database = "sigmanstec";
        $user = "root";
        $pass = "";
        
        //windows
        //--skip-opt
        if ($sistema === 'WINDOWS') {
            $comando='F:/xampp/mysql/bin/mysqldump --skip-opt --add-drop-table --user=' . $user . ' ' . $database . '> "F:/xampp/htdocs/SIGMANSTEC/backup/temp.sql" --tables ' . $tables . '';
        
        exec('F:\WINDOWS\system32\cmd.exe /c '.$comando.'');   
        }else if ($sistema === 'LINUX') {
        //server linux

        $db_host = 'localhost';
        $db_name = 'sigmanstec';
        $db_user = 'root';
        $db_pass = '123456';
        $dump = "mysqldump -h$db_host -u$db_user -p$db_pass --opt $db_name $tables > /var/www/html/SIGMANSTEC/backup/temp.sql";
        system($dump,$output);
        //exec($dump);


        }
       
         //parent::cerrarConexion($conn);
    }

    function restaurar_bd($ruta,$sistema) {
       $database = "sigmanstec";
        $user = "root";
        $pass = "";
        //windows
        //--skip-opt
        if ($sistema === 'WINDOWS') {
            $coman= 'F:/xampp/mysql/bin/mysql --user=' . $user . ' ' . $database . ' < "' . $ruta . '"';  
            exec('F:\WINDOWS\system32\cmd.exe /c '.$coman.'');   
        }else if ($sistema === 'LINUX') {
            //server linux
            $db_name = 'sigmanstec';
            $db_user = 'root';
            $db_pass = '123456';

            $dump = "mysql --user=$db_user --password=$db_pass $db_name < '". $ruta ."'"; 
            system($dump);
        }
    }

    function leer_contenido_completo($archivo) {
        //abrimos el fichero, puede ser de texto o una URL
        //echo $archivo;
        $fichero_url = fopen($archivo, "r");
        $texto = "";
        //bucle para ir recibiendo todo el contenido del fichero en bloques de 1024 bytes
        while ($trozo = fgets($fichero_url, 1024)) {
            $texto .= str_replace("\n", "<br>", $trozo);
        }

        return $texto;
    }

    /**
     * funcion para guardar la informacion del respaldo
     */
    function guardar_repaldo($contenido,$sistema) {
        date_default_timezone_set('America/Caracas');
        $fecha_completa = date('Y-m-d_H.i.s');        
        $database = "sigmanstec";
        $user = "root";
        //parent::cerrarConexion($conn);
         
        //$sistema= $info["os"];
         //windows
        //--skip-opt
        if ($sistema === 'WINDOWS') {
            $back = fopen("F:/xampp/htdocs/SIGMANSTEC/backup/" . $database . "_" . $fecha_completa . ".sql", "w");
            fwrite($back, $contenido);
            fclose($back);
        }elseif ($sistema === 'LINUX') {


            $db_host = 'localhost';
            $db_name = 'sigmanstec';
            $db_user = 'root';
            $db_pass = '123456';
            $fecha = date('Y-m-d_H.i.s');
            $salida_sql = $db_name.'_'.$fecha.'.sql';
            $dump = "mysqldump -h$db_host -u$db_user -p$db_pass --opt $db_name $tables > /var/www/html/SIGMANSTEC/backup/$salida_sql";
            system($dump,$output);
            //exec($dump);

           
        }
    }


}

?>
