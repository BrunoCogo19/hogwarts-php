<?php
namespace App\Model\Comunicacao;

class MensagemRepository
{
    private array $mensagens = [];

    public function adicionar(Mensagem $mensagem): void
    {
        $this->mensagens[] = $mensagem;
    }

    public function listarParaDestinatario(string $destinatario): array
    {
        return array_filter($this->mensagens, function ($msg) use ($destinatario) {
            return in_array($destinatario, $msg->getDestinatarios());
        });
    }

    public function listarTodas(): array
    {
        return $this->mensagens;
    }
}
