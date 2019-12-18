<?php
   include 'includes/admin_header.php';
   session_start();
?>
<?php
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin'){

   include 'includes/admin_navigation.php';
   include 'includes/admin_footer.php';

}else{
   header("Location: ../index.php");
}
?>
