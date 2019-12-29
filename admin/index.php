<?php
include 'includes/admin_header.php';
session_start();

if (isAdmin()){
  
  include 'includes/admin_navigation.php';
  include 'includes/admin_charts.php';
  include 'includes/admin_footer.php';

}else{
  header("Location: ../index.php");
}
?>
