<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Compressao {
    
    private $entrada = '';
    private $conteudos = '';
    private $conteudo = '';
    private $modoArray = true;
    private $modoSeparador = ';';
    private $cacheavel = false;
    private $modificado = 0;
    private $cache = 604800;

    /**
     * @return varchar
     */
    public function minificar($entrada) {

        $this->entrada = $entrada;

        #$this->_arquivoLista();
        $this->_arquivoConteudo();

        $this->_comprime();

        if ($this->cacheavel === true) {

            $this->_criaCacheBrowser();

            return $this->conteudo;
        }

        return $this->conteudo;
    }

    /**
     * @return varchar
     */
    private function _arquivoValido() {

        return $this->entrada;
    }

    /**
     * @return void
     */
    private function _arquivoConteudo() {

        foreach ($this->_arquivoSepara() as $arquivo) {

            $file = fopen($arquivo, 'r');

            $this->conteudos[] = fread($file, filesize($arquivo));
        }

        $this->_arquivoUne();
    }

    /**
     * @return void
     */
    private function _arquivoVida() {

        foreach ($this->_arquivoSepara() as $arquivo) {

            $tempo = filemtime($arquivo);

            if ($tempo > $this->modificado) {

                $this->modificado = $tempo;
            }
        }
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
     * @return varchar
     */
    private function _arquivoUne() {

        $this->conteudo = implode('', $this->conteudos);
    }

    /**
     * Lance les opérations de minification des fichiers
     * @return void
     */
    private function _comprime() {

        $this->_removeComentarios();
        $this->_removeEspacosLinhas();
        $this->_removeEspacos();
    }

    /**
     * Remove comentários
     * @return void
     */
    private function _removeComentarios() {

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
        $this->conteudo = str_replace(array(';}'), '}', $this->conteudo);
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
            header('Content-type: text/css; charset=UTF-8');
            header('Pragma:');
            header("Last-Modified: " . gmdate("D, d M Y H:i:s", $this->modificado) . " GMT");
        }
    }

}
