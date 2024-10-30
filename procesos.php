<?php
$conn = new mysqli("localhost", "root", "", "agenda_contactos");

if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    $sql = "INSERT INTO contactos (nombre, telefono, email) VALUES ('$nombre', '$telefono', '$email')";
    $conn->query($sql);

    header("Location: index.php");
}

if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $sql = "DELETE FROM contactos WHERE id=$id";
    $conn->query($sql);

    header("Location: index.php");
}

$conn->close();
?>
