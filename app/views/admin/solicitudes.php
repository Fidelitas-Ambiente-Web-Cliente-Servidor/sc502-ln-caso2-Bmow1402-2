<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="public/css/style.css">
    <script src="public/js/jquery-4.0.0.min.js"></script>
</head>
<body>

<nav class="navbar">
    <div class="navbar-container">
        <a href="index.php?page=home" class="navbar-brand">
            Gestion de Talleres
        </a>
        <div class="navbar-menu">
            <span class="user-name">
                Admin: <?php 
                $nombreAdmin = $_SESSION['user'] ?? 'Admin';
                echo htmlspecialchars($nombreAdmin); 
                ?>
            </span>
            <button id="btnLogout" class="btn btn-outline">Cerrar sesion</button>
        </div>
    </div>
</nav>

<div class="container">
    <!-- Seccion de Talleres Disponibles -->
    <div class="page-header">
        <h2>Talleres Disponibles</h2>
        <p>Visualizacion de todos los talleres y sus cupos</p>
    </div>

    <div id="listaTalleres" class="taller-grid">
        <div class="loading">Cargando talleres...</div>
    </div>

    <!-- Seccion de Solicitudes -->
    <div class="page-header" style="margin-top: 3rem;">
        <h2>Todas las Solicitudes</h2>
        <p>Gestiona las solicitudes de los usuarios</p>
    </div>

    <div class="admin-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Taller</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="solicitudes-body">
                <tr><td colspan="5">Cargando solicitudes...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<footer>
        <div class="footer">
            <p>SC502 - Caso de estudio 2 Administración Web Cliente/Servidor</p>
            <p>&copy; 2026 Paola Solorzano Mendez.</p>
        </div>
    </footer>
    
<script>
// Funcion para cargar talleres
function cargarTalleres() {
    $.ajax({
        url: "index.php",
        type: "GET",
        data: {
            option: "admin_talleres_json"
        },
        dataType: "json",
        success: function(data) {
            let html = "";
            
            if(!data || data.length === 0) {
                html = "<p>No hay talleres disponibles</p>";
            } else {
                data.forEach(function(taller) {
                    let estadoCupo = "";
                    let colorCupo = "";
                    
                    if(taller.cupo_disponible == 0) {
                        estadoCupo = "Sin cupos";
                        colorCupo = "red";
                    } else if(taller.cupo_disponible <= 2) {
                        estadoCupo = "Ultimos cupos: " + taller.cupo_disponible;
                        colorCupo = "orange";
                    } else {
                        estadoCupo = "Cupos disponibles: " + taller.cupo_disponible;
                        colorCupo = "green";
                    }
                    
                    html += `
                        <div class="taller-card">
                            <div class="taller-title">${taller.nombre}</div>
                            <div class="taller-desc">${taller.descripcion}</div>
                            <div class="taller-info">
                                <span>Capacidad maxima: ${taller.cupo_maximo}</span>
                                <span style="color: ${colorCupo}; font-weight: bold;">${estadoCupo}</span>
                            </div>
                        </div>
                    `;
                });
            }
            
            $("#listaTalleres").html(html);
        },
        error: function() {
            $("#listaTalleres").html("<p>Error al cargar talleres</p>");
        }
    });
}

// Funcion para cargar solicitudes
function cargarSolicitudes() {
    $.ajax({
        url: "index.php",
        type: "GET",
        data: {
            option: "solicitudes_json"
        },
        dataType: "json",
        success: function(data) {
            let html = "";
            
            if(!data || data.length === 0) {
                html = `<tr><td colspan="5" style="text-align: center;">No hay solicitudes</td></tr>`;
            } else {
                data.forEach(function(s) {
                    let estadoClass = "";
                    let estadoText = "";
                    let botones = "";
                    
                    if(s.estado === 'pendiente') {
                        estadoClass = "estado-pendiente";
                        estadoText = "Pendiente";
                        botones = `
                            <button class="btn-aprobar" onclick="aprobar(${s.id})">Aprobar</button>
                            <button class="btn-rechazar" onclick="rechazar(${s.id})">Rechazar</button>
                        `;
                    } else if(s.estado === 'aprobada') {
                        estadoClass = "estado-aprobada";
                        estadoText = "Aprobada";
                        botones = `<span style="color: green;">Procesada</span>`;
                    } else {
                        estadoClass = "estado-rechazada";
                        estadoText = "Rechazada";
                        botones = `<span style="color: red;">Procesada</span>`;
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
        error: function() {
            $("#solicitudes-body").html('<tr><td colspan="5">Error al cargar solicitudes</td></tr>');
        }
    });
}

window.aprobar = function(id) {
    if(confirm('¿Seguro de aprobar esta solicitud?')){
        $.ajax({
            url: "index.php",
            type: "POST",
            data: {
                option: "aprobar",
                id: id
            },
            dataType: "json",
            success: function(response) {
                if(response.success){
                    alert(response.message);
                    cargarSolicitudes();
                    cargarTalleres();
                } else {
                    alert('Error: ' + response.message);
                }
            }
        });
    }
}

window.rechazar = function(id) {
    if(confirm('¿Seguro de rechazar esta solicitud?')){
        $.ajax({
            url: "index.php",
            type: "POST",
            data: {
                option: "rechazar",
                id: id
            },
            dataType: "json",
            success: function(response) {
                if(response.success){
                    alert(response.message);
                    cargarSolicitudes();
                } else {
                    alert('Error: ' + response.message);
                }
            }
        });
    }
}

$(function() {
    cargarTalleres();
    cargarSolicitudes();
    
    $("#btnLogout").click(function() {
        $.post("index.php", {option: "logout"}, function() {
            window.location = "index.php?page=login";
        });
    });
});
</script>

</body>
</html>