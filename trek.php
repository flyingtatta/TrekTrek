<?php
include 'includes/header.php';
session_start();
include 'includes/functions.php';
include 'includes/navigation.php';


if (isset($_GET['trek_id'])) {
  $trek_id = $_GET['trek_id'];

  if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'User') {
    $query = mysqli_query($connection,"UPDATE treks SET trek_views = trek_views+1 WHERE trek_id = $trek_id");
    confirmQuery($query);
  }
  // else if(isset($_SESSION['user_role']) && $_SESSION['user_role'] != 'Organizer'){
  //
  // }

  $query = "SELECT * FROM treks WHERE trek_id = $trek_id";
  $select_trek = mysqli_query($connection, $query);
  confirmQuery($select_trek);

  while ($row = mysqli_fetch_assoc($select_trek)) {
    $trek_name      = $row['trek_name'];
    $trek_departure = date("d-m-Y", strtotime($row['trek_departure']));
    $trek_arrival   = date("d-m-Y", strtotime($row['trek_arrival']));
    $trek_about     = $row['trek_about'];
    $trek_location  = $row['trek_location'];
    $trek_duration  = $row['trek_duration'];
    $trek_image     = $row['trek_image'];
    $trek_type_id   = $row['trek_type_id'];
    $trek_views     = $row['trek_views'];
    $trek_altitude  = $row['trek_altitude'];
    $trek_price     = $row['trek_price'];
    $trek_status    = $row['trek_status'];
  }
  ?>

  <div class="mx-3 my-3">
    <div class="row">
      <div class="col-12 col-md-6">
        <h5 class="display-3" style="font-weight: 400;"><?php echo $trek_name; ?></h5>
        <p class="lead">
          <span style="font-size: 2rem; font-weight: 300;">About</span>
          <br>
          <?php echo $trek_about; ?>
        </p>
      </div>

      <div class="col-12 col-md-6">
        <img src="organizer/trek-images/<?php echo $trek_image; ?>" class="img-fluid rounded rounded-lg">
      </div>
    </div>

    <div class="row my-3">
      <div class="col-12 text-center">
        <p class="lead m-0" style="font-size: 2rem; font-weight: 400;">
          <?php echo $trek_departure; ?>
          <i class="fa fa-angle-double-right"></i>
          <?php echo $trek_arrival; ?>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-md-6">
        <img src="organizer/trek-images/<?php echo $trek_image; ?>" class="img-fluid rounded rounded-lg">
      </div>

      <div class="col-12 col-md-6 text-left align-self-center">
        <p class="lead m-0" style="font-size: 1.5rem;">
          <span style="font-size: 2rem; font-weight: 400;">Altitude : </span>
          <?php echo $trek_altitude; ?>

          <br>

          <span style="font-size: 2rem; font-weight: 400;">Cost : </span>
          &#8377;<?php echo $trek_price; ?>

          <br>

          <span style="font-size: 2rem; font-weight: 400;">Location : </span>
          <?php echo $trek_location; ?>

          <br>

          <span style="font-size: 2rem; font-weight: 400;">Type : </span>
          <?php
          trekTypeNameDisplay($trek_type_id);
          ?>

          <br>

          <span style="font-size: 2rem; font-weight: 400;">Views:</span>
          <?php echo $trek_views; ?>

          <br>
        </p>

      </div>
    </div>

    <?php include 'includes/comments.php' ?>

  </div>



  <?php
}else{
  header("Location: ./index.php");
}
?>



<?php include 'includes/footer.php'; ?>
