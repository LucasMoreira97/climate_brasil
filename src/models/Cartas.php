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

    private function cartaExiste($titulo)
    {
        $sql = "SELECT id FROM cartas WHERE titulo = :titulo LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':titulo', $titulo);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result ? true : false;
    }

    public function inserirCarta($data)
    {
        if ($this->cartaExiste($data['titulo'])) {
            return ['code' => 400, 'status' => 'Erro: já existe uma carta com esse título'];
        }

        $sql = "INSERT INTO cartas (titulo, resumo, demandas, imagem, coordenadas_pino, estado, abreviacao_estado, cidade)
                VALUES (:titulo, :resumo, :demandas, :imagem, :coordenadas_pino, :estado, :abreviacao_estado, :cidade)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':titulo', $data['titulo']);
        $stmt->bindValue(':resumo', $data['resumo']);
        $stmt->bindValue(':demandas', $data['demandas']);
        $stmt->bindValue(':imagem', $data['imagem']);
        $stmt->bindValue(':coordenadas_pino', $data['coordenadas_pino']);
        $stmt->bindValue(':estado', $data['estado']);
        $stmt->bindValue(':abreviacao_estado', $data['abreviacao_estado']);
        $stmt->bindValue(':cidade', $data['cidade']);

        $stmt->execute();
        $affected_lines = $stmt->rowCount();

        return ($affected_lines > 0) ? ['code' => 200, 'status' => 'Carta inserida com sucesso'] : ['code' => 400, 'status' => 'Erro ao inserir carta'];
    }

    public function editarCarta($data)
    {
        $db = $this->db;

        if ($data['titulo'] !== $data['novoTitulo'] && $this->cartaExiste($data['novoTitulo'])) {
            return ['code' => 400, 'status' => 'Erro: já existe uma carta com esse novo título'];
        }

        $sql = "UPDATE cartas SET titulo = :novoTitulo, resumo = :resumo, demandas = :demandas, imagem = :imagem, coordenadas_pino = :coordenadas_pino,
               estado = :estado, abreviacao_estado = :abreviacao_estado, cidade = :cidade
                WHERE titulo = :titulo";

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':titulo', $data['titulo']);
        $stmt->bindValue(':novoTitulo', $data['novoTitulo']);
        $stmt->bindValue(':resumo', $data['resumo']);
        $stmt->bindValue(':demandas', $data['demandas']);
        $stmt->bindValue(':imagem', $data['imagem']);
        $stmt->bindValue(':coordenadas_pino', $data['coordenadas_pino']);
        $stmt->bindValue(':estado', $data['estado']);
        $stmt->bindValue(':abreviacao_estado', $data['abreviacao_estado']);
        $stmt->bindValue(':cidade', $data['cidade']);

        $stmt->execute();
        $affected_lines = $stmt->rowCount();

        return ($affected_lines > 0) ? ['code' => 200, 'status' => 'Carta atualizada com sucesso'] : ['code' => 400, 'status' => 'Erro ao atualizar carta ou nenhum dado foi modificado'];
    }

    public function excluirCartas($userEmail, $titulo)
    {

        $sql = "DELETE FROM cartas WHERE titulo = :titulo";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':titulo', $titulo);
        $stmt->execute();

        $affected_lines = $stmt->rowCount();
        return ($affected_lines > 0) ? ['code' => 200, 'status' => 'Carta excluída com sucesso'] : ['code' => 400, 'status' => 'Erro ao excluir carta ou carta não encontrada'];
    }

    public function listarCartas($id_carta = null, $regiao = null, $estado = null)
    {

        $sql = 'SELECT * FROM cartas WHERE removida = 0';
        $sql .= !empty($id_carta) ? ' AND id = :id_carta' : '';
        $sql .= !empty($regiao) ? ' AND regiao = :regiao' : '';
        $sql .= !empty($estado) ? ' AND estado = :estado' : '';

        $stmt = $this->db->prepare($sql);

        if (!empty($id_carta)) {
            $stmt->bindValue(':id_carta', $id_carta);
        }

        if (!empty($regiao)) {
            $stmt->bindValue(':regiao', $regiao);
        }

        if (!empty($estado)) {
            $stmt->bindValue(':estado', $estado);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function coordenadaCartas($id_carta = null, $regiao = null, $estado = null)
    {

        $sql = 'SELECT id, titulo, regiao, coordenadas_pino FROM cartas WHERE removida = 0';
        $sql .= !empty($id_carta) ? ' AND id = :id_carta' : '';
        $sql .= !empty($regiao) ? ' AND regiao = :regiao' : '';
        $sql .= !empty($estado) ? ' AND estado = :estado' : '';

        $stmt = $this->db->prepare($sql);

        if (!empty($id_carta)) {
            $stmt->bindValue(':id_carta', $id_carta);
        }

        if (!empty($regiao)) {
            $stmt->bindValue(':regiao', $regiao);
        }

        if (!empty($estado)) {
            $stmt->bindValue(':estado', $estado);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
