<?php

class Acessos
{
    private $db;

    public function __construct()
    {
        $database = new Database;
        $this->db = $database->getConnection();
    }

    public function registrarAcesso($localizacao)
    {
        $db = $this->db;

        $sql = "INSERT INTO acessos (localizacao, data_acesso) VALUES (:localizacao, :data_acesso)";

        $executar = $db->prepare($sql);

        $executar->bindValue(':localizacao', $localizacao);
        $executar->bindValue(':data_acesso', time()); 

        $executar->execute();
        $affected_lines = $executar->rowCount();

        return ($affected_lines > 0) ? ['code' => 200, 'status' => 'Acesso registrado com sucesso'] : ['code' => 400, 'status' => 'Erro ao registrar acesso'];
    }

    public function contarAcessos()
    {
        $db = $this->db;

        $sql = "SELECT COUNT(*) AS total_acessos FROM acessos";
        $executar = $db->prepare($sql);
        $executar->execute();
        
        $resultado = $executar->fetch();

        return ($resultado) ? ['code' => 200, 'total_acessos' => $resultado['total_acessos']] : ['code' => 400, 'status' => 'Erro ao contar acessos'];
    }
}