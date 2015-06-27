#Definições Básicas de Uso

##Instanciando a Classe de Compressão
```php
$compressao = new Compressao();
```

##A função `incluir()`
A função `incluir()` é a responsável pelo retorno no conteúdo que deseja-se unificar e/ou comprimir.

Obrigatóriamente ele precisa receber dois valores como parâmetro.
* TIPO_DE_ARQUIVO ***(Recebe apenas `varchar`)***
* LISTA_DE_ARQUIVOS ***(Pode receber tanto `array` quanto `varchar`)***

A aplicação deve ser feita da seguinte forma:
```php
$compressao->incluir(TIPO_DE_ARQUIVO, LISTA_DE_ARQUIVOS);
```

##Imprimindo o conteúdo inline
Incluindo arquivos JavaScript usando o método de entrada em `Array`
```php
$compressao->incluir('js', array('js/jquery.min', 'js/exemplo'));
```

##Imprimindo o conteúdo inline
Incluindo arquivos CSS usando o método de entrada em `String Char`
```php
$compressao->incluir('css', 'css/bootstrap;css/exemplo');
```

##Imprimindo o conteúdo usando parâmetros da URL
 * Uso da função `buscaTipo()` para recuperar o tipo de arquivo na URL
 * Uso da função `buscaArquivos()` para recuperar os arquivos passados na URL

**Ex.:** `comprime.php?tipo=css&arquivos=css/bootstrap;css/exemplo`
```php
$compressao->incluir($compressao->buscaTipo(), $compressao->buscaArquivos());
```
A função `buscaTipo()` será responsável por recuperar o valor passado pelo parâmetro `tipo`
A função `buscaArquivos()` será responsável por recuperar o valor passado pelo parâmetro `arquivos`


#Definições Opcionais de Uso

###Definindo a pasta padrão dos arquivo de entrada
```php
/*
 * @default recursos/
 * @var $pasta (varchar)
 */
$compressao->pasta = "/projetos/recursos/";
```

###Definindo o nome do parâmetro na URL para identificar o tipo do arquivo
```php
/*
 * @default "tipo"
 * @var $buscaTipo (varchar)
 */
$compressao->buscaTipo = "tipo";
```

###Definindo o nome do parâmetro na URL para identificar os arquivos
```php
/*
 * @default "arquivos"
 * @var $buscaArquivos (varchar)
 */
$compressao->buscaArquivos = "arquivos";
```

###Definindo se o conteúdo deve ou não ser comprimido
```php
/*
 * @default true
 * @uses true / false
 * @var $arquivoComprime (boolean varchar)
 */
$compressao->arquivoComprime = true;
```

###Ignora a compressão do arquivo passando o nome do arquivo ou um termo do nome.
***NOTA: Usado somente se a variável `$arquivoComprime` estiver ativa***
```php
/*
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
```

###Definindo o modo de separação dos arquivos
***NOTA: Não usar ponto (.) a classe o interpreta para definir outros valores***
***NOTA: Usado somente no padrão sem array***
```php
/*
 * @default ";"
 * @uses ; / , / *
 * @var $modoSeparador (varchar)
 */
$compressao->modoSeparador = ";";
```

###Definindo se o retorno deve ser cacheado em `browser` ou não
```php
/*
 * @default false
 * @uses true / false
 * @var $cacheavel (boolean varchar)
 */
$compressao->cacheavel = false;
```

###Definindo o tempo de vida do Cache (em segundo)
***NOTA: Usado somente se a variável `$cacheavel` estiver ativa***
```php
/*
 * @default 604800
 * @var $cache (int)
 */
$compressao->cache = 604800;
```

## Contato
Se precisar entrar em contato, will_levinski@hotmail.com ou n3p0rb1t@gmail.com