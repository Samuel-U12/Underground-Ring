async function salvarFuncionario() {
    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;

    const funcionario = {
        nome:nome,
        email:email,
        senha:senha
    }
    try{
        const resposta = await fetch(
        "http://localhost/Underground-Ring/controladores/rota.php?acao=salvarFuncionario",{
            method: "POST",
            headers:{
                "Content-Type": "application/json"
            },
            body:JSON.stringify(funcionario)
        });
        const textoResposta = await resposta.text();
        console.log("Resposta bruta do PHP:", textoResposta);

        const dados = JSON.parse(textoResposta);
       
        if(resposta.ok){
            Swal.fire(
                {
                    icon:'success',
                    title:'Sucesso!',
                    text: dados.mensagem
                }
            )
        }  
    }catch(erro){
        //fazer a mesmgem de erro
        const mensagem = document.getElementById("mensagem");
        mensagem.innerHTML = erro.message;
        mensagem.style.color = "red";
        
    }
}

async function autenticar() {
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;
    
    const funcionario = {
        email:email,
        senha:senha
    }
    try{
        const resposta = await fetch(
        "http://localhost/Underground-Ring/controladores/rota.php?acao=autenticarFuncionario",{
            method: "POST",
            headers:{
                "Content-Type": "application/json"
            },
            body:JSON.stringify(funcionario)
        });
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
}
async function alterar() {
    const id = document.getElementById("id").value;
    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;
    const endereco = document.getElementById("endereco").value;
    const mensagem = document.getElementById("mensagem");

    mensagem.innerHTML = "";

    const funcionario = {
        id: id,
        nome: nome,
        email: email,
        endereco: endereco
    };

    try {
        const resposta = await fetch(
            "http://localhost/Underground-Ring/controladores/rota.php?acao=alterarfuncionario",
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
            localStorage.setItem("dadosfuncionario", JSON.stringify({
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
        } else {
            mensagem.innerHTML = dados.mensagem || "Não foi possível alterar o funcionario.";
            mensagem.style.color = "red";
        }
    } catch (erro) {
        mensagem.innerHTML = erro.message || "Erro de comunicação com o servidor.";
        mensagem.style.color = "red";
    }
}

async function carregarDadosfuncionario() {
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
            // Salva o objeto do funcionario no localStorage como string JSON
            localStorage.setItem("dadosfuncionario", JSON.stringify(dados.dadosfuncionario));
            preencherFormulariofuncionario();
        } else if (mensagem) {
            mensagem.innerHTML = dados.mensagem || "Não foi possível carregar os dados do funcionario.";
            mensagem.style.color = "red";
        }
    } catch (erro) {
        if (mensagem) {
            mensagem.innerHTML = erro.message || "Erro de comunicação com o servidor.";
            mensagem.style.color = "red";
        }
    }
}

function preencherFormulariofuncionario() {
    const dadosSalvos = localStorage.getItem("dadosfuncionario");
    if (!dadosSalvos) return;

    const funcionario = JSON.parse(dadosSalvos);

    const campoId = document.getElementById("id");
    const campoNome = document.getElementById("nome");
    const campoEmail = document.getElementById("email");
    const campoEndereco = document.getElementById("endereco");

    if (campoId && funcionario.id !== undefined) campoId.value = funcionario.id;
    if (campoNome) campoNome.value = funcionario.nome || "";
    if (campoEmail) campoEmail.value = funcionario.email || "";
    if (campoEndereco) campoEndereco.value = funcionario.endereco || "";
}

document.addEventListener("DOMContentLoaded", () => {
    // Se já houver algo no localStorage ao abrir a tela do formulário, preenche na hora
    preencherFormulariofuncionario();
});