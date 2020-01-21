<?php session_start() ?>
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

        <?php include('message.php') ?>

        <?php if (@$_SESSION['user']->role != 'admin') : ?>
            <a href="order.php" class="btn btn-juicy pull-right">Order Juice Now!</a>
        <?php endif ?>
        <div class="pull-left">
            <h3 class="pull-right">Welcome to Juicy Juice!</h3>
        </div>

        <div class="clearfix"></div>
        <br>
        <div class="alert panel-default">
            <h4>About Juicy Juice</h4>
            <p>When using any tool in the "real world", you feel more confident if you understand how that tool works.
                Application development is no different.</p>

            <p>When you understand how your development tools function,you feel more comfortable and confident using
                them.</p>

            <p>The goal of this document is to give you a good, high-level overview of how the this site
                "works". By getting to know the overall system better, everything feels less "magical" and you will
                be more confident in using it.</p>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="box">
                    <?php $p_orders = mysqli_query($db, "SELECT * FROM orders WHERE STATUS = 'pending'")->num_rows ?>
                    <label><?php echo $p_orders ?></label>
                    <b>Orders</b><br>
                    <small><i><?php echo $p_orders ?> pending orders</i></small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box">
                    <?php $suppliers = mysqli_query($db, "SELECT * FROM users WHERE role='supplier'")->num_rows ?>
                    <label><?php echo $suppliers ?></label>
                    <b>Suppliers</b><br>
                    <small><i><?php echo $suppliers ?> active suppliers</i></small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box">
                    <?php $stock = mysqli_query($db, "SELECT * FROM stocks")->num_rows ?>
                    <label><?php echo $stock ?></label>
                    <b>Stock</b><br>
                    <small><i><?php echo $stock ?> grand stock</i></small>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php' ?>
</body>
</html>
