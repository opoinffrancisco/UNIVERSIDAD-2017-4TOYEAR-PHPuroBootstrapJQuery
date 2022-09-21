
		<!-- Cuerpo de catalogo -->
		<div id="ctlgRendimiento" class="panel-body" style="height: 74%;"> 
		    <div class="row">
				<div class="col-md-4"  >
					<div class="">
					  <input type="text" maxlength="30" min="6" class="form-control input-sm" id="buscardorTxt"
					   onkeyup="mtdRendimiento.cargarGraficoPublic();" 
					   placeholder="Ingresar la cedúla del técnico " aria-describedby="sizing-addon2">
					</div>
				</div>
				<div class="col-md-3"  >
					<div class="input-group">
						<span class="input-group-addon" id="sizing-addon2" >Desde:</span>
						<input type="date" class="form-control input-sm" id="buscardorDesde"
						onkeyup="mtdRendimiento.cargarGraficoPublic();"
						onchange="mtdRendimiento.cargarGraficoPublic();"
						placeholder="Ingresar fecha" aria-describedby="sizing-addon2"
						>
					</div>				
				</div>    
				<div class="col-md-3 "  style="margin-left: 8%;" >
					<div class="input-group">
					  	<span class="input-group-addon" id="sizing-addon2" >Hasta:</span>
						<input type="date" maxlength="30" min="6" class="form-control input-sm" id="buscardorHasta" 
						onkeyup="mtdRendimiento.cargarGraficoPublic();"
						onchange="mtdRendimiento.cargarGraficoPublic();"
						placeholder="Ingresar fecha" aria-describedby="sizing-addon2">
					</div>				
				</div>  				
		    </div>
		    <br>
		    <div style=" height:auto; overflow-y: auto;">
			    <div class="row">
				    <div class="col-md-12"  style="background-color:#fff">
			
					    <b>Rendimiento de los técnicos al realizar los mantenimientos preventivos y correctivos</b>
					    <br>
   					    <b>El tiempo extra ocupado : 0 Horas a mas </b>
				    	<div id="graficoRendimiento" style="height: 250px;"></div>
						<div class="btn-group detallesBtnDiv" role="group" style="width: 100%; display: block;">
							<button type="button" class="btn btn-default" id="btnDetalles" onclick="mtdRendimiento.generarProcesoFiltrarPublic()" style="width: 100%;">
								Generar reporte
							</button>
						</div>
						<img id="captured" src="" >
					</div>
				</div>
			</div>	
		</div>	

	<!-- carga de complementos catalogo/ventana modal relacionados-->
<script type="text/javascript">

	graficoMtdRendimiento = new Morris.Line({
		element: 'graficoRendimiento',
		data: [
			{"FECHA_FINALIZACION": new Date().getTime(),"TARDANZA_PREVENTIVA":"0","TARDANZA_CORRECTIVA":"0"},
		],
		xkey: 'FECHA_FINALIZACION',
		ykeys: ['TARDANZA_PREVENTIVA', 'TARDANZA_CORRECTIVA'],
		labels: ['M. Preventivos', 'M. Correctivos']
	});		

	mtdRendimiento.cargarGraficoPublic();
	nucleo.fechaMaxPublic();
</script>