<?php

namespace Brasileirao\Domain;

class Time
{
    private $posicao;
    private $escudo;
    private $cidade;
    private $vitorias;
    private $empates;
    private $derrotas;

    public function __construct($posicao, $escudo, Cidade $cidade, $vitorias, $empates, $derrotas)
    {
        $this->posicao = $posicao;
        $this->escudo = $escudo;
        $this->cidade = $cidade;
        $this->vitorias = $vitorias;
        $this->empates = $empates;
        $this->derrotas = $derrotas;
    }

    public function posicao()
    {
        return $this->posicao;
    }

    public function escudo()
    {
        return $this->escudo;
    }

    public function cidade()
    {
        return $this->cidade;
    }

    public function pontos()
    {
        return $this->vitorias * 3 + $this->empates;
    }

    public function vitorias()
    {
        return $this->vitorias;
    }

    public function empates()
    {
        return $this->empates;
    }

    public function derrotas()
    {
        return $this->derrotas;
    }

    public function jogos()
    {
        return $this->vitorias +
            $this->derrotas +
            $this->empates;
    }

    public function toArray()
    {
        return [
            'posicao' => $this->posicao,
            'nome' => $this->cidade->nome(),
            'pontos' => $this->pontos(),
            'vitorias' => $this->vitorias,
            'empates' => $this->empates,
            'escudo' => $this->escudo,
            'derrotas' => $this->derrotas,
            'jogos' => $this->jogos(),
        ];
    }
}
