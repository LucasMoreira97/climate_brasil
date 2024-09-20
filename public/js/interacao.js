function toggleConteudo(element) {
    var topico = element.querySelector('.topico');
    var textoTopico = element.querySelector('.texto-topico');
    var seta = topico.querySelector('.seta');

    if (textoTopico.style.maxHeight === "0px" || textoTopico.style.maxHeight === "") {
        textoTopico.style.maxHeight = textoTopico.scrollHeight + "px";
        seta.style.transform = "rotate(90deg)";
    } else {
        textoTopico.style.maxHeight = "0px";
        seta.style.transform = "rotate(0deg)";
    }
}

function ativarItem(elemento) {
    $(elemento + ' li').click(function () {
        $(elemento + ' li').removeClass('active');

        $(this).addClass('active');
    });
}


$(document).ready(function () {
    ativarItem('.regioes');
});