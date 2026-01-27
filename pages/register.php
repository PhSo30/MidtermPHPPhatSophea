<?php

$nameError = $usernameError = $passwdError = $confirmpasswordError = '';
$name = $username = '';
if (isset($_POST['username'], $_POST['password'], $_POST['confirmpassword'], $_POST['name'])) {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $passwd = trim($_POST['password']);
    $confirmpassword = trim($_POST['confirmpassword']);
    if (empty($name)) {
        $nameError = "Name is required";
    }
    if (empty($passwd)) {
        $passwdError = "Password is required";
    }
    if (empty($username)) {
        $usernameError = "Username is required";
    }
    if ($passwd !== $confirmpassword) {
        $confirmpasswordError = "Password not match";
    }
    if (strlen($passwd) < 6 || strlen($passwd) > 25) {
        $passwdError = "Password must be at least 6 characters";
    }
    if (usernameExist($username)) {
        $usernameError = 'Usename is currently unavailable!';
    }
    if (empty($nameError) && empty($usernameError) && empty($passwdError)) {
        if (registerUser($name, $username, $passwd)) {
            $name = $username = '';
            echo '<div class="alert alert-success" role="alert">
    Registeration is successful! You can now <a href="./?page=login" class="alert-link">LOGIN</a>. Give it a click if you like.
</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">
  Please try again!
</div>';
        }

    }
}
?>

<body>


    <form method="post" action="./?page=register" class="col-md-8 col-lg-6 mx-auto">
        <h3>Register</h3>
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" value="<?php echo $name; ?>" type="text" class="form-control
            <?php echo empty($nameError) ? '' : 'is-invalid' ?>">
            <div class="invalid-feedback"><?php echo $nameError; ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input name="username" value="<?php echo $username; ?>" type="text" class="form-control
            <?php echo empty($usernameError) ? '' : 'is-invalid' ?>">
            <div class="invalid-feedback"><?php echo $usernameError; ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input name="password" type="password" class="form-control
            <?php echo empty($passwdError) ? '' : 'is-invalid' ?>">
            <div class="invalid-feedback"><?php echo $passwdError; ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input name="confirmpassword" type="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>