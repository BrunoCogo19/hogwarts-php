<?php
namespace App\Model\Comunicacao;

use App\Model\Comunicacao\Mensagem;

interface Notificavel
{
    public function receberMensagem(Mensagem $mensagem): void;
    public function listarMensagens(): array;
}
