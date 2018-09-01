<?php

namespace Brasileirao\Domain;

use Brasileirao\Helpers\Numero;
use Brasileirao\Helpers\Texto;

class Tabela implements \Countable
{
    private $times;

    public function __construct(array $times = [])
    {
        $this->times = $times;
    }

    public function adicionarTime(Time $time)
    {
        $this->times[Texto::sanitize($time->cidade()->nome())] = $time;
    }

    public function primeiro(): Time
    {
        return $this->times()[0];
    }

    public function ultimo(): Time
    {
        return $this->times()[$this->count()-1];
    }

    public function top4()
    {
        return $this->parte(0, 4);
    }

    public function zonaDeRebaixamento()
    {
        return $this->parte(16, 4);
    }

    public function totalDeTimes()
    {
        return $this->count();
    }

    public function parte($inicio, $tamanho)
    {
        return new self(array_slice($this->times, $inicio, $tamanho));
    }

    public function time($nome): Time
    {
        $nome = Texto::sanitize($nome);
        if (!isset($this->times[$nome])) {
            throw new \Exception('Time não encontrado', 204);
        }
        return $this->times[$nome];
    }

    public function times()
    {
        return array_values($this->times);
    }

    public function parteComTimeEspecifico($nome, $quantidadeDeTimes): Tabela
    {
        $time = $this->time($nome);
        $quantidadeDeTimesABaixo = $quantidadeDeTimes / 2;
        $quantidadeDeTimesACima = Numero::isPar($quantidadeDeTimes)
            ? $quantidadeDeTimesABaixo - 1
            : $quantidadeDeTimesABaixo;
        if ($time->posicao() - $quantidadeDeTimesACima < 0) {
            return $this->parte(0, $quantidadeDeTimes);
        } else if ($time->posicao() + $quantidadeDeTimesABaixo > $this->totalDeTimes()) {
            $inicio = $this->totalDeTimes() - $quantidadeDeTimes - 1;
            return $this->parte($inicio, $quantidadeDeTimes);
        } else {
            $inicio = $time->posicao() - $quantidadeDeTimesABaixo;
            return $this->parte($inicio, $quantidadeDeTimes);
        }
    }

    public function toArray()
    {
        return array_map(function (Time $time) {
            return $time->toArray();
        }, $this->times());
    }

    public function count()
    {
        return count($this->times());
    }
}
