<?php

use \App\Http\Response;
use App\Controller\Pages\Home;
use \App\Controller\Pages\About;


//Rota de home
$obRouter->get('/', [
    function(){
        return new Response(200, Home::getHome());
    }
]);

//Rota de sobre
$obRouter->get('/sobre', [
    function(){
        return new Response(200, About::getAbout());
    }
]);

//Rota dinámica
$obRouter->get('/pagina/{idPagina}', [
    function($idPagina){
        return new Response(200, 'Pagina '.$idPagina);
    }
]);