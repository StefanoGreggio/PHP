<?php

class Cart
{
    private $id;
    private $user_id;

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public static function Create($current_UserID)
    {
        $pdo = self::Connect();
        $stmt = $pdo->prepare("INSERT INTO ecommerce.carts (user_id) VALUES (:user_id)");
        $stmt->bindParam(":user_id", $current_UserID);
        if ($stmt->execute()) {
            $stmt = $pdo->prepare("select * from ecommerce.carts where user_id=:user_id");
            $stmt->bindParam("user_id", $current_UserID);
            $stmt->execute();
            $cart = $stmt->fetchObject("Cart");
            return $cart;
        } else {
            throw new PDOException("Errore");
        }
    }

    public static function Find($user_id)
    {
        $pdo = self::Connect();
        $stmt = $pdo->prepare("select * from ecommerce.carts where user_id = :user_id");
        $stmt->bindParam(":user_id", $user_id);
        if ($stmt->execute()) {
            return $stmt->fetchObject("Cart");
        } else {
            return false;
        }
    }

    public function addProduct($params)
    {
        $pdo = self::Connect();
        $cartId = $this->getId();
        $stmt = $pdo->prepare("INSERT INTO ecommerce.cart_products (cart_id, product_id, quantita) VALUES (:cart_id, :product_id, :quantita)");
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->bindParam(':product_id', $params['product_id']);
        $stmt->bindParam(':quantita', $params['quantita']);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateProduct($params)
    {
        $pdo = self::Connect();
        $cartId = $this->getId();
        $stmt = $pdo->prepare("UPDATE ecommerce.cart_products SET quantita = :quantita WHERE cart_id = :cart_id AND product_id = :product_id");
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->bindParam(':product_id', $params['product_id']);
        $stmt->bindParam(':quantita', $params['quantita']);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function removeProduct($product_id)
    {
        $pdo = self::Connect();
        $cartId = $this->getId();
        $stmt = $pdo->prepare("DELETE FROM ecommerce.cart_products WHERE cart_id = :cart_id AND product_id = :product_id");
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->bindParam(':product_id', $product_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getProducts()
    {
        $pdo = self::Connect();
        $cartId = $this->getId();
        $stmt = $pdo->prepare("SELECT product_id, quantita FROM ecommerce.cart_products WHERE cart_id = :cart_id");
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotal()
    {
        $total = 0;

        foreach ($this->getProducts() as $productInCart) {
            $product = Product::Find($productInCart['product_id']);
            $total += $productInCart['quantita'] * $product->getPrezzo();
        }

        return $total;
    }

    public static function Connect()
    {
        return DbManager::Connect("ecommerce");
    }
}