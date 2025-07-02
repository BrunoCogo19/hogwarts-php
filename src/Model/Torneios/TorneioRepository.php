<?php

namespace App\Model\Torneios;

class TorneioRepository
{
    /** @var Torneio[] */
    private array $torneios = [];

    public function adicionar(Torneio $torneio): void
    {
        $this->torneios[] = $torneio;
    }

    public function listarTodos(): array
    {
        return $this->torneios;
    }

    public function buscarPorNome(string $nome): ?Torneio
    {
        foreach ($this->torneios as $torneio) {
            if (strtolower($torneio->getNome()) === strtolower($nome)) {
                return $torneio;
            }
        }
        return null;
    }
}
