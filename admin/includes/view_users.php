<div class="mx-3">
<h1 class="display-4">
  All Users
</h1>

<?php
  $query = "SELECT * FROM users ORDER BY user_id ASC";
  $select_users = mysqli_query($connection, $query);
  confirmQuery($query);
?>


<table class="table table-bordered">
  <thead>
    <td>Delete</th>
    <th class="text-center">Id</th>
    <th class="text-center">Name</th>
  </thead>
  <tbody>
    <?php
    while ($row = mysqli_fetch_assoc($select_users)) {
      $user_id = $row['user_id'];
      $username = $row['username'];
    ?>
      <tr>
        <td class="text-center">
          <a href="users.php?delete=<?php echo $user_id; ?>">
            <i class="fa fa-trash text-danger fa-lg"></i>
          </a>
        </td>
        <td class="text-center"><?php echo $user_id; ?></td>
        <td class="text-center"><?php echo $username; ?></td>
      </tr>

    <?php
      }
    ?>


  </tbody>
</table>
</div>

<?php
  if (isset($_GET['delete'])) {
    $trek_id = $_GET['delete'];

    $stmt = mysqli_prepare($connection, "DELETE FROM users WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    confirmQuery($stmt);
    header("Location: users.php");
  }

  if (isset($_GET['status'])) {
    $trek_id = $_GET['trek_id'];
    $trek_status = $_GET['status'];
    reverseStatus($trek_id, $trek_status);
    header("Location: users.php");
  }
?>
