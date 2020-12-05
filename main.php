<?php    
    function getStylesDeclarations()
    {
        $styles = "";

        $cache = time();

        $styles .= "<link rel=\"stylesheet\" href=\"/store/assets/css/bootstrap.css.map?={$cache}\" />\n\t\t\t";
        $styles .= "<link rel=\"stylesheet\" href=\"/store/assets/css/bootstrap.min.css?={$cache}\" />\n\t\t\t";
        $styles .= "<link rel=\"stylesheet\" href=\"/store/assets/css/bootstrap.min.css.map?={$cache}\" />\n\t\t\t";
        $styles .= "<link rel=\"stylesheet\" href=\"/store/assets/css/fontawesome-all.min.css?={$cache}\" />\n\t\t\t";
        $styles .= "<link rel=\"stylesheet\" href=\"/store/assets/css/bootstrap-select.min.css?={$cache}\" />\n\t\t\t";
        $styles .= "<link rel=\"stylesheet\" href=\"/store/assets/css/custom.css?={$cache}\" />\n";

        return $styles;
    }

    function getMetaTagsDeclarations()
    {
        $metas = "";

        $metas .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n\n\t\t\t";
        $metas .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\" />\n\t\t\t";
        $metas .= "<meta name=\"description\" content=\"Trabalho Final da Cadeira de Desenvolvimento de Software para Web.\" />\n\t\t\t";
        $metas .= "<meta name=\"author\" content=\"Eduardo de Oliveira Rosa, Mestre Tramador\" />\n";

        return $metas;
    }

    function getScriptsDeclarations()
    {
        $scripts = "";

        $cache = time();

        $scripts .= "<script type=\"application/javascript\" src=\"/store/assets/js/jquery-3.5.1.min.js?={$cache}\"></script>\n\t\t\t";
        $scripts .= "<script type=\"application/javascript\" src=\"/store/assets/js/bootstrap.bundle.min.js?={$cache}\"></script>\n\t\t\t";
        $scripts .= "<link rel=\"application/javascript\" href=\"/store/assets/js/bootstrap.bundle.min.js.map?={$cache}\" />\n\t\t\t";
        $scripts .= "<script type=\"application/javascript\" src=\"/store/assets/js/bootstrap-select.min.js?={$cache}\"></script>\n\t\t\t";
        $scripts .= "<link rel=\"application/javascript\" href=\"/store/assets/js/bootstrap-select.min.js.map?={$cache}\" />\n\t\t\t";
        $scripts .= "<script type=\"application/javascript\" src=\"/store/assets/js/fontawesome-all.min.js?={$cache}\" defer></script>\n";

        return $scripts;
    }

    function getFavIconDeclaration()
    {
        $cache = time();
        
        return "<link rel=\"icon\" type=\"image/x-icon\" href=\"./favicon.ico?={$cache}\" />\n";
    }

    function getTitleDeclaration()
    {
        return "Cadastro do Ganso";
    }

    function checkIfIsLoaded()
    {
        return (realpath(__FILE__) == realpath($_SERVER["DOCUMENT_ROOT"] . $_SERVER["SCRIPT_NAME"]));
    }

    if(checkIfIsLoaded())
    {
        header("Location: /store/");
        die;
    }
?>