<?php

function registerTrek($trek_name,$trek_departure,$trek_arrival,$trek_about,$trek_location,$trek_duration,$trek_image,$tmp_trek_image,$trek_type,$trek_altitude,$trek_price,$trek_status){

  global $connection;

  move_uploaded_file($tmp_trek_image, "trek-images/$trek_image");

  $user_id = $_SESSION['user_id'];
  $select_trek_organizer_id = mysqli_query($connection, "SELECT organizer_id FROM trek_organizer WHERE organizer_id = $user_id");
  $row = mysqli_fetch_assoc($select_trek_organizer_id);
  $trek_organizer_id = $row['organizer_id'];

  $stmt = mysqli_prepare($connection, "INSERT INTO treks(trek_name,trek_departure,trek_arrival,trek_about,trek_location,trek_duration,trek_image,trek_type,trek_altitude,trek_price,trek_status,trek_organizer_id) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
  mysqli_stmt_bind_param($stmt, "sssssssssssi", $trek_name,$trek_departure,$trek_arrival,$trek_about,$trek_location,$trek_duration,$trek_image,$trek_type,$trek_altitude,$trek_price,$trek_status,$trek_organizer_id);
  mysqli_stmt_execute($stmt);
  confirmQuery($stmt);
  header("Location: treks.php");
}

function updateTrek($trek_id,$trek_name,$trek_departure,$trek_arrival,$trek_about,$trek_location,$trek_duration,$trek_image,$tmp_trek_image,$trek_type,$trek_altitude,$trek_price,$trek_status){
  global $connection;
  if (empty($trek_image)) {
    $query = mysqli_query($connection, "SELECT trek_image FROM treks WHERE trek_id = $trek_id");
    confirmQuery($query);
    while($row = mysqli_fetch_assoc($query)){
      $trek_image = $row['trek_image'];
    }
  }
  move_uploaded_file($tmp_trek_image, "trek-images/$trek_image");

  $stmt = mysqli_prepare($connection, "UPDATE treks SET trek_name = ?, trek_departure = ?, trek_arrival = ?,trek_about = ?, trek_location = ?,trek_duration = ?,trek_image = ?,trek_type = ?,trek_altitude = ?,trek_price = ?,trek_status = ? WHERE trek_id = ?;");
  mysqli_stmt_bind_param($stmt, "sssssssssssi", $trek_name,$trek_departure,$trek_arrival,$trek_about,$trek_location,$trek_duration,$trek_image,$trek_type,$trek_altitude,$trek_price,$trek_status,$trek_id);
  mysqli_stmt_execute($stmt);
  confirmQuery($stmt);
  header("Location: treks.php");
}

function deleteTrek($trek_id){
  global $connection;
  $stmt = mysqli_prepare($connection, "DELETE FROM treks WHERE trek_id = ?");
  mysqli_stmt_bind_param($stmt, "i", $trek_id);
  mysqli_stmt_execute($stmt);
  confirmQuery($stmt);
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
