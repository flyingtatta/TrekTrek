<?php include 'includes/header.php'; ?>
<?php session_start(); ?>
<?php include 'includes/functions.php'; ?>
<?php include 'includes/navigation.php'; ?>

<?php
$query = "SELECT * FROM treks WHERE trek_status = 'On'";
$select_all_treks = mysqli_query($connection, $query);

confirmQuery($select_all_treks);
?>


<?php include 'includes/main.php'; ?>


</div>
<?php include 'includes/footer.php'; ?>
