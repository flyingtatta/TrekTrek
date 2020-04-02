
<?php
if (!isset($_SESSION['user_role'])) {
  $query = $query = selectTreksWithStatusOn();
}else {
  if ($_SESSION['user_role'] == 'Organizer') {
    $query = selectTreksForOrganizer();
  }elseif ($_SESSION['user_role'] == 'User') {
    $query = selectTreksWithStatusOn();
  }elseif ($_SESSION['user_role'] == 'Admin') {
    $query = selectTreksForSoop();
  }
}

if (isset($_GET['type'])) {
  $query = selectTrekOfType($_GET['type'], 'On');
}else if (isset($_POST['search'])) {
  $query = searchTrek($_POST['search_tags']);
}

?>

<main class="mx-3">
  <!-- <div class="card-columns"> -->
  <div class="row">
    <?php
    while ($row = mysqli_fetch_assoc($query)) {
      $trek_id        = $row['trek_id'];
      $trek_name      = $row['trek_name'];
      $trek_departure = date("d-M-y", strtotime($row['trek_departure']));
      $trek_arrival   = date("d-M-y", strtotime($row['trek_arrival']));
      $trek_about     = $row['trek_about'];
      $trek_location  = $row['trek_location'];
      $trek_duration  = $row['trek_duration'];
      $trek_type_id   = $row['trek_type_id'];
      $trek_altitude  = $row['trek_altitude'];
      $trek_price     = $row['trek_price'];
      $trek_status    = $row['trek_status'];

      $trek_image     = explode(', ',$row['trek_image']);
      ?>

      <div class="col-12 col-md-4">
        <div class="card card-border">
          <div id="carouselFor<?php echo $trek_id; ?>" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <?php
                $i = 0;
                while ($i < sizeof($trek_image)) {
              ?>
                <li data-target="#carouselFor<?php echo $trek_id; ?>" data-slide-to="<?php echo $i ?>" <?php if ($i === 0): ?>class="active"<?php endif; ?>></li>
              <?php
                $i++;
                }
              ?>
            </ol>
            <div class="carousel-inner">
              <?php
                $i = 0;
                while ($i < sizeof($trek_image)) {
              ?>

                <div class="carousel-item <?php if ($i === 0): echo "active"; endif; ?>">
                  <img src="organizer/trek-images/<?php echo $trek_image[$i]; ?>" class="d-block w-100" alt="...">
                </div>
              <?php
                $i++;
                }
              ?>
                <div class="carousel-item">
                  <img src="organizer/trek-images/5.jpg" class="d-block w-100" alt="...">
                </div>

            </div>
            <a class="carousel-control-prev" href="#carouselFor<?php echo $trek_id; ?>" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselFor<?php echo $trek_id; ?>" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
          <!-- <img src="organizer/trek-images/<?php //echo $trek_image[0]; ?>" class="card-img-top"> -->

          <div class="card-body card-border">
            <h5 class="card-title d-flex justify-content-between">
              <?php echo $trek_name; ?>

              <div class="small" style="font-weight: lighter;">
                <i class="fa fa-eye"></i>
                <?php echo viewsCount($trek_id); ?>

                <?php if (isAdmin() || isOrganizer()): ?>
                  <span class="badge badge-primary badge-pill" style="
                  <?php if ($trek_status == 'Off'): ?>
                  background-color: #dc3545;
                  <?php else: ?>
                  background-color: #28a745;
                  <?php endif; ?>
                  font-weight: 400;">
                  <?php echo $trek_status; ?>
                </span>
              <?php endif; ?>
            </div>

          </h5>
          <ul class="list-group list-group-flush" style="background-color: none;">
            <li class="list-group-item list-gradient" style="text-decoration: none;">Price : &#8377;<?php echo $trek_price; ?></li>
            <li class="list-group-item list-gradient" style="text-decoration: none;">
              Days  :
              <?php
              echo $trek_duration;
              if ($trek_duration != 1) {
                echo " " . "days";
              }else{
                echo " " . "day";
              }
              ?>
            </li>
            <li class="list-group-item list-gradient" style="text-decoration: none;">Altitude : <?php echo $trek_altitude; ?></li>
          </ul>
          <br>

          <?php
          $trek_name_trim = str_replace(" ", "$trek_id", $trek_name);
          ?>
          <div class="d-flex justify-content-between">
            <a href="<?php echo "#".$trek_name_trim.$trek_id; ?>" data-toggle="modal" class="btn btn-sm btn-primary" style="border-radius: 20px;">
              Quick Details!
            </a>

            <a href="./trek.php?trek_id=<?php echo $trek_id; ?>" class="btn btn-sm btn-primary" style="border-radius: 20px;">
              Full Details
            </a>
          </div>
        </div>

        <!-- Modal -->
        <?php include 'includes/main_modal.php'; ?>


      </div>
      <br>
    </div>
  <?php } ?>
</div>
</main>
