<?php
    if ($_SESSION['opcionrpt']=="generico") {
      $limite_fila_pagina_1 = 4; 
      $limite_fila_pagina_1_alcanzado = false;       
      $limite_fila_pagina_2 = 14;     
      $contador_fila=0;
      $contador_paginacion=0;    
      $desactivar_antes_activas=false;
    }else{
      $limite_fila_pagina_1 = 4; 
      $limite_fila_pagina_1_alcanzado = false;       
      $limite_fila_pagina_2 = 10;     
      $contador_fila=0;
      $contador_paginacion=0;    
      $desactivar_antes_activas=false;      
    }




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
        border: 0px solid #777;
        border-spacing: 0px;
        width:100%;
    }
    thead.cabecera{
      width: 100%;
    }
    tr.fila-rpt {
        border: 0px solid #777;
    }
    td {
        padding: 5px;
        border: 0px solid #ccc;
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
    td.fila-rpt-space-fila {
        padding: 4px;
    }
    td.fila-rpt-space-fila-2{
      padding: 2px;
    }
    td.fila-rpt-space {
/*      background: #ccc; */
        padding: 10px;
    }
    td.fila-rpt-space-filtro{
        height: 58px;
    }
    td.fila-rpt-space-filtro_1{
        height: 24px;
    }    
    td.fila-rpt-space-filtro_2{
        height: 7px;
    }    
    td.fila-rpt-space_cedula {
        height: 260px;
    }
    td.fila-rpt-space_sin_cedula {
        height: 260px;
    }        
    td.fila-rpt-space-footer {
      height: 1px;
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
            <div class="col-md-8" style="text-align: center;font-size:12px;float: left;width: 73%;">
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
<!--
      <tr>
        <td class="fila-rpt-title" colspan="6" style="color:black;">
          <b>
            PROMEDIO DE TAREAS CORRECTIVAS REALIZADAS EN LOS DEPARTAMENTOS
          </b>
        </td>
      </tr>
-->          
      <?php
          $count_margen=0;
          if (!empty($this->funcion) || !empty($this->departamento) ||  
               (!empty($this->fecha_desde) && !empty($this->fecha_hasta))) {
      ?>
      <tr>
        <td class="fila-rpt-title" colspan="6" style="color:black;">
          <b>
            SEG??N LAS SIGUIENTES ESPESIFICACIONES
          </b>
        </td>
      </tr>    
      <?php      

              if (!empty($this->fecha_desde) && !empty($this->fecha_hasta)) {
                $count_margen=$count_margen+1;
            ?>
                <tr>
                  <td class="fila-rpt-title-filtro" colspan="6" style="color:black;"><b>DESDE: <?php echo $this->fecha_desde; ?> </b> -  <b>HASTA: <?php echo $this->fecha_hasta; ?> </b></td>        
                </tr>
            <?php 
              }
              switch ($count_margen) {
                case '1':
                    ?>
                      <tr><td class="fila-rpt-space-filtro_1"></td></tr>
                    <?php
                  break;
                case '2'
                    ?>
                      <tr><td class="fila-rpt-space-filtro_2"></td></tr>
                    <?php
                  break;
              }
         }else{
       ?>     
            <tr><td class="fila-rpt-space-filtro"></td></tr>
      <?php
          }
      ?>   

      <tr>
        <td class="" colspan="6" style="color:black;">
          <img src="<?php echo $this->img_grafico_1; ?>" style="padding-left:20px;width:690px;height:500px;">    
        </td>
      </tr>
      <?php
          if (!empty($this->funcion) || !empty($this->departamento) ||
               (!empty($this->fecha_desde) && !empty($this->fecha_hasta))) {
      ?>
        <tr><td class="fila-rpt-space_cedula" colspan="6"></td></tr>       
      <?php
         }else{
       ?>   
        <tr><td class="fila-rpt-space_sin_cedula" colspan="6"></td></tr>   
      <?php
          }
      ?>      
      <?php
              // limite de la pagina principal 6
              if ($limite_fila_pagina_1_alcanzado==false) {
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
      ?>



      <?php 


        if(!empty($this->datos)){
        foreach ($this->datos as $datos_fila) {
          $contador_fila=$contador_fila+1;
          if ($contador_fila==1) {
      ?>
      <tr><td class="fila-rpt-space-fila" colspan="6"></td></tr>  
      <!--  
            <tr>
              <td class="fila-rpt-title" colspan="6" style="color:black;">
                <b>
                  PROMEDIO DE TAREAS CORRECTIVAS REALIZADAS EN LOS DEPARTAMENTOS
                </b>
              </td>
            </tr>
            <tr><td class="fila-rpt-space-fila" colspan="6"></td></tr>        
      -->      
      <tr class="fila-rpt">
        <td class="columna-nombre" colspan="1" ><b>FECHA</b></td>
        <td class="columna-nombre" colspan="1" ><b>CONCURRENCIA</b></td>        
        <td class="columna-nombre" colspan="4" ><b>FUNCI??N</b></td>
      </tr >
      <?php
          } else {
      ?>
      <?php
          }
          
      ?>      


      <tr class="fila-rpt" >
        <td class="columna-dato" colspan="1" style="border-top:1px solid #ccc;"><?php echo $datos_fila['FECHA_M'];?></td>
        <td class="columna-dato" colspan="1" style="border-top:1px solid #ccc;"><?php echo $datos_fila['CONCURRENCIA'];?></td>
        <td class="columna-dato" colspan="4" style="border-top:1px solid #ccc;"><?php echo $datos_fila['FUNCION'];?></td> 
      </tr >      
      <tr class="fila-rpt">
        <td class="columna-nombre" colspan="1" >DEPARTAMENTO</td>
        <td class="columna-dato" colspan="5" ><?php echo $datos_fila['NOMBRE_DEPARTAMENTO'];?></td>
      </tr >            
        <?php 
          if ($_SESSION['opcionrpt']=="detallado") {
        ?>
      <tr class="fila-rpt">
        <td class="columna-nombre" colspan="1" style="border-top:1px solid white;" >OBSERVACI??N</td>
        <td class="columna-dato" colspan="5" ><?php echo $datos_fila['OBSERVACION'];?></td>
      </tr >            
      <tr><td class="fila-rpt-space-fila-2" colspan="6"></td></tr>       
        <?php 
          }else{
        ?>
        <tr><td class="fila-rpt-space-fila" colspan="6"></td></tr>
      <?php
          }
             $desactivar_antes_activas=false;
              // limite de la pagina segundario 7
              if ($contador_fila==$limite_fila_pagina_2 && $limite_fila_pagina_1_alcanzado==true) {
                $contador_paginacion=$contador_paginacion+1;
                $contador_fila=0;
                $desactivar_antes_activas=true;                
      ?>            
                <tr><td class="fila-rpt-space-fila-2" colspan="6"></td></tr>  
                <tr><td class="fila-rpt-space-fila-2" colspan="6"></td></tr>  
                <tr style="margin-bottom:1px;">
                  <td class="columna-footer" colspan="2" ><b>USUARIO: <?php echo $this->usuario; ?></b></td>
                  <td class="columna-footer" colspan="2" ><b>PAGINA : <?php echo $contador_paginacion; ?></b></td>
                  <td class="columna-footer" colspan="2" ><b>GENERADO EL : <?php echo $this->fecha_actual; ?></b></td>
                </tr >   


      <?php
              }
              
          }



              if ($desactivar_antes_activas==false) {
                $contador_paginacion=$contador_paginacion+1;
      ?>          
                <tr >
                  <td class="columna-footer" colspan="2" ><b>USUARIO : <?php echo $this->usuario; ?></b></td>
                  <td class="columna-footer" colspan="2" ><b>PAGINA : <?php echo $contador_paginacion; ?></b></td>
                  <td class="columna-footer" colspan="2" ><b>GENERADO EL : <?php echo $this->fecha_actual; ?></b></td>
                </tr >        

      <?php
              }          
      }
      ?>    

    </tbody>
  </table>

</body>
</html>
