<?php

namespace Potelo\NfseSsa\Request;

class Error
{
    /**
     * @var
     */
    public $codigo;

    /**
     * @var
     */
    public $mensagem;

    /**
     * @var
     */
    public $correcao;

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'codigo' => $this->codigo,
            'mensagem' => $this->mensagem,
            'correcao' => $this->correcao,
        ];
    }

    /**
     * Convert the model instance to JSON.
     *
     * @param  int  $options
     * @return string
     *
     * @throws \Exception
     */
    public function toJson($options = 0)
    {
        $json = json_encode($this->toArray(), $options);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception(json_last_error_msg());
        }

        return $json;
    }

    /**
     * Convert the model to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
