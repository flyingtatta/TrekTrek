<?php include 'includes/header.php'; ?>
<?php session_start(); ?>
<?php include 'includes/functions.php'; ?>
<?php include 'includes/navigation.php'; ?>

<?php if (isset($_SESSION['username'])): ?>
  <div class="mx-3">
    <div class="row">
      <div class="col-12 col-sm-6 col-md-6 text-center align-self-center">
        <div class="d-block d-sm-none">
            <img src="./images/<?php echo $_SESSION['user_image']; ?>" width="150" height="150" style="border-radius:50%;">
            <p></p>
        </div>

        <a href="./edit_user.php?user_id=<?php echo $_SESSION['user_id']; ?>"><i class="fa fa-edit fa-2x"></i></a>
        <h5 class="display-4"><?php echo $_SESSION['user_firstname'] . ". " . $_SESSION['user_lastname']; ?></h5>
      </div>
      <div class="col-6 d-none d-sm-block">
        <img src="./images/<?php echo $_SESSION['user_image']; ?>" style="width: 100%;" class="rounded rounded-lg">
      </div>
    </div>

    <br>

    <div class="row">
      <div class="col-12 col-sm-12 col-md-6 text-center">
        <p style="font-size: 1.5rem;">
          <span class="badge badge-primary badge-pill">
            <i class="fa fa-user"></i>
          </span>
          <span class="badge badge-pill badge-warning">
            <?php echo $_SESSION['username']; ?>
          </span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-12 col-md-6 text-center">
        <p style="font-size: 1.5rem;">
          <span class="badge badge-primary badge-pill">
            <i class="fa fa-envelope"></i>
          </span>
          <span class="badge badge-pill badge-warning">
            <?php echo $_SESSION['user_email']; ?>
          </span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-12 col-md-6 text-center">
        <p style="font-size: 1.5rem;">
          <span class="badge badge-primary badge-pill">
            <i class="fa fa-phone"></i>
          </span>
          <span class="badge badge-pill badge-warning">
            <?php echo $_SESSION['user_phonenumber']; ?>
          </span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-12 col-md-6 text-center">
        <p style="font-size: 1.5rem;" data-toggle="tooltip" data-placement="top" title="dd-mm-yyyy">
          <span class="badge badge-primary badge-pill">
            <i class="fa fa-calendar"></i>
          </span>
          <span class="badge badge-pill badge-warning">
            <?php echo date("d-m-Y", strtotime($_SESSION['user_dob'])); ?>
          </span>
        </p>
      </div>
    </div>


  </div>

<?php else: header("Location: ./index.php"); ?>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>
