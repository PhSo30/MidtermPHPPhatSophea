<?php
include './includes/header.inc.php';
include './includes/novbar.inc.php';
// $_GET['pages'];
// include_once './pages/'.$_GET['pages'].'.php';

$available_pages = ['login', 'register']; //create array

if (isset($_GET['page'])) {
    //     echo $_GET['page'];

    // include './pages/' . $_GET['page'] . '.php';
    $page = $_GET['page'];
    if (in_array($page, $available_pages)) { //check if value in array
        include './pages/' . $page . '.php';
    } else {
        echo '<h1>Error 404</h1>';
    }


} else {
    echo '<h1>Home Page</h1>';
}
include './includes/footer.inc.php';
?>