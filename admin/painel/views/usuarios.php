<div class="d-flex justify-content-between align-items-center">
	<p class="fs-3">Administradores do site</p>
	<div>
		<a href="/admin/painel/adicionar-adm" class="btn btn-success px-3"><i class="fa-solid fa-plus" style="border-radius: 8px;"></i></a>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('.deletar-cliente').click(function(){
			var clienteID = $(this).attr("data-cliente-id");
			var confirmacao = confirm("Deseja realmente deletar esse admin?.");
			if(confirmacao == true){
				$.ajax({ 
					dataType: 'jsonp',
					url: "models/postDeletarADM.php?ID="+clienteID,
					data: $("form").serialize(),
					success: function(result){
						if(result.RETORNO == "sucesso"){
							$("#data-tr-cliente"+clienteID).addClass("danger");
							$("#data-tr-cliente"+clienteID).toggle("slow");
						}else{
							alert("Erro ao deletar esse cliente.");
						}
					} 
				});
			}else{
				return false;
			}
		});
	})
</script>



<?php
$sql = "SELECT * FROM admin ORDER BY nome ASC";
if($conn->query($sql)->rowCount() == false){
	echo '<p class="alert alert-warning text-center">NENHUM USUÁRIO CADASTRADO</p>'."\n";
}else{?>
<div class="table-responsive text-nowrap mt-5">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>STATUS</th>
				<th>NOME</th>
				<th>E-MAIL</th>
				<th>AÇÃO</a></th>
			</tr>
		</thead>
		<tbody><?php 
			foreach($conn->query($sql)->fetchAll(PDO::FETCH_OBJ) as $ln){
				$ipBloqueado = @$conn->query("SELECT * FROM ipsbloqueados WHERE ip = '".$ln->ip."'")->rowCount(); ?>
				<tr <?php echo (($ln->status == "Inativo") ? 'class="warning"': ''); ?>>
					<td style="width: 50px;"><?php echo $ln->status; ?></td>
					<td> <?php echo $ln->nome; ?></td>
					<td><?php echo $ln->email; ?></td>
					<td style="width: 100px;">
						<a href="/admin/painel/editar-adm?adm=<?php echo $ln->ID; ?>" class="pe-3" style="color: black;"><span class="fa-solid fa-pencil"></span></a>
						<?php if($ln->email <> "suporte@megaperes.com.br"):	?>
						<a href="javascript:;" style="color: black;"><span class="fa-solid fa-trash deletar-cliente" data-cliente-id="<?php echo $ln->ID; ?>"></span></a>
					<?php endif; ?>
					</td>
				</tr><?php 
			} ?>
		</tbody>
	</table>
</div><?php 
}
