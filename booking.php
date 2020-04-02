<?php
include 'includes/header.php';

if (isset($_GET['trek_id'])):
  $trek_id = $_GET['trek_id'];
  if (isset($_SESSION['user_id'])):
    if (!isAdmin() && !isOrganizer()):
      if (isset($_POST['book_final'])) {

        $user_id         = $_SESSION['user_id'];
        $user_firstname  = $_POST['user_firstname'];
        $user_lastname   = $_POST['user_lastname'];
        $user_name       = $user_firstname." ".$user_lastname;
        $no_of_people    = $_POST['no_of_people'];
        $mode_id         = $_POST['mode_id'];
        $trek_price      = $_POST['trek_price'];

        $bill_price = $no_of_people * $trek_price;

        $query = mysqli_query($connection, "INSERT INTO billing_information(user_id, user_name, trek_id, bill_price,mode_id,no_people) VALUES($user_id, '$user_name', $trek_id, $bill_price, $mode_id, $no_of_people)");
        confirmQuery($query);
        header("Location: ./index.php");
      }
      include 'includes/navigation.php';
      $query = mysqli_query($connection, "SELECT * FROM treks INNER JOIN users ON treks.trek_organizer_id = users.user_id WHERE trek_id = $trek_id");
      while($row = mysqli_fetch_assoc($query)){
        $trek_image       = explode(', ', $row['trek_image']);
        $user_image       = $row['user_image'];
        $user_firstname   = $row['user_firstname'];
        $user_lastname    = $row['user_lastname'];
        $user_phonenumber = $row['user_phonenumber'];
        $user_email       = $row['user_email'];
        $trek_price       = $row['trek_price'];
      }
      ?>
      <div class="mx-3 my-3">
        <h1 class="display-4">Booking</h1>


        <!-- organizer details -->

        <div class="d-flex">
          <img src="images/<?php echo $user_image; ?>" class="img-fluid rounded rounded-lg" style="width: 15%; height: 15%;">
          <div class="align-items-start flex-column ml-3">
            <p style="font-size: 2.2rem; font-weight: 300;" class="mb-0">
              <?php echo $user_firstname." ".$user_lastname; ?>
            </p>
            <p style="font-size: 1.2rem; font-weight: 300;" class="mb-0">
              <i class="fa fa-phone"></i>
              <?php echo $user_phonenumber; ?>
            </p>
            <p style="font-size: 1.2rem; font-weight: 300;">
              <i class="fa fa-envelope"></i>
              <?php echo $user_email; ?>
            </p>
          </div>
        </div>
        <!-- END organizer details -->

        <div class="row mt-3">


          <div class="col-12 col-md-6">
            <!-- BILLING DETAILS START -->
            <form class="" action="" method="post">
              <input type="hidden" name="trek_price" value="<?php echo $trek_price; ?>">
              <div class="row">
                <div class="col-12 col-md-6">
                  <label for="">Firstname:</label>
                  <input type="text" name="user_firstname" class="d-felx form-control">
                </div>
                <div class="col-12 col-md-6">
                  <label for="">Lastname:</label>
                  <input type="text" name="user_lastname" class="d-felx form-control">
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-12 col-md-6">
                  <label for="">Number of People</label>
                  <select class="form-control" name="no_of_people">
                    <?php
                    $i = 1;
                    while ($i <= 10) {
                      ?>
                      <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                      <?php
                      $i++;
                    }
                    ?>
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <label for="">Mode of Payment</label>
                  <select class="form-control" name="mode_id">
                    <?php
                    $select_all_modes = mysqli_query($connection, "SELECT * FROM mode_of_payment");
                    while ($row = mysqli_fetch_assoc($select_all_modes)) {
                      ?>
                      <option value="<?php echo $row['mode_id']; ?>"><?php echo $row['mode_name']; ?></option>

                      <?php
                    }
                    ?>

                  </select>
                </div>
              </div>

              <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                  <input type="submit" name="book_final" value="Book" class="btn btn-success px-5">
                </div>
              </div>
            </form>
            <!-- BILLING DETAILS END -->
          </div>
          <div class="col-12 col-sm-6">
            <!-- SLIDE SHOW FOR THE TREK IMAGES START -->
            <div id="carouselFor<?php echo $trek_id; ?>" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <?php
                $i = 0;
                while ($i < sizeof($trek_image)) {
                  ?>
                  <li data-target="#carouselFor<?php echo $trek_id; ?>" data-slide-to="<?php echo $i ?>" <?php if ($i === 0): ?>class="active"<?php endif; ?>></li>
                  <?php
                  $i++;
                }
                ?>
              </ol>
              <div class="carousel-inner rounded rounded-lg">
                <?php
                $i = 0;
                while ($i < sizeof($trek_image)) {
                  ?>

                  <div class="carousel-item <?php if ($i === 0): echo "active"; endif; ?>">
                    <img src="organizer/trek-images/<?php echo $trek_image[$i]; ?>" class="d-block w-100" alt="...">
                  </div>
                  <?php
                  $i++;
                }
                ?>
                <div class="carousel-item">
                  <img src="organizer/trek-images/5.jpg" class="d-block w-100" alt="...">
                </div>

              </div>
              <a class="carousel-control-prev" href="#carouselFor<?php echo $trek_id; ?>" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselFor<?php echo $trek_id; ?>" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
            <!-- SLIDE SHOW FOR TREK IMAGES END -->
          </div>
        </div>
      </div>


      <?php
      include 'includes/footer.php';
    else:
      header("Location: ./index.php");
    endif;
  else:
    header("Location: ./index.php");
  endif;
else:
  header("Location: ./index.php");
endif;
?>
