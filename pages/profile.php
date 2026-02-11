<?php
$oldPasswd = $newPasswd = $confirmNewPassword = '';
$oldPasswdErr = $newPasswdErr = '';

if (!empty($_SESSION['Profile Message alert'])) {
    echo $_SESSION['Profile Message alert'];
    $_SESSION['Profile Message alert'] = '';
}


$photo = empty(getUserImage($_SESSION['user_id'])) ? 'emptyuser.png' : getUserImage($_SESSION['user_id']);

if (isset($_POST['changePasswd'], $_POST['oldPasswd'], $_POST['newPasswd'], $_POST['confirmNewPasswd'])) {
    $oldPasswd = trim($_POST['oldPasswd']);
    $newPasswd = trim($_POST['newPasswd']);
    $confirmNewPasswd = trim($_POST['confirmNewPasswd']);
    if (empty($oldPasswd)) {
        $oldPasswdErr = 'please input your old password';
    }
    if (empty($newPasswd)) {
        $newPasswdErr = 'please input your new password';
    }
    if ($newPasswd !== $confirmNewPasswd) {
        $newPasswdErr = 'password does not match';
    }
    if (!isUserHasPassword($oldPasswd)) {
        $oldPasswdErr = 'password is incorrect';
    }
    if (empty($oldPasswdErr) && empty($newPasswdErr)) {
        if (setUserNewPassword($newPasswd)) {
            header('Location: ./?page=logout');
            exit();
        } else {
            echo '<div class="alert alert-danger" role="alert">
                try again.
                </div>';
        }
    }
}
if (isset($_POST['deletePhoto'])) {
    deleteUserImage();
    $_SESSION['Profile Message alert'] = '<div class="alert alert-success" role="alert">Image deleted successfully!</div>';
    header('Location: ./?page=profile');
    exit();
}

if (isset($_POST['uploadPhoto'])) {
    if (isset($_FILES["photo"]) && !empty($_FILES["photo"]["name"])) {
        $response = insertImage($_FILES);
        if ($response) {
            $_SESSION['Profile Message alert'] = '<div class="alert alert-success" role="alert">Image uploaded successfully!</div>';
            header('Location: ./?page=profile');
            exit();
        } else {
            $_SESSION['Profile Message alert'] = '<div class="alert alert-danger" role="alert">Failed to upload image. Please try again.</div>';
            header('Location: ./?page=profile');
            exit();
        }
    } else {
        $_SESSION['Profile Message alert'] = '<div class="alert alert-danger" role="alert">No file selected. Please choose an image to upload.</div>';
        header('Location: ./?page=profile');
        exit();
    }
}




?>




<div class="row">
    <div class="col-6">
        <form method="post" action="./?page=profile" enctype="multipart/form-data">
            <div class="d-flex justify-content-center">
                <input name="photo" type="file" id="profileUpload" hidden>
                <label role="button" for="profileUpload">
                    <img src="./assets/images/<?php echo $photo ?>" class="rounded" width="200" height="200">
                </label>
            </div>
    </div>
    <div class="d-flex justify-content-center">
        <button type="submit" name="deletePhoto" class="btn btn-danger">Delete</button>
        <button type="submit" name="uploadPhoto" class="btn btn-success">Upload</button>
    </div>
    </form>
</div>
<div class="col-6">
    <form method="post" action="./?page=profile" class="col-md-10 col-lg-6 mx-auto">
        <h3>Change Password</h3>
        <div class="mb-3">
            <label class="form-label">Old Password</label>
            <input value="<?php echo $oldPasswd ?>" name="oldPasswd" type="password" class="form-control 
                <?php echo empty($oldPasswdErr) ? '' : 'is-invalid' ?>">
            <div class="invalid-feedback">
                <?php echo $oldPasswdErr ?>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input name="newPasswd" type="password" class="form-control 
                <?php echo empty($newPasswdErr) ? '' : 'is-invalid' ?>">
            <div class="invalid-feedback">
                <?php echo $newPasswdErr ?>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input name="confirmNewPasswd" type="password" class="form-control">
        </div>
        <button type="submit" name="changePasswd" class="btn btn-primary">Submit</button>
    </form>
</div>

</div>

<script>
    const profileUpload = document.getElementById('profileUpload');
    const profileImg = document.querySelector('label[for="profileUpload"] img');
    profileUpload.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                profileImg.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>