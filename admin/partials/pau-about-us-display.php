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

echo $this->getTitleMenuPage( "about-us2.svg" );


?>
<div class="container">
<!---html de pagina de bienvenida de PAU --->
<div class="wrap">

    <!--<div id="config-about-us-text"> -->
    <div class="row">
        <div class="col s12 descriptionPage">

        <?php
        /* translators: Respect the html tags */
        _e( '<h2 class="abouTitle about1">We are Accessibility and Inclusion</h2>
        <div class="barra"></div>
        <p>We are professionals with diverse capacities, and our objective is to create a working environment that allows us to channel diversity in the search for solutions to develop universally accessible communication, assuming the challenges that innovation stands for. Both in the development of computer tools and work integration processes.</p>', 'pau-universal-accessibility' );
        /* translators: Respect the html tags */
        _e( '<h2 class="abouTitle about2">We don’t say, we do</h2>
        <div class="barra"></div>
        <p>We have constituted ourselves as a Limited Labor Company because our roots are born within the social, solidary and equitable economy.</p>
        <p>Equality of opportunity, the right to work, to be self-sufficient, the dream in a full life is common to all people.</p>', 'pau-universal-accessibility' );
        ?>
        <img src="
        <?php echo PAU_DIR_URL. '/admin/img/todos-1024x483.jpg' ?>
        " alt="Estudio Inclusivo Team">
        <?php
        /* translators: Respect the html tags */
        _e( '<h2 class="abouTitle about3">Diversity working for Accesibility</h2>
        <div class="barra"></div>
    	<p>We live in the communication age. For those who have limited mobility and understanding, being able to access telematic channels of information can mean a radical change in their lives.</p>
    	<p>In Inclusive Studio (Estudio Inclusivo) we think that obstacles are opportunities that are disguised and that, with effort, will and a lot of love, can be overcome.</p>', 'pau-universal-accessibility' );
        /* translators: Respect the html tags */
        _e( '<p>In the same way, facilitating access and telematic navigation can bring commercial initiatives to a greater number of potential customers.</p>
        <p>We firmly believe that technological development provides us with tools capable of breaking the barriers that many people find when it comes to acquiring information due to their diversity, training and age.</p>', 'pau-universal-accessibility' );
        /* translators: Respect the html tags */
        _e( '<p>Through the research it is possible to innovate in the development of new tools that allow implementing accessibility in digital communication without the need to have programming knowledge. These tools include in the computer work market those people who, due to their diversity, have limited access to it, and allow them to develop their potential. Integration gives independence. Only by providing adequate support and tools to people is effective labor insertion achieved.</p>', 'pau-universal-accessibility' );

        /* translators: Respect the html tags */
        _e( '<h2 class="abouTitle about4">The person in charge of the project, "The teacher":</h2>' , "pau-universal-accessibility" );
        ?><div class="barra"></div>
        <div class="row">
            <div class="col s8">
                <?php
                /* translators: Respect the html tags */
                _e( '<p>This project has gone out to the public thanks to the indispensable help of <b>Gilbert Rodríguez</b>, who started being our on-line professor at <a href="https://www.udemy.com/user/gilbert-rodriguez/" target="_blank">Udemy (view his courses)</a>, and I have just led the project, being one of the family. Great teacher, but also great professional and great person, who allowed us to make this dream come true.</p>', "pau-universal-accessibility" );
                ?>
            </div>
            <div class="col s4">
                <img src="
                <?php echo PAU_DIR_URL. '/admin/img/gilbert.jpg' ?>
                " alt="Gilbert Rodriguez" class="foto-circular">
            </div>
        </div> <!--fin row-->
        <?php
        /* translators: Respect the html tags */
        _e( '<h2 class="abouTitle about4">Do you want to know more?</h2>' , "pau-universal-accessibility" );
        ?><div class="barra"></div><?php

        /* translators: Respect the html tags */
        _e( '<p>More information on our web: <a href="https://inclusivestudio.eu/?lang=en" target="_blank">www.inclusivestudio.eu</a></p>', "pau-universal-accessibility" );

        ?>
    	</br>
    	<img alt="<?php esc_attr_e( "Logo of Inclusive Studio", "pau-universal-accessibility" ); ?>" src="<?php echo PAU_MULTIMEDIA_PAU . 'img/logo-ei.png'?>">
    	</p>
        </div>
    </div>

</div>
</div> <!-- end of container div -->
