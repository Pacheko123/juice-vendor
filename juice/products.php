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
    <div class="content">
        <h4 class="pull-left">Products</h4>
        <?php if (isset($_SESSION['user']) && $_SESSION['user']->role == 'admin'): ?>
            <a href="product.php" class="btn btn-juicy-fill pull-right">New Product</a>
        <?php endif ?>

        <?php $products = mysqli_query($db, "SELECT * FROM products") ?>
        <table class="table table-bordered">
            <thead>
            <tr class="active">
                <th>Name</th>
                <th>Unit Price</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($product = mysqli_fetch_object($products)) : ?>
                <tr>
                    <td><?php echo $product->name ?></td>
                    <td><?php echo $product->unit_price ?></td>
                </tr>
            <?php endwhile ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'footer.php' ?>
</body>
</html>
