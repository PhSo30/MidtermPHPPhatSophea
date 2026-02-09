<?php
require_once './init/init.php';
$user = loggedInUser();
include './includes/header.inc.php';
include './includes/novbar.inc.php';
// $_GET['pages'];
// include_once './pages/'.$_GET['pages'].'.php';


$available_pages = ['login', 'register', 'dashboard', 'logout', 'profile']; //create array
$logged_in_pages = ['dashboard', 'profile']; //pages only for logged in users
$non_logged_in_pages = ['login', 'register']; //pages only for non-logged in users
$page = ''; //default page
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
if (in_array($page, $logged_in_pages) && empty($user)) {
    //redirect to login page
    header('Location: ./?page=login');
}
if (in_array($page, $non_logged_in_pages) && !empty($user)) {
    //redirect to dashboard page
    header('Location: ./?page=dashboard');
}
if (in_array($page, $available_pages)) {
    include_once './pages/' . $page . '.php';
} else {
    // header('Location: ./?page=login');
    header('Location: ./?page=dashboard'); // Header is used to redirect to dashboard by default
    // include_once './pages/' . 'dashboard' . '.php';
}

include './includes/footer.inc.php';
?>