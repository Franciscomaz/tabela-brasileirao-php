<?php

namespace Brasileirao\Tabela;

use Brasileirao\Helpers\Numero;

class TabelaBrasileirao extends \ArrayObject
{
    public function __construct(array $time = [])
    {
        $this->exchangeArray($time);
    }

    public function adicionarTime(Time $time)
    {
        $this->append($time);
    }

    /**
     * @return Time
     */
    public function primeiro()
    {
        return $this->times()[0];
    }

    /**
     * @return Time
     */
    public function ultimo()
    {
        return $this->times()[$this->count() - 1];
    }

    public function top4()
    {
        return $this->parteDaTabela(0, 4);
    }

    public function ultimos4()
    {
        return $this->parteDaTabela(16, 4);
    }

    public function totalDeTimes()
    {
        return $this->count();
    }

    public function parteDaTabela($inicio, $tamanho)
    {
        return new self(array_slice($this->times(), $inicio, $tamanho));
    }

    public function times()
    {
        return $this->getArrayCopy();
    }

    /**
     * @param $nome
     * @return Time
     * @throws \Exception
     */
    public function time($nome)
    {
        $time = array_filter($this->getArrayCopy(), function (Time $time) use ($nome) {
            return strtolower($time->cidade()->nome()) === strtolower($nome);
        });
        if (empty($time)) {
            throw new \Exception('Time não encontrado', 204);
        }
        return end($time);
    }

    /**
     * @param $nome
     * @param $quantidadeDeTimes
     * @return TabelaBrasileirao
     * @throws \Exception
     */
    public function parteDaTabelaComTimeEspecifico($nome, $quantidadeDeTimes)
    {
        $time = $this->time($nome);
        $quantidadeDeTimesABaixo = $quantidadeDeTimes / 2;
        $quantidadeDeTimesACima = Numero::isPar($quantidadeDeTimes)
            ? $quantidadeDeTimesABaixo - 1
            : $quantidadeDeTimesABaixo;
        if ($time->posicao() - $quantidadeDeTimesACima < 0) {
            return $this->parteDaTabela(0, $quantidadeDeTimes);
        } else if ($time->posicao() + $quantidadeDeTimesABaixo > $this->totalDeTimes()) {
            $inicio = $this->totalDeTimes() - $quantidadeDeTimes - 1;
            return $this->parteDaTabela($inicio, $quantidadeDeTimes);
        } else {
            $inicio = $time->posicao() - $quantidadeDeTimesABaixo;
            return $this->parteDaTabela($inicio, $quantidadeDeTimes);
        }
    }

    public function toArray()
    {
        return array_map(function (Time $time) {
            return $time->toArray();
        }, $this->times());
    }
}
