<?php
if (isset($_GET['trek_id'])) {
  $trek_id = $_GET['trek_id'];
  if (isset($_POST['submit'])) {
    $trek_name        = escape($_POST['trek_name']);
    $trek_departure   = escape($_POST['trek_departure']);
    $trek_arrival     = escape($_POST['trek_arrival']);
    $trek_about       = escape($_POST['trek_about']);
    $trek_location    = escape($_POST['trek_location']);

    $dateDiff = strtotime($trek_departure) - strtotime($trek_arrival);
    $trek_duration    =  abs(round($dateDiff/86400));


    $trek_image       = $_FILES['image']['name'];
    $tmp_trek_image   = $_FILES['image']['tmp_name'];
    $trek_type_id     = escape($_POST['trek_type_id']);
    $type_of_altitude = escape($_POST['type-of-altitude']);
    $trek_altitude    = escape($_POST['trek_altitude']);
    $trek_altitude    = $trek_altitude . $type_of_altitude;
    $trek_price       = escape($_POST['trek_price']);
    $trek_status      = 'On';

    $error = [
      'trek_name' => '',
      'trek_departure' => '',
      'trek_arrival' => '',
      'trek_about' => '',
      'trek_location' => '',
      'trek_altitude' => '',
      'trek_price' => ''
    ];

    if (empty($_POST['trek_name'])) {
      $error['trek_name'] = 'Trek Name cannot be empty';
    }

    // DATE VALIDATION
    if (empty($_POST['trek_departure'])) {
      $error['trek_departure'] = 'Cannot be empty';
    }
    if (empty($_POST['trek_arrival'])) {
      $error['trek_arrival'] = 'Cannot be empty';
    }

    if ($_POST['trek_departure'] < date('Y-m-d')) {
       $error['trek_departure'] = "We can't time travel";
    }

    if ($_POST['trek_departure'] > $_POST['trek_arrival']) {
      $error['trek_arrival'] = "Arrival cannot be before departure";
    }
    // DATE VALIDATION END

    if (empty($_POST['trek_about'])) {
      $error['trek_about'] = 'Cannot be empty';
    }
    if (strlen($_POST['trek_about']) < 100) {
      $error['trek_about'] = 'Atleast 30-35 words describing the place';
    }

    if (empty($_POST['trek_location'])) {
      $error['trek_location'] = 'Trek Location cannot be empty';
    }

    if ($_POST['trek_altitude'] < 0) {
      $error['trek_altitude'] = 'Altitude cannot be in minus';
    }

    if (empty($_POST['trek_price'])) {
      $error['trek_price'] = 'Trek Price cannot be empty';
    }

    if ($_POST['trek_price'] < 0) {
      $error['trek_price'] = 'Enter a valid price';
    }

    foreach ($error as $key => $value) {
      if (empty($value)) {
        unset($error[$key]);
      }
    }

    if (empty($error)) {
      updateTrek($trek_id,$trek_name,$trek_departure,$trek_arrival,$trek_about,$trek_location,$trek_duration,$trek_image,$tmp_trek_image,$trek_type_id,$trek_altitude,$trek_price,$trek_status);
    }
  }
  ?>
  <h1 class="display-4 text-center">
    Edit Trek : <?php echo $trek_id; ?>(id)
  </h1>

  <form class="" action="" method="post" enctype="multipart/form-data">
    <?php
    $query = "SELECT treks.trek_id,treks.trek_type_id,treks.trek_organizer_id, ";
    $query .= "trek_type.trek_type_name,";
    $query .= "treks.trek_name,treks.trek_departure,treks.trek_arrival,treks.trek_about,";
    $query .= "treks.trek_location,treks.trek_duration,treks.trek_image,treks.trek_views,";
    $query .= "treks.trek_altitude,treks.trek_price,treks.trek_status ";
    $query .= "FROM treks ";
    $query .= "INNER JOIN trek_type ON treks.trek_type_id = trek_type.trek_type_id ";
    $query .= "WHERE trek_id = $trek_id";

    $select_trek = mysqli_query($connection, $query);
    confirmQuery($select_trek);
    while($row = mysqli_fetch_assoc($select_trek)){
      $trek_name      = $row['trek_name'];
      $trek_departure = $row['trek_departure'];
      $trek_arrival   = $row['trek_arrival'];
      $trek_about     = $row['trek_about'];
      $trek_location  = $row['trek_location'];
      $trek_duration  = $row['trek_duration'];
      $trek_image     = $row['trek_image'];
      $trek_type_id   = $row['trek_type_id'];
      $trek_type_name = $row['trek_type_name'];
      $trek_altitude  = $row['trek_altitude'];
      $trek_altitude  = str_replace("ft", "", $trek_altitude);
      $trek_altitude  = str_replace("m", "", $trek_altitude);
      $trek_price     = $row['trek_price'];
      $trek_status    = $row['trek_status'];
      $trek_views     = $row['trek_views'];
    }
    ?>
    <div class="container mb-4">
      <div class="row">

        <div class="col-12 col-sm-12 form-group">
          <label for="">Trek Name(Place name):</label>
          <input type="text" name="trek_name" class="form-control"
          value="<?php
          if(isset($_POST['submit'])){
            echo $_POST['trek_name'];
          }else{
            echo $trek_name;
          }
          ?>">
          <p class="text-danger">
            <?php
            if (isset($error['trek_name'])) {
              echo $error['trek_name'];
            }
            ?>
          </p>
        </div>
      </div>

      <div class="row">
        <div class="col-12 col-sm-6 form-group">
          <label for="">Trek Departure:</label>
          <input type="date" name="trek_departure" class="form-control"
          value="<?php
          if(isset($_POST['submit'])){
            echo $_POST['trek_departure'];
          }elseif($trek_departure <= date('Y-m-d')){
            echo date('Y-m-d');
          }
          else{
            echo $trek_departure;
          } ?>">
          <p class="text-danger">
            <?php
            if (isset($error['trek_departure'])) {
              echo $error['trek_departure'];
            }
            ?>
          </p>
        </div>

        <div class="col-12 col-sm-6 form-group">
          <label for="">Trek Arrival:</label>
          <input type="date" name="trek_arrival" class="form-control"
          value="<?php
          if(isset($_POST['submit'])){
            echo $_POST['trek_arrival'];
          }elseif($trek_departure <= date('Y-m-d')) {
            echo date('Y-m-d');
          }
          else{
            echo $trek_arrival;
          } ?>">
          <p class="text-danger">
            <?php
            if (isset($error['trek_arrival'])) {
              echo $error['trek_arrival'];
            }
            ?>
          </p>
        </div>
      </div>

      <div class="row">
        <div class="col-12 col-sm-12 form-group">
          <label for="">About the Trek:</label>
          <textarea name="trek_about" class="form-control" rows="6" cols="25" id="body"><?php
          if(isset($_POST['submit'])){
            echo $_POST['trek_about'];
          }else{
            echo $trek_about;
          }?>
        </textarea>
        <p class="text-danger">
          <?php
          if (isset($error['trek_about'])) {
            echo $error['trek_about'];
          }
          ?>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-12 form-group">
        <label for="">Trek Location:</label>
        <input type="text" name="trek_location" class="form-control"
        value="<?php
        if(isset($_POST['submit'])){
          echo $_POST['trek_location'];
        }else{
          echo $trek_location;
        } ?>">
        <p class="text-danger">
          <?php
          if (isset($error['trek_location'])) {
            echo $error['trek_location'];
          }
          ?>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-6 form-group">
        <label for="">Type of Trek:</label>
        <select class="form-control" name="trek_type_id">

          <option value="<?php echo $trek_type_id; ?>" selected><?php echo $trek_type_name; ?></option>

          <?php
            $query = mysqli_query($connection, "SELECT * FROM trek_type WHERE trek_type_id != $trek_type_id");
            confirmQuery($query);
            while ($row = mysqli_fetch_assoc($query)) {
              $trek_type_id   = $row['trek_type_id'];
              $trek_type_name = $row['trek_type_name'];
          ?>
            <option value="<?php echo $trek_type_id; ?>"><?php echo $trek_type_name; ?></option>
          <?php
            }
            ?>

        </select>
      </div>

      <div class="col-12 col-sm-6 form-group">
        <label for="">Image:</label> <br>
        <input type="file" name="image" value="<?php echo $trek_image; ?>">
      </div>

    </div>

    <div class="row">

      <div class="col-12 col-sm-6 form-group">
        <label for="">Altitude:</label>
        <div class="input-group">
          <input type="number" name="trek_altitude" class="form-control" value="<?php
          if(isset($_POST['submit'])){
            echo $_POST['trek_altitude'];
          }else{
            echo $trek_altitude;
          } ?>">
          <div class="input-group-append">
            <select class="form-control" name="type-of-altitude">
              <option value="ft">ft</option>
              <option value="m">m</option>
            </select>
          </div>
        </div>

        <p class="text-danger">
          <?php
          if (isset($error['trek_altitude'])) {
            echo $error['trek_altitude'];
          }
          ?>
        </p>
      </div>

      <div class="col-12 col-sm-6 form-group">
        <label for="">Trek Price:</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">&#8377;</span>
          </div>
          <input type="number" name="trek_price" class="form-control"
          value="<?php
          if(isset($_POST['submit'])){
            echo $_POST['trek_price'];
          }else {
            echo $trek_price;
          } ?>">
        </div>
        <p class="text-danger">
          <?php
          if (isset($error['trek_price'])) {
            echo $error['trek_price'];
          }
          ?>
        </p>
      </div>
    </div>

    <div class="row justify-content-center">
      <input type="submit" name="submit" value="Add This Trek" class="btn btn-outline-success">
    </div>

  </div>
</form>
<?php
}else{
  header("Location: ./treks.php");
} ?>
