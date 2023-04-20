<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notificacao</title>
</head>
<body>
<h2>Enviar notificacao</h2><a href="send_notification.php">aqui</a>

<p id="token"></p>
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
                console.log("Notificação ativada");
                return messaging.getToken();
            })
            .then(function (token) {
                console.log("Token : "+token);
            })
            .catch(function (reason) {
                console.log(reason);
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
                window.open(payload.notification.click_action,'_blank');
                notification.close();
            }
        }

    });
    messaging.onTokenRefresh(function () {
        messaging.getToken()
            .then(function (newtoken) {
                console.log("New Token : "+ newtoken);
            })
            .catch(function (reason) {
                console.log(reason);
            })
    })
    IntitalizeFireBaseMessaging();
</script>
</body>
</html>