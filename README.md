### Compressão de Arquivos

**Instanciando a Classe de Compressão**
```php
$compressao = new Compressao();
```

**Definindo a Pasta padão dos arquivo de entrada** ***(opcional)***
```php
/*
 * @default recursos/
 * @var $pasta (varchar)
 */
$compressao->pasta = "/projetos/recursos/";
```

**Definindo o nome do parâmetro que será resgatado na URL para identificar o tipo do arquivo** ***(opcional)***
```php
/*
 * @default "tipo"
 * @var $buscaTipo (varchar)
 */
$compressao->buscaTipo = "tipo";
```

**Definindo o nome do parâmetro que será resgatado na URL para identificar os arquivos** ***(opcional)***
```php
/*
 * @default "arquivos"
 * @var $buscaArquivos (varchar)
 */
$compressao->buscaArquivos = "arquivos";
```

**Definindo se o conteúdo deve ou não ser comprimido** ***(opcional)***
```php
/*
 * @default true
 * @uses true / false
 * @var $arquivoComprime (boolean varchar)
 */
$compressao->arquivoComprime = true;
```

**Definindo se o termo do nome do arquivo para que ele seja ignorado** ***(opcional)***
```php
/*
 * @default ".min"
 * @uses .min / min. / .minify
 * @var $ignorar (varchar)
 */
$compressao->ignorar = '.min';
```

**Definindo se o valor da entrada deve ser do tipo array ou varchar** ***(opcional)***
```php
/*
 * @default true
 * @uses true / false
 * @var $modoArray (boolean varchar)
 */
$compressao->modoArray = true;
```

**Definindo o modo de separação dos arquivos** ***(opcional)***
```php
/*
 * NOTA: Não usar ponto (.) a classe o interpreta para definir outros valores
 * @default ";"
 * @uses ; / , / *
 * @var $modoSeparador (varchar)
 */
$compressao->modoSeparador = ";";
```

**Definiendo o retorno deve ser cacheado em browser ou não** ***(opcional)***
```php
/*
 * @default false
 * @uses true / false
 * @var $cacheavel (boolean varchar)
 */
$compressao->cacheavel = false;
```

**Definiendo o tempo de vida do Cache (em segundo)** ***(opcional)***
```php
/*
 * @default 604800
 * @var $cache (int)
 */
$compressao->cache = 604800;
```

**Retorno da função incluir**
 * Uso da função buscaTipo() para recuperar o tipo de arquivo na URL
 * Uso da função buscaArquivos() para recuperar os arquivos passados na URL
```php
echo $compressao->incluir($compressao->buscaTipo(), $compressao->buscaArquivos());
```



### Contato
Se precisar entrar em contato, will_levinski@hotmail.com e n3p0rb1t@gmail.com
