<?php include 'includes/header.php'; ?>
<?php session_start(); ?>
<?php include 'includes/functions.php'; ?>
<?php include 'includes/navigation.php'; ?>


<div class="container">
  <div class="d-flex justify-content-center">
    <img src="images/<?php echo $_SESSION['user_image']; ?>" width="50%" height="50%" class="">
  </div>

</div>

<?php include 'includes/footer.php'; ?>
