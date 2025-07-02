<?php
namespace App\Model\Comunicacao;

class Mensagem
{
    private string $titulo;
    private string $conteudo;
    private string $emissor;
    private array $destinatarios;
    private \DateTime $dataEnvio;

    public function __construct(string $titulo, string $conteudo, string $emissor, array $destinatarios, ?string $dataEnvio = null)
    {
        $this->titulo = $titulo;
        $this->conteudo = $conteudo;
        $this->emissor = $emissor;
        $this->destinatarios = $destinatarios;
        $this->dataEnvio = $dataEnvio ? new \DateTime($dataEnvio) : new \DateTime();
    }

    public function getTitulo(): string { return $this->titulo; }
    public function getConteudo(): string { return $this->conteudo; }
    public function getEmissor(): string { return $this->emissor; }
    public function getDestinatarios(): array { return $this->destinatarios; }
    public function getDataEnvio(): \DateTime { return $this->dataEnvio; }
}
