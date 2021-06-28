<?php
    require_once("../../db/db.php");
    require_once("../../classes/product.php");

    function buyProduct($id, $name, $quantity){
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
                echo "Product " . $name . " not found!";
            } else{
               if($quantity > $product->quantity){
                   echo "Product " . $name . " not in stock!";
               } else{
                $updateProductSql = "UPDATE products SET quantity=?-? WHERE id=?";
                $updateProductStmt = $connection->prepare($updateProductSql);
                $updateProductStmt->execute([$product->quantity, $quantity, $id]);
               }
            }          
        } catch (PDOException $e) {
            echo $e->getMessage();
        }  
    }
?>