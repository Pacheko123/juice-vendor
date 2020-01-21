<!DOCTYPE html>
<html>
<head>
    <title>Juicy Juice</title>
    <link rel="stylesheet" type="text/css" href="../styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" href=".../styles/styles.css">
</head>
<body>

<div class="container">
    <?php
    require 'db.php';
    if (isset($_POST['register'])) {
        session_start();
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $password = trim($_POST['password']);
        $confirm = trim($_POST['confirm']);

        foreach ($_POST as $key => $value) {
            $_SESSION[$key] = $value;
        }

        if ($confirm !== $password) {
            $message = 'Passwords do not match!';
        } else {

            $query = mysqli_query($db, "SELECT * FROM users WHERE email='$email' LIMIT 1");
            if ($query->num_rows == 1) {
                $message = 'E-Mail already taken!';

            } else {
                $password = md5($password);
                mysqli_query($db, "INSERT INTO users(name, phone, address, email, password) VALUES('$name','$phone','$address','$email','$password')") or die(mysqli_error($db));
                createAccount($db, $db->insert_id);

                foreach ($_POST as $key => $value) {
                    unset($_SESSION[$key]);
                }
                $message = 'Details saved successfully!';
            }
        }
        $_SESSION['message'] = $message;
    }
    ?>
    <?php
    function createAccount($db, $id)
    {
        $account = rand(10000000, 99999999);
        mysqli_query($db, "INSERT INTO accounts(user_id, account_no) VALUES('$id','$account')") or die(mysqli_error($db));
    }

    ?>

    <?php include "message.php" ?>

    <div class="content">
        <h4 class="center">Register</h4>
        <form method="post" action="" method="post" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-4">Full Name</label>
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" value="<?php echo @$_SESSION['name'] ?>"
                           required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Phone</label>
                <div class="col-md-4">
                    <input type="text" name="phone" class="form-control" value="<?php echo @$_SESSION['phone'] ?>">
                </did stock
d stock
v>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Address</label>
                <div class="col-md-4">
                    <input type="text" name="address" class="form-control" value="<?php echo @$_SESSION['address'] ?>"
                           required>
                </div>
            </div>d stock

            <div class="form-group">
                <label class="control-label col-md-4">E-Mail Address</label>
                <div class="col-md-4">
                    <input type="email" name="email" class="form-control" value="<?php echo @$_SESSION['email'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Password</label>
                <div class="col-md-4">
                    <input type="password" name="password" class="form-control"
                           value="<?php echo @$_SESSION['password'] ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Confirm Password</label>
                <div class="col-md-4">
                    <input type="password" name="confirm" class="form-control"
                           value="<?php echo @$_SESSION['confirm'] ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-4 col-md-4">
                    <input type="submit" name="register" class="btn btn-juicy-fill" value="Submit">
                    <input type="reset" class="btn btn-juicy" value="Cancel">

                    <a href="login.php" class="btn">Login</a>
                </div>
            </div>
        </form>

    </div>
</div>
</body>
</html>