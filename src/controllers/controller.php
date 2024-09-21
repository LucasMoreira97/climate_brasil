<?php

include_once '../../config/Database.php';
include_once '../models/Cartas.php';
include_once '../models/Usuarios.php';
// include_once '../models/Acessos.php';

$data = json_decode(file_get_contents('php://input'), true);

switch ($data['operacao']) {

    case 'adicionar_nova_carta':
        $Cartas = new Cartas();
        $inserir_carta = $Cartas->inserirCarta($data);
        print_r($inserir_carta);
        break;

    case 'coordenadas_cartas':
        $resposta = (new Cartas)->coordenadaCartas(null, $data['regiao'], $data['estado']);
        break;

    case 'detalhes_carta':
        $detalhes = (new Cartas)->listarCartas($data['id_carta']);
        $resposta = $detalhes[0];
        break;

    case 'cartas_regiao':
        $regiao = !empty($data['regiao']) ? $data['regiao'] : null;
        $resposta = (new Cartas)->listarCartas(null, $data['regiao']);
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

echo json_encode($resposta);