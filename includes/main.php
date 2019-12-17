
<main class="mx-3">
  <div class="row">
    <?php
    while ($row = mysqli_fetch_assoc($select_all_treks)) {
      $trek_id        = $row['trek_id'];
      $trek_name      = $row['trek_name'];
      $trek_departure = date("d-m-Y", strtotime($row['trek_departure']));
      $trek_arrival   = date("d-m-Y", strtotime($row['trek_arrival']));
      $trek_about     = $row['trek_about'];
      $trek_location  = $row['trek_location'];
      $trek_duration  = $row['trek_duration'];
      $trek_image     = $row['trek_image'];
      $trek_type      = $row['trek_type'];
      $trek_views     = $row['trek_views'];
      $trek_altitude  = $row['trek_altitude'];
      $trek_price     = $row['trek_price'];
      $trek_status    = $row['trek_status'];
      ?>
      <div class="col-12 col-md-4">
        <div class="card" style="width: auto;">
          <img src="organizer/trek-images/<?php echo $trek_image; ?>" class="card-img-top" style="height: 290px;">
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
              <li class="list-group-item">Altitude : <?php echo $trek_altitude; ?></li>
            </ul>
            <br>

            <!-- <a data-toggle="modal" href="<?php echo "#".$trek_name.$trek_id; ?>" class="btn btn-primary">
              Know More!
            </a> -->

            <div class="d-flex justify-content-between">
              <a href="<?php echo "#".$trek_name.$trek_id; ?>" data-toggle="modal" class="btn btn-primary">
                Quick Details!
              </a>

              <a href="./trek.php?trek_id=<?php echo $trek_id; ?>" class="btn btn-primary">
                Full Details
              </a>
            </div>

          </div>


          <!-- Button trigger modal -->
          <!-- <?php
          // if (isset($_POST['knowmore'])) {
          //   $query = "UPDATE treks SET trek_views = trek_views+1 WHERE trek_id = $trek_id";
          //   $views_query = mysqli_query($connection, $query);
          //   confirmQuery($views_query);
          // }
          ?> -->

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
                      <a class="nav-link active" href="<?php echo "#".$trek_name.$trek_id.'about'; ?>">About</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="<?php echo "#".$trek_name.$trek_id.'highlights'; ?>">Highlights</a>
                    </li>
                  </ul>

                  <br>

                  <p id="<?php echo $trek_name.$trek_id.'about'; ?>" class="text-justify">
                    <span class="lead text-primary">About</span>
                    <br>
                    <?php echo $trek_about; ?>
                  </p>

                  <p class="text-justify"  id="<?php echo $trek_name.$trek_id.'highlights'; ?>">
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
                      <span class="badge badge-primary badge-pill"><?php echo $trek_altitude; ?></span>
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
        <br>
      </div>
    <?php } ?>
  </div>
</main>