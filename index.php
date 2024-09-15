<?php

require_once('./src/models/Usuarios.php');
require_once './src/models/Cartas.php';
require_once './src/models/Acessos.php';

$cartas = new Cartas();
$Usuarios = new Usuarios();
$acessos = new Acessos();


$data_cadastrar = [
    'nome' => 'João Souza',
    'tipo' => 'administrador',
    'email' => 'silva@example.com',
    'senha' => 'senha123'  // Certifique-se de usar hash de senha em produção
];

// Chamar a função para cadastrar o usuário passando o array $data_cadastrar
$resultado = $Usuarios->CadastrarUsuario($data_cadastrar);
print_r($resultado);




// $adminEmail = 'caiosouza@gmail.com';

// $email = '';


// $excluir = $Usuarios->ExcluirUsuario($adminEmail, $email);
// print_r($excluir);

// $data_inserir = [
//     'titulo' => 'Título Rei',
//     'resumo' => 'Resumo da carta de exemplo',
//     'demandas' => 'Demandas de exemplo',
//     'imagens' => 'http://example.com/image.jpg',
//     'coordenadas_pino' => '23.5505,-46.6333',
//     'estado' => 'São Paulo',
//     'abreviacao_estado' => 'SP',
//     'cidade' => 'São Paulo'
// ];

// $resultado = $cartas->inserirCarta($data_inserir);
// print_r($resultado);



// $data_editar = [
//     'titulo' => 'Novo Título',  // Título atual
//     'novoTitulo' => 'New',
//     'resumo' => 'Resumo atualizado da carta',
//     'demandas' => 'Demandas atualizadas',
//     'imagens' => 'http://example.com/new_image.jpg',
//     'coordenadas_pino' => '23.5505,-46.6333',
//     'estado' => 'Rio de Janeiro',
//     'abreviacao_estado' => 'RJ',
//     'cidade' => 'Rio de Janeiro'
// ];

// $resultado = $cartas->editarCarta($data_editar);
// print_r($resultado);

// print_r($atualizar);

// $userEmail = 'caiosouza@gmail.com';
// $titulo = 'Título Atualizado';

// $excluir = $cartas->excluirCartas($userEmail, $titulo);
// print_r($excluir);

// $resultado = $acessos->contarAcessos();
// print_r($resultado);
