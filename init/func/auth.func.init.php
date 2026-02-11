<?php



function usernameExist($username)
{
    global $db;
    $query = $db->prepare('SELECT * FROM tbl_users WHERE username = ?');
    $query->bind_param('s', $username);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return true;
    }
    return false;

}
function registerUser($name, $username, $passwd)
{
    global $db;
    $query = $db->prepare('INSERT INTO tbl_users (name,username,passwd) VALUES (?,?,?)');
    $query->bind_param('sss', $name, $username, $passwd);
    $query->execute();

    if ($query->affected_rows) {
        return true;
    }
    return false;
}
function loginUser($username, $passwd)
{
    global $db;
    $query = $db->prepare('SELECT * FROM tbl_users WHERE username = ? AND passwd = ?');
    $query->bind_param('ss', $username, $passwd);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return $result->fetch_object();
        // return true;
    }
    return false;
}

function loggedInUser()
{
    global $db;
    if (!isset($_SESSION['user_id'])) {
        return false;
    }
    $user_id = $_SESSION['user_id'];
    $query = $db->prepare('SELECT * FROM tbl_users WHERE id = ?');
    $query->bind_param('d', $user_id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return $result->fetch_object();
    }
    return null;
}
function isAdmin()
{
    $user = loggedInUser();
    if ($user && $user->level === 'admin') {
        return true;
    }
    return false;
}
function isUserHasPassword($passwd)
{
    global $db;
    $user = loggedInUser();
    $query = $db->prepare('SELECT * FROM tbl_users WHERE id = ? AND passwd = ?');
    $query->bind_param('ds', $user->id, $passwd);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return true;
    }
    return false;
}
function setUserNewPassword($passwd)
{
    global $db;
    $user = loggedInUser();
    $query = $db->prepare('UPDATE tbl_users SET passwd = ? WHERE id = ?');
    $query->bind_param('sd', $passwd, $user->id);
    $query->execute();
    if ($db->affected_rows) {
        return true;
    }
    return false;

}
function insertImage($file)
{
    global $db;
    
    $image_name = $file["photo"]["name"];
    $image_temp = $file["photo"]["tmp_name"];
    rename($image_name, uniqid() . '_' . $image_name);
    $image_name = uniqid() . '_' . $image_name;
    $old_image = getUserImage($_SESSION['user_id']);
    
    $db->begin_transaction();
    
    $query = $db->prepare("UPDATE tbl_users SET photo = ? WHERE id = ?");
    $query->bind_param('sd', $image_name, $_SESSION['user_id']);
    $query->execute();
    if (!$query->affected_rows) {
        $db->rollback();
        return false;
    }
    if (!move_uploaded_file($image_temp, "./assets/images/" . $image_name)) {
        $db->rollback();
        return false;
    }
    if ($old_image) {
        unlink("./assets/images/" . $old_image);

    }


    $db->commit();

    return true;
}
function getUserImage($user_id)
{
    global $db;
    $query = $db->prepare("SELECT photo FROM tbl_users WHERE id = ?");
    $query->bind_param('d', $user_id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        return $result->fetch_object()->photo;
    }
    return null;
}
function deleteUserImage()
{
    global $db;
    $user_id = $_SESSION['user_id'];
    $query = $db->prepare("SELECT photo FROM tbl_users WHERE id = ?");
    $query->bind_param('d', $user_id);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows) {
        $photo = $result->fetch_object()->photo;
        if ($photo) {
            unlink("./assets/images/" . $photo);
        }
        $updateQuery = $db->prepare("UPDATE tbl_users SET photo = NULL WHERE id = ?");
        $updateQuery->bind_param('d', $user_id);
        $updateQuery->execute();
        if ($updateQuery->affected_rows) {
            return true;
        }
    }
    return false;
}



?>