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
        // console.log(data);

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
                dadospagina.detalhesCarta(id_carta);
            }
        });

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



        // <div class="nome-regiao">
        //     <img src="./public/image/pin-regiao.svg" alt="">
        //     <span>Todas as regiões</span>
        // </div>

        // <div class="cartas-regiao">
        //     <ul class="regiao-carta">
        //     </ul>
        // </div>


        if(regiao == null){
            regiao = 'Todas as regiões';
        }

        var cartas_regiao = '';
        // foto_carta

        data.map(carta => {
            cartas_regiao += `<li onclick="dadospagina.detalhesCarta(${carta.id})">
                                <p>${carta.titulo}</p>
                                <img src="${carta.foto_carta}">
                             </li>`
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
    }

    async detalhesCarta(id_carta) {

        $('.container-carta').html('');
        $('.parceiros').html('');
        $('.demandas').html('');

        const uri = '/climate_brasil/src/controllers/controller.php';
        const response = await fetch(uri, {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({
                operacao: 'detalhes_carta', id_carta: id_carta
            })
        });

        const data = await response.json();
        // console.log(data)

        var demandas = JSON.parse(data.demandas);
        this.demandas = demandas;

        var lista_demandas = '';
        demandas.map(detalhes_demanda => {

            var nome_demanda = detalhes_demanda.demanda;
            var id_demanda = detalhes_demanda.id_demanda;
            lista_demandas += `<li onclick="dadospagina.demandasCarta('${id_demanda}')">${nome_demanda}</li>`;
        });

        var detalhes_carta = `
                    <div class="foto-cartas">
                        <img src="${data.imagem}" alt="">
                    </div>

                    <div class="detalhes-cartas">
                        <p class="titulo-carta">${data.titulo}</p>
                        <p class="resumo-carta">${data.resumo}</p>
                        <ul>${lista_demandas}</ul>
                        <button class="leia-na-integra">LEIA NA ÍNTEGRA</button> 
                    </div>`;

        $('.container-carta').html(detalhes_carta);
        $('.container-carta').css({ opacity: 0, position: 'relative', top: '20px' });
        $('.container-carta').animate({ opacity: 1, top: '0px' }, 600);

        //-------------------------------------------------------
        var parceiros = JSON.parse(data.logo_parceiros);
        var logo_parceiros = '';

        // console.log(parceiros);

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


    demandasCarta(id_demanda) {

        // console.log(id_demanda);
        // console.log(this.demandas);

        var demanda_selecionada = this.demandas.find(function (item) {
            return item.id_demanda == id_demanda;
        });

        // console.log(demanda_selecionada);

        var titulo_demanda = demanda_selecionada.demanda;
        var imagem_demanda = demanda_selecionada.foto_demanda;
        var topicos_demanda = demanda_selecionada.topicos;

        console.log(imagem_demanda);

        var conteudo_topico = '';
        topicos_demanda.map(conteudo => {
            conteudo_topico += `<div class="demanda-visualizada" onmouseover="toggleConteudo(this)" onmouseout="toggleConteudo(this)">
                                    <div class="topico">
                                        <img class="seta" src="./public/image/chevron-right-solid.svg">${conteudo.topico}
                                    </div>
                                    <p class="texto-topico">${conteudo.texto_topico}</p>
                                </div>`;
        });

        $('.demandas').html(`<div class="titulo-demanda">${titulo_demanda}</div>
                             <div class="content-demandas">
                                <div class="foto-demanda">
                                    <img src="${imagem_demanda}">
                                </div>
                                <div class="texto-demanda">${conteudo_topico}</div>
                             </div>`);

        $('.demandas').css({ opacity: 0, position: 'relative', top: '20px' });
        $('.demandas').animate({ opacity: 1, top: '0px' }, 600);
    }

}


var dadospagina = new dadosPagina();
