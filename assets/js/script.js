document.addEventListener("DOMContentLoaded", function () {
    console.log("📢 script.js cargado correctamente.");

    // ==============================
    // 🟢 MANEJO DE FORMULARIOS LOGIN/REGISTRO
    // ==============================

    const contenedor_login_register = document.querySelector(".contenedorFormulariosRegistroeInicioSesion");
    const formulario_login = document.querySelector(".formularioInicioSesion");
    const formulario_register = document.querySelector(".formularioRegistroInicial");
    const caja_trasera_login = document.querySelector(".cuadroLogin");
    const caja_trasera_register = document.querySelector(".cuadroRegistroInicial");

    const btnLogin = document.getElementById("botonInicioSesion");
    const btnRegistro = document.getElementById("botonRegistroInicial");

    if (btnLogin) btnLogin.addEventListener("click", iniciarSesion);
    if (btnRegistro) btnRegistro.addEventListener("click", register);
    window.addEventListener("resize", anchoPagina);

    function anchoPagina() {
        console.log("📢 Ejecutando anchoPagina()");
    
        // Verificamos si los elementos existen antes de acceder a ellos
        const caja_trasera_login = document.querySelector(".cuadroLogin");
        const caja_trasera_register = document.querySelector(".cuadroRegistroInicial");
        const formulario_login = document.querySelector(".formularioInicioSesion");
        const formulario_register = document.querySelector(".formularioRegistroInicial");
        const contenedor_login_register = document.querySelector(".contenedorFormulariosRegistroeInicioSesion");
    
        if (!caja_trasera_login || !caja_trasera_register || !formulario_login || !formulario_register || !contenedor_login_register) {
            console.warn("⚠️ anchoPagina() no encontró todos los elementos necesarios.");
            return; // Salimos de la función para evitar errores
        }
    
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
    
    anchoPagina();

    function iniciarSesion() {
        console.log("📌 Click en Iniciar Sesión");
        if (!formulario_register || !formulario_login) {
            console.error("⚠️ Error: No se encontraron los formularios en el DOM.");
            return;
        }

        formulario_register.style.display = "none";
        formulario_login.style.display = "block";

        if (window.innerWidth > 850) {
            contenedor_login_register.style.left = "200px";
            caja_trasera_register.style.opacity = "1";
            caja_trasera_login.style.opacity = "0";
        } else {
            contenedor_login_register.style.left = "0px";
            caja_trasera_register.style.display = "block";
            caja_trasera_login.style.display = "none";
        }
    }

    function register() {
        console.log("📌 Click en Registrarse");
        if (!formulario_register || !formulario_login) {
            console.error("⚠️ Error: No se encontraron los formularios en el DOM.");
            return;
        }

        formulario_login.style.display = "none";
        formulario_register.style.display = "block";

        if (window.innerWidth > 850) {
            contenedor_login_register.style.left = "600px";
            caja_trasera_register.style.opacity = "0";
            caja_trasera_login.style.opacity = "1";
        } else {
            contenedor_login_register.style.left = "0px";
            caja_trasera_register.style.display = "none";
            caja_trasera_login.style.display = "block";
        }
    }

    // ==============================
    // 🟢 MANEJO DEL MODAL DE EDICIÓN DE USUARIOS
    // ==============================

    const modalEditar = document.getElementById("modalEditar");
    const btnCerrar = document.querySelector(".cerrar");
    const formEditar = document.getElementById("formEditarUsuario");

    // 📌 Asegurar que el modal esté oculto al cargar la página
    if (modalEditar) {
        console.log("✅ Modal encontrado en el DOM.");
        modalEditar.style.display = "none"; // Ocultar modal al inicio
    } else {
        console.error("⚠️ No se encontró #modalEditar en el DOM.");
    }

    // 📌 Función para abrir el modal y cargar datos del usuario
    window.abrirModalEditar = function (id, nombre, usuario, correo, rol) {
        console.log(`📝 Abriendo modal para ID: ${id}`);

        if (!modalEditar) {
            console.error("⚠️ Error: No se encontró el modal.");
            return;
        }

        const editId = document.getElementById("editIdUsuario");
        const editNombre = document.getElementById("editNombre");
        const editUsuario = document.getElementById("editUsuario");
        const editCorreo = document.getElementById("editCorreo");
        const editRol = document.getElementById("editRol");

        if (!editId || !editNombre || !editUsuario || !editCorreo || !editRol) {
            console.error("⚠️ Error: No se encontraron los campos del modal.");
            return;
        }

        editId.value = id;
        editNombre.value = nombre;
        editUsuario.value = usuario;
        editCorreo.value = correo;
        editRol.value = rol;

        modalEditar.style.display = "flex";
    };

    // 📌 Función para cerrar el modal
    // Función para cerrar el modal
window.cerrarModal = function () {
    console.log("❌ Cerrando modal...");
    const modalEditar = document.getElementById("modalEditar");
    if (modalEditar) {
        modalEditar.style.display = "none";
    } else {
        console.error("⚠️ No se encontró el modal.");
    }
};


    // 📌 Cerrar modal al hacer clic en la "×"
    if (btnCerrar) {
        btnCerrar.addEventListener("click", cerrarModal);
        console.log("✅ Botón de cerrar detectado.");
    } else {
        console.warn("⚠️ No se encontró el botón de cerrar en el modal.");
    }

    // 📌 Cerrar el modal si se hace clic fuera de él
    window.addEventListener("click", function (event) {
        if (modalEditar && event.target === modalEditar) {
            cerrarModal();
        }
    });

    // 📌 Cerrar modal con la tecla "Esc"
    window.addEventListener("keydown", function (event) {
        if (event.key === "Escape" && modalEditar.style.display === "flex") {
            cerrarModal();
        }
    });

    // 📌 Manejo del formulario de edición de usuario
    if (formEditar) {
        formEditar.addEventListener("submit", function (event) {
            event.preventDefault();

            const idUsuario = document.getElementById("editIdUsuario").value;
            const nombre = document.getElementById("editNombre").value;
            const usuario = document.getElementById("editUsuario").value;
            const correo = document.getElementById("editCorreo").value;
            const rol = document.getElementById("editRol").value;

            console.log("📌 Guardando cambios:", { idUsuario, nombre, usuario, correo, rol });

            cerrarModal(); // Cerrar modal después de guardar cambios
        });
    } else {
        console.warn("⚠️ No se encontró el formulario de edición en el DOM.");
    }
});
