<?php 

namespace App\Repository;
use App\Entity\Product;

class ProductRepository{

    /**
     * @return Product[] La liste des produits dans la bdd
    */
    public function findAll():array{
        $list = [];
        $req ="SELECT * FROM product" ;
        $connect = Database::getConnection();


        $query = $connect->prepare($req);
        $query->execute();

        foreach ($query->fetchAll() as $line) {
            $list[]=new Product($line['label'],$line['basePrice'],$line['description'],$line['picture'],$line['id_shop'],$line['id']);
        }
        return $list;
    }

    /**
     * Methode qui récupère une instance de Product en arguement
     * et la fait persister dans la bdd
     * @param $prod Le produit que l'on souhaite faire persister
    */
    public function persist(Product $prod){
        $connect = Database::getConnection();
        $req = "INSERT INTO product 
        (label,basePrice,descritpion,picture,id_shop)
        VALUES (:lab,:basPri,:descr,:pic,:idShop)";
        
        $query=$connect->prepare($req);
        $query->bindValue(":lab",$prod->getLabel());
        $query->bindValue(":basPri",$prod->getBasePrice());
        $query->bindValue(":descr",$prod->getDescription());
        $query->bindValue(":pic",$prod->getPicture());
        $query->bindValue(":idShop",$prod->getIdShop());
        $query->execute();

        $prod->setId($connect->lastInsertId());
    }

    /**
     * Methode qui permet de supprimer un produit de la bdd
     * 
     *@param $id (L'id du produit à supprimer)
    */
    public function delete(int $id){
        $connect = Database::getConnection();
        $req = "DELETE FROM product WHERE id = :id";

        $query=$connect->prepare($req);
        $query->bindValue(":id",$id);
        $query->execute();
    }

    /**
     * Méthode pour mettre à jour un product existant
     * 
     * @param Product $prod Le produit à mettre à jour.
    */
    public function update(Product $prod){
        $connect = Database::getConnection();
        $req = "UPDATE product SET label=:lab, basePrice=:basPri, description=:descr, picture=:pic, id_shop=:idShop WHERE id=:id";

        $query=$connect->prepare($req);
        $query->bindValue(":lab",$prod->getLabel());
        $query->bindValue(":basPri",$prod->getBasePrice());
        $query->bindValue(":descr",$prod->getDescription());
        $query->bindValue(":pic",$prod->getPicture());
        $query->bindValue(":idShop",$prod->getIdShop());
        $query->bindValue(":id",$prod->getId());
        $query->execute();
    }

    public function findById(int $id):?Product {

        $connection = Database::getConnection();

        $query = $connection->prepare("SELECT * FROM product INNER JOIN optionnes ON product.id = optionnes.id_product WHERE product.id =:id");
        $query->bindValue(":id", $id);
        $query->execute();

        foreach ($query->fetchAll() as $line) {
            return new Product($line["label"], $line["basePrice"], $line["description"], $line["picture"], $line["id_shop"], $line["id"]);
        }
        return null;

    }


}