<?php

require_once "header.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title;?></title>
    <link rel="stylesheet" href="<?=path;?>front/css/root.css">
    <link rel="stylesheet" href="<?=path;?>front/css/about_us.css">
</head>
<body>
<div class="container-fluid">
    <div class="title  text-center pt-5 pb-5">  <h2> About us </h2>

    </div>
<div class="about_us d-flex justify-content-center">
<div class="box p-3">
    <h5 class="heading1"> who are we</h5>
    <p class="fa-paragraph1">
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled
        it to make a type specimen book. It has survived not only five centuries, but also the leap into
    </p>
    <h5 class="heading2"> we are diffrent from the others</h5>
    <p class="fa-paragraph2">
        We're rooted in sales. is a long established fact that a
        reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here

        We've been where you are content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem
    </p>
    <div class="btns d-flex justify-content-center ">
        <a href="index" class="btn btn-main bg-light rounded-3 m-1 text-black ">home </a>
        <a href="contact_us"  class="btn btn-main bg-light rounded-3 m-1 text-black"> contact us </a>
    </div>
</div>
</div>
</div>
</body>
</html>
