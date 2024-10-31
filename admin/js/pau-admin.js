jQuery( document ).ready( function ( $ ) {

	'use strict';

	function extractWord( word, subject ) {

		let er = new RegExp( word );

		if ( er.test( subject ) ) {

			let index = subject.match( er ).index;

			return subject.substr( index, word.length );

		}

		return false;

	}

	/*-------------upload widget-----------------------------------------------*/
	/*fuente a doc:  https://cloudinary.com/documentation/upload_widget */
	/*
	 var myWidget = cloudinary.createUploadWidget({
	 cloudName: 'inclusive-studio',
	 uploadPreset: 'my_preset'}, (error, result) => {
	 if (!error && result && result.event === "success") {
	 console.log('Done! Here is the image info: ', result.info);
	 }
	 }
	 )

	 document.getElementById("upload_widget").addEventListener("click", function(){
	 myWidget.open();
	 }, false);

	 */
	/*fuente a doc:  https://demo.cloudinary.com/uw/#/ */
	/*	  function showUploadWidget() {
	 cloudinary.openUploadWidget({
	 cloudName: "<cloud name>",
	 uploadPreset: "<upload preset>",
	 sources: [
	 "local",
	 "url",
	 "camera",
	 "image_search",
	 "facebook",
	 "dropbox",
	 "instagram"
	 ],
	 googleApiKey: "<image_search_google_api_key>",
	 showAdvancedOptions: true,
	 cropping: true,
	 multiple: false,
	 defaultSource: "local",
	 styles: {
	 palette: {
	 window: "#FFFFFF",
	 windowBorder: "#90A0B3",
	 tabIcon: "#0078FF",
	 menuIcons: "#5A616A",
	 textDark: "#000000",
	 textLight: "#FFFFFF",
	 link: "#0078FF",
	 action: "#FF620C",
	 inactiveTabIcon: "#0E2F5A",
	 error: "#F44235",
	 inProgress: "#0078FF",
	 complete: "#20B832",
	 sourceBg: "#E4EBF1"
	 },
	 fonts: {
	 default: {
	 active: true
	 }
	 }
	 }
	 },
	 (err, info) => {
	 if (!err) {
	 console.log("Upload Widget event - ", info);
	 }
	 });
	 }
	 */
	/*-------------upload widget-----------------------------------------------*/

	/*Incializamos el menu desplegable collapsible de multimedia de alta en hotspot*/
	document.addEventListener( 'DOMContentLoaded', function () {
		var elems = document.querySelectorAll( '.collapsible' );
		var instances = M.Collapsible.init( elems, options );
	} );

	// Or with jQuery

	$( document ).ready( function () {
		$( '.collapsible' ).collapsible();
	} );
	/*--- fin---Incializamos el menu desplegable collapsible de multimedia de alta en hotspot*/

	const isLocalhost = Boolean(
		window.location.hostname === 'localhost' ||
		// [::1] is the IPv6 localhost address.
		window.location.hostname === '[::1]' ||
		// 127.0.0.1/8 is considered localhost for IPv4.
		window.location.hostname.match(
			/^127(?:\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/
		)
	);

	/*
	 * Cambios del mejoramiento dle código
	 */

	function modal_close( { msg = '', reload = false } ) {

		let $msgPrecargador    = $( "h3.msgPrecargador" ),
			$preloaderWrapper  = $( ".preloader-wrapper" ),
			$precargador       = $( '.precargador' ),
			$addHostspotsTable = $( '#add_hostspots_table' );

		$preloaderWrapper.css( "display", "none" );
		$msgPrecargador.text( msg );

		setTimeout( function () {

			$precargador.css( "display", "none" );

			if ( reload ) {
				$addHostspotsTable.modal( 'close' );
				location.reload();
			}

		}, 3000 );

	}

	$( '.tabs' ).tabs();

	$( '.modal' ).modal();
	$( 'select' ).formSelect( { classes : "pauSelHost" } );
	$( '.tooltipped' ).tooltip();

	$.fn.serializeObject = function () {

		var o = {};
		var a = this.serializeArray();

		$.each( a, function () {
			if ( o[ this.name ] ) {
				if ( !o[ this.name ].push ) {
					o[ this.name ] = [ o[ this.name ] ];
				}
				o[ this.name ].push( this.value || '' );
			} else {
				o[ this.name ] = this.value || '';
			}
		} );

		return o;

	};

	var $msgPrecargador   = $( "h3.msgPrecargador" ),
		$preloaderWrapper = $( ".preloader-wrapper" ),
		$pauMediaPreview  = $( ".pau-media-preview" ),
		$pauFormSettings  = $( "#pauFormSettings" ),
		$pauSaveSettings  = $( "#pauSaveSettings" ),
		$pauConfirmDelete = $( "#pauConfirmDelete" ),
		$pauDelete        = $( "#pauDelete" ),
		$pauTipo          = $( "#pauTipo" );

	if ( $pauSaveSettings.length ) {

		$pauSaveSettings.pushpin( {
			top    : $pauSaveSettings.offset().top,
			right  : 0,
			offset : 40
		} );

	}

	$pauSaveSettings.on( "click", function ( e ) {

		e.preventDefault();

		let data = $pauFormSettings.serializeObject();

		let extraValue = {
			action : 'pau_save_settings',
			nonce  : pau.seguridad
		};

		data = $.extend( {}, data, extraValue );

		$precargador.css( "display", "flex" );
		$preloaderWrapper.css( "display", "block" );
		$msgPrecargador.text( "" );

		$.ajax( {
			url      : pau.url.admin,
			type     : 'POST',
			dataType : 'json',
			data     : data,
			success  : function ( data ) {

				$preloaderWrapper.css( "display", "none" );

				if ( data.exception ) {
					console.log( data );
				} else if ( data.result ) {
					$msgPrecargador.text( pau.translate.settings.save );
				} else {
					$msgPrecargador.text( pau.translate.settings.nonewsave );
				}

				setTimeout( function () {
					$precargador.css( "display", "none" );
				}, 3000 );

			},
			error    : function ( d, x, v ) {

				console.log( d );
				console.log( x );
				console.log( v );

			}
		} );

	} );

	function validar( $elem ) {

		var nodeName = $elem.get( 0 ).nodeName,
			val      = $elem.val();

		var $inpSel = nodeName === "SELECT" ? $elem.siblings( "input.select-dropdown" ) : $elem;

		if ( val == "" || val == null ) {

			if ( !$inpSel.hasClass( "invalid" ) ) {
				$inpSel.addClass( "invalid" );
				$inpSel.removeClass( "valid" );
			}

			$inpSel.focus();

			M.toast( {
				html    : pau.translate.general.fieldempty,
				classes : 'rounded'
			} );

			return true;

		}

		if ( !$inpSel.hasClass( "valid" ) ) {
			$inpSel.addClass( "valid" );
			$inpSel.removeClass( "invalid" );
		}

	}

	$.fn.validar = function () {

		this.each( function () {

			var $this    = $( this ),
				nodeName = $this.get( 0 ).nodeName,
				val      = $this.val();

			var $inpSel = nodeName === "SELECT" ? $this.siblings( "input.select-dropdown" ) : $this;

			if ( val == "" || val == null ) {

				if ( !$inpSel.hasClass( "invalid" ) ) {
					$inpSel.addClass( "invalid" );
					$inpSel.removeClass( "valid" );
				}

				$inpSel.focus();

				M.toast( {
					html    : pau.translate.general.fieldempty,
					classes : 'rounded'
				} );

				return true;

			}

			if ( !$inpSel.hasClass( "valid" ) ) {
				$inpSel.addClass( "valid" );
				$inpSel.removeClass( "invalid" );
			}

			return false;

		} );

	};

	/*
	 * Checks validación de URLs externas
	 * de Videos y Audios
	 * */

	let $checkAudioVideoExternalUrls = $( '.checkAudioVideoExternalUrls' );

	$checkAudioVideoExternalUrls.on( 'click', function () {

		let $this = $( this ),
			type  = $this.attr( 'data-type' ),
			tp    = extractWord( "None", type );

		if ( !tp && type !== "None" ) {

			let $button = $( `.check${type}Urls button` ),
				$label  = $( `.check${type}Urls label` ),
				$input  = $( `.check${type}Urls input` );

			$button.toggle();
			$label.toggle();
			$input.toggle();

		} else {

			let $button = $( `.check${type.replace( 'None', '' )}Urls button` ),
				$msg    = $( `.msg${type}` );

			$msg.toggle();
			$button.toggle();

		}

	} );

	/*------------------------------------ codigo de Javi ------------------------------*/

	//declaramos todos los imput del formulario para poder trabajarlos
	var $pauID                         = $( '#pauIDHotsEdit' ),
		$pauInputEstado                = $( '#pau-input-estado' ),
		$pauSelectPage                 = $( '#pau-select-page' ),
		$pauInputTipo                  = $( '#pau-input-tipo' ),
		$pauInputRutaObjeto            = $( '#pau-input-ruta-objeto' ),
		$pauInputTextRutaObjeto        = $( '#pau-input-text-ruta-objeto' ),

		$pauInputTextIconLibrary       = $( '#pau-input-icon-library' ),
		$pauInputTextIconLibraryCode   = $( '#pau-input-icon-library-code' ),

		$pauInputNombrePictograma      = $( '#pau-input-nombre-pictograma' ),
		$pauInputPictogramaUrl         = $( '#pau-input-pictograma-url' ),
		$pauInputPictogramaUrlOn       = $( '#pau-input-pictograma-url-on' ),
		$pauPictoUrlImg                = $( ".pau-pictograma-url img" ),
		$pauPictoUrlOnImg              = $( ".pau-pictograma-url-on img" ),

		$pauInputPictogramaOnclic      = $( "#pau-input-pictograma-onclic" ),
		$pauInputOnclicTipo            = $( "#pau-input-onclic-tipo" ),
		$pauSelectPictogramaOnclicPage = $( '#pau-select-pictograma-onclic-page' ),

		$pauInputNombreAudio           = $( '#pau-input-nombre-audio' ),
		$pauInputNombreVideo           = $( '#pau-input-nombre-video' ),
		$pauInputAudioUrl              = $( '#pau-input-audio-url-mp3' ),
		$pauExtAudioOgg                = $( '#pau-input-audio-url-ogg' ),
		$pauInputVideoUrl              = $( '#pau-input-video-url-mp4' ),
		$pauExtVideoOgg                = $( '#pau-input-video-url-ogv' ),
		$pauExtVideoWebm               = $( '#pau-input-video-url-webm' ),
		$pauInputCorrectionW           = $( '#pau-input-correction-w' ),
		$pauInputCorrectionH           = $( '#pau-input-correction-h' ),
		$pauInputCorrectionX           = $( '#pau-input-correction-x' ),
		$pauInputCorrectionY           = $( '#pau-input-correction-y' ),

		$pauInputOption                = $( "#pau-input-option" ),
		$pauInputCorrectionWEmergent   = $( '#pau-input-correction-w-emergent' ),
		$pauInputCorrectionHEmergent   = $( '#pau-input-correction-h-emergent' ),

		$pauInputCutomClass            = $( '#pau-input-clase-personalizada' ),
		$pauSelectLang                 = $( "#pau-select-lang" ),
		$pauSelectPag                  = $( "#pau-select-page" ),

		// Campos nuevos para la edición

		$pauSelectPositionClase        = $( '#pau-select-position-clase' ),
		$onClicExternalUrls            = $( '.onClicExternalUrls' );

	$onClicExternalUrls.on( "click", function () {

		var $this   = $( this ),
			val     = $this.val(),
			isCheck = $this.prop( "checked" );

		if ( isCheck ) {
			$( '#pau-input-onclic-tipo' ).val( 'externo' );
		} else {
			$( '#pau-input-onclic-tipo' ).val( 'interno' );
		}

		$( '.onClicExternalUrl' ).toggle();
		$( '.onClicPageUrl' ).toggle();

	} );

	/*------------Funciones al editar----------*/

	var $editBtn = $( '.td-editar span i' );

	function editMediaPreview( { $el, val, type } ) {

		if ( val !== "" ) {

			let media   = type.split( "/" )[ 0 ],
				$parent = $el.parent(),
				$elObj  = $parent.find( `.pau-media-preview ${media}` );

			if ( media === "img" ) {

				$elObj.attr( 'src', val );

			} else {

				$elObj
					.append( `<source src="${val}" type="${type}">` );

				$elObj.get( 0 ).load();

			}

			$parent
				.find( '.pau-media-preview' )
				.show();

		}

	}

	$editBtn.on( "click", function () {
		// Don´t translate
		$pauTipo.val( "edit" );

		$( '.pau-media-preview' ).hide();

		$( '.pau-media-preview audio, .pau-media-preview video' ).empty();
		$( '.pau-media-preview img' ).attr( 'src', '' );

		$crearHotspots.text( pau.translate.hotspots.updatehotspot );

		var $this  = $( this ),
			$tr    = $this.parents( "tr" ),
			objAll = JSON.parse( $tr.attr( "data-all" ) );

		// $pauPictoUrlImg.parent().css( "display", "block" );
		// $pauPictoUrlOnImg.parent().css( "display", "block" );

		$pauID.val( objAll.id );
		$pauSelectLang.val( objAll.lang );

		if ( $pauSelectLang.length ) {

			if ( $pauSelectLang.get( 0 ).nodeName === "SELECT" ) {

				$pauSelectLang.trigger( "change" );

			}

		}

		$pauInputEstado.val( objAll.estado );
		$pauSelectPage.val( "" );

		setTimeout( function () {
			if ( objAll.page != "" ) {
				$pauSelectPage.val( objAll.page );
				$( 'select' ).formSelect( { classes : "pauSelHost" } );
			}
		}, 3000 );

		$pauInputTipo.val( objAll.type );
		$pauInputRutaObjeto.val( objAll.rute_object );
		$pauInputTextRutaObjeto.val( objAll.text_rute_object );

		$pauInputTextIconLibrary.val( objAll.icon_library );
		$pauInputTextIconLibraryCode.val( objAll.icon_library_code );

		/*
		 * Pictograma
		 * */
		$pauInputNombrePictograma.val( objAll.pictograma_name );
		$pauInputPictogramaUrl.val( objAll.pictograma_url );

		editMediaPreview( {
			$el  : $pauInputPictogramaUrl,
			val  : objAll.pictograma_url,
			type : 'img'
		} );

		$pauInputPictogramaUrlOn.val( objAll.pictograma_url_on );

		editMediaPreview( {
			$el  : $pauInputPictogramaUrlOn,
			val  : objAll.pictograma_url_on,
			type : 'img'
		} );

		$pauInputPictogramaOnclic.val( objAll.pictograma_onclic );
		$pauSelectPictogramaOnclicPage.val( objAll.pictograma_onclic_page );
		$pauInputOnclicTipo.val( objAll.pau_onclic_tipo );

		if ( objAll.pau_onclic_tipo === "externo" ) {
			$onClicExternalUrls.click();
		}

		/*
		 * Audio y Video name
		 * */
		$pauInputNombreAudio.val( objAll.audio_name );
		$pauInputNombreVideo.val( objAll.video_name );

		$pauInputCorrectionW.val( objAll.correccion_w );
		$pauInputCorrectionH.val( objAll.correccion_h );
		$pauInputCorrectionX.val( objAll.correccion_x );
		$pauInputCorrectionY.val( objAll.correccion_y );

		$pauInputOption.val( objAll.option );
		$pauInputCorrectionWEmergent.val( objAll.correccion_w_emergent );
		$pauInputCorrectionHEmergent.val( objAll.correccion_h_emergent );

		$pauInputCutomClass.val( objAll.custom_class );

		$pauSelectPositionClase.val( objAll.position );

		let data_media = JSON.parse( objAll.data_media.replace( /\\/g, "" ) );

		if ( $extCheckUrls.prop( "checked" ) === false ) {
			$extCheckUrls.trigger( 'click' );
		}

		/*
		 * Audios
		 * */
		$pauInputAudioUrl.val( data_media.audio.mp3 );
		$pauExtAudioOgg.val( data_media.audio.ogg );

		editMediaPreview( {
			$el  : $pauInputAudioUrl,
			val  : data_media.audio.mp3,
			type : 'audio/mpeg'
		} );

		editMediaPreview( {
			$el  : $pauExtAudioOgg,
			val  : data_media.audio.ogg,
			type : 'audio/ogg'
		} );

		/*
		 * Videos
		 * */
		$pauInputVideoUrl.val( data_media.video.mp4 );
		$pauExtVideoOgg.val( data_media.video.ogg );
		$pauExtVideoWebm.val( data_media.video.webm );

		editMediaPreview( {
			$el  : $pauInputVideoUrl,
			val  : data_media.video.mp4,
			type : 'video/mp4'
		} );
		editMediaPreview( {
			$el  : $pauExtVideoOgg,
			val  : data_media.video.ogg,
			type : 'video/ogg'
		} );
		editMediaPreview( {
			$el  : $pauExtVideoWebm,
			val  : data_media.video.webm,
			type : 'video/webm'
		} );

		M.updateTextFields();
		$( 'select' ).formSelect( { classes : "pauSelHost" } );
		$addHostspotsTable.modal( "open" );

	} );
	/*------FIN---Funciones al editar hotspot-------------*/

	//Cambio de pictograma de off a on----//
	var $pictoOFF = $( '.picto-off' );

	// on hover Cambiamos el pictograma en los listados de hotspots
	$pictoOFF
		.on( "mouseenter", function ( e ) {
			e.preventDefault();

			var $this      = $( this ),
				$urlActual = $this.attr( 'src' ),
				$urlCambio = $this.attr( 'data-url-cambio-estado' );
			// hacemos cambio de source
			//si no hay valor en data-url-cambio-estado, no cambies
			if ( $urlCambio != '' && typeof $urlCambio != 'undefined' ) {
				$this.attr( {
					'src'                    : $urlCambio,
					'data-url-cambio-estado' : $urlActual
				} );
			}
		} )
		.on( "mouseleave", function ( e ) {
			e.preventDefault();
			var $this      = $( this ),
				$urlActual = $this.attr( 'src' ),
				$urlCambio = $this.attr( 'data-url-cambio-estado' );
			// hacemos cambio de source
			//si no hay valor en data-url-cambio-estado, no cambies
			if ( $urlCambio != '' && typeof $urlCambio != 'undefined' ) {
				$this.attr( {
					'src'                    : $urlCambio,
					'data-url-cambio-estado' : $urlActual
				} );
			}

		} );

	/*Cambiamos cursor al pasar por encima de icono ASIGNAR*/

	var $asignar = $( '.asignar' );

	$asignar.on( "mouseenter", function ( e ) {

		e.preventDefault();

		$( this ).css( { 'cursor' : '-webkit-grab' } );

	} );

	/*---------------------------------FIN--- codigo de Javi ------------------------------*/
	/**
	 * Todo el código Javascript orientado a la administración
	 * debe estar escrito aquí
	 */

	var $precargador = $( '.precargador' ),
		urledit      = "?page=pau-hot-spots&action=edit&id=",
		idTable      = $( '#idTable' ).val();

	//funcion de boton multimedia
	/********************************
	 ** wp.media (ojb { atributos}) **
	 *********************************
	 * @atributos objeto
	 * str frame        ://[ 'select', 'post' (para editor de contenido, con galerias, lista de reproduccion de audio, videos o url) ,
	 *                        'image' , 'audio' , 'video' ]
	 * str title        :// 'Mi titulo del marco'
	 * bool multiple    : //activa 'true' o desactiva 'false' la selección multiple
	 * obj button        : { str text ] // 'Texto del boton de Selección'
	 * ojt library : {
	 *					str order :// 'ASC' | 'DESC'
	 *					str orderby		: // [ 'name' , 'autor', 'date' , 'title' , 'modified' ,
	 *											'uploadedTo' , 'id , 'post__in', 'menuOrder' ]
	 *					str type 		: // tipo mine. Ej: 'image, ' image/jpeg', 'video' , ...
	 *					str search 	: null // busca el titulo del archivo adjunto
	 *					int uploadedTo 	: null // adjunto a un post especifico (ID)
	 *				}
	 *******************************/

	var $btnMarco = $( '.btnMarco' ),
		marco;
	//abre la ventana de multimedia de WP
	$btnMarco.on( 'click', function ( e ) {
		/*$('.btnMarco').on( 'click' , function (e) {*/
		e.preventDefault();
		if ( marco ) {
			marco.open();
			return;
		}
		var marco = wp.media( {
			frame    : 'select',
			title    : pau.translate.hotspots.uploadvideo,
			button   : {
				text : pau.translate.hotspots.usethisvideo
			},
			multiple : true, // true o false
			library  : {
				order   : 'ASC',
				orderby : 'title',
				/*type: 'video/mp4',
				 search: 'pau' //este busca archivos que contengan en su titulo la palabra PAU
				 */
			}
		} );
		//obtener el dato para el select
		marco.on( 'select ', function () {
			/*
			 var pauVideoMp4 = marco.state().get( 'selection' ).toArray()[0].attributes.url; //convertimos a array y obtiene la URL del elemento 0 (uno solo seleccionado)
			 */
			//lo mismo en metodo Json
			/*
			 var pauVideoMp4 = marco.state().get( 'selection' ).toJSON()[0].url;
			 var pauVideoMp4 = marco.state().get( 'selection' ).first().toJSON().url;//lo mismo para el priemr elemento
			 */

			var pauVideoMp4 = marco.state().get( 'selection' ).first().toJSON(); //este seria para uno
			var pauVideos = marco.state().get( 'selection' ).toJSON();

			//solo uno
			$( '.seleccion' ).attr( 'src', pauVideoMp4.url );

			//multiples valores
			/*
			 $.each(pauVideos, function( i, v ){
			 console.log( 'Array: ' + i + ' Val: ' + v );
			 });
			 */

			//lo pone el previsualizacion
			$( '.seleccion' ).attr( 'src', pauVideos.url );

		} );

		marco.open();

	} );

	/**
	 * Helpers
	 */

	// Limpiador de enlaces para las imagenes
	function limpiarEnlace( url ) {

		var local = /localhost/;

		if ( local.test( url ) ) {

			var url_pathname = location.pathname,
				indexPos     = url_pathname.indexOf( 'wp-admin' ),
				url_pos      = url_pathname.substr( 0, indexPos ),
				url_delete   = location.protocol + "//" + location.host + url_pos;

			return url_pos + url.replace( url_delete, '' );

		} else {

			var url_real = location.protocol + '//' + location.hostname;
			return url.replace( url_real, '' );

		}

	}

	// Validando que los campos no estén vacíos
	function validarCamposVacios( selector ) {

		var $inputs = $( selector ),
			result  = false;

		$.each( $inputs, function ( k, v ) {

			var $input   = $( v ),
				inputVal = $input.val();

			if ( inputVal == '' && $input.attr( 'type' ) != 'file' ) {

				if ( !$input.hasClass( 'invalid' ) ) {

					$input.addClass( 'invalid' );

				}

				result = true;

			}

		} );

		if ( result ) {
			return true;
		} else {
			return false;
		}

	}

	function validarEmail( email ) {

		var er = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

		return er.test( email );

	}

	function quitarInvalid( selector ) {

		var $inputs = $( selector );

		$.each( $inputs, function ( k, v ) {

			var $input = $( v );

			if ( $input.hasClass( 'invalid' ) ) {
				$input.removeClass( 'invalid' );
			} else if ( $input.hasClass( 'active' ) ) {
				$input.removeClass( 'active' );
			}

		} );

	}

	var $addNuevoHotspot   = $( '#add-nuevo-hotspot' ),
		$addHostspotsTable = $( '#add_hostspots_table' );

	/* Modal con formulario para crear tabla */
	$addNuevoHotspot.on( 'click', function ( e ) {

		e.preventDefault();

		//limpiar $msgCampoSiVacio
		$( "input" ).not( '[type="checkbox"],[type="radio"],#pau-select-lang[type="text"],.notClean' ).val( "" );

		$( '.pau-media-preview' ).hide();
		$( '.pau-media-preview audio, .pau-media-preview video' ).empty();
		$( '.pau-media-preview img' ).attr( 'src', '' );

		$( "select" ).not( ".notClean" ).val( "" );
		$pauInputEstado.val( "pending" );
		$( "select" ).formSelect( { classes : "pauSelHost" } );

		if ( $extCheckUrls.prop( "checked" ) ) {
			$extCheckUrls.trigger( 'click' );
		}

		M.updateTextFields();

		$addHostspotsTable.modal( 'open' );

		$pauMediaPreview.css( "display", "none" );
		// no translate
		$pauTipo.val( "add" );
		$crearHotspots.text( pau.translate.hotspots.createhotspot );

	} );

	/*var $pauInputTipo  = $( "#pau-input-tipo" ),
	 $pauSelectPage = $( "#pau-select-page" );*/

	// $pauInputTipo.on( "change", function(){
	//
	// 	var $this 		= $(this),
	// 		valTipo		= $this.val();
	//
	// 	if( valTipo == "menu" ) {
	// 		$pauSelectPage.prop( "disabled", true );
	// 	} else {
	// 		$pauSelectPage.prop( "disabled", false );
	// 	}
	//
	// 	$('select').formSelect();
	//
	// });

	/**
	 * Checkbox external URLs event click
	 */

	var $extCheckUrls = $( ".checkExternalUrls" );

	$extCheckUrls.on( "click", function () {

		var $this   = $( this ),
			val     = $this.val(),
			isCheck = $this.prop( "checked" );

		$( '.pau-external-' + val ).toggle();
		$( 'button[data-media="pau-' + val + '"]' ).toggle();

	} );

	/**
	 * Evento click para guardar
	 * el registro en la base de datos
	 * utilizando AJAX
	 */

	function paUCallAjaxSaveHots( data ) {

		$.ajax( {
			url      : pau.url.admin,
			type     : 'POST',
			dataType : 'json',
			data     : data,
			success  : function ( data ) {

				let reload = false;

				if ( data.exception ) {
					console.log( data );
				} else {

					reload = true;

				}

				modal_close( {
					msg : data.msg,
					reload
				} );

			},
			error    : function ( d, x, v ) {

				console.log( d );
				console.log( x );
				console.log( v );

			}
		} );

	}

	var $crearHotspots = $( '#crear-hotspots' );

	$crearHotspots.on( 'click', function ( e ) {

		e.preventDefault();

		if (
			// ! validar( $pauSelectLang ) &&
			!validar( $pauInputEstado ) &&
			// ! validar( $pauSelectPage ) &&
			!validar( $pauInputTipo )
		// ! validar( $pauInputAudioUrl ) &&
		// ! validar( $pauInputVideoUrl )
		) {

			//cogemos los valores delos campos input para trabajr con ellos en AJAX
			var $formHotspots = $( "#formHotspots" ),
				data          = $formHotspots.serializeObject();

			var $dataPauInput   = $( ".data-pau-input" ),
				isMakeFormat    = false,
				hasException    = true,
				dataMakeFormats = [],
				data_media      = {},
				promise,
				cont            = 0;

			$.each( $dataPauInput, function ( i ) {

				var $elem = $( this ),
					val   = $elem.val();

				if ( val != "" ) {

					var obj = val.split( "," );

					dataMakeFormats[ cont ] = {
						id      : obj[ 0 ],
						type    : obj[ 1 ],
						subtype : obj[ 2 ],
						name    : obj[ 3 ],
						url     : obj[ 4 ]
					};

					cont++;

				}

			} );

			var extraValue = {
				action : 'pau_save_hostpots',
				nonce  : pau.seguridad,
				// tipo		: 'add'
			};

			data = $.extend( {}, data, extraValue );

			$preloaderWrapper.css( 'display', 'inline-block' );
			$precargador.css( 'display', 'flex' );

			if ( dataMakeFormats.length > 0 ) {

				$msgPrecargador.text( pau.translate.hotspots.processingvideo );

				promise = $.ajax( {
					url      : pau.url.admin,
					type     : 'POST',
					dataType : 'json',
					data     : {
						action          : 'pau_make_formats',
						nonce           : pau.seguridad,
						dataMakeFormats : dataMakeFormats,
						lang            : $pauSelectLang.val()
					},
					success  : function ( data ) {

						if ( data.exception ) {
							hasException = true;
						} else if ( data.result ) {
							isMakeFormat = true;
							data_media = data.data_media;
						}

					},
					error    : function ( d, x, v ) {

						console.log( d );
						console.log( x );
						console.log( v );

					}
				} )
					.then( function () {

						if ( hasException ) {

							modal_close();

							return;

						}

						$msgPrecargador.text( pau.translate.hotspots.savingdata );

						if ( !data_media.hasOwnProperty( "video" ) ) {

							data_media[ "video" ] = {
								mp4  : $pauInputVideoUrl.val(),
								ogg  : $pauExtVideoOgg.val(),
								webm : $pauExtVideoWebm.val()
							};

						} else if ( !data_media.hasOwnProperty( "audio" ) ) {

							data_media[ "video" ] = {
								mp3 : $pauInputAudioUrl.val(),
								ogg : $pauExtAudioOgg.val()
							};

						}

						data = $.extend( {}, data, { data_media : JSON.stringify( data_media ) } );

						// Call Ajax
						paUCallAjaxSaveHots( data );

					} );

			} else {

				data_media = {
					video : {
						mp4  : $pauInputVideoUrl.val(),
						ogg  : $pauExtVideoOgg.val(),
						webm : $pauExtVideoWebm.val()
					},
					audio : {
						mp3 : $pauInputAudioUrl.val(),
						ogg : $pauExtAudioOgg.val()
					}
				};

				$msgPrecargador.text( pau.translate.hotspots.savingdata );

				data = $.extend( {}, data, { data_media : JSON.stringify( data_media ) } );

				// Call Ajax
				paUCallAjaxSaveHots( data );

			}

			// $preloaderWrapper.css( "display", "none" );
			// $msgPrecargador.text( "Hubo un error al convertir el video y audio" );
			//
			// setTimeout( function(){
			// 	$precargador.fadeOut();
			// }, 3000 );

		}

	} );

	//funcion de BOTON EDITAR del listado
	// $(document).on( 'click' , '[data-pau-hotspot-id-edit]', function(){
	// 	var id=$(this).attr('data-pau-hotspot-id-edit');
	// 	location.href = urledit+id;
	//
	// });

	//funcion de VER EN VISUAl del listado
	$( document ).on( 'click', '[data-pau-hotspot-id-vervisual]', function () {
		var id = $( this ).attr( 'data-pau-hotspot-id-vervisual' );
		//location.href = urledit+id; //SERIA CON mode ver visual, habria que crearlo arriba
		alert( pau.translate.alerts.createfunctionvisual + id );

	} );

	//funcion de BOTON DUPLICAR del listado
	$( document ).on( 'click', '[data-pau-hotspot-id-duplicar]', function () {

		let $this = $( this ),
			id    = $this.attr( 'data-pau-hotspot-id-duplicar' );

		$precargador.css( 'display', 'flex' );
		$msgPrecargador.text( pau.translate.hotspots.duplicatehotspot );

		$.ajax( {
			url      : pau.url.admin,
			type     : 'POST',
			dataType : 'json',
			data     : {
				tipo   : "duplicate",
				action : 'pau_save_hostpots',
				nonce  : pau.seguridad,
				id     : id
			},
			success  : function ( data ) {

				$preloaderWrapper.css( "display", "none" );

				$msgPrecargador.text( data.msg );

				setTimeout( function () {
					$precargador.css( "display", "none" );
					$addHostspotsTable.modal( 'close' );
					location.reload();
				}, 3000 );

			},
			error    : function ( d, x, v ) {

				console.log( d );
				console.log( x );
				console.log( v );

			}
		} );

		//location.href = urledit+id;
		//dar de alta accion en json de duplicar y hacer un updae teble

	} );

	//funcion de BOTON EXPORTAR del listado
	$( document ).on( 'click', '[data-pau-hotspot-id-export]', function () {
		var id = $( this ).attr( 'data-pau-hotspot-id-export' );
		//location.href = urledit+id; //SERIA CON urlexport, habira que crearla arriba
		alert( pau.translate.alerts.createfunctionvisual + id );

	} );

	//funcion de BOTON ELMINAR del listado
	$( document ).on( 'click', '[data-pau-hotspot-id-remove]', function () {

		let $this = $( this ),
			id    = $this.attr( 'data-pau-hotspot-id-remove' );

		$pauConfirmDelete.find( ".modal-content h5 strong" ).text( id );
		$pauConfirmDelete.find( ".modal-footer a[data-pauID]" ).attr( "data-pauID", id );
		$pauConfirmDelete.modal( "open" );

	} );

	/**
	 * Confirmación de eliminación del registro de Hot Spots
	 */

	$pauDelete.on( "click", function () {

		// e.preventDefault();

		let id = $pauDelete.attr( "data-pauID" );

		$precargador.css( 'display', 'flex' );
		$msgPrecargador.text( pau.translate.hotspots.deletehotspot );

		$.ajax( {
			url      : pau.url.admin,
			type     : 'POST',
			dataType : 'json',
			data     : {
				tipo   : "delete",
				action : 'pau_save_hostpots',
				nonce  : pau.seguridad,
				id     : id
			},
			success  : function ( data ) {

				$preloaderWrapper.css( "display", "none" );

				$msgPrecargador.text( data.msg );

				setTimeout( function () {
					$precargador.css( "display", "none" );
					$addHostspotsTable.modal( 'close' );

					let $tr = $( 'tr[data-pauID="' + id + '"]' );
					$tr.css( {
						"background" : "red",
						"color"      : "white"
					} ).fadeOut( 700 );
					setTimeout( function () {
						$tr.remove();
					}, 700 );

					// location.reload();
				}, 3000 );

			},
			error    : function ( d, x, v ) {

				console.log( d );
				console.log( x );
				console.log( v );

			}
		} );

	} );

	//Abrir modal en page edit hotspots
	$( '.addItem' ).on( 'click', function ( e ) {

		$( '#addUpdate' ).modal( 'open' );

	} );

	//boton agragar item en page edit hotspots
	$( '.selectAudio' ).on( 'click', function ( e ) {

		e.preventDefault(); //esto es para que no se ejecute por defecto

	} );

	/*
	 * Selección de idiomas para las páginas
	 */

	if ( $pauSelectLang.length ) {

		if ( $pauSelectLang.get( 0 ).nodeName === "SELECT" ) {

			$pauSelectLang.on( 'change', function () {

				var $this = $( this ),
					lang  = $this.val();

				if ( lang != "" ) {

					$precargador.css( 'display', 'flex' );

					$.ajax( {
						url      : pau.url.admin,
						type     : 'POST',
						dataType : 'json',
						data     : {
							action : 'pau_switch_lang',
							nonce  : pau.seguridad,
							lang   : lang

						},
						success  : function ( data ) {

							$precargador.css( 'display', 'none' );

							/**
							 * Data Output de tipo wpml
							 */
							$pauSelectPag.html( data.output );
							$( "select" ).formSelect( { classes : "pauSelHost" } );

						},
						error    : function ( d, x, v ) {

							console.log( d );
							console.log( x );
							console.log( v );

						}
					} );

				}

			} );

		}

	}

	/*
	 * PAU Input Media
	 */

	var $pauMediaInputBtn = $( '.pau-input-media button' ),
		$pauRemoveMedia   = $( '.pau-remove-media' );

	$pauMediaInputBtn.on( 'click', function () {

		var $this            = $( this ),
			dataMedia        = $this.attr( 'data-media' ),
			mediaType        = $this.attr( 'data-mediaType' ),
			$pauMediaInput   = $( '.pau-input-media #' + dataMedia ),
			$pauDataInput    = $this.parent().parent().find( '#data-' + dataMedia ),
			$pauMediaPreview = $( '.pau-media-preview.' + dataMedia );

		$pauMediaPreview.hide();

		var marcoMedia;

		if ( marcoMedia ) {
			marcoMedia.open();
			return;
		}

		var title,
			btnText,
			media           = mediaType.split( "/" ),
			pauMediaTitle   = pau.translate.media.title,
			pauMediaBtnText = pau.translate.media.btnText;

		switch ( media[ 0 ] ) {

			case "image":
				[ title, btnText ] = [ pauMediaTitle.image, pauMediaBtnText.image ];
				break;

			case "audio":
				[ title, btnText ] = [ pauMediaTitle.audio, pauMediaBtnText.audio ];
				break;

			case "video":
				[ title, btnText ] = [ pauMediaTitle.video, pauMediaBtnText.video ];
				break;

		}

		marcoMedia = wp.media( {
			title    : title,
			button   : {
				text : btnText
			},
			multiple : false,
			library  : {
				type : mediaType
			}
		} );

		marcoMedia.on( 'select', function () {

			var adj = marcoMedia.state().get( 'selection' ).first().toJSON();

			$pauMediaInput.val( adj.url );

			switch ( adj.type ) {

				case "image":
					$pauMediaPreview.find( "img" ).attr( 'src', adj.url );
					break;

				case "audio":
				case "video":

					if ( $pauDataInput.length ) $pauDataInput.val( adj.id + "," + adj.type + "," + adj.subtype + "," + adj.name + "," + adj.url );

					$pauMediaPreview.find( adj.type )
						.append( `<source src="${adj.url}">` )
						.get( 0 ).load();
					break;

			}

			M.updateTextFields();

			setTimeout( function () {
				$pauMediaPreview.slideDown();
			}, 500 );

		} );

		marcoMedia.open();

	} );

	function selectProfiles( profile ) {

		let profiles = {

			/**
			 * Por defecto
			 */
			"default" : [

				// General
				{
					"cg_geral_todo" : {
						"type" : "check",
						"val"  : true,
					}
				},

				{
					"cg_geral_sonido" : {
						"type" : "check",
						"val"  : true,
					}
				},

				{
					"cg_geral_video" : {
						"type" : "check",
						"val"  : true,
					}
				},

				{
					"cg_geral_lectura" : {
						"type" : "check",
						"val"  : true,
					}
				},

				// Navegación
				{
					"cg_nav_bigcursor" : {
						"type" : "check",
						"val"  : true,
					}
				},

				{
					"cg_nav_clic" : {
						"type" : "check",
						"val"  : true,
					}
				},

				{
					"cg_nav_donde" : {
						"type" : "check",
						"val"  : true,
					}
				},

				{
					"cg_nav_zoom" : {
						"type" : "check",
						"val"  : true,
					}
				},

				// Fuentes

				{
					"cg_font_size" : {
						"type" : "text",
						"val"  : 1,
					}
				},

				{
					"cg_font_dislexia_legible" : {
						"type"   : "check",
						"val"    : "legible",
						"unique" : true
					}
				},

				{
					"cg_font_resaltar_links" : {
						"type" : "check",
						"val"  : true,
					}
				},

				// Visual
				{
					"cg_visual_resaltar_focus" : {
						"type" : "check",
						"val"  : true,
					}
				},

			],

			/**
			 * Diversidad Visual
			 */
			"visual-diversity" : [

				// General
				{
					"cg_geral_todo" : {
						"type" : "check",
						"val"  : true,
					}
				},

				{
					"cg_geral_sonido" : {
						"type" : "check",
						"val"  : true,
					}
				},

				{
					"cg_geral_video" : {
						"type" : "check",
						"val"  : false,
					}
				},

				{
					"cg_geral_lectura" : {
						"type" : "check",
						"val"  : false,
					}
				},

				// Navegación
				{
					"cg_nav_bigcursor" : {
						"type" : "check",
						"val"  : false,
					}
				},

				{
					"cg_nav_clic" : {
						"type" : "check",
						"val"  : true,
					}
				},

				{
					"cg_nav_donde" : {
						"type" : "check",
						"val"  : true,
					}
				},

				{
					"cg_nav_zoom" : {
						"type" : "check",
						"val"  : true,
					}
				},

				// Fuentes
				{
					"cg_font_size" : {
						"type" : "text",
						"val"  : 5,
					}
				},

				{
					"cg_font_dislexia_legible" : {
						"type"   : "check",
						"val"    : "legible",
						"unique" : true
					}
				},

				{
					"cg_font_resaltar_links" : {
						"type" : "check",
						"val"  : true,
					}
				},

				// Visual
				{
					"cg_visual_colors" : {
						"type"   : "check",
						"val"    : "blanconegro",
						"unique" : true
					}
				},

				{
					"cg_visual_resaltar_focus" : {
						"type" : "check",
						"val"  : true,
					}
				},

			],

			/**
			 * Diversidad Auditiva
			 */
			"auditive-diversity" : [

				// General
				{
					"cg_geral_todo" : {
						"type" : "check",
						"val"  : true,
					}
				},

				{
					"cg_geral_sonido" : {
						"type" : "check",
						"val"  : false,
					}
				},

				{
					"cg_geral_video" : {
						"type" : "check",
						"val"  : true,
					}
				},

				{
					"cg_geral_lectura" : {
						"type" : "check",
						"val"  : false,
					}
				},

				// Navegación
				{
					"cg_nav_bigcursor" : {
						"type" : "check",
						"val"  : false,
					}
				},

				{
					"cg_nav_clic" : {
						"type" : "check",
						"val"  : true,
					}
				},

				{
					"cg_nav_donde" : {
						"type" : "check",
						"val"  : true,
					}
				},

				{
					"cg_nav_zoom" : {
						"type" : "check",
						"val"  : true,
					}
				},

				// Fuentes
				{
					"cg_font_size" : {
						"type" : "text",
						"val"  : 6,
					}
				},

				{
					"cg_font_dislexia_legible" : {
						"type"   : "check",
						"val"    : "legible",
						"unique" : true
					}
				},

				{
					"cg_font_resaltar_links" : {
						"type" : "check",
						"val"  : true,
					}
				},

				// Visual
				{
					"cg_visual_resaltar_focus" : {
						"type" : "check",
						"val"  : true,
					}
				},

			],

			/**
			 * Diversidad Cognitiva
			 */
			"cognitive-diversity" : [

				// General
				{
					"cg_geral_todo" : {
						"type" : "check",
						"val"  : true,
					}
				},

				{
					"cg_geral_sonido" : {
						"type" : "check",
						"val"  : false,
					}
				},

				{
					"cg_geral_video" : {
						"type" : "check",
						"val"  : false,
					}
				},

				{
					"cg_geral_lectura" : {
						"type" : "check",
						"val"  : true,
					}
				},

				// Navegación
				{
					"cg_nav_bigcursor" : {
						"type" : "check",
						"val"  : false,
					}
				},

				{
					"cg_nav_clic" : {
						"type" : "check",
						"val"  : true,
					}
				},

				{
					"cg_nav_donde" : {
						"type" : "check",
						"val"  : true,
					}
				},

				{
					"cg_nav_zoom" : {
						"type" : "check",
						"val"  : true,
					}
				},

				// Fuentes
				{
					"cg_font_size" : {
						"type" : "text",
						"val"  : 6,
					}
				},

				{
					"cg_font_dislexia_legible" : {
						"type"   : "check",
						"val"    : "legible",
						"unique" : true
					}
				},

				{
					"cg_font_resaltar_links" : {
						"type" : "check",
						"val"  : true,
					}
				},

				// Visual
				{
					"cg_visual_resaltar_focus" : {
						"type" : "check",
						"val"  : true,
					}
				},

			],

			"custom" : []

		};

		profiles[ profile ].forEach( elem => {

			let name                          = Object.keys( elem )[ 0 ],
				$select                       = $( "." + name ),
				$elem                         = elem[ name ],
				{ type, val, unique = false } = $elem;

			switch ( type ) {

				case "check" :

					if ( unique ) {

						$select.each( function () {

							let $this = $( this ),
								value = $this.val();

							if ( val === value ) {
								$this.prop( "checked", true );
							}

						} );

					} else {

						$select.prop( "checked", val );

					}

					break;

				case "radio" :

					let $selecRadio = $( "." + name + '[value="' + val + '"]' );
					$selecRadio.prop( "checked", true );

					break;

				case "text" :

					$select.val( val );
					break;

			}

		} );

	}

	/*
	 * On Change Perfiles Settings
	 */

	var $cgPerfiles = $( ".cg_perfil_defecto" );

	$cgPerfiles.on( "click", function () {

		let $this = $( this ),
			val   = $this.val();

		if ( val === "personalizado" ) return;

		$( "input[type=text]" ).val( "" );
		$( 'input[type="checkbox"], input[type="radio"]' ).not( '#pau_activate_default, .cg_perfil_defecto, .pauShow' )
			.prop( "checked", false );
		$( "select" ).val( "" );
		$( "select" ).formSelect( { classes : "pauSelHost" } );
		//
		// if( $extCheckUrls.prop( "checked" ) === true ) {
		// 	$extCheckUrls.trigger( 'click' );
		// }

		M.updateTextFields();

		selectProfiles( val );

	} );

	$pauFormSettings
		.find( "input" )
		.not( "#pau_activate_default, .cg_perfil_defecto, .pauShow" )
		.on( "click", function () {
			$( '.cg_perfil_defecto[value="personalizado"]' ).prop( "checked", true );
		} );

	var $cg_font_dislexia_legible = $( ".cg_font_dislexia_legible" ),
		$cg_visual_colors         = $( ".cg_visual_colors" ),
		$pauCheckLegible          = $( "#pauCheckLegible" ),
		$pauCheckDislexia         = $( "#pauCheckDislexia" ),
		$pauCheckBlancoNegro      = $( "#pauCheckBlancoNegro" ),
		$pauCheckInvert           = $( "#pauCheckInvert" );

	$cg_font_dislexia_legible.on( "click", function ( e ) {

		let $this = $( this );

		if ( $this.is( ":checked" ) ) {

			if ( $this.val() === "readable" && $pauCheckDislexia.is( ":checked" ) ) {
				$pauCheckDislexia.trigger( "click" );
			} else if ( $pauCheckLegible.is( ":checked" ) ) {
				$pauCheckLegible.trigger( "click" );
			}

		}

	} );

	$cg_visual_colors.on( "click", function ( e ) {

		let $this = $( this );

		if ( $this.is( ":checked" ) ) {

			if ( $this.val() === "blackwhite" && $pauCheckInvert.is( ":checked" ) ) {
				$pauCheckInvert.trigger( "click" );
			} else if ( $pauCheckBlancoNegro.is( ":checked" ) ) {
				$pauCheckBlancoNegro.trigger( "click" );
			}

		}

	} );

	/**
	 * Mostrar / Ocultar todo
	 */

	let $cg_geral_todo    = $( "#cg_geral_todo" ),
		$cg_geral_sonido  = $( "#cg_geral_sonido" ),
		$cg_geral_video   = $( "#cg_geral_video" ),
		$cg_geral_lectura = $( "#cg_geral_lectura" );

	$cg_geral_todo.on( "click", function () {

		let $this = $( this );

		if ( $this.is( ":checked" ) ) {

			if ( !$cg_geral_sonido.is( ":checked" ) ) {
				$cg_geral_sonido.trigger( "click" );
			}

			if ( !$cg_geral_video.is( ":checked" ) ) {
				$cg_geral_video.trigger( "click" );
			}

			if ( !$cg_geral_lectura.is( ":checked" ) ) {
				$cg_geral_lectura.trigger( "click" );
			}

		} else {

			if ( $cg_geral_sonido.is( ":checked" ) ) {
				$cg_geral_sonido.trigger( "click" );
			}

			if ( $cg_geral_video.is( ":checked" ) ) {
				$cg_geral_video.trigger( "click" );
			}

			if ( $cg_geral_lectura.is( ":checked" ) ) {
				$cg_geral_lectura.trigger( "click" );
			}

		}

	} );

	

	var $pauSearchHotspot = $( ".pau_search_hotspot" );

	// $pauSearchHotspot.on( "keyup", function( e ){
	//
	// 	console.log( e.keyCode );
	//
	// });

} );
