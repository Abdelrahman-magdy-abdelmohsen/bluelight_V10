<?php
include_once VIEWS . "home/header.php";
?>
<!doctype html>
<html lang="en">
<head>

    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= path ?>front/css/cart_items.css">
</head>
<body>
<?php if (empty($cart_items)) : ?>
    <div class="empty-cart-message text-center d-flex justify-content-center align-items-center flex-column ">
        <img src="<?=path?>front/imgs/empty_cart.png" class="mb-2">
        <h3>Your cart is empty !!</h3>
        <p class="col-lg-6 col-md-6">
            You haven’t added any products to your cart yet. Browse products and add them to your cart for a quick checkout process.
        </p>
        <a href="<?=path?>home/index" class="btn btn-primary rounded-2">Continue shopping</a>
    </div>
<?php else : ?>
    <div class="con mt-3 mb-3 p-3">
        <div class="title d-flex justify-content-between">
            <div>Shopping Cart</div>
            <div id="items_count"><?= count($cart_items) ?> Items</div>
        </div>
        <hr>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="text-center">Image</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Remove</th>
                    <th class="text-center">Total Price</th>
                </tr>
                </thead>
                <!-- ... -->
                <?php foreach ($cart_items as $item) : ?>
                    <tr>
                        <td class="text-center"><img src="<?= path . 'front/products/' . $item["img"] ?>" alt="<?= $item["name"] ?>" class="img-thumbnail"></td>
                        <td class="text-center"><?= $item["name"] ?></td>
                        <td class="text-center"><input type="number" min="1" max="3" class="form-control quantity" value="<?= $item["qty"] ?>" data-product-id="<?= $item["product_id"] ?>"></td>
                        <td class="text-center"><span class="price"><?= $item["price"] ?></span></td>
                        <td class="text-center"><a href="delete_from_cart/<?= $item['id'] ?>" class="remove_item" data-product-id="<?= $item["product_id"] ?>"> <span> <i class="fa-solid fa-trash remove-icon"></i> </span></a></td>
                        <td class="text-center"><?= number_format($item["price"] * $item["qty"], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <!-- ... -->
            </table>
        </div>

        <?php
        // Calculate Subtotal
        $subtotal = 0;
        foreach ($cart_items as $item) {
            $itemTotalPrice = $item["price"] * $item["qty"];
            $subtotal += $itemTotalPrice;
        }
        ?>
        <div class="order_summary">
            <div>Subtotal: <span id="subtotal"><?= number_format($subtotal, 2) ?></span></div>
            <div class="total">Total: <span id="total"><?= number_format($subtotal, 2) ?></span></div>
        </div>
    </div>
<?php endif; ?>
