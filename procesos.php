<?php
session_start(); 
include 'conexion.php';

if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

  
    $allowed_domains = "/@(?:gmail\.com|hotmail\.com|yahoo\.com|outlook\.com|icloud\.com|live\.com)$/";
    if (!preg_match($allowed_domains, $email)) {
        $_SESSION['message'] = "El correo electrónico debe terminar en @gmail.com, @hotmail.com, @yahoo.com, @outlook.com, @icloud.com o @live.com.";
        header('Location: index.php');
        exit();
    }

    
    if (!ctype_digit($telefono)) {
        $_SESSION['message'] = "El teléfono solo debe contener números.";
        header('Location: index.php');
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO contactos (nombre, telefono, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $telefono, $email);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Contacto añadido correctamente.";
    } else {
        $_SESSION['message'] = "Error al añadir el contacto: " . $stmt->error;
    }
    
    $stmt->close();
    header("Location: index.php");
    exit();
}

if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
   
    $stmt = $conn->prepare("DELETE FROM contactos WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Contacto eliminado exitosamente.";
    } else {
        $_SESSION['message'] = "Error al eliminar el contacto: " . $stmt->error;
    }
    
    $stmt->close();
    header("Location: index.php");
    exit();
}

if (isset($_POST['modificar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    
    if (!preg_match($allowed_domains, $email)) {
        $_SESSION['message'] = "El correo electrónico debe terminar en @gmail.com, @hotmail.com, @yahoo.com, @outlook.com, @icloud.com o @live.com.";
        header('Location: index.php');
        exit();
    }

   
    if (!ctype_digit($telefono)) {
        $_SESSION['message'] = "El teléfono solo debe contener números.";
        header('Location: index.php');
        exit();
    }

  
    $stmt = $conn->prepare("UPDATE contactos SET nombre = ?, telefono = ?, email = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nombre, $telefono, $email, $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Contacto editado exitosamente.";
    } else {
        $_SESSION['message'] = "Error al modificar el contacto: " . $stmt->error;
    }
    
    $stmt->close();
    header("Location: index.php");
    exit();
}

$conn->close();
?>
