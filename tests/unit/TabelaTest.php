<?php

use Brasileirao\Domain\Parser;
use PHPUnit\Framework\TestCase;

class TabelaTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTime()
    {
        $time = (new Parser('b'))
            ->extrair()
            ->time('criciuma');
        self::assertEquals('Criciúma', $time->cidade()->nome());
    }

    /**
     * @throws Exception
     */
    public function testExtrairParteComTime()
    {
        $tabela = (new Parser('b'))
            ->extrair()
            ->parteComTimeEspecifico('criciúma', 5);
        $time = $tabela->time('criciúma');
        self::assertEquals('Criciúma', $time->cidade()->nome());
        self::assertEquals($tabela->totalDeTimes(), 5);
    }

    public function testTop4()
    {
        $tabela = (new Parser('b'))
            ->extrair()
            ->top4();
        self::assertEquals('1', $tabela->primeiro()->posicao());
        self::assertEquals('4', $tabela->ultimo()->posicao());
    }

    public function testUltimos4()
    {
        $tabela = (new Parser('b'))
            ->extrair()
            ->zonaDeRebaixamento();
        self::assertEquals('17', $tabela->primeiro()->posicao());
        self::assertEquals('20', $tabela->ultimo()->posicao());
    }
}
