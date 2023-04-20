<?php
    chaveSite($conn);
    insertVisitor($conn); // Carrega o contador sempre que chamar a home
?>


<section class="login">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
		<form class="px-3 formLogin" method="post" action="#">
			<div class="logo mb-3 text-center">
                <img class="img-fluid mb-3" style="width: 35%" src="assets/img/logo.png">
                <img class="img-fluid" style="width: 65%" src="assets/img/logo-text.png">

                <hr>

				<h5>Siga o andamento do seu serviço</h5>

			</div>
			<div class="form-group mb-3">
				<input type="email" name="email" class="form-control" id="email" placeholder="Email">
			</div>
			<div class="form-group mb-3">
				<input type="password" name="senha" class="form-control" id="senha" placeholder="Senha">
			</div>

			<button type="submit" style="background: #0091c1" class="btn w-100 send sendLogin btn-primary mb-3">Entrar</button>

			<!-- <div class="form-group col-12">
				<a href="#" data-bs-toggle="modal" data-bs-target="#modalRecup" class="text-decoration-none anima lost-mobile col-6 col-xs-6 nopadding text-white" style="text-align: right; float: right;">Esqueceu sua senha?</a>
				<a data-bs-toggle="modal" data-bs-target="#modalLostMail"  href="#" class="text-decoration-none anima lost-mobile col-6 col-xs-6 nopadding text-white">Esqueceu seu e-mail?</a>
			</div> -->
		</form>
      </div>
    </div>
  </div>

    <p class="text-center mt-5">
        Grupo Mega Peres
    </p>

	<script>
        $(document).ready(function(){

            $('.sendLogin').on("click", function(e){
                e.preventDefault();

                $(".send").addClass("disabled");
                $(".send").html("Processando... <span class='fa fa-spinner fa-spin'></span>");

                $.ajax({
                    url: "models/postLogin",
                    type: "POST",
                    dataType: "json",
                    data: $('.formLogin').serialize(),
                    success: function(result){
                        $(".send").removeClass("disabled");
                        $(".send").html("Entrar");

                        if(result.status){
                            window.location = "/app/home"
                        } else {
                            Swal.fire({title: "Atenção!", html: result.message, icon: "error"});
                        }
                    }
                })
            });

            // $('.formRecup').on("submit", function(e){
            //     e.preventDefault(); 

            //     $(".formRecup .sendForgot").addClass("disabled");
            //     $(".formRecup .sendForgot").html("Aguarde...");

            //     var userForgot	= $(".input-userForgot input").val();
            //     var formName    = "formRecup";

            //     $.ajax({
            //         url: "/models/postForgotSenha",
            //         type: "POST",
            //         data: {userForgot: userForgot, formName : formName},
            //         dataType: 'json',
            //         success: function(result){
            //             $(".formRecup .sendForgot").removeClass("disabled");
            //             $(".formRecup .sendForgot").html("Enviar nova senha");

            //             if(result.status){
            //                 Swal.fire({title: "Sucesso!", html: result.message, type: "success"});
            //             } else {
            //                 Swal.fire({title: "Atenção!", html: result.message,type: "error"});
            //             }
            //         }

            //     })
            // })

            // $('.formLostMail').on("submit", function(e){
            //     e.preventDefault();

            //     $(".formLostMail .sendLostMail").addClass("disabled");
            //     $(".formLostMail .sendLostMail").html("Aguarde...");

            //     var userLost	 = $(".input-userLost input").val();
            //     var userLostNasc = $(".input-userLostNasc input").val();
            //     var formName     = "formLostMail";

            //     $.ajax({
            //         url: "/models/postForgotMail",
            //         type: "POST",
            //         data: {userLost: userLost, userLostNasc : userLostNasc, formName : formName},
            //         dataType: 'json',
            //         success: function(result){
            //             $(".formLostMail .sendLostMail").removeClass("disabled");
            //             $(".formLostMail .sendLostMail").html("Consultar");

            //             if(result.status){
            //                 swal({title: "Sucesso!", html: result.message, type: "success"});
            //             } else {
            //                 swal({title: "Atenção!", html: result.message,type: "error"});
            //             }
            //         }

            //     })
            // })

        });
    </script>
</section>