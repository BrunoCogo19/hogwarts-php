<?php
namespace App\Model\Academico;

use App\Model\Usuario\Pessoa;
use App\Model\Comunicacao\Notificavel;
use App\Model\Comunicacao\Mensagem;

class Professor extends Pessoa implements Notificavel
{
    private array $disciplinas = [];
    private array $turmas = [];
    private Cronograma $cronograma;
    private array $mensagens = [];

    public function __construct(string $nome, string $email)
    {
        parent::__construct($nome, $email);
        $this->cronograma = new Cronograma();
    }

    public function adicionarDisciplina(string $disciplina): void
    {
        $this->disciplinas[] = $disciplina;
    }

    public function adicionarTurma(string $turma): void
    {
        $this->turmas[] = $turma;
    }

    public function getDisciplinas(): array
    {
        return $this->disciplinas;
    }

    public function getTurmas(): array
    {
        return $this->turmas;
    }

    public function getCronograma(): Cronograma
    {
        return $this->cronograma;
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
