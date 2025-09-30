
const button = document.getElementById('profileBtn');

const menu = document.getElementById('profileMenu');

const  list = menu.classList;
const temas_btn = document.getElementById('temas_tile');

button.addEventListener('click', function () {
    list.toggle('show')
})

document.addEventListener('click', function (e) {

    if (e.target !== button )
    {
        list.remove('show');
    }
});

temas_btn.addEventListener('click', function (){
    alert('hola')
})


