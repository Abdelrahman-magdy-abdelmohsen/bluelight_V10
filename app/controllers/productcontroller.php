<?php
namespace MVC\controllers;
use MVC\core\controller;
use MVC\models\cart;
use Rakit\Validation\Validator;
use MVC\core\Session;
use MVC\core\helper;
use PHPMailer\PHPMailer\PHPMailer;
use MVC\models\index;
use MVC\models\product_details;

class productcontroller extends controller
{
    public function __construct()
    {
        session::Start();
    }

    public function product_details($name)
    {

        if (empty($name)) {
            helper::redirect('home/index');
        }

        $user_data = Session::Get('user');
        $product_details = new product_details();
        $product = $product_details->get_product($name);
        $category_id = $product['category_id'];
        $product_id = $product['id'];
        $related_products = $product_details->related_products($category_id, $product_id);
        $stock = $product['qty'];
        // Check if a message parameter exists in the URL (for not logged-in or product added success message)
        $message = isset($_GET['message']) ? urldecode($_GET['message']) : null;
        $add_successfully = isset($_GET['add_message']) ? urldecode($_GET['add_message']) : null;
        $refresh = isset($_GET['refresh']) ? true : false;
        $this->view("product/product_details", [
            'title' => 'productdetails',
            'product' => $product,
            'related_pro' => $related_products,
            'not_logged' => $message,
            'add_successfully' => $add_successfully,
            'refresh' => $refresh // Pass the 'refresh' parameter to the view
        ]);
    }

    public function add_to_cart($name)
    {
        $user_data = Session::Get('user');
        $qty = $_POST['qty'];

        // Check if the quantity is less than 1
        if ($qty < 1) {
            // Redirect to product details with an 'out of stock' message
            $message = urlencode('cannot add less than 1 to cart.');
            helper::redirect("product/product_details/{$name}/?message=$message&refresh=true");
            exit();
        }

        // Check if the user is not logged in
        if (!$user_data || !isset($user_data['id'])) {
            // User is not logged in, redirect to product details with a message
            $message = urlencode('You should log in to add a product.');
            helper::redirect("product/product_details/{$name}/?message=$message&refresh=true");
            exit();
        }

        $user_id = $user_data['id'];
        $product_data = new product_details();
        $product = $product_data->get_product($name);
        $cart = new cart();

        // Check if the product already exists in the cart for the user
        $check = $cart->check_pro_cart_exist($product['id'], $user_id);

        if ($check) {
            $cart = new cart();
            $res =  $cart->pro_cart_qty($user_data['id'], $product['id']);
            $current_cart_qty = $res['qty']; // Contains the current product quantity in the cart

            // Calculate the total quantity including the current cart quantity and the requested quantity
            $total_qty = $current_cart_qty + $qty;

            // Ensure that the total quantity doesn't exceed the available stock
            if ($total_qty > $product['qty']) {
                // Redirect to product details with an 'out of stock' message
                $message = urlencode('Requested quantity exceeds available stock.');
                helper::redirect("product/product_details/{$name}/?message=$message&refresh=true");
                exit();
            }

            // Product exists in the cart, update the quantity
            $cart->update_pro_cart($user_id, $product['id'], $current_cart_qty, $qty);
        }
        else {
            // Product doesn't exist in the cart, add a new entry
            $cart_item_data = [
                'user_id' => $user_id,
                'product_id' => $product['id'],
                'qty' => $qty
            ];
            $cart->add_to_cart($cart_item_data);
        }

        // Redirect to product details with a success message
        $add_successfully = 'The product was added successfully';
        helper::redirect("product/product_details/{$name}/?add_message=$add_successfully&refresh=true");
        exit();
    }

    public function cart_items()
    {
        if((Session::Get('user'))){
            $user =   Session::Get('user');
            $userid = $user['id'];

            $cart = new cart();
            $data = $cart->show_cart_items($userid);
            $this->view("product/cart_items",['title'=>'cart_items','cart_items'=>$data]);
        }
        $this->view("product/cart_items",['title'=>'cart_items']);



    }
    public function delete_from_cart($id)
    {

     $product  = new cart();
     $delete = $product->delete_product($id);
     if($delete){
         helper::redirect('product/cart_items');
     }
     else{
         echo "there is error happend while deleting";
     }

    }
}