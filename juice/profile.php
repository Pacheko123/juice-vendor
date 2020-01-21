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
    if (isset($_GET['logout'])) {
        unset($_SESSION['user']);
        session_destroy();

        header('location:index.php');
    }
    ?>
    <?php include('message.php') ?>

    <div class="content">
        <h4 class="">Profile</h4>

        <?php if (!isset($_SESSION['user'])) : ?>
            <div class="text-danger h4">
                Your not logged in. <a href="login.php">Click here</a> to login.
            </div>
        <?php else: ?>
            <?php $auth = auth('id') ?>
            <?php $account = mysqli_query($db, "SELECT * FROM accounts WHERE user_id='$auth'")->fetch_object(); ?>

            <a href="profile.php?logout=true" class="btn btn-juicy pull-right">Logout</a>

            <b>Name :</b> <?php echo auth('name') ?><br>
            <b>Role :</b> <?php echo auth('role') ?><br>
            <b>Phone :</b> <?php echo auth('phone') ?><br>
            <b>E-Mail :</b> <?php echo auth('email') ?><br>
            <br>
            <h4>My Account</h4>
            <b>Account :</b> <?php echo $account->account_no ?> <br>
            <b>Cur Balance :</b> <?php echo number_format($account->balance, 2) ?> <br>
            <a href="statement.php" class="btn btn-juicy-fill">Generate Account Statement</a>
            <br>
            <br>
            <h4>Order History</h4>
        <?php endif ?>

        <?php $id = auth('id') ?>
        <?php $meta_orders = mysqli_query($db, "SELECT * FROM meta_orders WHERE user_id='$id'") ?>
        <table class="table">
            <thead>
            <tr>
                <th>Sn</th>
                <th>Order ID</th>
                <th>Date</th>
                <th>Orders</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <?php while ($meta = mysqli_fetch_object($meta_orders)) : ?>
                <?php $orders = mysqli_query($db, "SELECT * FROM orders WHERE meta_id='$meta->id'") ?>
                <tr>
                    <td><?php echo @++$i ?></td>
                    <td><?php echo $meta->code ?></td>
                    <td><?php echo $meta->order_date ?></td>
                    <td><?php echo $orders->num_rows ?></td>
                    <td><?php echo '-:-' ?></td>
                    <td>
                        <a href="view_order.php?id=<?php echo $meta->id ?>">View</a>
                    </td>
                </tr>
            <?php endwhile ?>
        </table>
        <div class="clearfix"></div>
    </div>
</div>
<?php include 'footer.php' ?>
</body>
</html>