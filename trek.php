<?php
include 'includes/header.php';
session_start();
include 'includes/functions.php';
include 'includes/navigation.php';


if (isset($_GET['trek_id'])) {
  $trek_id = $_GET['trek_id'];

  if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'User') {
    $user_id = $_SESSION['user_id'];

    $stmt = mysqli_query($connection, "SELECT * FROM views WHERE user_id=$user_id AND trek_id=$trek_id");
    confirmQuery($stmt);
    if (mysqli_num_rows($stmt) <= 0) {
      $query = mysqli_query($connection,"INSERT INTO views(user_id, trek_id) VALUES($user_id, $trek_id)");
      confirmQuery($query);
    }
  }

  $query = "SELECT treks.trek_id,treks.trek_type_id,treks.trek_organizer_id, ";
  $query .= "users.user_firstname,users.user_lastname,users.user_image, users.user_phonenumber, ";
  $query .= "trek_type.trek_type_name,";

  $query .= "treks.trek_name,treks.trek_departure,treks.trek_arrival,treks.trek_about,";
  $query .= "treks.trek_location,treks.trek_duration,treks.trek_image,";
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

      <div class="col-12 col-md-6 mt-sm-3 text-left align-self-start">

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
          <?php echo $trek_type_name; ?>
          <br>


          <span style="font-size: 2rem; font-weight: 400;">Views:</span>
          <?php
            echo viewsCount($trek_id);
          ?>
          <br>

          <form class="text-center" action="" method="post">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="hidden" name="trek_id" value="<?php echo $trek_id; ?>">

            <?php
              $query = mysqli_query($connection, "SELECT * FROM interested WHERE trek_id = $trek_id");

              if (isLoggedout()):
            ?>

            <button type="button" class="btn btn-dark btn-rounded-lg" disabled>
              <?php echo mysqli_num_rows($query); ?>
              Interested
            </button>

            <?php else:
              $user_id = $_SESSION['user_id'];
              $user_interest = mysqli_query($connection, "SELECT * FROM interested where user_id = $user_id AND trek_id = $trek_id");
            ?>
              <input type="submit" name="interested" value="<?php echo mysqli_num_rows($query); ?> Interested"

              <?php
                if (mysqli_num_rows($user_interest) < 0 || mysqli_num_rows($query) >= 0):
                  echo 'class="btn btn-lg btn-primary"';
                endif;
              ?>
              <?php
                if (mysqli_num_rows($user_interest) > 0):
                 echo 'class="btn btn-lg btn-success" disabled';
                endif;
              ?>
              >
            <?php
              endif;
            ?>




          </form>
        </p>

      </div>
    </div>

    <?php include 'includes/comments.php' ?>

  </div>



<?php
}else{
  header("Location: ./index.php");
}

if (isset($_POST['interested'])) {
  $user_id = $_POST['user_id'];
  $trek_id = $_POST['trek_id'];

  $stmt = mysqli_prepare($connection, "INSERT INTO interested(user_id, trek_id) VALUES(?,?)");
  mysqli_stmt_bind_param($stmt, 'ii', $user_id, $trek_id);
  mysqli_stmt_execute($stmt);

  header("Location: ./trek.php?trek_id=$trek_id");
}


include 'includes/footer.php'; ?>
