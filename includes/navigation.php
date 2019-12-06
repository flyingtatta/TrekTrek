<?php
  if (isset($_POST['submit'])) {
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    $query = "SELECT * FROM users WHERE user_email = '{$user_email}' AND user_password = '{$user_password}'";
    $login_user = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($login_user)){
      $db_user_firstname   = $row['user_firstname'];
      $db_user_lastname    = $row['user_lastname'];
      $db_username         = $row['username'];
      $db_user_email       = $row['user_email'];
      $db_user_phonenumber = $row['user_phonenumber'];
      $db_user_image       = $row['user_image'];
      $db_user_dob         = $row['user_dob'];
      $db_user_password    = $row['user_password'];
      $db_user_role        = $row['user_role'];
    }

    if ($user_email == $db_user_email && $user_password == $db_user_password) {
      $_SESSION['user_firstname']   = $db_user_firstname;
      $_SESSION['user_lastname']    = $db_user_lastname;
      $_SESSION['username']         = $db_username;
      $_SESSION['user_email']       = $db_user_email;
      $_SESSION['user_phonenumber'] = $db_user_phonenumber;
      $_SESSION['user_image']       = $db_user_image;
      $_SESSION['user_dob']         = $db_user_dob;
      $_SESSION['user_password']    = $db_user_password;
      $_SESSION['user_role']        = $db_user_role;
    }
  }
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
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
          <a class="nav-link">Register</a>
        </li>
      <?php endif; ?>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li> 
    </ul>

    <?php if (!isset($_SESSION['user_email'])): ?>
      <form class="form-inline" action="" method="post">
        <input class="form-control mr-2" type="text"     placeholder="Email"    name="user_email" >
        <input class="form-control mr-2" type="password" placeholder="Password" name="user_password" >
        <input class="form-control mr-2 btn btn-outline-primary" type="submit" name="submit" value="Login">
      </form>
    <?php else: ?>
      <ul class="navbar-nav ml-auto mr-2">
        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $_SESSION['user_firstname'] . ". " . $_SESSION['user_lastname']; ?>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="includes/logout.php">Logout</a>
          </div>
        </li>
      </ul>
    <?php endif; ?>

    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
