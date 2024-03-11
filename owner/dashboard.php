<?php
session_start();

include('includes/config.php');
if (strlen($_SESSION['ologin']) == 0) {
    header('location:index.php');
} else {
?>
    <!doctype html>
    <html lang="en" class="no-js">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="theme-color" content="#3e454c">

        <title>Car Rental Portal | Admin Dashboard</title>

        <!-- Font awesome -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <!-- Sandstone Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- Bootstrap Datatables -->
        <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
        <!-- Bootstrap social button library -->
        <link rel="stylesheet" href="css/bootstrap-social.css">
        <!-- Bootstrap select -->
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <!-- Bootstrap file input -->
        <link rel="stylesheet" href="css/fileinput.min.css">
        <!-- Awesome Bootstrap checkbox -->
        <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
        <!-- Admin Stye -->
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <?php include('includes/header.php'); ?>

        <div class="ts-main-content">
            <?php include('includes/leftbar.php'); ?>
            <div class="content-wrapper">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">

                            <h2 class="page-title">Dashboard</h2>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-primary text-light">
                                                    <div class="stat-panel text-center">
                                                        <?php

                                                        $oname = $_SESSION['ologin'];
                                                        $sqlo = "SELECT id FROM tblowner WHERE UserName = :oname";
                                                        $queryo = $dbh->prepare($sqlo);
                                                        $queryo->bindParam(':oname', $oname, PDO::PARAM_STR);
                                                        $queryo->execute();
                                                        $resulto = $queryo->fetchAll(PDO::FETCH_OBJ);
                                                        $oid = $resulto[0]->id;

                                                        $sql1 = "SELECT id from tblvehicles WHERE  owner_id=$oid";
                                                        $query1 = $dbh->prepare($sql1);;
                                                        $query1->execute();
                                                        $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                                        $totalvehicle = $query1->rowCount();
                                                        ?>
                                                        <div class="stat-panel-number h1 "><?php echo htmlentities($totalvehicle); ?></div>
                                                        <div class="stat-panel-title text-uppercase">My Cars</div>
                                                    </div>
                                                </div>
                                                <a href="mycars.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-success text-light">
                                                    <div class="stat-panel text-center">
                                                        <?php

                                                        $oname = $_SESSION['ologin'];
                                                        $sqlo = "SELECT id FROM tblowner WHERE UserName = :oname";
                                                        $queryo = $dbh->prepare($sqlo);
                                                        $queryo->bindParam(':oname', $oname, PDO::PARAM_STR);
                                                        $queryo->execute();
                                                        $resulto = $queryo->fetchAll(PDO::FETCH_OBJ);
                                                        $ownerId = $resulto[0]->id;
                                                        $status = 3;
                                                        $sql = "SELECT tblusers.FullName, tblbrands.BrandName, tblvehicles.VehiclesTitle, tblbooking.FromDate, tblbooking.ToDate, tblbooking.message, tblbooking.VehicleId as vid, tblbooking.Status, tblbooking.PostingDate, tblbooking.id, tblbooking.BookingNumber  
                                                  FROM tblbooking 
                                                  JOIN tblvehicles ON tblvehicles.id = tblbooking.VehicleId 
                                                  JOIN tblusers ON tblusers.EmailId = tblbooking.userEmail 
                                                  JOIN tblbrands ON tblvehicles.VehiclesBrand = tblbrands.id   
                                                  WHERE tblbooking.Status = :status
                                                  AND tblvehicles.owner_id = :ownerId";
                                                        $query2 = $dbh->prepare($sql);
                                                        $query2->bindParam(':status', $status, PDO::PARAM_STR);
                                                        $query2->bindParam(':ownerId', $ownerId, PDO::PARAM_INT);
                                                        $query2->execute();
                                                        $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                                        $totalbooking = $query2->rowCount();
                                                        ?>
                                                        <div class="stat-panel-number h1 "><?php echo htmlentities($totalbooking); ?></div>
                                                        <div class="stat-panel-title text-uppercase">Bookings</div>
                                                    </div>
                                                </div>
                                                <a href="booking.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>


                                        <div class="col-md-3">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-info text-light">
                                                    <div class="stat-panel text-center">
                                                        <?php

                                                        $oname = $_SESSION['ologin'];
                                                        $sqlo = "SELECT id FROM tblowner WHERE UserName = :oname";
                                                        $queryo = $dbh->prepare($sqlo);
                                                        $queryo->bindParam(':oname', $oname, PDO::PARAM_STR);
                                                        $queryo->execute();
                                                        $resulto = $queryo->fetchAll(PDO::FETCH_OBJ);
                                                        $ownerId = $resulto[0]->id;
                                                        $status = 3;
                                                        $sql = "SELECT tblvehicles.VehiclesTitle,tblbooking.advance, tblbooking.FromDate, tblbooking.ToDate, tblbooking.message, tblbooking.VehicleId as vid, tblbooking.Status, tblbooking.PostingDate, tblbooking.id, tblbooking.BookingNumber  
                                                  FROM tblbooking 
                                                  JOIN tblvehicles ON tblvehicles.id = tblbooking.VehicleId 
                                                  JOIN tblusers ON tblusers.EmailId = tblbooking.userEmail 
                                                  JOIN tblbrands ON tblvehicles.VehiclesBrand = tblbrands.id   
                                                  WHERE tblbooking.Status = :status
                                                  AND tblvehicles.owner_id = :ownerId";
                                                        $query2 = $dbh->prepare($sql);
                                                        $query2->bindParam(':status', $status, PDO::PARAM_STR);
                                                        $query2->bindParam(':ownerId', $ownerId, PDO::PARAM_INT);
                                                        $query2->execute();
                                                        $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                                        $total=0;
                                                        foreach ($results2 as $result) {  
                                                           $total+= $result->advance ;
                                                        }
                                                        ?>
                                                        <div class="stat-panel-number h1 "><?php echo htmlentities($total); ?></div>
                                                        <div class="stat-panel-title text-uppercase">Income</div>
                                                    </div>
                                                </div>
                                                <a href="booking.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>




                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <!-- Loading Scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script src="js/Chart.min.js"></script>
        <script src="js/fileinput.js"></script>
        <script src="js/chartData.js"></script>
        <script src="js/main.js"></script>

        <script>
            window.onload = function() {

                // Line chart from swirlData for dashReport
                var ctx = document.getElementById("dashReport").getContext("2d");
                window.myLine = new Chart(ctx).Line(swirlData, {
                    responsive: true,
                    scaleShowVerticalLines: false,
                    scaleBeginAtZero: true,
                    multiTooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
                });

                // Pie Chart from doughutData
                var doctx = document.getElementById("chart-area3").getContext("2d");
                window.myDoughnut = new Chart(doctx).Pie(doughnutData, {
                    responsive: true
                });

                // Dougnut Chart from doughnutData
                var doctx = document.getElementById("chart-area4").getContext("2d");
                window.myDoughnut = new Chart(doctx).Doughnut(doughnutData, {
                    responsive: true
                });

            }
        </script>
    </body>

    </html>
<?php } ?>