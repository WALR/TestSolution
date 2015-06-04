function checkSoloNum(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode > 31 && (charCode < 46 || charCode > 57)) {
		/*alert("Por favor digiet solo numeros.")*/
		return false;
	} else {
		return true;
	}
}

function validarLetras(e) { // 1
	tecla = (document.all) ? e.keyCode : e.which; 
	// console.log(tecla);
	if (tecla==8) return true; // backspace
	if (tecla==39) return true; // Apostrofe
	if (tecla==38) return true; // singo &
	if (tecla==32) return true; // espacio
	if (tecla==47) return true; // signo /
	if (e.ctrlKey && tecla==86) { return true;} //Ctrl v
	if (e.ctrlKey && tecla==67) { return true;} //Ctrl c
	if (e.ctrlKey && tecla==88) { return true;} //Ctrl x
	if (tecla >= 192 && tecla <= 255) { return true;} //Acento y Ñ
	if (tecla == 0) { return true;} //tabulador
	if (tecla == 44) { return true;} //coma ,
	if (tecla == 45) { return true;} // guion -
	if (tecla == 95) { return true;} // guion _
	if (tecla == 46) { return true;} //punto .	
	patron = /[a-zA-Z]/; //patron
	te = String.fromCharCode(tecla); 
	return patron.test(te); 
}
function redirection(dir){  
  window.location=dir;
}


var tmpModal = tmpModal || (function () {
    var pleaseWaitDiv = $('<div id="ModalEspera" class="modal" data-backdrop="static" data-keyboard="false"><div class="modal-dialog modal-dialog-center"><div class="modal-content"><div class="modal-header" style="padding: 10px;"><h4 style="margin:0;" class="Colet">Cargando...</h4></div><div class="modal-body"><div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div></div></div></div></div>');
    return {
        showModal: function() {
            pleaseWaitDiv.modal();
        },
        hideModal: function () {
            pleaseWaitDiv.modal('hide');
        },

    };
})();	

// $('input').on('keydown', function(e){
//                 // Solo nos importa si la tecla presionada fue ENTER... .webonweboff.com/tips/js/event_key_codes.aspx)
//         if(e.keyCode === 13)
//         {
//                 // Obtenemos el número del tabindex del campo actual
//                 var currentTabIndex = $(this).attr('tabindex');
//                 // Le sumamos 1 :P
//                 var nextTabIndex    = parseInt(currentTabIndex) + 1;
//                 // Obtenemos (si existe) el siguiente elemento usando la variable nextTabIndex
//                 var nextField       = $('[tabindex='+nextTabIndex+']');
//                 // Si se encontró un elemento:
//                 if(nextField.length > 0)
//                 {
//                         // Hacerle focus / seleccionarlo
//                         nextField.focus();
//                         // Ignorar el funcionamiento predeterminado (enviar el formulario)
//                         e.preventDefault();
//                 }
//                 // Si no se encontro ningún elemento, no hacemos nada (se envia el formulario)
//         }
// });


function fechaHoy() {  
    var fecha_actual = new Date()
    var dia = fecha_actual.getDate()
    var mes = fecha_actual.getMonth() + 1
    var anio = fecha_actual.getFullYear()
    if (mes < 10)
    mes = '0' + mes
    if (dia < 10)
    dia = '0' + dia
    return (dia + "-" + mes + "-" + anio)
}
