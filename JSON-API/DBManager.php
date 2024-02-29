<?php

class DbManager
{
    public static function Connect($dbname)
    {
        $dsn = "mysql:dbname={$dbname};host=192.168.2.200";
        try {
            $pdo = new PDO($dsn, 'stefano_greggio_1f', 'Januaries.quarrel.wall.');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $exception) {
            throw new PDOException("connesione al DataBase fallita");
        }
    }
}