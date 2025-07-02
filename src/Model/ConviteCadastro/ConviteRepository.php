<?php
namespace App\Model\ConviteCadastro;

class ConviteRepository {
    /** @var Convite[] */
    private array $convites = [];

    public function adicionar(Convite $convite): void {
        $this->convites[] = $convite;
    }

    public function listarTodos(): array {
        return $this->convites;
    }

    public function listarConfirmados(): array {
        return array_filter($this->convites, function ($convite) {
            return $convite->getAluno()->recebeuCarta();
        });
    }
}
