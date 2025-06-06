<?php
include('../../config/database.php'); // Conexión a la base de datos
session_start();

// Verifica si el usuario ya está logueado
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.html'); // Redirige al index si ya está logueado
    exit();
}

// Capturar los datos del formulario de inicio de sesión
$email = $_POST['e_mail'];
$passw = $_POST['passw'];

// Verificar que los datos no estén vacíos
if (empty($email) || empty($passw)) {
    echo "<script>alert('Por favor, ingrese todos los campos.'); window.location.href='../login.html';</script>";
    exit();
}

// Consulta SQL para verificar si el correo existe y está activo
$sql_check_email = "SELECT id, firstname, lastname, email, password FROM users WHERE email = $1 AND status = true";
$stmt_check_email = pg_prepare($conn, "check_email", $sql_check_email);
$res_check_email = pg_execute($conn, "check_email", array($email));

if ($res_check_email && pg_num_rows($res_check_email) > 0) {
    // Si el correo existe, verificar la contraseña
    $row = pg_fetch_assoc($res_check_email);
    
    // Verificar si la contraseña es correcta
    if (!empty($row['password']) && password_verify($passw, $row['password'])) {
        // Si la contraseña es válida, guardar los datos del usuario en la sesión
        $_SESSION['user_id'] = $row['id'];           // Guardamos el ID del usuario
        $_SESSION['user_name'] = $row['firstname'];  // Guardamos el primer nombre del usuario
        
        // Redirigir al index.php después del inicio de sesión
        header('Location: ../index.html');
        exit();
    } else {
        // Si la contraseña es incorrecta, mostrar mensaje de error
        echo "<script>alert('Correo o contraseña incorrectos'); window.location.href='../login.html';</script>";
    }
} else {
    // Si el correo no existe o la consulta falla, mostrar mensaje de error
    echo "<script>alert('Correo no registrado o error al verificar.'); window.location.href='../login.html';</script>";
}
?>
