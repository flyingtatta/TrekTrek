<div class="mx-3">
<h1 class="display-4">
  All Users
</h1>

<?php
if (!isset($_POST['search'])) {
  $query = "SELECT * FROM users ORDER BY user_id ASC";
  $select_users = mysqli_query($connection, $query);
  confirmQuery($query);
}else if(isset($_POST['search'])){
  $search_user = $_POST['search_tags'];
  $query = "SELECT * FROM users WHERE user_role LIKE '%$search_user%' OR username LIKE '%$search_user%' OR user_firstname LIKE '%$search_user%' OR user_lastname LIKE '%$search_user%' OR user_email LIKE '%$search_user%' ORDER BY user_id ASC";
  $select_users = mysqli_query($connection, $query);
  confirmQuery($query);
}

?>


<table class="table table-bordered">
  <thead>
    <td class="text-center" style="font-weight: 700;">Delete</th>
    <th class="text-center" style="font-weight: 700;">Id</th>
    <th class="text-center" style="font-weight: 700;">Firstname</th>
    <th class="text-center" style="font-weight: 700;">Lastname</th>
    <th class="text-center" style="font-weight: 700;">Username</th>
    <th class="text-center" style="font-weight: 700;">Email</th>
    <th class="text-center" style="font-weight: 700;">Phone</th>
    <th class="text-center" style="font-weight: 700;">Image</th>
    <th class="text-center" style="font-weight: 700;">DOB</th>
    <th class="text-center" style="font-weight: 700;">Role</th>
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
          <form class="" action="" method="post" onsubmit="return confirm('Are you sure you want to delete?');">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="submit" name="delete" value="Delete" class="btn btn-danger">
          </form>
          <!-- <a href="users.php?delete=<?php //echo $user_id; ?>">
            <i class="fa fa-trash text-danger fa-lg"></i>
          </a> -->
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
          <form class="" action="" method="post" onsubmit="return confirm('Are you sure you want to change?');">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="user_role" value="<?php echo $user_role; ?>">
            <span class="badge badge-pill badge-danger" style="background-color:
              <?php if ($user_role == 'User'): ?>
                <?php echo '#28a745'; ?>
              <?php endif; ?>

              <?php if ($user_role == 'Organizer'): ?>
                <?php echo '#007bff'; ?>
                <?php endif; ?>
              ;">

              <input type="submit" name="edit" value="<?php echo $user_role; ?>" style="background: none; border: none; color: white; font-size: 0.8rem; outline:none;">
            </span>
          </form>

        </td>
      </tr>

    <?php
      }
    ?>


  </tbody>
</table>
</div>

<?php
  if (isset($_POST['delete'])) {
    $user_id = $_POST['user_id'];
    deleteUser($user_id);
  }

  if (isset($_POST['edit'])) {
    $user_id = $_POST['user_id'];
    $user_role = $_POST['user_role'];
    changeRole($user_id, $user_role);
  }
?>
