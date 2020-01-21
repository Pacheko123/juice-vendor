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
    <?php include('message.php') ?>
    <div class="content">
        <?php $id = $_GET['id']; ?>
        <?php $meta = mysqli_query($db, "SELECT * FROM meta_orders WHERE id = '$id'")->fetch_object() ?>
        <?php if ($meta) : ?>
            <div class="center">
                <h3 class="">Order Details</h3>
                Order <?php echo $meta->code ?> <br>
                <?php echo date_create($meta->order_date)->format('M d, Y H:i A') ?><br>
                <br>
            </div>

            <?php $orders = mysqli_query($db, "SELECT * FROM orders WHERE meta_id='$meta->id'") ?>
            <table class="table">
                <thead>
                <tr>
                    <th>Sn</th>
                    <th>Product</th>
                    <th>Status</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($order = mysqli_fetch_object($orders)) : ?>
                    <?php $stock = mysqli_query($db, "SELECT * FROM stocks WHERE id= '$order->stock_id'")->fetch_object() ?>
                    <?php $product = @mysqli_query($db, "SELECT * FROM products WHERE id= '$stock->product_id'")->fetch_object() ?>

                    <?php if ($order->status != 'canceled') : ?>
                        <?php @$total = (@$product->unit_price * $order->quantity) ?>
                        <?php @$sum += $total ?>
                        <?php @$qty += $order->quantity ?>
                    <?php endif ?>

                    <tr class="<?php echo $order->status ?>">
                        <td><?php echo @++$i ?></td>
                        <td><?php echo @$product->name ?></td>
                        <td style="font-style: italic"><?php echo $order->status ?></td>
                        <td><?php echo @$product->unit_price ?></td>
                        <td><?php echo @$order->quantity ?></td>
                        <th>
                            <?php if ($order->status != 'canceled') : ?>
                                <?php echo number_format($total, 2) ?>
                            <?php endif ?>
                        </th>
                    </tr>
                <?php endwhile ?>
                </tbody>
                <tfoot>
                <th colspan="4" class="right">TOTALS :</th>
                <th><?php echo number_format(@$qty) ?></th>
                <th><?php echo number_format(@$sum, 2) ?></th>
                </tfoot>
            </table>
            <div class="center">
                <a href="profile.php" class="btn btn-juicy">Go Back</a>
            </div>

        <?php else : ?>
            <h3>Order not found</h3>
        <?php endif ?>
    </div>
</div>
<?php include 'footer.php' ?>
</body>
</html>