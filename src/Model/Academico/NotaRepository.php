<?php

namespace App\Model\Academico;

class NotaRepository
{
    /** @var Nota[] */
    private array $notas = [];

    public function adicionar(Nota $nota): void
    {
        $this->notas[] = $nota;
    }

    /** @return Nota[] */
    public function boletimPorAluno(string $nomeAluno): array
    {
        return array_filter($this->notas, fn($n) =>
            strtolower($n->getAluno()->getNome()) === strtolower($nomeAluno)
        );
    }
}
