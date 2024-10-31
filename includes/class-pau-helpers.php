<?php

/**
 * Define la funcionalidad de internacionalización
 *
 *  * Carga y define los archivos de internacionalización de este plugin para que esté listo para su traducción.
 *
 * @link       https://estudioinclusivo.com
 * @since      1.0.0
 *
 * @package    pau
 * @subpackage pau/includes
 */

/**
 * Ésta clase tiene varios métodos ayudantes
 *
 * @since      1.0.0
 * @package    pau
 * @subpackage pau/includes
 * @author     Estudio Inclusivo <admin@estudioinclusivo.com>
 */
class PAU_Helpers {

	/**
	 * Añade una acción nueva al array ($this->actions) a iterar para registrarla en WordPress.
	 *
	 * @param array $listArgs
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	private function dump( ...$listArgs ) {

		// $listArgs   = func_get_args();
		// $numArgs    = func_num_args();

		echo "<pre>\n\n";
		foreach ( $listArgs as $arg ) {

			echo "Tipo: " . gettype( $arg ) . " ----->\n";

			if ( is_array( $arg ) ) {

				echo "\n< -------------- /// -------------- >\n\n";
				foreach ( $arg as $k => $v ) {
					echo "Key: $k\nValue: ";
					var_dump( $v );
					echo "\n------------ / ------------\n\n";
				}
				echo "\n< -------------- /// -------------- >\n\n";

			} else {
				var_dump( $arg );
				echo "\n------------ / ------------\n\n";
			}

		}
		echo "</pre>";

	}

	/**
	 * @param $text
	 *
	 * @return mixed
	 */
	public static function cleanerText( $text ) {

		$text = trim( preg_replace( '/\t+/', '', $text ) );
		$text = preg_replace( '(\s{2,})', '', $text );

		return str_replace( PHP_EOL, '', $text );

	}

	/**
	 * @param string $val
	 * @param string $name
	 * @param string $select
	 *
	 * @return string
	 */
	public function getOptions( $val = "", $name = "", $select = "" ) {


		if ( ! is_array( $val ) ) {
			$val = esc_attr($val);
			return "<option value=\"$val\">$name</option>";
		}

		$output = "";

		foreach ( $val as $value => $name ) {
			$value = esc_attr($value);
			$output .= "<option value=\"$value\"" . selected( $value, $select, false ) . ">$name</option>";
		}

		return $output;

	}

	/**
	 * @param $diaStr
	 *
	 * @return mixed
	 */
	private function getDayEsp( $diaStr ) {

		$dias = [
			"Monday"    => "Lunes",
			"Tuesday"   => "Martes",
			"Wednesday" => "Miércoles",
			"Thursday"  => "Jueves",
			"Friday"    => "Viernes",
			"Saturday"  => "Sábado",
			"Sunday"    => "Domingo",
		];

		return $dias[ $diaStr ];

	}

	/**
	 * @param $mes
	 *
	 * @return mixed
	 */
	private function getMonthsEsp( $mes ) {

		$meses = [
			"January"   => "Enero",
			"February"  => "Febrero",
			"March"     => "Marzo",
			"April"     => "Abril",
			"May"       => "Mayo",
			"June"      => "Junio",
			"July"      => "Julio",
			"August"    => "Agosto",
			"September" => "Septiembre",
			"October"   => "Octubre",
			"November"  => "Noviembre",
			"December"  => "Diciembre",
		];

		return $meses[ $mes ];

	}

	/**
	 * @param $timestamp
	 *
	 * @return string
	 */
	public function getDate( $timestamp ) {

		$diaStr = $this->getDayEsp( date( "l", $timestamp ) );
		$diaNum = date( "d", $timestamp );
		$mes    = $this->getMonthsEsp( date( "F", $timestamp ) );
		$anio   = date( "Y", $timestamp );

		return "$diaStr $diaNum de $mes de $anio";

	}

	/**
	 * @param mixed ...$listArgs
	 */
	public static function dd( ...$listArgs ) {

		// $listArgs   = func_get_args();
		// $numArgs    = func_num_args();

		echo "
        <style>
        .HelpersDump {
            background-color: white;
            height: 100% !important;
            width: 100% !important;
            z-index: 9999999;
        }

        .HelpersDump pre {
            max-height: 700px;
            max-width: 700px;
            background-color: #7c0b0b;
            color: white;
            padding: 20px;
            overflow: auto;
            border-radius: 10px;
        }
        </style>
        ";

		echo "<div class=\"HelpersDump\"><pre>\n\n";
		foreach ( $listArgs as $arg ) {

			echo "Tipo: " . gettype( $arg ) . " ----->\n";

			echo "\n------------ / ------------\n\n";
			var_dump( $arg );
			echo "\n------------ / ------------\n\n";

		}

		echo "</pre></div>";

		die;

	}

	/**
	 * @param mixed ...$args
	 */
	public static function ddlog( ...$args ) {

		$jsonEncode = json_encode( $args );

		echo "
        <script>
            console.log( JSON.parse( '$jsonEncode' ) );
        </script>
        ";

	}

	/**
	 * @param array $default_attrs
	 * @param array $new_attrs
	 * @param bool  $object
	 *
	 * @return array|object
	 */
	public static function attr_default( Array $default_attrs, Array $new_attrs, Bool $object = false ) {

		$new_attrs = (array) $new_attrs;
		$out       = [];

		foreach ( $default_attrs as $name => $default ) {

			if ( array_key_exists( $name, $new_attrs ) ) {
				$out[ $name ] = $new_attrs[ $name ];
			} else {
				$out[ $name ] = $default;
			}

		}

		if ( $object ) {
			$out = (object) $out;
		}

		return $out;

	}

	/**
	 * @return bool
	 */
	public static function is_localhost(): Bool {

		if ( $_SERVER[ "SERVER_NAME" ] === "localhost" ) {
			return true;
		}

		return false;

	}


	/**
	 * @param bool $echo
	 *
	 * @return string|void
	 */
	public static function precargador( Bool $echo = true ) {

		$precargador = '
        <div class="precargador">

        	<h3 class="msgPrecargador"></h3>

        	<div class="preloader-wrapper big active">
        		<div class="spinner-layer spinner-blue">
        			<div class="circle-clipper left">
        				<div class="circle"></div>
        			</div><div class="gap-patch">
        				<div class="circle"></div>
        			</div><div class="circle-clipper right">
        				<div class="circle"></div>
        			</div>
        		</div>

        		<div class="spinner-layer spinner-red">
        			<div class="circle-clipper left">
        				<div class="circle"></div>
        			</div><div class="gap-patch">
        				<div class="circle"></div>
        			</div><div class="circle-clipper right">
        				<div class="circle"></div>
        			</div>
        		</div>

        		<div class="spinner-layer spinner-yellow">
        			<div class="circle-clipper left">
        				<div class="circle"></div>
        			</div><div class="gap-patch">
        				<div class="circle"></div>
        			</div><div class="circle-clipper right">
        				<div class="circle"></div>
        			</div>
        		</div>

        		<div class="spinner-layer spinner-green">
        			<div class="circle-clipper left">
        				<div class="circle"></div>
        			</div><div class="gap-patch">
        				<div class="circle"></div>
        			</div><div class="circle-clipper right">
        				<div class="circle"></div>
        			</div>
        		</div>
        	</div>

        </div>';

		if ( $echo ) {
			echo $precargador;

			return;
		}

		return $precargador;

	}

	/**
	 * @param Exception $e
	 *
	 * @param bool      $echoDie
	 *
	 * @return false|string
	 */
	public static function getExceptionJSON( Exception $e, $others = null, $echoDie = false, $msgDebug = null ) {

		ob_start();
		var_dump( $e );
		$dump = ob_get_clean();

		$json = json_encode( [
			'exception'        => true,
			'dump'             => $dump,
			'getMessages'      => $e->getMessage(),
			'getCode'          => $e->getCode(),
			'getFile'          => $e->getFile(),
			'getLine'          => $e->getLine(),
			'getTrace'         => $e->getTrace(),
			'getTraceAsString' => $e->getTraceAsString(),
			'others'           => $others ?? "",
			'msgDebug'         => $msgDebug ?? "",
		] );

		if ( $echoDie ) {
			echo $json;
			wp_die();
		}

		return $json;

	}

	public static function dberrorJSON( $db ) {

		if ( ! empty( $db->last_error ) ) {

			echo json_encode( [
				'exception'  => true,
				'msg'        => 'Error en la base de datos',
				'last_error' => $db->last_error,
				'last_query' => $db->last_query,
				'db_version' => $db->db_version(),
			] );

			wp_die();

		}

	}

	public static function ddJSON( ...$listArgs ) {

		echo json_encode( [
			"exception" => true,
			'msg'       => 'Verificando datos',
			"info"      => $listArgs,
		] );

		wp_die();

	}

}
