<?php

namespace App\Model\Torneios;

class Desafio
{
    private string $descricao;
    private int $pontuacaoMaxima;

    public function __construct(string $descricao, int $pontuacaoMaxima)
    {
        $this->descricao = $descricao;
        $this->pontuacaoMaxima = $pontuacaoMaxima;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getPontuacaoMaxima(): int
    {
        return $this->pontuacaoMaxima;
    }
}
