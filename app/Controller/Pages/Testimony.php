<?php

namespace App\Controller\Pages;


use App\Utils\View;
use App\Model\Entity\Testimony as EntityTestimony;
use WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page
{

    /**
    *Metodo responsável por obter a rendereização dos items de depoimentos
    *para a pagina
    */
    private static function getTestimoniesItems($request): string
    {
        //depoimentos
        $items = '';

        //Quantidade toda de registros;
        $quantidadeTotal = EntityTestimony::getTestimoniesItems(null, null,
        null, ' COUNT(*) as qtd ')->fetchObject()->qtd;

        //Pagina atual;
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //Instancia de paginação
        $pagination = new Pagination($quantidadeTotal, $paginaAtual, 5);

        $results = EntityTestimony::getTestimoniesItems(null, 'id DESC',
         $pagination->getLimit());
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
    public static function getTestimonies($request): string
    {
        $content = View::render('pages/testimonies', [
          'items'=>self::getTestimoniesItems($request)
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
        //Nova instancia de depoimento
        $testimony = new EntityTestimony();

        $testimony->nome = $postVars['nome'];

        $testimony->message = $postVars['mensagem'];

        $testimony->cadastrar();

        //Retorna a view de depoimentos
        return self::getTestimonies($request);
    }

}
