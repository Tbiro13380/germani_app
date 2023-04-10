<div class="d-flex justify-content-between align-items-center">
	<p class="fs-2 mb-0">Editar cliente</p>
	<a href="/admin/painel/clientes" class="btn btn-success px-3" style="border-radius: 8px;"><i class="fa-solid fa-arrow-left" ></i></a>
</div>

<?php 

	$ID = $_GET['ID'];

	if(!$ID){
		header("Location: /admin/painel/clientes");
	}

	$sql = "SELECT * FROM clientes WHERE ID = {$ID}";

	if($conn->query($sql)->rowCount() == false ){
		header("Location: /admin/painel/clientes");
	} 

	$cliente = $conn->query($sql)->fetch(PDO::FETCH_OBJ);


?>

<form class="formCliente mt-3" name="formCliente">

	<input type="hidden" name="ID" value="<?php echo $cliente->ID ?>">

	<div class="form-group w-md-50 w-100">
		<label for="nome">Nome</label>
		<input type="text" class="form-control" id="nome" name="nome" value="<?php echo $cliente->nome ?>" />
	</div>

	<div class="form-group w-md-50 w-100">
		<label for="email">Email</label>
		<input type="text" class="form-control" id="email" name="email" value="<?php echo $cliente->email ?>" />
	</div>

	<button onClick="return false;" id="editCliente" class="btn btn-success w-md-50 w-100  mt-4" type="submit" name="enviar">EDITAR</button>
</form>

<script>
	$('#editCliente').click(function(){

		$.ajax({ 
			type: "POST",
			dataType: 'json',
			url: "models/postEditarCliente.php",
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