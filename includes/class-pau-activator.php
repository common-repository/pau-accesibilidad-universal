<?php

/**
 * Se activa en la activación del plugin
 *
 * @link       https://estudioinclusivo.com
 * @since      1.0.0
 *
 * @package    pau
 * @subpackage pau/includes
 */

/**
 * Ésta clase define todo lo necesario durante la activación del plugin
 *
 * @since      1.0.0
 * @package    pau
 * @subpackage pau/includes
 * @author     Estudio Inclusivo <admin@estudioinclusivo.com>
 */
class PAU_Activator {
//echo ' entra en activator';
	/**
	 * Método estático que se ejecuta al activar el plugin
	 *
	 * Creación de la tabla {$wpdb->prefix}pau_data
     * para guardar toda la información necesaria
	 *
	 * @since 1.0.0
     * @access public static
	 */
	public static function activate() {

 		//echo ' entra en activate';
        //aqui pondremos bases de datos a crear
		// datos de configuracion inciales o deafault, etc

		/*Creamos base de datos de HotSpots */
		global $wpdb;

		$sql = "CREATE TABLE IF NOT EXISTS " . PAU_HOTSPOTS_TABLE . "(
			id int(11) UNSIGNED NOT NULL,
			lang text NOT NULL,
			estado varchar(20) NOT NULL DEFAULT 'pending',
			page varchar(20) NOT NULL,
			type tinytext NOT NULL,
			rute_object mediumtext NOT NULL,
			text_rute_object longtext,
			icon_library text NOT NULL,
			icon_library_code text NOT NULL,
			pictograma_name tinytext NOT NULL,
			pictograma_url text NOT NULL,
			pictograma_url_on text NOT NULL,
			pictograma_onclic text NOT NULL,
			pictograma_onclic_page varchar(20) NOT NULL,
			pau_onclic_tipo varchar(10) NOT NULL,
			audio_name tinytext NOT NULL,
			video_name tinytext NOT NULL,
			data_media longtext,
			correccion_w FLOAT(6) NOT NULL DEFAULT '0',
			correccion_h FLOAT(6) NOT NULL DEFAULT '0',
			correccion_x FLOAT(6) NOT NULL DEFAULT '0',
			correccion_y FLOAT(6) NOT NULL DEFAULT '0',
			position char(20) NOT NULL,
			correccion_w_emergent FLOAT(6) NOT NULL DEFAULT '0',
			correccion_h_emergent FLOAT(6) NOT NULL DEFAULT '0',
			custom_class char(50) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

		$wpdb->query( $sql );
		$wpdb->query( "ALTER TABLE {$wpdb->prefix}pau_hotspots ADD PRIMARY KEY (id)" );
		$wpdb->query( "ALTER TABLE {$wpdb->prefix}pau_hotspots CHANGE id id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT" );
		
		// FIN--Creamos base de datos de HotSpots //
		// INTRODUCION DE DATOS DEMO EN HOTSPOT

		$sql_2 = "INSERT INTO " . PAU_HOTSPOTS_TABLE . "(
			id, lang, estado, page, type, rute_object, text_rute_object, icon_library, icon_library_code, pictograma_name, pictograma_url, pictograma_url_on, pictograma_onclic, pictograma_onclic_page, pau_onclic_tipo, audio_name, video_name, data_media, correccion_w, correccion_h, correccion_x, correccion_y, position, correccion_w_emergent, correccion_h_emergent, custom_class) VALUES

			(null, 'es_ES', 'pending', '', 'menu', '', '', '', '',
				'Inicio', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/inicio-off.png', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/inicio-on.png', '', '', '',
				'audioInicio', 'VideoInicio', '{\"audio\":{\"mp3\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/es_ES/audioInicio.mp3\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/es_ES/audioInicio.ogg\"},\"video\":{\"mp4\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/es_ES/Menus/inicio.mp4\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/es_ES/Menus/inicio.ogv\",\"webm\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/es_ES/Menus/inicio.webm\"}}',
				0, 0, 5, 0, '', 0, 0, 'sinborde circular'
			),

			(null, 'es_ES', 'pending', '', 'menu', '', '', '', '',
				'Somos', 'https://res.cloudinary.com/inclusive-studio/image/upload/v1549281811/demo/pictogramas/somos-off.png', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/somos-on.png',  '', '', '',
				'audioQuienessomos', 'videoQuienesSomos', '{\"audio\":{\"mp3\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/es_ES/audioQuienessomos.mp3\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/es_ES/audioQuienessomos.ogg\"},\"video\":{\"mp4\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/es_ES/Menus/quienes-somos.mp4\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/es_ES/Menus/quienes-somos.ogv\",\"webm\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/es_ES/Menus/quienes-somos.webm\"}}',
				0, 0, 5, 0, '', 0, 0, 'sinborde circular'
			),

			(null, 'es_ES', 'pending', '', 'menu', '', '', '', '',
				'Accesibilidad', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/accesibilidad-off.png', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/accesibilidad-on.png', '', '', '',
				'audioAccesibilidad', 'videoAccesibilidad', '{\"audio\":{\"mp3\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/es_ES/audioAccesibilidad.mp3\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/es_ES/audioAccesibilidad.ogg\"},\"video\":{\"mp4\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/es_ES/Menus/accesibilidad.mp4\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/es_ES/Menus/accesibilidad.ogv\",\"webm\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/es_ES/Menus/accesibilidad.webm\"}}',
				0, 0, 5, 0, '', 0, 0, 'sinborde circular'
			),

			(null, 'es_ES', 'pending', '', 'menu', '', '', '', '',
				'Noticias', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/noticias-off.png', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/noticias-on.png',  '', '', '',
				'audioNoticias', 'videoNoticias', '{\"audio\":{\"mp3\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/es_ES/audioNoticias.mp3\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/es_ES/audioNoticias.ogg\"},\"video\":{\"mp4\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/es_ES/Menus/noticias.mp4\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/es_ES/Menus/noticias.ogv\",\"webm\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/es_ES/Menus/noticias.webm\"}}',
				0, 0, 5, 0, '', 0, 0, 'sinborde circular'
			),

			(null, 'es_ES', 'pending', '', 'menu', '', '', '', '',
				'Contacto', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/contacto-off.png', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/contacto-on.png',  '', '', '',
				'audioContacto', 'videoContacto', '{\"audio\":{\"mp3\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/es_ES/audioContacto.mp3\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/es_ES/audioContacto.ogg\"},\"video\":{\"mp4\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/es_ES/Menus/contacto.mp4\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/es_ES/Menus/contacto.ogv\",\"webm\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/es_ES/Menus/contacto.webm\"}}',
				0, 0, 5, 0, '', 0, 0, 'sinborde circular'
			),
			(null, 'ca', 'pending', '', 'menu', '', '', '', '',
				'Inci', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/inicio-off.png', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/inicio-on.png',  '', '', '',
				'audioInici', 'videoInici', '{\"audio\":{\"mp3\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/ca/audioInicio.mp3\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/ca/audioInicio.ogg\"},\"video\":{\"mp4\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/ca/Menus/inicio.mp4\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/ca/Menus/inicio.ogv\",\"webm\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/ca/Menus/inicio.webm\"}}',
				0, 0, 5, 0, '', 0, 0, 'sinborde circular'
			),

			(null, 'ca', 'pending', '', 'menu', '', '', '', '',
				'Som', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/somos-off.png', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/somos-on.png', '', '', '',
				'audioQuisom', 'videoQuisom', '{\"audio\":{\"mp3\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/ca/audioQuienesSomos.mp3\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/ca/audioQuienesSomos.ogg\"},\"video\":{\"mp4\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/ca/Menus/quienes-somos.mp4\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/ca/Menus/quienes-somos.ogv\",\"webm\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/ca/Menus/quienes-somos.webm\"}}',
				0, 0, 5, 0, '', 0, 0, 'sinborde circular'
			),

			(null, 'ca', 'pending', '', 'menu', '', '', '', '',
				'Accesibilitat', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/accesibilidad-off.png', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/accesibilidad-on.png', '', '', '',
				'audioAccesibilitat', 'videoAccesibilitat', '{\"audio\":{\"mp3\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/ca/audioAccesibilidad.mp3\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/ca/audioAccesibilidad.ogg\"},\"video\":{\"mp4\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/ca/Menus/accesibilidad.mp4\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/ca/Menus/accesibilidad.ogv\",\"webm\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/ca/Menus/accesibilidad.webm\"}}',
				0, 0, 5, 0, '', 0, 0, 'sinborde circular'
				),

			(null, 'ca', 'pending', '', 'menu', '', '', '', '',
				'Noticies', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/noticias-off.png', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/noticias-on.png', '', '', '',
				'audioNoticies', 'videoNoticies', '{\"audio\":{\"mp3\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/ca/audioNoticias.mp3\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/ca/audioNoticias.ogg\"},\"video\":{\"mp4\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/ca/Menus/noticias.mp4\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/ca/Menus/noticias.ogv\",\"webm\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/ca/Menus/noticias.webm\"}}',
				0, 0, 5, 0, '', 0, 0, 'sinborde circular'
			),

			(null, 'es_ES', 'pending', '', 'menu', '', '', '', '',
				'Contacte', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/contacto-off.png', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/contacto-on.png', '', '', '',
				'audioContacte', 'videoContacte', '{\"audio\":{\"mp3\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/ca/audioContacto.mp3\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/ca/audioContacto.ogg\"},\"video\":{\"mp4\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/ca/Menus/contacto.mp4\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/ca/Menus/contacto.ogv\",\"webm\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/ca/Menus/contacto.webm\"}}',
				0, 0, 5, 0, '', 0, 0, 'sinborde circular'
			),

			(null, 'en_EN', 'pending', '', 'menu', '', '', '', '',
				'Home', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/inicio-off.png', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/inicio-on.png', '', '', '',
				'audioHome', 'videoHome', '{\"audio\":{\"mp3\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/en_EN/audioInicio.mp3\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/en_EN/audioInicio.ogg\"},\"video\":{\"mp4\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/en_EN/Menus/inicio.mp4\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/en_EN/Menus/inicio.ogv\",\"webm\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/en_EN/Menus/inicio.webm\"}}',
				0, 0, 5, 0, '', 0, 0, 'sinborde circular'
			),

			(null, 'en_EN', 'pending', '', 'menu', '', '', '', '',
				'WeAre', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/somos-off.png', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/somos-on.png', '', '', '',
				'audioWeAre', 'videoWeAre', '{\"audio\":{\"mp3\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/en_EN/audioWeAre.mp3\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/en_EN/audioWeAre.ogg\"},\"video\":{\"mp4\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/en_EN/Menus/quienes-somos.mp4\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/en_EN/Menus/quienes-somos.ogv\",\"webm\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/en_EN/Menus/quienes-somos.webm\"}}',
				0, 0, 5, 0, '', 0, 0, 'sinborde circular'
			),

			(null, 'en_EN', 'pending', '', 'menu', '', '', '', '',
				'Accesibility', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/accesibilidad-off.png', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/accesibilidad-on.png', '', '', '',
				'audioAccesibility', 'videoAccesibility', '{\"audio\":{\"mp3\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/en_EN/audioAccesibilidad.mp3\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/en_EN/audioAccesibilidad.ogg\"},\"video\":{\"mp4\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/en_EN/Menus/accesibilidad.mp4\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/en_EN/Menus/accesibilidad.ogv\",\"webm\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/en_EN/Menus/accesibilidad.webm\"}}',
				0, 0, 5, 0, '', 0, 0, 'sinborde circular'
			),

			(null, 'en_EN', 'pending', '', 'menu', '', '', '', '',
				'News', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/noticias-off.png', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/noticias-on.png', '', '', '',
				'audioNews', 'videoNews', '{\"audio\":{\"mp3\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/en_EN/audioNoticias.mp3\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/en_EN/audioNoticias.ogg\"},\"video\":{\"mp4\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/en_EN/Menus/noticias.mp4\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/en_EN/Menus/noticias.ogv\",\"webm\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/en_EN/Menus/noticias.webm\"}}',
				0, 0, 5, 0, '', 0, 0, 'sinborde circular'
			),

			(null, 'en_EN', 'pending', '', 'menu', '', '', '', '',
				'Contact', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/contacto-off.png', 'https://res.cloudinary.com/inclusive-studio/image/upload/demo/pictogramas/contacto-on.png', '', '', '',
				'audioContact', 'videoContact', '{\"audio\":{\"mp3\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/en_EN/audioContacto.mp3\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/audios/en_EN/audioContacto.ogg\"},\"video\":{\"mp4\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/en_EN/Menus/contacto.mp4\",\"ogg\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/en_EN/Menus/contacto.ogv\",\"webm\":\"https://res.cloudinary.com/inclusive-studio/video/upload/demo/videos/en_EN/Menus/contacto.webm\"}}',
				0, 0, 5, 0, '', 0, 0, 'sinborde circular'
			)";

		$wpdb->query( $sql_2 );

		// comprobamos que no hayan sido definidos anteriormente
		$pauDefaultConfig = get_option( 'pau_default_data' );

        if( ! $pauDefaultConfig ) {

			$pauDefaultConfig  = [
				"settings" => [
					//AJUSTES
					'pau_activate_default' 	=> [
						'value'	=> 'on',
						'show'	=> 'on'
					],
					'cg_zoom_pau' 				=> [
						'value'	=> 100,
						'show'	=> 'on'
					],

					//perfiles
					'cg_perfil_defecto' 		=> [
						'value'	=> "default",
						'show'	=> 'on'
					],

					//General
					'cg_geral_todo' 			=> [
						'value'	=> 'on',
						'show'	=> 'on'
					],
					'cg_geral_sonido' 			=> [
						'value'	=> 'on',
						'show'	=> 'on'
					],
					'cg_geral_lectura' 			=> [
						'value'	=> 'on',
						'show'	=> 'on'
					],
					'cg_geral_video' 			=> [
						'value'	=> 'on',
						'show'	=> 'on'
					],

					//Navegacion
					'cg_nav_bigcursor' 				=> [
						'value'	=> 'on',
						'show'	=> 'on'
					],
					'cg_nav_clic' 				=> [
						'value'	=> 'on',
						'show'	=> 'on'
					],
					'cg_nav_zoom' 				=> [
						'value'	=> false,
						'show'	=> 'on'
					],
					'cg_nav_donde' 				=> [
						'value'	=> 'on',
						'show'	=> 'on'
					],

					//Fuentes y Tamaños
					'cg_font_size' 				=> [
						'value'	=> 1,
						'show'	=> 'on'
					],
					'cg_font_dislexia_legible'  => [
						'value'	=> false,
					],
					'cg_font_legible' 			=> [
						'show'	=> 'on'
					],
					'cg_font_dislexia' 			=> [
						'show'	=> 'on'
					],
					'cg_font_resaltar_links' 	=> [
						'value'	=> false,
						'show'	=> 'on'
					],

					//visuales
					'cg_visual_colors' 				=> [
						'value'	=> false
					],
					'cg_visual_colors_bn' 				=> [
						'show'	=> 'on'
					],
					'cg_visual_colors_invert' 		=> [
						'show'	=> 'on'
					],
					'cg_visual_resaltar_focus' 	=> [
						'value'	=> 'on',
						'show'	=> 'on'
					] //añadir ademas estilo, borde, color, etc
				],
				"hotspots"	=> []
			];

            //metemos array de datos en tabla options de WP pau_default_data
            add_option( 'pau_default_data', $pauDefaultConfig );
            //muestra en pantalla array

        }

	}

	/*----------------Damos de alta Hotspots de prueba pro defecto-------------*/

}
