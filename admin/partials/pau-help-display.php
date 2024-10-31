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
echo $this->getTitleMenuPage( "help.svg" );
?>
<div class="container">
        <div class="row">
            <div class="col s12 descriptionPage">
                <p style="text-align: center;">
                    <?php _e( 'Here you will find all the documentation and regarding help of the plugin pau.' , 'pau-universal-accessibility' ); ?>
                </p>

                <p style="text-align: center; font-size: 2em;">
                    <?php _e( 'Click on the type of that help you prefer:' , 'pau-universal-accessibility' ); ?>
                </p>
                <br>
                <p style="text-align: center; font-size: 2em;">

                     <?php
                     /* translators: Respect the html tags */
                      _e( '<a href="https://estudioinclusivo.com/products/panel-de-accesibilidad-universal/documentation-plugin-pau/?lang=en" target="_blank"> User manual / FAQ / Video tutorials </a>' , 'pau-universal-accessibility' ); ?>
                 </p>
             </div>
        </div>
</div> <!-- end of container div -->
