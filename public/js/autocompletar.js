




document.getElementById('producto_select').addEventListener('click', function (e) {

        var selectedValue = this.value;

        getData(selectedValue);

})



async function getData(id) {


    if (!id){
        return;
    }

    fetch(`api/product-data/${id}`, {
        headers: {
            'X-Requested-With' : 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name= "_token"]').value
        }
    })

    fetch(`api/product-data/${id}`)
        .then(response =>response.json())
        .then(data => {

            document.getElementById("pv").value = data.precio_venta || '';

        }).catch(error => console.error('Error:', error));


}
