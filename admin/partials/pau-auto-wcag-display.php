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
echo $this->getTitleMenuPage( "auto-wcagg.svg" );
?>

<h2>APLICACION AUTOMATICA DE ACCESIBILIDAD WCAG Y SEO</h2>
		<p><label>Eliminar todas las etiquetas Style, y cargarlas en css</label></p>
            <input type="checkbox" name="auto-ielimina-style">Eliminar todas las etiquetas Style</input>
            <a href="https://desarrollowp.com/blog/tutoriales/guia-sobre-wordpress-termmeta/" target="_blank">NO Mas Información</a>
            <br/>
            <a href="https://desarrollowp.com/blog/tutoriales/guia-sobre-wordpress-termmeta/" target="_blank">Cirterio de Accesibilidad x. x .x</a>
            <br/>
        <p><label>Corregir Enlaces de todo el sitio</label></p>
            <input type="checkbox" name="auto-enlaces">Corregir Enlaces</input>
            <a href="https://desarrollowp.com/blog/tutoriales/guia-sobre-wordpress-termmeta/" target="_blank">NO Mas Información</a>
            <br/>
            <a href="https://desarrollowp.com/blog/tutoriales/guia-sobre-wordpress-termmeta/" target="_blank">Cirterio de Accesibilidad x. x .x</a>
            <br/>
