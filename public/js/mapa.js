fetch('public/image/Blank_Map_of_Brazil.svg')
    .then(response => response.text())
    .then(svgText => {
        document.getElementById('mapa-container').innerHTML = svgText;
        const mapa = document.querySelector('svg');
        mapa.id = 'mapa';

        mapa.setAttribute('width', '100%');
        mapa.setAttribute('height', 'auto');

    });
