<?php


// require_once('./config/Database.php');

class Cartas
{
    private $db;

    public function __construct()
    {
        $database = new Database;
        $this->db = $database->getConnection();
    }

    private function tituloExiste($titulo)
    {
        $sql = "SELECT id FROM cartas WHERE titulo = :titulo LIMIT 1";
        $executar = $this->db->prepare($sql);
        $executar->bindValue(':titulo', $titulo);
        $executar->execute();
        $result = $executar->fetch();

        return $result ? true : false;
    }

    public function inserirCarta($data)
    {
        $db = $this->db;

        if ($this->tituloExiste($data['titulo'])) {
            return ['code' => 400, 'status' => 'Erro: já existe uma carta com esse título'];
        }

        $sql = "INSERT INTO cartas (titulo, resumo, demandas, imagens, coordenadas_pino, estado, abreviacao_estado, cidade)
                VALUES (:titulo, :resumo, :demandas, :imagens, :coordenadas_pino, :estado, :abreviacao_estado, :cidade)";

        $executar = $this->db->prepare($sql);

        $executar->bindValue(':titulo', $data['titulo']);
        $executar->bindValue(':resumo', $data['resumo']);
        $executar->bindValue(':demandas', $data['demandas']);
        $executar->bindValue(':imagens', $data['imagens']);
        $executar->bindValue(':coordenadas_pino', $data['coordenadas_pino']);
        $executar->bindValue(':estado', $data['estado']);
        $executar->bindValue(':abreviacao_estado', $data['abreviacao_estado']);
        $executar->bindValue(':cidade', $data['cidade']);

        $executar->execute();
        $affected_lines = $executar->rowCount();

        return ($affected_lines > 0) ? ['code' => 200, 'status' => 'Carta inserida com sucesso'] : ['code' => 400, 'status' => 'Erro ao inserir carta'];
    }

    public function editarCarta($data)
    {
        $db = $this->db;

        if ($data['titulo'] !== $data['novoTitulo'] && $this->tituloExiste($data['novoTitulo'])) {
            return ['code' => 400, 'status' => 'Erro: já existe uma carta com esse novo título'];
        }

        $sql = "UPDATE cartas SET titulo = :novoTitulo, resumo = :resumo, demandas = :demandas, imagens = :imagens, coordenadas_pino = :coordenadas_pino,
               estado = :estado, abreviacao_estado = :abreviacao_estado, cidade = :cidade
                WHERE titulo = :titulo";

        $executar = $db->prepare($sql);

        $executar->bindValue(':titulo', $data['titulo']);
        $executar->bindValue(':novoTitulo', $data['novoTitulo']);
        $executar->bindValue(':resumo', $data['resumo']);
        $executar->bindValue(':demandas', $data['demandas']);
        $executar->bindValue(':imagens', $data['imagens']);
        $executar->bindValue(':coordenadas_pino', $data['coordenadas_pino']);
        $executar->bindValue(':estado', $data['estado']);
        $executar->bindValue(':abreviacao_estado', $data['abreviacao_estado']);
        $executar->bindValue(':cidade', $data['cidade']);

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

        return $usuario && $usuario['tipos'] == 'administrador';
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
