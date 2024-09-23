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

// Verifica se o ID foi passado pela URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = $usuario->find($id);
    
    if (!$user) {
        die("Usuário não encontrado.");
    }
} else {
    die("ID do usuário não especificado.");
}

// Checar se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    
    if (!empty($nome) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $data = [
            'nome' => $nome,
            'email' => $email
        ];
        
        if ($usuario->update($id, $data)) {
            echo "<div class='alert alert-success'>Usuário atualizado com sucesso!</div>";
        } else {
            echo "<div class='alert alert-danger'>Erro ao atualizar o usuário.</div>";
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
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Editar Usuário</h1>
        <a href="index.php" class="btn btn-secondary mb-3">Voltar à Listagem</a>
        <form method="POST" action="edit.php?id=<?php echo $id; ?>">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" class="form-control" id="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </div>
</body>
</html>

