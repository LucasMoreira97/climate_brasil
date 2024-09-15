<?php

class Cartas
{
    private $db;

    public function __construct()
    {
        $database = new Database;
        $this->db = $database->getConnection();
    }

    public function inserirCarta($titulo, $resumo, $demandas, $imagens, $coordenadas_pino, $estado, $abreviacao_estado, $cidade)
    {
        $db = $this->db;

        $sql = "INSERT INTO cartas (titulo, resumo, demandas, imagens, coordenadas_pino, estado, abreviacao_estado, cidade)
                VALUES (:titulo, :resumo, :demandas, :imagens, :coordenadas_pino, :estado, :abreviacao_estado, :cidade)";

        $executar = $db->prepare($sql);

        $executar->bindValue(':titulo', $titulo);
        $executar->bindValue(':resumo', $resumo);
        $executar->bindValue(':demandas', $demandas);
        $executar->bindValue(':imagens', $imagens);
        $executar->bindValue(':coordenadas_pino', $coordenadas_pino);
        $executar->bindValue(':estado', $estado);
        $executar->bindValue(':abreviacao_estado', $abreviacao_estado);
        $executar->bindValue(':cidade', $cidade);

        $executar->execute();
        $affected_lines = $executar->rowCount();

        return ($affected_lines > 0) ? ['code' => 200, 'status' => 'Carta inserida com sucesso'] : ['code' => 400, 'status' => 'Erro ao inserir carta'];
    }

    public function editarCarta($titulo, $novoTitulo, $resumo, $demandas, $imagens, $coordenadas_pino, $estado, $abreviacao_estado, $cidade)
    {

        $db = $this->db;

        $sql = "UPDATE cartas SET titulo = :novoTitulo, resumo = :resumo, demandas = :demandas, imagens = :imagens, coordenadas_pino = :coordenadas_pino,
               estado = :estado, abreviacao_estado = :abreviacao_estado, cidade = :cidade
                WHERE titulo = :titulo";

        $executar = $db->prepare($sql);

        $executar->bindValue(':titulo', $titulo);  
        $executar->bindValue(':novoTitulo', $novoTitulo); 
        $executar->bindValue(':resumo', $resumo);
        $executar->bindValue(':demandas', $demandas);
        $executar->bindValue(':imagens', $imagens);
        $executar->bindValue(':coordenadas_pino', $coordenadas_pino);
        $executar->bindValue(':estado', $estado);
        $executar->bindValue(':abreviacao_estado', $abreviacao_estado);
        $executar->bindValue(':cidade', $cidade);

        $executar->execute();
        $affected_lines = $executar->rowCount();

        return ($affected_lines > 0) ? ['code' => 200, 'status' => 'Carta atualizada com sucesso'] : ['code' => 400, 'status' => 'Erro ao atualizar carta ou nenhum dado foi modificado'];
    }

    private function isAdmin($userEmail)
    {
        $sql = "SELECT tipos FROM usuarios WHERE email = :email LIMIT 1";
        $executar = $this->db->prepare($sql);
        $executar->bindValue(':email', $userEmail);
        $executar->execute();
        $usuario = $executar->fetch();

        return $usuario && $usuario['tipos'] === 'administrador';
    }

    public function excluirCartas($userEmail, $titulo)
    {
        $db = $this->db;

        if (!$this->isAdmin($userEmail)) {
            return ['code' => 403, 'status' => 'Ação não permitida. Apenas administradores podem excluir cartas.'];
        }

        $sql = "DELETE FROM cartas WHERE titulo = :titulo";
        $executar = $db->prepare($sql);

        $executar->bindValue(':titulo', $titulo);

        $executar->execute();
        $affected_lines = $executar->rowCount();

        return ($affected_lines > 0) ? ['code' => 200, 'status' => 'Carta excluída com sucesso'] : ['code' => 400, 'status' => 'Erro ao excluir carta ou carta não encontrada'];
    }
}
