
		<!-- Cuerpo de catalogo -->
		<div id="ctlgRendimiento" class="panel-body" style="height: 74%;"> 
		    <div class="row">
				<div class="col-md-4"  >
					<div id="divMarcaListD" class="form-group">
						<select  id="marcaListD" class="select  selectpicker  " data-select="1" name="Marca" data-show-subtext="true" data-live-search="true"
							onchange="	mtdAreasConcurrentesTareasCorrectivas.cargarGraficoPublic();">
							<option data-subtext="" value="0">No hay datos</option>								   		
						</select>
					</div>
				</div>
				<div class="col-md-3"  >
					<div class="input-group">
						<span class="input-group-addon" id="sizing-addon2" >Desde:</span>
						<input type="date" maxlength="30" min="6" class="form-control input-sm" id="buscardorDesde"
						onkeyup="mtdAreasConcurrentesTareasCorrectivas.cargarGraficoPublic();"
						onchange="mtdAreasConcurrentesTareasCorrectivas.cargarGraficoPublic();"
						placeholder="Ingresar fecha" aria-describedby="sizing-addon2">
					</div>				
				</div>    
				<div class="col-md-3 "  style="margin-left: 8%;" >
					<div class="input-group">
					  	<span class="input-group-addon" id="sizing-addon2" >Hasta:</span>
						<input type="date" maxlength="30" min="6" class="form-control input-sm" id="buscardorHasta" 
						onkeyup="mtdAreasConcurrentesTareasCorrectivas.cargarGraficoPublic();"
						onchange="mtdAreasConcurrentesTareasCorrectivas.cargarGraficoPublic();"
						placeholder="Ingresar fecha" aria-describedby="sizing-addon2">
					</div>				
				</div>  				
		    </div>
		    <div  class="row">
				<div class="col-md-4"  style="background-color:#fff">
					<div id="divModeloListD" class="form-group ">
						<select  id="modeloListD" class="select  selectpicker " data-select="1" name="Modelo" data-show-subtext="true" data-live-search="true"  
							onchange="	mtdAreasConcurrentesTareasCorrectivas.cargarGraficoPublic();">
							<option data-subtext="" value="0">No hay datos</option>
						</select>
					</div>
				</div>
				<div class="col-md-7"  style="background-color:#fff">
					<div id="divTipoListD" class="form-group">
						<select  id="tipoListD" class="select  selectpicker " data-select="1" name="Modelo" data-show-subtext="true" data-live-search="true"  
							onchange="	mtdAreasConcurrentesTareasCorrectivas.cargarGraficoPublic();">
							<option data-subtext="" value="0">No hay datos</option>
						</select>
					</div>
				</div>											
			</div>
		    <div style=" height:auto; overflow-y: auto;">
		    	<div class="row" id="DivPrevisualizacionTxt" style="display:none;">
		    		<div class="col-md-12" >
						<div class="input-group">
							<span class="input-group-addon" id="sizing-addon2" >Tarea concurrente:</span>
							<input type="text" class="form-control input-sm" id="previsualizacionTxt" disabled="TRUE"
								placeholder="Presionar un promedio en el grafico">
						</div>				
		    		</div>
		    	</div>
			    <div class="row">
				    <div class="col-md-12"  style="background-color:#fff">
				    	<div id="graficoRendimiento" style="height: 350px;width: 50%;margin-left: 25%;margin-right: 25%;"></div>
				    	<div class="row">
				    		<div class="col-md-12">		
								    
				    			<div style=" width: 35%; float: left;position: fixed;right: 37%;bottom: 8%;">
								    <b>Areas concurrentes de tareas correctivas realizadas</b>
								    <br>
								    <b>Formato:</b>  Concurrencia / Concurrencia total | Estimación % 
								</div>
								<div class="btn-group detallesBtnDiv" role="group" style="width: 20%;display: block;position: fixed;right: 3%;bottom: 10%;">
									<div id="opcionesRpt" class="btn-group " data-toggle="buttons" style="width: 100%;">
									  <label class="btn btn-primary active"  style="width: 50%;">
									    <input type="radio" name="options" id="rptGenerico" value="0" autocomplete="off" checked="checked"
									    	 onchange=" mtdAreasConcurrentesTareasCorrectivas.opcionesRptPublic() ">
									    Generico
									  </label>
									  <label class="btn btn-primary" onchange="" style="width: 50%;border-radius: 0px 3px 3px 0px;">
									    <input type="radio" name="options" id="rptDetallado" value="1" autocomplete="off" style="background:#f2dede;" 
									    	 onchange=" mtdAreasConcurrentesTareasCorrectivas.opcionesRptPublic() ">									    
									    Detallado
									  </label>
									</div>


									<button type="button" class="btn btn-default" id="btnGenerarReporte" 
										onclick="mtdAreasConcurrentesTareasCorrectivas.generarProcesoFiltrarPublic()" style="width: 100%;">
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
	GraficomtdAreasConcurrentesTareasCorrectivas = new Morris.Line({
		element: 'graficoRendimiento',
		data: [
			{"FECHA_FINALIZACION": new Date().getTime(),"TARDANZA_PREVENTIVA":"0","TARDANZA_CORRECTIVA":"0"},
		],
		xkey: 'FECHA_FINALIZACION',
		ykeys: ['TARDANZA_PREVENTIVA', 'TARDANZA_CORRECTIVA'],
		labels: ['M. Preventivos', 'M. Correctivos']
	});		
*/
	GraficoMtdAreasConcurrentesTareasCorrectivas = new Morris.Donut({
	  element: 'graficoRendimiento',
	  data: [
	    {value: 100, label: '100%', formatted: 'SIGMANSTEC' },
	  ],
	  formatter: function (x, data) { return data.formatted; },
	  backgroundColor: '#fff',
	  //labelColor: '#ccc',
	  colors: [
	    '#B40404',
	    'red',
	    '#FA5858',
	    '#F78181',
	    '#F6CECE',
	    '#F8E0E0',
	    '#FBEFEF'
	    ],
	}).on('click', function(i, row){
		$('#previsualizacionTxt').val(row.preview);
	});;
	mtdAreasConcurrentesTareasCorrectivas.Iniciar();
	mtdAreasConcurrentesTareasCorrectivas.cargarGraficoPublic();
	mtdAreasConcurrentesTareasCorrectivas.iniciarPanelTabEquiposPublic();
	nucleo.fechaMaxPublic();	

</script>