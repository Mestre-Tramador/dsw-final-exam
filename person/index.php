<?php require "../main.php"; ?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Start of the Meta Tags Section. -->
            <?=getMetaTagsDeclarations()?>
        <!-- End of the Meta Tags Section. -->

        <!-- Start of the Title. -->
            <?=getTitleDeclaration()?>
        <!-- End of the Title. -->

        <!-- Start of the Icon. -->
            <?=getFavIconDeclaration()?>
        <!-- End of the Icon. -->

        <!-- Start of the Style Links Section. -->
            <?=getStylesDeclarations()?>
            <link rel="stylesheet" href="/store/person/index.css?=<?=time()?>" />
        <!-- End of the Style Links Section. -->
    </head>

    <body>
        <!-- Start of the content. -->
            <div class="container">
                <div class="row">
                    <div class="col-12 px-0">
                        <!-- Start of the main card. -->
                            <div class="card my-5">
                                <div id="menu" class="card-body d-block">
                                    <!-- Start of the main card title. -->
                                        <div class="card-title d-flex">
                                            <!-- Start of the main card title text. -->
                                                <p class="h1 m-auto">
                                                    <u>Cadastro de Pessoas</u>
                                                </p>
                                            <!-- End of the main card title text. -->

                                            <!-- Start of the main card return button. -->
                                                <a href="/store/" class="btn btn-sm btn-outline-secondary my-auto" title="Voltar">
                                                    <i class="fa fa-lg fa-long-arrow-alt-left"></i>
                                                </a>
                                            <!-- End of the main card return button. -->
                                        </div> 
                                    <!-- End of the main card title. -->

                                    <!-- Start of the main card image row. -->
                                        <div class="d-flex mt-0">
                                            <img src="/store/assets/img/Logo.png" alt="Logo" class="mx-auto w-10 h-10" />
                                        </div>
                                    <!-- End of the main card image row. -->

                                    <!-- Start of the main card forms. -->
                                        <div class="card-text d-flex mt-4">
                                            <!-- Start of the main card person form. -->
                                                <div class="col-8 px-0">
                                                    <!-- Start of the main card person form title. -->
                                                        <p class="h4 text-center mb-4">
                                                            Dados Cadastrais
                                                        </p>    
                                                    <!-- End of the main card person form title. -->

                                                    <form>
                                                        <!-- Start of the main card person form first row. -->
                                                            <div class="form-row">
                                                                <!-- Start of the main card person form name input. -->
                                                                    <div class="col-5 mb-3">
                                                                        <label for="name">Nome</label>
                                                                        <input type="text" id="name" class="form-control" placeholder="Nome" />
                                                                        <div id="name_feedback" class="invalid-feedback"><!-- Here will be printed invalid feedbacks for the name. --></div>
                                                                    </div>
                                                                <!-- End of the main card person form name input. -->

                                                                <!-- Start of the main card person form surname input. -->
                                                                    <div class="col-5 mb-3">
                                                                        <label for="surname">Sobrenome</label>
                                                                        <input type="text" id="surname" class="form-control" placeholder="Sobrenome" />
                                                                        <div id="surname_feedback" class="invalid-feedback"><!-- Here will be printed invalid feedbacks for the surname. --></div>
                                                                    </div>
                                                                <!-- End of the main card person form surname input. -->

                                                                <!-- Start of the main card person form type radio group input. -->
                                                                    <div class="col-2 mt-4 mb-3 text-center">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="type" id="type_physical" value="physical" onchange="handleTypeChange(event)" checked />
                                                                            <label class="form-check-label" for="type_physical">PF</label>
                                                                        </div>

                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="type" id="type_legal" value="legal" onchange="handleTypeChange(event)" />
                                                                            <label class="form-check-label" for="type_legal">PJ</label>
                                                                        </div>
                                                                    </div>
                                                                <!-- End of the main card person form type radio group input. -->
                                                            </div>
                                                        <!-- End of the main card person form first row. -->

                                                        <!-- Start of the main card person form second row. -->
                                                            <div class="form-row">
                                                                <!-- Start of the main card person form document input. -->
                                                                    <div class="col-5 mb-3">
                                                                        <label for="document">CPF</label>
                                                                        <input type="text" id="document" class="form-control" placeholder="___.___.___-__" maxlength="14" />
                                                                        <div id="document_feedback" class="invalid-feedback"><!-- Here will be printed invalid feedbacks for the document. --></div>
                                                                    </div>
                                                                <!-- End of the main card person form document input. -->

                                                                <!-- Start of the main card person form birth date input. -->
                                                                    <div class="col-5 mb-3">
                                                                        <label for="birth_date">Data de Nascimento</label>
                                                                        <input type="date" id="birth_date" class="form-control" />
                                                                        <div id="birth_date_feedback" class="invalid-feedback"><!-- Here will be printed invalid feedbacks for the birth date. --></div>
                                                                    </div>
                                                                <!-- End of the main card person form birth date input. -->

                                                                <!-- Start of the main card person form gender select box. -->
                                                                    <div class="col-2 mb-3">
                                                                        <label for="gender">Gênero</label>
                                                                        <select id="gender" class="custom-select">
                                                                            <option value="" selected>...</option>
                                                                            <option value="F">Feminino</option>
                                                                            <option value="M">Masculino</option>
                                                                            <option value="O">Outro</option>
                                                                        </select>
                                                                        <div id="gender_feedback" class="invalid-feedback"><!-- Here will be printed invalid feedbacks for the gender. --></div>
                                                                    </div>
                                                                <!-- End of the main card person form gender select box. -->
                                                            </div>
                                                        <!-- End of the main card person form second row. -->

                                                        <!-- Start of the main card person form third row. -->
                                                            <div class="form-row">
                                                                <!-- Start of the main card person form phone input. -->
                                                                    <div class="col-6 mb-3">
                                                                        <label for="phone">Telefone</label>
                                                                        <input type="text" id="phone" class="form-control" placeholder="(DDD) ____-____" maxlength="14" />
                                                                        <div id="phone_feedback" class="invalid-feedback"><!-- Here will be printed invalid feedbacks for the phone. --></div>
                                                                    </div>
                                                                <!-- End of the main card person form phone input. -->

                                                                <!-- Start of the main card person form cellphone input. -->
                                                                    <div class="col-6 mb-3">
                                                                        <label for="cellphone">Celular</label>
                                                                        <input type="text" id="cellphone" class="form-control" placeholder="(DDD) _____-____" maxlength="15" />
                                                                        <div id="cellphone_feedback" class="invalid-feedback"><!-- Here will be printed invalid feedbacks for the cellphone. --></div>
                                                                    </div>
                                                                <!-- End of the main card person form cellphone input. -->
                                                            </div>
                                                        <!-- End of the main card person form third row. -->
                                                    </form>

                                                    <!-- Start of the main card form buttons row. -->
                                                        <div id="btn_row" class="form-row">
                                                            <div class="col-12 mb-3">
                                                                <button class="btn btn-block btn-success mt-4" onclick="console.log('salvou');">
                                                                    Salvar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    <!-- Start of the main card form buttons row. -->
                                                </div>
                                            <!-- End of the main card person form. -->

                                            <!-- Start of the main card address form. -->
                                                <div class="col-4 px-0 ml-3">
                                                    <!-- Start of the main card address form title. -->
                                                        <p class="h4 text-center mb-4">
                                                            Endereço de Entrega
                                                        </p>    
                                                    <!-- End of the main card address form title. -->

                                                    <form>
                                                        <!-- Start of the main card address form first row. -->
                                                        <div class="form-row">
                                                            <!-- Start of the main card address form street input. -->
                                                                <div class="col-7 mb-3">
                                                                    <label for="street">Rua</label>
                                                                    <input type="text" id="street" class="form-control" placeholder="Rua" />
                                                                    <div id="street_feedback" class="invalid-feedback"><!-- Here will be printed invalid feedbacks for the street. --></div>
                                                                </div>
                                                            <!-- End of the main card address form street input. -->

                                                            <!-- Start of the main card address form number input. -->
                                                                <div class="col-5 mb-3">
                                                                    <label for="number">Número</label>
                                                                    <input type="number" id="number" class="form-control" placeholder="Número" />
                                                                    <div id="number_feedback" class="invalid-feedback"><!-- Here will be printed invalid feedbacks for the number. --></div>
                                                                </div>
                                                            <!-- End of the main card address form number input. -->
                                                        </div>
                                                        <!-- End of th main card address form title. -->

                                                        <!-- Start of the main card address form second row. -->
                                                            <div class="form-row">
                                                                <!-- Start of the main card address form district input. -->
                                                                <div class="col-8 mb-3">
                                                                    <label for="district">Bairro</label>
                                                                    <input type="text" id="district" class="form-control" placeholder="Bairro" />
                                                                    <div id="district_feedback" class="invalid-feedback"><!-- Here will be printed invalid feedbacks for the district. --></div>
                                                                </div>
                                                                <!-- End of the main card address form district input. -->

                                                                <!-- Start of the main card address form zip code input. -->
                                                                    <div class="col-4 mb-3">
                                                                        <label for="zip_code">CEP</label>
                                                                        <input type="text" id="zip_code" class="form-control" placeholder="_____-___" maxlength="9" />
                                                                        <div id="zip_code_feedback" class="invalid-feedback"><!-- Here will be printed invalid feedbacks for the zip code. --></div>
                                                                    </div>
                                                                <!-- End of the main card address form zip code input. -->
                                                            </div>
                                                        <!-- End of the main card address form second row. -->

                                                        <!-- Start of the main card address form third row. -->
                                                            <div class="form-row">
                                                                <!-- Start of the main card address form complement input. -->
                                                                    <div class="col-6 mb-3">
                                                                        <label for="complement">Complemento</label>
                                                                        <input type="text" id="complement" class="form-control" placeholder="Complemento" />
                                                                        <div id="complement_feedback" class="invalid-feedback"><!-- Here will be printed invalid feedbacks for the complement. --></div>
                                                                    </div>
                                                                <!-- End of the main card address form complement input. -->

                                                                <!-- Start of the main card address form reference input. -->
                                                                    <div class="col-6 mb-3">
                                                                        <label for="reference">Referência</label>
                                                                        <input type="text" id="reference" class="form-control" placeholder="Referência" />
                                                                        <div id="reference_feedback" class="invalid-feedback"><!-- Here will be printed invalid feedbacks for the reference. --></div>
                                                                    </div>
                                                                <!-- End of the main card address form reference input. -->
                                                            </div>
                                                        <!-- End of the main card address form third row. -->

                                                        <!-- Start of the main card address form fourth row. -->
                                                            <div class="form-row">
                                                                <!-- Start of the main card address form city input. -->
                                                                    <div class="col-9 mb-3">
                                                                        <label for="city">Cidade</label>
                                                                        <input type="text" id="city" class="form-control" placeholder="Cidade" />
                                                                        <div id="city_feedback" class="invalid-feedback"><!-- Here will be printed invalid feedbacks for the city. --></div>
                                                                    </div>
                                                                <!-- End of the main card address form city input. -->

                                                                <!-- Start of the main card address form state select box. -->
                                                                    <div class="col-3 mb-3">
                                                                        <label for="state">Estado</label>
                                                                        <select id="state" class="custom-select">
                                                                            <option value="" selected>...</option>
                                                                            <option value="AC">AC</option>
                                                                            <option value="AL">AL</option>
                                                                            <option value="AP">AP</option>
                                                                            <option value="AM">AM</option>
                                                                            <option value="BA">BA</option>
                                                                            <option value="CE">CE</option>
                                                                            <option value="ES">ES</option>
                                                                            <option value="GO">GO</option>
                                                                            <option value="MA">MA</option>
                                                                            <option value="MT">MT</option>
                                                                            <option value="MS">MS</option>
                                                                            <option value="MG">MG</option>
                                                                            <option value="PA">PA</option>
                                                                            <option value="PB">PB</option>
                                                                            <option value="PR">PR</option>
                                                                            <option value="PE">PE</option>
                                                                            <option value="PI">PI</option>
                                                                            <option value="RJ">RJ</option>
                                                                            <option value="RN">RN</option>
                                                                            <option value="RS">RS</option>
                                                                            <option value="RO">RO</option>
                                                                            <option value="RR">RR</option>
                                                                            <option value="SC">SC</option>
                                                                            <option value="SP">SP</option>
                                                                            <option value="SE">SE</option>
                                                                            <option value="TO">TO</option>
                                                                            <option value="DF">DF</option>
                                                                        </select>
                                                                        <div id="state_feedback" class="invalid-feedback"><!-- Here will be printed invalid feedbacks for the state. --></div>
                                                                    </div>
                                                                <!-- End of the main card address form state select box. -->
                                                            </div>
                                                        <!-- End of the main card address form fourth row. -->
                                                    </form>
                                                </div>
                                            <!-- End of the main card address form. -->
                                        </div>
                                    <!-- End of the main card forms. -->
                                </div>
                            </div>
                        <!-- End of the main card. -->
                    </div>
                </div>
            </div>
        <!-- End of the content. -->
        
        <!-- Start of the Scripts Section. -->
            <?=getScriptsDeclarations()?>
            <script type="application/javascript" src="/store/person/index.js?=<?=time()?>"></script>
        <!-- End of the Scripts Section. -->
    </body>
</html>