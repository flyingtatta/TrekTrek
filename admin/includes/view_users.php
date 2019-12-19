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
    <th class="text-center">Firstname</th>
    <th class="text-center">Lastname</th>
    <th class="text-center">Username</th>
    <th class="text-center">Email</th>
    <th class="text-center">Phone</th>
    <th class="text-center">Image</th>
    <th class="text-center">DOB</th>
    <th class="text-center">Role</th>
  </thead>
  <tbody>
    <?php
    while ($row = mysqli_fetch_assoc($select_users)) {
      $user_id          = $row['user_id'];
      $username         = $row['username'];
      $user_firstname   = $row['user_firstname'];
      $user_lastname    = $row['user_lastname'];
      $user_email       = $row['user_email'];
      $user_phonenumber = $row['user_phonenumber'];
      $user_image       = $row['user_image'];
      $user_dob         = date("d-m-Y",strtotime($row['user_dob']));
      $user_role        = $row['user_role'];
    ?>
      <tr>
        <td class="text-center">
          <a href="users.php?delete=<?php echo $user_id; ?>">
            <i class="fa fa-trash text-danger fa-lg"></i>
          </a>
        </td>
        <td class="text-center"><?php echo $user_id; ?></td>
        <td class="text-center"><?php echo $user_firstname; ?></td>
        <td class="text-center"><?php echo $user_lastname; ?></td>
        <td class="text-center"><?php echo $username; ?></td>
        <td class="text-center"><?php echo $user_email; ?></td>
        <td class="text-center"><?php echo $user_phonenumber; ?></td>
        <td class="text-center"><img src="../images/<?php echo $user_image; ?>" width="200" height="100"></td>
        <td class="text-center"><?php echo $user_dob; ?></td>
        <td class="text-center">
          <a href="./users.php?roler_id=<?php echo $user_id; ?>&role=<?php echo $user_role; ?>">
            <span class="badge badge-pill badge-danger" style="background-color:
              <?php if ($user_role == 'User'): ?>
                <?php echo '#28a745'; ?>
              <?php endif; ?>

              <?php if ($user_role == 'Organizer'): ?>
                <?php echo '#007bff'; ?>
                <?php endif; ?>
              ;">
            <?php echo $user_role; ?>
          </span>
          </a>
        </td>
      </tr>

    <?php
      }
    ?>


  </tbody>
</table>
</div>

<?php
  if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    deleteUser($user_id);
  }

  if (isset($_GET['roler_id'])) {
    $user_id = $_GET['roler_id'];
    $user_role = $_GET['role'];
    changeRole($user_id, $user_role);
  }
?>
