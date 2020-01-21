<?php include('session.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Juicy Juice</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<?php include "db.php" ?>
<?php include "header.php" ?>

<div class="container">
    <?php

    if (isset($_POST['product'])) {
        $name = $_POST['name'];
        $unit_prce = $_POST['unit_price'];
        mysqli_query($db, "INSERT INTO products(name, unit_price) VALUES('$name', '$unit_prce')") or die(mysqli_query($db));
        header('location:products.php');
    }

    ?>

    <div class="content">
        <div class="col-md-6 col-md-offset-3">
            <h4 class="center">New Products</h4>
            <form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="control-label col-md-4">Product Name</label>
                    <div class="col-md-8">
                        <input type="text" name="name" class="form-control" autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Unit Price</label>
                    <div class="col-md-8">
                        <input type="number" min="0" name="unit_price" class="form-control" value="0.00">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-8">
                        <input type="submit" class="btn btn-juicy" name="product" value="Submit">
                    </div>
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<?php include 'footer.php' ?>
</body>
</html>
