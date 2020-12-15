<?php    
    /**
     * Check if the passed file path (or the current one) is loaded
     * or was included by another file.
     *
     * @param string $file (optional) The path to check of the `main.php` file itself.
     * @return bool **TRUE** if the file is being directly loaded.
     */
    function checkIfIsLoaded($file = __FILE__)
    {
        return (realpath($file) == realpath($_SERVER["DOCUMENT_ROOT"] . $_SERVER["SCRIPT_NAME"]));
    }

    /**
     * Return the HTML code to add the current favicon.
     *
     * @return string The `<link>` tag with the correct file path and cache preventer.
     */
    function getFavIconDeclaration()
    {
        $cache = time();
        
        return "<link rel=\"icon\" type=\"image/x-icon\" href=\"/store/favicon.ico?={$cache}\" />\n";
    }

    /**
     * Return the HTML code to add all page used meta tags.
     * 
     * Currently there is added these meta tags:
     * * *http-equiv*
     * * *viewport*
     * * *description*
     * * *author*
     *
     * @return string All `<meta>` tags in order with the correct data.
     */
    function getMetaTagsDeclarations()
    {
        $metas = "";

        $metas .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n\n\t\t\t";
        $metas .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\" />\n\t\t\t";
        $metas .= "<meta name=\"description\" content=\"Trabalho Final da Cadeira de Desenvolvimento de Software para Web.\" />\n\t\t\t";
        $metas .= "<meta name=\"author\" content=\"Eduardo de Oliveira Rosa, Mestre Tramador\" />\n";

        return $metas;
    }

    /**
     * Return the HTML code to add all frontend JS scripts tags.
     *
     * @see `./assets/js/env.js`
     * @link https://getbootstrap.com/
     * @link https://jquery.com/
     * @link https://fontawesome.com/
     * @return string All `<script>` tags in order with the correct paths and cache preventer.
     */
    function getScriptsDeclarations()
    {
        $scripts = "";

        $cache = time();

        $scripts .= "<script type=\"application/javascript\" src=\"/store/assets/js/jquery.min.js?={$cache}\"></script>\n\t\t\t";
        $scripts .= "<script type=\"application/javascript\" src=\"/store/assets/js/bootstrap.bundle.min.js?={$cache}\"></script>\n\t\t\t";
        $scripts .= "<link rel=\"application/javascript\" href=\"/store/assets/js/bootstrap.bundle.min.js.map?={$cache}\" />\n\t\t\t";
        $scripts .= "<script type=\"application/javascript\" src=\"/store/assets/js/bootstrap-select.min.js?={$cache}\"></script>\n\t\t\t";
        $scripts .= "<link rel=\"application/javascript\" href=\"/store/assets/js/bootstrap-select.min.js.map?={$cache}\" />\n\t\t\t";
        $scripts .= "<script type=\"application/javascript\" src=\"/store/assets/js/fontawesome-all.min.js?={$cache}\" defer></script>\n\t\t\t";
        $scripts .= "<script type=\"application/javascript\" src=\"/store/assets/js/env.js?={$cache}\"></script>\n";

        return $scripts;
    }

    /**
     * Return the HTML code to add all frontend CSS style tags.
     *
     * @see `./assets/css/custom.css`
     * @link https://getbootstrap.com/
     * @link https://fontawesome.com/
     * @return string All `<link rel="stylesheet">` tags in order with the correct paths and cache preventer.
     */
    function getStylesDeclarations()
    {
        $styles = "";

        $cache = time();

        $styles .= "<link rel=\"stylesheet\" href=\"/store/assets/css/bootstrap.css.map?={$cache}\" />\n\t\t\t";
        $styles .= "<link rel=\"stylesheet\" href=\"/store/assets/css/bootstrap.min.css?={$cache}\" />\n\t\t\t";
        $styles .= "<link rel=\"stylesheet\" href=\"/store/assets/css/bootstrap.min.css.map?={$cache}\" />\n\t\t\t";
        $styles .= "<link rel=\"stylesheet\" href=\"/store/assets/css/fontawesome-all.min.css?={$cache}\" />\n\t\t\t";
        $styles .= "<link rel=\"stylesheet\" href=\"/store/assets/css/custom.css?={$cache}\" />\n";

        return $styles;
    }
    
    /**
     * Return the HTML code to add the page title.
     *
     * @return string The `<title>` tag with the used title.
     */
    function getTitleDeclaration()
    {
        return "<title>Cadastro do Ganso</title>\n";
    }

    /**
     * Simple function to direct the location to the index page.
     *
     * @return void Add the `Location` header and **die**.
     */
    function goToIndex()
    {
        header("Location: /store/");
        die;
    }

    /**
     * If this file is directly loaded, then it's redirected to the Index.
     */
    if(checkIfIsLoaded())
    {
        goToIndex();
    }
?>