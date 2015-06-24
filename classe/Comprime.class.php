<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Compressao {

    private $entrada = '';
    private $extensao = '';
    private $conteudos = '';
    private $conteudo = '';
    private $minificado = '';
    private $modoArray = true;
    private $modoSeparador = ';';

    /**
     * @return varchar
     */
    public function minificar($entrada) {

        $this->entrada = $entrada;

        #$this->_arquivoLista();
        $this->_arquivoConteudo();

        $this->_comprime();

        return $this->conteudo;
    }
    
    /**
     * @return varchar
     */
    private function _arquivoValido() {

        return $this->entrada;
    }
    
    /**
     * @return varchar
     */
    private function _arquivoLista() {

        foreach ($this->_arquivoSepara() as $arquivo) {

            $data[] = $arquivo;
        }

        $this->conteudo = implode(' ', $data);
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
        $this->conteudo = str_replace(array(" { "," {", "{ "), '{', $this->conteudo);
        $this->conteudo = str_replace(array(" } "," }", "} "), '}', $this->conteudo);
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

    private function _criaHeader($modificado, $periodo) {

        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $modificado) {

            header("HTTP/1.0 304 Not Modified");
            header('Cache-Control:');
        } else {
            header('Cache-Control: max-age=' . $periodo);
            header('Content-type: text/css; charset=UTF-8');
            header('Pragma:');
            header("Last-Modified: " . gmdate("D, d M Y H:i:s", $modificado) . " GMT");
        }
    }

}
