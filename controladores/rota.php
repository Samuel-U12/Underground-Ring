<?php
require_once "../DTOs/ProdutoDTO.php";
require_once "ProdutoControlador.php";
require_once "../DTOs/FuncionarioDTO.php";
require_once "FuncionarioControlador.php";
require_once "../DTOs/ClienteDTO.php";
require_once "ClienteControlador.php";

$acao = $_GET['acao'] ?? '';

function exigirFuncionario(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['funcionario'])) {
        header('Location: ../telas/autenticarFuncionario.html');
        exit;
    }
}

switch ($acao) {
    case 'salvarProduto':
        exigirFuncionario();

        $produtoDTO = new ProdutoDTO();
        $produtoDTO->nome = $_POST['nome'] ?? '';
        $produtoDTO->quantidade = $_POST['quantidade'] ?? 0;
        $produtoDTO->preco = $_POST['preco'] ?? 0.0;
        $produtoDTO->foto = $_FILES['foto'] ?? null;

        $produtoControlador = new produtoControlador();
        try {
            $produtoControlador->salvar($produtoDTO);
        } catch (PDOException $erro) {
            echo "Erro na base de dados " . $erro->getMessage();
            exit;
        } catch (Exception $erro) {
            echo "Erro inesperado: " . $erro->getMessage();
            exit;
        }

        header("Location: ../telas/cadastrarProduto.html");
        break;

    case 'buscarProduto':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['cliente']) && !isset($_SESSION['funcionario'])) {
            header('Location: ../index.html');
            exit;
        }

        $produtoControlador = new produtoControlador();
        try {
            $produtoControlador->buscar();
        } catch (PDOException $erro) {
            echo "Erro na base de dados " . $erro->getMessage();
            exit;
        } catch (Exception $erro) {
            echo "Erro inesperado";
            exit;
        }
        header('Location: ../telas/mostrarProdutos.php');
        break;

    case 'excluirProduto':
        exigirFuncionario();

        $id = $_GET['id'] ?? 0;
        $produtoControlador = new ProdutoControlador();
        try {
            $produtoControlador->excluir($id);
        } catch (Exception $erro) {
            echo "Erro: " . $erro->getMessage();
            exit;
        }
        header('Location: rota.php?acao=buscarProduto');
        break;

    case 'buscarProdutoPorId':
        exigirFuncionario();

        $id = $_GET['id'] ?? 0;
        try {
            $produtoControlador = new produtoControlador();
            $produtoControlador->buscarPeloId($id);
            header('Location: ../telas/formAlterarProduto.php');
        } catch (PDOException $erro) {
            echo $erro->getMessage();
        }
        break;

    case 'alterarProduto':
        exigirFuncionario();

        $produtoDTO = new ProdutoDTO();
        $produtoDTO->id = $_POST['id'] ?? 0;
        $produtoDTO->nome = $_POST['nome'] ?? '';
        $produtoDTO->quantidade = $_POST['quantidade'] ?? 0;
        $produtoDTO->preco = $_POST['preco'] ?? 0.0;
        $produtoControlador = new produtoControlador();
        try {
            $produtoControlador->alterar($produtoDTO);
            header('Location: rota.php?acao=buscarProduto');
        } catch (PDOException $erro) {
            echo "Erro na base de dados " . $erro->getMessage();
        } catch (Exception $erro) {
            echo "Erro inesperado";
        }
        break;

    case 'salvarCliente':
        $dados = json_decode(file_get_contents("php://input"));

        $clienteDTO = new ClienteDTO();
        $clienteDTO->nome = $dados->nome ?? '';
        $clienteDTO->email = $dados->email ?? '';
        $clienteDTO->senha = $dados->senha ?? '';
        $clienteDTO->endereco = $dados->endereco ?? '';

        $clienteControlador = new ClienteControlador();

        try {
            $clienteControlador->salvarCliente($clienteDTO);
            http_response_code(201);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Cliente cadastrado com sucesso'
            ]);
        } catch (PDOException | Exception $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        }
        break;

    case 'autenticarCliente':
        $dados = json_decode(file_get_contents("php://input"));

        $clienteDTO = new ClienteDTO();
        $clienteDTO->email = $dados->email ?? '';
        $clienteDTO->senha = $dados->senha ?? '';

        $clienteControlador = new ClienteControlador();

        try {
            $cliente = $clienteControlador->autenticarCliente($clienteDTO);
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['cliente'] = $cliente;
            http_response_code(200);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Cliente fez login com sucesso',
                'redirecionar' => '/Underground-Ring/telas/homeC.php'
            ]);
        } catch (PDOException | Exception $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        }
        break;

    case 'buscarPeloIdCliente':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $cliente = $_SESSION['cliente'] ?? null;

        if (!$cliente) {
            http_response_code(401);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'Sessão do cliente não encontrada.'
            ]);
            break;
        }

        $clienteControlador = new ClienteControlador();
        try {
            $clienteAlterar = $clienteControlador->buscarPeloIdCliente($cliente);

            http_response_code(200);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Dados do cliente carregados com sucesso.',
                'dadosCliente' => [
                    'id' => $clienteAlterar->getId(),
                    'nome' => $clienteAlterar->getNome(),
                    'email' => $clienteAlterar->getEmail(),
                    'endereco' => $clienteAlterar->getEndereco()
                ]
            ]);
        } catch (PDOException | Exception $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        }
        break;

    case 'alterarCliente':
        $dados = json_decode(file_get_contents("php://input"));

        $clienteDTO = new ClienteDTO();
        $clienteDTO->id = $dados->id ?? null;
        $clienteDTO->nome = $dados->nome ?? '';
        $clienteDTO->email = $dados->email ?? '';
        $clienteDTO->senha = $dados->senha ?? '';
        $clienteDTO->endereco = $dados->endereco ?? '';

        $clienteControlador = new ClienteControlador();

        try {
            $clienteControlador->alterarCliente($clienteDTO);
            http_response_code(200);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Cliente alterado com sucesso',
                'redirecionar' => '/Underground-Ring/telas/perfilCliente.html'
            ]);
        } catch (PDOException | Exception $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        }
        break;

    case 'excluirCliente':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $cliente = $_SESSION['cliente'] ?? null;

        if (!$cliente) {
            http_response_code(401);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'Sessão do cliente não encontrada.'
            ]);
            break;
        }

        $clienteControlador = new ClienteControlador();

        try {
            $clienteControlador->excluirCliente($cliente);
            session_unset();
            session_destroy();

            http_response_code(200);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Cliente excluído com sucesso',
                'redirecionar' => '/Underground-Ring/index.html'
            ]);
        } catch (PDOException | Exception $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        }
        break;

    case 'salvarFuncionario':
        $dados = json_decode(file_get_contents("php://input"));

        $funcionarioDTO = new FuncionarioDTO();
        $funcionarioDTO->nome = $dados->nome ?? '';
        $funcionarioDTO->email = $dados->email ?? '';
        $funcionarioDTO->senha = $dados->senha ?? '';

        $funcionarioControlador = new FuncionarioControlador();

        try {
            $funcionarioControlador->salvarFuncionario($funcionarioDTO);
            http_response_code(201);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Funcionário cadastrado com sucesso'
            ]);
        } catch (PDOException | Exception $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        }
        break;

    case 'autenticarFuncionario':
        $dados = json_decode(file_get_contents("php://input"));

        $funcionarioDTO = new FuncionarioDTO();
        $funcionarioDTO->email = $dados->email ?? '';
        $funcionarioDTO->senha = $dados->senha ?? '';

        $funcionarioControlador = new FuncionarioControlador();

        try {
            $funcionario = $funcionarioControlador->autenticarFuncionario($funcionarioDTO);
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['funcionario'] = $funcionario;
            http_response_code(200);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Autenticado com sucesso',
                'redirecionar' => '/Underground-Ring/telas/homeF.php'
            ]);
        } catch (PDOException | Exception $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        }
        break;

    case 'buscarPeloIdFuncionario':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $funcionario = $_SESSION['funcionario'] ?? null;

        if (!$funcionario) {
            http_response_code(401);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'Sessão do funcionário não encontrada.'
            ]);
            break;
        }

        $funcionarioControlador = new FuncionarioControlador();
        try {
            $funcionarioAlterar = $funcionarioControlador->buscarPeloIdFuncionario($funcionario);

            http_response_code(200);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Dados do funcionário carregados com sucesso.',
                'dadosFuncionario' => [
                    'id' => $funcionarioAlterar->getId(),
                    'nome' => $funcionarioAlterar->getNome(),
                    'email' => $funcionarioAlterar->getEmail()
                ]
            ]);
        } catch (PDOException | Exception $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        }
        break;

    case 'alterarFuncionario':
        $dados = json_decode(file_get_contents("php://input"));

        $funcionarioDTO = new FuncionarioDTO();
        $funcionarioDTO->id = $dados->id ?? null;
        $funcionarioDTO->nome = $dados->nome ?? '';
        $funcionarioDTO->email = $dados->email ?? '';
        $funcionarioDTO->senha = $dados->senha ?? '';

        $funcionarioControlador = new FuncionarioControlador();

        try {
            $funcionarioControlador->alterarFuncionario($funcionarioDTO);
            http_response_code(200);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Funcionário alterado com sucesso',
                'redirecionar' => '/Underground-Ring/telas/perfilFuncionarios.html'
            ]);
        } catch (PDOException | Exception $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        }
        break;

    case 'excluirFuncionario':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $funcionario = $_SESSION['funcionario'] ?? null;

        if (!$funcionario) {
            http_response_code(401);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'Sessão do funcionário não encontrada.'
            ]);
            break;
        }

        $funcionarioControlador = new FuncionarioControlador();

        try {
            $funcionarioControlador->excluirFuncionario($funcionario);
            session_unset();
            session_destroy();

            http_response_code(200);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Funcionário excluído com sucesso',
                'redirecionar' => '/Underground-Ring/index.html'
            ]);
        } catch (PDOException | Exception $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        }
        break;

    case 'verTodosClientes':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['funcionario'])) {
            http_response_code(401);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'Acesso restrito a funcionários.'
            ]);
            break;
        }

        $clienteControlador = new ClienteControlador();
        try {
            $clientes = $clienteControlador->buscarTodosClientes();
            $lista = [];
            foreach ($clientes as $c) {
                $lista[] = [
                    'id' => $c->getId(),
                    'nome' => $c->getNome(),
                    'email' => $c->getEmail(),
                    'endereco' => $c->getEndereco()
                ];
            }

            http_response_code(200);
            echo json_encode([
                'sucesso' => true,
                'clientes' => $lista
            ]);
        } catch (PDOException | Exception $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        }
        break;
}