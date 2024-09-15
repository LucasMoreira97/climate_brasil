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
        $executar = $this->db->prepare($sql);
        $executar->bindValue(':email', $email);
        $executar->execute();
        $result = $executar->fetch();

        return $result ? true : false;
    }

    public function CadastrarUsuario($data)
    {
        $db = $this->db;

        if ($this->emailExiste($data['email'])) {
            return ['code' => 400, 'status' => 'Erro: Email já cadastrado'];
        }

        $current_date = time();
        $sql = "INSERT INTO usuarios(nome, tipos, email, senha, data_cadastro) 
                VALUES (:nome, :tipos, :email, :senha, :data_cadastro)";

        $executar = $db->prepare($sql);
        $executar->bindValue(':nome', $data['nome']);
        $executar->bindValue(':tipos', $data['tipo']);
        $executar->bindValue(':email', $data['email']);
        $executar->bindValue(':senha', $data['senha']);
        $executar->bindValue(':data_cadastro', $current_date);

        $executar->execute();
        $affected_lines = $executar->rowCount();

        return ($affected_lines > 0) ? ['code' => 200, 'status' => 'Cadastro realizado com sucesso'] : ['code' => 400, 'status' => 'Erro ao cadastrar usuário'];
    }

    public function ExcluirUsuario($adminEmail, $email)
    {
        $db = $this->db;

        $sql = "SELECT * FROM usuarios WHERE email = :email AND tipos = 'administrador' LIMIT 1";
        $executar = $db->prepare($sql);
        $executar->bindValue(':email', $adminEmail);
        $executar->execute();
        $adminResult = $executar->fetch();

        if (!$adminResult) {
            return ['code' => 403, 'status' => 'Ação não permitida. Apenas administradores podem excluir usuários.'];
        }

        $sql_delete = "DELETE FROM usuarios WHERE email = :email";
        $executar = $db->prepare($sql_delete);
        $executar->bindValue(':email', $email);
        $executar->execute();
        $affected_lines = $executar->rowCount();

        return ($affected_lines > 0) ? ['code' => 200, 'status' => 'Usuário excluído com sucesso'] : ['code' => 400, 'status' => 'Usuário não encontrado'];
    }
}
