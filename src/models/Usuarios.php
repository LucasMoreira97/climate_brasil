<?php

// require_once('./config/Database.php');

class Usuarios
{

    private $db;

    public function __construct()
    {
        $database = new Database;
        $this->db = $database->getConnection();
    }

    private function emailExiste($email)
    {
        $sql = "SELECT id FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result ? true : false;
    }

    public function cadastrarUsuario($data)
    {
        $db = $this->db;

        if ($this->emailExiste($data['email'])) {
            return ['code' => 400, 'status' => 'Erro: Email já cadastrado'];
        }

        $current_date = time();
        $sql = "INSERT INTO usuarios(nome, tipos, email, senha, data_cadastro) 
                VALUES (:nome, :tipos, :email, :senha, :data_cadastro)";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':nome', $data['nome']);
        $stmt->bindValue(':tipos', $data['tipo']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':senha', $data['senha']);
        $stmt->bindValue(':data_cadastro', $current_date);

        $stmt->execute();
        $affected_lines = $stmt->rowCount();

        return ($affected_lines > 0) ? ['code' => 200, 'status' => 'Cadastro realizado com sucesso'] : ['code' => 400, 'status' => 'Erro ao cadastrar usuário'];
    }

    public function excluirUsuario($adminEmail, $email)
    {
        $db = $this->db;

        $sql = "SELECT * FROM usuarios WHERE email = :email AND tipos = 'administrador' LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $adminEmail);
        $stmt->execute();
        $adminResult = $stmt->fetch();

        if (!$adminResult) {
            return ['code' => 403, 'status' => 'Ação não permitida. Apenas administradores podem excluir usuários.'];
        }

        $sql_delete = "DELETE FROM usuarios WHERE email = :email";
        $stmt = $db->prepare($sql_delete);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $affected_lines = $stmt->rowCount();

        return ($affected_lines > 0) ? ['code' => 200, 'status' => 'Usuário excluído com sucesso'] : ['code' => 400, 'status' => 'Usuário não encontrado'];
    }
}
