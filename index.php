<?php

require __DIR__.'/vendor/autoload.php';

define('URL', 'http://localhost/mvc');

//Defini o valor padrão das variáveis
\App\Utils\View::init([
    'URL'=>URL
]);

$obRouter = new \App\Http\Router(URL);

//Inclue as rotas de paginas
include __DIR__.'/routes/pages.php';

/*Imprime o response da pagina*/
$obRouter->run()->sendResponse();

echo memory_get_peak_ussage();