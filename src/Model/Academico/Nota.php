<?php

namespace App\Model\Academico;

use App\Model\ConviteCadastro\Aluno;

class Nota
{
    private Aluno $aluno;
    private Disciplina $disciplina;
    private float $valor;

    public function __construct(Aluno $aluno, Disciplina $disciplina, float $valor)
    {
        $this->aluno = $aluno;
        $this->disciplina = $disciplina;
        $this->valor = $valor;
    }

    public function getAluno(): Aluno
    {
        return $this->aluno;
    }

    public function getDisciplina(): Disciplina
    {
        return $this->disciplina;
    }

    public function getNota(): float
    {
        return $this->valor;
    }
}
