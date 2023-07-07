<?php

namespace App\Repository;
use App\Entity\Option;

class OptionRepository 
{
    public function findAll(): array
    {
        $list = [];
        $connection = Database::getConnection();

        $query = $connection->prepare("SELECT * FROM optionnes");

        $query->execute();

        foreach ($query->fetchAll() as $line) {
            $list[] = new Option($line["label"], $line["price"], $line["idProduct"], $line["id"]);
        }

        return $list;
    }

    public function delete(int $id) {

        $connection = Database::getConnection();

        $query = $connection->prepare("DELETE FROM optionnes WHERE id=:id");
        $query->bindValue(":id", $id);
        $query->execute();
    }

    public function update(Option $optionnes) {
        
        $connection = Database::getConnection();

        $query = $connection->prepare("UPDATE optionnes SET label=:label, price=:price, idProduct=:idproduct WHERE id=:id");
        $query->bindValue(':label', $optionnes->getLabel());
        $query->bindValue(':price', $optionnes->getPrice());
        $query->bindValue(':idproduct', $optionnes->getIdProduct());
        $query->bindValue(":id", $optionnes->getId());

        $query->execute();
    }

    public function persist(Option $optionnes) {
        $connection = Database::getConnection();

        $query = $connection->prepare("INSERT INTO optionnes (label, price,idProduct) VALUES (:label, :price, :id_product)");
        $query->bindValue(':label', $optionnes->getLabel());
        $query->bindValue(':price', $optionnes->getPrice());
        $query->bindValue(':id_product', $optionnes->getIdProduct());

        $query->execute();

        $optionnes->setId($connection->lastInsertId());
    }
    public function findById(int $id):?Option{
        $req ="SELECT *FROM optionnes WHERE id = :id";
        $connect = Database::getConnection();

        $query= $connect->prepare($req);
        $query->bindValue(':id',$id);
        $query->execute();
        foreach ($query->fetchAll() as $line) {
            return new Option($line['label'],$line['price'],$line['idProduct']) ;
        }
        return null;

    }


}