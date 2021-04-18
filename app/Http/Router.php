<?php

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;

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
        $this->request = new Request($this);
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

        //Variaveis da rota
        $params['variables'] = [];

        //Padrão de validação das variaveis de rotas
        $patternVariable = '/{(.*?)}/';
        if(preg_match_all($patternVariable, $route, $matches)){
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
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

    /**Método responsável por definir uma rota de POST*/
    public function post(string $route, array $params = []): void
    {
        $this->addRoute('POST', $route, $params);
    }

    /**Método responsável por definir uma rota de put*/
    public function put(string $route, array $params = []): void
    {
        $this->addRoute('PUT', $route, $params);
    }

    /**Método responsável por definir uma rota de delete*/
    public function delete(string $route, array $params = []): void
    {
        $this->addRoute('DELETE', $route, $params);
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

        //Method
        $httpMethod = $this->request->getHttpMethod();

        //Valida as rotas
        foreach($this->routes as $patternRoute => $method){
            //Verifica se a uri bate com o padrão
            if(preg_match($patternRoute, $uri, $matches)){
                //Verifica o método
                if(isset($method[$httpMethod])){
                    //Remove a primeira posição
                    unset($matches[0]);

                    //Variaveis processadas
                    $keys = $method[$httpMethod]['variables'];
                    $method[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $method[$httpMethod]['variables']['request'] = $this->request;

                    //Retorno dos parametros da rota
                    return $method[$httpMethod];
                }
                //Metodo não permitido
                throw  new Exception('Método não permitido', 405);
            }
        }
        //Url não encontrada
        throw  new Exception('URL não encontrada', 405);
    }

    /**Método responsável por executar a rota atual*/
    public function run()
    {
        try{
            //Obtem a rota atual
            $route = $this->getRoute();

            //Verifica o controlador
            if(!isset($route['controller'])){
                throw  new Exception('A url não pôde ser processada', 500);
            }

            //Argumentos da função
            $args = [];

            //Retorna a execução da função
            $reflection = new ReflectionFunction($route['controller']);

            foreach($reflection->getParameters() as $parameter){
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }
            return call_user_func_array($route['controller'], $args);
        }catch(Exception $e){
            return new Response($e->getCode(), $e->getMessage());
        }
    }
    /**Método responsavel por retornar a url atual*/
    public function getCurrentUrl()
    {
        return $this->url.$this->getUri();
    }
}
