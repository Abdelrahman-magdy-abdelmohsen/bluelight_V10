
<?php
include_once("header.php");

?>

<head>
    <link rel="stylesheet" href="<?= path?>front/css/index.css">
    <link rel="stylesheet" href="<?= path?>front/css/swiper-bundle.min.css">
</head>
<div id="carouselExampleInterval" class="carousel slide mb-3" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="5000">
            <img src="<?=path?>front/imgs/offer1.png" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item" data-bs-interval="5000">
            <img src="<?= path?>front/imgs/offer2.png" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item"data-bs-interval="5000">
            <img src="<?=path?>front/imgs/offer3.png" class="d-block w-100" alt="...">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="title">
    <h3 class="text-center mb-3">Shop by Brand</h3>
</div>

<!-- Your HTML content -->
<div class="brand mb-4">
    <div class="swiper-container-brands">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="<?= path ?>front/brands/schneider.png" alt="Schneider" class="img-fluid">
            </div>
            <div class="swiper-slide">
                <img src="<?= path ?>front/brands/osram.png" alt="Osram" class="img-fluid">
            </div>
            <div class="swiper-slide">
                <img src="<?= path ?>front/brands/osram.png" alt="Chint" class="img-fluid">
            </div>
            <div class="swiper-slide">
                <img src="<?= path ?>front/brands/Bosch.png" alt="Bosch" class="img-fluid">
            </div>
            <div class="swiper-slide">
                <img src="<?= path ?>front/brands/philips.png" alt="Philips" class="img-fluid">
            </div>
            <div class="swiper-slide">
                <img src="<?= path ?>front/brands/philips.png" alt="Philips" class="img-fluid">
            </div>
            <div class="swiper-slide">
                <img src="<?= path ?>front/brands/philips.png" alt="Philips" class="img-fluid">
            </div>
            <div class="swiper-slide">
                <img src="<?= path ?>front/brands/Bosch.png" alt="Bosch" class="img-fluid">
            </div>
            <!-- Add more brand images here -->
        </div>
        <!-- Navigation arrows -->
        <div class="swiper-button-prev prev"></div>
        <div class="swiper-button-next next"></div>
        <!-- If you want pagination -->
        <div class="swiper-pagination"></div>
    </div>
</div>

<div class="container">
    <h3 class="text-center align-items-center mb-3">Latest</h3>

    <!-- Products Slider -->
    <div class="products mb-4">
        <div class="swiper-container-products">
            <div class="swiper-wrapper">
                <?php foreach ($products as $final) { ?>
                    <div class="swiper-slide">
                        <!-- Product Card Structure -->
                        <div class='card'>
                            <a href='<?= path ?>product/product_details/<?= str_replace(' ', '-', $final['name']) ?>' class='text-decoration-none text-dark'>
                                <img class='card-img-top img-fluid' src='<?= path ?>front/products/<?= $final['img'] ?>'>
                                <div class='card-body rounded-4 mt-1'>
                                    <p class='card-title'><?= substr(str_replace('-', ' ', $final['name']), 0, 30) ?></p>
                                    <p class='card-text'><?= substr($final['description'], 0, 30) ?></p>
                                    <h6 class='card-subtitle mb-2 text-muted'>Price: $<?= $final['price'] ?></h6>
                                </div>
                                <div class='card-footer'>
                                    <a href='#' class='btn btn-primary rounded-pill'>Add to Cart</a>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- Navigation arrows for Products -->
            <div class="swiper-product-button-prev swiper-button-prev"></div>
            <div class="swiper-product-button-next swiper-button-next"></div>
            <!-- Pagination for Products -->
            <div class="swiper-pagination-product"></div>
        </div>
    </div>
</div>

<div class="push"></div>
</div>
<?php require_once 'footer.php'?>
<script src="<?= path?>front/js/index.js"> </script>
<script src="<?=path?>front/js/swiper-bundle.min.js"></script>

<script>
    var swiper = new Swiper('.swiper-container-brands', {
        slidesPerView: 5,
        spaceBetween: 10,
        sliderPerGroup: 5,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },

        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            520: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            1000: {
                slidesPerView: 7,
            },
        },
    });

    var swiper2 = new Swiper('.swiper-container-products', {
        slidesPerView: 4,
        spaceBetween: 20,
        navigation: {
            nextEl: '.swiper-product-button-next',
            prevEl: '.swiper-product-button-prev',
        },
        pagination: {
            el: '.swiper-pagination-product',
            clickable: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            },
            1200: {
                slidesPerView: 4,
            },
        },
    });
</script>
