$(function () {
    let formLogin = $("#formLogin");
    const urlBase = "index.php"

    formLogin.on("submit", function (event) {
        event.preventDefault();
        
        let username = $("#username");
        let password = $("#password");
        let isValid = true;
        
        // Limpiar mensajes de error anteriores
        $(".error-message").remove();
        $(".auth-input").removeClass("input-error");
        $(".form-alert").remove();
        
        // Validar usuario
        if (username.val().trim() === "") {
            mostrarError(username, "El usuario es requerido");
            isValid = false;
        } else if (username.val().trim().length < 3) {
            mostrarError(username, "El usuario debe tener al menos 3 caracteres");
            isValid = false;
        }
        
        // Validar contraseña
        if (password.val().trim() === "") {
            mostrarError(password, "La contraseña es requerida");
            isValid = false;
        } else if (password.val().trim().length < 4) {
            mostrarError(password, "La contraseña debe tener al menos 4 caracteres");
            isValid = false;
        }
        
        if (!isValid) {
            return;
        }
        
        // Deshabilitar boton
        let submitBtn = $(".auth-btn");
        let originalText = submitBtn.text();
        submitBtn.prop("disabled", true).text("Validando...");
        
        $.ajax({
            url: urlBase,
            type: 'POST',
            data: {
                username: username.val().trim(),
                password: password.val().trim(),
                option: "login"
            },
            dataType: 'json',
            success: function (response) {
                if (response.response === '00') {
                    // Redirigir segun el rol
                    if (response.rol === 'admin') {
                        window.location.href = 'index.php?page=admin';
                    } else {
                        window.location.href = 'index.php?page=talleres';
                    }
                } else {
                    mostrarAlerta(response.message || "Error de autenticacion", "error");
                    submitBtn.prop("disabled", false).text(originalText);
                }
            },
            error: function () {
                mostrarAlerta("Error de conexion con el servidor", "error");
                submitBtn.prop("disabled", false).text(originalText);
            }
        });
    });
    
    function mostrarError(input, mensaje) {
        input.addClass("input-error");
        input.after(`<div class="error-message">${mensaje}</div>`);
    }
    
    function mostrarAlerta(mensaje, tipo) {
        let alertClass = tipo === "error" ? "error-alert" : "success-alert";
        let icono = tipo === "error" ? "✖" : "✔";
        
        $(".auth-card form").prepend(`
            <div class="form-alert ${alertClass}">
                ${icono} ${mensaje}
            </div>
        `);
        
        setTimeout(function() {
            $(".form-alert").fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }
});