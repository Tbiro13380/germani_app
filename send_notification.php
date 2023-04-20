<form method="post" action="send_notification.php">
Title<input type="text" name="title">
Message<input type="text" name="message">
<!--Icon path<input type="text" name="icon">-->
<input type="submit" value="Send notification">
</form>

<?php

include_once("config/conexao.php");
include_once("config/funcoes.php");


function sendNotification($token){
    $url ="https://fcm.googleapis.com/fcm/send";

    $fields=array(
        "to"=>$token,
        "notification"=>array(
            "body"=>$_REQUEST['message'],
            "title"=>$_REQUEST['title'],
        )
    );

    $headers=array(
        'Authorization: key=AAAA9bFqYAg:APA91bGgiX0GRffLU8XnVcgbqZRw-VSU152XV6vb3GwkIldaSGPsTMmArZj-Q0rpUBiX9uQA4ziH9Y-QVOQNBfgV7l4qllBo8k0f3TvBeyr23nHf7KIlhwAu19mm0gPu5Ov7aMzrCKP7',
        'Content-Type:application/json'
    );

    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($fields));
    $result=curl_exec($ch);
    print_r($result);
    curl_close($ch);
}

$sql = "SELECT * FROM notificacao_tokens";

foreach($conn->query($sql)->fetchAll(PDO::FETCH_OBJ) as $token){
    sendNotification($token->token); 
}
?>