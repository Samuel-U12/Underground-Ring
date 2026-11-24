<?php
require_once "../DTOs/ProdutoDTO.php";
require_once "ProdutoControlador.php";
require_once "../DTOs/FuncionarioDTO.php";
require_once "FuncionarioControlador.php";
require_once "../DTOs/ClienteDTO.php";
require_once "ClienteControlador.php";

$acao = $_GET['acao'] ?? '';

switch ($acao) {
    case 'salvarProduto':
        $produtoDTO = new ProdutoDTO();
        $produtoDTO->nome = $_POST['nome'] ?? '';
        $produtoDTO->quantidade = $_POST['quantidade'] ?? 0;
        $produtoDTO->preco = $_POST['preco'] ?? 0.0;

        // Passa o arquivo $_FILES['foto'] inteiro para o DTO
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
        $produtoControlador = new produtoControlador();
        try {
            $produtoControlador->buscar();
        } catch (PDOException $erro) {
            echo "Erro na base de dados " . $erro->getMessage();
        } catch (Exception $erro) {
            echo "Erro inesperado";
        }
        header('Location:../telas/mostrarProdutos.php');
        break;

    case 'excluirProduto':
        $id = $_GET['id'];
        $produtoControlador = new ProdutoControlador();
        try {
            $produtoControlador->excluir($id);
        } catch (Exception $erro) {
            echo "Erro: " . $erro->getMessage();
        }
        header('Location:rota.php?acao=buscarProduto');
        break;

    case 'buscarProdutoPorId':
        $id = $_GET['id'];
        try {
            $produtoControlador = new produtoControlador();
            $produtoControlador = $produtoControlador->buscarPeloId($id);
            header('Location:../telas/formAlterarProduto.php');
        } catch (PDOException $erro) {
            echo $erro->getMessage();
        }
        break;

    case 'alterarProduto':
        $produtoDTO = new ProdutoDTO();
        $produtoDTO->id = $_POST['id'];
        $produtoDTO->nome = $_POST['nome'];
        $produtoDTO->quantidade = $_POST['quantidade'];
        $produtoDTO->preco = $_POST['preco'];
        $produtoControlador = new produtoControlador();
        try {
            $produtoControlador->alterar($produtoDTO);
            header('Location:rota.php?acao=buscarProduto');
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
        } catch (PDOException $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        } catch (Exception $erro) {
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
        $clienteDTO->email = $dados->email;
        $clienteDTO->senha = $dados->senha;

        $clienteControlador = new ClienteControlador();

        try {
            $cliente = $clienteControlador->autenticarCliente($clienteDTO);
            session_start();
            $_SESSION['cliente'] = $cliente;
            http_response_code(200);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Apagado com sucesso',
                'redirecionar' => '/Underground-Ring/telas/homeC.php'
            ]);
        } catch (PDOException $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        } catch (Exception $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        }
        break;
    case 'excluirCliente':
        session_start();
        $cliente = $_SESSION['cliente'] ?? null;

        $clienteControlador = new ClienteControlador();

        try {
            $clienteControlador->excluirCliente($cliente);
            http_response_code(201);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Cliente excluido com sucesso'
                'redirecionar' => '/Underground-Ring/index.html'
            ]);
        } catch (PDOException $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        } catch (Exception $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        }
        break;
    case 'buscarPeloId':
        session_start();
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
            // Garanta que ClienteControlador::buscarPeloId() e ClienteDAO::buscarPeloId() existam e retornem os dados do cliente
            $clienteAlterar = $clienteControlador->buscarPeloId($cliente->getId());

            http_response_code(200);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Dados do cliente carregados com sucesso.',
                'dadosCliente' => $clienteAlterar
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
        $clienteDTO->nome = $dados->nome;
        $clienteDTO->email = $dados->email;
        $clienteDTO->senha = $dados->senha;
        $clienteDTO->endereco= $dados->endereco

        $clienteControlador = new ClienteControlador();

        try {
            $clienteControlador->alterarCliente($clienteDTO);
            http_response_code(201);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Cliente alterado com sucesso'
                'redirecionar' => '/Underground-Ring/telas/homeC.php'
            ]);
        } catch (PDOException $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        } catch (Exception $erro) {
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
            $funcionario = $funcionarioControlador->salvarFuncionario($funcionarioDTO);
            http_response_code(201);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Funcionario cadastrado com sucesso'
            ]);
        } catch (PDOException $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        } catch (Exception $erro) {
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
            session_start();
            $_SESSION['funcionario'] = $funcionario;
            http_response_code(200);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Autenticado com sucesso',
                'redirecionar' => '/Underground-Ring/telas/homeF.php'
            ]);
        } catch (PDOException $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        } catch (Exception $erro) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $erro->getMessage()
            ]);
        }
        break;
}