<?php
include 'includes/header.php';
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

  $query = "SELECT * ";
  $query .= "FROM treks ";
  $query .= "INNER JOIN users ON treks.trek_organizer_id = users.user_id ";
  $query .= "INNER JOIN trek_type ON treks.trek_type_id = trek_type.trek_type_id ";

  $query .= "WHERE trek_id = $trek_id";

  $select_trek = mysqli_query($connection, $query);
  confirmQuery($select_trek);

  while ($row = mysqli_fetch_assoc($select_trek)) {
    $trek_name         = $row['trek_name'];
    $trek_departure    = date("d-M-y", strtotime($row['trek_departure']));
    $trek_arrival      = date("d-M-y", strtotime($row['trek_arrival']));
    $trek_about        = $row['trek_about'];
    $trek_location     = $row['trek_location'];
    $trek_duration     = $row['trek_duration'];
    $trek_type_id      = $row['trek_type_id'];
    $trek_altitude     = $row['trek_altitude'];
    $trek_price        = $row['trek_price'];
    $trek_status       = $row['trek_status'];
    $trek_organizer_id = $row['trek_organizer_id'];

    $user_id           = $row['user_id'];
    $user_firstname    = $row['user_firstname'];
    $user_lastname     = $row['user_lastname'];
    $user_image        = $row['user_image'];
    $user_phonenumber  = $row['user_phonenumber'];

    $trek_type_name    = $row['trek_type_name'];

    $trek_image        = explode(', ',$row['trek_image']);

  }
  $interested_num = mysqli_query($connection, "SELECT * FROM interested WHERE trek_id = $trek_id");
  $comments_num   = mysqli_query($connection, "SELECT * FROM comments WHERE trek_id = $trek_id");
  ?>

  <div class="mx-3 my-3">

    <ul class="nav nav-pills nav-fill mb-2">
      <li class="nav-item mr-2" style="border: 1px solid #38ef7d; border-radius: 10px;">
        <a class="nav-link">Interested
          <span class="badge badge-primary">
            <?php echo mysqli_num_rows($interested_num); ?>
          </span>
        </a>
      </li>

      <li class="nav-item mx-5" style="border: 1px solid #38ef7d; border-radius: 10px;">
        <a class="nav-link">Views
          <span class="badge badge-primary">
            <?php echo viewsCount($trek_id); ?>
          </span>
        </a>
      </li>
      <li class="nav-item ml-2" style="border: 1px solid #38ef7d; border-radius: 10px;">
        <a class="nav-link">Comments
          <span class="badge badge-primary">
            <?php echo mysqli_num_rows($comments_num); ?>
          </span>
        </a>
      </li>
    </ul>

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

        <img src="organizer/trek-images/<?php echo $trek_image[0]; ?>" class="img-fluid rounded rounded-lg">
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
        <img src="organizer/trek-images/<?php echo $trek_image[1]; ?>" class="img-fluid rounded rounded-lg">
      </div>

      <div class="col-12 col-md-6 mt-sm-3 text-left align-self-start">

        <p class="lead m-0" style="font-size: 1.5rem;">

          <div  class="d-flex justify-content-center">
            <img src="images/<?php echo $user_image; ?>" class="img-fluid rounded rounded-lg" style="height: 45px;">
            <span class="ml-2" style="font-size: 2rem; font-weight: 400;">
              <?php echo $user_firstname . " " . $user_lastname; ?>
            </span>
            <span style="font-size: 2rem; font-weight: 300;">
              :
              <?php echo $user_phonenumber; ?>
            </span>
            <?php if (!isLoggedOut()): ?>
              <?php if ($_SESSION['user_id'] != $user_id): ?>
                <div class="ml-2">
                  <?php
                  $followee_id = $_SESSION['user_id'];
                  $query = mysqli_query($connection, "SELECT * FROM follows WHERE followee_id = $followee_id");
                  while ($row = mysqli_fetch_assoc($query)) {
                    $follower_id = $row['follower_id'];
                    $followee_id = $row['followee_id'];
                  }
                  ?>
                  <a href="./trek.php?trek_id=<?php echo $trek_id; ?>&follow_id=<?php echo $user_id; ?>" class="py-1 badge badge-pill text-light
                    <?php if ($follower_id == $user_id): ?>
                      badge-success">
                      Following
                    <?php else: ?>
                      badge-primary">
                      Follow
                    <?php endif; ?>

                  </a>
                </div>
              <?php endif; ?>
            <?php endif; ?>
          </div>
          <br>

          <div class="" style="font-size: 1.5rem; font-weight: 300;">

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
          </div>

          <br>
          <br>


          <div class="text-center">
            <?php if (isLoggedout() || isOrganizer() || isAdmin()): ?>
              <button type="button" class="btn btn-outline-dark btn-rounded-lg" disabled>
                <?php echo mysqli_num_rows($interested_num); ?>
                Interested
              </button>

            <?php else: ?>

              <form action="" method="post">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <input type="hidden" name="trek_id" value="<?php echo $trek_id; ?>">

                <?php
                $user_id       = $_SESSION['user_id'];
                $user_interest = mysqli_query($connection, "SELECT * FROM interested where user_id = $user_id AND trek_id = $trek_id");
                ?>

                <div class="d-flex justify-content-center">
                  <div class="mr-3" style="font-family: Open Sans;font-size: 1.3rem; font-weight: lighter; color: #19e466">
                    <div class="d-flex align-items-start">
                      <i class="fa fa-thumbs-up">
                        <span style="font-family: Open Sans; font-weight: lighter;">
                          <?php echo mysqli_num_rows($interested_num); ?>
                        </span>
                      </i>
                    </div>
                    <div style="font-family: Open Sans;">
                      <?php if (mysqli_num_rows($interested_num) === 0): ?>
                        <?php echo "No one Interested"; ?>
                      <?php elseif (mysqli_num_rows($interested_num) === 1): ?>
                        <?php echo "Person Interested"; ?>
                      <?php else: ?>
                        <?php echo "People Interested"; ?>
                      <?php endif; ?>
                    </div>
                  </div>

                  <?php if (mysqli_num_rows($user_interest) <= 0): ?>
                    <input type="submit" name="interested" value="Interested?" class="d-block btn btn-lg btn-outline-primary">
                  <?php elseif (mysqli_num_rows($user_interest) > 0): ?>
                    <button class="d-block btn btn-lg btn-outline-success" disabled>You're Interested</button>
                  <?php endif; ?>

                </div>
              </form>
            <?php endif; ?>
          </div>
        </p>

      </div>
    </div>

    <?php include 'includes/comments.php' ?>

  </div>



  <?php
}else{
  header("Location: ./index.php");
}

if (isset($_GET['follow_id'])) {
  $follower_id   = $_GET['follow_id'];
  $followee_id   = $_SESSION['user_id'];

  $query = mysqli_query($connection, "INSERT INTO follows(follower_id, followee_id) VALUES($follower_id, $followee_id)");
  header("Location: ./trek.php?trek_id=$trek_id");
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
