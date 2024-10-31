<?php

/**
 * Se activa en la desactivación del plugin
 *
 * @link       https://estudioinclusivo.com
 * @since      1.0.0
 *
 * @package    pau
 * @subpackage pau/includes
 */

/**
 * Ésta clase define todo lo necesario durante la desactivación del plugin
 *
 * @since      1.0.0
 * @package    pau
 * @subpackage pau/includes
 * @author     Estudio Inclusivo <admin@estudioinclusivo.com>
 */

class PAU_Deactivator {

	/**
	 * Método estático
	 *
	 * Método que se ejecuta al desactivar el plugin
	 *
	 * @since 1.0.0
     * @access public static
	 */
	public static function deactivate() {

        flush_rewrite_rules();

	}

}
