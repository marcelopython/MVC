<?php

namespace App\Controller\Pages;


use App\Utils\View;
use App\Model\Entity\Testimony as EntityTestimony;

class Testimony extends Page
{

    /**
    *Metodo responsável por obter a rendereização dos items de depoimentos para a pagina
    */
    private static function getTestimoniesItems(): string
    {
        //depoimentos
        $items = '';

        $results = EntityTestimony::getTestimoniesItems(null, 'id DESC');
        while ($testimony = $results->fetchObject(EntityTestimony::class)) {
            $items .= View::render('pages/testimony/item', [
              'nome'=>$testimony->nome,
              'data'=>date('d/m/Y H:i:s', strtotime($testimony->data)),
              'message'=>$testimony->message
            ]);
        }

        return $items;
    }

    /**
     * Metodo responsável por retornar o conteudp (view) de depoimentos
     * */
    public static function getTestimonies(): string
    {
        $content = View::render('pages/testimonies', [
          'items'=>self::getTestimoniesItems()
        ]);
        //Retorna a view da página
        return parent::getPage('Depoimentos', $content);
    }

    /**
     * Metodo responsável por cadastrar um depoimento
     * @param $request
     */
    public static function insertTestimony($request): string
    {
        //Dados do post
        $postVars = $request->getPostVars();
        //print_r($postVars); exit;

        //Nova instancia de depoimento
        $testimony = new EntityTestimony();
        $testimony->nome = $postVars['nome'];
        $testimony->mensagem = $postVars['mensagem'];
        $testimony->cadastrar();

        //Retorna a view de depoimentos
        return self::getTestimonies();
    }

}
