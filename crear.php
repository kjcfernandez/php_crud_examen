<?php

require "db.php";

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo = trim($_POST['titulo'] ?? '');
    $director = trim($_POST['director'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    $anio = trim($_POST['anio'] ?? '');
    $duracion = trim($_POST['duracion'] ?? '');


    if ($titulo === '') $errores[] = "El título es obligatorio.";
    if ($director === '') $errores[] = "Este campo es obligatorio.";
    if ($genero === '') $errores[] = "Este campo es obligatorio.";
    if ($anio === '') $errores[] = "Este campo es obligatorio.";
    if ($duracion === '') $errores[] = "Este campo es obligatorio.";

    if (empty($errores)) {
        $stmt = $pdo->prepare("INSERT INTO peliculas (titulo, director, genero, anio, duracion) VALUES (:titulo, :director, :genero, :anio, :duracion)");

        $stmt->execute([
            ':titulo' => $titulo,
            ':director' => $director,
            ':genero' => $genero,
            ':anio' => $anio,
            ':duracion' => $duracion,


        ]);

        header("Location: index.php?mensaje=Película creada correctamente");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta Película</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 40px auto; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; }
        button { margin-top: 20px; padding: 8px 16px; background: #219621; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .error { color: #db231d; }
        a { display: inline-block; margin-top: 15px; }
    </style>
</head>
<body>
    <h1>Nueva película</h1>

    <?php if (!empty($errores)): ?>
        <ul class="error">
            <?php foreach ($errores as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="crear.php">
        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($_POST['titulo'] ?? ''); ?>">
        <label for="director">Director</label>
        <input type="text" id="director" name="director" value="<?php echo htmlspecialchars($_POST['director'] ?? ''); ?>">
        <label for="genero">Genero</label>
        <input type="text" id="genero" name="genero" value="<?php echo htmlspecialchars($_POST['genero'] ?? ''); ?>">
        <label for="anio">Año</label>
        <input type="text" id="anio" name="anio" value="<?php echo htmlspecialchars($_POST['anio'] ?? ''); ?>">
        <label for="duracion">Duración</label>
        <input type="text" id="duracion" name="duracion" value="<?php echo htmlspecialchars($_POST['duracion'] ?? ''); ?>">

        <button type="submit">Guardar</button>
    </form>

    <a href="index.php">&larr; Volver al listado</a>
</body>
</html>
