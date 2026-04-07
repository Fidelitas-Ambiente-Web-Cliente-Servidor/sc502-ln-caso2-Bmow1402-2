$(function(){

    const urlBase = "index.php";
    
    cargarSolicitudes();
    
    function cargarSolicitudes(){
        console.log("Cargando solicitudes...");
        
        $.ajax({
            url: urlBase,
            type: "GET",
            data: {
                option: "solicitudes_json"
            },
            dataType: "json",
            success: function(data){
                console.log("Datos recibidos:", data);
                
                let html = "";
                
                if(!data || data.length === 0){
                    html = `<tr>
                                <td colspan="5" style="text-align: center;">
                                    No hay solicitudes pendientes
                                </td>
                            </tr>`;
                } else {
                    for(let i = 0; i < data.length; i++) {
                        let s = data[i];
                        console.log("Solicitud:", s.id, s.username, s.nombre_taller);
                        
                        html += `
                        <tr>
                            <td>${s.username || 'N/A'}</td>
                            <td>${s.nombre_taller || 'N/A'}</td>
                            <td>${s.fecha_solicitud || 'N/A'}</td>
                            <td>
                                <span class="estado estado-pendiente">
                                    Pendiente
                                </span>
                            </td>
                            <td>
                                <button class="btn-aprobar" onclick="aprobar(${s.id})">
                                     Aprobar
                                </button>
                                <button class="btn-rechazar" onclick="rechazar(${s.id})">
                                     Rechazar
                                </button>
                            </td>
                        </tr>
                        `;
                    }
                }
                
                $("#solicitudes-body").html(html);
            },
            error: function(xhr, status, error){
                console.error("Error al cargar solicitudes:", error);
                console.log("Respuesta del servidor:", xhr.responseText);
                
                $("#solicitudes-body").html(`
                    <tr>
                        <td colspan="5" style="text-align: center; color: red;">
                            Error al cargar solicitudes
                        </td>
                    </tr>
                `);
            }
        });
    }
    
    window.aprobar = function(id){
        if(confirm('¿Estás seguro de aprobar esta solicitud?')){
            $.ajax({
                url: urlBase,
                type: "POST",
                data: {
                    option: "aprobar",
                    id: id
                },
                dataType: "json",
                success: function(response){
                    if(response.success){
                        alert(' Solicitud aprobada exitosamente');
                        cargarSolicitudes(); // Recargar la lista
                    } else {
                        alert(' Error: ' + (response.message || 'No se pudo aprobar'));
                    }
                },
                error: function(xhr){
                    alert('Error: ' + xhr.responseText);
                }
            });
        }
    }
    
    window.rechazar = function(id){
        if(confirm('¿Estás seguro de rechazar esta solicitud?')){
            $.ajax({
                url: urlBase,
                type: "POST",
                data: {
                    option: "rechazar",
                    id: id
                },
                dataType: "json",
                success: function(response){
                    if(response.success){
                        alert('❌ Solicitud rechazada');
                        cargarSolicitudes(); // Recargar la lista
                    } else {
                        alert('Error: ' + (response.message || 'No se pudo rechazar'));
                    }
                },
                error: function(xhr){
                    alert('Error: ' + xhr.responseText);
                }
            });
        }
    }
    
    $("#btnLogout").click(function(){
        $.post(urlBase, {
            option: "logout"
        }, function(){
            window.location = "index.php?page=login";
        });
    });
});