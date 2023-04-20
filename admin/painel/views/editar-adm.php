<?php
	$sql = "SELECT * FROM admin WHERE ID = {$_GET['adm']}";

	$admin = $conn->query($sql)->fetch(PDO::FETCH_OBJ);
?>


<div class="d-flex justify-content-between align-items-center">
	<p class="fs-3">Editar Administrador</p>
	<a href="/admin/painel/usuarios" class="btn btn-success px-3"><i class="fa-solid fa-arrow-left" style="border-radius: 8px;"></i></a>
</div>

<form class="formADM" name="formADM">
	<input type="hidden" name="id" value="<?php echo $_GET['adm']; ?>">
	<div class="form-group w-50">
		<label for="nome">Nome</label>
		<input type="text" class="form-control" id="nome" name="nome" value="<?php echo $admin->nome; ?>" />
	</div>

	<div class="form-group w-50">
		<label for="email">Email</label>
		<input type="text" class="form-control" id="email" name="email" value="<?php echo $admin->email; ?>" />
	</div>

	<div class="form-group w-50">
		<label for="senha">Senha</label>
		<input type="password" class="form-control" id="senha" name="senha" />
	</div>

	<div class="form-group w-50">
		<label for="senhac">Senha Antiga</label>
		<input type="password" class="form-control" id="senhac" name="senhac" />
	</div>

	<div class="form-group">
		<div>Status</div>
		<label class="pe-2"><input type="radio" id="status" <?php echo $admin->status == 'Ativo' ? 'checked="checked"' : '' ?> name="status" value="Ativo">Ativo</label>
		<label><input type="radio" id="status" name="status" <?php echo $admin->status == 'Inativo' ? 'checked="checked"' : '' ?> value="Inativo">Inativo</label>
	</div>

	<button onClick="return false;" id="addAdm" class="btn btn-success w-md-25 w-50  mt-4" type="submit" name="enviar">EDITAR</button>
</form>

<script>
	$('#addAdm').on("click", function(){
		$.ajax({
			url: 'models/postEditarAdm.php',
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