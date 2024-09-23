<?php
require_once '../config/Database.php';
require_once '../classes/Usuario.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

// Verifica se o ID foi passado
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($usuario->toggleStatus($id)) {
        echo "<div class='alert alert-success'>Status do usuário atualizado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro ao atualizar o status do usuário.</div>";
    }
} else {
    die("ID do usuário não especificado.");
}

// Redireciona de volta à listagem
header('Location: index.php');
?>
