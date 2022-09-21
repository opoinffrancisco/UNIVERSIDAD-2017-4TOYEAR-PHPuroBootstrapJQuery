<?php

	session_start();

		if(isset($_POST['accion']))
		{
			$accion=$_POST['accion'];

		}

		if (isset($_GET['accion'])) {
			$accion="actualizar-captcha";
		}

		if(isset($accion))
		{
			switch($accion)
			{					
				case 'actualizar-captcha':

					$random_alpha = md5(rand());
					$captcha_code = substr($random_alpha, 0, 6);
					$_SESSION["captcha_code".$_GET['dato_control']] = $captcha_code;
					// tamaño
					$target_layer = imagecreatetruecolor(70,30);
					// fondo
					$captcha_background = imagecolorallocate($target_layer, 255, 160, 119);
					// integracion y otros
					imagefill($target_layer,0,0,$captcha_background);
					//Colorear algo mas
					$captcha_text_color = imagecolorallocate($target_layer, 0, 0, 0);
					// convierte el string en una imagen
					imagestring($target_layer, 5, 5, 5, $captcha_code, $captcha_text_color);
					// convierte el documento/archivo/fichero en una imagen
					header("Content-type: image/jpeg");
					//header("Access-Control-Allow-Origin: *");	
					//Le coloca el formato ala imagen , en imprime el resultado
					imagejpeg($target_layer);

					break;			
				case 'verificar-captcha':

					header('Content-type: application/json');
					header("Access-Control-Allow-Origin: *");	

					if($_POST["captcha"]==$_SESSION["captcha_code".$_POST['dato_control']]){
						
						$datos = array(
							'controlError' => 0,
						);

					} else {
						$datos = array(
							'controlError' => 1,
							'mensaje' => "Captcha errado",
						);
					}

					echo '' . json_encode($datos) . '';				

					break;								
				default:
					break;
			}

		}





?>

