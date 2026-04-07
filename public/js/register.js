$(function () {
    let formRegister = $("#formRegister");
    const urlBase = "index.php"

    formRegister.on("submit", function (event) {
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
        } else if (username.val().trim().length > 50) {
            mostrarError(username, "El usuario no puede tener mas de 50 caracteres");
            isValid = false;
        } else if (!/^[a-zA-Z0-9_]+$/.test(username.val().trim())) {
            mostrarError(username, "El usuario solo puede contener letras, numeros y guion bajo");
            isValid = false;
        }
        
        // Validar contraseña
        if (password.val().trim() === "") {
            mostrarError(password, "La contraseña es requerida");
            isValid = false;
        } else if (password.val().trim().length < 4) {
            mostrarError(password, "La contraseña debe tener al menos 4 caracteres");
            isValid = false;
        } else if (password.val().trim().length > 255) {
            mostrarError(password, "La contraseña es demasiado larga");
            isValid = false;
        }
        
        if (!isValid) {
            return;
        }
        
        // Deshabilitar boton
        let submitBtn = $(".auth-btn");
        let originalText = submitBtn.text();
        submitBtn.prop("disabled", true).text("Registrando...");
        
        $.ajax({
            url: urlBase,
            type: 'POST',
            data: {
                username: username.val().trim(),
                password: password.val().trim(),
                option: "register"
            },
            dataType: 'json',
            success: function (response) {
                if (response.response === '00') {
                    mostrarAlerta(response.message || "Registro exitoso", "success");
                    // Redirigir a login despues de 1.5 segundos
                    setTimeout(function() {
                        window.location.href = 'index.php?page=login';
                    }, 1500);
                } else {
                    mostrarAlerta(response.message || "Error al registrar. El usuario ya existe", "error");
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