<?php

require "db.php";


$stmt = $pdo->prepare("SELECT id, titulo, director, genero, anio, duracion FROM peliculas ORDER BY id ASC");
$stmt->execute();

$peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PELÍCULAS.COM</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 40px auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px 12px; text-align: left; }
        th { background: #f4f4f4; }
        .btn { padding: 4px 10px; text-decoration: none; border-radius: 4px; color: white; font-size: 14px; }
        .btn-edit { background: #f0ad4e; }
        .btn-delete { background: #d9534f; }
        .btn-new { background: #005bc4; display: inline-block; margin-bottom: 10px; }
        .flash { background: #dff0d8; padding: 10px; border-radius: 4px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>CARTELERA DE PELÍCULAS</h1>

    <?php if (isset($_GET['mensaje'])): ?>
        <div class="flash"><?php echo htmlspecialchars($_GET['mensaje']); ?></div>
    <?php endif; ?>

    <a class="btn btn-new" href="crear.php">+ Añadir nueva película</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Director</th>
                <th>Genero</th>
                <th>Año</th>
                <th>Duración</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($peliculas) === 0): ?>
                <tr><td colspan="7">No hay películas registradas todavía.</td></tr>
            <?php else: ?>
                <?php foreach ($peliculas as $pelicula): ?>
                    <tr>
                        <td><?php echo $pelicula['id']; ?></td>
                        <td><?php echo htmlspecialchars($pelicula['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($pelicula['director']); ?></td>
                        <td><?php echo htmlspecialchars($pelicula['genero']); ?></td>
                        <td><?php echo htmlspecialchars($pelicula['anio']); ?></td>
                        <td><?php echo $pelicula['duracion']; ?></td>
                        <td>
                            <a class="btn btn-edit" href="editar.php?id=<?php echo $pelicula['id']; ?>">Editar</a>
                            <a class="btn btn-delete" href="eliminar.php?id=<?php echo $pelicula['id']; ?>"
                               onclick="return confirm('¿Seguro que quieres eliminar esta pelicula?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
