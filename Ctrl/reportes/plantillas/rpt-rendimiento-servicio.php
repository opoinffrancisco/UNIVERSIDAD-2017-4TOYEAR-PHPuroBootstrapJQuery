<?php
    $limite_fila_pagina_1 = 4; 
    $limite_fila_pagina_1_alcanzado = false;       
    $limite_fila_pagina_2 = 6;     
    $contador_fila=0;
    $contador_paginacion=0;    

    $desactivar_antes_activas=false;
/*
    foreach ($this->datos as $datos_fila) {
      $id_f = $datos_fila['ID_FUNCION'];
      if ($id_f==4 || $id_f==5 || $id_f==6 || $id_f==7 || $id_f==8 || $id_f==9 || $id_f==10 || $id_f==11 ) {
        //echo $datos_fila['DETALLES_EJECUCION'];
          $arrary = $datos_fila['DETALLES_EJECUCION'];
          $porciones = explode("#ARRAY#", $arrary);

          echo $porciones[0];
          echo $porciones[1];          
         
      }
      
    }
    die("<br>stop"); 
    */
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
    td.fila-rpt-space-fila {
/*      background: #ccc; */
        padding: 4px;
    }
    td.fila-rpt-space {
/*      background: #ccc; */
        padding: 10px;
    }
    td.fila-rpt-space_cedula {
        height: 480px;
    }
    td.fila-rpt-space_sin_cedula {
        height: 580px;
    }        
    td.fila-rpt-space-footer {
      height: 1px;
    }
    td.columna-dato-cabecera {
        text-align: center;
        background: white;
        border-bottom:1px solid #ccc;
        border-right:1px solid #ccc;
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
        border-bottom:1px solid #ccc;
        border-right:1px solid #ccc;
        font-size:12px;
    }

    td.columna-nombre {
/*        background: rgb(35, 95, 146);*/
        background: #eee;
        color: black;
        border-bottom:1px solid #ccc;
        border-right:1px solid  #ccc;
        font-size:12px;
    }
    td.columna-footer {
        background: #ccc;
        color: black;
        border-right:1px solid  #eee;
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


      <?php
          if ($this->cedula_t!="") {
      ?>
      <tr><td class="fila-rpt-title" colspan="6" style="color:black;"><b>DATOS DEL TECNICO</b></td></tr>
      <tr class="fila-rpt">
        <td class="columna-nombre-cabecera" colspan="2" style="border-left:1px solid #ccc;"><b>CEDÚLA</b></td>
        <td class="columna-dato-cabecera" colspan="4"><?php echo $this->cedula_t; ?></td>
      </tr>        
      <tr class="fila-rpt">
        <td class="columna-nombre-cabecera" colspan="2" style="border-left:1px solid #ccc;"><b>NOMBRE Y APELLIDO</b></td>
        <td class="columna-dato-cabecera" colspan="4"><?php echo $this->nombre_apellido_t ?></td>     
      </tr>
      <tr class="fila-rpt">
        <td class="columna-nombre-cabecera" colspan="2" style="border-left:1px solid #ccc;"><b>CORREO ELÉCTRONICO</b></td>
        <td class="columna-dato-cabecera" colspan="4"><?php echo $this->correo_electronico_t; ?></td>
      </tr>      
      <?php
        }
      ?>

      <tr>
        <td class="fila-rpt-title" colspan="6" style="color:black;">
          <b>
            TAREAS REALIZADAS CON TIEMPO EXTRA DE EJECUCIÓN
          </b>
        </td>
      </tr>    
      <tr>
        <td class="" colspan="6" style="color:black;">
          <img src="<?php echo $this->img_grafico_1; ?>" style="padding-left:20px;width:650px;height:250px;">    
        </td>
      </tr>
      <?php
          if ($this->cedula_t!="") {
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
      <tr>
        <td class="fila-rpt-title" colspan="6" style="color:black;">
          <b>
            TAREAS
          </b>
        </td>
      </tr>
      <?php
          } else {
      ?>
      <tr><td class="fila-rpt-space-fila" colspan="6"></td></tr>  
      <?php
          }
          
      ?>      

      <tr class="fila-rpt">
        <td class="columna-nombre" colspan="1" style="border-left:1px solid #ccc;"><b>TIPO</b></td>
        <td class="columna-nombre" colspan="3" ><b>TAREA</b></td>
        <td class="columna-nombre" colspan="2" ><b>FECHA DE FINALIZACIÓN</b></td>
      </tr >
      <tr class="fila-rpt">
        <td class="columna-dato" colspan="1" style="border-left:1px solid #ccc;"><?php echo $datos_fila['NOMBRE_TIPO_TAREA'];?></td>
        <td class="columna-dato" colspan="3" ><?php echo $datos_fila['NOMBRE_TAREA'];?></td> 
        <td class="columna-dato" colspan="2" ><?php echo $datos_fila['FECHA_FINALIZACION'];?></td>
      </tr >      
      <tr class="fila-rpt">
        <td class="columna-nombre" colspan="2" style="border-left:1px solid #ccc;"><b>DURACIÓN</b></td>
        <td class="columna-nombre" colspan="2" ><b>ESTIMACIÓN</b></td>
        <td class="columna-nombre" colspan="2" ><b>TIEMPO EXTRA OCUPADO</b></td>
      </tr >
      <tr class="fila-rpt">
        <td class="columna-dato" colspan="2" style="border-left:1px solid #ccc;"><?php echo $datos_fila['DURACION'];?></td>
        <td class="columna-dato" colspan="2" ><?php echo $datos_fila['ESTIMACION']." Horas";?></td> 
        <td class="columna-dato" colspan="2" ><?php echo $datos_fila['TARDANZA']." Horas";?></td>
      </tr >            
      <tr class="fila-rpt">
        <td class="columna-nombre" colspan="1" rowspan="2" style="border-left:1px solid #ccc;"><b>OBSERVACIÓN</b></td>
        <td class="columna-dato" colspan="5" rowspan="2"  ><?php echo $datos_fila['OBSERVACION'];?></td>
      </tr >
      <tr><td class="fila-rpt-space" colspan="6"></td></tr>         

      <?php

              $desactivar_antes_activas=false;
              // limite de la pagina segundario 7
              if ($contador_fila==$limite_fila_pagina_2 && $limite_fila_pagina_1_alcanzado==true) {
                $contador_paginacion=$contador_paginacion+1;
                $contador_fila=0;
                $desactivar_antes_activas=true;                
      ?>          
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
