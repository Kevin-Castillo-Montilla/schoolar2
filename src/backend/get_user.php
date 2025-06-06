<?php
session_start();

// Asegurarse de que la respuesta sea JSON
header('Content-Type: application/json');

// Comprobamos si el usuario está logueado
if (isset($_SESSION['user_name'])) {
    // Devolver el nombre de usuario desde la sesión
    $username = $_SESSION['user_name'];
} else {
    // Si no está logueado, devolver "Invitado"
    $username = "Invitado";
}

// Enviar la respuesta JSON con el nombre del usuario
echo json_encode(["username" => $username]);
?>
