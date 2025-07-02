<?php

namespace App\Model\Academico;

use App\Model\ConviteCadastro\Aluno;

class Comportamento
{
    private Aluno $aluno;
    private string $motivo;
    private int $pontos; // pode ser negativo

    public function __construct(Aluno $aluno, string $motivo, int $pontos)
    {
        $this->aluno = $aluno;
        $this->motivo = $motivo;
        $this->pontos = $pontos;
    }

    public function getAluno(): Aluno
    {
        return $this->aluno;
    }

    public function getPontos(): int
    {
        return $this->pontos;
    }

    public function getMotivo(): string
    {
        return $this->motivo;
    }
}
