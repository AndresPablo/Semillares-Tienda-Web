<?php

class Database 
{
    private $hostname = 'localhost';
    private $database = 'c1602108_tienda';
    private $username = 'c1602108_admin';
    private $password = 'Semillita23';
    private $charset = 'utf8';

    function conectar()
    {
        try{
            $conexion="mysql:host=" . $this->hostname  . ";dbname=" . $this->database . ";
            charset=" . $this->charset;

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $pdo = new PDO($conexion, $this->username, $this->password, $options);

            return $pdo;
        } catch(PDOException $e)
        {
            die('Error conexión: ' . $e->getMessage() . ' ' . print_r($pdo->errorInfo(), true));
            exit;
        }
    }
}








?>