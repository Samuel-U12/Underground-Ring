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