<?php
   include 'includes/organizer_header.php';
   session_start();
?>
<?php
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Organizer'){

   include 'includes/organizer_navigation.php';
   include 'includes/organizer_footer.php';

}else{
   header("Location: ../index.php");
}
?>
