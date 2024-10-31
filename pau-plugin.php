<?php
/**
 * Archivo del plugin
 * Este archivo es leído por WordPress para generar la información del plugin
 * en el área de administración del complemento. Este archivo también incluye
 * todas las dependencias utilizadas por el complemento, registra las funciones
 * de activación y desactivación y define una función que inicia el complemento.
 *
 */
/**
* @package  PAU, Universal Accessibility
 * @author    Inclusive Studio <info@estudioinclusivo.com>
 * @license   GPL-2.0+
 * @link      https://inclusivestudio.com
 * @copyright 2019 Estudio Inclusivo, S.L.L.
 *
 * @wordpress-plugin
 * Plugin Name:       PAU, Universal Accessibility
 * Plugin URI:        https://inclusivestudio.com
 * Description:       Add to your WordPress a panel with universal accessibility tools without the need for programming: Pictograms, sign language, audios, visual aids, keyboard navigation, zooms, fonts, large pointer, etc. It’s completely customisable by the web administrator and each user or visitor has specific pre-configurations for cognitive, auditory and visual profiles.
 * Version:           1.0.0
 * Author:            Inclusive Studio (Estudio Inclusivo, S.L.L.)
 * Author URI:        https://inclusivestudio.com
 * Text Domain:       pau-universal-accessibility
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/estudioinclusivo/pau
 */

// If this file is called directly, abort.

if ( ! defined( 'WPINC' ) ) {
	die;
}
global $wpdb, $helpers, $pauconfig, $pau_wpml, $separator;

$separator = DIRECTORY_SEPARATOR;

define( 'PAU_REALPATH_BASENAME', dirname( plugin_basename( __FILE__ ) ) );
define( 'PAU_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'PAU_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'PAU_HOTSPOTS_TABLE', $wpdb->prefix .'pau_hotspots' );
define( 'PAU_MULTIMEDIA', PAU_DIR_URL . 'multimedia/' );
define( 'PAU_MULTIMEDIA_PAU', PAU_DIR_URL . 'multimedia/pau/' );
define( 'PAU_SITE_URL', get_site_url() );
define( 'PAU_PAGE_ON_FRONT_ID', get_option( 'page_on_front' ) );
define( 'PAU_PAGE_FOR_POSTS_ID', get_option( 'page_for_posts' ) );
define( 'PAU_SHOW_ON_FRONT', get_option( 'show_on_front' ) );
define( 'PAU_MULTIMEDIA_USER', PAU_DIR_URL . 'multimedia/' . parse_url( PAU_SITE_URL, PHP_URL_HOST ) . '/' );
define( 'PAU_MULTIMEDIA_USER_PATH', PAU_DIR_PATH . 'multimedia/' . parse_url( PAU_SITE_URL, PHP_URL_HOST ) . '/' );

/**
 * Código que se ejecuta en la activación del plugin
 */
function activate_pau() {
    require_once PAU_DIR_PATH . 'includes/class-pau-activator.php';
	PAU_Activator::activate();
}

/**
 * Código que se ejecuta en la desactivación del plugin , añadir flush_rewrite_rules()
 */
function deactivate_pau() {
    require_once PAU_DIR_PATH . 'includes/class-pau-deactivator.php';
	PAU_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pau' );
register_deactivation_hook( __FILE__, 'deactivate_pau' );
//register_uninstall_hook( __FILE__ , ' pau_uninstall');

/*if (! function_exists ('pau_uninstall') {
    function pau_uninstall (){

        //Accion a ejecutar
        flush_rewrite_rules();
        //Borrar tablas en la base de datos
        //quitar alguna configuracion
        //u opciones
    }
*/
/* HAY QUE añadir flush_rewrite_rules() y metodo para borrado de plugin

/*--------------------------------- empieza a ejecurase el plugin ------------------------------------*/

require_once PAU_DIR_PATH . 'includes/class-pau-master.php';

function run_pau_master() {
	global $pauconfig;
	$pauconfig 	= get_option( 'pau_default_data' );
    $pau_master = new PAU_Master;
    $pau_master->run();
}

run_pau_master();

// if( class_exists( "PAU_WPML" ) ) {
// 	var_dump( "Si existe" );
// } else {
// 	var_dump( "No existe" );
// }

// var_dump( $pau_wpml );

// PAU_Helpers::dump( $pauconfig );

/*si es de la parte publica metemos capa html para ejecutarse PAU despues de cargarse la pagina
ejemplo en https://codex.wordpress.org/Plugin_API/Action_Reference/wp_loaded
*/

add_action( 'wp_loaded','eipau_load_html' );
function eipau_load_html() {
	//COMPROBAMOS IDIOMA
	//sI EXISTE plugin WPML trabaja con idioma seleccionado de WPML
	if ( function_exists('ICL_LANGUAGE_CODE') ){
		//echo "<h2> SI EXISTE ICL_LANGUAGE_CODE= ".ICL_LANGUAGE_CODE."</h2>";
		$lenguaje_actual = ICL_LANGUAGE_CODE;
		//echo "<h2> SI EXISTE ICL_LANGUAGE_CODE= ".$lenguaje_actual."</h2>";
	} else { //si NO trabaja con idioma por defecto de WP
			$lenguaje_actual = get_locale();
			//echo '<h2> El idimoa de WP es '.$lenguaje_actual.' .</H2>';
	}
	//insertamos parametros
	//echo"<script type='text/javascript' src='/accesibilidad/parametros_".$lenguaje_actual.".js'></script>";

} //fin der funcion eipau_load_html
