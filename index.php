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
    <style>
        .buscador {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .buscador form {
            display: flex;
            width: 100%;
            max-width: 600px;
        }

        .buscador input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .buscador button {
            padding: 10px 15px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }

        .buscador button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div id="particles-js"></div>
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
        <!-- Buscador integrado con la lista de contactos -->
        <div class="buscador">
            <form action="index.php" method="POST">
                <input type="text" name="search_term" placeholder="Buscar por nombre, teléfono o email" value="<?php if (isset($_POST['search_term'])) echo htmlspecialchars($_POST['search_term']); ?>">
                <button type="submit" name="search" class="boton">Buscar</button>
            </form>
        </div>

        <h2>Lista de Contactos</h2>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
            <?php
                // Aquí gestionamos la búsqueda si se ha enviado el formulario
                if (isset($_POST['search']) && !empty($_POST['search_term'])) {
                    $search_term = $_POST['search_term'];
                    // Usar consulta preparada para la búsqueda
                    $stmt = $conn->prepare("SELECT * FROM contactos WHERE nombre LIKE ? OR telefono LIKE ? OR email LIKE ?");
                    $search_term_wildcard = "%" . $search_term . "%";
                    $stmt->bind_param("sss", $search_term_wildcard, $search_term_wildcard, $search_term_wildcard);
                    $stmt->execute();
                    $result = $stmt->get_result();
                } else {
                    // Si no se ha buscado, mostrar todos los contactos
                    $result = $conn->query("SELECT * FROM contactos");
                }

                // Mostrar los resultados de la búsqueda o todos los contactos
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

                // Cerrar la conexión de la base de datos
                if (isset($stmt)) {
                    $stmt->close();
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
    </script>
</body>
</html>
