<!-- 
    Compressão e União de Arquivos
    Arquivo responsável pelo recebimento dos arquivos css e js
   
    @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
    @author Willian keller <will_levinki@hotmail.com>
    @package Compressao
-->
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Compressão e União de Arquivos com Cache do Browser usando PHP</title>
        <!-- 
            Chamada do arquivo de stylesheet
            Incluindo os arquivos:
            - css/bootstrap
            - css/exemplo
        -->
        <script>console.time("CSS:");</script>
        <link href="comprime/css/css/bootstrap;css/exemplo" rel="stylesheet" type="text/css">
        <script>console.timeEnd("CSS:");</script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <Div class="col-sm-6 col-sm-offset-3">
                    <div class="minha-area text-center mt-100">
                        <h2 class="text-info hidden">Compressão e União de Arquivos com Cache do Browser usando PHP</h2>
                        <h4 class="text-muted hidden"></h4>
                        <h5 class="text-muted hidden"></h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- 
            Chamada do arquivo de javascript
            Incluindo os arquivos:
            - js/jquery
            - js/bootstrap.min
        -->
        <script>console.time("JS:");</script>
        <script src="comprime/js/js/jquery.min;js/bootstrap.min;js/exemplo"></script>
        <script>console.timeEnd("JS:");</script>
    </body>
</html>