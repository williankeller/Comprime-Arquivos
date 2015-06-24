<?php

/*
 * Compressão de Arquivos
 */

require_once('classe/Comprime.class.php');

$compressao = new Compressao();

echo ($compressao->minificar(array('teste/exemplo.css', 'teste/exemplo.css')));

#echo ($compressao->minificar('teste/exemplo.css;teste/exemplo.css'));

