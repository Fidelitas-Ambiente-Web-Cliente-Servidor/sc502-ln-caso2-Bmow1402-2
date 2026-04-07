<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Sistema de Gestión de Talleres</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php?page=home" class="navbar-brand">
                Gestión de Talleres
            </a>

            <div class="navbar-menu">
                <?php if (isset($_SESSION['id'])): ?>
                    <span class="user-name">
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </span>

                    <?php if ($_SESSION['rol'] == 'admin'): ?>
                        <a href="index.php?page=admin" class="nav-link">Panel Admin</a>
                    <?php endif; ?>

                    <a href="index.php?page=talleres" class="nav-link">Talleres</a>

                    <form method="POST" action="index.php" style="display: inline;">
                        <input type="hidden" name="option" value="logout">
                        <button type="submit" class="btn btn-outline">
                            Cerrar sesión
                        </button>
                    </form>

                <?php else: ?>

                    <a href="index.php?page=login" class="nav-link">Iniciar sesión</a>

                    <a href="index.php?page=registro" class="btn btn-primary">
                        Registrarse
                    </a>

                <?php endif; ?>
            </div>
        </div>
    </nav>


    <div class="container">

        <div class="hero">
            <h1>Sistema de Gestión de Talleres</h1>
            <p>Administra y participa en talleres educativos de forma sencilla</p>

            <?php if (!isset($_SESSION['id'])): ?>
                <div class="cta-buttons">
                    <a href="index.php?page=registro" class="btn btn-primary">Comenzar</a>
                    <a href="index.php?page=login" class="btn btn-outline">Ya tengo cuenta</a>
                </div>
            <?php else: ?>
                <div class="cta-buttons">
                    <a href="index.php?page=talleres" class="btn btn-primary">Ver talleres</a>
                </div>
            <?php endif; ?>
        </div>


        <div class="features">

            <div class="feature-card">
                <h3>Talleres Especializados</h3>
                <p>Diferentes áreas del conocimiento con cupos limitados.</p>
            </div>

            <div class="feature-card">
                <h3>Panel Administrativo</h3>
                <p>Administra participantes y solicitudes fácilmente.</p>
            </div>

            <div class="feature-card">
                <h3>Control de Cupos</h3>
                <p>Visualiza disponibilidad en tiempo real.</p>
            </div>

        </div>

        
    </div>
 


</body>

    <footer>
        <div class="footer">
            <p>SC502 - Caso de estudio 2 Administración Web Cliente/Servidor</p>
            <p>&copy; 2026 Paola Solorzano Mendez.</p>
        </div>
    </footer>
</html>