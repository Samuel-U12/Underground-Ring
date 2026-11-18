<?php
require_once "../conexao/conexao.php";
require_once "../exceptions/ProdutoException.php";
class ImagemServico{
    public function salvarImagem($arquivo){

        if ($arquivo['error'] === UPLOAD_ERR_NO_FILE) {
            throw new ProdutoException("Sem foto.");
        }
        // Verifica se houve erro no upload
        if ($arquivo['error'] !== UPLOAD_ERR_OK) {
            throw new ProdutoException("Erro no upload do arquivo.");
        }

        // Define a pasta de destino
        $pastaDestino = "../imgs/";
        
        // Cria a pasta se ela não existir
        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0755, true);
        }

        // Gera um nome único para evitar sobrescrever arquivos
        $nomeOriginal = $arquivo['name'];
        $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
        $novoNome = uniqid() . "." . $extensao;

        // Extensões permitidas
        $permitidos = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($extensao, $permitidos)) {
            $caminhoCompleto = $pastaDestino . $novoNome;
            
            // Move o arquivo da pasta temporária para o destino final
            if (move_uploaded_file($arquivo['tmp_name'], $caminhoCompleto)) {
                return $caminhoCompleto;
            } else {
                throw new ProdutoException ("Não foi possível mover o arquivo para o destino.");
            }
        } else {
            throw new ProdutoException ("Tipo de arquivo não permitido.");
        }
    }
    public function excluirImagem($produto){
        $caminho = $produto->getFoto_url();
        echo $caminho;
            // 1. Primeiro verificamos se o arquivo realmente existe no servidor
            if (file_exists($caminho)) {
                
                // 2. A função unlink() apaga o arquivo e retorna true (sucesso) ou false (erro)
                if (unlink($caminho)) {
                    echo "Apagada com sucesso";
                } else {
                    throw new ProdutoException("Erro ao tentar apagar a imagem do servidor.");
                }
            } else {
                throw new ProdutoException("Não existe a imagem no servidor");
            }
    }
}

?>