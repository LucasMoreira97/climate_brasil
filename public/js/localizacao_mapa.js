
fetch('../image/Blank_Map_of_Brazil.svg')
    .then(response => response.text())
    .then(svgText => {
        document.getElementById('mapa-container').innerHTML = svgText;
        const mapa = document.querySelector('svg');
        mapa.id = 'mapa';

        mapa.setAttribute('width', '100%');
        mapa.setAttribute('height', 'auto');

        mapa.addEventListener('click', function (event) {
            const rect = mapa.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;

            const xPercent = (x / rect.width) * 100;
            const yPercent = (y / rect.height) * 100;

            console.log(xPercent);
            console.log(yPercent);

            // alert(`Coordenadas clicadas: X: ${xPercent.toFixed(2)}%, Y: ${yPercent.toFixed(2)}%`);
            adicionarPino(xPercent, yPercent);
        });
    });


function adicionarPino(xPercent, yPercent) {
    const pino = document.createElement('div');
    pino.classList.add('pino');
    pino.style.left = xPercent + '%';
    pino.style.top = yPercent + '%';

    pino.addEventListener('dblclick', function () {
        pino.remove();
    });

    document.getElementById('mapa-container').appendChild(pino);
}
