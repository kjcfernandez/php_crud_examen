<?php

require_once "conexion.php";
header("Content-Type: application/json");
$metodo = $_SERVER['REQUEST_METHOD'];

/* =========================
   GET
   ========================= */
if ($metodo === 'GET') {
    $resultado = $conexion->query(
        "SELECT id, titulo, director, genero, anio, duracion FROM peliculas"
    );
    $peliculas = [];
    while ($fila = $resultado->fetch_assoc()) {
        $peliculas[] = $fila;
    }
    http_response_code(200);
    echo json_encode($peliculas);
    exit;
}


/* =========================
   MÉTODO NO PERMITIDO
   ========================= */
http_response_code(405);
echo json_encode([
    "error" => "Método no permitido"
]);
exit;
