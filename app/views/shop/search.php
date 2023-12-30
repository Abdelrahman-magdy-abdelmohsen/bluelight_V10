<?php
require_once VIEWS.'home/header.php';

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title?></title>
    <link rel="stylesheet" href="<?= path ?>front/css/search.css">
</head>
<body>

<?php if(isset($not_found)){
    echo $not_found;

}
if(isset($empty_search)){
    echo $empty_search;
}
?>
<div class="title">
    <h2 class="mt-5 ms-5"> search result: "<?= $_GET['search']?>"</h2>
    <h3 class="text-center mb-3">Shop by Brand</h3>
</div>

<!-- Your HTML content -->
<div class="container">
<div class="brand mb-4">
    <div class="swiper-container-brands">
        <div class="swiper-wrapper d-flex">
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
    <div class='order_by d-flex align-items-center justify-content-end mb-3'>

        <select id="orderBySelect" class="form-select form-select-sm w-25" aria-label=".form-select-sm example">
            <option selected>relevance </option>
            <option value="popularity">sort by popularity</option>
            <option value="latest">sort by latest</option>
            <option value="low_to_high">sort by low to high</option>
            <option value="high_to_low">sort by high to low</option>
        </select>
    </div>

    <div class="category_page  d-flex flex-lg-row  flex-md-row flex-sm-column ">
        <div class="filter_container col-sm-12 col-md-12 col-lg-12">
            <div class="filter-content d-none d-md-block">  <h5 class="mb-4">Filter by</h5>
                <div class="filter_category">
                    <h5>Categories</h5>
                </div>
            </div>
            <button class="filter-toggle btn btn-outline-secondary d-block d-md-none" aria-expanded="false">
                Show Filters
                <div class="filter-content d-none">  <h5 class="mb-4">Filter by</h5>
                    <div class="filter_category">
                        <h5>Categories</h5>
                    </div>
                </div>
            </button>
        </div>





         <div class='latest d-flex  align-items-center justify-content-center '>
             <div id="searchResults" class='row g-4'>
<?php
if(isset($result)){
    foreach ($result as $final) {
        echo "<div class='col-sm-6 col-md-4 col-lg-4 product'>";
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
}


?>
</div>
</div>
        <!-- Pagination section -->
        <div class="pagination-section mt-4">
            <ul class="pagination justify-content-center">
                <?php if ($totalPages > 1) : ?>
                    <?php if ($currentPage > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= path ?>shop/search/?search=<?= $_GET['search'] ?>&page=<?= $currentPage - 1 ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?= ($currentPage == $i) ? 'active' : '' ?>">
                            <a class="page-link" href="<?= path ?>shop/search/?search=<?= $_GET['search'] ?>&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages) : ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= path ?>shop/search/?search=<?= $_GET['search'] ?>&page=<?= $currentPage + 1 ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
</body>
</html>
<script src="<?=path?>front/js/swiper-bundle.min.js"></script>

<script>
    // Rest of your existing code...
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
    // Inside your JavaScript code
    const productContainer = document.querySelector('.latest .row');
    const productCount = productContainer.querySelectorAll('.product').length;
    if (productCount === 1) {
        productContainer.querySelector('.product').classList.add('col-lg-12');
    }
    if (productCount == 2) {
        productContainer.querySelector('.product').classList.add('col-lg-6');
    }
    const filterToggle = document.querySelector('.filter-toggle');
    const filterContainer = document.querySelector('.filter_container');

    filterToggle.addEventListener('click', () => {
        filterContainer.classList.toggle('show');
    });

    // Get the select element
    const orderBySelect = document.getElementById('orderBySelect');

    // Add event listener for change event on select element
    orderBySelect.addEventListener('change', function() {
        // Get the selected value from the select input
        const selectedValue = orderBySelect.value;

        // Modify the URL with the selected value using window.location
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('orderBy', selectedValue); // Set query parameter

        // Redirect to the updated URL
        window.location.href = currentUrl.href;
    });



</script>