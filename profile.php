<?php
include 'includes/header.php';
if (isset($_SESSION['user_id'])):
  include 'includes/navigation.php';
  ?>

  <div class="container mt-3 ">
    <div class="row ">

      <div class="col-12 col-md-4  d-flex justify-content-center">
        <img src="./images/<?php echo $_SESSION['user_image']; ?>" alt="" class="img-fluid rounded rounded-lg align-self-start" width="300">
      </div>
      <div class="col-12 col-md-8  m-0 mt-sm-3 mt-md-0 mt-lg-0 my-xl-0">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true">Profile</a>
          <a class="nav-item nav-link" id="nav-messages-tab" data-toggle="tab" href="#nav-messages" role="tab" aria-controls="nav-messages" aria-selected="false">Messages</a>
          <a class="nav-item nav-link " id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Edit Profile</a>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
          <div class="row mt-3">

            <div class="col-12 col-md-8">
              <!-- NAME -->
              <span class="lead"  style="font-weight: 500;">
                <?php echo $_SESSION['user_firstname']." ".$_SESSION['user_lastname']; ?>
              </span>

              <!-- ABOUT -->
              <div class="mt-2">
                <div style="font-weight: 500;" class="lead">
                  About
                </div>
                <div class="" style="font-weight: 400;">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                </div>
              </div>
              <!-- HOBBIES -->
              <div class="mt-2">
                <div style="font-weight: 500;" class="lead">
                  Hobbies
                </div>
                <div class="" style="font-weight: 400;">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                </div>
              </div>

            </div>

            <div class="col-12 col-md-4 text-center">
              <a class="badge badge-primary" href="./follows.php?source=followers">
                <?php
                $user_id = $_SESSION['user_id'];
                $followers = mysqli_query($connection, "SELECT * FROM follows WHERE follower_id = $user_id");
                echo mysqli_num_rows($followers);
                ?>
                Followers
              </a>
              <a class="badge badge-success" href="./follows.php?source=following">
                Following
                <?php
                $user_id = $_SESSION['user_id'];
                $following = mysqli_query($connection, "SELECT * FROM follows WHERE followee_id = $user_id");
                echo mysqli_num_rows($following);
                ?>
              </a>
              <span class="badge badge-warning text-light">
                10 Treks Attended
              </span>
              <div class="row mt-3">
                <div class="col-12">
                  <a href="./includes/logout.php" class="badge badge-danger p-2 text-light form-control ">
                    Logout
                  </a>
                </div>
              </div>
            </div>

          </div>


          <!-- RECENT ACTIVITY -->
          <?php include 'includes/recent_activity.php'; ?>


        </div>

        <div class="tab-pane fade" id="nav-messages" role="tabpanel" aria-labelledby="nav-messages-tab">
          <?php include 'includes/messages.php'; ?>
        </div>

        <div class="tab-pane fade mt-3" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
          <?php include 'edit_user.php'; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<nav>


  <?php
  include 'includes/footer.php';
else:
  header("Location: ./index.php");
endif;
?>
