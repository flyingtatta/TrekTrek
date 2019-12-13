<?php include 'includes/header.php'; ?>
<?php session_start(); ?>
<?php include 'includes/functions.php'; ?>
<?php include 'includes/navigation.php'; ?>

<?php
  $query = "SELECT * FROM treks WHERE trek_status = 'On'";
  $select_all_treks = mysqli_query($connection, $query);

  confirmQuery($select_all_treks);

  while ($row = mysqli_fetch_assoc($select_all_treks)) {
    $trek_id = $row['trek_id'];
    $trek_name = $row['trek_name'];
    $trek_departure = $row['trek_departure'];
    $trek_arrival = $row['trek_arrival'];
    $trek_about = $row['trek_about'];
    $trek_location = $row['trek_location'];
    $trek_duration = $row['trek_duration'];
    $trek_image = $row['trek_image'];
    $trek_type = $row['trek_type'];
    $trek_views = $row['trek_views'];
    $trek_altitude = $row['trek_altitude'];
    $trek_price = $row['trek_price'];
    $trek_status = $row['trek_status'];
    ?>

<main class="container">
    <div class="row">
      <div class="col-12">
        <div class="card" style="width: auto;">
          <img src="organizer/trek-images/<?php echo $trek_image; ?>" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">
              <?php echo $trek_name; ?>
            </h5>
            <ul class="list-group list-group-flush" style="background-color: none;">
              <li class="list-group-item">Price : &#8377;<?php echo $trek_price; ?></li>
              <li class="list-group-item">
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
              <li class="list-group-item">Altitude : <?php echo $trek_altitude; ?>ft</li>
            </ul>
            <br>
            <a data-toggle="modal" class="btn btn-primary" href="<?php echo "#".$trek_name.$trek_id; ?>">
              Know More!
            </a>
          </div>


          <!-- Button trigger modal -->


          <!-- Modal -->
          <div class="modal fade" id="<?php echo $trek_name.$trek_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalCenterTitle"><?php echo $trek_name; ?></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#highlights">Highlights</a>
                    </li>
                  </ul>

                  <br>

                  <p id="about" class="text-justify">
                    <span class="lead text-primary">About</span>
                    <br>
                    <?php echo $trek_about; ?>
                  </p>

                  <p class="text-justify"  id="highlights">
                    <span class="lead text-primary">Highlights</span>
                  </p>

                  <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <span class="badge badge-primary badge-pill"><?php echo $trek_departure; ?></span>
                      <span class="badge badge-primary badge-pill"><i class="fa fa-arrow-circle-right"></i></span>
                      <span class="badge badge-primary badge-pill"><?php echo $trek_arrival; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      Days
                      <span class="badge badge-primary badge-pill"><?php echo $trek_duration; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      Location
                      <span class="badge badge-primary badge-pill"><i class="fa fa-map-marker"></i> <?php echo $trek_location; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      Price
                      <span class="badge badge-primary badge-pill">&#8377;<?php echo $trek_price; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      Altitude
                      <span class="badge badge-primary badge-pill"><?php echo $trek_altitude; ?>ft</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      Type
                      <span class="badge badge-primary badge-pill"><?php echo $trek_type; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      Views
                      <span class="badge badge-primary badge-pill"><?php echo $trek_views; ?></span>
                    </li>

                  </ul>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <br>
  </main>
<?php } ?>

</div>
<?php include 'includes/footer.php'; ?>
