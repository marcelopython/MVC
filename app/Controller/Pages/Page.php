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

    /**Metodo responsável por renderizar o layout da paginação**/
    public static function getPagination($request, $pagination): string
    {
        //Paginas;
        $pages = $pagination->getPages();

        //Verifica a quantidade de paginas
        if(count($pages) <= 1){
            return '';
        }

        //links
        $links = '';

        //url autal sem gets
        $url = $request->getRouter()->getCurrentUrl();

        //Get
        $queryParams = $request->getQueryParams();

        //Renderiza os links
        foreach($pages as $page){
            //Altera a pagina
            $queryParams['page'] = $page['page'];

            //link
            $link = $url.'?'.http_build_query($queryParams);

            //View
            $links .= View::render('pages/paginations/link',
            ['page'=>$page['page'],'link'=>$link,'active'=>$page['current'] ? 'active' : '']);
        }
        //Renderiza box de paginação
        return View::render('pages/paginations/box',['links'=>$links]);
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
