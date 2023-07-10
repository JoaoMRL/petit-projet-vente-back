-- SQLBook: Code
-- Active: 1688647729271@@127.0.0.1@3306@projet_vente
CREATE DATABASE projet_vente
    DEFAULT CHARACTER SET = 'utf8mb4';
    
USE projet_vente;

DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS shop;
DROP TABLE IF EXISTS optionnes;
DROP TABLE IF EXISTS orderres;
DROP TABLE IF EXISTS option_order;


CREATE TABLE shop (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL
);
CREATE TABLE product (
    id INT PRIMARY KEY AUTO_INCREMENT,
    label VARCHAR(255) NOT NULL,
    basePrice FLOAT NOT NULL,
    description TEXT NOT NULL,
    picture TEXT,
    id_shop INT,
    FOREIGN KEY(id_shop) REFERENCES shop(id)ON DELETE CASCADE
);
CREATE TABLE optionnes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    label VARCHAR(255) NOT NULL,
    price FLOAT NOT NULL,
    idProduct INT,
    FOREIGN KEY(idProduct) REFERENCES product(id)ON DELETE CASCADE
);
CREATE TABLE orderres (
    id INT PRIMARY KEY AUTO_INCREMENT,
    createAt DATETIME NOT NULL,
    customerName VARCHAR(255) NOT NULL,
    idProduct INT,
    FOREIGN KEY(idProduct) REFERENCES product(id)ON DELETE CASCADE
);

CREATE TABLE option_order (
    id_option INT,
    id_order INT,
    PRIMARY KEY (id_option,id_order),
    Foreign Key (id_option) REFERENCES optionnes(id) ON DELETE CASCADE,
    Foreign Key (id_order) REFERENCES orderres(id) ON DELETE CASCADE
);

INSERT INTO shop (name,address) VALUES ('Micromania','23 Grand Rue'),('Game Cash','20 Avenue de la Periaz'),('EGaming','15 rue du Commerce');
INSERT INTO product (label,basePrice,description,id_shop) VALUES ('PS5',500,'PS5 New Generation',1),('PS5 slim',400,'PS5 Slim bien plus fine que la normale',2),('XBOX ONE',500,'Non ce n est pas la première Xbox',1),('Nintendo SWITCH',499.99,'Console de Nintendo',3);
INSERT INTO optionnes (label, price,idProduct) VALUES ('Spider-Man', 79.99,1), ('FIFA 23', 59.99,2), ('Miitopia', 49.99,3);
INSERT INTO orderres (createAt,customerName,idProduct) VALUES ('2020-08-16','Eurenie',1),('2021-10-06','Marco',2),('2019-07-12','Xiaoyu',4);
INSERT INTO option_order (id_option,id_order) VALUES (1,1),(2,1),(3,3),(1,2),(2,2),(3,2);

SELECT * FROM product;
SELECT * FROM shop;
SELECT * FROM optionnes;
SELECT * FROM orderres;
SELECT * FROM option_order;
SELECT * FROM product WHERE label LIKE '%PS%';





SELECT *, orderres.id AS ordreduchaos_id  FROM shop 
LEFT JOIN product ON shop.id = product.id_shop
INNER JOIN orderres ON product.id = orderres.id_product;

SELECT * FROM product INNER JOIN optionnes ON product.id = optionnes.id_product WHERE product.id = 2;

SELECT *, product.id AS product_id FROM product 
INNER JOIN shop ON shop.id = product.id_shop WHERE shop.id = 1;
 

SELECT *FROM orderres, product WHERE orderres.id_product = product.id AND product.id=1;

SELECT * FROM orderres 
INNER JOIN option_order ON orderres.id = option_order.id_order
INNER JOIN optionnes ON option_order.id_option=optionnes.id
WHERE orderres.id =1;


