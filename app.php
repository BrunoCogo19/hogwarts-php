<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Model\ConviteCadastro\{Aluno, Convite, ConviteRepository};
use App\Model\SelecaoCasas\{Casa, ChapeuSeletor};
use App\Model\Torneios\{Torneio, Desafio, Inscricao, TorneioRepository, Ranking};
use App\Model\Academico\{Comportamento, ComportamentoRepository, Cronograma, Disciplina, Nota, NotaRepository, Professor, ProfessorRepository, Turma};
use App\Model\Comunicacao\{Mensagem, MensagemRepository};

// Instâncias iniciais
$alunos = [];
$repoConvites = new ConviteRepository();
$repoTorneios = new TorneioRepository();
$inscricoes = [];
$repoComportamento = new ComportamentoRepository();
$repoNotas = new NotaRepository();
$cronograma = new Cronograma();
$repoProfessores = new ProfessorRepository();
$repoMensagens = new MensagemRepository();


// Loop principal
while (true) {
    echo "\n✨ Bem-vindo ao Sistema de Hogwarts!\n";
    echo "1. Diretor\n2. Administrador\n3. Aluno\n4. Professor\n0. Sair\nEscolha seu perfil: ";
    $perfil = trim(fgets(STDIN));

    if ($perfil === "0") {
        echo "Saindo... Até logo!\n";
        break;
    }

    switch ($perfil) {

        case "1": // Diretor
            echo "\n🔧 Menu do Diretor:\n";
            echo "1. Cerimônia do Chapéu Seletor\n";
            echo "2. Ranking por Casa\n";
            echo "Opção: ";
            $op = trim(fgets(STDIN));

            if ($op === "1") { // Executar cerimônia do Chapéu Seletor
                foreach ($alunos as $aluno) {
                    if ($aluno->getCasa() === null && $aluno->recebeuCarta()) {
                        $casa = ChapeuSeletor::sortearCasa($aluno);
                        $aluno->setCasa($casa);
                        echo "🎩 {$aluno->getNome()} foi selecionado para a casa {$casa->value}.\n";
                    }
                }
            } elseif ($op === "2") {
                $ranking = Ranking::calcularPorCasa($inscricoes, $repoComportamento);
                echo "\n🏆 Ranking por Casa:\n";
                foreach ($ranking as $casa => $pontos) {
                    echo "- {$casa}: {$pontos} pontos\n";
                }
            }
            break;

        case "2": // ADMINISTRADOR
            echo "\n🔧 Menu do Administrador:\n";
            echo "1. Cadastrar novo aluno pré-selecionado\n";
            echo "2. Enviar cartas\n";
            echo "3. Ver convites confirmados\n";
            echo "4. Visualizar distribuição por casa\n";
            echo "5. Criar Torneio\n";
            echo "6. Lançar Pontuações\n";
            echo "7. Aplicar bônus/penalidade\n";
            echo "8. Cadastro de Professores\n";
            echo "9. Agendar ou enviar Mensagem\n";
            echo "Opção: ";
            $op = trim(fgets(STDIN));

            if ($op === "1") {
                echo "Nome do aluno: ";
                $nome = trim(fgets(STDIN));

                echo "Email do aluno: ";
                $email = trim(fgets(STDIN));

                echo "Data de nascimento (YYYY-MM-DD): ";
                $dataNascimento = trim(fgets(STDIN));

                echo "Característica principal do aluno (ex: coragem, ambição, inteligência, lealdade): ";
                $caracteristica = trim(fgets(STDIN));

                $aluno = new Aluno($nome, $email, $dataNascimento);
                $aluno->definirCaracteristicas([$caracteristica]);
                $alunos[] = $aluno;

                echo "✅ Aluno cadastrado com sucesso!\n";
            } elseif ($op === "2") {
                foreach ($alunos as $aluno) {
                    if ($aluno->temIdadeMinima()) {
                        $convite = new Convite($aluno);
                        $convite->enviar();
                        $repoConvites->adicionar($convite);
                    }
                }
                echo "✅ Cartas enviadas!\n";
            } elseif ($op === "3") {
                $confirmados = $repoConvites->listarConfirmados();
                echo "\n📬 Alunos que confirmaram recebimento:\n";
                foreach ($confirmados as $convite) {
                    echo "- " . $convite->getAluno()->getNome() . "\n";
                }
            } elseif ($op === "4") { // Visualizar distribuição por casa
                $distribuicao = [
                    'Grifinória' => 0,
                    'Sonserina' => 0,
                    'Corvinal' => 0,
                    'Lufa-Lufa' => 0
                ];

                foreach ($alunos as $aluno) {
                    if ($aluno->getCasa()) {
                        $distribuicao[$aluno->getCasa()->value]++;
                    }
                }

                echo "\n🏠 Distribuição de alunos por casa:\n";
                foreach ($distribuicao as $casa => $quantidade) {
                    echo "- {$casa}: {$quantidade} aluno(s)\n";
                }
            } elseif ($op === "5") {
                echo "Nome do torneio: ";
                $nome = trim(fgets(STDIN));
                echo "Tipo: ";
                $tipo = trim(fgets(STDIN));
                echo "Regras: ";
                $regras = trim(fgets(STDIN));
                echo "Local: ";
                $local = trim(fgets(STDIN));
                echo "Data: ";
                $data = trim(fgets(STDIN));
                $torneio = new Torneio($nome, $tipo, $regras, $local, $data);

                echo "Quantos desafios terá este torneio? ";
                $qtdDesafios = (int)trim(fgets(STDIN));
                for ($i = 0; $i < $qtdDesafios; $i++) {
                    echo "Descrição do desafio " . ($i + 1) . ": ";
                    $desc = trim(fgets(STDIN));
                    echo "Pontuação máxima: ";
                    $max = (int)trim(fgets(STDIN));
                    $torneio->adicionarDesafio(new Desafio($desc, $max));
                }

                $repoTorneios->adicionar($torneio);
                echo "✅ Torneio criado com sucesso!\n";
            } elseif ($op === "6") {
                echo "Digite o nome do aluno a pontuar: ";
                $nome = trim(fgets(STDIN));

                echo "Digite o nome do torneio: ";
                $nomeTorneio = trim(fgets(STDIN));
                $torneio = $repoTorneios->buscarPorNome($nomeTorneio);

                if ($torneio) {
                    foreach ($inscricoes as $inscricao) {
                        if (
                            strtolower($inscricao->getAluno()->getNome()) === strtolower($nome) &&
                            in_array($inscricao->getDesafio(), $torneio->getDesafios(), true)
                        ) {
                            echo "Desafio: " . $inscricao->getDesafio()->getDescricao() . " (máximo: " . $inscricao->getDesafio()->getPontuacaoMaxima() . ")\n";
                            echo "Pontuação obtida pelo aluno: ";
                            $pontuacao = (int)trim(fgets(STDIN));
                            $inscricao->registrarPontuacao($pontuacao);
                        }
                    }
                    echo "✅ Pontuação registrada!\n";
                } else {
                    echo "❌ Torneio não encontrado.\n";
                }
            } elseif ($op === "7") {
                echo "Digite o nome do aluno para registrar comportamento: ";
                $nomeAluno = trim(fgets(STDIN));

                $aluno = null;
                foreach ($alunos as $a) {
                    if (strtolower($a->getNome()) === strtolower($nomeAluno)) {
                        $aluno = $a;
                        break;
                    }
                }

                if ($aluno) {
                    echo "Motivo do registro (ex: mérito por boa ação, punição por bagunça): ";
                    $motivo = trim(fgets(STDIN));

                    echo "Pontos (use negativo para penalidade): ";
                    $pontos = (int)trim(fgets(STDIN));

                    $registro = new \App\Model\Academico\Comportamento($aluno, $motivo, $pontos);
                    $repoComportamento->adicionar($registro);

                    echo "✅ Registro de comportamento salvo!\n";
                } else {
                    echo "❌ Aluno não encontrado.\n";
                }
            }
            if ($op === "8") {
                echo "Nome do professor: ";
                $nomeProfessor = trim(fgets(STDIN));

                echo "E-mail do professor: ";
                $emailProfessor = trim(fgets(STDIN));

                $professor = new Professor($nomeProfessor, $emailProfessor);

                echo "Quantas disciplinas ele ministra? ";
                $qtdDisciplinas = (int)trim(fgets(STDIN));
                for ($i = 0; $i < $qtdDisciplinas; $i++) {
                    echo "Nome da disciplina #" . ($i + 1) . ": ";
                    $professor->adicionarDisciplina(trim(fgets(STDIN)));
                }

                echo "Quantas turmas ele ministra? ";
                $qtdTurmas = (int)trim(fgets(STDIN));
                for ($i = 0; $i < $qtdTurmas; $i++) {
                    echo "Nome da turma #" . ($i + 1) . ": ";
                    $professor->adicionarTurma(trim(fgets(STDIN)));
                }

                $repoProfessores->adicionar($professor);
                echo "✅ Professor cadastrado com sucesso!\n";
            }
            if ($op === "9") {
                echo "\n📢 Enviar/Avisar (Administrador):\n";
                echo "Título da mensagem: ";
                $titulo = trim(fgets(STDIN));

                echo "Conteúdo: ";
                $conteudo = trim(fgets(STDIN));

                echo "Destinatários (separe por vírgula): ";
                $destinatarios = array_map('trim', explode(',', fgets(STDIN)));

                echo "Deseja agendar para uma data futura? (s = sim / qualquer tecla = agora): ";
                $agendar = trim(fgets(STDIN));
                $dataEnvio = null;

                if (strtolower($agendar) === 's') {
                    echo "Informe a data no formato YYYY-MM-DD HH:MM: ";
                    $dataEnvio = trim(fgets(STDIN));
                }

                $msg = new Mensagem($titulo, $conteudo, 'Administrador', $destinatarios, $dataEnvio);
                $repoMensagens->adicionar($msg);

                echo "✅ Mensagem registrada com sucesso!\n";
            }

            break;

        case "3": // ALUNO
            echo "Digite seu nome: ";
            $nomeAluno = trim(fgets(STDIN));

            $alunoLogado = null;
            foreach ($alunos as $aluno) {
                if (strtolower($aluno->getNome()) === strtolower($nomeAluno)) {
                    $alunoLogado = $aluno;
                    break;
                }
            }

            if ($alunoLogado) {
                echo "\n🎓 Bem-vindo, {$alunoLogado->getNome()}!\n";

                echo "\n📚 Menu do Aluno:\n";
                echo "1. Ver carta e confirmar recebimento\n";
                echo "2. Inscrever-se em torneio\n";
                echo "3. Ver Boletim\n";
                echo "4. Ver Notificações\n";
                echo "0. Sair\n";
                echo "Escolha uma opção: ";
                $opcaoAluno = trim(fgets(STDIN));

                switch ($opcaoAluno) {
                    case "1":
                        echo "\n📜 Escola de Magia e Bruxaria de Hogwarts\n";
                        echo "Prezado(a) {$alunoLogado->getNome()},\n";
                        echo "Temos o prazer de informar que você foi aceito na Escola de Magia e Bruxaria de Hogwarts.\n";
                        echo "Pedimos que compareça com todos os materiais listados.\n";
                        echo "Entre os itens obrigatórios estão: uma varinha mágica, um caldeirão e uma coruja para correspondência.\n";
                        echo "Aguardamos ansiosamente sua chegada ao Expresso de Hogwarts, na Plataforma 9¾.\n";
                        echo "Por favor, confirme o recebimento para garantir sua participação.\n";

                        if (!$alunoLogado->recebeuCarta()) {
                            echo "\nDeseja confirmar o recebimento? (1 = Sim / 0 = Não): ";
                            $confirmar = trim(fgets(STDIN));
                            if ($confirmar === "1") {
                                $alunoLogado->confirmarRecebimento();
                                echo "✅ Recebimento confirmado! Bem-vindo(a) a Hogwarts!\n";
                            } else {
                                echo "⚠️ Recebimento não confirmado.\n";
                            }
                        } else {
                            echo "✅ Você já confirmou o recebimento da carta.\n";
                        }
                        break;

                    case "2":
                        echo "\n🏆 Torneios disponíveis:\n";
                        foreach ($repoTorneios->listarTodos() as $torneio) {
                            echo "- " . $torneio->getNome() . " (" . $torneio->getTipo() . ")\n";
                        }

                        echo "Digite o nome do torneio que deseja se inscrever: ";
                        $nomeTorneio = trim(fgets(STDIN));
                        $torneio = $repoTorneios->buscarPorNome($nomeTorneio);

                        if ($torneio) {
                            foreach ($torneio->getDesafios() as $desafio) {
                                $inscricao = new Inscricao($alunoLogado, $desafio);
                                $inscricoes[] = $inscricao;
                            }
                            echo "✅ Inscrição realizada! Aguarde a avaliação de desempenho.\n";
                        } else {
                            echo "❌ Torneio não encontrado.\n";
                        }
                        break;
                    case "3":
                        $boletim = $repoNotas->boletimPorAluno($alunoLogado->getNome());

                        echo "\n📊 Boletim de {$alunoLogado->getNome()}:\n";
                        if (empty($boletim)) {
                            echo "Nenhuma nota registrada.\n";
                        } else {
                            foreach ($boletim as $nota) {
                                echo "- " . $nota->getDisciplina()->getNome() . ": " . $nota->getNota() . "\n";
                            }
                        }
                        break;
                    case "4":
                        echo "\n📨 Suas mensagens:\n";
                        $msgs = $repoMensagens->listarParaDestinatario($alunoLogado->getNome());

                        if (empty($msgs)) {
                            echo "Nenhuma mensagem encontrada.\n";
                        } else {
                            foreach ($msgs as $m) {
                                echo "\n📬 " . $m->getTitulo() . "\n";
                                echo "🗓️ " . $m->getDataEnvio()->format('d/m/Y H:i') . "\n";
                                echo "De: " . $m->getEmissor() . "\n";
                                echo $m->getConteudo() . "\n";
                            }
                        }
                        break;
                    case "0":
                        echo "👋 Saindo do menu do aluno...\n";
                        break;

                    default:
                        echo "❌ Opção inválida!\n";
                        break;
                }
            } else {
                echo "❌ Aluno não encontrado.\n";
            }
            break;
        case "4": // PROFESSOR
            echo "Digite seu nome, professor: ";
            $nomeProfessor = trim(fgets(STDIN));
            $professor = $repoProfessores->buscarPorNome($nomeProfessor);

            if (!$professor) {
                echo "❌ Professor não encontrado.\n";
                break;
            }

            echo "\n📘 Menu do Professor:\n";
            echo "1. Registrar nota de aluno\n";
            echo "2. Ver cronograma de aulas\n";
            echo "3. Adicionar aula ao cronograma\n";
            echo "4. Enviar alerta\n";
            echo "Opção: ";
            $op = trim(fgets(STDIN));

            if ($op === "1") {
                echo "Nome do aluno: ";
                $nomeAluno = trim(fgets(STDIN));

                $aluno = null;
                foreach ($alunos as $a) {
                    if (strtolower($a->getNome()) === strtolower($nomeAluno)) {
                        $aluno = $a;
                        break;
                    }
                }

                if ($aluno) {
                    echo "Nome da disciplina: ";
                    $nomeDisciplina = trim(fgets(STDIN));

                    echo "Nota (0 a 10): ";
                    $valorNota = (float)trim(fgets(STDIN));

                    $disciplina = new \App\Model\Academico\Disciplina($nomeDisciplina);
                    $nota = new \App\Model\Academico\Nota($aluno, $disciplina, $valorNota);
                    $repoNotas->adicionar($nota);

                    echo "✅ Nota registrada com sucesso!\n";
                } else {
                    echo "❌ Aluno não encontrado.\n";
                }
            } elseif ($op === "2") {
                echo "\n🗓️ Seu Cronograma de Aulas:\n";
                $professor->getCronograma()->exibir();
            } elseif ($op === "3") {
                echo "Dia da semana: ";
                $dia = trim(fgets(STDIN));

                echo "Horário (ex: 14:00): ";
                $hora = trim(fgets(STDIN));

                echo "Nome da disciplina: ";
                $disciplina = trim(fgets(STDIN));

                echo "Turma: ";
                $turma = trim(fgets(STDIN));

                $professor->getCronograma()->adicionarHorario($dia, $hora, $disciplina, $turma);
                echo "✅ Aula adicionada ao cronograma com sucesso!\n";
            } elseif ($op === "4") {
                echo "Título do aviso: ";
                $titulo = trim(fgets(STDIN));
                echo "Conteúdo do aviso: ";
                $conteudo = trim(fgets(STDIN));

                echo "Destinatários (nomes separados por vírgula): ";
                $destinatarios = array_map('trim', explode(',', fgets(STDIN)));

                $mensagem = new Mensagem($titulo, $conteudo, $professor->getNome(), $destinatarios);
                $repoMensagens->adicionar($mensagem);

                echo "✅ Aviso enviado!\n";
            }


            break;
    }
}
