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
    <?php include "message.php" ?>
    <div class="content">

        <?php if (isset($_GET['id'])): ?>
            <?php include("user.php") ?>
        <?php else: ?>

            <h4 class="pull-left">Suppliers</h4>

            <?php $users = mysqli_query($db, "SELECT * FROM users") ?>

            <input type="text" name="search" id="table_search" onkeyup="TableSearch('1')"
                   placeholder="Search by client name" class="pull-right">

            <table class="table table-bordered table-condensed" id="table">
                <tr class="active">
                    <th>Name</th>
                    <th>E-Mail</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                <?php while ($user = mysqli_fetch_object($users)) : ?>
                    <tr style="<?php if ($user->id == auth('id')) : ?>color:#500; font-weight: bold<?php endif ?>">
                        <td><?php echo $user->name ?></td>
                        <td><?php echo $user->email ?></td>
                        <td><?php echo $user->phone ?></td>
                        <td><?php echo $user->role ?></td>
                        <td>
                            <a href="suppliers.php?id=<?php echo $user->id ?>" class="btn btn-juicy btn-sm">View
                                &raquo;</a> &nbsp;
                        </td>
                    </tr>
                <?php endwhile ?>
            </table>
        <?php endif ?>
    </div>
</div>
<?php include 'footer.php' ?>
</body>
</html>
