<?php
  include 'includes/header.php';
  include 'includes/navigation.php';

  if (isset($_POST['register'])) {
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
      'username' => '',
      'user_email' => '',
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

    if (empty($_POST['username'])) {
      $error['username'] = 'Username cannot be empty';
    }
    if (strlen($_POST['username']) < 4) {
      $error['username'] = 'Username should be atleast 4 characters';
    }
    if (usernameExists($_POST['username'])) {
      $error['username'] = 'Username exists choose another';
    }

    if (empty($_POST['user_phonenumber'])) {
      $error['user_phonenumber'] = 'Phone Number cannot be empty';
    }
    if (strlen($_POST['user_phonenumber']) != 10) {
      $error['user_phonenumber'] = 'Phone Number should be 10 characters';
    }

    if (empty($_POST['user_email'])) {
      $error['user_email'] = 'Email cannot be empty';
    }
    if (emailExists($_POST['user_email'])) {
      $error['user_email'] = 'Email exists choose another';
    }

    if (empty($_POST['user_dob'])) {
      $error['user_dob'] = 'DOB cannot be empty';
    }

    if (empty($_POST['user_password'])) {
      $error['user_password'] = 'Password cannot be empty';
    }

    foreach ($error as $key => $value) {
      if (empty($value)) {
        unset($error[$key]);
      }
    }

    if (empty($error)) {
      registerUser($user_firstname, $user_lastname, $username, $user_email, $user_phonenumber, $user_image, $tmp_user_image, $user_dob, $user_password);
      loginUser($user_email, $user_password);
    }


  }
?>

<h1 class="display-4 text-center mt-3">
  Sign Up
</h1>

<div class="container my-4">
  <form class="" action="" method="post" enctype="multipart/form-data">

    <div class="row">
      <div class="col-12 col-sm-6 form-group">
        <label for="">Firstname</label>
        <input type="text" name="user_firstname" class="form-control"
        value="<?php if(isset($_POST['register'])){ echo $user_firstname; } ?>">
        <p class="text-danger">
          <?php
            if (isset($error['user_firstname'])) {
              echo $error['user_firstname'];
            }
          ?>
        </p>
      </div>
      <div class="col-12 col-sm-6 form-group">
        <label for="">Lastname</label>
        <input type="text" name="user_lastname" class="form-control"
        value="<?php if(isset($_POST['register'])){ echo $user_lastname; } ?>">
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-6 form-group">
        <label for="">Username</label>
        <input type="text" name="username" class="form-control"
        value="<?php if(isset($_POST['register'])){ echo $username; } ?>">
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
        <input type="email" name="user_email" class="form-control"
        value="<?php if(isset($_POST['register'])){ echo $user_email; } ?>">
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
      <div class="col-12 col-md-4 form-group">
        <label for="">Phone Number</label>
        <input type="number" name="user_phonenumber" class="form-control"
        value="<?php if(isset($_POST['register'])){ echo $user_phonenumber; } ?>">
        <p class="text-danger">
          <?php
            if (isset($error['user_phonenumber'])) {
              echo $error['user_phonenumber'];
            }
          ?>
        </p>
      </div>

      <div class="col-12 col-md-4 form-group">
        <label for="">Profile Pic</label><br>
        <input type="file" name="image">
      </div>


      <div class="col-12 col-md-4 form-group">
        <label for="">Date-of-Birth</label>
        <input type="date" name="user_dob" class="form-control"
        value="<?php if(isset($_POST['register'])){ echo $user_dob; } ?>">
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

    </div>

    <div class="row">
      <div class="col-12 col-sm-12 form-group">
        <label for="">Password</label>
        <input type="password" name="user_password" class="form-control">
        <p class="text-danger">
          <?php
            if (isset($error['user_password'])) {
              echo $error['user_password'];
            }
          ?>
        </p>
      </div>
    </div>

    <div class="row justify-content-center">
      <input type="submit" name="register" value="Sign Up" class="btn btn-outline-success px-5">
    </div>

  </form>
</div>

<?php include 'includes/footer.php'; ?>
