<?php
session_start(); 
include 'conexion.php';


if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    $sql = "INSERT INTO contactos (nombre, telefono, email) VALUES ('$nombre', '$telefono', '$email')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Contacto añadido correctamente.";
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $sql = "DELETE FROM contactos WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Contacto eliminado exitosamente.";
        header("Location: index.php");
        exit();
    } else {
        echo "Error al eliminar el contacto: " . $conn->error;
    }
}


if (isset($_POST['modificar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    $sql = "UPDATE contactos SET nombre='$nombre', telefono='$telefono', email='$email' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Contacto editado exitosamente.";
        header("Location: index.php");
        exit();
    } else {
        echo "Error al modificar el contacto: " . $conn->error;
    }
}

$conn->close();
?>
