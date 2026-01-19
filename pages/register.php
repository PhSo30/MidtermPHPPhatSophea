<?php
// include_once '../includes/header.inc.php';
// include_once '../includes/footer.inc.php';
// include_once '../includes/novbar.inc.php';
$nameError = $usernameError = $passwdError = $confirmpasswordError = '';
$name = $username = $passwd = $confirmpassword = '';
    if (isset($_POST['username'],$_POST['password'],$_POST['confirmpassword'],$_POST['name'])) {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $passwd = $_POST['password'];
        $confirmpassword = $_POST['confirmpassword'];
        if(empty($name)){
            $nameError = "Name is required";
        }
        if(empty($passwd)){
            $passwdError = "Password is required";
        }
        if(empty($username)){
            $usernameError = "Username is required";
        }
    }
?>

<body>


    <form method="post" action="./?page=register" class="col-md-8 col-lg-6 mx-auto">
        <h3>Register</h3>
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" value="<?php echo $name;?>" type="text" class="form-control
            <?php echo empty($nameError) ? '' : 'is-invalid'?>">
            <div class="invalid-feedback"><?php echo $nameError;?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input name="username" value="<?php echo $username;?>" type="text" class="form-control
            <?php echo empty($usernameError) ? '' : 'is-invalid'?>">
            <div class="invalid-feedback"><?php echo $usernameError;?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input name="password" type="password" class="form-control
            <?php echo empty($passwdError) ? '' : 'is-invalid'?>">
            <div class="invalid-feedback"><?php echo $passwdError;?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input name="confirmpassword" type="password" class="form-control"
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>