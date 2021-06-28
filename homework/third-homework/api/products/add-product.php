<?php
    require_once("../../db/db.php");
    require_once("../../classes/product.php");

    function addProduct($id, $name, $quantity){
        try {
            $db = new DB();
            $connection = $db->getConnection();

            $quantitySql = "SELECT * FROM products WHERE id=?";
            $quantityStmt = $connection->prepare($quantitySql);
            $quantityStmt->execute([$id]);
            $rows = $quantityStmt->rowCount();

            $product = null;

            while($row = $quantityStmt->fetch(PDO::FETCH_ASSOC)){
                $product = new Product($row["id"], $row["name"], $row["quantity"]);
            }

            if(!$rows){
                $addProductSql = "INSERT INTO products (id, name, quantity) VALUES (?, ?, ?)";
                $addProductStmt = $connection->prepare($addProductSql);
                $addProductStmt->execute([$id, $name, $quantity]);
            } else{
                $updateProductSql = "UPDATE products SET quantity=?+? WHERE id=?";
                $updateProductStmt = $connection->prepare($updateProductSql);
                $updateProductStmt->execute([$product->quantity, $quantity, $id]);
            }          
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
?>