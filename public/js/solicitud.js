$(function(){

    const urlBase = "index.php";
    
    cargarSolicitudes();
    
    function cargarSolicitudes(){
        $.ajax({
            url: urlBase,
            type: "GET",
            data: {
                option: "solicitudes_json"
            },
            dataType: "json",
            success: function(data){
                let html = "";
                
                if(!data || data.length === 0){
                    html = `<tr><td colspan="5" style="text-align: center;">No hay solicitudes</td></tr>`;
                } else {
                    data.forEach(function(s){
                        let estadoClass = "";
                        let estadoText = "";
                        let botones = "";
                        
                        if(s.estado === 'pendiente'){
                            estadoClass = "estado-pendiente";
                            estadoText = "⏳ Pendiente";
                            botones = `
                                <button class="btn-aprobar" onclick="aprobar(${s.id})"> Aprobar</button>
                                <button class="btn-rechazar" onclick="rechazar(${s.id})"> Rechazar</button>
                            `;
                        } else if(s.estado === 'aprobada'){
                            estadoClass = "estado-aprobada";
                            estadoText = "Aprobada";
                            botones = `<span style="color: green;"> Procesada</span>`;
                        } else {
                            estadoClass = "estado-rechazada";
                            estadoText = " Rechazada";
                            botones = `<span style="color: red;"> Procesada</span>`;
                        }
                        
                        html += `
                        <tr>
                            <td>${s.username || 'N/A'}</td>
                            <td>${s.nombre_taller || 'N/A'}</td>
                            <td>${s.fecha_solicitud || 'N/A'}</td>
                            <td><span class="${estadoClass}">${estadoText}</span></td>
                            <td>${botones}</td>
                        </tr>
                        `;
                    });
                }
                
                $("#solicitudes-body").html(html);
            },
            error: function(){
                $("#solicitudes-body").html('<tr><td colspan="5">Error al cargar</td></tr>');
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
                        alert(' ' + response.message);
                        cargarSolicitudes(); // Recargar la lista
                    } else {
                        alert(' Error: ' + response.message);
                    }
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
                        alert(' ' + response.message);
                        cargarSolicitudes(); // Recargar la lista
                    } else {
                        alert('Error: ' + response.message);
                    }
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