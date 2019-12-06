<?php

  session_start();

  $_SESSION['user_firstname']   = null;
  $_SESSION['user_lastname']    = null;
  $_SESSION['username']         = null;
  $_SESSION['user_email']       = null;
  $_SESSION['user_phonenumber'] = null;
  $_SESSION['user_image']       = null;
  $_SESSION['user_dob']         = null;
  $_SESSION['user_password']    = null;
  $_SESSION['user_role']        = null;

  header('Location: ../index.php');

?>
