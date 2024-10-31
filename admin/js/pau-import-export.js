console.log ('Entrar en import js');
(function( $ ) {
	console.log ('Entrar en funcion de import js');
	//alert ('entra en import js');
	
//funcion de boton multimedia
	/********************************
	** wp.media (ojb { atributos}) **
	*********************************
	* @atributos objeto
	* str frame 		://[ 'select', 'post' (para editor de contenido, con galerias, lista de reproduccion de audio, videos o url) ,
	*						'image' , 'audio' , 'video' ]
	* str title 		:// 'Mi titulo del marco'
	* bool multiple 	: //activa 'true' o desactiva 'false' la selección multiple
	* obj button 		: { str text ] // 'Texto del boton de Selección'
	* ojt library : {
	*					str order :// 'ASC' | 'DESC'	
	*					str orderby		: // [ 'name' , 'autor', 'date' , 'title' , 'modified' ,
	*											'uploadedTo' , 'id , 'post__in', 'menuOrder' ]
	*					str type 		: // tipo mine. Ej: 'image, ' image/jpeg', 'video' , ...
	*					str search 	: null // busca el titulo del archivo adjunto
	*					int uploadedTo 	: null // adjunto a un post especifico (ID)
	*				}
	*******************************/
	
	var $btnMarco = $('#BtnExaminar'),
		marco;
	//abre la ventana de multimedia de WP	
	$btnMarco.on( 'click' , function (e) {
	/*$('.btnMarco').on( 'click' , function (e) {*/
		e.preventDefault();
		
		if( marco ) {
			marco.open();
			return;
		}
		
		var marco = wp.media({
			frame: 'select',
			title: 'Subir Video',
			button: {
					text: 'Usar este video'
				},
			multiple: true, // true o false
			library: {
				order: 'ASC',
				orderby: 'title'
				,
				type: 'file/js',
				search: 'pau' //este busca archivos que contengan en su titulo la palabra PAU
				
				}
		});
		
		//obtener el dato para el select
		marco.on( 'select ', function(){
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
			console.log( 'El priemro es: ' + pauVideoMp4.url );
			$('.seleccion').attr( 'src', pauVideoMp4.url );
			
			//multiples valores
			console.log( 'Elementos: ' + pauVideos );
			$.each(pauVideos, function(i, v){
				console.log( 'Array: ' + i + ' Valor: ' + v );
			});
			
			//lo pone el previsualizacion
			$('.seleccion').attr( 'src', pauVideos.url );
		});
		
		marco.open();
		
	});
	
	
})( jQuery );	