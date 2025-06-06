<?php
session_start();
session_unset();
session_destroy();
header("Location: ../login.html"); // O a donde quieras redirigir
exit;
