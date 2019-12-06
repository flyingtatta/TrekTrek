<?php
  include 'includes/header.php';
  session_start();
?>
<?php include 'includes/functions.php'; ?>
<?php include 'includes/navigation.php'; ?>

<?php
  if (isset($_POST['register'])) {
    $user_firstname   = mysqli_real_escape_string($connection, $_POST['user_firstname']);
    $user_lastname    = mysqli_real_escape_string($connection, $_POST['user_lastname']);
    $username         = mysqli_real_escape_string($connection, $_POST['username']);
    $user_email       = mysqli_real_escape_string($connection, $_POST['user_email']);
    $user_phonenumber = mysqli_real_escape_string($connection, $_POST['user_phonenumber']);
    $user_image       = $_FILES['image']['name'];
    $tmp_user_image   = $_FILES['image']['tmp_name'];
    $user_dob         = mysqli_real_escape_string($connection, $_POST['user_dob']);
    $user_password    = mysqli_real_escape_string($connection, $_POST['user_password']);

    registerUser($user_firstname, $user_lastname, $username, $user_email, $user_phonenumber, $user_image, $tmp_user_image, $user_dob, $user_password);
    loginUser($user_email, $user_password);

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
        <input type="text" name="user_firstname" class="form-control">
      </div>
      <div class="col-12 col-sm-6 form-group">
        <label for="">Lastname</label>
        <input type="text" name="user_lastname" class="form-control">
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-6 form-group">
        <label for="">Username</label>
        <input type="text" name="username" class="form-control">
      </div>
      <div class="col-12 col-sm-6 form-group">
        <label for="">Email</label>
        <input type="text" name="user_email" class="form-control">
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-12 form-group">
        <label for="">Phone Number</label>
        <input type="number" name="user_phonenumber" class="form-control">
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-6 form-group">
        <label for="">Profile Pic</label><br>
        <input type="file" name="image">
      </div>
      <div class="col-12 col-sm-6 form-group">
        <label for="">Date-of-Birth</label>
        <input type="date" name="user_dob" class="form-control">
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-12 form-group">
        <label for="">Password</label>
        <input type="password" name="user_password" class="form-control">
      </div>
    </div>

    <div class="row justify-content-center">
      <input type="submit" name="register" value="Sign Up" class="btn btn-outline-success px-5">
    </div>

  </form>
</div>

<?php include 'includes/footer.php'; ?>
