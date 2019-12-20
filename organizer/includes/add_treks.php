<?php
if (isset($_POST['submit'])) {
  $trek_name        = escape($_POST['trek_name']);
  $trek_departure   = escape($_POST['trek_departure']);
  $trek_arrival     = escape($_POST['trek_arrival']);
  $trek_about       = $_POST['trek_about'];
  $trek_location    = escape($_POST['trek_location']);

  $dateDiff = strtotime($trek_departure) - strtotime($trek_arrival);
  $trek_duration    =  abs(round($dateDiff/86400));


  $trek_image       = $_FILES['image']['name'];
  $tmp_trek_image   = $_FILES['image']['tmp_name'];
  $trek_type        = escape($_POST['trek_type']);
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

  if (empty($_POST['trek_departure'])) {
    $error['trek_departure'] = 'Cannot be empty';
  }
  if (empty($_POST['trek_arrival'])) {
    $error['trek_arrival'] = 'Cannot be empty';
  }

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
    registerTrek($trek_name,$trek_departure,$trek_arrival,$trek_about,$trek_location,$trek_duration,$trek_image,$tmp_trek_image,$trek_type,$trek_altitude,$trek_price,$trek_status);
  }


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
        <input type="text" name="trek_name" class="form-control"
        value="<?php if(isset($_POST['submit'])){ echo $_POST['trek_name']; } ?>">
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
        value="<?php if(isset($_POST['submit'])){ echo $_POST['trek_departure']; } ?>">
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
        value="<?php if(isset($_POST['submit'])){ echo $_POST['trek_arrival']; } ?>">
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
        <textarea name="trek_about" class="form-control" rows="6" cols="25" id="body"><?php if(isset($_POST['submit'])){ echo $_POST['trek_about']; } ?></textarea>
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
        value="<?php if(isset($_POST['submit'])){ echo $_POST['trek_location']; } ?>">
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
        <select class="form-control" name="trek_type">
          <?php if (isset($_POST['submit'])) { ?>
            <option value="<?php echo $_POST['trek_type']; ?>"><?php echo $_POST['trek_type']; ?></option>
          <?php } ?>
          <option value="Long Day">Long Day Trek</option>
          <option value="Short Day">Short Day Trek</option>
          <option value="Camping">Camping Trek</option>
        </select>
      </div>

      <div class="col-12 col-sm-6 form-group">
        <label for="">Image:</label> <br>
        <input type="file" name="image">
      </div>

    </div>

    <div class="row">

      <div class="col-12 col-sm-6 form-group">
        <label for="">Altitude (in Ft):</label>
        <div class="input-group">
          <input type="number" name="trek_altitude" class="form-control" value="<?php if(isset($_POST['submit'])){ echo $_POST['trek_altitude']; } ?>">
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
          value="<?php if(isset($_POST['submit'])){ echo $_POST['trek_price']; } ?>">
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
