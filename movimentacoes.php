<?php

require_once('conexao.php');

$id = 0;
$data_movimentacao = '';
$quantidade = '';
$tipo_documento = '';
$numero_documento = '';


//atenção este get está associado ao botão excluir, junto ao get global do código.
if (isset($_GET['excluir'])) {
    $id = filter_input(INPUT_GET, 'excluir', FILTER_SANITIZE_NUMBER_INT);

    if($id);
    $conn->exec('DELETE FROM cadastrar_produto WHERE id=' . $id);

    header('Location: index.php');
    exit;
  
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data_movimentacao = $_POST['data_movimentacao'];
    $quantidade = $_POST['quantidade'];
    $tipo_documento = $_POST['tipo_documento'];
    $numero_documento = $_POST['numero_documento'];

    $stmt = $conn->prepare("INSERT INTO movimentacoes (data_movimentacao, quantidade, tipo_documento, numero_documento) VALUES (:data_movimentacao, :quantidade, :tipo_documento, :numero_documento)");
    $stmt->bindParam(':data_movimentacao', $data_movimentacao);
    $stmt->bindParam(':quantidade', $quantidade);
    $stmt->bindParam(':tipo_documento', $tipo_documento);
    $stmt->bindParam(':numero_documento', $numero_documento);
    $stmt->execute();
}

//area de conexao com a tabela no banco de dados
$stm = $conn->query('SELECT * FROM movimentacoes');
$movimentacoes = $stm->fetchAll();


$results = $conn->query("select * from movimentacoes")->fetchAll();

$arrayDescricao = [1 => 'CNPJ', 2 => 'CPF'];

include_once("./layout/_header.php");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Estoque</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="bg-dark">

    <div class="card mt-4">
        <div class="card-header bg-warning">
            <h1 class="text-center mb-4">Controle de Estoque</h1>
        </div>

        <div class="card-body">
            <h2 class="text-center mb-4">Movimentações</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Data Movimentação</th>
                        <th>Quantidade</th>
                        <th>Tipo de Documento</th>
                        <th>Número do Documento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($movimentacoes as $movimentacao) : ?>
                        <tr>
                            <td><?= $movimentacao['id'] ?></td>
                            <td><?= $movimentacao['data_movimentacao'] ?></td>
                            <td><?= $movimentacao['quantidade'] ?></td>
                            <td><?= $movimentacao['tipo_documento'] ?></td>
                            <td><?= $movimentacao['numero_documento'] ?></td>
                            <td>
                            <a class="btn btn-sm btn-primary" href="cadastro.php?id=<?= $item['id'] ?>">Editar</a>
                            <button class="btn btn-sm btn-danger" onclick="excluir(<?=$item['id']?>)">Excluir</button>
                        </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h2 class="mt-4">Adicionar Movimentação</h2>
            <form method="post" action="movimentacoes.php">
                <div class="form-group">
                    <label for="data_movimentacao">Data Movimentação:</label>
                    <input type="date" class="form-control" name="data_movimentacao" required>
                </div>

                <div class="form-group">
                    <label for="quantidade">Quantidade:</label>
                    <input type="number" class="form-control" name="quantidade" required>
                </div>

                <div class="form-group">
                    <label for="tipo_documento">Tipo de Documento:</label>
                    <select class="form-select form-control-sm mt-2" id="tipo_documento" name="tipo_documento" required>
                        <option value="1" <?= $tipo_documento == 1 ? 'selected' : '' ?>>CNPJ</option>
                        <option value="2" <?= $tipo_documento == 2 ? 'selected' : '' ?>>CPF</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="numero_documento">Número do Documento:</label>
                    <input type="text" class="form-control" name="numero_documento" required>
                </div>
                <!-- btn mexe no botao, no tamanho use btn-sm, btn-lg ou btn-xs para extra grande -->
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Adicionar Movimentação</button>
            <a class="btn btn-danger" href="index.php">Voltar</a>
        </div>

        </form>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>   
 function excluir(id) {
    if (confirm("Deseja Excluir este cadastro?")) {
        window.location.href = "index.php?excluir=" + id;
    }
 }

</script>

</body>

</html>