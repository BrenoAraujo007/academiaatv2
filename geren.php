<?php
include 'conexao.php';

// Cadastrar usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $pago = isset($_POST['pago']) ? 1 : 0;
    $ultimo_pagamento = $_POST['ultimo_pagamento'];
    $valor_pagamento = $_POST['valor_pagamento'];
    $frequencia = $_POST['frequencia'];

// Inserir novo usuário no banco de dados
    $dados = $conn->prepare("INSERT INTO usuarios (nome, cpf, pago, ultimo_pagamento, valor_pagamento, frequencia) VALUES (?, ?, ?, ?, ?, ?)");
    $dados->execute([$nome, $cpf, $pago, $ultimo_pagamento, $valor_pagamento, $frequencia]);

    // Redirecionar para a página de gerenciamento após o cadastro
    header("Location: geren.php");
}

// Atualizar usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $pago = isset($_POST['pago']) ? 1 : 0;
    $ultimo_pagamento = $_POST['ultimo_pagamento'];
    $valor_pagamento = $_POST['valor_pagamento'];
    $frequencia = $_POST['frequencia'];

    // Atualizar dados do usuário no banco de dados
    $dados = $conn->prepare("UPDATE usuarios SET nome = ?, cpf = ?, pago = ?, ultimo_pagamento = ?, valor_pagamento = ?, frequencia = ? WHERE id = ?");
    $dados->execute([$nome, $cpf, $pago, $ultimo_pagamento, $valor_pagamento, $frequencia, $id]);

    // Redirecionar para a página de gerenciamento após a atualização
    header("Location: geren.php");
}

// Deletar usuário
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Deletar usuário do banco de dados
    $dados = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $dados->execute([$id]);

    // Redirecionar para a página de gerenciamento após a exclusão
    header("Location: geren.php");
}

// Consultar usuários
$usuarios = $conn->query("SELECT * FROM usuarios")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Academia</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000;
            color: #fff;
        }
        .container {
            background-color: #333;
            padding: 20px;
            border-radius: 10px;
        }
        .form-control, .form-check-input {
            background-color: #555;
            color: #fff;
            border: 1px solid #777;
        }
        .form-control::placeholder {
            color: #bbb;
        }
        .btn {
            margin-top: 10px;
        }
        .table {
            background-color: #444;
            color: #fff;
        }
        .table thead {
            background-color: #555;
        }
        .table tbody tr {
            background-color: #666;
        }
        .table tbody tr:hover {
            background-color: #777;
        }
        .img-center {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Gerenciamento de Academia</h1>
    <img src="academia.webp" class="img-fluid mb-4 img-center" alt="Academia">
    <form method="POST" class="mb-5">
        <input type="hidden" name="id" id="id">
        <div class="form-group">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="form-group">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" class="form-control" id="cpf" name="cpf" required>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="pago" name="pago">
            <label for="pago" class="form-check-label">Pago</label>
        </div>
        <div class="form-group">
            <label for="ultimo_pagamento" class="form-label">Último Pagamento</label>
            <input type="date" class="form-control" id="ultimo_pagamento" name="ultimo_pagamento" required>
        </div>
        <div class="form-group">
            <label for="valor_pagamento" class="form-label">Valor do Pagamento</label>
            <input type="number" step="0.01" class="form-control" id="valor_pagamento" name="valor_pagamento" required>
        </div>
        <div class="form-group">
            <label for="frequencia" class="form-label">Frequência</label>
            <input type="text" class="form-control" id="frequencia" name="frequencia" required>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" name="cadastrar" class="btn btn-success">Cadastrar</button>
            <button type="submit" name="atualizar" class="btn btn-primary">Atualizar</button>
            <a href="geren.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>

    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Pago</th>
                <th>Último Pagamento</th>
                <th>Valor do Pagamento</th>
                <th>Frequência</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo $usuario['id']; ?></td>
                <td><?php echo $usuario['nome']; ?></td>
                <td><?php echo $usuario['cpf']; ?></td>
                <td><?php echo $usuario['pago'] ? 'Sim' : 'Não'; ?></td>
                <td><?php echo $usuario['ultimo_pagamento']; ?></td>
                <td><?php echo $usuario['valor_pagamento']; ?></td>
                <td><?php echo $usuario['frequencia']; ?></td>
                <td>
                    <a href="geren.php?delete=<?php echo $usuario['id']; ?>" class="btn btn-danger btn-sm">Excluir</a>
                    <button class="btn btn-warning btn-sm" onclick="editUsuario(<?php echo $usuario['id']; ?>, '<?php echo $usuario['nome']; ?>', '<?php echo $usuario['cpf']; ?>', <?php echo $usuario['pago']; ?>, '<?php echo $usuario['ultimo_pagamento']; ?>', '<?php echo $usuario['valor_pagamento']; ?>', '<?php echo $usuario['frequencia']; ?>')">Editar</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function editUsuario(id, nome, cpf, pago, ultimo_pagamento, valor_pagamento, frequencia) {
    document.getElementById('id').value = id;
    document.getElementById('nome').value = nome;
    document.getElementById('cpf').value = cpf;
    document.getElementById('pago').checked = pago;
    document.getElementById('ultimo_pagamento').value = ultimo_pagamento;
    document.getElementById('valor_pagamento').value = valor_pagamento;
    document.getElementById('frequencia').value = frequencia;
}
</script>
<script src="https://code.jquery