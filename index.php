<?php include 'includes/header.php'; ?>
<?php session_start(); ?>
<?php include 'includes/functions.php'; ?>
<?php include 'includes/navigation.php'; ?>



<?php include 'includes/main.php'; ?>

<!-- <?php
  if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] == 'Organizer') {
      $trek_username = $_SESSION['username'];
      $trek_user_email = $_SESSION['user_email'];
      $trek_user_phonenumber = $_SESSION['user_phonenumber'];

      $query = mysqli_query($connection,"SELECT * FROM trek_organizer WHERE trek_user_email = '$trek_user_email'");
      $select_organizer = mysqli_execute($query);
      $row = mysqli_fetch_assoc($select_organizer);
      echo $row;
      if ($row >= 1) {

      }else{
        $query = mysqli_query($connection, "INSERT INTO trek_organizer(trek_organizer_name, trek_organizer_email, trek_organizer_phonenumber) VALUES('$trek_username', '$trek_user_email', '$trek_user_phonenumber')");
        mysqli_execute($query);
        confirmQuery($query);
      }
    }
  }
?> -->

<?php include 'includes/footer.php'; ?>
