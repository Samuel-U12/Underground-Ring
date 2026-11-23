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
            "http://localhost/agenda/controladores/rota.php?acao=salvarCliente",
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

        /*const dados = await resposta.json();

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
    }*/
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
            "http://localhost/agenda/controladores/rota.php?acao=autenticarCliente",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(autenticarCliente)
            }
        );

        const dados = await resposta.json();

        if (resposta.ok) {
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: dados.mensagem
            }).then(() => {
                if (dados.redirecionar) {
                    window.location.href = dados.redirecionar;
                }
            });
        } else {
            mensagem.innerHTML = dados.mensagem || "Falha na autenticação.";
            mensagem.style.color = "red";
        }
    } catch (erro) {
        mensagem.innerHTML = erro.message || "Erro de comunicação com o servidor.";
        mensagem.style.color = "red";
    }
}