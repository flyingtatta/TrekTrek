<?php

  function deleteUser($user_id){
    global $connection;
    $stmt = mysqli_prepare($connection, "DELETE FROM users WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    confirmQuery($stmt);
    header("Location: users.php");
  }

  function changeRole($user_id, $user_role){
    global $connection;
    if ($user_role == 'Organizer') {
      $temp_role = 'User';

      $stmt = mysqli_prepare($connection, "UPDATE users SET user_role = ? WHERE user_id = ?");
      mysqli_stmt_bind_param($stmt, "si", $temp_role, $user_id);
      mysqli_stmt_execute($stmt);
      confirmQuery($stmt);

      $stmt = mysqli_prepare($connection, "DELETE FROM trek_organizer WHERE organizer_id = ?");
      mysqli_stmt_bind_param($stmt, "i", $user_id);
      mysqli_stmt_execute($stmt);

      header("Location: users.php");

    }else if ($user_role == 'User') {
      $temp_role = 'Organizer';
      $stmt = mysqli_prepare($connection, "UPDATE users SET user_role = ? WHERE user_id = ?");
      mysqli_stmt_bind_param($stmt, "si", $temp_role, $user_id);
      mysqli_stmt_execute($stmt);
      confirmQuery($stmt);

      $select_new_organizer_id = mysqli_query($connection, "SELECT * FROM users WHERE user_id = $user_id");
      $row = mysqli_fetch_assoc($select_new_organizer_id);
      $user_email = $row['user_email'];

      $query = mysqli_query($connection, "INSERT INTO trek_organizer(organizer_id, trek_organizer_email) VALUES($user_id,'$user_email')");

      header("Location: users.php");
    }
  }

  function addUser($user_firstname, $user_lastname, $username, $user_email, $user_phonenumber, $user_image, $tmp_user_image, $user_dob, $user_password, $user_role){
    global $connection;

    move_uploaded_file($tmp_user_image, "/TrekTrek/images/$user_image");

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

    if ($user_role == 'Organizer') {
      $stmt1 = mysqli_prepare($connection, "INSERT INTO users(user_firstname, user_lastname, username, user_email, user_phonenumber, user_image, user_dob, user_password, user_role) VALUES(?,?,?,?,?,?,?,?,?)");
      mysqli_stmt_bind_param($stmt1, "ssssissss", $user_firstname, $user_lastname, $username, $user_email, $user_phonenumber, $user_image, $user_dob, $user_password, $user_role);
      mysqli_stmt_execute($stmt1);

      $select_new_organizer_id = mysqli_query($connection, "SELECT user_id FROM users WHERE user_email = '$user_email'");
      $row = mysqli_fetch_assoc($select_new_organizer_id);
      $user_id = $row['user_id'];

      $query = mysqli_query($connection, "INSERT INTO trek_organizer(organizer_id, trek_organizer_email) VALUES($user_id,'$user_email')");

      confirmQuery($stmt1);
      confirmQuery($query);
    }else if ($user_role == 'User') {
      $stmt = mysqli_prepare($connection, "INSERT INTO users(user_firstname, user_lastname, username, user_email, user_phonenumber, user_image, user_dob, user_password, user_role) VALUES(?,?,?,?,?,?,?,?,?)");
      mysqli_stmt_bind_param($stmt, "ssssissss", $user_firstname, $user_lastname, $username, $user_email, $user_phonenumber, $user_image, $user_dob, $user_password, $user_role);
      mysqli_stmt_execute($stmt);
      confirmQuery($stmt);
    }

    header("Location: users.php");
  }
?>
