<?php

namespace App\Model\Torneios;

use App\Model\ConviteCadastro\Aluno;

class Inscricao
{
    private Aluno $aluno;
    private Desafio $desafio;
    private int $pontuacaoObtida = 0;

    public function __construct(Aluno $aluno, Desafio $desafio)
    {
        $this->aluno = $aluno;
        $this->desafio = $desafio;
    }

    public function registrarPontuacao(int $pontos): void
    {
        $this->pontuacaoObtida = min($pontos, $this->desafio->getPontuacaoMaxima());
    }

    public function getPontuacao(): int
    {
        return $this->pontuacaoObtida;
    }

    public function getAluno(): Aluno
    {
        return $this->aluno;
    }

    public function getDesafio(): Desafio
    {
        return $this->desafio;
    }
}
