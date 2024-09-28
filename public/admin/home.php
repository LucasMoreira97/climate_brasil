<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Inferior Fixo</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>

    <div class="container">

        <div id="mapa-container"></div>

        <div class="home">


            <div class="adicionar-carta">

                <p class="legenda-pagina">Adicionar uma nova carta</p>

                <form action="">

                    <div class="cabecalho">

                        <div class="grupo-item">
                            <label for="nome-carta">Nome da carta</label>
                            <input id="nome-carta" type="text">
                        </div>


                        <div class="grupo-item">
                            <label for="imagem-carta">Capa da carta</label>
                            <input id="imagem-carta" type="file" accept="image/*">
                        </div>

                        <div class="grupo-item">
                            <label for="resumo-carta">Resumo da carta</label>
                            <textarea name="resumo-carta" id="resumo-carta"></textarea>
                        </div>

                    </div>




                    <div class="demandas">

                        <p>Demandas</p>

                        <div class="dados-demanda" id_demanda="1">

                            <div class="grupo-item">
                                <label for="titulo-demanda">Título</label>
                                <input id="titulo-demanda" type="text">
                            </div>


                            <div class="grupo-item">
                                <label for="foto-demanda">Foto para demanda</label>
                                <input id="foto-demanda" type="file" accept="image/*">
                            </div>



                            <div class="topicos">

                                <div class="grupo-item">
                                    <label for="topico-1">Topico 1</label>
                                    <input id="topico-1" type="text">
                                </div>

                                <div class="grupo-item">
                                    <label for="texto-topico-1">Informações</label>
                                    <input id="texto-topico-1" type="text">
                                </div>

                                <button>Adicionar novo topico</button>



                            </div>





                        </div>





                    </div>

                    <button>Adicionar nova demanda</button>





                </form>



            </div>






        </div>





        <div class="menu-inferior">
            <div class="menu-item">
                <i class="fas fa-plus"></i>
                <span>Adicionar uma carta</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-edit"></i>
                <span>Editar cartas</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-eraser"></i>
                <span>Remover cartas</span>
            </div>
        </div>
    </div>

    <script src="../js/admin.js"></script>
    <script src="../js/localizacao_mapa.js"></script>

</body>

</html>