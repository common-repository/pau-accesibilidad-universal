<?php

/**
  * Proporcionar una vista de área de administración para el plugin
  *
  * Este archivo se utiliza para marcar los aspectos de administración del plugin.
  *
  * @link https://estudioinclusivo.com
  * @since desde 1.0.0
  *
  * @package pau
  * @subpackage pau/admin/parcials
  */




//variable global de WP para trabajar con Base de datos y utilizar sus funciones
global $wpdb;

//obtenemos los todos los hotSpots y los introducimos en la arrray hotspots

// $sql = "SELECT id, Estado, page, Type, IdObject, ChildLevel, RuteObject, ClassObject,
// 			AudioName, AudioUrl, VideoName, VideoUrl, PictogramaName, PictogramaUrl, PictogramaOnclic,
// 			CustomClass, CorrectionX, CorrectionY
// 			FROM " . PAU_HOTSPOTS_TABLE ;
//
// $hotspots = $wpdb->get_results($sql);

//obtenemos los toda la configuracion de PAU y lo introducimos en la arrray PAUconfig

$PAUconfig = get_option( 'pau_default_data' );

//------vamos a mostrar en pantalla los datos que contengan ambas arrays--------

//abrimos seccion
// echo '
// 		<div class="fila">
// 			<div class="col100">
// 				<h1> datos actuales de las arrays</h1>
// 	';
//Datos de Configuracion $PAUconfig
//var_dump($PAUconfig);
//salto de linea separador
// echo '</br></hr></br>';
//Datos de Hotsport $hotspots
//var_dump($hotspots);

//cierre de seccion
// echo ' 			<h1> FIN de datos actuales de las arrays</h1>
// 			</div>
// 		</div>
// 	';

/*function otto_options_page() {
	if ( otto_check_buttons() ) return;
}
*/

echo $this->getTitleMenuPage( "import-export.svg" );

//---------------- aqui introduciremos -------- los mensajes de error y acierto a la hora de crear el archivo ------------------

?>
<!--CONTENIDO POR DEFECTO en html-->
<div class="col100">
	<div class="col50">
		<h2>EXPORTAR</h2>
		</hr>
		<!--
		<div id="DivBtnExportar">
			<div id="BtnExportar">Boton EXPORTAR</div>
		</div>
		-->
		<hr>
		<!-- empieza codigo form definitivo -->
		<div>
			<h2>Exportar File</h2>
			<form action="" method="post">
			<input name="PAUnombreExport" type="text" value="MiNombre" />
			<?php wp_nonce_field(); ?>
			<input name="save" type="submit" value="Exportar" />
			</form>
		</div>
		<!-- Fin empieza codigo form definitivo -->
	</div>
	<div class="col50">
		<h2>IMPORTAR</h2>
		<hr>
		<div id="DivBtnImportar">
			<div id="BtnExaminar">Boton EXAMINAR</div>
			<div id="BtnImportar">Boton IMPORTAR</div>
			<!--boton multimedia-->
			<input id="pau-input-url-import" type="text" class="validate">
			<label for="pau-label-url-import">Video Name:</label>
			<p id="pau-input-url-import-invalid" class="validate"> Este campo SI puede quedar vacio</p>

			<!--boton multimedia-->
			<button class="btn btn-primary btnMarco">Subir</button>
			<!-- Visualizacion de lo seleccionado-->
			<div class="pau-input-url-import-ok">
				<img class="pau-img-input-url-import" src="">
			</div>
		</div>
	</div>
</div>

<?php
if (empty($_POST)) return false;

check_admin_referer();

$form_fields = array ('save'); // this is a list of the form field contents I want passed along between page views
$method = ''; // Normally you leave this an empty string and it figures it out by itself, but you can override the filesystem method here
$post_save = sanitize_text_field( $_POST[ 'save' ] );
// check to see if we are trying to save a file
	if (isset($post_save)) {
			// okay, let's see about getting credentials
			$url = wp_nonce_url('admin.php?page=pau-import-export');

			if (false === ($creds = request_filesystem_credentials($url, $method, false, false, $form_fields) ) ) {

				// if we get here, then we don't have credentials yet,
				// but have just produced a form for the user to fill in,
				// so stop processing for now
				echo 'No tienes credenciales';

				return true; // stop the normal page form from displaying
			}

			// now we have some credentials, try to get the wp_filesystem running
			if ( ! WP_Filesystem($creds) ) {
				// our credentials were no good, ask the user for them again
				request_filesystem_credentials($url, $method, true, false, $form_fields);
				return true;
			}
			// CARLOS EMPIEZA AQUI


			// get the upload directory and make a test.txt file
			//----GENERAR EL FICHERO
			$PAUExportName = sanitize_text_field( $_POST[ 'PAUnombreExport' ] );
			echo 'PAUExportName = '.$PAUExportName.'</br>';
			$upload_dir = wp_upload_dir(); //EJEMPLO uploads dir
			$filename = trailingslashit($upload_dir['path']). 'Pau-Data_'.date('Y-m-d').'-'.$PAUExportName.'.txt';


			//------------Generamos el contenido del archivo antes de escribirlo----------
			$pau_contenido_exportar =  '';
			$pau_contenido_exportar .= '<table-options>
			';
			$pau_contenido_exportar .= 'ESTO ES TUNA PRUEBA';

			//ahora sacamos configuracion PAU
			foreach ($PAUconfig as $clave => $valor) {
				// $array[3] se actualizará con cada valor de $array...
				$pau_contenido_exportar .= "{$clave} => {$valor}";
				$pau_contenido_exportar .= "
				";
				//print_r($PAUconfig);
			}
			$pau_contenido_exportar .= '
			</table-options>
			';
			$pau_contenido_exportar .= '
			<table-hotspots>
			';
			//$hotspotsSTR= implode ("','" , $hotspots);
			//ahora sacamos hotspots
			//$hotspotsArray = Array($hotspots);
			//$hotspotsSTR= implode($hotspots);
			//$pau_contenido_exportar .= print_r($hotspots);
			/*
			$sql = "SELECT id, Estado, page, Type, IdObject, ChildLevel, RuteObject, ClassObject,
			AudioName, AudioUrl, VideoName, VideoUrl, PictogramaName, PictogramaUrl, PictogramaOnclic,
			CustomClass, CorrectionX, CorrectionY
			FROM " . PAU_HOTSPOTS_TABLE ;
			/*
			while ($row = mysqli_fetch_assoc($sql)){
					$pau_contenido_exportar .= printf ("%s (%s)\n", $row["Name"], $row["CountryCode"]);
				}

			foreach ($hotspots as $clave2 => $valor2) {
				// $array[3] se actualizará con cada valor de $array...
				$claveSTR = '';
				$valorSTR = '';
				//$claveSTR = implode($clave2);
				//$valorSTR =  implode($valor2);
				//$pau_contenido_exportar .= "$claveSTR => $valorSTR";
				echo $clave2 . ' = ' . $valor2;
				$pau_contenido_exportar .= "
				";
				//print_r($PAUconfig);
			}
			*/

		foreach( $hotspots as $k=>$v ){
			$pau_contenido_exportar .=	'(';
				$id=				$v->id;
			$pau_contenido_exportar .=	$id.',';
				$Estado=			$v->Estado;
			$pau_contenido_exportar .=	$Estado.',';
				$page=				$v->page;
			$pau_contenido_exportar .=	$page.',';
				$Type=				$v->Type;
			$pau_contenido_exportar .=	$Type.',';
				$IdObject=			$v->IdObject;
			$pau_contenido_exportar .=	$IdObject.',';
				$ChildLevel=		$v->ChildLevel;
			$pau_contenido_exportar .=	$ChildLevel.',';
				$RuteObject=		$v->RuteObject;
			$pau_contenido_exportar .=	$RuteObject.',';
				$ClassObject=		$v->ClassObject;
			$pau_contenido_exportar .=	$ClassObject.',';
				$AudioName=			$v->AudioName;
			$pau_contenido_exportar .=	$AudioName.',';
				$AudioUrl=			$v->AudioUrl;
			$pau_contenido_exportar .=	$AudioUrl.',';
				$VideoName=			$v->VideoName;
			$pau_contenido_exportar .=	$VideoName.',';
				$VideoUrl=			$v->VideoUrl;
			$pau_contenido_exportar .=	$VideoUrl.',';
				$PictogramaName=	$v->PictogramaName;
			$pau_contenido_exportar .=	$PictogramaName.',';
				$PictogramaUrl=		$v->PictogramaUrl;
			$pau_contenido_exportar .=	$PictogramaUrl.',';
				$PictogramaOnclic=	$v->PictogramaOnclic;
			$pau_contenido_exportar .=	$PictogramaOnclic.',';
				$CustomClass=		$v->CustomClass;
			$pau_contenido_exportar .=	$CustomClass.',';
				$CorrectionX=		$v->CorrectionX;
			$pau_contenido_exportar .=	$CorrectionX.',';
				$CorrectionY=		$v->CorrectionY;
			$pau_contenido_exportar .=	$CorrectionY.',';

			$pau_contenido_exportar .=	')';
		}
			$pau_contenido_exportar .= '
			</table-hotspots>
			';
			print_r($pau_contenido_exportar);



			// --------------by this point, the $wp_filesystem global should be working, so let's use it to create a file
			global $wp_filesystem;
			if ( ! $wp_filesystem->put_contents( $filename, $pau_contenido_exportar, FS_CHMOD_FILE) ) {
				echo "error saving file!";
			} else { //el archivo se ha guardado correctamente
				echo '</br>El archivo se ha guardado correctamente en: </br>' .$filename;
			}
	}

?>

<!--cierra en html-->
