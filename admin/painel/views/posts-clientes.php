<?php 
	if(!$_GET['ID']){
		header("Location: /admin/painel/clientes");
	}

	$clienteID = $_GET['ID'];

	$sql = "SELECT * FROM clientes WHERE ID = {$clienteID}";
	$cliente = $conn->query($sql)->fetch(PDO::FETCH_OBJ);
?>

<div class="d-flex justify-content-between align-items-center">
	<p class="fs-5 mb-0">Posts - <?php echo $cliente->nome ?></p>
	<div>
		<a href="/admin/painel/adicionar-post?ID=<?php echo $clienteID  ?>" class="btn btn-success px-3" style="border-radius: 8px;"><i class="fa-solid fa-plus" ></i></a>
		<a href="/admin/painel/clientes" class="btn btn-success px-3" style="border-radius: 8px;"><i class="fa-solid fa-arrow-left" ></i></a>
	</div>
</div>
	<?php
		$sql = "SELECT * FROM posts WHERE clienteID = {$clienteID} ORDER BY data ASC";
		echo '<p class="d-flex justify-content-between py-3 fs-6">Exibindo todos os posts <span class="pull-right">Total: <strong style="font-size: 18px;">'.$conn->query($sql)->rowCount().'</strong></span></p>'."\n";
		
	if($conn->query($sql)->rowCount() == false){
		echo '<br /><p class="alert alert-warning text-center">NENHUM POST ENCONTRADO</p>'."\n";
	} else { 
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('.deletar-post').click(function(){
					var postID = $(this).attr("data-post-id");
					var confirmacao = confirm("Deseja realmente deletar esse post?");
					if(confirmacao == true){
						$.ajax({ 
							dataType: 'jsonp',
							url: "models/postDeletarPost.php?ID="+postID,
							data: $("form").serialize(),
							success: function(result){
								if(result.RETORNO == "sucesso"){
									$("#data-tr-cliente"+postID).addClass("danger");
									$("#data-tr-cliente"+postID).toggle("slow");
								}else{
									alert("Erro ao deletar esse post.");
								}
							} 
						});
					}else{
						return false;
					}
				});
			});
		</script>
		<div class="table-responsive text-nowrap">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>DESCRICAO</th>
						<th>DATA</th>
						<th>STATUS</th>
						<th>AÇÃO</th>
					</tr>
				</thead>
				<tbody><?php 
					foreach($conn->query($sql)->fetchAll(PDO::FETCH_OBJ) as $ln){

						$tarja = '';
						?>
						<tr <?php echo $tarja; ?> id="data-tr-cliente<?php echo $ln->ID; ?>">
							<td><?php
								echo $ln->descricao ?>
							</td>
							<td><?php 
								$dataCadastro = date('d/m/Y H:i', strtotime($ln->data));

								echo $dataCadastro;	
							?></td>
							<td>
								<div class="form-group w-md-50 w-100">
									<select id="status-<?php echo $ln->ID ?>" name="status" data-id="<?php echo $ln->ID ?>" style="border: none">
										<option value="ativo" <?php echo $ln->ativo == 'Sim' ? 'selected' : '' ?>>Ativo</option>
										<option value="inativo" <?php echo $ln->ativo == 'Nao' ? 'selected' : '' ?>>Inativo</option>
									</select>
								</div>
							</td>
							<td>
								<a href="/admin/painel/editar-post?ID=<?php echo $ln->ID; ?>&clienteID=<?php echo $clienteID ?>" class="" data-bs-toggle="tooltip" data-placement="top" title="Editar post"><span class="fa fa-pencil text-black pe-2"></span></a>
								<a href="javascript:;" class="deletar-post" data-post-id="<?php echo $ln->ID; ?>" data-bs-toggle="tooltip" data-placement="top" title="Deletar post"><span class="fa fa-trash text-black pe-2"></span></a>
								<a href="/admin/painel/post-fotos?ID=<?php echo $ln->ID; ?>&clienteID=<?php echo $clienteID ?>" class="posts" data-bs-toggle="tooltip" data-placement="top" title="Ver fotos do post"><span class="fa fa-camera text-black pe-2"></span></a>
								<!-- <a href="javascript:;"  onClick="confirm('<h1>Deseja realmente deletar esse cliente</h1>Isso também apagará todas as compras e registros vinculados a esse cliente.', 'pages/clientes/deletar.html?ID=<?php echo $ln->ID; ?>')" class="btn btn-danger"  data-toggle="tooltip" data-placement="top" title="Deletar cliente"><span class="glyphicon glyphicon-trash"></span></a> -->
							</td>
							<script>
								$(document).ready(function(){
									$('#status-<?php echo $ln->ID ?>').change(function(){
										var status = $(this).val();
										var id = $(this).data('id');

										$.ajax({
											url: 'models/postAlterarStatus.php',
											dataType: 'json',
											data: {status: status, id: id},
											type: 'POST',
											success: function(result){
												if(result.status){
													Swal.fire({title: 'Sucesso', text: result.message, icon: 'success'});
												} else {
													Swal.fire({title: 'Atenção!', text: result.message, icon: 'error'})
												}
											} 
										})

									});
								});
							</script>
						</tr><?php 
					} ?>
				</tbody>
			</table>
		</div>
	<?php }

?>