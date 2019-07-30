<?php

session_start();

if(!isset($_SESSION['admin']) && $_SESSION['admin']==false) {
    header("Location:index.php");
    die();
}

unset($_SESSION['admin']);
header("Location:index.php");
