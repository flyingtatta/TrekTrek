<div class="row my-5">
  <div class="col-12">

    <h1 class="display-4">Comments</h1>


    <?php if (isLoggedout()): ?>
      <div class="row">
        <div class="col-12">
          <p class="lead m-0 text-danger" style="font-size: 1.3rem;">
            Log in to comment
          </p>
        </div>
      </div>
    <?php else: ?>
      <div class="row">
        <div class="col-12">
          <p class="lead m-0" style="font-size: 2.3rem;">
            <img src="./images/<?php echo $_SESSION['user_image']; ?>" width="60" height="60" style="border-radius:50%;">
            <?php echo $_SESSION['user_firstname'] . ". " . $_SESSION['user_lastname']; ?></p>
          </div>
        </div>
      <?php endif; ?>


      <div class="row mt-3">
        <div class="col-8 col-sm-12 col-md-8">
          <form class="" action="" method="post">
            <textarea name="comment_content" rows="3" cols="50" id="body" class="form-control" placeholder="Your comments..." required></textarea>            
            <input type="submit" name="post_comment" value="Post" class="form-control btn btn-success mt-1">
          </form>
        </div>
      </div>

      <hr>



      <?php
      $query = mysqli_query($connection, "SELECT * FROM comments WHERE trek_id = $trek_id ORDER  BY comment_id DESC");
      confirmQuery($query);

      while($row = mysqli_fetch_assoc($query)){
        $comment_id = $row['comment_id'];
        $commenter_id = $row['user_id'];
        $trek_id      = $row['trek_id'];
        $comment_content = $row['comment_content'];
        $comment_date = date("d-m-Y", strtotime($row['comment_date']));

        $commenter = mysqli_query($connection, "SELECT user_image, user_firstname, user_lastname FROM users WHERE user_id =  $commenter_id");
        confirmQuery($query);

        while($row = mysqli_fetch_assoc($commenter)){
          $user_image = $row['user_image'];
          $user_firstname = $row['user_firstname'];
          $user_lastname = $row['user_lastname']; ?>


          <div class="row">

            <div class="col-12 col-md-8">

              <div class="d-flex justify-content-between">

                <div class="lead" style="font-size: 2.3rem;">
                  <img src="./images/<?php echo $user_image; ?>" width="60" height="60" style="border-radius:50%;">
                  <?php echo $user_firstname . ". " . $user_lastname; ?>
                </div>

                <div class="lead">
                  <span style="font-size: 0.9rem;" class="align-self-right">
                    <?php echo $comment_date; ?>

                    <?php if (!isLoggedout()): ?>
                      <?php if ($_SESSION['user_id'] == $commenter_id): ?>
                        <form class="" action="" method="post" onsubmit="return confirm('Are you sure you want to delete the comment');">
                          <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
                          <input type="submit" name="comment_delete" value="Delete" class="btn btn-danger">
                        </form>
                      <?php endif; ?>
                    <?php endif; ?>

                  </span>
                </div>

              </div>

              <br>

              <p class="lead">
                <?php echo $comment_content; ?>
              </p>

            </div> <!-- Column end -->

          </div> <!-- Row end -->
          <?php
        }
      }
      ?>

    </div>
  </div>

  <?php

  if (isset($_POST['comment_delete'])) {
    $comment_id = $_POST['comment_id'];
    deleteComment($comment_id, $trek_id);
  }

  if (isset($_SESSION['user_role'])) {
    if (isset($_POST['post_comment'])) {
      $user_id = $_SESSION['user_id'];
      $trek_id = $_GET['trek_id'];
      $comment_content = escape($_POST['comment_content']);

      insertIntoComment($user_id, $trek_id, $comment_content);
    }
  }
  ?>
