function build_catg(nombre) {

    let element = {};

    element = document.createElement('span');
    element.classList.add('sample');
    element.innerText = nombre;

    return element;
}

function build_color(color) {

    let element = {};
    element = document.createElement('div');
    element.classList.add('color');
    element.style.backgroundColor = color;
    element.style.border = 'none';

    return element;
}


let datos = [30, 70, 45, 55, 10];  //Aquí irían los datos de los porcientos de distribucion

async function getDistribution() {


    fetch('/stats')
        .then(response => response.json())
        .then(data => {



            const colores = ['rgb(40,180,9)', 'rgb(255,213,170)', 'rgb(121,72,20)', 'rgba(232,165,165,0.27)', '#FFCE56'];
            const div_distribution = document.getElementById('diagram_leyend');

            let valores = data['data'];

            let categorias = [];
            let values = [];

            for (let i = 0; i < valores.length; i++) {

                categorias[i] = valores[i].categoria;
                values[i] = parseFloat(valores[i].percent);
                let span = (build_catg(categorias[i]));
                div_distribution.append(span);
                span.append(build_color(colores[i]));
            }

            console.log(categorias, values)

            // Seleccionar el elemento, y obtenermos su display
            const canvas = document.getElementById('categoría_distribution');
            const ctx = canvas.getContext('2d');


            //Petición asíncrona a un controlador para obtener la distribución



            const total = values.reduce((acc, val) => acc + val, 0);  //hace una sumatoria del total
            let anguloInicial = 0;

            for (let i = 0; i < categorias.length; i++) {

                const fraccion = values[i] / total;
                const anguloFinal = anguloInicial + fraccion * 2 * Math.PI;

                ctx.beginPath();
                ctx.moveTo(150, 150);
                ctx.arc(150, 150, 125, anguloInicial, anguloFinal);
                ctx.closePath();
                ctx.fillStyle = colores[i];
                ctx.fill();

                anguloInicial = anguloFinal;
            }


        }).catch(error => console.error('Error:', error))


}


document.addEventListener('DOMContentLoaded', function () {

    getDistribution();
})



