
		<!-- Cuerpo de catalogo -->
		<div id="ctlgRendimiento" class="panel-body" style="height: 74%;"> 
		    <div class="row">
				<div class="col-md-4"  >
					<div id="divMarcaListD" class="form-group">
						<select  id="funcionListD" class="select  selectpicker  " data-select="1" name="Marca" data-show-subtext="true" data-live-search="true"
							onchange="	mtdDesincorporacionesConcurrentes.cargarGraficoPublic();">
							<option data-subtext="" value="0">Seleccione una función</option>
							<option data-subtext="" value="4">DESINCORPORO EQUIPO</option>
							<option data-subtext="" value="5">DESINCORPORO PERIFERICO</option>
							<option data-subtext="" value="6">DESINCORPORO COMPONENTE</option>
							<option data-subtext="" value="7">CAMBIO POR PERIFÉRICO NUEVO</option>
							<option data-subtext="" value="8">CAMBIO POR PERIFÉRICO USADO</option>
							<option data-subtext="" value="9">CAMBIO POR COMPONENTE NUEVO</option>
							<option data-subtext="" value="10">CAMBIO POR COMPONENTE USADO</option>
						</select>
					</div>
				</div>
				<div class="col-md-3"  >
					<div class="input-group">
						<span class="input-group-addon" id="sizing-addon2" >Desde:</span>
						<input type="date" maxlength="30" min="6" class="form-control input-sm" id="buscardorDesde"
						onkeyup="mtdDesincorporacionesConcurrentes.cargarGraficoPublic();"
						onchange="mtdDesincorporacionesConcurrentes.cargarGraficoPublic();"
						placeholder="Ingresar fecha" aria-describedby="sizing-addon2">
					</div>				
				</div>    
				<div class="col-md-3 "  style="margin-left: 8%;" >
					<div class="input-group">
					  	<span class="input-group-addon" id="sizing-addon2" >Hasta:</span>
						<input type="date" maxlength="30" min="6" class="form-control input-sm" id="buscardorHasta" 
						onkeyup="mtdDesincorporacionesConcurrentes.cargarGraficoPublic();"
						onchange="mtdDesincorporacionesConcurrentes.cargarGraficoPublic();"
						placeholder="Ingresar fecha" aria-describedby="sizing-addon2">
					</div>				
				</div>  				
		    </div>
		    <div  class="row">
				<div class="col-md-5"  style="background-color:#fff">
					<div id="divDepartamentoListD" class="form-group ">
						<select  id="departamentoListD" class="select  selectpicker " data-select="1" name="Modelo" data-show-subtext="true" data-live-search="true"  
							onchange="	mtdDesincorporacionesConcurrentes.cargarGraficoPublic();">
							<option data-subtext="" value="0">No hay datos</option>
						</select>
					</div>
				</div>
				<div class="col-md-7"  style="background-color:#fff">
					<div id="opcionesRpt" class="btn-group " data-toggle="buttons" style="width: 100%;">
					  <label class="btn btn-primary active"  style="width: 50%;">
					    <input type="radio" name="options" id="rptGenerico" value="0" autocomplete="off" checked="checked"
					    	 onchange=" mtdDesincorporacionesConcurrentes.opcionesRptPublic() ">
					    Generico
					  </label>
					  <label class="btn btn-primary" onchange="" style="width: 50%;border-radius: 0px 3px 3px 0px;">
					    <input type="radio" name="options" id="rptDetallado" value="1" autocomplete="off" style="background:#f2dede;" 
					    	 onchange=" mtdDesincorporacionesConcurrentes.opcionesRptPublic() ">									    
					    Detallado
					  </label>
					</div>
				</div>											
			</div>
		    <div style=" height:auto; overflow-y: auto;">
		    	<div class="row" id="DivPrevisualizacionTxt" style="display:none;">
		    		<div class="col-md-12" >
						<div class="input-group">
							<span class="input-group-addon" id="sizing-addon2" >Observación de desincorporación:</span>
							<input type="text" class="form-control input-sm" id="previsualizacionTxt" disabled="TRUE"
								placeholder="Presionar un promedio en el grafico">
						</div>				
		    		</div>
		    	</div>
			    <div class="row">
				    <div class="col-md-12"  style="background-color:#fff">
				    	<div id="graficoRendimiento" style="height: 280px;width: 100%;margin-left: 0%;margin-right: 0%;"></div>
				    	<div class="row">
				    		<div class="col-md-12">		

								<div style=" width: 35%; float: left;position: fixed;right: 37%;bottom: 8%;">

								</div>
								<div class="btn-group detallesBtnDiv" role="group" style="width: 20%;display: block;position: fixed;right: 3%;bottom: 10%;">
									


									<button type="button" class="btn btn-default" id="btnGenerarReporte" 
										onclick="mtdDesincorporacionesConcurrentes.generarProcesoFiltrarPublic()" style="width: 100%;">
										Generar reporte
									</button>
								</div>							

				    		</div>
				    	</div>
					</div>
				</div>
			</div>	
		</div>	

	<!-- carga de complementos catalogo/ventana modal relacionados-->
<script type="text/javascript">
/*
	GraficomtdDesincorporacionesConcurrentes = new Morris.Line({
		element: 'graficoRendimiento',
		data: [
			{"FECHA_FINALIZACION": new Date().getTime(),"TARDANZA_PREVENTIVA":"0","TARDANZA_CORRECTIVA":"0"},
		],
		xkey: 'FECHA_FINALIZACION',
		ykeys: ['TARDANZA_PREVENTIVA', 'TARDANZA_CORRECTIVA'],
		labels: ['M. Preventivos', 'M. Correctivos']
	});		
*/
	GraficomtdDesincorporacionesConcurrentes = new Morris.Bar({
	  element: 'graficoRendimiento',
	  data: [
	    {x: '', y: 0},
	  ],
	  xkey: 'fecha',
	  ykeys: ['concurrencia'],
	  labels: ['Concurrencia de desincorporacion'],
	  barColors: function (row, series, type) {
	    if (type === 'bar') {
	      var red = Math.ceil(255 * row.y / this.ymax);
	      return 'rgb(' + red + ',0,0)';
	    }
	    else {
	      return '#000';
	    }
	  },
	  hoverCallback: function (index, options, content, row) {
	  	$('#previsualizacionTxt').val(row.observacion);
	  	if (opcionRptCfg=="generico") {
	  		var fecha_muestra = "<b>CONCURRENCIA:</b> "+row.concurrencia +"<br>"+"<b>FECHA</b>: "+row.fecha_m;	
	  	} else{
	  		var fecha_muestra = "<b>FECHA:</b> "+row.fecha_m;	
	  	};
	  	var return_html_ = "";
		if (row.funcion!=undefined) {
			return_html_ = fecha_muestra+
			   "<hr>"+
  			   "<b>FUNCIÓN:</b> "+row.funcion +
  			   "<hr>"+
  			   "<b>DEPARTAMENTO:</b> "+row.departamento ;
		}else{
			return_html_	=	"<b>SIN RESULTADOS</b>";
		};	  	
  		return return_html_;
	  }
	});
	mtdDesincorporacionesConcurrentes.Iniciar();
	mtdDesincorporacionesConcurrentes.cargarGraficoPublic();
	mtdDesincorporacionesConcurrentes.iniciarPanelTabEquiposPublic();
	nucleo.fechaMaxPublic();
		
</script>