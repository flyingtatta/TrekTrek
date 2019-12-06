<?php
  if (isset($_POST['submit'])) {
    $trek_name      = $_POST['trek_name'];
    $trek_departure = $_POST['trek_departure'];
    $trek_arrival   = $_POST['trek_arrival'];
    $trek_about     = $_POST['trek_about'];
    $trek_location  = $_POST['trek_location'];
    $trek_duration  = $_POST['trek_duration'];
    $trek_image     = $_FILES['image']['name'];
    $tmp_trek_image = $_FILES['image']['tmp_name'];
    $trek_type      = $_POST['trek_type'];
    $trek_altitude  = $_POST['trek_altitude'];
    $trek_price     = $_POST['trek_price'];
    $trek_status    = 'On';

    move_uploaded_file($tmp_trek_image, "trek-images/$trek_image");
    $stmt = mysqli_prepare($connection, "INSERT INTO treks(trek_name,trek_departure,trek_arrival,trek_about,trek_location,trek_duration,trek_image,trek_type,trek_altitude,trek_price,trek_status) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt, "sssssssssss", $trek_name,$trek_departure,$trek_arrival,$trek_about,$trek_location,$trek_duration,$trek_image,$trek_type,$trek_altitude,$trek_price,$trek_status);
    mysqli_stmt_execute($stmt);
    confirmQuery($stmt);
  }
?>
<h1 class="display-4 text-center">
  Add Trek
</h1>

<form class="" action="" method="post" enctype="multipart/form-data">
  <div class="container mb-4">
    <div class="row">
      <div class="col-12 col-sm-12 form-group">
        <label for="">Trek Name(Place name):</label>
        <input type="text" name="trek_name" class="form-control">
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-6 form-group">
        <label for="">Trek departue:</label>
        <input type="date" name="trek_departure" class="form-control">
      </div>

      <div class="col-12 col-sm-6 form-group">
        <label for="">Trek arrival:</label>
        <input type="date" name="trek_arrival" class="form-control">
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-12 form-group">
        <label for="">About the Trek:</label>
        <textarea name="trek_about" class="form-control" rows="6" cols="25"></textarea>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-12 form-group">
        <label for="">Trek Location:</label>
        <input type="text" name="trek_location" class="form-control">
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-6 form-group">
        <label for="">No. of Days:</label>
        <select class="form-control" name="trek_duration">
          <?php for ($i=1; $i <= 7; $i++) { ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?> day<?php if ($i>=2){echo "s";} ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="col-12 col-sm-6 form-group">
        <label for="">Type of Trek:</label>
        <select class="form-control" name="trek_type">
          <option value="longDay">Long Day Trek</option>
          <option value="shortDay">Short Day Trek</option>
          <option value="camping">Camping Trek</option>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-6 form-group">
        <label for="">Image:</label> <br>
        <input type="file" name="image">
      </div>

      <div class="col-12 col-sm-6 form-group">
        <label for="">Altitude:</label>
        <input type="number" name="trek_altitude" class="form-control">
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-12 form-group">
        <label for="">Trek Price:</label>
        <input type="number" name="trek_price" class="form-control">
      </div>
    </div>

    <div class="row justify-content-center">
      <input type="submit" name="submit" value="Add This Trek" class="btn btn-outline-success">
    </div>

  </div>
</form>
