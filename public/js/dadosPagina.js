class dadosPagina {


    async carregarMapa(estado = null, regiao = null) {

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

        if (regiao != null) {
            this.cartasRegiao(regiao);
        }

    }

    adicionarPino(xPercent, yPercent, id_carta, titulo) {
        const pino = document.createElement('div');
        pino.classList.add('pino');
        pino.id = id_carta;
        pino.style.left = xPercent + '%';
        pino.style.top = yPercent + '%';

        pino.onclick = function () {
            dadospagina.detalhesCarta(id_carta);
        };

        const tooltip = document.createElement('span');
        tooltip.classList.add('tooltip');
        tooltip.innerText = titulo;

        pino.appendChild(tooltip);

        document.getElementById('mapa-container').appendChild(pino);

        pino.addEventListener('mouseenter', function () {
            tooltip.style.left = (xPercent + 2) + '%';
            tooltip.style.top = (yPercent - 2) + '%';
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

        var cartas_regiao = '';

        data.map(carta => {
            cartas_regiao += `<li onclick=" dadospagina.detalhesCarta(${carta.id})">${carta.titulo}</li>`
        });

        var cartas_listadas = `<div class="nome-regiao">
                                    <img src="./public/image/pin-regiao.svg" alt="">
                                    <span>${regiao}</span>
                                </div>
                                <div class="cartas-regiao">
                                    <ul>
                                        ${cartas_regiao}
                                    </ul>
                                </div>`

        $('.regiao').html(cartas_listadas);
        $('.regiao').css({ opacity: 0, position: 'relative', top: '20px' });
        $('.regiao').animate({ opacity: 1, top: '0px' }, 600);
    }



    async detalhesCarta(id_carta) {
        const uri = '/climate_brasil/src/controllers/controller.php';
        const response = await fetch(uri, {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({
                operacao: 'detalhes_carta', id_carta: id_carta
            })
        });

        const data = await response.json();
        console.log(data);


    }

}


var dadospagina = new dadosPagina();
