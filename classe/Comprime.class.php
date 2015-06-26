<?php

/**
 * Class Compressao
 * 
 * Compressão e União de Arquivos
 * Classe responsável pela compressão e unificação de arquivos css e js
 * 
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author Willian keller <will_levinki@hotmail.com>
 * @package Compressao
 */
class Compressao {
    /*
     * Variável de entrada da compressão
     * @var $entrada (varchar) 
     */

    private $entrada;

    /*
     * Tipo de arquivo à ser unificado e comprimido (js ou css)
     * @var $tipo (varchar) 
     */
    private $tipo;

    /*
     * Conteúdo retirado do arquivo informado na @entrada
     * @var $conteudo (varchar) 
     */
    private $conteudo;

    /*
     * Conteúdo em laço preparado para ser unificado
     * @var $unificados (array) 
     */
    private $unificados;

    /*
     * Recebe o tempo de modificação do arquivo
     * @var $modificado (int)
     */
    private $modificado = 0;

    /*
     * Pasta padrão dos arquivos da @entrada
     * @default "recursos/"
     * @var $pasta (varchar)
     */
    public $pasta = "recursos/";

    /*
     * Nome do parâmetro que será resgatado da URL para identificar o tipo do arquivo
     * @default "tipo"
     * @var $buscaTipo (varchar)
     */
    public $buscaTipo = "tipo";

    /*
     * Nome do parâmetro que será resgatado da URL para identificar os arquivos
     * @default "arquivos"
     * @var $buscaArquivos (varchar)
     */
    public $buscaArquivos = "arquivos";

    /*
     * Define se o conteúdo deve ou não ser comprimido (true / false)
     * @default true
     * @var $arquivoComprime (boolean varchar)
     */
    public $arquivoComprime = true;

    /*
     * Define se o termo do nome do arquivo para que ele seja ignorado (.min / min. / .minify)
     * @default ".min"
     * @var $ignorar (varchar)
     */
    public $ignorar = ".min";

    /*
     * Define se o valor da entrada deve ser do tipo array ou varchar (true / false)
     * @default true
     * @var $modoArray (boolean varchar)
     */
    public $modoArray = true;

    /*
     * Define o modo de separação dos arquivos da @entrada (; / , / *)
     * NOTA: Não usar ponto (.) a classe o interpreta para definir outros valores
     * @default ";"
     * @var $modoSeparador (varchar)
     */
    public $modoSeparador = ";";

    /*
     * Define se o retorno deve ser cacheado em browser ou não (true / false)
     * @default false
     * @var $cacheavel (boolean varchar)
     */
    public $cacheavel = false;

    /*
     * Define o tempo de vida do Cache (em segundo)
     * @default 604800
     * @var $cache (int)
     */
    public $cache = 604800;

    /**
     * incluir()
     * Função responsável por incluir o conteúdo dos arquivos informados na @entrada 
     *
     * @function public
     * @param varchar $tipo (Tipo de arquivo à ser unificado e comprimido js ou css)
     * @param varchar / array $entrada (Variável de entrada da compressão)
     * @return $this->conteudo (Retorna conteúdo do arquivo da @entrada)
     */
    public function incluir($tipo, $entrada) {

        // Passando a variável $entrada para a instância @entrada
        $this->tipo = $tipo;

        // Passando a variável $entrada para a instância @entrada
        $this->entrada = $entrada;

        $this->_arquivoConteudo();

        /*
         * Verifica se a definição permite 
         * que o conteúdo seja cacheado
         */
        if ($this->cacheavel === true) {

            /*
             * Executa a função resposável por definir o tempo de vida do arquivo em cache
             */
            $this->_arquivoVida();

            /*
             * Executa a função responsável por criar o cache no browser
             */
            $this->_criaCacheBrowser();

            // Retorna o conteúdo cacheado
            return $this->conteudo;
        }
        // Retorna o conteúdo padrão
        return $this->conteudo;
    }

    /**
     * buscaTipo()
     * Função responsável por recuperar o tipo passado por parâmetro na URL 
     *
     * @function public
     * @method varchar $this->buscaTipo (Nome do parâmetro que será resgatado da URL para identificar o tipo do arquivo)
     * @return varchar $_GET (Retorna os tipo do arquivo)
     */
    public function buscaTipo() {

        // Retorna o tipo do arquivo
        return filter_input(INPUT_GET, $this->buscaTipo, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /**
     * buscaArquivos()
     * Função responsável por recuperar o tipo passado por parâmetro na URL 
     *
     * @function public
     * @method varchar $this->buscaArquivos (Nome do parâmetro que será resgatado da URL para identificar os arquivos)
     * @return varchar $_GET (Retorna a lista de arquivos)
     */
    public function buscaArquivos() {

        // Verifica se o modo array está ativo
        #if ($this->modoArray === true) {
        // Retorna a lista dos arquivos em modo array
        return filter_input(INPUT_GET, $this->buscaArquivos, FILTER_SANITIZE_SPECIAL_CHARS);
        #}
        // Retorna o parâmetro padrão do arquivo (Ainda unido pelo @modoSeparador)
        return filter_input(INPUT_GET, $this->buscaArquivos, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /**
     * _arquivoPasta()
     * Função responsável por retornar a rota base do arquivo 
     * incluindo a extenção passada pela @tipo
     *
     * @function private
     * @param varchar $arquivo (Arquivo passado na @entrada)
     * @return varchar (Retorna a rota base do arquivo)
     */
    private function _arquivoPasta($arquivo) {

        // Retorna a rota base do arquivo com a extenção
        return $_SERVER['DOCUMENT_ROOT'] . $this->pasta . $arquivo . '.' . $this->tipo;
    }

    /**
     * _arquivoConteudo()
     * Função responsável por retornar a rota base do arquivo 
     * incluindo a extenção passada pela @tipo
     *
     * @function private
     * @param varchar $arquivo (Arquivo passado na @entrada)
     * @return void
     */
    private function _arquivoConteudo() {

        /*
         * Função cria o header do tipo do arquivo para leitura
         */
        $this->_arquivoTipoConteudo();

        /*
         * Inicia o laço de leitura individal por arquivo
         */
        if (is_array($this->_arquivoSepara())) {

            foreach ($this->_arquivoSepara() as $arquivo) {

                // Verifica se o arquivo não existe
                if (file_exists($this->_arquivoPasta($arquivo))) {

                    /*
                     * Função responsável pela abertura e leitura do arquivo informado
                     */
                    $this->_arquivoLeitura($arquivo);
                } else {
                    /*
                     * Função responsável por definir o erro em formáto de comentátio no arquivo
                     */
                    $this->_arquivoErro('Erro ao incluir o arquivo:', $arquivo);
                }
            }
        } else {
            $this->_arquivoErro('Modo array ativo. ', 'Nenhum arquivo passado');
        }
        /*
         * Função responsável por unir o conteúdo dos arquivos
         */
        $this->_arquivoUnifica();
    }

    /**
     * _arquivoTipoConteudo()
     * Função cria o header do tipo do arquivo para leitura
     *
     * @function private
     * @return void
     */
    private function _arquivoTipoConteudo() {

        // Verifica se o tipo do arquivo corresponde ao desejado
        if ($this->tipo === 'css') {
            // Cria o header para leiura de css
            header('Content-type: text/css; charset=UTF-8');
        } else {
            // cria do header para leitura de javascript
            header('Content-Type: application/javascript');
        }
    }

    /**
     * _arquivoLeitura()
     * Função responsável pela abertura e leitura do arquivo informado
     *
     * @function private
     * @param varchar $arquivo
     * @return void
     */
    private function _arquivoLeitura($arquivo) {

        // Realiza a abertura do arquivo
        $fopen = fopen($this->_arquivoPasta($arquivo), 'r');

        // Realiza a leitura do arquivo
        $this->conteudo = fread($fopen, filesize($this->_arquivoPasta($arquivo)));

        /*
         * Verifica se o arquivo permite a compressão
         * Definição feita em "$this->ignorar"
         * Caso o nome do arquivo contenha esse valor, a compressão será ignorada
         */
        if (strpos(basename($arquivo), $this->ignorar) === false) {

            /*
             * Executa a função responsável pela compressão do conteúdo do arquivo
             */
            $this->_comprime();
        }
        /*
         * Define o conteúdo em laço preparado para ser unificado
         */
        $this->unificados[] = $this->conteudo;
    }

    /**
     * _arquivoErro()
     * Função responsável por definir o erro em formato de comentátio no arquivo
     *
     * @function private
     * @param varchar $arquivo
     * @return void
     */
    private function _arquivoErro($erro, $arquivo) {

        // Define a resposta em comentário para o laço
        $this->unificados[] = "\n/* \n * ERRO: " . $erro . " '" . $arquivo . "' \n */ \n";
    }

    /**
     * _arquivoSepara()
     * Função verifica se o modo é array
     * Caso seja, retorna valor padrão
     * Se não ela separa usando a base @modoSeparador
     *
     * @function private
     * @return array (Lista de arquivos em laço)
     */
    private function _arquivoSepara() {

        // Verifica se o modo array está ativo
        if ($this->modoArray === true) {

            // Retorna valor padrão
            return $this->entrada;
        }

        // Retorna usando a base @modoSeparador
        return explode($this->modoSeparador, $this->entrada);
    }

    /**
     * _arquivoUnifica()
     * Função responsável por unir o conteúdo dos arquivos
     *
     * @function private
     * @return void
     */
    private function _arquivoUnifica() {

        // Define o parâmetro conteúo com os conteúdos ufinicados
        $this->conteudo = implode('', $this->unificados);
    }

    /**
     * _arquivoVida()
     * Função resposável por definir o tempo de vida do arquivo em cache
     *
     * @function private
     * @return void
     */
    private function _arquivoVida() {

        // Monta o laço dos arquivos
        foreach ($this->_arquivoSepara() as $arquivo) {

            // recupera a data de criação do arquivo
            $tempo = filemtime($this->_arquivoPasta($arquivo));

            // Verifica o período de modificação
            if ($tempo > $this->modificado) {

                // Define o novo período de modificação
                $this->modificado = $tempo;
            }
        }
    }

    /**
     * _comprime()
     * Função responsável pela compressão do conteúdo do arquivo
     *
     * @function private
     * @return void
     */
    private function _comprime() {

        // Verifica se o método de compressão está ativo
        if ($this->arquivoComprime === true) {

            /*
             * Função responsável por remover os comentários em linha e em blocos
             */
            $this->_removeComentarios();

            /*
             * Função responsável por remover quebras de linha, tabs e grandes espaços
             */
            $this->_removeLinhas();

            /*
             * Função responsável por remover os espaços desnecessários entre os caracteres
             */
            $this->_removeEspacos();
        }
    }

    /**
     * _removeComentarios()
     * Função responsável por remover os comentários em linha e em blocos
     *
     * @function private
     * @return void
     */
    private function _removeComentarios() {

        // Inicia a substituição do conteúdo
        $this->conteudo = preg_replace('!/\*.*?\*/!s', '', $this->conteudo);
        $this->conteudo = preg_replace('/\n\s*\n/', "\n", $this->conteudo);
        $this->conteudo = preg_replace('/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/', '', $this->conteudo);
    }

    /**
     * _removeLinhas()
     * Função responsável por remover quebras de linha, tabs e grandes espaços
     *
     * @function private
     * @return void
     */
    private function _removeLinhas() {

        // Inicia a substituição do conteúdo
        $this->conteudo = str_replace(array("\t", "\n", "\r", '  ', '    ', '     '), '', $this->conteudo);
    }

    /**
     * _removeEspacos()
     * Função responsável por remover os espaços desnecessários entre os caracteres
     *
     * @function private
     * @return void
     */
    private function _removeEspacos() {

        // Inicia a substituição do conteúdo
        $this->conteudo = str_replace(array(" {", "{ "), '{', $this->conteudo);
        $this->conteudo = str_replace(array(" }", "} "), '}', $this->conteudo);
        $this->conteudo = str_replace(array(' <', '< '), '<', $this->conteudo);
        $this->conteudo = str_replace(array(' >', '> '), '>', $this->conteudo);
        $this->conteudo = str_replace(array(' +', '+ '), '+', $this->conteudo);
        $this->conteudo = str_replace(array(' -', '- '), '-', $this->conteudo);
        $this->conteudo = str_replace(array(' ]', '] '), ']', $this->conteudo);
        $this->conteudo = str_replace(array(' [', '[ '), '[', $this->conteudo);
        $this->conteudo = str_replace(array(';}', '} '), '}', $this->conteudo);
        $this->conteudo = str_replace(array(' ;', '; '), ';', $this->conteudo);
        $this->conteudo = str_replace(array(' (', '( '), '(', $this->conteudo);
        $this->conteudo = str_replace(array(' )', ') '), ')', $this->conteudo);
        $this->conteudo = str_replace(array(' ,', ', '), ',', $this->conteudo);
        $this->conteudo = str_replace(array(' :', ': '), ':', $this->conteudo);
        $this->conteudo = str_replace(array(' =', '= '), '=', $this->conteudo);
        $this->conteudo = str_replace(array(' ==', '== '), '==', $this->conteudo);
        $this->conteudo = str_replace(array(' &&', '&& '), '&&', $this->conteudo);
        $this->conteudo = str_replace(array(' ||', '|| '), '||', $this->conteudo);
        $this->conteudo = str_replace(array(' !==', '!== '), '!==', $this->conteudo);
        $this->conteudo = str_replace(array(' ===', '=== '), '===', $this->conteudo);
    }

    /**
     * _criaCacheBrowser()
     * Função responsável por criar o cache no browser
     *
     * @final private
     * @return void
     */
    final private function _criaCacheBrowser() {

        // Define o período de vida do cache
        header('Expires: ' . gmdate("D, d M Y H:i:s", time() + $this->cache) . ' GMT');

        /*
         * Verifica a data de modigicação do HTTP
         * Caso seja maior limpa todo o cache
         */
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $this->modificado) {

            // Cria o header de não alterado
            header("HTTP/1.0 304 Not Modified");
            header('Cache-Control:');
        }
        /*
         * Define a vida útil do cache
         * Como padrão a data a última modificação
         */ else {
            // Cria o header com o novo período
            header('Cache-Control: max-age=' . $this->cache);
            header('Pragma:');
            header("Last-Modified: " . gmdate("D, d M Y H:i:s", $this->modificado) . " GMT");
        }
    }

}

// Compressao
