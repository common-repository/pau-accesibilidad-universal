
jQuery( document ).ready( function( $ ) {

	'use strict';

	var $body = $( "body" );
	$body.prepend( pau.pauMainAcces );

	/**
	 * Todo el código Javascript orientado a la administración
	 * debe estar escrito aquí
	 */

	 //Declaramos objetos a utilizar
 	var $PauActivarSubmenuObj		= $('#PauActivarSubmenu'), 	//Estado de panle de control mediante class
		$PauAppObj					= $('#PauApp'), 	//PAU APP
 		$PauCompletoObj 			= $('#PauCompleto'),		//Panel Completo PAU + Panel
 		$logoPauAppDivObj 			= $('#logoPauAppDiv'), //Espacio de PAU solo y sin Panel
 		$BarraPauAppObj 			= $('#BarraPauApp') //Barra sup de PAU en grande



	//hacemos arrastrable la capa padre de PAU, mas info https://css-tricks.com/using-css-cursors/
	$( ".dragable" ).draggable();
	//Cambiamos el cursor de la capa padre de PAU a arrastrable

	$('.dragable').on("mouseenter", function(e){

		e.preventDefault();
		$( this ).css({'cursor': 'move'});


		}
	);
	$('.dragable').on("click", function(e){
			e.preventDefault();
			var offset = $PauCompletoObj.offset();
			console.log( "Arrastramos desde left: " + offset.left + ", top: " + offset.top );
		});

});
