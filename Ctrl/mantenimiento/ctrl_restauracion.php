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

if (isset($_POST['mostrarSQL'])) {
    $archivo = $_FILES["file"]["tmp_name"];
    $data = $objMantenimiento->leer_contenido_completo($archivo);
    echo $data;
    $IP=$_POST['ip_cliente'];
    $IDUSUARIO=$_POST['id_usuario'];                                
    $modBitacora->guardarOperacion('INTENTO REALIZAR UNA RESTAURACION DE LA BASE DE DATOS Y OBSERVO EL ARCHIVO SQL',$IP,$IDUSUARIO);
}


if (isset($_POST['guardarRestauracion'])) {
    $uploads_dir = "../../backup";
    $tmp_name = $_FILES["file"]["tmp_name"];
    $name = "_temp_" . $_FILES["file"]["name"];
    $filepath = "$uploads_dir/$name";
    move_uploaded_file($tmp_name, $filepath);
    $objMantenimiento->restaurar_bd($filepath,$sistema);
    $IP=$_POST['ip_cliente'];
    $IDUSUARIO=$_POST['id_usuario'];                                
    $modBitacora->guardarOperacion('REALIZO UNA RESTAURACION LA BASE DE DATOS',$IP,$IDUSUARIO);

}
?>

