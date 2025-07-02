<?php

namespace App\Model\Torneios;

class Torneio
{
    private string $nome;
    private string $tipo;
    private string $regras;
    private string $local;
    private string $data;
    private array $desafios = [];

    public function __construct(string $nome, string $tipo, string $regras, string $local, string $data)
    {
        $this->nome = $nome;
        $this->tipo = $tipo;
        $this->regras = $regras;
        $this->local = $local;
        $this->data = $data;
    }

    public function adicionarDesafio(Desafio $desafio): void
    {
        $this->desafios[] = $desafio;
    }

    public function getDesafios(): array
    {
        return $this->desafios;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getTipo(): string
    {
        return $this->tipo;
    }
}
