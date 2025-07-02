<?php
namespace App\Model\ConviteCadastro;

use App\Model\Usuario\Pessoa;
use App\Model\Comunicacao\Notificavel;
use App\Model\Comunicacao\Mensagem;

class Aluno extends Pessoa implements Notificavel
{
    private \DateTime $dataNascimento;
    private bool $cartaRecebida = false;
    private ?\App\Model\SelecaoCasas\Casa $casa = null;
    private array $caracteristicas = [];
    private array $mensagens = [];

    public function __construct(string $nome, string $email, string $dataNascimento)
    {
        parent::__construct($nome, $email);
        $this->dataNascimento = new \DateTime($dataNascimento);
    }

    public function confirmarRecebimento(): void
    {
        $this->cartaRecebida = true;
    }

    public function recebeuCarta(): bool
    {
        return $this->cartaRecebida;
    }

    public function temIdadeMinima(int $idadeMinima = 11): bool
    {
        $hoje = new \DateTime();
        $idade = $hoje->diff($this->dataNascimento)->y;
        return $idade >= $idadeMinima;
    }

    public function setCasa(\App\Model\SelecaoCasas\Casa $casa): void
    {
        $this->casa = $casa;
    }

    public function getCasa(): ?\App\Model\SelecaoCasas\Casa
    {
        return $this->casa;
    }

    public function definirCaracteristicas(array $caracteristicas): void
    {
        $this->caracteristicas = $caracteristicas;
    }

    public function getCaracteristicas(): array
    {
        return $this->caracteristicas;
    }

    // Implementação da interface Notificavel
    public function receberMensagem(Mensagem $mensagem): void
    {
        $this->mensagens[] = $mensagem;
    }

    public function listarMensagens(): array
    {
        return $this->mensagens;
    }
}
