<?php require "./main.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Start of the Meta Tags Section. -->
            <?=getMetaTagsDeclarations()?>
        <!-- End of the Meta Tags Section. -->

        <!-- Start of the Title. -->
            <title><?=getTitleDeclaration()?></title>
        <!-- End of the Title. -->

        <!-- Start of the Icon. -->
            <?=getFavIconDeclaration()?>
        <!-- End of the Icon. -->

        <!-- Start of the Style Links Section. -->
            <?=getStylesDeclarations()?>
            <link rel="stylesheet" href="/store/index.css?=<?=time()?>" />
        <!-- End of the Style Links Section. -->
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card my-5">
                        <div id="menu" class="card-body d-block">

                        </div>

                        <div id="database" class="card-body d-none text-center">
                            <p class="h3">
                                Você não possui nenhum Banco de Dados ativo!
                            </p>
                            <p class="h5">
                                Por favor, escolha um Banco de Dados para operar.
                            </p>
                            <div class="d-flex">
                                <button role="button" class="btn btn-lg btn-info ml-auto mr-3" onmouseover="setDatabaseFlavorText(true, 'S')" onmouseout="setDatabaseFlavorText(false)" onclick="createDatabase('store')">
                                    STORE
                                </button>
                                <button role="button" class="btn btn-lg btn-info mr-auto ml-3" onmouseover="setDatabaseFlavorText(true, 'L')" onmouseout="setDatabaseFlavorText(false)" onclick="createDatabase('loja')">
                                    LOJA
                                </button>
                            </div>
                            <span id="database_flavor" class="text-muted mt-2 d-none"><!-- Here will be showned a little text for the databases. --></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Start of the Scripts Section. -->
            <?=getScriptsDeclarations()?>
            <script type="application/javascript" src="/store/index.js?=<?=time()?>"></script>
        <!-- End of the Scripts Section. -->
    </body>
</html>