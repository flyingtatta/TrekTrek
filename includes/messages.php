<?php if (isset($_GET['reciever_id'])): ?>
  <form class="my-3" action="index.html" method="post">
    <div class="row">
      <div class="col-12 col-sm-6">
        <input type="text" name="" value="" class="form-control">
      </div>
      <div class="col-12 col-sm-6">
        <input type="text" name="" value="" class="form-control">
      </div>
    </div>
    <div class="row mt-3">
      <div class="div-group col-12">
        <textarea name="name" rows="3" cols="40" class="form-control"></textarea>
      </div>
    </div>
  </form>
<?php endif; ?>

<table class="table table-hover">
  <tbody>
    <?php
    $user_id = $_SESSION['user_id'];
    $query   = mysqli_query($connection, "SELECT DISTINCT sender_id, CONCAt_WS(' ', user_firstname, user_lastname) AS 'user_name', user_image, message_content FROM messages INNER JOIN users ON messages.sender_id = users.user_id WHERE messages.reciever_id = $user_id ORDER BY messages.created_at DESC LIMIT 1");
    while ($row = mysqli_fetch_assoc($query)) {
      $sender_id = $row['sender_id'];
      $user_name = $row['user_name'];
      $user_image = $row['user_image'];
      $message_content = $row['message_content'];
      ?>
      <tr>
        <td>
          <div class="d-flex align-items-start">
            <img src="./images/<?php echo $user_image; ?>" alt="" class="img-fluid" style="width: 50px; height: 50px; border-radius: 50px;">
            <div class="ml-2">
              <div class="d-flex" style="font-weight: 500;">
                <?php echo $user_name; ?>
                <form class="ml-2" action="chat.php" method="get">
                  <input type="hidden" name="sender_id" value="<?php echo $sender_id; ?>">
                  <button type="submit" class="badge badge-primary" style="border: none;">
                    Reply
                  </button>
                </form>
              </div>

              <div class="">
                <?php echo $message_content; ?>
              </div>
            </div>
          </div>
        </td>
      </tr>
      <?php
    }
    ?>

  </tbody>
</table>
