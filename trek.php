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

  $query = "SELECT treks.trek_id,treks.trek_type_id,treks.trek_organizer_id, ";
  $query .= "users.user_firstname,users.user_lastname,users.user_image, users.user_phonenumber, ";
  $query .= "trek_type.trek_type_name,";

  $query .= "treks.trek_name,treks.trek_departure,treks.trek_arrival,treks.trek_about,";
  $query .= "treks.trek_location,treks.trek_duration,treks.trek_image,treks.trek_views,";
  $query .= "treks.trek_altitude,treks.trek_price,treks.trek_status ";

  $query .= "FROM treks ";

  $query .= "INNER JOIN users ON treks.trek_organizer_id = users.user_id ";
  $query .= "INNER JOIN trek_type ON treks.trek_type_id = trek_type.trek_type_id ";

  $query .= "WHERE trek_id = $trek_id";

  $select_trek = mysqli_query($connection, $query);
  confirmQuery($select_trek);

  while ($row = mysqli_fetch_assoc($select_trek)) {
    $trek_name         = $row['trek_name'];
    $trek_departure    = date("d-m-Y", strtotime($row['trek_departure']));
    $trek_arrival      = date("d-m-Y", strtotime($row['trek_arrival']));
    $trek_about        = $row['trek_about'];
    $trek_location     = $row['trek_location'];
    $trek_duration     = $row['trek_duration'];
    $trek_image        = $row['trek_image'];
    $trek_type_id      = $row['trek_type_id'];
    $trek_views        = $row['trek_views'];
    $trek_altitude     = $row['trek_altitude'];
    $trek_price        = $row['trek_price'];
    $trek_status       = $row['trek_status'];

    $user_firstname    = $row['user_firstname'];
    $user_lastname     = $row['user_lastname'];
    $user_image        = $row['user_image'];
    $user_phonenumber  = $row['user_phonenumber'];

    $trek_type_name    = $row['trek_type_name'];
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


          <span style="font-size: 2rem; font-weight: 300;" class="d-flex justify-content-center">
            <img src="images/<?php echo $user_image; ?>" class="img-fluid rounded rounded-lg" style="height: 45px;">
            <span style="font-weight: 400;">
              <?php echo $user_firstname . " " . $user_lastname; ?>
            </span>
            :
            <?php echo $user_phonenumber; ?>

          </span>

          <br>

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
          // trekTypeNameDisplay($trek_type_id);
          echo $trek_type_name;
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
