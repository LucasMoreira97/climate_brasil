<?php

class Database
{


    private $servidor;
    private $nome_banco;
    private $usuario;
    private $senha;
    private $conexao;

    public function __construct()
    {
        $this->servidor = 'localhost';
        $this->nome_banco = 'climate_brasil';
        $this->usuario = 'root';
        $this->senha  = '';
        $this->conexao = '';
    }

    public function getConnection()
    {
        $this->conexao = new PDO("mysql:host=" . $this->servidor . ";dbname=" . $this->nome_banco, $this->usuario, $this->senha);
        $this->conexao->exec("set names utf8");

        return $this->conexao;
    }
}
