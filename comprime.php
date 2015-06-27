<?php

/**
 * Arquivo comprime
 * 
 * Compressão e União de Arquivos
 * Arquivo responsável pelo recebimento dos arquivos css e js
 * 
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author Willian keller <will_levinki@hotmail.com>
 * @package Compressao
 */
/*
 * Inclução da Classe de compressão
 * @method require_once
 */
require_once('classe/Comprime.class.php');

/*
 * Instanciando a Classe de Compressão
 */
$compressao = new Compressao();

/*
 * Pasta padrão dos arquivos da @entrada
 * @default recursos/
 * @var $pasta (varchar)
 */
$compressao->pasta = "/Comprime-Arquivos/recursos/";

/*
 * Nome do parâmetro que será resgatado da URL para identificar o tipo do arquivo
 * @default "tipo"
 * @var $buscaTipo (varchar)
 */
$compressao->buscaTipo = "tipo";

/*
 * Nome do parâmetro que será resgatado da URL para identificar os arquivos
 * @default "arquivos"
 * @var $buscaArquivos (varchar)
 */
$compressao->buscaArquivos = "arquivos";

/*
 * Define se o conteúdo deve ou não ser comprimido
 * @default true
 * @uses true / false
 * @var $arquivoComprime (boolean varchar)
 */
$compressao->arquivoComprime = true;

/*
 * Ignora a compressão do arquivo 
 * passando o nome do arquivo ou um termo do nome.
 * 
 * NOTA: Usado somente se a variável "arquivoComprime" estiver ativa 
 * 
 * @default ".min"
 * @uses .min / min. / .minify / nome-do-arquivo
 * @var $ignorar (array) ou (varchar)
 */

/*
 * Vários valores podem ser passados no modo array
 */
$compressao->ignorar = array('.min','exemplo');

/*
 * Apenas um valor pode ser passado no modo varchar
 */
#$compressao->ignorar = '.min';

/*
 * Define o modo de separação dos arquivos da @entrada
 * 
 * NOTA: Não usar ponto (.) a classe o interpreta para definir outros valores
 * NOTA: Usado somente no padrão sem array
 * 
 * @default ";"
 * @uses ; / , / *
 * @var $modoSeparador (varchar)
 */
$compressao->modoSeparador = ";";

/*
 * Define se o retorno deve ser cacheado em browser ou não
 * @default false
 * @uses true / false
 * @var $cacheavel (boolean varchar)
 */
$compressao->cacheavel = false;

/*
 * Define o tempo de vida do Cache (em segundo)
 * 
 * NOTA: Usado somente se a variável "cacheavel" estiver ativa
 * 
 * @default 604800
 * @var $cache (int)
 */
$compressao->cache = 604800;

/*
 * Retorno da função incluir
 * 
 * Uso da função buscaTipo() para recuperar o tipo de arquivo na URL
 * Uso da função buscaArquivos() para recuperar os arquivos passados na URL
 */
echo ($compressao->incluir($compressao->buscaTipo(), $compressao->buscaArquivos()));
