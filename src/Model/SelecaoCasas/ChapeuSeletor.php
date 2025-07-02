<?php

namespace App\Model\SelecaoCasas;

use App\Model\ConviteCadastro\Aluno;

class ChapeuSeletor
{
    public static function sortearCasa(Aluno $aluno): Casa
    {
        // Simples: com base na primeira característica
        $preferencia = strtolower($aluno->getCaracteristicas()[0] ?? '');

        return match (true) {
            str_contains($preferencia, 'coragem') => Casa::Grifinoria,
            str_contains($preferencia, 'ambição') => Casa::Sonserina,
            str_contains($preferencia, 'sabedoria') => Casa::Corvinal,
            str_contains($preferencia, 'lealdade') => Casa::LufaLufa,
            default => Casa::cases()[array_rand(Casa::cases())]
        };
    }
}
