<?php

function update_status(){
  global $connection;
  $current_date = date('Y-m-d');
  $query = mysqli_query($connection, "UPDATE treks SET trek_status = 'Off' WHERE '$current_date' > trek_departure");
  confirmQuery($query);
}

function deleteComment($comment_id, $trek_id){
  global $connection;

  $query = mysqli_query($connection, "DELETE FROM comments WHERE comment_id = $comment_id");
  confirmQuery($query);
  header("Location: ./trek.php?trek_id=$trek_id");
}

function insertIntoComment($user_id, $trek_id, $comment_content){
  global $connection;

  $query = mysqli_query($connection, "INSERT INTO comments(user_id, trek_id, comment_content, comment_date) VALUES($user_id, $trek_id, '$comment_content', now())");
  confirmQuery($query);
  header("Location: ./trek.php?trek_id=$trek_id");
}

function isLoggedout(){
  global $connection;

  if (empty($_SESSION['user_role'])) {
    return true;
  }
  return false;
}

function isOrganizer(){
  global $connection;

  if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] === 'Organizer') {
      return true;
    }
  }
  return false;
}

function isAdmin(){
  global $connection;

  if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] === 'Admin') {
      return true;
    }
  }
  return false;
}


function recordCount($table_name){
  global $connection;

  $query = mysqli_query($connection, "SELECT * FROM $table_name");
  $count = mysqli_num_rows($query);
  confirmQuery($query);
  return $count;
}

function recordCountFor($table_name, $where_clause,$condition){
  global $connection;

  $query = mysqli_query($connection, "SELECT * FROM $table_name WHERE $where_clause = '$condition'");
  $count = mysqli_num_rows($query);
  confirmQuery($query);
  return $count;
}

function viewsCount($trek_id){
  global $connection;

  $query = mysqli_query($connection, "SELECT * FROM views WHERE trek_id=$trek_id");
  confirmQuery($query);
  return mysqli_num_rows($query);
}

function escape($string){
  global $connection;
  return mysqli_real_escape_string($connection, $string);
}

function usernameExists($username){
  global $connection;

  $query = "SELECT username FROM users WHERE username = '{$username}'";
  $username_exists = mysqli_query($connection, $query);

  if (mysqli_num_rows($username_exists) > 0) {
    return true;
  }
  return false;
}

function confirmQuery($query){
  global $connection;
  if (!$query) {
    die('Query Failed: ' . mysqli_error($connection));
  }
}

function emailExists($user_email){
  global $connection;

  $query = "SELECT user_email FROM users WHERE user_email = '{$user_email}'";
  $email_exists = mysqli_query($connection, $query);

  if (mysqli_num_rows($email_exists) > 0) {
    return true;
  }
  return false;
}


//SELECT QUERIES
function trekTypeNameDisplay($trek_type_id){
  global $connection;

  $query = mysqli_query($connection, "SELECT * FROM trek_type WHERE trek_type_id = $trek_type_id");
  confirmQuery($query);
  $row = mysqli_fetch_assoc($query);
  echo $row['trek_type_name'];
}

function selectTreksForOrganizer(){
  global $connection;

  $organizer_id = $_SESSION['user_id'];

  $stmt  = "SELECT treks.trek_id,treks.trek_type_id,treks.trek_organizer_id, ";
  $stmt .= "trek_type.trek_type_name,";
  $stmt .= "treks.trek_name,treks.trek_departure,treks.trek_arrival,treks.trek_about,";
  $stmt .= "treks.trek_location,treks.trek_duration,treks.trek_image,treks.trek_views,";
  $stmt .= "treks.trek_altitude,treks.trek_price,treks.trek_status ";
  $stmt .= "FROM treks ";
  $stmt .= "INNER JOIN trek_type ON treks.trek_type_id = trek_type.trek_type_id ";
  $stmt .= "WHERE trek_organizer_id = $organizer_id";
  $query = mysqli_query($connection, $stmt);
  confirmQuery($query);

  return $query;
}

function selectTreksForSoop(){
  global $connection;

  $stmt  = "SELECT treks.trek_id,treks.trek_type_id,treks.trek_organizer_id, ";
  $stmt .= "trek_type.trek_type_name,";
  $stmt .= "treks.trek_name,treks.trek_departure,treks.trek_arrival,treks.trek_about,";
  $stmt .= "treks.trek_location,treks.trek_duration,treks.trek_image,treks.trek_views,";
  $stmt .= "treks.trek_altitude,treks.trek_price,treks.trek_status ";
  $stmt .= "FROM treks ";
  $stmt .= "INNER JOIN trek_type ON treks.trek_type_id = trek_type.trek_type_id ";
  $query = mysqli_query($connection, $stmt);
  confirmQuery($query);

  return $query;
}

function selectTreksWithStatusOn(){
  global $connection;

  $query = mysqli_query($connection, "SELECT * FROM treks WHERE trek_status = 'On'");
  confirmQuery($query);

  return $query;
}

function selectTrekOfType($type,$status){
  global $connection;

  $query = mysqli_query($connection, "SELECT * FROM treks WHERE trek_type_id = '$type' AND trek_status = '$status'");
  confirmQuery($query);

  return $query;
}

function searchTrek($search_tags){
  global $connection;

  $query = mysqli_query($connection, "SELECT * FROM treks WHERE trek_tags LIKE '%$search_tags%' AND trek_status='On' OR trek_name LIKE '%$search_tags%' AND trek_status='On' OR trek_location LIKE '%$search_tags%' AND trek_status='On'");
  confirmQuery($query);

  return $query;
}



function registerUser($user_firstname, $user_lastname, $username, $user_email, $user_phonenumber, $user_image, $tmp_user_image, $user_dob, $user_password){
  global $connection;

  move_uploaded_file($tmp_user_image, "images/$user_image");

  $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

  $user_role = 'User';
  $stmt = mysqli_prepare($connection, "INSERT INTO users(user_firstname, user_lastname, username, user_email, user_phonenumber, user_image, user_dob, user_password, user_role) VALUES(?,?,?,?,?,?,?,?,?)");
  mysqli_stmt_bind_param($stmt, "ssssissss", $user_firstname, $user_lastname, $username, $user_email, $user_phonenumber, $user_image, $user_dob, $user_password, $user_role);
  mysqli_stmt_execute($stmt);

  if (!$stmt) {
    die(mysqli_error($connection));
  }

  header("Location: ./index.php");
}

function updateUser($user_id, $user_firstname, $user_lastname, $username, $user_email, $user_phonenumber, $user_image, $tmp_user_image, $user_dob, $user_password){
  global $connection;

  if (empty($user_image)) {
    $query = mysqli_query($connection, "SELECT user_image FROM users WHERE user_id = $user_id");
    confirmQuery($query);
    while($row = mysqli_fetch_assoc($query)){
      $user_image = $row['user_image'];
      $_SESSION['user_image'] = $user_image;
    }
  }else{
    $_SESSION['user_image'] = $user_image;
  }

  if (empty($user_password)) {
    $query = mysqli_query($connection, "SELECT user_password FROM users WHERE user_id = $user_id");
    confirmQuery($query);
    while($row = mysqli_fetch_assoc($query)){
      $user_password = $row['user_password'];
    }
  }else{
    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
  }

  move_uploaded_file($tmp_user_image, "images/$user_image");


  $stmt = mysqli_prepare($connection, "UPDATE users SET user_firstname = ?, user_lastname = ?, username = ?, user_email = ?, user_phonenumber = ?, user_image = ?, user_dob = ?, user_password = ? WHERE user_id = ?;");
  mysqli_stmt_bind_param($stmt, "ssssssssi", $user_firstname, $user_lastname, $username, $user_email, $user_phonenumber, $user_image, $user_dob, $user_password, $user_id);
  mysqli_stmt_execute($stmt);
  confirmQuery($stmt);
  
  header("Location: ./profile.php");
}


function loginUser($user_data, $user_password){
  global $connection;

  $query = "SELECT * FROM users WHERE user_email = '{$user_data}' OR username = '{$user_data}'";
  $login_user = mysqli_query($connection, $query);

  while($row = mysqli_fetch_assoc($login_user)){
    $db_user_id          = $row['user_id'];
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
      $_SESSION['user_id']          = $db_user_id;
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
