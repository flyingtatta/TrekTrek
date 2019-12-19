<?php
   include 'includes/admin_header.php';
   session_start();
?>
<?php
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin'){
  include 'includes/admin_navigation.php';

  if (isset($_GET['source'])) {
    $source = $_GET['source'];
  }else{
    $source = '';
  }
  switch ($source) {
    case 'add_users':
      include 'includes/add_users.php';
      break;

    default:
      include 'includes/view_users.php';
      break;
    }

  include 'includes/admin_footer.php';

}else{
   header("Location: ../index.php");
}
?>
