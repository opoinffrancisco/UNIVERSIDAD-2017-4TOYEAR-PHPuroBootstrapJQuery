<style type="text/css">


 

	.desvanecido {
		display: none;
	}

</style>
<div class="panel panel-default">
	<div class="panel-body" style="height: 100%;">
		<div class="row ">
			<div class="col-md-6 col-md-offset-4">
				<h1 class="desvanecido" id="fila-1"><b>Bienvenido</b></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h2 class="desvanecido" id="fila-2">¿ Necesitas ayuda con tu equipo ?</h2>
			</div>
		</div>
		<div class="row ">
			<div class="col-md-6 col-md-offset-6">
				<h2 class="desvanecido" id="fila-3">Podemos ayudarte</h2>
			</div>
		</div>
		<div class="row ">
			<div class="col-md-6 col-md-offset-2">
				<h2 class="desvanecido" id="fila-4">Solo solicita lo que necesitas.</h2>
			</div>
		</div>
		<br><br><br>
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<img class=" desvanecido" id="fila-5" src="Vist/img/logo.png" style="width: 150px;height: 150px;">
			</div>
		</div>


	</div>
</div>


<script type="text/javascript">
	$("#logo-menu").fadeOut(10);
	var time ="";

	time = setTimeout(function() {
	        $("#fila-1").fadeIn(1500);
	        clearTimeout(time);
	},100);

	time = setTimeout(function() {
	        $("#fila-2").fadeIn(1500);
	        clearTimeout(time);
	},1000);
	time = setTimeout(function() {
	        $("#fila-3").fadeIn(1500);
	        clearTimeout(time);
	},2500);
	time = setTimeout(function() {
	        $("#fila-4").fadeIn(1500);
	        clearTimeout(time);
	},4000);

	time = setTimeout(function() {
	        $("#fila-5").fadeIn(1500);
	        clearTimeout(time);
	},5000);

	time = setTimeout(function() {
			$("#fila-5").fadeOut(1000);
	        $("#logo-menu").fadeIn(1500);
	        clearTimeout(time);
	},6000);

	time = setTimeout(function() {
			$("#fila-1").fadeOut(500);
			$("#fila-2").fadeOut(500);
			$("#fila-3").fadeOut(500);
	        $("#fila-4").fadeOut(500);
	        
	        clearTimeout(time);
	},5000);
	clearTimeout(time);

</script>
