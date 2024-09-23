<?php
class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $nome;
    public $email;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Criar usuário
    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " (nome, email, status) VALUES (:nome, :email, :status)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nome", $data['nome']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":status", $data['status']);
        return $stmt->execute();
    }

    // Retornar todos os usuários
    public function all() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retornar um usuário específico
    public function find($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualizar um usuário// Atualizar um usuário
public function update($id, $data) {
    var_dump($data); // Adicione esta linha para ver os dados que estão sendo atualizados
    $query = "UPDATE " . $this->table_name . " SET nome = :nome, email = :email WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":nome", $data['nome']);
    $stmt->bindParam(":email", $data['email']);
    $stmt->bindParam(":id", $id);
    return $stmt->execute();
    }

    // Deletar um usuário
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Alternar status do usuário
    public function toggleStatus($id) {
        $user = $this->find($id);
        $newStatus = ($user['status'] == 'ativo') ? 'inativo' : 'ativo';

        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $newStatus);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
