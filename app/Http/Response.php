<?php

namespace App\Http;


class Response
{
    /**Cõdigo do status Http*/
    private int $httpCode = 200;

    /**Cabeçalho do response*/
    private array $headers = [];

    /**Tipo de conteudo*/
    private string $contentType = 'text/html';

    /**Conteudo do Response*/
    private $content;

    public function __construct(int $httpCode, $content, string $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    /**Método responsável por alterar o contentType do response*/
    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**Método responsável por adicionar um registro no cabeçalho do response*/
    public function addHeader(string $key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**Metodo responsável por enviar os headers para o navegador*/
    private function sendHeaders(): void
    {
        //Status
        http_response_code($this->httpCode);

        //Enviar Headers
        foreach($this->headers as $key => $value){
            header($key.': '.$value);
        }
    }

    /**Metodo responsavel por enviar resposta para o usuário*/
    public function sendResponse()
    {
        // Envia os headers
        $this->sendHeaders();

        // Imprime o conteudo
        switch($this->contentType){
            case 'text/html':
                echo $this->content;
                exit;
        }
    }

}