<?php
if (isset($_POST['submit'])) {
  $user_email    = $_POST['user_email'];
  $user_password = $_POST['user_password'];
  loginUser($user_email, $user_password);
}
?>
<div class="my-3 mx-3">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded rounded-lg">
    <a class="navbar-brand">TrekTrek</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">

        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>

        <?php if (!isset($_SESSION['username'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="register.php">Register</a>
          </li>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Organizer'): ?>

          <li class="nav-item">
            <a class="nav-link" href="organizer">Organizer</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="organizer/treks.php">Treks</a>
          </li>

        <?php endif; ?>


        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin'): ?>
          <li class="nav-item">
            <a class="nav-link" href="admin">Admin</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin/users.php">Users</a>
          </li>
        <?php endif; ?>

      </ul>



      <?php if (!isset($_SESSION['user_email'])): ?>
        <form class="form-inline" action="" method="post">
          <input class="form-control mr-2" type="text"     placeholder="Email"    name="user_email" >
          <input class="form-control mr-2" type="password" placeholder="Password" name="user_password" >
          <input class="form-control mr-2 btn btn-success" type="submit" name="submit" value="Login">
        </form>
      <?php else: ?>
        <ul class="nav nav-pills mr-2">
          <li class="nav-item dropdown active">
            <a class="nav-link text-light text-decoration-none dropdown-toggle" href='' id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="./images/<?php echo $_SESSION['user_image']; ?>" width="35" height="35" style="border-radius:50%;">
              <?php echo $_SESSION['user_firstname'] . ". " . $_SESSION['user_lastname']; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="../profile.php">Profile</a>
              <a class="dropdown-item" href="./includes/logout.php">Logout</a>
            </div>
          </li>
        </ul>
      <?php endif; ?>

      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>
</div>
