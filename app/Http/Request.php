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

    public function __construct()
    {
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
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