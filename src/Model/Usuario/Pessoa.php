<?php
namespace App\Model\Usuario;

abstract class Pessoa
{
    protected string $nome;
    protected string $email;

    public function __construct(string $nome, string $email)
    {
        $this->nome = $nome;
        $this->email = $email;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}

