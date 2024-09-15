<?php

require_once('./src/models/Usuarios.php');
require_once './src/models/Cartas.php';
require_once './src/models/Acessos.php';

$cartas = new Cartas();
$Usuarios = new Usuarios();
$acessos = new Acessos();


// $nome = 'Caio Souza';
// $tipo = 'administrador';
// $email = 'caiosouza@gmail.com';
// $senha = '203040';

// $cadastro = $Usuarios->CadastrarUsuario($nome, $tipo, $email, $senha);
// print_r($cadastro);


// $adminEmail = 'caiosouza@gmail.com';

// $email = '';


// $cadastrar = $Usuarios->ExcluirUsuario($adminEmail, $email);
// print_r($cadastrar);

// $titulo = 'Título Exemplo de Carta';
// $resumo = 'Este é um resumo exemplo para a carta que será inserida no banco de dados.';
// $demandas = 'Aqui estão as demandas relacionadas a esta carta.';
// $imagens = 'http://exemplo.com/imagem1.jpg, http://exemplo.com/imagem2.jpg';
// $coordenadas_pino = '23.5505,-46.6333'; // Exemplo de coordenadas de São Paulo
// $estado = 'São Paulo';
// $abreviacao_estado = 'SP';
// $cidade = 'São Paulo';

// $cadastro_Carta = $cartas->inserirCarta($titulo, $resumo, $demandas, $imagens, $coordenadas_pino, $estado, $abreviacao_estado, $cidade);
// print_r($cadastro_Carta);



// $titulo = 'Título Atualizado da Carta';  
// $novoTitulo = 'Título Atualizado'; 
// $resumo = 'Este é um resumo atualizado.';
// $demandas = 'Demandas do rio.';
// $imagens = 'http://exemplo.com/nova_imagem1.jpg, http://exemplo.com/nova_imagem2.jpg';
// $coordenadas_pino = '23.5505,-46.6333';  // Exemplo de coordenadas de São Paulo
// $estado = 'Rio de Janeiro';
// $abreviacao_estado = 'RJ';
// $cidade = 'Rio de Janeiro';

// $atualizar = $cartas->editarCarta($titulo, $novoTitulo, $resumo, $demandas, $imagens, $coordenadas_pino, $estado, $abreviacao_estado, $cidade);

// print_r($atualizar);

// $userEmail = 'caiosouza@gmail.com';
// $titulo = 'Título Atualizado';

// $excluir = $cartas->excluirCartas($userEmail, $titulo);
// print_r($excluir);

$resultado = $acessos->contarAcessos();
print_r($resultado);
