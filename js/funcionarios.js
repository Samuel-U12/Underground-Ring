async function salvarFuncionario() {
    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;

    const funcionario = {
        nome: nome,
        email: email,
        senha: senha
    };
    try {
        const resposta = await fetch(
            "http://localhost/Underground-Ring/controladores/rota.php?acao=salvarFuncionario",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(funcionario)
            }
        );
        const textoResposta = await resposta.text();
        console.log("Resposta bruta do PHP:", textoResposta);

        const dados = JSON.parse(textoResposta);

        if (resposta.ok) {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: dados.mensagem
            });
        }
    } catch (erro) {
        const mensagem = document.getElementById("mensagem");
        if (mensagem) {
            mensagem.innerHTML = erro.message;
            mensagem.style.color = "red";
        }
    }
}

async function autenticar() {
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;
    const mensagem = document.getElementById("mensagem");

    const funcionario = {
        email: email,
        senha: senha
    };
    try {
        const resposta = await fetch(
            "http://localhost/Underground-Ring/controladores/rota.php?acao=autenticarFuncionario",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(funcionario)
            }
        );
        const textoResposta = await resposta.text();
        console.log("Resposta bruta do PHP:", textoResposta);

        const dados = JSON.parse(textoResposta);

        if (resposta.ok) {
            if (dados.redirecionar) {
                window.location.href = dados.redirecionar;
            }
        } else if (mensagem) {
            mensagem.innerHTML = dados.mensagem || "Falha na autenticação.";
            mensagem.style.color = "red";
        }
    } catch (erro) {
        if (mensagem) {
            mensagem.innerHTML = erro.message || "Erro de comunicação com o servidor.";
            mensagem.style.color = "red";
        }
    }
}

async function alterar() {
    const id = document.getElementById("id")?.value ?? "";
    const nome = document.getElementById("nome")?.value ?? "";
    const email = document.getElementById("email")?.value ?? "";
    const senha = document.getElementById("senha")?.value ?? "";
    const mensagem = document.getElementById("mensagem");

    if (mensagem) mensagem.innerHTML = "";

    const funcionario = {
        id: id,
        nome: nome,
        email: email,
        senha: senha
    };

    try {
        const resposta = await fetch(
            "http://localhost/Underground-Ring/controladores/rota.php?acao=alterarFuncionario",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(funcionario)
            }
        );

        const textoResposta = await resposta.text();
        console.log("Resposta bruta do PHP:", textoResposta);

        const dados = JSON.parse(textoResposta);

        if (resposta.ok && dados.sucesso) {
            localStorage.setItem("dadosFuncionario", JSON.stringify({
                id: id,
                nome: nome,
                email: email
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
            mensagem.innerHTML = dados.mensagem || "Não foi possível alterar o funcionário.";
            mensagem.style.color = "red";
        }
    } catch (erro) {
        if (mensagem) {
            mensagem.innerHTML = erro.message || "Erro de comunicação com o servidor.";
            mensagem.style.color = "red";
        }
    }
}

async function carregarDadosFuncionario() {
    const mensagem = document.getElementById("mensagem");
    if (mensagem) {
        mensagem.innerHTML = "";
    }

    try {
        const resposta = await fetch(
            "http://localhost/Underground-Ring/controladores/rota.php?acao=buscarPeloIdFuncionario",
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
            localStorage.setItem("dadosFuncionario", JSON.stringify(dados.dadosFuncionario));
            preencherFormularioFuncionario();
        } else if (mensagem) {
            mensagem.innerHTML = dados.mensagem || "Não foi possível carregar os dados do funcionário.";
            mensagem.style.color = "red";
        }
    } catch (erro) {
        if (mensagem) {
            mensagem.innerHTML = erro.message || "Erro de comunicação com o servidor.";
            mensagem.style.color = "red";
        }
    }
}

function preencherFormularioFuncionario() {
    const dadosSalvos = localStorage.getItem("dadosFuncionario");
    if (!dadosSalvos) return;

    const funcionario = JSON.parse(dadosSalvos);

    const campoId = document.getElementById("id");
    const campoNome = document.getElementById("nome");
    const campoEmail = document.getElementById("email");

    if (campoId && funcionario.id !== undefined) campoId.value = funcionario.id;
    if (campoNome) campoNome.value = funcionario.nome || "";
    if (campoEmail) campoEmail.value = funcionario.email || "";

    // Caso a página de perfil use spans/elementos de texto com esses IDs:
    const perfilNome = document.getElementById("perfil-nome");
    const perfilEmail = document.getElementById("perfil-email");

    if (perfilNome) perfilNome.textContent = funcionario.nome || "";
    if (perfilEmail) perfilEmail.textContent = funcionario.email || "";
}

async function excluirFuncionario() {
    const mensagem = document.getElementById("mensagem");
    if (mensagem) mensagem.innerHTML = "";

    try {
        const resposta = await fetch(
            "http://localhost/Underground-Ring/controladores/rota.php?acao=excluirFuncionario",
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
            localStorage.removeItem("dadosFuncionario");

            if (typeof Swal !== "undefined") {
                await Swal.fire({
                    icon: "success",
                    title: "Conta excluída!",
                    text: dados.mensagem
                });
            }

            window.location.href = dados.redirecionar || "/Underground-Ring/index.html";
        } else if (mensagem) {
            mensagem.innerHTML = dados.mensagem || "Não foi possível excluir o funcionário.";
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
    preencherFormularioFuncionario();
});