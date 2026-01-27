<?php
$usernameError = $passwdError = '';
$username = $passwd = '';
if (isset($_POST['username'], $_POST['passwd'])) {
    $username = trim($_POST['username']);
    $passwd = trim($_POST['passwd']);
    if (empty($username)) {
        $usernameError = "Username is required";
    }
    if (empty($passwd)) {
        $passwdError = "Password is required";
    }

    if (!usernameExist($username)) {
        $usernameError = 'No username match!';
    }
    if (empty($usernameError) && empty($passwdError)) {
        if (loginUser($username, $passwd)) {
            $username = $passwd = '';
            echo '<div class="alert alert-success" role="alert">
    Login successful! Click to continue to <a href="./?page=home" class="alert-link">HOME</a>. Give it a click if you like.
</div>';
        } else {
            $passwdError = 'Password is incorrect!';
        }
    }
}
?>


<form method="post" action="./?page=login" class="col-md-8 col-lg-6 mx-auto">
    <h3>Login</h3>
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input name="username" value="<?php echo $username; ?>" type="text"
            class="form-control <?php echo empty($usernameError) ? '' : 'is-invalid' ?>">
        <div class="invalid-feedback"><?php echo $usernameError; ?></div>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" name="passwd" class="form-control 
        <?php echo empty($passwdError) ? '' : 'is-invalid' ?>" id="exampleInputPassword1">
        <div class="invalid-feedback"><?php echo $passwdError; ?></div>

    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>