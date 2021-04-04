<?php

require __DIR__.'/vendor/autoload.php';

use App\Controller\Pages\Home;

define('URL', 'http://localhost/mvc');


$obRouter = new \App\Http\Router(URL);


$obRouter->get('/', [
    function(){
        return new \App\Http\Response(200, Home::getHome());
    }
]);

/*Imprime o response da pagina*/
$obRouter->run()->sendResponse();

echo memory_get_peak_usage();