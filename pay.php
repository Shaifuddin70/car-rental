<?php
session_start();

include('includes/config.php');
if(isset($_POST['submit'])) {
  $review = $_POST['message'];
  $bookingid = $_GET['bookingid'];
  $newpay = $_SESSION['newpay']; // Assuming 'newpay' is stored in the session

  // Prepare and execute the SQL query
  $sql = "UPDATE `tblbooking` SET `advance`=:newpay, `due`='0', `Status`='3', `review`=:review WHERE id=:bookingid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':review', $review, PDO::PARAM_STR);
  $query->bindParam(':bookingid', $bookingid, PDO::PARAM_INT);
  $query->bindParam(':newpay', $newpay, PDO::PARAM_INT);
  $query->execute();

  // Check if the query executed successfully
  if ($query->rowCount() > 0) {
    echo "<script>alert('Payment successful.');</script>";
    echo "<script type='text/javascript'> document.location = 'my-booking.php'; </script>";
  } else {
    echo "<script>alert('Something went wrong. Please try again');</script>";
    echo "<script type='text/javascript'> document.location = 'car-listing.php'; </script>";
  }
}






if (strlen($_SESSION['login']) == 0) {
  header('location:index.php');
} else {
?>
  <!DOCTYPE HTML>
  <html lang="en">

  <head>

    <title>Car Rental Portal - My Booking</title>
    <!--Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <!--Custome Style -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <!--OWL Carousel slider-->
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <!--slick-slider -->
    <link href="assets/css/slick.css" rel="stylesheet">
    <!--bootstrap-slider -->
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <!--FontAwesome Font Style -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">

    <!-- SWITCHER -->
    <link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
    <!-- Google-Font-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
  </head>

  <body>


    <!--Header-->
    <?php include('includes/header.php'); ?>
    <!--Page Header-->
    <!-- /Header -->

    <!--Page Header-->
    <section class="page-header profile_page">
      <div class="container">
        <div class="page-header_wrap">
          <div class="page-heading">
            <h1>My Booking</h1>
          </div>
          <ul class="coustom-breadcrumb">
            <li><a href="#">Home</a></li>
            <li>My Booking</li>
          </ul>
        </div>
      </div>
      <!-- Dark Overlay-->
      <div class="dark-overlay"></div>
    </section>
    <!-- /Page Header-->
    <section class="user_profile inner_pages">
      <div class="container">

        <div class="row">
          <div class="col-md-3 col-sm-3">
            <?php include('includes/sidebar.php'); ?>


            <div class="col-md-8 col-sm-8">
              <?php
              $bookingid = $_GET['bookingid'];

              $sql = "SELECT tblvehicles.VehiclesTitle, tblvehicles.id as vid, tblbrands.BrandName, tblbooking.id, tblbooking.FromDate, tblbooking.ToDate, tblbooking.message, tblbooking.advance, tblbooking.due, tblbooking.Status, tblvehicles.PricePerDay, DATEDIFF(tblbooking.ToDate, tblbooking.FromDate) as totaldays, tblbooking.BookingNumber  
        FROM tblbooking 
        JOIN tblvehicles ON tblbooking.VehicleId = tblvehicles.id 
        JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
        WHERE tblbooking.id = :bookingid 
        ORDER BY tblbooking.id DESC";

              $query = $dbh->prepare($sql);
              $query->bindParam(':bookingid', $bookingid, PDO::PARAM_INT);
              $query->execute();
              $results = $query->fetchAll(PDO::FETCH_OBJ);
              ?>

              <?php foreach ($results as $result) : ?>
                <h5 class="tittle">Due Payment for Booking ID: <?php echo $result->id ?></h5>

                </button>

                <div class="col-md-8 col-sm-8">
                  <p><b>Vehicle:</b> <?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?></p>
                  <p><b>Booking Dates:</b> <?php echo htmlentities($result->FromDate); ?> - <?php echo htmlentities($result->ToDate); ?></p>
                  <p><b>Total Due:</b> <?php echo htmlentities($result->due); ?> TK</p>
                </div>
              <?php endforeach; ?>

              <div class="col-md-8 col-sm-8">
                <form method="post">

                  <div class="form-group">
                    <label for="card_number">Card Number:</label>
                    <input type="text" class="form-control" id="card_number" name="card_number" required>
                  </div>
                  <div class="form-group">
                    <label for="expiry_date">Expiry Date:</label>
                    <input type="text" class="form-control" id="expiry_date" name="expiry_date" required>
                  </div>
                  <div class="form-group">
                    <label for="cvv">CVV:</label>
                    <input type="text" class="form-control" id="cvv" name="cvv" required>
                  </div>
                  <div class="form-group">
                    <label for="message">Message (optional):</label>
                    <textarea class="form-control" id="message" name="message"></textarea>
                  </div>
                  <button type="submit" name="submit" class="btn btn-primary">Make Payment</button>
                </form>
              </div>
            </div>

          </div>


        </div>
      </div>
      </div>
      </div>
      </div>
    </section>
    <!--/my-vehicles-->
    <?php include('includes/footer.php'); ?>




    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/interface.js"></script>
    <!--Switcher-->
    <script src="assets/switcher/js/switcher.js"></script>
    <!--bootstrap-slider-JS-->
    <script src="assets/js/bootstrap-slider.min.js"></script>
    <!--Slider-JS-->
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
  </body>

  </html>
<?php } ?>