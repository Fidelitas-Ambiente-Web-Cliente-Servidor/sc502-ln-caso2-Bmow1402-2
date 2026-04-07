<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Panel Administrador</title>

<link rel="stylesheet" href="public/css/style.css">

<script src="public/js/jquery-4.0.0.min.js"></script>
<script src="public/js/solicitud.js"></script>

</head>

<body>

<nav class="navbar">
    <div class="navbar-container">

        <a href="index.php?page=home" class="navbar-brand">
            Gestión de Talleres
        </a>

        <div class="navbar-menu">

            <a href="index.php?page=talleres" class="nav-link">
                Talleres
            </a>

            <a href="index.php?page=admin" class="nav-link active">
                Solicitudes
            </a>

            <span class="user-name">
                Admin: <?= htmlspecialchars($_SESSION['user']) ?>
            </span>

            <button id="btnLogout" class="btn btn-outline">
                Cerrar sesión
            </button>

        </div>
    </div>
</nav>


<div class="container">

    <div class="page-header">
        <h2>Solicitudes pendientes</h2>
        <p>Aprobar o rechazar inscripciones de usuarios</p>
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
                <tr>
                    <td colspan="5" class="loader">
                        Cargando solicitudes...
                    </td>
                </tr>
            </tbody>

        </table>

    </div>

</div>

</body>
</html>