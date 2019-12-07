<div class="mx-3">
<h1 class="display-4">
  All Treks
</h1>

<?php
  $query = "SELECT * FROM treks";
  $select_treks = mysqli_query($connection, $query);
  confirmQuery($query);
?>


<table class="table table-bordered">
  <thead>
    <th>Id</th>
    <th>Name</th>
    <th>Departure</th>
    <th>Arrival</th>
    <th>About</th>
    <th>Location</th>
    <th>Duration</th>
    <th>Image</th>
    <th>Type</th>
    <th>Altitude</th>
    <th>Price</th>
    <th>Status</th>
    <th>Views</th>
  </thead>
  <tbody>
    <?php
    while ($row = mysqli_fetch_assoc($select_treks)) {
      $trek_id        = $row['trek_id'];
      $trek_name      = $row['trek_name'];
      $trek_departure = $row['trek_departure'];
      $trek_arrival   = $row['trek_arrival'];
      $trek_about     = $row['trek_about'];
      $trek_location  = $row['trek_location'];
      $trek_duration  = $row['trek_duration'];
      $trek_image     = $row['trek_image'];
      $trek_type      = $row['trek_type'];
      $trek_altitude  = $row['trek_altitude'];
      $trek_price     = $row['trek_price'];
      $trek_status    = $row['trek_status'];
      $trek_views     = $row['trek_views']; ?>

      <tr>
        <td><?php echo $trek_id; ?></td>
        <td><?php echo $trek_name; ?></td>
        <td><?php echo $trek_departure; ?></td>
        <td><?php echo $trek_arrival; ?></td>
        <td><?php echo $trek_about; ?></td>
        <td><?php echo $trek_location; ?></td>
        <td><?php echo $trek_duration; ?></td>
        <td><img src="trek-images/<?php echo $trek_image; ?>" width="200" height="100"></td>
        <td><?php echo $trek_type; ?></td>
        <td><?php echo $trek_altitude; ?>ft</td>
        <td>&#8377;<?php echo $trek_price; ?></td>
        <td><?php echo $trek_status; ?></td>
        <td><?php echo $trek_views; ?></td>
      </tr>

    <?php
      }
    ?>


  </tbody>
</table>
</div>
