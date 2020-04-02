<div class="modal fade" id="<?php echo $trek_name_trim.$trek_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">

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
            <span class="badge badge-primary badge-pill"><?php trekTypeNameDisplay($trek_type_id); ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            Views
            <span class="badge badge-primary badge-pill"><?php echo viewsCount($trek_id); ?></span>
          </li>
        </ul>

      </div>
      <div class="modal-footer d-flex justify-content-between">
        <?php if (isLoggedOut() || $trek_status == 'Off' || isOrganizer() || isAdmin()):?>
          <button type="button" class="btn btn-success" disabled>Book</button>
        <?php else: ?>
          <a href="booking.php?trek_id=<?php echo $trek_id; ?>" class="btn btn-success">Book</a>
        <?php endif; ?>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
