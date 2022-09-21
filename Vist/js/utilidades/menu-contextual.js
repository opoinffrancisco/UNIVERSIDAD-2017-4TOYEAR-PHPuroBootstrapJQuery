var menuContextual = function () {

	var item_click = "";

	var mostrarMenu = function (event, id, menu_id) {

		item_click=event.path[0];
		/************************************/
		var posX, posY, span; // Declaracion de variables

		posX = event.pageX; // Obtenemos pocision X del cursor
		posY = event.pageY; // Obtenemos pocision Y del cursor

		// Hacemos aparecer el menu contextual
		$('#' + menu_id).fadeIn('fast');

		// Flecha que indica submenues
		span = $('#' + menu_id + " span");
		span.html("»");

		// Editando el codigo CSS para ciertos elementos
		span.css(
		{
		  float: 'right',
		  marginRight: '12px'
		}
		);

		$('#' + menu_id).css(
		  {
		    position: 'absolute',
		    display: 'block',
		    top: posY,
		    left: posX,
		    cursor: 'default',
		    width: '200px',
		    height: 'auto',
		    padding: '2px 2px 2px 2px',
		    listStyle: 'none',
		    listStyleType: 'none'		    

		  }
		);

		$('#' + menu_id + " li").css(
		  {
		    width:'100%',
		    height:'auto',
		    margin:'0 auto',
		    padding:'3px 0px 3px 7px',
		    wordWrap:'break-word'
		  }
		);

		$('#' + menu_id + " li ul").css(
		  {
		    listStyle:'none',
		    listStyleType:'none',
		    cursor:'default',
		    position:'absolute',
		    left:'188px',
		    marginTop:'-20px',
		    width:'200px',
		    height:'auto',
		    padding:'2px 2px 2px 2px'
		  }
		);
	}

	var ocultarMenu = function (menu_id) {

		$('#'+menu_id).fadeOut('fast');
	}


    var GetSelectedText = function () {
        if (window.getSelection) {	// all browsers, except IE before version 9
            var range = window.getSelection();                                        
            return range.toString();
        } 
		else {
			if (document.selection.createRange) { // Internet Explorer
				var range = document.selection.createRange();
				return range.text;
			}
		}
    }
	var copiarMC = function () {
		$('#portapapelesMC').val('');
		$('#portapapelesMC').val(menuContextual.GetSelectedTextPublic());
		console.log('conpiando texto : '+$('#portapapelesMC').val());	
	}
	var pegarMC = function () {
		$('#'+item_click.id).val($('#portapapelesMC').val());
		console.log('pegando texto');		
	}

	return{
		Iniciar:function() {


			console.log(" -- Finalizando carga de menu contextual");
		},
		mostrarMenuPulic : mostrarMenu,
		ocultarMenuPulic : ocultarMenu,
		GetSelectedTextPublic : GetSelectedText,
		copiarMCPublic : copiarMC,
		pegarMCPublic : pegarMC,

	}
}();