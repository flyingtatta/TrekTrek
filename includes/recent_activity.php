<div class="mt-2">
  <div style="font-weight: 500;" class="lead">
    Recent Activity
  </div>
  <table class="table table-striped mt-1">
    <tbody>
      <?php
      $user_id = $_SESSION['user_id'];
      $recent = "SELECT
      treks.trek_id,trek_name,DATE_FORMAT(treks.created_at,'on %d-%M-%y at %h:%m%p') AS 'created_at',
      trek_status,CONCAt_WS(' ', user_firstname, user_lastname) AS 'user_name'
      FROM treks
      INNER JOIN users ON treks.trek_organizer_id = users.user_id
      INNER JOIN follows ON treks.trek_organizer_id = follows.follower_id
      WHERE follows.followee_id = $user_id ORDER BY treks.created_at";
      $query = mysqli_query($connection, $recent);
      while ($row = mysqli_fetch_assoc($query)) {
        $trek_id   = $row['trek_id'];
        $trek_name = $row['trek_name'];
        $user_name = $row['user_name'];
        $created_at = $row['created_at'];
        $trek_status = $row['trek_status'];
        ?>
        <tr>

          <td>
            <div class="">
              <!-- ORGANIZER NAME -->
              <span style="font-weight: 600;">
                <?php echo $user_name; ?>
              </span>
              added

              <!-- TREK NAME -->
              <?php
              if ($trek_status == 'On') {
                ?>
                <a href="./trek.php?trek_id=<?php echo $trek_id; ?>">
                  <?php
                }
                ?>
                <?php echo $trek_name; ?>
              </a>

              <?php echo $created_at; ?>
            </div>
          </td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
</div>
