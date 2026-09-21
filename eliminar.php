<?php

require "db.php";

$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM peliculas WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

header("Location: index.php?mensaje=Película eliminada correctamente");
exit;
