let eliminaModal = document.getElementById('eliminaModal')
eliminaModal-addEventListener('show.bs.modal', function(event)
{
    let button = event.relatedTarget
    let id = button.getAttribute('data-bs-id')
    let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
    buttonElimina.value = id
})

function eliminaProducto()
{
    let botonElimina = document.getElementById('btn-elimina')
    let id = botonElimina.value

    let url = 'clases/actualizar_carrito.php'
    let formData = new FormData()
    formData.append('action', 'eliminar');
    formData.append('id', id);

    fetch(url, {
        method: 'POST',
        body: formData,
        mode: 'cors'
    }).then(respose => respose.json()) 
    .then(data =>  {
        if(data.ok){
            location.reload()
        }
    })
}

function addProducto(id, token)
{
    let url = 'clases/carrito.php'
    let formData = new FormData()
    formData.append('id', id);
    formData.append('token', token)

    fetch(url, {
        method: 'POST',
        body: formData,
        mode: 'cors'
    }).then(respose => respose.json()) 
    .then(data =>  {
        if(data.ok){
            let elemento = document.getElementById("num_cart")
            elemento.innerHTML = data.numero 
        }
    })
}

function actualizaCantidad(cantidad, id)
{
    let url = './clases/actualizar_carrito.php'
    let formData = new FormData()
    formData.append('action', 'agregar');
    formData.append('id', id);
    formData.append('cantidad', cantidad)

    fetch(url, {
        method: 'POST',
        body: formData,
        mode: 'cors'
    }).then(respose => respose.json()) 
    .then(data =>  {
        if(data.ok){
            // recibimos el subtotal
            let divsubtotal = document.getElementById('subtotal_' + id);
            divsubtotal.innerHTML = data.sub;
            let total = 0.00;
            let list = document.getElementsByName("subtotal[]");

            for(let i= 0; i < list.length; i++)
            {
                total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''))
            }
            total = new Intl.NumberFormat('es-AR', {
                minimumIntegerDigits: 2
            }).format(total)
            document.getElementById('total').innerHTML = '<?php echo MONEDA ?>' + total;
        }
    })
}