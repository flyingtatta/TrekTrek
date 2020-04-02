<?php
include 'includes/header.php';
include 'includes/navigation.php';
?>
<div class="mx-3 d-flex justify-content-center">
  <div class="container mx-5">
    <?php
    $sender_id   =  $_GET['sender_id'];
    $user_id     = $_SESSION['user_id'];
    $select_sender       = mysqli_query($connection, "SELECT user_id,user_phonenumber,CONCAT_WS(' ', user_firstname, user_lastname) AS 'user_name', user_image FROM users WHERE user_id = $sender_id");
    while ($row = mysqli_fetch_assoc($select_sender)) {
      $main_sender_id = $row['user_id'];
      $user_image = $row['user_image'];
      $user_name  = $row['user_name'];
      $user_phonenumber = $row['user_phonenumber'];
      ?>

      <div class="d-flex align-items-center">
        <img src="./images/<?php echo $user_image; ?>" alt="" class="img-fluid" style="width: 80px; height: 80px; border-radius: 50px;">
        <div class="ml-2">
          <div class="d-flex" style="font-weight: 500; font-size: 2.1rem;">
            <?php echo $user_name; ?>
          </div>
          <div class="text-left">
            <?php echo $user_phonenumber; ?>
          </div>
        </div>
      </div>

      <?php
    }
    ?>
    <div class="d-flex justify-content-center">

      <div class="d-flex flex-column mt-3" style="width: 45%;">
        <?php
        $query       = mysqli_query($connection, "SELECT DATE_FORMAT(messages.created_at,'%h:%i%p') AS 'created_at',sender_id, CONCAT_WS(' ', user_firstname, user_lastname) AS 'user_name', user_image, message_content FROM messages INNER JOIN users ON messages.sender_id = users.user_id WHERE messages.reciever_id = $user_id AND sender_id = $sender_id OR sender_id = $user_id OR reciever_id = $sender_id ORDER BY messages.created_at ASC");
        while ($row = mysqli_fetch_assoc($query)) {
          $sender_id  = $row['sender_id'];
          $user_image = $row['user_image'];
          $user_name  = $row['user_name'];
          $message_content = $row['message_content'];
          $message_time = $row['created_at']
          ?>
          <div class="d-flex mx-1">
            <span style="font-weight: 600;" class="py-1 mt-2 badge <?php if ($sender_id == $user_id): ?>
              badge-success
              ml-auto
            <?php else: ?>
              badge-primary
            <?php endif; ?> badge-pill">
            <span style="font-size: 0.9rem;">
              <?php echo $message_content; ?>
            </span>
            <span style="font-size: 0.6rem;">
              <?php echo $message_time; ?>
            </span>
          </span>
        </div>
        <?php
      }
      ?>

      <form class="d-flex mt-2" method="post">
        <textarea name="message_content" rows="1" class="form-control" required></textarea>
        <input type="hidden" name="sender_id" value="<?php echo $_SESSION['user_id']; ?>">
        <input type="hidden" name="reciever_id" value="<?php echo $main_sender_id; ?>">
        <input type="submit" name="reply" value="Reply" class="btn btn-md btn-primary">
      </form>
    </div>
  </div>
</div>
</div>
<?php
if (isset($_POST['reply'])) {
  $message_content = $_POST['message_content'];
  $reciever_id     = $_POST['reciever_id'];
  $sender_id       = $_POST['sender_id'];

  $query = mysqli_query($connection, "INSERT INTO messages(sender_id, reciever_id, message_content) VALUES($sender_id, $reciever_id, '{$message_content}')");
  header("Location: ./chat.php?sender_id=$main_sender_id");
}
include 'includes/footer.php';
?>
