<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('classe/Comprime.class.php');

$compressao = new Compressao();

echo ($compressao->minificar(array('teste/exemplo.css', 'teste/exemplo.css')));

