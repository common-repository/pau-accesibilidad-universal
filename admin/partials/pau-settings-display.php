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

echo $this->getTitleMenuPage( "settings.svg" );

PAU_Helpers::precargador();

?>

<div class="row">

	<div class="col s12 m0 p0">
		<ul class="tabs" id="pauSettingTabs">
			<li class="tab"><a class="active" href="#pauConfigGeneral"><?php _e( "General setting", "pau-universal-accessibility" ); ?></a></li>
			<li class="tab"><a href="#pauConfigDefault"><?php _e( "Default setting", "pau-universal-accessibility" ); ?></a></li>
			<li class="tab"><a href="#pauDesign"><?php _e( "Design", "pau-universal-accessibility" ); ?></a></li>
		</ul>
	</div>

	<form id="pauFormSettings">

	<!-- Ajuste General -->
	<div id="pauConfigGeneral" class="col s12 p20 pauContentSettings">
		<div class="row">
			<div class="col s12 descriptionPage">
				<?php
				/* translators: Respect the html tags */
				_e( "<p>In this section you can configure and customise the behavior of your PAU panel, as well as, if you want to provide it with audios and / or sign language.</p>", "pau-universal-accessibility" ); ?>
			</div>
		</div>

		<!-- Valor por defecto - Tipo Checkbox -->
		<p>
			<label>
				<input name="pau_default_data[settings][pau_activate_default][value]" id="pau_activate_default" class="pauShow filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'pau_activate_default' ][ 'value' ] ?? "" ); ?> />
				<span><?php _e( "PAU enabled by default", "pau-universal-accessibility" ); ?></span>
			</label>
		</p>

	</div>
	<!-- // Ajuste General // -->

	<!-- Ajuste por defecto -->
	<div id="pauConfigDefault" class="col s12 p20 pauContentSettings">
		<div class="row">
			<div class="col s12 descriptionPage">
				<?php
				/* translators: Respect the html tags */
				_e( "
							<p>In this section you can indicate the buttons that will be displayed in your PAU panel, check the box show if you want them to be available in the panel.</p>
							<p>You can also indicate if this will be active by default, or not, in the second box next to the name of each function.</p>
							<p>This last configuration by default can be changed by each of the users, allowing them a personalised assisted browsing, and storing their preferences in a cookie.</p>
				", "pau-universal-accessibility" ); ?>
			</div>
		</div>
		<!-- Perfil por defecto - Tipo Radio Button -->
		<div class="row">
			<div class="col s12">

				<fieldset class="pauFieldfix col s12 m4">

					<legend><?php _e( "Profiles", "pau-universal-accessibility" ); ?></legend>

					<p>
						<!-- Show ? -->
						<label class="mr20">
							<input name="pau_default_data[settings][cg_perfil_defecto][show]" id="" class="pauShow filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_perfil_defecto' ][ 'show' ] ?? "" ); ?> />
							<span><?php _e( "Show?", "pau-universal-accessibility" ); ?></span>
						</label>
						<!-- / Show ? -->
					</p>

				<?php

				$perfiles = [
					"default"				=> __( "Default", "pau-universal-accessibility" ),
					"visual-diversity"		=> __( "Visual Diversity", "pau-universal-accessibility" ),
					"auditive-diversity"	=> __( "Auditive Diversity", "pau-universal-accessibility" ),
					"cognitive-diversity"	=> __( "Cognitive Diversity", "pau-universal-accessibility" ),
					"custom"				=> __( "Custom", "pau-universal-accessibility" )
				];

				foreach ( $perfiles as $id => $perfil ) {

					echo "
					<p>
						<label>
							<input class='cg_perfil_defecto' name='pau_default_data[settings][cg_perfil_defecto][value]' type='radio' value='$id' " . checked( $id, $this->settings[ 'cg_perfil_defecto' ][ 'value' ] ?? '', false ) . " />
							<span>$perfil</span>
						</label>
					</p>
					";

				}

				?>

				</fieldset>

			</div>
		</div>

		<div class="row">
			<div class="col s12">

				<fieldset class="pauFieldfix col s12 m4">

					<legend><?php _e( "General", "pau-universal-accessibility" ); ?></legend>

					<!-- Mostrar u Ocultar todo - Tipo Checkbox -->
					<p>
						<!-- Show ? -->
						<label class="mr20">
							<input name="pau_default_data[settings][cg_geral_todo][show]" id="" class="pauShow filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_geral_todo' ][ 'show' ] ?? "" ); ?> />
							<span><?php _e( "Show?", "pau-universal-accessibility" ); ?></span>
						</label>
						<!-- / Show ? -->

						<label>
							<input name="pau_default_data[settings][cg_geral_todo][value]" id="cg_geral_todo" class="cg_geral_todo filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_geral_todo' ][ 'value' ] ?? "" ); ?> />
							<span><?php _e( "Show / Hide ALL", "pau-universal-accessibility" ); ?></span>
						</label>
					</p>

					<!-- Activar Sonido Geral. - Tipo Checkbox -->
					<p>
						<!-- Show ? -->
						<label class="mr20">
							<input name="pau_default_data[settings][cg_geral_sonido][show]" id="" class="pauShow filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_geral_sonido' ][ 'show' ] ?? "" ); ?> />
							<span><?php _e( "Show?", "pau-universal-accessibility" ); ?></span>
						</label>
						<!-- / Show ? -->

						<label>
							<input name="pau_default_data[settings][cg_geral_sonido][value]" id="cg_geral_sonido" class="cg_geral_sonido filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_geral_sonido' ][ 'value' ] ?? "" ); ?> />
							<span><?php _e( "Activate General Sound.", "pau-universal-accessibility" ); ?></span>
						</label>
					</p>

					<!-- Todos los Videos de LSE - Tipo Checkbox -->
					<p>
						<!-- Show ? -->
						<label class="mr20">
							<input name="pau_default_data[settings][cg_geral_video][show]" id="" class="pauShow filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_geral_video' ][ 'show' ] ?? "" ); ?> />
							<span><?php _e( "Show?", "pau-universal-accessibility" ); ?></span>
						</label>
						<!-- / Show ? -->

						<label>
							<input name="pau_default_data[settings][cg_geral_video][value]" id="cg_geral_video" class="cg_geral_video filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_geral_video' ][ 'value' ] ?? "" ); ?> />
							<span><?php _e( "All Sign Language Videos", "pau-universal-accessibility" ); ?></span>
						</label>
					</p>

					<!-- Lectura o sonido del contenido - Tipo Checkbox -->
					<p>
						<!-- Show ? -->
						<label class="mr20">
							<input name="pau_default_data[settings][cg_geral_lectura][show]" id="" class="pauShow filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_geral_lectura' ][ 'show' ] ?? "" ); ?> />
							<span><?php _e( "Show?", "pau-universal-accessibility" ); ?></span>
						</label>
						<!-- / Show ? -->

						<label>
							<input name="pau_default_data[settings][cg_geral_lectura][value]" id="cg_geral_lectura" class="cg_geral_lectura filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_geral_lectura' ][ 'value' ] ?? "" ); ?> />
							<span><?php _e( "Content presentation", "pau-universal-accessibility" ); ?></span>
						</label>
					</p>

				</fieldset>

			</div>
		</div>

		<div class="row">
			<div class="col s12">

				<fieldset class="pauFieldfix col s12 m4">

					<legend><?php _e( "Navigation", "pau-universal-accessibility" ); ?></legend>

					<!-- Cursor grande - Tipo Checkbox -->
					<p>
						<!-- Show ? -->
						<label class="mr20">
							<input name="pau_default_data[settings][cg_nav_bigcursor][show]" id="" class="pauShow filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_nav_bigcursor' ][ 'show' ] ?? "" ); ?> />
							<span><?php _e( "Show?", "pau-universal-accessibility" ); ?></span>
						</label>
						<!-- / Show ? -->

						<label>
							<input name="pau_default_data[settings][cg_nav_bigcursor][value]" id="cg_nav_bigcursor" class="cg_nav_bigcursor filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_nav_bigcursor' ][ 'value' ] ?? "" ); ?> />
							<span><?php _e( "Large cursor", "pau-universal-accessibility" ); ?></span>
						</label>
					</p>

					<!-- Sonido al clic - Tipo Checkbox -->
					<p>
						<!-- Show ? -->
						<label class="mr20">
							<input name="pau_default_data[settings][cg_nav_clic][show]" id="" class="pauShow filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_nav_clic' ][ 'show' ] ?? "" ); ?> />
							<span><?php _e( "Show?", "pau-universal-accessibility" ); ?></span>
						</label>
						<!-- / Show ? -->

						<label>
							<input name="pau_default_data[settings][cg_nav_clic][value]" id="cg_nav_clic" class="cg_nav_clic filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_nav_clic' ][ 'value' ] ?? "" ); ?> />
							<span><?php _e( "Click sound", "pau-universal-accessibility" ); ?></span>
						</label>
					</p>

					<!-- Mostrar donde estas - Tipo Checkbox -->
					<p>
						<!-- Show ? -->
						<label class="mr20">
							<input name="pau_default_data[settings][cg_nav_donde][show]" id="" class="pauShow filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_nav_donde' ][ 'show' ] ?? "" ); ?> />
							<span><?php _e( "Show?", "pau-universal-accessibility" ); ?></span>
						</label>
						<!-- / Show ? -->

						<label>
							<input name="pau_default_data[settings][cg_nav_donde][value]" id="cg_nav_donde" class="cg_nav_donde filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_nav_donde' ][ 'value' ] ?? "" ); ?> />
							<span><?php _e( "Show where you are", "pau-universal-accessibility" ); ?></span>
						</label>
					</p>

					<!-- Zoom sobre enlaces - Tipo Checkbox -->
					<p>
						<!-- Show ? -->
						<label class="mr20">
							<input name="pau_default_data[settings][cg_nav_zoom][show]" id="" class="pauShow filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_nav_zoom' ][ 'show' ] ?? "" ); ?> />
							<span><?php _e( "Show?", "pau-universal-accessibility" ); ?></span>
						</label>
						<!-- / Show ? -->

						<label>
							<input name="pau_default_data[settings][cg_nav_zoom][value]" id="cg_nav_zoom" class="cg_nav_zoom filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_nav_zoom' ][ 'value' ] ?? "" ); ?> />
							<span><?php _e( "Zoom in on links", "pau-universal-accessibility" ); ?></span>
						</label>
					</p>

				</fieldset>

			</div>
		</div>

		<div class="row">
			<div class="col s12">

				<fieldset class="pauFieldfix col s12 m4">

					<legend><?php _e( "Fonts", "pau-universal-accessibility" ); ?></legend>

					<!-- Tamaño de fuente ( 1-10em ) - Tipo Number -->
					<div class="row">

						<!-- Show ? -->
						<?php

						$item_show = [
							[
								"id"			=> "cg_font_size_show",
								"label"			=> __( "Show?", "pau-universal-accessibility" ),
								"name"			=> "pau_default_data[settings][cg_font_size][show]",
								"label_class"	=> "pauShow"
							]
						];

						$this->formbuild->check_radio([
							"items" 			=> $item_show,
							"class_container" 	=> "col s4 m3",
							"value_db" 			=> $this->settings[ 'cg_font_size' ][ 'show' ] ?? ""
						]);

						?>
						<!-- / Show ? -->

						<?php

						$this->formbuild->input([
							"type"  			=> "number",
							"id" 				=> "cg_font_size",
							"label" 			=> __( "Font size (1-9 em)", "pau-universal-accessibility" ),
							"name"  			=> "pau_default_data[settings][cg_font_size][value]",
							"value" 			=> $this->settings[ 'cg_font_size' ][ 'value' ] ?? '',
							"class_container" 	=> "col s7 m6 pl0",
							"class_input" 		=> "cg_font_size"
						]);

						?>

					</div>
					<!-- Agrupamiento -->
					<div role="group" class="fieldsGroup">
						<legend class="subleyenda"><?php _e( "Type of font (only one at a time)", "pau-universal-accessibility" ); ?></legend>
					<!-- Fuente Legible - Tipo Checkbox -->
					<p>
						<!-- Show ? -->
						<label class="mr20">
							<input name="pau_default_data[settings][cg_font_legible][show]" id="" class="pauShow filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_font_legible' ][ 'show' ] ?? "" ); ?> />
							<span><?php _e( "Show?", "pau-universal-accessibility" ); ?></span>
						</label>
						<!-- / Show ? -->

						<label>
							<input name="pau_default_data[settings][cg_font_dislexia_legible][value]" id="pauCheckLegible" class="cg_font_dislexia_legible filled-in" type="checkbox" value="readable" <?php checked( "readable", $this->settings[ 'cg_font_dislexia_legible' ][ 'value' ] ?? "" ); ?> />
							<span><?php _e( "Readable", "pau-universal-accessibility" ); ?></span>
						</label>

					</p>

					<!-- Fuente Dislexia - Tipo Checkbox -->
					<p>
						<!-- Show ? -->
						<label class="mr20">
							<input name="pau_default_data[settings][cg_font_dislexia][show]" id="" class="pauShow filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_font_dislexia' ][ 'show' ] ?? "" ); ?> />
							<span><?php _e( "Show?", "pau-universal-accessibility" ); ?></span>
						</label>
						<!-- / Show ? -->

						<label>
							<input name="pau_default_data[settings][cg_font_dislexia_legible][value]" id="pauCheckDislexia" class="cg_font_dislexia_legible filled-in" type="checkbox" value="dyslexia" <?php checked( "dyslexia", $this->settings[ 'cg_font_dislexia_legible' ][ 'value' ] ?? "" ); ?> />
							<span><?php _e( "Dyslexia", "pau-universal-accessibility" ); ?></span>
						</label>

					</p>
				</div> <!--fin de agrupamiento-->
					<!-- Resaltar Enlaces - Tipo Checkbox -->
					<p>
						<!-- Show ? -->
						<label class="mr20">
							<input name="pau_default_data[settings][cg_font_resaltar_links][show]" id="" class="pauShow filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_font_resaltar_links' ][ 'show' ] ?? "" ); ?> />
							<span><?php _e( "Show?", "pau-universal-accessibility" ); ?></span>
						</label>
						<!-- / Show ? -->

						<label>
							<input name="pau_default_data[settings][cg_font_resaltar_links][value]" id="cg_font_resaltar_links" class="cg_font_resaltar_links filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_font_resaltar_links' ][ 'value' ] ?? "" ); ?> />
							<span><?php _e( "Highlight Links", "pau-universal-accessibility" ); ?></span>
						</label>
					</p>

				</fieldset>

			</div>

		</div>

		<div class="row">
			<div class="col s12">

				<fieldset class="pauFieldfix col s12 m4">

					<legend><?php _e( "Visual", "pau-universal-accessibility" ); ?></legend>


					<div role="group" class="fieldsGroup">
						<!-- Agrupamiento -->
						<legend><?php _e( "Filters (only one at a time)", "pau-universal-accessibility" ); ?></legend>
						<!-- Ver en Blanco y Negro - Tipo Checkbox -->
					<p>
						<!-- Show ? -->
						<label class="mr20">
							<input name="pau_default_data[settings][cg_visual_colors_bn][show]" id="" class="pauShow filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_visual_colors_bn' ][ 'show' ] ?? "" ); ?> />
							<span><?php _e( "Show?", "pau-universal-accessibility" ); ?></span>
						</label>
						<!-- / Show ? -->

						<label>
							<input name="pau_default_data[settings][cg_visual_colors][value]" id="pauCheckBlancoNegro" class="cg_visual_colors filled-in" type="checkbox" value="blackwhite" <?php checked( "blackwhite", $this->settings[ 'cg_visual_colors' ][ 'value' ] ?? "" ); ?> />
							<span><?php _e( "See in Black and White", "pau-universal-accessibility" ); ?></span>
						</label>
					</p>

					<!-- Invertir Colores - Tipo Checkbox -->
					<p>
						<!-- Show ? -->
						<label class="mr20">
							<input name="pau_default_data[settings][cg_visual_colors_invert][show]" id="" class="pauShow filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_visual_colors_invert' ][ 'show' ] ?? "" ); ?> />
							<span><?php _e( "Show?", "pau-universal-accessibility" ); ?></span>
						</label>
						<!-- / Show ? -->

						<label>
							<input name="pau_default_data[settings][cg_visual_colors][value]" id="pauCheckInvert" class="cg_visual_colors filled-in" type="checkbox" value="invert-colors" <?php checked( "invert-colors", $this->settings[ 'cg_visual_colors' ][ 'value' ] ?? "" ); ?> />
							<span><?php _e( "Invert Colours", "pau-universal-accessibility" ); ?></span>
						</label>
					</p>

					</div> <!-- en subgorup-->

					<!-- Resaltar Selección - Tipo Checkbox -->
					<p>
						<!-- Show ? -->
						<label class="mr20">
							<input name="pau_default_data[settings][cg_visual_resaltar_focus][show]" id="" class="pauShow filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_visual_resaltar_focus' ][ 'show' ] ?? "" ); ?> />
							<span><?php _e( "Show?", "pau-universal-accessibility" ); ?></span>
						</label>
						<!-- / Show ? -->

						<label>
							<input name="pau_default_data[settings][cg_visual_resaltar_focus][value]" id="cg_visual_resaltar_focus" class="cg_visual_resaltar_focus filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_visual_resaltar_focus' ][ 'value' ] ?? "" ); ?> />
							<span><?php _e( "Highlight the focus of a selection", "pau-universal-accessibility" ); ?></span>
						</label>
					</p>

				</fieldset>

			</div>
		</div>

		<div class="row">
			<div class="col s12">

				<fieldset class="pauFieldfix col s12 m4">

					<legend><?php _e( "Design", "pau-universal-accessibility" ); ?></legend>

					<div class="row">

						<!-- Show ? -->
						<div class="col s4 m3">

							<label class="mr20">
								<input name="pau_default_data[settings][cg_zoom_pau][show]" id="" class="pauShow filled-in" type="checkbox" <?php checked( "on", $this->settings[ 'cg_zoom_pau' ][ 'show' ] ?? "" ); ?> />
								<span><?php _e( "Show?", "pau-universal-accessibility" ); ?></span>
							</label>

						</div>
						<!-- / Show ? -->

						<!-- Zoom - Tipo Number -->
						<div class="input-field col s7 m6 mb0">

							<input name="pau_default_data[settings][cg_zoom_pau][value]" id="cg_zoom_pau" type="number" class="cg_zoom_pau validate" value="<?php echo $this->settings[ 'cg_zoom_pau' ][ 'value' ] ?? ''; ?>" min="70" max="200" step="10" />
							<label for="cg_zoom_pau"><?php _e( "PAU Zoom (from 30% to 200%)", "pau-universal-accessibility" ); ?></label>

				        </div>
					</div>

					</legend>

				</fieldset>

			</div>
		</div>

	</div>
	<!-- // Ajuste por defecto // -->

	<div id="pauDesign" class="col s12 p20 pauContentSettings">
		<div class="row">
			<div class="col s12 descriptionPage">
				<?php
				/* translators: Respect the html tags */
				_e( "
							<p>In this section you can customise the design and styles of your PAU panel.</p>
				", "pau-universal-accessibility" ); ?>
			</div>
		</div>

		<h3>
			<?php _e( "COMING SOON", "pau-universal-accessibility" ); ?>
		</h3>

	</div>

	</form>
	<div class="capaSemiTransparente">
		<button type="button" class="btn-pau btn-pau pau-bg-verde pau-guardar pin-bottom" id="pauSaveSettings"><?php _e( "Save", "pau-universal-accessibility" ); ?> &nbsp;<i class="material-icons">save</i></button>
	</div>
</div>
