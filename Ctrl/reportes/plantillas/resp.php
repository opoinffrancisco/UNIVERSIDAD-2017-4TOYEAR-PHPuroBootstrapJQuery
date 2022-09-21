      <tr class="fila-rpt">
        <td class="columna-nombre"><b>RESPONSABLE</b></td>
        <td class="columna-nombre" colspan="3"><b>TAREA</b></td>
        <td class="columna-nombre" ><b>INICIO</b></td>
        <td class="columna-nombre" ><b>FINALIZO</b></td>
      </tr >
      <tr class="fila-rpt">
        <td class="columna-dato"><?php echo 'C.I:  '.$datos_fila['RESPONSABLE'];?></td>
        <td class="columna-dato" colspan="3" ><?php echo $datos_fila['TAREA'];?></td> 
        <td class="columna-dato" ><?php echo $datos_fila['INICIO'];?></td>
        <td class="columna-dato" ><?php echo $datos_fila['FINALIZO'];?></td>
      </tr >      
      <tr class="fila-rpt">

        <td class="columna-nombre"><b>DURACIÓN</b></td>
        <td class="columna-nombre"><b>ESTIMACIÓN</b></td>
        <td class="columna-nombre"><b>TARDANZA</b></td>       
        <td class="columna-nombre" colspan="3" ><b>OBSERVACIÓN</b></td>
      </tr >
      <tr >
        <td class="columna-dato"><?php echo $datos_fila['DURACCION'];?></td>
        <td class="columna-dato"><?php echo $datos_fila['TIEMPO ESTIMADO'];?></td>
        <td class="columna-dato"><?php echo $datos_fila['TARDANZA'];?></td>
        <td class="columna-dato" colspan="3"><?php echo $datos_fila['OBSERVACION'];?></td>
      </tr >
      <tr><td class="fila-rpt-space" colspan="6"></td></tr>           

















            <tr class="fila-rpt">
        <td class="columna-nombre-cabecera"><b>FECHA DE SOLICITUD</b></td>
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->fecha_solicitud; ?></td>
        <td class="columna-nombre-cabecera"><b>FECHA DE ATENCIÓN</b></td>
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->fecha_atencion; ?></td>
        <td class="columna-nombre-cabecera"><b>FECHA DE CIERRE</b></td>
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->fecha_cierre; ?></td>        
      </tr>

      <tr><td class="fila-rpt-title" colspan="6" style="color:white;"><b>DATOS DEL SOLICITANTE</b></td></tr>
      <tr class="fila-rpt">
        <td class="columna-nombre-cabecera"><b>CEDÚLA</b></td>
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->ci_solicitante; ?></td>
        <td class="columna-nombre-cabecera"><b>CARGO Y DEPARTAMENTO</b></td>
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->cargoYdpto_solicitante; ?></td>     
      </tr>

      <?php
          if ($this->ci_responsable_asignado!=0) {
      ?>
      <tr><td class="fila-rpt-title" colspan="6" style="color:white;"><b>DATOS DEL RESPONSABLE ASIGNADO</b></td></tr>
      <tr class="fila-rpt">
        <td class="columna-nombre-cabecera"><b>CEDÚLA</b></td>
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->ci_responsable_asignado; ?></td>
        <td class="columna-nombre-cabecera"><b>CARGO Y DEPARTAMENTO</b></td>
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->cargoYdpto_responsable_asignado; ?></td>     
      </tr>
      <?php
        }
      ?>

      <tr><td class="fila-rpt-title" colspan="6" style="color:white;"><b>DATOS DEL EQUIPO</b></td></tr>
      <tr class="fila-rpt">
        <td class="columna-nombre-cabecera"><b>SERIAL</b></td>
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->serial_e; ?></td>
        <td class="columna-nombre-cabecera"><b>TIPO DE EQUIPO</b></td>
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->tipo_e; ?></td>     
      </tr>
      <tr class="fila-rpt">
        <td class="columna-nombre-cabecera"><b>SERIAL DE BIEN NACIONAL</b></td>
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->serial_bn_e; ?></td>
        <td class="columna-nombre-cabecera"><b>MARCA Y MODELO</b></td>
        <td class="columna-dato-cabecera" colspan="2"><?php echo $this->marcaymodelo_e; ?></td>           
      </tr>

      <tr><td class="fila-rpt-space-top" colspan="5"></td></tr>
      <tr><td class="fila-rpt-title" colspan="6" style="color:white;"><b>ACTIVIDADES</b></td></tr>

      <?php 
        foreach ($this->datos as $datos_fila) {
          $contador_fila=$contador_fila+1;
      ?>      


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
