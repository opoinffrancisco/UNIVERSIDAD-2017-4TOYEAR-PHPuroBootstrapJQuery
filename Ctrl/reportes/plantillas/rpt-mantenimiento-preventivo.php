<?php
    $limite_fila_pagina_1 = 7; 
    $limite_fila_pagina_1_alcanzado = false;       
    $limite_fila_pagina_2 = 8;     
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
      color:black;
    }
    table.table-rpt {
        border: 0px solid #777;
        border-spacing: 0px;
        width:100%;
    }
    tr.fila-rpt {
        border: 0px solid #777;
    }
    td {
        padding: 5px;
        border: 0px solid #ccc;
        color: white;
    }
    td.fila-rpt-title {
        color: white;
        background: #ccc;
        padding: 2px;
        text-align: center;
    }
    td.fila-rpt-space {
        background: #fff;
        padding: 1px;
    }
    td.fila-rpt-space-footer {
      height: 50px;
    }
        td.columna-dato-cabecera {
        text-align: center;
        background: white;
        border-bottom:1px solid #ccc;
        border-right:1px solid #ccc;          
        color: black;
    }

    td.columna-nombre-cabecera {
        background: #eee;
        color: black;
        border-bottom:1px solid  #ccc;
        border-right:1px solid #ccc;        
    }
    td.columna-dato {
        text-align: center;
        background: white;
        border-right:1px solid #ccc;
        border-bottom:1px solid #ccc;        
        font-size:12px;
        color:black;
    }

    td.columna-nombre {
        background: #eee;
        color: white;
        border-right:1px solid  #ccc;
        font-size:12px;
    }
    td.columna-footer {
        background: #ccc;
        color: black;
        border-right:1px solid  white;
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
              <b>MINISTERIO DEL PODER POPULAR PARA LA EDUCACIÓN UNIVERSITARIA</b><br>
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

      <tr><td class="fila-rpt-title" colspan="6" style="color:white;"><b>DATOS ACTUALES DEL EQUIPO</b></td></tr>
      <tr class="fila-rpt">
        <td class="columna-nombre-cabecera" style="border-left:1px solid #ccc;"><b>SERIAL</b></td>
        <td class="columna-dato-cabecera" colspan="2" ><?php echo $this->serial; ?></td>
        <td class="columna-nombre-cabecera"><b>TIPO DE EQUIPO</b></td>
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->tipo_eq; ?></td>     
      </tr>
      <tr class="fila-rpt">
        <td class="columna-nombre-cabecera" style="border-left:1px solid #ccc;"><b>SERIAL DE BIEN NACIONAL</b></td>
        <td class="columna-dato-cabecera" colspan="2" ><?php echo $this->serial_bn; ?></td>
        <td class="columna-nombre-cabecera"><b>MARCA Y MODELO</b></td>
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->marcaymodelo; ?></td>           
      </tr>

      <tr><td class="fila-rpt-space-top" colspan="5"></td></tr>
      <?php 
        if (empty($this->fecha_desde) && empty($this->fecha_hasta) || 
            !empty($this->fecha_desde) && empty($this->fecha_hasta) ||
            empty($this->fecha_desde) && !empty($this->fecha_hasta)) {

      ?>
      <tr><td class="fila-rpt-title" colspan="6" style="color:white;"><b>MANTENIMIENTOS PREVENTIVOS</b></td></tr>
      <?php 
        }elseif (!empty($this->fecha_desde) && !empty($this->fecha_hasta)) {

      ?>
      <tr>
        <td class="fila-rpt-title" colspan="3" style="color:white;"><b>MANTENIMIENTOS PREVENTIVOS</b></td>
        <td class="fila-rpt-title" colspan="3" style="color:white;"><b>DESDE: <?php echo $this->fecha_desde; ?> </b> - <b>HASTA: <?php echo $this->fecha_hasta; ?> </b></td>        
      </tr>
      <?php 

        }
        foreach ($this->datos as $datos_fila) {
          $contador_fila=$contador_fila+1;
          if ($contador_fila==1 && $limite_fila_pagina_1_alcanzado==true) {
      ?>      
        <tr><td class="fila-rpt-title" colspan="6" style="color:white;"><b>MANTENIMIENTOS PREVENTIVOS</b></td></tr>

      <?php
          }
      ?>
      <tr class="fila-rpt">
        <td class="columna-nombre" style="border-left:1px solid #ccc;"><b>RESPONSABLE</b></td>
        <td class="columna-nombre" colspan="3"><b>TAREA</b></td>
        <td class="columna-nombre" ><b>INICIO</b></td>
        <td class="columna-nombre" ><b>FINALIZO</b></td>
      </tr >
      <tr class="fila-rpt">
        <td class="columna-dato" style="border-left:1px solid #ccc;"><?php echo 'C.I:  '.$datos_fila['RESPONSABLE'];?></td>
        <td class="columna-dato" colspan="3" ><?php echo $datos_fila['TAREA'];?></td> 
        <td class="columna-dato" ><?php echo $datos_fila['INICIO'];?></td>
        <td class="columna-dato" style="border-right:1px solid #ccc;"><?php echo $datos_fila['FINALIZO'];?></td>
      </tr >      
      <tr class="fila-rpt">

        <td class="columna-nombre" style="border-left:1px solid #ccc;"><b>DURACIÓN</b></td>
        <td class="columna-nombre"><b>ESTIMACIÓN</b></td>
        <td class="columna-nombre"><b>TARDANZA</b></td>       
        <td class="columna-nombre" colspan="3" ><b>OBSERVACIÓN</b></td>
      </tr >
      <tr >
        <td class="columna-dato"  style="border-left:1px solid #ccc;"><?php echo $datos_fila['DURACCION'];?></td>
        <td class="columna-dato"><?php echo $datos_fila['TIEMPO ESTIMADO'];?></td>
        <td class="columna-dato"><?php echo $datos_fila['TARDANZA'];?></td>
        <td class="columna-dato" colspan="3" style="border-right:1px solid #ccc;"><?php echo $datos_fila['OBSERVACION'];?></td>
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
                <tr><td class="fila-rpt-space-footer" colspan="6"></td></tr>           

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
                <tr><td class="fila-rpt-space-footer" colspan="6"></td></tr>           

      <?php
              }


      ?>    
    </tbody>
  </table>

</body>
</html>
