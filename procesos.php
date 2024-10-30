<?php
include 'conexion.php';

// Añadir contacto
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    $sql = "INSERT INTO contactos (nombre, telefono, email) VALUES ('$nombre', '$telefono', '$email')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Eliminar contacto
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $sql = "DELETE FROM contactos WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error al eliminar el contacto: " . $conn->error;
    }
}


$conn->close();
?>
