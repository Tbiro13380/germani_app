<div class="d-flex justify-content-between align-items-center">
	<p class="fs-3">Adicionar Administrador</p>
	<a href="/admin/painel/usuarios" class="btn btn-success px-3"><i class="fa-solid fa-arrow-left" style="border-radius: 8px;"></i></a>
</div>

<form class="formADM col-md-6" name="formADM">
	<div class="form-group w-100">
		<label for="nome">Nome</label>
		<input type="text" class="form-control" id="nome" name="nome" />
	</div>

	<div class="form-group w-100">
		<label for="email">Email</label>
		<input type="text" class="form-control" id="email" name="email" />
	</div>

	<div class="form-group w-100">
		<label for="email">Senha</label>
		<input type="text" class="form-control" id="senha" name="senha" />
	</div>

	<div class="form-group w-100">
		<div>Status</div>
		<label class="pe-2"><input type="radio" id="status" name="status" value="Ativo">Ativo</label>
		<label><input type="radio" id="status" name="status" value="Inativo">Inativo</label>
	</div>

	<button onClick="return false;" id="addAdm" class="btn btn-success w-md-25 w-100  mt-4" type="submit" name="enviar">CADASTRAR</button>
</form>

<script>
	$('#addAdm').on("click", function(){
		$.ajax({
			url: 'models/postAddAdm.php',
			dataType: 'json',
			data: $('.formADM').serialize(),
			type: 'POST',
			success: function(response){
				if(response.status){
					Swal.fire({title: 'Sucesso!', text: response.message, icon: 'success'}).then(function(){
						location.href = '/admin/painel/usuarios';
					});
				} else {
					Swal.fire({title: 'Atenção!', text: response.message, icon: 'error'});
				}
			}
		})
	});
</script>