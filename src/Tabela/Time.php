<?php

namespace Brasileirao\Tabela;

class Time
{
    private $posicao;
    private $escudo;
    private $cidade;
    private $pontos;
    private $vitorias;
    private $empates;
    private $derrotas;

    public function __construct($posicao, $escudo, Cidade $cidade, $pontos, $vitorias, $empates, $derrotas)
    {
        $this->posicao = $posicao;
        $this->escudo = $escudo;
        $this->cidade = $cidade;
        $this->pontos = $pontos;
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
        return $this->pontos;
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

    public function quantidadeDeJogos()
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
            'pontos' => $this->pontos,
            'vitorias' => $this->vitorias,
            'empates' => $this->empates,
            'escudo' => $this->escudo,
            'derrotas' => $this->derrotas,
            'jogos' => $this->quantidadeDeJogos(),
        ];
    }
}
