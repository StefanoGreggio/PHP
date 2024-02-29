<?php

require 'DBManager.php';

class Product
{
    private $id;
    private $nome;
    private $prezzo;
    private $marca;


    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getPrezzo()
    {
        return $this->prezzo;
    }

    public function setPrezzo($prezzo)
    {
        $this->prezzo = $prezzo;
    }

    public function getMarca()
    {
        return $this->marca;
    }

    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    public static function Find($id)
    {
        $pdo = self::Connect();
        $stmt = $pdo->prepare("select * from Products where id = :id");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            return $stmt->fetchObject("Product");
        } else {
            return false;
        }
    }

    public static function Create($params)
    {
        $pdo = self::Connect();
        $stmt = $pdo->prepare("insert into Products (nome,prezzo,marca) values (:nome,:prezzo,:marca)");
        $stmt->bindParam(":nome", $params["nome"]);
        $stmt->bindParam(":prezzo", $params["prezzo"]);
        $stmt->bindParam(":marca", $params["marca"]);
        if ($stmt->execute()) {
            $stmt = $pdo->prepare("select * from Products order by id desc limit 1");
            $stmt->execute();
            return $stmt->fetchObject("Product");
        } else {
            throw new PDOException("Errore Nella Creazione");
        }
    }

    public static function FetchAll()
    {
        $pdo = self::Connect();
        $stmt = $pdo->query("select * from Products");
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
    }

    public function Update($params)
    {
        $pdo = self::Connect();
        $query = "Update Products SET";
        $count = 0;
        if (isset($params['nome']) && $params['nome'] != null) {
            $query = $query . " nome = :nome";
            $count++;
        }
        if ($count == 1 && count($params) > 1) {
            $query = $query . ", ";
        }
        if ($params['prezzo'] != null) {
            $query = $query . " prezzo = :prezzo";
            $count++;
        }
        if ($count <= 2 && count($params) > 1) {
            $query = $query . ", ";
        }
        if (isset($params['marca']) && $params['marca'] != null) {
            $query = $query . " marca = :marca";
        }
        $query = $query . " where id = :id";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":id", $this->id);
        if (isset($params['nome']) && $params['nome'] != null) {
            $stmt->bindParam(":nome", $params['nome']);
        }
        if ($params['prezzo'] != null) {
            $stmt->bindParam(":prezzo", $params['prezzo']);
        }
        if (isset($params['marca']) && $params['marca'] != null) {
            $stmt->bindParam(":marca", $params['marca']);
        }
        if ($stmt->execute()) {
            $stmt = $pdo->prepare("select * from Products where id=:id");
            $stmt->bindParam(":id", $this->id);
            $stmt->execute();
            return $stmt->fetchObject("Product");
        } else {
            throw new PDOException("Errore Nella Modifica");
        }

    }

    public function Delete()
    {
        $pdo = self::Connect();
        $stmt = $pdo->prepare("DELETE FROM Products WHERE id = :id");
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();

    }

    public static function Connect()
    {
        return DbManager::Connect("stefano_greggio_1f_ecommerce");
    }


}