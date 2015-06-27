/* 
 * Arquivo de exemplo 
 * Execução de leitura
 */
(function ($) {

    var m_a = $('.minha-area'), url = '/' + '/';

    m_a.find('h2').fadeIn();

    setTimeout(function () {

        m_a.find('h5').html('<a href="' + url + 'github.com/williankeller/Comprime-Arquivos">Fork on GitHub</a>').fadeIn('slow');

    }, 1000);

}(window.jQuery));
