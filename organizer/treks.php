<?php include 'includes/organizer_header.php'; ?>
<?php session_start(); ?>

<?php include 'includes/organizer_navigation.php'; ?>

<?php

  if (isset($_GET['source'])) {
    $source = $_GET['source'];
  }else{
    $source = '';
  }
  switch ($source) {
    case 'add_treks':
      include 'includes/add_treks.php';
      break;

    default:
      include 'includes/view_treks.php';
      break;
    }

?>


<?php include 'includes/organizer_footer.php'; ?>
