<?php

namespace Brasileirao\Domain;

class Cidade
{
    private $uf;
    private $nome;

    public function __construct($uf, $nome)
    {
        $this->uf = $uf;
        $this->nome = $nome;
    }

    public function nome()
    {
        return $this->nome;
    }

    public function uf()
    {
        return $this->uf;
    }
}
