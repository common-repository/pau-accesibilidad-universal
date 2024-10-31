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

//   /* Este archivo debe consistir principalmente en HTML con un poco de PHP. */
echo $this->getTitleMenuPage( "suppliers.svg" );

?>

<div class="row">
	<div class="col s12">
		<section>
			<h2 class="abouTitle"><?php _e( 'INCLUSIVE STUDIO SERVICES:' , 'pau-universal-accessibility' ); ?></h2>
			<div class="barra"></div>

			<div class="container">
				<p style="text-align: center;font-size: 2em;">
					<?php _e( 'Forget about everything. Inclusive Studio does it all for you, generating inclusive employment.' , 'pau-universal-accessibility' ); ?>
				</p>
				<p style="text-align: center;font-size: 1.5em;">
					<?php _e( 'We buy and put the Pro Version, we configure everything you want, and we put all the pictograms, audios and sign language you need.' , 'pau-universal-accessibility' ); ?>
				</p>
				<p style="text-align: center;font-size: 2em;">
					<a href="https://estudioinclusivo.com/contacto/?lang=en" target="_blank">
					<?php _e( 'ASK FOR BUDGET WITHOUT COMMITMENT' , 'pau-universal-accessibility' ); ?>
					</a>
				</P>
			</div> <!-- end of container div -->
		</section>
		<br><hr>
	</div>
</div>

<div class="container">
<?php
PAU_Helpers::precargador();
?>


</div> <!-- end of container div -->
