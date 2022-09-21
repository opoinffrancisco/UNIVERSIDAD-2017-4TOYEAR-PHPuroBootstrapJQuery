<div style="width: 100%; height: 100%; background-color: rgb(35, 95, 146); position: absolute;">
	<div id="logo">
		
	    <img src="Vist/img/logo-600x480.png" style="width: 12%;float: left;margin-left: 10%;margin-top: 15%;position: absolute;">
	    <div   ><b style="
						    font-size: 300%;
						    font-stretch: semi-expanded;
						    position: absolute;
						    margin-top: 20%;
						    margin-left: 22%;
						    color: #ffffff;
						">SIGMANSTEC</b></div>
	</div>
	<div id="panelAcceso">
		<div class="panel-body">
			<form id="form-login">
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
				    	<label for="recurso" id="usuarioTxtBienv">Bienvenido:</label>						
				    </div>
				    </br>
					<div class="col-md-7 col-md-offset-1" style="display:none;">	  
				  	  	<div id="divUsuarioTxt" class="form-group no-v-minmax">
					    	<input type="text" name="nombre" class="campo-clave  form-control input-sm" id="usuarioTxt">
					  	</div>				  	
					</div>
				</div>		
				<div class="row">
					<div class="col-md-2 col-md-offset-1">
					      <label for="recurso">Contraseña:</label>							  
				    </div>
					<div class="col-md-7 col-md-offset-1">	
				  	  	<div id="divContrasenaTxt" class="form-group no-v-minmax">
					    	<input type="password" name="contrasena" class=" form-control input-sm" id="contrasenaTxt" placeholder="Ingresar contraseña" 
					  			onkeyup="nucleo.verificarDatosPublic('','','contrasenaTxt','')"
					    		data-cantmax="15" maxlength="15" data-cantmin="4" data-vexistencia="0" 
					    		data-solonumero="0" data-sololetra="0" data-sololetrayespacio="0" data-vcorreo="0"
					    		autocomplete="off" required="TRUE">
					  	</div>				  	
				  	</div>
				</div>		
				<div class="row">
					<div class="col-md-2 col-md-offset-1">
					      <label for="recurso">Captcha:</label>							  
				    </div>
					<div class="col-md-7 col-md-offset-1">	
				  	  	<div id="divCaptchaTxt" class="form-group no-v-minmax">
					    	<input type="text" name="captcha" 
					    	class=" form-control input-sm" id="captchaTxt" placeholder="Ingresar captcha" 
					    	maxlength="8" required="TRUE"
					    		onkeyup="nucleo.convetirMinMayusPublic(this,'min');" 
					    	>
					  	</div>				  	
				  </div>
				</div>						
				<div class="row">
					<div class="col-md-4 col-md-offset-1" style="padding-right:0px;">
						<input type="button" class="btnRefresh" 
						onClick="nucleo.refreshCaptchaPublic();" value="Actualizar"
						style="width: 100%;height: 30px;"/>
				    </div>
					<div class="col-md-7 col-md-offset-0"  
						style="padding-left:0px;padding-right:40px;">
						<img id="captcha_code" 
							src="" 
							style="width: 97%;height: 30px;"/>
				    </div>		
				</div>				
			</form>
			<hr style="margin-bottom: 2.5%;">
			<div class="row">
				<div class="col-md-10 col-md-offset-1" >
			  		<button type="submit" id="btnIniciarSesion" class="btn btn-default"  style="width: 100%;"  onclick="nucleo.continuarSesionPublic('divContrasenaTxt')" >Continuar sesión</button>
			  	</div>
				<div class="col-md-10 col-md-offset-1" >
			  		<button type="submit" id="btnIniciarSesionOtraCuenta" class="btn btn-default" style="width: 100%;"  onclick="nucleo.iniciarSesionOtraCuentaPublic()" >Finalizar sesión</button>
			  	</div>			  	
		  	</div>
		</div>	  			
	</div>
</div>
<script type="text/javascript">
	nucleo.activarEnvioContSesionPublic();
	nucleo.refreshCaptchaPublic();	
	nucleo.stopSuspensionPublic();
</script>