<?php
include 'includes/header.php';
include 'includes/navigation.php';
?>
<div class="mx-3">
  <?php
  $user_id = $_SESSION['user_id'];
  if (isset($_GET['source'])) {
    $following    = mysqli_query($connection, "SELECT * FROM follows INNER JOIN users ON follows.follower_id = users.user_id WHERE followee_id = $user_id");
    $followers    = mysqli_query($connection, "SELECT * FROM follows INNER JOIN users ON follows.followee_id = users.user_id WHERE follower_id = $user_id");
    if ($_GET['source'] === 'followers') {
      while ($row    = mysqli_fetch_assoc($followers)) {
        $followee_id = $row['followee_id'];
        $user_name   = $row['user_firstname']." ".$row['user_lastname'];
        $user_image  = $row['user_image'];
        $username    = $row['username'];
        ?>
        <div class="d-flex justify-content-center w-50 m-auto">
          <div class="d-flex align-self-center">
            <img src="./images/<?php echo $user_image; ?>" alt="" class="mt-1 img-fluid" style="width: 50px; height: 50px; border-radius: 50px;">

            <div class="ml-2">
              <span style="font-size: 1.5rem;">
                <?php echo $user_name; ?>
              </span>
              <a href="./chat.php?sender_id=<?php echo $followee_id; ?>">
                <i class="fa fa-comment text-primary"></i>
              </a>
              <div style="font-weight: 300;">
                <?php echo $username; ?>
              </div>
            </div>
          </div>
            <?php
            $following_check    = mysqli_query($connection, "SELECT * FROM follows INNER JOIN users ON follows.follower_id = users.user_id WHERE followee_id = $user_id AND follower_id = $followee_id");
            if (mysqli_num_rows($following_check) == 0):
            ?>
            <div class="ml-3 align-self-center btn btn-sm btn-primary">
            <a href="./follows.php?source=<?php echo $_GET['source'] ?>&follower_id=<?php echo $followee_id ?>" class="text-light">
              Follow
            </a>
            </div>
            <?php
            else:
            ?>
            <div class="ml-auto align-self-center btn btn-sm btn-success">
              Following
            </div>
            <?php
            endif;
            ?>
        </div>
        <?php
      }
    }else if ($_GET['source'] === 'following') {
      while ($row     = mysqli_fetch_assoc($following)) {
        $follower_id  = $row['follower_id'];
        $user_name    = $row['user_firstname']." ".$row['user_lastname'];
        $user_image   = $row['user_image'];
        $username     = $row['username'];
        ?>
        <div class="d-flex justify-content-center w-50 m-auto">
          <div class="d-flex align-self-center">
            <img src="./images/<?php echo $user_image; ?>" alt="" class="mt-1 img-fluid" style="width: 50px; height: 50px; border-radius: 50px;">

            <div class="ml-2">
              <span style="font-size: 1.5rem;">
                <?php echo $user_name; ?>
              </span>
              <a href="./chat.php?sender_id=<?php echo $follower_id; ?>">                
                <i class="fa fa-comment text-primary"></i>
              </a>
              <div style="font-weight: 300;">
                <?php echo $username; ?>
              </div>
            </div>
          </div>
            <?php
            $following_check    = mysqli_query($connection, "SELECT * FROM follows INNER JOIN users ON follows.follower_id = users.user_id WHERE followee_id = $user_id AND follower_id = $follower_id");
            if (mysqli_num_rows($following_check) == 0):
            ?>
            <div class="ml-auto align-self-center btn btn-sm btn-primary">
            <a href="./follows.php?source=<?php echo $_GET['source'] ?>&follower_id=<?php echo $follower_id ?>" class="text-light">
              Follow
            </a>
            </div>
            <?php
            else:
            ?>
            <div class="ml-auto align-self-center btn btn-sm btn-success">
              Following
            </div>
            <?php
            endif;
            ?>
        </div>
        <?php
      }
    }
  }else{
    header("Location: ./profile.php");
  }
  ?>
</div>
<?php
if (isset($_GET['follower_id'])) {
  $followee_id = $_SESSION['user_id'];
  $follower_id = $_GET['follower_id'];
  $query = mysqli_query($connection, "INSERT INTO follows(followee_id, follower_id) VALUES($followee_id, $follower_id)");
  $source = $_GET['source'];
  header("Location: ./follows.php?source=$source");
}
include 'includes/footer.php';
?>
