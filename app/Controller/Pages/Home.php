<?php

namespace App\Controller\Pages;

use App\Model\Entity\Organization;
use App\Utils\View;

class Home extends Page
{

    /*Metodo responsável por retornar o conteudp (view) da home*/
    public static function getHome(): string
    {
        $obOrganization = new Organization();
//                echo '<pre>';
//        print_r($obOrganization);
//        exit;

        //View da home
        $content = View::render('pages/home', [
            'name'=>$obOrganization->name, 'description'=>$obOrganization->description, 'site'=>$obOrganization->site
        ]);
        //Retorna a view da página
        return parent::getPage('Pagina inicial', $content);
    }

}