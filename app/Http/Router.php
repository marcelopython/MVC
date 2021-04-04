<?php

namespace App\Http;

use \Closure;
use \Exception;

class Router
{

    /**Url completa do projeto*/
    private string $url = '';

    /**Prefixo de todas as rotas*/
    private string $prefix;

    /**Indice de rotas*/
    private $routes = [];

    /**instancia de request*/
    private Request $request;

    public function __construct(string $url)
    {
        $this->request = new Request();
        $this->url = $url;
        $this->setPrefix();
    }

    /**Método responsável por definir o prefixo das rotas*/
    private function setPrefix()
    {
        //Informações da url atual
        $parseUrl = parse_url($this->url);

        //Define o prefixo
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**Método responsável por adicionar uma rota na classe*/
    private function addRoute(string $method, string $route, array $params = [])
    {
        //Validação dos parametros
        foreach($params as $key => $value){
            if($value instanceof Closure){
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        //Padrão de validação da url
        $patternRoute = '/^'.str_replace('/', '\/', $route).'$/';

        //Adiciona a rota dentro da classe
        $this->routes[$patternRoute][$method] = $params;

    }

    /**Método responsável por definir uma rota de GET*/
    public function get(string $route, array $params = []): void
    {
        $this->addRoute('GET', $route, $params);
    }

    /**Método Responsavel por retornar a  URI desconsidereando o prefixo*/
    private function getUri(): string
    {
        //Uri da request
        $uri = $this->request->getUri();

        //Fatia uri com o prefixo
        $exUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        //Retorna a uri sem prefixo
        return end($exUri);
    }

    /**Metodo responsável por retornar os dados da rota atual*/
    private function getRoute(): array
    {
        //Uri
        $uri = $this->getUri();
    }

    /**Método responsável por executar a rota atual*/
    public function run(): Response
    {
        try{
            //Obtem a rota atual
            $route = $this->getRoute();


        }catch(Exception $e){
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}