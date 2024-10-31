jQuery( document ).ready( function ( $ ) {

	'use strict';

	// console.log("\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n");

	var $body = $( 'body' );

	$body
		.prepend( asignacion.html )
		.prepend( asignacion.selectorAsignacion );

	var $pauSelectorView      = $( "#pau-selector-view h4#pauRute" ),
		$pauMsgConflicts      = $( "#pau-selector-view h4#pauMsgConflicts" ),
		$pauSaveAssig         = $( "#pauSaveAssig" ),
		$pauSaveWithConflicts = $( "#pauSaveAssigWithConflicts" ),
		$pauAssigModal        = $( "#pauAssigModal" ),
		$pauAssigModalClose   = $( "#pauAssigModal #pauClose" ),
		$pauAssigModalEdit    = $( "#pauAssigModal #pauEditPage" ),
		$pauAssigModalMsg     = $( "#pauAssigModal p#pauMsg" ),
		$pauAssigConflicts    = $( "#pauAssigConflicts" ),
		$pauDataPath          = $( "#pauDataPath" ),
		pau_page              = "",
		id_page               = "",
		pau_page_search       = "";

	if ( asignacion.pau_page != 0 ) {
		pau_page = "&pau_page=" + asignacion.pau_page;
	}

	if ( asignacion.id_page != 0 ) {
		pau_page = "&id_page=" + asignacion.id_page;
	}

	if ( asignacion.pau_page_search != 0 ) {
		pau_page_search = "&pau_search=" + asignacion.pau_page_search;
	}

	var url   = asignacion.siteUrl + "/wp-admin/admin.php?page=pau-hot-spots&id_hotspots=" + asignacion.id_hotspots + id_page + pau_page + asignacion.pau_lang + "&rute_object=",
		xPath = "",
		$selectorAssig;

	$.fn.tagName = function () {
		return this.prop( "tagName" ).toLowerCase();
	};

	$pauAssigModalClose.on( "click", function () {
		$( this ).parents( "#pauAssigModal" ).hide();
	} );

	$pauAssigConflicts.on( "click", function () {
		$pauAssigModal.show();
	} );

	class PauAssignment {

		constructor() {
			this.error = this.msgInitError();
			this.d = document;
		}

		getXPath( element ) {

			xPath = "";

			for ( ; element && element.nodeType == 1; element = element.parentNode ) {

				var id      = element.getAttribute( "id" ),
					tagName = element.tagName.toLowerCase().trim();

				if ( tagName == "html" || tagName == "body" ) return;

				// if( tagName == "div" ) tagName = "";

				if ( id !== null ) {
					xPath = tagName + "#" + id + xPath;
					xPath = xPath.replace( /  /g, " " );
					break;
				} else {
					xPath = " > " + tagName + xPath;
				}

			}

			return xPath;

		}

		validateXPath() {

			let select  = this.d.querySelectorAll( xPath ),
				count   = select.length || null,
				msgConf = asignacion.translate.conflictroute,
				verify  = "",
				error;

			if ( count > 0 && select[ 0 ].tagName === 'IMG' ) {

				// Ocultando botones para solución de conflictos
				$pauMsgConflicts.css( "display", "none" );
				$pauAssigConflicts.css( "display", "none" );
				$pauSaveWithConflicts.css( "display", "none" );

				// Mostrando el botón para el guardado sin conflictos
				$pauSaveAssig.css( "display", "inline-block" );

			} else if ( !xPath.match( /#/ ) ) { // Validando que exista un identificador

				error = this.error[ "c1" ];

				$pauMsgConflicts
					.css( "display", "block" )
					.html( msgConf );

				// Agregando mensaje al modal
				var msgModal = asignacion.translate.objectnounique;

				$pauAssigConflicts.css( "display", "inline-block" );
				$pauSaveWithConflicts.css( "display", "inline-block" );

				// Ocultando el botón para el guardado sin conflictos
				$pauSaveAssig.css( "display", "none" );

			} else if ( count > 1 ) {

				error = this.error[ "c2" ];
				$pauMsgConflicts
					.css( "display", "block" )
					.html( msgConf );

				let output_text = "",
					c           = 0,
					line        = '-'.repeat( 10 );

				select.forEach( function ( el ) {
					c++;
					output_text += '<strong>' + asignacion.translate.conflict + ' #' + c + ': </strong>' + xPath +
						': ' + el.innerText + '<br>';
				} );

				// Agregando mensaje al modal
				var msgModal = asignacion.translate.repeatobject1 + ' <strong>' + count + '</strong> ' + asignacion.translate.repeatobject2 + '<br><strong>' + asignacion.translate.conflict + '</strong><br>' + line + '<br>' +
					output_text + line +
					'<br>' + asignacion.translate.repeatobject3 + '<br>' + asignacion.translate.solution1 + '<br>' + asignacion.translate.solution2;

				$pauAssigModalMsg.html( msgModal );

				// Mostrando botones para solución de conflictos
				$pauAssigConflicts.css( "display", "inline-block" );
				$pauSaveWithConflicts.css( "display", "inline-block" );

				// Ocultando el botón para el guardado sin conflictos
				$pauSaveAssig.css( "display", "none" );

			} else {

				// Ocultando botones para solución de conflictos
				$pauMsgConflicts.css( "display", "none" );
				$pauAssigConflicts.css( "display", "none" );
				$pauSaveWithConflicts.css( "display", "none" );

				// Mostrando el botón para el guardado sin conflictos
				$pauSaveAssig.css( "display", "inline-block" );

			}

			// console.log( count );

		}

		msgInitError() {

			return {
				c1 : {
					btnText : asignacion.translate.saveassignment,
					msgHelp : asignacion.translate.saveassignmenthelp,
				},
				c2 : {
					btnText : asignacion.translate.saveassignmenttext,
					msgHelp : asignacion.translate.saveassignmenttexthelp,
				}
			};

		}

	}

	var pauAssig = new PauAssignment();

	$( document ).on( "mouseover", function ( e ) {

		if ( e.target.id.indexOf( 'selector' ) !== -1 || e.target.tagName === 'BODY' || e.target.tagName === 'HTML' ) return;

		var $target      = $( e.target ),
			targetOffset = $target[ 0 ].getBoundingClientRect();

		// console.log( targetOffset );
		// console.log( "height: " + targetOffset.height );
		// console.log( "width: " + targetOffset.width );
		// console.log( "bottom: " + targetOffset.bottom );
		// console.log( "left: " + targetOffset.left );
		// console.log( "right: " + targetOffset.right );
		// console.log( "top: " + targetOffset.top );
		// console.log( "x: " + targetOffset.x );
		// console.log( "y: " + targetOffset.y );

		$target.not( ".pauNoEventAssig, .pauNoEventAssig *" ).addClass( 'pau-onlive' );

	} ).on( "mouseout", function ( e ) {

		if ( e.target.id.indexOf( 'selector' ) !== -1 || e.target.tagName === 'BODY' || e.target.tagName === 'HTML' ) return;

		var $target = $( e.target );

		$target.not( ".pauNoEventAssig, .pauNoEventAssig *" ).removeClass( 'pau-onlive' );

	} ).on( "click", function ( e ) {

		if ( e.target.id.indexOf( 'selector' ) !== -1 || e.target.tagName === 'BODY' || e.target.tagName === 'HTML' ) return;

		var $target = $( e.target ),
			id      = $target.attr( "id" );

		$selectorAssig = $target;

		switch ( id ) {

			case "pauEditPage":
			case "pauClose":
			case "pauSaveAssigWithConflicts":
			case "pauSaveAssig":
			case "pauAssigConflicts":
				return;

		}

		e.preventDefault();

		xPath = pauAssig.getXPath( $target.get( 0 ) ) || '';
		xPath = xPath.length > 0 ? xPath.trim() : xPath;

		$selectorAssig = $target;

		if ( e.target.tagName === 'IMG' ) {

			xPath = `img[src='${$target.attr( 'src' )}']`;

		}

		$pauSelectorView.html( xPath );
		$pauDataPath.val( url + xPath );

		pauAssig.validateXPath();

	} );

	$pauSaveAssig.on( "click", function () {

		var urlFinal = url + xPath.replace( "#", "PAUNUM" );
		location.href = urlFinal;

	} );

	$pauSaveWithConflicts.on( "click", function () {

		var texto    = $selectorAssig.text(),
			urlFinal = url + xPath.replace( "#", "PAUNUM" ) + "&text=" + texto;

		location.href = urlFinal;

	} );
	$( function () {
		$( '#draggable' ).draggable();
	} );

} );
