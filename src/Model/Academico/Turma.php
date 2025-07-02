<?php

namespace App\Model\Academico;

class Turma
{
    private string $nome;
    private string $horario;

    public function __construct(string $nome, string $horario)
    {
        $this->nome = $nome;
        $this->horario = $horario;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getHorario(): string
    {
        return $this->horario;
    }
}
