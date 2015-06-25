<?php

/*
 * 
 */

require_once('classe/Comprime.class.php');

$compressao = new Compressao();

echo ($compressao->minificar($compressao->buscaTipo(), $compressao->buscaArquivos(true)));
