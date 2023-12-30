<?php require_once "header.php"; ?>
<?php
if(isset($result)){
    echo "<div class='alert alert-success' role='alert'>
            $result
        </div>";
}
if(isset($error)){
    echo "<div class='alert alert-danger' role='alert'>
            $error
        </div>";
}


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= path ?>front/css/contact_us.css">
    <link rel="stylesheet" href="<?= path ?>front/css/root.css">
    <!-- Bootstrap CSS -->
    <link href="path_to_bootstrap/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="title text-center">
                <h3>Send us a message</h3>
            </div>
            <form method="post" class="contact_us_form" action="contact_us_mail">
                <div class="form-group">
                    <input type="text" class="form-control rounded-4" placeholder="Your full name"name="full_name">
                    <?php if (isset($errors['name'])) : ?>
                        <div class="error-text"><?= $errors['name'] ?></div>
                    <?php endif; ?>

                </div>
                <div class="form-group">
                    <input type="email" class="form-control rounded-4" placeholder="Your email"name="email">
                    <?php if (isset($errors['email'])) : ?>
                        <div class="error-text"><?= $errors['email'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control rounded-4" placeholder="Your phone" name="phone">
                    <?php if (isset($errors['phone'])) : ?>
                        <div class="error-text"><?= $errors['phone'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <textarea class="form-control rounded-4" placeholder="Your message" style="height: 100px" name="msg"></textarea>
                    <?php if (isset($errors['msg'])) : ?>
                        <div class="error-text"><?= $errors['msg'] ?></div>
                    <?php endif; ?>

                </div>
                <button type="submit"class="" name="btn"> send </button>
            </form>
        </div>
    </div>
</div>


