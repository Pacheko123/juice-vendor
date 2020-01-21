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
    $auth = auth('id');
    $account = mysqli_query($db, "SELECT * FROM accounts WHERE user_id='$auth'")->fetch_object();

    if (isset($_POST['deposit'])) {
        $debit = 200;
        $credit = $account->account_no;
        $amount = trim($_POST['amount']);

        $balance = ($account->balance + $amount);
        mysqli_query($db, "INSERT INTO transactions(debit, credit, amount, narration) VALUES('$debit', '$credit', '$amount', 'CASH Deposit')") or die(mysqli_error($db));
        mysqli_query($db, "UPDATE accounts SET balance = '$balance' WHERE account_no= '$account->account_no'");

        $_SESSION['message'] = "Your account has been credited with $amount";
//        header('location:deposit.php');
    }

    ?>

    <div class="content">
        <?php include('message.php') ?>

        <div class="col-md-6 col-md-offset-3">

            <h4 class="center">Deposit</h4>
            <form method="post" action="" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-md-4">Account</label>
                    <div class="col-md-8">
                        <input class="form-control" disabled
                               value="<?php echo $account->account_no ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Balance</label>
                    <div class="col-md-8">
                        <input value="<?php echo $account->balance ?>" class="form-control" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Amount</label>
                    <div class="col-md-8">
                        <input type="number" min="10" max="100000" name="amount" class="form-control" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-8">
                        <input type="submit" class="btn btn-juicy" name="deposit" value="Submit">
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
