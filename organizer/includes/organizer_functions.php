<?php

function registerTrek($trek_name,$trek_departure,$trek_arrival,$trek_about,$trek_location,$trek_duration,$trek_image,$tmp_trek_image,$trek_type,$trek_altitude,$trek_price,$trek_status){

  global $connection;

  move_uploaded_file($tmp_trek_image, "trek-images/$trek_image");

  $stmt = mysqli_prepare($connection, "INSERT INTO treks(trek_name,trek_departure,trek_arrival,trek_about,trek_location,trek_duration,trek_image,trek_type,trek_altitude,trek_price,trek_status) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
  mysqli_stmt_bind_param($stmt, "sssssssssss", $trek_name,$trek_departure,$trek_arrival,$trek_about,$trek_location,$trek_duration,$trek_image,$trek_type,$trek_altitude,$trek_price,$trek_status);
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
?>
