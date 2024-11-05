<?php
session_start();
include 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Contactos</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    
    <div id="particles-js"></div>

    <div class="count-particles">
        <span class="js-count-particles">--</span> particles
    </div>

    <h1>Agenda de Contactos</h1>

  
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert" id="alert-message">
            <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>

    <div class="contenedor">
        <form id="contact-form" action="procesos.php" method="POST">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>
            <input type="email" name="email" placeholder="Correo Electrónico" required>
            <button type="submit" name="agregar" class="boton">Agregar Contacto</button>
        </form>
    </div>

    <div class="contenedor">
        <h2>Lista de Contactos</h2>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
            <?php
                $result = $conn->query("SELECT * FROM contactos");

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['telefono']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>
                            <a href='editar.php?id=" . $row['id'] . "' class='boton'>Modificar</a> | 
                            <a href='procesos.php?eliminar=" . $row['id'] . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este contacto?\");' class='boton'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
                $conn->close();
            ?>
        </table>
    </div>

    
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="js/app.js"></script>
    <script src="js/lib/stats.js"></script>
    <script src="script.js"></script>

    <script>
        setTimeout(function() {
            const alertMessage = document.getElementById('alert-message');
            if (alertMessage) {
                alertMessage.style.display = 'none';
            }
        }, 2000);

        
        var count_particles, stats, update;
        stats = new Stats();
        stats.setMode(0);
        stats.domElement.style.position = 'absolute';
        stats.domElement.style.left = '0px';
        stats.domElement.style.top = '0px';
        document.body.appendChild(stats.domElement);

        count_particles = document.querySelector('.js-count-particles');
        update = function() {
            stats.begin();
            stats.end();
            if (window.pJSDom && window.pJSDom[0] && window.pJSDom[0].pJS.particles.array) {
                count_particles.innerText = window.pJSDom[0].pJS.particles.array.length;
            }
            requestAnimationFrame(update);
        };
        requestAnimationFrame(update);
    </script>
</body>
</html>
