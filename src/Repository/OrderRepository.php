<?php

namespace App\Repository;
use App\Entity\Option;
use App\Entity\Order;
use App\Entity\Product;

class OrderRepository {
    public function findAll(): array
    {
        $list = [];
        $connection = Database::getConnection();

        $query = $connection->prepare("SELECT * FROM orderres");

        $query->execute();

        foreach ($query->fetchAll() as $line) {
            $list[] = new Order($line["createAt"], $line["customerName"], $line["id_product"], $line["id"]);
        }

        return $list;
    }

    public function persist(Order $order) {
        
        $connection = Database::getConnection();

        $query = $connection->prepare("INSERT INTO orderres (createAt, customerName, id_product) VALUES (:createAt, :customerName, :id_product)");
        $query->bindValue(':createAt', $order->getCreatAt());
        $query->bindValue(':customerName', $order->getCustomerName());
        $query->bindValue(':id_product', $order->getIdProduct());

        $query->execute();
        $order->setId($connection->lastInsertId());
        
    }
    public function update(Order $order) {
        
        $connection = Database::getConnection();

        $query = $connection->prepare("UPDATE orderres SET createAt=:createAt customerName=:customerName id_product=:id_product WHERE id=:id");
        $query->bindValue(':createAt', $order->getCreatAt());
        $query->bindValue(':customerName', $order->getCustomerName());
        $query->bindValue(':id_product', $order->getIdProduct());
        $query->bindValue(":id", $order->getId());

        $query->execute();
    }

    public function delete(int $id) {

        $connection = Database::getConnection();

        $query = $connection->prepare("DELETE FROM orderres WHERE id=:id");
        $query->bindValue(":id", $id);
        $query->execute();
    }

    public function FindProductbyOrderresId(int $id):?Product {
        $connection = Database::getConnection();
        $query = $connection->prepare("SELECT * FROM orderres, product WHERE orderres.id_product = product.id AND product.id=:id;");
        $query->bindValue(':id', $id);
        $query->execute();
        foreach ($query->fetch() as $line) {
            return new Product($line["label"], $line["basePrice"], $line["description"], $line["picture"], $line["id_shop"], $line["id_product"]);
        }
        return null;
    }

    public function FindOptionByOrderId(int $id):array{
        $list=[];
        $connect= Database::getConnection();
        $req = "SELECT * FROM orderres 
        INNER JOIN option_order ON orderres.id = option_order.id_order
        INNER JOIN optionnes ON option_order.id_option=optionnes.id
        WHERE orderres.id =:id";

        $query=$connect->prepare($req);
        $query->bindValue(":id",$id);
        $query->execute();
        
        foreach ($query->fetchAll() as $line) {
            $list[]=new Option($line['label'],$line['price'],$line['id_product'],$line['id_option']);
        }
        return $list;
    }
    
}
