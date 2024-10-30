<?php include 'conexion.php'; ?>

<?php
// Obtener el contacto a editar
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM contactos WHERE id = $id");

    if ($result->num_rows > 0) {
        $contacto = $result->fetch_assoc();
    } else {
        echo "Contacto no encontrado.";
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Modificar Contacto</title>
</head>
<body>
    <h1>Modificar Contacto</h1>
    <form action="procesos.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $contacto['id']; ?>">
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($contacto['nombre']); ?>" required>
        <input type="text" name="telefono" value="<?php echo htmlspecialchars($contacto['telefono']); ?>" required>
        <input type="email" name="email" value="<?php echo htmlspecialchars($contacto['email']); ?>" required>
        <button type="submit" name="modificar">Modificar Contacto</button>
    </form>
    <a href="index.php">Cancelar</a>
</body>
</html>
