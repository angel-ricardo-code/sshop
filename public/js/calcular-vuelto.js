const cash = document.getElementById('cash_input');
const vuelto = document.getElementById('result_input');
const full = document.getElementById('full_price');
const alertBox = document.getElementById('alert');

cash.addEventListener('input', function () {

    let result = vuelto.value = cash.value - full.value;

    if (result < 0)
        alertBox.classList.remove('hide');

    else
        alertBox.classList.add('hide');

})
