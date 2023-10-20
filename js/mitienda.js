

function addProducto(id, token)
{
    let url = 'clases/carrito.php'
    let formData = new FormData()
    formData.append('id', id);
    formData.append('token', token)
    fetch(url, {
        method: 'POST',
        body: FormData,
        mode: 'cors'
    }).then(respose => respose.json()) 
    .then(data =>  {
        if(data.ok){
            let elemento = document.getElementById("num_cart")
            elemento.innerHTML = data.numero 
        }
    })
}