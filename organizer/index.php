<?php
include 'includes/organizer_header.php';
session_start();

if (isOrganizer()){
  
  include 'includes/organizer_navigation.php';
  include 'includes/organizer_charts.php';
  include 'includes/organizer_footer.php';

}else{
  header("Location: ../index.php");
}
?>
