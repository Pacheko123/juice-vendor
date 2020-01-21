<!--?php include('session.php') ?-->
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

    if (isset($_GET['clear'])) {
        $id = $_GET['clear'];
        mysqli_query($db, "UPDATE orders SET status='cleared' WHERE id='$id'");
    }

    if (isset($_GET['clear_all'])) {
        $cleared = false;
        $meta_id = $_GET['clear_all'];
        $orders = mysqli_query($db, "SELECT * FROM orders WHERE meta_id='$meta_id' AND status='pending'");
        while ($order = $orders->fetch_object()) {
            mysqli_query($db, "UPDATE orders SET status='cleared' WHERE id='$order->id'");
            $cleared = true;
        }
        if ($cleared) {
            $_SESSION['message'] = 'All orders cleared successfully!';
        }
    }

    if (isset($_GET['cancel'])) {
        $id = $_GET['cancel'];
        $order = mysqli_query($db, "SELECT * FROM orders WHERE id='$id'")->fetch_object();
        $stock = mysqli_query($db, "SELECT * FROM stocks WHERE id='$order->stock_id'")->fetch_object();
        $product = mysqli_query($db, "SELECT * FROM products WHERE id='$stock->product_id'")->fetch_object();
        $new_qty = ((int)$stock->quantity + $order->quantity);

        mysqli_query($db, "UPDATE stocks SET quantity='$new_qty' WHERE id ='$stock->id'") or die(mysqli_error($db));
        mysqli_query($db, "UPDATE orders SET status='canceled' WHERE id='$id'") or die(mysqli_error($db));
    }

    ?>
    <?php include('message.php') ?>
    <div class="content">
        <h4>Orders</h4>

        <?php $type = @$_GET['status'] ?>
        <select id="order_status">
            <option value="">All Orders</option>
            <option value="pending" <?php if ($type && $type == 'pending'): ?> selected <?php endif ?>>Pending Orders
            </option>
            <option value="cleared" <?php if ($type && $type == 'cleared'): ?> selected <?php endif ?>>Cleared Orders
            </option>
            <option value="canceled" <?php if ($type && $type == 'canceled'): ?> selected <?php endif ?>>Canceled
                Orders
            </option>
        </select>

        <select id="stock_type">
            <?php $stock_type = @$_GET['stock']; ?>
            <option value="">All Stock</option>
            <?php $stocks = mysqli_query($db, "SELECT * FROM stocks") ?>
            <?php while ($stock = mysqli_fetch_object($stocks)) : ?>
                <?php $product = mysqli_query($db, "SELECT * FROM products WHERE id='$stock->product_id'")->fetch_object() ?>
                <option value="<?php echo $stock->id ?>" <?php if ($stock_type && $stock_type == $stock->id): ?> selected <?php endif ?>>
                    <?php echo $product->name ?>
                </option>
            <?php endwhile ?>
        </select>

        <div class="pull-right">
            <a href="orders.php" class="btn btn-juicy-fill btn-sm">Refresh</a> &nbsp;&nbsp;
        </div>

        <br><br><br>
        <?php $meta_orders = mysqli_query($db, "SELECT * FROM meta_orders ORDER BY id DESC") ?>
        <?php while ($meta = mysqli_fetch_object($meta_orders)) : ?>
            <?php $user = mysqli_query($db, "SELECT * FROM users WHERE id= '$meta->user_id'")->fetch_object() ?>
            <?php

            $stock = @$_GET['stock'];
            if ($stock && !empty($type))
                $orders = mysqli_query($db, "SELECT * FROM orders WHERE meta_id = '$meta->id' AND stock_id='$stock' AND status = '$type'");
            else if ($stock)
                $orders = mysqli_query($db, "SELECT * FROM orders WHERE meta_id = '$meta->id' AND stock_id='$stock'");
            else if ($type)
                $orders = mysqli_query($db, "SELECT * FROM orders WHERE meta_id = '$meta->id' AND status = '$type'");
            else
                $orders = mysqli_query($db, "SELECT * FROM orders WHERE meta_id = '$meta->id'");
            ?>

            <?php if ($orders->num_rows > 0): ?>

                <div class="pull-left">
                    <b>Order : </b><?php echo $meta->code ?> - <?php echo $user->name ?>
                </div>
                <div class="pull-right">
                    <span class="text-muted"><b>Date : </b><?php echo date_create($meta->order_date)->format('M d,y H:i') ?></span>
                    &nbsp;
                    <a href="orders.php?clear_all=<?php echo $meta->id ?>" id="clear_all" class="btn btn-default btn-sm">Clear
                        All</a>
                </div>

                <table class="table table-condensed table-bordered" id="table" style="border: none">
                    <thead>
                    <tr class="active">
                        <th>#</th>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $count = 0 ?>
                    <?php $total = 0 ?>
                    <?php $sum = 0 ?>
                    <?php $quantity = 0 ?>
                    <?php while ($order = mysqli_fetch_object($orders)) : ?>
                        <?php $count++ ?>
                        <?php $stock = mysqli_query($db, "SELECT * FROM stocks WHERE id= '$order->stock_id'")->fetch_object() ?>
                        <?php $product = @mysqli_query($db, "SELECT * FROM products WHERE id= '$stock->product_id'")->fetch_object() ?>

                        <?php if ($order->status != 'canceled') : ?>
                            <?php $total = (@$product->unit_price * $order->quantity) ?>
                            <?php $sum += $total ?>
                            <?php $quantity += $order->quantity ?>
                        <?php endif ?>

                        <tr class="<?php echo $order->status ?>">
                            <td class="active"><?php echo $count ?></td>
                            <td><?php echo @$product->name ?></td>
                            <td style="font-style: italic"><?php echo $order->status ?></td>
                            <td><?php echo @$product->unit_price ?></td>
                            <td><?php echo @$order->quantity ?></td>
                            <th>
                                <?php if ($order->status != 'canceled') : ?>
                                    <?php echo number_format($total, 2) ?>
                                <?php endif ?>
                            </th>
                            <td align="right">
                                <?php if ($order->status == 'pending') : ?>
                                    <a href="orders.php?clear=<?php echo $order->id ?>" class="btn btn-juicy btn-table">Clear</a>
                                    <a href="orders.php?cancel=<?php echo $order->id ?>"
                                       class="remove btn btn-juicy btn-table">Cancel</a>
                                <?php elseif ($order->status == 'cleared'): ?>
                                    Processed
                                <?php else : ?>
                                    Canceled
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endwhile ?>
                    </tbody>
                    <tfoot>
                    <th colspan="4"></th>
                    <th class="active"><?php echo number_format($quantity) ?></th>
                    <th class="active"><?php echo number_format($sum, 2) ?></th>
                    <th></th>
                    </tfoot>
                </table>
            <?php endif ?>
        <?php endwhile ?>
    </div>
</div>
<?php include 'footer.php' ?>
</body>
</html>
