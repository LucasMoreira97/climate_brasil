$(document).ready(function() {
    $('.topico').click(function() {
      $(this).toggleClass('active');
      var textoTopico = $(this).next('.texto-topico');
      if (textoTopico.css('max-height') !== '0px') {
        textoTopico.css('max-height', '0');
      } else {
        textoTopico.css('max-height', textoTopico.get(0).scrollHeight + 'px');
      }
    });
  });