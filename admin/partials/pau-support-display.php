<?php

/**
 * Proporcionar una vista de área de administración para el plugin
 *  
 * Este archivo se utiliza para marcar los aspectos de administración del plugin.
 *  
 * @link       https://estudioinclusivo.com
 * @since      desde 1.0.0
 *
 * @package    pau
 * @subpackage pau/admin/parcials
 * */

/* Este archivo debe consistir principalmente en HTML con un poco de PHP. */
echo $this->getTitleMenuPage( "support.svg" );
?>
<div class="container">

	<p style="text-align: center; font-size: 1.5em;">
		<?php _e( 'Technical support is uniquely limited to PRO Licenses. Please attach the license key to your incident, thank you.', 'pau-universal-accessibility' ); ?>
	</p>
	<p style="text-align: center; font-size: 1.5em;">
		<?php _e( 'Without license or pro version, you can use the forums that you have of the plugin in wordpress.' ); ?>
	</p>
	<br>
	<p style="text-align: center; font-size: 2em;">
		<?php _e( 'Click on the type of support you need:', 'pau-universal-accessibility' ); ?>
	</p>
	<br>
	<p style="text-align: center; font-size: 2em;">

		<?php
		/* translators: Respect the html tags */
		_e( '<a href="https://estudioinclusivo.com/contacto/?lang=en" target="_blank"> Billing / Commercial / Technical support </a>', 'pau-universal-accessibility' ); ?>
	</p>

</div> <!-- end of container div -->
