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
        "http://localhost/agenda/controladores/rota.php?acao=salvarFuncionario",{
            method: "POST",
            headers:{
                "Content-Type": "application/json"
            },
            body:JSON.stringify(funcionario)
        });
        const dados = await resposta.json();
       
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
    
    const autenticarUsuario = {
        nome:nome,
        senha:senha
    }
    try{
        const resposta = await fetch(
        "http://localhost/agenda/controladores/rota.php?acao=autenticarFuncionario",{
            method: "POST",
            headers:{
                "Content-Type": "application/json"
            },
            body:JSON.stringify(funcionario)
        });
        const dados = await resposta.json();
       
        if(resposta.ok){
            Swal.fire(
                {
                    icon:'success',
                    title:'Sucesso!',
                    text: dados.mensagem
                }
            )
        }
    }catch (erro) {
        mensagem.innerHTML = erro.message || "Erro de comunicação com o servidor.";
        mensagem.style.color = "red";
    }
}