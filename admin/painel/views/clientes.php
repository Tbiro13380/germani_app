<?php 
	if(@$_GET["acao"] == "editar"){
		extract($_POST);
		if(@$cpf == false){
			echo '<div class="alert alert-warning" role="alert"><strong>Erro!</strong> Preencha o CPF.</div>';
			die('<script>document.formClientes.cpf.focus();</script>');
		}
		
		if($cpf <> $cpfAtual){
			if(@validaCPF($cpf) == false){
				echo '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> CPF inválido.</div>';
				die('<script>document.formClientes.cpf.focus();</script>');
			}
			$replaces = array(".", "-");
			$consultaCpf = "SELECT * FROM lojistas WHERE cpf = '".str_replace($replaces, "", anti_inject($cpf))."' AND cpf <> '$cpfAtual'";
			if($conn->query($consultaCpf)->rowCount() == true){
				echo '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> Este CPF já está em uso.</div>';
				die('<script>document.nomeLoja.cpf.focus();</script>');
			}
		}
		
		if(@$email == false){
			echo '<div class="alert alert-warning" role="alert"><strong>Erro!</strong> Preencha o e-mail.</div>';
			die('<script>document.formClientes.email.focus();</script>');
		}
		
		if($email <> $emailAtual){
			if(@validaEmail($email) == false){
				echo '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> E-mail inválido.</div>';
				die('<script>document.formClientes.email.focus();</script>');
			}
			
			$consultaEmail = "SELECT * FROM clientes WHERE email = '$email' AND email <> '$emailAtual'";
			if($conn->query($consultaEmail)->rowCount() == true){
				echo '<div class="alert alert-danger" role="alert"><strong>Erro!</strong> Este e-mail já está em uso.</div>';
				die('<script>document.nomeLoja.email.focus();</script>');
			}
		}
		
		if(@$senha == true and strlen($senha) < 6){
			echo '<div class="alert alert-warning" role="alert"><strong>Erro!</strong> A senha deve ter no mínimo 6 caracteres.</div>';
			die('<script>document.formClientes.senha.focus();</script>');
		}
		
		$senhaSql = $senha == false ? $senhaAtual : md5($senha);
		$replacesCPF = array(".", "-");
		update($conn, array("cpf", "email", "senha"), array(str_replace($replacesCPF, "", $cpf), $email, $senhaSql), "lojistas", "WHERE ID = '$ID'");
		update($conn, "id_plano", $plano, "plano_lojistas", "WHERE id_lojista = {$ID}");
		saveLog($conn, dadosAdmin($conn, "nome", $_SESSION["emailAdmin"])." editou informações no cadastro do cliente (".$nomeAtual." #$ID).");
		die('<script>location.href="'.URL_SITE.'/admin/pages/clientes/lista.html";</script>');
	} ?>	
<style>
	
</style>

<style>
.search {
  width: 100%;
  position: relative;
  display: flex;
}

.searchTerm {
  width: 100%;
  border: 3px solid black;
  border-right: none;
  padding: 15px;
  height: 20px;
  border-radius: 5px 0 0 5px;
  outline: none;
  color: #9DBFAF;
}

.searchTerm:focus{
  color: black;
}

.searchButton {
  width: 40px;
  height: 36px;
  border: 1px solid black;
  background: black;
  text-align: center;
  color: #fff;
  border-radius: 0 5px 5px 0;
  cursor: pointer;
  font-size: 20px;
}

/*Resize the wrap to see the search bar change!*/
.wrap{
  width: 30%;
}
</style>
<div class="d-flex justify-content-between align-items-center mb-4">
	<div class="d-flex ">
		<p class="fs-3">Clientes</p>
	</div>
	<div class="wrap">
       <div class="search" id="search">
          <input type="text" class="searchTerm" placeholder="Pesquisar por nome">
          <button type="submit" class="searchButton">
            <i class="fa fa-search"></i>
         </button>
       </div>
    </div>
	<a href="/admin/painel/adicionar-cliente" class="btn ms-2 btn-success px-3" style="border-radius: 8px;"><i class="fa-solid fa-plus" ></i></a>
</div>
<script>
    $('#search').on("click", function(){
        const searchTerm = $('.searchTerm').val();
        if(searchTerm.trim() !== ''){
            window.location.href = window.location.pathname + '?search=' + encodeURIComponent(searchTerm);
        }
    })
</script>

<div class="row gap-2 gap-md-0">
	<p class="fs-6 py-2">Filtrar por</p>
	<div class="dropdown col-md-12">
		<button class="btn btn-dark w-100 dropdown-toggle" type="button" id="data_cadastro" data-bs-toggle="dropdown" aria-expanded="false">
			<span class="text-white">Cadastro</span>
		</button>
		<ul class="dropdown-menu" aria-labelledby="data_cadastro">
			<li><a class="dropdown-item" href="/admin/painel/clientes?dataCad=mais_novos">Mais novos</a></li>
			<li><a class="dropdown-item" href="/admin/painel/clientes?dataCad=mais_antigos">Mais velhos</a></li>
		</ul>
	</div>
</div>

<?php 
	if(seo(true, 2) == ""){

		if(seo(true, 2) == "" and @$_GET["dataCad"] == "mais_novos"){
			$sql = "SELECT * FROM clientes ORDER BY data_cadastro DESC";
			echo '<div class="d-flex justify-content-between py-3 fs-6">Exibindo por data de cadastro: <strong>Mais novos para mais velhos</strong> </div>'."\n";
		}elseif(seo(true, 2) == "" and @$_GET["dataCad"] == "mais_antigos"){
			$sql = "SELECT * FROM clientes ORDER BY data_cadastro ASC";
			echo '<div class="d-flex justify-content-between py-3 fs-6">Exibindo por data de cadastro: <strong>Mais velhos para mais novos</strong> </div>'."\n";
		}elseif(seo(true, 2) == "" and @$_GET["search"] !== "") {
		    @$sql = "SELECT * FROM clientes WHERE nome LIKE '%{$_GET['search']}%'";
		    
		    echo '
		    <div class="d-flex justify-content-between py-3 fs-6">
		 		Exibindo por nome: '.@$_GET['search'].'
		 		<span>Total: <strong style="font-size: 18px;">'.$conn->query($sql)->rowCount().'</strong></span>
		 	</div>
		    '."\n";
		} else {
			$sql = "SELECT * FROM clientes ORDER BY nome ASC";
			echo '<p class="d-flex justify-content-between py-3 fs-6">Exibindo todos os clientes<span class="pull-right">Total: <strong style="font-size: 18px;">'.$conn->query($sql)->rowCount().'</strong></span></p>'."\n";
		}
		
		if($conn->query($sql)->rowCount() == false){
			echo '<br /><p class="alert alert-warning text-center">NENHUM CLIENTE ENCONTRADO</p>'."\n";
		}else{ ?>
			<script type="text/javascript">
			$(document).ready(function(){
				$('.deletar-cliente').click(function(){
					var clienteID = $(this).attr("data-cliente-id");
					var confirmacao = confirm("Deseja realmente deletar esse cliente?");
					if(confirmacao == true){
						$.ajax({ 
							dataType: 'jsonp',
							url: "models/postDeletarCliente.php?ID="+clienteID,
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

			});
			</script>
			<div class="table-responsive text-nowrap">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>NOME</th>
							<th>EMAIL</th>
							<th>DATA CADASTRO</th>
							<th>AÇÃO</th>
						</tr>
					</thead>
					<tbody><?php 
						foreach($conn->query($sql)->fetchAll(PDO::FETCH_OBJ) as $ln){

							$tarja = '';
							?>
							<tr <?php echo $tarja; ?> id="data-tr-cliente<?php echo $ln->ID; ?>">
								<td><?php
									echo $ln->nome ?>
								</td>
								<td><?php echo $ln->email; ?></td>
								<td><?php
									$dataCadastro = date('d/m/Y', strtotime($ln->data_cadastro));

									echo $dataCadastro;	

								 ?></td>
								<td>
									<a href="/admin/painel/editar-cliente?ID=<?php echo $ln->ID; ?>" class="" data-bs-toggle="tooltip" data-placement="top" title="Editar cliente"><span class="fa fa-pencil text-black pe-2"></span></a>
									<a href="javascript:;" class="deletar-cliente" data-cliente-id="<?php echo $ln->ID; ?>" data-bs-toggle="tooltip" data-placement="top" title="Deletar cliente"><span class="fa fa-trash text-black pe-2"></span></a>
									<a href="/admin/painel/posts-clientes?ID=<?php echo $ln->ID; ?>" class="posts" data-bs-toggle="tooltip" data-placement="top" title="Ver posts"><span class="fa fa-eye text-black pe-2"></span></a>
									<a target="_blank" href="../../app/home/adminLoginCliente/<?php echo $ln->ID ?>" class="text-dark"  data-bs-toggle="tooltip" data-placement="top" title="Logar"><i class="fa fa-external-link" aria-hidden="true"></i></a>
									<!-- <a href="javascript:;"  onClick="confirm('<h1>Deseja realmente deletar esse cliente</h1>Isso também apagará todas as compras e registros vinculados a esse cliente.', 'pages/clientes/deletar.html?ID=<?php echo $ln->ID; ?>')" class="btn btn-danger"  data-toggle="tooltip" data-placement="top" title="Deletar cliente"><span class="glyphicon glyphicon-trash"></span></a> -->
								</td>
							</tr><?php 
						} ?>
					</tbody>
				</table>
			</div>
			<script>
				 $(document).ready(function(){
					$('.maskData').mask('00/00/0000');
					$('.maskCelular').mask('(00) 0 0000-0000');
					$('.maskCPF').mask('000.000.000-00');
				});
			</script>
				<?php 
		}
	}