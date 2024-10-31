<?php

/**
 *   * Proporcionar una vista de área de administración para el plugin
 *   *
 *   * Este archivo se utiliza para marcar los aspectos de administración del plugin.
 *   *
 *   * @link https://estudioinclusivo.com
 *   * @since desde 1.0.0
 *   *
 *   * @package pau
 *   * @subpackage pau/admin/parcials
 *   *
 **/

$pauSearchVal = sanitize_text_field( $_GET[ "pau_search" ] ?? "" );
$where        = "";

if ( ! empty( $pauSearchVal ) ) {

	$where .= " WHERE ";

	$busqueda = explode( " ", $pauSearchVal );

	foreach ( $busqueda as $key => $search ) {

		if ( ! empty( $search ) ) {

			if ( $key !== 0 ) {

				$where .= " OR ";

			}

			$where .= "
			(
				pictograma_name LIKE '%$search%' OR
				audio_name LIKE '%$search%' OR
				video_name LIKE '%$search%'
			)
			";

		}

	}

}

$sql_count_page = "SELECT COUNT(id) FROM " . PAU_HOTSPOTS_TABLE . $where;

$count_page      = $this->db->get_var( $sql_count_page );
$porPagina       = 10;
$paginas         = ceil( $count_page / $porPagina );
$pagina          = isset( $_GET[ 'pau_page' ] ) ? (int) sanitize_text_field( $_GET[ 'pau_page' ] ) : 1;
$init            = ( $pagina - 1 ) * $porPagina;
$pauPage         = isset( $_GET[ 'pau_page' ] ) ? "&pau_page=" . sanitize_text_field( $_GET[ 'pau_page' ] ) : "";
$pau_page_search = ! empty( $pauSearchVal ) ? "&pau_search=" . str_replace( " ", "+", $pauSearchVal ) : "";

$sql = "SELECT 	*
		FROM " . PAU_HOTSPOTS_TABLE
       . " $where ORDER BY id DESC LIMIT $init, $porPagina";

$result = $this->db->get_results( $sql );
// PAU_Helpers::dd( $count_page );

$msgSeleccionar  = __( "-- Select --", "pau-universal-accessibility" );
$msgCampoSiVacio = __( "This field can be left empty", "pau-universal-accessibility" );

if ( $this->wpml->is_active() ) {

	$langs = $this->wpml->get_langs();

	uasort( $langs, function( $a, $b ) {

		if ( $a == $this->wpml->get_default_lang() ) {
			return -1;
		}

		return 1;

	} );

	$langs_select = [];

	foreach ( $langs as $key => $lang ) {
		$langs_select[ $lang[ "code" ] ] = $lang[ "native_name" ];
	}

}

// Guardando la asignación

if ( isset( $_GET[ "rute_object" ] ) ) :

	$pauRute  = sanitize_text_field( $_GET[ "rute_object" ] );
	$lang     = sanitize_text_field( $_GET[ "pau_lang" ] );
	$pauRuteR = str_replace( "PAUNUM", "#", $pauRute );

	$sql_prepare = $this->db->prepare( "
			SELECT rute_object, lang
			FROM " . PAU_HOTSPOTS_TABLE . "
			WHERE rute_object = '%s' AND
			lang = '%s'
			",
		$pauRuteR,
		$lang
	);

	$results = $this->db->get_results( $sql_prepare );

	if ( count( $results ) > 0 ) {
		echo "
		<script>
		alert( 'Este rute_object ya está asignado y no se puede reasignar' );
		</script>
		";
	} else {

		// PAU_Helpers::dd( count( $results ), $pauRuteR, $sql_prepare, $results );

		$dataRute = [
			'rute_object' => stripslashes( $pauRuteR ),
		];

		$dataFormatRute = [
			"%s",
		];

		$whereRute = [
			"id" => sanitize_text_field( $_GET[ "id_hotspots" ] ),
		];

		$whereFormatRute = [
			"%d",
		];

		if ( isset( $_GET[ "id_page" ] ) ) {

			if ( sanitize_text_field( $_GET[ "id_page" ] ) != PAU_PAGE_ON_FRONT_ID ) {
				$whereRute       = array_merge( $whereRute, [ "page" => sanitize_text_field( $_GET[ "id_page" ] ) ] );
				$whereFormatRute = array_merge( $whereFormatRute, [ "%s" ] );
			}

		}

		if ( isset( $_GET[ "text" ] ) ) {
			$dataRute       = array_merge( $dataRute, [ "text_rute_object" => sanitize_text_field( $_GET[ "text" ] ) ] );
			$dataFormatRute = array_merge( $dataFormatRute, [ "%s" ] );
		}

		$result_update = $this->db->update( PAU_HOTSPOTS_TABLE, $dataRute, $whereRute, $dataFormatRute, $whereFormatRute );

		if ( $result_update ) : ?>

			<div id="pauAsiggModalUpdate"
				 class="modal">
				<div class="modal-content">
					<h4 style="
    display: flex;
    justify-content: center;
    align-items: center;
"><?php _e( "The assignment has been saved correctly!", "pau-universal-accessibility" ); ?></h4>
				</div>
				<div class="modal-footer">
					<a href="#!"
					   class="modal-close waves-effect waves-green btn-flat"><?php _e( "Close", "pau-universal-accessibility" ); ?></a>
				</div>
			</div>

			<script>

				<?php echo "var pauPageAsig = '$pauPage$pau_page_search'"; ?>

				document.addEventListener( 'DOMContentLoaded', function () {

					var elems       = document.querySelectorAll( '.modal' ),
						instances   = M.Modal.init( elems ),
						modalUpdate = document.getElementById( "pauAsiggModalUpdate" );

					var instModUpd = M.Modal.getInstance( modalUpdate );

					instModUpd.open();

					setTimeout( function () {
						instModUpd.close();
						location.href = "?page=pau-hot-spots" + pauPageAsig;
					}, 6000 );

				} );

			</script>

		<?php endif;
	}
endif;

PAU_Helpers::precargador();

?>

<!-- Modal Structure -->
<div id="add_hostspots_table"
	 class="modal modal-fixed-footer">


	<div class="modal-content">

		<!-- ===================== FORMULARIO DE ENTRADA DE DATOS ===================== -->

		<form method="post"
			  class="col s12"
			  id="formHotspots">

			<div class="row">

				<input id="pauTipo"
					   name="tipo"
					   type="hidden"
					   value="add">
				<input id="pauIDHotsEdit"
					   name="pauIDHotsEdit"
					   type="hidden"
					   value="">

		<div class="row">

				<div class="col s12">
					<h2><?php _e( "HotSpot UA:", "pau-universal-accessibility" ); ?></h2>
				</div>

				<div class="col s12">
					<ul class="tabs"
						id="pauSettingTabs">
						<li class="tab col s3">
							<a href="#pauFormObject"
							   class="active"><?php _e( "Object", "pau-universal-accessibility" ); ?></a>
						</li>
						<li class="tab col s3">
							<a href="#pauFormMulti"><?php _e( "Multimedia", "pau-universal-accessibility" ); ?></a>
						</li>
						<li class="tab col s3">
							<a href="#pauFormStyle"><?php _e( "Style", "pau-universal-accessibility" ); ?></a>
						</li>
					</ul>
				</div>


				<div id="pauFormObject"
					 class="col s12 pauContentSettings">

					<div class="row">

				<?php //Campo de Tipo de HotSpot

					$items_select = [
						[
							"name"	=> __( "Menu", "pau-universal-accessibility" ),
							"value"	=> "menu"
						],
						[
							"name"	=> __( "Container", "pau-universal-accessibility" ),
							"value"	=> "container"
						],
						[
							"name"	=> __( "Page Content", "pau-universal-accessibility" ),
							"value"	=> "page-content"
						],
						[
							"name"	=> __( "Emergent", "pau-universal-accessibility" ),
							"value"	=> "emergent"
						],
						[
							"name"	=> __( "Embedded", "pau-universal-accessibility" ),
							"value"	=> "embedded"
						],
					];

					$this->formbuild->select([
						"id" 				=> "pau-input-tipo",
						"label" 			=> __( "Type of HotSpot:", "pau-universal-accessibility" ),
						"name" 				=> "pau-input-tipo",
						"items" 			=> $items_select,
						"class_select" 		=> "pauHotspotsSelect",
						"class_container" 	=> "col s4",
						"description" 		=> $msgCampoSiVacio
					]);

					?>

					<div class="input-field col s4">
						<select class="pauHotspotsSelect" name="pau-input-estado" id="pau-input-estado">
							<option value="pending" selected><?php _e( "Pending", "pau-universal-accessibility" ); ?></option>
								<option value="active"><?php _e( "Active", "pau-universal-accessibility" ); ?></option>
								<option value="trash"><?php _e( "Deactivate", "pau-universal-accessibility" ); ?></option>
						</select>
						<label for="pau-input-estado"><?php _e( "State:", "pau-universal-accessibility" ); ?></label>
						<p id="pau-input-estado-invalid" class="validate"><?php echo $msgCampoSiVacio; ?></p>
					</div>



		</div><!--fin row-->

		<ul class="collapsible popout">
		<li>
		  <div class="collapsible-header">
			  <i class="material-icons">spellcheck</i>
			  <?php _e( "Filters:", "pau-universal-accessibility" ); ?>
		  </div>
		  <div class="collapsible-body">
			<div class="row">
					<?php if( $this->wpml->is_active() ) :	?>


						<div class="input-field col s4">
								<select class="pauHotspotsSelect notClean" name="pau-select-lang" id="pau-select-lang">

										<option value=""></option>
									<?php

									echo $this->helpers->getOptions( $langs_select, "", $this->wpml->get_current_lang() );
									?>
									</select>
													<label for="pau-select-lang"><?php _e( "Language:", "pau-universal-accessibility" ); ?></label>
								<p id="pau-select-lang-invalid" class="validate"></p>
						</div>


					<?php else : ?>

						<div class="input-field col s3">
											<input name="pau-select-lang" id="pau-select-lang" type="text" class="validate" value="<?php echo get_locale(); ?>" required>
											<label for="pau-select-lang"><?php _e( "Language:", "pau-universal-accessibility" ); ?></label>
							<p id="pau-select-lang-invalid" class="validate"><?php _e( "Add the language code.<br> EJ: es_ES, en_US, fr_FR.", "pau-universal-accessibility" ) ?></p>
									</div>

					<?php endif; ?>

				<div class="input-field col s4">
					<select class="pauHotspotsSelect" name="pau-select-page" id="pau-select-page">
				      <option value="" ></option>
					  <?php

						if( $this->wpml->is_active() ) :

							echo $this->helpers->getOptions( $this->wpml->getOptionsPage() );

						else :

						$sqlPage = "SELECT id, post_title AS title
								FROM {$this->db->prefix}posts
								WHERE post_type = 'page' AND post_status = 'publish'";

						$pages = $this->db->get_results( $sqlPage );

						$outputPage = "";

						foreach( $pages as $page ) {

							$outputPage .= $this->helpers->getOptions( $page->id, $page->title );

						}

						echo $outputPage;

						endif;

					  ?>
				    </select>
	                <label for="pau-select-page"><?php _e( "Page:", "pau-universal-accessibility" ); ?></label>
					<p id="pau-select-page-invalid" class="validate"><?php echo $msgCampoSiVacio; ?></p>
	            </div> <!--row-->
			</div>  <!--collapsible-body -->
		</li>
		<li>
		  <div class="collapsible-header">
			  <i class="material-icons">touch_app</i>
			  <?php _e( "Asginación:", "pau-universal-accessibility" ); ?>
		  </div>
		  <div class="collapsible-body">
			  	<div class="borde-darkred">
					<p class="warning-title">
					  <i class="material-icons warning-ico">warning</i>
					  <?php _e( "WARNING:", "pau-universal-accessibility" ); ?>
				  	</p>
					<p>
						<i class="tyni material-icons">touch_app</i>
						<?php _e( "Use this button from the hotspot list to enter data automatically.", "pau-universal-accessibility" ); ?>
					</p>
					<p>
						<i class="tyni material-icons">info</i>
						<?php _e( "It is recommended not to edit the assignment data manually, except for exceptions.", "pau-universal-accessibility" ); ?></p>
					</div> <!-- fin border red--->
				<div class="row">

					<div class="input-field col s3">
		                <input name="pau-input-ruta-objeto" id="pau-input-ruta-objeto" type="text" class="validate">
		                <label for="pau-input-ruta-objeto"><?php _e( "Route of the Object:", "pau-universal-accessibility" ); ?></label>
						<p id="pau-input-ruta-objeto-invalid" class="validate"><?php echo $msgCampoSiVacio; ?></p>
		            </div>

					<div class="input-field col s3">
		                <input name="pau-input-text-ruta-objeto" id="pau-input-text-ruta-objeto" type="text" class="validate">
		                <label for="pau-input-text-ruta-objeto"><?php _e( "Text Rute Object:", "pau-universal-accessibility" ); ?></label>
						<p id="pau-input-text-ruta-objeto-invalid" class="validate"><?php echo $msgCampoSiVacio; ?></p>
		            </div>

				</div> <!--row-->
			</div>  <!--collapsible-body -->
		</li>
		<ul>




			</div>

		</div>

		<div id="pauFormMulti" class="col s12 pauContentSettings">
		  	<ul class="collapsible popout">
				<li class="alis"><!--INCIO---Iconografia-->
		  			<div class="collapsible-header" tabindex="0">
						<!--<i class="material-icons">video_library</i>-->
						<i class="material-icons">accessibility</i>
						<?php _e( "ALIS, Accessibility Library of Inclusive Studio :", "pau-universal-accessibility" ); ?>
					</div>
					<div class="collapsible-body">
						<div class="row" style:"text-align: center;">
							<i class="material-icons">build</i><p>Coming soon</p>
								<!--Boton cloudinary-->
								<!-- INCIO DE CLOUDINARY

								FIN DE CLOUDINARY -->
								<!--fin-Boton cloudinary-->
						</div> <!--fin de row-->
					</div><!----fin collapsible-body -->
				</li> <!--fin---Iconografia-->
		  	  	<li class="iconografia"><!--INCIO---Iconografia-->
		  			<div class="collapsible-header" tabindex="0">
						<i class="material-icons">info</i>
						<?php _e( "Iconography:", "pau-universal-accessibility" ); ?>
					</div>
					<div class="collapsible-body">
						<div class="row">
							<div class="input-field col s3">
								<input name="pau-input-icon-library" id="pau-input-icon-library" type="text" class="validate" val="https://fonts.googleapis.com/icon?family=Material+Icons">
								<!-- now is Matelialize, but on future version PUXL = http://puxl.io/ -->
								<label for="pau-input-icon-library"><?php _e( "Icon Library URL:", "pau-universal-accessibility" ); ?></label>
								<p id="pau-input-icon-library-invalid" class="validate"><?php echo $msgCampoSiVacio; ?></p>
							</div>
							<div class="collapsible-body">
								<div class="row"
									 style="text-align:
								center;">
									<i class="material-icons">build</i>
									<p>
										Coming
										soon</p>
									<!--Boton cloudinary-->
									<!-- INCIO DE CLOUDINARY

									 fin DE CLOUDINARY -->
									<!--fin-Boton cloudinary-->
								</div>
								<!--fin de row-->
							</div>
							<!----fin collapsible-body -->
						</li>
						<!--fin---Iconografia-->
						<li>

						<li>
							<!--INCIO---pictogramas-->
							<div class="collapsible-header"
								 tabindex="0">
								<i class="material-icons">directions_transit</i>
								<?php _e( "Pictograms:", "pau-universal-accessibility" ); ?>
							</div>
							<div class="collapsible-body">
								<div class="row">

									<div class="input-field col s3">
										<input name="pau-input-nombre-pictograma"
											   id="pau-input-nombre-pictograma"
											   type="text"
											   class="validate">
										<label for="pau-input-nombre-pictograma"><?php _e( "Pictogram Name:", "pau-universal-accessibility" ); ?></label>
										<p id="pau-input-nombre-pictograma-invalid"
										   class="validate"><?php echo $msgCampoSiVacio; ?></p>
									</div>

									<?php

									echo $this->formbuild->media( "pictograma-url", "", "Pictograma Url:", "Upload .png", "image/png", true, "checkImageUrls" );
									echo $this->formbuild->media( "pictograma-url-on", "", "Pictograma Url On:", "Upload .png", "image/png", true, "checkImageUrls" );

									?>

								</div>
								<div class="row">

									<input name="pau-input-onclic-tipo"
										   id="pau-input-onclic-tipo"
										   class="notClean"
										   type="hidden"
										   value="interno">

									<!--INTRODUCIMOS DESPLEGABLE PARA SELECCIONAR PAGINA!-->
									<div class="onClicPageUrl input-field col s6">

										<select class="pauHotspotsSelect"
												name="pau-select-pictograma-onclic-page"
												id="pau-select-pictograma-onclic-page">
											<option value=""></option>
											<?php

											if ( $this->wpml->is_active() ) :

												echo $this->helpers->getOptions( $this->wpml->getOptionsPage() );

											else :

												$sqlPage = "SELECT id, post_title AS title
											FROM {$this->db->prefix}posts
											WHERE post_type = 'page' AND post_status = 'publish'";

												$pages = $this->db->get_results( $sqlPage );

												$outputPage = "";

												foreach ( $pages as $page ) {

													$outputPage .= $this->helpers->getOptions( $page->id, $page->title );

												}

												echo $outputPage;

											endif;

											?>
										</select>
										<label for="pau-input-pictograma-onclic-page"><?php _e( "Page:", "pau-universal-accessibility" ); ?></label>
										<p id="pau-input-pictograma-onclic-page-invalid"
										   class="validate"><?php echo $msgCampoSiVacio; ?></p>
									</div>
									<!--FIN---INTRODUCIMOS DESPLEGABLE PARA SELECCIONAR PAGINA!-->

									<div class="onClicExternalUrl input-field col s6">
										<input name="pau-input-pictograma-onclic"
											   id="pau-input-pictograma-onclic"
											   type="text"
											   class="validate">
										<label for="pau-input-pictograma-onclic"><?php _e( "OnClick event of the Pictogram:", "pau-universal-accessibility" ); ?></label>
										<p id="pau-input-pictograma-onclic-invalid"
										   class="validate"><?php echo $msgCampoSiVacio; ?></p>
									</div>

									<!--checkbox for external URL link !-->
									<div class="input-field col s6">
										<p>
											<label>
												<input class='onClicExternalUrls'
													   type='checkbox'
													   val=''><span>
										<?php echo __( "OnClick event of the Pictogram link to external URL", "pau-universal-accessibility" ) ?>
									</span>
											</label>
										</p>
									</div>
								</div>
								<!--fin de row-->
							</div>
							<!----fin collapsible-body -->
						</li>
						<!--fin---pictogramas-->
						<li>
							<!--INCIO---Audios-->
							<div class="collapsible-header"
								 tabindex="0">
								<i class="material-icons">settings_voice</i>
								<?php _e( "Voice:", "pau-universal-accessibility" ); ?>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="input-field col s3">
										<input name="pau-input-nombre-audio"
											   id="pau-input-nombre-audio"
											   type="text"
											   class="validate">
										<label for="pau-input-nombre-audio"><?php _e( "Audio Name:", "pau-universal-accessibility" ); ?></label>
										<p id="pau-input-nombre-audio-invalid"
										   class="validate"><?php echo $msgCampoSiVacio; ?></p>
									</div>

									<?php

									//									echo $this->formbuild->mediaMakeFormat( "audio-url", "", "Audio Url:", "Upload .mp3", "audio/mpeg", false );
									echo $this->formbuild->media( "audio-url-mp3", "", "Audio Url .mp3:", "Upload .mp3", "audio/mpeg", true, "checkAudioUrls" );
									echo $this->formbuild->media( "audio-url-ogg", "", "Audio Url .ogg:", "Upload .ogg", "audio/ogg", true, "checkAudioUrls" );

									?>

								</div>
								<!--fin de row-->
							</div>
							<!----fin collapsible-body -->
						</li>
						<!--fin---Audios-->
						<li>
							<!--INCIO---Videos-->
							<div class="collapsible-header"
								 tabindex="0">
								<i class="material-icons">thumbs_up_down</i>
								<?php _e( "Sign language:", "pau-universal-accessibility" ); ?>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="input-field col s3">

										<input name="pau-input-nombre-video"
											   id="pau-input-nombre-video"
											   type="text"
											   class="validate">
										<label for="pau-input-nombre-video"><?php _e( "Video Name:", "pau-universal-accessibility" ); ?></label>
										<p id="pau-input-nombre-video-invalid"
										   class="validate"><?php echo $msgCampoSiVacio; ?></p>

									</div>
								</div>
								<div class="row">

									<?php
									//								echo $this->formbuild->mediaMakeFormat( "video-url", "", "Video Url .mp4:", "Upload .mp4", "video/mp4" );
									echo $this->formbuild->media( "video-url-mp4", "", "Video Url .mp4:", "Upload .mp4", "video/mp4", true, "checkVideoUrls" );
									echo $this->formbuild->media( "video-url-ogv", "", "Video Url .ogv:", "Upload .ogv", "video/ogg", true, "checkVideoUrls" );
									echo $this->formbuild->media( "video-url-webm", "", "Video Url .webm:", "Upload .webm", "video/webm", true, "checkVideoUrls" );
									?>

								</div>
								<!--fin de row-->
							</div>
							<!----fin collapsible-body -->
						</li>
						<!--fin---Audios-->

					</ul>
					<!----fin de desplegables collapsible-->
				</div>

				<!------------TAB STYLES--->


				<div id="pauFormStyle"
					 class="col s12 pauContentSettings">
					<ul class="collapsible popout">
						<li>
							<!--INCIO---Tamaños-->
							<div class="collapsible-header"
								 tabindex="0">
								<!--<i class="material-icons">video_library</i>-->
								<i class="material-icons">aspect_ratio</i>
								<?php _e( "Sizes:", "pau-universal-accessibility" ); ?>
							</div>
							<div class="collapsible-body">

								<div class="row">

									<?php

									$this->formbuild->input( [
										"type"            => "number",
										"id"              => "pau-input-correction-w",
										"label"           => __( "Width Container:", "pau-universal-accessibility" ),
										"name"            => "pau-input-correction-w",
										"value"           => "125",
										"class_container" => "col s3",
										"class_input"     => "notClean",
										"description"     => $msgCampoSiVacio,
									] );

									$this->formbuild->input( [
										"type"            => "number",
										"id"              => "pau-input-correction-h",
										"label"           => __( "Height Container:", "pau-universal-accessibility" ),
										"name"            => "pau-input-correction-h",
										"value"           => "125",
										"class_container" => "col s3",
										"class_input"     => "notClean",
										"description"     => $msgCampoSiVacio,
									] );
									$this->formbuild->input( [
										"type"            => "number",
										"id"              => "pau-input-correction-w-emergent",
										"label"           => __( "Width Emergent Container:", "pau-universal-accessibility" ),
										"name"            => "pau-input-correction-w-emergent",
										"value"           => "125",
										"class_container" => "col s3",
										"class_input"     => "notClean",
										"description"     => $msgCampoSiVacio,
									] );

									$this->formbuild->input( [
										"type"            => "number",
										"id"              => "pau-input-correction-h-emergent",
										"label"           => __( "Height Emergent Container:", "pau-universal-accessibility" ),
										"name"            => "pau-input-correction-h-emergent",
										"value"           => "125",
										"class_container" => "col s3",
										"class_input"     => "notClean",
										"description"     => $msgCampoSiVacio,
									] );
									?>

								</div>
								<!--fin de row-->
							</div>
							<!----fin collapsible-body -->
						</li>
						<!--fin---Tamaños-->

						<li>
							<!--INCIO---Posicion-->
							<div class="collapsible-header"
								 tabindex="0">
								<!--<i class="material-icons">my_location</i> -->
								<!--<i class="material-icons">border_outer</i> -->
								<i class="material-icons">picture_in_picture</i>
								<!--<i class="material-icons">photo_size_select_small</i> -->
								<!--<i class="material-icons">zoom_out_map</i> -->
								<?php _e( "Position:", "pau-universal-accessibility" ); ?>
							</div>
							<div class="collapsible-body">

								<div class="row">

									<div class="input-field col s6">

										<select class="notClean"
												name="pau-select-position-clase"
												id="pau-select-position-clase">

											<?php

											$optionsPositionClass = [
												'none'   => __( 'None' ),
												'right'  => __( 'Right' ),
												'top'    => __( 'Top' ),
												'bottom' => __( 'Bottom' ),
												'left'   => __( 'Left' ),
											];

											echo $this->helpers->getOptions( $optionsPositionClass, "", "none" );

											?>

										</select>
										<label for="pau-input-position-clase"><?php _e( "Position:", "pau-universal-accessibility" ); ?></label>
										<p id="pau-input-position-clase-invalid"
										   class="validate"><?php echo $msgCampoSiVacio; ?></p>

									</div>

									<div class="input-field col s3">
										<input name="pau-input-correction-x"
											   id="pau-input-correction-x"
											   type="number"
											   class="validate"
											   value="0">
										<label for="pau-input-correction-x"><?php _e( "X Position:", "pau-universal-accessibility" ); ?></label>
										<p id="pau-input-correction"
										   class="validate"><?php echo $msgCampoSiVacio; ?></p>
									</div>

									<div class="input-field col s3">
										<input name="pau-input-correction-y"
											   id="pau-input-correction-y"
											   type="number"
											   class="validate"
											   value="0">
										<label for="pau-input-correction-y"><?php _e( "Y Position:", "pau-universal-accessibility" ); ?></label>
										<p id="pau-input-correction-y-invalid"
										   class="validate"><?php echo $msgCampoSiVacio; ?></p>
									</div>

								</div>
								<!--fin de row-->
							</div>
							<!----fin collapsible-body -->
						</li>
						<!--fin---Poscicion-->

						<li>
							<!--INCIO---clases personalizadas-->
							<div class="collapsible-header"
								 tabindex="0">
								<i class="material-icons">border_color</i>
								<!--<i class="material-icons">code</i> -->
								<?php _e( "Custom Classes:", "pau-universal-accessibility" ); ?>
							</div>
							<div class="collapsible-body">

								<div class="row">
									<p><?php _e( 'Enter all the classes you want, separated by a space. Example: "transparent sync circle my_class".', 'pau-universal-accessibility' ); ?></p>
									<div class="input-field col s12">


										<input name="pau-input-clase-personalizada"
											   id="pau-input-clase-personalizada"
											   type="text"
											   class="validate">
										<label for="pau-input-clase-personalizada"><?php _e( 'Custom Class:', "pau-universal-accessibility" ); ?></label>
										<p id="pau-input-clase-personalizada-invalid"
										   class="validate"><?php echo $msgCampoSiVacio; ?></p>
									</div>
								</div> <!--end row-->
								<div class="row">
									<div class="input-field col s12">
										<div class"borde-darkred class-list">

											<!--insertamos tabla de datos de classes pre-hechas-->
											<table>
												<thead>
													<p class="pau-class-toUse-title">
														<i class="material-icons">style</i>
														<!--<i class="material-icons">code</i>-->
														<?php _e( "Classes ready to use:", "pau-universal-accessibility" ); ?>
													</p>
													<tr>
														<th class="th-class"><?php _e( "Class:", "pau-universal-accessibility" ); ?></th>
														<th class="th-concept"><?php _e( "Concept:", "pau-universal-accessibility" ); ?></th>
														<th class="th-description"><?php _e( "Descriptión:", "pau-universal-accessibility" ); ?></th>
														<th class="th-example"><?php _e( "Example:", "pau-universal-accessibility" ); ?></th>
													<tr>
												</thead>
												<tbody>
													<tr>
														<th class="th-class">sinborde circular</th>
														<th class="th-concept"><?php _e( "Default Demo", "pau-universal-accessibility" ); ?></th>
														<th class="th-description"><?php _e( "The HotSpot that comes with the plugin. They are the combination of two classes, without border and circular.", "pau-universal-accessibility" ); ?></th>
														<th class="th-example">
															<img src="<?php echo PAU_DIR_URL . 'admin/img/customClasses-DefaultDemo.jpg'
															?>" class="PauCutomClass-example">
														</th>
													</tr>
													<tr>
														<th class="th-class"></th>
														<th class="th-concept"><?php _e( "Nothing / empty", "pau-universal-accessibility" ); ?></th>
														<th class="th-description"><?php _e( "When the field is left empty.", "pau-universal-accessibility" ); ?></th>
														<th class="th-example">
															<img src="<?php echo PAU_DIR_URL . 'admin/img/customClasses-Default.jpg'
															?>" class="PauCutomClass-example">
														</th>
													</tr>

													<tr>
														<th class="th-class">PauHotSpot-withoutBorder</th>
														<th class="th-concept"><?php _e( "Without Border", "pau-universal-accessibility" ); ?></th>
														<th class="th-description"><?php _e( "Remove edges to the hotspot", "pau-universal-accessibility" ); ?></th>
														<th class="th-example"><?php _e( "example", "pau-universal-accessibility" ); ?></th>
													</tr>
													<tr>
														<th class="th-class">PauHotSpot-withoutBorder</th>
														<th class="th-concept"><?php _e( "Without Border", "pau-universal-accessibility" ); ?></th>
														<th class="th-description"><?php _e( "Remove edges to the hotspot", "pau-universal-accessibility" ); ?></th>
														<th class="th-example"><?php _e( "example", "pau-universal-accessibility" ); ?></th>
													</tr>
													<tr>
														<th class="th-class">PauHotSpot-circular</th>
														<th class="th-concept"><?php _e( "Circular", "pau-universal-accessibility" ); ?></th>
														<th class="th-description"><?php _e( "The shape of the HotSpot will be circular.", "pau-universal-accessibility" ); ?></th>
														<th class="th-example"><?php _e( "example", "pau-universal-accessibility" ); ?></th>
													</tr>
													<tr>
														<th class="th-class">PauHotSpot-transparent</th>
														<th class="th-concept"><?php _e( "Transparent", "pau-universal-accessibility" ); ?></th>
														<th class="th-description"><?php _e( "Makes the HotSpot fund 10% transparent.", "pau-universal-accessibility" ); ?></th>
														<th class="th-example"><?php _e( "example", "pau-universal-accessibility" ); ?></th>
													</tr>
													<tr>
														<th class="th-class">PauHotSpot-ToLeft</th>
														<th class="th-concept"><?php _e( "To Left:", "pau-universal-accessibility" ); ?></th>
														<th class="th-description"><?php _e( "Descriptión:", "pau-universal-accessibility" ); ?></th>
														<th class="th-example"><?php _e( "example", "pau-universal-accessibility" ); ?></th>
													</tr>
													<tr>
														<th class="th-class"><?php _e( "Class:", "pau-universal-accessibility" ); ?></th>
														<th class="th-concept"><?php _e( "Concept:", "pau-universal-accessibility" ); ?></th>
														<th class="th-description"><?php _e( "Descriptión:", "pau-universal-accessibility" ); ?></th>
														<th class="th-example"><?php _e( "example", "pau-universal-accessibility" ); ?></th>
													</tr>
													<tr>
														<th class="th-class"><?php _e( "Class:", "pau-universal-accessibility" ); ?></th>
														<th class="th-concept"><?php _e( "Concept:", "pau-universal-accessibility" ); ?></th>
														<th class="th-description"><?php _e( "Descriptión:", "pau-universal-accessibility" ); ?></th>
														<th class="th-example"><?php _e( "example", "pau-universal-accessibility" ); ?></th>
													</tr>
												</tbody>
											</table>

										<div> <!-- FIN DE class-list-->
									</div>

								</div>
								<!--fin de row-->
							</div>
							<!----fin collapsible-body -->
						</li>
						<!--fin---Clases Personalizadas-->
					</ul>
					<!----fin de desplegables collapsible-->

				</div>

			</div>

		</form>

	</div>
	<div class="modal-footer">
		<button style="position: relative;right: 20px;"
				id="crear-hotspots"
				class="btn waves-effect waves-light "
				type="button"
				name="action">
			<?php _e( "Create Hotspot:", "pau-universal-accessibility" ); ?>
			<i class="material-icons right">add</i>
		</button>
		<!-- <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a> -->
	</div>

</div>

<!-- Modal de confirmación de eliminación -->
<div id="pauConfirmDelete"
	 class="modal">
	<div class="modal-content">
		<h5 style="color: red;"><?php _e( "Are you sure off deleting the record with the ID ", "pau-universal-accessibility" ); ?>
			<strong></strong>
		</h5>
	</div>
	<div class="modal-footer">
		<a href="#!"
		   class="modal-close waves-effect waves-green btn-flat"><?php _e( "Cancel", "pau-universal-accessibility" ); ?></a>
		<a id="pauDelete"
		   data-pauID=""
		   href="#!"
		   class="modal-close waves-effect waves-red btn-flat"><?php _e( "Delete", "pau-universal-accessibility" ); ?></a>
	</div>
</div>

<!-- ================================= Pagina a mostrar de normal ================================= -->

<div class="had-container">

	<!-- TIULO DE LA PAGINA --->
	<?php echo $this->getTitleMenuPage( "hot-spots-ua.svg" ); ?>
	<div class="row">
		<div class="col s12 descriptionPage">
			<p>
				<?php _e( 'In this section you can manage your spotlights or accessibility HotSpots for your website, with pictograms, audios (locutions) and sign language (video).', 'pau-universal-accessibility' ); ?>
			</p>
		</div>
	</div>

	<!-- boton crear nuevo item --->
	<div class="row mb0 mt0 hotspotBarra">

		<form role="search">

			<input type="hidden"
				   name="page"
				   value="pau-hot-spots">

			<div class="col s12 m4 push-m7">

				<div class="input-field dflex">

					<i class="material-icons prefix pau_search_hotspot">search</i>

					<input name="pau_search"
						   id="pau_search_hotspot"
						   type="search"
						   value="<?php echo esc_attr($pauSearchVal); ?>"
						   class="validate pau_search_hotspot"
						   aria-label="<?php esc_attr_e( "Search a HotSpot", "pau-universal-accessibility" ); ?>">

					<label for="pau_search_hotspot"><?php _e( "Search", "pau-universal-accessibility" ); ?></label>

					<button class="waves-effect waves-light btn mt6"
							type="submit">
						<i class="material-icons">location_searching</i>
					</button>

				</div>

			</div>

		</form>

		<div class="col s1 pull-m4 hotspotBotonNuevo">
			<a id="add-nuevo-hotspot"
			   class="btn-floating btn-large pulse scale-transition">
				<i class="material-icons">add</i></a>
			<br>
			<?php _e( "New", "pau-universal-accessibility" ); ?>

		</div>

		<?php /* We leave this code for the next Version
			<div class="col s2">
				<a class="btn-floating btn-large scale-transition">
				<i class="material-icons">remove_red_eye</i>
				</a>
				<?php _e( "Visual Mode", "pau-universal-accessibility" ); ?>
			</div>
			<!--
			<div class="col s2">
				<a class="btn-floating btn-large scale-transition">
				<i class="material-icons">reply_all</i>
				</a>
				Exportar
			</div>
			-->
			<div class="col s2">
				<a class="btn-floating btn-large scale-transition">
				<i class="material-icons">import_export</i>
				</a>
				<?php _e( "Import", "pau-universal-accessibility" ); ?>
			</div>
			<div class="col s2">
				<a class="btn-floating btn-large scale-transition">
				<i class="material-icons">cloud_upload</i>
				</a>
				<?php _e( "UpLoad", "pau-universal-accessibility" ); ?>
			</div>
			<div class="col s2">
				<a class="btn-floating btn-large scale-transition">
				<i class="material-icons">sort_by_alpha</i>
				</a>
				<?php _e( "Sort by", "pau-universal-accessibility" ); ?>
			</div>

			END this code for the next Version */ ?>

	</div>

	<?php if ( ! empty( $_GET[ "pau_search" ] ) ) : ?>
		<h3>
			<?php if ( $count_page == 0 ) :
				/* translators: No eliminar el %s */
				printf(
					__( "No results were found for: “%s”", "pau-universal-accessibility" ),
					sanitize_text_field( $_GET[ "pau_search" ] )
				); ?>

			<?php else :
				/* translators: No eliminar el %s */
				printf(
					_n(
						"%s results found for: “%s”",
						"We found %s result for: “%s”",
						$count_page,
						"pau"
					),
					number_format_i18n( $count_page ),
					sanitize_text_field( $_GET[ "pau_search" ] )
				);
			endif; ?>
		</h3>
		<h5>
			<a href="admin.php?page=pau-hot-spots"><?php _e( "Click here to return to the HotSpot list", "pau-universal-accessibility" ); ?></a>
		</h5>
	<?php endif; ?>

	<br>
	<!-- Tabla de HotSpots -->
	<table id="tableHotspot"
		   class="responsive-table striped borderred">
		<thead>
		<tr>
			<!-- max 12 columnnas-->
			<th class="th-id">
				&nbsp;&nbsp;<?php _e( "Id", "pau-universal-accessibility" ); ?></th>
			<th class="th-id"><?php _e( "Language", "pau-universal-accessibility" ); ?></th>
			<th class="th-estado"><?php _e( "State", "pau-universal-accessibility" ); ?></th>
			<th class="th-page"><?php _e( "Page", "pau-universal-accessibility" ); ?></th>
			<th class="th-objeto"><?php _e( "Object", "pau-universal-accessibility" ); ?></th>
			<th class="th-objeto"><?php _e( "Type", "pau-universal-accessibility" ); ?></th>
			<th class="th-picto"><?php _e( "Pictograms", "pau-universal-accessibility" ); ?></th>
			<th class="th-audio"><?php _e( "Audios", "pau-universal-accessibility" ); ?> </th>
			<th class="th-video"><?php _e( "Sign language", "pau-universal-accessibility" ); ?></th>
			<th colspan="3"
				class="th-actions"
				style="text-align: center;"><?php _e( "Actions", "pau-universal-accessibility" ); ?></th>
		</tr>
		</thead>

		<tbody>


		<!--===================== PAGINACION =====================-->
		<?php
		$anterior   = $pagina - 1;
		$siguiente  = $pagina + 1;
		$urlDefault = "?page=pau-hot-spots&pau_page";
		?>

		<ul class="pagination">
			<?php if ( ! ( $pagina <= 1 ) ) : ?>
				<li class="waves-effect">
					<?php $urlPrev = "$urlDefault=$anterior";
							$urlPrev = esc_url($urlPrev);?>
					<a href="<?php echo $urlPrev; ?>"><i
								class="material-icons">chevron_left</i></a>
				</li>
			<?php endif; ?>

			<?php
			if ( $paginas >= 1 ) {

				for ( $x = 1; $x <= $paginas; $x++ ) {

					$pauActive  = ( $x == $pagina ) ? "active" : "";
					$urlPauPage = ( $x != $pagina ) ? "$urlDefault=$x" : "#";
					$urlDinamic = esc_url($urlPauPage . $pau_page_search);
					echo "<li class='waves-effect $pauActive'><a href='$urlDinamic'>$x</a></li>";

				}

			}
			?>
			<?php if ( ! ( $pagina >= $paginas ) ) : ?>
				<li class="waves-effect">
					<?php $urlNext = "$urlDefault=$siguiente$pau_page_search";
							$urlNext = esc_url($urlNext);?>
					<a href="<?php echo $urlNext; ?>"><i
								class="material-icons">chevron_right</i></a>
				</li>
			<?php endif; ?>
		</ul>
		<!--===================== FIN - PAGINACION =====================-->

		<?php
		//hacemos foreach con el resultado de la consulta de la db (hecha arriba del todo) almacenada en $result
		// ... y le asignamos una clave $k y un valor $v
		//echo '<br>la consulta a la tabla pau_hotspots es: <br>';
		//var_dump ($result);
		foreach ( $result as $k => $v ) {

			$valores = (array) $v;

			$json_all = json_encode( $valores, JSON_HEX_APOS );

			/**
			 * Declaración de variables obtenidas desde la
			 * función extract()
			 *
			 * @var $estado            string
			 * @var $rute_object       string
			 * @var $pictograma_url    string
			 * @var $pictograma_name   string
			 * @var $pictograma_url_on string
			 * @var $data_media        string
			 * @var $audio_name        string
			 * @var $type              string
			 * @var $video_name        string
			 */
			extract( $valores );

			//escapando valores
			$id = esc_html($id);
			$idA = esc_attr($id);
			$lang = esc_html($lang);
			$estado = esc_html($estado);
			$enlPageTitle = esc_html($enlPageTitle);

			$rute_object = esc_html($rute_object);
			$pageA = esc_attr($page);
			$urlFinal = esc_url($urlFinal);

			$pictograma_name = esc_html($pictograma_name);
			$pictograma_nameA = esc_attr($pictograma_name);
			$pictograma_url_on = esc_url($pictograma_url_on);
			$pictograma_url = esc_url($pictograma_url);

			$pauPage = esc_html($pauPage);


			$urlEnd = "id_hotspots=$id&paumode=asignacion$pauPage";

			if ( ! empty( $page ) ) {

				$post_page = get_post( $page );
				$pLink     = esc_url( get_permalink( $page ) );

				$charquest    = strpos( $pLink, "?" ) !== false ? "&" : "?";
				$urlFinal     = "$pLink$charquest$urlEnd&preview_id=$page$pau_page_search";
				$enlPageTitle = "<a href='$pLink' target='_blank'>{$post_page->post_title}</a>";

			} else {

				if ( PAU_SHOW_ON_FRONT == "posts" ) {
					$pLink     = PAU_SITE_URL;
					$previewID = "";
				} else {
					//$post_page = get_post( PAU_PAGE_ON_FRONT_ID );
					//Fuente a la solucion de obtener url home especifica de un idioma concreto
					//https://wpml.org/forums/topic/get-home-link-of-specified-language/
					global $sitepress, $post;
					$post_page = $sitepress->convert_url( home_url(), $lang );
					//$html = "<h1>Entra, el valor es de PostPage es: " . $post_page;
					// fin
					//PAU_Helpers::dd($post_page);
					$pLink = esc_url( $sitepress->convert_url( get_permalink( $post->ID ), $lang ) );
					//fuente a la solucion de darme el post-page en un determinado idioma
					//$my_duplications will return an associative array with language codes as indexes and post_ids as values fuente: https://wpml.org/documentation/support/wpml-coding-api/wpml-hooks-reference/#hook-606329
					//$my_duplications = apply_filters( 'wpml_post_duplicates', $post->ID );
					$previewID = "";
				}

				$charquest = strpos( $pLink, "?" ) !== false ? "&" : "?";
				$urlFinal  = "$pLink$charquest$urlEnd$previewID$pau_page_search";

				$enlPageTitle = "";

			}

			$html = "
					<tr data-pauID='$idA' data-all='$json_all' data-table='$idA'>
						<td class='td-id'>&nbsp;&nbsp;$id</td>
						<td class='td-lang'>$lang</td>
						<td class='td-estado'>$estado</td>
						<td class='td-page'>$enlPageTitle</td>
					";

			if ( $rute_object != "" ) {

				$html .= "
					<td class='td-rute'>
						<span data-bc-id-visualedit='$pageA' class='btn btn-floating waves-effect waves-light tooltipped' data-position='top' data-tooltip='" . __( "Reassign", "pau-universal-accessibility" ) . "&nbsp;'>
							<a href='$urlFinal'>
							<i class='tyni material-icons'>touch_app</i>
							</a>
						</span>
					" . trim( $rute_object ) . "</td>
					";

			} else {

				$html .= "
					<td class='td-obj td-editar-visual asignar'>
						<span data-bc-id-visualedit='$pageA' class='btn btn-floating waves-effect waves-light tooltipped' data-position='top' data-tooltip='" . __( "To Assign", "pau-universal-accessibility" ) . "'>
							<a href='$urlFinal'>
							<i class='tyni material-icons'>touch_app</i>
							</a>
						</span>
					</td>";

			}

			$html .= "
				<td>" . sprintf( __( "%s", "pau-universal-accessibility" ), ucwords( str_replace( "-", " ", trim( $type ) ) ) ) . "</td>
				";

			//Visualizacion de Pictograma
			if ( $pictograma_url != '' || $pictograma_name != '' ) {

				$html .= "
						<td class='td-picto'>

							$pictograma_name

							<!-- pictograma -->

							<img id='$pictograma_nameA' class='picto-off pau-img-admin-picto-hotspots-list'
							data-url-cambio-estado='$pictograma_url_on'
							src='$pictograma_url'
							   alt='$pictograma_nameA'>

							<!--- pictograma en estado on

							 <img id ='$pictograma_nameA' class='picto-on pau-img-admin-picto-hotspots-list' src='$pictograma_url_on'
								alt='$pictograma_nameA'>
								-->
						</td>
						";

			} else {
				$html .= "
						<td class='td-picto unassigned'>
							" . __( "Unassigned", "pau-universal-accessibility" ) . "
						</td>
					";
			}
			//Visualizacion de audio
			$data_media_obj = json_decode( stripslashes( $data_media ) );

			if ( $data_media != '' || $audio_name != '' ) {
				$mp3 = esc_url($data_media_obj->audio->mp3);
				$mp3 = ! empty( $data_media_obj->audio->mp3 ) ? "<source src='{$data_media_obj->audio->mp3}' type='audio/mpeg'>" : "";
				$ogg = esc_url($data_media_obj->audio->ogg);
				$ogg = ! empty( $data_media_obj->audio->ogg ) ? "<source src='{$data_media_obj->audio->ogg}' type='audio/ogg'>" : "";

				$tagAudio = "$mp3$ogg";

				if ( ! empty( $tagAudio ) ) {
					$tagAudio = "
						<audio controls>
							$tagAudio
							" .
					            __( 'Your browser does not support the audio tag html5', 'pau-textdomain' ) . "
						</audio>
						";
				}

				$html .= "
					<input type='hidden' class='edit-json-media' value='" . stripslashes( $data_media ) . "'>
					";

				$html .= "
						<td class='td-audio'>
							$audio_name
							$tagAudio
						</td>
						";

			} else {
				$html .= "
						<td class='td-audio unassigned'>
							" . __( "Unassigned", "pau-universal-accessibility" ) . "
						</td>
					";
			}

			//Visualizacion de video
			if ( $data_media != '' || $video_name != '' ) {
				$mp4 = esc_url($data_media_obj->video->mp4);
				$mp4  = ! empty( $data_media_obj->video->mp4 ) ? "<source src='$mp4' type='video/mp4'>" : "";
				$ogg = esc_url($data_media_obj->video->ogg);
				$ogg  = ! empty( $data_media_obj->video->ogg ) ? "<source src='{$data_media_obj->video->ogg}' type='video/ogg'>" : "";
				$webm = esc_url($data_media_obj->video->webm);
				$webm = ! empty( $data_media_obj->video->webm ) ? "<source src='{$data_media_obj->video->webm}' type='video/webm'>" : "";

				$tagVideo = "$mp4$ogg$webm";

				if ( ! empty( $tagVideo ) ) {
					$tagVideo = "
						<video class='pau-video-admin-hotspots-list' width='110' height='110' controls>
							$tagVideo
							" .
					            __( 'Your browser does not support the video tag html5', 'pau-universal-accessibility' ) . "
						</video>
						";
				}
				// PAU_Helpers::ddlog( $id, $data_media_obj );
				$html .= "
						<td data-video='' class='td-video'>
							$video_name
							$tagVideo
						</td>
							";

			} else {
				$html .= "
						<td class='td-video unassigned'>
							" . __( "Unassigned", "pau-universal-accessibility" ) . "
						</td>
					";
			}

			//Visualizacion de iconos
			$html .= "
						<td class='td-editar'>
							<span data-pau-hotspot-id-edit='$idA' class='btn btn-floating waves-effect waves-light tooltipped' data-position='top' data-tooltip='" . __( "Edit", "pau-universal-accessibility" ) . "'>
								<i class='tyni material-icons'>mode_edit</i>
							</span>
						</td>
						";
			/* web leave this code to de next version
			$html_v2 .='
					<td class="td-obj td-ver-visual">
						<span data-pau-hotspot-id-vervisual="'.$id.'" class="btn btn-floating waves-effect waves-light">
							<i class="tyni material-icons">remove_red_eye</i>
						</span>
					</td>
					*/
			$html .= "<td class='td-duplicar'>
							<span data-pau-hotspot-id-duplicar='$idA' class='btn btn-floating waves-effect waves-light tooltipped' data-position='top' data-tooltip='" . __( "Duplicate", "pau-universal-accessibility" ) . "'>
								<i class='tyni material-icons'>repeat_one</i>
							</span>
						</td>";
			/*<td class="td-export">
				<span data-pau-hotspot-id-export="'.$id.'" class="btn btn-floating waves-effect waves-light">
					<i class="tyni material-icons">reply_all</i>
				</span>
			</td>
			';
	en code to de next version*/
			$html .= "
						<td class='td-borrar'>
							<span data-pau-hotspot-id-remove='$idA' class='btn btn-floating waves-effect waves-light red darken-1 tooltipped' data-position='top' data-tooltip='" . __( "Delete", "pau-universal-accessibility" ) . "'>
								<i class='tyni material-icons'>close</i>
							</span>
						</td>
					 </tr>";

			echo $html;

		}

		?>

		</tbody>
	</table>
	<!--===================== PAGINACION =====================-->
	<?php

	$anterior   = $pagina - 1;
	$siguiente  = $pagina + 1;
	$urlDefault = "?page=pau-hot-spots&pau_page";

	?>
	<br>

	<ul class="pagination">
		<?php if ( ! ( $pagina <= 1 ) ) : ?>
			<li class="waves-effect">
				<?php $urlPrev = "$urlDefault=$anterior";
						$urlPrev = esc_url($urlPrev);?>
				<a href="<?php echo $urlPrev; ?>"><i
							class="material-icons">chevron_left</i></a>
			</li>
		<?php endif; ?>

		<?php
		if ( $paginas >= 1 ) {

			for ( $x = 1; $x <= $paginas; $x++ ) {

				$pauActive  = ( $x == $pagina ) ? "active" : "";
				$urlPauPage = ( $x != $pagina ) ? "$urlDefault=$x" : "#";
				$urlDinamic = esc_url($urlPauPage . $pau_page_search);
				echo "<li class='waves-effect $pauActive'><a href='$urlDinamic'>$x</a></li>";

			}

		}
		?>
		<?php if ( ! ( $pagina >= $paginas ) ) : ?>
			<li class="waves-effect">
				<?php $urlNext = "$urlDefault=$siguiente$pau_page_search";
						$urlNext = esc_url($urlNext);?>
				<a href="<?php echo $urlNext; ?>"><i
							class="material-icons">chevron_right</i></a>
			</li>
		<?php endif; ?>
	</ul>
	<!--===================== FIN - PAGINACION =====================-->

	<!--===================== COPYRIGHT =====================-->
	<!-- <div class="row">
		<div class="col s12">
			<img href="images/logo.png" alt="Logo de Estudio Inclusivo">
			<p>Realizado por Estudio Inclusivo. PAU, Panel de Accesibilidad Universal.</p>
		</div>
	</div> -->

	<!--===================== FIN - COPYRIGHT =====================-->
</div>
