<?php

class PAU_Settings {

    protected $settings;

    /*--------------------------------------- AJUSTES DE PAU ---------------------------------------*/

    // registrando una nueva configuración en la página "general" o el slug del Menu o submenu al que pertenece
    //primer parametro mismo nombre que slug del menu o submenu al que pertenece

    public function init() {

        global $pauconfig;
        $this->settings = $pauconfig[ "settings" ];

		$args = [
			// 'sanitize_callback' => [ $this, 'pau_filtrando' ],
			'default' => 'Este nombre de opción no fue encontrado en la tabla de opciones'
		 ];

        register_setting( 'pau-settings', 'pau_default_data', $args );

	    // SECCION AJUSTES: Registrando una nueva sección en la página "general"
		add_settings_section(
			'pau_ajustes_section',      	//id
			'Ajustes de PAU',				//title
			[ $this, 'pau_ajustes_seccion_cb' ],		//Funcion callback
			'pau-settings' 					//pagina, poner nombre del slug del Menu o submenu
		 );
		// regsitando  campo PAU activado
		add_settings_field(
			'pau_activate_default',	//id
			'PAU activado por defecto',		//title
			[ $this, 'pau_activate_default_cb1' ],		//funcion callback
			'pau-settings',  				//pagina, poner nombre del slug del Menu o submenu
			'pau_ajustes_section',			//seccion a la que pertenece
											//argumentos con los atributos html del campo
			[
				'label_for' => 'pau_activate_default',
				'class' => 'clase_campo',
				'pau_dato_personalizado' => 'valor personalizado 1'
			 ]
		 );


	// SECCION CONFIG POR DEFECTO: Registrando una nueva sección en la página "general"
		add_settings_section(
			'pau_configuracion_section',      	//id
			'Configuracion por defecto de PAU',	//title
			[ $this, 'pau_configuracion_seccion_cb' ],		//Funcion callback
			'pau-settings' 					//pagina, poner nombre del slug del Menu o submenu
		 );
		// regsitando  campo zoom de PAU
		add_settings_field(
			'cg_zoom_pau_field',	//id
			'Zoom de PAU ( de 1 a 10 )',		//title
			[ $this, 'cg_zoom_pau_field_cb' ],		//funcion callback
			'pau-settings',  				//pagina, poner nombre del slug del Menu o submenu
			'pau_configuracion_section',			//seccion a la que pertenece
											//argumentos con los atributos html del campo
			[
				'label_for' => 'cg_zoom_pau',
				'class' => 'clase_campo',
				'pau_dato_personalizado' => 'cg_zoom_pau'
			 ]
		 );

		// regsitando  campo Perfil por defecto
		add_settings_field(
			'cg_perfil_defecto_field',	//id
			'Perfil por Defecto',		//title
			[ $this, 'cg_perfil_defecto_field_cb' ],		//funcion callback
			'pau-settings',  				//pagina, poner nombre del slug del Menu o submenu
			'pau_configuracion_section',			//seccion a la que pertenece
											//argumentos con los atributos html del campo
			[
				'label_for' => 'cg_perfil_defecto',
				'class' => 'clase_campo',
				'pau_dato_personalizado' => 'cg_perfil_defecto'
			 ]
		 );

		// registando  campo general todo
		add_settings_field(
			'cg_geral_todo_field',	//id
			'Mostrar / Ocultar TODO',		//title
			[ $this, 'cg_geral_todo_field_cb' ],		//funcion callback
			'pau-settings',  				//pagina, poner nombre del slug del Menu o submenu
			'pau_configuracion_section',			//seccion a la que pertenece
											//argumentos con los atributos html del campo
			[
				'label_for' => 'cg_geral_todo',
				'class' => 'clase_campo',
				'pau_dato_personalizado' => 'cg_geral_todo'
			 ]
		 );

		// registando  campo general sonido
		add_settings_field(
			'cg_geral_sonido_field',	//id
			'Activar Sonido Geral.',		//title
			[ $this, 'cg_geral_sonido_field_cb' ],		//funcion callback
			'pau-settings',  				//pagina, poner nombre del slug del Menu o submenu
			'pau_configuracion_section',			//seccion a la que pertenece
											//argumentos con los atributos html del campo
			[
				'label_for' => 'cg_geral_sonido',
				'class' => 'clase_campo',
				'pau_dato_personalizado' => 'cg_geral_sonido'
			 ]
		 );
		// regsitrando Leer-sonido de Pagina o contenido
		add_settings_field(
			'cg_geral_lectura_field',	//id
			'Lectura o sonido del contenido',		//title
			[ $this, 'cg_geral_lectura_field_cb' ],		//funcion callback
			'pau-settings',  				//pagina, poner nombre del slug del Menu o submenu
			'pau_configuracion_section',			//seccion a la que pertenece
											//argumentos con los atributos html del campo
			[
				'label_for' => 'cg_geral_lectura',
				'class' => 'clase_campo',
				'pau_dato_personalizado' => 'cg_geral_lectura'
			 ]
		 );
		// registrando todos los videos
		add_settings_field(
			'cg_geral_video',	//id
			'Todos los Videos de LSE',		//title
			[ $this, 'cg_geral_video_field_cb' ],		//funcion callback
			'pau-settings',  				//pagina, poner nombre del slug del Menu o submenu
			'pau_configuracion_section',			//seccion a la que pertenece
											//argumentos con los atributos html del campo
			[
				'label_for' => 'cg_geral_video',
				'class' => 'clase_campo',
				'pau_dato_personalizado' => 'cg_geral_video'
			 ]
		 );

		//------- Navegacion
		// registrando todos los videos
		add_settings_field(
			'cg_nav_clic',	//id
			'Sonido al clic',		//title
			[ $this, 'cg_nav_clic_field_cb' ],		//funcion callback
			'pau-settings',  				//pagina, poner nombre del slug del Menu o submenu
			'pau_configuracion_section',			//seccion a la que pertenece
											//argumentos con los atributos html del campo
			[
				'label_for' => 'cg_nav_clic',
				'class' => 'clase_campo',
				'pau_dato_personalizado' => 'cg_nav_clic'
			 ]
		 );

		// registrando Zoom sobre enlaces
		add_settings_field(
			'cg_nav_zoom',	//id
			'Zoom sobre enlaces',		//title
			[ $this, 'cg_nav_zoom_field_cb' ],		//funcion callback
			'pau-settings',  				//pagina, poner nombre del slug del Menu o submenu
			'pau_configuracion_section',			//seccion a la que pertenece
											//argumentos con los atributos html del campo
			[
				'label_for' => 'cg_nav_zoom',
				'class' => 'clase_campo',
				'pau_dato_personalizado' => 'cg_nav_zoom'
			 ]
		 );

		// registrando Mostrar donde estas
		add_settings_field(
			'cg_nav_donde',	//id
			'Mostrar donde estas',		//title
			[ $this, 'cg_nav_donde_field_cb' ],		//funcion callback
			'pau-settings',  				//pagina, poner nombre del slug del Menu o submenu
			'pau_configuracion_section',			//seccion a la que pertenece
											//argumentos con los atributos html del campo
			[
				'label_for' => 'cg_nav_donde',
				'class' => 'clase_campo',
				'pau_dato_personalizado' => 'cg_nav_donde'
			 ]
		 );
		//Fuentes y Tamaños
		// registrando Tamaño de fuente
		add_settings_field(
			'cg_font_size',	//id
			'Tamaño de fuente ( 1-10em )',		//title
			[ $this, 'cg_font_size_field_cb' ],		//funcion callback
			'pau-settings',  				//pagina, poner nombre del slug del Menu o submenu
			'pau_configuracion_section',			//seccion a la que pertenece
											//argumentos con los atributos html del campo
			[
				'label_for' => 'cg_font_size',
				'class' => 'clase_campo',
				'pau_dato_personalizado' => 'cg_font_size'
			 ]
		 );
		// registrando Fuente Legible
		add_settings_field(
			'cg_font_legible',	//id
			'Fuente Legible',		//title
			[ $this, 'cg_font_legible_field_cb' ],		//funcion callback
			'pau-settings',  				//pagina, poner nombre del slug del Menu o submenu
			'pau_configuracion_section',			//seccion a la que pertenece
											//argumentos con los atributos html del campo
			[
				'label_for' => 'cg_font_legible',
				'class' => 'clase_campo',
				'pau_dato_personalizado' => 'cg_font_legible'
			 ]
		 );

		// registrando Fuente Dixlesia
		add_settings_field(
			'cg_font_dixlesia',	//id
			'Fuente Dixlesia',		//title
			[ $this, 'cg_font_dixlesia_field_cb' ],		//funcion callback
			'pau-settings',  				//pagina, poner nombre del slug del Menu o submenu
			'pau_configuracion_section',			//seccion a la que pertenece
											//argumentos con los atributos html del campo
			[
				'label_for' => 'cg_font_dixlesia',
				'class' => 'clase_campo',
				'pau_dato_personalizado' => 'cg_font_dixlesia'
			 ]
		 );

		// registrando Resaltar Enlaces
		add_settings_field(
			'cg_font_resaltar_links',	//id
			'Resaltar Enlaces',		//title
			[ $this, 'cg_font_resaltar_links_field_cb' ],		//funcion callback
			'pau-settings',  				//pagina, poner nombre del slug del Menu o submenu
			'pau_configuracion_section',			//seccion a la que pertenece
											//argumentos con los atributos html del campo
			[
				'label_for' => 'cg_font_resaltar_links',
				'class' => 'clase_campo',
				'pau_dato_personalizado' => 'cg_font_resaltar_links'
			 ]
		 );
		//visuales
		// registrando Ver en Blanco y Negro
		add_settings_field(
			'cg_visual_bn',	//id
			'Ver en Blanco y Negro',		//title
			[ $this, 'cg_visual_bn_field_cb' ],		//funcion callback
			'pau-settings',  				//pagina, poner nombre del slug del Menu o submenu
			'pau_configuracion_section',			//seccion a la que pertenece
											//argumentos con los atributos html del campo
			[
				'label_for' => 'cg_visual_bn',
				'class' => 'clase_campo',
				'pau_dato_personalizado' => 'cg_visual_bn'
			 ]
		 );
		// registrando Invertir Colores
		add_settings_field(
			'cg_visual_rcolors',	//id
			'Invertir Colores',		//title
			[ $this, 'cg_visual_rcolors_field_cb' ],		//funcion callback
			'pau-settings',  				//pagina, poner nombre del slug del Menu o submenu
			'pau_configuracion_section',			//seccion a la que pertenece
			[ //argumentos con los atributos html del campo
				'label_for' => 'cg_visual_rcolors',
				'class' => 'clase_campo',
				'pau_dato_personalizado' => 'cg_visual_rcolors'
			 ]
		 );

		// registrando Resaltar Seleccion
		add_settings_field(
			'cg_visual_resaltar_focus',	//id
			'Resaltar Selección',		//title
			[ $this, 'cg_visual_resaltar_focus_field_cb' ],		//funcion callback
			'pau-settings',  				//pagina, poner nombre del slug del Menu o submenu
			'pau_configuracion_section',			//seccion a la que pertenece
											//argumentos con los atributos html del campo
			[
				'label_for' => 'cg_visual_resaltar_focus',
				'class' => 'clase_campo',
				'pau_dato_personalizado' => 'cg_visual_resaltar_focus'
			 ]
		 );
    }

    //filtrado de campos o validacion de campos de ajustes
    public function pau_filtrando( $valor ) {

    	//Ajustes

		$valor[ 'aj_pau_activate_default' ] = $valor[ 'aj_pau_activate_default' ];


	    //CONFIGURACION POR DEFECTO
		$valor[ 'cg_zoom_pau' ] = $valor[ 'cg_zoom_pau' ];
		//perfiles
		$valor[ 'cg_perfil_defecto' ] = $valor[ 'cg_perfil_defecto' ];
		//$valor[ 'cg_perfil_visual' ] = $valor[ 'cg_perfil_visual' ];
		//$valor[ 'cg_perfil_auditiva' ] = $valor[ 'cg_perfil_auditiva' ];
		//$valor[ 'cg_perfil_cognitiva' ] = $valor[ 'cg_perfil_cognitiva' ];

		//General
		$valor[ 'cg_geral_todo' ] = $valor[ 'cg_geral_todo' ];
		$valor[ 'cg_geral_sonido' ] = $valor[ 'cg_geral_sonido' ];
		$valor[ 'cg_geral_lectura' ] = $valor[ 'cg_geral_lectura' ];
		$valor[ 'cg_geral_video' ] = $valor[ 'cg_geral_video' ];

		//Navegacion
		$valor[ 'cg_nav_clic' ] = $valor[ 'cg_nav_clic' ];
		$valor[ 'cg_nav_zoom' ] = $valor[ 'cg_nav_zoom' ];
		$valor[ 'cg_nav_donde' ] = $valor[ 'cg_nav_donde' ];

		//Fuentes y Tamaños
		$valor[ 'cg_font_size' ] = $valor[ 'cg_font_size' ];
		$valor[ 'cg_font_legible' ] = $valor[ 'cg_font_legible' ];
		$valor[ 'cg_font_dixlesia' ] = $valor[ 'cg_font_dixlesia' ];
		$valor[ 'cg_font_resaltar_links' ] = $valor[ 'cg_font_resaltar_links' ];

		//visuales
		$valor[ 'cg_visual_bn' ] = $valor[ 'cg_perfil_visual' ];
		$valor[ 'cg_visual_rcolors' ] = $valor[ 'cg_visual_rcolors' ];
		$valor[ 'cg_visual_resaltar_focus' ] = $valor[ 'cg_visual_resaltar_focus' ];

		return $valor;

    }



    //------------------------------------------ html de campos de ajustes----------------------------------------------------------------
    public function pau_ajustes_seccion_cb( ) {

        // global $helpers, $pauconfig;

        // $helpers->dump( $pauconfig );

        echo "<p>En esta seccion encontraras la toda la configuracion relacionada con el comportamiento de PAU</p>";;
       // echo '<strong>DATOS DE LA ARRAY: </strong></BR>';
    	//var_dump( $mpconfig );
    }


    //---campo PAU activado----
    public function pau_activate_default_cb1( $args ) {

        $checked='';
        $checked_show='';

        if( isset( $this->settings[ 'pau_activate_default' ] ) )
            if( $this->settings[ 'pau_activate_default' ][ 'value' ] == 'on' ) $checked='checked';
            if( $this->settings[ 'pau_activate_default' ][ 'show' ] == 'on' ) $checked_show='checked';

        $html = "<input class='{$args[ 'class' ]}' id='{$args['label_for']}' type='checkbox' name='pau_default_data[settings][{$args['label_for']}][value]' $checked>

        <label for='{$args['label_for']}-show'>¿Mostrar?</label>
        <input class='{$args[ 'class' ]}' id='{$args['label_for']}-show' type='checkbox' name='pau_default_data[settings][{$args['label_for']}][show]' $checked_show>
        ";

        echo $html;

    }


    //------------------------------------html---SECCION CONFIGURACION POR DEFECTO ----------------------------------------------------

    public function pau_configuracion_seccion_cb( ) {
        echo "<p>En esta seccion se indicara la configuracion por defecto de activacion / desactivacion de ayudas de PAU</p>";
    }

    public function cg_zoom_pau_field_cb( $args ) {

        $valor = 5;

        if( isset( $this->settings[ 'cg_zoom_pau' ] ) )
            $valor = $this->settings[ 'cg_zoom_pau' ][ 'value' ];


        $html = "<input class='{$args[ 'class' ]}' data-custom='{$args[ 'pau_dato_personalizado' ]}' type='number' name='pau_default_data[settings][{$args[ 'label_for']}][value]'
    				min='1' max='10' value='$valor'>";

        echo $html;

    }
    // ------------------------------CAMPO rRADIO  DE PERFILES------------

    public function cg_perfil_defecto_field_cb( $args ) {

		$perfiles = array( "Por defecto" , "Diversidad Visual" , "Diversidad Auditiva", "Diversidad Cognitiva" );

		foreach ( $perfiles as $perfil ){

            $id = str_replace( " ", "-", strtolower( $perfil ) );

			$html = "</br><input id='$id' class='{$args[ 'class' ]}' data-custom='{$args[ 'pau_dato_personalizado' ]}' type='radio' name='pau_default_data[settings][{$args[ 'label_for' ]}][value]' value='$perfil'";

            if( isset( $this->settings[ 'cg_perfil_defecto' ][ 'value' ] ) )
                $html .= checked( $this->settings[ 'cg_perfil_defecto' ][ 'value' ], $perfil, false );

			$html .= "><label for='$id'>$perfil</label></br>";

			echo $html;

		}

    }

    //-------------------------------------------------CAMPOS GENERAL TODO------------


    //---campo DESACTIVAR TODO----
    public function cg_geral_todo_field_cb( $args ) {

		$checked='';

        if( isset( $this->settings[ 'cg_geral_todo' ] ) )
            if( $this->settings[ 'cg_geral_todo' ][ 'value' ] == 'on' ) $checked='checked';

        $html = "<input class='{$args[ 'class' ]}' data-custom='{$args[ 'pau_dato_personalizado' ]}' type='checkbox' name='pau_default_data[settings][{$args[ 'label_for' ]}][value]' $checked>";
        echo $html;

    }
    //---Campo  SONIDO General----
    public function cg_geral_sonido_field_cb( $args ) {

		$checked='';

        if( isset( $this->settings[ 'cg_geral_sonido' ] ) )
            if( $this->settings[ 'cg_geral_sonido' ][ 'value' ] == 'on' ) $checked='checked';

        $html = "<input class='{$args[ 'class' ]}' data-custom='{$args[ 'pau_dato_personalizado' ]}' type='checkbox' name='pau_default_data[settings][{$args[ 'label_for' ]}][value]' $checked>";
        echo $html;

    }

    //---Campo  Leer-sonido de Pagina o contenido----
    public function cg_geral_lectura_field_cb( $args ) {

        $checked='';

        if( isset( $this->settings[ 'cg_geral_lectura' ] ) )
            if( $this->settings[ 'cg_geral_lectura' ][ 'value' ] == 'on' ) $checked='checked';

        $html = "<input class='{$args[ 'class' ]}' data-custom='{$args[ 'pau_dato_personalizado' ]}' type='checkbox' name='pau_default_data[settings][{$args[ 'label_for' ]}][value]' $checked>";
        echo $html;

    }
    //---Campo Video----
    public function cg_geral_video_field_cb( $args ) {

        $checked='';

        if( isset( $this->settings[ 'cg_geral_video' ] ) )
            if( $this->settings[ 'cg_geral_video' ][ 'value' ] == 'on' ) $checked='checked';

        $html = "<input class='{$args[ 'class' ]}' data-custom='{$args[ 'pau_dato_personalizado' ]}' type='checkbox' name='pau_default_data[settings][{$args[ 'label_for' ]}][value]' $checked>";
        echo $html;

    }
    //-------------------------------------------------CAMPOS NAVEGACION------
    //---Campo Click----
    public function cg_nav_clic_field_cb( $args ) {

        $checked='';

        if( isset( $this->settings[ 'cg_nav_clic' ] ) )
            if( $this->settings[ 'cg_nav_clic' ][ 'value' ] == 'on' ) $checked='checked';

        $html = "<input class='{$args[ 'class' ]}' data-custom='{$args[ 'pau_dato_personalizado' ]}' type='checkbox' name='pau_default_data[settings][{$args[ 'label_for' ]}][value]' $checked>";
        echo $html;

    }
    //---Campo nav zoom----
    public function cg_nav_zoom_field_cb( $args ) {

        $checked='';

        if( isset( $this->settings[ 'cg_nav_zoom' ] ) )
            if( $this->settings[ 'cg_nav_zoom' ][ 'value' ] == 'on' ) $checked='checked';

        $html = "<input class='{$args[ 'class' ]}' data-custom='{$args[ 'pau_dato_personalizado' ]}' type='checkbox' name='pau_default_data[settings][{$args[ 'label_for' ]}][value]' $checked>";
        echo $html;

    }
    //---Campo cg_nav_donde----
    public function cg_nav_donde_field_cb( $args ) {

        $checked='';

        if( isset( $this->settings[ 'cg_nav_donde' ] ) )
            if( $this->settings[ 'cg_nav_donde' ][ 'value' ] == 'on' ) $checked='checked';

        $html = "<input class='{$args[ 'class' ]}' data-custom='{$args[ 'pau_dato_personalizado' ]}' type='checkbox' name='pau_default_data[settings][{$args[ 'label_for' ]}][value]' $checked>";
        echo $html;

    }

    //-------------------------------------------------CAMPOS Fuentes y Tamaños------

    //---Campo cg_nav_donde----OJO CAMPO NUMERICO INT
    public function cg_font_size_field_cb( $args ) {

        $valor = 1;

        if( isset( $this->settings[ 'cg_zoom_pau' ] ) )
            $valor = $this->settings[ 'cg_zoom_pau' ][ 'value' ];

		$html = "<input class='{$args[ 'class' ]}' data-custom='{$args[ 'pau_dato_personalizado' ]}' type='number' name='pau_default_data[settings][{$args[ 'label_for' ]}][value]'
					min='1' max='10' value='$valor'> em.";
		echo $html;

    }

    //---Campo cg_font_legible----
    public function cg_font_legible_field_cb( $args ) {

        $checked='';

        if( isset( $this->settings[ 'cg_font_legible' ] ) )
            if( $this->settings[ 'cg_font_legible' ][ 'value' ] == 'on' ) $checked='checked';

        $html = "<input class='{$args[ 'class' ]}' data-custom='{$args[ 'pau_dato_personalizado' ]}' type='checkbox' name='pau_default_data[settings][{$args[ 'label_for' ]}][value]' $checked>";
        echo $html;

    }

    //---Campo cg_font_dixlesia----
    public function cg_font_dixlesia_field_cb( $args ) {

        $checked='';

        if( isset( $this->settings[ 'cg_font_dixlesia' ] ) )
            if( $this->settings[ 'cg_font_dixlesia' ][ 'value' ] == 'on' ) $checked='checked';

        $html = "<input class='{$args[ 'class' ]}' data-custom='{$args[ 'pau_dato_personalizado' ]}' type='checkbox' name='pau_default_data[settings][{$args[ 'label_for' ]}][value]' $checked>";
        echo $html;

    }

    //---Campo cg_font_resaltar_links----
    public function cg_font_resaltar_links_field_cb( $args ) {

        $checked='';

        if( isset( $this->settings[ 'cg_font_resaltar_links' ] ) )
            if( $this->settings[ 'cg_font_resaltar_links' ][ 'value' ] == 'on' ) $checked='checked';

        $html = "<input class='{$args[ 'class' ]}' data-custom='{$args[ 'pau_dato_personalizado' ]}' type='checkbox' name='pau_default_data[settings][{$args[ 'label_for' ]}][value]' $checked>";
        echo $html;

    }

    //-------------------------------------------------CAMPOS Ayudas Visuales------

    //---Campo cg_visual_bn----
    public function cg_visual_bn_field_cb( $args ) {

        $checked='';

        if( isset( $this->settings[ 'cg_visual_bn' ] ) )
            if( $this->settings[ 'cg_visual_bn' ][ 'value' ] == 'on' ) $checked='checked';

        $html = "<input class='{$args[ 'class' ]}' data-custom='{$args[ 'pau_dato_personalizado' ]}' type='checkbox' name='pau_default_data[settings][{$args[ 'label_for' ]}][value]' $checked>";

        echo $html;

    }

    //---Campo cg_visual_rcolors INVERTIR COLORES----
    public function cg_visual_rcolors_field_cb( $args ) {

        $checked='';

        if( isset( $this->settings[ 'cg_visual_rcolors' ] ) )
            if( $this->settings[ 'cg_visual_rcolors' ][ 'value' ] == 'on' ) $checked='checked';

        $html = "<input class='{$args[ 'class' ]}' data-custom='{$args[ 'pau_dato_personalizado' ]}' type='checkbox' name='pau_default_data[settings][{$args[ 'label_for' ]}][value]' $checked>";
        echo $html;

    }

    //---Campo cg_visual_resaltar_focus resaltr focus----
    public function cg_visual_resaltar_focus_field_cb( $args ) {

        $checked='';

        if( isset( $this->settings[ 'cg_visual_resaltar_focus' ] ) )
            if( $this->settings[ 'cg_visual_resaltar_focus' ][ 'value' ] == 'on' ) $checked='checked';

        $html = "<input class='{$args[ 'class' ]}' data-custom='{$args[ 'pau_dato_personalizado' ]}' type='checkbox' name='pau_default_data[settings][{$args[ 'label_for' ]}][value]' $checked>";
        echo $html;

    }

}
