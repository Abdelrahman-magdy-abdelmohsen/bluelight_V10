<?php
include_once VIEWS . "home/header.php";

if (isset($add_successfully)) {
    echo "<div class='alert alert-success'>$add_successfully</div>";
}
if (isset($not_logged)) {
    echo "<div class='alert alert-danger'>$not_logged</div>";
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= path ?>front/css/product_details.css"/>
    <link rel="stylesheet" href="<?= path ?>front/css/root.css"/>
    <style>
        .out-of-stock-message {
            display: <?= $product['qty'] < 1 ? 'block' : 'none' ?>;
            color: red;
        }
        .out-of-stock .add_cart_btn,
        .out-of-stock .buy_btn,
        .out-of-stock .quantity {
            display: <?= $product['qty'] < 1 ? 'none' : 'block' ?>;
        }
    </style>
</head>
<body>

<div class="container pb-3 pt-3 mt-5 ">
    <div class="row">
        <div class="box col-lg-6 col-sm-12 col-md-6">
            <div class="img">
                <img src="<?= path ?>front/products/<?= $product['img'] ?>" class="img-fluid p-5">
            </div>
            <div class="features d-flex justify-content-between mt-3">
                <div class="d-flex flex-column">
                    <i class="fa-solid fa-wallet  feature_icon mb-2"></i>
                    Cash on delivery
                    <p class="text-center"> cash or card</p>
                </div>
                <div class="d-flex flex-column">
                    <i class="fa-solid fa-arrow-rotate-left feature_icon mb-2"></i>
                    Return for free
                    <p class="text-center"> up to 14 days</p>
                </div>
                <div>

                </div>

            </div>
        </div>
        <div class="box col-lg-6 col-sm-12 col-md-6">
            <div class="details_pro">
                <h5 class=" fs-5 d-flex justify-content-between"><?= $product['brand'] ?>
                <h5 class=" fs-5 d-flex justify-content-between"><?= $product['name'] ?>
                    <span><i class="fa-solid fa-share-nodes share_icon rounded-pill"></i></span></h5>
                <div class="description">
                    <p><?= $product['description'] ?></p>
                </div>
                <div class="price">
                    <h5 class="price"><?= $product['price'] ?> <span>EGP</span></h5>
                </div>
                <div class="stock">
                    <p><?= $product['qty'] ?> in stock</p>
                    <p class="out-of-stock-message" style="display: <?= $product['qty'] < 1 ? 'block' : 'none' ?>">Out of Stock</p>
                </div>
                <div class="product_imgs d-flex flex-row">
                    <img src="<?= path ?>front/products/<?= $product['img'] ?>" class="img-fluid">
                    <img src="<?= path ?>front/products/<?= $product['img'] ?>" class="img-fluid">
                </div>
                <div class="stock">
                    <p> in stock</p>
                </div>
                <form method="post" class="add_cart" action="<?= path ?>product/add_to_cart/<?= $product['name'] ?>">
                    <?php if ($product['qty'] >= 1): ?>
                        <input type="number" min="1" max="<?= $product['qty']?>" class="quantity rounded-pill p-lg-2" value="1" name="qty">
                        <button class="add_cart_btn">
                            <i class="fas fa-cart-shopping"></i>
                            Add to Cart
                        </button>
                        <input type="submit" value="buy now" class="rounded-pill p-lg-2 p-3 buy_btn">
                    <?php endif; ?>
                    <span class="add_fav rounded-pill">
                        <i class="fa-regular fa-heart"></i>
                    </span>
                </form>
            </div>
            <hr>
            <p><i class="fa-solid fa-truck deliver_icon"></i> Doorstep delivery, as soon as Today, Fri, 8 December</p>
            <div class="sold_by">
                <p> sold by : <span>bluelight</span></p>
                <i class="fa-solid fa-star star_icon"></i>
                <i class="fa-solid fa-star star_icon"></i>
                <i class="fa-solid fa-star star_icon"></i>
                <i class="fa-solid fa-star star_icon"></i>
                <i class="fa-solid fa-star star_icon"></i>
            </div>
        </div>
    </div>
</div>

<?php
echo "<h4 class='text-center'> related product </h4>";
echo "<div class='related d-flex justify-content-center align-items-center'>";
echo "<div class='row g-4 m-auto'>";

foreach ($related_pro as $final) {
    echo "<div class='col-sm-6 col-md-4 col-lg-3'>";
    $productName = str_replace(' ', '-', $final['name']);
    echo "<a href='" . path . "product/product_details/" . $productName . "' class='text-decoration-none text-dark'>";
    echo "<div class='card'>";
    echo "<img class='card-img-top img-fluid' src='" . path . "front/products/" . $final['img'] . "'>";
    echo "<div class='card-body rounded-4 mt-1'>";
    echo "<p class='card-title'>" . substr(str_replace('-',' ',$final['name']),0,30). "</p>";
    echo "<p class='card-text'>" .substr($final['description'],0,30) . "</p>";
    echo "<h6 class='card-subtitle mb-2 text-muted'>Price: $" . $final['price'] . "</h6>";
    echo "</div>";
    echo "<div class='card-footer'>";
    echo "<a href='#' class='btn btn-primary rounded-pill'>Add to Cart</a>";
    echo "</div>";
    echo "</div>";
    echo "</a>"; // Closing the <a> tag for each product
    echo "</div>";
}

echo "</div>";
echo "</div>";
?>

<?php if (isset($refresh) && $refresh) : ?>
    <script>
        // Refresh the page after 2 seconds
        setTimeout(function () {
            window.location.href = '<?= path ?>product/product_details/<?= $product['name'] ?>';
        }, 2000); // 2000 milliseconds (2 seconds)
    </script>
<?php endif; ?>

</body>
</html>
