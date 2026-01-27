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
        return true;
    }
    return false;
}



?>