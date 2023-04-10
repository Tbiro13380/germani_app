<p class="fs-2 mb-0">Configurações</p>

<form class="formConfig" name="formConfig" role="form">
	<div class="row">
		<div class="col-md-6">
			<p class="fs-5 mb-3 mt-3">Informações do site</p>

			<hr class="bg-black">

			<div class="form-group w-100">
				<label for="titulo">Titulo do Site</label>
				<input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo sistema($conn, "titulo"); ?>" />
			</div>

			<div class="form-group w-100">
				<label for="palavrasChave">Palavras Chave (Separados por vírgula)</label>
				<input type="text" class="form-control" id="palavrasChave" name="palavrasChave" value="<?php echo sistema($conn, "palavrasChave"); ?>" />
			</div>

			<div class="form-group w-100">
				<label for="descricao">Breve descrição do site</label>
				<textarea class="form-control" rows="5" name="descricao" id="descricao"><?php echo sistema($conn, "descricao"); ?></textarea>
			</div>
		</div>

		<div class="col-md-6">
			<p class="fs-5 mb-3 mt-3">Dados para E-mails</p>

			<hr class="bg-black">

			<div class="form-group w-100">
				<label for="emailNome">Nome para exibição</label>
				<input type="text" class="form-control" name="emailNome" id="emailNome" value="<?php echo sistema($conn, "emailNome"); ?>"></input>
			</div>

			<div class="form-group w-100">
				<label for="emailHost">Host</label>
				<input type="text" class="form-control" name="emailHost" id="emailHost" value="<?php echo sistema($conn, "emailHost"); ?>"></input>
			</div>

			<div class="form-group w-100">
				<label for="emailPorta">Porta</label>
				<input type="text" class="form-control" name="emailPorta" id="emailPorta" value="<?php echo sistema($conn, "emailPorta"); ?>"></input>
			</div>

			<div class="form-group w-100">
				<label for="emailUsuario">Usuario</label>
				<input type="text" class="form-control" name="emailUsuario" id="emailUsuario" value="<?php echo sistema($conn, "emailUsuario"); ?>"></input>
			</div>

			<div class="form-group w-100">
				<label for="emailSenha">Senha</label>
				<input type="text" class="form-control" name="emailSenha" id="emailSenha" value="<?php echo sistema($conn, "emailSenha"); ?>"></input>
			</div>
		</div>

		<div class="col-md-6">
			<p class="fs-5 mb-3 mt-3">Google Analytics</p>

			<hr class="bg-black">

			<div class="form-group w-100">
				<label for="google_analytics">Google Analytics</label>
				<textarea class="form-control" id="google_analytics" name="google_analytics"><?php echo sistema($conn, "google_analytics"); ?></textarea>
			</div>
		</div>

		<div class="col-md-12">
			<input onClick="return false;" class="btn w-100 btn-success mt-3" id="send" type="submit" name="enviar" value="SALVAR" />
		</div>
	</div>
</form>

<script>
	$('#send').on("click", function(){
		$.ajax({
			url: "models/postConfiguracoes.php",
			data: $(".formConfig").serialize(),
			dataType: "json",
			type: "POST",
			success: function(result){
				if(result.status){
					Swal.fire({title: "Sucesso!", text: result.message, icon: "success"});
				} else {
					Swal.fire({title: "Atenção!", text: result.message, icon: "error"});
				}
			}
		})
	})
</script>