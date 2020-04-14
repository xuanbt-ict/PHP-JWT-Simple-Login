<?php

class Database
{
    public function getConnection()
    {
        try {
            $dbConnection = new PDO(
                "mysql:host=127.0.0.1;port=3306;charset=utf8mb4;dbname=homestead",
                'homestead',
                'password'
            );
            return $dbConnection;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
