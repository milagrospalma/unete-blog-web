# Blog Unete - blog.uneteabelcorp.com

Blog de Unete para belcorp

* Jefe de proyecto: Pamela de la Cruz *<pamela.delacruz@altimea.com>*
* Líder técnico: Hegel Chamba *<hegel.chamba@altimea.com>*

## Copiar archivos de seguridad
* Copiar el directorio wflogs-template que esta dentro de  project_files_template y pegarlo dentro de wp-content y renombrarlo a wflogs
* Copiar el archivo wordfence-waf.php en la carpeta raiz 

## ¿Cómo montar el proyecto en local?
* Clonar el repositorio al lugar de tu elección
* Hacer una copia del archivo **app/project_files_templates/htaccess-template** (**IMPORTANTE** hacer una copia a partir de este archivo para tener las variables necesarias.)
* Pegar el archivo en **app/**, renombrarlo a .htaccess

* Hacer una copia del archivo **app/project_files_templates/object-cache.php**
* Pegar el archivo en **app/wp-content/object-cache.php**, se tiene que tener el plugin de cache de redis activado.

* Hacer una copia del archivo **app/wp-config-template.php** (**IMPORTANTE** hacer una copia a partir de este archivo para tener las variables necesarias.)
* Modificar el archivo anterior modificando la url donde va a estar tu proyecto localmente, así como el usuario, clave y nombre de la base de datos. En total, se deberá cambiar los siguientes valores:

>define('WP_HOME','http://local.uneteabelcorp.com/');

>define('WP_SITEURL','http://local.uneteabelcorp.com/');

>define('DB_NAME', 'nombredetubasededatos');

>define('DB_USER', 'nombredeusuario');

>define('DB_PASSWORD', 'contraseña');

* Modificar el wp-config.php los valores de conexion a redis.

>define('WP_REDIS_HOST', '127.0.0.1');

>define('WP_REDIS_PORT', 6379);

* Modificar el wp-config.php los valores de google recaptcha.

>define('RECAPTCHA_SITEKEY', '');

>define('RECAPTCHA_SECRETKEY', '');


* En la carpeta database se encuentra el script sql, importar en tu base de datos - phpmyadmin o en workbench
* Modificar el archivo **app/database/blogunete.sql**. Cambiar el valor del dominio que le hayas asignado al proyecto en tu virtualhost. Ejemplo: **local.uneteabelcorp.com** y ejectuar el script.

* Modificar el archivo **app/wp-content/themes/unete/gulpconfig.js**. Cambiar el valor del proxy de BrowserSync al dominio que le hayas asignado al proyecto en tus virtualhost. Ejemplo:

```javascript
browsersync: {
files: [build+'/**', '!'+build+'/**.map'] // Exclude map files
, notify: false // In-line notifications (the blocks of text saying whether you are connected to the BrowserSync server or not)
, open: true // Set to false if you don't like the browser window opening automatically
, port: 3000 // Port number for the live version of the site; default: 3000
, proxy: 'local.uneteabelcorp.com' // We need to use a proxy instead of the built-in server because WordPress has to do some server-side rendering for the theme to work
, watchOptions: {
debounceDelay: 2000 // This introduces a small delay when watching for file change events to avoid triggering too many reloads
}
},
```
* Asegurarse de tener instalado nodejs/npm y sus paquetes gulp y yarn
* Para instalar esos dos paquetes ejectuar:
    * sudo npm install -g gulp yarn
* Abrir una terminal en **app/wp-content/themes/unete/assets/** y ejectuar los siguientes comandos:
* npm install
* En la misma terminal de antes, situada en **app/wp-content/themes/unete/assets/** ejecutar:
* gulp
* El comando anterior hará todas las tareas automáticas configuradas y abrirá un nuevo navegador con el WordPress. Notar que la url que os dará será **http://localhost:3000**. Esta url será la que se podrá usar para ver en tiempo real los cambios que se hagan en el código, pero también estará disponible la url que hayas configurado en tu virtualhost, salvo que tendrás que recargar manualmente cada vez que quieras ver un cambio. Ambas url funcionan al 100%.


## Organización del proyecto
**IMPORTANTE:** Todo el desarrollo se realiza en la carpeta *app/wp-content/themes/unete/* y es la herramienta GULP la encargada de colocar todo como debe.

### Estilos
Se está usando Sass como precompilador de CSS. Podrás encontrar toda la jerarquía de archivos en:
```
app/wp-content/themes/unete/assets/sources/scss/
```

* El archivo style.css solo se modificará para añadir librerías externas de CSS. Actualmente, el proyecto emplea:
* Bourbon: Colección de mixins
* Normalize
* La carpeta base contiene archivos generales a toda la aplicación:
* _animations.scss: Animaciones CSS
* _fonts.scss: Fuentes
* _globals.scss: Estilos globales por ejemplo aplicados a body, html, a...
* _helpers.scss: Clases para facilitarte la vida como para convertir a uppercase.
* _icons.scss: Iconos CSS
* _variables.scss: Definición de las variables SCSS a usar en el proyecto.
* La carpeta responsive será la contenedora de los ajustes globales para diferentes tamaños de viewport. No se usará para estilos concretos de secciones, los cuales deberán ir en la siguiente área.
* La carpeta sections contendrá los estilos en archivos individuales de cada sección (contacto, ayuda, header, footer...).

### Sass utils core or use https://v4-alpha.getbootstrap.com/layout/overview/#responsive-breakpoints
Use sass mixin responsive helpers file in `sass/mixin/_media_queries.scss`

Example use `@include maxw(xs){};` for  `@media (max-width: 575px){};`

Or use `@include minw(xs){};` for  `@media (min-width: 576px){};`
#### Input sass example
```sh
.my-component{
// use example props test
width: 25%;
font-size: 15px;
&__title{
    color: blue;
}
// use max-width
@include maxw(xs){
    width: 75%;
}
// use min-width
@include minw(xs){
    font-size: 18px;
}
}
```
#### Output css
```sh
.my-component{
width: 25%;
font-size: 15px;
}
.my-component__title{
color: blue;
}
@media (max-width: 575px) {
.my-component{
    width: 100%;
}
}
@media (min-width: 576px) {
.my-component{
    font-size: 18px;
}
}
```

#### Existing mixin media queries:
Mixin `maxw($breakpoint)` with parameters **lg** = 1199px , **md** = 991px , **sm** = 767px , **xs** = 575px.

Example `@include maxw(lg){...};`  output  `@media (max-width: 1199px){...};`

Mixin `minw($breakpoint)` with parameters **lg** = 1200px , **md** = 992px , **sm** = 768px , **xs** = 576px.

Example `@include minw(xs){...};`  output  `@media (max-width: 576px){...};`


### Javascripts 
Se configuró el proyecto para que separe nuestros scripts en 2 archivos.
* Los plugins o librerías externas irán almacenados en unete-plugins.js. Estas librerías se deberán instalar mediante bower y es necesario modificar el archivo gulpconfig.js para indicarle los nuevos scripts.
* Nuestro código de aplicación irá en unete-core.js

El archivo core.js que será donde trabajaremos nuestra aplicación se encuentra en **app/wp-content/themes/unete/assets/sources/js/**

NOTA: Los plugins de terceros que se instalen en WordPress es posible que inserten más scripts, pero en todo caso serán insertados en el footer.

### PHP
Los archivos PHP se intentarán ordenar en lo máximo posible dentro de **app/wp-content/themes/unete/inc/**, a excepción de los Templates

Actualmente se encuentran 5 carpetas y un archivo ahí:

* assets.php: Este archivo es el encargado de encolar estilos y javascripts de nuestra plantilla.
* actions: Aquí crearemos nuestros actions de WordPress
* filters: Aquí crearemos nuestros filters de WordPress
* custom_posts: Aquí crearemos nuestros custom_posts de WordPress
* custom_fields: Aquí especificaremos los custom fields creados con la herramienta "Advanced Custom Fields"

- Los Templates estarán en la carpeta **app/wp-content/themes/unete/templates/**

### Error ejecute GULP  ENOSPC
For Arch Linux add this line to:

sudo nano /etc/sysctl.d/99-sysctl.conf

fs.inotify.max_user_watches=524288

Then execute:

sysctl --system


### El archivo Robots.txt debe contener lo siguiente:
```sh
User-agent: *
Disallow: /wp-login
Disallow: /wp-admin
Disallow: //wp-includes/
Disallow: /*/feed/
Disallow: /*/trackback/
Disallow: /*/attachment/
Disallow: /author/
Disallow: /*/page/
Disallow: /*/feed/
Disallow: /tag/*/page/
Disallow: /tag/*/feed/
Disallow: /page/
Disallow: /comments/
Disallow: /xmlrpc.php
Disallow: /*?s=
Disallow: /*/*/*/feed.xml
Disallow: /?attachment_id*

```

### Imágenes
Durante el proceso de creación de la versión de producción se optimizan todas las imágenes que tengamos en nuestra plantilla.

Las imágenes se almacenan en **app/wp-content/themes/unete/img/**

**IMPORTANTE:** Siempre que sea posible, organizar las imágenes en subcarpetas para mantener un órden.

Para enlazar imágenes en los CSS, hay una variable que te da el root de la carpeta que las contiene llamada **$imagesPath**

### Fuentes
Las fuentes se encuentran ordenadas en subcarpetas por su familia en **app/wp-content/themes/unete/fonts/**

Las fuentes se declaran en el archivo de fuentes de Sass utilizando un mixin de Bourbon para conseguir importar todos los formatos en una sola línea. Ejemplo:

```
@include font-face("dinnext-regular", $icon-font-path + "dinnext/DINNextLTPro-Regular", $file-formats: eot woff ttf svg);
```

### Idiomas (archivos .pot)
El proyecto ha sido pensado para ser multilenguaje, por lo que el desarrollo debe ser acorde.
* Todas las cadenas de texto deberán insertarse usando las funciones de gettext. Su valor por defecto será en español y el dominio
será 'unete_template':
```
<h1><?php _e('Esto es una prueba', 'unete_template'); ?></h1>
```
* Para generar el archivo .pot para traducciones, existe una tarea de gulp. El archivo generado es puesto en src/languages
```
gulp potfiles
```

Para mayor información consultar: https://codex.wordpress.org/I18n_for_WordPress_Developers


## Otras consideraciones a la hora de trabajar en el proyecto

* El idioma principal del proyecto es el Inglés
* Todas las variables deberán ser especificadas en inglés, tanto de PHP, javascript como clases de CSS
* Es preferible que se comente el código en inglés, pero en este caso podrá ser usado el español si se va a representar mejor la información que quieres transmitir.
* La tabulación por defecto del proyecto es tabulación de 4 spaces. Esta configuración está especificada en el archivo .editorconfig
* Es primordial contar con una extensión para linteo de javascripts en el editor que se vaya a utilizar. Por ejemplo:
* El HTML deberá ser correctamente formateado en cascada evitando comprimir varias etiquetas en una sola línea para poder leer más fácilmente el código. Una herramienta automatizada es la encargada luego de comprimir todo el HTML.
* No dejar atributos HTML vacíos como name o id. Si no se necesitan no se ponen.
* No dejar código comentado salvo casos de fuerza mayor. Si se necesita ver versiones anteriores de código se usará GIT.
* En la cabecera de nuestras funciones, poner un pequeño comentario con la funcionalidad de esa función, así como detallar qué parámetros recibe la función y qué devuelve, si es que devuelve algo. Ejemplo:

```
/**
* Method to change the graph to the selected time frame
* @param  {string} type "Type of group to return its value"
* @param  {array} item
*/
```
## Fixed bug in Total Cache while upstream answers

El plugin de Total Caché a la hora de escribir este reporte, cuenta con un bug
que causa que los scripts y estilos que son procesados y combinados por el minify, teniendo
la opción de HTTP/2 activada, sean descargados 2 veces por los navegadores.

La primera vez es descargado con la url de la web, y la segunda con la del CDN.

Esto es a raíz del header para preload de HTTP/2 que configura Total Cache para dar soporte
a los usuarios del CDN CloudFlare, en el cual colocan la URI al css sin el dominio, por lo que el
navegador por defecto hace el preload con la URL del a web, y acto seguido, como está en el HTML con la
URL del CDN, el asset es de nuevo descargado con la url del CDN.


Existe un issue abierto en el Github del proyecto Total Cache de otra persona con el mismo
problema, y se está esperando a que los desarrolladores contesten a nuestra petición.

Enlace del issue: https://github.com/szepeviktor/w3-total-cache-fixed/issues/514

Se ha procedido a modificar temporalmente el plugin hasta que upstream de una contestación.

El archivo modificado es:

app/wp-content/plugins/w3-total-cache/Minify_Plugin.php  en la línea  1325

$domain = Dispatcher::component( 'Cdn_Core' )->get_cdn()->get_prepend_path($uri);

Se obtiene el dominio del CDN y se concatena
 
## Qué poner en los commits o Pull Requests
* En el caso de los desarrolladores, estos valores pueden ponerlos directamente en el nombre del pull request, en vez
de cada commit.

#### Añade un plugin
>[new plugin] Added `plugin_name`

>[new plugin] Added Advanced Custom Fields PRO

#### Modifica un plugin
>[`plugin_name`] `Modification description`

>[altimea-connector-hybris] Refactoring of connection logic

#### Elimina un plugin
>[remove plugin] Removed `plugin_name`

>[remove plugin] Removed Advanced Custom Fields PRO

#### Nueva característica
>[feature] `Feature description`

>[feature] Ability to send emails from custom form

#### Fix
>[fix] `Fix description`

>[fix] Fixed wrong analytics value

#### Documentación
>[doc] `Description`

>[doc] Added these cases in README.md

#### Infraestructura
>[arch] `Description`

>[arch] Modified Dockerfile

#### Actualización
>[update] `package_name or library` updated to `new_version`

>[update] WordPress updated to 5.8

#### Otros
>[others] `Description`

>[others] Blank line