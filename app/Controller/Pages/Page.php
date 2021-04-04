<?php

namespace App\Controller\Pages;

use App\Utils\View;

class Page
{

    /*Metodo responsável por renderizar o topo da paginas*/
    private static function getHeader(): string
    {
        return View::render('pages/header');
    }

    /*Metodo responsável por renderizar o footer da paginas*/
    private static function getFooter(): string
    {
        return View::render('pages/footer');
    }

    /*Metodo responsável por retornar o conteudo (view) da pagina generica*/
    public static function getPage(string $title, string $content): string
    {
        return View::render('pages/page',
            [
                'title'=>$title,
                'header'=>self::getHeader(),
                'content'=>$content,
                'footer'=>self::getFooter()
            ]
        );
    }

}