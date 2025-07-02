<?php

namespace App\Model\Academico;

class Cronograma
{
    private array $horarios = [];

    public function adicionarHorario(string $dia, string $hora, string $disciplina, string $turma): void
    {
        $this->horarios[] = [
            'dia' => $dia,
            'hora' => $hora,
            'disciplina' => $disciplina,
            'turma' => $turma
        ];
    }

    public function listarHorarios(): array
    {
        return $this->horarios;
    }

    public function exibir(): void
    {
        foreach ($this->horarios as $item) {
            echo "📚 {$item['disciplina']} - Turma {$item['turma']} - {$item['dia']} às {$item['hora']} \n";
        }
    }
}
