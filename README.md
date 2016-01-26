# PHPPushNotificationAppcelerator

Este es un ejemplo de como hacer push notifications en appcelerator utilizando el appi en PHP.

https://otnielgomez.wordpress.com/2016/01/26/push-notifications-appcelerator-php/

Primero que nada y antes de empezar con código tenemos que saber que se necesitan varios elementos para que nuestro sistema de notificaciones con PHP funcione (Esto infiriendo que nuestra aplicación ya tenga la habilidad de recibir y que podamos enviar y/o programar notificaciones desde el dashboard o platform de Appcelerator).

1. Crear Usuario de Push
Debemos crear un usuario que es el que usaremos como método de acceso al API de Appcelerator para poder mandar nuestras notificaciones.

Se debe accesar a https://platform.appcelerator.com/ y dentro del menú “Apps” entramos a nuestra aplicación.

Despues vamos al menú Arrow (Damos Click en el ArrowDB que tengamos) > Manage Data > Users > Create User.

Es importante que llenemos los campos lo mejor posible, guardar el email y la contraseña ya que las usaremos después,  y recordar que el usuario que vamos a crear tiene que ser un ADMIN de lo contrario no podremos accesar al API.

2. Obtener el App Key
Esta es la llave que nos da el acceso al API. Esta llave es unica y se obtiene en Configuration > Keys.

3. Código
Tenemos la documentación de Appcelerator que podemos seguir pero aquí dejo el código 100% funcional.

PHPPushNotificationAppcelerator

Son simples 2 archivos 1 HTML y 1 PHP, abriéndolos veremos en los comentarios las cosas que tenemos que cambiar para que nos funcionen.

Este proyecto esta programado de manera que podamos enviar notificaciones al instante como programarlas.

*Para que funcione la programación de las notificaciones es importante en el archivo push.php cambiar la zona horaria por la que corresponda donde nos encontremos.

Dentro de este mismo archivo se encuentra señalado donde tenemos que poner nuestro email, password, y el APP Key que nos arroja el dashboard para hacer la conexión con el API, así como el Channel si especificamos alguno en nuestra App o a quien se lo estaremos enviando, por default se encuentra to_ids=everyone.

De igual manera se encuentra indicado tanto en el html como en el php algunas <URL> que tenemos que cambiar si es que subimos este código a algún sitio.

Ejemplo
El ejemplo funcional se encuentra en mi sitio en la siguiente liga: http://gomezz.info/pushNotifications/enviar.html

Comentarios adicionales
La funcionalidad de esta consola es muy sencilla: 

 1. Seleccionar si se quiere Enviar Ahora o Programar Envío.

Enviar Ahora: Se enviara la notificación inmediatamente después que se oprima el botón Enviar.

Programar Envío: Se tiene que seleccionar una Fecha y Hora (NOTA: LA HORA TIENE QUE ESTAR EN HORARIO MILITAR. EJEMPLO: 19:00 se enviara a las 7pm).

 2. Ingresar un Titulo

 3. Ingresar el Mensaje

 4. Dar click en Enviar y nos aparecera una pantalla con un menaje en verde que nos dice que se a “enviado o a quedado programado” nuestro mensaje.

NOTA: Se pueden enviar emojis en el titulo o en el mensaje.

