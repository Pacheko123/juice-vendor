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
    $user = auth('id');
    $account = mysqli_query($db, "SELECT * FROM accounts WHERE user_id='$user'")->fetch_object();

    if (isset($_POST['order'])) {

        $ids = @$_POST['ids'];
        foreach ($ids as $key => $value) {
            $_SESSION[@$value] = @$_POST['quantities'][@$key];
        }
;
        $total = $_POST['total_sum'];
        $quantities = $_POST['quantities'];

        if (!$account) {
            $_SESSION['message'] = 'Invalid user account!';

        } else {
            if ($account->balance < $total) {
                $message = "You have insufficient balance to place this order. Your balance is $account->balance";
                $_SESSION['message'] = $message;

            } else {
                $code = rand(1000, 9999) . '_' . sprintf('%03d', auth('id'));
                mysqli_query($db, "INSERT INTO meta_orders(user_id, code) VALUES('$user', '$code')") or die(mysqli_error($db));
                $order_id = $db->insert_id;

                $sum = 0;
                $placed = false;
                foreach ($ids as $i => $id) {
                    $quantity = @(int)$quantities[$i];
                    if ($quantity > 0) {
                        $stock = mysqli_query($db, "SELECT * FROM stocks WHERE id='$id'")->fetch_object();
                        $sum += ($quantity * (int)$stock->sell_price);
                        mysqli_query($db, "INSERT INTO orders(meta_id, stock_id, quantity) VALUES('$order_id','$id','$quantity')") or die(mysqli_error($db));

                        $new_qty = (int)($stock->quantity - $quantity);
                        mysqli_query($db, "UPDATE stocks SET quantity='$new_qty' WHERE id='$id'") or die(mysqli_error($db));

                        $placed = true;
                    }
                }

                if (!$placed) {
                    $_SESSION['message'] = 'Please at least order something!';
                } else {
                    createPayment($db, $total, $account);
                    $_SESSION['message'] = 'Order placed successfully. Order ID => ' . $code;
                }
            }
        }
    }
    ?>

    <?php
    function createPayment($db, $total, $account)
    {
        $debit = $account->account_no;
        $credit = '100';
        if ($total > 0) {
            $balance = ($account->balance - $total);
            mysqli_query($db, "INSERT INTO transactions(debit, credit, amount,narration) VALUE('$debit', '$credit','$total','Placed Order')") or die(mysqli_error($db));
            mysqli_query($db, "UPDATE accounts SET balance = '$balance'");
        }
    }

    ?>
    <div class="content">

        <h4>
            Order Juice
            <b class="pull-right">Balance : <?php echo number_format(@$account->balance, 2) ?></b>
        </h4>
        <?php include('message.php') ?>

        <form method="post" action="">
            <table class="table table-bordered table-condensed">
                <tr class="active">
                    <th>Product</th>
                    <th>Available</th>
                    <th>@</th>
                    <th>Quantity</th>
                    <th class="right">Sum</th>
                </tr>
                <?php $stocks = mysqli_query($db, "SELECT * FROM stocks") ?>
                <?php while ($stock = mysqli_fetch_object($stocks))  : ?>

                    <input type="hidden" name="ids[]" value="<?php echo $stock->id ?>">

                    <?php $product = mysqli_query($db, "SELECT * FROM products WHERE id=$stock->product_id")->fetch_object(); ?>
                    <tr>
                        <td><?php echo $product->name ?></td>
                        <td><?php echo $stock->quantity ?></td>
                        <td class="unit"><?php echo $product->unit_price ?></td>

                        <td><input type="number" class="quantities" name="quantities[]" min="1"
                                   max="<?php echo $stock->quantity ?>"
                                   style="width: 100%" value="<?php echo @$_SESSION[$product->id] ?>" autofocus></td>

                        <td class="sum right">0.00</td>
                    </tr>

                <?php endwhile; ?>
                <tr>
                    <th colspan="4"></th>
                    <th class="total_sum right">0.00</th>
                </tr>
            </table>
            <input type="hidden" id="total_sum" name="total_sum" value="0">
            <input type="submit" class="btn btn-juicy order" name="order" value="Submit">
            <button type="reset" class="btn btn-default">Reset</button>
            <div class="clearfix"></div>
        </form>
    </div>
</div>
<?php include 'footer.php' ?>
<script>
    $('.quantities').on('keyup change', function () {
        var row = $(this).parent().parent();
        var quantity = $(this).val();
        quantity = (quantity === '') ? 0 : quantity;

        var unit_price = row.find('.unit').html();
        var sum = parseFloat(unit_price) * parseInt(quantity);

        row.find('.sum').html(sum.toFixed(2));

        GrandSums();
    });

    function GrandSums() {
        var total_sum = 0;

        $('.sum').each(function (a, b) {
            total_sum += parseInt($(b).html());
            $('#total_sum').val(total_sum);
            $('.total_sum').html(total_sum.toFixed(2) + '/=');
        })
    }

</script>
</body>
</html>
