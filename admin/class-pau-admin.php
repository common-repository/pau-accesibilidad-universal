<?php

/**
 * La funcionalidad específica de administración del plugin.
 *
 * @link       https://estudioinclusivo.com
 * @since      1.0.0
 *
 * @package    pau
 * @subpackage pau/admin
 */

/**
 * Define el nombre del plugin, la versión y dos métodos para
 * Encolar la hoja de estilos específica de administración y JavaScript.
 *
 * @since      1.0.0
 * @package    pau
 * @subpackage pau/admin
 * @author     Estudio Inclusivo <admin@estudioinclusivo.com>
 *
 * @property string $plugin_pau
 * @property string $version
 */
class PAU_Admin {

	/** El identificador único de éste plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_pau El nombre o identificador único de éste plugin
	 */
	private $plugin_pau;

	/**
	 * Versión actual del plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version La versión actual del plugin
	 */
	private $version;

	/**
	 * Objeto registrador de menús
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object $build_menupage Instancia del objeto BCPG_Build_Menupage
	 */
	private $build_menupage;

	/**
	 * Objeto wpdb
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object $db @global $wpdb
	 */
	private $db;

	/**
	 * Objeto BCPG_CRUD_JSON
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object $crud_json Instancia del objeto BCPG_CRUD_JSON
	 */
	private $crud_json;

	/**
	 * Array con valores de los menús del Plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array
	 */
	private $menus = [
		'toplevel_page_pau',
		'pau_page_pau-settings',
		'pau_page_pau-proveedores',
		'pau_page_pau-wordpress',
		'pau_page_pau-auto-wcag',
		'pau_page_pau-wcag-assistant',
		'pau_page_pau-hot-spots',
		'pau_page_pau-styles',
		'pau_page_pau-import-export',
		'pau_page_pau-help',
		'pau_page_pau-support',
		'pau_page_pau-about-us',
	];

	private $helpers;
	private $pau_wpml;
	private $formbuild;
	private $settings;

	/**
	 * @param string $plugin_pau nombre o identificador único de éste plugin.
	 * @param string $version    La versión actual del plugin.
	 */
	public function __construct( $plugin_pau, $version ) {

		$this->plugin_name    = $plugin_pau;
		$this->version        = $version;
		$this->build_menupage = new PAU_Build_Menupage();

		global $wpdb, $helpers, $pau_wpml, $pauconfig;
		$this->settings = $pauconfig[ "settings" ];

		$this->db        = $wpdb;
		$this->helpers   = $helpers;
		$this->wpml      = $pau_wpml;
		$this->formbuild = new PAU_FormBuild();

	}

	/**
	 * Registra los archivos de hojas de estilos del área de administración
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function enqueue_styles( $hook ) {

		/**
		 * Condicional para controlar la carga de los archivos
		 * solamente en las páginas del plugin
		 */
		//echo "<br>---------------------------------------- el hook es $hook";

		if ( ! in_array( $hook, $this->menus ) ) {
			return;
		}

		//echo "<br>---------------------------------------- EJECUTA ENCOLAMIENTO CSS del plugin ---".$hook;

		/** INSERTAMOS MATERIALIZE CSS
		 * Framework Materializecss
		 * http://materializecss.com/getting-started.html
		 * Material Icons Google
		 * https://material.io/icons/
		 */
		wp_enqueue_style( 'pau_material_icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', [], $this->version, 'all' );
		wp_enqueue_style( 'pau_materialize_admin_css', PAU_DIR_URL . 'helpers/materialize/css/materialize.min.css', [], '1.0.0', 'all' );

		/**
		 * Una instancia de esta clase debe pasar a la función run()
		 * definido en PAU_Cargador como todos los ganchos se definen
		 * en esa clase particular.
		 *
		 * El PAU_Cargador creará la relación
		 * entre los ganchos definidos y las funciones definidas en este
		 * clase.
		 */
		wp_enqueue_style( $this->plugin_name, PAU_DIR_URL . 'admin/css/pau-admin.css', [], $this->version, 'all' );

	}

//----------------------------------------------------------------------------------------------------

	/**
	 * Registra los archivos Javascript del área de administración
	 *
	 * @param string $hook Devuelve el texto del slug del menú con el texto toplevel_page
	 *
	 * @since    1.0.0
	 * @access   public
	 *
	 */
	public function enqueue_scripts( $hook ) {

		/**
		 * Condicional para controlar la carga de los archivos
		 * solamente en las páginas del plugin
		 */

		//carga js solo si es una pagina del plugin PAU

		if ( ! in_array( $hook, $this->menus ) ) {
			return;
		}

		//echo "<br>---------------------------------------- EJECUTA ENCOLAMIENTO JS del plugin ---".$hook;
		/**
		 * Condicional para controlar la carga de los archivos
		 * solamente en la página del plugin
		 */
		//carga materialize solo en pagina de admin de hot-spots

		//echo "<br>----------------------------------------entra en if pau-hot-spots y carga JS de materilize ---$hooks";

		wp_enqueue_media();

		/**
		 * Framework Materializecss
		 * http://materializecss.com/getting-started.html
		 * Material Icons Google
		 */
		wp_enqueue_script( 'pau_materialize_admin_js', PAU_DIR_URL . 'helpers/materialize/js/materialize.min.js', [ 'jquery' ], '1.0.0', true );

		/**
		 * Sweet Alert
		 * http://t4t5.github.io/sweetalert/
		 */
		//wp_enqueue_script( 'pau_sweet_alert_js', PAU_DIR_URL . 'helpers/sweetalert-master/dist/sweetalert.min.js', ['jquery'], $this->version, true );

		//carga js correspondiente si entra en importar y exportar
		if ( $hook == 'pau_page_pau-import-export' ) {
			wp_enqueue_script( $this->plugin_name, PAU_DIR_URL . 'admin/js/pau-import-export.js', [ 'jquery' ], $this->version, true );
			//console.log('Llamamos entrar en import js');
		}

		/**
		 * Una instancia de esta clase debe pasar a la función run()
		 * definido en PAU_Cargador como todos los ganchos se definen
		 * en esa clase particular.
		 *
		 * El PAU_Cargador creará la relación
		 * entre los ganchos definidos y las funciones definidas en este
		 * clase.
		 */
		wp_enqueue_script( $this->plugin_name, PAU_DIR_URL . 'admin/js/pau-admin.js', [
			'jquery',
			'pau_materialize_admin_js',
		], $this->version, true );

		/**
		 * Lozalizando el archivo Javascript
		 * principal del área de administración
		 * para pasarle el objeto "bcpg" con los parámetros:
		 *
		 * @param bcpg.url        Url del archivo admin-ajax.php
		 * @param bcpg.seguridad  Nonce de seguridad para el envío seguro de datos
		 */
		wp_localize_script(
			$this->plugin_name,
			'pau',
			[
				'translate' => [
					'media'     => [
						'title'   => [
							'image' => __( 'Select an image', 'pau-universal-accessibility' ),
							'audio' => __( 'Select an audio', 'pau-universal-accessibility' ),
							'video' => __( 'Select a video', 'pau-universal-accessibility' ),
						],
						'btnText' => [
							'image' => __( 'Use this image', 'pau-universal-accessibility' ),
							'audio' => __( 'Use this audio', 'pau-universal-accessibility' ),
							'video' => __( 'Use this video', 'pau-universal-accessibility' ),
						],
					],
					'suppliers' => [

						'savinginfo'             => __( 'We are saving the information.', 'pau-universal-accessibility' ),
						'savingupdatepage'       => __( 'It has been saved correctly, the page will be updated soon.', 'pau-universal-accessibility' ),

					],
					'settings'  => [
						'save'      => __( 'The data has been saved correctly', 'pau-universal-accessibility' ),
						'nonewsave' => __( 'There is no information to save', 'pau-universal-accessibility' ),
					],
					'hotspots'  => [
						'createhotspot'    => __( "CREATE HOT SPOTS", 'pau-universal-accessibility' ),
						'updatehotspot'    => __( "UPDATE HOT SPOTS", 'pau-universal-accessibility' ),
						'deletehotspot'    => __( "Deleting the record ...", 'pau-universal-accessibility' ),
						'duplicatehotspot' => __( "Duplicating the data ...", 'pau-universal-accessibility' ),
						'usethisvideo'     => __( 'Use this video', 'pau-universal-accessibility' ),
						'uploadvideo'      => __( 'Upload video', 'pau-universal-accessibility' ),
						'processingvideo'  => __( 'Processing the conversion and optimisation of videos to 3 formats (mp4,mov and webm)...', 'pau-universal-accessibility' ),
						'savingdata'       => __( 'Saving the data ...', 'pau-universal-accessibility' ),
					],
					'general'   => [
						'fieldempty' => __( 'This field can not be left empty', 'pau-universal-accessibility' ),
					],
					'alerts'    => [
						'createfunctionvisual' => __( 'Create function of SEE IN VISUAL of the id: ', 'pau-universal-accessibility' ),
					],
				],
				'url'       => [
					'admin'           => admin_url( 'admin-ajax.php' ),
					'dir_path'        => PAU_DIR_PATH,
					'dir_url'         => PAU_DIR_URL,
					'multimedia'      => PAU_MULTIMEDIA,
					'multimedia_pau'  => PAU_MULTIMEDIA_PAU,
					'multimedia_user' => PAU_MULTIMEDIA_USER,
				],
				'seguridad' => wp_create_nonce( "pau_seg" ),
			]
		);

	} //fin de encolamiento de scripts

	public function make_formats_ffmpeg() {

		check_ajax_referer( 'pau_seg', 'nonce' );

		if ( current_user_can( 'manage_options' ) ) {

			require PAU_DIR_PATH . "helpers/ffmpeg/vendor/autoload.php";

			global $separator;

			/*PAU_Helpers::dd(
				is_file( PAU_DIR_PATH . "helpers/ffmpeg/bin/ffmpeg.exe" ),
				is_file( PAU_DIR_PATH . "helpers/ffmpeg/bin/ffprobe.exe" )
			);*/

			//PAU_Helpers::ddJSON( PAU_DIR_PATH, is_file( "/var/www/vhosts/estudioinclusivo.com/ffmpeg.estudioinclusivo.com/wp-content/plugins/pau/helpers/ffmpeg/bin/ffmpeg" ) );


			$post_lang = sanitize_text_field( $_POST[ 'lang' ] );
			$path_ffmpeg  = PAU_DIR_PATH . "helpers/ffmpeg/bin/ffmpeg.exe";
			$path_ffprobe = PAU_DIR_PATH . "helpers/ffmpeg/bin/ffprobe.exe";

			$dateMakeFormats = sanitize_text_field( $_POST[ "dataMakeFormats" ] );

			$dir_url_lang_user  = PAU_MULTIMEDIA_USER . $post_lang . "/";
			$dir_path_lang_user = PAU_MULTIMEDIA_USER_PATH . $post_lang . "/";
			$data_media         = [];

			if ( ! file_exists( $dir_path_lang_user ) ) {
				mkdir( $dir_path_lang_user, 0777, true );
			}
			if ( ! file_exists( $dir_path_lang_user . "videos" ) ) {
				mkdir( $dir_path_lang_user . "videos", 0777 );
			}
			if ( ! file_exists( $dir_path_lang_user . "audios" ) ) {
				mkdir( $dir_path_lang_user . "audios", 0777 );
			}

			$args_binaries = [
				'ffmpeg.binaries'  => $path_ffmpeg,
				'ffprobe.binaries' => $path_ffprobe,
				'timeout'          => 3600,
				'ffmpeg.threads'   => 12,
			];

			try {

				$ffmpeg = FFMpeg\FFMpeg::create( $args_binaries );

				foreach ( $dateMakeFormats as $infoMedia ) {

					$infoMedia = (object) $infoMedia;

					$attach_file = get_attached_file( $infoMedia->id );
					$media       = $ffmpeg->open( $attach_file );

					/*$msgDebugFFMpeg = [];

					$ffmpeg->getFFMpegDriver()->listen(new \Alchemy\BinaryDriver\Listeners\DebugListener());
					$ffmpeg->getFFMpegDriver()->on('debug', function ($message) use (&$msgDebugFFMpeg) {

						$msgDebugFFMpeg[] = $message;

					});*/

					$ruta_url  = "$dir_url_lang_user{$infoMedia->type}s/{$infoMedia->name}-{$infoMedia->id}";
					$ruta_path = "$dir_path_lang_user{$infoMedia->type}s/{$infoMedia->name}-{$infoMedia->id}";
//					PAU_Helpers::ddJSON( $attach_file, is_writable( $attach_file ) );

					switch ( $infoMedia->type ) {

						case 'video':

							$webm = $ffmpeg->open( $attach_file );
							// $mp4  = $ffmpeg->open( $attach_file );
							$formatMp4 = new FFMpeg\Format\Video\X264();

							$formatMp4->setAudioCodec( "libmp3lame" );

							$webm
								->filters()
								->resize( new FFMpeg\Coordinate\Dimension( 150, 150 ) )
								// ->framerate( 15 )
								->synchronize();

							$media
								->filters()
								->resize( new FFMpeg\Coordinate\Dimension( 300, 300 ) )
								// ->framerate( 15 )
								->synchronize();

							$webm
								->save( new FFMpeg\Format\Video\WebM(), "$ruta_path.webm" );

							$media
								->filters()
								->resize( new FFMpeg\Coordinate\Dimension( 300, 300 ) )
								// ->framerate( 15 )
								->synchronize();

							$media
								->save( $formatMp4, "$ruta_path.mp4" )
								->save( new FFMpeg\Format\Video\Ogg(), "$ruta_path.ogg" );

							$data_media[ 'video' ] = [
								"mp4"  => "$ruta_url.mp4",
								"ogg"  => "$ruta_url.ogg",
								"webm" => "$ruta_url.webm",
							];

							break;

						case 'audio':

							$formatOgg = new FFMpeg\Format\Audio\Ogg();
							$formatMp3 = new FFMpeg\Format\Audio\Mp3();

//							$formatMp3->setAudioKiloBitrate( 128 );
//							$formatOgg->setAudioKiloBitrate( 128 );

							$media
								->save( $formatMp3, "$ruta_path.mp3" )
								->save( $formatOgg, "$ruta_path.ogg" );

							$data_media[ 'audio' ] = [
								"mp3" => "$ruta_url.mp3",
								"ogg" => "$ruta_url.ogg",
							];

							break;

					}

				}

				$json = json_encode( [
					'result'     => true,
					'data_media' => $data_media,
				] );

			} catch ( Exception $e ) {

				$json = PAU_Helpers::getExceptionJSON( $e );

			}

			echo $json;
			wp_die();

		}

	}


//---------------------------------------------------------------------------------------------------
	//funcion de tratamiento de datos via ajax de hotspots
	public function pau_save_hostpots() {

		check_ajax_referer( 'pau_seg', 'nonce' );

		if ( current_user_can( 'manage_options' ) ) {


			$this->db->show_errors = false;

			$tipo = sanitize_text_field( $_POST[ "tipo" ] );

			$subtitle = "";
			$idEditHS = "";

			if ( $tipo == 'add' ) {

				$subtitle = "guardados";

				$columns = [
					'lang'                   => sanitize_text_field( $_POST[ "pau-select-lang" ] ?? '' ),
					'estado'                 => sanitize_text_field( $_POST["pau-input-estado" ] ?? ''),
					'page'                   => sanitize_text_field( $_POST["pau-select-page" ] ?? ''),
					'type'                   => sanitize_text_field( $_POST[ "pau-input-tipo" ] ?? ''),
					'rute_object'            => sanitize_text_field( $_POST["pau-input-ruta-objeto" ] ?? ''),
					'text_rute_object'       => sanitize_text_field( $_POST[ "pau-input-text-ruta-objeto" ] ?? ''),
					'icon_library'           => sanitize_text_field( $_POST[ "pau-input-icon-library" ] ?? ''),
					'icon_library_code'      => sanitize_text_field( $_POST[ "pau-input-icon-library-code" ] ?? ''),
					'pictograma_name'        => sanitize_text_field( $_POST[ "pau-input-nombre-pictograma" ] ?? ''),
					'pictograma_url'         => sanitize_text_field( $_POST[ "pau-input-pictograma-url" ] ?? ''),
					'pictograma_url_on'      => sanitize_text_field( $_POST[ "pau-input-pictograma-url-on" ] ?? ''),
					'pictograma_onclic'      => sanitize_text_field( $_POST[ "pau-input-pictograma-onclic" ] ?? ''),
					'pictograma_onclic_page' => sanitize_text_field( $_POST[ "pau-select-pictograma-onclic-page" ] ?? ''),
					'pau_onclic_tipo'        => sanitize_text_field( $_POST[ "pau-input-onclic-tipo" ] ?? ''),
					'audio_name'             => sanitize_text_field( $_POST[ "pau-input-nombre-audio" ] ?? ''),
					'video_name'             => sanitize_text_field( $_POST[ "pau-input-nombre-video" ] ?? ''),
					'correccion_w'           => sanitize_text_field( $_POST[ "pau-input-correction-w" ] ?? ''),
					'correccion_h'           => sanitize_text_field( $_POST[ "pau-input-correction-h" ] ?? ''),
					'correccion_x'           => sanitize_text_field( $_POST[ "pau-input-correction-x" ] ?? ''),
					'correccion_y'           => sanitize_text_field( $_POST[ "pau-input-correction-y" ] ?? ''),
					'position'               => sanitize_text_field( $_POST[ "pau-select-position-clase" ] ?? ''),
					'correccion_w_emergent'  => sanitize_text_field( $_POST[ "pau-input-correction-w-emergent" ] ?? ''),
					'correccion_h_emergent'  => sanitize_text_field( $_POST[ "pau-input-correction-h-emergent" ] ?? ''),
					'custom_class'           => sanitize_text_field( $_POST[ "pau-input-clase-personalizada" ] ?? ''),
					'data_media'             => sanitize_text_field( $_POST[ "data_media" ] ?? ''),
				];

				$format = [
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
				];

//				PAU_Helpers::ddJSON( $columns, $format, $_POST );


				$result = $this->db->insert( PAU_HOTSPOTS_TABLE, $columns, $format );

			} elseif ( $tipo == 'edit' ) {

				$subtitle = "actualizados";

				$columns = [
					'lang'                   => sanitize_text_field( $_POST[ "pau-select-lang" ] ?? ''),
					'estado'                 => sanitize_text_field( $_POST[ "pau-input-estado" ] ?? ''),
					'page'                   => sanitize_text_field( $_POST[ "pau-select-page" ] ?? ''),
					'type'                   => sanitize_text_field( $_POST[ "pau-input-tipo" ] ?? ''),
					'rute_object'            => sanitize_text_field( $_POST[ "pau-input-ruta-objeto" ] ?? ''),
					'text_rute_object'       => sanitize_text_field( $_POST[ "pau-input-text-ruta-objeto" ] ?? ''),
					'icon_library'           => sanitize_text_field( $_POST[ "pau-input-icon-library" ] ?? ''),
					'icon_library_code'      => sanitize_text_field( $_POST[ "pau-input-icon-library-code" ] ?? ''),
					'pictograma_name'        => sanitize_text_field( $_POST[ "pau-input-nombre-pictograma" ] ?? ''),
					'pictograma_url'         => sanitize_text_field( $_POST[ "pau-input-pictograma-url" ] ?? ''),
					'pictograma_url_on'      => sanitize_text_field( $_POST[ "pau-input-pictograma-url-on" ] ?? ''),
					'pictograma_onclic'      => sanitize_text_field( $_POST[ "pau-input-pictograma-onclic" ] ?? ''),
					'pictograma_onclic_page' => sanitize_text_field( $_POST[ "pau-select-pictograma-onclic-page" ] ?? ''),
					'pau_onclic_tipo'        => sanitize_text_field( $_POST[ "pau-input-onclic-tipo" ] ?? ''),
					'audio_name'             => sanitize_text_field( $_POST[ "pau-input-nombre-audio" ] ?? ''),
					'video_name'             => sanitize_text_field( $_POST[ "pau-input-nombre-video" ] ?? ''),
					'correccion_w'           => sanitize_text_field( $_POST[ "pau-input-correction-w" ] ?? ''),
					'correccion_h'           => sanitize_text_field( $_POST[ "pau-input-correction-h" ] ?? ''),
					'correccion_x'           => sanitize_text_field( $_POST[ "pau-input-correction-x" ] ?? ''),
					'correccion_y'           => sanitize_text_field( $_POST[ "pau-input-correction-y" ] ?? ''),
					'position'               => sanitize_text_field( $_POST[ "pau-select-position-clase" ] ?? ''),
					'correccion_w_emergent'  => sanitize_text_field( $_POST[ "pau-input-correction-w-emergent" ] ?? ''),
					'correccion_h_emergent'  => sanitize_text_field( $_POST[ "pau-input-correction-h-emergent" ] ?? ''),
					'custom_class'           => sanitize_text_field( $_POST[ "pau-input-clase-personalizada" ] ?? ''),
					'data_media'             => sanitize_text_field( $_POST[ "data_media" ] ?? ''),
				];

				$format = [
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
					"%s",
				];

				$idEditHS = sanitize_key( $_POST[ 'pauIDHotsEdit' ] );

				$where = [
					"id" => $idEditHS,
				];

				$whereFormat = [
					"%d",
				];

				/*---Incio----edicion javi */

				$result = $this->db->update( PAU_HOTSPOTS_TABLE, $columns, $where, $format, $whereFormat );

				/*---FIN----edicion javi ---*/

				$msg = __( 'No new data to update ...', 'pau-universal-accessibility' );

			} elseif ( $tipo == 'duplicate' ) {

				$subtitle = "duplicados";

				$hotsTable = PAU_HOTSPOTS_TABLE;
				$sql_post_id = sanitize_key( $_POST[ "id" ] );
				$sql = "
                    INSERT INTO $hotsTable
                    SELECT null, lang, estado,
                           page, type, null, null,
                           icon_library, icon_library_code,
                           pictograma_name, pictograma_url, pictograma_url_on,
                           pictograma_onclic, pictograma_onclic_page, pau_onclic_tipo,
                           audio_name, video_name, data_media,
                           correccion_w, correccion_h, correccion_x, correccion_y,
                           position, correccion_w_emergent, correccion_h_emergent, custom_class
                    FROM $hotsTable
                    WHERE id = $sql_post_id
                ";

				$result = $this->db->query( $sql );

				$msg = __( 'The registration could not be duplicated, please contact the administrator ...', 'pau-universal-accessibility' );

			} elseif ( $tipo == 'delete' ) {

				$subtitle = __( "deletes", "pau-universal-accessibility" );

				$where = [
					'id' => sanitize_key( $_POST[ 'id' ] ),
				];

				$where_format = [
					"%d",
				];

				$result = $this->db->delete( PAU_HOTSPOTS_TABLE, $where, $where_format );

				$msg = __( 'The record could not be deleted ...', 'pau-universal-accessibility' );

			}

			if ( $result ) {
				$msg = sprintf(
					__( "The data has been %s correctly", "pau-universal-accessibility" ),
					$subtitle
				);
			}

						PAU_Helpers::dberrorJSON( $this->db );

			$json = json_encode( [
				'result' => $result,
				'msg'    => $msg,
			] );

			echo $json;
			wp_die();

		}

	}

	public function pau_save_settings() {

		check_ajax_referer( 'pau_seg', 'nonce' );

		if ( current_user_can( 'manage_options' ) ) {

			if ( isset( $_POST[ 'pau_default_data' ] ) ) {

				$settings = $_POST[ 'pau_default_data' ][ 'settings' ];
				$settings_final = [];

				// Limpiando Datos
				foreach ( $settings as $key => $value ) {

					$settings_final[ $key ] = [];

					if ( is_array( $value ) ) {

						foreach ( $value as $key2 => $value2 ) {

							$settings_final[ $key ][ $key2 ] = sanitize_text_field( $value2 );

						}

					}

				}

				$result = update_option( "pau_default_data", [ 'settings' => $settings_final ] );

				$json = json_encode( [
					'result'           => $result,
					"pau_default_data" => $PostDefaultData,
				] );

				echo $json;
				wp_die();

			}

		}

	}


	/**
	 * Registra los menús del plugin en el
	 * área de administración
	 *
	 * @since    1.0.0
	 * @access   public
	 */

	/*-------------Menu Principal------------*/
	public function add_menu() {

		$this->build_menupage->add_menu_page(
			__( 'PAU Dashboard: Universal Accessibility Control Panel for the administrator', 'pau-universal-accessibility' ),
			__( 'PAU', 'pau-universal-accessibility' ),
			'manage_options',
			'pau',
			[
				$this,
				'controlador_page_display_menu',
			],
			PAU_DIR_URL . 'admin/img/menus/icono-pau.svg',
			22
		);

		/*---------------------------registro de submenus ------------------------------------*/
		/**
		 * Registra los sub-menús del plugin en el
		 * área de administración
		 *
		 * @since    1.0.0
		 * @access   public
		 **/

		/*---------submenu de SETTINGS ------------*/
		$this->build_menupage->add_submenu_page(
			'pau',                     //slug del padre
			__( 'PAU Settings', 'pau-universal-accessibility' ),                  //titulo
			__( 'Settings', 'pau-universal-accessibility' ),                   //titulo del menu
			'manage_options',                  //capacidades (usuario actual)
			'pau-settings',                   //slug del menu o enlace
			[
				$this,
				'controlador_page_display_menu',
			]      //la funcion a la que se llama al ejecutar
		//'pau_config_page_display'    //la funcion a la que se llama al ejecutar
		);

		/*---------submenu de PROVEEDORES ------------*/
		$this->build_menupage->add_submenu_page(
			'pau',                     //slug del padre
			__( 'Accessible content, providers and licenses', 'pau-universal-accessibility' ),                  //titulo
			__( 'Suppliers', 'pau-universal-accessibility' ),                   //titulo del menu
			'manage_options',                  //capacidades (usuario actual)
			'pau-proveedores',                   //slug del menu o enlace
			[
				$this,
				'controlador_page_display_menu',
			]      //la funcion a la que se llama al ejecutar
		);

		/*---------submenu de Wordpress ------------*/
		/*
        $this->build_menupage->add_submenu_page(
           'pau',                     //slug del padre
            __( 'Wordpress WCAG', 'pau-universal-accessibility' ),                  //titulo
            __('Wordpress WCAG', 'pau-universal-accessibility' ),                   //titulo del menu
            'manage_options',                  //capacidades (usuario actual)
            'pau-wordpress',                   //slug del menu o enlace
			[ $this, 'controlador_page_display_menu' ]     //la funcion a la que se llama al ejecutar
        );
        */

		/*---------submenu de Auto WCAG ------------*/
		/*
        $this->build_menupage->add_submenu_page(
			'pau',                     //slug del padre
            __( 'Auto WCAG', 'pau-universal-accessibility' ),                  //titulo
            __( 'Auto WCAG', 'pau-universal-accessibility' ),                   //titulo del menu
            'manage_options',                  //capacidades (usuario actual)
            'pau-auto-wcag',                   //slug del menu o enlace
			[ $this, 'controlador_page_display_menu' ]     //la funcion a la que se llama al ejecutar
        );
        */

		/*---------submenu de WCAG ASISTANT ------------*/
		/*
		$this->build_menupage->add_submenu_page(
			'pau',                     //slug del padre
			__( 'WCAG assistant', 'pau-universal-accessibility' ),                  //titulo
			__( 'WCAG assistant', 'pau-universal-accessibility' ),                   //titulo del menu
			'manage_options',                  //capacidades (usuario actual)
			'pau-wcag-assistant',                   //slug del menu o enlace
			[ $this, 'controlador_page_display_menu' ]     //la funcion a la que se llama al ejecutar
		);
		*/

		/*---------submenu de HotSpots UA ------------*/
		$this->build_menupage->add_submenu_page(
			'pau',                     //slug del padre
			__( 'Hot Spots Universal Accessibility', 'pau-universal-accessibility' ),                //titulo
			__( 'Hot Spots UA', 'pau-universal-accessibility' ),               //titulo del menu
			'manage_options',                  //capacidades (usuario actual)
			'pau-hot-spots',                   //slug del menu o enlace
			[
				$this,
				'controlador_page_display_menu',
			]     //la funcion a la que se llama al ejecutar
		);

		/*---------submenu de ESTILOS ------------*/
		/*
		$this->build_menupage->add_submenu_page(
		   'pau',                     //slug del padre
			__( 'Styles of the different elements of PAU' , 'pau-universal-accessibility' ),                //titulo
			__( 'Styles', 'pau-universal-accessibility' ),               //titulo del menu
			'manage_options',                  //capacidades (usuario actual)
			'pau-styles',                   //slug del menu o enlace
			[ $this, 'controlador_page_display_menu' ]     //la funcion a la que se llama al ejecutar
		);
		*/
		/*---------submenu de IMPORTAR Y EXPORTAR ------------*/
		/*
        $this->build_menupage->add_submenu_page(
           'pau',                     //slug del padre
            __( 'Import and Export configuration and Accessibility', 'pau-universal-accessibility' ),                  //titulo
            __( 'Import & Export', 'pau-universal-accessibility' ),                   //titulo del menu
            'manage_options',                  //capacidades (usuario actual)
            'pau-import-export',                   //slug del menu o enlace
			[ $this, 'controlador_page_display_menu' ]     //la funcion a la que se llama al ejecutar
        );
        */

		/*---------submenu de Help ------------*/
		$this->build_menupage->add_submenu_page(
			'pau',                     //slug del padre
			__( 'Help About Manage PAU', 'pau-universal-accessibility' ),                  //titulo
			__( 'Help', 'pau-universal-accessibility' ),                   //titulo del menu
			'manage_options',                  //capacidades (usuario actual)
			'pau-help',                   //slug del menu o enlace
			[
				$this,
				'controlador_page_display_menu',
			]     //la funcion a la que se llama al ejecutar
		);

		/*---------submenu de support ------------*/
		$this->build_menupage->add_submenu_page(
			'pau',                     //slug del padre
			__( 'Support PAU by Inclusive Studio', 'pau-universal-accessibility' ),                  //titulo
			__( 'Support', 'pau-universal-accessibility' ),                   //titulo del menu
			'manage_options',                  //capacidades (usuario actual)
			'pau-support',                   //slug del menu o enlace
			[
				$this,
				'controlador_page_display_menu',
			]     //la funcion a la que se llama al ejecutar
		);

		/*---------submenu de Quienes Somos ------------*/
		$this->build_menupage->add_submenu_page(
			'pau',                     //slug del padre
			__( '¿Who is Inclusive Studio (Estudio Inclusivo, SLL) ?', 'pau-universal-accessibility' ),                  //titulo
			__( 'About us', 'pau-universal-accessibility' ),                   //titulo del menu
			'manage_options',                  //capacidades (usuario actual)
			'pau-about-us',                   //slug del menu o enlace
			[
				$this,
				'controlador_page_display_menu',
			]     //la funcion a la que se llama al ejecutar
		);

		$this->build_menupage->run();

	}


	/*----------------------------------- SUB MENU CARGA DE PAGINAS FUNCIONES -------------------------*/
	/**
	 * Controla las visualizaciones del menú
	 * en el área de administración
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	/*---------submenu de PRINCIPAL ------------*/
	public function controlador_page_display_menu() {
		$get_page = sanitize_text_field( $_GET[ 'page' ] );
		switch ( $get_page ) {

			case 'pau':
				require_once PAU_DIR_PATH . 'admin/partials/pau-admin-display.php';
				break;

			case 'pau-settings':
				require_once PAU_DIR_PATH . 'admin/partials/pau-settings-display.php';
				break;

			case 'pau-proveedores':
				require_once PAU_DIR_PATH . 'admin/partials/pau-suppliers-display.php';
				break;

			case 'pau-wordpress':
				require_once PAU_DIR_PATH . 'admin/partials/pau-wordpress-display.php';
				break;

			case 'pau-auto-wcag':
				require_once PAU_DIR_PATH . 'admin/partials/pau-auto-wcag-display.php';
				break;

			case 'pau-wcag-assistant':
				require_once PAU_DIR_PATH . 'admin/partials/pau-wcag-assistant-display.php';
				break;

			case 'pau-hot-spots':
				require_once PAU_DIR_PATH . 'admin/partials/pau-hotspots-display.php';
				break;

			case 'pau-styles':
				require_once PAU_DIR_PATH . 'admin/partials/pau-styles-display.php';
				break;

			case 'pau-import-export':
				require_once PAU_DIR_PATH . 'admin/partials/pau-import-export-display.php';
				break;

			case 'pau-help':
				require_once PAU_DIR_PATH . 'admin/partials/pau-help-display.php';
				break;

			case 'pau-support':
				require_once PAU_DIR_PATH . 'admin/partials/pau-support-display.php';
				break;

			case 'pau-about-us':
				require_once PAU_DIR_PATH . 'admin/partials/pau-about-us-display.php';
				break;

		}

	}

	private function getTitleMenuPage( $nameImg ) {

		$locale = apply_filters( 'plugin_locale', is_admin() ? get_user_locale() : get_locale(), "pau-universal-accessibility" );

		$output = "
                <div class=\"pauAdminPageTitle\">
            		<img src=\"" . PAU_DIR_URL . "admin/img/menus/$nameImg\" alt=\"\">
        			<h1 class='abouTitle pauAdminTitleH1'>" . esc_html( get_admin_page_title() ) . "</h1>
        		</div>
                ";

		return $output;

	}

	public function ajax_lang() {

		check_ajax_referer( 'pau_seg', 'nonce' );

		if ( current_user_can( 'manage_options' ) ) {
			$post_lang = sanitize_text_field( $_POST[ "lang" ] );
			$post_action = sanitize_text_field( $_POST[ "action" ] );
			if ( isset( $post_action ) && isset( $post_lang ) ) {

				$options = "<option value=''></option>";

				$options .= $this->helpers->getOptions( $this->wpml->getOptionsPage( $post_lang ) );

				$data = [
					"output" => $this->helpers->cleanerText( $options ),
				];

				echo json_encode( $data );

				wp_die();

			}

		}

	}

	public function is_64bits() {

		if ( function_exists( 'decbin' ) ) {

			$bits = strlen( decbin( ~0 ) );

			if ( $bits === 64 ) {
				return true;
			}

			return false;

		}

		if ( PHP_INT_SIZE === 8 ) {
			return true;
		}

		return false;

	}

}
/*-------------------------------fin---- SUB MENU CARGA DE PAGINAS FUNCIONES -------------------------*/
