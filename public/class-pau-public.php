<?php

/**
 * La funcionalidad específica de administración del plugin.
 *
 * @link       https://estudioinclusivo.com
 * @since      1.0.0
 *
 * @package    plugin_name
 * @subpackage plugin_name/admin
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
class PAU_Public {

	/**
	 * El identificador único de éste plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    plugin_name  El nombre o identificador único de éste plugin
	 */
	private $plugin_name;

	/**
	 * Versión actual del plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version La versión actual del plugin
	 */
	private $version;

	/**
	 * @param string $plugin_pau nombre o identificador único de éste plugin.
	 * @param string $version    La versión actual del plugin.
	 */
	public function __construct( $plugin_pau, $version ) {

		$this->plugin_name = $plugin_pau;
		$this->version     = $version;

	}

	/**
	 * Registra los archivos de hojas de estilos del área de administración
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function enqueue_styles() {

		/**
		 * Una instancia de esta clase debe pasar a la función run()
		 * definido en PAU_Cargador como todos los ganchos se definen
		 * en esa clase particular.
		 *
		 * El PAU_Cargador creará la relación
		 * entre los ganchos definidos y las funciones definidas en este
		 * clase.
		 */

		$pathMainCss = $this->getMainReact( "/^main\..+\.css$/", PAU_DIR_PATH . 'public/build/static/css/' );

		wp_enqueue_style( 'pau-pulpo', PAU_DIR_URL . 'public/build/static/css/' . $pathMainCss, [], $this->version, 'all' );

		wp_enqueue_style( 'pau-toastmessage-css', PAU_DIR_URL . 'helpers/jquery-toastmessage/src/main/resources/css/jquery.toastmessage.css', [], $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name, PAU_DIR_URL . 'public/css/pau-public.css', [], $this->version, 'all' );

		wp_enqueue_style( 'dashicons' );

		if ( isset( $_GET[ 'paumode' ] ) ) {

			$id_hotspots = sanitize_text_field( $_GET[ 'id_hotspots' ] );
			$id_page     = sanitize_text_field( $_GET[ 'preview_id' ] ?? 0 );
			$paumode     = sanitize_text_field( $_GET[ 'paumode' ] );

			if ( $paumode == 'asignacion' ) {

				if ( ! is_user_logged_in() && ! current_user_can( "magane_option" ) ) {
					// ...
					return;
				}

				wp_enqueue_style( 'pau-asignacion-css', PAU_DIR_URL . 'public/css/pau-asignacion.css' );

			}

		}

	}

	/**
	 * Registra los archivos Javascript del área de administración
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function enqueue_scripts() {

		/**
		 * Una instancia de esta clase debe pasar a la función run()
		 * definido en PAU_Cargador como todos los ganchos se definen
		 * en esa clase particular.
		 *
		 * El PAU_Cargador creará la relación
		 * entre los ganchos definidos y las funciones definidas en este
		 * clase.
		 */

		if ( is_admin() ) {
			return;
		}

		$request_uri  = $_SERVER[ "REQUEST_URI" ];
		$query_string = $_SERVER[ "QUERY_STRING" ];

		if (
			preg_match( "/so_css_preview/", $request_uri ) ||
			preg_match( "/so_css_preview/", $query_string )
		) {
			return;
		}

		wp_enqueue_script( 'jquery-ui-droppable' );

		//damos de alta js de REACT para PAU_Cargador
		wp_enqueue_script( 'pau-service-worker-js', PAU_DIR_URL . 'public/build/service-worker.js', [ 'jquery' ], $this->version, true );

		wp_enqueue_script( 'pau-toastmessage-js', PAU_DIR_URL . 'helpers/jquery-toastmessage/src/main/javascript/jquery.toastmessage.js', [ 'jquery' ], $this->version, true );

		wp_enqueue_script( $this->plugin_name, PAU_DIR_URL . 'public/js/pau-public.js', [ 'jquery' ], $this->version, true );

		$pathMainJs = $this->getMainReact( "/^main\..+\.js/", PAU_DIR_PATH . 'public/build/static/js/' );

		wp_enqueue_script( 'pau-pulpo-js', PAU_DIR_URL . 'public/build/static/js/' . $pathMainJs, [ 'jquery' ], $this->version, true );

		$pauPageID = get_the_ID();
		

		$is_administrator = "0";

		$user = wp_get_current_user();

		if ( is_user_logged_in() && in_array( "administrator", (array) $user->roles ) ) {
			$is_administrator = "1";
		}

		$siteurl = get_site_url();

		wp_localize_script(
			$this->plugin_name,
			'pau',
			[
				'translate'    => [
					'choosediversity'          => __( 'Choose your DIVERSITY profile', 'pau-universal-accessibility' ),
					'defaultdiversity'         => __( 'Default', 'pau-universal-accessibility' ),
					'visualdiversity'          => __( 'Visual diversity', 'pau-universal-accessibility' ),
					'auditivediversity'        => __( 'Auditive diversity', 'pau-universal-accessibility' ),
					'cognitivediversity'       => __( 'Cognitive Diversity', 'pau-universal-accessibility' ),
					'continue'                 => __( 'Continue', 'pau-universal-accessibility' ),
					'increasesizepau'          => __( 'Increase the size of PAU', 'pau-universal-accessibility' ),
					'increasedsizepau'         => __( 'You have increased the size of PAU', 'pau-universal-accessibility' ),
					'decreasesizepau'          => __( 'Decrease the size of PAU', 'pau-universal-accessibility' ),
					'setpositionpau'           => __( 'Set position of PAU', 'pau-universal-accessibility' ),
					'sendsleeppau'             => __( 'Send to sleep to PAU', 'pau-universal-accessibility' ),
					'paugosleep'               => __( 'You have sent PAU to sleep', 'pau-universal-accessibility' ),
					'returndefaultprofile'     => __( 'Return to default profile', 'pau-universal-accessibility' ),
					'returneddefaultprofile'   => __( 'You have returned to the default profile', 'pau-universal-accessibility' ),
					'choosevisualdiversity'    => __( 'Choose the VISUAL DIVERSITY profile', 'pau-universal-accessibility' ),
					'selectedvisualdiversity'  => __( 'You have selected the VISUAL DIVERSITY profile', 'pau-universal-accessibility' ),
					'choosehearingdiversity'   => __( 'Choose the HEARING DIVERSITY profile', 'pau-universal-accessibility' ),
					'selectedhearingdiversity' => __( 'You have selected the HEARING DIVERSITY profile', 'pau-universal-accessibility' ),
					'deactivatedpaupanel'      => __( 'You have deactivated the PAU panel', 'pau-universal-accessibility' ),
				],
				'url'          => [
					'admin'           => admin_url( 'admin-ajax.php' ),
					'dir_path'        => PAU_DIR_PATH,
					'dir_url'         => PAU_DIR_URL,
					'multimedia'      => PAU_MULTIMEDIA,
					'multimedia_pau'  => PAU_MULTIMEDIA_PAU,
					'multimedia_user' => PAU_MULTIMEDIA_USER,
				],
				'pauMainAcces' => "<div data-siteurl='$siteurl' id=\"pauMainAcces\" data-paupageid=\"$pauPageID\" pau-is-administrator=\"$is_administrator\" data-url=\"" . PAU_DIR_URL . "\" data-license=\"$license\"></div>",
			]
		);

		/**
		 * Arrays con las traducciones de
		 * las secciones de ReactPau
		 */

		$profiles = [
			"init"               => __( "Profiles", "pau-universal-accessibility" ),
			"default"            => __( "Default", "pau-universal-accessibility" ),
			"visualDiversity"    => __( "Visual Diversity", "pau-universal-accessibility" ),
			"auditiveDiversity"  => __( "Auditive Diversity", "pau-universal-accessibility" ),
			"cognitiveDiversity" => __( "Cognitive Diversity", "pau-universal-accessibility" ),
			"custom"             => __( "Customed", "pau-universal-accessibility" ),
		];

		$general = [
			"init"                => __( "General", "pau-universal-accessibility" ),
			"showHideAll"         => __( "Show / Hide ALL", "pau-universal-accessibility" ),
			"activateGeralSound"  => __( "Activate Geral Sound.", "pau-universal-accessibility" ),
			"allLSEVideos"        => __( "All Sign Language Videos", "pau-universal-accessibility" ),
			"readingSoundContent" => __( "Reading or sound content", "pau-universal-accessibility" ),
		];

		$navigation = [
			"init"        => __( "Navigation", "pau-universal-accessibility" ),
			"largeCursor" => __( "Large cursor", "pau-universal-accessibility" ),
			"clickSound"  => __( "Click sound", "pau-universal-accessibility" ),
			"showWhere"   => __( "Show where you are", "pau-universal-accessibility" ),
			"zoomLinks"   => __( "Zoom in on links", "pau-universal-accessibility" ),
		];

		$fonts = [
			"init"           => __( "Fonts", "pau-universal-accessibility" ),
			"fontSize"       => __( "Font size (1 - 9 em)", "pau-universal-accessibility" ),
			"readable"       => __( "Readable", "pau-universal-accessibility" ),
			"dyslexia"       => __( "Dyslexia", "pau-universal-accessibility" ),
			"highlightLinks" => __( "Highlight links", "pau-universal-accessibility" ),
		];

		$visual = [
			"init"           => __( "Visual", "pau-universal-accessibility" ),
			"blackWhite"     => __( "Black/White", "pau-universal-accessibility" ),
			"invertColors"   => __( "Invert Colours", "pau-universal-accessibility" ),
			"selectionFocus" => __( "Highlight Focused", "pau-universal-accessibility" ),
		];

		$design = [
			"init"                 => __( "Design", "pau-universal-accessibility" ),
			"increasePanel"        => __( "Increase of the panel", "pau-universal-accessibility" ),
			"selPAUDesignTemplate" => __( "Select PAU Design Template", "pau-universal-accessibility" ),
			"selPositionPAU"       => __( "Select Position of the PAU", "pau-universal-accessibility" ),
		];

		$urlDomain = "https://estudioinclusivo.com";

		$help = [
			"init"              => __( "Help", "pau-universal-accessibility" ),
			"documentation"     => __( "Documentation", "pau-universal-accessibility" ),
			"documentationLink" => sprintf(
				__(
					"%s/products/panel-de-accesibilidad-universal/documentation-plugin-pau/?lang=en",
					"pau"
				),
				$urlDomain
			),
			"videos"            => __( "Videos", "pau-universal-accessibility" ),
			"support"           => __( "Support", "pau-universal-accessibility" ),
			"suggestions"       => __( "Suggestions", "pau-universal-accessibility" ),
			"suggestionsLink"   => sprintf(
				__(
					"%s/contacto/?lang=en",
					"pau"
				),
				$urlDomain
			),
		];

		$others = [
			"togo"       => __( "To go", "pau-universal-accessibility" ),
			"comingSoon" => __( "Coming Soon", "pau-universal-accessibility" ),
		];

		wp_localize_script(
			$this->plugin_name,
			"reactTranslate",
			[
				"profiles"   => $profiles,
				"general"    => $general,
				"navigation" => $navigation,
				"fonts"      => $fonts,
				"visual"     => $visual,
				"design"     => $design,
				"help"       => $help,
				"others"     => $others,
			]
		);

		if ( isset( $_GET[ 'paumode' ] ) ) {

			$pau_lang = get_locale();

			$pau_page_search = sanitize_text_field( $_GET[ "pau_search" ]  ?? 0 );
			$id_hotspots     = sanitize_text_field( $_GET[ 'id_hotspots' ] );
			$pau_page        = sanitize_text_field( $_GET[ 'pau_page' ]  ?? 0 );
			$id_page         = sanitize_text_field( $_GET[ 'preview_id' ] ?? 0 );
			$paumode         = sanitize_text_field( $_GET[ 'paumode' ] );

			if ( $paumode == 'asignacion' ) {

				$templateAsignacion = "
                <div id='selector'>
                    <div id='selector-top'></div>
                    <div id='selector-left'></div>
                    <div id='selector-right'></div>
                    <div id='selector-bottom'></div>
                </div>";

				wp_enqueue_script( 'pau-asignacion-js', PAU_DIR_URL . 'public/js/pau-asignacion.js', [ 'jquery' ], $this->version, true );

				$asignacion_html = "<div id='draggable' class='draggable row asignacion-content pauNoEventAssig' draggable='true'>
            		<div class='s12 red'>
                    " . sprintf( __( "The ID hotspot is: %d <br> Click on the element you want to select for the assignment and then save the assignment" ), $id_hotspots ) . "
                        <div id='pau-selector-view'>
                            <h3 style=\"display: inline-block;margin-right: 10px !important;\" >" . __( 'Object route', 'pau-universal-accessibility' ) . "</h3>
                            <h4 style=\"display: inline-block;margin-right: 10px !important;\" id='pauRute'></h4>
                            <h4 id='pauMsgConflicts'></h4>
                            <input type='hidden' id='pauDataPath' value=''>
                            <button class='btn-pau btn-pau-assig pau-hide' id='pauSaveAssigWithConflicts'>" . __( "Save assignment through text", "pau-universal-accessibility" ) . "</button>
                            <button class='btn-pau btn-pau-assig pau-hide' id='pauSaveAssig'>" . __( "Save assignment", "pau-universal-accessibility" ) . "</button>
                            <button class='btn-pau btn-pau-assig pau-hide' id='pauAssigConflicts'>" . __( "See conflicts", "pau-universal-accessibility" ) . "</button>
                            <br>
                        </div>
                	</div>
                    <div id='pauAssigModal' class='pau-hide pauNoEventAssig'>
                        <div class='pauAssigContent'>
                            <p id='pauMsg'>
                                " . __( "Test message", "pau-universal-accessibility" ) . "
                            </p>
                        </div>
                        <div class='pauAssigFooter'>
                            <button id='pauClose'>" . __( "1) Close", "pau-universal-accessibility" ) . "</button>
                            <a class='btn-pau btn-pau-assig' style='color:white;' href='" . get_edit_post_link( $id_page ) . "' id='pauEditPage' target='_blank' style='display: inline-flex;'>" . __( "2) Edit page", "pau-universal-accessibility" ) . "</a>
                        </div>
                    </div>
                	";

				wp_localize_script(
					'pau-asignacion-js',
					'asignacion',
					[
						'pau_lang'           => "&pau_lang=$pau_lang",
						'id_hotspots'        => $id_hotspots,
						'pau_page'           => $pau_page,
						'pau_page_search'    => $pau_page_search,
						'id_page'            => $id_page,
						'html'               => PAU_Helpers::cleanerText( $asignacion_html ),
						'selectorAsignacion' => PAU_Helpers::cleanerText( $templateAsignacion ),
						'siteUrl'            => PAU_SITE_URL,

						'translate' => [
							'conflictroute'          => __( 'The route you selected has a conflict, click on the button see conflict below.', 'pau-universal-accessibility' ),
							'objectnounique'         => __( 'The object to which you have clicked, does not have a unique identifier that allows us to assign the Hots Post correctly, we recommend adding a unique Identifier to the element you are selecting, you can click on the edit page button, to put a unique identifier to the objects in conflicts.', 'pau-universal-accessibility' ),
							'conflict'               => __( 'Conflict', 'pau-universal-accessibility' ),
							'repeatobject1'          => __( 'The object that you have clicked on a route that refers to', 'pau-universal-accessibility' ),
							'repeatobject2'          => __( 'objects.', 'pau-universal-accessibility' ),
							'repeatobject3'          => __( 'You have 2 solutions: ', 'pau-universal-accessibility' ),
							'solution1'              => __( '1 - Easy: Close this window and you will find a button that says Save Assignment taking into account the text. Pressured and ready.', 'pau-universal-accessibility' ),
							'solution2'              => __( '2 - Better: We recommend adding a unique Identifier to the element you are selecting, you can click on the edit page button, to put a unique identifier to the objects in conflicts.', 'pau-universal-accessibility' ),
							'saveassignment'         => __( 'Save assignment', 'pau-universal-accessibility' ),
							'saveassignmenthelp'     => __( 'The object you selected does not have an identifier, please click on the button see conflicts.', 'pau-universal-accessibility' ),
							'saveassignmenttext'     => __( 'Save assignment through text', 'pau-universal-accessibility' ),
							'saveassignmenttexthelp' => __( 'The object you selected does not have any identifier, please click on the button see conflicts.', 'pau-universal-accessibility' ),
						],
					]
				);

			}

		}

	}

	public function getMainReact( $er, $path ) {

		$arrPath = array_diff( scandir( $path ), [
			'.',
			'..',
		] );
		$getPath = preg_grep( $er, $arrPath );

		return current( $getPath );

	}

	public function cargaContenedorVideoLSE2() {

		$output = "
        <div id='LocucionLSE'>
            <div id='buttonbar'>
                <button id='playVideo' style='visibility: visible;'>&#124;&#124;</button>
            </div>
            <button id='playVideo' title='Play / Stop' style='visibility: visible;'>&#124;&#124;</button>
            <button id='PantallaCompleta' title='" . __( 'Fullscreen', 'pau-universal-accessibility' ) . "' style='visibility: visible;'>&#91;&#32;&#32;&#93;</button>
            <button id='CierraVideo' title='" . __( 'Close', 'pau-universal-accessibility' ) . "' style='visibility: visible;'>X</button></div>
            <div id='video-controls'>
                <input type='range' id='seek-bar' title='" . __( 'Position', 'pau-universal-accessibility' ) . "' value='0'>" . __( 'Position', 'pau-universal-accessibility' ) . "</input>
                <input type='range'  id='volume-bar' title='" . __( 'Volume', 'pau-universal-accessibility' ) . "' min='0' max='1' step='0.1' value='1'>" . __( 'Volume', 'pau-universal-accessibility' ) . "</input>
            </div>
        </div>";

		return $output;

	}

	public function pauCompleto() {

		$output = "

            <div id='PauCompleto' class='dragable'>
                <div id='logoPauAppDiv'>
                    <div id='BarraPauApp'>
                    <nav id='pau-navigation' class='pau-navigation' role='navigation' aria-label='PAU'>
                        <ul id='MenuBarraPauApp'>
                            <li>
                                <a id='ZommMasPauBtn' class='dashicons dashicons-plus'></a>
                            </li>
                            <li>
                                <a id='ZommMenosPauBtn' class='dashicons dashicons-minus'></a>
                            </li>
                            <li class='MenuBarraPauAppIzq2'>
                                <a id='FijarPauBtn' class='dashicons dashicons-admin-post'></a>
                            </li>
                            <li class='MenuBarraPauAppIzq1'>
                                <a id='CerrarPauBtn' class='dashicons dashicons-dismiss'></a>
                            </li>
                        </ul>
                    </nav>
                    </div>

                    <div id='logoPauAppFondo'>
                        <div id='CaraPauInteractiva'>

                            <div id='CascosPauInteractiva'>
                                <img id='CascosBtn' class='cabezaPauBtn' src='" . PAU_MULTIMEDIA . "pau/img/componentes/cascos.png'>
                            </div>
                            <div id='GafasPauInteractiva'>
                                <img id='GafasBtn' class='ojosPauBtn' src='" . PAU_MULTIMEDIA . "pau/img/componentes/Gafas_sol.png'>
                            </div>

                            <div id='OjosPauInteractiva'>
                                <img id='OjosPauIzqBtn'  class='ojosPauBtn' src='" . PAU_MULTIMEDIA . "pau/img/componentes/ojo_izquierdo.png'>
                                <img id='OjosPauDechBtn'  class='ojosPauBtn' src='" . PAU_MULTIMEDIA . "pau/img/componentes/ojo_derecho.png'>
                            </div>

                            <div id='BocaPauInteractiva'>
                                <img id='BocaPauBtn' class='boca' src='" . PAU_MULTIMEDIA . "pau/img/componentes/boca_alegre.png'>
                            </div>

                        </div>
                        <img id='logoPauAppImg'  class='cuerpoPauBtn' src='" . PAU_MULTIMEDIA . "pau/img/componentes/PAU_sin_brazos.png'>

                        <div id='BrazosPauInteractiva'>
                            <img id='BrazoIzquierdoImg' class='brazosPauBtn' src='" . PAU_MULTIMEDIA . "pau/img/componentes/Brazo_izquierdo.png'>
                            <img id='BrazoDerechoImg' class='brazosPauBtn' src='" . PAU_MULTIMEDIA . "pau/img/componentes/Brazo_derecho.png'>
                        </div>

                    </div>
                </div>

                <div id='DesplegablePau'>
                    <noscript>You need to enable JavaScript to run PAU.</noscript>
                    <div id='Pauapp' class='panel-no-activo'></div>
                </div>
            </div>

        ";

		// {$this->cargaContenedorVideoLSE2()}

		return $output;

	}

	public function the_breadcrumb( $content ) {

		//echo 'entra en breadcrumb ';
		$showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$delimiter   = '&raquo;'; // delimiter between crumbs
		$home        = __( 'Home' ); // text for the 'Home' link
		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$before      = '<span class="current">'; // tag before the current crumb
		$after       = '</span>'; // tag after the current crumb

		$breakcrumb = "";

		global $post;
		$homeLink = get_bloginfo( 'url' );

		if ( is_home() || is_front_page() ) {

			if ( $showOnHome == 1 ) {
				$breakcrumb .= '<div id="pauDonde">' . __( "You are in: ", "pau-universal-accessibility" ) . '<a href="' . $homeLink . '">' . $home . '</a></div>';
			}

		} else {

			$breakcrumb .= '<div id="pauDonde"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

			if ( is_category() ) {

				$thisCat = get_category( get_query_var( 'cat' ), false );

				if ( $thisCat->parent != 0 ) {
					$breakcrumb .= get_category_parents( $thisCat->parent, true, ' ' . $delimiter . ' ' );
				}

				$breakcrumb .= $before . __( "Archive by category: ", "pau-universal-accessibility" ) . ' "' . single_cat_title( '', false ) . '"' . $after;

			} elseif ( is_search() ) {

				$breakcrumb .= $before . __( "Search results for: ", "pau-universal-accessibility" ) . '"' . get_search_query() . '"' . $after;

			} elseif ( is_day() ) {

				$breakcrumb .= '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
				$breakcrumb .= '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a> ' . $delimiter . ' ';
				$breakcrumb .= $before . get_the_time( 'd' ) . $after;

			} elseif ( is_month() ) {

				$breakcrumb .= '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
				$breakcrumb .= $before . get_the_time( 'F' ) . $after;

			} elseif ( is_year() ) {

				$breakcrumb .= $before . get_the_time( 'Y' ) . $after;

			} elseif ( is_single() && ! is_attachment() ) {

				if ( get_post_type() != 'post' ) {

					$post_type = get_post_type_object( get_post_type() );
					$slug      = $post_type->rewrite;

					$breakcrumb .= '<a href="' . $homeLink . '/' . $slug[ 'slug' ] . '/">' . $post_type->labels->singular_name . '</a>';

					if ( $showCurrent == 1 ) {
						$breakcrumb .= ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
					}

				} else {

					$cat  = get_the_category();
					$cat  = $cat[ 0 ];
					$cats = get_category_parents( $cat, true, ' ' . $delimiter . ' ' );

					if ( $showCurrent == 0 ) {
						$cats = preg_replace( "#^(.+)\s$delimiter\s$#", "$1", $cats );
					}

					$breakcrumb .= $cats;
					if ( $showCurrent == 1 ) {
						$breakcrumb .= $before . get_the_title() . $after;
					}

				}

			} elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {

				$post_type  = get_post_type_object( get_post_type() );
				$breakcrumb .= $before . $post_type->labels->singular_name . $after;

			} elseif ( is_attachment() ) {

				$parent = get_post( $post->post_parent );
				$cat    = get_the_category( $parent->ID );
				PAU_Helpers::ddlog( $parent, $cat );
				$cat = $cat[ 0 ] ?? "";

				if ( ! empty( $cat ) ) {

					$breakcrumb .= get_category_parents( $cat, true, ' ' . $delimiter . ' ' );
					$breakcrumb .= '<a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a>';

					if ( $showCurrent == 1 ) {
						$breakcrumb .= ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
					}

				}

			} elseif ( is_page() && ! $post->post_parent ) {

				if ( $showCurrent == 1 ) {
					$breakcrumb .= $before . get_the_title() . $after;
				}

			} elseif ( is_page() && $post->post_parent ) {

				$parent_id   = $post->post_parent;
				$breadcrumbs = [];

				while ( $parent_id ) {

					$page          = get_page( $parent_id );
					$breadcrumbs[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
					$parent_id     = $page->post_parent;

				}

				$breadcrumbs = array_reverse( $breadcrumbs );

				for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
					$breakcrumb .= $breadcrumbs[ $i ];
					if ( $i != count( $breadcrumbs ) - 1 ) {
						$breakcrumb .= ' ' . $delimiter . ' ';
					}
				}

				if ( $showCurrent == 1 ) {
					$breakcrumb .= " $delimiter " . get_the_title() . $after;
				}

			} elseif ( is_tag() ) {

				$breakcrumb .= $before . __( "Posts tagged: ", "pau-universal-accessibility" ) . '"' . single_tag_title( '', false ) . '"' . $after;

			} elseif ( is_author() ) {

				global $author;
				$userdata   = get_userdata( $author );
				$breakcrumb .= $before . __( "Articles posted by: ", "pau-universal-accessibility" ) . $userdata->display_name . $after;

			} elseif ( is_404() ) {
				$breakcrumb .= $before . __( "Error 404 ", "pau-universal-accessibility" ) . $after;
			}

			if ( get_query_var( 'paged' ) ) {

				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					$breakcrumb .= ' (';
				}
				$breakcrumb .= __( 'Page' ) . ' ' . get_query_var( 'paged' );
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					$breakcrumb .= ')';
				}

			}

			$breakcrumb .= '</div>';

		}

		$content = "$breakcrumb <br> $content";

		return $content;

	} // end the_breadcrumb()

}
