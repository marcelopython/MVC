<?php

namespace App\Http;


class Request
{

    /**Metodo http da requisição*/
    private string $httpMethod;

    /**Uri da pagina*/
    private string $uri;

    /**Parametros da url ($_GET)*/
    private array $queryParams = [];

    /**Variaveis recebidas no POST da página ($_POST)*/
    private array $postVars = [];

    /**Cabeçalho da requisição*/
    private array $headers = [];

    /**Instanceia de Router*/
    private Router $router;

    public function __construct($router)
    {
        $this->router = $router;
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
    }

    /**Método responsável por definir a uri*/
    private function setUri()
    {
        //Uri completa
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';

        //Remove gets da uri
        $xURI = explode('?', $this->uri);
        $this->uri = $xURI[0];
    }

    //Método responsável por retornar a instanceia de router
    public function getRouter()
    {
        return $this->router;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getPostVars(): array
    {
        return $this->postVars;
    }

}
