<?php

class PAU_FormBuild {

    public function input( Array $attrs = [] ) {

        $default_attr = [
            "type"			        => "text",
            "id"			        => "",
            "label"	                => "",
            "name"	                => "",
            "value"	                => "",
            "class_container"	    => "",
            "class_input"	        => "",
            "placeholder"	        => "",
            "description"	        => "",
            "echo"	                => true
        ];

        $attrs = PAU_Helpers::attr_default( $default_attr, $attrs, true );

        $output = "
        <div class='input-field {$attrs->class_container}'>

            <input name='{$attrs->name}' id='{$attrs->id}' type='{$attrs->type}' class='validate {$attrs->class_input}' value='{$attrs->value}' placeholder='{$attrs->placeholder}'>
            <label for='{$attrs->id}'>{$attrs->label}</label>";

        if( ! empty( $description ) ) $output .= "<p class='validate'>{$attrs->description}</p>";

        $output .= "</div>";

        if( $attrs->echo ) {
            echo $output;
            return;
        }

        return $output;

    }

    public function check_radio( Array $attrs ) {

        $default_attrs = [
            "type"                => "checkbox",
            "items"               => [],
            "class_container"     => "",
            "value_db"            => "",
            "echo"                => true
        ];

        $attrs = PAU_Helpers::attr_default( $default_attrs, $attrs, true );

        $output = "<div class='{$attrs->class_container}'>";

        $class_type = $attrs->type === "checkbox" ? "filled-in" : "";

        $default_attr_item = [
            "id"			=> "",
            "label"			=> "",
            "name"			=> "",
            "value"			=> "",
            "input_class"	=> "",
            "label_class"	=> ""
        ];

        foreach( $attrs->items as $item ) {

            $item = PAU_Helpers::attr_default( $default_attr_item, $item, true );

            if( $item->value === "" ) {
                $value = "";
                $on = "on";
            } else {
                $value = "value='{$item->value}'";
                $on = $item->value;
            }

            $checked = checked( $on, $attrs->value_db, false );

            $output .= "
            <p>
                <label for='{$item->id}' class='{$item->label_class}'>
                    <input name='{$item->name}' id='{$item->id}' type='{$attrs->type}' class='$class_type {$item->input_class}' $value $checked>
                    <span>{$item->label}</span>
                </label>
            </p>
            ";

        }

        $output .= "</div>";

        if( $attrs->echo ) {
            echo $output;
            return;
        }

        return $output;

    }

    public function select( Array $attrs ) {

        $default_attr = [
            "option_init"           => "",
            "id"			        => "",
            "label"	                => "",
            "name"	                => "",
            "items"	                => [],
            "value_db"	            => "",
            "class_select"	        => "",
            "class_container"	    => "",
            "description"	        => "",
            "echo"	                => true
        ];

        $attrs = PAU_Helpers::attr_default( $default_attr, $attrs, true );

        if( empty( $attrs->option_init ) ) {
            $option_init = "<option value='' disabled selected>" . __( "-- Select --", "pau-universal-accessibility" ) . "</option>";
        } else {
            $option_init = "<option value='{$attrs->option_init[ "value" ]}' {$attrs->option_init[ "attrs" ]}>{$attrs->option_init[ "name" ]}</option>";
        }

        $output = "
        <div class='input-field {$attrs->class_container}'>
            <select id='{$attrs->id}' class='{$attrs->class_select}' name='{$attrs->name}'>
                $option_init";

        $default_attr_item = [
            "name"			=> "Option #",
            "value"			=> "",
            "attrs"	        => ""
        ];

        foreach( $attrs->items as $item ) {

            $item = PAU_Helpers::attr_default( $default_attr_item, $item, true );
            $output .= "<option value='{$item->value}' {$item->attrs}>{$item->name}</option>";

        }

        $output .= "</select>
            <label for='{$attrs->id}'>{$attrs->label}</label>";

        if( ! empty( $description ) ) $output .= "<p class='validate'>{$attrs->description}</p>";

        $output .= "</div>";

        if( $attrs->echo ) {
            echo $output;
            return;
        }

        return $output;

    }

	public function mediaMakeFormat( $id, $value = "", $textTitle = "", $textBtn = "Upload", $tipo = "", $hidden = true, $info = "" ) {

		$media = explode( "/", $tipo );

		$output = "<p>
        <label>
            <input class='checkExternalUrls filled-in' type='checkbox' value='$id'>
            <span>" . __( "Show fields for external URLs", "pau-universal-accessibility" ) . "</span>
        </label>
        </p>
        <input class='data-pau-input' id='data-pau-input-$id' type='hidden' value=''>";

		$output .= $this->media( $id, $value, $textTitle, $textBtn, $tipo, $info, $hidden );

		$output .= "
        <div class='input-field col s3 pau-externals pau-input-$id'>
            <input name='pau-input-$id-ogg' id='pau-input-$id-ogg' type='text' class='validate' value=''>
            <label for='pau-input-$id-ogg' class=''>$textTitle Ogg:</label>
        </div>";

		if( $media[ 0 ] == "video" ) {
			$output .= "
            <div class='input-field col s3 pau-externals pau-external-$id'>
            <input name='pau-input-$id-webm' id='pau-input-$id-webm' type='text' class='validate' value=''>
            <label for='pau-input-$id-webm' class=''>$textTitle Webm:</label>
            </div>";
		}

		return $output;

	}

    public function media( $id, $value = "", $textTitle = "", $textBtn = "Upload", $tipo = "", $hidden = true, $classContainer = '', $info = "" ) {

        $media = explode( "/", $tipo );

        if( $value != "" ) {
            $dBlock = "display:block;";
        } else {
            $dBlock = "";
        }

	    $hidden = $hidden ? "display:none;" : "";

        $output = "
        <div class='input-field col s3 pau-input-media $classContainer'>
        
            <input name='pau-input-$id' id='pau-input-$id' type='text' class='validate' value='$value' style='$hidden'>";

	    $output .= "
	    	<label for='pau-input-$id' style='$hidden'>" . sprintf( __( '%s', 'pau-universal-accessibility' ), $textTitle ) . "</label>
            <p id='pau-input-$id-invalid' class='validate'>$info</p>

            <div class='pau-media-preview pau-input-$id' style='$dBlock'>";

		    switch ( $media[ 0 ] ) {

			    case 'image':
				    $output .= "<img src='$value'>";
				    break;

			    case 'audio':
			    case 'video':
				    $output .= "
	                    <{$media[ 0 ]} controls>";
				            $output .= ! empty( $value ) ? "<source src='$value' type='$tipo'>" : "";
	                    $output .= "</{$media[ 0 ]}>
	                    ";
				    break;

		    }

		    $output .= "</div>
            <button type='button' class='btn btn-primary' data-media='pau-input-$id' data-mediaType='$tipo'>" .
	               sprintf( __( '%s', 'pau-universal-accessibility' ), $textBtn ) . "
            </button>
        </div>";

	    return $output;

    }

}
