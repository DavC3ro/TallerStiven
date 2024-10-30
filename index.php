<?php include 'conexion.php'; session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Contactos</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <h1>Agenda de Contactos</h1>

    
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert" id="alert-message">
            <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>

    <div class="formulario">
        <form id="contact-form" action="procesos.php" method="POST">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>
            <input type="email" name="email" placeholder="Correo Electrónico" required>
            <button type="submit" name="agregar">Agregar Contacto</button>
        </form>
    </div>
    <div class="contact-list">
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
                            <a href='editar.php?id=" . $row['id'] . "'>Modificar</a> | 
                            <a href='procesos.php?eliminar=" . $row['id'] . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este contacto?\");'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
                $conn->close();
            ?>
        </table>
    </div>
    <script src="script.js"></script>
    <script>
        // Desaparecer el mensaje después de 2 segundos
        setTimeout(function() {
            const alertMessage = document.getElementById('alert-message');
            if (alertMessage) {
                alertMessage.style.display = 'none';
            }
        }, 2000);
    </script>
</body>
</html>
