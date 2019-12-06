<?php

  session_start();

  $_SESSION['user_email'] = null;
  $_SESSION['user_password'] = null;

  header('Location: ../index.php');

?>
