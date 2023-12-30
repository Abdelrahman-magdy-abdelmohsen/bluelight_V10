<?php
namespace MVC\models;

use MVC\core\model;

class cart extends model
{


    public function add_to_cart($data)
    {
        $product = model::db()->insert('cart_item',$data);
        return $product;
    }
    public function check_pro_cart_exist($id, $user_id)
    {
        $product = model::db()->run("SELECT * FROM cart_item WHERE product_id = ? AND user_id = ?", [$id, $user_id])->fetch();
        return ($product !== false); // Return true if product exists, false otherwise
    }
    public function update_pro_cart($id, $product_id, $current_qty, $qty_added)
    {
        $updated_qty = $current_qty + $qty_added; // Calculate the new quantity by adding the provided quantity

        $product = model::db()->update('cart_item', ['qty' => $updated_qty], ['user_id' => $id, 'product_id' => $product_id]);
        return $product;
    }
    public function pro_cart_qty($user_id, $product_id)
    {
        $product = model::db()->run('SELECT qty FROM cart_item WHERE user_id = ? AND product_id = ?', [$user_id, $product_id])->fetch();
        return $product;
    }
    public function show_cart_items($user_id)
    {
        $product = model::db()->run('SELECT p.name, p.img, ci.qty, p.price,ci.product_id,ci.id FROM cart_item ci INNER JOIN product p ON ci.product_id = p.id WHERE ci.user_id = ?',[$user_id])->fetchALL();
        return $product;
    }
    public function delete_product($id)
    {
        $product = model::db()->deleteById('cart_item', $id);
        return $product;
    }





}
?>
