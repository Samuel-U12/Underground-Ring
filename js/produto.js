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
