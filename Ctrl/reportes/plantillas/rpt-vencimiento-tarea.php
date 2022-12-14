<?php
    $limite_fila_pagina_1 = 6; 
    $limite_fila_pagina_1_alcanzado = false;       
    $limite_fila_pagina_2 = 7;     
    $contador_fila=0;
    $contador_paginacion=0;    
?>


<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta charset="utf-8">
  

  <style type="text/css">
    *{
      font-size:11px;  
    }
    table.table-rpt {
        border: 0px solid #ccc;
        border-spacing: 0px;
        width:100%;
    }
    tr.fila-rpt {
        border: 0px solid #ccc;
    }
    td {
        padding: 5px;
        border: 0px solid #fff;
        color: black;
    }
    td.fila-rpt-title {
        color: black;
        background: #ccc;
        padding: 2px;
        text-align: center;
    }
    td.fila-rpt-title-filtro {
        color: black;
        background: white;
        padding: 2px;
        text-align: center;
    }    
    td.fila-rpt-space {
        background: #ccc;
        padding: 0px;
    }
    td.fila-rpt-space-footer {
      height: 40px;
    }
    td.columna-dato-cabecera {
        text-align: center;
        background: #fff;
        border-bottom:1px solid #eee;
    }

    td.columna-nombre-cabecera {
        background: #eee;
        color: black;
        border-bottom:1px solid  #fff;
    }
    td.columna-dato {
        text-align: center;
        background: #fff;
        border-right:1px solid #ccc;
        border-left:1px solid #ccc;        
        font-size:12px;
        border-bottom: 1px solid #ccc;
    }

    td.columna-nombre {
        background: #ccc;
        color: black;
        border-right:1px solid  #fff;
        font-size:12px;
    }
    td.columna-footer {
        background: #ccc;
        color: black;
        border-right:1px solid  #fff;
        font-size:10px;

    }    
  </style>
</head>
<body>



  <table class="table-rpt" style="position:relative;">
    <thead class="cabecera">

      <tr>
        <td colspan="6" style="color:black;">
          <div class="row" style="position:relative; height:130px;" >
            <div class="col-md-2" style="float: left;">
             <img src="<?php echo $this->logo; ?>" style="width:100px;height:100px;">
            </div>
            <div class="col-md-8" style="text-align: center;font-size:12px;float: left;width: 75%;">
              <br><br>
              <b>MINISTERIO DEL PODER POPULAR PARA LA EDUCACI??N UNIVERSITARIA</b><br>
              <b><?php echo $this->nombre_ente; ?></b>
              <br><br><br>
              <b><?php echo $this->titulo; ?></b>
            </div>
            <div class="col-md-2" style="float: right;">
             <img src="../../Vist/img/logo.png" style="width:100px;height:100px;">
            </div>             
          </div>          
        </td>
      </tr>
 
    </thead>
    <tbody class="resultado">

      <?php 

        if (!empty($this->fecha_desde) && !empty($this->fecha_hasta)) {
      ?>
        <tr>
          <td class="fila-rpt-title-filtro" colspan="6" style="color:black;"><b>ENTRE: <?php echo $this->fecha_desde; ?> </b> -  <b>Y: <?php echo $this->fecha_hasta; ?> </b></td>        
        </tr>
        <tr>
          <td>
            <br>    
          </td>
        </tr>
        
      <?php 
        }
      ?>

      <tr class="fila-rpt">
        <td class="columna-nombre"  ><b>VENCIMIENTO</b></td>      
        <td class="columna-nombre" colspan="4" ><b>TAREA</b></td>
        <td class="columna-nombre"  ><b>SERIAL EQUIPO</b></td>        
      </tr >

      <?php
        foreach ($this->datos as $datos_fila) {
          $contador_fila=$contador_fila+1;
      ?>
      <tr class="fila-rpt">
        <td class="columna-dato"  ><?php echo $datos_fila['DIAS_INTERVALO'];?></td>      
        <td class="columna-dato" colspan="4" ><?php echo $datos_fila['NOMBRE'];?></td>
        <td class="columna-dato"  ><?php echo $datos_fila['SERIAL'];?></td> 
      </tr >      
      <tr><td class="fila-rpt-space" colspan="6"></td></tr>           
      <?php
              // limite de la pagina principal 6
              if ($contador_fila==$limite_fila_pagina_1 && $limite_fila_pagina_1_alcanzado==false 
                  ) {
                $contador_paginacion=$contador_paginacion+1;
                $limite_fila_pagina_1_alcanzado=true;
                $contador_fila=0;
      ?>          
                <tr >
                  <td class="columna-footer" colspan="2" ><b>USUARIO: <?php echo $this->usuario; ?></b></td>
                  <td class="columna-footer" colspan="2" ><b>PAGINA : <?php echo $contador_paginacion; ?></b></td>
                  <td class="columna-footer" colspan="2" ><b>GENERADO EL : <?php echo $this->fecha_actual; ?></b></td>
                </tr >        
      <?php
              }
              // limite de la pagina segundario 7
              if ($contador_fila==$limite_fila_pagina_2 && $limite_fila_pagina_1_alcanzado==true) {
                $contador_paginacion=$contador_paginacion+1;
                $contador_fila=0;
      ?>          
                <tr >
                  <td class="columna-footer" colspan="2" ><b>USUARIO: <?php echo $this->usuario; ?></b></td>
                  <td class="columna-footer" colspan="2" ><b>PAGINA : <?php echo $contador_paginacion; ?></b></td>
                  <td class="columna-footer" colspan="2" ><b>GENERADO EL : <?php echo $this->fecha_actual; ?></b></td>
                </tr >        
                <tr><td class="fila-rpt-space-footer" colspan="6"></td></tr>           

      <?php
              }
              
          }
              if ($contador_fila<$limite_fila_pagina_1) {
                $contador_paginacion=$contador_paginacion+1;
      ?>          
                <tr >
                  <td class="columna-footer" colspan="2" ><b>USUARIO: <?php echo $this->usuario; ?></b></td>
                  <td class="columna-footer" colspan="2" ><b>PAGINA : <?php echo $contador_paginacion; ?></b></td>
                  <td class="columna-footer" colspan="2" ><b>GENERADO EL : <?php echo $this->fecha_actual; ?></b></td>
                </tr >        
      <?php
              }


      ?>    
    </tbody>
  </table>

</body>
</html>
