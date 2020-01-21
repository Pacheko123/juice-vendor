<?php $id = $_GET['id'] ?>
<?php $user = mysqli_query($db, "SELECT * FROM users WHERE id='$id'")->fetch_object() ?>

<h4 class=""><?php echo $user->name ?> Profile</h4>

<b>Name :</b> <?php echo $user->name ?><br>
<b>Phone :</b> <?php echo $user->phone ?><br>
<b>E-Mail :</b> <?php echo $user->email ?><br>
<b>Address :</b> <?php echo $user->address ?><br>

<?php $meta_orders = mysqli_query($db, "SELECT * FROM meta_orders WHERE user_id='$id'") ?>
<br>

<?php while ($meta = mysqli_fetch_object($meta_orders)) : ?>
    <?php $orders = mysqli_query($db, "SELECT * FROM orders WHERE meta_id='$meta->id'") ?>
    <div class="media">
        <div class="media-body">
            <h4 class="media-heading">
                #<?php echo $meta->code ?>
                <small><i>Ordered
                        on <?php echo date_create($meta->order_date)->format('D d M, Y h:m:s A') ?></i></small>

                <small><a href="javascript:void(0)" data-toggle="collapse" class="pull-right"
                          data-target="#<?php echo $meta->code ?>">[Toggle]</a></small>
            </h4>
        </div>
    </div>

    <div class="collapse in" id="<?php echo $meta->code ?>">
        <table class="table table-condensed">
            <thead>
            <tr class="active">
                <th>Product</th>
                <th>Status</th>
                <th>@</th>
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
            <th colspan="3"></th>
            <th class="active"><?php echo number_format(@$qty) ?></th>
            <th class="active"><?php echo number_format(@$sum, 2) ?></th>
            </tfoot>
        </table>
    </div>
<?php endwhile ?>
<a href="javascript:history.go(-1)" class="btn btn-juicy-fill">Go Back</a>

