<div class="mx-3">
<h1 class="display-4">
  All Treks
</h1>

<?php
  $query = "SELECT * FROM treks ORDER BY trek_id DESC";
  $select_treks = mysqli_query($connection, $query);
  confirmQuery($query);
?>


<table class="table table-bordered">
  <thead>
    <td>Delete</th>
    <td>Edit</th>
    <th class="text-center">Id</th>
    <th class="text-center">Name</th>
    <th class="text-center px-3">Departure</th>
    <th class="text-center px-5">Arrival</th>
    <th class="text-center">About</th>
    <th class="text-center">Location</th>
    <th class="text-center">Duration</th>
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
      $trek_type      = $row['trek_type'];
      $trek_altitude  = $row['trek_altitude'];
      $trek_price     = $row['trek_price'];
      $trek_status    = $row['trek_status'];
      $trek_views     = $row['trek_views']; ?>

      <tr>
        <td class="text-center">
          <a href="treks.php?delete=<?php echo $trek_id; ?>">
            <i class="fa fa-trash text-danger fa-lg"></i>
          </a>
        </td>
        <td class="text-center">
          <a href="">
            <i class="fa fa-edit text-primary fa-lg"></i>
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
        <td class="text-center" ><?php echo $trek_type; ?></td>
        <td class="text-center" ><?php echo $trek_altitude; ?></td>
        <td class="text-center" >&#8377;<?php echo $trek_price; ?></td>
        <td class="text-center"><?php echo $trek_status; ?></td>
        <td class="text-center" >
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
          ;">
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
  if (isset($_GET['delete'])) {
    $trek_id = $_GET['delete'];

    $stmt = mysqli_prepare($connection, "DELETE FROM treks WHERE trek_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $trek_id);
    mysqli_stmt_execute($stmt);
    confirmQuery($stmt);
    header("Location: treks.php");
  }
?>
