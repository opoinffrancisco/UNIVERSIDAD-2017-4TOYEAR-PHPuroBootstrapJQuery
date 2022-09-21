<br>

<div  class="row">

	<div class="col-md-12">

		<div class="row">
			<div class="col-md-5">
				<div class="form-group">
					<label for="1">Serial:</label>
				    <input type="text" class="form-control" id="serialtxt"
				    	onkeyup="nucleo.verificarExistenciaPublic('equipo','serial','vtnProcsEquipoConsulta #serialtxt','vtnProcsEquipoConsulta #serialtxt')" 
				    	maxlength="50"
				     >
				</div>											
			</div>				
			<div class="col-md-5">
				<div class="form-group">
					<label for="1">Serial Bien Nacional:</label>
				    <input type="text" class="form-control" id="serialBienNacionaltxt" 
				    	onkeyup="nucleo.verificarExistenciaPublic('equipo','serial_bn','vtnProcsEquipoConsulta #serialBienNacionaltxt','vtnProcsEquipoConsulta #serialBienNacionaltxt')" 
				    	maxlength="50"
				    >
				</div>												
			</div>	
			<div class="col-md-2">
				<div class="form-group editarBtnDiv">
					<label for="1"></label>
					<button type="button" id="btnGuardarSeriales" class="btn btn-default" style="width: 100%;"
					 onclick="mtdEquipo.editarSerialesEQERIFCOMPPPublic('equipo');" 
			  		>Guardar Seriales</button>
				</div>
			</div>																							
		</div>	
		
		<div class="row">
			<div class="col-md-10">

				<div class="row">

					<div class="col-md-12">
						<div class="form-group">
							<label for="1">Tipo</label>
						    <input type="text" class="form-control" id="tipotxt" disabled="TRUE">
						</div>																						
					</div>																					
				</div>
			
				<div class="row">
					<div class="col-md-6">											
						<div class="form-group">
						    <label for="1">Marca</label>
						    <input type="text" class="form-control" id="marcatxt" disabled="TRUE">
						</div>											
					</div>				
					<div class="col-md-6">
						<div class="form-group">
							<label for="1">Modelo</label>
						    <input type="text" class="form-control" id="modelotxt" disabled="TRUE">
						</div>																						
					</div>																					
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label id="lbMensajeDesincorpora" style="color: red; display: none;">Desincorporado :</label>
						    <textarea class="form-control" id="mensajeTxtDesincorporacion" style="display:none;resize: none;" disabled="TRUE"></textarea>
						</div>											
					</div>						
				</div>
			</div>				
			<div class="col-md-2">

				<div class="form-group">
					<label for="1">Interfaces</label>
					<div id="listGestionCaractInterfacesEqu" class="list-group" style="FONT-SIZE: smaller;">
						
					</div>							
				</div>
			</div>	
		</div>
	</div>
	
</div>
<hr>
<div  id="SerialesPERIFCOMP" style="display: none;">
	<div class="row" style="   background: #337ab7;    color: white;">
		<div class="col-md-11 col-md-offset-1">
			<h2>
				<b> Editar : Seriales del </b><b id="textoEjecutaActual"></b>
			</h2>
		</div>
	</div>
	<br>
	<div class="row">	
		<input type="text" id="datoControlIdPC" style="display: none;">
		<div class="col-md-5">
			<div class="form-group">
				<label for="1">Serial:</label>
			    <input type="text" class="form-control input-ms" id="serialtxt" maxlength="50">
			</div>											
		</div>				
		<div class="col-md-5">
			<div class="form-group">
				<label for="1">Serial Bien Nacional:</label>
			    <input type="text" class="form-control input-ms" id="serialBienNacionaltxt" maxlength="50">
			</div>												
		</div>	
		<div class="col-md-2">
			<div class="form-group">
				<label for="1"></label>
				<button type="button" id="btnGuardarSerialesPERIFCOMP" class="btn btn-default" style="width: 100%;"
				 onclick="mtdEquipo.editarSerialesEQERIFCOMPPPublic('');" 
		  		>Guardar</button>
			</div>
		</div>	
	</div>
	<hr>
</div>	
<div class="row">
	<div class="col-md-4">
		<div class="row" style="margin-bottom: 10px;">
			<div class="col-md-12" style="text-align: center;">
				<b>Periféricos:</b>
			</div>
		</div>								
	</div>
	<div class="col-md-4">
		<div class="row" style="margin-bottom: 10px;">
			<div class="col-md-12" style="text-align: center;">
				<b>Componentes:</b>
			</div>
		</div>	
	</div>
	<div class="col-md-4">
		<div class="row" style="margin-bottom: 10px; ">
			<div class="col-md-12" style="text-align: center;">
				<b>Software:</b>
			</div>
		</div>	
	</div>
</div>
<div class="row">
	<div class="col-md-4 ">
		<button type="button" id="btnAnadirPeriferico" class="btn btn-default nuevoBtnDiv" 
		style=" margin-bottom:20px; width:100%;"
		onclick="panelTabs.cambiarFormularioPublico(
					configuracion.urlsPublic().equipo.tabsDetallar.perifericos, 'form',
					datosIdsTabs=[ 'tabDetalles' ]
		  		)"
		>Añadir</button>
		<div id="pgnListPerifericos" >
			<div id="pagination">
				
			</div>
		</div>	
		<div id="listGestionPerifericos" class="list-group" style="FONT-SIZE: smaller;">

		</div>							
		<div id="pgnListPerifericos">
			<div id="pagination">
				
			</div>
		</div>	
	</div>
	<div class="col-md-4 ">
		<button type="button" id="btnAnadirComponente" class="btn btn-default nuevoBtnDiv" 
		style=" margin-bottom:20px; width:100%;"
		onclick="panelTabs.cambiarFormularioPublico(
					configuracion.urlsPublic().equipo.tabsDetallar.componentes, 'form',
					datosIdsTabs=[ 'tabDetalles' ]
		  		)"
		>Añadir</button>
		<div id="pgnListComponentes" >
			<div id="pagination">
				
			</div>
		</div>	
		<div id="listGestionComponentes" class="list-group" style="FONT-SIZE: smaller;">

		</div>							
		<div id="pgnListComponentes">
			<div id="pagination">
				
			</div>
		</div>							
	</div>
	<div class="col-md-4 ">
		<button type="button" id="btnAnadirSoftware" class="btn btn-default nuevoBtnDiv" 
		style=" margin-bottom:20px; width:100%;"
		onclick="panelTabs.cambiarFormularioPublico(
					configuracion.urlsPublic().equipo.tabsDetallar.software, 'form',
					datosIdsTabs=[ 'tabDetalles' ]
		  		)"
		>Añadir</button>
		<div id="pgnListSoftware" >
			<div id="pagination">
				
			</div>
		</div>	
		<div id="listGestionSoftware" class="list-group" style="FONT-SIZE: smaller;">

		</div>							
		<div id="pgnListSoftware">
			<div id="pagination">
				
			</div>
		</div>							
	</div>
</div>
<script type="text/javascript">
	
	mtdEquipo.consultar(0);
	mtdEquipo.cargarListaPerifericosEquipoPublic(1);	
	mtdEquipo.cargarListaComponentesEquipoPublic(1);
	mtdEquipo.cargarListaSoftwareEquipoPublic(1);
	nucleo.asignarPermisosBotonesPublic(6);
</script>