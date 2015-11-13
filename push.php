<?
$titulo = $_POST["titulo"];
$mensaje = $_POST["mensaje"];
$programado = $_POST["schedule"];
$date = $_POST["date"];
$time = $_POST["time"];

$timeZone = new DateTimeZone("America/Monterrey");
$utc = new DateTimeZone("UTC");
$fechaEnvio = new DateTime($date." ".$time, $timeZone);
$fechaEnvio->setTimezone($utc);
//echo $fechaEnvio->format('Y-m-d\TH:i');
if ($titulo && $mensaje) {
    $Curl_Session1 = curl_init('https://api.cloud.appcelerator.com/v1/users/login.json?key=pYxZvtVCUQZ7TEp4H4hKQYWfi54FY5yK');
    curl_setopt ($Curl_Session1, CURLOPT_RETURNTRANSFER, true);
    curl_setopt ($Curl_Session1, CURLOPT_POSTFIELDS, "login=otniel.gomez@sorteostec.mx&password=qwe123/*-");
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
        $Curl_Session2 = curl_init('https://api.cloud.appcelerator.com/v1/push_notification/notify.json?key=pYxZvtVCUQZ7TEp4H4hKQYWfi54FY5yK&_session_id='.$session->meta->session_id);
        curl_setopt ($Curl_Session2, CURLOPT_POSTFIELDS, "payload=".json_encode($obj->payload)."&channel=news_alerts&to_ids=everyone");
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
        $Curl_Session2 = curl_init('https://api.cloud.appcelerator.com/v1/push_schedules/create.json?key=pYxZvtVCUQZ7TEp4H4hKQYWfi54FY5yK&_session_id='.$session->meta->session_id);
        curl_setopt ($Curl_Session2, CURLOPT_POSTFIELDS, "schedule=".json_encode($obj->schedule)."");
    }
    curl_exec($Curl_Session2);
    curl_close ($Curl_Session2);
} else {
	echo "Escriba titulo y mensaje de la notificacion.";
}
?>