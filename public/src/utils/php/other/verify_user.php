<?php

if (!isset($_SESSION['username'])) {
      $_SESSION['msg'] = "You must log in first";
      header('location: ../../front/login.php');
}
if (isset($_GET['logout'])) {
      session_destroy();
      unset($_SESSION['username']);
      header("location: ../../front/login.php");
}