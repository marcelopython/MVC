<?php


require __DIR__.'/../vendor/autoload.php';

use \WilliamCosta\DotEnv\Environment;
use \App\Utils\View;
use \WilliamCosta\DatabaseManager\Database;

//Carrega variáveis de ambiente
Environment::load(__DIR__.'/../');


//Definie as configurações do banco de dados
Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT')
);
//config($host,$name,$user,$pass,$port = 3306)
//Define a constante de url no projeto
define('URL', getenv('URL'));

//Defini o valor padrão das variáveis
View::init([
    'URL'=>URL
]);
