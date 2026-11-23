async function salvarCliente() {
    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;
    const endereco = document.getElementById("endereco").value;
    const mensagem = document.getElementById("mensagem");

    mensagem.innerHTML = "";

    const cliente = {
        nome: nome,
        email: email,
        senha: senha,
        endereco: endereco
    };

    try {
        const resposta = await fetch(
            "http://localhost/Underground-Ring/controladores/rota.php?acao=salvarCliente",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(cliente)
            }
        );

        const textoResposta = await resposta.text();
        console.log("Resposta bruta do PHP:", textoResposta);

        const dados = JSON.parse(textoResposta);

        if (resposta.ok) {
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: dados.mensagem
            });
        } else {
            mensagem.innerHTML = dados.mensagem || "Não foi possível salvar o cliente.";
            mensagem.style.color = "red";
        }
    } catch (erro) {
        mensagem.innerHTML = erro.message || "Erro de comunicação com o servidor.";
        mensagem.style.color = "red";
    }
}

async function autenticar() {
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;
    const mensagem = document.getElementById("mensagem");

    mensagem.innerHTML = "";

    const autenticarCliente = {
        email: email,
        senha: senha
    };

    try {
        const resposta = await fetch(
            "http://localhost/Underground-Ring/controladores/rota.php?acao=autenticarCliente",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(autenticarCliente)
            }
        );

        const textoResposta = await resposta.text();
        console.log("Resposta bruta do PHP:", textoResposta);

        const dados = JSON.parse(textoResposta);

        if (resposta.ok) {
            if (dados.redirecionar) {
                window.location.href = dados.redirecionar;
            }
        }else {
            mensagem.innerHTML = dados.mensagem || "Falha na autenticação.";
            mensagem.style.color = "red";
        }
    } catch (erro) {
        mensagem.innerHTML = erro.message || "Erro de comunicação com o servidor.";
        mensagem.style.color = "red";
    }
async function alterar(){
        fetch('http://localhost/Underground-Ring/controladores/rota.php?acao=buscarPeloId', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
        })
        .then(response => response.json()) // Transforma a resposta em um objeto JavaScript
        .then(resultado => {
            // Aqui você já tem o objeto pronto para usar!
            if (resultado.sucesso) {
                console.log('Mensagem:', resultado.mensagem);
                console.log('Dados do cliente:', resultado.dadosCliente);
                
                // Exemplo de como acessar uma propriedade do cliente (ex: nome)
                console.log('Nome do cliente:', resultado.dadosCliente.nome);

                // Se quiser redirecionar depois:
                // window.location.href = resultado.redirecionar;
            } else {
                console.error('Erro:', resultado.mensagem);
            }
        })
        .catch(erro => {
            console.error('Erro na requisição:', erro);
        });
        /*Colocar os dados no local estorage*/
    }
}