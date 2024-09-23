<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/Database.php';
require_once '../classes/Usuario.php';

// Conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

// Instancia o objeto Usuario
$usuario = new Usuario($db);

// Checar se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar campos
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $status = 'ativo'; // Novo usuário começa como ativo por padrão
    
    if (!empty($nome) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Inserir usuário no banco
        $data = [
            'nome' => $nome,
            'email' => $email,
            'status' => $status
        ];
        
        if ($usuario->create($data)) {
            echo "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
        } else {
            echo "<div class='alert alert-danger'>Erro ao cadastrar o usuário.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Por favor, insira um nome válido e um email válido.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Cadastrar Novo Usuário</h1>
        <a href="index.php" class="btn btn-secondary mb-3">Voltar à Listagem</a>
        <form method="POST" action="create.php">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" class="form-control" id="nome" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
</body>
</html>
