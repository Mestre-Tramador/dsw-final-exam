<?php require "./main.php"; ?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Start of the Meta Tags Section. -->
            <?=Main::getMetaTagsDeclarations()?>
        <!-- End of the Meta Tags Section. -->

        <!-- Start of the Title. -->
            <?=Main::getTitleDeclaration()?>
        <!-- End of the Title. -->

        <!-- Start of the Icon. -->
            <?=Main::getFavIconDeclaration()?>
        <!-- End of the Icon. -->

        <!-- Start of the Style Links Section. -->
            <?=Main::getStylesDeclarations()?>
            <link rel="stylesheet" href="/store/index.css?=<?=time()?>" />
        <!-- End of the Style Links Section. -->
    </head>

    <body>
        <!-- Start of the content. -->
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- Start of the main card. -->
                            <div class="card my-5">
                                <!-- Start of the main card menu and list body. -->
                                    <div id="menu" class="card-body d-block">
                                        <!-- Start of the main card menu and list body database section. -->
                                            <div class="card-title text-right">
                                                <!-- Start of the actual database text. -->
                                                    <span id="database_actual">
                                                        <!-- Here will be printed the actual database on usage. -->
                                                    </span>
                                                <!-- End of the actual database text. -->

                                                <!-- Start of the delete database button. -->
                                                    <button role="figure" class="btn btn-no-outline p-1" onmouseover="setDatabaseDeleteText(true)" onmouseout="setDatabaseDeleteText(false)" onclick="refreshEnvironment()">
                                                        <i class="fa fa-lg fa-trash text-danger"></i>
                                                    </button>
                                                <!-- End of the delete database button. -->
                                            </div>  
                                        <!-- End of the main card menu and list body database section. -->

                                        <!-- Start of the main card menu and list body listage section. -->
                                            <div class="card-text">
                                                <!-- Start of the listage title. -->
                                                    <p class="h1 text-center mb-3">
                                                        <u>PESSOAS CADASTRADAS</u>
                                                    </p>
                                                <!-- End of the listage title. -->

                                                <!-- Start of the persons list. -->
                                                    <div id="persons" class="list-group overflow-auto">
                                                        <!-- Here will be printed the list of persons. -->
                                                    </div>
                                                <!-- End of the persons list. -->
                                            </div>
                                        <!-- End of the main card menu and list body listage section. -->

                                        <!-- Start of the main card menu and list body include section. -->
                                            <div class="d-flex">
                                                <a href="/store/person/" class="btn btn-primary mx-auto mt-4">
                                                    <i class="fa fa-lg fa-plus"></i>&nbsp;<strong>Novo Cadastro</strong>
                                                </a>
                                            </div>
                                        <!-- End of the main card menu and list body include section. -->
                                    </div>
                                <!-- End of the main card menu and list body. -->

                                <!-- Start of the main card database body. -->
                                    <div id="database" class="card-body d-none text-center">
                                        <!-- Start of the main card database body text. -->
                                            <p class="h3">Você não possui nenhum Banco de Dados ativo!</p>

                                            <p class="h5">Por favor, escolha um Banco de Dados para operar.</p>
                                        <!-- End of the main card database body text. -->

                                        <!-- Start of the main card database body buttons section. -->
                                            <div class="d-flex">
                                                <!-- Start of the "store" database button. -->
                                                    <button role="button" class="btn btn-lg btn-info ml-auto mr-3" onmouseover="setDatabaseFlavorText(true, 'S')" onmouseout="setDatabaseFlavorText(false)" onclick="createDatabase('store')">
                                                        STORE
                                                    </button>
                                                <!-- End of the "store" database button. -->

                                                <!-- Start of the "loja" database button. -->
                                                    <button role="button" class="btn btn-lg btn-info mr-auto ml-3" onmouseover="setDatabaseFlavorText(true, 'L')" onmouseout="setDatabaseFlavorText(false)" onclick="createDatabase('loja')">
                                                        LOJA
                                                    </button>
                                                <!-- End of the "loja" database button. -->
                                            </div>
                                        <!-- End of the main card database body buttons section. -->

                                        <!-- Start of the database flavor text. -->
                                            <span id="database_flavor" class="text-muted mt-2 d-none">
                                                <!-- Here will be showned a little text for the databases. -->
                                            </span>
                                        <!-- End of the database flavor text. -->

                                        <!-- Start of the database feedback. -->
                                            <div id="database_feedback" class="invalid-feedback">
                                                Não foi possível criar o Banco de Dados Selecionado
                                            </div>
                                        <!-- End of the database feedback. -->
                                    </div>
                                <!-- End of the main card database body. -->
                            </div>
                        <!-- End of the main card. -->
                    </div>
                </div>
            </div>
        <!-- End of the content. -->
        
        <!-- Start of the Scripts Section. -->
            <?=Main::getScriptsDeclarations()?>
            <script type="application/javascript" src="/store/index.js?=<?=time()?>"></script>
        <!-- End of the Scripts Section. -->
    </body>
</html>