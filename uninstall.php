<?php

/**
 * Se activa cuando el plugin va a ser desinstalado
 *
 * @link       https://estudioinclusivo.com
 * @since      1.0.0
 *
 * @package    pau
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( "pau_default_data" );

global $wpdb;
$sql = "DROP TABLE IF EXISTS {$wpdb->prefix}pau_hotspots";
$wpdb->query( $sql );
