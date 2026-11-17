<?php

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $config = require __DIR__ . '/../config/database.php';

        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            
            error_log('Database connection failed: ' . $e->getMessage());
            throw new Exception('Sorry, we could not connect to the database right now.');
        }
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}