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
        <?php $id = auth('id') ?>
        <?php $account = mysqli_query($db, "SELECT * FROM accounts WHERE user_id='$id'")->fetch_object() ?>
        <?php $transactions = mysqli_query($db, "SELECT * FROM transactions WHERE debit='$account->account_no' OR credit='$account->account_no'") ?>

        <h4 class="">Statement</h4>
        <b>Account :</b> <?php echo $account->account_no ?> <br>
        <b>Cur Balance :</b> <?php echo number_format($account->balance, 2) ?> <br>

        <table class="table">
            <thead>
            <tr>
                <th>Sn</th>
                <th>Ref</th>
                <th>Date</th>
                <th>Narration</th>
                <th class="right">Paid Out</th>
                <th class="right">Pain In</th>
                <th class="right">Running</th>
            </tr>
            </thead>
            <?php $sum = 0 ?>
            <?php while ($trans = mysqli_fetch_object($transactions)) : ?>
                <tr>
                    <td><?php echo @++$i ?></td>
                    <td><?php echo sprintf("%03d", $trans->id) ?></td>
                    <td><?php echo $trans->date ?></td>
                    <td><?php echo $trans->narration ?></td>

                    <?php if ($trans->debit == $account->account_no): ?>
                        <?php $sum -= $trans->amount ?>
                        <td class="right"><?php echo number_format($trans->amount, 2) ?></td>
                    <?php else : ?>
                        <td class="right">-</td>
                    <?php endif ?>
                    <?php if ($trans->credit == $account->account_no): ?>
                        <?php $sum += $trans->amount ?>
                        <td class="right"><?php echo number_format($trans->amount, 2) ?></td>
                    <?php else : ?>
                        <td class="right">-</td>
                    <?php endif ?>
                    <th class="right"><?php echo number_format($sum, 2) ?></th>
                </tr>
            <?php endwhile ?>
        </table>
        <br>
    </div>
</div>
<?php include 'footer.php' ?>
</body>
</html>