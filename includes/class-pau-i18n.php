<?php

/**
 * Define la funcionalidad de internacionalización
 *
 * Carga y define los archivos de internacionalización de este plugin para que esté listo para su traducción.
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
class PAU_i18n {

    /**
	 * Carga el dominio de texto (textdomain) del plugin para la traducción.
	 *
     * @since    1.0.0
     * @access public static
	 */
    public function load_plugin_textdomain() {

        $locale = apply_filters( "plugin_locale", get_locale(), "pau-universal-accessibility" );
        load_textdomain( "pau", PAU_DIR_PATH . 'languages/pau-' . $locale . '.mo'  );

        load_plugin_textdomain(
            'pau',
            false,
            PAU_DIR_PATH . 'languages/'
        );

    }

}
