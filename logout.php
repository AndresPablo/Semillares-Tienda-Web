<?php 

require 'config/config.php';

// Cierra la sesion
session_destroy();

// Redirige al indice
header("Location: index.php");