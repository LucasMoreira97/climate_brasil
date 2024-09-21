function toggleConteudoClick(element) {
    var $element = $(element).closest('.demanda-visualizada');
    var $texto_topico = $element.find('.texto-topico');
    var $seta = $(element).find('.seta');

    $('.demanda-visualizada').not($element).each(function () {
        $(this).find('.texto-topico').css('maxHeight', '0px');
        $(this).find('.seta').css('transform', 'rotate(0deg)');
    });

    if ($texto_topico.css('maxHeight') === "0px" || $texto_topico.css('maxHeight') === "") {
        $texto_topico.css('maxHeight', $texto_topico[0].scrollHeight + "px");
        $seta.css('transform', 'rotate(90deg)');
    } else {
        $texto_topico.css('maxHeight', "0px");
        $seta.css('transform', 'rotate(0deg)');
    }
}

function ativarItem(elemento) {
    $(elemento).find('li').on('click', function () {
        $(elemento).find('li').removeClass('active');
        $(this).addClass('active');
    });
}

function smoothScrollTo(target, duration = 1000, use_native = false, offset = 0) {
    const $target_element = typeof target === 'string' ? $('#' + target) : $(target);

    if ($target_element.length) {
        const target_position = $target_element.offset().top + offset;

        if (use_native) {
            window.scrollTo({ top: target_position, behavior: 'smooth' });
        } else {
            $('html, body').animate({ scrollTop: target_position }, duration);
        }
    }
}


function isIOS() {
    return /iPhone|iPad|iPod/i.test(navigator.userAgent);
}

function compartilharLink(link, texto) {
    if (navigator.share && !isIOS()) {
        navigator.share({
            title: document.title,
            text: texto,
            url: link
        }).then(() => {
            showPopup('Link compartilhado com sucesso!');
        }).catch(() => {
            showPopup('Erro ao compartilhar o link.');
        });

    } else if (isIOS()) {
        copyToClipboard(link);
        showPopup('Link copiado para a área de transferência');
    } else {
        showPopup('Compartilhamento não suportado neste navegador.');
    }
}

function copyToClipboard(text) {
    const $input = $('<textarea>').val(text).appendTo('body').select();
    document.execCommand('copy');
    $input.remove();
}

function showPopup(message) {
    $('#popup').text(message).css('opacity', '1').fadeIn();

    setTimeout(() => {
        $('#popup').fadeOut(500, function () {
            $(this).css('opacity', '0');
        });
    }, 2000);
}

function ajustarDetalhesCartas() {
    $('.container-carta').each(function () {
        const $titulo = $(this).find('.titulo-carta');
        const $detalhesCartas = $(this).find('.detalhes-cartas');
        const $fotoCartas = $(this).find('.foto-cartas');

        if ($(window).width() < 750) {
            $titulo.insertBefore($fotoCartas);
        } else {
            $titulo.prependTo($detalhesCartas);
        }
    });
}

$(document).ready(function () {
    ativarItem('.regioes');
    ajustarDetalhesCartas();
});

$(window).on('resize', function () {
    ajustarDetalhesCartas();
});
