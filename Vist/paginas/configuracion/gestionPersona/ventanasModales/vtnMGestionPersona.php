<div id="contenedorOverflow" style="height:600px;">	

		<!-- Panel de Ventana modal-->
		<div id="vtnPersona" class="panel panel-primary ventana-modal-panel-grande ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestione la persona
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal'),mtdPersona.restablecerFormPublic()">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body" style="overflow:none;"  > 
				<form id="form" method="POST" enctype="multipart/form-data">
					<input type="text" id="datoControl" value="" style="display:none;"></input>
					<input type="text" id="datoControlId" value="" style="display:none;"></input>

					<div class="row">
						<div id ="contentFoto" class="col-md-3">
							<div id="cfgFotoPerfil" class="cfgFotoPerfil" 
								style="	width: 100%; float:left; border: ridge;">
								<img id="preViewImg" src="" style="width: 100%;height: 150px;  display:none;" >
								<img id="sinImg" src="Vist/img/cfg_persona_sin-foto.png" style="width: 100%;height: 150px;  display:block;">
							</div>
							<div style="width: 100%;float:left;margin-top: 2%;">
						  		<input type="file" id="fotografia" accept="image/jpeg, image/png"  class="btn btn-default" style="width: 100%;float: left;color: transparent;" >
						  		<button type="button" id="btnFotografiar" class="btn btn-default" style="width: 100%;float: left; display:none;">Fotografiar</button>
							</div>
						</div>

						<div class="col-md-9 " style=" padding: initial;">
							<div class="row">
							    <div class="col-md-5 ">
   							      <label for="recurso">Cedula:</label>							  
							  	  	<div id="divCedulaTxt" class="form-group">
								    	<input type="text" name="nombre" class="campo-clave campo-control form-control input-sm" id="cedulaTxt" placeholder="Ingresar cedula" 
								  			onkeypress="nucleo.verificarDatosInputPublic(event,this,'divCedulaTxt')"								    		
							  				onkeyup="nucleo.verificarDatosPublic('cfg_persona','cedula','cedulaTxt','divCedulaTxt')"
								    		data-cantmax="8" maxlength="8" data-cantmin="6" data-vexistencia="1" 
								    		data-solonumero="1">
								  	</div>				  	
							    </div>
							</div>
							<div class="row">
								<div class="col-md-5 ">
	   							      <label for="recurso">Nombre:</label>							  
								  	  	<div id="divNombreTxt" class="form-group">
									    	<input type="text" name="nombre" class="campo-control form-control input-sm" id="nombreTxt" placeholder="Ingresar nombre" 
									  			onkeypress="nucleo.verificarDatosInputPublic(event,this,'divNombreTxt')"								    		
									    		data-cantmax="30" maxlength="30" data-cantmin="2" data-vexistencia="0" 
									    		data-sololetrayespacio="1">
									  	</div>				  	
								</div>
								<div class="col-md-5 col-md-offset-1">
	   							      <label for="recurso">Apellido:</label>							  
								  	  	<div id="divApellidoTxt" class="form-group">
									    	<input type="text" name="apellido" class="campo-control form-control input-sm" id="apellidoTxt" placeholder="Ingresar apellido" 
									  			onkeypress="nucleo.verificarDatosInputPublic(event,this,'divApellidoTxt')"								    		
									    		data-cantmax="30" maxlength="30" data-cantmin="2" 
									    		data-sololetrayespacio="1" >
									  	</div>				  	
								</div>
							</div>
							<div class="row">
								<div class="col-md-11 col-md-offset-0">
	   							      <label for="recurso">Correo electronico:</label>							  
								  	  	<div id="divCorreoTxt" class="form-group">
									    	<input type="text" name="correo electronico" class="campo-control form-control input-sm" id="correoTxt" placeholder="Ingresar Correo electronico" 
									  			onkeypress="nucleo.verificarDatosInputPublic(event,this,'divCorreoTxt')"								    		
									  			onkeyup="nucleo.verificarDatosPublic('cfg_persona','correo_electronico','correoTxt','divCorreoTxt')"
									    		data-cantmax="50" maxlength="50" data-cantmin="6" data-vexistencia="1" 
									    		data-vcorreo="1" >
									  	</div>				  	
								</div>										
							</div>

							<hr>		
							<div class="row">
							    <div class="col-md-5 ">
   							      <label for="recurso">Usuario:</label>							  
							  	  	<div id="divUsuarioTxt" class="form-group">
								    	<input type="text" name="usuario" class="campo-control form-control input-sm" id="usuarioTxt" placeholder="Ingresar usuario" 
									  		onkeypress="nucleo.verificarDatosInputPublic(event,this,'divUsuarioTxt')"								    		
								  			onkeyup="nucleo.verificarDatosPublic('cfg_pn_usuario','usuario','usuarioTxt','divUsuarioTxt')"
								    		data-cantmax="20" maxlength="20" data-cantmin="2" data-vexistencia="1" 
								    		data-sololetra="1">
								  	</div>				  					  	
							  	  	<div id="divPerfilTxt" class="form-group">
								    	<label for="perfil">Perfil:</label>
										<select class="listd-control form-control" id="perfilListD" data-tabla="cfg_pn_perfil">
											<option value="" selected="true">Seleccione un Perfil</option>
										</select>
								  	</div>		
							  	</div>
							    <div class="col-md-5 col-md-offset-1">
									<label for="recurso">Contraseña:</label>							  
									<div id="divContrasenaTxt" class="form-group">
										<input type="text" name="nombre" class="campo-control form-control input-sm" id="contrasenaTxt" placeholder="Ingresar contraseña" 
											data-cantmax="15" maxlength="15" data-cantmin="4" >
									</div>
							  	</div>
							</div>

							<hr>

						</div>
					</div>

			  		<button type="button" id="btnGuardarFloatR" class="btn btn-default" 
						style="position: fixed; z-index: 99; float: right; right: 2%; bottom: 5%;"
			  		>Guardar</button>
				</form>
				<?php 

					include '../../../../secciones/dialogo/procesandoDatos.php';

				?>
			</div>				
		</div>
</div>


<!-- carga de complementos catalogo/ventana modal relacionados // Estos complementos deben de ser los ultimos en cargar-->
<script type="text/javascript">
		mtdPersona.Iniciar();
</script>
