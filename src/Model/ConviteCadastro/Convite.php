<?php
namespace App\Model\ConviteCadastro;

class Convite {
    private Aluno $aluno;
    private bool $enviado = false;

    public function __construct(Aluno $aluno) {
        $this->aluno = $aluno;
    }

    public function enviar(): void {
        echo "🦉 Enviando carta para " . $this->aluno->getNome() . " (" . $this->aluno->getEmail() . ")" . PHP_EOL;
        echo "🧙‍♂️ Conteúdo: Prezado " . $this->aluno->getNome() . ", você foi convocado a ingressar em Hogwarts!" . PHP_EOL;
        $this->enviado = true;
    }

    public function foiEnviado(): bool {
        return $this->enviado;
    }

    public function getAluno(): Aluno {
        return $this->aluno;
    }
}
