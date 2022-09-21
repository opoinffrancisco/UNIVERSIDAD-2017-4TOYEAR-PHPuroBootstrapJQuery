<?php
require_once '../../Mod/conexion.php';
require_once '../../Mod/mantenimiento/mod-respaldo/Mantenimiento.php';
require_once '../../Mod/utilidades/mod-bitacora.php';

$objMantenimiento = new Mantenimiento();
//
$modBitacora = new modBitacora();   

$info=detect();
$sistema=$info["os"];
function detect()
{
  $os=array("WINDOWS","MAC","LINUX");
 
  # definimos unos valores por defecto para el navegador y el sistema operativo
  
  $info['os'] = "OTHER";
  # obtenemos el sistema operativo
  foreach($os as $val)
  {
    if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
      $info['os'] = $val;
  }
 
  # devolvemos el array de valores
  return $info;
}


if (isset($_POST['comenzarRespaldo'])) {
    $data = $_POST['allTables'];

    $tables = explode(",", $data);
    $str_tables = "";
    for ($i = 0; $i < count($tables); $i++) {
        $str_tables .= "\"" . $tables[$i] . "\" ";
    }

    $objMantenimiento->respaldar($str_tables,$sistema);

    echo $objMantenimiento->leer_contenido_completo("../../backup/temp.sql");
   	unlink("../../backup/temp.sql");
    //-------
    $IP=$_POST['ip_cliente'];
    $IDUSUARIO=$_POST['id_usuario'];                                
    $modBitacora->guardarOperacion('INTENTO REALIZAR UN RESPALDO DE LA BASE DE DATOS',$IP,$IDUSUARIO);
}

if (isset($_POST['guardarRespaldo'])) {
    $contenido = $_POST['contenido_sql'];
    $cont = str_replace("<br>", "\n", $contenido);
    $objMantenimiento->guardar_repaldo($cont,$sistema);
    echo "1";
    //-------
    $IP=$_POST['ip_cliente'];
    $IDUSUARIO=$_POST['id_usuario'];                                
    $modBitacora->guardarOperacion('REALIZO UN RESPALDO DE LA BASE DE DATOS',$IP,$IDUSUARIO);

}

?>

