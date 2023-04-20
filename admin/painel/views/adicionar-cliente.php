<div class="d-flex justify-content-between align-items-center">
	<p class="fs-2 mb-0">Adicionar cliente</p>
	<a href="/admin/painel/clientes" class="btn btn-success px-3" style="border-radius: 8px;"><i class="fa-solid fa-arrow-left" ></i></a>
</div>


<form class="formCliente mt-3" name="formCliente">

	<div class="form-group w-md-50 w-100">
		<label for="nome">Nome</label>
		<input type="text" class="form-control" id="nome" name="nome" />
	</div>

	<div class="form-group w-md-50 w-100">
		<label for="email">Email</label>
		<input type="text" class="form-control" id="email" name="email" />
	</div>

	<div class="form-group w-md-50 w-100">
		<label for="senha">Senha</label>
		<input type="text" class="form-control" id="senha" name="senha" />
	</div>

	Enviar email com os dados?
	<div>
		<label for="nao">Não</label>
		<input type="checkbox" id="nao" checked name="sendmail" value="nao" onclick="document.getElementById('sim').checked = false;">
	</div>
	<div>
		<label for="sim">Sim</label>
		<input type="checkbox" id="sim" name="sendmail" onclick="document.getElementById('nao').checked = false;" value="sim">
	</div>

	<button onClick="return false;" id="addCliente" class="btn btn-success w-md-50 w-100  mt-4" type="submit" name="enviar">CADASTRAR</button>
</form>

<script>
	$('#addCliente').click(function(){

		$.ajax({ 
			type: "POST",
			dataType: 'json',
			url: "models/postCliente.php",
			data: $('.formCliente').serialize(),
			success: function(result){
				if(result.status){
					Swal.fire({title: 'Sucesso', text: result.message, icon: 'success'}).then(function(){
						window.location = '/admin/painel/clientes';
					});
				} else {
					Swal.fire({title: 'Atenção!', text: result.message, icon: 'error'})
				}
			} 
		});
	});
</script>