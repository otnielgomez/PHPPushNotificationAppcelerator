<?
$titulo = $_POST["titulo"];
$mensaje = $_POST["mensaje"];
$programado = $_POST["schedule"];
$date = $_POST["date"];
$time = $_POST["time"];

$timeZone = new DateTimeZone("America/Monterrey"); //***IMPORTANTE CAMBIAR LA ZONA HORARIA LOCAL
$utc = new DateTimeZone("UTC");
$fechaEnvio = new DateTime($date." ".$time, $timeZone);
$fechaEnvio->setTimezone($utc);
if ($titulo && $mensaje) {
    $Curl_Session1 = curl_init('https://api.cloud.appcelerator.com/v1/users/login.json?key=<KEY>'); //CAMBIAR <KEY> POR EL APP KEY
    curl_setopt ($Curl_Session1, CURLOPT_RETURNTRANSFER, true);
    curl_setopt ($Curl_Session1, CURLOPT_POSTFIELDS, "login=<ADMIN EMAIL>&password=<ADMIN PASSWORD>"); //CAMBIAR <ADMIN EMAIL> Y <ADMIN PASSWORD>
    $res = curl_exec ($Curl_Session1);
    $session = json_decode($res);
    if ($programado === "false") {
        //SE MANDA INMEDIATAMENTE
        $payload->title = $titulo;
        $payload->alert = $mensaje;
        $payload->icon = "/appicon.png";
        $payload->badge = "";
        $payload->vibrate = true;
        $payload->sound = "default";
        $obj->payload = $payload;
        $Curl_Session2 = curl_init('https://api.cloud.appcelerator.com/v1/push_notification/notify.json?key=<KEY>&_session_id='.$session->meta->session_id); //CAMBIAR <KEY> POR EL APP KEY
        curl_setopt ($Curl_Session2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($Curl_Session2, CURLOPT_POSTFIELDS, "payload=".json_encode($obj->payload)."&channel=news_alerts&to_ids=everyone"); //CAMBIAR channel O to_ids SEGUN SE REQUIERA
    }else{
        //SE PROGRAMA NOTIFICACION
        $payload->title = $titulo;
        $payload->alert = $mensaje;
        $payload->icon = "/appicon.png";
        $payload->badge = "";
        $payload->vibrate = true; 
        $payload->sound = "default";
        $push_notification->payload = json_encode($payload);
        $push_notification->channel = 'news_alerts';
        $schedule->name = "Push Schedule";
        $schedule->start_time = $fechaEnvio->format('Y-m-d\TH:i');
        $schedule->push_notification = $push_notification;
        $obj->schedule = $schedule;
        $Curl_Session2 = curl_init('https://api.cloud.appcelerator.com/v1/push_schedules/create.json?key=<KEY>&_session_id='.$session->meta->session_id); //CAMBIAR <KEY> POR EL APP KEY
        curl_setopt ($Curl_Session2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($Curl_Session2, CURLOPT_POSTFIELDS, "schedule=".json_encode($obj->schedule)."");
    }
    $response = curl_exec($Curl_Session2);
    $response = json_decode($response);
    $response = $response->meta;
    curl_close ($Curl_Session2);
} else {
	echo "Escriba titulo y mensaje de la notificacion.";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Status: <?=$response->status?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript">
            history.pushState(null, null, location.href);
            window.onpopstate = function(event) {
                history.go(1);
            };
        </script>
    </head>
    <body>
    <div class="container">
        <? if ($response->status === "ok"): ?>
            <div class="row">
                <div class="alert alert-success" role="alert">
                  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                  <strong>OhYeah!</strong>
                  Se envio el mensaje. :D
                </div>
                <div style="margin-top:15px;">
                    Si no eres redirijido en <label id="numero">10</label>, da click <a href="<URL>/enviar.html">aqui</a> <!--CAMBIAR <URL> POR DONDE SE ENCUENTRE HOSPEDADO -->
                </div>
            </div>
            <script type="text/javascript">
            var numero, segundos;
                setInterval(function() {
                    numero = parseInt(document.getElementById('numero').innerText);
                    segundos = numero - 1;
                    document.getElementById('numero').innerText = segundos;
                    if (segundos == 1) {
                        window.location = "<URL>/enviar.html" //CAMBIAR <URL> POR DONDE SE ENCUENTRE HOSPEDADO
                    };
                }, 1000);
            </script>
        <? else: ?>
            <div class="row">
                <div class="alert alert-danger" role="alert">
                  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                  <strong>¡Ups!</strong>
                  <?=$response->message?>
                </div>
                <div style="margin-top:15px;">
                    <a href="<URL>/enviar.html">Volver a intentar</a> <!--CAMBIAR <URL> POR DONDE SE ENCUENTRE HOSPEDADO -->
                </div>
            </div>
        <? endif ?>
    </div>
    </body>
</html>
