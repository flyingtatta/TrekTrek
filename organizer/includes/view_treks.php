<div class="mx-3">
<h1 class="display-4">
  All Treks
</h1>

<?php
if (!isset($_POST['search'])) {
  $user_id = $_SESSION['user_id'];
  $query  = "SELECT treks.trek_id,treks.trek_type_id,treks.trek_organizer_id, ";
  $query .= "trek_type.trek_type_name,";
  $query .= "treks.trek_name,treks.trek_departure,treks.trek_arrival,treks.trek_about,";
  $query .= "treks.trek_location,treks.trek_duration,treks.trek_image,treks.trek_views,";
  $query .= "treks.trek_altitude,treks.trek_price,treks.trek_status ";
  $query .= "FROM treks ";
  $query .= "INNER JOIN trek_type ON treks.trek_type_id = trek_type.trek_type_id ";
  $query .= "WHERE trek_organizer_id = '$user_id' ORDER BY trek_id DESC";

  $select_treks = mysqli_query($connection, $query);
  confirmQuery($query);
}else if(isset($_POST['search'])){
  $user_id = $_SESSION['user_id'];
  $search_trek = $_POST['search_tags'];

  $query = "SELECT * FROM treks WHERE trek_organizer_id = '$user_id' AND trek_tags LIKE '%$search_trek%' OR trek_status LIKE '%$search_trek%'  OR trek_name LIKE '%$search_trek%'ORDER BY trek_id DESC";
  $select_treks = mysqli_query($connection, $query);
  confirmQuery($query);
}

?>


<table class="table table-bordered">
  <thead>
    <td>Delete</th>
    <td>Edit</th>
    <td>View</th>
    <th class="text-center">Id</th>
    <th class="text-center">Name</th>
    <th class="text-center px-3">Departure</th>
    <th class="text-center px-5">Arrival</th>
    <th class="text-center">About</th>
    <th class="text-center">Location</th>
    <th class="text-center">Days</th>
    <th class="text-center">Image</th>
    <th class="text-center">Type</th>
    <th class="text-center">Altitude</th>
    <th class="text-center">Price</th>
    <th class="text-center">Status</th>
    <th class="text-center">Views</th>
  </thead>
  <tbody>

    <?php
    while ($row = mysqli_fetch_assoc($select_treks)) {
      $trek_id        = $row['trek_id'];
      $trek_name      = $row['trek_name'];
      $trek_departure = date("d-m-Y", strtotime($row['trek_departure']));
      $trek_arrival   = date("d-m-Y", strtotime($row['trek_arrival']));
      $trek_about     = trim(substr($row['trek_about'], 0, 50));
      $trek_about     = $trek_about . "...";
      $trek_location  = $row['trek_location'];
      $trek_duration  = $row['trek_duration'];
      $trek_image     = $row['trek_image'];
      $trek_type_id   = $row['trek_type_id'];
      $trek_type_name = $row['trek_type_name'];
      $trek_altitude  = $row['trek_altitude'];
      $trek_price     = $row['trek_price'];
      $trek_status    = $row['trek_status'];
      $trek_views     = $row['trek_views']; ?>

      <tr>
        <td class="text-center">
          <form class="" action="" method="post" onsubmit="return confirm('Are you sure you want to delete?');">
            <input type="hidden" name="trek_id" value="<?php echo $trek_id; ?>">
            <input type="submit" name="delete" value="Delete" class="btn btn-danger">
          </form>
        </td>
        <td class="text-center">
          <a href="./treks.php?source=edit_treks&trek_id=<?php echo $trek_id; ?>">
            <i class="fa fa-edit text-primary fa-lg"></i>
          </a>
        </td>
        <td class="text-center">
          <a href="../trek.php?trek_id=<?php echo $trek_id; ?>">
            <i class="fa fa-eye text-dark fa-sm"></i>
          </a>
        </td>
        <td class="text-center"><?php echo $trek_id; ?></td>
        <td class="text-center"><?php echo $trek_name; ?></td>
        <td class="text-center"><?php echo $trek_departure; ?></td>
        <td class="text-center"><?php echo $trek_arrival; ?></td>
        <td class="text-left"><?php echo $trek_about; ?></td>
        <td class="text-center" ><?php echo $trek_location; ?></td>
        <td class="text-center" ><?php echo $trek_duration; ?></td>
        <td class="text-center" ><img src="trek-images/<?php echo $trek_image; ?>" width="200" height="100"></td>
        <td class="text-center" ><?php echo $trek_type_name; ?></td>
        <td class="text-center" ><?php echo $trek_altitude; ?></td>
        <td class="text-center" >&#8377;<?php echo $trek_price; ?></td>
        <td class="text-center">


          <form class="" action="" method="post" onsubmit="return confirm('Are you sure you want to change status?');">
            <input type="hidden" name="trek_id" value="<?php echo $trek_id; ?>">
            <input type="hidden" name="trek_status" value="<?php echo $trek_status; ?>">
            <span class="badge badge-primary badge-pill" style="background-color:
            <?php if ($trek_status == 'On'): ?>
              <?php echo "#28a745";?>
            <?php else: ?>
              <?php echo "#dc3545";?>
            <?php endif; ?>">
              <input type="submit" name="change_status" value="<?php echo $trek_status; ?>" style="background: none; border: none; color: white; font-size: 0.9rem; outline:none;">
            </span>
          </form>

        </td>

        <td class="text-center">
          <span class="badge badge-primary badge-pill" style="background-color:
          <?php if ($trek_views >= 0 && $trek_views < 25): ?>
          <?php echo "#dc3545";?>
          <?php endif; ?>

          <?php if ($trek_views >= 25 && $trek_views < 50): ?>
          <?php echo "#007bff"; ?>
          <?php endif; ?>

          <?php if ($trek_views >= 50): ?>
          <?php echo "#28a745"; ?>
          <?php endif; ?>
          ; font-size: 0.9rem;">
            <?php echo $trek_views; ?>
          </span>
        </td>
      </tr>

    <?php
      }
    ?>


  </tbody>
</table>
</div>

<?php
  if (isset($_POST['delete'])) {
    $trek_id = $_POST['trek_id'];
    deleteTrek($trek_id);
  }

  if (isset($_POST['change_status'])) {
    $trek_id = $_POST['trek_id'];
    $trek_status = $_POST['trek_status'];
    reverseStatus($trek_id, $trek_status);
  }
?>
