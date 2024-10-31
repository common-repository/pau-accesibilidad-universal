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
echo $this->getTitleMenuPage( "wordpress-wcag.svg" );
?>

<br/><hr/><h2>ACCESIBILIDAD PARA WORDPRESS</h2><hr/>
<hr/>
<p> <strong>Manual de Accesibilidad de Wordpress<a href="https://make.wordpress.org/accessibility/handbook/" target="_blank">
Mas info</a>
</strong></p>
<p>Abrir ticket en Wordpress sobre Accesibilidad<a href="https://core.trac.wordpress.org/newticket?focuses=accessibility" target="_blank">
Abrir Trac</a>
</p>
<hr/>
<p><label>Añadir Lectura Facil</label></p>
<input type="checkbox" name="auto-lectura-Facil">Habilitar Lectura Facil</input>
<a href="https://desarrollowp.com/blog/tutoriales/como-agregar-un-campo-personalizado-debajo-del-titulo-de-una-entrada/" target="_blank">Mas Información</a>
<br/>
<p><label>Cambiar puntuacion en listados para Lectura Facil</label></p>
<input type="checkbox" name="auto-lectura-Facil">Cambiar puntuacion de listas</input>
<a href="https://css-tricks.com/almanac/properties/l/list-style/" target="_blank">Mas Información</a>
<br/>
<p><label>Eliminar o cambiar, comillas, parrentesis y Siglas para lectura facil</label></p>
<input type="checkbox" name="auto-lectura-Facil">Cambiar elementos complejos de la Lectura facil</input>
<a href="#" target="_blank">BUSCAR Información</a>
<br/>

</br><hr/><p><label>Añadir Pictogramas a las Categorias</label></p>
<input type="checkbox" name="auto-imagenes-categorias">Habilitar imagenes en Categorias</input>
<a href="https://desarrollowp.com/blog/tutoriales/guia-sobre-wordpress-termmeta/" target="_blank">Mas Información</a>
<br/>
<p><label>Añadir Pictogramas a las Etiquetas</label></p>
<input type="checkbox" name="auto-etiquetas-categorias">Habilitar imagenes en Etiquetas</input>
<a href="https://desarrollowp.com/blog/tutoriales/guia-sobre-wordpress-termmeta/" target="_blank">Mas Información</a>
<br/>

<hr/><h4>Mejoras de accesibilidad añadidas por WP Accessibility:
		<a href="https://make.wordpress.org/accessibility/handbook/which-tools-can-i-use/wp-accessibility-plugin/" target="_blank"> Ver </a>
	</h4><hr/>
<ul>
	<li>Activar enlaces de salto con soporte WebKit añadiendo JavasScript para mover el foco del teclado.</li>
	<li>Añade enlaces de salto configurados por el usuario. (Destinos y apariencia personalizable.)</li>
	<li>Añade atributos de idioma y dirección del texto  en tu etiqueta HTML</li>
	<li>Añade un contorno para indicar la recepción del foco en aquellos elementos que permitan recibir foco desde el teclado.</li>
	<li>Añade una barra de tareas para alternar vistas entre alto contraste, vista para impresión y escala de grises en tu tema.</li>
	<li>Añade una descripción larga a las imágenes. Usa el campo “Descripción” de la imagen para añadir descripciones largas.</li>
	<li>Mejora para los atributos ‘alt’ de las imágenes.</li>
</ul>

<hr/>
	<h4> Corregidas en instalacion por defecto de Wordpress, no con otro tema, por ello hay que aplicar
		<a href="https://make.wordpress.org/accessibility/handbook/which-tools-can-i-use/wp-accessibility-plugin/" target="_blank"> Ver </a>
	</h4><hr/>
	<p> Elimina el atributo ‘target’ de los enlaces.
	<p>Fuerza una página de error cuando una búsqueda se ha hecho con una cadena vacía. (Si tu tema tiene un fichero search.php.)</p>
	<p>Elimina atributos ‘tabindex’ de elementos que pueden recibir el foco.</p>
	<p>Elimina atributos ‘title’ de imágenes insertadas en el contenido.</p>
	<p>Elimina atributos ‘title’ redundantes de los listados de páginas, listados de categorías y archivos de menús.</p>
	<p>Añade los títulos de las entradas a los enlaces estándar “leer más”.</p>
	<p>Corrige algunos problemas de accesibilidad en los estilos de administración de WordPress</p>
	<p>Añade etiquetas si no existen, a los campos de formularios estándar de WordPress</p>


<hr/><h1>MAS PLUGINS DE ACCESIBILIDAD</h1><hr/><br/>
<p>
    <ul>
         <li> Post y Paginas Accesibles<li>
         <li> Formularios Accesibles<li>
         <li> Profolio Accesible<li>
         <li> Pictogramas y LSE Accesible de ARASAC<li>
         <li> Constructo Visual Accesible<li>
         <li> Lenguaje Inclusivo<li>

     </ul>
	 <hr/>
	 <h4> OTROS PLUGINS INSTERESANTES </h4>
	 <ul>
		<li> Todos los plugins con el tag de accesibilidad del Repositorio de Wordpress <a href="https://wordpress.org/plugins/tags/accessibility/" target="_blank">
		 Mas info</a>
		</li>
		<li> ACCES MONITOR chekeo con la api de TENON <a href="https://wordpress.org/plugins/access-monitor/" target="_blank">
		 Mas info</a>
		</li>
		<li>One Click Accessibility, añade landmarks automaticamente y crea un sitemap automaticamente <a href="https://wordpress.org/plugins/pojo-accessibility/" target="_blank">
		 Mas info</a>
		</li>
		<li> Video libreria accesible (obsoleto)<a href="https://wordpress.org/plugins/accessible-video-library/" target="_blank">
		 Mas info</a>
		 </li>
	 </ul>
	 <hr/>
	 <h4> OTROS CODIGOS LIBRES INSTERESANTES SOBRE ACCESIBILIDAD</h4>
	 <ul>
		<li> Repositorio de GitHub sobre accesibilididad <a href="https://wordpress.org/plugins/tags/accessibility/" target="_blank">
		 Mas info</a>
		</li>
	</ul>
</p>
