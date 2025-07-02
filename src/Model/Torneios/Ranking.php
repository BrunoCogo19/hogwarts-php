<?php

namespace App\Model\Torneios;

use App\Model\Academico\ComportamentoRepository;

class Ranking
{
    public static function calcularPorCasa(array $inscricoes, ComportamentoRepository $repoComportamento): array
    {
        $pontuacao = [];

        // 1. Somar pontos das inscrições (torneios)
        foreach ($inscricoes as $inscricao) {
            $casa = $inscricao->getAluno()->getCasa();
            if ($casa) {
                $nomeCasa = $casa->value;
                $pontuacao[$nomeCasa] = ($pontuacao[$nomeCasa] ?? 0) + $inscricao->getPontuacao();
            }
        }

        // 2. Somar pontos de comportamento
        $comportamento = $repoComportamento->pontuacaoPorCasa();
        foreach ($comportamento as $casa => $pontos) {
            $pontuacao[$casa] = ($pontuacao[$casa] ?? 0) + $pontos;
        }

        arsort($pontuacao);
        return $pontuacao;
    }

    public static function calcularPorAluno(array $inscricoes): array
    {
        $pontuacao = [];

        foreach ($inscricoes as $inscricao) {
            $nome = $inscricao->getAluno()->getNome();
            $pontuacao[$nome] = ($pontuacao[$nome] ?? 0) + $inscricao->getPontuacao();
        }

        arsort($pontuacao);
        return $pontuacao;
    }
}
