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
 * Ésta clase define todo lo necesario para
 * obtener el status de las licencias
 *
 * @since      1.0.0
 * @package    pau
 * @subpackage pau/includes
 * @author     Estudio Inclusivo <admin@estudioinclusivo.com>
 */

class Pau_License {

    private $http;

    public function __construct() {
        $this->http = new WP_Http;
    }

    public function getStatus( $license ) {

        $ssl = isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] == 'on' ? true : false;

        $url = "://" . $_SERVER[ "HTTP_HOST" ];

        if( isset( $_SERVER[ "REQUEST_SCHEME" ] ) ) {
            $url = $_SERVER[ "REQUEST_SCHEME" ] . $url;
        } else {
            $s = $ssl ? "s" : "";
            $url = "http$s$url";
        }

        $args = [ "headers" => [ "referer" => $url ] ];

        $response = $this->http->get( PAU_Helpers::get_link_validate_license( $license ), $args );

        $json = false;

        if( ! is_wp_error( $response ) ) $json = json_decode( $response[ "body" ] );

        return $json;

    }

}
