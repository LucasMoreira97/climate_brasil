<?php

include_once '../../config/Database.php';
include_once '../models/Cartas.php';
include_once '../models/Usuarios.php';
include_once '../models/Acessos.php';

$data = [

    'operacao' => 'adicionar_nova_carta',
    // 'operacao' => 'editar_uma_carta',
    // 'operacao' => 'excluir_carta',
    // 'operacao' => 'cadastrar_usuario',
    // 'operacao' => 'excluir_usuario',
    // 'operacao' => 'registrar_acesso',
    // 'operacao' => 'contar_acessos',

    'titulo' => 'Quimadas',
    'resumo' => 'blablablba',
    'demandas' =>  'A.B,C',
    'imagens' => 'http://example.com/image.jpg',
    'coordenadas_pino' =>  '23.5505,-46.6333',
    'estado' => 'São Paulo',
    'abreviacao_estado' => 'SP',
    'cidade' => 'São Paulo',
    'novoTitulo' => 'New NEW',
    'nome' => 'João Souza',
    'tipo' => 'administrador',
    'email' => 'silva@example.com',
    'senha' => 'senha123',

];

$userEmail = 'a@a';
$adminEmail = 'silva@example.com';

switch ($data['operacao']) {

    case 'adicionar_nova_carta':
        $Cartas = new Cartas();
        $inserir_carta = $Cartas->inserirCarta($data);
        print_r($inserir_carta);
        break;

    case 'editar_uma_carta';
        $Cartas = new Cartas();
        $editar_carta = $Cartas->editarCarta($data);
        print_r($editar_carta);
        break;

    case 'excluir_carta';
        $Cartas = new Cartas();
        $excluir_carta = $Cartas->excluirCartas($userEmail, $data['titulo']);
        print_r($excluir_carta);
        break;

    case 'cadastrar_usuario';
        $Usuarios = new Usuarios();
        $cadastrar_usuario = $Usuarios->CadastrarUsuario($data);
        print_r($cadastrar_usuario);
        break;

    case 'excluir_usuario';
        $Usuarios = new Usuarios();
        $excluir_usuario = $Usuarios->ExcluirUsuario($adminEmail, $data['email']);
        print_r($excluir_usuario);
        break;

    case 'registrar_acesso';
        $Acessos = new Acessos();
        $registar_acesso = $Acessos->registrarAcesso($localizacao);
        print_r($registar_acesso);
        break;

    case 'contar_acessos';
        $Acessos = new Acessos();
        $contar_acessos = $Acessos->contarAcessos();
        print_r($contar_acessos);
        break;
}
