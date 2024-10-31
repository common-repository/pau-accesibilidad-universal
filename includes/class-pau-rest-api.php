<?php

class PAU_REST_API {

    public function init( $server ) {

        $namespace = "/pau/v1";

        // Pau Activate Default
    	$server->register_route( $namespace, "$namespace/pau_activate", array(
    		'methods' => 'GET',
    		'callback' => [ $this, 'pau_activate' ],
    	));

        //un Au hotspot by ID
        $server->register_route( $namespace, "$namespace/hotspot/(?P<id>)", array(
    		'methods' => 'GET',
    		'callback' => [ $this, 'dameHotSpot' ],
    	));

    	//todos los AU hotSpots
    	$server->register_route( $namespace, "$namespace/hotspots", array(
    		'methods' => 'GET',
    		'callback' => [ $this, 'dameHotSpotS' ],
    	));
        //un Au hotspot by ID
        $server->register_route( $namespace, "$namespace/hotspots/page/(?P<page>[a-zA-Z0-9-]+)", array(
            'methods' => 'GET',
            'callback' => [ $this, 'dameHotSpotPage' ],
        ));

    	//Configuracion por defecto de pau segun admin
    	$server->register_route( $namespace, "$namespace/config", array(
    		'methods' => 'GET',
    		'callback' => [ $this, 'damePAUconfig' ],
    	));

    	//Pasmamos defines o variables globales
    	$server->register_route( $namespace, "$namespace/global", array(
    		'methods' => 'GET',
    		'callback' => [ $this, 'dameGlobalPAU' ],
    	));


    }

    public function pau_activate() {

    	$pau_data = get_option( 'pau_default_data' )[ "settings" ];
        $pau_activate = false;

        if( array_key_exists( "pau_activate_default", $pau_data ) ) {
            if( $pau_data[ "pau_activate_default" ][ "value" ] === "on" ) {
                $pau_activate = true;
            }
        }

        $json = [
            "pau_activate" => $pau_activate
        ];

    	return rest_ensure_response( $json );

    }

    public function dameHotSpot( $data ) {

    	global $wpdb;
    	$myHotSpot = $wpdb->get_row( "SELECT *
    								FROM " . PAU_HOTSPOTS_TABLE . "
    								WHERE id=" . $data['id'] . ";"
    								,  ARRAY_A);

    	return rest_ensure_response($myHotSpot);

    }

    public function dameHotSpotS() {

    	global $wpdb;

		$sql = "SELECT *
				FROM " . PAU_HOTSPOTS_TABLE . "
                WHERE type <> 'contenido'
				";
		$result = $wpdb->get_results( $sql );

		return rest_ensure_response( $result );

    }

    public function dameHotSpotPage( $data ) {

    	global $wpdb;
        // $pageVals = explode( "-", $data['page'] );

        // $id_page  = (int) $pageVals[ 0 ];
        // $lang     = $pageVals[ 1 ];

        $id_page = $data[ 'page' ];

        $sql = "SELECT *
                FROM " . PAU_HOTSPOTS_TABLE . "
				WHERE page='$id_page'";

    	$myHotSpot = $wpdb->get_results( $sql );

    	return rest_ensure_response( $myHotSpot );

    }

    //-----------------------PAU REST API SETTINGS -------------------------------//
    public function damePAUconfig() {

    	//echo 'entra damePAUconfig -';
    	global $wpdb;
    	//$PAUconfig = get_option('pau_default_data', ARRAY_N);
    	$PAUconfig = get_option('pau_default_data');
    	//var_dump($PAUconfig);
    	//return wp_json_encode($PAUconfig);
    	return rest_ensure_response( $PAUconfig );

    }

    //-----------------------PAU REST API GLOBALS -------------------------------//
    public function dameGlobalPAU() {


    	global $wpdb;

    	$pau_urlDomain = get_site_url();

    	$globalPAU = array(
			"pau_RealpathBasenameplugin"   => PAU_REALPATH_BASENAME,
			"pau_PluginDirPath"            => PAU_REALPATH_BASENAME,
			"pau_PluginDomain"             => parse_url( $pau_urlDomain, PHP_URL_HOST ),
			"pau_PluginDirUrl"             => PAU_DIR_URL,
			"pau_HotspotsTable"            => PAU_HOTSPOTS_TABLE,
			"pau_PluginMultimedia"         => PAU_MULTIMEDIA,
			"pau_PluginMultimediaPau"      => PAU_MULTIMEDIA_PAU,
			"pau_PluginMultimediaUser"     => PAU_MULTIMEDIA_USER
		);

    	return rest_ensure_response( $globalPAU );

    }

}
