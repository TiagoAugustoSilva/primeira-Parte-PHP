<?php

require_once("conexao.php");

//atenção este get está associado ao botão excluir, junto ao get global do código.
if (isset($_GET['excluir'])) {
    $id = filter_input(INPUT_GET, 'excluir', FILTER_SANITIZE_NUMBER_INT);

    if($id);
    $conn->exec('DELETE FROM cadastrar_produto WHERE id=' . $id);

    header('Location: index.php');
    exit;
  
}

$results = $conn->query("select * from cadastrar_produto")->fetchAll();

$arrayDescricao = [1 => 'Eletrônicos', 2 => 'Informática', 3 => 'Domésticos', 4 => 'Celulares', 5 => 'Acessórios'];

include_once("./layout/_header.php");


?>

<?php

require_once("conexao.php");

include_once("./layout/_header.php");

?>

<!-- O mt-4 é o mesmo que margin-top: 4; aplicado ao elemento card -->

<div class="card mt-4">
    <!--justify-content-between joga o botão la no fim Chick D+-->
    <div class="card-header d-flex justify-content-between align-items-center custom-card-header bg-warning">
        <!-- o text-center my-4 mx-auto é o mesmo que display flex, justify-content-center align-items-center-->
        <h2 class="text-center my-4 h2-striped">Mini Faturamento
        <a class="btn btn-primary" href="cadastro.php">+Adicionar</a>
        </h2>
        <!--ao utilizar btn-success ele dará a  cor verde ao botão pelo boostrap-->
        <a class="btn btn-dark" href="movimentacoes.php">Controle de Estoque</a>
    </div>
    <!-- Conteúdo do corpo do cartão -->
    <div class="card-body">
        <!--com bootstrap só de por a class="table" ele já ajusta a tabela-->
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th>Código </th>
                    <th>Produto</th>
                    <th>Descrição</th>
                    <th>Valor Unitário</th>
                    <th>Unidade de Medida</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $item) : ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= $item['produto'] ?></td>
                        <td><?= $arrayDescricao[$item['descricao']] ?></td>
                        <td><?= $item['valor_unitario'] ?></td>
                        <td><?= $item['unidade_medida'] ?></td>
                        <!--área abaixo onde colocamos os nosso btn(Buttons) lembrando que btn-primary botão azul e btn-danger-botão vermelho-->
                        <td>
                            <a class="btn btn-sm btn-primary" href="cadastro.php?id=<?= $item['id'] ?>">Editar</a>
                            <button class="btn btn-sm btn-danger" onclick="excluir(<?=$item['id']?>)">Excluir</button>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<script>   
 function excluir(id) {
    if (confirm("Deseja Excluir este cadastro?")) {
        window.location.href = "index.php?excluir=" + id;
    }
 }

</script>

<?php
include_once("./layout/_footer.php");
?>
