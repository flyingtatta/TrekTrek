<?php
  if (isset($_POST['update'])) {
    $user_id = $_SESSION['user_id'];
    $user_firstname   = escape($_POST['user_firstname']);
    $user_lastname    = escape($_POST['user_lastname']);
    $username         = escape($_POST['username']);
    $user_email       = escape($_POST['user_email']);
    $user_phonenumber = escape($_POST['user_phonenumber']);
    $user_image       = $_FILES['image']['name'];
    $tmp_user_image   = $_FILES['image']['tmp_name'];
    $user_dob         = escape($_POST['user_dob']);
    $user_password    = escape($_POST['user_password']);

    $error = [
      'user_firstname' => '',
      'user_dob' => '',
      'user_phonenumber' => '',
      'user_password' => ''
    ];

    if (empty($_POST['user_firstname'])) {
      $error['user_firstname'] = 'Firstname cannot be empty';
    }
    if (strlen($_POST['user_firstname']) < 1) {
      $error['user_firstname'] = 'Firstname should be atleast 2 characters';
    }

    if (empty($_POST['user_phonenumber'])) {
      $error['user_phonenumber'] = 'Phone Number cannot be empty';
    }
    if (strlen($_POST['user_phonenumber']) != 10) {
      $error['user_phonenumber'] = 'Phone Number should be 10 characters';
    }


    if (empty($_POST['user_dob'])) {
      $error['user_dob'] = 'DOB cannot be empty';
    }


    foreach ($error as $key => $value) {
      if (empty($value)) {
        unset($error[$key]);
      }
    }

    // foreach ($error as $key => $value) {
    //   echo $error[$key];
    // }

    if (empty($error)) {
      updateUser($user_id, $user_firstname, $user_lastname, $username, $user_email, $user_phonenumber, $user_image, $tmp_user_image, $user_dob, $user_password);
    }


  }
?>

<!-- <div class="container my-4"> -->
  <form class="" action="" method="post" enctype="multipart/form-data">
    <div class="row">
      <div class="col-12 col-sm-6 form-group">
        <label for="">Firstname</label>
        <input type="text" name="user_firstname" class="form-control" value="<?php
          if(isset($_POST['user_firstname'])){
            echo $_POST['user_firstname'];
          }else{
            echo $_SESSION['user_firstname'];
          } ?>">
        </p>
      </div>
      <div class="col-12 col-sm-6 form-group">
        <label for="">Lastname</label>
        <input type="text" name="user_lastname" class="form-control" value="<?php
          if(isset($_POST['user_lastname'])){
            echo $_POST['user_lastname'];
          }else{
            echo $_SESSION['user_lastname'];
          } ?>">
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-6 form-group">
        <label for="">Username</label>
        <input type="text" name="username" class="form-control"
        value="<?php echo $_SESSION['username']; ?>" readonly>
        <p class="text-danger">
          <?php
            if (isset($error['username'])) {
              echo $error['username'];
            }
          ?>
        </p>
      </div>
      <div class="col-12 col-sm-6 form-group">
        <label for="">Email</label>
        <input type="email" name="user_email" class="form-control" value="<?php echo $_SESSION['user_email']; ?>" readonly>
        <p class="text-danger">
          <?php
            if (isset($error['user_email'])) {
              echo $error['user_email'];
            }
          ?>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-12 form-group">
        <label for="">Phone Number</label>
        <input type="text" name="user_phonenumber" class="form-control"
        value="<?php
          if(isset($_POST['register'])){
            echo $_POST['user_phonenumber'];
          }else{
            echo $_SESSION['user_phonenumber'];
          } ?>">
        <p class="text-danger">
          <?php
            if (isset($error['user_phonenumber'])) {
              echo $error['user_phonenumber'];
            }
          ?>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-6 form-group">
        <label for="">Profile Pic</label><br>
        <img src="images/<?php echo $_SESSION['user_image']; ?>" width="100">
        <input type="file" name="image">
      </div>
      <div class="col-12 col-sm-6 form-group">
        <label for="">Date-of-Birth</label>
        <input type="date" name="user_dob" class="form-control"
        value="<?php
        if(isset($_POST['register'])){
          echo $_POST['user_dob'];
        }else{
          echo $_SESSION['user_dob'];
        } ?>">
        <p class="text-danger">
          <?php
            if (isset($error['user_dob'])) {
              echo $error['user_dob'];
            }
          ?>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-12 form-group">
        <label for="">Password</label>
        <input type="password" name="user_password" class="form-control" value="">
      </div>
    </div>

    <div class="row justify-content-center">
      <input type="submit" name="update" value="Submit" class="btn btn-outline-success px-5">
    </div>

  </form>
<!-- </div> -->
