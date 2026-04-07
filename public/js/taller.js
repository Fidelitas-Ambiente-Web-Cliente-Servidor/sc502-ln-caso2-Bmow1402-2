$(function () {

    const urlBase = "index.php";

    cargarTalleres();
    cargarMisSolicitudes();

    function cargarTalleres() {
        $.get(urlBase, {
            option: "talleres_json"
        }, function (data) {
            let html = "";

            data.forEach(t => {
                let botonHtml = '';
                let mensajeRechazo = '';
                
                // Si fue rechazado, mostrar mensaje y deshabilitar botón
                if(t.fue_rechazado) {
                    botonHtml = `
                        <button class="btn btn-disabled" disabled style="background-color: #6B7280; cursor: not-allowed;">
                             No puedes aplicar
                        </button>
                        <div style="color: #DC2626; font-size: 0.875rem; margin-top: 0.5rem;">
                             Fuiste rechazado en este taller. No puedes volver a solicitarlo.
                        </div>
                    `;
                } else {
                    botonHtml = `
                        <button class="btn btn-primary btn-solicitar" onclick="solicitar(${t.id})">
                            Solicitar inscripción
                        </button>
                    `;
                }
                
                html += `
                <div class="taller-card">
                    <div class="taller-title">${t.nombre}</div>
                    <div class="taller-desc">${t.descripcion}</div>
                    <div class="taller-cupos">Cupos disponibles: ${t.cupo_disponible}</div>
                    ${botonHtml}
                </div>
                `;
            });

            $("#listaTalleres").html(html);

        }, "json");
    }

    function cargarMisSolicitudes() {
        $.ajax({
            url: urlBase,
            type: "GET",
            data: {
                option: "mis_solicitudes_json"
            },
            dataType: "json",
            success: function(data){
                let html = "";
                
                if(!data || data.length === 0){
                    html = `<tr><td colspan="3">No has realizado solicitudes</td></tr>`;
                } else {
                    data.forEach(function(s){
                        let estadoClass = "";
                        let estadoText = "";
                        
                        if(s.estado === 'pendiente'){
                            estadoClass = "estado-pendiente";
                            estadoText = "⏳ Pendiente - Esperando aprobación";
                        } else if(s.estado === 'aprobada'){
                            estadoClass = "estado-aprobada";
                            estadoText = " Aprobada - ¡Felicidades!";
                        } else {
                            estadoClass = "estado-rechazada";
                            estadoText = "Rechazada - No puedes volver a solicitar este taller";
                        }
                        
                        html += `
                        <tr>
                            <td>${s.nombre_taller}</td>
                            <td>${s.fecha_solicitud}</td>
                            <td><span class="${estadoClass}">${estadoText}</span></td>
                        </tr>
                        `;
                    });
                }
                
                $("#misSolicitudes-body").html(html);
            }
        });
    }

    window.solicitar = function(id) {
        if(confirm('¿Estás seguro de solicitar este taller?')){
            $.post(urlBase, {
                option: "solicitar",
                taller_id: id
            }, function(response) {
                response = JSON.parse(response);
                
                if(response.success){
                    alert(" Solicitud enviada exitosamente");
                    cargarTalleres();
                    cargarMisSolicitudes();
                } else {
                    alert(" Error: " + response.error);
                }
            });
        }
    }

    $("#btnLogout").click(function() {
        $.post(urlBase, {
            option: "logout"
        }, function() {
            window.location = "index.php?page=login";
        });
    });

});