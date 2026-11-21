async function SalvarProduto() {

    const Foto = document.getElementById("foto").value;
    const formData = new formData();
    formData.append('nome', document.getElementById('nome').value);
    formData.append('preco', document.getElementById('preco').value);
    if (inputFile.files.length > 0){
        formData.append('foto', inputFile.files[0]);
    }try{
        const resposta = await fetch('rota.php', {
            method: 'POST',
            body: formData 
        });

        const resultado = await resposta.json();
        console.log('Sucesso:', resultado);
        alert('Produto cadastrado com sucesso!');
    } catch (erro) {
        console.error('Erro ao enviar:', erro);
    }
};

async function AlterarProduto() {
    const nome = document.getElementById("nome").value;
    const quantidade = document.getElementById("quantidade").value;
    const preco = document.getElementById("preco").value;
    
    const alterarProduto = {
        nome:nome,
        quantidade:quantidade,
        preco:preco
    }
    try{
        const resposta = await fetch(
        "http://localhost/agenda/controladores/rota.php?acao=autenticarProduto",{
            method: "POST",
            headers:{
                "Content-Type": "application/json"
            },
            body:JSON.stringify(Produto)
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