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
    if (isset($_POST['login'])) {
        session_start();
        $username = trim($_POST['email']);
        $password = trim($_POST['password']);

        $_SESSION['username'] = $username;

        $query = mysqli_query($db, "SELECT * FROM users WHERE email='$username' LIMIT 1");

        if ($query->num_rows == 0) {
            $message = 'Credentials not found!';

        } elseif ($query->num_rows == 1) {
            $user = $query->fetch_object();

            if ($user->password != md5($password)) {
                $message = 'You entered wrong password!';

            } else {
                $message = 'Successfully logged in as ' . strtoupper($user->role) . '!';
                $_SESSION['user'] = $user;
                unset($_SESSION['username']);
                header('location:profile.php');
            }
        }
        $_SESSION['message'] = $message;
    }
    ?>

    <?php if (isset($_SESSION['message'])) : ?>
        <div class="alert alert-juicy">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <?php echo $_SESSION['message']; ?>
        </div>
    <?php endif ?>

    <div class="content">
        <form method="post" action="" method="post" class="form-horizontal">
            <div class="form-group">
                <div class="col-md-offset-3 col-md-4">
                    <h4>Login</h4>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">E-Mail</label>
                <div class="col-md-4">
                    <input type="email" name="email" class="form-control" value="<?php echo @$_SESSION['username'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Password</label>
                <div class="col-md-4">
                    <input type="password" name="password" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-3 col-md-4">
                    <input type="submit" name="login" class="btn btn-juicy-fill" value="Login">
                    <a class="btn" href="register.php">Create Account?</a>
                </div>
            </div>
        </form>

    </div>
</div>
</body>
</html>