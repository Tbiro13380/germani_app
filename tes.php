<!-- DB -->

Notificacao_clicks
ID
clicks int

Notificao_tokens
ID
token text

<!-- INDEX -->
<script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-messaging.js"></script>
<script>
	var firebaseConfig = {
		apiKey: "AIzaSyAwNKsg_n6Pj7FfqVgJG4_fLIUy2x7OmL4",
		authDomain: "notificacao-41c71.firebaseapp.com",
		projectId: "notificacao-41c71",
		storageBucket: "notificacao-41c71.appspot.com",
		messagingSenderId: "1055243526152",
		appId: "1:1055243526152:web:1146f0bbca8ef2b360b1bd",
		measurementId: "G-J8RH69PT0H"
	};
	
	firebase.initializeApp(firebaseConfig);
	const messaging=firebase.messaging();


	function IntitalizeFireBaseMessaging() {
		messaging
			.requestPermission()
			.then(function () {
				return messaging.getToken();
			})
			.then(function (token) {
				console.log("Token : "+token);
				$.ajax({
					url: 'posts/postToken.php',
					type: "POST",
					data: {'token' : token},
					success: function(){
						return null;
					}
				});
			})
			.catch(function (reason) {
				return null;
			});
	}

	messaging.onMessage(function (payload) {
		
		console.log(payload);
		const notificationOption={
			body:payload.notification.body,
			icon:payload.notification.icon
		};

		if(Notification.permission==="granted"){
			var notification=new Notification(payload.notification.title,notificationOption);

			notification.onclick=function (ev) {
				ev.preventDefault();
				window.open('home','_blank');
				notification.close();
				
				$.ajax({
					url: 'posts/postToken.php',
					type: "POST",
					data: {'click' : 1},
					success: function(){
						return null;
					}
				});
			}
		}

	});

	messaging.onTokenRefresh(function () {
		messaging.getToken()
			.then(function (newtoken) {
				console.log("Novo Token : "+ newtoken);
			})
			.catch(function (reason) {
				console.log(reason);
			})
	})
	IntitalizeFireBaseMessaging();
</script>

<!-- postToken -->

	<?php

		include_once("../config/conexao.php");
		include_once("../config/funcoes.php");

		if(isset($_POST["token"])){
			$sql = "SELECT * FROM notificacao_tokens WHERE token = '".$_POST['token']."'";
			if($conn->query($sql)->rowCount() == true){
				die();
			} else {
				$sql2 = "INSERT INTO notificacao_tokens (`token`) VALUES ('".$_POST['token']."')";
				$conn->query($sql2);
			}
		}
		
		if(isset($_POST["click"])){
			$sql3 = "UPDATE notificacao_clicks SET clicks = clicks + 1";
			$conn->query($sql3);
		}
		

	?>

<!-- ADMIN INDEX -->

<li><a href="pages/notificacoes/notificacoes.html">NOTIFICAÇÕES</a></li>

<!-- Post notificacao -->

<?php

include_once("../../config/conexao.php");
include_once("../../config/funcoes.php");

if(!isset($_POST['descricao'])){
    die(json_encode(array("status" => false, "message" => "Preencha a descrição")));
}

if(!isset($_POST['titulo'])){
    die(json_encode(array("status" => false, "message" => "Preencha o titulo")));
}

function sendNotification($token){
    $url ="https://fcm.googleapis.com/fcm/send";

    $fields=array(
        "to"=>$token,
        "notification"=>array(
            "body"=>$_POST['descricao'],
            "title"=>$_POST['titulo'],
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
    curl_close($ch);
    echo $result;
}

if(!empty($_POST['descricao'] && !empty($_POST['titulo']))){
    $sql = "SELECT * FROM notificacao_tokens";

    foreach($conn->query($sql)->fetchAll(PDO::FETCH_OBJ) as $token){
        sendNotification($token->token); 
    }
    
    die(json_encode(array("status" => true, "message" => "Mensagem Enviada")));
}


?>

<!-- notificacao -->
<form action="pages/postNotificacao.php" id="formNotificacao" method="post">
	<div class="form-group">
		<label for="">Titulo</label>
		<input type="text" style="width: 300px;"  class="form-control" id="titulo" name="titulo">
	</div>
	<div class="form-group">
		<label for="">Descrição</label>
		<input type="text" style="width: 300px;"  class="form-control" id="descricao" name="descricao">
	</div>
	
	<input type="submit" value="Enviar Notificação" id="enviar" class="btn">
</form>

<script>
    $('#enviar').on("click", function(e){
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: "pages/postNotificacao.php",
            data: $('#formNotificacao').serialize(),
            dataType: "json",
            success: function(response){
                if(response.status){
                    swal({
                        title: "Sucesso",
                        text: response.message,
						type: "success"
                    });
                } else {
                    swal("Atenção!", response.message, 'error');
                }
            }
        })
    });
</script>

<br>