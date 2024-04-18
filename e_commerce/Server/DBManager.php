<?php

class DbManager
{
    public static function Connect($dbname)
    {
        $dsn = "mysql:dbname={$dbname};host=localhost";
        try {
            $pdo = new PDO($dsn, 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $exception) {
            throw new PDOException("connesione al DataBase fallita");
        }
    }
}