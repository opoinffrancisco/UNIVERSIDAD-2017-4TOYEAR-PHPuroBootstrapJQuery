<?php
		
/*
		$hoy=date("Y-m-d");
		$ayer=date("Y-m-d",strtotime($hoy.' – 1 day'));
		$mañana=date("Y-m-d",strtotime($hoy.' + 1 day'));
		$hace_una_semana=date("Y-m-d",strtotime($hoy.' – 1 week'));
		$dentro_de_una_semana=date("Y-m-d",strtotime($hoy.' + 1 week'));
		$hace_un_mes=date("Y-m-d",strtotime($hoy.' – 1 month'));
		$dentro_de_un_mes=date("Y-m-d",strtotime($hoy.' + 1 month'));
		$hace_un_año=date("Y-m-d",strtotime($hoy.' – 1 year'));
		$dentro_de_un_año=date("Y-m-d",strtotime($hoy.' + 1 year'));
*/

//		echo calculaFecha("years",9,"2017-06-20");
//		echo calculaFecha("months",9,"2017-06-20");
//		echo calculaFecha("days",9,"2017-06-20");

		function fechaActual()
		{
			 return date("Y-m-d",time());			
		}

		function calculaFecha($modo,$valor,$fecha_inicio=false){
		 
		   if($fecha_inicio!=false) {
		          $fecha_base = strtotime($fecha_inicio);
		   }else {
		          $time=time();
		          $fecha_actual=date("Y-m-d",$time);
		          $fecha_base=strtotime($fecha_actual);
		   }
		 
   			$calculo = strtotime("$valor $modo","$fecha_base");

		   return date("Y-m-d", $calculo);
		 
		}
		function calcularIntervaloFechas($fecha1, $fecha2)
		{
			$datetime1 = date_create($fecha1);
			$datetime2 = date_create($fecha2);
			$interval = date_diff($datetime1, $datetime2);
			return $interval->format('%a');
		}
?>