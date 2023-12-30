<?php
namespace MVC\models;

use MVC\core\model;

class index extends model
{


    public function show_products()
    {
        $products = model::db()->run("SELECT id,name,price,description,img from product")->fetchAll();
        return $products; // Return the count of emails or password found
    }
    public function latest_products()
    {
        $products = model::db()->run("SELECT id, name, price, description, img FROM product ORDER BY created_at DESC  LIMIT 10")->fetchAll();
        return $products;
    }






}
?>
