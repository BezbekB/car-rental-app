<?php
require_once('../../config/auth.php');
requireLoggedIn();
session_destroy();
header("Location: ./login.php");
exit
?>