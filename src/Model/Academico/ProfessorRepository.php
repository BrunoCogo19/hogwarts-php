<?php

namespace App\Model\Academico;
use App\Model\Academico\Cronograma;
use App\Model\Academico\Professor;



class ProfessorRepository
{
    private array $professores = [];

    public function adicionar(Professor $professor): void
    {
        $this->professores[] = $professor;
    }

    public function listar(): array
    {
        return $this->professores;
    }

    public function buscarPorNome(string $nome): ?Professor
    {
        foreach ($this->professores as $professor) {
            if (strtolower($professor->getNome()) === strtolower($nome)) {
                return $professor;
            }
        }
        return null;
    }

    public function adicionarAoCronograma(
        string $nomeProfessor,
        string $dia,
        string $hora,
        string $disciplina,
        string $turma
    ): bool {
        $professor = $this->buscarPorNome($nomeProfessor);
        if ($professor) {
            $professor->getCronograma()->adicionarHorario($dia, $hora, $disciplina, $turma);
            return true;
        }
        return false;
    }
}
