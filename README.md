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



## 3. Implementar modificaciones al código para mitigar los ataques XSS

