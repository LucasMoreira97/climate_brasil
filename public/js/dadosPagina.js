class dadosPagina {

    constructor() {
        this.carregarMapa();
        this.demandas = '';
    }

    async carregarMapa(estado = null, regiao = null) {

        $('.pino').remove();

        const uri = '/climate_brasil/src/controllers/controller.php';
        const response = await fetch(uri, {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({
                operacao: 'coordenadas_cartas',
                regiao: regiao,
                estado: estado
            })
        });

        const data = await response.json();

        data.map(carta => {
            const coordenadas = JSON.parse(carta.coordenadas_pino);
            this.adicionarPino(coordenadas.x, coordenadas.y, carta.id, carta.titulo);
        });

        this.cartasRegiao(regiao);

    }

    adicionarPino(xPercent, yPercent, id_carta, titulo) {

        const $pino = $('<div></div>', {
            class: 'pino',
            id: id_carta,
            css: { left: xPercent + '%', top: yPercent + '%' },
            click: function () {
                const targetId = this.getAttribute('data-target');
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    smoothScrollTo(targetElement, 1000);
                }
            }
        }).attr('data-target', 'carta-' + id_carta); //fazer um id para carta aqui


        const $tooltip = $('<span></span>', {
            class: 'tooltip', text: titulo
        });

        $pino.append($tooltip);
        $('#mapa-container').append($pino);

        $pino.on('mouseenter', function () {
            $tooltip.css({ left: (xPercent + 2) + '%', top: (yPercent - 2) + '%' });
        });
    }

    async cartasRegiao(regiao) {

        const uri = '/climate_brasil/src/controllers/controller.php';
        const response = await fetch(uri, {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({
                operacao: 'cartas_regiao',
                regiao: regiao
            })
        });

        const data = await response.json();
        console.log(data);

        if (regiao == null) {
            regiao = 'Todas as regiões';
        }

        var cartas_regiao = '';

        $('.lista-cartas').html('');
        data.map(carta => {
            cartas_regiao += `<li onclick="smoothScrollTo('carta-${carta.id}');">
                                <p>${carta.titulo}</p>
                                <img src="${carta.foto_carta}">
                             </li>`

            this.detalhesCarta(carta);
        });

        var cartas_listadas = `<div class="nome-regiao">
                                    <img src="./public/image/pin-regiao.svg" alt="">
                                    <span>${regiao}</span>
                                </div>
                                <div class="cartas-regiao">
                                    <ul class="regiao-carta">
                                        ${cartas_regiao}
                                    </ul>
                                </div>`

        $('.regiao').html(cartas_listadas);
        $('.regiao').css({ opacity: 0, position: 'relative', top: '20px' });
        $('.regiao').animate({ opacity: 1, top: '0px' }, 600);

        ativarItem('.regiao-carta');
        const hash = window.location.hash.substring(1);
        if (hash) {
            smoothScrollTo(hash);
        }

    }

    async detalhesCarta(data) {

        $('.parceiros').html('');
        $('.demandas').html('');

        var demandas = JSON.parse(data.demandas);
        this.demandas = demandas;

        var lista_demandas = '';
        demandas.map(detalhes_demanda => {
            var nome_demanda = detalhes_demanda.demanda;
            var id_demanda = detalhes_demanda.id_demanda;
            lista_demandas += `<li onclick="dadospagina.demandasCarta('${data.id}','${id_demanda}')">${nome_demanda}</li>`;
        });

        var link_compartilhado = window.location.href;

        if (link_compartilhado.endsWith('/')) {
            link_compartilhado = link_compartilhado.slice(0, -1) + '#carta-' + data.id;
        }

        var tituloCarta = `<p class="titulo-carta">${data.titulo}</p>`;
        var imagemCarta = `<div class="foto-cartas">
                            <img src="${data.imagem}" alt="">
                         </div>`;
        var detalhesAcoes = `<div class="detalhes-cartas">
                                ${window.innerWidth > 750 ? tituloCarta : ''}
                                <p class="resumo-carta">${data.resumo}</p>
                                <ul>${lista_demandas}</ul>
                                <div class="acoes-carta">
                                    <button class="leia-na-integra">LEIA NA ÍNTEGRA</button>
                                    <button class="compartilhar" onclick="compartilharLink('${link_compartilhado}')">COMPARTILHAR</button>
                                </div>
                             </div>`;

        var detalhes_carta = `<div class="container-carta" id="carta-${data.id}">
                                ${window.innerWidth > 750 ? '' : tituloCarta}
                                ${imagemCarta}
                                ${detalhesAcoes}
                              </div>
                              <div class="parceiros"></div>
                              <div class="demandas" id_carta="${data.id}"></div>
                              <hr>`;


        $('.lista-cartas').append(detalhes_carta);
        $('.lista-cartas').css({ opacity: 0, position: 'relative', top: '20px' });
        $('.lista-cartas').animate({ opacity: 1, top: '0px' }, 600);

        //-------------------------------------------------------
        var parceiros = JSON.parse(data.logo_parceiros);
        var logo_parceiros = '';

        parceiros.map(parceiro => {
            logo_parceiros += `<li><img src="${parceiro.logo}"></li>`;
        });

        var div_parceiros = `
                    <p>Parceiros</p>
                    <ul class="logo-apoio">${logo_parceiros}</ul>`;
        //-------------------------------------------------------
        $('.parceiros').html(div_parceiros);
        $('.parceiros').css({ opacity: 0, position: 'relative', top: '20px' });
        $('.parceiros').animate({ opacity: 1, top: '0px' }, 600);
    }


    demandasCarta(id_carta, id_demanda) {

        var demanda_selecionada = this.demandas.find(function (item) {
            return item.id_demanda == id_demanda;
        });

        var titulo_demanda = demanda_selecionada.demanda;
        var imagem_demanda = demanda_selecionada.foto_demanda;
        var topicos_demanda = demanda_selecionada.topicos;

        var conteudo_topico = '';
        topicos_demanda.map(conteudo => {
            conteudo_topico += `<div class="demanda-visualizada" id="carta-${id_carta}-demanda-${id_demanda}">
                                    <div class="topico" onclick="toggleConteudoClick(this)">
                                        <img class="seta" src="./public/image/chevron-right-solid.svg">${conteudo.topico}
                                    </div>
                                    <p class="texto-topico">${conteudo.texto_topico}</p>
                                </div>`;
        });

        $(`div[id_carta="${id_carta}"]`).html(`<div class="titulo-demanda">${titulo_demanda}</div>
                             <div class="content-demandas">
                                <div class="foto-demanda">
                                    <img src="${imagem_demanda}">
                                </div>
                                <div class="texto-demanda">${conteudo_topico}</div>
                             </div>`);

        $(`div[id_carta="${id_carta}"]`).css({ opacity: 0, position: 'relative', top: '20px' });
        $(`div[id_carta="${id_carta}"]`).animate({ opacity: 1, top: '0px' }, 600);


        smoothScrollTo(`carta-${id_carta}-demanda-${id_demanda}`, 1000, false, -350);

    }

}


var dadospagina = new dadosPagina();
