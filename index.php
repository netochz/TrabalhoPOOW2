<?php
require_once '../config/Database.php';
require_once '../classes/Usuario.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);
$usuarios = $usuario->all();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Usuários</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Usuários Cadastrados</h1>
        <a href="create.php" class="btn btn-primary mb-3">Cadastrar Novo Usuário</a>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo $usuario['id']; ?></td>
                        <td><?php echo $usuario['nome']; ?></td>
                        <td><?php echo $usuario['email']; ?></td>
                        <td>
                            <span class="badge <?php echo $usuario['status'] == 'ativo' ? 'badge-success' : 'badge-secondary'; ?>">
                                <?php echo ucfirst($usuario['status']); ?>
                            </span>
                        </td>
                        <td>
                            <a href="edit.php?id=<?php echo $usuario['id']; ?>" class="btn btn-warning">Editar</a>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal" data-id="<?php echo $usuario['id']; ?>">Remover</button>
                            <a href="toggleStatus.php?id=<?php echo $usuario['id']; ?>" class="btn btn-secondary">
                                <?php echo $usuario['status'] == 'ativo' ? 'Inativar' : 'Ativar'; ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal de Confirmação -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Remoção</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja remover este usuário?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Remover</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let userId;

            // Captura o ID do usuário a ser removido
            $('#confirmDeleteModal').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget);
                userId = button.data('id');
            });

            // Ação de remoção
            $('#confirmDeleteBtn').click(function() {
                if (userId) {
                    window.location.href = 'delete.php?id=' + userId;
                }
            });
        });
    </script>
</body>
</html>
