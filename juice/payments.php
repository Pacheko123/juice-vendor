<?php include('session.php'); ?>
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
    <?php $query = "SELECT transactions.*, users.name
    FROM transactions
    JOIN accounts ON accounts.account_no = transactions.debit
    JOIN users ON accounts.user_id = users.id" ?>
    <?php $payments = mysqli_query($db, $query) or die(mysqli_error($db)) ?>

    <div class="content">
        <h3>Payments</h3>
        <table class="table">
            <thead>
            <tr>
                <th>Sn</th>
                <th>Date</th>
                <th>Payee</th>
                <th>Narration</th>
                <th class="right">Amount</th>
            </tr>
            </thead>
            <?php $sum = 0 ?>
            <?php while ($payment = mysqli_fetch_object($payments)) : ?>
                <tr>
                    <?php $sum += $payment->amount ?>
                    <td><?php echo @++$i ?></td>
                    <td><?php echo date_create($payment->date)->format('M d,y H:i') ?></td>
                    <td><?php echo $payment->name ?></td>
                    <td><?php echo $payment->narration ?></td>
                    <td class="right"><?php echo number_format($payment->amount, 2) ?></td>
                </tr>
            <?php endwhile ?>
            <tr>
                <td colspan="4"></td>
                <th class="right"><?php echo number_format($sum,2) ?></th>
            </tr>
        </table>
    </div>
</div>
<?php include 'footer.php' ?>
</body>
</html>
