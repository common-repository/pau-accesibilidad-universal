<?php

/**
 * El archivo que define la clase del cerebro principal del plugin
 *
 * Una definición de clase que incluye atributos y funciones que se
 * utilizan tanto del lado del público como del área de administración.
 *
 * @link       https://estudioinclusivo.com
 * @since      1.0.0
 *
 * @package    pau
 * @subpackage pau/includes
 */

/**
 * También mantiene el identificador único de este complemento,
 * así como la versión actual del plugin.
 *
 * @since      1.0.0
 * @package    pau
 * @subpackage pau/includes
 * @author     Estudio Inclusivo <admin@estudioinclusivo.com>
 *
 * @property object $cargador
 * @property string $plugin_pau
 * @property string $version
 */
class PAU_Master {

    /**
	 * El cargador que es responsable de mantener y registrar
     * todos los ganchos (hooks) que alimentan el plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      PAU_Cargador    $cargador  Mantiene y registra todos los ganchos ( Hooks ) del plugin
	 */
    protected $cargador;

    /**
	 * El identificador único de éste plugin
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_pau  El nombre o identificador único de éste plugin
	 */
    protected $plugin_pau;

    /**
	 * Instancia del objeto PAU_Settings para ejecutar
	 * ls configuraciones iniciales
     *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_pau  Instancia para iniciar las configuraciones
	 */
    protected $settings;

    /**
	 * Instancia del objeto PAU_REST_API
     *
	 * @since    1.0.0
	 * @access   protected
	 * @var      object    $rest_api  Instancia para iniciar los valores de configuración Rest API
	 */
    protected $rest_api;

    /**
	 * Instancia del objeto PAU_REST_API
     *
	 * @since    1.0.0
	 * @access   protected
	 * @var      object    $wpml  Instancia para iniciar los valores de configuración Rest API
	 */
    protected $wpml;

    /**
     * Versión actual del plugin
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version  La versión actual del plugin
	 */
    protected $version;

    /**
     * Constructor
     *
	 * Defina la funcionalidad principal del plugin.
	 *
	 * Establece el nombre y la versión del plugin que se puede utilizar en todo el plugin.
     * Cargar las dependencias, carga de instancias, definir la configuración regional (idioma)
     * Establecer los ganchos para el área de administración y
     * el lado público del sitio.
	 *
	 * @since    1.0.0
	 */
    public function __construct() {

        $this->plugin_name = 'pau';
        $this->version = '1.0.0';

        $this->cargar_dependencias();
        $this->set_vals_global();
        $this->cargar_instancias();
        $this->set_idiomas();
        $this->definir_admin_hooks();
        $this->definir_public_hooks();

    }

    /**
	 * Cargue las dependencias necesarias para este plugin.
	 *
	 * Incluya los siguientes archivos que componen el plugin:
	 *
	 * - PAU_Cargador. Itera los ganchos del plugin.
	 * - PAU_i18n. Define la funcionalidad de la internacionalización
	 * - PAU_Admin. Define todos los ganchos del área de administración.
	 * - PAU_Public. Define todos los ganchos del del cliente/público.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
    private function cargar_dependencias() {

        require_once PAU_DIR_PATH . 'includes/class-pau-helpers.php';
        require_once PAU_DIR_PATH . 'includes/class-pau-wpml.php';
        require_once PAU_DIR_PATH . 'includes/class-pau-formbuild.php';

        /**
		 * La clase responsable de iterar las acciones y filtros del núcleo del plugin.
		 */
        require_once PAU_DIR_PATH . 'includes/class-pau-cargador.php';

        /**
		 * La clase responsable de definir la funcionalidad de la
         * internacionalización del plugin
		 */
        require_once PAU_DIR_PATH . 'includes/class-pau-i18n.php';

        /* ---- edicion de javi-----*/

        /**
		 * La clase responsable de registrar menús y submenús
         * en el área de administración
		 */
        require_once PAU_DIR_PATH . 'includes/class-pau-build-menupage.php';

        /* --FIN -- edicion de javi-----*/

        /**
		 * La clase responsable de definir todas las acciones en el
         * área de administración
		 */
        require_once PAU_DIR_PATH . 'admin/class-pau-admin.php';

        /**
		 * La clase responsable de definir todas las acciones en el
         * área del lado del cliente/público
		 */
        require_once PAU_DIR_PATH . 'public/class-pau-public.php';

        /**
		 * La clase responsable de definir todas las configuraciones
         * del plugin n general
		 */
        require_once PAU_DIR_PATH . 'includes/class-pau-settings.php';

        /**
		 * La clase responsable de definir todas las configuraciones
         * en la Rest API
		 */
        require_once PAU_DIR_PATH . 'includes/class-pau-rest-api.php';



    }

    /**
	 * Defina la configuración regional de este plugin para la internacionalización.
     *
     * Utiliza la clase PAU_i18n para establecer el dominio y registrar el gancho
     * con WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
    private function set_idiomas() {

        $pau_i18n = new PAU_i18n();
        $this->cargador->add_action( 'plugins_loaded', $pau_i18n, 'load_plugin_textdomain' );

    }

    /**
	 * Cargar todas las instancias necesarias para el uso de los
     * archivos de las clases agregadas
	 *
	 * @since    1.0.0
	 * @access   private
	 */
    private function cargar_instancias() {

        // Cree una instancia del cargador que se utilizará para registrar los ganchos con WordPress.
        $this->cargador      = new PAU_cargador;
        $this->pau_admin     = new PAU_Admin( $this->get_plugin_name(), $this->get_version() );
        $this->pau_public    = new PAU_Public( $this->get_plugin_name(), $this->get_version() );
        $this->settings      = new PAU_Settings;
        $this->rest_api      = new PAU_REST_API;
        $this->wpml          = new PAU_WPML;

    }

    private function set_vals_global() {

        global $helpers, $pau_wpml;

        $helpers 	 = new PAU_Helpers;
    	$pau_wpml 	 = new PAU_WPML;

    }

    /**
	 * Registrar todos los ganchos relacionados con la funcionalidad del área de administración
     * Del plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
    private function definir_admin_hooks() {

        $this->cargador->add_action( 'admin_enqueue_scripts', $this->pau_admin, 'enqueue_styles' );
        $this->cargador->add_action( 'admin_enqueue_scripts', $this->pau_admin, 'enqueue_scripts' );

/* ------------------------------------------------------- EMPIEZA EDICION DE JAVI -----------------------------------------------------------*/

		$this->cargador->add_action( 'admin_menu', $this->pau_admin, 'add_menu' ); //registramos menus y submenus en un unico metodo

		$this->cargador->add_action( 'admin_init', $this->settings, 'init' );

		/** damos de alta el procedimiento ajax de hotspot
         * Primer paramaetro: wp_ajax_ + bcpg_crud_table nombre que aplicamos ne la accion en pau-admin.js line: 130 code: "data : {action: 'bcpg_crud_table',"
		 * 3ª parametro: se obtiene de la funcion a ejecutar donde apsamos los datos ajax a almacenar que es esta en class-pau-admin.php codee:"public function ajax_crud_table() {"
		*/

		$this->cargador->add_action( 'wp_ajax_pau_save_hostpots', $this->pau_admin, 'pau_save_hostpots' );

		$this->cargador->add_action( 'wp_ajax_pau_save_settings', $this->pau_admin, 'pau_save_settings' );

        

		$this->cargador->add_action( 'wp_ajax_pau_make_formats', $this->pau_admin, 'make_formats_ffmpeg' );

		$this->cargador->add_action( 'wp_ajax_pau_switch_lang', $this->pau_admin, 'ajax_lang' );

/* -- FIN ----------------------------------------------------- EMPIEZA EDICION DE JAVI -----------------------------------------------------------*/
    }

    /**
	 * Registrar todos los ganchos relacionados con la funcionalidad del área de administración
     * Del plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
    private function definir_public_hooks() {

        $this->cargador->add_action( 'wp_enqueue_scripts', $this->pau_public, 'enqueue_styles' );
        $this->cargador->add_action( 'wp_enqueue_scripts', $this->pau_public, 'enqueue_scripts' );

        $this->cargador->add_filter( 'the_content', $this->pau_public, 'the_breadcrumb' );

		$this->cargador->add_action( 'rest_api_init', $this->rest_api, 'init' );

    }

    /**
	 * Ejecuta el cargador para ejecutar todos los ganchos con WordPress.
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function run() {
        $this->cargador->run();
    }

	/**
	 * El nombre del plugin utilizado para identificarlo de forma exclusiva en el contexto de
     * WordPress y para definir la funcionalidad de internacionalización.
	 *
	 * @since     1.0.0
     * @access    public
	 * @return    string    El nombre del plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * La referencia a la clase que itera los ganchos con el plugin.
	 *
	 * @since     1.0.0
     * @access    public
	 * @return    PAU_Cargador    Itera los ganchos del plugin.
	 */
	public function get_cargador() {
		return $this->cargador;
	}

	/**
	 * Retorna el número de la versión del plugin
	 *
	 * @since     1.0.0
     * @access    public
	 * @return    string    El número de la versión del plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
