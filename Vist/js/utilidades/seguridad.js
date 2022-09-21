var seguridad = function () {

		var sensorKey = function (e) {

			tecla=(document.all) ? e.keyCode : e.which;
			//-> Evitar abrir Consola del navegador
			if(tecla==123 || e.key=="F12" || e.code=="F12"){
				e.preventDefault();
				return false;
			}
			if( e.ctrlKey==true && e.shiftKey==true && (tecla==74 || e.key=="J" ) ){
				e.preventDefault();
				return false;
			}
			if( e.ctrlKey==true && (tecla==83 || e.key=="S" ) ){
				e.preventDefault();
				return false;
			}			 
			if( e.ctrlKey==true &&  e.key=="I" ){
				e.preventDefault();
				return false;
			}						
		}

	return{
		Iniciar : function () {

		},
		sensorKeyPublic : sensorKey,
	}
}();