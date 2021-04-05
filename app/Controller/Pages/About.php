<?php

namespace App\Controller\Pages;

use App\Model\Entity\Organization;
use App\Utils\View;

class About extends Page
{

    /*Metodo responsável por retornar o conteudp (view) da home*/
    public static function getAbout(): string
    {
        $obOrganization = new Organization();
        //View de sobre
        $content = View::render('pages/about', [
            'name'=>$obOrganization->name, 'description'=>$obOrganization->description, 'site'=>$obOrganization->site
        ]);
        //Retorna a view da página
        return parent::getPage('Sobre', $content);
    }

}