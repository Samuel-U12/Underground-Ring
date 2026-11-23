async function salvarCliente() {
    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;
    const endereco = document.getElementById("endereco").value;

    const cliente = {
        nome:nome,
        email:email,
        senha:senha,
        endereco:endereco
    }
    try{
        const resposta = await fetch(
        "http://localhost/agenda/controladores/rota.php?acao=salvarCliente",{
            method: "POST",
            headers:{
                "Content-Type": "application/json"
            },
            body:JSON.stringify(cliente)
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
    
    const autenticarCliente = {
        email:email,
        senha:senha
    }
    try{
        const resposta = await fetch(
        "http://localhost/agenda/controladores/rota.php?acao=autenticarCliente",{
            method: "POST",
            headers:{
                "Content-Type": "application/json"
            },
            body:JSON.stringify(autenticarCliente)
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
    }
}