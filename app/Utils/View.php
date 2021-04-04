<?php


namespace App\Utils;

class View
{
    /*Método responsável por retornar o conteúdo de uma view*/
    private static function getContentView(string $view): string
    {
        $file = __DIR__.'/../../resources/view/'.$view.'.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    /**
     * Método responsável por retornar o conteúdo rendereizado de uma view
     * $vars são as variáveis que serão passadas para a view
     */
    public static function render(string $view, array $vars = []): string
    {
        //Conteudo da view
        $contentView = self::getContentView($view);

        //Chaves do array de variaveis
        $keys = array_keys($vars);
        $keys = array_map(function($item){return '{{'.$item.'}}';}, $keys);

//        echo '<pre>';
//        print_r($keys);
//        exit;

        //Retorna o conteudo renderizado
        return str_replace($keys, array_values($vars), $contentView);

    }

}