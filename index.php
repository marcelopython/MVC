<?php

require __DIR__.'/includes/app.php';

use \App\Http\Router;

$obRouter = new Router(URL);

//Inclue as rotas de paginas
include __DIR__.'/routes/pages.php';

/*Imprime o response da pagina*/
$obRouter->run()->sendResponse();
