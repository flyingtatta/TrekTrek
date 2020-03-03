<?php
include 'includes/organizer_header.php';
session_start();
?>
<?php
if (isOrganizer()){
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

    case 'edit_treks':
      include 'includes/edit_trek.php';
    break;

    case 'trek_info':
      include 'includes/trek_info.php';
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
