<?php

namespace Brasileirao\Tabela;

use DOMElement;
use DOMNodeList;
use DOMDocument;
use Brasileirao\Helpers\Numero;

class TabelaBrasileiraoParser
{
    const TABELA_URL = 'https://www.cbf.com.br/futebol-brasileiro/competicoes/campeonato-brasileiro-serie-';
    private $documento;

    public function __construct($serie)
    {
        libxml_use_internal_errors(true);
        $this->documento = new DOMDocument();
        $this->documento->loadHTML(file_get_contents(self::TABELA_URL.strtolower($serie)));
    }

    public function extrair()
    {
        $tabela = $this->documento
            ->getElementsByTagName('table')
            ->item(0);
        $tableBody = $tabela
            ->getElementsByTagName('tbody')
            ->item(0);
        $linhas = $tableBody
            ->getElementsByTagName('tr');
        return $this->criarTabela($linhas);
    }

    private function criarTabela(DOMNodeList $linhas)
    {
        $tabelaBrasileirao = new TabelaBrasileirao();
        foreach ($linhas as $key => $linha) {
            if (Numero::isPar($key)) {
                $tabelaBrasileirao->adicionarTime($this->criarTime($linha));
            }
        }
        return $tabelaBrasileirao;
    }

    private function criarTime(DOMElement $linha)
    {
        $celulasBody = $linha
            ->getElementsByTagName('td');
        $posicao = $celulasBody
            ->item(0)
            ->getElementsByTagName('b')
            ->item(0)
            ->textContent;
        $nome = $celulasBody
            ->item(0)
            ->getElementsByTagName('span')
            ->item(1)
            ->textContent;
        $escudo = $celulasBody
            ->item(0)
            ->getElementsByTagName('img')
            ->item(0)
            ->getAttribute('src');
        $pontos = $linha
            ->getElementsByTagName('th')
            ->item(0)
            ->textContent;
        $vitorias = $celulasBody
            ->item(2)
            ->textContent;
        $empates = $celulasBody
            ->item(3)
            ->textContent;
        $derrotas = $celulasBody
            ->item(4)
            ->textContent;
        return new Time($this->limparPosicao($posicao), $escudo, $this->criarCidade($nome), $pontos, $vitorias, $empates, $derrotas);
    }

    private function limparPosicao($posicao)
    {
        return str_replace('º', '', $posicao);
    }

    private function criarCidade($nome)
    {
        $array = explode('-', $nome);
        $cidade = trim($array[0]);
        $uf = trim($array[1]);
        return new Cidade($uf, $cidade);
    }
}
