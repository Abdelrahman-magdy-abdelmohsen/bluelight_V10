<?php
namespace MVC\models;

use MVC\core\model;

class product_details extends model
{


    public function get_product($name)
    {
        $product = model::db()->run("SELECT * FROM product where name = ?",[$name])->fetch();
        return $product;

    }

    public function related_products($category_id, $currentProductID)
    {
        $relatedProducts = model::db()->run("SELECT *  FROM product WHERE category_id = ? AND id <> ?", [$category_id, $currentProductID])->fetchAll();

        return $relatedProducts;
    }


}
?>
