<?php

  function insertIntoTrekOrganizer($user_id, $user_email){
    global $connection;

    $stmt = mysqli_prepare($connection, "INSERT INTO trek_organizer(organizer_id, trek_organizer_email) VALUES(?,?)");
    mysqli_stmt_bind_param($stmt, "is", $user_id, $user_email);
    mysqli_stmt_execute($stmt);
    confirmQuery($stmt);
  }

  function deleteUser($user_id){
    global $connection;

    $deletestmt = mysqli_prepare($connection, "DELETE FROM users WHERE user_id = ?");
    mysqli_stmt_bind_param($deletestmt, "i", $user_id);
    mysqli_stmt_execute($deletestmt);
    confirmQuery($deletestmt);

    header("Location: users.php");
  }

  function updateUserRole($temp_role, $user_id){
    global $connection;

    $stmt = mysqli_prepare($connection, "UPDATE users SET user_role = ? WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "si", $temp_role, $user_id);
    mysqli_stmt_execute($stmt);
    confirmQuery($stmt);
  }

  function deleteTrekOrganizer($user_id){
    global $connection;

    $deletestmt = mysqli_prepare($connection, "DELETE FROM trek_organizer WHERE organizer_id = ?");
    mysqli_stmt_bind_param($deletestmt, "i", $user_id);
    mysqli_stmt_execute($deletestmt);

    $stmt = mysqli_prepare($connection, "DELETE FROM treks WHERE trek_organizer_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    confirmQuery($stmt);
  }

  function changeRole($user_id, $user_role){
    global $connection;
    if ($user_role == 'Organizer') {

      // Changing the role to user
      $user_role = 'User';

      updateUserRole($user_role, $user_id);

      //deleting the data in the trek organizer database where user id is samme
      deleteTrekOrganizer($user_id);

      header("Location: users.php");

    }else if ($user_role == 'User') {

      // Changing to organizer
      $user_role = 'Organizer';

      updateUserRole($user_role, $user_id);

      $stmt = mysqli_prepare($connection, "SELECT * FROM users WHERE user_id = ?");
      mysqli_stmt_bind_param($stmt, "i", $user_id);
      mysqli_stmt_execute($stmt);
      $result = $stmt -> get_result();
      $row = $result -> fetch_assoc();
      $user_email = $row['user_email'];
      confirmQuery($stmt);

      insertIntoTrekOrganizer($user_id, $user_email);

      header("Location: users.php");
    }
  }

  function insertDataIntoUsers($user_firstname, $user_lastname, $username, $user_email, $user_phonenumber, $user_image, $user_dob, $user_password, $user_role){
    global $connection;

    $stmt = mysqli_prepare($connection, "INSERT INTO users(user_firstname, user_lastname, username, user_email, user_phonenumber, user_image, user_dob, user_password, user_role) VALUES(?,?,?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt, "ssssissss", $user_firstname, $user_lastname, $username, $user_email, $user_phonenumber, $user_image, $user_dob, $user_password, $user_role);
    mysqli_stmt_execute($stmt);
    confirmQuery($stmt);
  }

  function selectUserID($user_email){
    global $connection;

    $stmt = mysqli_prepare($connection, "SELECT user_id FROM users WHERE user_email = ?");
    mysqli_stmt_bind_param($stmt, "s", $user_email);
    mysqli_stmt_execute($stmt);
    $result = $stmt -> get_result();
    $row = $result -> fetch_assoc();
    $user_id = $row['user_id'];

    confirmQuery($stmt);

    insertIntoTrekOrganizer($user_id, $user_email);
  }

  function addUser($user_firstname, $user_lastname, $username, $user_email, $user_phonenumber, $user_image, $tmp_user_image, $user_dob, $user_password, $user_role){
    global $connection;

    move_uploaded_file($tmp_user_image, "/TrekTrek/images/$user_image");
    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

    if ($user_role == 'Organizer') {

      insertDataIntoUsers($user_firstname, $user_lastname, $username, $user_email, $user_phonenumber, $user_image, $user_dob, $user_password, $user_role);

      selectUserID($user_email);

    }else if ($user_role == 'User') {
      insertDataIntoUsers($user_firstname, $user_lastname, $username, $user_email, $user_phonenumber, $user_image, $user_dob, $user_password, $user_role);
    }

    header("Location: users.php");
  }
?>
