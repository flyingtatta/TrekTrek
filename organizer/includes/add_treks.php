<?php
  if (isset($_POST['submit'])) {
    $trek_name      = escape($_POST['trek_name']);
    $trek_departure = escape($_POST['trek_departure']);
    $trek_arrival   = escape($_POST['trek_arrival']);
    $trek_about     = escape($_POST['trek_about']);
    $trek_location  = escape($_POST['trek_location']);
    $trek_duration  = escape($_POST['trek_duration']);
    $trek_image     = $_FILES['image']['name'];
    $tmp_trek_image = $_FILES['image']['tmp_name'];
    $trek_type      = escape($_POST['trek_type']);
    $trek_altitude  = escape($_POST['trek_altitude']);
    $trek_price     = escape($_POST['trek_price']);
    $trek_status    = 'On';

    $error = [
      'trek_name' => '',
      'trek_departure' => '',
      'trek_arrival' => '',
      'trek_about' => '',
      'trek_location' => '',
      'trek_duration' => '',
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
      $error['trek_about'] = 'Atleast 20 words describing the place';
    }

    if (empty($_POST['trek_location'])) {
      $error['trek_location'] = 'Trek Location cannot be empty';
    }

    if (empty($_POST['trek_duration'])) {
      $error['trek_duration'] = 'Trek duration cannot be empty';
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
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-6 form-group">
        <label for="">Trek departue:</label>
        <input type="date" name="trek_departure" class="form-control"
        value="<?php if(isset($_POST['submit'])){ echo $_POST['trek_departure']; } ?>">
      </div>

      <div class="col-12 col-sm-6 form-group">
        <label for="">Trek arrival:</label>
        <input type="date" name="trek_arrival" class="form-control"
        value="<?php if(isset($_POST['submit'])){ echo $_POST['trek_arrival']; } ?>">
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-12 form-group">
        <label for="">About the Trek:</label>
        <textarea name="trek_about" class="form-control" rows="6" cols="25">
          <?php if(isset($_POST['submit'])){ echo $_POST['trek_about']; } ?>
        </textarea>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-12 form-group">
        <label for="">Trek Location:</label>
        <input type="text" name="trek_location" class="form-control"
        value="<?php if(isset($_POST['submit'])){ echo $_POST['trek_location']; } ?>">
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-6 form-group">
        <label for="">No. of Days:</label>
        <select class="form-control" name="trek_duration">
          <?php if (isset($_POST['submit'])) { ?>
            <option value="<?php echo $_POST['trek_duration']; ?>"><?php echo $_POST['trek_duration']; ?> day<?php if ($i>=2){echo "s";} ?></option>
          <?php } ?>
          <?php for ($i=1; $i <= 7; $i++) { ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?> day<?php if ($i>=2){echo "s";} ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="col-12 col-sm-6 form-group">
        <label for="">Type of Trek:</label>
        <select class="form-control" name="trek_type">
          <?php if (isset($_POST['submit'])) { ?>
            <option value="<?php echo $_POST['trek_type']; ?>"><?php echo $_POST['trek_type']; ?></option>
          <?php } ?>
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
        <input type="number" name="trek_altitude" class="form-control"
        value="<?php if(isset($_POST['submit'])){ echo $_POST['trek_altitude']; } ?>">
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-12 form-group">
        <label for="">Trek Price:</label>
        <input type="number" name="trek_price" class="form-control"
        value="<?php if(isset($_POST['submit'])){ echo $_POST['trek_price']; } ?>">
      </div>
    </div>

    <div class="row justify-content-center">
      <input type="submit" name="submit" value="Add This Trek" class="btn btn-outline-success">
    </div>

  </div>
</form>
