<?php 

namespace App\Repository;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Shop;

class ShopRepository{

    /**
     * @return Shop[] La liste des shops contenus dans la bdd
     */
    public function findAll():array{
        $list = [];
        $req ="SELECT * FROM shop" ;
        $connect = Database::getConnection();


        $query = $connect->prepare($req);
        $query->execute();

        foreach ($query->fetchAll() as $line) {
            $list[]=new Shop($line['name'],$line['address'],$line['id']) ;
        }
        return $list;
    }

    public function findOrderByShop(int $id):array{
        $list=[];
        $req ="SELECT *, orderres.id AS ordreduchaos_id   FROM shop 
        LEFT JOIN product ON shop.id = product.id_shop
        INNER JOIN orderres ON product.id = orderres.id_product";
        $connect = Database::getConnection();

        $query= $connect->prepare($req);
        $query->execute();
        foreach ($query->fetchAll() as $line) {
            $list[]=new Order(new \DateTime($line['createAt']),$line['customerName'],$line['id_product'],$line['ordreduchaos_id']);
        }
        return $list;

    }
    public function findProductByShop(int $id) : array {
        $list = [];
        $connection = Database::getConnection();
        $query = $connection ->prepare("SELECT *, product.id AS product_id FROM product 
        INNER JOIN shop ON shop.id = product.id_shop WHERE shop.id = 1");
        $query -> bindValue(":id", $id);
        $query -> execute();

        foreach ($query->fetchAll() as $line) {
            $list[]=new Product($line["label"], $line["basePrice"], $line["description"], $line["picture"], $line["id_shop"], $line["id"]);
        }
        return $list;
    }

    public function persist(Shop $shop) {
        
        $connection = Database::getConnection();

        $query = $connection->prepare("INSERT INTO shop (name, address) VALUES (:name, :adress)");
        $query->bindValue(':name', $shop->getName());
        $query->bindValue(':adress', $shop->getAddress());

        $query->execute();
        $shop->setId($connection->lastInsertId());
    }
    public function update(Shop $Shop){
        $connect = Database::getConnection();
        $req = "UPDATE shop SET name=:name, address=:address WHERE id=:id";

        $query=$connect->prepare($req);
        $query->bindValue(":name",$Shop->getName());
        $query->bindValue(":address",$Shop->getAddress());
        $query->bindValue(":id",$Shop->getId());
        $query->execute();
    }




    public function delete(int $id):void{
        $connection = Database::getConnection();

        $query = $connection->prepare("DELETE FROM shop WHERE id=:id");
        $query->bindValue(":id", $id);
        $query->execute();
    }
        
}