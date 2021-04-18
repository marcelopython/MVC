<?php

use \App\Http\Response;
use App\Controller\Pages\ {
    Home,
    About,
    Testimony
};


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


//Rota de depoimentos
$obRouter->get('/depoimentos', [
    function($request){
        return new Response(200, Testimony::getTestimonies($request));
    }
]);


//Rota de depoimentos insert
$obRouter->post('/depoimentos', [
    function($request){
        return new Response(200, Testimony::insertTestimony($request));
    }
]);
