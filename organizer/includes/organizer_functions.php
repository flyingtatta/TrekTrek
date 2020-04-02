<?php
function recordCountTreks($table_name, $trek_organizer_id){
  global $connection;

  $query = mysqli_query($connection, "SELECT * FROM $table_name WHERE trek_organizer_id = $trek_organizer_id");
  $count = mysqli_num_rows($query);
  confirmQuery($query);
  return $count;
}

function recordCountForTreks($table_name,$where,$trek_status, $trek_organizer_id){
  global $connection;
  $query = mysqli_query($connection, "SELECT * FROM $table_name WHERE trek_organizer_id = '$trek_organizer_id' AND trek_status = '$trek_status'");
  $count = mysqli_num_rows($query);
  confirmQuery($query);
  return $count;
}

function registerTrek($trek_name,$trek_departure,$trek_arrival,$trek_about,$trek_location,$trek_duration,$trek_image,$tmp_trek_image,$trek_type_id,$trek_altitude,$trek_price,$trek_status){

  global $connection;



  $user_id = $_SESSION['user_id'];
  $select_trek_organizer_id = mysqli_query($connection, "SELECT organizer_id FROM trek_organizer WHERE organizer_id = $user_id");
  $row = mysqli_fetch_assoc($select_trek_organizer_id);
  $trek_organizer_id = $row['organizer_id'];

  $stmt = mysqli_prepare($connection, "INSERT INTO treks(trek_name,trek_departure,trek_arrival,trek_about,trek_location,trek_duration,trek_image,trek_type_id,trek_altitude,trek_price,trek_status,trek_organizer_id) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
  mysqli_stmt_bind_param($stmt, "sssssssisssi", $trek_name,$trek_departure,$trek_arrival,$trek_about,$trek_location,$trek_duration,$trek_image,$trek_type_id,$trek_altitude,$trek_price,$trek_status,$trek_organizer_id);
  mysqli_stmt_execute($stmt);
  confirmQuery($stmt);
  header("Location: treks.php");
}

function updateTrek($trek_id,$trek_name,$trek_departure,$trek_arrival,$trek_about,$trek_location,$trek_duration,$trek_image,$tmp_trek_image,$trek_type_id,$trek_altitude,$trek_price,$trek_status){
  global $connection;
  if (empty($trek_image)) {
    $query = mysqli_query($connection, "SELECT trek_image FROM treks WHERE trek_id = $trek_id");
    confirmQuery($query);
    while($row = mysqli_fetch_assoc($query)){
      $trek_image = $row['trek_image'];
    }
  }
  move_uploaded_file($tmp_trek_image, "trek-images/$trek_image");

  $stmt = mysqli_prepare($connection, "UPDATE treks SET trek_name = ?, trek_departure = ?, trek_arrival = ?,trek_about = ?, trek_location = ?,trek_duration = ?,trek_image = ?,trek_type_id = ?,trek_altitude = ?,trek_price = ?,trek_status = ? WHERE trek_id = ?;");
  mysqli_stmt_bind_param($stmt, "sssssssisssi", $trek_name,$trek_departure,$trek_arrival,$trek_about,$trek_location,$trek_duration,$trek_image,$trek_type_id,$trek_altitude,$trek_price,$trek_status,$trek_id);
  mysqli_stmt_execute($stmt);
  confirmQuery($stmt);
  header("Location: treks.php");
}

function deleteTrek($trek_id){
  global $connection;
  $comments = mysqli_prepare($connection, "DELETE FROM comments WHERE trek_id = ?");
  mysqli_stmt_bind_param($comments, "i", $trek_id);
  mysqli_stmt_execute($comments);

  $views = mysqli_prepare($connection, "DELETE FROM views WHERE trek_id = ?");
  mysqli_stmt_bind_param($views, "i", $trek_id);
  mysqli_stmt_execute($views);

  $interested = mysqli_prepare($connection, "DELETE FROM interested WHERE trek_id = ?");
  mysqli_stmt_bind_param($interested, "i", $trek_id);
  mysqli_stmt_execute($interested);

  $trek = mysqli_prepare($connection, "DELETE FROM treks WHERE trek_id = ?");
  mysqli_stmt_bind_param($trek, "i", $trek_id);
  mysqli_stmt_execute($trek);
  confirmQuery($trek);
  header("Location: treks.php");
}

function reverseStatus($trek_id, $trek_status){
  global $connection;
  if ($trek_status == 'On') {
    $trek_status = 'Off';
    $stmt = mysqli_prepare($connection, "UPDATE treks SET trek_status = ? WHERE trek_id = ?");
    mysqli_stmt_bind_param($stmt, "si", $trek_status, $trek_id);
    mysqli_stmt_execute($stmt);
    confirmQuery($stmt);
  }else if ($trek_status == 'Off') {
    $trek_status = 'On';
    $stmt = mysqli_prepare($connection, "UPDATE treks SET trek_status = ? WHERE trek_id = ?");
    mysqli_stmt_bind_param($stmt, "si", $trek_status, $trek_id);
    mysqli_stmt_execute($stmt);
    confirmQuery($stmt);
  }
  header("Location: treks.php");
}
?>
