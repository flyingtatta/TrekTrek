<?php
   include 'includes/organizer_header.php';
   session_start();
?>
<?php
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Organizer'){
  include 'includes/organizer_navigation.php';

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

  include 'includes/organizer_footer.php';

}else{
   header("Location: ../index.php");
}
?>
