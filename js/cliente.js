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
                    "Content-Type": "application/json",
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
        } else {
            mensagem.innerHTML = dados.mensagem || "Falha na autenticação.";
            mensagem.style.color = "red";
        }
    } catch (erro) {
        mensagem.innerHTML = erro.message || "Erro de comunicação com o servidor.";
        mensagem.style.color = "red";
    }
}

async function alterar() {
    const id = document.getElementById("id")?.value ?? "";
    const nome = document.getElementById("nome")?.value ?? "";
    const email = document.getElementById("email")?.value ?? "";
    const senha = document.getElementById("senha")?.value ?? "";
    const endereco = document.getElementById("endereco")?.value ?? "";
    const mensagem = document.getElementById("mensagem");

    if (mensagem) mensagem.innerHTML = "";

    const cliente = {
        id: id,
        nome: nome,
        email: email,
        senha: senha,
        endereco: endereco
    };

    try {
        const resposta = await fetch(
            "http://localhost/Underground-Ring/controladores/rota.php?acao=alterarCliente",
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

        if (resposta.ok && dados.sucesso) {
            localStorage.setItem("dadosCliente", JSON.stringify({
                id: id,
                nome: nome,
                email: email,
                endereco: endereco
            }));

            if (typeof Swal !== "undefined") {
                await Swal.fire({
                    icon: "success",
                    title: "Sucesso!",
                    text: dados.mensagem
                });
            }

            if (dados.redirecionar) {
                window.location.href = dados.redirecionar;
            }
        } else if (mensagem) {
            mensagem.innerHTML = dados.mensagem || "Não foi possível alterar o cliente.";
            mensagem.style.color = "red";
        }
    } catch (erro) {
        if (mensagem) {
            mensagem.innerHTML = erro.message || "Erro de comunicação com o servidor.";
            mensagem.style.color = "red";
        }
    }
}

async function carregarDadosCliente() {
    const mensagem = document.getElementById("mensagem");
    if (mensagem) {
        mensagem.innerHTML = "";
    }

    try {
        const resposta = await fetch(
            "http://localhost/Underground-Ring/controladores/rota.php?acao=buscarPeloIdCliente",
            {
                method: "GET",
                headers: {
                    "Content-Type": "application/json"
                }
            }
        );

        const textoResposta = await resposta.text();
        console.log("Resposta bruta do PHP:", textoResposta);
        const dados = JSON.parse(textoResposta);

        if (resposta.ok && dados.sucesso) {
            localStorage.setItem("dadosCliente", JSON.stringify(dados.dadosCliente));
            preencherFormularioCliente();
        } else if (mensagem) {
            mensagem.innerHTML = dados.mensagem || "Não foi possível carregar os dados do cliente.";
            mensagem.style.color = "red";
        }
    } catch (erro) {
        if (mensagem) {
            mensagem.innerHTML = erro.message || "Erro de comunicação com o servidor.";
            mensagem.style.color = "red";
        }
    }
}

function preencherFormularioCliente() {
    const dadosSalvos = localStorage.getItem("dadosCliente");
    if (!dadosSalvos) return;

    const cliente = JSON.parse(dadosSalvos);

    const campoId = document.getElementById("id");
    const campoNome = document.getElementById("nome");
    const campoEmail = document.getElementById("email");
    const campoEndereco = document.getElementById("endereco");

    if (campoId && cliente.id !== undefined) campoId.value = cliente.id;
    if (campoNome) campoNome.value = cliente.nome || "";
    if (campoEmail) campoEmail.value = cliente.email || "";
    if (campoEndereco) campoEndereco.value = cliente.endereco || "";

    // Caso a página de perfil use spans/elementos de texto com esses IDs:
    const perfilNome = document.getElementById("perfil-nome");
    const perfilEmail = document.getElementById("perfil-email");
    const perfilEndereco = document.getElementById("perfil-endereco");

    if (perfilNome) perfilNome.textContent = cliente.nome || "";
    if (perfilEmail) perfilEmail.textContent = cliente.email || "";
    if (perfilEndereco) perfilEndereco.textContent = cliente.endereco || "";
}

async function excluirCliente() {
    const mensagem = document.getElementById("mensagem");
    if (mensagem) mensagem.innerHTML = "";

    try {
        const resposta = await fetch(
            "http://localhost/Underground-Ring/controladores/rota.php?acao=excluirCliente",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                }
            }
        );

        const textoResposta = await resposta.text();
        const dados = JSON.parse(textoResposta);

        if (resposta.ok && dados.sucesso) {
            localStorage.removeItem("dadosCliente");

            if (typeof Swal !== "undefined") {
                await Swal.fire({
                    icon: "success",
                    title: "Conta excluída!",
                    text: dados.mensagem
                });
            }

            window.location.href = dados.redirecionar || "/Underground-Ring/index.html";
        } else if (mensagem) {
            mensagem.innerHTML = dados.mensagem || "Não foi possível excluir o cliente.";
            mensagem.style.color = "red";
        }
    } catch (erro) {
        if (mensagem) {
            mensagem.innerHTML = erro.message || "Erro de comunicação com o servidor.";
            mensagem.style.color = "red";
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    preencherFormularioCliente();
});