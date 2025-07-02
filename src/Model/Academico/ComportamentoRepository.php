<?php

namespace App\Model\Academico;

class ComportamentoRepository
{
    /** @var Comportamento[] */
    private array $registros = [];

    public function adicionar(Comportamento $registro): void
    {
        $this->registros[] = $registro;
    }

    /** @return array<string, int> Casa => Pontuação acumulada */
    public function pontuacaoPorCasa(): array
    {
        $pontuacao = [];

        foreach ($this->registros as $registro) {
            $casa = $registro->getAluno()->getCasa()?->value ?? 'Sem casa';
            $pontuacao[$casa] = ($pontuacao[$casa] ?? 0) + $registro->getPontos();
        }

        return $pontuacao;
    }
}
