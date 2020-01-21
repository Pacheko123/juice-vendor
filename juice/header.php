<div class="container">
    <header>
        <a href="index.php"><b class="h3">PACHEKO</b></a>
    </header>
</div>

<nav style="text-align: center; background-color: #600; padding: 10px; margin-bottom: 10px">
    <ul class="list-inline" style="margin-bottom: 0">
        <li><a href="index.php">Home</a></li>

        <?php if (@$_SESSION['user']->role == 'admin') : ?>
            <li><a href="stock.php">Stock</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="payments.php">Payments</a></li>
            <li><a href="suppliers.php">Users</a></li>
            <li><a href="order.php">Order</a></li>
            <li><a href="products.php">Products</a></li>
        <?php else: ?>
            <li><a href="order.php">Order</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="deposit.php">Deposit</a></li>
        <?php endif ?>

        <li><a href="profile.php">Profile</a></li>
    </ul>
</nav>

