<?php 
	session_start();

	class classConexion {
		private $conexion;

		public function __CONSTRUCT()
		{
		}
		public function getConexion()
		{
			try
			{
				$this->conexion = new PDO('mysql:host=localhost;dbname=sigmanstec', 'root', '');
				$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		 
				return $this->conexion;	 
			}
			catch(Exception $e)
			{
				echo 'Error'.$e->getMessage().' !!!! ';
			}
		}
		public function getCerrarSesion()
		{
			$this->conexion=null;
			return null;
		}
		public function getUltimoIdGuardado()
		{
			return $this->conexion->lastInsertId();
		}


						
	}
?>

