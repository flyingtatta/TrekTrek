<?php

  function registerUser($user_firstname, $user_lastname, $username, $user_email, $user_phonenumber, $user_image, $tmp_user_image, $user_dob, $user_password){
    global $connection;

    move_uploaded_file($tmp_user_image, "images/$user_image");

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

    $user_role = 'User';
    $stmt = mysqli_prepare($connection, "INSERT INTO users(user_firstname, user_lastname, username, user_email, user_phonenumber, user_dob, user_image, user_password, user_role) VALUES(?,?,?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt, "ssssissss", $user_firstname, $user_lastname, $username, $user_email, $user_phonenumber, $user_image, $user_dob, $user_password, $user_role);
    mysqli_stmt_execute($stmt);

    if (!$stmt) {
      die(mysqli_error($connection));
    }

    header("Location: ./index.php");
  }

  function loginUser($user_email, $user_password){
    global $connection;

    $query = "SELECT * FROM users WHERE user_email = '{$user_email}'";
    $login_user = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($login_user)){
      $db_user_firstname   = $row['user_firstname'];
      $db_user_lastname    = $row['user_lastname'];
      $db_username         = $row['username'];
      $db_user_email       = $row['user_email'];
      $db_user_phonenumber = $row['user_phonenumber'];
      $db_user_image       = $row['user_image'];
      $db_user_dob         = $row['user_dob'];
      $db_user_password    = $row['user_password'];
      $db_user_role        = $row['user_role'];

    if (password_verify($user_password, $db_user_password)) {
      $_SESSION['user_firstname']   = $db_user_firstname;
      $_SESSION['user_lastname']    = $db_user_lastname;
      $_SESSION['username']         = $db_username;
      $_SESSION['user_email']       = $db_user_email;
      $_SESSION['user_phonenumber'] = $db_user_phonenumber;
      $_SESSION['user_image']       = $db_user_image;
      $_SESSION['user_dob']         = $db_user_dob;
      $_SESSION['user_password']    = $db_user_password;
      $_SESSION['user_role']        = $db_user_role;

      header("Location: ./index.php");
    }
  }
  }

?>
