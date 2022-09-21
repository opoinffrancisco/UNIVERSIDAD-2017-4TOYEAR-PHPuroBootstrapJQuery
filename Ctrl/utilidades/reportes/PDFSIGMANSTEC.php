<?php
  	require_once '../../Mod/configuracion/mod-configuracion/entidad-configuracion.php';
	require_once '../../Mod/configuracion/mod-configuracion/mod-configuracion.php';		
	require_once '../../vendor/lib/tcpdf/tcpdf.php';	
	class PDFSIGMANSTEC extends TCPDF {

		private $cfgcoll;
		private $titulo;
		private $datos;
		private $usuario;
		//control de coll
		private $coll1;
		private $coll2;
		private $coll3;
		private $coll4;
		private $coll5;
		private $coll6;
		private $coll7;
		private $coll8;
		private $coll9;
		private $coll10;
		private $coll11;

		const limitePagina = 245; 
		const comienzoTabla = 50;
		const alturaFila = 10;

		//Introducir los datos que vamos a exportar
		public function setDatos($cfgcoll,$titulo, $usuario, $datos){
			$this->cfgcoll= $cfgcoll;
			$this->titulo = $titulo;
			$this->usuario = $usuario;
			$this->datos = $datos;
		}
		//Control variables columnas - La columna del estado siempre estara presente
		public function set3Coll($coll1, $coll2){
			//no se cuenta la columna del estado pero seria la - ultima
			$this->coll1= $coll1;
			$this->coll2 = $coll2;
		}
		public function set4Coll($coll1, $coll2, $coll3){
			//no se cuenta la columna del estado pero seria la - ultima
			$this->coll1= $coll1;
			$this->coll2 = $coll2;
			$this->coll3 = $coll3;
		}
		public function set5Coll($coll1, $coll2, $coll3, $coll4){
			//no se cuenta la columna del estado pero seria la - ultima
			$this->coll1= $coll1;
			$this->coll2 = $coll2;
			$this->coll3= $coll3;
			$this->coll4 = $coll4;				
		}	

	    // Extaer dato 
	    public function __GET($campo){ 

	    	return $this->$campo; 
	    }

        public function Header() {
                $this->setJPEGQuality(90);

               // $this->Image('../Vist/img/logo.png', 170, 10, 30, 0, 'PNG', '');

                //$this->Image('../Vist/img/logo.png', 10, 10, 30, 0, 'PNG', '');

 				//$this->Image('../Vist/img/logo.png', 120, 10, 75, 0, 'PNG', 'http://www.finalwebsites.com');

			    // Logos
				$configuracion = new configuracion();
				$modConfiguracion = new modConfiguracion();				    
			 	$resultados = $modConfiguracion->consultar(99999);
				$imgLogoInstitucion = $this->cargarImagenServerBase64($resultados->logo,"","logo-uptab.jpg");
 
 
			    $this->Image('../../Vist/img/'.$imgLogoInstitucion,15,8,20,20);
				unlink($imgLogoInstitucion);


			    $this->Image('../../Vist/img/logo.png',175,8,20,20);

			    // Arial bold 15
                $this->SetFont(PDF_FONT_NAME_MAIN, 'B', 10);
			    // Movernos a la derecha
			    $this->Cell(80);
			    // Título
			    $this->Cell(30,33,'MINISTERIO DEL PODER POPULAR PARA LA EDUCACION UNIVERSITARIA',0,0,'C');
			    // Salto de línea sin espacios
				$this->Ln(0);
			    // Movernos a la derecha		
			    $this->Cell(80);
			    $this->Cell(30,43,utf8_encode($resultados->nombre),0,0,'C');	 
			    // Salto de línea con 20 de espacio	      
				$this->Ln(15);
			    // Movernos a la derecha		
			    $this->Cell(80);
			    $this->Cell(30,45, $this->titulo ,0,0,'C');	    
			    // Salto de línea con 20 de espacio
				$this->Ln(20);	 				


        }
        
        public function Footer() {
                $this->SetY(-15);
                $this->SetFont(PDF_FONT_NAME_MAIN, 'I', 8);
        
			    // Posición: a 1,5 cm del final
			    $this->SetY(-15);
			    // autor
			    $this->Cell(40,10,'GENERADO POR  :  '.$this->usuario,0,0,'C');
			    // Número de página
			    $this->Cell(100,10,'PAGINA '.$this->PageNo().'/'.$this->getAliasNbPages(),0,0,'C');

			    $this->Cell(50,10,'GENERADO EL  :  '.date("d-m-Y"),0,0,'C');

        }
        
        public function CreateTextBox($textval, $x = 0, $y, $width = 0, $height = 10, $fontsize = 10, $fontstyle = '', $align = 'L') {
                $this->SetXY($x+20, $y); // 20 = margin left
                $this->SetFont(PDF_FONT_NAME_MAIN, $fontstyle, $fontsize);
                $this->Cell($width, $height, $textval, 0, false, $align);
        }



	        ///

		//exportar PDF
		public function exportar(){
			
			$this->SetCreator('SIGMANSTEC');
			$this->SetTitle("SIGMANSTEC - ".$this->titulo);
			//añadir primer pagina
			$this->AddPage();

			//se recorre a los datos
			foreach ($this->datos as $dato) {
				switch ($this->cfgcoll) {
					case 'CFG-2COLL':
								$this->exportarDatos2coll($dato);
						break;
					case 'CFG-3COLL':
						# code...
								$this->exportarDatos3coll($dato);
						break;
					case 'CFG-3COLL-1REL':
								$this->exportarDatos3coll($dato);
						break;
					case 'CFG-3COLL-C-EQUIPOS':
								$this->exportarDatos3coll($dato);
						break;						
					case 'CFG-3COLL-C-PERIFERICOS':
								$this->exportarDatos3coll($dato);
						break;								
					case 'CFG-3COLL-C-COMPONENTES':
								$this->exportarDatos3coll($dato);
						break;								
					case 'CFG-3COLL-SOFTWARE':
								$this->exportarDatos3coll($dato);
						break;												
					case 'CFG-4COLL':
								$this->exportarDatos4coll($dato);
						break;
					case 'CFG-5COLL':

						# code...
						break;				
					case 'CFG-2COLL-CARGOS':
								$this->exportarDatosCargos($dato);
						break;			
					case 'CFG-5COLL-M-PERSONAS':
								$this->exportarDatos5collPersonas($dato);
						break;			
					default:
						# code...
						break;
				}

				//se verifica si se necesita o no una nueva página
				$this->analizarSaltoDePagina();

			}
//			header("Content-Type: text/html; charset=iso-8859-1 ");

			header('Content-type: application/pdf; charset=iso-8859-1');		
			$nombre='Rpt_'.$this->titulo.'_'.date("d-m-Y H-i-s").'.pdf';
			 ob_clean(); 
			$this->Output($nombre, 'I');
			

	//		header("Content-Disposition:attachment;filename='".$nombre."'");
			// The PDF source is in original.pdf
	//		readfile($nombre);


		}
		
		private function analizarSaltoDePagina(){
			//si la posición X del documento supera el límite de salto de pagina
			if($this->GetY()>self::limitePagina - self::alturaFila){
				//se añade una nueva página
				$this->AddPage();	
			}
		}
		//sobrecargamos la funcion AddPage para que cada vez que se agrega una página
		public function AddPage(){
			//llamamos a la creación de paginas de FPDF y luego añadimos nuestra funcinalidad
			parent::addPage();
			//se dibuja la tabla
			switch ($this->cfgcoll) {
				case 'CFG-2COLL':
					$this->dibujarTabla2Coll();
					break;
				case 'CFG-3COLL':
					$this->dibujarTabla3Coll();
					break;
				case 'CFG-3COLL-1REL':
					$this->dibujarTabla3Coll();
					break;
				case 'CFG-3COLL-C-EQUIPOS':
					$this->dibujarTabla3Coll();
					break;
				case 'CFG-3COLL-C-PERIFERICOS':
					$this->dibujarTabla3Coll();
					break;				
				case 'CFG-3COLL-C-COMPONENTES':
					$this->dibujarTabla3Coll();
					break;				
				case 'CFG-3COLL-SOFTWARE':
					$this->dibujarTabla3Coll();
					break;										
				case 'CFG-4COLL':
					$this->dibujarTabla4Coll();
					break;
				case 'CFG-5COLL':
					break;	
					case 'CFG-2COLL-CARGOS':
							$this->dibujarTablaCargos();
						break;								
				case 'CFG-5COLL-M-PERSONAS':
							$this->dibujarTabla5CollPersonas();
					break;		
				default:
					# code...
					break;
			}
			//se posiciona en el comienzo de la tabla
			$this->starty = self::comienzoTabla;
		}

		//--------------------------------------------------------
		//dibujar cada fila 
		public function exportarDatos2coll($datos){

			$starty = $this->GetY();
			//formato de la fuente (fuente,estilo,tamaño)
			$this->SetFont(PDF_FONT_NAME_MAIN,'',10);

			//columna identificador cliente
			//se posiciona el cursor
			$this->setXY(10,$starty);
			//se convierde de UTF-8 a windows-1252 porque FPDF no acepta UTF-8 - CENTRADO
			$this->Cell(160,self::alturaFila, iconv('UTF-8', 'windows-1252', $datos['nombre']),1,1,'C');

			//columna edad
			//se posiciona el cursor
			$this->setXY(170,$starty);
			//
			//se hace un cuadro de texto sin centrar
			$this->Cell(30,self::alturaFila, iconv('UTF-8', 'windows-1252', '    '.$datos['estado']) ,1,'C');

			//salto de línea
			$this->Ln();
		}
		//funcion que dibuja la tabla en cuestión
		private function dibujarTabla2Coll(){

			//formato de la fuente (fuente,estilo,tamaño)
			$this->SetFont(PDF_FONT_NAME_MAIN,'B',10);

			//se posiciona el cursor
			$this->setXY(10,self::comienzoTabla);
			//se hace un cuadro de texto (ancho, alto, texto, bordes, alineación del texto)
			$this->MultiCell(160,5,'NOMBRE',1,'C');
			// se dibuja la columna (x,y,ancho,alto)
			$this->Rect(10,self::comienzoTabla,160,self::limitePagina-self::comienzoTabla);

			//se posiciona el cursor
			$this->setXY(170,self::comienzoTabla);
			//se hace un cuadro de texto 
			$this->MultiCell(30,5,'ESTADO',1,'C');
			// se dibuja la columna
			$this->Rect(170,self::comienzoTabla,30,self::limitePagina-self::comienzoTabla);
		}		
		//--------------------------------------------------------
		//dibujar cada fila 
		public function exportarDatos3coll($datos){

			$starty = $this->GetY();
			//formato de la fuente (fuente,estilo,tamaño)
			$this->SetFont(PDF_FONT_NAME_MAIN,'',10);


			//columna identificador cliente
			//se posiciona el cursor
			$this->setXY(10,$starty);
			//se convierde de UTF-8 a windows-1252 porque FPDF no acepta UTF-8 - CENTRADO
			$this->Cell(80,self::alturaFila, 
							iconv('UTF-8', 'windows-1252', $datos[''.$this->coll1.'']),
			1,1,'C');

			//
			$this->setXY(90,$starty);
			//se convierde de UTF-8 a windows-1252 porque FPDF no acepta UTF-8 - CENTRADO
			$this->Cell(80,self::alturaFila,
			 				iconv('UTF-8', 'windows-1252', $datos[''.$this->coll2.'']),
			 1,1,'C');
			//

			//columna edad
			//se posiciona el cursor
			$this->setXY(170,$starty);
			//
			//se hace un cuadro de texto sin centrar
			$this->Cell(30,self::alturaFila, 
							iconv('UTF-8', 'windows-1252', '    '.$datos['estado']) ,
			1,'C');

			//salto de línea
			$this->Ln();
		}
		//funcion que dibuja la tabla en cuestión
		private function dibujarTabla3Coll(){

			//formato de la fuente (fuente,estilo,tamaño)
			$this->SetFont(PDF_FONT_NAME_MAIN,'B',10);

			//se posiciona el cursor
			$this->setXY(10,self::comienzoTabla);
			//se hace un cuadro de texto (ancho, alto, texto, bordes, alineación del texto)
			$this->MultiCell(80,5,  strtoupper($this->coll1)  ,1,'C');
			// se dibuja la columna (x,y,ancho,alto)
			$this->Rect(10,self::comienzoTabla,80,self::limitePagina-self::comienzoTabla);


			//se posiciona el cursor
			$this->setXY(90,self::comienzoTabla);
			//se hace un cuadro de texto (ancho, alto, texto, bordes, alineación del texto)
			$this->MultiCell(80,5,  strtoupper($this->coll2)   ,1,'C');
			// se dibuja la columna (x,y,ancho,alto)
			$this->Rect(90,self::comienzoTabla,80,self::limitePagina-self::comienzoTabla);


			//se posiciona el cursor
			$this->setXY(170,self::comienzoTabla);
			//se hace un cuadro de texto 
			$this->MultiCell(30,5,'ESTADO',1,'C');
			// se dibuja la columna
			$this->Rect(170,self::comienzoTabla,30,self::limitePagina-self::comienzoTabla);
		}		
		//--------------------------------------------------------
		//dibujar cada fila 
		public function exportarDatos4coll($datos){

			$starty = $this->GetY();
			//formato de la fuente (fuente,estilo,tamaño)
			$this->SetFont(PDF_FONT_NAME_MAIN,'',10);


			//columna identificador cliente
			//se posiciona el cursor
			$this->setXY(10,$starty);
			//se convierde de UTF-8 a windows-1252 porque FPDF no acepta UTF-8 - CENTRADO
			$this->Cell(80,self::alturaFila, 
							iconv('UTF-8', 'windows-1252', $datos[''.$this->coll1.'']),
			1,1,'C');

			//
			$this->setXY(90,$starty);
			//se convierde de UTF-8 a windows-1252 porque FPDF no acepta UTF-8 - CENTRADO
			$this->Cell(80,self::alturaFila,
			 				iconv('UTF-8', 'windows-1252', $datos[''.$this->coll2.'']),
			 1,1,'C');
			//

			//columna edad
			//se posiciona el cursor
			$this->setXY(170,$starty);
			//
			//se hace un cuadro de texto sin centrar
			$this->Cell(30,self::alturaFila, 
							iconv('UTF-8', 'windows-1252', '    '.$datos['estado']) ,
			1,'C');

			//salto de línea
			$this->Ln();
		}
		//funcion que dibuja la tabla en cuestión
		private function dibujarTabla4Coll(){

			//formato de la fuente (fuente,estilo,tamaño)
			$this->SetFont(PDF_FONT_NAME_MAIN,'B',10);

			//se posiciona el cursor
			$this->setXY(10,self::comienzoTabla);
			//se hace un cuadro de texto (ancho, alto, texto, bordes, alineación del texto)
			$this->MultiCell(80,5,  strtoupper($this->coll1)  ,1,'C');
			// se dibuja la columna (x,y,ancho,alto)
			$this->Rect(10,self::comienzoTabla,80,self::limitePagina-self::comienzoTabla);


			//se posiciona el cursor
			$this->setXY(90,self::comienzoTabla);
			//se hace un cuadro de texto (ancho, alto, texto, bordes, alineación del texto)
			$this->MultiCell(80,5,  strtoupper($this->coll2)   ,1,'C');
			// se dibuja la columna (x,y,ancho,alto)
			$this->Rect(90,self::comienzoTabla,80,self::limitePagina-self::comienzoTabla);


			//se posiciona el cursor
			$this->setXY(170,self::comienzoTabla);
			//se hace un cuadro de texto 
			$this->MultiCell(30,5,'ESTADO',1,'C');
			// se dibuja la columna
			$this->Rect(170,self::comienzoTabla,30,self::limitePagina-self::comienzoTabla);
		}		
		//--------------------------------------------------------
		
		//dibujar cada fila 
		public function exportarDatos5collPersonas($datos){

			$starty = $this->GetY();
			//formato de la fuente (fuente,estilo,tamaño)
			$this->SetFont(PDF_FONT_NAME_MAIN,'',10);


			//columna identificador cliente
			//se posiciona el cursor
			$this->setXY(10,$starty);
			//se convierde de UTF-8 a windows-1252 porque FPDF no acepta UTF-8 - CENTRADO
			$this->Cell(30,self::alturaFila, 
							iconv('UTF-8', 'windows-1252', $datos[''.$this->coll1.'']),
			1,1,'C');

			//
			$this->setXY(40,$starty);
			//se convierde de UTF-8 a windows-1252 porque FPDF no acepta UTF-8 - CENTRADO
			$this->Cell(50,self::alturaFila,
			 				$datos[''.$this->coll2.''],
			 1,1,'C');
			//
			$this->setXY(90,$starty);
			//se convierde de UTF-8 a windows-1252 porque FPDF no acepta UTF-8 - CENTRADO
			$this->Cell(40,self::alturaFila,
			 				$datos[''.$this->coll3.''],
			 1,1,'C');			
			//
			$this->setXY(130,$starty);
			//se convierde de UTF-8 a windows-1252 porque FPDF no acepta UTF-8 - CENTRADO
			$this->Cell(40,self::alturaFila,
			 				$datos[''.$this->coll4.''],
			 1,1,'C');				
			//
			//se posiciona el cursor
			$this->setXY(170,$starty);
			//
			//se hace un cuadro de texto sin centrar
			$this->Cell(30,self::alturaFila, 
							iconv('UTF-8', 'windows-1252', '    '.$datos['estado']) ,
			1,'C');

			//salto de línea
			$this->Ln();
		}
		//funcion que dibuja la tabla en cuestión
		private function dibujarTabla5CollPersonas(){

			//formato de la fuente (fuente,estilo,tamaño)
			$this->SetFont(PDF_FONT_NAME_MAIN,'B',10);

			//se posiciona el cursor
			$this->setXY(10,self::comienzoTabla);
			//se hace un cuadro de texto (ancho, alto, texto, bordes, alineación del texto)
			$this->MultiCell(30,5,  strtoupper($this->coll1)  ,1,'C');
			// se dibuja la columna (x,y,ancho,alto)
			$this->Rect(10,self::comienzoTabla,30,self::limitePagina-self::comienzoTabla);


			//se posiciona el cursor
			$this->setXY(40,self::comienzoTabla);
			//se hace un cuadro de texto (ancho, alto, texto, bordes, alineación del texto)
			$this->MultiCell(50,5,  strtoupper($this->coll2)   ,1,'C');
			// se dibuja la columna (x,y,ancho,alto)
			$this->Rect(40,self::comienzoTabla,50,self::limitePagina-self::comienzoTabla);

			//se posiciona el cursor
			$this->setXY(90,self::comienzoTabla);
			//se hace un cuadro de texto (ancho, alto, texto, bordes, alineación del texto)
			$this->MultiCell(40,5,  strtoupper($this->coll3)   ,1,'C');
			// se dibuja la columna (x,y,ancho,alto)
			$this->Rect(90,self::comienzoTabla,40,self::limitePagina-self::comienzoTabla);

			//se posiciona el cursor
			$this->setXY(130,self::comienzoTabla);
			//se hace un cuadro de texto (ancho, alto, texto, bordes, alineación del texto)
			$this->MultiCell(40,5,  strtoupper($this->coll4)   ,1,'C');
			// se dibuja la columna (x,y,ancho,alto)
			$this->Rect(130,self::comienzoTabla,40,self::limitePagina-self::comienzoTabla);

			//se posiciona el cursor
			$this->setXY(170,self::comienzoTabla);
			//se hace un cuadro de texto 
			$this->MultiCell(30,5,'ESTADO',1,'C');
			// se dibuja la columna
			$this->Rect(170,self::comienzoTabla,30,self::limitePagina-self::comienzoTabla);
		}		
		//--------------------------------------------------------
		//dibujar cada fila 
		public function exportarDatosCargos($datos){

			$starty = $this->GetY();
			//formato de la fuente (fuente,estilo,tamaño)
			$this->SetFont(PDF_FONT_NAME_MAIN,'',10);


			//columna identificador cliente
			//se posiciona el cursor
			$this->setXY(10,$starty);
			//se convierde de UTF-8 a windows-1252 porque FPDF no acepta UTF-8 - CENTRADO
			$this->Cell(90,self::alturaFila, 
							iconv('UTF-8', 'windows-1252', $datos[''.$this->coll1.'']),
			1,1,'C');

			//
			$this->setXY(100,$starty);
			//se convierde de UTF-8 a windows-1252 porque FPDF no acepta UTF-8 - CENTRADO
			$this->Cell(60,self::alturaFila,
			 				$datos[''.$this->coll2.''],
			 1,1,'C');	
			//
			//se posiciona el cursor
			$this->setXY(160,$starty);
			//
			//se hace un cuadro de texto sin centrar
			$this->Cell(40,self::alturaFila, 
							iconv('UTF-8', 'windows-1252', '    '.$datos['estado']) ,
			1,'C');

			//salto de línea
			$this->Ln();
		}
		//funcion que dibuja la tabla en cuestión
		private function dibujarTablaCargos(){

			//formato de la fuente (fuente,estilo,tamaño)
			$this->SetFont(PDF_FONT_NAME_MAIN,'B',10);

			//se posiciona el cursor
			$this->setXY(10,self::comienzoTabla);
			//se hace un cuadro de texto (ancho, alto, texto, bordes, alineación del texto)
			$this->MultiCell(90,5,  strtoupper($this->coll1)  ,1,'C');
			// se dibuja la columna (x,y,ancho,alto)
			$this->Rect(10,self::comienzoTabla,90,self::limitePagina-self::comienzoTabla);


			//se posiciona el cursor
			$this->setXY(100,self::comienzoTabla);
			//se hace un cuadro de texto (ancho, alto, texto, bordes, alineación del texto)
			$this->MultiCell(60,5,  strtoupper($this->coll2)   ,1,'C');
			// se dibuja la columna (x,y,ancho,alto)
			$this->Rect(100,self::comienzoTabla,60,self::limitePagina-self::comienzoTabla);

			//se posiciona el cursor
			$this->setXY(160,self::comienzoTabla);
			//se hace un cuadro de texto 
			$this->MultiCell(40,5,'ESTADO',1,'C');
			// se dibuja la columna
			$this->Rect(160,self::comienzoTabla,40,self::limitePagina-self::comienzoTabla);
		}				
		//--------------------------------------------------------
		//--------------------------------------------------------
		private function cargarImagenServerBase64($_base64IMG_,$_urlIMG_,$_nombreIMG_)
			{				
				$urlyimg = $_urlIMG_ . $_nombreIMG_;
				$im = imagecreatefromstring(base64_decode($_base64IMG_));
		        imagejpeg($im, $urlyimg);
		        imagedestroy($im);
				return $urlyimg;            		
			}
	}

	

?>