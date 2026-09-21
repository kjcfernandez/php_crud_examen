<?php

require "db.php";

$id = (int) ($_GET['id'] ?? 0);

if ($id === 0) {
    header("Location: index.php?mensaje=" . urlencode("Película no encontrada"));
    exit;
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $director = trim($_POST['director'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    // Convertimos a entero para evitar fallos de formato con la base de datos
    $anio = (int) ($_POST['anio'] ?? 0);
    $duracion = (int) ($_POST['duracion'] ?? 0);

    if ($titulo === '') $errores[] = "El título es obligatorio.";
    if ($director === '') $errores[] = "Este campo es obligatorio.";
    if ($genero === '') $errores[] = "Este campo es obligatorio.";
    if ($anio === 0) $errores[] = "El año debe ser un número válido.";
    if ($duracion === 0) $errores[] = "La duración debe ser un número válido.";

    if (empty($errores)) {
        $stmt = $pdo->prepare("UPDATE peliculas SET titulo = :titulo, director = :director, genero = :genero, anio = :anio, duracion = :duracion WHERE id = :id");
        $stmt->execute([
            ':titulo' => $titulo,
            ':director' => $director,
            ':genero' => $genero,
            ':anio' => $anio,
            ':duracion' => $duracion,
            ':id' => $id,
        ]);

        // Usamos urlencode para proteger el texto en la redirección
        header("Location: index.php?mensaje=" . urlencode("Película actualizada correctamente"));
        exit;
    }
} else {
    $stmt = $pdo->prepare("SELECT * FROM peliculas WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $pelicula = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pelicula) {
        header("Location: index.php?mensaje=" . urlencode("Película no encontrada"));
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar película</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 40px auto; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; }
        button { margin-top: 20px; padding: 8px 16px; background: #f0ad4e; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .error { color: #d9534f; }
        a { display: inline-block; margin-top: 15px; }
    </style>
</head>
<body>
    <h1>Editar película</h1>

    <?php if (!empty($errores)): ?>
        <ul class="error">
            <?php foreach ($errores as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="editar.php?id=<?php echo $id; ?>">
        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo"
               value="<?php echo htmlspecialchars($_POST['titulo'] ?? $pelicula['titulo']); ?>">

        <label for="director">Director</label>
        <input type="text" id="director" name="director"
               value="<?php echo htmlspecialchars($_POST['director'] ?? $pelicula['director']); ?>">

        <label for="genero">Genero</label>
        <input type="text" id="genero" name="genero"
               value="<?php echo htmlspecialchars($_POST['genero'] ?? $pelicula['genero']); ?>">

        <label for="anio">Año</label>
        <input type="text" id="anio" name="anio"
               value="<?php echo htmlspecialchars($_POST['anio'] ?? $pelicula['anio']); ?>">

        <label for="duracion">Duración</label>
        <input type="text" id="duracion" name="duracion"
               value="<?php echo htmlspecialchars($_POST['duracion'] ?? $pelicula['duracion']); ?>">

        <button type="submit">Actualizar</button>
    </form>

    <a href="index.php">&larr; Volver al listado</a>
</body>
</html>
