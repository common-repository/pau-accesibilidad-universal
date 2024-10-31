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

// Este archivo debe consistir principalmente en HTML con un poco de PHP. */

echo $this->getTitleMenuPage( "pau.svg" );

?>
<div class="container">
    <!---html de pagina de bienvenida de PAU --->
    <div class="wrap">
        <h1 class="abouTitle"><?php _e('The best path is that one that does not end' , 'pau-universal-accessibility' ); ?></h1>
        <div class="barra"></div>
        <div id="config-wellcome-text">
            <div class="row">
                <div class="col s12 descriptionPage">
                <?php
                /* translators: Respect the html tags */
                $pageDescription = __( '
                    <p>In this section, in the near future, a control of the accessibility status will be carried out throughout the web, until then, allow us to give you a brief introduction of how we got here..
            		</p>
            		<p>In order to be able to develop this plugin in an inclusive way (with mixed teams of people with disabilities and without them), previously there have been 5 years of research and development to detect and create the necessary tools to carry out an inclusive communication on the web, a contrasted and collaborative work with the different organisations and associations of the disability sector.</p>
                    <p>In addition, it has been necessary to find talents within the disability sector and outside of it, to create and form a team of hopeful people, who develop under criteria of labor inclusion, in an economic organisation (Estudio Inclusivo) framed in the social economy, where people and the social good of their products are the epicentre.</p>
                    <p>To achieve these results, in an environment that is a new economic and social-labor paradigm, they have had to create, adapt, discuss and improve numerous work protocols, customised to the diversity of each component of the team, carried out jointly by the coordinators. of equipment and psychologists.
                    </p>
                    <p>That said, we hope you enjoy using this plugin that allows a use of a web without barriers, and that you are also so satisfied that you recommend it, allowing us to continue generating a social value chain.</p>' , 'pau-universal-accessibility' );

                    $allowsTags = [
                        "p" => []
                    ];

                    echo wp_kses( $pageDescription, $allowsTags );

                ?>

                <p>
                    <?php
                    /* translators: Respect the html tags */
                     echo wp_kses( __( 'For more information, visit our website: <a href="https://inclusivestudio.com" target="_Blank">www.inclusivestudio.com</a>' , 'pau-universal-accessibility' ), [
                             "a" => [
                                 "href" => [],
                                 "target" => [],
                             ]
                         ] ); ?>
                </p>

        <br><br>
                <img alt="<?php esc_attr_e( "Logo of Inclusive Studio", "pau-universal-accessibility" ); ?>" src="<?php echo PAU_MULTIMEDIA_PAU . 'img/logo-ei.png'?>">

                </div>
            </div>
            </div>
    </div>
</div> <!-- end of container div -->
