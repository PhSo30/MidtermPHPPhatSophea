<?php
session_set_cookie_params(60 * 30);
$baseUrl = '/MidtermPHPPhatSophea/';
session_start();
require_once './init/db.init.php';
require_once './init/func/auth.func.init.php';
