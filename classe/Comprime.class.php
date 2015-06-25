<?php

class Compressao {

    private $entrada;
    private $tipo;
    private $conteudo;
    private $unificados;
    private $pasta = '/projetos/Comprime-Arquivos/recursos/';
    private $buscaTipo = 'tipo';
    private $buscaArquivos = 'arquivos';
    private $arquivoComprime = true;
    private $ignorar = '.min';
    private $modoArray = true;
    private $modoSeparador = ';';
    private $cacheavel = false;
    private $modificado = 0;
    private $cache = 604800;

    /**
     * @return varchar
     */
    public function minificar($tipo, $entrada) {

        $this->entrada = $entrada;
        $this->tipo = $tipo;

        $this->_arquivoConteudo();

        if ($this->cacheavel === true) {

            $this->_arquivoVida();

            $this->_criaCacheBrowser();

            return $this->conteudo;
        }

        return $this->conteudo;
    }

    /**
     * @return varchar
     */
    public function buscaTipo() {

        return filter_input(INPUT_GET, $this->buscaTipo, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /**
     * @return varchar
     */
    public function buscaArquivos($array = null) {

        if ($array === true) {

            return explode($this->modoSeparador, filter_input(INPUT_GET, $this->buscaArquivos, FILTER_SANITIZE_SPECIAL_CHARS));
        }

        return filter_input(INPUT_GET, $this->buscaArquivos, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /**
     * @return varchar
     */
    private function _arquivoPasta($arquivo) {

        return $_SERVER['DOCUMENT_ROOT'] . $this->pasta . $arquivo . '.' . $this->tipo;
    }

    /**
     * @return void
     */
    private function _arquivoConteudo() {

        if ($this->tipo === 'css') {
            header('Content-type: text/css; charset=UTF-8');
        } else {
            header('Content-Type: application/javascript');
        }

        foreach ($this->_arquivoSepara() as $arquivo) {

            if (!file_exists($this->_arquivoPasta($arquivo))) {

                $this->unificados[] = $this->_arquivoErro($arquivo);
            } else {
                $file = fopen($this->_arquivoPasta($arquivo), 'r');

                $this->conteudo = fread($file, filesize($this->_arquivoPasta($arquivo)));

                if (strpos(basename($arquivo), $this->ignorar) === false) {

                    $this->_comprime();
                }
                $this->unificados[] = $this->conteudo;
            }
        }
        $this->_arquivoUnifica();
    }
    
    /**
     * @return varchar
     */
    private function _arquivoErro($arquivo) {

        return "\n /* Erro ao incluir o arquivo '" . $arquivo . "' */";
    }

    /**
     * @return array
     */
    private function _arquivoSepara() {

        if ($this->modoArray === true) {

            return $this->entrada;
        }

        return explode($this->modoSeparador, $this->entrada);
    }

    /**
     * @return void
     */
    private function _arquivoUnifica() {

        $this->conteudo = implode('', $this->unificados);
    }

    /**
     * @return void
     */
    private function _arquivoVida() {

        foreach ($this->_arquivoSepara() as $arquivo) {

            $tempo = filemtime($this->_arquivoPasta($arquivo));

            if ($tempo > $this->modificado) {

                $this->modificado = $tempo;
            }
        }
    }

    /**
     * Lance les opérations de minification des fichiers
     * @return void
     */
    private function _comprime() {

        if ($this->arquivoComprime === true) {

            $this->_removeComentarios();
            $this->_removeEspacosLinhas();
            $this->_removeEspacos();
        }
    }

    /**
     * Remove comentários
     * @return void
     */
    private function _removeComentarios() {

        $this->conteudo = preg_replace('!/\*.*?\*/!s', '', $this->conteudo);
        $this->conteudo = preg_replace('/\n\s*\n/', "\n", $this->conteudo);
        $this->conteudo = preg_replace('/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/', '', $this->conteudo);
    }

    /**
     * Remove tabs e quebras de linhas
     * @return void
     */
    private function _removeEspacosLinhas() {

        $this->conteudo = str_replace(array("\t", "\n", "\r", '  ', '    ', '     '), '', $this->conteudo);
    }

    /**
     * Remove espaços do itens
     * @return void
     */
    private function _removeEspacos() {

        $this->conteudo = str_replace(array(" {", "{ "), '{', $this->conteudo);
        $this->conteudo = str_replace(array(" }", "} "), '}', $this->conteudo);
        $this->conteudo = str_replace(array(';}', '} '), '}', $this->conteudo);
        $this->conteudo = str_replace(array(' ;', '; '), ';', $this->conteudo);
        $this->conteudo = str_replace(array(' (', '( '), '(', $this->conteudo);
        $this->conteudo = str_replace(array(' )', ') '), ')', $this->conteudo);
        $this->conteudo = str_replace(array(' ,', ', '), ',', $this->conteudo);
        $this->conteudo = str_replace(array(' :', ': '), ':', $this->conteudo);
        $this->conteudo = str_replace(array(' =', '= '), '=', $this->conteudo);
        $this->conteudo = str_replace(array(' ==', '== '), '==', $this->conteudo);
        $this->conteudo = str_replace(array(' ===', '=== '), '===', $this->conteudo);
    }

    /**
     * Remove espaços do itens
     * @return void
     */
    private function _criaCacheBrowser() {

        header('Expires: ' . gmdate("D, d M Y H:i:s", time() + $this->cache) . ' GMT');

        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $this->modificado) {

            header("HTTP/1.0 304 Not Modified");
            header('Cache-Control:');
        } else {
            header('Cache-Control: max-age=' . $this->cache);
            header('Pragma:');
            header("Last-Modified: " . gmdate("D, d M Y H:i:s", $this->modificado) . " GMT");
        }
    }

}
