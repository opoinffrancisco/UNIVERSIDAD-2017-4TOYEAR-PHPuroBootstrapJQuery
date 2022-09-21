<?php
    $limite_fila_pagina_1 = 6; 
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
    thead.cabecera{
      width: 100%;
    }
    tr.fila-rpt {
        border: 1px solid #777;
    }
    td {
        padding: 5px;
        border: 0px solid #ccc;
        color: black;
    }
    td.fila-rpt-title {
        color: white;
        background: #ccc;
        padding: 2px;
        text-align: center;
    }
    td.fila-rpt-space {
        background: #fff;
        padding: 2px;
    }
    td.fila-rpt-space-footer {
      height: 30px;
    }
    td.columna-dato-cabecera {
        text-align: center;
        background: white;
        border-bottom:1px solid #ccc;
        border-left:1px solid #ccc;          
        color: black;
    }

    td.columna-nombre-cabecera {
        background: #eee;
        color: black;
        border-bottom:1px solid  #ccc;
        border-left:1px solid #ccc;        
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
      <tr><td class="fila-rpt-title" colspan="6" style="color:white;"><b>DATOS DE SOLICITUD</b></td></tr>
      <tr class="fila-rpt">
        <td class="columna-nombre-cabecera " colspan="2"><b>ASUNTO</b></td>
        <td class="columna-dato-cabecera" colspan="4"  style="border-right:1px solid #ccc;"><?php echo $this->asunto; ?></td>
      </tr>
      <tr class="fila-rpt">
        <td class="columna-nombre-cabecera" rowspan="3" colspan="2"><b>DESCRIPCIÓN</b></td>
        <td class="columna-dato-cabecera" rowspan="3" colspan="4"  style="border-right:1px solid #ccc;"><?php echo $this->descripcion; ?></td>
      </tr>
      <tr>
        <td></td><td></td>
      </tr>      
      <tr>
        <td></td><td></td>
      </tr>            
      <tr class="fila-rpt">
        <td class="columna-nombre-cabecera" colspan="2"><b>FECHA DE SOLICITUD</b></td>
        <td class="columna-nombre-cabecera" colspan="2"><b>FECHA DE ATENCIÓN</b></td>
        <td class="columna-nombre-cabecera" colspan="2" style="border-right:1px solid #ccc;"><b>FECHA DE CIERRE</b></td>
      </tr>
      <tr class="fila-rpt">
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->fecha_solicitud; ?></td>
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->fecha_atencion; ?></td>
        <td class="columna-dato-cabecera" colspan="2" style="border-right:1px solid #ccc;"><?php echo $this->fecha_cierre; ?></td>        
      </tr>      

      <tr><td class="fila-rpt-title" colspan="6" style="color:white;"><b>DATOS DEL SOLICITANTE</b></td></tr>
      <tr class="fila-rpt">
        <td class="columna-nombre-cabecera"><b>CEDÚLA</b></td>
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->ci_solicitante; ?></td>
        <td class="columna-nombre-cabecera" ><b>CARGO Y DEPARTAMENTO</b></td>
        <td class="columna-dato-cabecera" colspan="2"  style="border-right:1px solid #ccc;"><?php echo $this->cargoYdpto_solicitante; ?></td>     
      </tr>

      <?php
          if ($this->ci_responsable_asignado!=0) {
      ?>
      <tr><td class="fila-rpt-title" colspan="6" style="color:white;"><b>DATOS DEL RESPONSABLE ASIGNADO</b></td></tr>
      <tr class="fila-rpt">
        <td class="columna-nombre-cabecera"><b>CEDÚLA</b></td>
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->ci_responsable_asignado; ?></td>
        <td class="columna-nombre-cabecera"><b>CARGO Y DEPARTAMENTO</b></td>
        <td class="columna-dato-cabecera" colspan="2"  style="border-right:1px solid #ccc;"><?php echo $this->cargoYdpto_responsable_asignado; ?></td>     
      </tr>
      <?php
        }
      ?>

      <tr><td class="fila-rpt-title" colspan="6" style="color:white;"><b>DATOS DEL EQUIPO</b></td></tr>
      <tr class="fila-rpt">
        <td class="columna-nombre-cabecera"><b>SERIAL</b></td>
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->serial_e; ?></td>
        <td class="columna-nombre-cabecera"><b>TIPO DE EQUIPO</b></td>
        <td class="columna-dato-cabecera" colspan="2"  style="border-right:1px solid #ccc;"><?php echo $this->tipo_e; ?></td>     
      </tr>
      <tr class="fila-rpt">
        <td class="columna-nombre-cabecera"><b>SERIAL DE BIEN NACIONAL</b></td>
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->serial_bn_e; ?></td>
        <td class="columna-nombre-cabecera"><b>MARCA Y MODELO</b></td>
        <td class="columna-dato-cabecera" colspan="2"  style="border-right:1px solid #ccc;"><?php echo $this->marcaymodelo_e; ?></td>           
      </tr>

      <tr><td class="fila-rpt-space-top" colspan="5"></td></tr>
      <tr><td class="fila-rpt-title" colspan="6" style="color:white;"><b>ACTIVIDADES</b></td></tr>


      <?php 
        foreach ($this->datos as $datos_fila) {
          $contador_fila=$contador_fila+1;
          
          $observacion_fila = $datos_fila['OBSERVACION'];

      ?>      

      <tr class="fila-rpt">
        <td class="columna-nombre" colspan="1" ><b>RESPONSABLE</b></td>
        <td class="columna-nombre" colspan="3" ><b>ACTIVIDAD</b></td>
        <td class="columna-nombre" colspan="2" ><b>FECHA DE EJECUCIÓN</b></td>
      </tr >
      <tr class="fila-rpt">
        <td class="columna-dato" colspan="1" style="border-left:1px solid #ccc;" ><?php echo $datos_fila['RESPONSABLE'];?></td>
        <td class="columna-dato" colspan="3" ><?php echo $datos_fila['FUNCION'];?></td> 
        <td class="columna-dato" colspan="2" ><?php echo $datos_fila['FECHA_EJECUCION'];?></td>
      </tr >      
      <?php
        if ($datos_fila['DETALLES_EJECUCION']=='NO-APLICA' && $datos_fila['OBSERVACION']=='NO-APLICA' ) {
        }elseif ($datos_fila['DETALLES_EJECUCION']!='NO-APLICA' && $datos_fila['OBSERVACION']=='NO-APLICA' ) {
      ?>
          <tr class="fila-rpt">
            <td class="columna-nombre" colspan="3" ><b>DETALLES</b></td>
            <td class="columna-nombre" colspan="3" ><b>OBSERVACIÓN</b></td>
          </tr >
          <tr >
            <td class="columna-dato" colspan="3" style="border-left:1px solid #ccc;"><?php echo $datos_fila['DETALLES_EJECUCION'];?></td>
            <td class="columna-dato" colspan="3" ><?php echo $observacion_fila;?></td>
          </tr >
        
      <?php
        }elseif ($datos_fila['DETALLES_EJECUCION']=='NO-APLICA' && $datos_fila['OBSERVACION']!='NO-APLICA' ) {
      ?>
          <tr class="fila-rpt">
            <td class="columna-nombre" colspan="3" ><b>DETALLES</b></td>
            <td class="columna-nombre" colspan="3" ><b>OBSERVACIÓN</b></td>
          </tr >
          <tr >
            <td class="columna-dato" colspan="3" style="border-left:1px solid #ccc;"><?php echo $datos_fila['DETALLES_EJECUCION'];?></td>
            <td class="columna-dato" colspan="3" ><?php echo $observacion_fila;?></td>
          </tr >
        
      <?php
        }else{
      ?>
          <tr class="fila-rpt">
            <td class="columna-nombre" colspan="3" ><b>DETALLES</b></td>
            <td class="columna-nombre" colspan="3" ><b>OBSERVACIÓN</b></td>
          </tr >
          <tr >
            <td class="columna-dato" colspan="3" style="border-left:1px solid #ccc;"><?php echo $datos_fila['DETALLES_EJECUCION'];?></td>
            <td class="columna-dato" colspan="3" ><?php echo $observacion_fila;?></td>
          </tr >
        
      <?php
        }
      ?>
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

      <?php
              }


      ?>    

    </tbody>
  </table>

</body>
</html>
