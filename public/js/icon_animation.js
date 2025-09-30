




document.addEventListener('DOMContentLoaded', function () {

    const icon_list = document.getElementsByTagName('svg');
    const m_list = document.getElementsByClassName('mssge');
    let index = 0;

    icon_list[0].style.display = 'block';
    m_list[0].style.display = 'block';


    const intervalo = setInterval( ()=> {

        //Ocultar el actual
        icon_list[index].style.display = 'none';
        m_list[index].style.display = 'none';
        //Actualizamos el indice para pasa al siguiente elemento
        index = (index + 1) % icon_list.length;

        //Mostramos el elemento, solo por 3s
        icon_list[index].style.display = 'block';
        m_list[index].style.display = 'block';

    }, 1500);
})
