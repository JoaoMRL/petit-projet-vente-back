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
            $list[] = new Option($line["label"], $line["price"], $line["id_product"], $line["id"]);
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

        $query = $connection->prepare("UPDATE optionnes SET label=:label, price=:price, id_product=:id_product WHERE id=:id");
        $query->bindValue(':label', $optionnes->getLabel());
        $query->bindValue(':price', $optionnes->getPrice());
        $query->bindValue(':id_product', $optionnes->getId_product());
        $query->bindValue(":id", $optionnes->getId());

        $query->execute();
    }

    public function persist(Option $optionnes) {
        $connection = Database::getConnection();

        $query = $connection->prepare("INSERT INTO optionnes (label, price,id_product) VALUES (:label, :price, :id_product)");
        $query->bindValue(':label', $optionnes->getLabel());
        $query->bindValue(':price', $optionnes->getPrice());
        $query->bindValue(':id_product', $optionnes->getId_product());

        $query->execute();

        $optionnes->setId($connection->lastInsertId());
    }


}