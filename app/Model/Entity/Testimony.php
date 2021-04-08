<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Testimony
{
    /**
     * ID do depoimento
     */
    public int $id;

    /**
     * Nome do usuário
     */
    public string $nome;

    /**
     * Mensagem do usuário
     */
    public string $message;

    /**
     * Data da criação do depoimentos
     */
    public \DateTime $data;

    /**
   * Metodo responsável por cadastrar a instancia atual no bando de dados
   */
  public function cadastrar()
  {
      $this->data = new \DateTime();

      //Insere depoimento no banco de dados
      $this->id = (new Database('depoimentos'))->insert([
          'nome'=>$this->nome, 'message'=>$this->message, 'data'=>$this->data->format('Y-m-d H:i:s')
      ]);
      return $this;
    }
}
