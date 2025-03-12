document.addEventListener("DOMContentLoaded", function () {
    // Obtener referencias a los elementos del DOM
    const contenedor_login_register = document.querySelector(".contenedorFormulariosRegistroeInicioSesion");
    const formulario_login = document.querySelector(".formularioInicioSesion");
    const formulario_register = document.querySelector(".formularioRegistroInicial");
    const caja_trasera_login = document.querySelector(".cuadroLogin");    
    const caja_trasera_register = document.querySelector(".cuadroRegistroInicial");

    const botonInicioSesion = document.getElementById("botonInicioSesion");
    const botonRegistroInicial = document.getElementById("botonRegistroInicial");

    // Asegurar que los elementos existen antes de asignar eventos
    if (!contenedor_login_register || !formulario_login || !formulario_register || !caja_trasera_login || !caja_trasera_register || !botonInicioSesion || !botonRegistroInicial) {
        console.error("Algunos elementos no se encontraron en el DOM");
        return;
    }

    // Función para cambiar la visibilidad según el tamaño de la pantalla
    function anchoPagina() {
        if (window.innerWidth > 850) {
            caja_trasera_login.style.display = "block";
            caja_trasera_register.style.display = "block";
        } else {
            caja_trasera_register.style.display = "block";
            caja_trasera_register.style.opacity = "1";
            caja_trasera_login.style.display = "none";
            formulario_login.style.display = "block";
            formulario_register.style.display = "none";
            contenedor_login_register.style.left = "0";
        }
    }
    
    // Función para alternar entre login y registro
    function cambiarFormulario(mostrarLogin) {
        if (window.innerWidth > 850) {
            formulario_register.style.display = mostrarLogin ? "none" : "block";
            formulario_login.style.display = mostrarLogin ? "block" : "none";
            contenedor_login_register.style.left = mostrarLogin ? "200px" : "600px";
            caja_trasera_register.style.opacity = mostrarLogin ? "1" : "0";
            caja_trasera_login.style.opacity = mostrarLogin ? "0" : "1";
        } else {
            formulario_register.style.display = mostrarLogin ? "none" : "block";
            formulario_login.style.display = mostrarLogin ? "block" : "none";
            contenedor_login_register.style.left = "0px";
            caja_trasera_register.style.display = mostrarLogin ? "block" : "none";
            caja_trasera_login.style.display = mostrarLogin ? "none" : "block";
            caja_trasera_login.style.opacity = "1";
        }
    }
    

    // Eventos para alternar los formularios
    botonInicioSesion.addEventListener("click", () => cambiarFormulario(true));
    botonRegistroInicial.addEventListener("click", () => cambiarFormulario(false));

    // Detectar cambios en el tamaño de la ventana
    window.addEventListener("resize", anchoPagina);

    // Ejecutar función al cargar la página
    anchoPagina();
});
